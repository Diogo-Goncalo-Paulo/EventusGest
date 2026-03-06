# EventusGest — Ubuntu VPS Deployment Guide (Nginx)

This guide walks you through deploying EventusGest on a fresh **Ubuntu 22.04 LTS** VPS using **Nginx**, **PHP-FPM**, and **MySQL**.

> **Default credentials:** Username: `admin` / Password: `adminadmin`
> Change these immediately after the first login.

---

## Table of Contents

1. [Prerequisites](#1-prerequisites)
2. [System Setup](#2-system-setup)
3. [MySQL Database Setup](#3-mysql-database-setup)
4. [Project Installation](#4-project-installation)
5. [Nginx Configuration](#5-nginx-configuration)
6. [File Permissions](#6-file-permissions)
7. [SSL/TLS with Let's Encrypt](#7-ssltls-with-lets-encrypt)
8. [Firewall Configuration](#8-firewall-configuration)
9. [SMTP / Email Configuration](#9-smtp--email-configuration)
10. [Maintenance & Troubleshooting](#10-maintenance--troubleshooting)

---

## 1. Prerequisites

| Requirement | Minimum Version |
|---|---|
| Ubuntu | 22.04 LTS |
| PHP | 7.4+ (8.1 recommended) |
| MySQL | 5.7+ (or MariaDB 10.3+) |
| Nginx | 1.18+ |
| Composer | 2.x |
| Git | 2.x |

You will also need:

- A domain name (or two subdomains) pointed to your VPS IP address — for example `eventusgest.example.com` (frontend) and `admin.eventusgest.example.com` (backend).
- SSH access with a sudo-enabled user.

---

## 2. System Setup

### 2.1 Update the system

```bash
sudo apt update && sudo apt upgrade -y
```

### 2.2 Install Nginx

```bash
sudo apt install -y nginx
```

### 2.3 Install PHP and required extensions

```bash
sudo apt install -y php-fpm php-mysql php-xml php-mbstring php-curl \
    php-gd php-zip php-intl php-bcmath php-json php-tokenizer php-openssl
```

> **Note:** On Ubuntu 22.04 the default PHP version is 8.1. All commands below use `php8.1-fpm`. If you install a different version, adjust the socket path and service names accordingly.

Verify the installation:

```bash
php -v
php -m | grep -E "pdo_mysql|gd|curl|zip|mbstring|intl|openssl"
```

### 2.4 Install MySQL

```bash
sudo apt install -y mysql-server
sudo mysql_secure_installation
```

Follow the interactive prompts to set a root password and remove insecure defaults.

### 2.5 Install Composer

```bash
cd /tmp
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### 2.6 Install Git

```bash
sudo apt install -y git
```

---

## 3. MySQL Database Setup

### 3.1 Create the database and user

```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE eventusgest CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'eventusgest'@'localhost' IDENTIFIED BY 'CHANGE_ME_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON eventusgest.* TO 'eventusgest'@'localhost';
FLUSH PRIVILEGES;

EXIT;
```

> **Important:** Replace `CHANGE_ME_STRONG_PASSWORD` with a strong, unique password.

### 3.2 Import the database schema (optional)

If you want to start from the provided SQL dump instead of running migrations:

```bash
mysql -u eventusgest -p eventusgest < /var/www/eventusgest/dump.sql
```

Otherwise, migrations will be run in [step 4.4](#44-run-database-migrations).

---

## 4. Project Installation

### 4.1 Clone the repository

```bash
sudo mkdir -p /var/www/eventusgest
sudo chown $USER:$USER /var/www/eventusgest
git clone https://github.com/Diogo-Goncalo-Paulo/EventusGest.git /var/www/eventusgest
cd /var/www/eventusgest
```

### 4.2 Install PHP dependencies

```bash
composer install --no-dev --optimize-autoloader
```

### 4.3 Initialize the environment

The Yii2 `init` script copies environment-specific configuration files (cookie keys, debug settings, etc.):

```bash
php init --env=Production --overwrite=All
```

This will:
- Copy production config templates to their local counterparts.
- Set `YII_DEBUG = false` and `YII_ENV = 'prod'`.
- Generate random cookie validation keys.
- Set directory permissions for `runtime/` and `web/assets/`.

### 4.4 Configure the database connection

Edit the common local config file:

```bash
nano /var/www/eventusgest/common/config/main-local.php
```

Update the database component to match the **exact same credentials** you created in [step 3.1](#31-create-the-database-and-user) — the database name, username, and password **must** match:

```php
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=eventusgest',
            'username' => 'eventusgest',
            'password' => 'CHANGE_ME_STRONG_PASSWORD',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // Configure transport for real email delivery — see section 9
        ],
    ],
];
```

### 4.5 Run database migrations

If you did **not** import the SQL dump in [step 3.2](#32-import-the-database-schema-optional):

```bash
cd /var/www/eventusgest
php yii migrate --interactive=0
```

This creates all tables and seeds RBAC roles.

---

## 5. Nginx Configuration

EventusGest is a Yii2 Advanced application with two separate web roots:

| App | Web Root | Example Domain |
|---|---|---|
| Frontend | `/var/www/eventusgest/frontend/web` | `eventusgest.example.com` |
| Backend | `/var/www/eventusgest/backend/web` | `admin.eventusgest.example.com` |

### 5.1 Frontend virtual host

Create the Nginx config:

```bash
sudo nano /etc/nginx/sites-available/eventusgest-frontend
```

Paste the following (adjust `server_name` and PHP socket version as needed):

```nginx
server {
    listen 80;
    server_name eventusgest.example.com;

    root /var/www/eventusgest/frontend/web;
    index index.php;

    charset utf-8;

    # Maximum upload size — increase if users need to upload large event files
    client_max_body_size 20M;

    # Logs
    access_log /var/log/nginx/eventusgest-frontend-access.log;
    error_log  /var/log/nginx/eventusgest-frontend-error.log;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    # Deny access to dot files
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        try_files $uri =404;
    }

    # Cache static assets
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        access_log off;
        add_header Cache-Control "public";
    }
}
```

### 5.2 Backend virtual host

```bash
sudo nano /etc/nginx/sites-available/eventusgest-backend
```

```nginx
server {
    listen 80;
    server_name admin.eventusgest.example.com;

    root /var/www/eventusgest/backend/web;
    index index.php;

    charset utf-8;

    # Maximum upload size — increase if users need to upload large event files
    client_max_body_size 20M;

    # Logs
    access_log /var/log/nginx/eventusgest-backend-access.log;
    error_log  /var/log/nginx/eventusgest-backend-error.log;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    # Deny access to dot files
    location ~ /\. {
        deny all;
        access_log off;
        log_not_found off;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        try_files $uri =404;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 30d;
        access_log off;
        add_header Cache-Control "public";
    }
}
```

### 5.3 Enable the sites and restart Nginx

```bash
sudo ln -s /etc/nginx/sites-available/eventusgest-frontend /etc/nginx/sites-enabled/
sudo ln -s /etc/nginx/sites-available/eventusgest-backend  /etc/nginx/sites-enabled/

# Test the configuration
sudo nginx -t

# Reload Nginx
sudo systemctl reload nginx
```

---

## 6. File Permissions

Nginx (and PHP-FPM) typically runs as `www-data`. The project directories must be readable by that user, and certain directories need write access.

```bash
cd /var/www/eventusgest

# Set ownership
sudo chown -R $USER:www-data .

# Default: files readable, directories traversable
sudo find . -type f -exec chmod 644 {} \;
sudo find . -type d -exec chmod 755 {} \;

# Writable directories (asset compilation, logs, uploads)
sudo chmod -R 775 frontend/runtime
sudo chmod -R 775 frontend/web/assets
sudo chmod -R 775 backend/runtime
sudo chmod -R 775 backend/web/assets
sudo chmod -R 775 console/runtime

# Upload directories (if they exist)
[ -d frontend/web/uploads ] && sudo chmod -R 775 frontend/web/uploads
[ -d backend/web/uploads ]  && sudo chmod -R 775 backend/web/uploads
[ -d frontend/web/qrcodes ] && sudo chmod -R 775 frontend/web/qrcodes

# Make the Yii console command executable
sudo chmod 755 yii
```

> **Security tip:** To prevent execution of malicious uploaded files, add the following
> blocks inside both Nginx server configs (after the `location /` block):
>
> ```nginx
> location ~* /uploads/.*\.php$ { deny all; }
> location ~* /qrcodes/.*\.php$ { deny all; }
> ```

---

## 7. SSL/TLS with Let's Encrypt

It is strongly recommended to serve the application over HTTPS.

### 7.1 Install Certbot

```bash
sudo apt install -y certbot python3-certbot-nginx
```

### 7.2 Obtain certificates

```bash
sudo certbot --nginx -d eventusgest.example.com -d admin.eventusgest.example.com
```

Certbot will automatically modify your Nginx config to redirect HTTP → HTTPS.

### 7.3 Verify auto-renewal

```bash
sudo certbot renew --dry-run
```

---

## 8. Firewall Configuration

If you use `ufw`:

```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
sudo ufw status
```

This opens ports **22** (SSH), **80** (HTTP), and **443** (HTTPS).

---

## 9. SMTP / Email Configuration

By default, the mailer writes emails to files. To send real emails, edit the mailer transport in `common/config/main-local.php`:

> **Note:** This project uses SwiftMailer (`yii2-swiftmailer`), which is the default for
> this Yii2 version. If you upgrade Yii2 to a newer version that uses Symfony Mailer,
> the transport configuration below will need to be updated accordingly.

```php
'mailer' => [
    'class' => 'yii\swiftmailer\Mailer',
    'viewPath' => '@common/mail',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.example.com',
        'username' => 'noreply@eventusgest.example.com',
        'password' => 'YOUR_SMTP_PASSWORD',
        'port' => '587',
        'encryption' => 'tls',
    ],
],
```

You can use any SMTP provider (Gmail, Mailgun, SendGrid, Amazon SES, etc.).

---

## 10. Maintenance & Troubleshooting

### 10.1 Useful commands

| Task | Command |
|---|---|
| Check Nginx config | `sudo nginx -t` |
| Restart Nginx | `sudo systemctl restart nginx` |
| Restart PHP-FPM | `sudo systemctl restart php8.1-fpm` |
| View Nginx error logs | `sudo tail -f /var/log/nginx/eventusgest-*-error.log` |
| View application logs | `tail -f /var/www/eventusgest/frontend/runtime/logs/app.log` |
| Run new migrations | `cd /var/www/eventusgest && php yii migrate` |
| Clear Yii cache | `cd /var/www/eventusgest && php yii cache/flush-all` |
| Check PHP extensions | `php -m` |

### 10.2 Updating the application

> **Important:** Ensure there are no local uncommitted changes before pulling.
> For critical production environments, consider deploying from tagged releases
> or using a CI/CD pipeline instead of pulling directly.

```bash
cd /var/www/eventusgest

# Ensure working directory is clean
git status

# Pull latest changes
git pull origin master

# Install dependencies (if composer.json changed)
composer install --no-dev --optimize-autoloader

# Run new migrations (if any)
php yii migrate --interactive=0

# Clear runtime caches
php yii cache/flush-all

# Fix permissions
sudo chown -R $USER:www-data .
sudo chmod -R 775 frontend/runtime frontend/web/assets backend/runtime backend/web/assets console/runtime

# Restart PHP-FPM to clear opcache
sudo systemctl restart php8.1-fpm
```

### 10.3 Common issues

#### **502 Bad Gateway**

PHP-FPM is not running or the socket path is wrong.

```bash
# Check PHP-FPM status
sudo systemctl status php8.1-fpm

# Verify socket exists
ls -la /run/php/php8.1-fpm.sock

# If you have a different PHP version, find the correct socket:
ls /run/php/
```

Update the `fastcgi_pass` directive in your Nginx config to match the actual socket file.

#### **403 Forbidden**

File permissions are incorrect. Re-run the permissions commands in [section 6](#6-file-permissions).

#### **Blank page or 500 error**

Check the application and Nginx error logs:

```bash
tail -50 /var/www/eventusgest/frontend/runtime/logs/app.log
tail -50 /var/log/nginx/eventusgest-frontend-error.log
```

Common causes:
- Missing PHP extensions — run `php requirements.php` from the project root.
- Database connection failure — verify credentials in `common/config/main-local.php`.

#### **Assets not loading (CSS/JS)**

Ensure the `web/assets` directories are writable:

```bash
sudo chmod -R 775 /var/www/eventusgest/frontend/web/assets
sudo chmod -R 775 /var/www/eventusgest/backend/web/assets
```

### 10.4 Security checklist

- [ ] Change the default admin password (`admin` / `adminadmin`) immediately after deployment.
- [ ] Ensure `YII_DEBUG` is set to `false` in both `frontend/web/index.php` and `backend/web/index.php` (handled by `init --env=Production`).
- [ ] Keep PHP, MySQL, Nginx, and OS packages up to date.
- [ ] Use HTTPS (see [section 7](#7-ssltls-with-lets-encrypt)).
- [ ] Set strong, unique passwords for both the MySQL user and SMTP credentials.
- [ ] Restrict backend access by IP if possible (add `allow`/`deny` directives in the backend Nginx config).
- [ ] Disable directory listing (Nginx does this by default).
- [ ] Enable a firewall (see [section 8](#8-firewall-configuration)).
