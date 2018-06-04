<?php

use Cake\Routing\Router
?>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4> Hygiene Check </h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project Name</label>
                <div class="col-sm-6">
                    <?php
                    echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control prodash-txt', 'value' => $ProjectId, 'onchange' => 'getRegion(this.value);'));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Region</label>
                <div class="col-sm-6">
                    <div id="LoadRegion">
                        <?php 
                            if ($RegionId == '') {
                                $Region=array(0=>'--Select--');
                                echo $this->Form->input('', array('options' => $Region,'id' => 'RegionId', 'name' => 'RegionId', 'style'=>'margin-top:-17px;', 'class'=>'form-control','value'=>$RegionId,'onchange' => 'getModule(this.value); getusergroupdetails(this.value)')); 
                            } else {
                                echo $RegionId;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Module</label>
                <div class="col-sm-6">
                    <?php 
                    if ($ModuleId == '') {
                    $Modules = array(0 => '--Select--'); ?>
                    <div id="LoadModule">
                        <?php
                        echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleId', 'name' => 'ModuleId', 'class' => 'form-control prodash-txt', 'value' => $ModuleId));
                        //echo $ModuleList;
                            ?>
                    </div>
                    <?php }else{
                        echo $ModuleId;
                    } ?>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                <label for="UserGroupId" class="col-sm-6 control-label">User Group</label>
                <div class="col-sm-6 prodash-txt">
                    <?php
                    if ($UserGroupId == '') {
                        $UserGroup = array(0 => '--Select--'); ?>
                     <div id="LoadUserGroup">
                        <?php 
                        echo $this->Form->input('', array('options' => $UserGroup, 'id' => 'UserGroupId', 'name' => 'UserGroupId', 'class' => 'form-control', 'value' => $UserGroupId, 'selected' => $UserGroupId));
                      ?>
                        </div>
                    <?php }else{
                        echo $UserGroupId;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <?php
            echo $this->Form->button('Search', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search',  'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));

            echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));

        echo $this->Form->end();
        ?>
            </div>

        </div>
    </div>
</div>
  <?php 
if (count($Production_batch) > 0) {
?>
<div class="panel-group" id="accordion-dv" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">

            </div>
            <?php if($Production_batch!=0){ ?>
            <div class="bs-example">
                <div id="vertical">
                    <div id="top-pane">
                        <div id="horizontal" style="height: 100%; width: 100%;">
                            <div class="pane-content" >
                                <table style='width:100%;' class="table table-striped table-center" id='example'>
                                    <thead>
                                        <tr class="Heading">
                                            <th class="Cell" width="10%"> Project </th> 
                                            <th class="Cell" width="10%"> Region </th> 
                                            <th class="Cell" width="10%"> Process Name </th>
                                            <th class="Cell" width="10%"> Entity Count </th>
                                            <th class="Cell" width="10%"> Status </th>
                                            <th class="Cell" width="10%"> Batch Name </th>
                                            <th class="Cell" width="10%"> Start Date </th>
                                            <th class="Cell" width="10%"> End Date </th>
                                            <th class="Cell" width="10%"> Batch Created Date </th>
                                            <th class="Cell" width="10%"> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <?php $i = 0;
                                            foreach ($Production_batch as $inputVal => $input):
                                                $HygieneCheckDetails = $this->Html->link('HygieneCheckDetails', ['action' => 'checkdetails',$input['Id'],$input['ProjectId'],$input['RegionId'],$input['ProcessId']]);
                                        ?>
                                        <tr><?php if($input['StatusId'] == '2'){
                                                    $StatusName = 'Ready For HygieneCheck';
                                                }
                                                if($input['StatusId'] == '4'){
                                                    $StatusName = 'TL Rebutal';
                                                }
                                                if($input['StatusId'] == '6'){
                                                    $StatusName = 'TL Rebutal Rejected';
                                                }
                                                $StartDate = $input['ProductionStartDate']; 
                                                $newStartDate = date('d-m-Y H:i:s', strtotime($StartDate));
                                                
                                                $EndDate = $input['ProductionEndDate']; 
                                                $newEndDate = date('d-m-Y H:i:s', strtotime($EndDate));
                                                
                                                $CreatedDate = $input['CreatedDate']; 
                                                $newCreatedDate = date('d-m-Y H:i:s', strtotime($CreatedDate));
                                            ?>
                                            <td><?php echo $contentArr[$input['ProjectId']]; ?></td>
                                            <td><?php echo $region[$input['RegionId']]; ?></td>
                                            <td><?php echo $module[$input['ProcessId']]; ?></td>
                                            <td><?php echo $input['EntityCount']; ?></td>
                                            <td><?php echo $StatusName; ?></td>
                                            <td><?php echo $input['BatchName']; ?></td>
                                            <td><?php echo $newStartDate; ?></td>
                                            <td><?php echo $newEndDate; ?></td>
                                            <td><?php echo $newCreatedDate ?></td>
                                            <td><?php echo $HygieneCheckDetails; ?></td>
                                        </tr>
                                        <?php $i++; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div><div class="panel-heading" role="tab" id="headingTwo"></div>
</div>
<?php
}
echo $this->Form->end();
?>
<script>
    $(document).ready(function () {
        var projectId = $('#ProjectId').val();
        var id = $('#RegionId').val();

        if ($('#ProjectId').val() != '') {
            //getRegion();
            var e = document.getElementById("RegionId");
            var strUser = e.options[e.selectedIndex].text;
        }
    });

    function Mandatory() {
        if ($('#ProjectId').val() == 0) {
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
        if ($('#RegionId').val() == 0) {
            alert('Select Region Name');
            $('#RegionId').focus();
            return false;
        }
        if ($('#ModuleId').val() == 0) {
            alert('Select Module Name');
            $('#ModuleId').focus();
            return false;
        }
        if ($('#UserGroupId').val() == 0) {
            alert('Select UserGroup');
            $('#UserGroupId').focus();
            return false;
        }
    }

    function ClearFields() {
        $('#ProjectId').val(0);
        $('#RegionId').val(0);
        $('#ModuleId').val(0);
        $('#UserGroupId').val(0);
        $('#vertical').hide();
//        reload();
    }

    function getRegion(projectId) {
        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'HygieneCheck', 'action' => 'ajaxregion')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
            }
        });
    }

    function getModule()
    {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'HygieneCheck', 'action' => 'ajaxmodule')); ?>",
            data: ({ProjectId: ProjectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadModule').innerHTML = result;
            }
        });
    }
    function getusergroupdetails(RegionId) {
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'HygieneCheck', 'action' => 'getusergroupdetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserGroup').innerHTML = result;
//                var optionValues = [];
//                $('#UserGroupId option').each(function () {
//                    optionValues.push($(this).val());
//                });
////                optionValues.join(',')
////                $('#UserGroupId').prepend('<option selected value="' + optionValues + '">All</option>');
              //  getresourcedetails();

            }
        });
    }
//    function getresourcedetails() {
//        var ProjectId = $('#ProjectId').val();
//        var RegionId = $('#RegionId').val();
//        var UserGroupId = $('#UserGroupId').val();
//
//        $.ajax({
//            type: "POST",
//            url: "<?php echo Router::url(array('controller' => 'HygieneCheck', 'action' => 'getresourcedetails')); ?>",
//            data: ({projectId: ProjectId, regionId: RegionId, userGroupId: UserGroupId}),
//            dataType: 'text',
//            async: false,
//            success: function (result) {
//                document.getElementById('LoadUserDetails').innerHTML = result;
//            }
//        });
//    }


</script>

