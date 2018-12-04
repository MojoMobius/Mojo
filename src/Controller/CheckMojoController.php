<?php

/**
 * Form : ProductionFieldsMapping
 * Developer: Mobius
 * Created On: Oct 17 2016
 * class to get Input status of a file
 */

namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;



class CheckMojoController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public function initialize() {
        parent::initialize();
        $this->loadModel('Produserqltysummary');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $ProjectMaster = TableRegistry::get('Projectmaster');
        $ProList = $ProjectMaster->find();
        $Projects = array();
        $ProListopt = '';

        $ProListopt = '<select name="ProjectId" id="ProjectId" class="form-control"><option value=0>--Select--</option>';
        foreach ($ProList as $query):
            $Projects[$query->ProjectId] = $query->ProjectName;
            $ProListopt.='<option value="' . $query->ProjectId . '">';
            $ProListopt.=$query->ProjectName;
            $ProListopt.='</option>';
        endforeach;
        $assigned_details_cnt = 1;
        $ProListopt.='</select>';

        $this->set(compact('ProListopt'));
        $this->set(compact('ProList'));

    }

    function ajaxCheckMojoconfig() {
        
        $path = JSONPATH . '\\ProjectConfig_' . $_POST['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $Module = $contentArr['Module'];
        
        $abstractionModule = array_search('Abstraction', $Module);
        $staticValues = $contentArr['ModuleAttributes'][1011][$abstractionModule]['static'];
        $DomainId = $contentArr['ProjectConfig']['DomainId'];
       
        /* Lease Id Order Check */
        if(!empty($DomainId)){
        $keyDisplay = array_column($staticValues, 'DispalyOrder');
       $key = array_keys(array_column($staticValues, 'AttributeMasterId', 'DispalyOrder'), $DomainId); 
       $LeaseId = '<font color="green"><b>Success</b></font>';
        if($keyDisplay[0] != $key[0]){
           $LeaseId = '<font color="red"><b>Failure</b></font>';
           $LeaseIdReason  = 'In Static Fields Lease Id Display Order should be first';
        }
        }
        /* User Name Duplicate check */
       $UserList = $contentArr['UserList'];
        $projUsers = array_keys($UserList);
        $projUsers = implode(',', $projUsers);
       if(!empty($projUsers)){
        $connection = ConnectionManager::get('d2k');
        $dupCheckUsers = $connection->execute("select  Username, COUNT(*) count from Employee where Id IN ('.$projUsers.') and Active = 1 and Deleted = 0  GROUP by Username Having COUNT(*) > 1")->fetchAll('assoc');
        $UserdDupCheck = '<font color="green"><b>Success</b></font>';
        if(!empty($dupCheckUsers)){
           $UserdDupCheck = '<font color="red"><b>Failure</b></font>';
           $UserdDupCheckReason = 'Duplicate Users found';
        }
       }
       /* Project Config, API details */
        $ApiProjectId = $contentArr['ProjectConfig']['ApiProjectId'];
                $ApiTemplateId = $contentArr['ProjectConfig']['ApiTemplateId'];
           $apiDetails = '<font color="green"><b>Success</b></font>';
        if(empty($ApiProjectId) && empty($ApiTemplateId)){
            $apiDetails = '<font color="red"><b>Failure</b></font>';
            $apiDetailsReason = 'Api Project and Template Id Missing';
        }
        else if(empty($ApiProjectId)){
            $apiDetails = '<font color="red"><b>Failure</b></font>';
            $apiDetailsReason = 'Api Project Id Missing';
        }
        else if(empty($ApiTemplateId)){
            $apiDetails = '<font color="red"><b>Failure</b></font>';
            $apiDetailsReason = 'Api Template Id Missing';
        }
        $connection = ConnectionManager::get('default');
        /* File Storage Path */
        $filePath = $connection->execute("select ID from ME_FileStoragePath where RecordStatus = 1 and ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
        $FileStoragePath = '<font color="green"><b>Success</b></font>';
        if(empty($filePath)){
           $FileStoragePath = '<font color="red"><b>Failure</b></font>';
           $FileStoragePathReason = 'File Storage path missing in Mojo Configuration';
        }
        
         /* Dependency Type */
        $dependencyType = $connection->execute("select ID from MC_DependencyTypeMaster where ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
        $dependencyMaster = '<font color="green"><b>Success</b></font>';
        if(empty($dependencyType)){
           $dependencyMaster = '<font color="red"><b>Failure</b></font>';
           $dependencyMasterReason = 'Dependency type missing in Mojo Configuration';
        }
        
        /* Multiple Instance */
        $multipleInstance = $connection->execute("select ID from MC_Subgroup_Config where Is_Distinct = 1 and RecordStatus = 1 and ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
        $multipleInstanceCheck = '<font color="green"><b>Success</b></font>';
        if(empty($multipleInstance)){
           $multipleInstanceCheck = '<font color="red"><b>Failure</b></font>';
           $multipleInstanceCheckReason = 'Sub Group mapping missing in Mojo configuration';
        }
       
        /* Unique Id References */
        $uniqueIdReference = $connection->execute("select ID from MV_UniqueIdFields where RecordStatus = 1 and ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
        $UniqueIdRefCheck = '<font color="green"><b>Success</b></font>';
        if(empty($uniqueIdReference)){
           $UniqueIdRefCheck = '<font color="red"><b>Failure</b></font>';
           $UniqueIdRefCheckReason = 'Unique Id Reference missing in Mojo Configuration';
        }
        
        /* Job Definition */
        $jobId = $connection->execute("select ID from MV_UniqueIndentity where RecordStatus = 1 and ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
        $UniqueId = '<font color="green"><b>Success</b></font>';
        if(empty($jobId)){
           $UniqueId = '<font color="red"><b>Failure</b></font>';
           $UniqueIdReason = 'Unique Id missing in Mojo Configuration (Job Definition)';
        }
        
         /* Url Check */
        $DomainUrl = $contentArr['ProjectConfig']['DomainUrl'];
        if(!empty($DomainUrl)){
        $ModuleConfig = $connection->execute("select ModuleId from ME_Module_Level_Config where IsAllowedToDisplay = 1 and RecordStatus = 1 and Project =" .$_POST['ProjectId'])->fetchAll('assoc');
        $ModuleConfig = array_map('current', $ModuleConfig);
        $TemplateAttributes = $connection->execute("select ModuleId from ME_TemplateAttributeMapping where AttributeMasterId = $DomainUrl and RecordStatus = 1 and ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
        $TemplateAttributes = array_map('current', $TemplateAttributes);
        $UrlModules = array_diff($ModuleConfig, $TemplateAttributes);
        $UrlModulesCheck = '<font color="green"><b>Success</b></font>';
        if(!empty($UrlModules)){
           $UrlModulesCheck = '<font color="red"><b>Failure</b></font>';
           $UrlModulesCheckReason = 'Domain Url should map for all active modules in Mojo Production Template Master';
        }
        }
        else{
           $UrlModulesCheck = '<font color="red"><b>Failure</b></font>';
           $UrlModulesCheckReason = 'Domain Url missing'; 
        }
        /* Module Configs- From Status */
        $ModuleFromStatus = $connection->execute("select FromStatus from ME_Module_Level_Config where IsAllowedToDisplay = 1 and RecordStatus = 1 and FromStatus != '' and Project =" .$_POST['ProjectId'])->fetchAll('assoc');
        $fromStatus = '<font color="green"><b>Success</b></font>';
        if(count($ModuleConfig) != count($ModuleFromStatus)){
         $fromStatus = '<font color="red"><b>Failure</b></font>';  
         $fromStatusReason = 'From Status mandatory for all modules in project (only IsAllowedToDisplay modules)';
        }
        
        /* Project Role Configs */
        $Modulename = $connection->execute("select Id from ME_ModuleName where RecordStatus = 1")->fetchAll('assoc');
        $ProjectRoleConfigs = $connection->execute("select Id from ME_ProjectRoleMapping where RecordStatus = 1 and ProjectId =" .$_POST['ProjectId'])->fetchAll('assoc');
         $roleConfig = '<font color="green"><b>Success</b></font>';  
        if(empty($ProjectRoleConfigs)){
        $roleConfig = '<font color="red"><b>Failure</b></font>';
        $roleConfigReason = 'Role Configuration not mapped in Mojo Project Configuration';
        }
        else if((count($Modulename)) != (count($ProjectRoleConfigs))){
         $roleConfig = '<font color="red"><b>Failure</b></font>';
         $roleConfigReason = 'Role Configuration missed in Mojo Project Configuration';
        }
        /* ACL Configuration */
        $connection = ConnectionManager::get('d2k');
        $dupCheckUsers = $connection->execute("select D2K_ProjectACL.Id from D2K_ProjectACL inner join D2K_ProjectModuleActionMapping on D2K_ProjectACL.ProjectActionId = D2K_ProjectModuleActionMapping.Id inner join D2K_ProjectModuleMapping on D2K_ProjectModuleActionMapping.ProjectModuleMapId = D2K_ProjectModuleMapping.Id where D2K_ProjectModuleMapping.ProjectId=" .$_POST['ProjectId'])->fetchAll('assoc');
        $aclConfig = '<font color="green"><b>Success</b></font>';
        if(empty($dupCheckUsers)){
        $aclConfig = '<font color="red"><b>Failure</b></font>';
        $aclConfigReason = 'ACL Configuration wrong';
        }
      
        $defaultProj = Array
(
    0 => Array
        (
            'prodStatus' => 'Submitted',
            'modStatus' => 'Ready for DQC English'
        ),

      
    1 => Array
        (
            'prodStatus' => 'Submitted',
            'modStatus' => 'Ready for DQC NonEnglish'
        ),

    2 => Array
        (
            'prodStatus' => 'Ready for DQC English',
            'modStatus' => 'Ready for Manual DQC English'
        ),

    3 => Array
        (
            'prodStatus' => 'Ready for DQC NonEnglish',
            'modStatus' => 'Ready for Manual DQC NonEnglish'
        ),

    4 => Array
        (
            'prodStatus' => 'Ready for Manual DQC English',
            'modStatus' => 'Manual DQC Inprogress English'
        ),

    5 => Array
        (
            'prodStatus' => 'Ready for Manual DQC NonEnglish',
            'modStatus' => 'Manual DQC Inprogress NonEnglish'
        ),

    6 => Array
        (
            'prodStatus' => 'Manual DQC Inprogress English',
            'modStatus' => 'Manual DQC Completed English'
        ),

    7 => Array
        (
            'prodStatus' => 'Manual DQC Inprogress NonEnglish',
            'modStatus' => 'Manual DQC Completed NonEglish'
        ),

    8 => Array
        (
            'prodStatus' => 'Input Consolidation Pending',
            'modStatus' => 'Ready for Abstraction'
        ),

    9 => Array
        (
            'prodStatus' => 'Manual DQC Completed NonEglish',
            'modStatus' => 'Ready for Autotranslation'
        ),

    10 => Array
        (
            'prodStatus' => 'Ready For Translation',
            'modStatus' => 'Translation Inprogress'
        ),

    11 => Array
        (
            'prodStatus' => 'Translation Inprogress',
            'modStatus' => 'Translation Completed'
        ),

    12 => Array
        (
            'prodStatus' => 'Translation Completed',
            'modStatus' => 'Ready for Abstraction'
        ),

    13 => Array
        (
            'prodStatus' => 'Manual DQC Inprogress English',
            'modStatus' => 'DQC English Query',
        ),

    14 => Array
        (
            'prodStatus' => 'Manual DQC Inprogress NonEnglish',
            'modStatus' => 'DQC Non English Query'
        ),

    15 => Array
        (
            'prodStatus' => 'DQC Non English Query',
            'modStatus' => 'Ready for Manual DQC NonEnglish'
        ),

    16 => Array
        (
            'prodStatus' => 'DQC English Query',
            'modStatus' => 'Ready for Manual DQC English'
        ),

    17 => Array
        (
            'prodStatus' => 'Ready for Abstraction',
            'modStatus' => 'Abstraction WIP'
        ),

    18 => Array
        (
            'prodStatus' => 'Abstraction WIP',
            'modStatus' => 'Abstraction Completed'
        ),

    19 => Array
        (
            'prodStatus' => 'Abstraction WIP',
            'modStatus' => 'Abstraction Query'
        ),

    20 => Array
        (
            'prodStatus' => 'Manual DQC Completed English',
            'modStatus' => 'Input Consolidation Pending'
        ),

    21 => Array
        (
            'prodStatus' => 'Abstraction Completed',
            'modStatus' => 'Ready for Review',
        ),

    22 => Array
        (
            'prodStatus' => 'Ready for Review',
            'modStatus' => 'Review WIP'
        ),

    25 => Array
        (
            'prodStatus' => 'Ready for Sense Check',
            'modStatus' => 'Sense Check WIP'
        ),

    26 => Array
        (
            'prodStatus' => 'Sense Check WIP',
            'modStatus' => 'Sense Check Completed'
        ),

    27 => Array
        (
            'prodStatus' => 'Review WIP',
            'modStatus' => 'Ready for Abstraction Review Rework'
        ),

    28 => Array
        (
            'prodStatus' => 'Ready for Review Rework',
            'modStatus' => 'Review Rework Inprogress'
        ),

    29 => Array
        (
            'prodStatus' => 'Review Rework Inprogress',
            'modStatus' => 'Review Rework Completed'
        ),

    30 => Array
        (
            'prodStatus' => 'Ready for Sense Rework',
            'modStatus' => 'Sense Rework Inprogress'
        ),

    31 => Array
        (
            'prodStatus' => 'Sense Rework Inprogress',
            'modStatus' => 'Sense Rework Completed'
        ),

    32 => Array
        (
            'prodStatus' => 'Ready for Abstraction Review Rework',
            'modStatus' => 'Abstraction Rework Review Inprogress'
        ),

    33 => Array
        (
            'prodStatus' => 'Ready for Abstraction Sense Rework',
            'modStatus' => 'Abstraction Rework Sense Inprogress'
        ),

    34 => Array
        (
            'prodStatus' => 'Abstraction Rework Sense Inprogress',
            'modStatus' => 'Abstraction Rework Sense Completed'
        ),

    35 => Array
        (
            'prodStatus' => 'Sense Check WIP',
            'modStatus' => 'Ready for Abstraction Sense Rework'
        ),

    36 => Array
        (
            'prodStatus' => 'Abstraction Rework Review Inprogress',
            'modStatus' => 'Ready for Review PU TL Rebuttal'
        ),

    37 => Array
        (
            'prodStatus' => 'Ready for Review PU TL Rebuttal',
            'modStatus' => 'Ready for Review QC TL Rebuttal'
        ),

    38 => Array
        (
            'prodStatus' => 'Abstraction Rework Sense Inprogress',
            'modStatus' => 'Ready for Sense PU TL Rebuttal'
        ),

    39 => Array
        (
            'prodStatus' => 'Ready for Sense PU TL Rebuttal',
            'modStatus' => 'Ready for Sense QC TL Rebuttal'
        ),

    40 => Array
        (
            'prodStatus' => 'Ready for Review QC TL Rebuttal',
            'modStatus' => 'Ready for Review Rework'
        ),

    41 => Array
        (
            'prodStatus' => 'Ready for Sense QC TL Rebuttal',
            'modStatus' => 'Ready for Sense Rework'
        ),

    42 => Array
        (
            'prodStatus' => 'Abstraction Rework Review Completed',
            'modStatus' => 'Ready for Sense Check'
        ),

    43 => Array
        (
            'prodStatus' => 'Translation Inprogress',
            'modStatus' => 'Translation Query'
        ),

    44 => Array
        (
            'prodStatus' => 'Abstraction Rework Review Inprogress',
            'modStatus' => 'Abstraction Rework Review Completed'
        ),

    45 => Array
        (
            'prodStatus' => 'Review WIP',
            'modStatus' => 'Review Completed'
        ),

    46 => Array
        (
            'prodStatus' => 'Abstraction Query',
            'modStatus' => 'Ready for Abstraction'
        ),

    47 => Array
        (
            'prodStatus' => 'Translation Query',
            'modStatus' => 'Ready For Translation'
        ),

    48 => Array
        (
            'prodStatus' => 'Translation Completed',
            'modStatus' => 'Input Consolidation Pending'
        ),

    49 => Array
        (
            'prodStatus' => 'Review Rework Inprogress',
            'modStatus' => 'Ready for Sense Check'
        ),
            50 => Array
        (
            'prodStatus' => 'Ready for Autotranslation',
            'modStatus' => 'Ready For Translation'
        ),
       
            51 => Array
        (
            'prodStatus' => 'Review Completed',
            'modStatus' => 'Ready for Sense Check'
        )
);
         /* Work flow check */
        $connection = ConnectionManager::get('d2k');
        $statusNav = $connection->execute("select ProjectEntityStatusMaster.Status as 'prodStatus',D2K_ModuleStatusMaster.Status as 'modStatus' from D2K_ProjectModuleStatusMapping inner join ProjectEntityStatusMaster on D2K_ProjectModuleStatusMapping.ProjectStatusId = ProjectEntityStatusMaster.Id inner join D2K_ModuleStatusMaster on D2K_ProjectModuleStatusMapping.ModuleStatusId = D2K_ModuleStatusMaster.Id where ProjectEntityStatusMaster.ProjectId = " .$_POST['ProjectId'])->fetchAll('assoc');

foreach($statusNav AS $aV) {
    $aTmp1[] = $aV['prodStatus'] . $aV['modStatus'];
}

foreach($defaultProj AS $aV) {
    $aTmp2[] = $aV['prodStatus'] . $aV['modStatus'];
}
       $new_array = array_diff($aTmp1,$aTmp2);
    $workFlow = '<font color="green"><b>Success</b></font>';
       if(count($aTmp1) != count($aTmp2)){
            $workFlow = '<font color="red"><b>Failure</b></font>';
            $$workFlowReason = 'Module Status Navigation missed or wrongly mapped';
       }
       else if($new_array != ''){
         $workFlow = '<font color="red"><b>Failure</b></font>';
         $$workFlowReason = 'Module Status Navigation missed or wrongly mapped';
        } 
       
        $template='';
        $template.='<table class="table table-striped table-center dataTable no-footer"><thead><tr class="Heading"><th>S.no</th><th>Check List</th><th>Result</th><th>Reason</th></tr></thead>';
        $template.='<tbody><tr class="odd"><td>1</td><td>Lease Id Order</td><td>'.$LeaseId.'</td><td>'.$LeaseIdReason.'</td></tr>'
                . '<tr class="even"><td>2</td><td>Work flow check</td><td>'.$workFlow.'</td><td>'.$$workFlowReason.'</td></tr>'
                . '<tr class="even"><td>3</td><td>User Name Duplicate check</td><td>'.$UserdDupCheck.'</td><td>'.$UserdDupCheckReason.'</td></tr>'
                . '<tr class="odd"><td>4</td><td>ACL Configuration</td><td>'.$aclConfig.'</td><td>'.$aclConfigReason.'</td></tr>'
                . '<tr class="even"><td>5</td><td>Project Config, API details</td><td>'.$apiDetails.'</td><td>'.$apiDetailsReason.'</td></tr>'
                . '<tr class="even"><td>6</td><td>Project Role Configs</td><td>'.$roleConfig.'</td><td>'.$roleConfigReason.'</td></tr>'
                . '<tr class="even"><td>7</td><td>Job Definition</td><td>'.$UniqueId.'</td><td>'.$UniqueIdReason.'</td></tr>'
                . '<tr class="even"><td>8</td><td>Unique Id References</td><td>'.$UniqueIdRefCheck.'</td><td>'.$UniqueIdRefCheckReason.'</td></tr>'
                . '<tr class="even"><td>9</td><td>File Storage Path</td><td>'.$FileStoragePath.'</td><td>'.$FileStoragePathReason.'</td></tr>'
                . '<tr class="even"><td>10</td><td>Module Configs- From Status</td><td>'.$fromStatus.'</td><td>'.$fromStatusReason.'</td></tr>'
                . '<tr class="even"><td>11</td><td>Dependency Type</td><td>'.$dependencyMaster.'</td><td>'.$dependencyMasterReason.'</td></tr>'
                . '<tr class="even"><td>12</td><td>Multiple Instance</td><td>'.$multipleInstanceCheck.'</td><td>'.$multipleInstanceCheckReason.'</td></tr>'
                . '<tr class="even"><td>13</td><td>URL Check</td><td>'.$UrlModulesCheck.'</td><td>'.$UrlModulesCheckReason.'</td></tr>'
                . '</tbody>';
        echo $template.='</table>';
        exit;
    }

                
}
