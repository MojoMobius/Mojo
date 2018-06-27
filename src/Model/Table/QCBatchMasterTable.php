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

class QCBatchMasterTable extends Table {

    public function initialize(array $config) {
        $this->table('MV_QC_BatchMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    public function findRegion(Query $query, array $options) {

        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if ($options['RegionId'] != '') {
            $RegionId = $options['RegionId'];
        }
        $call = 'getModule();getusergroupdetails(this.value);';
        $template = '';
        $template.='<select name="RegionId" id="RegionId" class="form-control"  onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $region = $contentArr['RegionList'];

            if (count($region) == 1 && isset($options['SetIfOneRow'])) {
                $RegionId = array_keys($region)[0];
            }

            foreach ($region as $key => $val):
                if ($key == $RegionId) {
                    $selected = 'selected=' . $RegionId;
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
        $template = '';
        $template = '<select name="ModuleId" id="ModuleId" class="form-control"><option value=0>--Select--</option>';
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

    public function findStatuslist(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $ModuleId = $options['ModuleId'];
        if ($options['status'] != '') {
            $statusselid = $options['status'];
        }
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $call = '';
        $template = '';
        $template = '<select name="status[]" id="status" style="height:60px;width:200px;margin-top:15px;" onchange="' . $call . '" multiple="multiple">';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $modulestatuslist = $contentArr['ModuleStatusList'][$ModuleId];
            $statuslist = $contentArr['ProjectStatus'];

            $pos = array_search('Completed', $modulestatuslist);
            $searchword = 'Completed';
            $matches = array_filter($modulestatuslist, function($var) use ($searchword) {
                return preg_match("/\b$searchword\b/i", $var);
            });
            $array_with_lcvalues = array_map('strtolower', $matches);
            //pr($array_with_lcvalues);
            foreach ($matches as $key => $value) {
                $statusid = array_search(strtolower($value), $array_with_lcvalues);
                if (in_array($statusid, $statusselid)) {
                    $selected = 'selected=' . $statusid;
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . '  value="' . $statusid . '">';
                $template.=$value;
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
        } else {
            $template.='<option  value="">';
            $template.='--select--';
            $template.='</option>';
            $template.='</select>';
            return $template;
        }
    }

    function findUsergroupdetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserId = $options['UserId'];

        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserGroupId,UGMaster.GroupName from MV_UserGroupMapping as UGMapping INNER JOIN MV_UserGroupMaster as UGMaster ON UGMapping.UserGroupId = UGMaster.Id"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserId = " . $UserId . " AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
        $queries = $queries->fetchAll('assoc');
        $call = 'getAvailableDate(this.value);';
        $template = '';
        $template.='<select name="UserGroupId" id="UserGroupId"  class="form-control" onchange="' . $call . '" style="margin-top:17px;"><option value=0>--Select--</option>';
        if (!empty($queries)) {
            foreach ($queries as $key => $val):

                $template.='<option value="' . $val['UserGroupId'] . '" >';
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
//        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
//                    . " where UGMapping.ProjectId = ".$ProjectId." AND UGMapping.RegionId = ".$RegionId." AND UGMapping.UserGroupId IN (".$UserGroupId.") AND UGMapping.RecordStatus = 1 GROUP BY UGMapping.UserId");
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 2 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");
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
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 2 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');

        $template = array();
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                $template[$val['UserId']] = $user_list[$val['UserId']];
            endforeach;
        }
        return $template;
    }

    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];

        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        $Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ProjectId in (' . $test . ') AND RecordStatus = 1');
        $Field = $Field->fetchAll('assoc');
        return $Field;
    }

    public function findAvailabledate(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ModuleId = $options['ModuleId'];
        $UserGroupId = $options['UserGroupId'];
        $QcModuleId = $options['QcModuleId'];

        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");

        $queries = $queries->fetchAll('assoc');
        $Queriesresult = array_map('current', $queries);
        $UserList = implode(",", $Queriesresult);
        
                $CompletedRecords = $connection->execute("SELECT distinct(CONVERT(varchar(10), Start_Date, 105)) as StartDate FROM ME_Production_TimeMetric where ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and QcStatusId = 1 and QC_Module_Id=$QcModuleId")->fetchAll('assoc');
      
        $Completedresult = array_map('current', $CompletedRecords);
        $StartDate = implode("   ,   ", $Completedresult);  
        
        if ($StartDate == '') {
            $StartDate = "No Date available to create the batch";
        }
        $tableData = '<div class="bs-example" style="margin-top:20px;">';
        $tableData .= '<table id="AddOptionTable" class="table table-striped table-center">';
        $tableData.='<thead><tr><th style="text-align:center;">Available Batch Creation Date(s)</th></tr></thead>';
        $tableData.='<tbody><tr><td> <div style="text-align:center;" class="col-sm-12"><b> ' . $StartDate . ' </b></div> </td>';
        $tableData.='</tr></tbody>';
        $tableData.='</table>';
        $tableData .= '</div>';

        return $tableData;
    }
    public function findAvailableproduction(Query $query, array $options) {
	
	
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ModuleId = $options['ModuleId'];
        $UserGroupId = $options['UserGroupId'];
        $QcModuleId = $options['QcModuleId'];
        
        $batch_from = $options['batch_from'];
        $batch_to = $options['batch_to'];
        $from_time = $options['FromTime'];
        $to_time = $options['ToTime'];
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $ProjectStatus=$contentArr['ProjectStatus'];
        $userlist=$contentArr['UserList'];
        $domainId=$contentArr['ProjectConfig']['DomainId'];
        
        $ProductionStartDate = $batch_from;
            $ProductionStartDate = date("Y-m-d", strtotime($ProductionStartDate));
            $ProductionStartTime = $from_time;
            if($batch_to=='')
                $ProductionEndDate = date("Y-m-d");
            else
                $ProductionEndDate = $batch_to;
            
            $ProductionEndDate = date("Y-m-d", strtotime($ProductionEndDate));
            $ProductionEndTime = $to_time;

            if ($ProductionStartTime == '') {
                $ProductionStartTime = '00:00:00';
            }
            

            $conditions = ''; $joinoperator='';

            if ($ProductionEndTime != '') {

                $NewEndTime = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
                $NewEndTime->modify("-1 second");
                $NewEndTime = $NewEndTime->format('Y-m-d H:i:s');

                $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $NewEndTime . "'";
            }

            if ($ProductionEndTime == '') {
                $currentDate = date("Y-m-d");
                $currentTime = date("H:i:s");
                $ProductionEndTime = '23:59:59';
                if ($ProductionEndDate >= $currentDate) {
                    $ProductionEndTime = $currentTime;
                }
                $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $ProductionEndDate . " $ProductionEndTime'";
            }
            if($conditions!='')
                $joinoperator='AND ';
        
        $ReadyForQCBatch = 1;
        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");

        $queries = $queries->fetchAll('assoc');
        $Queriesresult = array_map('current', $queries);
        $UserList = implode(",", $Queriesresult);
		

                $CompletedRecords = $connection->execute("SELECT InputEntityId,UserId FROM ME_Production_TimeMetric where $conditions $joinoperator ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and Qc_Batch_Id is NULL and QC_Module_Id=$QcModuleId and QcStatusId=$ReadyForQCBatch order by Start_Date")->fetchAll('assoc');
       
        $Completedresult = array_map('current', $CompletedRecords);
        //$inputEntity = implode("   ,   ", $Completedresult);
        $inputEntity=array();
       foreach($CompletedRecords  as $val){
           $user[$val['InputEntityId']]=$val['UserId'];
           $inputEntity[]=$val['InputEntityId'];
       }
       $inputEntity=  array_unique($inputEntity);
       
        $inputEntity=  implode(',', $inputEntity);
        $Production='';
		
        $Dependency = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where FieldTypeName='General' and ProjectId=$ProjectId")->fetchAll('assoc');
       $DependencyType=$Dependency[0]['Id'];
        if($inputEntity){ 
	//	echo "SELECT * FROM ProductionEntityMaster where InputEntityId in ($inputEntity) ORDER BY InputEntityId";
        $Production = $connection->execute("SELECT * FROM ProductionEntityMaster where InputEntityId in ($inputEntity) ORDER BY InputEntityId")->fetchAll('assoc');
       // $domainId = $connection->execute("SELECT InputEntityId,AttributeValue FROM MC_CengageProcessInputData where InputEntityId in ($inputEntity) and AttributeMasterId=$domainId and DependencyTypeMasterId=$DependencyType ORDER BY InputEntityId")->fetchAll('assoc');
        //foreach ($domainId as $val ){
        //    $domainArr[$val['InputEntityId']]=$val['AttributeValue'];
        //}
        }
       // $Completedresult = array_map('current', $CompletedRecords);
        
        if (empty($Production) ) {
             $tableData = '<div class="bs-example" style="margin-top:20px;">';
        $tableData .= '<table id="AddOptionTable" class="table table-striped table-center">';
        $tableData.='<thead><tr><th style="text-align:center;">No Data Available</th>';
         $tableData.='</thead>';
        $tableData.='</table>';
        $tableData .= '</div>';
        }
        else {
            //pr($Production);
            $cnt=count($Production);
        $tableData = '<div class="bs-example" style="margin-top:20px;">';
        $tableData .= '<table id="AddOptionTable" class="table table-striped table-center">';
       // $tableData.='<thead><tr><th style="text-align:center;">Id</th><th style="text-align:center;">Status</th><th style="text-align:center;">Start Date</th><th style="text-align:center;">End Date</th><th style="text-align:center;">Time Taken</th><th style="text-align:center;">User ID</th></tr></thead><tbody>';
        $tableData.='<thead><th><th style="text-align:center;">Total No Of Jobs Available for Batch Creation : '.$cnt.' (from '. date('d-m-Y H:i:s:',strtotime($Production[0]['ProductionStartDate'])).')</th></tr>'
                
                . '</thead>';
        //foreach ($Production as $key=>$val) {
        //$tableData.='<tr><td>'.$domainArr[$val['InputEntityId']].'</td><td>'.$ProjectStatus[$val['StatusId']].'</td><td>'.date('d-m-Y H:i:s',  strtotime($val['ProductionStartDate'])).'</td><td>'.date('d-m-Y H:i:s',  strtotime($val['ProductionEndDate'])).'</td><td>'.date('H:i:s',  strtotime($val['TotalTimeTaken'])).'</td><td>'.$userlist[$user[$val['InputEntityId']]].'</td></tr>';
        
       // }
        $tableData.='</tbody>';
        $tableData.='</table>';
        $tableData .= '</div>';
        }
        return $tableData;
    }

}
