<?php

/**
 * Form : Stratification Rule Model
 * Developer: SyedIsmail N
 * Created On: Jul 07 2017
 * class to get Input status of a file
 */
 
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use App\Model\Entity\User;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;

class StratificationRuleTable extends Table {

    public function initialize(array $config) {
        $this->table('ProjectAttributeMaster');
        $this->primaryKey('Id');
    }

    public static function defaultConnectionName() {
        return 'd2k';
    }
    public function findRegion(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $region = $contentArr['RegionList'];
        if($options['RegionId']!=''){
           $RegionId = $options['RegionId'];
        }
        $call='getModule();getAttributeids();';
        $template = '';
        if(count($region)==1) { $RegionId = array_keys($region)[0]; } else { $RegionId = 0; }
        $template = '<select name="Region" id="Region" class="form-control" onchange="'.$call.'"><option value=0>--Select--</option>';
        foreach ($region as $key => $val):
            if ($key == $RegionId) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $template.='<option ' . $selected . ' value="' . $key . '" >';
            $template.=$val;
            $template.='</option></select>';
        endforeach;
        return $template;
    }
    
    public function findModule(Query $query, array $options){
        $ProjectId = $options['ProjectId'];
        
        if($options['ProcessId']!=''){
            $ProcessId = $options['ProcessId'];
        }
        if($options['ModuleId']!=''){
           $ModuleId = $options['ModuleId'];
        }
        $path=JSONPATH.'\\ProjectConfig_'.$ProjectId.'.json';
        $call='getAttributeids(this.value)';
        $template='';
        $template='<select name="ModuleId" id="ModuleId" class="form-control" onchange="'.$call.'"><option value=0>--Select--</option>';
        if(file_exists($path)) {
            $content=  file_get_contents($path);
            $contentArr=  json_decode($content,true);
            $module=$contentArr['Module'];
            $ModuleConfig=$contentArr['ModuleConfig'];
            foreach ($ModuleConfig as $Modkey => $Modvalue) {
                if($Modvalue['IsModuleGroup']==1){
//                foreach ($module as $key => $value) {
                    if($Modkey == $ModuleId){
                        $selected = 'selected='.$ModuleId;
                    }elseif($Modkey == $ProcessId){
                        $selected = 'selected='.$ProcessId;
                    }else{
                        $selected = '';
                    }
                
                $template.='<option '.$selected.' value="'.$Modkey.'">';
                $template.=$module[$Modkey];
//                $template.='<option '.$selected.' value="'.$key.'">';
//                $template.=$value;
                $template.='</option>';
//                }
                }
            }
            $template.='</select>';
            return $template;
        }else{
            $template.='</select>';
            return $template;
        }
    }
    
    function findAttributeids(Query $query, array $options) {
  
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ModuleId = $options['ModuleId'];
        $AttributeMasId = $options['AttributeMasterId'];
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $i = 0;
        $template = '';
        $module = $contentArr['ModuleAttributes'][$RegionId][$ModuleId];
        if ($module != '') {
            $template.='<option value="0">--Select--</option>';
            $module1 = $contentArr['ModuleAttributes'][$RegionId][$ModuleId]['production'];
            $j=0;
            foreach ($module1 as $val) {
                if($val['ControlName']=='DropDownList') {
                    $opval = $val['ProjectAttributeMasterId'] . '_' . $val['AttributeMasterId'];
                    $diffarr = array_intersect(array($opval),$AttributeMasId);
                    $selected='';
                    if ($diffarr[0]!='') {
                            $selected = 'selected='.$opval;
                            $seleId = "id=LoadAttributeids$j";
                            $seleName = "name=LoadAttributeids[]";
                        } else {
                            $selected = '';
                        }
                    $template.='<option '.$seleId.' '.$seleName.' '.$selected . ' value="' . $opval . '">' . $val['AttributeName'] . '</option>';
                    $j++;
               }
            }
            $template.='';
            return $template;
        } else {
            $template.='<option value=0>--Select--</option>';
            $template.='';
            return $template;
        }
    }

    public function findGetMojoProjectNameList(Query $query, array $options) {
        $proId = $options['proId'];
        $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        $Field = $connection->execute('select ProjectName,ProjectId from ProjectMaster where ProjectId in (' . $test . ') AND RecordStatus = 1');
        $Field = $Field->fetchAll('assoc');
        return $Field;
    }
    
    public function findGetdetail(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $status = array();
            $modStatus = $contentArr['ProjectStatus'];
            foreach ($modStatus as $key => $val) {
                $status[$key] = $val;
            }
            $detail['Status'] = $status;
            $detail['Region'] = $contentArr['RegionList'];
            $detail['Module'] = $contentArr['Module'];
            return $detail;
        }
    }
}
