<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class TranslatemoduleTable extends Table {

    public function initialize(array $config) {
        $this->table('Staging_1149_Data');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
        $this->ModuleId = 1149;
    }

    
    public function findQuerypost(Query $query, array $options) {

        $connection = ConnectionManager::get('default');
        $moduleId=  $options['moduleId'];
        $count = $connection->execute("SELECT Id FROM ME_UserQuery WHERE ProductionEntityId='" . $options['ProductionEntity'] . "' AND RecordStatus=1 AND ModuleId = '$moduleId'")->fetchAll('assoc');
        $QueryValue = str_replace("'", "''", trim($options['query']));

        if (!empty($count)) {
            $queryUpdate = "update ME_UserQuery set Query='" . $QueryValue . "',StatusID=1  where ProductionEntityId='" . $options['ProductionEntity'] . "' and ModuleId='" . $options['moduleId'] . "'";
            $connection->execute($queryUpdate);
        }else {
            $queryInsert = "Insert into ME_UserQuery (ProjectId,RegionId,UserID,ProductionEntityId,ModuleId,Query,QueryRaisedDate,StatusID,RecordStatus,CreatedDate,CreatedBy) values('" . $options['ProjectId'] . "','" . $options['RegionId'] . "','" . $options['user'] . "','" . $options['ProductionEntity'] . "','" . $options['moduleId'] . "','" . $QueryValue . "','" . date('Y-m-d H:i:s') . "',1,1,'" . date('Y-m-d H:i:s') . "','" . $options['user'] . "')";
            $connection->execute($queryInsert);
        }
        return $options['query'];
    }
    

}
