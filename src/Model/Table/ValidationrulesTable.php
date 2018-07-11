<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Query;
use Cake\Datasource\ConnectionManager;

class ValidationrulesTable extends Table {

    public function initialize(array $config) {
        $this->table('ME_ValidationRules');
        $this->primaryKey('Id');
    }

    public function findRegion(Query $query, array $options) {
        $path = JSONPATH . '\\ProjectConfig_' . $options['ProjectId'] . '.json';
        if ($options['RegionId'] != '') {
            $RegionId = $options['RegionId'];
        }
        //$call = 'getAttributes();';
        $call = 'getModule();';
        //$call = 'getAttributeids();getModule();';
        $template = '';
        $template.='<select name="RegionId" id="RegionId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $region = $contentArr['RegionList'];
            foreach ($region as $key => $val):
                if ($key == $RegionId) {
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

    public function findModule(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        if ($options['ModuleId'] != '') {
            $ModuleId = $options['ModuleId'];
        }
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        //$call = 'getDependencyatt();';
        $call = 'getAttributes();';
        $template = '';
        $template = '<select name="ModuleId" id="ModuleId" class="form-control" onchange="' . $call . '"><option value=0>--Select--</option>';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $module = $contentArr['Module'];
            foreach ($module as $key => $value) {
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

    function findAttribute(Query $query, array $options) {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ModuleId = $options['ModuleId'];
        $connection = ConnectionManager::get('default');
//        $MojoTemplate = $connection->execute("SELECT ProjectAttributeMasterId,IsMandatory,IsAlphabet,IsNumeric,IsEmail,IsUrl,IsDate,DateFormat,IsDecimal,AllowedDecimalPoint,
//            IsAutoSuggesstion,IsAllowNewValues,IsSpecialCharacter,AllowedCharacter,NotAllowedCharacter,Format,MaxLength,MinLength FROM ME_ValidationRules 
//            WHERE ME_ValidationRules.RecordStatus=1 AND ME_ValidationRules.ProjectId=$ProjectId AND ME_ValidationRules.RegionId=$RegionId AND ME_ValidationRules.ModuleId=$ModuleId");
        $MojoTemplate = $connection->execute("SELECT ProjectAttributeMasterId,IsMandatory,IsAlphabet,IsNumeric,IsEmail,IsUrl,IsDate,DateFormat,IsDecimal,AllowedDecimalPoint,
            IsAutoSuggesstion,IsAllowNewValues,IsSpecialCharacter,AllowedCharacter,NotAllowedCharacter,Format,MaxLength,MinLength FROM ME_ValidationRules 
            WHERE ME_ValidationRules.RecordStatus=1 AND ME_ValidationRules.ProjectId=$ProjectId AND ME_ValidationRules.RegionId=$RegionId");
        $mojoArr = $MojoTemplate->fetchAll('assoc');
        return $mojoArr;
    }
    
    function findAttributelist(Query $query, array $options)
    {
        $ProjectId = $options['ProjectId'];
        $RegionId = $options['RegionId'];
        $ModuleId = $options['ModuleId'];
        $path = JSONPATH . '\\ProjectConfig_' . $ProjectId . '.json';
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $contentArr = json_decode($content, true);
            $module_attributes = $contentArr['ModuleAttributes'][$RegionId][$ModuleId]['production'];
        }
//        echo '<pre>';
//        //print_r($module_attributes);
//        foreach ($module_attributes as $key => $mojo) {
//            print_r($mojo['DisplayAttributeName']);
//            print_r($mojo['ProjectAttributeMasterId']);
//            print_r($mojo['AttributeMasterId']);
//        }
//        exit;
        
        $MappedAttribute = $options['mappedattribute'];
//        $connection = ConnectionManager::get('d2k');
//        $MojoTemplate = $connection->execute("select AttributeMaster.Id,Region.ProjectAttributeId,PAM.DisplayAttributeName,AttributeMaster.ID from RegionAttributeMapping as Region INNER JOIN ProjectAttributeMaster as PAM ON PAM.Id=Region.ProjectAttributeId INNER JOIN AttributeMaster ON AttributeMaster.AttributeName=PAM.AttributeName where  Region.ProjectId=$ProjectId and RegionId='$RegionId'");
//        $MojoTemplates = $MojoTemplate->fetchAll('assoc');
        $templatenew ='';
        if(empty($module_attributes)!='1'){    
            $templatenew.='<div id="parent"><table id="fixTable" class="table"><thead><tr>';
            $templatenew.='<th>AttributeName</th>';
            $templatenew.='<th>IsMandatory</th>';
            $templatenew.='<th>IsAlphabet</th>';
            $templatenew.='<th>IsNumeric</th>';
            $templatenew.='<th>IsEmail</th>';
            $templatenew.='<th>IsUrl</th>';
            $templatenew.='<th>IsDate</th>';
            $templatenew.='<th>DateFormat</th>';
            $templatenew.='<th>IsDecimal</th>';
            $templatenew.='<th>AllowedDecimalPoint</th>';
            $templatenew.='<th>IsAutoSuggesstion</th>';
            $templatenew.='<th>IsAllowNewValues</th>';
            $templatenew.='<th>IsSpecialCharacter</th>';
            $templatenew.='<th>AllowedCharacter</th>';
            $templatenew.='<th>NotAllowedCharacter</th>';
            $templatenew.='<th>Format</th>';
            $templatenew.='<th>MaxLength</th>';
            $templatenew.='<th>MinLength</th>';
            $templatenew.='</tr></thead><tbody>';
            $i=0;
        //foreach ($MojoTemplates as $mojo){
        foreach ($module_attributes as $key => $mojo) {
            //AttributeName starts
            $templatenew.='<input type="hidden" name="AttributeName[]" value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'">';
            $templatenew.='<tr><td>'.$mojo['DisplayAttributeName'];
            $templatenew.='</td>';
            //AttributeName ends
            //IsMandatory starts
            if($MappedAttribute[$i]['IsMandatory']=='1')
                $checkedIsMand='checked=""';
            else
                $checkedIsMand='';
            $templatenew.='<td><input class="form-control" type="checkbox" name="IsMandatory[]" '.$checkedIsMand.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'"></td>';
            //IsMandatory ends
            //IsAlphabet starts
            if($MappedAttribute[$i]['IsAlphabet']=='1')
                $checkedIsAlph='checked=""';
            else
                $checkedIsAlph='';
            $templatenew.='<td><input class="form-control" type="checkbox" id="IsAlphabet_'.$mojo['AttributeMasterId'].'" name="IsAlphabet[]" '.$checkedIsAlph.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'"></td>';
            //IsAlphabet ends
            //IsNumeric starts
            if($MappedAttribute[$i]['IsNumeric']=='1')
                $checkedIsNum='checked=""';
            else
                $checkedIsNum='';
            $templatenew.='<td><input class="form-control" type="checkbox" id="IsNumeric_'.$mojo['AttributeMasterId'].'" name="IsNumeric[]" '.$checkedIsNum.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" onclick="numericCheck('.$mojo['AttributeMasterId'].');"></td>';
            //IsNumeric ends
            //IsEmail starts
            if($MappedAttribute[$i]['IsEmail']=='1')
                $checkedIsEma='checked=""';
            else
                $checkedIsEma='';    
            $templatenew.='<td><input class="form-control" type="checkbox" id="IsEmail_'.$mojo['AttributeMasterId'].'" name="IsEmail[]" '.$checkedIsEma.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" onclick="emailCheck('.$mojo['AttributeMasterId'].');"></td>';
            //IsEmail ends
            //IsUrl starts
            if($MappedAttribute[$i]['IsUrl']=='1')
                $checkedIsUrl='checked=""';
            else
                $checkedIsUrl='';    
            $templatenew.='<td><input class="form-control" type="checkbox" id="IsUrl_'.$mojo['AttributeMasterId'].'" name="IsUrl[]" '.$checkedIsUrl.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" onclick="urlCheck('.$mojo['AttributeMasterId'].');"></td>';
            //IsUrl ends
            //IsDate starts
            if($MappedAttribute[$i]['IsDate']=='1'){
                $checkedIsDate='checked=""';
                $readonly='';
            }
            else{
                $checkedIsDate='';
                $readonly='style="pointer-events:none;" readonly=""';
            }
            $templatenew.='<td><input class="form-control" id="IsDate_'.$mojo['AttributeMasterId'].'" type="checkbox" name="IsDate[]" '.$checkedIsDate.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" onclick="updteDatechk('.$mojo['AttributeMasterId'].');"></td>';
            //IsDate ends
            //DateFormat starts
            
            $templatenew.='<td><select class="form-control" id="DateFormat_'.$mojo['AttributeMasterId'].'" name="DateFormat[]" '.$readonly.' style="width:100px;">';
            $templatenew.='<option value="">--select--</option>';
            if($MappedAttribute[$i]['DateFormat']==''){
             $selected ='selected';
             
              $templatenew.='<option value="MM-dd-yy">MM-DD-YYYY</option>'; 
             $templatenew.='<option value="y-M-d">YYYY-MM-DD</option>';
             $templatenew.='<option value="M/d/y">MM/DD/YYYY</option>';
             $templatenew.='<option value="M/d/y H:m">MM/DD/YYYY H:M</option>';
             
            }else{
            if($MappedAttribute[$i]['DateFormat']=='MM-dd-yy'){
                $selected ='selected';
                $templatenew.='<option  selected="'.$selected.'" value="MM-dd-yy">MM-DD-YYYY</option>';
            }else {
              $templatenew.='<option value="MM-dd-yy">MM-DD-YYYY</option>';  
            }
            if($MappedAttribute[$i]['DateFormat']=='y-M-d'){
                $selected ='selected';
                $templatenew.='<option selected="'.$selected.'" value="y-M-d">YYYY-MM-DD</option>';
            }else{
                $templatenew.='<option value="y-M-d">YYYY-MM-DD</option>';
            }
            if($MappedAttribute[$i]['DateFormat']=='M/d/y'){
                $selected ='selected';
               $templatenew.='<option selected="'.$selected.'" value="M/d/y">MM/DD/YYYY</option>'; 
            }else{
                $templatenew.='<option value="M/d/y">MM/DD/YYYY</option>';
            }
            if($MappedAttribute[$i]['DateFormat']=='M/d/y H:m'){
                $selected ='selected';
                $templatenew.='<option selected="'.$selected.'" value="M/d/y H:m">MM/DD/YYYY H:M</option>';
            }else{
                $templatenew.='<option value="M/d/y H:m">MM/DD/YYYY H:M</option>';
            }
            }
            $templatenew.='</select></td>';
            //DateFormat ends
            //IsDecimal starts
            if($MappedAttribute[$i]['IsDecimal']=='1'){
                $checkedIsDecimal='checked=""';
                $readonly='';
            }
            else{
                $checkedIsDecimal='';  
                $readonly='readonly=""';
            }
            $templatenew.='<td><input class="form-control" id="IsDecimal_'.$mojo['AttributeMasterId'].'" type="checkbox" name="IsDecimal[]" '.$checkedIsDecimal.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" onclick="updteDecimalchk('.$mojo['AttributeMasterId'].');"></td>';
            //IsDecimal ends
            //AllowedDecimalPoint starts
            $templatenew.='<td><input class="form-control" id="AllowedDecimalPoint_'.$mojo['AttributeMasterId'].'" type="text" name="AllowedDecimalPoint[]" '.$readonly.'  onblur="checkLength('.$mojo['AttributeMasterId'].',this.value);" value="'.$MappedAttribute[$i]['AllowedDecimalPoint'].'" ></td>';
            //AllowedDecimalPoint ends
            //IsAutoSuggesstion starts
            if($MappedAttribute[$i]['IsAutoSuggesstion']=='1')
                $checkedIsAutoSuggesstion='checked=""';
            else
                $checkedIsAutoSuggesstion='';    
            $templatenew.='<td>';
            $templatenew.='<input class="form-control" type="checkbox" name="IsAutoSuggesstion[]" '.$checkedIsAutoSuggesstion.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'">';
            $templatenew.='</td>';
            //IsAutoSuggesstion ends
            //IsAllowNewValues starts
            if($MappedAttribute[$i]['IsAllowNewValues']=='1')
                $checkedIsAllowNewValues='checked=""';
            else
                $checkedIsAllowNewValues='';    
            $templatenew.='<td>';
            $templatenew.='<input class="form-control" type="checkbox" name="IsAllowNewValues[]" '.$checkedIsAllowNewValues.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'">';
            $templatenew.='</td>';
            //IsAllowNewValues ends
            //IsSpecialCharacter starts
            if($MappedAttribute[$i]['IsSpecialCharacter']=='1'){
                $checkedIsSpec='checked=""';
                $readonly='';
            }else{
                $checkedIsSpec='';
                $readonly='readonly=""';
            }
            $templatenew.='<td>';
            $templatenew.='<input id="IsSpl_'.$mojo['AttributeMasterId'].'" type="checkbox" name="IsSpecialCharacter[]" '.$checkedIsSpec.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" onclick="updteStatuschk1('.$mojo['AttributeMasterId'].');">';
            $templatenew.='</td>';
            //IsSpecialCharacter ends
            //AllowedCharacter starts
            $templatenew.='<td>';
            $MappedAttribute[$i]['AllowedCharacter'] = str_replace('\\\\','\\',$MappedAttribute[$i]['AllowedCharacter']);
            $templatenew.='<textarea onkeyup="allowedchar('.$mojo['AttributeMasterId'].')" class="form-control" id="Allow_'.$mojo['AttributeMasterId'].'" type="text" name="AllowedCharacter[]" '.$readonly.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" >'.$MappedAttribute[$i]['AllowedCharacter'].'</textarea>';
            $templatenew.='</td>';
            //AllowedCharacter ends
            //NotAllowedCharacter starts
            $templatenew.='<td>';
            $MappedAttribute[$i]['NotAllowedCharacter'] = str_replace('\\\\','\\',$MappedAttribute[$i]['NotAllowedCharacter']);
            $templatenew.='<textarea onkeyup="notallowedchar('.$mojo['AttributeMasterId'].')" class="form-control" id="NotAllow_'.$mojo['AttributeMasterId'].'" type="text" name="NotAllowedCharacter[]" '.$readonly.' value="'.$mojo['ProjectAttributeMasterId'].'_'.$mojo['AttributeMasterId'].'" >'.$MappedAttribute[$i]['NotAllowedCharacter'].'</textarea>';
            $templatenew.='</td>';
            //NotAllowedCharacter ends
            //Format starts
            $templatenew.='<td>';
            $templatenew.='<input class="form-control" id="Format_'.$mojo['AttributeMasterId'].'" type="text" name="Format[]"  value="'.$MappedAttribute[$i]['Format'].'" >';
            $templatenew.='</td>';
            //Format ends
            //MaxLength starts
            $templatenew.='<td>';
            $templatenew.='<input class="form-control" minlength=2 id="MaxLength_'.$mojo['AttributeMasterId'].'" type="text" name="MaxLength[]"  value="'.$MappedAttribute[$i]['MaxLength'].'" >';
            $templatenew.='</td>';
            //MaxLength starts
            //MinLength starts
            $templatenew.='<td>';
            $templatenew.='<input class="form-control" maxlength=2 id="MinLength_'.$mojo['AttributeMasterId'].'" type="text" name="MinLength[]"  value="'.$MappedAttribute[$i]['MinLength'].'" >';
            $templatenew.='</td>';
            //MinLength ends
            $templatenew.='</tr>';
            $i++;
        }
        
            $templatenew.='</tbody></table></div>';
        //$template='<label for="RegionId"><b> Attribute Name: </b> &nbsp;</label>';
//        $template.='<div style="max-width:1300px;width:auto;overflow:auto;">';
//        $template.='<table border="1" style="background-color:#F79F81;" >';
//        $template.='<th style="padding:0 25px 0 37px;">AttributeName</th><th style="padding:0 15px 0 15px;">IsMandatory</th><th style="padding:0 35px 0 32px;">IsAlphabet</th><th style="padding:0 33px 0 38px;">IsNumeric</th><th style="padding:0 48px 0 44px;">IsEmail</th><th style="padding:0 56px 0 53px;">IsUrl</th><th style="padding:0 50px 0 47px;">IsDate</th><th style="padding:0 30px 0 30px;">DateFormat</th><th style="padding:0 37px 0 37px;">IsDecimal</th><th style="padding:0 0px 0 0px;">AllowedDecimalPoint</th><th style="padding:0 6px 0 2px;">IsAutoSuggesstion</th><th style="padding:0 7px 0 9px;">IsAllowNewValues</th><th style="padding:0 18px 0 12px;">IsSpecialCharacter</th><th style="padding:0 13px 0 14px;">AllowedCharacter</th><th style="padding:0 11px 0 8px;">NotAllowedCharacter</th><th style="padding:0 49px 0 43px;">Format</th><th style="padding:0 32px 0 31px;">MaxLength</th><th style="padding:0 32px 0 34px;">MinLength</th>';
//        $template.='</table>';//<th style="padding:0 15px 0 15px;">IsMandatory</th>
//        $template.='<div style=" height:600px">';
//        $template.='<table border="1">';
//        $i=0;
//        foreach ($MojoTemplates as $mojo):
//            if($i==0){
//                $template.='<th style="padding:0 15px 0 15px;"></th><th style="padding:0 58px 0 58px;"></th><th style="padding:0 57px 0 47px;"></th><th style="padding:0 55px 0 45px;"></th><th style="padding:0 45px 0 34px;"></th><th style="padding:0 30px 0 32px;"></th><th style="padding:0 30px 0 32px;"></th><th style="padding:0 30px 0 32px;"><th style="padding:0 50px 0 32px;"></th><th style="padding:0 30px 0 32px;"><th style="padding:0 50px 0 95px;"></th><th style="padding:0 50px 0 87px;"></th><th style="padding:0 82px 0 80px;"></th><th style="padding:0 15px 0 15px;"></th><th style="padding:0 15px 0 15px;"></th><th style="padding:0 15px 0 15px;"></th><th style="padding:0 15px 0 15px;"></th><th style="padding:0 15px 0 15px;"></th>';
//                $template.='<tr>';//<th style="padding:0 58px 0 58px;"></th>
//            }
//            $template.='<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$mojo['DisplayAttributeName'];
//            $template.='<input type="hidden" name="AttributeName[]" value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            if($MappedAttribute[$i]['IsMandatory']=='1')
//                $checkedIsMand='checked=""';
//            else
//                $checkedIsMand='';            
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsMandatory[]" '.$checkedIsMand.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//           
//            if($MappedAttribute[$i]['IsAlphabet']=='1')
//                $checkedIsAlph='checked=""';
//            else
//                $checkedIsAlph='';
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsAlphabet[]" '.$checkedIsAlph.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            
//            if($MappedAttribute[$i]['IsNumeric']=='1')
//                $checkedIsNum='checked=""';
//            else
//                $checkedIsNum='';
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsNumeric[]" '.$checkedIsNum.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//
//            if($MappedAttribute[$i]['IsEmail']=='1')
//                $checkedIsEma='checked=""';
//            else
//                $checkedIsEma='';    
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsEmail[]" '.$checkedIsEma.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//
//            if($MappedAttribute[$i]['IsUrl']=='1')
//                $checkedIsUrl='checked=""';
//            else
//                $checkedIsUrl='';    
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsUrl[]" '.$checkedIsUrl.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            if($MappedAttribute[$i]['IsDate']=='1'){
//                $checkedIsDate='checked=""';
//                $readonly='';
//            }
//            else{
//                $checkedIsDate='';
//                $readonly='disabled=""';
//            }
//            $template.='<td style="text-align:center">';
//            $template.='<input id="IsDate_'.$mojo['ID'].'" type="checkbox" name="IsDate[]" '.$checkedIsDate.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'" onclick="updteDatechk('.$mojo['ID'].');">';
//            $template.='&nbsp;&nbsp;</td>';
////            $selected1 ='';
////            $selected2 ='';
////            $selected3 ='';
////            $selected4 ='';
////            $selected5 ='';
//            //echo $MappedAttribute[$i]['DateFormat'].'<br>';
//            $template.='<td style="text-align:center">';
//            $template.='<select id="DateFormat_'.$mojo['ID'].'" name="DateFormat[]" '.$readonly.' >';
//            if($MappedAttribute[$i]['DateFormat']=='mm-dd-yy'){
//                $selected ='selected';
//                $template.='<option  selected="'.$selected.'" value="mm-dd-yy">mm-dd-yy</option>';
//            }else {
//              $template.='<option value="mm-dd-yy">mm-dd-yy</option>';  
//            }
//            if($MappedAttribute[$i]['DateFormat']=='Y-m-d'){
//                $selected ='selected';
//                $template.='<option selected="'.$selected.'" value="Y-m-d">Y-m-d</option>';
//            }else{
//                $template.='<option value="Y-m-d">Y-m-d</option>';
//            }
//            if($MappedAttribute[$i]['DateFormat']=='m/d/Y'){
//                $selected ='selected';
//               $template.='<option selected="'.$selected.'" value="m/d/Y">m/d/Y</option>'; 
//            }else{
//                $template.='<option value="m/d/Y">m/d/Y</option>';
//            }
//            if($MappedAttribute[$i]['DateFormat']=='m/d/Y H:i'){
//                $selected ='selected';
//                $template.='<option selected="'.$selected.'" value="m/d/Y H:i">m/d/Y H:i</option>';
//            }else{
//                $template.='<option value="m/d/Y H:i">m/d/Y H:i</option>';
//            }
//            //else{$selected5 ='selected';}
//            
////            $template.='<option selected="'.$selected.'" value="">--select--</option>';
////            $template.='<option  selected="'.$selected.'" value="mm-dd-yy">mm-dd-yy</option>';
////            $template.='<option selected="'.$selected.'" value="Y-m-d">Y-m-d</option>';
////            $template.='<option selected="'.$selected.'" value="m/d/Y">m/d/Y</option>';
////            $template.='<option selected="'.$selected.'" value="m/d/Y H:i">m/d/Y H:i</option>';
//            $template.='</select>';
////            $template.='<input id="DateFormat_'.$mojo['ID'].'" type="text" name="DateFormat[]" '.$readonly.'  value="'.$MappedAttribute[$i]['DateFormat'].'" >';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            if($MappedAttribute[$i]['IsDecimal']=='1'){
//                $checkedIsDecimal='checked=""';
//                $readonly='';
//            }
//            else{
//                $checkedIsDecimal='';  
//                $readonly='readonly=""';
//            }
//            $template.='<td style="text-align:center">';
//            $template.='<input id="IsDecimal_'.$mojo['ID'].'" type="checkbox" name="IsDecimal[]" '.$checkedIsDecimal.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'" onclick="updteDecimalchk('.$mojo['ID'].');">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='<td style="text-align:center">';
//            $template.='<input id="AllowedDecimalPoint_'.$mojo['ID'].'" type="text" name="AllowedDecimalPoint[]" '.$readonly.'  value="'.$MappedAttribute[$i]['AllowedDecimalPoint'].'" >';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            if($MappedAttribute[$i]['IsAutoSuggesstion']=='1')
//                $checkedIsAutoSuggesstion='checked=""';
//            else
//                $checkedIsAutoSuggesstion='';    
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsAutoSuggesstion[]" '.$checkedIsAutoSuggesstion.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            if($MappedAttribute[$i]['IsAllowNewValues']=='1')
//                $checkedIsAllowNewValues='checked=""';
//            else
//                $checkedIsAllowNewValues='';    
//            $template.='<td style="text-align:center">';
//            $template.='<input type="checkbox" name="IsAllowNewValues[]" '.$checkedIsAllowNewValues.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'">';
//            $template.='&nbsp;&nbsp;</td>';
//
//            if($MappedAttribute[$i]['IsSpecialCharacter']=='1'){
//                $checkedIsSpec='checked=""';
//                $readonly='';
//            }else{
//                $checkedIsSpec='';
//                $readonly='readonly=""';
//            }
//            $template.='<td style="text-align:center">';
//            $template.='<input id="IsSpl_'.$mojo['ID'].'" type="checkbox" name="IsSpecialCharacter[]" '.$checkedIsSpec.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'" onclick="updteStatuschk1('.$mojo['ID'].');">';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='<td style="text-align:center">';
//            $template.='<textarea id="Allow_'.$mojo['ID'].'" type="text" name="AllowedCharacter[]" '.$readonly.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'" >'.$MappedAttribute[$i]['AllowedCharacter'].'</textarea>';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='<td style="text-align:center;padding:8px">';
//            $template.='<textarea id="NotAllow_'.$mojo['ID'].'" type="text" name="NotAllowedCharacter[]" '.$readonly.' value="'.$mojo['ProjectAttributeId'].'_'.$mojo['ID'].'" >'.$MappedAttribute[$i]['NotAllowedCharacter'].'</textarea>';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='<td style="text-align:center">';
//            $template.='<input id="Format_'.$mojo['ID'].'" type="text" name="Format[]"  value="'.$MappedAttribute[$i]['Format'].'" >';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='<td style="text-align:center">';
//            $template.='<input id="MaxLength_'.$mojo['ID'].'" type="text" name="MaxLength[]"  value="'.$MappedAttribute[$i]['MaxLength'].'" >';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='<td style="text-align:center">';
//            $template.='<input id="MinLength_'.$mojo['ID'].'" type="text" name="MinLength[]"  value="'.$MappedAttribute[$i]['MinLength'].'" >';
//            $template.='&nbsp;&nbsp;</td>';
//            
//            $template.='</tr>';
//            $i++;
//        endforeach;
//        $template.='</table>';
//        $template.='</div>';
//        $template.='</div>';
        return $templatenew;
        //return $template;
        }
    }

   

}
