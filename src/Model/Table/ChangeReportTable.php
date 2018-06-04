<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

class ChangeReportTable extends Table {

    public function initialize(array $config) {
        $this->table('ProductionEntityMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
        
    }

    public function findRegion(Query $query, array $options) {

        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
                if($options['RegionId']!=''){
           $RegionId = $options['RegionId'];
        }
        $call = 'getusergroupdetails(this.value);';
        $template = '';
        $template.='<select name="RegionId" style="width:150px;" id="RegionId" class="form-control"  onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $region = $contentArr['RegionList'];
            foreach ($region as $key => $val):
                            if($key == $RegionId){
                $selected = 'selected='.$RegionId;
            }else{$selected = '';}
                $template.='<option '.$selected.' value="' . $key . '" >';
                $template.=$val;
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        }else {
            $template.='</select>';
            return $template;
        }
    }

    public function findUsers(Query $query, array $options) {
        
        $connection = ConnectionManager::get('default');
        $from = strtotime($options['batch_from']);
        $month = date("n", $from);
        $year = date("Y", $from);
        $to = strtotime($options['batch_to']);
        $tomonth = date("n", $to);
        $toyear = date("Y", $to);
        $UserGroupId = $options['UserGroupId'];
        $ModuleId = $options['Module_Id'];
        
        $finalArr=array();
        //////////////////////////////////////get user group name based on user id
        $UserIdCondition = '';
        if (!empty($UserId))
            $UserIdCondition = " AND UGMap.UserId IN (" .$UserIdImploded. ")";
        
        $queriesUGMappingName = $connection->execute("select UGMap.UserId, UGMas.GroupName from MV_UserGroupMapping UGMap"
                ." INNER JOIN MV_UserGroupMaster as UGMas ON UGMas.Id = UGMap.UserGroupId"
                . " where UGMap.UserGroupId IN (".$UserGroupId.") $UserIdCondition AND UGMap.ProjectId = ".$options['Project_Id']." AND UGMap.RegionId = ".$options['Region_Id']." AND UGMap.RecordStatus = 1 GROUP BY UGMap.UserId, UGMas.GroupName");
        $queriesUGMappingName = $queriesUGMappingName->fetchAll('assoc');
        
        $queriesUGNamedetails = array();
        foreach ($queriesUGMappingName as $row):
            $queriesUGNamedetails[$row['UserId']] = $row['GroupName'];
        endforeach;
        
        if ($month == $tomonth && $toyear == $year && $options['batch_to'] != '' && $options['batch_from'] != '') {

            if(!empty($options['select_fields'])){
                $queries = $connection->execute("select ".implode(',', $options['select_fields'])." from Report_ChangeUrlMonitoring_".$month."_".$year." as CUM"
                        . " INNER JOIN ME_Production_TimeMetric_" . $month . "_" . $year . " as PTM ON CUM.InputEntityId=PTM.InputEntityId"
                    . " where" . $options['condition'] . " AND Module_Id = $ModuleId GROUP BY ".implode(',', $options['select_fields'])." ");
            }else{
                return FALSE;
            }
            
        } else {

            $connection = ConnectionManager::get('default');
            $start  =   new \DateTime($options['batch_from']);
            $end  =   new \DateTime($options['batch_to']);
            $interval = \DateInterval::createFromDateString('1 month');
            $period   = new \DatePeriod($start, $interval, $end);

            foreach ($period as $dt) {
                $month=$dt->format("n");
                $year=$dt->format("Y");
             
                $queries = array();
                if(!empty($options['select_fields'])){
                $queries = $connection->execute("select ".implode(',', $options['select_fields'])." from Report_ChangeUrlMonitoring_".$month."_".$year." as CUM"
                    . " INNER JOIN ME_Production_TimeMetric_" . $month . "_" . $year . " as PTM ON CUM.InputEntityId=PTM.InputEntityId"
                . " where" . $options['condition'] . " AND Module_Id = $ModuleId GROUP BY ".implode(',', $options['select_fields'])." ");
                }else{
                    return FALSE;
                }
            }
            $finalArr[0]=$queries;
            $finalArr[1]=$queriesUGNamedetails;
            return $finalArr;
        }
        $finalArr[0]=$queries;
        $finalArr[1]=$queriesUGNamedetails;
        return $finalArr;
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
                    . " where UGMapping.ProjectId = ".$ProjectId." AND UGMapping.RegionId = ".$RegionId." AND UGMapping.UserId = ".$UserId." AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
        $queries = $queries->fetchAll('assoc');
        $template = '';
        $template.='<select name="UserGroupId" id="UserGroupId"  class="form-control" style="margin-top:17px;" onchange="getresourcedetails()">';
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                if ($key == $UserGroupId) {
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
    
    function findResourcedetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];
        
        if ($options['UserId'] != '') {
            $UserId = $options['UserId'];
        }
        
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        
        $connection = ConnectionManager::get('default');

        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                ." where UGMapping.ProjectId = ".$ProjectId." AND UGMapping.RegionId = ".$RegionId." AND UGMapping.UserGroupId IN (". $UserGroupId.") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                ." SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = ".$ProjectId." AND ModuleId = 2 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                .") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');
        
        $template = '';
        $template.='<select multiple=true name="user_id[]" id="user_id"  class="form-control" style="margin-top:17px;">';
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                if ($key == $UserId) {
                    $selected = '';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $val['UserId'] . '" >';
                $template.= $user_list[$val['UserId']];
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }
    
    function findResourceDetailsArrayOnly(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];
        
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        
        $connection = ConnectionManager::get('default');
        
//        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
//                    . " where UGMapping.ProjectId = ".$ProjectId." AND UGMapping.RegionId = ".$RegionId." AND UGMapping.UserGroupId IN (".$UserGroupId.") AND UGMapping.RecordStatus = 1 GROUP BY UGMapping.UserId");
//        $queries = $queries->fetchAll('assoc');
        
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                ." where UGMapping.ProjectId = ".$ProjectId." AND UGMapping.RegionId = ".$RegionId." AND UGMapping.UserGroupId IN (". $UserGroupId.") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                ." SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = ".$ProjectId." AND ModuleId = 2 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                .") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');

        $template = array();
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                $template[$val['UserId']] = $user_list[$val['UserId']];
            endforeach;            
        }
        return $template;
    }
    
    function getExportData($Production_dashboard) {

        $tableData = '<table>';
        $tableData.='<tr><td>Project</td><td>Resource</td><td>Status</td><td>Production Start Date</td><td>Production End Date</td><td>Production Time</td></tr>';
        foreach ($Production_dashboard as $inputVal => $input):

            $path = JSONPATH . '\\ProjectConfig_' . $input['ProjectId'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $user_list = $contentArr['UserList'];
            $status_list = $contentArr['ProjectStatus'];

            $tableData.='<tr><td>' . $contentArr[$input['ProjectId']] . '</td>';
            $tableData.='<td>' . $input['UserId'] . '</td>';
            $tableData.='<td>' . $status_list[$input['StatusId']] . '</td>';
            $tableData.='<td>' . $input['ProductionStartDate'] . '</td>';
            $tableData.='<td>' . $input['ProductionEndDate'] . '</td>';
            $tableData.='<td>' . $input['TotalTimeTaken'] . '</td>';
            $tableData.='</tr>';
            $i++;
        endforeach;
        $tableData.='</table>';
        return $tableData;
    }
    public function findGetmapping(Query $query, array $options){
        $connection = ConnectionManager::get('default');
        $Fields = $connection->execute("SELECT AttributeMasterId,ProjectAttributeMasterId,OrderId FROM ME_ClientOutputTemplateMapping WHERE ProjectId=".$options['Project_Id']." AND RegionId=".$options['Region_Id']." ORDER BY OrderId")->fetchAll('assoc');
        $path = JSONPATH . '\\ProjectConfig_' . $options['Project_Id'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $module = $contentArr['Module'];
            $moduleConfig = $contentArr['ModuleConfig'];
            $JsonArray=$contentArr['AttributeOrder'][$options['Region_Id']];
        $firldArr=array();
        $i=1;
        $j=0;
        $Headers = array();
        foreach($Fields as $val)  {
            
            if(is_numeric($val['ProjectAttributeMasterId'])){
                $firldArr['Fields'][$j]='['.$val['AttributeMasterId'].'],['.$val['AttributeMasterId'].'_old],['.$val['AttributeMasterId'].'_changed]';
            }else{
                $firldArr['Fields'][$j]='['.$val['AttributeMasterId'].']';
            }
           if(is_numeric($val['ProjectAttributeMasterId'])){
               array_push($Headers, $JsonArray[$val['ProjectAttributeMasterId']]['DisplayAttributeName']);
               $i++;
               array_push($Headers, $JsonArray[$val['ProjectAttributeMasterId']]['DisplayAttributeName'].'_old');
               $i++;
               array_push($Headers, $JsonArray[$val['ProjectAttributeMasterId']]['DisplayAttributeName'].'_changed');
               $i++;
                //$firldArr['Headers'][$i]=$JsonArray[$val['ProjectAttributeMasterId']]['DisplayAttributeName'].','.$JsonArray[$val['ProjectAttributeMasterId']]['DisplayAttributeName'].'_old'.','.$JsonArray[$val['ProjectAttributeMasterId']]['DisplayAttributeName'].'_changed';
                //$firldArr['Fields'][$i]='['.$val['AttributeMasterId'].']';
            }
            elseif ($val['AttributeMasterId'] == 'UserId')  {
                foreach ($module as $key => $value) {
                    if ($moduleConfig[$key]['IsUrlMonitoring'] == 1) {
                
                        $firldArr['UserId']['Order'] = $i;
                        $moduleUserGroup = $value . '_UserId';
                        //$firldArr['Headers'][$i] = $moduleUserGroup;
                        array_push($Headers, $moduleUserGroup);
                        $i++;
                        
                        $moduleUserGroup = $value . '_UserGroup';
                        //$firldArr['Headers'][$i] = $moduleUserGroup;
                        array_push($Headers, $moduleUserGroup);
                        $i++;
                        
                        $moduleUserGroup = $value . '_Start_Date';
                        array_push($Headers, $moduleUserGroup);
                        $i++;
                        
                        $moduleUserGroup = $value . '_End_Date';
                        array_push($Headers, $moduleUserGroup);
                        $i++;
                        
                        $moduleUserGroup = $value . '_Time_Taken';
                        array_push($Headers, $moduleUserGroup);
                        $i++;
                
                    }
                }
            } 
            else {
                //$firldArr['Headers'][$i]=$val['ProjectAttributeMasterId'];
                array_push($Headers, $val['ProjectAttributeMasterId']);
                $i++;
            }
            if ($val['AttributeMasterId'] == 'UserId') {
                //$firldArr['UserId']['Order'] = $val['OrderId'];
            }
            if ($val['AttributeMasterId'] == 'QcUserId') {
                $firldArr['QcUserId']['Order'] = $val['OrderId'];
            }
            $j++;
        }
        //pr($Headers);exit;
        return array($Headers,$firldArr);
    }
    
    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];

        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        //$Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ProjectId in (' . $test . ') AND RecordStatus = 1');
        $Field = $connection->execute("SELECT MLC.Project as ProjectId,PM.ProjectName,MLC.ModuleId FROM ME_Module_Level_Config MLC,ProjectMaster PM WHERE PM.ProjectID=MLC.Project AND MLC.IsUrlMonitoring=1 AND MLC.RecordStatus =1 AND PM.RecordStatus=1");
        $Field = $Field->fetchAll('assoc');
        return $Field;
    }
}
