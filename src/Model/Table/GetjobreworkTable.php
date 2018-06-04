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
 * Form : Getjobrework
 * Developer: SyedIsmail N
 * Created On: Sep 19 2017
 */

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
class GetjobreworkTable extends Table {

    public function initialize(array $config) {
        $this->table('Staging_1149_Data');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
        $this->ModuleId = 1149;
    }

    public function findQuerypost(Query $query, array $options) {

        $connection = ConnectionManager::get('default');
        $count = $connection->execute("SELECT Id FROM ME_UserQuery WHERE ProductionEntityId='" . $options['ProductionEntity'] . "' AND RecordStatus=1")->fetchAll('assoc');
        $QueryValue = str_replace("'", "''", trim($options['query']));

        if (!empty($count)) {
            $queryUpdate = "update ME_UserQuery set Query='" . $QueryValue . "'  where ProductionEntityId='" . $options['ProductionEntity'] . "' and ModuleId=$this->ModuleId";
            $connection->execute($queryUpdate);
        } else {
            $queryInsert = "Insert into ME_UserQuery (ProjectId,UserID,ProductionEntityId,ModuleId,Query,QueryRaisedDate,StatusID,RecordStatus,CreatedDate,CreatedBy) values('" . $options['ProjectId'] . "','" . $options['user'] . "','" . $options['ProductionEntity'] . "','" . $options['moduleId'] . "','" . $QueryValue . "','" . date('Y-m-d H:i:s') . "',1,1,'" . date('Y-m-d H:i:s') . "','" . $options['user'] . "')";
            $connection->execute($queryInsert);
        }
        return $options['query'];
    }

    public function findCommandInfo(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $InputEntityId = $options['InputEntityId'];
        $ModuleId = $options['ModuleId'];
        $StatusId = 2;

        $timeDetails = array();
        //$QcTimeMetrics = $connection->execute("SELECT Id,ProjectId,RegionId,InputEntityId,AttributeMasterId,ProjectAttributeMasterId,OldValue,QCValue,QCComments,Reference,ErrorCategoryMasterId,SubErrorCategoryMasterId,SequenceNumber,UserId,StatusId,TLReputedComments,UserReputedComments,RecordStatus FROM MV_QC_Comments WHERE ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId=$InputEntityId and StatusId=2 and RecordStatus=1")->fetchAll("assoc");
        $QcTimeMetrics = $connection->execute("SELECT QCC.Id,QCC.ProjectId,QCC.RegionId,QCC.InputEntityId,QCC.AttributeMasterId,QCC.ProjectAttributeMasterId,
            QCC.OldValue,QCC.QCValue,QCC.QCComments,QCC.Reference,QCC.ErrorCategoryMasterId,QCC.SubErrorCategoryMasterId,
            QCC.SequenceNumber,QCC.UserId,QCC.StatusId,QCC.TLReputedComments,QCC.UserReputedComments,QEC.ErrorCategoryName,
            QSC.SubCategoryName FROM MV_QC_Comments as QCC INNER JOIN MV_QC_ErrorCategoryMaster as QEC ON QCC.ErrorCategoryMasterId=QEC.Id 
            INNER JOIN MV_QC_ErrorSubCategoryMaster as QSC ON QCC.SubErrorCategoryMasterId=QSC.Id WHERE QCC.ProjectId= $ProjectId 
            and QCC.RegionId=$RegionId and QCC.InputEntityId = $InputEntityId and QCC.StatusId NOT IN (0) and QSC.RecordStatus=1")->fetchAll("assoc");
        $i = 0;
        foreach ($QcTimeMetrics as $time):
            $timeDetails[$i]['Id'] = $time['Id'];
            $timeDetails[$i]['ProjectId'] = $time['ProjectId'];
            $timeDetails[$i]['RegionId'] = $time['RegionId'];
            $timeDetails[$i]['InputEntityId'] = $time['InputEntityId'];
            $timeDetails[$i]['AttributeMasterId'] = $time['AttributeMasterId'];
            $timeDetails[$i]['ProjectAttributeMasterId'] = $time['ProjectAttributeMasterId'];
            $timeDetails[$i]['OldValue'] = $time['OldValue'];
            $timeDetails[$i]['QCValue'] = $time['QCValue'];
            $timeDetails[$i]['QCComments'] = $time['QCComments'];
            $timeDetails[$i]['Reference'] = $time['Reference'];
            $timeDetails[$i]['ErrorCategoryName'] = $time['ErrorCategoryName'];
            $timeDetails[$i]['SubCategoryName'] = $time['SubCategoryName'];
            $timeDetails[$i]['SequenceNumber'] = $time['SequenceNumber'];
            $timeDetails[$i]['UserId'] = $time['UserId'];
            $timeDetails[$i]['StatusId'] = $time['StatusId'];
            $timeDetails[$i]['TLReputedComments'] = $time['TLReputedComments'];
            $timeDetails[$i]['UserReputedComments'] = $time['UserReputedComments'];
            $timeDetails[$i]['ModuleId'] = $options['ModuleId'];
            $i++;
        endforeach;
        return $timeDetails;
    }

    public function findUpdateCommand(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $UserId = $options['UserId'];
        $ModuleId = $options['data']['ModuleId'];
        $NextStatusId = $options['NextStatusId'];
        $cnt = count($options['data']['cmd']);
        for ($i = 0; $i < $cnt; $i++) {
            $Id = $options['data']['cmd'][$i];
            $StagingTable = "Staging_" . $ModuleId . "_Data";
            $qcstatus = $options['data']['qcstatus' . $options['data']['cmd'][$i]];
            $AttributeMasterId = $options['data']['AttributeMasterId' . $options['data']['cmd'][$i]];
            $ProjectAttributeMasterId = $options['data']['ProjectAttributeMasterId' . $options['data']['cmd'][$i]];
            $InputEntityId = $options['data']['InputEntityId' . $options['data']['cmd'][$i]];
            $SequenceNumber = $options['data']['SequenceNumber' . $options['data']['cmd'][$i]];
            $QCValue = $options['data']['QCValue' . $options['data']['cmd'][$i]];
            $UserReputedComments = $options['data']['UserReputedComments_' . $options['data']['cmd'][$i]];

            $CheckTable = $connection->execute("select COUNT(*) InputEntityId from ME_ProductionData where InputEntityId=$InputEntityId and ProjectAttributeMasterId=$ProjectAttributeMasterId and RecordStatus=1");
            foreach ($CheckTable as $Table):
                if ($Table['InputEntityId'] != 0) {
                    if (($qcstatus == 4)) {
                        //$StagingTableCommentsUpdate = $connection->execute("UPDATE $StagingTable SET [" . $AttributeMasterId . "]='" . $QCValue . "',ModifiedBy=$UserId,ModifiedDate='" . date('Y-m-d H:i:s') . "' WHERE InputEntityId=$InputEntityId and SequenceNumber=$SequenceNumber");
                        $MvQcCommentsUpdate = $connection->execute("update MV_QC_Comments set StatusId=" . $qcstatus . ", ModifiedBy=" . $options['UserId'] . ",ModifiedDate='" . date('Y-m-d H:i:s') . "' where Id=$Id and InputEntityId=$InputEntityId and SequenceNumber=$SequenceNumber");
                    } else {
                        $MvQcCommentsUpdate = $connection->execute("update MV_QC_Comments set UserReputedComments='" . $UserReputedComments . "' ,StatusId=" . $qcstatus . ", ModifiedBy=" . $options['UserId'] . ",ModifiedDate='" . date('Y-m-d H:i:s') . "' where Id=$Id and InputEntityId=$InputEntityId and SequenceNumber=$SequenceNumber");
                    }
                }
            endforeach;
        }
    }
    
    public function findSubcategory(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $CategoryId = $options['CategoryId'];
        $subCategory = $connection->execute("SELECT Id,SubCategoryName FROM MV_QC_ErrorSubCategoryMaster where ErrorCatId= $CategoryId")->fetchAll('assoc');

        $template = '';
        $template.='<select name="SubCategory" id="SubCategory" style= "margin-top:17px;" class="form-control"><option value=0>--Select--</option>';
        if (!empty($subCategory)) {
            foreach ($subCategory as $key => $val):
                $template.='<option value="' . $val['Id'] . '" >';
                $template.=$val['SubCategoryName'];
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }
    
    function ajax_GetOldDatavalue($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber) {
        $connection = ConnectionManager::get('default');
        $cmdOldData = $connection->execute("select count(*) OldDataCount from MV_QC_Comments where AttributeMasterId = $AttributeMasterId and ProjectAttributeMasterId=$ProjectAttributeMasterId and InputEntityId=$InputEntyId and SequenceNumber = $SequenceNumber and StatusID IN (1,2)")->fetchAll('assoc');
        return $cmdOldData[0];
    }

    function ajax_GetRebutalvalue($InputEntyId, $AttributeMasterId, $ProjectAttributeMasterId, $SequenceNumber) {
        $connection = ConnectionManager::get('default');
        $cmdOldData = $connection->execute("select count(*) OldDataCount from MV_QC_Comments where AttributeMasterId = $AttributeMasterId and ProjectAttributeMasterId=$ProjectAttributeMasterId and InputEntityId=$InputEntyId and SequenceNumber = $SequenceNumber and StatusID=2")->fetchAll('assoc');
        return $cmdOldData[0];
    }
    
    public function findGetolddata(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $AttributeMasterId = $options[0]['AttributeMasterId'];
        $ProjectAttributeMasterId = $options[0]['ProjectAttributeMasterId'];
        $InputEntityId = $options[0]['InputEntyId'];
        $SequenceNumber = $options[0]['SequenceNumber'];
        $cmdOldData = $connection->execute("select * from MV_QC_Comments where AttributeMasterId = $AttributeMasterId and ProjectAttributeMasterId= $ProjectAttributeMasterId and InputEntityId= $InputEntityId and RecordStatus = 1 and SequenceNumber=$SequenceNumber and StatusID IN (1,4,5)")->fetchAll('assoc');
        return $cmdOldData[0];
    }
    
    public function findCommentStatus(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $InputEntyId = $options['InputEntyId'];
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $cmdStatusData = $connection->execute("select COUNT(id) as CntVal from MV_QC_Comments where ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId=$InputEntyId And StatusID IN (1,2)")->fetchAll('assoc');
        return $cmdStatusData[0]['CntVal'];
    }

}
