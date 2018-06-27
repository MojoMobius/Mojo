<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class ADMVReportController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index() {

        $session = $this->request->session();
        $user_id = $session->read('user_id');
    $connection = ConnectionManager::get('default');
        if ($this->request->is('post')) {
//            pr($this->request->data);
//            exit;
            $ProjectId = $this->request->data('ProjectId');
            $month = $this->request->data('month');
            $year = $this->request->data('year');
           
                  $dt = $month.'_'.$year;
          
                
                  $conditions  =  "month(ProductionStartDate) ='" . $month . "' AND year(ProductionStartDate) ='" . $year . "'";
                  $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $moduleId = $connection->execute("select ModuleId from ME_Module_Level_Config where modulegroup =1 and Project = $ProjectId")->fetchAll('assoc');
        $moduleId = $moduleId[0]['ModuleId'];
        $Regionid = $contentArr['RegionList'];
        $Regionid = array_keys($Regionid);
        $Regionid = $Regionid[0];
        $ProductionFields = $contentArr['ModuleAttributes'][$Regionid][$moduleId]['production'];
        $AttributeGroupMaster = $contentArr['AttributeGroupMasterDirect'];
            $groupwisearray = array();
            $subgroupwisearray = array();
            foreach ($AttributeGroupMaster as $key => $value) {
            //    $groupwisearray[] = $value;
                $keys = array_map(function($v) use ($key, $emparr) {
                    if ($v['MainGroupId'] == $key) {
                        return $v;
                    }
                }, $ProductionFields);
                $keys_sub = $this->combineBySubGroup($keys);
                $groupwisearray[] = $keys_sub;
            }
            $n = 0;
            $firstValue = array();
            foreach ($AttributeGroupMaster as $key => $value) {
                foreach ($groupwisearray[$key] as $keysub => $valuesSub) {
                    $firstValue[$n] = $valuesSub[0];
                    $n++;
                }
            }
          
        $subattrList= array();
        $finalarray=array();
        $arrtlist=array();
        foreach ($AttributeGroupMaster as $key => $val){
            $subattrList[] = $contentArr['AttributeSubGroupMaster'][$key];
        }
   
    $i=0;
         foreach ($subattrList as $key => $val){
             foreach ($val as $keys => $vals){
             $finalarray[$keys]= $groupwisearray[$i][$keys];
         }
         $i++;
         }
 
                     foreach ($finalarray as $key => $val){
                  foreach ($val as $keys => $value){
                $arrtlist[$key][] = $value['AttributeMasterId'];  
                }
            }
   
            $select_fields_sel = [];
            $select_fields_exists =[];
                    $select_fields_exists_group =[];
                $test = [];    
           
     foreach($arrtlist as $key => $value){
         foreach($value as $val){
             $select_fields_sel = "'$val'";
             $queriesFieldFind = $connection->execute("select name as select_fields_name FROM sys.columns WHERE name in (N$select_fields_sel) AND object_id = OBJECT_ID(N'Report_ProductionEntityMaster_" . $dt . "')");
                    $queriesFieldFind = $queriesFieldFind->fetchAll('assoc');
                    $reportListfinal = [];
                    foreach ($queriesFieldFind as $select_fields_ex){
                        $vals_exist = '['.$select_fields_ex['select_fields_name'].']';
                        $select_fields_exists_group = '['.$select_fields_ex['select_fields_name'].']';
                        $select_fields_exists = "REPLACE(REPLACE(".$vals_exist.",CHAR(13),' '),CHAR(10),' ') as ".$vals_exist."";
                        $display_fields[] = $select_fields_ex['select_fields_name'];
                           $reportList = $connection->execute("Select count(".$select_fields_exists_group.") as cnt,$select_fields_exists_group as $select_fields_exists_group from Report_ProductionEntityMaster_" . $dt . " where $conditions and ProjectId ='".$ProjectId."'  and DependencyTypeMasterId=20  group by ".$select_fields_exists_group."");
                $reportList = $reportList->fetchAll('assoc');
               $this->set('select_fields_exists_group', $select_fields_exists_group);
               
               
                foreach($reportList as $keys => $vals){
                    foreach($ProductionFields as $item){
                    $SubGroupName = $contentArr['AttributeSubGroupMaster'][$item['MainGroupId']][$key];
                     if(($vals[$select_fields_ex['select_fields_name']] == '') || ($vals[$select_fields_ex['select_fields_name']] == null)){
                             
                         if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                         $test[$SubGroupName][$item['DisplayAttributeName']]['X'] = $vals['cnt'];
                    }
                    if($vals[$select_fields_ex['select_fields_name']] == 'A'){
                        if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                            $test[$SubGroupName][$item['DisplayAttributeName']]['A'] = $vals['cnt'];
                    }
                   if($vals[$select_fields_ex['select_fields_name']] == 'D'){
                       if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                          $test[$SubGroupName][$item['DisplayAttributeName']]['D'] = $vals['cnt'];
                    }
                   if($vals[$select_fields_ex['select_fields_name']] == 'M'){
                       if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                $test[$SubGroupName][$item['DisplayAttributeName']]['M'] = $vals['cnt'];
                    }
                    if($vals[$select_fields_ex['select_fields_name']] == 'V'){
                        if ($item['AttributeMasterId'] == $select_fields_ex['select_fields_name'])
                                $test[$SubGroupName][$item['DisplayAttributeName']]['V'] = $vals['cnt'];
                    }
                }
               }
                    }
         }
             
     }

      $this->set('test', $test);
  if (empty($test)) {
                $this->Flash->error(__('No Record found for this combination!'));
            }
        }

        $ProjectMaster = TableRegistry::get('Projectmaster');
        $ProList = $ProjectMaster->find();
      //  $UserGroupMapping = $this->UserGroupMapping->newEntity();
        $ProListopt = '';
        $call = 'getRegion(this.value); getUserList();';
        $ProListopt = '<select name="ProjectId" id="ProjectId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        foreach ($ProList as $query):
            $ProListopt.='<option value="' . $query->ProjectId . '">';
            $ProListopt.=$query->ProjectName;
            $ProListopt.='</option>';
        endforeach;
        $ProListopt.='</select>';
        $this->set(compact('ProListopt'));
        $this->set(compact('ProList'));
        $this->set(compact('UserGroupMapping'));

}
function combineBySubGroup($keysss) {
        $mainarr = array();
        foreach ($keysss as $key => $value) {
            if (!empty($value))
                $mainarr[$value['SubGroupId']][] = $value;
        }
        return $mainarr;
    }
}
