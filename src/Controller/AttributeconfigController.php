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

class AttributeconfigController extends AppController {

    /**
     * to initialize the model/utilities gonna to be used this page
     */
    public function initialize() {
        parent::initialize();
        $this->loadModel('GetJob');
        $this->loadModel('ProjectRoleMapping');
        $this->loadModel('projectmasters');
        $this->loadModel('Attributeconfig');
        $this->loadComponent('RequestHandler');
    }

    public function index() {


        $connection = ConnectionManager::get('default');
        $session = $this->request->session();
        $user_id = $session->read('user_id');
        $ProjectId = $session->read("ProjectId");
        //$ProjectId=3346;
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $region=$JsonArray['RegionList'];
        $AttArr = $JsonArray['AttributeOrder']; 
       //echo"<pre>"; print_r($AttArr['1011']);exit;
       
        foreach($region as $key => $val){
            $RegionId=$key;
        }
        if (isset($this->request->params['pass'][0])) {
            $Id = $this->request->params['pass'][0];
        } else {
            $Id = '';
        }
        $MojoProjectIds = $this->projectmasters->find('Projects');
        $test = implode(',', $MojoProjectIds);      
        $connection2 = ConnectionManager::get('d2k');
        $query=$connection2->execute('SELECT ProjectMasterId FROM Employee_ProjectMaster_Mapping WHERE ProjectMasterId in ('.$test.') ')->fetchAll('assoc');
       $Projectlanding = array();
        foreach ($query as $pass) {
           // pr($pass);
            $Projectlanding[] = $pass['ProjectMasterId'];
        }        
         $ProList = $this->Attributeconfig->find('GetMojoProjectNameList', ['proId' => $Projectlanding]);
               
        $ProListFinal = array('0' => '--Select Project--');      
        
        foreach ($ProList as $values):
            $ProListFinal[$values['ProjectId']] = $values['ProjectName'];
        endforeach;
        $this->set('Projects', $ProListFinal);
        $this->set('ProjectIds', "");
        $this->set('RegionId', $RegionId);
        $AttrListmode= '<select name="attribute[]" id="attribute" class="form-control "><option value="0" selected="selected">--Select Project--</option></select>';
        $this->set('Attr1', $AttrListmode); 
        $this->set('Attr2', $AttrListmode);
        $this->set('Attr3', $AttrListmode);
        $this->set('Attr4', $AttrListmode);
        
         if (isset($this->request->data['ProjectId'])) {
             $AttrIds=array();  
             $Arrattribute=$_POST['attribute'];
             $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $_POST['ProjectId']]);      
             $AttArr = $JsonArray['AttributeOrder']; 
             $AttrIds[0] =$AttArr[$_POST['RegionId']][$Arrattribute[0]]['AttributeId'];
             $AttrIds[1] =$AttArr[$_POST['RegionId']][$Arrattribute[1]]['AttributeId'];
             $AttrIds[2] =$AttArr[$_POST['RegionId']][$Arrattribute[2]]['AttributeId'];
             $AttrIds[3] =$AttArr[$_POST['RegionId']][$Arrattribute[3]]['AttributeId'];
             if(empty($AttrIds[0]))
                  $AttrIds[0] =0;
             if(empty($AttrIds[1]))
                  $AttrIds[1] =0;
             if(empty($AttrIds[2]))
                  $AttrIds[2] =0;
             if(empty($AttrIds[3]))
                  $AttrIds[3] =0;
            
             
             
              $Saved = $this->Attributeconfig->find('insertdata', ['ProjectId' => $_POST['ProjectId'],'RegionId' => $_POST['RegionId'],'UserId' => $user_id,'projattribute' => $_POST['attribute'],'attribute' =>$AttrIds]);
               
         }
        
     
         if($Id !=''){
             $saveList =  $connection->execute("SELECT * FROM RentCalc_Config WHERE Id='".$Id."'")->fetchAll('assoc');
             $Projectlist = $this->Attributeconfig->find('proname', ['Prolist' => $ProList,'ProjectId' => $saveList[0]['ProjectId']]);
              
        $this->set('ProjectIds', $Projectlist);
        $this->set('RegionId', $saveList[0]['Regionid']);
         $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $saveList[0]['ProjectId']]);      
         $AttArr = $JsonArray['AttributeOrder'];      
         $AttrList1=$this->Checkattributes($saveList[0]['Commencement_Date_Proj_AttrId'],$saveList[0]['Regionid'],$AttArr);
          $AttrList2=$this->Checkattributes($saveList[0]['Expiration_Date_Proj_AttriId'],$saveList[0]['Regionid'],$AttArr);
          $AttrList3=$this->Checkattributes($saveList[0]['Base_Rent_Initial_amount_Proj_AttriId'],$saveList[0]['Regionid'],$AttArr);
          $AttrList4=$this->Checkattributes($saveList[0]['Rent_Inc_Proj_AttrId'],$saveList[0]['Regionid'],$AttArr);
        $this->set('Attr1', $AttrList1); 
        $this->set('Attr2', $AttrList2);
        $this->set('Attr3', $AttrList3);
        $this->set('Attr4', $AttrList4);
        
         }
       
        
         
          $AttrListarr =  $connection->execute("SELECT * FROM RentCalc_Config WHERE RecordStatus = '1'")->fetchAll('assoc');
         
          $AttrList=array();
          foreach($AttrListarr as $key => $val):
          $Pro_id=$val['ProjectId'];       
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $Pro_id]);      
        $AttArr = $JsonArray['AttributeOrder']; 
        $Proname = $JsonArray[$Pro_id]; 
       
        
        $AttrList[] =array(
            'Id'=>$val['Id'],
            'ProjectId'=>$Proname,
             'Commencement_Date_Proj_AttrId'=>$AttArr[$val['Regionid']][$val['Commencement_Date_Proj_AttrId']]['DisplayAttributeName'],
             'Expiration_Date_Proj_AttriId'=>$AttArr[$val['Regionid']][$val['Expiration_Date_Proj_AttriId']]['DisplayAttributeName'],
             'Base_Rent_Initial_amount_Proj_AttriId'=>$AttArr[$val['Regionid']][$val['Base_Rent_Initial_amount_Proj_AttriId']]['DisplayAttributeName'],
             'Rent_Inc_Proj_AttrId'=>$AttArr[$val['Regionid']][$val['Rent_Inc_Proj_AttrId']]['DisplayAttributeName']
            );

        
          endforeach;
         //pr($AttrList);exit;
          //count($AttrList);exit;
          $this->set('AttrList', $AttrList);
         
         
      
         if (isset($this->request->data['ProjectId'])) {
                 return $this->redirect(['action' => 'index']);
         }
        
        
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

        $connection2 = ConnectionManager::get('d2k');
        $UserRoleList = $connection2->execute("select RoleMaster.Id,RoleMaster.Name from RoleMaster as RoleMaster INNER JOIN D2K_ProjectRoleMapping as D2K_ProjectRoleMapping on RoleMaster.Id = D2K_ProjectRoleMapping.RoleId where D2K_ProjectRoleMapping.ProjectId = $ProjectId")->fetchAll('assoc');
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
    function ajaxdata(){
        $ProjectId= $_POST['ProId'];
       // $ProjectId= 3346;
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $AttArr = $JsonArray['AttributeOrder'];
        $region=$JsonArray['RegionList'];
        foreach($region as $key => $val){
            $RegionId=$key;
        }
        
       
        $AttrListFinal ='<select name="attribute[]" id="attribute"  class="form-control" ><option value=0>--Select--</option>';
        
        foreach ($AttArr[$RegionId] as $key => $values):
           $AttrListFinal.='<option value='.$values['ProjectAttributeId'].'>'.$values['DisplayAttributeName'].'</option>';
           // $AttrListFinal[$values['AttributeId']] = $values['DisplayAttributeName'];
        endforeach;
        $AttrListFinal.="</select>";
        echo $AttrListFinal;
        exit;
        
        
    }
    
    function ajaxdataregion(){
        $ProjectId= $_POST['ProId'];
         // $ProjectId= 3346;
        $JsonArray = $this->GetJob->find('getjob', ['ProjectId' => $ProjectId]);
        $AttArr = $JsonArray['AttributeOrder'];
        $region=$JsonArray['RegionList'];
        foreach($region as $key => $val){
            $RegionId=$key;
        }
      
        echo "<input type='hidden' name='RegionId' id='RegionId' value=".$RegionId.">";
        exit;
    }
    function Checkattributes($AttrId,$RegId,$Attarray){
         $Attr='<select name="attribute[]" id="attribute" class="form-control "><option value="0" selected="selected">--Select Project--</option>';
   
    foreach ($Attarray[$RegId] as $key => $values):
         
                $selected='';
                if($AttrId == $values['ProjectAttributeId']){
                  $selected ="selected";
                 }
           $Attr.='<option value='.$values['ProjectAttributeId'].' '.$selected.' >'.$values['DisplayAttributeName'].'</option>';
           // $AttrListFinal[$values['AttributeId']] = $values['DisplayAttributeName'];
        endforeach;
        $Attr.="</select>";
        return $Attr;
         }

}
