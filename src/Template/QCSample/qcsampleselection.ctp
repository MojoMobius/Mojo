<?php
use Cake\Routing\Router;

$path = JSONPATH . '\\ProjectConfig_' .$SelectQCBatch['0']['ProjectId']. '.json';
$content = file_get_contents($path);
$contentArr = json_decode($content, true);

$sampling_showValue = $RuleId_showValue = $SampleCountWithPercentage = 0;
$SampleCount_showValue = "";
//print_r($showValuesArray);
if(isset($showValuesArray)) {
    $sampling_showValue = $showValuesArray['sampling'];
    $RuleId_showValue = $showValuesArray['RuleId'];
    $ReworkId_showValue = $showValuesArray['ReworkId'];
    $SampleCount_showValue = $showValuesArray['SampleCount']; 
    $SampleCountWithPercentage = $showValuesArray['SampleCountWithPercentage']; 
}
?>

<div class="container-fluid">
    <div class=" jumbotron formcontent">
        <h4>QC Sample Selection</h4>
        <?php echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms','name' => 'projectforms')); ?>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project :</label>
                <input name="BatchId" type="hidden" value="<?php echo $SelectQCBatch['0']['Id']; ?>">
                <div class="col-sm-6">
                    <?php echo $Projects[$SelectQCBatch['0']['ProjectId']]; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Region :</label>
                <div class="col-sm-6">
                    <?php echo $contentArr['RegionList'][$SelectQCBatch['0']['RegionId']]; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Batch Name :</label>
                <div class="col-sm-6">
                    <?php echo $SelectQCBatch['0']['BatchName']; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Process Id:</label>
                <div class="col-sm-6">
                    <?php echo $contentArr['Module'][$SelectQCBatch['0']['ProcessId']]; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Sampling :</label>
                <div class="col-sm-6">
                    <input type="radio" <?php if($sampling_showValue==1) { echo "checked"; } ?> class="samplingInputClass" id="sampling1" name="sampling" value="1"> Random Sampling
                    <input type="radio" <?php if($sampling_showValue==2) { echo "checked"; } ?> class="samplingInputClass" id="sampling2" name="sampling" value="2"> Stratified Sampling
                </div>
            </div>
        </div>  
        
        <div class="col-md-4 SamplingTypeBothDivs" id="RuleIdDiv" style="display:none;">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Stratification Rule : </label>
                <div class="col-sm-6">
                    <select id="RuleId" name="RuleId" class="form-control"">
                        <option value='0'>--Select--</option>
                    <?php
                        if(!empty($StratificationRules)) { 
                            foreach($StratificationRules as $value) {
                                if($RuleId_showValue==$value['Id'])
                                    $selectedval = "selected";
                                else
                                    $selectedval = "";
                                echo "<option value='".$value['Id']."' ".$selectedval.">".$value['RuleName']."</option>";
                            }
                        }
                    ?>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 SamplingTypeBothDivs" id="SampleCountDiv" style="display:none;">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Sample Percentage : </label>
                <div class="col-sm-6">
                   
                <div class="col-sm-5">
               <input class="form-control" name="SampleCount" size="5" type="text" id="SampleCount" value="<?php if($SampleCount_showValue!="") { echo $SampleCount_showValue; } ?>">
                </div>
                    <label><b>%</b></label> &nbsp; (Batch Count: <?php echo $SelectQCBatch['0']['EntityCount']; ?>)

                    <input name="SampleCountValue" type="hidden" id="SampleCountValue" value="<?php echo $SelectQCBatch['0']['EntityCount']; ?>">
                </div>
            </div>
        </div>
        
          <div class="col-md-4" id="ReworkHide">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Rework Type :</label>
                <div class="col-sm-6">
                    <input type="radio" <?php echo "checked"; ?>  id="sampleRework" name="ReworkId" value="0"> Sample Rework
                    <input type="radio" <?php if($ReworkId_showValue==1) { echo "checked"; } ?>  id="batchRework" name="ReworkId" value="1"> Batch Rework
                </div>
            </div>
        </div>  
        
        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <?php 
                    $addbutton = $this->Form->submit( 'Sample View' , array( 'id' => 'check_submit', 'name' => 'check_submit_random', 'value' => 'Submit','style'=>'margin-left:550px;width:100px;float:left;padding-bottom:2 px;','class'=>'btn btn-primary btn-sm','onclick'=>'return validateForm();'));
                    $clearbutton = $this->Form->button('Clear', array( 'id' => 'Clear', 'name' => 'Clear', 'value' => 'Clear','style'=>'margin-left:10px;float:left;display:inline;padding-bottom:6px;','class'=>'btn btn-primary btn-sm','onclick'=>'return ClearFields();','type'=>'button'));
                    echo $addbutton;
                    echo $clearbutton; ?>
                <?php echo $this->Form->end(); ?> 
                
                <form action="<?php echo Router::url('/', true); ?>q-c-sample/" method="post" style="width: 0px !important; margin: 0 0 -15em 80em !important; padding: 0 !important;">
                <div style="text-align:center;">
                    <input type="hidden" name="ProjectId" id="ProjectId">
                    <input type="hidden" name="RegionId" id="RegionId">
                    <input type="hidden" name="ModuleId" id="ModuleId">
                    <input type="hidden" name="UserGroupId" id="UserGroupId">
                 <?php 
                 echo $this->Form->submit('Go Back to List', array('id' => 'check_submit','class'=>'btn btn-primary btn-sm', 'name' => 'check_submit', 'value' => 'Submit', 'onclick' => 'goBack();history.back();'));
                ?>
                </div>
                </form>
            </div>
        </div>
        
        
    </div>
    <?php 
    if (count($ShowSamplingRecords) > 0) {
    ?>
    <!--    <div class="container-fluid">-->
    <?php echo $this->Form->create('', array('class' => 'form-horizontal randomView', 'id' => 'projectforms','name' => 'projectforms')); ?>
        <div class="bs-example" id="randomView">
            <div id="vertical">
                <div id="top-pane">
                    <div id="horizontal" style="height: 100%; width: 99.9%;">
                        <div id="left-pane" class="pa-lef-10">
                            <div class="pane-content" > 
                                Batch Count: <?php echo $SelectQCBatch['0']['EntityCount']; ?>  
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Sample Count: <?php echo $SampleCountWithPercentage; ?><br>
                                <input name="SampleCountWithPercentage" type="hidden" id="SampleCountWithPercentage" value="<?php echo $SampleCountWithPercentage; ?>">
								<input name="ReworkId" type="hidden" id="ReworkId" value="<?php echo $ReworkId_showValue; ?>">
                                <table style='width:99%;' class="table table-striped table-center" id='example'>
                                    <thead>
                                        <tr class="Heading">
                                            <th class="Cell" width="40%">Resource</th> 
                                            <th class="Cell" width="10%">Total Count</th> 
                                            <th class="Cell" width="10%">Sample Count</th>
                                            <th class="Cell" width="10%">Sample Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 0;
                                        foreach ($ShowSamplingRecords as $row):
                                            $samplePercentage = round(($row['SampleCount']/$row['TotalCount'])*100,2);
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $row['Resource']; ?>
                                                <input type="hidden" name="UserIds[]" value="<?php echo $row['UserId']; ?>">
                                            </td>
                                            
                                            <td><input class="form-control" type="text" readonly name="<?php echo $row['UserId']; ?>_totalcount" id="<?php echo $row['UserId']; ?>_totalcount" data-id="<?php echo $row['UserId']; ?>" value="<?php echo $row['TotalCount']; ?>"></td>
                                            
                                            <td><input class="form-control sampleCountEditOnDisplay" type="text" name="<?php echo $row['UserId']; ?>_samplecount" data-id="<?php echo $row['UserId']; ?>" id="<?php echo $row['UserId']; ?>_samplecount" value="<?php echo $row['SampleCount']; ?>"></td>
                                            
                                            <td><input class="form-control" type="text" readonly name="<?php echo $row['UserId']; ?>_samper" id="<?php echo $row['UserId']; ?>_samper" data-id="<?php echo $row['UserId']; ?>" value="<?php echo $samplePercentage; ?>"></td>
                                        </tr>
                                    <?php
                                        $i++;
                                        endforeach;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group" style="text-align:center;">
                                <div class="col-sm-12">
                                    <?php 
                                        echo $addbutton = $this->Form->submit( 'Create Sample' , array( 'id' => 'sample_create_random', 'name' => 'sample_create_random', 'value' => 'Submit','style'=>'margin-left:550px;width:100px;float:left;padding-bottom:2 px;','class'=>'btn btn-primary btn-sm','onclick'=>'return validateSamplingForm();'));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $this->Form->end(); ?>
    <!--    </div>-->
    <?php
    }
    ?>
    
    <?php 
    if (count($ShowStratificationSamplingRecords) > 0) {
        
//        $SampleType = $showValuesArray['SampleType'];
//        $SampleValue = $showValuesArray['SampleValue'];
    ?>
    <!--    <div class="container-fluid">-->
    <?php echo $this->Form->create('', array('class' => 'form-horizontal stratumView', 'id' => 'projectforms','name' => 'projectforms')); ?>
        <div class="bs-example" id="stratumView">
            <div id="vertical">
                <div id="top-pane">
                    <div id="horizontal" style="height: 100%; width: 99.9%;">
                        <div id="left-pane" class="pa-lef-10">
                            <div class="pane-content" > 
                                Batch Count: <?php echo $SelectQCBatch['0']['EntityCount']; ?>  
                                <input name="EntityCountTotal" type="hidden" id="EntityCountTotal" value="<?php echo $SampleCountWithPercentage; ?>">
                                <table style='width:99%;' class="table table-striped table-center" id='example'>
                                    <thead>
                                        <tr class="Heading">
                                            <th class="Cell" width="40%">Stratification</th> 
                                            <th class="Cell" width="10%">Total Count</th> 
                                            <th class="Cell" width="10%">Sample Count</th>
                                            <th class="Cell" width="10%">Sample Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 0;
                                        foreach ($ShowStratificationSamplingRecords as $key=>$row):
                                            $samplePercentage = round(($row['SampleCount']/$row['TotalCount'])*100,2);
                                            $keyValue = explode('^^^^^^^^', $key);
                                            $DisplayName = $keyValue['1'];
                                            $SubmitValue = $keyValue['0'];
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $DisplayName; ?>
                                                <input type="hidden" name="StratificationCombinations[]" value="<?php echo $SubmitValue; ?>">
                                            </td>
                                            
                                            <td><input class="form-control" type="text" readonly name="<?php echo $i; ?>_totalcount" id="<?php echo $i; ?>_totalcount" data-id="<?php echo $i; ?>" value="<?php echo $row['TotalCount']; ?>"></td>
                                            
                                            <td><input class="form-control sampleCountEditOnDisplay2" type="text" name="<?php echo $i; ?>_samplecount" data-id="<?php echo $i; ?>" id="<?php echo $i; ?>_samplecount" value="<?php echo $row['SampleCount']; ?>"></td>
                                            
                                            <td><input class="form-control" type="text" readonly name="<?php echo $i; ?>_samper" id="<?php echo $i; ?>_samper" data-id="<?php echo $i; ?>" value="<?php echo $samplePercentage; ?>"></td>
                                        </tr>
                                    <?php
                                        $i++;
                                        endforeach;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group" style="text-align:center;">
                                <div class="col-sm-12">
                                    <?php 
                                        echo $addbutton = $this->Form->submit( 'Create Sample' , array( 'id' => 'sample_create_stratification', 'name' => 'sample_create_stratification', 'value' => 'Submit','style'=>'margin-left:550px;width:100px;float:left;padding-bottom:2 px;','class'=>'btn btn-primary btn-sm','onclick'=>'return validateStratificationSamplingForm();'));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php echo $this->Form->end(); ?>
    <!--    </div>-->
    <?php
    }
    else {
    ?>
    <div class="bs-example">
        No combinations found for rule you have selected.
    </div>
    <?php
    }
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function (projectId) {
        var samplingvalout = '<?php echo $sampling_showValue; ?>';
        if(samplingvalout==1) {
            $('.SamplingTypeBothDivs').hide();
            $('#SampleCountDiv').show();
            $("#check_submit").attr('name', 'check_submit_random');
        }
        if(samplingvalout==2) {
            $('.SamplingTypeBothDivs').hide();
            $('#RuleIdDiv').show();
            $("#check_submit").attr('name', 'check_submit_stratification');
        }
        
        $(".samplingInputClass").click(function() {
            var samplingval = $('input[name=sampling]:checked').val();
            if(samplingval==1) {
                document.getElementById("ReworkHide").style = "margin-left:115px;";
                $('.SamplingTypeBothDivs').hide();
                $('#SampleCountDiv').show();
                $('#SampleCount').val('');
                $('.stratumView').hide();
                $("#check_submit").attr('name', 'check_submit_random');
            }
            
            if(samplingval==2) {
                document.getElementById("ReworkHide").style = "margin-left:115px;";
                $('.SamplingTypeBothDivs').hide();
                $('#RuleIdDiv').show();
                $('#RuleId').val('0');
                $('.randomView').hide();
                $("#check_submit").attr('name', 'check_submit_stratification');
            }
        });
        
        // prevent not to allow other than numeric values in samplecount textbox
        $('#SampleCount').keyup(function(e){
            if (/\D/g.test(this.value))
            {
              // Filter non-digits from input value.
              this.value = this.value.replace(/\D/g, '');
            }
        });
        
        $('#SampleCountDiv').on('keydown', '#SampleCount', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        
        $('.sampleCountEditOnDisplay').keyup(function(e){
            if (/\D/g.test(this.value))
            {
              // Filter non-digits from input value.
              this.value = this.value.replace(/\D/g, '');
            }
            
            var UserId = $(this).data("id");
            var SampleCountWithPercentage = $('#SampleCountWithPercentage').val();
            var totalcount = parseInt($('#'+UserId+'_totalcount').val());
            var samplecount = parseInt($('#'+UserId+'_samplecount').val());
            
            if(samplecount > totalcount) {
                alert('Please enter user sample count is lesser than or equal to user total Count.');
                $(this).val('');
                $(this).focus();
                $('#'+UserId+'_samper').val('');
                return false;
            }
            
            if(samplecount>=0) {
                var percentage = (samplecount/totalcount)*100;
                percentage = percentage.toFixed(2);
                $('#'+UserId+'_samper').val(percentage);
            }
            else 
                $('#'+UserId+'_samper').val('');
            
//            var sum = 0;
//            $('.sampleCountEditOnDisplay').each(function() {
//                sum += Number($(this).val());
//            });
//            if (sum != SampleCountWithPercentage){
//                alert('Please enter all user sample count equals to Batch sample count');
//                //$(this).val($.trim($(this).val()).slice(0, -1));
//                $(this).focus();
//                return false;
//            }
        });
        
        $('.sampleCountEditOnDisplay2').keyup(function(e){
            if (/\D/g.test(this.value))
            {
              // Filter non-digits from input value.
              this.value = this.value.replace(/\D/g, '');
            }
            
            var Id = $(this).data("id");
            var EntityCountTotal = $('#EntityCountTotal').val();
            var totalcount = parseInt($('#'+Id+'_totalcount').val());
            var samplecount = parseInt($('#'+Id+'_samplecount').val());
            
            if(samplecount > totalcount) {
                alert('Please enter user sample count is lesser than or equal to user total Count.');
                $(this).val('');
                $(this).focus();
                $('#'+Id+'_samper').val('');
                return false;
            }
            
            if(samplecount>=0) {
                var percentage = (samplecount/totalcount)*100;
                percentage = percentage.toFixed(2);
                $('#'+Id+'_samper').val(percentage);
            }
            else
                $('#'+Id+'_samper').val('');
            
//            var sum = 0;
//            $('.sampleCountEditOnDisplay2').each(function() {
//                sum += Number($(this).val());
//            });
//            if (sum <= 0 || sum > EntityCountTotal){
//                alert('Please enter all user sample count equals to Batch count');
//                //$(this).val($.trim($(this).val()).slice(0, -1));
//                $(this).focus();
//                return false;
//            }
        });
    });
    
    function validateSamplingForm() {
        var SampleCountWithPercentage = $('#SampleCountWithPercentage').val();
        var sum = 0;
        $('.sampleCountEditOnDisplay').each(function() {
            sum += Number($(this).val());
        });
        if (sum != SampleCountWithPercentage){
            alert('Please enter all user sample count equals to Batch sample count');
            return false;
        }
    }
    
    function validateStratificationSamplingForm() {
        var EntityCountTotal = $('#EntityCountTotal').val();
        var sum = 0;
        $('.sampleCountEditOnDisplay2').each(function() {
            sum += Number($(this).val());
        });
        if (sum <= 0 || sum > EntityCountTotal){
            alert('Please enter all user sample count equals to Batch count');
            return false;
        }
    }
    
    function ClearFields() {
        $('#RuleId').val('0');
        $('#SampleCount').val('');
        $('input[name=sampling]').attr('checked',false);
        $('.SamplingTypeBothDivs').hide();
    }
    
    function validateForm() {
        if($('input:radio:checked').length <= 0) {
            alert('Select Sampling type');
            $('#sampling1').focus();
            return false;
        }
        var samplingval = $('input[name=sampling]:checked').val();
        if(samplingval==1) {
             $('.randomView').show();
             $('.stratumView').hide();
            if ($('#SampleCount').val() <=0){
                //alert('Please enter sample count');
                alert('Please enter sample Percentage');
                $('#SampleCount').focus();
                return false;
            }
            if ($('#SampleCount').val() > 100){ //$('#SampleCountValue').val()
                //alert('Please enter sample count lesser than or equal to max count avail.');
                alert('Please enter less than or equal to 100 percentage');
                $('#SampleCount').focus();
                return false;
            }
        }
        if(samplingval==2) {
             $('.randomView').hide();
             $('.stratumView').show();
            if ($('#RuleId').val() == 0){
                alert('Select Stratification Rule');
                $('#RuleId').focus();
                return false;
            }
        }
    }
    function goBack(){
        <?php
$js_array = json_encode($SelectQCBatch);

echo "var BatchId = " . $js_array . ";\n";
?>
   var mandatory = BatchId['0']['Id'];
         var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCSample', 'action' => 'ajaxlist')); ?>",
            data: ({mandatory: mandatory}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var resultData = JSON.parse(result);
                 $('#ProjectId').val(resultData['ProjectId']);
                 $('#RegionId').val(resultData['RegionId']);
                 $('#ModuleId').val(resultData['ProcessId']);
                 $('#UserGroupId').val(resultData['UserGroupId']);
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