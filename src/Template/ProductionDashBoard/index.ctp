<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--<link rel="stylesheet" href="/webroot/css/font-awesome.min.css">-->
<?php
use Cake\Routing\Router;
?>
<style>
.panel{
	height:425;
	width:100%;
	margin:10px 0px;
}
.setting-popup .widget-item {
    display: flex;
    align-items: center;
    padding: 5px 0px;
    justify-content: space-between;
    border-bottom: 1px solid rgb(231, 231, 231);
	margin-bottom:10px;
    }
	.widget-item > span {
    font-weight: bold;
    color: #666;
    margin-right: 20px;
}
.setting-popup .widget-item .switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 28px;
    margin-bottom: 0;
}
.setting-popup.widget-item label {
    color: #555555;
    font-size: 12pt;
}
.switch {
    position: relative;
    display: inline-block;
    width: 55px;
    height: 28px;
    margin-bottom: 0;
}

.switch input {display:none;}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 21px;
  width: 21px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 28px;
}

.slider.round:before {
  border-radius: 50%;
}
.set-filter{
	padding-top:15px;
}
.set-border {
    border-bottom: 1px dashed #ADADAD;
}
.set-border p{
	font-size:20px;
	padding:5px;
	font-weight:600;
}
.setting-ico{
	padding-top:10px;
}
.setting-ico i {font-size: 20pt; cursor: pointer;color:#6b6d70;}
.setting-ico i:hover {color: #4397e6;}
</style>
<div class="container-fluid">
    <div class=" jumbotron formcontent">
         <div class="col-md-12 set-border"><div class="col-md-11"> <p>Quality Dashboard </p></div> <div class="col-md-1 setting-ico"> <i class="fa fa-cog pull-right" data-toggle="modal" data-target="#widget-modal"></i></div></div>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms')); ?>
 <div class="col-md-12 set-filter"> 
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
        <a href="../../../../../../../C:/Users/vgs-user/Downloads/Mojo docu/mojo-v8/production-dashboard.html"></a>


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

                <div class="row" id="monitor-list">
                    <div class="col-md-12">
                        <div class="col-md-6">

                            <div class="col-md-12 panel" style="min-height: 425px;width: 100%;margin-top:10px;" id="chart-results">
                                <b>Over all</b> 
                                <div id="linechartContainer"></div>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 panel" style="min-height: 425px;width: 100%;margin-top:10px;" id="">
                                <b>Error Distribution</b> 
                                <div id="errorchartContainer"></div>


                            </div>
                        </div>

                        <div class="col-md-12">

                           <div class="col-md-12 panel" style="height: 500px;width: 100%;margin-top:10px;" id="">
                                <b>Error Distribution</b> 
        
                                <div id="errorbarchartContainer"></div>


                            </div>
                        </div>

                         <div class="col-md-12">
                            <div class="col-md-12 panel" style="height: 700px;width: 100%;" id="">
                          <b>Right First Time - Campaign Level</b>
                          <div id="errorcampaignlevelContainer">
                              
           <div class="col-md-12 panel data-table" style="padding-bottom:20px;">
            <p class="graph-title">Right First Time - Campaign Level</p>
            <div class="table-responsive">
              <table class="table table-striped dataTable no-footer" id="data-table">
                <thead>
                  <tr>
                    <th class="sorting_disabled">Table Name</th>
                    <th class="sorting_disabled">Field Name</th>
                    <th class="sorting_disabled">X</th>
                    <th class="sorting_disabled">A</th>
                    <th class="sorting_disabled">D</th>
                    <th class="sorting_disabled">M</th>
                    <th class="sorting_disabled">V</th>
                    <th class="sorting_disabled">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row">
                    <th rowspan="21">Organization Information</th>
                    <td>Disposition_Organization Name</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>722</td>
                    <td>15186</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Organization Category_A</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>15908</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Organization Status_A</td>
                    <td>15901</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>7</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Organization Name Type_A</td>
                    <td>2233</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>13675</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Acronym_A</td>
                    <td>15506</td>
                    <td></td>
                    <td>1</td>
                    <td></td>
                    <td>401</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Inception Date_A</td>
                    <td>7044</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>8864</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Main URL Address_A</td>
                    <td>5083</td>
                    <td>381</td>
                    <td>696</td>
                    <td>816</td>
                    <td>8932</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Location Type_A</td>
                    <td></td>
                    <td>14</td>
                    <td></td>
                    <td>1</td>
                    <td>15893</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Address Status_A</td>
                    <td>15863</td>
                    <td>36</td>
                    <td>9</td>
                    <td></td>
                    <td></td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Physical Street_A</td>
                    <td></td>
                    <td>9</td>
                    <td>36</td>
                    <td>5731</td>
                    <td>10132</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Physical City_A</td>
                    <td>1</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2181</td>
                    <td>13722</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Physical State_A</td>
                    <td>9145</td>
                    <td>91</td>
                    <td>2</td>
                    <td>174</td>
                    <td>6496</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Physical Country_A</td>
                    <td></td>
                    <td>5</td>
                    <td></td>
                    <td>34</td>
                    <td>15869</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Physical Postal1_A</td>
                    <td>2709</td>
                    <td>267</td>
                    <td>75</td>
                    <td>3718</td>
                    <td>9139</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Physical Subdivision_A</td>
                    <td>15868</td>
                    <td>1</td>
                    <td>5</td>
                    <td>1</td>
                    <td>33</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Disposition_English Spoken</td>
                    <td>5154</td>
                    <td>1653</td>
                    <td>624</td>
                    <td>1696</td>
                    <td>6781</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Mailing Street_A</td>
                    <td>13482</td>
                    <td>578</td>
                    <td>412</td>
                    <td>105</td>
                    <td>1331</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Mailing City_A</td>
                    <td>13481</td>
                    <td>576</td>
                    <td>414</td>
                    <td>59</td>
                    <td>1378</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Mailing State_A</td>
                    <td>14858</td>
                    <td>259</td>
                    <td>373</td>
                    <td>2</td>
                    <td>416</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Mailing Country_A</td>
                    <td>13477</td>
                    <td>580</td>
                    <td>413</td>
                    <td></td>
                    <td>1438</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <td>Mailing Postal1_A</td>
                    <td>14109</td>
                    <td>476</td>
                    <td>384</td>
                    <td>189</td>
                    <td>750</td>
                    <td>15908</td>
                  </tr>
                  <tr>
                    <th>Location Email</th>
                    <td>Email Address_A</td>
                    <td></td>
                    <td>2147</td>
                    <td>2189</td>
                    <td>1</td>
                    <td>7256</td>
                    <td>11593</td>
                  </tr>
                  <tr>
                    <th>Languages</th>
                    <td>Languages_A</td>
                    <td></td>
                    <td>11632</td>
                    <td>1315</td>
                    <td></td>
                    <td>3117</td>
                    <td>16064</td>
                  </tr>
                  <tr>
                    <th rowspan="6">Phone</th>
                    <td>PhoneType_A</td>
                    <td>50</td>
                    <td>8297</td>
                    <td>9183</td>
                    <td>335</td>
                    <td>13507</td>
                    <td>31372</td>
                  </tr>
                  <tr>
                    <td>Area Code_A</td>
                    <td>24936</td>
                    <td>844</td>
                    <td>4310</td>
                    <td></td>
                    <td>1282</td>
                    <td>31372</td>
                  </tr>
                  <tr>
                    <td>City Code_A</td>
                    <td>14669</td>
                    <td>6805</td>
                    <td>2292</td>
                    <td>119</td>
                    <td>7487</td>
                    <td>31372</td>
                  </tr>
                  <tr>
                    <td>Phone Number_A</td>
                    <td></td>
                    <td>8281</td>
                    <td>9233</td>
                    <td>2640</td>
                    <td>11218</td>
                    <td>31372</td>
                  </tr>
                  <tr>
                    <td>Country Calling Code_A</td>
                    <td>6854</td>
                    <td>7211</td>
                    <td>4865</td>
                    <td>33</td>
                    <td>12409</td>
                    <td>31372</td>
                  </tr>
                  <tr>
                    <td>Phone Text_A</td>
                    <td>31354</td>
                    <td></td>
                    <td>18</td>
                    <td></td>
                    <td></td>
                    <td>31372</td>
                  </tr>
                  <tr>
                    <th rowspan="2">Social Media</th>
                    <td>Social Media Type_A</td>
                    <td>4</td>
                    <td>2328</td>
                    <td>27</td>
                    <td></td>
                    <td>4448</td>
                    <td>6807</td>
                  </tr>
                  <tr>
                    <td>Social Media Handle_A</td>
                    <td>4</td>
                    <td>2328</td>
                    <td>28</td>
                    <td>2</td>
                    <td>4445</td>
                    <td>6807</td>
                  </tr>
                  <tr>
                    <th rowspan="2">Variant Name</th>
                    <td>Variant Name_A</td>
                    <td></td>
                    <td></td>
                    <td>156</td>
                    <td>1</td>
                    <td>26</td>
                    <td>183</td>
                  </tr>
                  <tr>
                    <td>Organization Name Type_A</td>
                    <td>2</td>
                    <td></td>
                    <td>154</td>
                    <td></td>
                    <td>27</td>
                    <td>183</td>
                  </tr>
                  <tr>
                    <th>ISO</th>
                    <td>ISO_A</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>0</td>
                  </tr>
                  <tr>
                    <th>Secondary URL</th>
                    <td>URL Address_A</td>
                    <td></td>
                    <td></td>
                    <td>22</td>
                    <td></td>
                    <td>66</td>
                    <td>88</td>
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

                <!--                <div id="horizontal" style="height: 100%; width: 100%;">
                
                
                                    <div id="left-pane" class="pa-lef-10" style="display: none;">
                                        <div class="pane-content" >
                                            <div id="no-results-found" style="display:none;" >
                                                No Results found
                                            </div>
                
                                            
                
                
                                        </div>
                                    </div>
                                </div>-->
            </div>
        </div>
    </div>
</div>
       <!-- Widget Modal -->
        <div class="modal fade setting-popup" id="widget-modal" aria-hidden="true" aria-labelledby="widget-modal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="exampleModalTitle">Widget Settings</h4>
            </div>
            <div class="modal-body">
                <div class="widget-item" >
                  <span>Over All</span>
                  <label class="switch">
                      <input type="checkbox" checked>
                      <span class="slider round"></span>
                    </label>
                </div>
                <div class="widget-item" >
                    <span>Error Distribution</span>
                    <label class="switch">
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                      </label>
                  </div>
                  <div class="widget-item" >
                      <span>Issues</span>
                      <label class="switch">
                          <input type="checkbox" checked>
                          <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="widget-item">
                      <span>Right First Time</span>
                      <label class="switch">
                          <input type="checkbox" checked>
                          <span class="slider round"></span>
                        </label>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Widget Modal -->

<?php
}
echo $this->Form->end();

?>
<?php echo $this->Html->script('reportchart/canvasjs.min.js'); ?>



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

    function LineChartreports(chartres) {

        var chart = new CanvasJS.Chart("linechartContainer", {
            title: {
                text: ""
            },
            axisY: {
                title: "Data"
            },
            data: chartres

        });
        chart.render();

    }


    function pieErrorchartreports(chartres) {

        var chart = new CanvasJS.Chart("errorchartContainer", {
            theme: "light2",
            animationEnabled: true,
            title: {
                text: ""
            },
            subtitles: [{
                    text: "",
                    fontSize: 16
                }],
            data: [{
                    type: "pie",
                    indexLabelFontSize: 15,
                    radius: 170,
                    indexLabel: "{label} - {y}",
                    yValueFormatString: "###0.0'%'",
                    click: explodePie,
                    dataPoints: chartres

                }]
        });
        chart.render();
    }

    function explodePie(e) {
        for (var i = 0; i < e.dataSeries.dataPoints.length; i++) {
            //if(i !== e.dataPointIndex)
            //e.dataSeries.dataPoints[i].exploded = false;
        }
    }


    function Errorbarchart(chartres) {

        var chart = new CanvasJS.Chart("errorbarchartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: ""
            },
            legend: {
                dockInsidePlotArea: true,
                verticalAlign: "center",
                horizontalAlign: "right",
				maxWidth:300,
            },
            dataPointWidth: 5,
            data:chartres
//            data: [{
//                    type: "column",
//                    showInLegend: true,
//                    yValueFormatString: "#,##0.## tonnes",
//                    name: "Target",
//                    dataPoints: chartres
//                }, {
//                    type: "column",
//                    name: "Achieved",
//                    showInLegend: true,
//                    yValueFormatString: "#,##0.## tonnes",
//                    dataPoints: chartres
//                }
//            ]
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
//        $("#chart-results").hide();
//        var today = new Date();
//        var dd = today.getDate();
//        var mm = today.getMonth() + 1; //January is 0!
//        var yyyy = today.getFullYear();
//
//        var hour = today.getHours();
//        var minute = today.getMinutes();
//        var seconds = today.getSeconds();
//
//        var todaydate = new Date();
//        var dd = todaydate.getDate();
//        var mm = todaydate.getMonth() + 1; //January is 0!
//        var yyyy = todaydate.getFullYear();
//
//        var hour = todaydate.getHours();
//        var minute = todaydate.getMinutes();
//        var seconds = todaydate.getSeconds();
//
//        if (dd < 10) {
//            dd = '0' + dd
//        }
//
//        if (mm < 10) {
//            mm = '0' + mm
//        }
//        if (hour < 10) {
//            hour = '0' + hour
//        }
//
//        if (minute < 10) {
//            minute = '0' + minute
//        }
//
//        if (seconds < 10) {
//            seconds = '0' + seconds
//        }
//        today = dd + '-' + mm + '-' + yyyy;
//        todaydate = yyyy + '-' + mm + '-' + dd;
//        var time = hour + ':' + minute + ':' + seconds;
//
//        if ($('#ProjectId').val() == 0) {
//            alert('Select Project Name');
//            $('#ProjectId').focus();
//            return false;
//        }
//
//
//        if (($('#month_from').val() == ''))
//        {
//            alert('Select From date!');
//            $('#month_from').focus();
//            return false;
//        }
//
//        if (($('#month_from').val() == '') && ($('#month_to').val() != ''))
//        {
//            alert('Select From date!');
//            $('#month_from').focus();
//            return false;
//        }
//
//        var date = $('#month_from').val();
//        var datearray = date.split("-");
//        var month_from = datearray[2] + '-' + datearray[1] + '-' + datearray[0];

        $("#left-pane").show();
        $(".validationloader").show();
        $(".container-fluid").css("opacity", 0.5);

        setTimeout(function () {
            AjaxValidationstart();
        }, 500);


        return false;
    }

    function AjaxValidationstart() {

        var ProjectId = $('#ProjectId').val();
        var month_from = $('#month_from').val();
        var month_to = $('#month_to').val();
        var txt_td = "";


    $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'productiondashboard', 'action' => 'getdashboardchartreports')); ?>",
            data: ({ProjectId: ProjectId, month_from: month_from, month_to: month_to}),
            dataType: 'text',
            async: false,
            success: function (result) {

                var results = JSON.parse(result);
               
                // line chart
                if (results.linechart.total > 0) {
                    LineChartreports(results.linechart.chartres);
                }
                
                // pie-chart
                if (results.piechart.total > 0) {
                    pieErrorchartreports(results.piechart.chartres);
                }
                
                 //bar chart 
                if (results.barchart.total > 0) {
                    Errorbarchart(results.barchart.chartres);
                }
                
                
//                console.log(results.linechart.total);debugger;
                
                
                $(".validationloader").hide();
                $(".container-fluid").css("opacity", '');
            }
        });


        return 1;
      
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

