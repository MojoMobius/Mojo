<?php

use Cake\Routing\Router;
?>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>Accuracy Trend</h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>

        <div class="col-md-3">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
                    <?php
                    echo $this->Form->input('', array('options' => $Projects, 'id' => 'ProjectId', 'name' => 'ProjectId', 'class' => 'form-control prodash-txt', 'value' => $ProjectId));
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">

                <label for="inputPassword3" class="col-sm-6 control-label">From</label>
                <div class="col-sm-6">
                    <input readonly='readonly' placeholder='MM-YYYY' type='text' name='month_from' id='month_from'>

                </div>

            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">

                <div class="col-sm-6">
                    <label for="inputPassword3" class="col-sm-6 control-label">To</label>
                    <div class="col-sm-6">
                        <input readonly='readonly' placeholder='MM-YYYY' type='text' name='month_to' id='month_to'>

                    </div>

                </div>

            </div>
        </div>



        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12"><input type="hidden" name="resultcnt" id="resultcnt">
                <?php
            echo $this->Form->button('QC Reports', array('id' => 'check_submit', 'name' => 'check_submit', 'value' => 'Search',  'class' => 'btn btn-primary btn-sm', 'onclick' => 'return Mandatory()'));

            echo $this->Form->button('Clear', array('id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear', 'style' => 'margin-left:5px;', 'class' => 'btn btn-primary btn-sm', 'onclick' => 'return ClearFields()', 'type' => 'button'));

        echo $this->Form->end();
        ?>
            </div>
        </div>


    </div>
</div>
        <?php 
if (count($Chartreports) >= 0) {
?>
<div class="validationloader" style="display:none;"></div>
<div class="container-fluid">
    <div class="bs-example">
        <div id="vertical">
            <div id="top-pane">

                <div id="horizontal" style="height: 100%; width: 100%;">


                    <div id="left-pane" class="pa-lef-10" style="display: none;">
                        <div class="pane-content" >
                            <div id="no-results-found" style="display:none;" >
                                No Results found
                            </div>

                            <div style="height: 100%;width: 100%;display:none;" id="chart-results">
                                <div style="height: 100%;width: 33%;float: left;" id="charttable">
                                    <table class="table table-striped table-center">
                                    </table>
                                </div>
                                <div id="chartContainer" style="height: 100%;width: 67%; margin: 0px auto;float: right;"></div>

                            </div>


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
<?php echo $this->Html->script('reportchart/canvasjs.min.js'); ?>

<script type="text/javascript">
    var chart_reports = "<?php //echo json_encode($Chartreports); ?>";
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
    #top-pane  { background-color: rgba(60, 70, 80, 0.05); }
    #left-pane{padding-top:12px !important; background-color: #fff !important;}
    .pane-content {
        padding: 0 10px;
    }
    .lastrow label{position:relative !important;}
    .validationloader {
        border: 8px solid #f3f3f3;
        border-radius: 50%;
        border-top: 8px solid #3498db;
        width: 60px;
        height: 60px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        margin: 59px 0px 6px 630px;
        z-index: 9999;
        position: absolute;
    }
    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>

    function Chartreports(chartres) {

        var chart = new CanvasJS.Chart("chartContainer", {
            title: {
                text: "Accuracy Trend"
            },
            axisY: {
                title: "Data"
            },
            data: chartres

        });

        chart.render();


    }


</script>

<script type="text/javascript">

    function ClearFields()
    {
        $('#ProjectId').val('0');
        $('#month_from').val('');
        $('#month_to').val('');

    }





    function Mandatory()
    {
        $("#chart-results").hide();
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


        if (($('#month_from').val() == ''))
        {
            alert('Select From date!');
            $('#month_from').focus();
            return false;
        }

        if (($('#month_from').val() == '') && ($('#month_to').val() != ''))
        {
            alert('Select From date!');
            $('#month_from').focus();
            return false;
        }

        var date = $('#month_from').val();
        var datearray = date.split("-");
        var month_from = datearray[2] + '-' + datearray[1] + '-' + datearray[0];

//        var date = $('#month_to').val();
//        var datearray = date.split("-");
//        var month_to = datearray[2] + '-' + datearray[1] + '-' + datearray[0];

//        var start = $('#FromTime').val();
//        var end = $('#ToTime').val();
        $("#left-pane").show();
        $(".validationloader").show();
       $(".container-fluid").css("opacity",0.5);
       
        setTimeout(function(){
                AjaxValidationstart(); 
            }, 500);
            
       
        return false;
    }
    
    function AjaxValidationstart(){
        
        var ProjectId = $('#ProjectId').val();
        var month_from = $('#month_from').val();
        var month_to = $('#month_to').val();
        var txt_td = "";
        
     $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Chartsqcbatch', 'action' => 'getChartreports')); ?>",
            data: ({ProjectId: ProjectId, month_from: month_from, month_to: month_to}),
            dataType: 'text',
            async: false,
            success: function (result) {

                var results = JSON.parse(result);
                if (results.total > 0) {

                    if (results.getbatchavgres.length > 0) {
                        $("#charttable > table").html("");
                        $("#chart-results").show();
                        $("#no-results-found").hide();
                        Chartreports(results.chartres);

                        txt_td = "<thead><tr><th>Month</th><th>Accuracy%</th><th>First Pass%</th><th>SLA%</th></tr></thead>";
                        $("#charttable > table").append(txt_td);
                        $.each(results.getbatchavgres, function (key, val) {
                            txt_td = "<tr><td>" + val.monthTxt + "</td><td>" + val.AccuracyTxt + "</td><td>" + val.FirstpassTxt + "</td><td>" + val.sla + "</td></tr>";
                            $("#charttable > table").append(txt_td);
                        });
                    }

                } else {
                    $("#chart-results").hide();
                    $("#no-results-found").show();
                    $("#left-pane").show();
                    $("#charttable > table").html("");
                }
                $(".validationloader").hide();
                 $(".container-fluid").css("opacity",'');
            }
        });
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

    }
</script>
<style>
    .tab-tot{
        background-color: #dadada !important;
    }
    #charttable{
        height: 100%;
        width: 33%;
        float: left;
        margin-top: 10px;
    }
    #no-results-found{
        height: 61%;
        width: 89%;
        text-align: center;
        margin-top: 121px;
        color: red;
        font-size: 20px;
        position: absolute;
    }
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

