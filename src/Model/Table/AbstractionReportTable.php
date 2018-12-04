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
class AbstractionReportTable extends Table {

    public function initialize(array $config) {
        $this->table('ME_UserQuery');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }

    function findExport(Query $query, array $options) {
//      echo "<pre>sd";   print_r($options); 

        $ProjectId = $options['ProjectId'];

        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        $content = file_get_contents($path);
        $contentArr = json_decode($content, true);
        $module = $contentArr['Module'];
        $moduleConfig = $contentArr['ModuleConfig'];
        $AttributeGroupMaster = $contentArr['AttributeGroupMasterDirect'];
        $AttributeSubGroupMaster = $contentArr['AttributeSubGroupMaster'];

//       echo "<pre>s"; print_r($contentArr);
//       echo "<pre>s"; print_r($ProjectId);
//pr($options['condition']); exit;

        $i = 1;
        
         
        $j = count($options['condition']);
        
        foreach ($options['condition'] as $inputKey => $input):
            $tableData .= '<table border="1" style="margin-top:10px;"><thead>';
            // main head values 
            $tableData.='<tr class="Heading" >';
            $tableData.='<th colspan="4" style="background-color: #CED1CF;">' . $AttributeGroupMaster[$inputKey] . '</th>';
            $tableData.= '</tr>';
            $tableData.='</thead>';
		$odd=1;$even=0;
            foreach ($input['main'] as $subkey => $subval):
                $n = round(count($subval) / 2);
                for ($k = 0; $k < $n; $k++) {
                    $tableData.='<tr>';
                    $tableData .= '<tbody>';
                    $tableData.='<td >' . $subval[$even]['DisplayAttributeName'] . '</td>';

                    
                    $tableData.='<td style="border: 1px solid"><table><tr>';
                    if($subval[$even]['DisplayAttributeName']=='Lease ID')
                        $seqcnt=1;
                    $seqcnt = $subval[$even]['seqcnt'];
                    $subseqcnt = $even;
                    for ($ksub = 0; $ksub < $seqcnt; $ksub++) {
                        if(!empty($subval[$subseqcnt]['res'][$ksub])){
                            $tableData.='<td style="border-right: 1px solid">'. $subval[$subseqcnt]['res'][$ksub] . '</td>';
                        }else{
                             $tableData.='<td></td>';
                        }
                              
                    }
                    $tableData.= '</tr></table></td>';
                    $tableData.='<td >' . $subval[$odd]['DisplayAttributeName'] . '</td>';
                    $tableData.='<td style="border: 1px solid"><table><tr>';
                    if($subval[$odd]['DisplayAttributeName']=='Lease ID')
                        $seqcnt=1;
                    $seqcnt = $subval[$odd]['seqcnt'];
                    $subseqcnt = $odd;
                    for ($ksub = 0; $ksub < $seqcnt; $ksub++) {
                        if(!empty($subval[$subseqcnt]['res'][$ksub])){
                             $tableData.='<td style="border-right: 1px solid">' . $subval[$subseqcnt]['res'][$ksub] . '</td>';
                        }else{
                             $tableData.='<td></td>';
                        }
                            
                    }
                    $tableData.= '</tr></table></td>';
                    $tableData .= '</tbody>';
                    $tableData.='</tr>';
					$odd+=2;
					$even+=2;
                }
            endforeach;
            // sub header 
			//pr($input['sub']);
            foreach ($input['sub'] as $subheadkey => $subheadval):
               // pr($subheadval); //exit;
			       $tableData.='<tr>';
                    $tableData .= '<tbody>';
                    $tableData.='<td style="background-color:#E8F1B9;">' .  $AttributeSubGroupMaster[$inputKey][$subheadkey] . '</td>';
                    $tableData.='<td style="border: 1px solid"></td><td ></td><td ></td></tbody></tr>';
                   
                    
                $n = round(count($subheadval) / 2);
				$before = round(count($subheadval));
				$odd=1;$even=0;
                $seqcnt = $subheadval[0]['seqcnt'];
                                for ($ksub = 0; $ksub < $seqcnt; $ksub++) {	
                                    $odd=1;$even=0;
                for ($k = 0; $k < $n; $k++) {
		
               // $odd=1;$even=0;
                    
                        if($subheadval[$even]['DisplayAttributeName']!=''){
                    $tableData.='<tr>';
                    $tableData .= '<tbody>';
                    $tableData.='<td>' . $subheadval[$even]['DisplayAttributeName'] . '</td>';
//                    $tableData.='<td >' . round($n - $k) . '</td>';
                    
                    
                    
                    $subseqcnt = $even;
                   
                        if(!empty($subheadval[$subseqcnt]['res'][$ksub])){
                             $tableData.='<td style="border-right: 1px solid">'. $subheadval[$subseqcnt]['res'][$ksub] . '</td>';
                        }else{
                             $tableData.='<td></td>';
                        }
                   
                   
                    
                    $tableData.='<td >' . $subheadval[$odd]['DisplayAttributeName'] . '</td>';
                  
                    //$tableData.='<td style="border: 1px solid">';
                    //$seqcnt = $subheadval[$odd]['seqcnt'];
                    $subseqcnt = $odd;
                    
                         if(!empty($subheadval[$subseqcnt]['res'][$ksub])){
                             $tableData.='<td style="border-right: 1px solid">' . $subheadval[$subseqcnt]['res'][$ksub] . '</td>';
                        }else{
                             $tableData.='<td></td>';
                        }
                            
                   // }
                   
                    
                    $tableData .= '</tbody>';
                    $tableData.='</tr>';
					$odd+=2;
					$even+=2;
                        }
					
                }
                $tableData.='<tr><td colspan="4"></td></tr>';
                }		
            endforeach;
            //exit;
            $tableData.='</table>  </td></tr><tr><td colspan="2"></td></tr></table>';
            
            
            if($i < $j){
                $tableData.='<table ><tr><td></td><td>';
                $tableData.=' <table border="1" style="margin-top:10px;"><thead>';
            }
            
            $i++;
            $tableData.='</table> ';
        endforeach;
//exit;
         

        echo $tableData;
        //exit;

        return $tableData;
 
    }

}
