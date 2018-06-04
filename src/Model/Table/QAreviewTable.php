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

class QAreviewTable extends Table {
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
	    public function findStatus(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if ($options['StatusId'] != '') {
            $StatusId = $options['StatusId'];
        }        
        $template = '';
        $template.='<select name="StatusId" id="StatusId" class="form-control" ><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
			
	    //$status = $contentArr['ProjectGroupStatus']['Validation'];
//             $status = array(
//                    '1' => 'Ready for Batch Creation',
//                    '2' => 'Ready for Hygine Check',
//                    '3' => 'Ready for Sample Creation',
//                    '4' => 'Hygine check Rejected',
//                    '5' => 'Sample Created'
//            );

            if (count($status) == 1 && isset($options['SetIfOneRow'])) {
                $StatusId = array_keys($status)[0];
            }
            foreach ($status as $key => $val):
                if ($key == $RegionId) {
                    $selected = 'selected=' . $StatusId;
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

    function findExport(Query $query, array $options) {
        // pr($options); 
        $ProjectId = $options['ProjectId'];
        foreach ($options['condition'] as $inputVal => $input):
            $path = JSONPATH . '\\ProjectConfig_' . $input['ProjectId'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $user_list = $contentArr['UserList'];
            $status_list = $contentArr['ProjectGroupStatus'][ProjectStatusProduction];
            $module = $contentArr['Module'];
            $moduleConfig = $contentArr['ModuleConfig'];
            $tableData = '<table border=1>  <thead>';
            $tableData.='<tr class="Heading"><th>Date</th><th>Project</th><th>Batch Name</th><th>Status</th><th>Batch Size</th><th>Sample Size</th><th>QC Completed</th><th>Pending</th><th>Final AOQ</th>';
            
        endforeach;
        $tableData.= '</tr>';
        $tableData.='</thead>';

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        $regionlist = $contentArr['RegionList'];
        $module = $contentArr['Module'];
        $moduleConfig = $contentArr['ModuleConfig'];

        foreach ($options['condition'] as $inputVal => $input):
	    //pr($input);exit;
            $tableData .= '<tbody>';
            $IDValue = $input['Id'];
            $statusName = $status_list[$input['StatusId']];
            $showDataRow = false;
            foreach ($module as $key => $val) {
                if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                    if (!empty($options['time'][$key][$IDValue]))
                        $showDataRow = true;
                }
            }
	    $qcpending = $input['SampleCount'] - $input['QCCompletedCount'];
            $posReady = strpos(strtolower($statusName), 'ready');
           // if ($showDataRow === true || $posReady !== false) {
                $tableData.='<tr><td>' . $input['CreatedDate'] . '</td>';
                $tableData.='<td>' . $contentArr[$input['ProjectId']] . '</td>';
                $tableData.='<td>' . $input['BatchName'] . '</td>';
                $tableData.='<td>' . $input['StatusId'] . '</td>';
                $tableData.='<td>' . $input['EntityCount'] . '</td>';
				$tableData.='<td>' . $input['SampleCount'] . '</td>';
				$tableData.='<td>' . $input['QCCompletedCount'] . '</td>';
				$tableData.='<td>' . $qcpending . '</td>';
				$tableData.='<td>' . $input['aoq'] . '</td>';
                
                $tableData.='</tr>';
          //  }
            $i++;
        endforeach;
        $tableData.='</tbody></table>';
        //echo 'jai'.$tableData;
        //exit;
        return $tableData;
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

        $CompletedRecords = $connection->execute("SELECT distinct(CONVERT(varchar(10), Start_Date, 105)) as StartDate FROM ME_Production_TimeMetric where ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and QcStatusId = 1 ")->fetchAll('assoc');
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
//echo "SELECT InputEntityId FROM ME_Production_TimeMetric where $conditions $joinoperator ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and Qc_Batch_Id is NULL and QcStatusId=$ReadyForQCBatch";
        $CompletedRecords = $connection->execute("SELECT InputEntityId,UserId FROM ME_Production_TimeMetric where $conditions $joinoperator ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and Qc_Batch_Id is NULL and QcStatusId=$ReadyForQCBatch order by Start_Date")->fetchAll('assoc');
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
        $Production = $connection->execute("SELECT * FROM ProductionEntityMaster where InputEntityId in ($inputEntity) ORDER BY InputEntityId")->fetchAll('assoc');
        $domainId = $connection->execute("SELECT InputEntityId,AttributeValue FROM MC_CengageProcessInputData where InputEntityId in ($inputEntity) and AttributeMasterId=$domainId and DependencyTypeMasterId=$DependencyType ORDER BY InputEntityId")->fetchAll('assoc');
        foreach ($domainId as $val ){
            $domainArr[$val['InputEntityId']]=$val['AttributeValue'];
        }
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
        $tableData = '<div class="bs-example" style="margin-top:20px;">';
        $tableData .= '<table id="AddOptionTable" class="table table-striped table-center">';
        $tableData.='<thead><tr><th style="text-align:center;">Id</th><th style="text-align:center;">Status</th><th style="text-align:center;">Start Date</th><th style="text-align:center;">End Date</th><th style="text-align:center;">Time Taken</th><th style="text-align:center;">User ID</th></tr></thead><tbody>';
        foreach ($Production as $key=>$val) {
        $tableData.='<tr><td>'.$domainArr[$val['InputEntityId']].'</td><td>'.$ProjectStatus[$val['StatusId']].'</td><td>'.date('d-m-Y H:i:s',  strtotime($val['ProductionStartDate'])).'</td><td>'.date('d-m-Y H:i:s',  strtotime($val['ProductionEndDate'])).'</td><td>'.date('H:i:s',  strtotime($val['TotalTimeTaken'])).'</td><td>'.$userlist[$user[$val['InputEntityId']]].'</td></tr>';
        }
        $tableData.='</tbody>';
        $tableData.='</table>';
        $tableData .= '</div>';
        }
        return $tableData;
    }

}
