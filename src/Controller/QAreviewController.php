<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\DateTime;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Utility\Hash;

class QAreviewController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Id' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadModel('QCBatchMaster');
        $this->loadModel('projectmasters');
        $this->loadModel('QAreview');
        $this->loadModel('GetJob');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    public function index() {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);
        $status = array(
            '0' => '--Select Status--',
            '2' => 'Ready for Hygine Check',
            '3' => 'Ready for Sample Creation',
            '4' => 'Hygine check Rejected',
            '5' => 'Sample Created'
        );
        $this->set('Status', $status);
        $UserProject = array_keys($ProListFinal);
        $ids = join("','", $UserProject);

        //$Filter="WHERE  ProjectId IN ('$ids') AND CreatedDate >= '".date("Y-m-d")."'";
/////index value form///
        if (!empty($this->request->data('batch_from'))) {
            $fdate = date("d-m-Y", strtotime($this->request->data('batch_from')));
        } else {
            $fdate = ""; //date("d-m-Y");
        }

        if (!empty($this->request->data('batch_to'))) {
            $tdate = date("d-m-Y", strtotime($this->request->data('batch_to')));
        } else {
            $tdate = "";
        }
        $this->set('fromdate', $fdate);
        $this->set('todate', $tdate);

////index value form end/////               

        if (isset($this->request->data['check_submit']) || isset($this->request->data['downloadFile'])) {





            $session = $this->request->session();
            $user_id = $session->read('user_id');

            $ModifiedDate = date("Y-m-d H:i:s");

            $ProjectId = $this->request->data('ProjectId');
            $StatusId = $this->request->data('StatusId');


            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);

            $batch_from = $this->request->data('batch_from');
            $batch_to = $this->request->data('batch_to');


            if (empty($ProjectId)) {
                $ProjectId = $session->read('ProjectId');
            }

            //$StatusId=5;			
            $Filter = "WHERE QC_Module_Id=".$moduleId." AND StatusId=" . $StatusId . " AND ProjectId=" . $ProjectId . " ";
            if (!empty($batch_from) && !empty($batch_to)) {
                $Filter.="AND CONVERT(date,CreatedDate) >= '" . date("Y-m-d", strtotime($batch_from)) . "'";
            } else if (!empty($batch_from) && empty($batch_to)) {
                $Filter.="AND CONVERT(date,CreatedDate) ='" . date("Y-m-d", strtotime($batch_from)) . "'";
            }
            if (!empty($batch_to)) {
                $Filter.=" AND CONVERT(date,CreatedDate) <='" . date("Y-m-d", strtotime($batch_to)) . "'";
            }
            //  echo "select * from MV_QC_BatchMaster ".$Filter."  ORDER BY Id DESC";exit;
            //  } //check_submit close
            $UserProject = array_keys($ProListFinal);
            $ids = join("','", $UserProject);
            $connection = ConnectionManager::get('default');

            $ErrorCatMasterIdsQuery = $connection->execute("SELECT Id FROM MV_QC_ErrorCategoryMaster where ErrorCategoryName='Missed'")->fetchAll('assoc');
            $ErrorcatId = $ErrorCatMasterIdsQuery[0]['Id'];

            //echo "select * from MV_QC_BatchMaster ".$Filter."  ORDER BY ProductionStartDate DESC,ProductionStartTime DESC";exit;

            $SelectQCBatch = $connection->execute("select * from MV_QC_BatchMaster  " . $Filter . "   ORDER BY Id DESC")->fetchAll('assoc');
            //$this->set('SelectQCBatch', $SelectQCBatch);


            $QA_data = array();
            foreach ($SelectQCBatch as $input):


                /////////////AOQ start/////////////////

            
                $DependentMasterIdsQuery = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='" . $input['ProjectId'] . "' AND FieldTypeName='After Normalized'")->fetchAll('assoc');
                $DependId = $DependentMasterIdsQuery[0]['Id'];

//echo "select DISTINCT InputEntityId from ME_Production_TimeMetric where Qc_Batch_Id='" . $input['Id'] . "'";
                $Selectaoqtime = $connection->execute("select DISTINCT InputEntityId from ME_Production_TimeMetric where Qc_Batch_Id='" . $input['Id'] . "'")->fetchAll('assoc');
                // echo $Selectaoqtime[0]['InputEntityId'];exit;
				$in=0;$inputentityArr='';
				foreach($Selectaoqtime as $val){
					$inputentityArr[$in]=$val['InputEntityId'];
					$in++;
				}
				 $inputentity=implode(',',$inputentityArr);
				//if($inputentity!=''){
                /////Attributes Missed 
                $Selectaoqqc = $connection->execute("select COUNT(Id) as cnt from MV_QC_Comments where ModuleId=".$moduleId." and ErrorCategoryMasterId='" . $ErrorcatId . "' AND InputEntityId in (" . $inputentity . ")")->fetchAll('assoc');
                foreach ($Selectaoqqc as $Inattr):
                    $AttrFilledqc[] = $Inattr['cnt'];
                endforeach;
                  $totAttrMissed = array_sum($AttrFilledqc);
				//$totAttrMissed = $Selectaoqqc[0]['cnt'];

                /////Attributes Filled
			//	echo "select COUNT(Id) as cnt from MC_CengageProcessInputData where DependencyTypeMasterId='" . $DependId . "' AND InputEntityId in (" . $inputentity . " ) GROUP BY SequenceNumber,AttributeMasterId,DependencyTypeMasterId";
				$Selectaoqinput = $connection->execute("select COUNT(MC_CengageProcessInputData.Id) as cnt from MC_CengageProcessInputData 
				INNER JOIN ProductionEntityMaster ON ProductionEntityMaster.InputEntityId=	MC_CengageProcessInputData.InputEntityId
				
				where DependencyTypeMasterId='" . $DependId . "' AND MC_CengageProcessInputData.InputEntityId in (" . $inputentity . " )
				AND StatusId!=19
				GROUP BY MC_CengageProcessInputData.InputEntityId ,MC_CengageProcessInputData.SequenceNumber,MC_CengageProcessInputData.AttributeMasterId,MC_CengageProcessInputData.DependencyTypeMasterId")->fetchAll('assoc');
                $AttrFilled = array();
                foreach ($Selectaoqinput as $Inattr):
                    $AttrFilled[] = $Inattr['cnt'];
                endforeach;
                   $totAttrFilled = count($Selectaoqinput);


                
				///error weightage//////////
				//echo "select SUM(wm.Weightage) as weightage from MV_QC_Comments as cm LEFT JOIN MC_WeightageMaster as wm ON cm.ErrorCategoryMasterId=wm.ErrorCategory  where InputEntityId in (" . $inputentity . ") GROUP BY cm.InputEntityId";
				//echo "select SUM(wm.Weightage) as weightage from MV_QC_Comments as cm LEFT JOIN MC_WeightageMaster as wm ON cm.ErrorCategoryMasterId=wm.ErrorCategory   where cm.ModuleId=".$moduleId." and InputEntityId in (" . $inputentity . ") GROUP BY cm.InputEntityId";
                $Selectaoqweight = $connection->execute("select SUM(wm.Weightage) as weightage from MV_QC_Comments as cm LEFT JOIN MC_WeightageMaster as wm ON cm.ErrorCategoryMasterId=wm.ErrorCategory   where cm.ModuleId=".$moduleId." and InputEntityId in (" . $inputentity . ") GROUP BY cm.InputEntityId")->fetchAll('assoc');
                  foreach ($Selectaoqweight as $Inaoqattr):
                    $AoqAttrFilled[] = $Inaoqattr['weightage'];
                endforeach;
                   $totweight = array_sum($AoqAttrFilled);
				 //$totweight = $Selectaoqweight[0]['weightage'];

                ///////end/////////////////
            /*    
echo "select COUNT(Id) as cnt from MV_QC_Comments where ErrorCategoryMasterId='" . $ErrorcatId . "' AND InputEntityId='" . $Selectaoqtime[0]['InputEntityId'] . "'";
            echo "select COUNT(Id) as cnt from MC_CengageProcessInputData where DependencyTypeMasterId='" . $DependId . "' AND InputEntityId='" . $Selectaoqtime[0]['InputEntityId'] . "' GROUP BY SequenceNumber,AttributeMasterId,DependencyTypeMasterId";
            
            echo "select SUM(wm.Weightage) as weightage from MV_QC_Comments as cm LEFT JOIN MC_WeightageMaster as wm ON cm.ErrorCategoryMasterId=wm.ErrorCategory  where InputEntityId='" . $Selectaoqtime[0]['InputEntityId'] . "' GROUP BY cm.InputEntityId";
            
            exit;*/
                
                
                $totAttributes = $totAttrFilled + $totAttrMissed;
                $AOQ_Calc = 100 - (($totweight / $totAttributes) * 100);
                $AOQ_Calc = bcdiv($AOQ_Calc, 1, 2);  // 2.56
                if (floor($AOQ_Calc) == $AOQ_Calc) {
                    $AOQ_Calc = round($AOQ_Calc);
                }

				$AOQ_Calc=$AOQ_Calc/count($inputentity);

                /////////////AOQ end/////////////////


                $path = JSONPATH . '\\ProjectConfig_' . $input['ProjectId'] . '.json';
                $content = file_get_contents($path);
                $contentArr = json_decode($content, true);

                //$status = $contentArr['ProjectGroupStatus']['Validation'];
                /*             $status = array(
                  '1' => 'Ready for Batch Creation',
                  '2' => 'Ready for Hygine Check',
                  '3' => 'Ready for Sample Creation',
                  '4' => 'Hygine check Rejected',
                  '5' => 'Sample Created'
                  );
                 * 
                 */
                $originalStartDate = $input['CreatedDate'];
                $newStartDate = date("d-m-Y", strtotime($originalStartDate));

                $qcpending = $input['SampleCount'] - $input['QCCompletedCount'];
                if ($input['SampleCount'] > 0 && $qcpending == 0) {
                    $accuracy_percentage = $AOQ_Calc . "%";
                } else {
                    $accuracy_percentage = "";
                }

                $QA_data[$i]['CreatedDate'] = $newStartDate;
                $QA_data[$i]['ProjectId'] = $input['ProjectId'];
                $QA_data[$i]['BatchName'] = $input['BatchName'];
                $QA_data[$i]['StatusId'] = $status[$input['StatusId']];
                $QA_data[$i]['EntityCount'] = $input['EntityCount'];
                $QA_data[$i]['SampleCount'] = $input['SampleCount'];
                $QA_data[$i]['QCCompletedCount'] = $input['QCCompletedCount'];
                $QA_data[$i]['QCpending'] = $qcpending;
                $QA_data[$i]['aoq'] = $accuracy_percentage;
                $QA_data[$i]['BatchRejectionStatus'] = $input['BatchRejectionStatus'];
                $QA_data[$i]['Id'] = $input['Id'];


                $i++;
            endforeach;
            $this->set('SelectQCBatch', $QA_data);

            if (isset($this->request->data['downloadFile'])) {

                $productionData = '';
                if (!empty($QA_data)) {
                    $productionData = $this->QAreview->find('export', ['ProjectId' => $ProjectId, 'condition' => $QA_data]);
                $this->layout = null;
                if (headers_sent())
                    throw new Exception('Headers sent.');
                while (ob_get_level() && ob_end_clean());
                if (ob_get_level())
                    throw new Exception('Buffering is still active.');
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition:attachment;filename=QAreviewreport.xls");
                echo $productionData;
                exit;
                }
               
            }
            if (empty($QA_data)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }

            // $this->set('QAreview', $QA_data);
        } //check_submit close
    }

    function ajaxstatus() {
        echo $status = $this->QAreview->find('status', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxregion() {
        echo $region = $this->QAreview->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->QAreview->find('module', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->QAreview->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getavailabledate() {

        echo $Module = $this->QAreview->find('availabledate', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $_POST['ModuleId'], 'UserGroupId' => $_POST['UserGroupId']]);
        exit;
    }

    function getProductionData() {
        echo $Module = $this->QAreview->find('availableproduction', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $_POST['ModuleId'], 'UserGroupId' => $_POST['UserGroupId'], 'batch_from' => $_POST['batch_from'], 'batch_to' => $_POST['batch_to'], 'FromTime' => $_POST['FromTime'], 'ToTime' => $_POST['ToTime']]);
        exit;
    }

    function ajaxgetdata() {
        $QaSLA = QareviewSLA;
        ////project////
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $userid = $session->read('user_id');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;


        ////project end//////

        $id = $this->request->data('Id');
        $connection = ConnectionManager::get('default');

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $status = $contentArr['ProjectGroupStatus']['Validation'];

        /* $SelectRow = $connection->execute("select *
          from
          (
          select  QCBatchId, BatchName,date
          from MV_QC_BatchIteration
          ) src
          pivot
          (
          max(QCBatchId)
          for QCBatchId in ([4155])
          ) piv;")->fetchAll('assoc'); */
       // $SelectRow = $connection->execute("select  date,ProjectId,BatchName,StatusId,BatchSize,SampleSize,QcCompleted,QcPending,AOQ  from MV_QC_BatchIteration WHERE QCBatchId='4155'")->fetchAll('assoc');
	           $SelectRow = $connection->execute("select  date,ProjectId,BatchName,StatusId,BatchSize,SampleSize,QcCompleted,QcPending,AOQ  from MV_QC_BatchIteration WHERE QCBatchId='".$id."'")->fetchAll('assoc');

        $ArKey = array();
        $ArVal = array();
        $i = 0;
        $qc_datarow = "";
        $totRow = count($SelectRow);
////head//////////////////////////////
        $qc_datahead = "<tr>";
        for ($r = 0; $r <= $totRow; $r++) {
            if ($r == 0) {
                $title = "";
            } else {
                $title = "Iteration-" . $r;
            }
            $qc_datahead.='<td style="border: 1px solid black;">' . $title . '</td>';
        }
        $qc_datahead.="</tr>";

////head end//////////////////////////////

        foreach ($SelectRow as $key => $value) {
            foreach ($value as $arkey => $arvalue) {
                $ArKey[$i][] = $arkey;
                $ArVal[$i][$arkey] = $arvalue;
            }
            $i++;
        }


        $totcountkey = count($ArVal[0]);
        $totcount = count($ArVal);
///////////////row//////////////////
        for ($j = 0; $j < $totcountkey; $j++) {
            $key = $ArKey[0][$j];

            $qc_datarow.='<tr>';
            $qc_datarow.='<td style="border: 1px solid black;">' . $key . '</td>';
            for ($i = 0; $i < $totcount; $i++) {
                if ($key == "ProjectId") {

                    $value = $ProListFinal[$ArVal[$i][$key]];
                } else {

                    $value = $ArVal[$i][$key];
                }
                $qc_datarow.='<td style="border: 1px solid black;">' . $value . '</td>';
            }

            $qc_datarow.='<tr>';
        }

///////////////row end//////////////////



        /* foreach($SelectRow as $key=>$value){
          $qc_datarow.='<tr>';
          foreach($value as $arkey=>$arvalue){
          $qc_datarow.='<td>'.$arkey.'</td>';
          $qc_datarow.='<td>'.$arvalue.'</td>';
          }
          $qc_datarow.='</tr>';


          } */


        $qc_data.='<table cellpadding="10" style="display:inline-table;border-collapse: collapse;">';
        $qc_data.=$qc_datahead . $qc_datarow;
        // $qc_data.=$qc_datarow;
        $qc_data.='</table>';
        echo $qc_data;
        // echo json_encode($valArr);
        exit;
    }

    function ajaxcount() {

        $ProjectId = $_POST['ProjectId'];
        $RegionId = $_POST['RegionId'];
        $ModuleId = $_POST['ModuleId'];
        $UserGroupId = $_POST['UserGroupId'];

        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $contentArr['RegionList'];
        $hygineCheck = $contentArr['ProjectConfig']['HygineCheck'];
        $moduleHygenicCheck = $contentArr['ModuleConfig'][$ModuleId]['IsHygineCheck'];

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

        $batch_from = $_POST['batch_from'];
        $batch_to = $_POST['batch_to'];

        $from_time = $_POST['FromTime'];
        $to_time = $_POST['ToTime'];

        $ProductionStartDate = $batch_from;
        $ProductionStartDate = date("Y-m-d", strtotime($ProductionStartDate));
        $ProductionStartTime = $from_time;

        $ProductionEndDate = $batch_to;
        $ProductionEndDate = date("Y-m-d", strtotime($ProductionEndDate));
        $ProductionEndTime = $to_time;

        if ($ProductionStartTime == '') {
            $ProductionStartTime = '00:00:00';
        }
        $DupCheckTimeStart = new \DateTime($ProductionStartDate . ' ' . $ProductionStartTime);
        $DupCheckTimeStart->modify("+1 second");
        $DupCheckTimeStart = $DupCheckTimeStart->format('Y-m-d H:i:s');

        $conditions = '';

        if ($ProductionEndTime != '') {

            $NewEndTime = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
            $NewEndTime->modify("-1 second");
            $NewEndTime = $NewEndTime->format('Y-m-d H:i:s');

            $DupCheckTimeEnd = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
            $DupCheckTimeEnd->modify("-1 second");
            $DupCheckTimeEnd = $DupCheckTimeEnd->format('Y-m-d H:i:s');
            $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $NewEndTime . "'";
        }

        if ($ProductionEndTime == '') {
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i:s");
            $ProductionEndTime = '23:59:59';
            if ($ProductionEndDate >= $currentDate) {
                $ProductionEndTime = $currentTime;
            }
            $DupCheckTimeEnd = new \DateTime($ProductionEndDate . ' ' . $ProductionEndTime);
            $DupCheckTimeEnd = $DupCheckTimeEnd->format('Y-m-d H:i:s');
            $conditions.="  Start_Date >='" . $ProductionStartDate . " $ProductionStartTime' AND Start_Date <='" . $ProductionEndDate . " $ProductionEndTime'";
        }

        $selectRecords = $connection->execute("select * from ME_Production_TimeMetric where $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ")")->fetchAll('assoc');

        $CompletedRecords = $connection->execute("select * from ME_Production_TimeMetric where $conditions and ProjectId=$ProjectId and RegionId = $RegionId and Module_Id= $ModuleId and UserId IN (" . $UserList . ") and QcStatusId = 1")->fetchAll('assoc');

        $totalSelectedRecords = count($selectRecords);
        $totalCompletedRecords = count($CompletedRecords);
        $text = "Batch Not Created Some Incomplete Records in Selected date";

//        $selectBatch = $connection->execute("SELECT * FROM MV_QC_BatchMaster WHERE ((ProductionStartDate <= '$DupCheckTimeStart' and '$DupCheckTimeStart' <= ProductionEndDate) or
//                (ProductionStartDate  <= '$DupCheckTimeEnd' and '$DupCheckTimeEnd' <= ProductionEndDate) or
//                ('$DupCheckTimeStart'  <= ProductionStartDate and ProductionStartDate <= '$DupCheckTimeEnd')) and ProjectId=$ProjectId and RegionId = $RegionId and ProcessId= $ModuleId")->fetchAll('assoc');
        // if (empty($selectBatch)) {
        if (!empty($totalCompletedRecords)) {
            //if ($totalSelectedRecords == $totalCompletedRecords) {
            // if (($hygineCheck == 1) && ($moduleHygenicCheck == 1)) {
            echo $totalCompletedRecords;
            // }
//                } else {
//                    echo 'Incomplete';
//                }
        } else {
            echo 'No Record Found';
        }
        //}

        exit;
    }
    function ajaxRejectstatus(){

        $connection = ConnectionManager::get('default');
      
         $Id = $_POST['Id'];
         $flag = $_POST['flag'];
         $selectRecords = $connection->execute("update MV_QC_BatchMaster set BatchRejectionStatus = '".$flag."' where Id='".$Id."'")->fetchAll('assoc');
         echo "true";
         exit;
}

}
