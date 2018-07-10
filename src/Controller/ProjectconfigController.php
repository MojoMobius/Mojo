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
use Cake\ORM\Entity;
use Cake\Datasource\ConnectionManager;

class ProjectconfigController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public function initialize() {
        parent::initialize();
        $this->loadModel('ProjectRoleMapping');
        $this->loadModel('projectmasters');
        $this->loadComponent('RequestHandler');
    }

    public function index() {

//        if($this->request->data['submit']=='Submit') {
//           // pr($this->request->data);exit;
//            $this->ProductionFieldsMapping->InsertAttributeMapping($this->request->data);
//            $this->Session->setFlash('Entered Data Successfully Saved!','flash_good');
//        }
        //error_reporting(E_ALL);
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        if (isset($this->request->params['pass'][0])) {
            $Id = $this->request->params['pass'][0];
        } else {
            $Id = '';
        }
        $connection = ConnectionManager::get('default');
        $Cl_listarray = $connection->execute("select Id,ClientName FROM ClientMaster")->fetchAll('assoc');
		 
        $Cl_list = array('0' => '--Select--');
        foreach ($Cl_listarray as $values):
            $Cl_list[$values['Id']] = $values['ClientName'];
        endforeach;
        //$ProListFinal = ['0' => '--Select Project--', '2278' => 'ADMV_YP'];
        $this->set('Clients', $Cl_list);
        
        //echo $Id;
        //exit;
        if ($this->request->is('post')) {
            $Projectmastertable = TableRegistry::get('Projectmaster');
            $ProjectId = $this->request->data('ProjectId');
            $ProjectName = $this->request->data('ProjectName');
            $workflow_template = $this->request->data('workflow_template');
            $default_prod_view = $this->request->data('default_prod_view');
            $default_dashboard_count = $this->request->data('default_dashboard_count');
            $quality_limit = $this->request->data('quality_limit');
            $monthly_target = $this->request->data('monthly_target');
            $ClientId = $this->request->data('ClientId');
            $input_mandatory = $this->request->data('input_mandatory');
            $is_bulk = $this->request->data('is_bulk');
            $hygine_check = $this->request->data('hygine_check');
			$CengageProject_check = $this->request->data('CengageProject');
			$job_allocation = $this->request->data('job_allocation');
            $existing = array(
                'ProjectId' => $ProjectId
            );
            //if ($Id=='') {
            if (($Projectmastertable->exists($existing)) && ($Id == '')) {
                $this->Flash->error(__('Project Config already exists.'));
                //$this->Flash->error('Project Config already exists.', ['key' => 'error']);
                //$this->Flash->error('Project Config already exists!');
                //}
            } else {
                $Projectmastertable->deleteAll($existing);

                //$Projectmastertable->deleteAll($existing);
                $Projectconfigmaster = $Projectmastertable->newEntity();
                $Projectconfigmaster->CreatedDate = date("Y-m-d H:i:s");
                $Projectconfigmaster->RecordStatus = '1';
                $Projectconfigmaster->CreatedBy = $user_id;
                $Projectconfigmaster->ProjectId = $ProjectId;
                $Projectconfigmaster->ProjectName = $ProjectName;
                $Projectconfigmaster->ProjectTypeId = $workflow_template;
                $Projectconfigmaster->ProdDB_PageLimit = $default_dashboard_count;
                $Projectconfigmaster->ProductionView = $default_prod_view;
                $Projectconfigmaster->QualityLimit = $quality_limit;
                $Projectconfigmaster->MonthlyTarget = $monthly_target;
                $Projectconfigmaster->client_id = $ClientId;
                $Projectconfigmaster->InputCheck = $input_mandatory;
                $Projectconfigmaster->isBulk = $is_bulk;
                $Projectconfigmaster->HygineCheck = $hygine_check;
				$Projectconfigmaster->CengageProject = $CengageProject_check;
				$Projectconfigmaster->joballocation_type = $job_allocation;
                //$OptionMasterMap = $OptionMasterMaptable->patchEntity($OptionMasterMap, $data);

                $Projectmastertable->save($Projectconfigmaster);
                //$this->Flash->success(__('Project Config has been saved.'));
                $this->Flash->success('Project Config has been saved.');
            }
            return $this->redirect(['action' => 'index']);
        }

        $ProjectNameEdit = '';
        $ProEditTypeListopt = '';
        $ProjectIdEdit = '';
        $workflow_templateEdit = '';
        $ProductionViewEdit = '';
        $selectedvertical = '';
        $selectedhorizontal = '';
        $selectedCengage = '';
        $default_dashboard_count_edit = '';
        $QualityLimitEdit = '';
        $monthlytargetEdit = '';
        $selectedyes = '';
        $selectedno = '';
        $selectedbulkyes = '';
        $selectedbulkno = '';
        $selectedhyginecheckyes = '';
        $selectedhyginecheckno = '';
		$selectedLease='';
		$selectedCengage='';
		$selectedothers='';
		$selectedJobManual='';
		$selectedJobAuto='';
        if ($Id != '') {
            $ProjectMaster = TableRegistry::get('Projectmaster');
            $ProEditList = $ProjectMaster->find();
            $ProEditList->where(['RecordStatus' => 1, 'Id' => $Id]);
  //          pr($ProEditList);
//            exit;
            foreach ($ProEditList as $query):
                $ClientId = $query->client_id;
           
                
                $ProjectIdEdit = $query->ProjectId;
                $ProjectNameEdit = $query->ProjectName;
                $workflow_templateEdit = $query->ProjectTypeId;
                $ProductionViewEdit = $query->ProductionView;
				 $job_allocation=$query->joballocation_type; //exit;
                if ($ProductionViewEdit == 1) {
                    $selectedvertical = "selected=selected";
                } else if ($ProductionViewEdit == 2) {
                    $selectedhorizontal = "selected=selected";
                } else if ($ProductionViewEdit == 3) {
                    $selectedCengage = "selected=selected";
                }
                $default_dashboard_count_edit = $query->ProdDB_PageLimit;
                //pr($default_dashboard_count_edit);
                $QualityLimitEdit = $query->QualityLimit;
                $monthlytargetEdit = $query->MonthlyTarget;
                //pr($QualityLimitEdit);
                $InputCheckEdit = $query->InputCheck;
                if ($InputCheckEdit == 1) {
                    $selectedyes = "checked=checked";
                } else {
                    $selectedno = "checked=checked";
                }
                $IsBulkEdit = $query->isBulk;
                if ($IsBulkEdit == 1) {
                    $selectedbulkyes = "checked=checked";
                } else {
                    $selectedbulkno = "checked=checked";
                }
                $HygineCheckEdit = $query->HygineCheck;
                if ($HygineCheckEdit == 1) {
                    $selectedhyginecheckyes = "checked=checked";
                } else {
                    $selectedhyginecheckno = "checked=checked";
                }
				
                if ($job_allocation == 1) {
                    $selectedJobManual = "checked=checked";
                } else {
                    $selectedJobAuto = "checked=checked";
                }
				$CengageProjectCheckEdit = $query->CengageProject;
                if ($CengageProjectCheckEdit == 1) {
                    $selectedCengage = "selected=selected";
                }
				elseif ($CengageProjectCheckEdit == 2) {
                    $selectedLease = "selected=selected";
                }				else {
                    $selectedOthers = "selected=selected";
                }
            endforeach;
             if ($ClientId > 0) {
                 $Clients = $this->Projectconfig->find('client', ['ClientId' => $ClientId]);
                 $this->set('ClientIds', $Clients);
                } else {
                    $this->set('ClientIds', 0);
                }
        
        
        }
        $this->set(compact('ProjectIdEdit'));
        $this->set(compact('ProjectNameEdit'));
        $this->set(compact('selectedvertical'));
        $this->set(compact('selectedhorizontal'));
        $this->set(compact('selectedCengage'));
		$this->set(compact('selectedLease'));
		$this->set(compact('selectedOthers'));
		$this->set(compact('selectedJobAuto'));
		$this->set(compact('selectedJobManual'));
        $this->set(compact('selectedyes'));
        $this->set(compact('selectedno'));
        $this->set(compact('selectedbulkyes'));
        $this->set(compact('selectedbulkno'));
        $this->set(compact('selectedhyginecheckyes'));
        $this->set(compact('selectedhyginecheckno'));
		$this->set(compact('selectedCengageyes'));
        $this->set(compact('selectedCengageno'));
        $this->set(compact('default_dashboard_count_edit'));
        $this->set(compact('QualityLimitEdit'));
        $this->set(compact('monthlytargetEdit'));
        $ProjectMaster = TableRegistry::get('Projectmaster');
        $ProList = $ProjectMaster->find();
        $ProList->where(['RecordStatus' => 1]);

        $ProjectTypeMaster = TableRegistry::get('Projecttypemaster');
        $ProTypeList = $ProjectTypeMaster->find();
        $ProTypeList->where(['RecordStatus' => 1]);
        $ProjectTypeMaster = $this->Projectconfig->newEntity();
        $ProTypeListopt = '';
        $call = '';
        $ProTypeListopt = '<select name="workflow_template" id="workflow_template" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        foreach ($ProTypeList as $query):
            if ($workflow_templateEdit == $query->Id) {
                $selected = "selected=selected";
            } else {
                $selected = '';
            }
            $ProTypeListopt.='<option ' . $selected . ' value="' . $query->Id . '">';
            $ProTypeListopt.=$query->ProjectType;
            $ProTypeListopt.='</option>';
        endforeach;
        $assigned_details_cnt = 1;
        $ProTypeListopt.='</select>';

        $this->set(compact('ProTypeListopt'));
        $this->set(compact('ProTypeList'));
        $this->set(compact('ProList'));
    }

    public function config($ProjectId = null) {
        //pr($this->request->data);
        $ProjectId = $this->request->params['pass'][0];
        $this->set('ProjectId', $ProjectId);
        $Projects = $this->projectmasters->find('ProjectOption');
        $this->set('Projects', $Projects);

        $connection = ConnectionManager::get('default');
        $Module = $connection->execute("select Id, ModuleName from ME_ModuleName where RecordStatus = 1")->fetchAll('assoc');
        $this->set('Module', $Module);

        $ModuleName = array();
        $ModuleId = array();

        foreach ($Module as $key => $value) {
            $ModuleId[$value['ModuleName']] = $value['Id'];
            $ModuleName[$value['Id']] = $value['ModuleName'];
        }

        $this->set('ModuleName', $ModuleName);
        $this->set('ModuleId', $ModuleId);

        $connection = ConnectionManager::get('d2k');
        $UserRoleList = $connection->execute("select RoleMaster.Id,RoleMaster.Name from RoleMaster as RoleMaster INNER JOIN D2K_ProjectRoleMapping as D2K_ProjectRoleMapping on RoleMaster.Id = D2K_ProjectRoleMapping.RoleId where D2K_ProjectRoleMapping.ProjectId = $ProjectId")->fetchAll('assoc');
        $this->set('UserRoleList', $UserRoleList);

        $RoleName = array();
        foreach ($UserRoleList as $key => $value) {
            $RoleName[$value['Id']] = $value['Name'];
        }
        $this->set('RoleName', $RoleName);

        $connection = ConnectionManager::get('default');
        $GetRoleId = $connection->execute("select RoleId from ME_ProjectRoleMapping where ProjectId =$ProjectId and RecordStatus = 1")->fetchAll('assoc');

        $GetRole = array();
        $Queriesresult = array_map('current', $GetRoleId);
        foreach ($Queriesresult as $key => $value) {
            $str = explode(',', $value);
            $GetRole[$key] = $str;
        }
        $this->set('selected', $GetRole);

        $ProjectId = $this->request->data['ProjectId'];

        $RoleMapping = array();
        $RoleId = array();

        foreach ($ModuleName as $key => $value) {
            $RoleId[$key] = $this->request->data['UserList_' . $key . ''];
        }

        foreach ($RoleId as $key => $value) {
            $str = implode(",", $value);
            $RoleMapping[$key] = $str;
        }

        $session = $this->request->session();
        $CreatedBy = $session->read('user_id');
        $CreatedDate = date('Y-m-d H:i:s');
        if ($this->request->is(['post', 'put'])) {
            $connection = ConnectionManager::get('default');
            $productionjob = $connection->execute("DELETE FROM ME_ProjectRoleMapping WHERE ProjectId='" . $ProjectId . "'");
            foreach ($RoleMapping as $key => $value) {
                //echo "INSERT INTO  ME_ProjectRoleMapping(ProjectId,ModuleId, RoleId,RecordStatus,CreatedDate,CreatedBy)values ($ProjectId,$key,'$value',1,'$CreatedDate',1)";
                //echo '<br>';
                $productionjob = $connection->execute("INSERT INTO  ME_ProjectRoleMapping(ProjectId,ModuleId, RoleId,RecordStatus,CreatedDate,CreatedBy)values ($ProjectId,$key,'$value',1,'$CreatedDate',1)");
            }
            $this->Flash->success(__('Updated Successfully.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    function ajaxcheckproject() {
        echo $ProjectIdDk = $this->Projectconfig->find('projectcheck', ['ProjectId' => $_POST['ProjectId']]);
        exit;
    }

}
