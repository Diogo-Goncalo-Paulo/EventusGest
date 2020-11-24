<?php

use yii\db\Migration;

/**
 * Class m201111_164337_init_rbac
 */
class m201111_164337_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201111_164337_init_rbac cannot be reverted.\n";

        return false;
    }

    public function up()
    {
        $auth = Yii::$app->authManager;

        //Event permissions
        $createEvent = $auth->createPermission('createEvent');
        $createEvent->description = 'create a event';
        $auth->add($createEvent);

        $updateEvent = $auth->createPermission('updateEvent');
        $updateEvent->description = 'update a event';
        $auth->add($updateEvent);

        $deleteEvent = $auth->createPermission('deleteEvent');
        $deleteEvent->description = 'delete a event';
        $auth->add($deleteEvent);

        $viewEvent = $auth->createPermission('viewEvent');
        $viewEvent->description = 'view a event';
        $auth->add($viewEvent);

        // User permissions
        $createUser = $auth->createPermission('createUsers');
        $createUser->description = 'create a user';
        $auth->add($createUser);

        $updateUser = $auth->createPermission('updateUsers');
        $updateUser->description = 'update a user';
        $auth->add($updateUser);

        $deleteUser = $auth->createPermission('deleteUsers');
        $deleteUser->description = 'delete a user';
        $auth->add($deleteUser);

        $viewUser = $auth->createPermission('viewUsers');
        $viewUser->description = 'view a user';
        $auth->add($viewUser);

        //Entity Type Permissions
        $createEntityType = $auth->createPermission('createEntityType');
        $createEntityType->description = 'create a entity type';
        $auth->add($createEntityType);

        $updateEntityType = $auth->createPermission('updateEntityType');
        $updateEntityType->description = 'update a entity type';
        $auth->add($updateEntityType);

        $deleteEntityType = $auth->createPermission('deleteEntityType');
        $deleteEntityType->description = 'delete a entity type';
        $auth->add($deleteEntityType);

        $viewEntityType = $auth->createPermission('viewEntityType');
        $viewEntityType->description = 'view a entity type';
        $auth->add($viewEntityType);

        //Entity Permissions
        $createEntity = $auth->createPermission('createEntity');
        $createEntity->description = 'create a entity';
        $auth->add($createEntity);

        $updateEntity = $auth->createPermission('updateEntity');
        $updateEntity->description = 'update a entity';
        $auth->add($updateEntity);

        $deleteEntity = $auth->createPermission('deleteEntity');
        $deleteEntity->description = 'delete a entity';
        $auth->add($deleteEntity);

        $viewEntity = $auth->createPermission('viewEntity');
        $viewEntity->description = 'view a entity';
        $auth->add($viewEntity);

        //Credential Permissions
        $createCredential = $auth->createPermission('createCredential');
        $createCredential->description = 'create a credential';
        $auth->add($createCredential);

        $deleteCredential = $auth->createPermission('deleteCredential');
        $deleteCredential->description = 'delete a credential';
        $auth->add($deleteCredential);
        
        $updateCredential = $auth->createPermission('updateCredential');
        $updateCredential->description = 'update a credential';
        $auth->add($updateCredential);
        
        $viewCredential = $auth->createPermission('viewCredential');
        $viewCredential->description = 'view a credential';
        $auth->add($viewCredential);

        //Movement Permissions
        $createMovement = $auth->createPermission('createMovement');
        $createMovement->description = 'Create a movement for a credential';
        $auth->add($createMovement);

        $updateMovement = $auth->createPermission('updateMovement');
        $updateMovement->description = 'update a movement for a credential';
        $auth->add($updateMovement);

        $deleteMovement = $auth->createPermission('deleteMovement');
        $deleteMovement->description = 'delete a movement for a credential';
        $auth->add($deleteMovement);

        $viewMovement = $auth->createPermission('viewMovement');
        $viewMovement->description = 'view a movement for a credential';
        $auth->add($viewMovement);

        //Carrier Type Permissions
        $createCarrierType = $auth->createPermission('createCarrierType');
        $createCarrierType->description = 'create a carrier type';
        $auth->add($createCarrierType);

        $updateCarrierType = $auth->createPermission('updateCarrierType');
        $updateCarrierType->description = 'update a carrier type';
        $auth->add($updateCarrierType);

        $deleteCarrierType = $auth->createPermission('deleteCarrierType');
        $deleteCarrierType->description = 'delete a carrier type';
        $auth->add($deleteCarrierType);

        $viewCarrierType = $auth->createPermission('viewCarrierType');
        $viewCarrierType->description = 'view a carrier type';
        $auth->add($viewCarrierType);

        //Carrier Permissions
        $createCarrier = $auth->createPermission('createCarrier');
        $createCarrier->description = 'Create a carrier';
        $auth->add($createCarrier);

        $deleteCarrier = $auth->createPermission('deleteCarrier');
        $deleteCarrier->description = 'Delete a carrier';
        $auth->add($deleteCarrier);

        $updateCarrier = $auth->createPermission('updateCarrier');
        $updateCarrier->description = 'update a carrier';
        $auth->add($updateCarrier);

        $viewCarrier = $auth->createPermission('viewCarrier');
        $viewCarrier->description = 'view a carrier';
        $auth->add($viewCarrier);

        //Area Permissions
        $createArea = $auth->createPermission('createArea');
        $createArea->description = 'Create a area for a event';
        $auth->add($createArea);

        $deleteArea = $auth->createPermission('deleteArea');
        $deleteArea->description = 'delete a area for a event';
        $auth->add($deleteArea);

        $updateArea = $auth->createPermission('updateArea');
        $updateArea->description = 'update a area for a event';
        $auth->add($updateArea);

        $viewArea = $auth->createPermission('viewArea');
        $viewArea->description = 'view a area for a event';
        $auth->add($viewArea);

        //Roles
        $porteiro = $auth->createRole('porteiro');
        $auth->add($porteiro);

        $auth->addChild($porteiro, $createMovement);
        $auth->addChild($porteiro, $updateMovement);
        $auth->addChild($porteiro, $deleteMovement);
        $auth->addChild($porteiro, $viewMovement);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->addChild($admin, $porteiro);

        $auth->addChild($admin, $createEvent);
        $auth->addChild($admin, $deleteEvent);
        $auth->addChild($admin, $updateEvent);
        $auth->addChild($admin, $viewEvent);

        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $viewUser);

        $auth->addChild($admin, $createEntityType);
        $auth->addChild($admin, $deleteEntityType);
        $auth->addChild($admin, $updateEntityType);
        $auth->addChild($admin, $viewEntityType);

        $auth->addChild($admin, $createEntity);
        $auth->addChild($admin, $deleteEntity);
        $auth->addChild($admin, $updateEntity);
        $auth->addChild($admin, $viewEntity);

        $auth->addChild($admin, $createCredential);
        $auth->addChild($admin, $deleteCredential);
        $auth->addChild($admin, $updateCredential);
        $auth->addChild($admin, $viewCredential);

        $auth->addChild($admin, $createCarrierType);
        $auth->addChild($admin, $deleteCarrierType);
        $auth->addChild($admin, $updateCarrierType);
        $auth->addChild($admin, $viewCarrierType);

        $auth->addChild($admin, $createCarrier);
        $auth->addChild($admin, $deleteCarrier);
        $auth->addChild($admin, $updateCarrier);
        $auth->addChild($admin, $viewCarrier);

        $auth->addChild($admin, $createArea);
        $auth->addChild($admin, $deleteArea);
        $auth->addChild($admin, $updateArea);
        $auth->addChild($admin, $viewArea);

    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
