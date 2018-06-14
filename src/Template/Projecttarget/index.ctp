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
 .table tbody{
	 background:#fff;
 }
 .tab-scroll{
	 width:100!important;
	 overflow-x:auto;
 }
 table #example1{
	 width:110%;
 }


</style>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>Monthly Delivered Report</h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>

        
       <div class="col-md-12" >
           
        <div class="col-md-4" >
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">From Date</label>
                <div class="col-sm-6">
                    <input readonly='readonly' placeholder='MM-YYYY' type='text' name='month_from' id='month_from' value='<?php echo $fromdate;?>'>
                </div>
            </div>
        </div>
           <div class="col-md-2"></div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputPassword4" class="col-sm-6 control-label">To Date</label>
                <div class="col-sm-6">				
                    <input readonly='readonly' placeholder='MM-YYYY' type='text' name='month_to' id='month_to' value='<?php echo $todate;?>'>
                </div>
            </div>
        </div>
      <div class="col-md-3"></div>
		</div>


        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12"><input type="hidden" name="resultcnt" id="resultcnt">
                <?php
            echo $this->Form->button('Create Report', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search',  'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()','type' => 'submit'));
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
if (!empty($monthtitle)) {
?>
<div class="container-fluid"  >
    <div class="bs-example">
        <div id="vertical">
   
					
                <div id="chartContainer" style="height: 200px; width: 100%;padding-bottom:10px;"></div>
                        

</div>
</div>
</div>
		


<div class="container-fluid">
    <div class="bs-example">
        <div id="vertical">
            <div id="top-pane">
			
                <div id="horizontal" style="height: 100%; width: 100%;">
                    <div id="left-pane" class="pa-lef-10 col-md-12">
					
                        <div class="pane-content tab-scroll">
                            <table style='width:100%;' class="table table-striped table-center table-hover" id="example1">
                                <thead>
                                    <tr>
										<th class="Cell" width="10%">Menu</th>
										<?php foreach ($monthtitle as $val){ ?>
                                        <th class="Cell" width="10%"><?php echo $val;?></th> 
										<?php } ?>
										
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <!--<tr  data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal" >-->
                                    <tr>
									 <td>Target</td> 
									<?php foreach ($target as $val){ ?>									
                                        <td><?php echo $val;?></td> 
									<?php } ?>
									
									</tr>
									<tr>
									 <td>Completed</td> 
									<?php foreach ($completed as $val){ ?>									
                                     <td><?php echo $val;?></td> 
									<?php } ?>
									
									</tr>
										
										
                                   
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
else{
    ?>
    <table style='width:100%;' class="table table-striped table-center table-hover" id='example'>
                                <thead>
                                    <tr>
					<th style="display:none">Id</th>
                                        <th class="Cell" width="10%">Name</th> 
                                        <th class="Cell" width="10%">Month</th> 
                                    </tr>
									<tr><td>Target</td><td></td></td></tr>									
									<tr><td>Completed</td><td></td></td></tr>
                                </thead>    
    </table>
    <?php
}
echo $this->Form->end();
?><?php echo $this->Html->script('reportchart/canvasjs.min.js'); ?>

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

         

        if (($('#month_from').val() == ''))
        {
            alert('Select From Month!');
            $('#month_from').focus();
            return false;
        }
		 if (($('#month_to').val() == ''))
        {
            alert('Select To Month!');
            $('#month_to').focus();
            return false;
        }
		
        var batch_from = $('#month_from').val();
        var batch_to = $('#month_to').val();
        return true;
	 

	 
       
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
 <script type="text/javascript">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Monthly Delivered Chart"      
      },   
	  axisX: {
				
			},
      data: [{        
        type: "column",
        <?php echo $fchart;?>
      },
      {        
        type: "column",
        <?php echo $f2chart;?>
      }        
      ]
    });

    chart.render();
  }
  </script>
  
  <!--<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
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

