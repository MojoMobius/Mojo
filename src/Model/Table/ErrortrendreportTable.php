<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\DateTime;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Hash;

class ErrortrendreportTable extends Table {

    public function initialize(array $config) {
        $this->table('MV_QC_BatchMaster');
    }
    public function findCampaign(Query $query, array $options) {
       
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if ($options['CampaignId'] != '') {
            $postCampaignId = $options['CampaignId'];
        }
      //  pr($options['ProjectId']);exit;
        //$call = 'getModule();getusergroupdetails(this.value);';
        $template = '';
        $template.='<select name="CampaignId[]" id="CampaignId" class="form-control" multiple="multiple" style ="height:100px;" >';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $Campaign = $contentArr['AttributeGroupMasterDirect'];

            if (count($Campaign) == 1 && isset($options['SetIfOneRow'])) {
                $CampaignId = array_keys($Campaign)[0];
            }
            $i=0;
           
            foreach ($Campaign as $key => $val):
               
                if (in_array($key,$postCampaignId)) {                   
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
 
	function findExport(Query $query, array $options) {
        // pr($options); 
            $ProjectId = $options['ProjectId'];           
            $tableData = '<table border=1>  <thead>';
            $tableData.='<tr class="Heading"><th>PROJECT</th><th>CAMPAIGN</th><th>ERRORS</th><th>COUNT</th><th>PERCENTAGE</th>';
            
        $tableData.= '</tr>';
        $tableData.='</thead>';

       
  $totcount=count($options['v_project']);
  for($i=0;$i < $totcount;$i++){
	    //pr($input);exit;
            $tableData .= '<tbody>';         
                $tableData.='<tr><td>' . $options['v_project'][$i] . '</td>';
                $tableData.='<td>' . $options['v_campaign'][$i] . '</td>';
                $tableData.='<td>' . $options['v_error'][$i] . '</td>';
                $tableData.='<td>' . $options['v_totalcount'][$i] . '</td>';
                $tableData.='<td>' . $options['v_percentage'][$i] . '</td>';
                
                $tableData.='</tr>';
          
            $i++;
        }
        $tableData.='</tbody></table>';
        //echo 'jai'.$tableData;
        //exit;
        return $tableData;
    }
  
}
