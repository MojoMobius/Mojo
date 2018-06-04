<?php

/*
 * Form : TL Rebutal
 * Developer: SyedIsmail N
 * Created On: SEP 12 2017
 * 
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

class TLRebutalUserTable extends Table {

    public function initialize(array $config) {
        $this->table('ProductionEntityMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    public function findRegion(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if ($options['RegionId'] != '') {
            $RegionId = $options['RegionId'];
        }
        $call = 'getModule();';
        $template = '';
        $template.='<select name="RegionId" id="RegionId"  class="form-control" style="margin-top:5px;width:220px;" onchange="getusergroupdetails(this.value);"><option value=0>--Select--</option>';
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

    public function findStatuslist(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';

        $StausId = 0;
        if ($options['StausId'] != '') {
            $StausId = $options['StausId'];
        }

        $call = 'getModule();';
        $template = '';
        $template.='<select name="status[]" multiple=true id="status"  class="form-control" style="height:120px;width:220px">';
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
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserId = " . $UserId . " AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
        $queries = $queries->fetchAll('assoc');
        $template = '';
        $template.='<select name="UserGroupId" id="UserGroupId" style="margin-top:5px;" class="form-control" onchange="getresourcedetails()">';
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
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 1 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');

        $template = '';
        $template.='<select multiple=true name="user_id[]" id="user_id"  class="form-control" style="height:120px;width:220px">';
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
        
        $AttributeIds = $options['AttributeIds'];
        $ModuleId = $options['Module_Id'];
        $ProjectId = $options['Project_Id'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];
        $UserId = $options['UserId'];
        $from = strtotime($options['batch_from']);
        $month = date("n", $from);
        $year = date("Y", $from);
        $to = strtotime($options['batch_to']);
        $tomonth = date("n", $to);
        $toyear = date("Y", $to);
        $condition = $options['condition'];
        $conditions_timemetric = $options['conditions_timemetric'];
        $domainId = $options['domainId'];
        
        $timeDetails=array();
            $QcTimeMetrics = $connection->execute("SELECT Id,ProjectId,RegionId,ProductionEntityID,InputEntityId,Module_Id,QcStatusId,QCUSerID,QCTimeTaken FROM MV_QC_TimeMetric WHERE ProjectId=$ProjectId and RegionId=$RegionId and $condition")->fetchAll("assoc");
            $i=0;
            foreach ($QcTimeMetrics as $time):
                $timeDetails[$i]['Id'] = $time['Id'];
                $timeDetails[$i]['ProjectId'] = $time['ProjectId'];
                $timeDetails[$i]['RegionId'] = $time['RegionId'];
                $timeDetails[$i]['QCUSerID'] = $time['QCUSerID'];
                $timeDetails[$i]['InputEntityId'] = $time['InputEntityId'];
                $QcDomainUrl = $connection->execute("SELECT ProjectId,RegionId,InputEntityId,DomainId,DomainUrl FROM ME_DomainUrl WHERE ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId='".$time['InputEntityId']."'")->fetchAll("assoc");
                foreach ($QcDomainUrl as $domain):
                    $timeDetails[$i]['DomainId'] = $domain['DomainId'];
                    $timeDetails[$i]['DomainUrl'] = $domain['DomainUrl'];
                endforeach;
                $QcUserId = $connection->execute("SELECT ProjectId,RegionId,InputEntityId,UserId FROM ME_Production_TimeMetric WHERE ProjectId=$ProjectId and RegionId=$RegionId and InputEntityId='".$time['InputEntityId']."'")->fetchAll("assoc");
                foreach ($QcUserId as $user):
                    $timeDetails[$i]['UserId'] = $user['UserId'];
                endforeach;
                $i++;
            endforeach;
        return $timeDetails;
    }

    function findExport(Query $query, array $options) {
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
            $tableData.= '<tr> <th colspan="4"> </th>';
            foreach ($module as $key => $val) {
                if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                    $tableData.='<th colspan="5"> ' . $val . ' </th>';
                }
            }
            $tableData.= '</tr>';
            $tableData.='<tr class="Heading"><th>Project</th><th>Region</th><th>Domain Id</th><th>Status Id</th>';
            foreach ($module as $key => $val) {
                if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                    $tableData.='<th>Start Date</th>';
                    $tableData.='<th>End Date</th>';
                    $tableData.='<th>Time Taken</th>';
                    $tableData.='<th>User Id</th>';
                    $tableData.='<th>User Group</th>';
                }
            }
        endforeach;
        $tableData.='</thead>';
        $tableData.= '</tr>';

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        $status_list = $contentArr['ProjectGroupStatus'][ProjectStatusProduction];
        $regionlist = $contentArr['RegionList'];
        $module = $contentArr['Module'];
        $moduleConfig = $contentArr['ModuleConfig'];

        foreach ($options['condition'] as $inputVal => $input):
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
            $posReady = strpos(strtolower($statusName), 'ready');
            if ($showDataRow === true || $posReady !== false) {
                $tableData.='<tr><td>' . $contentArr[$input['ProjectId']] . '</td>';
                $tableData.='<td>' . $regionlist[$input['RegionId']] . '</td>';
                $tableData.='<td>' . $input['domainId'] . '</td>';
                $tableData.='<td>' . $status_list[$input['StatusId']] . '</td>';
                foreach ($module as $key => $val) {
                    if (($moduleConfig[$key]['IsAllowedToDisplay'] == 1) && ($moduleConfig[$key]['IsModuleGroup'] == 1)) {
                        $tableData.='<td>' . $options['time'][$key][$input['Id']]['Start_Date'] . '</td>';
                        $tableData.='<td>' . $options['time'][$key][$input['Id']]['End_Date'] . '</td>';
                        $tableData.='<td>' . $options['time'][$key][$input['Id']]['TimeTaken'] . '</td>';
                        $tableData.='<td>' . $user_list[$options['time'][$key][$input['Id']]['UserId']] . '</td>';
                        $tableData.='<td>' . $options['time'][$key][$input['Id']]['UserGroupId'] . '</td>';
                    }
                }
                $tableData.='</tr>';
            }
            $i++;
        endforeach;
        $tableData.='</tbody></table>';
        return $tableData;
    }

    function findProductivityReportDetailsExport(Query $query, array $options) {

        $module = $options['module'];
        $moduleDetails = $options['moduleDetails'];
        $tableData = '<table border=1><thead><tr>';
        $tableData.= '<th> User </th>';
        $tableData.= '<th> User Group </th>';
        foreach ($moduleDetails as $key => $val) {
            $tableData.= '<th> ' . $module[$val] . ' </th>';
        }
        $tableData.= '</tr></thead>';
        $i = 1;
        foreach ($options['condition'] as $inputVal => $input):
            $tableData.='<tbody><tr>';
            $tableData.='<td>' . $input['UserId'] . '</td>';
            $tableData.='<td>' . $input['UserGroupId'] . '</td>';
            foreach ($moduleDetails as $key => $val) {
                $tableData.='<td>' . $input[$val] . '</td>';
            }
            $tableData.='</tr></tbody>';
            $i++;
        endforeach;
        $tableData.='</table>';
        return $tableData;
    }

    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];

        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        $Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ProjectId in (' . $test . ') AND RecordStatus = 1');
        $Field = $Field->fetchAll('assoc');
        return $Field;
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
        $connection->execute("exec CreateTable_MonthwiseReport");
        $connection->execute("exec CreateTable_MonthwiseProductionTimeMetricReport");
    }

    public function CheckAttributesMatching($ProjectId) {
        $connection = ConnectionManager::get('default');
        $CountQry = $connection->execute("SELECT AttributeMasterId FROM ME_ProductionData WHERE ProjectId = '" . $ProjectId . "' GROUP BY AttributeMasterId");
        $CountQrys = $CountQry->fetchAll('assoc');
        $AttributeIds = [];
        foreach ($CountQrys as $ColName):
            $AttributeIds[] = $ColName['AttributeMasterId'];
        endforeach;

        if (count($AttributeIds) > 0) {
            $ColumnName = $connection->execute("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'ML_ProductionEntityMaster'");
            $ColumnName = $ColumnName->fetchAll('assoc');
            $CName = [];
            foreach ($ColumnName as $ColName):
                if (in_array($ColName['COLUMN_NAME'], $AttributeIds))
                    $CName[] = $ColName['COLUMN_NAME'];
            endforeach;

            $resultDiff = array_diff($AttributeIds, $CName);
            if (count($CName) <= 0 || count($resultDiff) > 0) {
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
    
    //--------------------------------------------------------------------------
    
    public function findGetcommands(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $ProjectAttributeId = $contentArr['AttributeOrder'][$options['RegionId']];
        
        $qcCommand = $connection->execute("SELECT QCC.Id,QCC.ProjectId,QCC.RegionId,QCC.InputEntityId,QCC.AttributeMasterId,QCC.ProjectAttributeMasterId,
            QCC.OldValue,QCC.QCValue,QCC.QCComments,QCC.Reference,QCC.ErrorCategoryMasterId,QCC.SubErrorCategoryMasterId,
            QCC.SequenceNumber,QCC.UserId,QCC.StatusId,QCC.TLReputedComments,QCC.UserReputedComments,QEC.ErrorCategoryName,
            QSC.SubCategoryName FROM MV_QC_Comments as QCC INNER JOIN MV_QC_ErrorCategoryMaster as QEC ON QCC.ErrorCategoryMasterId=QEC.Id 
            INNER JOIN MV_QC_ErrorSubCategoryMaster as QSC ON QCC.SubErrorCategoryMasterId=QSC.Id WHERE QCC.ProjectId= '".$options['ProjectId']."' 
            and QCC.RegionId = '".$options['RegionId']."' and QCC.StatusId NOT IN (0,4) and QCC.InputEntityId = '".$options['InputEntityId']."' and QEC.RecordStatus = 1
            and QSC.RecordStatus = 1");
        $QcCommands = $qcCommand->fetchAll('assoc');
//        $qcCommand = $connection->execute("SELECT Id,ProjectId,RegionId,InputEntityId,AttributeMasterId,ProjectAttributeMasterId,
//            OldValue,QCValue,QCComments,Reference,ErrorCategoryMasterId,SubErrorCategoryMasterId,SequenceNumber,UserId,StatusId,TLReputedComments,
//            UserReputedComments FROM MV_QC_Comments WHERE ProjectId= '".$options['ProjectId']."' and RegionId='".$options['RegionId']."' 
//            and InputEntityId = '".$options['InputEntityId']."'");
//        $QcCommands = $qcCommand->fetchAll('assoc');

        $key='';
        $i=0;
        foreach($QcCommands as $val){
            $cmd[$i]['cmdId']=$val['Id'];
            $cmd[$i]['InputEntityId']=$val['InputEntityId'];
            $cmd[$i]['AttributeMasterId']=$val['AttributeMasterId'];
            $cmd[$i]['ProjectAttributeMasterId']=$ProjectAttributeId[$val['ProjectAttributeMasterId']]['DisplayAttributeName'];
            $cmd[$i]['OldValue']=$val['OldValue'];
            $cmd[$i]['QCValue']=$val['QCValue'];
            $cmd[$i]['ErrorCategoryName']=$val['ErrorCategoryName'];
            $cmd[$i]['SubCategoryName']=$val['SubCategoryName'];
            $cmd[$i]['QCComments']=$val['QCComments'];
            $cmd[$i]['Reference']=$val['Reference'];
            $cmd[$i]['SequenceNumber']=$val['SequenceNumber'];
            $cmd[$i]['UserId']=$val['UserId'];
            $cmd[$i]['TLReputedComments']=$val['TLReputedComments'];
            $cmd[$i]['UserReputedComments']=$val['UserReputedComments'];
            $i++;
        }
        return json_encode($cmd);
    }
    
    public function findRebutal(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $totalrebuteerror = count($options['data']['rebute']);
        
        if($totalrebuteerror > 0)
        {
          $MvQcCommentsSet = $connection->execute("update MV_QC_Comments set StatusId=2 where InputEntityId=".$options['data']['InputEntityId']);
          for($i=0;$i<count($options['data']['rebute']);$i++) 
            {
            $tlcmd_Id = $options['data']['rebute'][$i];
            $tlcmd_str = 'tlcmd_'.$options['data']['rebute'][$i];
            $MvQcComments = $connection->execute("update MV_QC_Comments set TLReputedComments='".$options['data'][$tlcmd_str]."' ,StatusId=".$options['data']['cmdStatus'].", ModifiedBy=".$options['UserId']." where InputEntityId=".$options['data']['InputEntityId']." and Id=".$tlcmd_Id);
            $MvQcTimeMetric = $connection->execute("update MV_QC_TimeMetric set QcStatusId=".$options['data']['cmdStatus'].", ModifiedBy=".$options['UserId']." where InputEntityId=".$options['data']['InputEntityId']);
            }
        } else {
            $MvQcComments = $connection->execute("update MV_QC_Comments set TLReputedComments='',StatusId=".$options['data']['cmdStatus'].", ModifiedBy=".$options['UserId']." where InputEntityId=".$options['data']['InputEntityId']);
            $MvQcTimeMetric = $connection->execute("update MV_QC_TimeMetric set QcStatusId=".$options['data']['cmdStatus'].", ModifiedBy=".$options['UserId']." where InputEntityId=".$options['data']['InputEntityId']);
        }
    }
    
    public function findRebutalStatus(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
        $QcRework = 2;
        foreach($options['rework'] as $val)
        {
            $MvQcComments = $connection->execute("update MV_QC_Comments set StatusId=$QcRework where InputEntityId=".$val);
            $MvQcTimeMetric = $connection->execute("update MV_QC_TimeMetric set QcStatusId=$QcRework where InputEntityId=".$val);
        }
    }
    
    public function findMovetopu(Query $query, array $options) {
        $connection = ConnectionManager::get('default');
         $QcRework = 2;
        $InputEntityId = $options['InputEntityId'];
        $MvQcComments = $connection->execute("update MV_QC_Comments set StatusId=$QcRework where InputEntityId=".$InputEntityId);
        $MvQcTimeMetric = $connection->execute("update MV_QC_TimeMetric set QcStatusId=$QcRework where InputEntityId=".$InputEntityId);
    }

    //--------------------------------------------------------------------------
}
