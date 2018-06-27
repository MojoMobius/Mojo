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

class QCSampleController extends AppController {

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
        $this->loadModel('QCSample');
        $this->loadModel('QCBatchMaster');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    public function index() {
        $session = $this->request->session();
        $userid = $session->read('user_id');
        
        $moduleId = $session->read("moduleId");
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);

        
        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->QCSample->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        if (isset($this->request->data['ModuleId'])) {
            $Modules = $this->QCSample->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleId', $Modules);
        } else {
            $this->set('ModuleId', 0);
        }

        if (isset($this->request->data['UserGroupId'])) {
            $UserGroup = $this->QCSample->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }
        
        $SelectQCBatch = [];        
        if (isset($this->request->data['check_submit'])) {
           //  print_r($this->request->data);
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ModuleId = $this->request->data('ModuleId');
            $UserGroupId = $this->request->data('UserGroupId');
            $QcStatusId = ('3');
             $session = $this->request->session();
        $userid = $session->read('user_id');
        
         $moduleId = $session->read("moduleId");

            $SelectQCBatch = $this->QCSample->find('batches', ['QcStatusId' => $QcStatusId, 'QcModuleId' => $moduleId, 'ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'ModuleId' => $ModuleId, 'UserGroupId' => $UserGroupId]);
            
            if(!empty($SelectQCBatch)){
                //$this->Flash->success(__('Sample Created Successfully'));
            }else{
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
        $this->set('SelectQCBatch', $SelectQCBatch);
    }
    
    public function qcsampleselection($Id=0) {
       
        $session = $this->request->session();
        //   $ProjectId = $session->read('ProjectId');

        $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");

        $MojoProjectIds = $this->projectmasters->find('Projects');
        //$this->set('Projects', $ProListFinal);
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->QCBatchMaster->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);

        $UserProject = array_keys($ProListFinal);
        $ids = join("','", $UserProject);
        $connection = ConnectionManager::get('default');
        
        $SelectQCBatch = $connection->execute("select * from MV_QC_BatchMaster where RecordStatus=1 and Id IN ('$Id') AND StatusId = 3 AND QC_Module_Id=$moduleId")->fetchAll('assoc');
        $this->set('SelectQCBatch', $SelectQCBatch);
        
        $SelectRules = $connection->execute("select Id,RuleName from MV_QC_StratificationRules where RecordStatus=1 and ProjectId = ".$SelectQCBatch['0']['ProjectId']." AND RegionId = ".$SelectQCBatch['0']['RegionId']." AND ProcessId = ".$SelectQCBatch['0']['ProcessId']." ")->fetchAll('assoc');
        //pr($SelectRules); die;
        $this->set('StratificationRules', $SelectRules);
        $ShowSamplingRecords = $ShowStratificationSamplingRecords = [];
        
     
        
        if (isset($this->request->data['check_submit_random'])) {
            $BatchId = $this->request->data('BatchId');
            $sampling = $this->request->data('sampling');
            $RuleId = $this->request->data('RuleId');
            $ReworkId = $this->request->data('ReworkId');
            $SampleCount = $this->request->data('SampleCount');
            //$SampleCountValue = $this->request->data('SampleCountValue');
            
            $path = JSONPATH . '\\ProjectConfig_' . $SelectQCBatch['0']['ProjectId'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $user_list = $contentArr['UserList'];
            
            $showValuesArray = [
                'sampling' => $sampling,
                'RuleId' => $RuleId,
                'ReworkId' => $ReworkId,
                'SampleCount' => $SampleCount
            ];
          
            $getUserIdByGroup = $connection->execute("SELECT UserId,Count(UserId) UserDoneCnt FROM ME_Production_TimeMetric WHERE Qc_Batch_Id='".$BatchId."' and QC_Module_Id=$moduleId and QcStatusId=3 GROUP BY UserId")->fetchAll('assoc');
             $availJOb = $connection->execute("SELECT count(1) as cnt FROM ME_Production_TimeMetric WHERE Qc_Batch_Id='".$BatchId."' and QC_Module_Id=$moduleId and QcStatusId=3 GROUP BY InputEntityId")->fetchAll('assoc');
			 
//            $SampleCountAvail = $SampleCount;
//            $useridsCount = count($getUserIdByGroup);
//            $totalAvailJobs = $SelectQCBatch['0']['EntityCount'];
//            $eachUserJobsAssignPercentage = floor(($SampleCount/$totalAvailJobs)*100);
//            $eachUserJobsAssignCnt = floor($SampleCount/$useridsCount);

            $useridsCount = count($getUserIdByGroup);
            //$totalAvailJobs = $SelectQCBatch['0']['EntityCount'];
			$totalAvailJobs = count($availJOb);
            $SampleCountAvail = $SampleCountWithPercentage = ceil(($SampleCount / 100) * $totalAvailJobs);
            $showValuesArray['SampleCountWithPercentage'] = $SampleCountWithPercentage; //exit;
            //$eachUserJobsAssignPercentage = floor(($SampleCount/$totalAvailJobs)*100);
            $eachUserJobsAssignPercentage = $SampleCount;
            $eachUserJobsAssignCnt = floor($SampleCount/$useridsCount);
            foreach($getUserIdByGroup as $row) {
                $UserId = $row['UserId'];
                $rowArray = [];
                $rowArray['UserId'] = $UserId;
                $rowArray['Resource'] = $user_list[$UserId];
                $rowArray['TotalCount'] = $row['UserDoneCnt'];
                if($eachUserJobsAssignPercentage>0) {
                    $getUserJobWithPercentage = floor(($eachUserJobsAssignPercentage / 100) * $row['UserDoneCnt']);
                    if($getUserJobWithPercentage>0) 
                        $rowArray['SampleCount'] = $getUserJobWithPercentage;
                    else
                        $rowArray['SampleCount'] = 0;
                    $SampleCountAvail = $SampleCountAvail-$rowArray['SampleCount'];
                    $rowArray['RemainAvailCount'] = $row['UserDoneCnt']-$rowArray['SampleCount'];
                }
                else {
                    $rowArray['SampleCount'] = 0;
                    $rowArray['RemainAvailCount'] = $row['UserDoneCnt'];
                }
                $ShowSamplingRecords[$UserId] = $rowArray;
            }
            if($SampleCountAvail>0) {
                $ShowSamplingRecords = $this->getAvailUserArrays($ShowSamplingRecords,$SampleCountAvail);
            }
            
            $this->set('showValuesArray', $showValuesArray);
            $this->set('ShowSamplingRecords', $ShowSamplingRecords);
        }
        
        if (isset($this->request->data['check_submit_stratification'])) {
            ini_set('max_execution_time', 0);
            $BatchId = $this->request->data('BatchId');
            $sampling = $this->request->data('sampling');
            $ReworkId = $this->request->data('ReworkId');
            $RuleId = $this->request->data('RuleId');
            //$SampleCount = $this->request->data('SampleCount');
            //$SampleCountValue = $this->request->data('SampleCountValue');
            
            $path = JSONPATH . '\\ProjectConfig_' . $SelectQCBatch['0']['ProjectId'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $user_list = $contentArr['UserList'];
            
            $showValuesArray = [
                'sampling' => $sampling,
                'RuleId' => $RuleId,
                'ReworkId' => $ReworkId,
                'SampleCount' => 0
            ];
            
            $RuleDetails = $connection->execute("SELECT Id,SampleType,SampleValue,ResourceStratification,ResourceSampleType,ResourceSampleValue FROM MV_QC_StratificationRules WHERE Id='".$RuleId."' and RecordStatus=1 and ProjectId=".$SelectQCBatch['0']['ProjectId']." and RegionId=".$SelectQCBatch['0']['RegionId']." and ProcessId=".$SelectQCBatch['0']['ProcessId']." ")->fetchAll('assoc');
            $RuleId = $RuleDetails['0']['Id'];
            $RuleFactorsDetails = $connection->execute("SELECT AttributeMasterId,ProjectAttributeMasterId FROM MV_QC_StratificationFactors WHERE StratificationRuleId='".$RuleId."'")->fetchAll('assoc');

            $getInpEntIds = $connection->execute("SELECT distinct (InputEntityId) FROM ME_Production_TimeMetric WHERE Qc_Batch_Id='".$BatchId."' and QcStatusId=3 and QC_Module_Id=$moduleId")->fetchAll('assoc');
            $InpEntIds = [];
            $InpEntIds = array_map(function($value) use($InpEntIds){ return $InpEntIds[] = $value['InputEntityId']; }, $getInpEntIds);
            $InpEntIdsWithCommas = implode(',', $InpEntIds);
            
            $AllAttributeOptions = [];
            foreach($RuleFactorsDetails as $eachAtrributes) {
                $AttributeMasterId = $eachAtrributes['AttributeMasterId'];
                $ProjectAttributeMasterId = $eachAtrributes['ProjectAttributeMasterId'];
                $AttributeOrder = $contentArr['AttributeOrder'][$SelectQCBatch['0']['RegionId']];
                $Options_array = array_values($AttributeOrder[$AttributeMasterId]['Options']);
                $Options_array = array_map(function($value) use($ProjectAttributeMasterId){ return $ProjectAttributeMasterId.'^^'.$value; }, $Options_array);
                $AllAttributeOptions[] = $Options_array;
            }
            
            $getCombinations = $this->combinations($AllAttributeOptions);
         
            foreach($getCombinations as $eachCombination) {
           $where = "";
             $displayName = [];
               if(count($eachCombination) == 1){
                   
                    $splitvalue = explode('^^', $eachCombination);
                    $ProjAttMasterId = $splitvalue['0'];
                    $AttValue = $splitvalue['1'];
                    $where = $where." and [".$ProjAttMasterId."] = N'".$AttValue."'";
                    $displayName[] = $AttValue; 
               }
            else{
               foreach($eachCombination as $eachFields) {
                 
                    $splitvalue = explode('^^', $eachFields);
                    $ProjAttMasterId = $splitvalue['0'];
                    $AttValue = $splitvalue['1'];
                    $where = $where." and [".$ProjAttMasterId."] = N'".$AttValue."'";
                    $displayName[] = $AttValue;
               }      
            }
                $getRecordCountByCombi = $connection->execute("SELECT distinct(stuff((select distinct ',' + Cast(u.InputEntityId as nvarchar(max)) from ML_CengageProductionEntityMaster u WHERE ProjectId=".$SelectQCBatch['0']['ProjectId']." and RegionId=".$SelectQCBatch['0']['RegionId']." and SequenceNumber=1 and InputEntityId IN ($InpEntIdsWithCommas)".$where." for xml path('') ),1,1,'')) as InputEntityIdLists, Count(distinct InputEntityId) InputEntityIdCnt FROM ML_CengageProductionEntityMaster WHERE ProjectId=".$SelectQCBatch['0']['ProjectId']." and RegionId=".$SelectQCBatch['0']['RegionId']." and SequenceNumber=1 and InputEntityId IN ($InpEntIdsWithCommas)".$where)->fetchAll('assoc');
              
                if($getRecordCountByCombi['0']['InputEntityIdCnt']>0) {
                    $keyValue = implode('^^^^', $eachCombination);
                    $displayName = implode('-', $displayName);
                    $addarr = [];
                    $addarr[] = $getRecordCountByCombi['0']['InputEntityIdLists'];
                    $addarr[] = $getRecordCountByCombi['0']['InputEntityIdCnt'];
                    $ShowStratificationSamplingRecords[$keyValue."^^^^^^^^".$displayName] = $addarr;
                }
            }
          
            $StratificationCombiCount = count($ShowStratificationSamplingRecords);
            $totalAvailJobs = $SelectQCBatch['0']['EntityCount'];
            $SampleType = $showValuesArray['SampleType'] = $RuleDetails['0']['SampleType'];
            $SampleCountMain = $showValuesArray['SampleValue'] = $RuleDetails['0']['SampleValue'];
            
            if($SampleType==1) {
                $SampleCountAvail = $SampleCount = ceil(($SampleCountMain / 100) * $totalAvailJobs);
                $eachUserJobsAssignPercentage = $SampleCountMain;
            }
            else if($SampleType==2) {
                $SampleCountAvail = $SampleCount = $SampleCountMain;
                $eachUserJobsAssignPercentage = floor(($SampleCountMain/$totalAvailJobs)*100);
            }
            $showValuesArray['SampleCountWithPercentage'] = $SampleCount;
            $eachUserJobsAssignCnt = floor($SampleCount/$StratificationCombiCount);
         
            if(count($ShowStratificationSamplingRecords)>0) {
                foreach($ShowStratificationSamplingRecords as $key=>$row) {
                    $rowArray = [];
                    $rowArray['DisplayName'] = $key;
                    $rowArray['TotalCount'] = $TotalCount = $row['1'];
                    if($eachUserJobsAssignPercentage>0) {
                        $getUserJobWithPercentage = floor(($eachUserJobsAssignPercentage / 100) * $TotalCount);
                        if($getUserJobWithPercentage>0) 
                            $rowArray['SampleCount'] = $getUserJobWithPercentage;
                        else
                            $rowArray['SampleCount'] = 0;
                        $SampleCountAvail = $SampleCountAvail-$rowArray['SampleCount'];
                        $rowArray['RemainAvailCount'] = $TotalCount-$rowArray['SampleCount'];
                    }
                    else {
                        $rowArray['SampleCount'] = 0;
                        $rowArray['RemainAvailCount'] = $TotalCount;
                    }
                    $ShowSamplingRecords[$key] = $rowArray;
                }
            }
            if($SampleCountAvail>0 && count($ShowSamplingRecords)>0) {
                $ShowSamplingRecords = $this->getAvailStratificationArrays($ShowSamplingRecords,$SampleCountAvail);
            }
//            pr($ShowSamplingRecords);
//            die; 
            $this->set('showValuesArray', $showValuesArray);
            $this->set('ShowStratificationSamplingRecords', $ShowSamplingRecords);
        }
        
        if (isset($this->request->data['sample_create_random'])) {
            
            $UserIds = $this->request->data('UserIds');
            $ReworkId = $this->request->data('ReworkId');
            //pr($UserIds); 
            $ProductionModuleId = $SelectQCBatch['0']['ProcessId'];
            $QCBatchId = $SelectQCBatch['0']['Id'];
            $path = JSONPATH . '\\ProjectConfig_' . $SelectQCBatch['0']['ProjectId'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $ModuleConfig = $contentArr['ModuleConfig'];
            $ModuleStatus_Navigation = $contentArr['ModuleStatus_Navigation'];
            $samplecountArr=0;
            foreach($UserIds as $uid) {
                $samplecount = $this->request->data($uid.'_samplecount');
				if($samplecount>0) {
					$Query = $connection->execute("SELECT ProductionEntityID,InputEntityId FROM ME_Production_TimeMetric WHERE Qc_Batch_Id=".$QCBatchId." and UserId=$uid and QcStatusId=3 and QC_Module_Id=$moduleId and Module_Id=$ProductionModuleId ")->fetchAll('assoc'); //and RecordStatus=1
					$inputenityIds = [];
					foreach($Query as $ids) {
						$inputenityIds[] = $ids['InputEntityId'];
					}              
					shuffle($inputenityIds);
					$randInputEntityIds = array_slice($inputenityIds, 0, $samplecount);
					$randInputEntityIds = implode(',', $randInputEntityIds);
					
					$Query = $connection->execute("SELECT StatusId FROM ProductionEntityMaster WHERE InputEntityId IN (".$randInputEntityIds.") AND ProjectId=".$SelectQCBatch['0']['ProjectId']."  AND RegionId=".$SelectQCBatch['0']['RegionId']." GROUP BY StatusId")->fetchAll('assoc');
					if(!empty($Query)) {
						$statusIdOld = $Query['0']['StatusId'];
						$statusIdNext = $ModuleStatus_Navigation[$statusIdOld]['1'];
						$UpdateFactors = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=".$statusIdNext." WHERE InputEntityId IN (".$randInputEntityIds.") AND ProjectId=".$SelectQCBatch['0']['ProjectId']."  AND RegionId=".$SelectQCBatch['0']['RegionId']."");
					}
                }
                $samplecountArr=$samplecount+$samplecountArr;
            }
            $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");
            $ModifiedDate = date("Y-m-d H:i:s");
            $connection->execute("UPDATE ME_Production_TimeMetric SET QcStatusId=5, ModifiedBy='". $userid ."', ModifiedDate='".$ModifiedDate."' WHERE Qc_Batch_Id=".$QCBatchId." and QC_Module_Id=$moduleId");
            $connection->execute("UPDATE MV_QC_BatchMaster SET StatusId=5,BatchRejectionStatus='". $ReworkId ."',SampleCount=".$samplecountArr.",QCCompletedCount=0, ModifiedBy='". $userid ."', ModifiedDate='".$ModifiedDate."' WHERE Id=".$QCBatchId." and QC_Module_Id=$moduleId");
            $this->Flash->success(__('Random Sampling Created Successfully!'));
            $this->redirect(['action' => 'index']);  
        }
        
        if (isset($this->request->data['sample_create_stratification'])) {
            ini_set('max_execution_time', 0);
            $StratificationCombinations = $this->request->data('StratificationCombinations');
            //pr($StratificationCombinations); 
            $ProductionModuleId = $SelectQCBatch['0']['ProcessId'];
            $QCBatchId = $SelectQCBatch['0']['Id'];
            $path = JSONPATH . '\\ProjectConfig_' . $SelectQCBatch['0']['ProjectId'] . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $ModuleConfig = $contentArr['ModuleConfig'];
            $ModuleStatus_Navigation = $contentArr['ModuleStatus_Navigation'];

            $getInpEntIds = $connection->execute("SELECT InputEntityId FROM ME_Production_TimeMetric WHERE Qc_Batch_Id='".$SelectQCBatch['0']['Id']."' and QcStatusId=3 and QC_Module_Id=$moduleId")->fetchAll('assoc');
            $InpEntIds = [];
            $InpEntIds = array_map(function($value) use($InpEntIds){ return $InpEntIds[] = $value['InputEntityId']; }, $getInpEntIds);
            $InpEntIdsWithCommas = implode(',', $InpEntIds);
            $exitsInputEntityIds = ['0'];
            $samplecountArr=0;
            foreach($StratificationCombinations as $key=>$value) {
                $samplecount = $this->request->data($key.'_samplecount');
                $eachCombination = explode('^^^^', $value);
                $where = "";
                $exitsInputEntityIdsWithCommas = implode(',', $exitsInputEntityIds);
                //pr($exitsInputEntityIds);
                foreach($eachCombination as $eachFields) {
                    $splitvalue = explode('^^', $eachFields);
                    $ProjAttMasterId = $splitvalue['0'];
                    $AttValue = str_replace("'","''",$splitvalue['1']);
                    $where = $where." and [".$ProjAttMasterId."] = N'".$AttValue."'";
                }
                $Query = $connection->execute("SELECT InputEntityId, StatusId FROM ML_CengageProductionEntityMaster WHERE ProjectId=".$SelectQCBatch['0']['ProjectId']." and RegionId=".$SelectQCBatch['0']['RegionId']." and SequenceNumber=1 and InputEntityId IN ($InpEntIdsWithCommas) and InputEntityId NOT IN ($$exitsInputEntityIdsWithCommas)".$where)->fetchAll('assoc');
                
                if(count($Query)>0) {
                    $inputenityIds = [];
                    foreach($Query as $ids) {
                        $inputenityIds[] = $ids['InputEntityId'];
                        $exitsInputEntityIds[] = $ids['InputEntityId'];
                    }              
                    shuffle($inputenityIds);
                    $randInputEntityIds = array_slice($inputenityIds, 0, $samplecount);
                    $randInputEntityIds = implode(',', $randInputEntityIds);

                    $statusIdOld = $Query['0']['StatusId'];
                    $statusIdNext = $ModuleStatus_Navigation[$statusIdOld]['1'];
                    $UpdateFactors = $connection->execute("UPDATE ProductionEntityMaster SET StatusId=".$statusIdNext." WHERE InputEntityId IN (".$randInputEntityIds.") AND ProjectId=".$SelectQCBatch['0']['ProjectId']."  AND RegionId=".$SelectQCBatch['0']['RegionId']."");
                }
                $samplecountArr=$samplecount+$samplecountArr;
            }
            $ReworkId = $this->request->data('ReworkId');
            $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");
            $ModifiedDate = date("Y-m-d H:i:s");
            $connection->execute("UPDATE ME_Production_TimeMetric SET QcStatusId=5, ModifiedBy='". $userid ."', ModifiedDate='".$ModifiedDate."' WHERE Qc_Batch_Id=".$QCBatchId." and QC_Module_Id=$moduleId");
            $connection->execute("UPDATE MV_QC_BatchMaster SET StatusId=5,BatchRejectionStatus='". $ReworkId ."',SampleCount=$samplecountArr,QCCompletedCount=0, ModifiedBy='". $userid ."', ModifiedDate='".$ModifiedDate."' WHERE Id=".$QCBatchId." and QC_Module_Id=$moduleId");
            $this->Flash->success(__('Stratified Sampling Created Successfully!'));
            $this->redirect(['action' => 'index']);  
        }
    }
    
    function getAvailUserArrays($ShowSamplingRecords,$SampleCountAvail) {
	//echo 'came'; 
        $found_items = []; 
        foreach($ShowSamplingRecords as $k=>$v)
        {
            if($v['RemainAvailCount']>0)
            {
               $found_items[] = $v['UserId'];
            }
        }
        if(!empty($found_items)) {
            $useridsCount = count($found_items);
            $eachUserJobAssign = ceil($SampleCountAvail/$useridsCount);
            if($eachUserJobAssign>0) {
                foreach($found_items as $useridvalue) {
                    $recordrowvalue = $ShowSamplingRecords[$useridvalue];
                    if($recordrowvalue['RemainAvailCount']>=$eachUserJobAssign && $SampleCountAvail>0) {
                        $recordrowvalue['SampleCount'] = $recordrowvalue['SampleCount'] + $eachUserJobAssign;
                        $recordrowvalue['RemainAvailCount'] = $recordrowvalue['RemainAvailCount'] - $eachUserJobAssign;
                        $SampleCountAvail = $SampleCountAvail - $eachUserJobAssign;
                    }
                    $ShowSamplingRecords[$useridvalue] = $recordrowvalue;
                }
            }
        }
        if($SampleCountAvail>0) {
            $ShowSamplingRecords = $this->getAvailUserArrays($ShowSamplingRecords,$SampleCountAvail);
        }
		//pr($ShowSamplingRecords);
        return $ShowSamplingRecords;
    }
    
    function getAvailStratificationArrays($ShowSamplingRecords,$SampleCountAvail) {
        $found_items = []; 
        foreach($ShowSamplingRecords as $k=>$v)
        {
            if($v['RemainAvailCount']>0)
            {
               $found_items[] = $v['DisplayName'];
            }
        }
        if(!empty($found_items)) {
            $useridsCount = count($found_items);
            $eachUserJobAssign = ceil($SampleCountAvail/$useridsCount);
            if($eachUserJobAssign>0) {
                foreach($found_items as $useridvalue) {
                    $recordrowvalue = $ShowSamplingRecords[$useridvalue];
                    if($recordrowvalue['RemainAvailCount']>=$eachUserJobAssign && $SampleCountAvail>0) {
                        $recordrowvalue['SampleCount'] = $recordrowvalue['SampleCount'] + $eachUserJobAssign;
                        $recordrowvalue['RemainAvailCount'] = $recordrowvalue['RemainAvailCount'] - $eachUserJobAssign;
                        $SampleCountAvail = $SampleCountAvail - $eachUserJobAssign;
                    }
                    $ShowSamplingRecords[$useridvalue] = $recordrowvalue;
                }
            }
        }
        if($SampleCountAvail>0) {
            $ShowSamplingRecords = $this->getAvailUserArrays($ShowSamplingRecords,$SampleCountAvail);
        }
        return $ShowSamplingRecords;
    }
            
    function combinations($arrays, $i = 0) {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }
        // get combinations from subsequent arrays
        $tmp = $this->combinations($arrays, $i + 1);
        $result = array();
        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? 
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }
        return $result;
    }
    
    function ajaxregion() {
        echo $region = $this->QCSample->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {
        echo $module = $this->QCSample->find('module', ['ProjectId' => $_POST['ProjectId'], 'ModuleId' => $_POST['ModuleId']]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->QCSample->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }
    
    function ajaxlist(){
        
         $session = $this->request->session();
        $moduleId = $session->read("moduleId");
        
        $batchId = $_POST['mandatory'];
        
        $connection = ConnectionManager::get('default');
        
        $SelectQCBatchList = $connection->execute("select ProjectId,RegionId,ProcessId,UserGroupId from MV_QC_BatchMaster where RecordStatus=1 and StatusId=3 and QC_Module_Id=$moduleId and Id =" . $batchId . " ")->fetchAll('assoc');
        $SelectQCBatchList = $SelectQCBatchList[0];
        echo $dataList = json_encode($SelectQCBatchList);
        exit;
    }
}
