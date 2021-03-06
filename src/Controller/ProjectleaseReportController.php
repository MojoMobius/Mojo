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
class ProjectleaseReportController extends AppController {

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
        $this->loadModel('GetJob');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->loadModel('ProjectleaseReport');
    }

    public function pr($array) {
        echo "<pre>";
        print_r($array);
        exit;
    }

    public function getvalues($array, $key,$d='',$dt='',$s='') {
        $arr = array();
        if (!empty($array)) {
            $arr = array_column($array, $key);
            $msg = '';
            if (!empty($arr)) {
                $i = 1;
                foreach ($arr as $k => $v) {
                    if (!empty($v)) {
                        if(!empty($d)){
                            $v = date('d-m-Y', strtotime($v));
                        }
                        if(!empty($dt)){
                            $v = date('d-m-Y', strtotime($v));
                        }
                        if(!empty($s)){
                              $v = $i.". ". $v;
                              $i++;
                        }
                        
                        $msg .=$v . ", ";
                    }
                }
            }
            
            $msg = rtrim($msg, ', ');
                      
            return $msg;
        }

        return $arr;
    }

    public function index() {
        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read("user_id");
        $role_id = $session->read("RoleId");
        $RegionId = 1011;
        $moduleIdtxt = 'DQC';
        $this->set('RegionId', $RegionId);
//        $ProjectId = $session->read("ProjectId");
        $moduleId = $session->read("moduleId");


        $MojoProjectIds = $this->projectmasters->find('Projects');
        $this->loadModel('EmployeeProjectMasterMappings');
        $is_project_mapped_to_user = $this->EmployeeProjectMasterMappings->find('Employeemappinglanding', ['userId' => $user_id, 'Project' => $MojoProjectIds]);
        $ProList = $this->Puquery->find('GetMojoProjectNameList', ['proId' => $is_project_mapped_to_user]);
        $ProListFinal = array('0' => '--Select Project--');
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;


        $this->set('Projects', $ProListFinal);

//        $this->request->data['ProjectId'] = 3346;
//        $ProjectId = 3346;
//$this->request->data['ProjectId'] = 3369;
        if (isset($this->request->data['ProjectId'])) {
            $this->set('ProjectId', $this->request->data['ProjectId']);
            $ProjectId = $this->request->data['ProjectId'];
        } else {
            $this->set('ProjectId', 0);
            $ProjectId = 0;
        }

        if (isset($this->request->data['ProjectId'])) {
            $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
            $resources = $JsonArray['UserList'];
            $domainId = $JsonArray['ProjectConfig']['DomainId'];
            $AttributeMasterId = $JsonArray['ProjectConfig']['DomainId'];
            $region = $regionMainList = $JsonArray['RegionList'];
            $modules = $JsonArray['Module'];
            $ModuleId = array_search($moduleIdtxt, $modules);

            $ProjectName = $JsonArray[$ProjectId];

            $modulesConfig = $JsonArray['ModuleConfig'];
            $modulesArr = array();

            $modulesArr[$ModuleId] = $moduleIdtxt;
            ksort($modulesArr);
        }

        $this->set('resources', $resources);
        $this->set('modules', $modulesArr);

        if (isset($this->request->data['QueryDateFrom'])) {
            $QueryDateFrom = $this->request->data['QueryDateFrom'];
            $this->set('QueryDateFrom', $this->request->data['QueryDateFrom']);
        } else {
            $this->set('QueryDateFrom', '');
            $QueryDateFrom = '';
        }


        if (isset($this->request->data['QueryDateTo'])) {
            $QueryDateTo = $this->request->data['QueryDateTo'];
            $this->set('QueryDateTo', $this->request->data['QueryDateTo']);
        } else {
            $this->set('QueryDateTo', '');
            $QueryDateTo = '';
        }


        if (isset($this->request->data['user_id']))
            $this->set('UserId', $this->request->data['user_id']);
        else
            $this->set('UserId', '');

//        print_r($this->request->data['user_id']) ;exit;

        if (isset($this->request->data['user_id']))
            $this->set('postuser_id', $this->request->data['user_id']);
        else
            $this->set('postuser_id', '');


//            $this->set('User', array());

        if (isset($this->request->data['ProjectId']) || isset($this->request->data['ModuleId'])) {
            $Modules = $this->ProjectleaseReport->find('module', ['ProjectId' => $this->request->data['ProjectId'], 'ModuleId' => $ModuleId]);

            $this->set('ModuleIds', $Modules);
        } else {
            $this->set('ModuleIds', 0);
        }
//        QueryRaisedDate
        if (isset($this->request->data['UserGroupId']))
            $this->set('postbatch_UserGroupId', $this->request->data['UserGroupId']);
        else
            $this->set('postbatch_UserGroupId', '');

        $resqueryData = array();
        $result = array();
        if (isset($this->request->data['check_submit']) || isset($this->request->data['formSubmit'])) {

            $ProjectId = $this->request->data['ProjectId'];
            $RegionId = $this->request->data['regionId'];
//            $ModuleId = $this->request->data['ModuleId'];
            $UserGroupId = $this->request->data['UserGroupId'];

            $QueryDateFrom = $this->request->data['QueryDateFrom'];
            $QueryDateTo = $this->request->data['QueryDateTo'];

            $user_id = $this->request->data['user_id'];

            if (isset($this->request->data['user_id']))
                $this->set('postuser_id', $this->request->data['user_id']);
            else
                $this->set('postuser_id', '');


            $user_id_list = $this->Puquery->find('resourceDetailsArrayOnly', ['ProjectId' => $ProjectId, 'RegionId' => $RegionId, 'UserId' => $session->read('user_id'), 'UserGroupId' => $UserGroupId]);
            $this->set('User', $user_id_list);

            if (empty($user_id)) {
                $user_id = array_keys($user_id_list);
            }

            $conditions = "";

            if (!empty($user_id)) {
                $conditions.="  AND uq.UserID in (" . implode(',', $user_id) . ")";
            }
            if ($QueryDateFrom != '' && $QueryDateTo != '') {
                $conditions.="  AND QueryRaisedDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND QueryRaisedDate <='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }
            if ($QueryDateFrom != '' && $QueryDateTo == '') {
                $conditions.="  AND QueryRaisedDate >='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 00:00:00' AND QueryRaisedDate <='" . date('Y-m-d', strtotime($QueryDateFrom)) . " 23:00:00'" ;
            }
            if ($QueryDateFrom == '' && $QueryDateTo != '') {
                $conditions.="  AND QueryRaisedDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 00:00:00' AND QueryRaisedDate ='" . date('Y-m-d', strtotime($QueryDateTo)) . " 23:59:59'";
            }

//            $conditions = "";

            $queryData = $connection->execute("SELECT Id FROM MC_DependencyTypeMaster where ProjectId='$ProjectId' and FieldTypeName='General' ")->fetchAll('assoc');
            $DependencyTypeMasterId = $queryData[0]['Id'];

            $queryData = $connection->execute("select cpid.AttributeValue as fdrid,cpid.ProductionEntityID ,cpid.InputEntityId from ME_UserQuery as uq inner join MC_CengageProcessInputData as cpid on uq.ProductionEntityID=cpid.ProductionEntityID  where uq.ProjectId='$ProjectId' and cpid.DependencyTypeMasterId='$DependencyTypeMasterId' and cpid.SequenceNumber=1 and cpid.AttributeMasterId='$AttributeMasterId' $conditions group by cpid.AttributeValue , cpid.ProductionEntityID,cpid.InputEntityId")->fetchAll('assoc');
        
            $list = array();
            if (!empty($queryData)) {
                foreach ($queryData as $key => $val) {

                    $ProductionEntityID = $val['ProductionEntityID'];
                    $InputEntityId = $val['InputEntityId'];
                    $doclist = $this->ajaxgetgroupurl($ProjectId, $RegionId, $ModuleId, $ProductionEntityID, $InputEntityId);
             
                    $list['leaseid'] = $val['fdrid'];
                    $list['noofdocuments'] = $doclist['noofdocuments'];
                    $list['pdfname'] = $doclist['pdfname'];

                    $sub_queryData = $connection->execute("SELECT * FROM ME_UserQuery as uq where uq.ProjectId='$ProjectId' and uq.ModuleId='$ModuleId' and uq.ProductionEntityID='$ProductionEntityID' AND uq.RegionId ='$RegionId'  $conditions")->fetchAll('assoc');

//                    $sub_queryData[0]['Client_Response']= "tset tets";
//                    $sub_queryData[] =$sub_queryData[0];
                    
                    //and ProductionEntityID='$ProductionEntityID' 
//                     $this->pr($sub_queryData);

                    $TLComments = "";
                    $QueryRaisedDate = "";
                    $Client_Response = "";
                    $Client_Response_Date = "";
                    if (!empty($sub_queryData)) {
                        $Query = $this->getvalues($sub_queryData, 'Query','','','s');
                        $TLComments = $this->getvalues($sub_queryData, 'TLComments','','','s');
                        $QueryRaisedDate = $this->getvalues($sub_queryData, 'QueryRaisedDate','D');
                        $Client_Response = $this->getvalues($sub_queryData, 'Client_Response','','','s');
                        $Client_Response_Date = $this->getvalues($sub_queryData, 'Client_Response_Date','','dt');
                    }
                    $list['Query'] = $Query;    
                    $list['holdcomments'] = $TLComments;
                    $list['holdreportdate'] = $QueryRaisedDate;
                    $list['ProjectName'] = $ProjectName;

                    $list['Client_Response'] = $Client_Response;
                    $list['Client_Response_Date'] = $Client_Response_Date;

                    $queryData = $connection->execute("SELECT StatusId FROM ProductionEntityMaster where Id='$ProductionEntityID'")->fetchAll('assoc');
                    $statusid = $queryData[0]['StatusId'];
                    $list['status'] = $JsonArray['ProjectStatus'][$statusid];
                    $result[] = $list;
                }
            }

//              $this->pr($result);exit;

            $this->set('result', $result);

            if (isset($this->request->data['downloadFile'])) {

                $productionData = '';
                if (!empty($result)) {
                    $productionData = $this->ProjectleaseReport->find('export', ['ProjectId' => $ProjectId, 'condition' => $result]);
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

            if (empty($result)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }
    }

    function ajaxgetgroupurl($ProjectId, $RegionId, $moduleId, $ProdEntityId, $InputEntityId) {
        $connection = ConnectionManager::get('default');
//        $ProjectId = $_POST['ProjectId'];
//        $RegionId = $_POST['RegionId'];
//        $InputEntityId = $_POST['InputEntityId'];
//        $ProdEntityId = $_POST['ProdEntityId'];
//        $ProdEntityId = 108904;
//        $InputEntityId = 110190;

//        $AttrGroup = $_POST['AttrGroup'];
//        $AttrSubGroup = $_POST['AttrSubGroup'];
//        $AttrId = $_POST['AttrId'];
//        $Seq = $_POST['seq'];
//        $ProjAttrId = $_POST['ProjAttrId'];
        $session = $this->request->session();

        $stagingTable = 'Staging_' . $moduleId . '_Data';

//        if ($AttrId != '') {
//            $RefURL = AfterRefURL;
//            $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');
//            
//            $multipleValStaging = $connection->execute("Select [" . $AttrId . "] as AttributeValue from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "  and SequenceNumber = " . $Seq . " and [" . $AttrId . "] <> '' GROUP by [" . $AttrId . "]")->fetchAll('assoc');
//        }
        $RefURL = AfterRefURL;
        $RefUrlID = $connection->execute("Select Id from MC_DependencyTypeMaster where Type = '$RefURL' AND ProjectId=" . $ProjectId)->fetchAll('assoc');

        $ColumnNames = $connection->execute("SELECT DISTINCT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  where TABLE_NAME='$stagingTable' and ISNUMERIC(COLUMN_NAME) = 1")->fetchAll('assoc');

        $arr = array();
        foreach ($ColumnNames as $key => $val):
            $arr[] = '[' . $val['COLUMN_NAME'] . ']';
        endforeach;
        $NumericColumnNames = implode(",", $arr);

        $multipleAttr = $connection->execute("Select $NumericColumnNames from $stagingTable where ProjectId = " . $ProjectId . " and RegionId = " . $RegionId . " and InputEntityId = " . $InputEntityId . " and ProductionEntity = " . $ProdEntityId . " and DependencyTypeMasterId = " . $RefUrlID[0]['Id'] . "")->fetchAll('assoc');



        foreach ($multipleAttr as $keys => $values) {
            foreach ($values as $key => $val) {
                if (!empty($val)) {
                    $newArr[$val][] = $key;
                }
            }
        }

        $i = 0;

        foreach ($newArr as $val => $key) {
            $multipleAttrVal[$i]['AttributeValue'] = $val;
            $multipleAttrVal[$i]['attrcnt'] = count(array_unique($key));
            $i++;
        }

        $arrayres = array_column($multipleValStaging, 'AttributeValue');

        $finalarr = array_map(function ($mulattval) use($arrayres) {
            if (!in_array($mulattval['AttributeValue'], $arrayres))
                return $mulattval;
        }, $multipleAttrVal);
        $finalarr1 = array_filter($finalarr);

        $result = array();
        $res = array();
        if (!empty($finalarr1)) {
            $result = array_column($finalarr1, 'AttributeValue');
        }
        if (!empty($result)) {
            $res['pdfname'] = implode(',', $result);
            $res['noofdocuments'] = count($result);
        }
        return $res;
//        $this->pr($array_data);
    }

    public function getmonthlist($date1, $date2) {

        $ts1 = strtotime($date1);
        $ts2 = strtotime($date2);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
        if ($diff > 0) {
            for ($i = 0; $i <= $diff; $i++) {
                $months[] = date('_n_Y', strtotime("$date1 +$i month"));
            }
        } else {
            $months[] = date('_n_Y', strtotime($date1));
        }
        return $months;
    }

    public function purebuteajaxqueryinsert() {
        echo $region = $this->Puquery->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxregion() {
        echo $region = $this->Puquery->find('region', ['ProjectId' => $_POST['projectId']]);
        exit;
    }

    function ajaxfilelist() {
        echo $file = $this->Puquery->find('filelist');
        exit;
    }

    function ajaxstatus() {
        echo $file = $this->Puquery->find('status', ['ProjectId' => $_POST['projectId'], 'importType' => $_POST['importType']]);
        exit;
    }

    function ajaxmodule() {

        echo $module = $this->ProjectleaseReport->find('module', ['ProjectId' => $_POST['ProjectId'], 'RegionId' => $_POST['RegionId'], 'ModuleId' => $ModuleId]);
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

    public function delete($id = null) {
        $Puquery = $this->Puquery->get($id);
        if ($id) {
            $user_id = $this->request->session()->read('user_id');
            $Puquery = $this->Puquery->patchEntity($Puquery, ['ModifiedBy' => $user_id, 'ModifiedDate' => date("Y-m-d H:i:s"), 'RecordStatus' => 0]);
            if ($this->Puquery->save($Puquery)) {
                $this->Flash->success(__('Import Initiate deleted Successfully'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('Puquery', $Puquery);
        $this->render('index');
    }

   

}
