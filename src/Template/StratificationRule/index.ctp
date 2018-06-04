<!--Form : Stratification Rule
  Developer: SyedIsmail N
  Created On: Jul 07 2017 -->
<?php

use Cake\Routing\Router; ?>
<script type="text/javascript">
    
    $( document ).ready(function() {
    var projectId = <?php echo $sessionProjects ?>;
    $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'StratificationRule','action'=>'ajaxregion'));?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
            }
        });
        
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'StratificationRule', 'action' => 'ajaxmodule')); ?>",
            data: ({ProjectId: ProjectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadModule').innerHTML = result;
            }
        });
        
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#Region').val();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'StratificationRule', 'action' => 'ajaxattributeids')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                cols = '<select class="form-control" name="LoadAttributeids[]" id="LoadAttributeids" style="width:220px; margin-left: 35px;">';
                cols += result;
                cols += '</select>';
                document.getElementById('LoadAttributeids').innerHTML = cols;
            }
        });
    });
    
    function validateForm() {

        if ($('#ProjectId').val() == 0){
            alert('Select Project');
            $('#ProjectId').focus();
            return false;
        }
        if ($('#Region').val() == 0){
            alert('Select Region');
            $('#ProjectName').focus();
            return false;
        }
        if ($('#RuleName').val() == 0){
            alert('Enter Rule Name!');
            $('#RuleName').focus();
            return false;
        }
        if ($('#AcceptanceLimit').val() == 0){
            alert('Enter Acceptance Limit!');
            $('#AcceptanceLimit').focus();
            return false;
        }
        if ($('#ModuleId').val() == 0){
            alert('Please Select Process');
            $('#ModuleId').focus();
            return false;
        }
//        if ($('#MinimumSample').val() == 0){
//            alert('Enter Minimum Sample!');
//            $('#MinimumSample').focus();
//            return false;
//        }
        
        if ($('#LoadAttributeids').val() == '0'){
            alert('Enter Stratification factors in Row - 1');
            $('#LoadAttributeids').focus();
            return false;
        }
        
        var counter = $('#AddUniqueTable tbody tr').length;
        for (i = 0; i <= counter; i++)
        {
            if ($('#LoadAttributeids' + i).val() == '0')
            {
                alert('Enter Stratification factors in Row - ' + i);
                $('#LoadAttributeids' + i).focus();
                return false;
            }
        }
        if ((!$('#Rule_sample_one').prop("checked")) && (!$('#Rule_sample_two').prop("checked")))
        {
            alert('Please Select Sample type');
            return false;
        }

        if ($('#Sample_value').val() == 0){
            alert('Please Select Stratification factors values');
            $('#Sample_value').focus();
            return false;
        }
        
        if(document.getElementById('Resource_stratification').checked){
            
            if ((!$('#Resource_sample_one').prop("checked")) && (!$('#Resource_sample_two').prop("checked")))
            {
                alert('Please Select Resource Sample type');
                return false;
            }

            if ($('#Resource_value').val() == 0){
                alert('Please Select Resource Stratification values');
                $('#Resource_value').focus();
                return false;
            }
        }
    }
    
    
    function ClearFields() {
        $('#ProjectId').val('0');
        $('#Region').val('0');
        $('#RuleName').val("");
        $('#AcceptanceLimit').val("");
        $('#ModuleId').val("0");
        //$('#MinimumSample').val("");
        $('#LoadAttributeids').val('0');
        $('#Sample_value').val("");
        $('#Resource_value').val("");
        $('input[type=checkbox]').attr('checked',false);
        $('input[name=Rule_sample]').attr('checked',false);
        $('input[name=Resource_sample]').attr('checked',false);
        var counter = $('#AddUniqueTable tbody tr').length;
        for (i = 1; i <= counter; i++)
        {
            $('#LoadAttributeids' + i).val('0');
        }
    }
    
    function getRegion(projectId) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'StratificationRule','action'=>'ajaxregion'));?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
            }
        });
    }
    
    function getAttributeids(ModuleId)
    {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#Region').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'StratificationRule', 'action' => 'ajaxattributeids')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, ModuleId: ModuleId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                cols = '<select class="form-control" name="LoadAttributeids[]" id="LoadAttributeids" style="width:220px; margin-left: 35px;">';
                cols += result;
                cols += '</select>';
                document.getElementById('LoadAttributeids').innerHTML = cols;
            }
        });
        var counter = $('#AddUniqueTable tbody tr').length;
        for (i = 1; i <= counter; i++)
        {
            $('#LoadAttributeids' + i).val('0');
        }
    }
    
    function getModule()
    {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'StratificationRule', 'action' => 'ajaxmodule')); ?>",
            data: ({ProjectId: ProjectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadModule').innerHTML = result;
            }
        });
    }
    
    function AddRow() {
        if ($('#ModuleId').val() == 0){
            alert('Please Select Process');
            $('#ModuleId').focus();
            return false;
        }
        
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#Region').val();
        var ModuleId = $('#ModuleId').val();
        var count = $('#AddUniqueTable tr').length;
        var count = count+1;
        var newRow = $("<tr>");
        var cols = "";
        cols += '<td class="non-bor" style="padding-top: 10px;">';
        cols +='<select class="form-control" name="LoadAttributeids[]" id="LoadAttributeids' + count + '" style="width:220px;">';
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'StratificationRule', 'action' => 'ajaxattributeids')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, ModuleId: ModuleId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                cols += result;
            }
        });
        cols += '</select>';
        cols += '</td>';
        cols += '<td class="non-bor" style="padding-top: 10px;"><img style="cursor: pointer;" src="<?php echo Router::url('/', true);?>webroot/img/images/delete.png" onclick="RemoveRow(' + count + ');"></td>';

        newRow.append(cols);
        $("#AddUniqueTable").append(newRow);
    }
    
    function RemoveRow(r) {
        var counter = $('#AddUniqueTable tbody tr').length;
        if (counter > 1) {
            $("#AddUniqueTable tbody tr:nth-child(" + r + ")").remove();
            var table = document.getElementById('AddUniqueTable');

            for (var r = 1, n = table.rows.length; r < n; r++) {

                for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {

                    if (c == 0)
                    {
                        var nodes = table.rows[r].cells[c].childNodes;
                        for (var i = 0; i < nodes.length; i++) {
                            if (nodes[i].nodeName.toLowerCase() == 'select')
                                nodes[i].id = 'LoadAttributeids' + (r+1);
                        }
                    }
                    if (c == 1 && r >= 1) {
                        var nodes = table.rows[r].cells[c].childNodes;
                        for (var i = 0; i < nodes.length; i++) {
                            nodes[i].setAttribute('onclick', "RemoveRow(" + (r+1) + ")");
                        }
                    }
                }
            }
        } else {
            alert('Minimum One Row Required')
        }
    }
</script>

<div class="container-fluid mt15">
    <div class="formcontent">
        <h4>Stratification Rule</h4>
            <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms','name' => 'projectforms')); ?>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
                    <?php
                        if($ProjectIdEdit==''){
                            $ProjectValue=$sessionProjects;
                        }else{
                            $ProjectValue=$ProjectIdEdit;
                        }        
                    ?>
                    <?php echo $this->Form->input('', array('options' => $Projects,'id' => 'ProjectId', 'value' => $ProjectValue ,'name' => 'ProjectId', 'class'=>'form-control prodash-txt', 'onchange'=>'getRegion(this.value);getModule();' )); ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Region</label>
                <div class="col-sm-6">
                    <?php 
                        if($RegionIdEdit!=''){
                            echo $RegionIdEdit;
                        }else{
                        $Region=array(0=>'--Select--');
                        echo '<div id="LoadRegion">';
                        echo $this->Form->input('', array('options' => $Region,'id' => 'Region', 'value' =>$detailArr[$ProjectIdEdit]['Region'][$RegionIdEdit], 'name' => 'Region', 'class'=>'form-control prodash-txt')); 
                        echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Rule Name : </label>
                <div class="col-sm-6">
                    <input type="text" name="RuleName" id="RuleName" value="<?php echo $RuleNameEdit; ?>" class="form-control">
                    <input type="hidden" name="StratificationRuleId" id="StratificationRuleId" value="<?php echo $StratificationRuleId; ?>" class="form-control">
                    <?php foreach ($EditId as $key => $value) { pr($value['EditId']);?>
                        <input type="hidden" name="EditId[]" id="EditId" value="<?php echo $value['EditId']; ?>" class="form-control">
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Acceptance Limit : </label>
                <div class="col-sm-6">
                    <input type="text" name="AcceptanceLimit" id="AcceptanceLimit" value="<?php echo $AceptanceLimitEdit ?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Process :</label>
                <div class="col-sm-6">
                    <?php $Module = array(0 => '--Select--'); ?>
                    <div id="LoadModule">
                        <?php echo $ProcessIdEdit; //--!important
                            if ($ProcessIdEdit == '') { ?>
                            <select class="form-control">
                                <option selected>--Select--</option>
                            </select>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Minimum Sample</label>
                <div class="col-sm-6">
                    <input type="text" name="MinimumSample" id="MinimumSample" value="<?php echo $MinimumSampleEdit; ?>" class="form-control">
                </div>
            </div>
        </div>-->
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">&nbsp;&nbsp;&nbsp;</label>
                <div class="col-sm-6">
                    <input type="hidden" name="MinimumSample" id="MinimumSample" value="0" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Stratification factors : </label>
                <div class="col-sm-6">
                    <table class=" list-master" style="width: 25%; margin-left: 0px;" id="AddUniqueTable">
                        <tbody>
                            <?php if ($AttributeCount == '') { ?>
                            <tr>
                                <td style="padding-top: 10px;">
                                    <select id="LoadAttributeids" class="form-control" name="LoadAttributeids[]" style="width:220px;">
                                        <option selected>--Select--</option>
                                    </select>
                                </td>
                                <td class="non-bor" style="padding-top: 10px;"><a><?php echo $this->Html->image("images/add.png", array('name' => 'add', 'onclick' => 'AddRow();')); ?></a></td >
                            </tr>    
                            <?php } ?>
                            <?php $j=0; for ($i = 1; $i <= $AttributeCount; $i++) { ?>
                                <tr>
                                <?php if($StratificationfactorsEdit != ''){?>
                                    <td style="padding-top: 10px;">
                                        <select id="LoadAttributeids<?php echo $i; ?>" name="LoadAttributeids[]" class="form-control" style="width:220px;">
                                            <?php echo $StratificationfactorsEdit[$j] ?>
                                        </select>
                                    </td>
                                <?php } ?>
                                <?php if ($i == 1) { ?>
                                    <td class="non-bor" style="padding-top: 10px;"><a><?php echo $this->Html->image("images/add.png", array('name' => 'add', 'onclick' => 'AddRow();')); ?></a></td >
                                <?php } else { ?>
                                    <td class="non-bor" style="padding-top: 10px;"><?php echo $this->Html->image("images/delete.png", array('onclick' => 'RemoveRow(' . ($i) . ');')); ?></td>
                                <?php } ?>
                                </tr>
                            <?php $j++; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-6" style="margin-left: 90px;">
                    <div class="col-sm-4" style="margin-top: -3px;"><input <?php echo $samplePercentage; ?> type="radio" class="form-control" id="Rule_sample_one" name="Rule_sample" value="1"><div style="margin-top: -20px;margin-left: 20px;">Sample&nbsp;&nbsp;Percentage</div></div><br />
                    <div class="col-sm-4" style="margin-top: -3px;margin-left: -30px;"><input <?php echo $sampleCount; ?> type="radio" class="form-control" id="Rule_sample_two" name="Rule_sample" value="2"><div style="margin-top: -20px;margin-left: 20px;">Sample&nbsp;&nbsp;Count</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="col-sm-6">
                    <input type="text" name="Sample_value" id="Sample_value" placeholder="Stratification factor Value" value="<?php echo $SampleValueEdit; ?>" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group"></div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label"></label>
                <div class="col-sm-6">
                    <input type="checkbox" id="Resource_stratification" name="Resource_stratification" <?php echo $ResourceChecked; ?>> Resource Stratification<br>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-6" style="margin-left: 90px;">
                    <div class="col-sm-4" style="margin-top: -3px;"><input  <?php echo $selectedPercentage; ?> type="radio" class="form-control" id="Resource_sample_one" name="Resource_sample" value="1"><div style="margin-top: -20px;margin-left: 20px;">Sample&nbsp;&nbsp;Percentage</div></div><br />
                    <div class="col-sm-4" style="margin-top: -3px;margin-left: -30px;"><input <?php echo $selectedCount; ?> type="radio" class="form-control" id="Resource_sample_two" name="Resource_sample" value="2"><div style="margin-top: -20px;margin-left: 20px;">Sample&nbsp;&nbsp;Count</div></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <div class="col-sm-6">
                    <input type="text" name="Resource_value" id="Resource_value" value="<?php echo $ResourceSampleValueEdit; ?>" placeholder="Resource Stratification value"  class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <?php 
                if($ProjectIdEdit==""){
                    //$addbutton = 'Add Rule';
                    $addbutton = $this->Form->submit( 'Add Rule' , array( 'id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Submit','style'=>'margin-left:550px;width:70px;float:left;padding-bottom:2 px;','class'=>'btn btn-primary btn-sm','onclick'=>'return validateForm();'));
                    $clearbutton = $this->Form->button('Clear', array( 'id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear','style'=>'margin-left:10px;float:left;display:inline;padding-bottom:6px;','class'=>'btn btn-primary btn-sm','onclick'=>'return ClearFields();','type'=>'button'));
                } else {
//                    $addbutton = 'Update';
                    $addbutton = $this->Form->submit( 'Update' , array( 'id' => 'check_update', 'name' => 'check_update', 'value' => 'Update','style'=>'margin-left:550px;width:70px;float:left;padding-bottom:2 px;','class'=>'btn btn-primary btn-sm','onclick'=>'return validateForm();'));
                    $clearbutton = $this->Form->button('Back', array( 'id' => 'check_back', 'name' => 'check_back', 'value' => 'Back','style'=>'margin-left:10px;float:left;display:inline;padding-bottom:6px;','class'=>'btn btn-primary btn-sm'));
                }
                    echo $addbutton;
                    echo $clearbutton; ?>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="bs-example mt15">
        <table class="table table-striped table-center">
            <?php if($RuleList!=0){?>
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Rule Name</th>
                    <th>Acceptance Limit</th>
                    <th>Process</th>
                    <th>Stratification factor Value</th>
                    <th>Sample Type</th>
                    <th>Sample Value</th>
                    <th>Resource Stratification</th>
                    <th>Resource SampleType</th>
                    <th>Resource Samplevalue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php } ?>
            <tbody>
                <?php
                foreach ($RuleList as $inputVal => $input) {
                    $EdiT = $this->Html->link('Edit', ['action' => 'index', $input['Id']]);
                    $ConfigRole = $this->Html->link('RoleConfig', ['action' => 'config', $input['ProjectId']]);
                    ?>
                    <tr>
                        <?php
                        if($input['ResourceSampleType'] == 0){
                            $ResourceSampleType = '-';
                        }else{
                            $ResourceSampleType = $input['ResourceSampleType'];
                        }
                        if($input['ResourceSampleValue'] == 0){
                            $ResourceSampleValue = '-';
                        }else{
                            $ResourceSampleValue = $input['ResourceSampleValue'];
                        }
                        if($input['ResourceStratification'] == 0){
                            $ResourceStratification = '-';
                        }else{
                            $ResourceStratification = $input['ResourceStratification'];
                        }
                        echo '<td>' . $Projects[$input['ProjectId']] . '</td>';
                        echo '<td>' . $input['RuleName'] . '</td>';
                        echo '<td>' . $input['AceptanceLimit'] . '</td>';
                        echo '<td>' . $detailArr[$input['ProjectId']]['Module'][$input['ProcessId']] . '</td>';
                        echo '<td>' . $input['StratificationFactors'] . '</td>';
                        echo '<td>' . $input['SampleType'] . '</td>';
                        echo '<td>' . $input['SampleValue'] . '</td>';
                        echo '<td>' . $ResourceStratification . '</td>';
                        echo '<td>' . $ResourceSampleType . '</td>';
                        echo '<td>' . $ResourceSampleValue . '</td>';
                        echo '<td>' . $EdiT . '</td>';
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div>&nbsp;</div>
</div>