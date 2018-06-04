<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * Requirement : REQ-003
 * Form : ProductionFieldsMapping
 * Developer: Jaishalini R
 * Created On: Nov 12 2015
 */

namespace App\Model\Table;
use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Session;

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */

class GetInvalidViewTable extends Table {
    
    public function initialize(array $config)
    {
        //$this->table('Staging_1156_Data');
        $session = new Session();
        $moduleId = $session->read('moduleId');
        $this->table('Staging_'.$moduleId.'_Data');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }
    
    public function findGetInvalidDomainUrl(Query $query,array $options){
        
        $connection = ConnectionManager::get('default');
        //$DomainUrlVal = $connection->execute("SELECT * FROM ME_DomainUrl_".$options['DomainUrlMonthYear']." as MDM INNER JOIN ME_InvalidUrl as MIU ON MDM.InputId = MIU.InputId WHERE MDM.DomainId='".$options['DomainId']."' AND MDM.DomainUrl='".$options['DomainUrl']."' AND MDM.RecordStatus=1")->fetchAll('assoc');
        $DomainUrlVal = $connection->execute("SELECT * FROM ME_DomainUrl_".$options['DomainUrlMonthYear']." WHERE DomainId='".$options['DomainId']."' AND DomainUrl='".$options['DomainUrl']."' AND RecordStatus=1")->fetchAll('assoc');
        //$DomainUrlVal = $connection->execute("SELECT * FROM ME_InvalidUrl WHERE DomainId='".$options['DomainId']."' AND DomainUrl='".$options['DomainUrl']."' AND RecordStatus=1")->fetchAll('assoc');
        return $DomainUrlVal;
    }
    public function findGetInvalidDomainUrlRemarks(Query $query,array $options){
        
        $connection = ConnectionManager::get('default');
        $DomainUrlVal = $connection->execute("SELECT * FROM ME_DomainUrl_".$options['DomainUrlMonthYear']." as MDM INNER JOIN ME_InvalidUrl as MIU ON MDM.InputId = MIU.InputId WHERE MDM.DomainId='".$options['DomainId']."' AND MDM.DomainUrl='".$options['DomainUrl']."' AND MDM.RecordStatus=1")->fetchAll('assoc');
        //$DomainUrlVal = $connection->execute("SELECT * FROM ME_DomainUrl_".$options['DomainUrlMonthYear']." WHERE DomainId='".$options['DomainId']."' AND DomainUrl='".$options['DomainUrl']."' AND RecordStatus=1")->fetchAll('assoc');
        //$DomainUrlVal = $connection->execute("SELECT * FROM ME_InvalidUrl WHERE DomainId='".$options['DomainId']."' AND DomainUrl='".$options['DomainUrl']."' AND RecordStatus=1")->fetchAll('assoc');
        return $DomainUrlVal;
    }
    
    public function findGetUrlRemarks(Query $query,array $options){
        $connection = ConnectionManager::get('default');
        $UrlRemarks = $connection->execute("select ID,Remarks from ME_UrlRemarks where RecordStatus=1")->fetchAll('assoc');
        foreach($UrlRemarks as $key=>$value){
            $Remarks[$value['ID']]= $value['Remarks'];
        }
        return $Remarks;
    }

    public function findUpdateInvalidDomainUrl(Query $query,array $options){
        $connection = ConnectionManager::get('default');
        $ModifiedDate = date("Y-m-d H:i:s");
        $Reason = $options['Reason'];
        if($options['Remarks']!='17')
            $Reason='';

        $delete = $connection->execute("DELETE FROM ME_InvalidUrl WHERE DomainId='".$options['DomainId']."' and InputId='".$options['FirstLinkInputId']."' and CreatedDate='".date("Y-m-d")."'");
        
        $queryUpdate = "INSERT INTO ME_InvalidUrl (ProjectId,RegionId,InputEntityId,DomainId,DomainUrl,InputId,Remarks,Reason,RecordStatus,CreatedDate,ModifiedDate,ModifiedBy)"
                . "values('".$options['ProjectId']."','".$options['RegionId']."','".$options['InputEntityId']."','".$options['DomainId']."','".$options['DomainUrlLink']."',"
                . "'".$options['FirstLinkInputId']."','".$options['Remarks']."','".$options['Reason']."',1,'".date("Y-m-d")."','".$ModifiedDate."','".$options['UserId']."')";
        $connection->execute($queryUpdate);
    }
    
}
