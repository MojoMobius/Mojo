<!--Form : Dropdown Mapping
  Developer: Sivaraj K
  Created On: Sep 20 2016 -->
<?php

use Cake\Routing\Router; 

?>


<script type="text/javascript">

    $(document).ready(function () {
<?php
$js_array = json_encode($ProdDB_PageLimit);
echo "var mandatoryArr = " . $js_array . ";\n";
//echo "var mandatoryArr = "10 ";\n";
?>
        //var projectId = 3346;
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
                {"bSearchable": false,
                    //"aTargets": [5]
                }
            ]
        });
    });

</script>

<style>
    .hot table { 
        border-spacing: 10px;
    }
    tr {
        cursor: pointer !important;
    }
    .no-cursor{
        cursor: default;
        text-align: center;
    }
    .modal-header {

        background-color: #337AB7;
        width:100%;

        padding:10px 16px;

        color:#FFF;

        border-bottom:2px dashed #337AB7;

    }
    .hot td{
        padding:10px;
    }
    .container-fluid{
        padding-bottom:10px;
    }

</style>
<script type="text/javascript">
    $(function () {
        $("#file").change(function () {
            $("#fileuploads").show();
            $("#submitbtwn").hide();

        });

    });

    function validatefileForm()
    {

        if ($('#ProjectId').val() == 0)
        {
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
        if ($('#RegionId').val() == 0)
        {
            alert('Select Region Name');
            $('#RegionId').focus();
            return false;
        }
        if ($('#ModuleId').val() == 0)
        {
            alert('Select Module Name');
            $('#ModuleId').focus();
            return false;
        }
        if ($('#LoadPrimaryAttributeids').val() == 0)
        {
            alert('Select Primary Attribute List');
            $('#LoadPrimaryAttributeids').focus();
            return false;
        }
        if ($('#LoadSecondaryAttributeids').val() == 0)
        {
            alert('Select Secondary Attribute List');
            $('#LoadSecondaryAttributeids').focus();
            return false;
        }

        if ($('#file').val() == '')
        {
            alert('Choose a file for Upload');
            $('#file').focus();
            return false;
        }


    }

    function validateForm()
    {
        if ($('#ProjectId').val() == 0)
        {
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
        if ($('#file').val() == '')
        {
            alert('Choose Upload file ');
            $('#file').focus();
            return false;
        }

        //  document.getElementById('myFileInput').files.length


    }

    function getStatus(ProjectId) {
        //alert(ProjectId);
        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Inputinitiate', 'action' => 'ajaxStatus')); ?>",
            data: ({ProjectId: ProjectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                //alert(result);
                document.getElementById('LoadStatus').innerHTML = result;
            }
        });
    }


</script>


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

<div class="container-fluid">
    <div class="jumbotron formcontent">
        <h4>Input Initiate</h4>
        <?php echo $this->Form->create($OptionMaster, array('class' => 'form-horizontal', 'id' => 'projectforms','enctype' => 'multipart/form-data')); ?>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
                    <?php echo $ProListopt; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-5 control-label" style="">Choose File</label>
                <div class="col-sm-6">
                    <span><input type="file" name="file" id="file"  style="border:none;">
                    </span>
                    <br>(Allowed Formats:.xls and .xlsx)

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Status</label>
                <div class="col-sm-6">
                    <?php $Module = array(0 => '--Select--'); ?>
                    <div id="LoadStatus">
                        <?php
                        echo $ModuleList;
                        if ($ModuleList == '') {
                            ?>
                        <select class="form-control" id="module">
                            <option selected>--Select--</option>
                        </select>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group" style="text-align:center;display:none;" id="fileuploads">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm" value="Submit" id="submit" name="submit" onclick="return validatefileForm()">Upload</button>
            </div>
        </div>



        <div id="submitbtwn" class="form-group" style="text-align:center;">
            <div class="col-sm-12">

                <button type="submit" class="btn btn-primary btn-sm" value="Submit" id="submit" name="submit" onclick="return validateForm()">Submit</button>
            </div>
        </div>

        <?php echo $this->Form->end(); ?>
    </div>


</div>

<?php 
if (count($list) > 0) {
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
                                        <th class="Cell" hidden="">Id</th> 
                                        <th class="Cell" width="10%">Project</th> 
                                        <th class="Cell" width="10%">Region</th> 
                                        <th class="Cell" width="10%">File Name</th>
                                        <th class="Cell" width="10%">Status</th>
                                        <th class="Cell" width="10%">Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($list as $inputVal => $input):
                                        $path = JSONPATH . '\\ProjectConfig_' . $input['ProjectId'] . '.json';
                                        $content = file_get_contents($path);
                                        $contentArr = json_decode($content, true);
                                        $RegionName = $contentArr['RegionList'][$input['Region']];
                                        $StatusType = $contentArr['ProjectStatus'];

                                        $CreatedDate = $input['CreatedDate']; 
                                        $newCreatedDate = date('d-m-Y H:i:s', strtotime($CreatedDate));
                                        $basefilepath_file =  $this->request->webroot.$basefilepath.'/'.$input['FileName'];
                                        
                                            ?>
                                    <tr>
                                        <td hidden=""><?php echo $i; ?></td>
                                        <td><?php echo $Projects[$input['ProjectId']]; ?></td>
                                        <td><?php echo $RegionName; ?></td>
                                        <td><?php echo "<a href='$basefilepath_file'> ".$input['FileName']."</a>"; ?></td>
                                        <td><?php echo $input['ResponseData']; ?></td>
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


