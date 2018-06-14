<?php

use Cake\Routing\Router;
?>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>QC Batch Master</h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
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
                <div class="col-sm-6" >
                    <?php
                    if ($RegionId == '') {
                        $Region = array(0 => '--Select--');
                        echo '<div id="LoadRegion">';
                        echo $this->Form->input('', array('options' => $Region, 'id' => 'RegionId', 'name' => 'RegionId', 'class' => 'form-control','style' => 'margin-top:-17px' ,'value' => $RegionId,'onchange' => 'getModule(this.value); getusergroupdetails(this.value);'));
                        echo '</div>';
                    } else {
                        echo $RegionId;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Module</label>
                <div class="col-sm-6">
                    <?php 
                    if ($ModuleIds == '') {
                    $Modules = array(0 => '--Select--'); ?>
                    <div id="LoadModule">
                        <?php
                        echo $this->Form->input('', array('options' => $Modules, 'id' => 'ModuleIds', 'name' => 'ModuleIds', 'class' => 'form-control prodash-txt', 'value' => $ModuleIds));
                            ?>
                    </div>
                    <?php }else{
                        echo $ModuleIds;
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
                        $UserGroup = array(0 => '--Select--');
                        echo '<div id="LoadUserGroup">';
                        echo $this->Form->input('', array('options' => $UserGroup, 'id' => 'UserGroupId', 'name' => 'UserGroupId', 'class' => 'form-control','onchange' => 'getAvailableDate(this.value);', 'value' => $UserGroupId, 'selected' => $UserGroupId));
                        echo '</div>';
                    } else {
                        echo $UserGroupId;
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-6" style="margin-left: -160px;">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">From</label>
                <div class="col-sm-6">
                    <input readonly='readonly' placeholder='DD-MM-YYYY' type='text' name='batch_from' id='batch_from' onblur="getAvailableDate(1)">
                    <input placeholder='HH:MM:SS' class="FromTime" id="FromTime" onkeypress="return isNumberKey(event)" onblur='return isFromDate(""); ' name="FromTime" type="text">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">To</label>
                <div class="col-sm-6">
                    <input readonly='readonly' placeholder='DD-MM-YYYY' type='text' name='batch_to' id='batch_to' onblur="getAvailableDate(1)">
                    <input placeholder='HH:MM:SS' class="ToTime" id="ToTime" onkeypress="return isNumberKey(event)" onblur='return isToDate("");' name="ToTime" type="text" class="time" />
                </div>
            </div>
        </div>

        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12"><input type="hidden" name="resultcnt" id="resultcnt">
                <?php
            echo $this->Form->button('Create QC Batch', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search',  'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));

            echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));

        echo $this->Form->end();
        ?>
            </div>
        </div>

         <?php
                $Module=array(0=>'--Select--');
                $TypeArr=array('0'=>'No',1=>'Yes',2=>'No',''=>'No');
                  echo '<div id="LoadDate">';
                 // echo $this->Form->input('Module Name', array('options' => $Module,'type'=>'hidden', 'id' => 'ModuleId', 'name' => 'ModuleId', 'class'=>'form-control')); 
                  echo '</div>';
                ?>
    </div>
</div>
        <?php 
if (count($SelectQCBatch) > 0) {
?>
<div class="container-fluid">
    <div class="bs-example">
        <div id="vertical">
            <div id="top-pane">
                <div id="horizontal" style="height: 100%; width: 100%;">
                    <div id="left-pane" class="pa-lef-10">
                        <div class="pane-content" >
                            <input type="hidden" name="UpdateId" id="UpdateId">
                            <button style="float:right; height:18px; visibility: hidden; margin-right:15px;" type='hidden' name='downloadFile' id='downloadFile' value='downloadFile'></button>
                            <table style='width:100%;' class="table table-striped table-center" id='example'>
                                <thead>
                                    <tr class="Heading">
                                        <th class="Cell" width="10%">Project</th> 
                                        <th class="Cell" width="10%">Region</th> 
                                        <th class="Cell" width="10%">Process Name</th>
                                        <th class="Cell" width="10%">User Group</th>
                                        <th class="Cell" width="10%">Status</th>
                                        <th class="Cell" width="10%">Batch Name</th>
                                        <th class="Cell" width="10%">Entity Count</th>
                                        <th class="Cell" width="10%">Production Start Date</th>
                                        <th class="Cell" width="10%">Production End Date</th>
                                        <th class="Cell" width="10%">Batch Created Date</th>
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
                                        $UserGroup = $contentArr['UserGroups'][$input['UserGroupId']];
                                        $StatusType=array(2=>'Ready For Hygenic Check',3=>'Ready For QC Sampling',4=>'TL Rebutal',5=>'Ready For QC',6=>'Ready for Delivery');
                                        $originalStartDate = $input['ProductionStartDate'];
                                        $newStartDate = date("d-m-Y H:i:s", strtotime($originalStartDate));

                                        $originalEndDate = $input['ProductionEndDate']; 
                                        $newEndDate = date("d-m-Y H:i:s", strtotime($originalEndDate));

                                        $CreatedDate = $input['CreatedDate']; 
                                        $newCreatedDate = date('d-m-Y H:i:s', strtotime($CreatedDate));
                                            ?>
                                    <tr>
                                        <td><?php echo $Projects[$input['ProjectId']]; ?></td>
                                        <td><?php echo $RegionName; ?></td>
                                        <td><?php echo $ModuleName; ?></td>
                                        <td><?php echo $UserGroup; ?></td>
                                        <td><?php echo $StatusType[$input['StatusId']]; ?></td>
                                        <td><?php echo $input['BatchName']; ?></td>
                                        <td><?php echo $input['EntityCount']; ?></td>
                                        <td><?php echo $newStartDate; ?></td>
                                        <td><?php echo $newEndDate; ?></td>
                                        <td><?php echo $newCreatedDate; ?></td>
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
</div>

<?php
}
echo $this->Form->end();
?>

<script type="text/javascript">

    $(document).ready(function () {
        $("#vertical").kendoSplitter({
            orientation: "vertical",
            panes: [
                {collapsible: false},
                {collapsible: false, size: "100px"},
                {collapsible: false, resizable: false, size: "100px"}
            ]
        });

        $("#horizontal").kendoSplitter({
            panes: [
                {collapsible: true},
                {collapsible: false},
                {collapsible: true}
            ]
        });
    });
</script>
<style>
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
<script type="text/javascript">
    $(document).ready(function (projectId) {
<?php
$js_array = json_encode($ProdDB_PageLimit);

echo "var mandatoryArr = " . $js_array . ";\n";
?>
        var pageCount = mandatoryArr;
        //$.fn.dataTable.moment('DD-MM-YYYY HH:mm:ss');
        //$.fn.dataTable.moment( 'dddd, DD/MM/YYYY' );
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
        //{ "bSearchable":false, "aTargets": [0,6,7] }
        //{ "bSortable": false, "aTargets": [0,6,7] },
        //  var id = $('#RegionId').val();

        //        if ($('#ProjectId').val() != '') {
        //            getRegion();
        //            var e = document.getElementById("RegionId");
        //            var strUser = e.options[e.selectedIndex].text;
        //
        //        }

    });
    $(document).ready(function (projectId) {
        var id = $('#RegionId').val();

        // alert(id);
        if ($('#ProjectId').val() != '') {
            getRegion();
            var e = document.getElementById("RegionId");
            var strUser = e.options[e.selectedIndex].text;
        }
    });

    function getRegion(projectId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCBatchMaster', 'action' => 'ajaxregion')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'QCBatchMaster', 'action' => 'ajaxmodule')); ?>",
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
            url: "<?php echo Router::url(array('controller' => 'QCBatchMaster', 'action' => 'getusergroupdetails')); ?>",
            data: ({projectId: ProjectId, regionId: RegionId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadUserGroup').innerHTML = result;
            }
        });
    }
    function getAvailableDate(val) {
        if (val != 0) {
            $('#LoadDate').show();
            var ProjectId = $('#ProjectId').val();
            var RegionId = $('#RegionId').val();
            var ModuleId = $('#ModuleId').val();
            var UserGroupId = $('#UserGroupId').val();
            var batch_from = $('#batch_from').val();
            var FromTime = $('#FromTime').val();
            //alert(FromTime);
            var batch_to = $('#batch_to').val();
            var ToTime = $('#ToTime').val();

            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'QCBatchMaster', 'action' => 'getProductionData')); ?>",
                data: ({ProjectId: ProjectId, RegionId: RegionId, ModuleId: ModuleId, UserGroupId: UserGroupId,batch_from:batch_from,FromTime:FromTime,batch_to:batch_to,ToTime:ToTime}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    document.getElementById('LoadDate').innerHTML = result;
                }
            });
        } else {
            $('#LoadDate').hide();
        }
    }
    function ClearFields()
    {
        $('#ProjectId').val('0');
        $('#RegionId').val('0');
        $('#ModuleId').val('0');
        $('#ModuleIds').val('0');
        $('#UserGroupId').val('0');
        $('#batch_from').val('');
        $('#batch_to').val('');
        $('#FromTime').val('');
        $('#ToTime').val('');
        $('#LoadDate').hide();

    }

    function Mandatory()
    {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        var hour = today.getHours();
        var minute = today.getMinutes();
        var seconds = today.getSeconds();

        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();

        var hour = todaydate.getHours();
        var minute = todaydate.getMinutes();
        var seconds = todaydate.getSeconds();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }
        if (hour < 10) {
            hour = '0' + hour
        }

        if (minute < 10) {
            minute = '0' + minute
        }

        if (seconds < 10) {
            seconds = '0' + seconds
        }
        today = dd + '-' + mm + '-' + yyyy;
        todaydate = yyyy + '-' + mm + '-' + dd;
        var time = hour + ':' + minute + ':' + seconds;

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
            alert('Select Module');
            $('#ModuleId').focus();
            return false;
        }
        if ($('#UserGroupId').val() == 0) {
            alert('Select User Group');
            $('#UserGroupId').focus();
            return false;
        }

        if (($('#batch_from').val() == '') && ($('#batch_to').val() == ''))
        {
            alert('Select any date!');
            $('#batch_from').focus();
            return false;
        }
        if (($('#batch_from').val() == '') && ($('#batch_to').val() != ''))
        {
            alert('Select From date!');
            $('#batch_from').focus();
            return false;
        }

        var date = $('#batch_from').val();
        var datearray = date.split("-");
        var batch_from = datearray[2] + '-' + datearray[1] + '-' + datearray[0];

        var date = $('#batch_to').val();
        var datearray = date.split("-");
        var batch_to = datearray[2] + '-' + datearray[1] + '-' + datearray[0];

//        if ($('#batch_from').val() > today) {
//            alert("Future Date is not Allowed!");
//            $('#batch_from').focus();
//            return false;
//        }
        if (batch_from > todaydate) {
            alert("Future Date is not Allowed!");
            $('#batch_from').focus();
            return false;
        }
        if ((batch_from >= todaydate) && ($('#FromTime').val() > time)) {
            alert("Start Time must be lesser than or equal to current Time!");
            $('#FromTime').focus();
            return false;
        }
        if (($('#batch_from').val() != '') && ($('#batch_to').val() == ''))
        {
            alert('Select To date!');
            $('#batch_to').focus();
            return false;
        }
//        if ($('#batch_to').val() > today) {
//            alert("Future Date is not Allowed!");
//            $('#batch_to').focus();
//            return false;
//        }
        if (batch_to > todaydate) {
            alert("Future Date is not Allowed!");
            $('#batch_to').focus();
            return false;
        }
        if ((batch_to >= todaydate) && ($('#ToTime').val() > time)) {
            alert("End Time must be lesser than or equal to current Time!");
            $('#ToTime').focus();
            return false;
        }
        var start = $('#FromTime').val();
        var end = $('#ToTime').val();
        if ((batch_from == batch_to)) {
            if(end != ''){
            if (start > end) {
                alert("End Time must be greater than or equal to start Time!");
                $('#ToTime').focus();
                return false;
            }
        }
        }
        var ProjectId = $('#ProjectId').val();
        var RegionId = $('#RegionId').val();
        var ModuleId = $('#ModuleId').val();
        var UserGroupId = $('#UserGroupId').val();
        var batch_from = $('#batch_from').val();
        var batch_to = $('#batch_to').val();
        var FromTime = $('#FromTime').val();
        var ToTime = $('#ToTime').val();
        var stoploading = false;
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCBatchMaster', 'action' => 'ajaxcount')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, ModuleId: ModuleId, UserGroupId: UserGroupId, batch_from: batch_from, batch_to: batch_to, FromTime: FromTime, ToTime: ToTime}),
            dataType: 'text',
            async: false,
            success: function (result) {
                $('#resultcnt').val('');
                if (result == 'Incomplete') {
                    alert('Batch Not Created Some Incomplete Records in Selected date');
                    stoploading = true;
                    return false;
                } else {
                    $('#resultcnt').val(result);
                }

            }
        });

        var resultcnt = $('#resultcnt').val();
        if (resultcnt != '') {
            if(resultcnt=='No Record Found'){
                alert('No Record Found for this combinaion!');
                return false;
            }
            else {
            var getConform = confirm("Total Records are " + resultcnt + "!. Are You Sure want to Create Batch?");
            if (getConform) {
                return true;
            } else {
                return false;
            }
            return false;
            }
        } else if (stoploading) {
            return false;
        } else {
            return true;
        }
        return false;
    }
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 58 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    function isFromDate(str)
    {

        var fromTime = $("#" + str + "FromTime").val();
        var pieces = fromTime.split(':');
        var hour = pieces[0];
        var minute = pieces[1];
        var seconds = pieces[2];

        setDate = 'true';
        //Checks for mm/dd/yyyy format.
        if (hour != '' && minute != '') {

            if (hour < 0 || hour > 24)
                setDate = 'wrong';
            else if (minute < 0 || minute > 59)
                setDate = 'wrong';
            else if (seconds < 0 || seconds > 59)
                setDate = 'wrong';

            if (setDate == 'wrong')
            {
                $("#" + str + "FromTime").val('');
                alert('wrong time');
                $('#FromTime').focus();
            } else
            {
                actDate = hour + ':' + minute + ':' + seconds;
                if (str == '')
                    $("#FromTime").val(actDate);
                else
                    $("#" + str).val(actDate);
            }
        }
        
        getAvailableDate(1);
    }

    function isToDate(str)
    {
        var toTime = $("#" + str + "ToTime").val();
        var pieces = toTime.split(':');
        var hour = pieces[0];
        var minute = pieces[1];
        var seconds = pieces[2];

        setDate = 'true';
        //Checks for mm/dd/yyyy format.
        if (hour != '' && minute != '') {
            if (hour < 0 || hour > 24)
                setDate = 'wrong';
            else if (minute < 0 || minute > 59)
                setDate = 'wrong';
            else if (seconds < 0 || seconds > 59)
                setDate = 'wrong';

            if (setDate == 'wrong')
            {
                $("#" + str + "ToTime").val('');
                alert('wrong time');
                $('#ToTime').focus();
            } else
            {
                actDate = hour + ':' + minute + ':' + seconds;
                if (str == '')
                    $("#ToTime").val(actDate);
                else
                    $("#" + str).val(actDate);
            }
        }
         getAvailableDate(1);
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

</style>

