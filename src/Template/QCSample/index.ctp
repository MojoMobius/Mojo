<?php
use Cake\Routing\Router;
?>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>QC Sample Selection</h4>
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
                    <div id="LoadModule">
                    <?php 
                    if ($ModuleId == '') {
                        $Modules = array(0 => '--Select--'); 
                        echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleId', 'name' => 'ModuleId', 'class' => 'form-control prodash-txt', 'value' => $ModuleId)); 
                    }
                    else{
                        echo $ModuleId;
                    } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="UserGroupId" class="col-sm-6 control-label">User Group</label>
                <div class="col-sm-6 prodash-txt">
                    <div id="LoadUserGroup">
                    <?php
                    if ($UserGroupId == '') {
                        $UserGroup = array(0 => '--Select--'); ?>
                        <?php 
                        echo $this->Form->input('', array('options' => $UserGroup, 'id' => 'UserGroupId', 'name' => 'UserGroupId', 'class' => 'form-control', 'value' => $UserGroupId, 'selected' => $UserGroupId));
                      ?>
                    <?php 
                    }
                    else{
                        echo $UserGroupId;
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
            <?php
                echo $this->Form->button('Search', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search',  'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));
                echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));
            ?>
            </div>
        </div>
        <?php
        echo $this->Form->end();
        ?>
    </div>
<?php 
if (count($SelectQCBatch) > 0) {
?>
<!--    <div class="container-fluid">-->
    <div class="bs-example">
        <div id="vertical">
            <div id="top-pane">
                <div id="horizontal" style="height: 100%; width: 99.9%;">
                    <div id="left-pane" class="pa-lef-10">
                        <div class="pane-content" > <br>
                            <table style='width:99%;' class="table table-striped table-center" id='example'>
                                <thead>
                                    <tr class="Heading">
                                        <th class="Cell" width="10%">Project Name</th> 
                                        <th class="Cell" width="10%">Region</th> 
                                        <th class="Cell" width="10%">Process Id</th>
                                        <th class="Cell" width="10%">Batch Name</th>
                                        <th class="Cell" width="10%">Entity Count</th>
                                        <th class="Cell" width="10%">Production Start Date & Time</th>
<!--                                            <th class="Cell" width="10%">Production Start Time</th>-->
                                        <th class="Cell" width="10%">Production End Date & Time</th>
<!--                                            <th class="Cell" width="10%">Production End Time</th>-->
                                        <th class="Cell" width="10%">Created Date</th>
                                        <th class="Cell" width="10%">QC Sample Select</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $i = 0;
                                    foreach ($SelectQCBatch as $inputVal => $input):
                                        $path = JSONPATH . '\\ProjectConfig_' . $input['ProjectId'] . '.json';
                                        $content = file_get_contents($path);
                                        $contentArr = json_decode($content, true);
                                        $RegionName = $contentArr['RegionList'][$input['RegionId']];
                                        $ModuleName = $contentArr['Module'][$input['ProcessId']];
                                        $CheckDetails = $this->Html->link('Select Sample', ['action' => 'qcsampleselection', $input['Id']]);
                                ?>
                                    <tr>
                                        <td><?php echo $Projects[$input['ProjectId']]; ?></td>
                                        <td><?php echo $RegionName; ?></td>
                                        <td><?php echo $ModuleName; ?></td>
                                        <td><?php echo $input['BatchName']; ?></td>
                                        <td><?php echo $input['EntityCount']; ?></td>
                                        <td><?php echo $input['ProductionStartDate']; ?></td>
<!--                                                <td><?php echo $input['ProductionStartTime']; ?></td>-->
                                        <td><?php echo $input['ProductionEndDate']; ?></td>
<!--                                                <td><?php echo $input['ProductionEndTime']; ?></td>-->
                                        <td><?php echo $input['CreatedDate']; ?></td>
                                        <td><?php echo $CheckDetails; ?></td>
                                    </tr>
                                <?php
                                    $i++;
                                    endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    </div>-->
<?php
}
?>
</div>
<script type="text/javascript">
    $(document).ready(function (projectId) {
        <?php
            $js_array = json_encode($ProdDB_PageLimit);
            echo "var mandatoryArr = " . $js_array . ";\n";
        ?>
        var pageCount = mandatoryArr;
        tables = $('#example').DataTable({
            //            "pagingType": "simple_numbers",
            //            "bInfo": true,
            //            "bFilter": false,
            //             "dom": '<"top"irflp>rt<"bottom"irflp><"clear">',
            //            "pageLength": mandatoryArr,
            //*******show entry data table bottom dropdown **************//
            //            "sDom": 'Rlifrtlip',  ####Important###
            "sPaginationType": "full_numbers",
            "sDom": 'Rlifprtlip',
            "bStateSave": true,
            "bFilter": true,
            //"scrollY": 300,
            //            "scrollX": true,
            "aoColumnDefs": [
                {"bSearchable": false, "aTargets": [6]}
            ]
        });


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
    }
    
    function getRegion(projectId) {
        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCSample', 'action' => 'ajaxregion')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadRegion').innerHTML = result;
                $('#ModuleId,#UserGroupId').children('option:not(:first)').remove();
            }
        });
    }

    function getModule()
    {
        var result = new Array();
        var ProjectId = $('#ProjectId').val();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCSample', 'action' => 'ajaxmodule')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'QCSample', 'action' => 'getusergroupdetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserGroup').innerHTML = result;
            }
        });
    }

</script>
<style>
    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
    }
    .overlay:target {
        visibility: visible;
        opacity: 1;
    }


    .popup {
        margin: 150px auto;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        width: 40%;
        position: relative;
        transition: all 5s ease-in-out;

    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }
    .popup .close {
        position: absolute;
        top: 20px;
        right: 30px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }
    .popup .close:hover {
        color: #fdc382;
    }
    .popup .content {
        max-height: 30%;
        overflow: auto;
    }
    .query_outerbdr {
        background: #fff none repeat scroll 0 0;
        border-radius: 5px;
        margin: 3px;
        padding: 6px;
    }

    .allocation_popuphgt {
        font-size: 12px;
        height: 157px;
        overflow: auto;
    }
    .white_content {
        background: #fdfdfd url("../img/popupbg.png") repeat-x scroll left top;
        border: 5px solid #fff;
        display: none;
        height: auto;
        left: 25%;
        padding: 16px;
        position: absolute;
        top: 25%;
        width: 50%;
        z-index: 1002;
    }

    #vertical {
        height: 750px;
        margin: 0 auto;
    }
    #left-pane,#top-pane  { background-color: rgba(60, 70, 80, 0.05); }
    #left-pane{padding-top:12px !important};
    .pane-content {
        padding: 0 10px;
    }
    .lastrow label{position:relative !important;}
</style>