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
class QctlrebuttalTable extends Table {

    public function initialize(array $config) {
        $this->table('ME_InputInitiation');
        $this->primaryKey('Id');
        $this->addBehavior('Timestamp');
    }


    public function findModule(Query $query, array $options) {

        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $connection = ConnectionManager::get('default');
        
        
         $modulesArr = $connection->execute("SELECT ModuleId ,ModuleName FROM ME_Module_Level_Config where Project='$ProjectId' and modulegroup=2")->fetchAll('assoc');
        
        if ($options['ModuleId'] != '') {
            $ModuleId = $options['ModuleId'];
        }
       
      
        $template = '';
        $template = '<select name="ModuleId"  id="ModuleId" class="form-control"><option value=0>--Select--</option>';
        if (!empty($modulesArr)) {

            foreach ($modulesArr as $key => $value) {
             
                if ($value['ModuleId'] == $ModuleId) {
                    $selected = 'selected=' . $value['ModuleId'];
                } else {
                    $selected = '';
                }
                $template.='<option ' . $selected . ' value="' . $value['ModuleId'] . '">';
                $template.=$value['ModuleName'];
                $template.='</option>';
            }
            $template.='</select>';
            return $template;
            
        } else {
            $template.='</select>';
            return $template;
        }
    }
    
    
}
