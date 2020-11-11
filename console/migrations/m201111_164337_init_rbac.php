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

        $createEvent = $auth->createPermission('createEvent');
        $createEvent->description = 'Create a event';
        $auth->add($createEvent);

        $createUser = $auth->createPermission('createUsers');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        $createEntityType = $auth->createPermission('createEntityType');
        $createEntityType->description = 'Create a entity type';
        $auth->add($createEntityType);

        $createEntity = $auth->createPermission('createEntity');
        $createEntity->description = 'Create a entity';
        $auth->add($createEntity);

        $createCredential = $auth->createPermission('createCredential');
        $createCredential->description = 'Create a credential';
        $auth->add($createCredential);

        $createMovement = $auth->createPermission('createMovement');
        $createMovement->description = 'Create a movement for a credential';
        $auth->add($createMovement);

        $createCarrierType = $auth->createPermission('createCarrierType');
        $createCarrierType->description = 'Create a carrier type';
        $auth->add($createCarrierType);

        $createCarrier = $auth->createPermission('createCarrier');
        $createCarrier->description = 'Create a carrier';
        $auth->add($createCarrier);

        $createArea = $auth->createPermission('createArea');
        $createArea->description = 'Create a area for a event';
        $auth->add($createMovement);

        $createEvent = $auth->createPermission('createEvent');
        $createEvent->description = 'Create a event';
        $auth->add($createEvent);

        $createUser = $auth->createPermission('createUsers');
        $createUser->description = 'Create a user';
        $auth->add($createUser);

        $createEntityType = $auth->createPermission('createEntityType');
        $createEntityType->description = 'Create a entity type';
        $auth->add($createEntityType);

        $createEntity = $auth->createPermission('createEntity');
        $createEntity->description = 'Create a entity';
        $auth->add($createEntity);

        $createCredential = $auth->createPermission('createCredential');
        $createCredential->description = 'Create a credential';
        $auth->add($createCredential);

        $createMovement = $auth->createPermission('createMovement');
        $createMovement->description = 'Create a movement for a credential';
        $auth->add($createMovement);

        $createCarrierType = $auth->createPermission('createCarrierType');
        $createCarrierType->description = 'Create a carrier type';
        $auth->add($createCarrierType);

        $createCarrier = $auth->createPermission('createCarrier');
        $createCarrier->description = 'Create a carrier';
        $auth->add($createCarrier);

        $createArea = $auth->createPermission('createArea');
        $createArea->description = 'Create a area for a event';
        $auth->add($createMovement);

        $deleteEvent = $auth->deletePermission('deleteEvent');
        $deleteEvent->description = 'Delete a event';
        $auth->add($deleteEvent);

        $deleteUser = $auth->deletePermission('deleteUsers');
        $deleteUser->description = 'Delete a user';
        $auth->add($deleteUser);

        $deleteEntityType = $auth->deletePermission('deleteEntityType');
        $deleteEntityType->description = 'Delete a entity type';
        $auth->add($deleteEntityType);

        $deleteEntity = $auth->deletePermission('deleteEntity');
        $deleteEntity->description = 'Delete a entity';
        $auth->add($deleteEntity);

        $deleteCredential = $auth->deletePermission('deleteCredential');
        $deleteCredential->description = 'Delete a credential';
        $auth->add($deleteCredential);

        $deleteMovement = $auth->deletePermission('deleteMovement');
        $deleteMovement->description = 'Delete a movement for a credential';
        $auth->add($deleteMovement);

        $deleteCarrierType = $auth->deletePermission('deleteCarrierType');
        $deleteCarrierType->description = 'Delete a carrier type';
        $auth->add($deleteCarrierType);

        $deleteCarrier = $auth->deletePermission('deleteCarrier');
        $deleteCarrier->description = 'Delete a carrier';
        $auth->add($deleteCarrier);

        $deleteArea = $auth->deletePermission('deleteArea');
        $deleteArea->description = 'Delete a area for a event';
        $auth->add($deleteMovement);

        $deleteEvent = $auth->deletePermission('deleteEvent');
        $deleteEvent->description = 'Delete a event';
        $auth->add($deleteEvent);

        $deleteUser = $auth->deletePermission('deleteUsers');
        $deleteUser->description = 'Delete a user';
        $auth->add($deleteUser);

        $deleteEntityType = $auth->deletePermission('deleteEntityType');
        $deleteEntityType->description = 'Delete a entity type';
        $auth->add($deleteEntityType);

        $deleteEntity = $auth->deletePermission('deleteEntity');
        $deleteEntity->description = 'Delete a entity';
        $auth->add($deleteEntity);

        $deleteCredential = $auth->deletePermission('deleteCredential');
        $deleteCredential->description = 'Delete a credential';
        $auth->add($deleteCredential);

        $deleteMovement = $auth->deletePermission('deleteMovement');
        $deleteMovement->description = 'Delete a movement for a credential';
        $auth->add($deleteMovement);

        $deleteCarrierType = $auth->deletePermission('deleteCarrierType');
        $deleteCarrierType->description = 'Delete a carrier type';
        $auth->add($deleteCarrierType);

        $deleteCarrier = $auth->deletePermission('deleteCarrier');
        $deleteCarrier->description = 'Delete a carrier';
        $auth->add($deleteCarrier);

        $deleteArea = $auth->deletePermission('deleteArea');
        $deleteArea->description = 'Delete a area for a event';
        $auth->add($deleteMovement);

        $updateEvent = $auth->updatePermission('updateEvent');
        $updateEvent->description = 'update a event';
        $auth->add($updateEvent);

        $updateUser = $auth->updatePermission('updateUsers');
        $updateUser->description = 'update a user';
        $auth->add($updateUser);

        $updateEntityType = $auth->updatePermission('updateEntityType');
        $updateEntityType->description = 'update a entity type';
        $auth->add($updateEntityType);

        $updateEntity = $auth->updatePermission('updateEntity');
        $updateEntity->description = 'update a entity';
        $auth->add($updateEntity);

        $updateCredential = $auth->updatePermission('updateCredential');
        $updateCredential->description = 'update a credential';
        $auth->add($updateCredential);

        $updateMovement = $auth->updatePermission('updateMovement');
        $updateMovement->description = 'update a movement for a credential';
        $auth->add($updateMovement);

        $updateCarrierType = $auth->updatePermission('updateCarrierType');
        $updateCarrierType->description = 'update a carrier type';
        $auth->add($updateCarrierType);

        $updateCarrier = $auth->updatePermission('updateCarrier');
        $updateCarrier->description = 'update a carrier';
        $auth->add($updateCarrier);

        $updateArea = $auth->updatePermission('updateArea');
        $updateArea->description = 'update a area for a event';
        $auth->add($updateMovement);

        $updateEvent = $auth->updatePermission('updateEvent');
        $updateEvent->description = 'update a event';
        $auth->add($updateEvent);

        $updateUser = $auth->updatePermission('updateUsers');
        $updateUser->description = 'update a user';
        $auth->add($updateUser);

        $updateEntityType = $auth->updatePermission('updateEntityType');
        $updateEntityType->description = 'update a entity type';
        $auth->add($updateEntityType);

        $updateEntity = $auth->updatePermission('updateEntity');
        $updateEntity->description = 'update a entity';
        $auth->add($updateEntity);

        $updateCredential = $auth->updatePermission('updateCredential');
        $updateCredential->description = 'update a credential';
        $auth->add($updateCredential);

        $updateMovement = $auth->updatePermission('updateMovement');
        $updateMovement->description = 'update a movement for a credential';
        $auth->add($updateMovement);

        $updateCarrierType = $auth->updatePermission('updateCarrierType');
        $updateCarrierType->description = 'update a carrier type';
        $auth->add($updateCarrierType);

        $updateCarrier = $auth->updatePermission('updateCarrier');
        $updateCarrier->description = 'update a carrier';
        $auth->add($updateCarrier);

        $updateArea = $auth->updatePermission('updateArea');
        $updateArea->description = 'update a area for a event';
        $auth->add($updateMovement);


        $viewEvent = $auth->viewPermission('viewEvent');
        $viewEvent->description = 'view a event';
        $auth->add($viewEvent);

        $viewUser = $auth->viewPermission('viewUsers');
        $viewUser->description = 'view a user';
        $auth->add($viewUser);

        $viewEntityType = $auth->viewPermission('viewEntityType');
        $viewEntityType->description = 'view a entity type';
        $auth->add($viewEntityType);

        $viewEntity = $auth->viewPermission('viewEntity');
        $viewEntity->description = 'view a entity';
        $auth->add($viewEntity);

        $viewCredential = $auth->viewPermission('viewCredential');
        $viewCredential->description = 'view a credential';
        $auth->add($viewCredential);

        $viewMovement = $auth->viewPermission('viewMovement');
        $viewMovement->description = 'view a movement for a credential';
        $auth->add($viewMovement);

        $viewCarrierType = $auth->viewPermission('viewCarrierType');
        $viewCarrierType->description = 'view a carrier type';
        $auth->add($viewCarrierType);

        $viewCarrier = $auth->viewPermission('viewCarrier');
        $viewCarrier->description = 'view a carrier';
        $auth->add($viewCarrier);

        $viewArea = $auth->viewPermission('viewArea');
        $viewArea->description = 'view a area for a event';
        $auth->add($viewMovement);

        $viewEvent = $auth->viewPermission('viewEvent');
        $viewEvent->description = 'view a event';
        $auth->add($viewEvent);

        $viewUser = $auth->viewPermission('viewUsers');
        $viewUser->description = 'view a user';
        $auth->add($viewUser);

        $viewEntityType = $auth->viewPermission('viewEntityType');
        $viewEntityType->description = 'view a entity type';
        $auth->add($viewEntityType);

        $viewEntity = $auth->viewPermission('viewEntity');
        $viewEntity->description = 'view a entity';
        $auth->add($viewEntity);

        $viewCredential = $auth->viewPermission('viewCredential');
        $viewCredential->description = 'view a credential';
        $auth->add($viewCredential);

        $viewMovement = $auth->viewPermission('viewMovement');
        $viewMovement->description = 'view a movement for a credential';
        $auth->add($viewMovement);

        $viewCarrierType = $auth->viewPermission('viewCarrierType');
        $viewCarrierType->description = 'view a carrier type';
        $auth->add($viewCarrierType);

        $viewCarrier = $auth->viewPermission('viewCarrier');
        $viewCarrier->description = 'view a carrier';
        $auth->add($viewCarrier);

        $viewArea = $auth->viewPermission('viewArea');
        $viewArea->description = 'view a area for a event';
        $auth->add($viewMovement);

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
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $createEntityType);
        $auth->addChild($admin, $createEntity);
        $auth->addChild($admin, $createCredential);
        $auth->addChild($admin, $createCarrierType);
        $auth->addChild($admin, $createCarrier);
        $auth->addChild($admin, $createArea);
        $auth->addChild($admin, $createEvent);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $createEntityType);
        $auth->addChild($admin, $createEntity);
        $auth->addChild($admin, $createCredential);
        $auth->addChild($admin, $createCarrierType);
        $auth->addChild($admin, $createCarrier);
        $auth->addChild($admin, $createArea);
        $auth->addChild($admin, $deleteEvent);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $deleteEntityType);
        $auth->addChild($admin, $deleteEntity);
        $auth->addChild($admin, $deleteCredential);
        $auth->addChild($admin, $deleteCarrierType);
        $auth->addChild($admin, $deleteCarrier);
        $auth->addChild($admin, $deleteArea);
        $auth->addChild($admin, $deleteEvent);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $deleteEntityType);
        $auth->addChild($admin, $deleteEntity);
        $auth->addChild($admin, $deleteCredential);
        $auth->addChild($admin, $deleteCarrierType);
        $auth->addChild($admin, $deleteCarrier);
        $auth->addChild($admin, $deleteArea);
        $auth->addChild($admin, $updateEvent);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $updateEntityType);
        $auth->addChild($admin, $updateEntity);
        $auth->addChild($admin, $updateCredential);
        $auth->addChild($admin, $updateCarrierType);
        $auth->addChild($admin, $updateCarrier);
        $auth->addChild($admin, $updateArea);
        $auth->addChild($admin, $updateEvent);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $updateEntityType);
        $auth->addChild($admin, $updateEntity);
        $auth->addChild($admin, $updateCredential);
        $auth->addChild($admin, $updateCarrierType);
        $auth->addChild($admin, $updateCarrier);
        $auth->addChild($admin, $updateArea);
        $auth->addChild($admin, $viewEvent);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $viewEntityType);
        $auth->addChild($admin, $viewEntity);
        $auth->addChild($admin, $viewCredential);
        $auth->addChild($admin, $viewCarrierType);
        $auth->addChild($admin, $viewCarrier);
        $auth->addChild($admin, $viewArea);
        $auth->addChild($admin, $viewEvent);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $viewEntityType);
        $auth->addChild($admin, $viewEntity);
        $auth->addChild($admin, $viewCredential);
        $auth->addChild($admin, $viewCarrierType);
        $auth->addChild($admin, $viewCarrier);
        $auth->addChild($admin, $viewArea);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
