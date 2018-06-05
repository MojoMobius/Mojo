<?php

/**
 * Requirement : REQ-003
 * Form : Input Initation
 * Developer: Jaishalini R
 * Created On: 21 Sep 2016
 * class to Initiate Import
 * 
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

/**
 * Bookmarks Controller
 *
 * @property \App\Model\Table\ImportInitiates $ImportInitiates
 */
class QctlrebuttalController extends AppController {

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
        $this->loadModel('projectmasters');
        $this->loadModel('importinitiates');
        $this->loadModel('Puquery');
        $this->loadModel('Purebuttal');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
    }

    public function index() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");
        
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $user_id, 'Project' => $MojoProjectIds]);
        $ProList = $this->Puquery->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2294' => 'Mojo URL Monitoring'];
        $this->set('Projects', $ProListFinal);
        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }
        
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $resources = $JsonArray['UserList'];
        $domainId = $JsonArray['ProjectConfig']['DomainId'];
        $region = $regionMainList = $JsonArray['RegionList'];
        $modules = $JsonArray['Module'];

        $modulesConfig = $JsonArray['ModuleConfig'];
        $modulesArr = array();
        foreach ($modules as $key => $val) {
            if (($modulesConfig[$key]['IsAllowedToDisplay'] == 1) && ($modulesConfig[$key]['IsModuleGroup'] == 1)) {
                $modulesArr[$key] = $val;
            }
        }
        $modulesArr[0] = '--Select--';
        ksort($modulesArr);
        $this->set('resources', $resources);
        $this->set('modules', $modulesArr);

        if (count($ProListFinal) == 2) {
            $ProjectId = $this->request->data['ProjectId'] = array_keys($ProListFinal)[1];
        }

         if (isset($this->request->data['ProjectId']) || isset($this->request->data['RegionId'])) {
            $region = $this->Puquery->find('region', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'SetIfOneRow' => 'yes']);
            $this->set('RegionId', $region);
        } else {
            $this->set('RegionId', 0);
        }

        $this->set('CallUserGroupFunctions', '');
        if (count($ProListFinal) == 2 && count($regionMainList) == 1 && !isset($this->request->data['RegionId'])) {
            $this->set('CallUserGroupFunctions', 'yes');
        }

        if (isset($this->request->data['UserGroupId'])) {
           
            $UserGroup = $this->Puquery->find('usergroupdetails', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('UserGroupId', $UserGroup);
            $UserGroupId = $this->request->data('UserGroupId');
        } else {
            $UserGroupId = '';
            $this->set('UserGroupId', '');
        }

        if (isset($this->request->data['QueryDateFrom']))
            $this->set('QueryDateFrom', $this->request->data['QueryDateFrom']);
        else
            $this->set('QueryDateFrom', '');

        if (isset($this->request->data['QueryDateTo']))
            $this->set('QueryDateTo', $this->request->data['QueryDateTo']);
        else
            $this->set('QueryDateTo', '');

        if (isset($this->request->data['UserId']))
            $this->set('UserId', $this->request->data['UserId']);
        else
            $this->set('UserId', '');

        if (isset($this->request->data['user_id']))
            $this->set('postuser_id', $this->request->data['user_id']);
        else
            $this->set('postuser_id', '');

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['ModuleId'])) {
            $this->set('ModuleId', $this->request->data['ModuleId']);
            $Modules = $this->Purebuttal->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'RegionId' => $this->request->data['RegionId'], 'ModuleId' => $this->request->data['ModuleId']]);

//            $Modules = $this->Puquery->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $this->request->data['ModuleId']]);
            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }

        if (isset($this->request->data['UserGroupId']))
            $this->set('postbatch_UserGroupId', $this->request->data['UserGroupId']);
        else
            $this->set('postbatch_UserGroupId', '');

        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            $conditions_cengage = "";
            $ProjectId = $this->request->data('ProjectId');
            $RegionId = $this->request->data('RegionId');
            $ModuleId = $this->request->data('ModuleId');
            ////////
            $connectiond2k = ConnectionManager::get('d2k');
            $ReadyforQCtlRebuttal = ReadyforQCtlRebuttalIdentifier;


            $QcFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$ModuleId and ModuleStatusIdentifier='$ReadyforQCtlRebuttal' AND RecordStatus=1")->fetchAll('assoc');

            $QcFirstStatus = array_map(current, $QcFirstStatus);
            $first_Status_name = $QcFirstStatus[0];
            $first_Status_id = array_search($first_Status_name, $JsonArray['ProjectStatus']);

            $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId=$ProjectId and FieldTypeName='General' ")->fetchAll('assoc');
            $DependencyTypeMasterId = $queryData[0]['Id'];

            $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);

            $user_id = $this->request->data('user_id');
            $user_group_id = $this->request->data('UserGroupId');
            $QueryDateTo = $this->request->data('QueryDateTo');
            $QueryDateFrom = $this->request->data('QueryDateFrom');
            $user_id_list = $this->Puquery->find('resourceDetailsArrayOnly', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'UserId' => $session->read('user_id'), 'UserGroupId' => $this->request->data['UserGroupId']]);
            $this->set('User', $user_id_list);

            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }

            if ($QueryDateFrom != '' && $QueryDateTo != '') {
                $conditions .= "  AND prdem.ProductionStartDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND prdem.ProductionStartDate <='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }
            if ($QueryDateFrom != '' && $QueryDateTo == '') {
                $conditions .= "  AND prdem.ProductionStartDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND prdem.ProductionStartDate <='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 23:59:59'";
            }
            if ($QueryDateFrom == '' && $QueryDateTo != '') {
                $conditions .= "  AND prdem.ProductionStartDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 00:00:00' AND prdem.ProductionStartDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }


            if ($user_id != '') {
                $conditions_cengage .= "  AND ptm.UserID in (" . implode(',', $user_id) . ")";
            }


            $productionmasters = array();
            $result = array();
            $ReferanceId = "DomainId";

            $queryData = $connection->execute("SELECT uniq.AttributeMasterId,prdem.id as ProductionEntityMasterId,prdem.InputEntityId FROM MV_UniqueIdFields as uniq inner join ProductionEntityMaster as prdem on uniq.ProjectId = prdem.ProjectId where prdem.ProjectId='$ProjectId' and uniq.ReferanceId = '$ReferanceId' and prdem.StatusId ='$first_Status_id' $conditions")->fetchAll('assoc');

            if (!empty($queryData)) {

                foreach ($queryData as $key => $val) {
                    $ProductionEntityID = $val['ProductionEntityMasterId'];
                    $InputEntityId = $val['InputEntityId'];
                    $AttributeMasterId = $val['AttributeMasterId'];

                    // get fdrid  
                    $getresultfdrid = $connection->execute("SELECT cpid.AttributeValue FROM MC_CengageProcessInputData as cpid inner join ME_Production_TimeMetric as ptm on ptm.ProductionEntityID=cpid.ProductionEntityID where cpid.ProductionEntityID='$ProductionEntityID' and cpid.SequenceNumber=1 and cpid.DependencyTypeMasterId='$DependencyTypeMasterId' and cpid.AttributeMasterId='$AttributeMasterId' and cpid.AttributeValue!='' $conditions_cengage group by cpid.AttributeValue")->fetchAll('assoc');

                    // check fdrid not empty
                    if (!empty($getresultfdrid)) {
                        $fdrid = $getresultfdrid[0]['AttributeValue'];
                        $queries = $connection->execute("SELECT qccmt.StatusId,qccmt.RegionId,qccmt.SequenceNumber,qccmt.ProjectAttributeMasterId,qccmt.Id,qccmt.ProjectId,qccmt.RegionId,qccmt.InputEntityId,qccmt.TLReputedComments,qccmt.UserReputedComments,qccmt.QCTLRebuttedComments,qccmt.QCComments,qccmt.AttributeMasterId,qccmt.OldValue,qccat.ErrorCategoryName FROM MV_QC_Comments as qccmt inner join MV_QC_ErrorCategoryMaster as qccat on qccat.id= qccmt.ErrorCategoryMasterId where qccmt.ProjectId = '$ProjectId' and qccmt.InputEntityId ='$InputEntityId' and qccmt.StatusId IN(4,6,7)")->fetchAll('assoc');

                        foreach ($queries as $key => $val) {
                            $queries[$key]['displayname'] = $contentArr['AttributeOrder'][$val['RegionId']][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];
                        }

                        $result[$fdrid]['list'] = $queries;
                        $result[$fdrid]['ProductionEntityID'] = $ProductionEntityID;
                    }
                }
            }

            $this->set('rebuttalResult', $result);

            if (empty($result)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
    }

    function ajaxregion() {
        echo $region = $this->Puquery->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxmodule() {


        echo $module = $this->Purebuttal->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
        exit;
    }

    function getusergroupdetails() {
        $session = $this->request->session();
        echo $module = $this->Puquery->find('usergroupdetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserId' => $session->read('user_id')]);
        exit;
    }

    function getresourcedetails() {
        $session = $this->request->session();
        echo $module = $this->Puquery->find('resourcedetails', ['ProjectId' => $_POST['projectId'], 'RegionId' => $_POST['regionId'], 'UserGroupId' => $_POST['userGroupId']]);
        exit;
    }

    public function ajaxpurebutalcommentsinsert() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user = $session->read("user_id");

        $CommentsId = $_POST['CommentsId'];
        $ProjectId = $_POST['ProjectId'];
        $InputEntityId = $_POST['InputEntityId'];
        $QCrebuttalTextbox = $_POST['QCrebuttalTextbox'];
        $Status_id = $_POST['Status_id'];
        $ModuleId = $_POST['ModuleId'];

        $defaultstatusid = 4;
        $rebutted = 6;
        $rejected = 7;


        $UpdateQryStatus = "update MV_QC_Comments set  StatusId='" . $Status_id . "' ,QCTLRebuttedComments='" . trim($QCrebuttalTextbox) . "' where Id='" . $CommentsId . "' ";
        $QryStatus = $connection->execute($UpdateQryStatus);

        $queries = $connection->execute("SELECT RegionId,StatusId,SequenceNumber,Id,TLReputedComments,UserReputedComments,QCComments,QCTLRebuttedComments,AttributeMasterId,OldValue FROM MV_QC_Comments where Id = '$CommentsId'")->fetchAll('assoc');
        $RegionId = $queries[0]['RegionId'];
        // pu user rework -> status update when atleast one reject from pu-tl   
        $pucmtcntfindqueries = $connection->execute("SELECT count(Id) as pucmtcnt FROM MV_QC_Comments where StatusId = '$defaultstatusid' and InputEntityId='$InputEntityId' and ProjectId='$ProjectId'")->fetchAll('assoc');

        if (!empty($pucmtcntfindqueries)) {

            $pucmtcnt = array_map(current, $pucmtcntfindqueries);
            $cnt = $pucmtcnt[0];

            if ($cnt == 0) { // checking no Tl - comments pending 
                $connectiond2k = ConnectionManager::get('d2k');

                $getReputedIdentifier = ReadyforQCReworkIdentifier;
                $getRejectedIdentifier = Readyforputlrebuttal;
                $ReadyforQCtlRebuttal = ReadyforQCtlRebuttalIdentifier;

                $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);

                // get rejection count details - query 
                $purejectcmtcntfindqueries = $connection->execute("SELECT count(Id) as pucmtcnt FROM MV_QC_Comments where StatusId = '$rejected' and InputEntityId='$InputEntityId' and ProjectId='$ProjectId'")->fetchAll('assoc');
                $purejcmtcnt = array_map(current, $purejectcmtcntfindqueries);
                $purejcnt = $purejcmtcnt[0];

                if ($purejcnt > 0) { // check its having any rejected status
                    // get id for QC User rework 
                    $getreworkFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId='$ModuleId' and ModuleStatusIdentifier='$getRejectedIdentifier' AND RecordStatus=1")->fetchAll('assoc');
                    $reworkfirstStatus = array_map(current, $getreworkFirstStatus);
                    $reworkfirst_Status_name = $reworkfirstStatus[0];
                    $rework_Status_id = array_search($reworkfirst_Status_name, $JsonArray['ProjectStatus']);

                    $UpdateQryStatus = "update ProductionEntityMaster set StatusId='$rework_Status_id' where ProjectId='$ProjectId' AND InputEntityId='$InputEntityId'";
                    $QryStatus = $connection->execute($UpdateQryStatus);
                } else { // pu rebuttal comments done without any reject
                
                      // get production main-status id 
                    $PutlFirstStatus = $connectiond2k->execute("SELECT Status FROM D2K_ModuleStatusMaster where ModuleId=$ModuleId and ModuleStatusIdentifier='$ReadyforQCtlRebuttal' AND RecordStatus=1")->fetchAll('assoc');
                    $PutlFirstStatus = array_map(current, $PutlFirstStatus);
                    $Putlfirst_Status_name = $PutlFirstStatus[0];
                    $Putlfirst_Status_id = array_search($Putlfirst_Status_name, $JsonArray['ProjectStatus']);

                    $qctlcompletedstatus_id = $JsonArray['ModuleStatus_Navigation'][$Putlfirst_Status_id][1];
                    $UpdateQryStatus = "update ProductionEntityMaster set  StatusId='$qctlcompletedstatus_id' where ProjectId='$ProjectId' AND InputEntityId='$InputEntityId'";

                    $QryStatus = $connection->execute($UpdateQryStatus);
                    //Staging table updation
                    $module = $JsonArray['Module'];
                    $module = array_keys($module);
                    $ProductionFields = array();
                    foreach ($module as $key => $value) {
                        $StaticFieldssarr = $JsonArray['ModuleAttributes'][$RegionId][$value]['production'];
                        if (!empty($StaticFieldssarr)) {
                            $moduleId = $value;
                        }
                    }
                    $stagingTable = 'Staging_' . $moduleId . '_Data';
                    $UpdateQryStatus = "update $stagingTable set  StatusId='$qctlcompletedstatus_id' where ProjectId='$ProjectId'  AND InputEntityId=$InputEntityId";
                    $QryStatus = $connection->execute($UpdateQryStatus);
                }
            }
        }

        $data1 = $queries[0];

        if ($data1['StatusId'] == $rebutted) {
            $rebute_txt = "Rebute";
        } else if ($data1['StatusId'] == $rejected) {
            $rebute_txt = "Reject";
        }
        $call = "return query('" . $data1['Id'] . "','" . $data1['StatusId'] . "','D','" . $data1['QCTLRebuttedComments'] . "','" . $data1['QCComments'] . "','" . $data1['UserReputedComments'] . "')";

        echo '<button name="frmsubmit" type="button" onclick="' . $call . '" class="btn btn-default btn-sm added-commnt">' . $rebute_txt . '</button>';
        exit;
    }

}
