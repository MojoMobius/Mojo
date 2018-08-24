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

class ProductionestimationReportsTable extends Table {

    public function initialize(array $config) {
        $this->table('ProductionEntityMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    public function findClient(Query $query, array $options) {

        $ClientId = $options['ClientId'];
        $connection = ConnectionManager::get('default');


        $modulesArr = $connection->execute("select Id,ClientName FROM ClientMaster where Id='$ClientId'")->fetchAll('assoc');



        $template = '';
        $template = '<select name="ClientId"  id="ClientId" class="form-control"><option value=0>--Select--</option>';
        if (!empty($modulesArr)) {

            foreach ($modulesArr as $key => $value) {

                if ($value['Id'] == $ClientId) {
                    $selected = 'selected=' . $value['Id'];
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $value['Id'] . '">';
                $template.=$value['ClientName'];
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    public function findStatuslist(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';

        $StausId = 0;
        if ($options['StausId'] != '') {
            $StausId = $options['StausId'];
        }

        $call = 'getModule();';
        $template = '';
        $template.='<select name="status[]" multiple=true id="status"  class="form-control" style="height:120px;width:180px">';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $status_list = $contentArr['ProjectGroupStatus'][ProjectStatusProduction];
            asort($status_list);
            foreach ($status_list as $key => $val):
                if ($key == $StausId) {
                    $selected = 'selected="' . $StausId . '"';
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

    function findUsergroupdetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserId = $options['UserId'];

        if ($options['UserGroupId'] != '') {
            $UserGroupId = $options['UserGroupId'];
        }

        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserGroupId,UGMaster.GroupName from MV_UserGroupMapping as UGMapping INNER JOIN MV_UserGroupMaster as UGMaster ON UGMapping.UserGroupId = UGMaster.Id"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . "  AND UGMapping.UserId = " . $UserId . " AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
        $queries = $queries->fetchAll('assoc');
        $template = '';
        $template.='<select name="UserGroupId" id="UserGroupId" style="margin-top:5px;" class="form-control" onchange="getresourcedetails(' . $RegionId . ')">';
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
        /* echo "select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
          . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (".$UserGroupId.")  AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
          . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String
          FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String
          FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
          . ") GROUP BY UGMapping.UserId";exit; */
        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ")  AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');

        $template = '';
        $template.='<select multiple=true name="user_id[]" id="user_id"  class="form-control" style="height:120px;width:180px">';
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
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
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

    public function findUsers(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $connection1 = ConnectionManager::get('default');
        $connection2 = ConnectionManager::get('default');
        $from = strtotime($options['batch_from']);
        $batch_from = $options['batch_from'];
        $batch_to = $options['batch_to'];
        $month = date("n", $from);
        $year = date("Y", $from);
        $to = strtotime($options['batch_to']);
        $tomonth = date("n", $to);
        $toyear = date("Y", $to);
        $domainId = $options['domainId'];
        $conditions_timemetric = $options['conditions_timemetric'];
        $UserGroupId = $options['UserGroupId'];
        $UserId = $options['UserId'];
        $AttributeIds = $options['AttributeIds'];
        $CheckSPDone = $options['CheckSPDone'];
        $DateCondition = "";
        if (($batch_from != "") && ($batch_to != "")) {
            $DateCondition = " AND CONVERT(char(10), Start_Date, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), Start_Date, 120) <=  '" . date('Y-m-d', strtotime($batch_to)) . "'";
        }

        if (($batch_from != "") && ($batch_to == "")) {
            $DateCondition = " AND CONVERT(char(10), Start_Date, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), Start_Date, 120) <=  '" . date('Y-m-d', strtotime($batch_from)) . "'";
        }
        $ReportDateCondition = "";
        if (($batch_from != "") && ($batch_to != "")) {
            $ReportDateCondition = " AND CONVERT(char(10), ProductionStartDate, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), ProductionStartDate, 120) <=  '" . date('Y-m-d', strtotime($batch_to)) . "'";
        }

        if (($batch_from != "") && ($batch_to == "")) {
            $ReportDateCondition = " AND CONVERT(char(10), ProductionStartDate, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), ProductionStartDate, 120) <=  '" . date('Y-m-d', strtotime($batch_from)) . "'";
        }


        //////////////////////////////////////get user group name based on user id /////
        $UserIdCondition = '';
        if (!empty($UserId))
            $UserIdCondition = " AND UGMap.UserId IN (" . implode(',', $UserId) . ")";

        $queriesUGMappingName = $connection->execute("select UGMap.UserId, UGMas.GroupName from MV_UserGroupMapping UGMap"
                . " INNER JOIN MV_UserGroupMaster as UGMas ON UGMas.Id = UGMap.UserGroupId"
                . " where UGMap.UserGroupId IN (" . $UserGroupId . ") $UserIdCondition AND UGMap.ProjectId = " . $options['Project_Id'] . " AND UGMap.RegionId = " . $options['RegionId'] . " AND UGMap.RecordStatus = 1 GROUP BY UGMap.UserId, UGMas.GroupName");
        $queriesUGMappingName = $queriesUGMappingName->fetchAll('assoc');

        $queriesUGNamedetails = array();
        foreach ($queriesUGMappingName as $row):
            $queriesUGNamedetails[$row['UserId']] = $row['GroupName'];
        endforeach;

        //pr($options);exit;
        $timeDetails = array();
        $productionIdarray = $productionIdarrayNotIn = array();


        //// Get Completed data///////////////////////////////////////
        $GetPeriodArray = $this->Periods($batch_from, $batch_to);
        //pr($GetPeriodArray); die;
        $queries = array();
        $timeMetric = array();
        $timeMetrics = array();
        foreach ($GetPeriodArray as $dt) {
            $DataExistsCount = $this->DataExistsInMonthwiseCheck($options['Project_Id'], $dt);
            if ($DataExistsCount != "") {
               
                        $IsItOkay = TRUE;
                if ($IsItOkay) {


                    $querie2 = array();

                    $querie2 = $connection->execute("select report.InputEntityId,report.Id,report.ProjectId,report.RegionId,report.StatusId,report.ProductionStartDate,report.ProductionEndDate,report.TotalTimeTaken,[" . $domainId . "] as domainId from Report_ProductionEntityMaster_" . $dt . " as report where" . $options['condition'] . " $ReportDateCondition AND report.ProjectId = " . $options['Project_Id'] . " AND report.SequenceNumber = 1 AND [" . $domainId . "] IS NOT NULL AND [" . $domainId . "] != '' GROUP BY report.InputEntityId,report.Id,report.ProjectId,report.RegionId,report.StatusId,report.ProductionStartDate,report.ProductionEndDate,report.TotalTimeTaken,[" . $domainId . "]");
                    
                    $querie2 = $querie2->fetchAll('assoc');
                    $queries = array_merge($queries, $querie2);
                    //pr($queries);

                    $prod = 0;
                    foreach ($queries as $Production):
                        $productionIdarray[$prod] = $Production['InputEntityId'];
                        $prod++;
                    endforeach;
                    $timeDetails = array();
                    $productionIdarray = array_unique($productionIdarray);
                    $productionIdarrayNotIn = array_merge($productionIdarrayNotIn, $productionIdarray);
                    if (!empty($productionIdarray)) {
                        $connection = ConnectionManager::get('default');

                        $timeMetrics = $connection->execute("SELECT max(Start_Date) as Start_Date,max(End_Date) as End_Date,max(TimeTaken) as TimeTaken,ProductionEntityID,UserId,Module_Id FROM ME_Production_TimeMetric_" . $dt . " WHERE InputEntityId in(" . implode(',', $productionIdarray) . ") $conditions_timemetric $DateCondition group by ProductionEntityID , Module_Id, UserId")->fetchAll("assoc");
                        $timeMetric = array_merge($timeMetric, $timeMetrics);
                        foreach ($timeMetric as $time):
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['Start_Date'] = date("d-m-Y H:i:s", strtotime($time['Start_Date']));
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['End_Date'] = date("d-m-Y H:i:s", strtotime($time['End_Date']));
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['TimeTaken'] = date("H:i:s", strtotime($time['TimeTaken']));
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['UserId'] = $time['UserId'];
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['UserGroupId'] = $queriesUGNamedetails[$time['UserId']];
                        endforeach;
                    }
                }
            }
        }

        //// Get Get Ready data///////////////////////////////////////
        $inputentityidNotIn = '';
        if (!empty($productionIdarrayNotIn)) {
            $inputentityidNotIn = "AND InputEntityId not in(" . implode(',', $productionIdarrayNotIn) . ")";
        }

        //Check This Project Attributes are created as table columns in ProductionEntityMaster tbl
        $IsItOkay = TRUE;
        if ($CheckSPDone <= 0) {
            $this->SpRunFunc();
            $IsItOkay = $this->CheckAttributesMatching($options['Project_Id']);
            if ($IsItOkay) {
                $queryInsert = "Insert into MV_SP_Run_CheckList (ProjectId,SP_Name,SP_Id,RecordStatus,CreatedDate) values('" . $options['Project_Id'] . "','CreateView_ProductionEntityMaster',1,1,'" . date('Y-m-d H:i:s') . "')";
                $connection->execute($queryInsert);
            }
        }
        $IsItOkay = TRUE;
        if ($IsItOkay) {

            $ReportDateCondition = "";
            if (($batch_from != "") && ($batch_to != "")) {
                $ReportDateCondition = " AND ((production.ProductionStartDate IS NULL AND production.ProductionEndDate IS NULL)  OR (CONVERT(char(10), ProductionStartDate, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), ProductionStartDate, 120) <=  '" . date('Y-m-d', strtotime($batch_to)) . "'))";
            }

            if (($batch_from != "") && ($batch_to == "")) {
                $ReportDateCondition = " AND ((production.ProductionStartDate IS NULL AND production.ProductionEndDate IS NULL)  OR (CONVERT(char(10), ProductionStartDate, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), ProductionStartDate, 120) <=  '" . date('Y-m-d', strtotime($batch_from)) . "'))";
            }
            

            $querie4 = $connection->execute("select  production.InputEntityId,production.Id,production.ProjectId,production.priority,production.RegionId,production.StatusId,production.ProductionStartDate,production.ProductionEndDate,production.TotalTimeTaken,[" . $domainId . "] as domainId  from ML_CengageProductionEntityMaster as production where   production.InputEntityId IS NOT NULL " . $ReportDateCondition . $options['conditions_status'] . " AND production.ProjectId = " . $options['Project_Id'] . " AND [" . $domainId . "] IS NOT NULL AND [" . $domainId . "] != '' AND production.SequenceNumber = 1 $inputentityidNotIn GROUP BY production.InputEntityId,production.Id,production.ProjectId,production.priority,production.RegionId,production.StatusId,production.ProductionStartDate,production.ProductionEndDate,production.TotalTimeTaken,[" . $domainId . "]");

            $querie4 = $querie4->fetchAll('assoc');
            //  pr($queries);
          
            $queries = array_merge($queries, $querie4);
            $productionIdarraylast = array();
            $prodlast = 0;
            foreach ($queries as $Production):
                $productionIdarraylast[$prodlast] = $Production['InputEntityId'];
                $prodlast++;
            endforeach;
            $ProjectId = $options['Project_Id'];
            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $module = $contentArr['Module'];
            $timeMetricdata = array();

            //pr($module);
            $timeMetricsdata = array();
            if (!empty($productionIdarraylast)) {
                foreach ($module as $key => $value) {

                    $staging_table = 'ME_Production_TimeMetric';
                    $connection = ConnectionManager::get('default');
                    $CountQry = $connection->execute("select count(*) tabexists from INFORMATION_SCHEMA.TABLES where TABLE_NAME='$staging_table'");
                    $CountQrys = $CountQry->fetch('assoc');
                    $tablexists = $CountQrys['tabexists'];
                    if ($tablexists != '0') {

                        $DateCond = "";
                        if (($batch_from != "") && ($batch_to != "")) {
                            $DateCond = " AND CONVERT(char(10), Start_Date, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), Start_Date, 120) <=  '" . date('Y-m-d', strtotime($batch_to)) . "'";
                        }

                        if (($batch_from != "") && ($batch_to == "")) {
                            $DateCond = " $DateCond AND CONVERT(char(10), Start_Date, 120) >=  '" . date('Y-m-d', strtotime($batch_from)) . "' AND CONVERT(char(10), Start_Date, 120) <=  '" . date('Y-m-d', strtotime($batch_from)) . "'";
                        }

                        $timeMetricsdata = $connection->execute("SELECT max(Start_Date) as Start_Date,max(End_Date) as End_Date,max(TimeTaken) as TimeTaken,ProductionEntityID as ProductionEntityID,UserId,Module_Id FROM $staging_table WHERE InputEntityId in(" . implode(',', $productionIdarraylast) . ") $DateCond $conditions_timemetric group by ProductionEntityID ,Module_Id, UserId")->fetchAll("assoc");


                        foreach ($timeMetricsdata as $time):
                            if (!empty($time['Start_Date'])) {
                                $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['Start_Date'] = date("d-m-Y H:i:s", strtotime($time['Start_Date']));
                            }
                            if (!empty($time['End_Date'])) {
                                $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['End_Date'] = date("d-m-Y H:i:s", strtotime($time['End_Date']));
                            }
                            if (!empty($time['TimeTaken'])) {
                                $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['TimeTaken'] = date("H:i:s", strtotime($time['TimeTaken']));
                            }
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['UserId'] = $time['UserId'];
                            $timeDetails[$time['Module_Id']][$time['ProductionEntityID']]['UserGroupId'] = $queriesUGNamedetails[$time['UserId']];
                        endforeach;
                    }
                }
            }
        }

        return array($queries, $timeDetails);
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
            $tableData.= '<tr> <th colspan="3"> </th>';
            foreach ($module as $key => $val) {
                if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                    $tableData.='<th colspan="5"> ' . $val . ' </th>';
                }
            }
            $tableData.= '</tr>';
            $tableData.='<tr class="Heading"><th>Project</th><th>Lease Id</th><th>Status Id</th>';
            foreach ($module as $key => $val) {
                if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                    $tableData.='<th>Start Date</th>';
                    $tableData.='<th>End Date</th>';
                    $tableData.='<th>Estimated Time</th>';
                    $tableData.='<th>Time Taken</th>';
                    $tableData.='<th>User Id</th>';
                }
            }
        endforeach;
        $tableData.='</thead>';
        $tableData.= '</tr>';

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
//        $status_list = $contentArr['ProjectGroupStatus'][ProjectStatusProduction];
        $status_list = $contentArr['ProjectStatus'];
      
        
      
        $regionlist = $contentArr['RegionList'];
        $module = $contentArr['Module'];
        $moduleConfig = $contentArr['ModuleConfig'];

        foreach ($options['condition'] as $inputVal => $input):
            $tableData .= '<tbody>';
            $IDValue = $input['Id'];
            $statusName = $status_list[$input['StatusId']];
            $showDataRow = false;
         
                $tableData.='<tr><td>' . $contentArr[$input['ProjectId']] . '</td>';
//                $tableData.='<td>' . $regionlist[$input['RegionId']] . '</td>';
                $tableData.='<td>' . $input['fdrid'] . '</td>';
                $tableData.='<td>' . $status_list[$input['StatusId']] . '</td>';
                foreach ($module as $key => $val) {
                    if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                        $tableData.='<td>' . $input['module'][$key]['Start_Date'] . '</td>';
                        $tableData.='<td>' . $input['module'][$key]['End_Date'] . '</td>';
                        $tableData.='<td>' . $input['module'][$key]['Estimated_Time'] . '</td>';
                        $tableData.='<td>' . $input['module'][$key]['TimeTaken'] . '</td>';
                        $tableData.='<td>' . $user_list[$input['module'][$key]['UserId']] . '</td>';
                       
                    }
                }
                $tableData.='</tr>';
         
            $i++;
        endforeach;
        $tableData.='</tbody></table>';
//        echo 'jai'.$tableData;
//        exit;
        return $tableData;
    }


    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];
        $ClientId = $options['ClientId'];
        $clientCheck = "";
        if ($ClientId > 0) {
            $clientCheck = "client_id ='" . $ClientId . "' and ";
        }

        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        $Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ' . $clientCheck . ' ProjectId in (' . $test . ') AND RecordStatus = 1');
        $Field = $Field->fetchAll('assoc');
        return $Field;
    }

    public function findajaxProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];
        $ClientId = $options['ClientId'];
        $RegionId = $options['RegionId'];
        $clientCheck = "";
        if ($ClientId > 0) {
            $clientCheck = "client_id ='" . $ClientId . "' and ";
        }
        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');


        $modulesArr = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ' . $clientCheck . ' ProjectId in (' . $test . ') AND RecordStatus = 1');



        $template = '';
        $template = '<select name="ProjectId"  id="ProjectId" class="form-control" onchange="getusergroupdetails(' . $RegionId . ');getStatus(this.value);"><option value=0>--Select--</option>';
        if (!empty($modulesArr)) {

            foreach ($modulesArr as $key => $value) {

                $template.='<option  value="' . $value['ProjectId'] . '">';
                $template.=$value['ProjectName'];
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    public function Periods($st, $ed) {
        $result = array();
        $date = date("Y-m-d", strtotime($st));
        $date2 = date("Y-m-d", strtotime($ed));
        $start = (new \DateTime($date))->modify('first day of this month');
        $end = (new \DateTime($date2))->modify('first day of next month');
        $interval = \DateInterval::createFromDateString('1 month');
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $result[] = $dt->format("n_Y");
        }
        return $result;
    }

    public function DataExistsInMonthwiseCheck($ProjectId, $MonthYear) {
        $connection = ConnectionManager::get('default');
        //echo "select TOP 1 Id from Report_ProductionEntityMaster_".$MonthYear." WHERE ProjectId = $ProjectId"; die;
        $CountQry = $connection->execute("select TOP 1 Id from Report_ProductionEntityMaster_" . $MonthYear . " WHERE ProjectId = $ProjectId");
        $CountQrys = $CountQry->fetch('assoc');
        $tablexists = $CountQrys['Id'];
        return $tablexists;
    }

    public function SpRunFunc() {
        $connection = ConnectionManager::get('default');
        $ProductionData = $connection->execute("exec CreateView_ProductionEntityMaster");
    }

    public function SpRunFuncRPEMMonthWise() {
        $connection = ConnectionManager::get('default');
        $connection->execute("exec CreateView_ProductionEntityMaster_monthwise");
        $connection->execute("exec CreateView_ProductionTimeMetric_monthwise");

        $connection->execute("exec CreateTable_MonthwiseProductionTimeMetricReport");
    }

    public function CheckAttributesMatching($ProjectId) {
        $connection = ConnectionManager::get('default');
        //echo "SELECT AttributeMasterId FROM MC_CengageProcessInputData WHERE ProjectId = '" . $ProjectId . "' GROUP BY AttributeMasterId";
        $CountQry = $connection->execute("SELECT AttributeMasterId FROM MC_CengageProcessInputData WHERE ProjectId = '" . $ProjectId . "' GROUP BY AttributeMasterId");
        $CountQrys = $CountQry->fetchAll('assoc');
        $AttributeIds = [];
        foreach ($CountQrys as $ColName):
            $AttributeIds[] = $ColName['AttributeMasterId'];
        endforeach;
        //pr($AttributeIds);
        //die;

        if (count($AttributeIds) > 0) {
            $ColumnName = $connection->execute("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'ML_ProductionEntityMaster'");
            $ColumnName = $ColumnName->fetchAll('assoc');
            $CName = [];
            foreach ($ColumnName as $ColName):
                if (in_array($ColName['COLUMN_NAME'], $AttributeIds))
                    $CName[] = $ColName['COLUMN_NAME'];
            endforeach;

            $resultDiff = array_diff($AttributeIds, $CName);

            echo "<br>";
            //if (count($CName) <= 0 || count($resultDiff) > 0) {
            if (count($CName) <= 0 || count($resultDiff) < 0) {
                return False;
            } else {
                return True;
            }
        } else {
            return False;
        }
    }

    public function CheckAttributesMatchingRPEMMonthWise($ProjectId, $dt) {
        $connection = ConnectionManager::get('default');
        //echo "SELECT AttributeMasterId FROM ME_ProductionData WHERE ProjectId = '".$ProjectId."' GROUP BY AttributeMasterId";
        $CountQry = $connection->execute("SELECT AttributeMasterId FROM ME_ProductionData WHERE ProjectId = '" . $ProjectId . "' GROUP BY AttributeMasterId");
        $CountQrys = $CountQry->fetchAll('assoc');
        $AttributeIds = [];
        foreach ($CountQrys as $ColName):
            $AttributeIds[] = $ColName['AttributeMasterId'];
        endforeach;
        //pr($AttributeIds);
        //die;

        if (count($AttributeIds) > 0) {
            $ColumnName = $connection->execute("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Report_ProductionEntityMaster_" . $dt . "'");
            $ColumnName = $ColumnName->fetchAll('assoc');
            $CName = [];
            foreach ($ColumnName as $ColName):
                if (in_array($ColName['COLUMN_NAME'], $AttributeIds))
                    $CName[] = $ColName['COLUMN_NAME'];
            endforeach;

            $resultDiff = array_diff($AttributeIds, $CName);
//            pr($AttributeIds); 
//            pr($ColumnName); 
//            pr($resultDiff); 
//            die;
            if (count($CName) <= 0 || count($resultDiff) > 0) {
                return False;
            } else {
                return True;
            }
        } else {
            return False;
        }
    }

}
