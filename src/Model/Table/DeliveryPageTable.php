<?php

/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * Requirement : REQ-003
 * Form : ProductionFieldsMapping
 * Developer: Jaishalini R
 * Created On: Nov 12 2015
 */

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Datasource\ConnectionManager;

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class DeliveryPageTable extends Table {

    public function initialize(array $config) {
        $this->table('ProductionEntityMaster');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

//    public function findRegion(Query $query, array $options){
//        $path=JSONPATH.'\\ProjectConfig_'.$options['ProjectId'].'.json'; 
//        $content=  file_get_contents($path);
//        $contentArr=  json_decode($content,true);
//        $region=$contentArr['RegionList'];$template='';
//        $template='<select name="Region" id="Region" class="form-control"><option value=0>--Select--</option>';
//        foreach ($region as $key=>$val):
//            $template.='<option value="'.$key.'" >';
//            $template.=$val;
//            $template.='</option>';
//        endforeach;
//        return $template;
//    }

    public function findRegion(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';

        if ($options['RegionId'] != '') {
            $RegionId = $options['RegionId'];
        }
        $call = 'getModule();';
        $template = '';
        $template.='<select name="RegionId" id="RegionId"  class="form-control" style="margin-top:17px;" onchange="getusergroupdetails(this.value);"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $region = $contentArr['RegionList'];

            if (count($region) == 1 && isset($options['SetIfOneRow'])) {
                $RegionId = array_keys($region)[0];
            }

            foreach ($region as $key => $val):
                if ($key == $RegionId) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $key . '" >';
                $template.=$val;
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    public function findModule(Query $query, array $options) {

        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];

        if ($options['ModuleId'] != '') {
            $ModuleId = $options['ModuleId'];
        }
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $call = 'getAttributeids();';
        $template = '';
        $template = '<select name="ModuleId"  id="ModuleId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $module = $contentArr['Module'];
            $modulesConfig = $contentArr['ModuleConfig'];
            $modulesArr = array();
            foreach ($module as $key => $val) {
                if (($modulesConfig[$key]['IsAllowedToDisplay'] == 1) && ($modulesConfig[$key]['IsModuleGroup'] == 1)) {
                    $modulesArr[$key] = $val;
                }
            }
            //$modulesArr[0] = '--Select--';
            ksort($modulesArr);
            foreach ($modulesArr as $key => $value) {
                if ($key == $ModuleId) {
                    $selected = 'selected=' . $ModuleId;
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $key . '">';
                $template.=$value;
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    public function findFilelist(Query $query, array $options) {
        $files = scandir(INPUTPATH);
        foreach ($files as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (!is_dir(INPUTPATH . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = $value;
                }
            }
        }
        $template = '<select name="FileName" id="FileName" class="form-control" ><option value=0>--Select--</option>';
        foreach ($result as $val):
            $template.='<option value="' . $val . '" >';
            $template.=$val;
            $template.='</option>';

        endforeach;
        return $template;
    }

    function findUsergroupdetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserId = $options['UserId'];

        if ($options['UserGroupId'] != '') {
            $UserGroupId = $options['UserGroupId'];
        }

        $connection = ConnectionManager::get('default');
        $queries = $connection->execute("select UGMapping.UserGroupId,UGMaster.GroupName from MV_UserGroupMapping as UGMapping INNER JOIN MV_UserGroupMaster as UGMaster ON UGMapping.UserGroupId = UGMaster.Id"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserId = " . $UserId . " AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
        $queries = $queries->fetchAll('assoc');
        $template = '';
        $template.='<select name="UserGroupId" id="UserGroupId"  class="form-control" style="margin-top:17px;"  onchange="getresourcedetails()">';
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                if ($key == $UserGroupId) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $val['UserGroupId'] . '" >';
                $template.=$val['GroupName'];
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    function findResourcedetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];

        if ($options['UserId'] != '') {
            $UserId = $options['UserId'];
        }

        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];

        $connection = ConnectionManager::get('default');

//        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
//                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 GROUP BY UGMapping.UserId");
//        $queries = $queries->fetchAll('assoc');

        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 3 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');

        $template = '';
        $template.='<select multiple=true name="user_id[]" id="user_id"  class="form-control" style="height:100px;width:150px">';
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                if ($key == $UserId) {
                    $selected = '';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $val['UserId'] . '" >';
                $template.= $user_list[$val['UserId']];
                $template.='</option>';
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }

    function findResourceDetailsArrayOnly(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];

        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];

        $connection = ConnectionManager::get('default');
//        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
//                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 GROUP BY UGMapping.UserId");
        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId = " . $ProjectId . " AND ModuleId = 3 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId");
        $queries = $queries->fetchAll('assoc');
        $template = array();
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                $template[$val['UserId']] = $user_list[$val['UserId']];
            endforeach;
        }
        return $template;
    }

    public function findStatus(Query $query, array $options) {

        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $modStatus = $contentArr['ProjectStatus'];
        $template = '<select name="InputToStatus" id="InputToStatus" class="form-control" ><option value=0>--Select--</option>';
        $status[0] = '--Select--';
        if ($options['importType'] == 1) {
            foreach ($modStatus as $key => $val) {
                // foreach($module as $key=>$val){
                $template.='<option value="' . $key . '" >';
                $template.=$val;
                $template.='</option>';
                //}
            }
        }
        return $template;
    }

    public function findGetdetail(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $status = array();
            $modStatus = $contentArr['ProjectStatus'];
            foreach ($modStatus as $key => $val) {
                //foreach($module as $key=>$val){
                $status[$key] = $val;
                // }
            }
            $detail['Status'] = $status;
            $detail['Region'] = $contentArr['RegionList'];
            return $detail;
        }
    }
 public function findClient(Query $query, array $options) {

        $ClientId = $options['ClientId'];
        $connection = ConnectionManager::get('default');
        
        
         $modulesArr = $connection->execute("select Id,ClientName FROM ClientMaster where Id='$ClientId'")->fetchAll('assoc');
        
       
      
        $template = '';
        $template = '<select name="ClientId"  id="ClientId" class="form-control" onchange="getProject(this.value)"><option value=0>--Select--</option>';
        if (!empty($modulesArr)) {

            foreach ($modulesArr as $key => $value) {
             
                if ($value['Id'] == $ClientId) {
                    $selected = 'selected=' . $value['Id'];
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $value['Id'] . '">';
                $template.=$value['ClientName'];
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
            
        } else {
            $template.='</select>';
            return $template;
        }
    }
	public function findajaxProjectNameList(Query $query, array $options) {
         $proId = $options['proId'];
         $ClientId = $options['ClientId']; 
		 $RegionId = $options['RegionId'];
        $clientCheck="";
        if($ClientId > 0){
        $clientCheck="client_id ='".$ClientId."' and ";    
        }
         $test = implode(',', $options['proId']);
        $connection = ConnectionManager::get('default');
        
        
         $modulesArr =  $connection->execute('select ProjectName,ProjectId from ProjectMaster where '.$clientCheck.' ProjectId in (' . $test . ') AND RecordStatus = 1');
        
       
      
        $template = '';
        $template = '<select name="ProjectId"  id="ProjectId" class="form-control" onchange="getusergroupdetails('.$RegionId.');getModule(this.value);"><option value=0>--Select--</option>';
        if (!empty($modulesArr)) {

            foreach ($modulesArr as $key => $value) {             
               
                $template.='<option  value="' . $value['ProjectId'] . '">';
                $template.=$value['ProjectName'];
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
            
        } else {
            $template.='</select>';
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

}
