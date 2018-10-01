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
class QualityReportTable extends Table {

    public function initialize(array $config) {
        $this->table('ME_UserQuery');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    
    function findResourceDetailsArrayOnly(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];

     

        $connection = ConnectionManager::get('default');

        $ProjectIds = implode(',',$ProjectId);
        $queries = $connection->execute("select UGMapping.UserId,UGMapping.ProjectId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId IN ($ProjectIds) AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId  IN ($ProjectIds) AND ModuleId = 3 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId,UGMapping.ProjectId");
        $queries = $queries->fetchAll('assoc');
        $template = array();
        if (!empty($queries)) {
            foreach ($queries as $key => $val):
                $path = JSONPATH . '\\ProjectConfig_' . $val['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
                
        $template[$key]['UserId'] = $val['UserId'];
        $template[$key][$val['UserId']] = $user_list[$val['UserId']];
        $template[$key]['ProjectId'] = $val['ProjectId'];
        
//                $template[$val['UserId']] = $user_list[$val['UserId']];
//                $template[$val['UserId']] = $user_list[$val['UserId']];
            endforeach;
        }
        return $template;
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
        
        
         $modulesArr =  $connection->execute('select ProjectName,ProjectId from ProjectMaster where '.$clientCheck.' ProjectId in (' . $test . ') AND RecordStatus = 1')->fetchAll('assoc');
		 
			 $i=0;
			 $Strpro='';
			 foreach($modulesArr as $val) { 
			 if($i > 0){
				$Strpro.=','; 
			 }
			 $Strpro.= $val['ProjectId'];
			 $i++;
			 }
      
        $template = '';
        $template = '<select name="ProjectId[]" multiple="multiple" id="ProjectId" class="form-control" onchange="getusergroupdetails('.$RegionId.');getStatus(this.value);">';
        if (!empty($modulesArr)) {
			 $template.='<option  value="' . $Strpro . '">All</option>';
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
    
    function findResourcedetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserGroupId = $options['UserGroupId'];
        //print_r($_POST['user_id']);exit;
        $ProjectIds = implode(",", $ProjectId);

        if ($options['UserId'] != '') {
            $UserId = $options['UserId'];
        }

      

        $connection = ConnectionManager::get('default');

//        $queries = $connection->execute("select UGMapping.UserId from MV_UserGroupMapping as UGMapping"
//                . " where UGMapping.ProjectId = " . $ProjectId . " AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 GROUP BY UGMapping.UserId");
//        $queries = $queries->fetchAll('assoc');

        $queries = $connection->execute("select UGMapping.UserId,UGMapping.ProjectId from MV_UserGroupMapping as UGMapping"
                . " where UGMapping.ProjectId IN ($ProjectIds) AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserGroupId IN (" . $UserGroupId . ") AND UGMapping.RecordStatus = 1 AND UGMapping.UserRoleId IN ("
                . " SELECT Split.a.value('.', 'VARCHAR(100)') AS String  
                   FROM (SELECT CAST('<M>' + REPLACE([RoleId], ',', '</M><M>') + '</M>' AS XML) AS String  
                        FROM ME_ProjectRoleMapping where ProjectId IN ($ProjectIds) AND ModuleId = 3 AND RecordStatus = 1) AS A CROSS APPLY String.nodes ('/M') AS Split(a)"
                . ") GROUP BY UGMapping.UserId,UGMapping.ProjectId order by UGMapping.ProjectId");
        $queries = $queries->fetchAll('assoc');
        $template = '';
        $template.='<select multiple=true name="user_id[]" id="user_id"  class="form-control" style="height:100px;width:150px">';
        if (!empty($queries)) {
         $UniqueUser=array();
		 $i=0;
		// print_r($UserId);
		 
		// print_r($queries);exit;
		 
            foreach ($queries as $key => $val):
			if (!in_array($val['UserId'], $UniqueUser)){
			$UniqueUser[]=$val['UserId'];
                
        $path = JSONPATH . '\\ProjectConfig_' . $val['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $user_list = $contentArr['UserList'];
        
                if ($val['UserId'] == $UserId[$i]) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $val['UserId'] . '" >';
                $template.= $user_list[$val['UserId']];
                $template.='</option>';
			}//if end
			$i++;
            endforeach;
            $template.='</select>';
            return $template;
        } else {
            $template.='</select>';
            return $template;
        }
    }
    
    function findUsergroupdetails(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $UserId = $options['UserId'];

        if ($options['UserGroupId'] != '') {
            $UserGroupId = $options['UserGroupId'];
        }

        $ProjectIds = implode(",", $ProjectId);
        
        $connection = ConnectionManager::get('default');
	
        $queries = $connection->execute("select UGMapping.UserGroupId,UGMaster.GroupName from MV_UserGroupMapping as UGMapping INNER JOIN MV_UserGroupMaster as UGMaster ON UGMapping.UserGroupId = UGMaster.Id"
                . " where UGMapping.ProjectId IN ($ProjectIds) AND UGMapping.RegionId = " . $RegionId . " AND UGMapping.UserId = " . $UserId . " AND UGMapping.RecordStatus = 1 AND UGMaster.RecordStatus = 1 GROUP BY UGMapping.UserGroupId,UGMaster.GroupName");
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
    
    public function findModule(Query $query, array $options) {

        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];

        if ($options['ModuleId'] != '') {
            $ModuleId = $options['ModuleId'];
        }
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        $call = 'getusergroupdetails();getresourcedetails();';
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

    function findExport(Query $query, array $options) {
		$tHead="";
	 foreach($result[$Headkey]['CommentHead'] as $head){ 
																			
         $tHead.="<th>".$head." Comments</th>";
		 $tHead.="<th>".$head." Percentage</th>";
										
		}
	
        $ProjectId = $options['ProjectId'];

        $tableData = '<table border=1><thead>';
        $tableData.='<tr class="Heading">'
                . '<th>S No</th><th>Client</th><th>Project</th>'
                . '<th>Date</th><th>LeaseId</th>'.$tHead.'<th>Overall Percentage</th>';
        $tableData.= '</tr>';
        $tableData.='</thead>';
        $i = 1;

        foreach ($options['result'] as $inputVal => $input):
		
            $tableData .= '<tbody>';
            $tableData.='<tr><td>' . $i . '</td>';
            $tableData.='<td>' . $input['Client'] . '</td>';
            $tableData.='<td>' . $input['project_name'] . '</td>';
            $tableData.='<td>' . $input['date'] . '</td>';
            $tableData.='<td>' . $input['leaseId'] . '</td>';
            $tableData.='<td>' . $input['numberofjobs'] . '</td>';
            $tableData.='<td>' . $input['fdrid'] . '</td>';
			$total_percent=array();
			foreach($result[$Headkey]['CommentHead'] as $keyhead => $head){
			$total_percent[]= count($val['comments'][$keyhead][$key1]);
			$cnt= count($val['comments'][$keyhead][$key1]);
			$com_percentage= 1 - ( $cnt / $val['totalAttributes']) ;
		    $ModulePercentage=  number_format((float)$com_percentage, 2, '.', '');
			
			
			  $tableData.='<td>';
					foreach($val['comments'][$keyhead][$key1] as $valcomments){
					 $tableData.='<p>'.$valcomments.'</p>';
					} 
				  $tableData.='</td>';
			  $tableData.='<td>'.$ModulePercentage.'</td>';
				
				$tableData.='</td>';
				  
			}
			$totalcnt=array_sum($total_percent);
			$tot_perc= 1 -( $totalcnt / $val['totalAttributes']) ;
			$TotPercent= number_format((float)$tot_perc, 2, '.', '');
			
            $tableData.='<td>' . $TotPercent . '</td>';

            $tableData.='</tr>';

            $i++;
        endforeach;
        $tableData.='</tbody></table>';
        return $tableData;
    }

}
