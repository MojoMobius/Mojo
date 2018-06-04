<?php

use Cake\Routing\Router;
?>
<style>
.hot table { 
    border-spacing: 10px;
}
table.dataTable tbody tr {
    cursor: pointer !important;
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
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>QA Review Report</h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>
 <div class="col-md-12" >
     
          
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
                    <?php
                    echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control prodash-txt', 'value' => $this->request->data('ProjectId')));
                    ?>
                </div>
            </div>
        </div>
     <div class="col-md-2"></div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Status</label>
                <div class="col-sm-6" >
                     <?php
                    echo $this->Form->input('', array('options' => $Status, 'id' => 'StatusId', 'name' => 'StatusId', 'class' => 'form-control prodash-txt', 'value' => $this->request->data('StatusId')));
                    ?>
                </div>
            </div>
        </div>
      <div class="col-md-3"></div>
</div>
        
       <div class="col-md-12" >
           
        <div class="col-md-4" >
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Batch Created Date From</label>
                <div class="col-sm-6">
                    <input readonly='readonly' placeholder='DD-MM-YYYY' type='text' name='batch_from' id='batch_from' value='<?php echo $fromdate;?>'>
                </div>
            </div>
        </div>
           <div class="col-md-2"></div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword4" class="col-sm-6 control-label">Batch Created Date To</label>
                <div class="col-sm-6">
				<?php if($todate !=""){
					$placeholder=$todate;
				}
				else{
					$placeholder="DD-MM-YYYY";
				}
				?>
                    <input readonly='readonly' placeholder='DD-MM-YYYY' type='text' name='batch_to' id='batch_to' value='<?php echo $todate;?>'>
                </div>
            </div>
        </div>
      <div class="col-md-3"></div>
		</div>


        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12"><input type="hidden" name="resultcnt" id="resultcnt">
                <?php
            echo $this->Form->button('Create QA Review', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search',  'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()','type' => 'submit'));
	        echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));
            echo $this->Form->button('Export QA Review Results', array('id' => 'downloadFile', 'name' => 'downloadFile', 'value' => 'downloadFile', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()', 'type' => 'submit'));
            
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
                        <div class="pane-content" id="ajxload_data" >
                            <input type="hidden" name="UpdateId" id="UpdateId">
                            <button style="float:right; height:18px; visibility: hidden; margin-right:15px;" type='hidden' name='downloadFile' id='downloadFile' value='downloadFile'></button>
                            <table style='width:100%;' class="table table-striped table-center table-hover" id='example'>
                                <thead>
                                    <tr>
										<th style="display:none">Id</th>
                                        <th class="Cell" width="10%">Batch Created Date</th> 
                                        <th class="Cell" width="10%">Project</th> 
                                        <th class="Cell" width="10%">Batch Name</th>
                                        <th class="Cell" width="10%">Status</th>
                                        <th class="Cell" width="10%">Batch Size</th>
                                        <th class="Cell" width="10%">Sample Size</th>
                                        <th class="Cell" width="10%">QC Completed</th>
                                        <th class="Cell" width="10%">Pending</th>
                                        <th class="Cell" width="10%">Final AOQ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($SelectQCBatch as $inputVal => $input):
                                        
                                            ?>
                                    <!--<tr  data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal" >-->
                                    <tr >
										<td style="display:none"><?php echo $input['Id'];?></td>  
										<td><?php echo $input['CreatedDate']; ?></td>
                                        <td><?php echo $Projects[$input['ProjectId']]; ?></td>
                                        <td><?php echo $input['BatchName']; ?></td>
                                        <td><?php echo $input['StatusId']; ?></td>
                                        <td><?php echo $input['EntityCount']; ?></td>
                                        <td><?php echo $input['SampleCount']; ?></td>
                                        <td><?php echo $input['QCCompletedCount']; ?></td>
                                        <td><?php echo $input['QCpending']; ?></td>
                                        <td><?php echo $input['aoq']; ?></td>
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
		 <!-- Popup new Modal -->
<div class="modal fade modal-fill-in" id="exampleFillPopup" aria-hidden="false" aria-labelledby="exampleFillInHandson" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleFillInHandsonModalTitle"></h4>
                    </div>
                    <div class="modal-body">
                        <div id="example" class="container-fluid" style="margin-bottom:-10px;">
                            <div id="vertical">
                                <div id="top-pane">
                                    <div id="horizontal" style="height: 100%; width: 100%;">
                                        <div id="right-pane">
<div id="example1" class="hot handsontable htColumnHeaders">



</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- Popup new Modal -->

<?php
}
else{
    ?>
    <table style='width:100%;' class="table table-striped table-center table-hover" id='example'>
                                <thead>
                                    <tr>
					<th style="display:none">Id</th>
                                        <th class="Cell" width="10%">Batch Created Date</th> 
                                        <th class="Cell" width="10%">Project</th> 
                                        <th class="Cell" width="10%">Batch Name</th>
                                        <th class="Cell" width="10%">Status</th>
                                        <th class="Cell" width="10%">Batch Size</th>
                                        <th class="Cell" width="10%">Sample Size</th>
                                        <th class="Cell" width="10%">QC Completed</th>
                                        <th class="Cell" width="10%">Pending</th>
                                        <th class="Cell" width="10%">Final AOQ</th>
                                    </tr>
                                </thead>    
    </table>
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
        var id = $('#StatusId').val();

        // alert(id);
        if ($('#ProjectId').val() != '') {
            getStatus();
            var e = document.getElementById("StatusId");
            var strUser = e.options[e.selectedIndex].text;
        }
    });

    function getStatus(projectId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QAreview', 'action' => 'ajaxstatus')); ?>",
            data: ({projectId: projectId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadStatus').innerHTML = result;
            }
        });
    }
    
    
    function ClearFields()
    {
        $('#ProjectId').val('0');
        $('#StatusId').val('0');
        $('#batch_from').val('');
        $('#batch_to').val('');

    }

    function Mandatory()
    {
	
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        var todaydate = new Date();
        var dd = todaydate.getDate();
        var mm = todaydate.getMonth() + 1; //January is 0!
        var yyyy = todaydate.getFullYear();  

       
        today = dd + '-' + mm + '-' + yyyy;
        todaydate = yyyy + '-' + mm + '-' + dd;

        if ($('#ProjectId').val() == 0) {
            alert('Select Project Name');
            $('#ProjectId').focus();
            return false;
        }
        if ($('#StatusId').val() == 0) {
            alert('Select Status Name');
            $('#StatusId').focus();
            return false;
        }       

        if (($('#batch_from').val() == ''))
        {
            alert('Select From date!');
            $('#batch_from').focus();
            return false;
        }
       /* if (($('#batch_from').val() == '') && ($('#batch_to').val() != ''))
        {
            alert('Select From date!');
            $('#batch_from').focus();
            return false;
        }*/

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
        
//        if ($('#batch_to').val() > today) {
//            alert("Future Date is not Allowed!");
//            $('#batch_to').focus();
//            return false;
//        }

        
        var ProjectId = $('#ProjectId').val();
        var StatusId = $('#StatusId').val();
        var batch_from = $('#batch_from').val();
        var batch_to = $('#batch_to').val();
        return true;
	 
       /* $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QAreview', 'action' => 'index')); ?>",
            data: ({ProjectId: ProjectId, StatusId: StatusId,  batch_from: batch_from, batch_to: batch_to}),
            dataType: 'text',
            async: false,
            success: function (result) {
                $('#ajxload_data').val('');
                if (result == 'Incomplete') {
                    alert('QA Review Created Some Incomplete Records in Selected date');
                    stoploading = true;
                    return false;
                } else {
                    $('#ajxload_data').val(result);
                }

            }
        });*/
	// return true;
	 
       
    }
     function Mandatory_old()
    {
        if ($('#query').val() == '') {
            if ($('#ProjectId').val() == 0) {
                alert('Select Project Name');
                $('#ProjectId').focus();
                return false;
            }
            if ($('#StatusId').val() == 0) {
            alert('Select Region Name');
            $('#RegionId').focus();
            return false;
            }  
            if (($('#batch_from').val() == '') && ($('#batch_to').val() == '') && ($('#user').val() == null))
            {
                alert('Select any one date!');
                $('#batch_from').focus();
                return false;
            }
        }
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
/*
$('#example').find('tr').click( function(){
 var id = $(this).find('td:first').text();
  $.ajax({
		    url: '<?php echo Router::url(array('controller' => 'QAreview', 'action' => 'ajaxgetdata')); ?>',
		    dataType: 'text',
		    type: 'POST',
		    data: {Id: id},
		    success: function (res) {	
		     $(".hot").html(res);
		    }
		});
});*/
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

