<?php

/**
 * Form : Stratification Rule Controller
 * Developer: SyedIsmail N
 * Created On: Jul 07 2017
 * class to get Input status of a file
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;

class StratificationRuleController extends AppController {
    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public function initialize() {
        parent::initialize();
        $this->loadModel('ProjectRoleMapping');
        $this->loadModel('projectmasters');
        $this->loadModel('importinitiates');
        $this->loadModel('StratificationRule');
        $this->loadComponent('RequestHandler');
    }

    public function index() {
        $session = $this->request->session();
        $userid = $session->read('user_id');
        $moduleId = $session->read("moduleId");
        $sessionProjects = $session->read('ProjectId');
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $userid, 'Project' => $MojoProjectIds]);
        $ProList = $this->StratificationRule->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $Projects = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $Projects[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $Projects);
        $this->set('sessionProjects', $sessionProjects);
        
        $detailArr = array();
        foreach ($Projects as $key => $val) {
            $detailArr[$key] = $this->StratificationRule->find('getdetail', ['ProjectId' => $key]);
        }
        $this->set('detailArr', $detailArr);
        foreach ($Projects as $key => $val):
            if($key !=0)
                $path = JSONPATH . '\\ProjectConfig_' . $key . '.json';
        endforeach;
        //$path = JSONPATH . '\\ProjectConfig_' . $sessionProjects . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        $status_list = $contentArr['ProjectStatus'];
        $regionMainList = $contentArr['RegionList'];
        $module = $contentArr['Module'];
        asort($status_list);
        $this->set('User', $user_list);
        $this->set('Users', $user_lists);
        $this->set('Status', $status_list);
        $this->set('contentArr', $contentArr);
        if (isset($this->request->params['pass'][0])) {
            $Id = $this->request->params['pass'][0];
        } else {
            $Id = '';
        }
        
        if (isset($this->request->data['check_back'])) {
            return $this->redirect(['action' => 'index']);
        }
        
        if (isset($this->request->data['check_update'])) {
            $ProEditId = $this->request->data('EditId');
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('Region');
            $RuleName = $this->request->data('RuleName');
            $AcceptanceLimit = $this->request->data('AcceptanceLimit');;
            $Process = $this->request->data('ModuleId');
            $MinimumSample = $this->request->data('MinimumSample');
            $LoadAttribute = $this->request->data('LoadAttributeids');
            $SampleType = $this->request->data('Rule_sample');
            $SampleValue = $this->request->data('Sample_value');
            $Resource_sample = $this->request->data('Resource_sample');
            $Resource_value = $this->request->data('Resource_value');
            $StratificationRuleId = $this->request->data('StratificationRuleId');
            if(isset($this->request->data['Resource_stratification'])){
                $Resource_stratification=1;
            }else{
                $Resource_stratification=0;
            }
            $CreatedDate = date("Y-m-d H:i:s");
            $ModifiedDate = date("Y-m-d H:i:s");
            $connection = ConnectionManager::get('default');
            $UpdateRule = $connection->execute("UPDATE MV_QC_StratificationRules SET ProjectId=" . $ProjectId . ",RegionId='" . $RegionId . "',RuleName='".$RuleName."',"
                    . "AceptanceLimit='". $AcceptanceLimit ."', ProcessId='". $Process ."',QC_Module_Id='". $moduleId ."', MinimumSample='". $MinimumSample ."',"
                    . "ResourceStratification='". $Resource_stratification ."', ResourceSampleType='". $Resource_sample ."', ResourceSampleValue='".$Resource_value."',"
                    . "SampleType='". $SampleType ."',SampleValue='". $SampleValue ."',ModifiedBy='". $userid ."', ModifiedDate='".$ModifiedDate."'  WHERE Id=".$StratificationRuleId);
            foreach ($ProEditId as $keys => $ProValue) {
                $EditIds[] = $ProValue;
            }

            if($LoadAttribute!=$ProEditId){
                $StratificationRuleId = $connection->execute("SELECT Id FROM MV_QC_StratificationRules WHERE RuleName='".$RuleName."' and ProjectId=$ProjectId and RegionId=$RegionId and QC_Module_Id=$moduleId and RecordStatus=1")->fetchAll('assoc');
                    $StratificationRuleCnt = $StratificationRuleId[0]['Id'];
                    if($StratificationRuleCnt!=''){
                        $productionjob = $connection->execute("DELETE FROM MV_QC_StratificationFactors WHERE StratificationRuleId=".$StratificationRuleCnt);
                    foreach ($LoadAttribute as $key => $value) {
                            $LoadAttrVal = explode("_",$value);
                            $InsertRule = $connection->execute("INSERT INTO MV_QC_StratificationFactors(StratificationRuleId,ProjectAttributeMasterId,AttributeMasterId,UserId,CreatedDate,CreatedBy)"
                            . "values ($StratificationRuleCnt,$LoadAttrVal[1],$LoadAttrVal[0],$userid,'".$CreatedDate."',1)");
                        }
                    }
                }else{
            foreach ($LoadAttribute as $key => $value) {
                    $LoadAttrVal = explode("_",$value);
                    $UpdateFactors = $connection->execute("UPDATE MV_QC_StratificationFactors SET ProjectAttributeMasterId='".$LoadAttrVal[1]."',AttributeMasterId='".$LoadAttrVal[0]."',"
                    . " ModifiedBy='". $userid ."', ModifiedDate='".$ModifiedDate."' WHERE Id=".$EditIds[$key]);
                }
            }
            $this->Flash->success(__('Data Updated Successfully ..!'));
        }
        
        if (isset($this->request->data['check_submit'])) {

            $ProjectId = $this->request->data('ProjectId');
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('Region');
            $RuleName = $this->request->data('RuleName');
            $AcceptanceLimit = $this->request->data('AcceptanceLimit');;
            $Process = $this->request->data('ModuleId');
            $MinimumSample = $this->request->data('MinimumSample');
            $LoadAttribute = $this->request->data('LoadAttributeids');
            $SampleType = $this->request->data('Rule_sample');
            if($SampleType ==''){
                    $SampleType=0;
            }
            $SampleValue = $this->request->data('Sample_value');
            $Resource_sample = $this->request->data('Resource_sample');
            if($Resource_sample ==''){
                    $Resource_sample=0;
            }
            $Resource_value = $this->request->data('Resource_value');
            if($Resource_value==''){
                $Resource_value=0;
            }
            if(isset($this->request->data['Resource_stratification'])){
                $Resource_stratification=1;
            }else{
                $Resource_stratification=0;
            }
            $CreatedDate = date("Y-m-d H:i:s");
            $connection = ConnectionManager::get('default');
            $RuleCount = $connection->execute("SELECT COUNT(Id) as countId FROM MV_QC_StratificationRules WHERE RuleName='".$RuleName."' and ProjectId=$ProjectId and RegionId=$RegionId and QC_Module_Id=$moduleId and RecordStatus=1")->fetchAll('assoc');
            $RuleNameCnt = $RuleCount[0]['countId'];
                if($RuleNameCnt==0){
                    $InsertRule = $connection->execute("INSERT INTO MV_QC_StratificationRules(ProjectId,RegionId,ProcessId,QC_Module_Id,RuleName,AceptanceLimit,MinimumSample,ResourceStratification,ResourceSampleType,ResourceSampleValue,SampleType,SampleValue,RecordStatus,UserId,CreatedDate,CreatedBy)values ($ProjectId,$RegionId,$Process,$moduleId,'$RuleName',$AcceptanceLimit,$MinimumSample,$Resource_stratification,$Resource_sample,$Resource_value,$SampleType,$SampleValue,1,$userid,'".$CreatedDate."',1)");
                    $StratificationRuleId = $connection->execute("SELECT Id FROM MV_QC_StratificationRules WHERE RuleName='".$RuleName."' and ProjectId=$ProjectId and QC_Module_Id=$moduleId and RegionId=$RegionId and RecordStatus=1")->fetchAll('assoc');
                    $StratificationRuleCnt = $StratificationRuleId[0]['Id'];
                    if($StratificationRuleCnt!=''){
                        foreach ($LoadAttribute as $key => $value) {
                            $LoadAttrVal = explode("_",$value);
                            $InsertRule = $connection->execute("INSERT INTO MV_QC_StratificationFactors(StratificationRuleId,ProjectAttributeMasterId,AttributeMasterId,UserId,CreatedDate,CreatedBy)"
                            . "values ($StratificationRuleCnt,$LoadAttrVal[1],$LoadAttrVal[0],$userid,'".$CreatedDate."',1)");
                        }
                        $this->Flash->success(__('Entered Data Successfully Saved!.'));
                    }
                }else{
                    $this->Flash->error(__('Rule Name already exists!'));
                }
            return $this->redirect(['action' => 'index']);
        }
        $connection = ConnectionManager::get('default');
        $userProjectIds = implode(',', $is_project_mapped_to_user);
        
        
        $FinalArr=array();
        $RuleList = $connection->execute("SELECT Id,ProjectId,RegionId,ProcessId,RuleName,AceptanceLimit,MinimumSample,ResourceStratification,ResourceSampleType,ResourceSampleValue,SampleType,SampleValue,UserId FROM MV_QC_StratificationRules WHERE RecordStatus=1 AND QC_Module_Id=$moduleId AND ProjectId IN ($userProjectIds)")->fetchAll('assoc');
        $RegionId = $RuleList[0]['RegionId'];
        foreach ($RuleList as $values):
            $RuleId = $values['Id'];
            $usearray = $contentArr['AttributeOrder'][$RegionId];
            $Stratificationfactors = $connection->execute("SELECT StratificationRuleId,AttributeMasterId,ProjectAttributeMasterId FROM MV_QC_StratificationFactors where StratificationRuleId=".$RuleId)->fetchAll('assoc');
            $attributeNames = array_map(function($a) use($usearray){ return $usearray[$a['AttributeMasterId']]['DisplayAttributeName']; },$Stratificationfactors);
            //pr($attributeNames);
            $values['StratificationFactors'] = implode(',', $attributeNames);
//            $values['SampleType'] = $Stratificationfactors['0']['SampleType'];
//            $values['SampleValue'] = $Stratificationfactors['0']['SampleValue'];
            $FinalArr[] = $values;
        endforeach;
        $this->set('RuleList', $FinalArr);
         
        $IdEdit = '';
        $ProjectIdEdit = '';
        $RegionIdEdit = '';
        $ProcessIdEdit = '';
        $RuleNameEdit = '';
        $AceptanceLimitEdit = '';
        $MinimumSampleEdit = '';
        $ResourceStratificationEdit = '';
        $ResourceSampleTypeEdit = '';
        $ResourceSampleValueEdit = '';
        $UserIdEdit = '';
        $SampleTypeEdit = '';
        $SampleValueEdit = '';
        $StratificationRuleId = '';
        
        if ($Id != '') {
            $EditRuleList = $connection->execute("SELECT * FROM MV_QC_StratificationRules  WHERE Id=$Id and RecordStatus=1")->fetchAll('assoc');
          $finalArr=array();
            foreach ($EditRuleList as $key => $query):
                $EditId = $query['Id'];
                $ProjectIdEdit = $query['ProjectId'];
                $RegionIdEdit = $query['RegionId'];
                $ProcessIdEdit = $query['ProcessId'];
                $RuleNameEdit = $query['RuleName'];
                $AceptanceLimitEdit = $query['AceptanceLimit'];
                $MinimumSampleEdit = $query['MinimumSample'];
                $ResourceStratificationEdit = $query['ResourceStratification'];
                if ($ResourceStratificationEdit == 1) {
                    $ResourceStratificationChecked = "checked=checked";
                }
                $ResourceSampleTypeEdit = $query['ResourceSampleType'];
                if ($ResourceSampleTypeEdit == 1) {
                    $selectedPercentage = "checked=checked";
                } 
                if ($ResourceSampleTypeEdit == 2) {
                    $selectedCount = "checked=checked";
                }
                $ResourceSampleValueEdit = $query['ResourceSampleValue'];
                $SampleTypeEdit = $query['SampleType'];
                    if ($SampleTypeEdit == 1) {
                        $samplePercentage = "checked=checked";
                    } 
                    if ($SampleTypeEdit == 2) {
                        $sampleCount = "checked=checked";
                    }
                $SampleValueEdit = $query['SampleValue'];
                $UserIdEdit = $query['UserId'];
                $EditIdList = $connection->execute("SELECT * FROM MV_QC_StratificationFactors WHERE StratificationRuleId=$EditId ")->fetchAll('assoc');
                
                foreach ($EditIdList as $key => $value):
                    $AttributeMasterIdEdit = array();
                    $SampleEditId = $value['Id'];
//                    $SampleTypeEdit = $value['SampleType'];
//                    if ($SampleTypeEdit == 1) {
//                        $samplePercentage = "checked=checked";
//                    } else {
//                        $sampleCount = "checked=checked";
//                    }
//                    $SampleValueEdit = $value['SampleValue'];
                    $AttributeMasterIdEdit[$key] = $value['AttributeMasterId']."_".$value['ProjectAttributeMasterId'];
                    $finId[$key]['EditId'] = $value['Id'];
                    $StratificationRuleId = $value['StratificationRuleId'];
                   
                    $attributeids[] = $this->StratificationRule->find('attributeids', ['ProjectId' => $ProjectIdEdit, 'RegionId' => $RegionIdEdit, 'ModuleId' => $ProcessIdEdit, 'AttributeMasterId'=>$AttributeMasterIdEdit]);
                endforeach;
            endforeach;
            
            $RegionEdit = $this->StratificationRule->find('region', ['ProjectId' => $ProjectIdEdit]);
            $moduleEdit = $this->StratificationRule->find('module', ['ProjectId' => $ProjectIdEdit, 'ProcessId' => $ProcessIdEdit]);
        }

        $this->set('EditId',$finId);
        $this->set('ProjectIdEdit',$ProjectIdEdit);
        $this->set('RegionIdEdit',$RegionEdit);
        $this->set('ProcessIdEdit',$moduleEdit);
        $this->set('RuleNameEdit',$RuleNameEdit);
        $this->set('AceptanceLimitEdit',$AceptanceLimitEdit);
        $this->set('MinimumSampleEdit',$MinimumSampleEdit);
        $this->set('StratificationfactorsEdit',$attributeids);
        $this->set('ResourceStratificationEdit',$ResourceStratificationEdit);
        $this->set('selectedPercentage',$selectedPercentage);
        $this->set('selectedCount',$selectedCount);
        $this->set('samplePercentage',$samplePercentage);
        $this->set('sampleCount',$sampleCount);
        $this->set('ResourceChecked',$ResourceStratificationChecked);
        $this->set('ResourceSampleValueEdit',$ResourceSampleValueEdit);
        $this->set('SampleValueEdit',$SampleValueEdit);
        $this->set('StratificationRuleId',$StratificationRuleId);
        $this->set('AttributeMasterIdEdit',$AttributeMasterIdEdit);
        $this->set('ProjectAttributeMasterIdEdit',$ProjectAttributeMasterIdEdit);
        $this->set('AttributeCount',count($attributeids));
    }
    
    function ajaxregion() {
        echo $region = $this->StratificationRule->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }
    
    function ajaxmodule() {
        echo $module = $this->StratificationRule->find('module', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

    function ajaxattributeids() {
        echo $attributeids = $this->StratificationRule->find('attributeids', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $_POST['ModuleId']]);
        exit;
    }
}
