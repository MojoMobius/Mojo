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
class ProjectleaseReportTable extends Table {

    public function initialize(array $config) {
        $this->table('ME_UserQuery');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
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
//      echo "<pre>sd";   print_r($options); 
//      exit;
        $ProjectId = $options['ProjectId'];
      
          $tableData = '<table border=1><thead>';
            $tableData.='<tr class="Heading"><th>S No</th><th>Project</th><th>Lease ID</th><th>No. of Documents</th><th>PDF Name</th><th>Status</th><th>On-Hold Comments</th><th>On-hold reported date</th><th>Client Responses</th><th>Client resolution date</th>';
        $tableData.= '</tr>';
        $tableData.='</thead>';
        $i = 1;
        foreach ($options['condition'] as $inputVal => $input):
	    //pr($input);exit;
            $tableData .= '<tbody>';
                $tableData.='<tr><td>' . $i . '</td>';
                $tableData.='<td>' . $input['ProjectName'] . '</td>';
                $tableData.='<td>' . $input['leaseid'] . '</td>';
                $tableData.='<td>' . $input['noofdocuments'] . '</td>';
                $tableData.='<td>' . $input['pdfname'] . '</td>';
				$tableData.='<td>' . $input['status'] . '</td>';
				$tableData.='<td>' . $input['holdcomments'] . '</td>';
				$tableData.='<td>' . $input['holdreportdate'] . '</td>';
				$tableData.='<td>' . $input['Client_Response'] . '</td>';
				$tableData.='<td>' . $input['Client_Response_Date'] . '</td>';
                
                $tableData.='</tr>';
        
            $i++;
        endforeach;
        $tableData.='</tbody></table>';
    
        return $tableData;
    }
    
    
    
    
    
}
