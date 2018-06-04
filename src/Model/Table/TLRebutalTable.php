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
 * Requirement : REQ-004
 * Form : TL Rebutal
 * Developer: Syedismail N
 * Created On: 29 Aug 2017
 */

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\DateTime;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

class TLRebutalTable extends Table {

    public function initialize(array $config) {
        $this->table('ProductionEntityMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    public function findBatches(Query $query, array $options) {

        $connection = ConnectionManager::get('default');
        $QcStatusId = $options['QcStatusId'];
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ModuleId = $options['ModuleId'];
        $UserGroupId = $options['UserGroupId'];

        $QcStatusDetails = $connection->execute("select Id,ProjectId,RegionId,ProcessId,BatchName,EntityCount,ProductionStartDate,"
                . "ProductionEndDate,StatusId,RecordStatus FROM MV_QC_BatchMaster WHERE StatusId IN ($QcStatusId) "
                . "and ProjectId='" . $ProjectId . "' and RegionId='" . $RegionId . "' and ProcessId='" . $ModuleId . "' and UserGroupId='" . $UserGroupId . "' and RecordStatus=1");
        $QcStatusDetails = $QcStatusDetails->fetchAll('assoc');

        return array($QcStatusDetails);
    }

    public function findBatchesDetails(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $BatchId = $options['BatchId'];
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ProcessId = $options['ProcessId'];
        $QcStatusId = $options['QcStatusId'];

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $ModuleAttributes = $contentArr['ModuleAttributes'];

        $SelectProductionTimeMetric = $connection->execute("SELECT * FROM ME_Production_TimeMetric where Qc_Batch_Id=$BatchId and ProjectId=$ProjectId and RegionId = $RegionId");
        $SelectProdTimeMetric = $SelectProductionTimeMetric->fetchAll('assoc');
        foreach ($SelectProdTimeMetric as $key => $row):
            $SelectProdTimeInputEntityId[$key] = $row['InputEntityId'];
        endforeach;
        $ProdTimeInputEntityId = implode("', '", $SelectProdTimeInputEntityId);

        $staticModuleAttributes = $ModuleAttributes[$RegionId][$ProcessId]['static'];
        $productionModuleAttributes = $ModuleAttributes[$RegionId][$ProcessId]['production'];
        $AllModuleAttributes = array_merge($staticModuleAttributes, $productionModuleAttributes);

        foreach ($AllModuleAttributes as $key => $row):
            $SelectModuleAttributes['Header'][$row['AttributeMasterId']] = $row['DisplayAttributeName'];
        endforeach;

        $StagingModule = $SelectNextModuleDetails[0];
        $Staging = "Staging_" . $StagingModule . "_Data";

        $SelectAttributesArray = array_keys($SelectModuleAttributes);
        $Attributes_value = implode("],[", $SelectAttributesArray);

        foreach ($SelectProdTimeInputEntityId as $key => $value):

            $ProdSeqCount = $connection->execute("SELECT TOP 1 MAX(SequenceNumber) as SeqCount FROM ME_ProductionData WHERE ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId IN ('$value') group by SequenceNumber order by SequenceNumber desc");
            $ProdSeqCount = $ProdSeqCount->fetchAll('assoc');

            for ($i = 1; $i <= $ProdSeqCount[0]['SeqCount']; $i++) {
                $ProdDataDetails = $connection->execute("SELECT Id,InputEntityId,SequenceNumber,AttributeMasterId,ProjectAttributeMasterId,AttributeValue FROM ME_ProductionData WHERE ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId IN ('$value') and SequenceNumber=$i");
                $ProdDataDetails = $ProdDataDetails->fetchAll('assoc');

                $ProdArr = array();
                foreach ($ProdDataDetails as $keys => $val):
                    $ProdArr['InputEntityId'] = $val['InputEntityId'];
                endforeach;
                $ProdArr['Data'] = $ProdDataDetails;

                $ProdArray[] = $ProdArr;
            }
        endforeach;

        $ProdTemplateMaster = $connection->execute("SELECT Id,BlockName FROM ME_ProductionTemplateMaster WHERE ProjectId=$ProjectId and BlockName IN ('static_fields','readonly_fields') and RecordStatus=1");
        $ProdTemplateMaster = $ProdTemplateMaster->fetchAll('assoc');
        foreach ($ProdTemplateMaster as $key => $value):
            $ProdTemp['TempMaster'][$key] = $value;
        endforeach;

        foreach ($ProdTemplateMaster as $key => $value):
            $TempMasterId = $value['Id'];

            $TempAttributeMap = $connection->execute("SELECT Id,AttributeMasterId,TemplateMasterId FROM ME_TemplateAttributeMapping WHERE ProjectId=$ProjectId and RegionId=$RegionId and TemplateMasterId=$TempMasterId and RecordStatus=1");
            $TempAttributeMap = $TempAttributeMap->fetchAll('assoc');
            $TempAttributeMaps[$key] = $TempAttributeMap;
        endforeach;

        foreach ($TempAttributeMaps as $key => $AttrMapsval):
            foreach ($AttrMapsval as $key => $AttMapval):
                $ProdArray['AttributeMasterId'][] = $AttMapval['AttributeMasterId'];

            endforeach;
        endforeach;

        return array_merge($ProdArray, $SelectModuleAttributes);
    }

    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];

        $ProjectId = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        $Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ProjectId in (' . $ProjectId . ') AND RecordStatus = 1');
        $Field = $Field->fetchAll('assoc');
        return $Field;
    }

    public function findRegion(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';

        if ($options['RegionId'] != '') {
            $RegionId = $options['RegionId'];
        }
        $call = 'getModule();getusergroupdetails(this.value)';
        $template = '';
        $template.='<select name="RegionId" id="RegionId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $region = $contentArr['RegionList'];
            if (count($region) == 1 && isset($options['SetIfOneRow'])) {
                $RegionId = array_keys($region)[0];
            }
            foreach ($region as $key => $val):
                if ($key == $RegionId) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $key . '" >';
                $template.=$val;
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    public function findModule(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        if ($options['ModuleId'] != '') {
            $ModuleId = $options['ModuleId'];
        }
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $call = 'getStatus();';
        $template = '';
        $template = '<select name="ModuleId" id="ModuleId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $module = $contentArr['Module'];
            foreach ($module as $key => $value) {
                $moduleconfig = $contentArr['ModuleConfig'];
                if (($moduleconfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleconfig[$key]['IsModuleGroup'] == 1)) {
                    if ($key == $ModuleId) {
                        $selected = 'selected=' . $ModuleId;
                    } else {
                        $selected = '';
                    }
                    $template.='<option ' . $selected . ' value="' . $key . '">';
                    $template.=$value;
                    $template.='</option>';
                }
            }
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    function findUsergroupdetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserId = $options['UserId'];

        if ($options['UserGroupId'] != '') {
            $UserGroupId = $options['UserGroupId'];
        }

        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserGroupId,UGMaster.GroupName from MV_UserGroupMapping as UGMapping INNER JOIN MV_UserGroupMaster as UGMaster ON UGMapping.UserGroupId = UGMaster.Id"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserId = " . $UserId . " AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
        $queries = $queries->fetchAll('assoc');
        $template = '';
        $template.='<select name="UserGroupId" id="UserGroupId"  class="form-control" style="margin-top:17px;"><option value=0>--Select--</option>';
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                if ($val['UserGroupId'] == $UserGroupId) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $val['UserGroupId'] . '" >';
                $template.=$val['GroupName'];
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

}
