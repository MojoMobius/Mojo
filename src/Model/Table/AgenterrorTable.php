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

class AgenterrorTable extends Table {

    public function initialize(array $config) {
        $this->table('MV_QC_BatchMaster');
    }
 public function findCampaign(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if ($options['CampaignId'] != '') {
            $CampaignId = $options['CampaignId'];
        }
        //$call = 'getModule();getusergroupdetails(this.value);';
        $template = '';
        $template.='<select name="CampaignId" id="CampaignId" class="form-control" ><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $Campaign = $contentArr['AttributeGroupMasterDirect'];

            if (count($Campaign) == 1 && isset($options['SetIfOneRow'])) {
                $CampaignId = array_keys($Campaign)[0];
            }

            foreach ($Campaign as $key => $val):
                if ($key == $CampaignId) {
                    $selected = 'selected=' . $RegionId;
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
            $tableData.='<tr class="Heading"><th>Date</th><th>Project</th><th>Batch Name</th><th>Status</th><th>Batch Size</th><th>Sample Size</th><th>QC Completed</th><th>Pending</th><th>Final AOQ</th>';
            
        $tableData.= '</tr>';
        $tableData.='</thead>';

       
        $totcount=count($options['condition']);
        for($i=0;$i<$totcount;$i++){
	    //pr($input);exit;
            $tableData .= '<tbody>';
            $IDValue = $input['Id'];
            $statusName = $status_list[$input['StatusId']];
            $showDataRow = false;
            
                $tableData.='<tr><td>' . $input['CreatedDate'] . '</td>';
                $tableData.='<td>' . $contentArr[$input['ProjectId']] . '</td>';
                $tableData.='<td>' . $input['BatchName'] . '</td>';
                $tableData.='<td>' . $input['StatusId'] . '</td>';
                $tableData.='<td>' . $input['EntityCount'] . '</td>';
				$tableData.='<td>' . $input['SampleCount'] . '</td>';
				$tableData.='<td>' . $input['QCCompletedCount'] . '</td>';
				$tableData.='<td>' . $qcpending . '</td>';
				$tableData.='<td>' . $input['aoq'] . '</td>';
                
                $tableData.='</tr>';
          
            $i++;
        }
        $tableData.='</tbody></table>';
        //echo 'jai'.$tableData;
        //exit;
        return $tableData;
    }
  
}
