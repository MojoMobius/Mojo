<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/handsontable.css">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/pikaday/pikaday.css">
<script data-jsfiddle="common" src="webroot/dist/pikaday/pikaday.js"></script>
<script data-jsfiddle="common" src="webroot/dist/moment/moment.js"></script>
<script data-jsfiddle="common" src="webroot/dist/zeroclipboard/ZeroClipboard.js"></script>
<script data-jsfiddle="common" src="webroot/dist/numbro/numbro.js"></script>
<script data-jsfiddle="common" src="webroot/dist/numbro/languages.js"></script>
<script data-jsfiddle="common" src="webroot/dist/handsontable.js"></script>
<script src="webroot/js/samples.js"></script>
<script src="webroot/js/highlight/highlight.pack.js"></script>
<link rel="stylesheet" media="screen" href="webroot/js/highlight/styles/github.css">
<link rel="stylesheet" href="webroot/css/font-awesome/css/font-awesome.min.css">
<?php
use Cake\Routing\Router;
$RegionId = 0;
if ($NoNewJob == 'NoNewJob') {
    ?>
<br><br>
<div align="center" style="color:green;">
    <b>
            <?php echo 'No New Job Available Now! <br> Check Later to have new job!'; ?>
    </b>
    <br><br>
</div>
    <?php
} else if ($this->request->query['job'] == 'completed' || $this->request->query['job'] == 'Query') {
    ?>
<br><br>
<div align="center" style="color:green;">
    <b>
            <?php
            if ($this->request->query['job'] == 'completed')
                echo 'Job completed.<br>';
            else
                echo 'Query Posted Successfully.<br>';
            ?>

            <?php echo 'Click Get Job Button to get new Job'; ?>
    </b>
    <br><br>
    <div style="margin:0px 0px 5px 0px;">
        <button class="btn btn-default btn-sm" type="button" onclick="getJob()">Get Job</button>
    </div>
</div>
<br><br>   
    <?php
}
else if ($getNewJOb == 'getNewJOb') {
    echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms'));
    ?>
<br><br>
<div align="center" style="color:green;">
    <b>
            <?php echo 'Click Get Job Button to get new Job'; ?>
    </b>
    <br><br>
    <div style="margin:0px 0px 5px 0px;">
            <?php echo $this->Form->button('GetJob', array('id' => 'NewJob', 'name' => 'NewJob', 'value' => 'NewJob', 'class' => 'btn btn-default btn-sm')); ?>
    </div>
</div>
    <?php
    echo $this->Form->end();
} else {
    $RegionId = $productionjob['RegionId'];
    echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms', 'name' => 'getjob'));
    ?>
<input type="hidden" name="resultcnt" id="resultcnt">
<input type="hidden" name='loaded' id='loaded' value="">
<input type="hidden" name='qc_comments_projectattributeid' id='qc_comments_projectattributeid' value="0">
<input type="hidden" name='qc_comments_attributeid' id='qc_comments_attributeid' value="0">
<input type="hidden" name='qc_comments_puvalue' id='qc_comments_puvalue' value="">
<input type="hidden" name='qc_comments_attributename' id='qc_comments_attributename' value="">
<input type="hidden" name='qc_comments_controlname' id='qc_comments_controlname' value="">
<input type="hidden" name='qc_comments_attributedisplayname' id='qc_comments_attributedisplayname' value="">
<input type="hidden" name='qc_comments_rowno' id='qc_comments_rowno' value="">

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">

        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        QC Validation
                    </a> <span class="buttongrp">    
                        <!--                            <a  class="btn btn-primary btn-xs pull-right" href="#popup1" style="margin-top:-4px;">Query</a>-->


                        <button type="submit" id="SubmitForm" style="margin-right:3px;" name='Submit' value="Submit" class="btn btn-primary btn-xs pull-right" onclick="return formSubmit();">Submit</button> </span>

                    <div class='qc_popuptitle' style="cursor: pointer;margin-left:1170px;margin-top: -16px;" id='Error' style="margin-left:290px;margin-top: -65px;" value='' onclick="query();" style="margin-top:-4px;"> </div>
                </h3>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">

                <span  class="form-horizontal" id="">        
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label"><b><?php echo $moduleName; ?> process</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
								<?php foreach ($StaticFields as $key => $value) { ?>

                                <a style="color:#555b86 !important;"
                                   href="#"><u><?php echo $value['DisplayAttributeName']; ?>:<?php echo $productionjob[$value['AttributeMasterId']]; ?></u></a>

                                <?php } ?> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group"style="margin: 0px;" >
                            <label for="inputEmail3" class="col-sm-4 control-label"><b>Timer:</b></label>
                            <div class="col-sm-8" style="padding-top: 3px;padding-left: 15px;">
                                <a href="#">
                                    <span class="badge" id='countdown'>
                                            <?php
                                            if (empty($productionjob['TimeTaken']))
                                                $hrms[0] = '00:00:00';
                                            else
                                                $hrms = explode('.', $TimeTaken);
                                            ?><?php echo $hrms[0]; ?>
                                    </span>
                                        <?php echo $this->Form->input('', array('type' => 'hidden', 'id' => 'TimeTaken', 'name' => 'TimeTaken', 'value' => $hrms[0])); ?>
                                </a> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label"><b>Status</b></label>
                            <div class="col-sm-6" style="padding-top: 3px;">
                                QC Inprogress
                            </div>
                        </div>
                    </div>
                </span>	

<span  class="form-horizontal" id="">        
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label" ><b>Batch Name:</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
						 <?php echo $QcBatchName; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                    <div class="col-md-4">
                        <div class="form-group"style="margin: 0px;" >
                            <label for="inputEmail3" class="col-sm-6 control-label"><b>Researcher Name:</b></label>
                            <div class="col-sm-6" style="padding-top: 3px;">
<?php echo $userList[$ProdUserId]; ?>
                            </div>
                        </div>
                    </div>
                </span>	
                <div class="form-group">
                    <div class="col-sm-12">
                    </div>
                </div>
                    <?php if (!empty($DynamicFields)) { ?>
                <div id="top-pane" readonly="readonly">
                    <div class="pane-content" style="width:99.7%;" >
                        <div class="form-horizontal">
                            <div class="form-group form-group-sm form-inline" id='appendNew' style="overflow-x: scroll;overflow-y:hidden !important; white-space: nowrap;padding-bottom: 15px;">
                                        <?php foreach ($DynamicFields as $key => $value) { ?>

                                <span  class="form-horizontal" id="projectforms">        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6
                                                   control-label"><b><?php echo $value['DisplayAttributeName']; ?></b></label>
                                            <input type="hidden" name="CommonAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" id="CommonAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" value="<?php echo $dynamicData[$value['AttributeMasterId']]; ?>">

                                            <div class="col-sm-6 " style="padding-top: 3px;">
                                                    <!--                                <input id="1390" class="form-control" size="40" name="1390" value="" onblur="('1390', this.value, '', '', '', '')" maxlength="" minlength="" type="text">-->
                                                        <?php if ($value['ControlName'] == 'TextBox' || $value['ControlName'] == 'Label') { ?>
                                                <input readonly="readonly" class="form-control" type="text"  size="40" title="<?php echo $value['AttributeMasterId']; ?>" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" onblur="<?php echo $value['FunctionName']; ?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]', this.value, '<?php echo $value['AllowedCharacter']; ?>', '<?php echo $value['NotAllowedCharacter']; ?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']]; ?>">
                                                        <?php } elseif ($value['ControlName'] == 'DropDownList') { ?>
                                                <select disabled="disabled" class="form-control" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]">
                                                    <option value="yes" <?php
                                                                if ($value['AttributeValue'] == 'yes') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>Yes</option>
                                                    <option value="no" <?php
                                                                if ($value['AttributeValue'] == 'no') {
                                                                    echo 'Selected';
                                                                }
                                                                ?>>No</option>
                                                </select>
                                                        <?php } elseif ($value['ControlName'] == 'MultiTextBox') { ?>
                                                <textarea disabled="disabled" title="<?php echo $value['AttributeValue']; ?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" onblur="<?php echo $value['FunctionName']; ?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]', this.value, '<?php echo $value['AllowedCharacter']; ?>', '<?php echo $value['NotAllowedCharacter']; ?>')"><?php echo $dynamicData[$value['AttributeValue']]; ?></textarea>
                                                        <?php } elseif ($value['ControlName'] == 'RadioButton') { ?>
                                                <input disabled="disabled" class="form-control" type="radio" <?php
                                                            if ($value['AttributeValue'] == 'Valid') {
                                                                echo 'checked';
                                                            }
                                                            ?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId']; ?>_1" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                                <input disabled="disabled" class="form-control" type="radio" <?php
                                                            if ($value['AttributeValue'] == 'InValid') {
                                                                echo 'checked';
                                                            }
                                                            ?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId']; ?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid
                                                               <?php }
                                                               ?>
                                            </div>
                                        </div>
                                    </div>
                                        <?php } ?>

                            </div>
                        </div>
                    </div>
                    </span>	

                </div>
                    <?php } ?>
            </div>
        </div>    </div></div>


    <?php //pr($productionjob);?>
<input type="hidden" name='ProductionId' value="<?php echo $productionjob['Id']; ?>">
<input type="hidden" name='ProductionEntity' id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity']; ?>">
<input type="hidden" name='StatusId' value="<?php echo $productionjob['StatusId']; ?>">
<input type="hidden" name="ADDNEW" id="ADDNEW" value="<?php echo $ADDNEW; ?>">
    <?php
    echo $this->Form->input('', array('type' => 'hidden', 'id' => 'addnewActivityChange', 'name' => 'addnewActivityChange', 'value' => $addnewActivityChange));
    echo $this->Form->input('', array('type' => 'hidden', 'id' => 'page', 'name' => 'page', 'value' => $page));
    echo $this->Form->input('', array('type' => 'hidden', 'id' => 'prevPage', 'name' => 'prevPage', 'value' => $this->request->params[paging][GetJob][prevPage]));
    echo $this->Form->input('', array('type' => 'hidden', 'id' => 'nextPage', 'name' => 'nextPage', 'value' => $this->request->params[paging][GetJob][nextPage]));
    ?>
<div id="example" class="container-fluid" style="margin-bottom:-10px;">
    <div id="vertical">
        <div id="top-pane">
            <div id="horizontal" style="height: 100%; width: 100%;">
                <div id="left-pane">
                    <div class="pane-content" >

                        <!-- Load pdf file starts -->
                        <div style="margin-top:10px;"><iframe id="frame" sandbox="" src="<?php echo $FirstLink;   ?>" onload="onMyFrameLoad(this)"></iframe>
                        </div> 
                        <!-- Load pdf file ends-->
                    </div>
                </div>

                <div id="right-pane">
                    <div class="col-md-12">
                        <div class="col-md-4  pull-left">
                                    <?php echo $this->Form->input('', array('options' => $Html, 'id' => 'status', 'name' => 'status', 'class' => 'form-control', 'onchange' => 'LoadPDF(this.value);','style' => 'width:400px; margin-top:-11px; margin-left:-25px;')); ?>

                        </div>
                        <div class="pull-right" style="cursor:pointer;padding-top:5px;">
                            <button class="btn btn-primary btn-xs " name='gopdf' id='gopdf' onclick="OpenPdf();" type="button">Go</button>
                            <button class="btn btn-primary btn-xs " name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>
                        </div>
                    </div>
                    <p>
                        <label><input style = "margin-left:-12px;" type="checkbox" name="autosave" checked="checked" disabled="" autocomplete="off"> </label>
                    </p>
                    <div id="example1" class="hot handsontable htColumnHeaders"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="light" class="white_content" style="position:fixed;">
    <div class="query_popuptitle"><div style='float:left;width:40%'><b>QC Comments</b></div><div align='right'> <b><a onclick="document.getElementById('light').style.display = 'none';document.getElementById('fade').style.display = 'none';cleartext();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
    <div class="query_innerbdr">
        <div class="query_outerbdr" style='height:315px;overflow:auto;'>
            <div id='QcsuccessMessage' align='center' style='display:none;color:green;'><b>Comments Successfully Posted!</b></div>
            <div id='QcDeletedMessage' align='center' style='display:none;color:green;'><b>Comments Deleted Successfully!</b></div>
            <input type='hidden' name='CommentsId' Id ='CommentsId' value='0'>
            <?php
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'inspectionId', 'name' => 'inspectionId')); 
            ?>
            <label class="col-sm-4 control-label"><b>Attribute</b></label>
            <div class="col-sm-7">
                <pre class="" style='background-color:white;border:0px;padding:0px;' id='Attribute'>-</pre>
            </div>
            <label hidden class="col-sm-4 control-label"><b>AttributeMasterId</b></label>
            <div hidden class="col-sm-7">
                <pre class="" style='background-color:white;border:0px;padding:0px;' id='AttributeMasterId'>-</pre>
            </div>
            <label hidden class="col-sm-4 control-label"><b>ProjectAttributeMasterId</b></label>
            <div hidden class="col-sm-7">
                <pre class="" style='background-color:white;border:0px;padding:0px;' id='ProjectAttributeMasterId'>-</pre>
            </div>
            <div id='puVEF' style='dispaly:block;'>
                <label class="col-sm-4 control-label"><b>PU Value</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='PUvalue'>-</pre>
                </div>
            </div>
            <label class="col-sm-4 control-label"><b>Error Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
            <div class="col-sm-7" style="width: 34.333%;">
                <?php 
                    echo $this->Form->input('',array('options' => $CategoryName,'default' => '0','name'=>'CategoryName','id'=>'CategoryName','style'=>'margin-top:-16px;','class'=>'form-control','onchange' => 'getCategory(this.value);')); 
                ?>
            </div>
            <label style="margin-top:16px;" class="col-sm-4 control-label"><b>Error Sub Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
            <div class="col-sm-7" style="width: 34.333%;">
                <?php 
                        $SubCategory = array(0 => '-- Select --');
                        echo '<div id="LoadSubCategory">';
                        echo $this->Form->input('', array('options' => $SubCategory, 'id' => 'SubCategory', 'name' => 'SubCategory','style'=>'margin-top:0px;', 'class' => 'form-control','value' => $SubCategory));
                        echo '</div>';
                ?>
                &nbsp;
            </div>
<!--            <label class="col-sm-4 control-label"><b>QC Value&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
            <div class="col-sm-7"  id="QcCtlMultiTextbox">
                <?php 
                echo $this->Form->textarea('', array( 'type'=>'text','id' => 'QCValueMultiTextbox', 'name' => 'QCValueMultiTextbox','style'=>'margin-bottom:8px;')); ?>
                &nbsp;
            </div>
            <div class="col-sm-7" style="width: 34.333%;" id="QcCtlDropdown">
                <?php 
                 $User=array(0 => '-- Select --');
                echo $this->Form->input('', array( 'options' => $User,'id' => 'QCValueDropdown', 'name' => 'QCValueDropdown','style'=>'margin-top:0px;')); ?>
                &nbsp;
            </div>
            <div class="col-sm-7" id="QcCtlTextbox">
                <?php 
                echo $this->Form->input('', array( 'type'=>'text','id' => 'QCValueTextbox', 'name' => 'QCValueTextbox','style'=>'margin-bottom:8px;')); ?>
                &nbsp;
            </div>
            &nbsp;
            <label style="margin-top:8px;" class="col-sm-4 control-label"><b>Reference</b></label>
            <div class="col-sm-7">
                <?php 
               
                    echo $this->Form->input('', array( 'type'=>'text','id' => 'Reference', 'name' => 'Reference','style'=>'margin-bottom:8px;margin-top:10px;')); 
                ?>
            </div>-->

            <label class="col-sm-4 control-label"><b>QC Comments</b></label>
            <div class="col-sm-7" id="QcCmnd">
                <?php echo $this->Form->textarea('', array( 'type'=>'text','id' => 'QCComments', 'name' => 'QCComments','style'=>'margin-bottom:8px;')); ?>
            </div>

            <div  class="col-sm-10" id='oldData' ></div>

            <div class="col-sm-12" style="text-align:center;margin-top: 7px;">
                <?php
                  echo $this->Form->button('Mark Error', array( 'id' => 'QuerySubmit', 'name' => 'QuerySubmit', 'value' => 'QuerySubmit','class'=>'btn btn-primary btn-sm','onclick'=>"return valicateQuery('".$value['AttributeMasterId']."','".$value['ProjectAttributeMasterId']."');",'type'=>'button')).' '; 
                 echo $this->Form->button('Close', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-primary btn-sm','onclick'=>"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';cleartext();")).' '; 
                echo $this->Form->button('Delete', array( 'type'=>'button','id' => 'Delete', 'name' => 'Delete', 'value' => 'Delete','class'=>'btn btn-primary btn-sm','onclick'=>"cleartext();return DeleteQuery();")); ?>   
            </div>   
            &nbsp;
            &nbsp; 
        </div>


    </div>
</div>
<div id="fade" class="black_overlay"></div>
        <?php
        echo $this->Form->end();
    }
    ?>
<script>
    var myWindow = null;
    function onMyFrameLoad() {
        $('#loaded').val('loaded');
    }
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
            orientation: "horizontal",
            panes: [
                {collapsible: true},
                {collapsible: true},
                {collapsible: true}
            ],
            expand: onExpandSplitter,
            resize: onResizeSplitter
        });

    });

    function onResizeSplitter(e) {

        var leftpaneSize = $('#left-pane').data('pane').size;
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'upddateLeftPaneSizeSession')); ?>",
            data: ({leftpaneSize: leftpaneSize}),
            dataType: 'text',
            async: true,
            success: function (result) {
                //  loadHotWidth();
            }
        });


    }

    function onExpandSplitter() {
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'no'}),
            dataType: 'text',
            async: true,
            success: function (result) {

            }
        });
        if (myWindow)
            myWindow.close();

        //loadHotWidth();
    }

    function displayTimeout() {
        iframe1 = document.getElementById('frame');
        if ($('#loaded').val() === 'loaded') {

        } else {

            var p = iframe1.parentNode;
            p.removeChild(iframe1);

            var div = document.createElement("iframe");

            div.setAttribute("id", "frame");
            div.setAttribute("style", 'width:100%; height:800px; overflow:hidden !important;');
            p.appendChild(div);
            var html = '<body>Loading takes longer than usual.<br> Please use Go button!</body>';
            div.src = 'data:text/html;charset=utf-8,' + encodeURI(html);
            p.appendChild(div);
            console.log('div.contentWindow =', div.contentWindow);
        }



    }
    setTimeout(displayTimeout, 8000);

    function LoadPDF(file)
    {
        document.getElementById('frame').src = file;

    }
//
//    function loadHotWidth() {
//        hot.updateSettings({
//            width: '100%'
//        });
//    }
</script>
</div>
<script>
    //hot;
    var hms = '<?php echo $hrms[0]; ?>';   // your input string
    if (hms != '') {
        var a = hms.split(':'); // split it at the colons
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    } else
    {
        var seconds = 0;
    }
    function secondPassed() {
        var hour = Math.round((Math.round((seconds - 30) / 60) - 30) / 60);
        var temp = hour * 60 * 60;
        var minutes = Math.round(((seconds - temp) - 30) / 60);
        var remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }

        if (hour < 10) {
            hour = "0" + hour;
        }
        document.getElementById('countdown').innerHTML = hour + ":" + minutes + ":" + remainingSeconds;
        document.getElementById('TimeTaken').value = hour + ":" + minutes + ":" + remainingSeconds;
        seconds++;
    }
    var countdownTimer = setInterval('secondPassed()', 1000);

    function getJob()
    {
        window.location.href = "QCValidation?job=newjob";
    }
    var windowObjectReference;
    var strWindowFeatures = "menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";
    function OpenPdf() {
        str = $("#status option:selected").text();
        if (str.search("http://") > -1)
            file = $("#status option:selected").text();
        else if (str.search("https://") > -1)
            file = $("#status option:selected").text();
        else
            file = 'http://' + $("#status option:selected").text() + '/';
        windowObjectReference = window.open(file, "CNN_WindowName", strWindowFeatures);
    }


    function PdfPopup()
    {
//        var splitterElement = $("#horizontal").kendoSplitter({
//            panes: [
//                    {collapsible: true},
//                    {collapsible: true},
//                    {collapsible: true}
//                ]
//        });
//        var splitter = splitterElement.data("kendoSplitter");
//        var leftPane = $("#left-pane");
//        splitter["collapse"](leftPane);


        var splitterElement = $("#horizontal"), getPane = function (index) {
            index = Number(index);
            var panes = splitterElement.children(".k-pane");
            if (!isNaN(index) && index < panes.length) {
                return panes[index];
            }
        };

        var splitter = splitterElement.data("kendoSplitter");
        var pane = getPane('0');
        splitter.toggle(pane, $(pane).width() <= 0);


        var file = $("#status option:selected").text();
        myWindow = window.open("", "myWindow", "width=500, height=500");
        myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:100%; overflow:hidden !important;"></iframe>');

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'yes'}),
            dataType: 'text',
            async: true,
            success: function (result) {

            }
        });

        //    loadHotWidth();
    }



    function LoadPDF(file)
    {
        document.getElementById('frame').src = file;
        $("body", myWindow.document).find('#pdfframe').attr('src', file);
    }

    ipValidatorRegexp = /^(?:\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b|null)$/;
    emailValidator = function (value, callback) {
        setTimeout(function () {
            if (value === '') {
                callback(true);
            } else if (/.+@.+/.test(value)) {
                callback(true);
            } else {
                callback(false);
            }
        }, 1000);
    };

    UrlRegexp = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
    urlValidator = function (value, callback) {
        setTimeout(function () {
            if (UrlRegexp.test(value)) {
                callback(true);
            } else {
                callback(false);
            }
        }, 100);
    };

    var AlphbetOnlyReg = /^[a-zA-Z\s]+$/;
    AlphabetOnlyValidator = function (value, callback) {
        setTimeout(function () {
            if (AlphbetOnlyReg.test(value) == false) {
                callback(false);
            } else {
                callback(true);
            }
        }, 100);
    };
    var AlphaNumericOnlyReg = /^[a-zA-Z\s]+$/;
    AlphaNumericOnlyValidator = function (value, callback) {
        setTimeout(function () {
            if (AlphaNumericOnlyReg.test(value) == false) {
                callback(false);
            } else {
                callback(true);
            }
        }, 100);
    };
    var NumbersOnlyReg = /^[a-zA-Z\s]+$/;
    NumbersOnlyValidator = function (value, callback) {
        setTimeout(function () {
            if (NumbersOnlyReg.test(value) == false) {
                callback(false);
            } else {
                callback(true);
            }
        }, 100);
    };
    function getCustomRenderer() {
        return function (instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.hidden = true;
        }
    }
    function calculateSize() {
        var offset;


        offset = Handsontable.Dom.offset(example1);
        availableWidth = Handsontable.Dom.innerWidth(document.body) - offset.left + window.scrollX;
        availableHeight = Handsontable.Dom.innerHeight(document.body) - offset.top + window.scrollY;

        example1.style.width = availableWidth + 'px';
        example1.style.height = availableHeight + 'px';

    }
    var
            $container = $("#example1"),
            $console = $("#exampleConsole"),
            $parent = $container.parent(),
            autosaveNotification,
            container3 = document.getElementById('example1'),
            hot;
    hot = new Handsontable($container[0], {
        colWidths: 100,
        height: 520,
        minSpareCols: 0,
        minSpareRows: 1,
        columnSorting: true,
        sortIndicator: true,
        readOnly: true,
        manualColumnMove: true,
        stretchH: 'all',
        rowHeaders: true,
        manualRowResize: true,
        manualColumnResize: true,
        comments: false,
        // contextMenu: ['undo','redo','make_read_only','alignment','remove_row'],

        colHeaders: ['DataId',
<?php
foreach ($handsonHeaders as $value) {
    echo "'" . $value . "',";
}
?>],
        columns: [
            {readOnly: true},
            <?php
foreach ($ReadOnlyFields as $key => $val) {
        echo "{readOnly: true},";
}
?>
<?php
foreach ($ProductionFields as $key => $val) {
    $validationstx = '';
    if ($val['FunctionName'] != '') {
        $validationstx = ',validator: ' . $val['FunctionName'] . ', allowInvalid: false';
    }
    if ($val['ControlName'] == 'DropDownList') {
        if ($val['Optionsbut1'] === 'NO') {
            $test = '["--Select--"]';
        } else  
            $test = $val['Optionsbut1'];


        echo "{ type: 'dropdown',source: $test},";
    }
    elseif ($val['ControlName'] == 'Auto') {
      //  echo "{ type: 'autocomplete',source: $test'},";
         $test = $val['Optionsbut1'];
       echo " {
        type: 'autocomplete',
        source: $test,
        strict: true
      },";
    } else
        echo "{type:'text' $validationstx},";
}
?>
        ],
        afterValidate: function (result) {
            if (!result.isValid) {
                //  alert('Invalid Data Point'); 
            }
        },
        beforeRemoveRow: function (change, source) {
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxremoverow')); ?>',
                dataType: 'json',
                type: 'POST',
                data: {changes: change, data: hot.getData()}, // contains changed cells' data
                success: function (result) {

                }
            });
        },
        afterChange: function (change, source) {
            var data;
            if (source === 'loadData' || !$parent.find('input[name=autosave]').is(':checked')) {
                return;
            }
            data = change[0];
            data[0] = hot.sortIndex[data[0]] ? hot.sortIndex[data[0]][0] : data[0];
            clearTimeout(autosaveNotification);
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxsavedatahand')); ?>',
                dataType: 'json',
                type: 'POST',
                data: {changes: change, data: hot.getData()}, // contains changed cells' data
                success: function (result) {

                }
            });
            //onChange(change, source);
        },
        afterSelection: function (r, c) {
            $('#Error').show();
            var colno = c;
            var rowno = r;
            colno = colno - 1;
            var data = this.getValue(r);
            <?php
                $js_array = json_encode($handsonHeaders);
                echo "var javascript_array = ". $js_array . ";\n";
            ?>
            if (colno >= 0) {
                var col_name = javascript_array[colno];
            } else {
                var col_name = 'DataId';
            }
            <?php
                $js_array = json_encode($AttributeOrder[$RegionId]);
                echo "var AttributeOrder = ". $js_array . ";\n";
            ?>
            var col_ControlName;
            var col_attributedisplayname;
            var col_ProjectAttributeId = 0;
            var col_AttributeId = 0;
            $.each(AttributeOrder, function (key, element) {
                if (element['AttributeName'] == col_name) {
                    col_ProjectAttributeId = element['ProjectAttributeId'];
                    col_AttributeId = element['AttributeId'];
                    col_ControlName = element['ControlName'];
                    col_attributedisplayname = element['DisplayAttributeName'];
                    //break;
                }
            });
            $("#qc_comments_projectattributeid").val(col_ProjectAttributeId);
            $("#qc_comments_attributeid").val(col_AttributeId);
            $("#qc_comments_puvalue").val(data);
            $("#qc_comments_attributename").val(col_name);
            $("#qc_comments_controlname").val(col_ControlName);
            $("#qc_comments_attributedisplayname").val(col_attributedisplayname);
            $("#qc_comments_rowno").val(rowno + 1);

            var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
            var next_status_id = '<?php echo $next_status_id;?>';
            var seq = document.getElementById('qc_comments_rowno');
            var page = seq.value;


            var ProjAttrId = document.getElementById('qc_comments_projectattributeid');
            var AttrId = document.getElementById('qc_comments_attributeid');

            var ProjectAttributeMasterId = ProjAttrId.value;
            var AttributeMasterId = AttrId.value;
            var ProductionEntity = $('#ProductionEntity').val();
            var prodArr =<?php echo json_encode($ProductionFields );?>;
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetnextpagedata'));?>",
                data: ({page: page, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
                dataType: 'text',
                async: false,
                success: function (result) {

                    if (result === 'expired') {
                        window.location = "users";
                    }
                    var resultData = JSON.parse(result);
                    $('#Error').removeClass("qcGreen_popuptitle");
                    $('#Error').removeClass("qcRed_popuptitle");
                    $('#Error').addClass("qc_popuptitle");

                    if (resultData['attrcnt'] != '') {
                        $('#Error').addClass("qcGreen_popuptitle");
                        $('#Error').removeClass("qc_popuptitle");
                    } else {
                        $('#Error').addClass("qc_popuptitle");
                    }
                    if (resultData['attrRebutal'] != '') {

                        $('#Error').addClass("qcRed_popuptitle");
                        $('#Error').removeClass("qc_popuptitle");
                    } else {
                        $('#Error').addClass("qc_popuptitle");
                    }

                    document.getElementById('fade').style.display = '';
                }
            });

        },
        afterDeselect: function () {
//            $("#qc_comments_attributeid").val('0');
//            $("#qc_comments_puvalue").val('');
//            $("#qc_comments_attributename").val('');
//            $("#qc_comments_attributedisplayname").val('');
//            $("#qc_comments_rowno").val('');
        }
    });

    hot.addHook('afterChange', function (changes, source) {
        if (!changes) {
            return;

        }
        changed = changes.toString().split(",");
        var keyval = changed[1] - 1;
        <?php
        $temp = json_encode($ProductionFields);
        echo "var production = " . $temp . ";\n";
        ?>


        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxconvert')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {keyval: keyval, changed: changed, production: production}, // contains changed cells' data
            success: function (result) {
                if (result) {
                    // alert(result);
                    hot.updateSettings({
                        cells: function (row, col, prop) {
                            if (row == changed[0] && col == result[1]) {
                                var cellProperties = {};
                                cellProperties.source = result[0];
                                return cellProperties;
                            }
                        }

                    });
                }
            }
        });

<?php ?>



    });
    $(document).ready(function () {
        $('#Error').hide();
        var ProductionEntity = $('#ProductionEntity').val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxgetdatahand')); ?>',
            dataType: 'json',
            type: 'POST',
            async: false,
            data: {ProductionEntity: ProductionEntity},
            success: function (res) {
                var data = [], row;
                for (var i = 0, ilen = res.handson.length; i < ilen; i++) {
                    row = [];
                    row[0] = res.handson[i].DataId;
                    var prodArr =<?php echo json_encode($ProductionFields); ?>;
                    var readArr = '';
                    var readArr =<?php if(isset($ReadOnlyFields)){ echo json_encode($ReadOnlyFields); } else { echo "''";}  ?>;
                    var cnt = 1;
                    if (typeof readArr != 'undefined') {
                        $.each(readArr, function (key, element) {
                            if (element['AttributeMasterId'] != '') {
                                elt = element['AttributeMasterId'];
                                row[cnt] = res.handson[i]['[' + elt + ']'];
                                cnt++;
                            }
                        });
                    }
                    $.each(prodArr, function (key, element) {
                        if (element['AttributeMasterId'] != '') {
                            elt = element['AttributeMasterId'];
                            row[cnt] = res.handson[i]['[' + elt + ']'];
                            cnt++;
                        }
                    });
                    data[res.handson[i].Id] = row;
                }
                hot.loadData(data);
            }
        });
    });
//    shortcut.add("Ctrl+g",function() {
//	 $("#gopdf").trigger('click'); 
//    });
//    shortcut.add("Ctrl+u",function() {
//	 $("#pdfPopUp").trigger('click');
//    });
//    shortcut.add("Ctrl+Alt+j",function() {
//        $("#SubmitForm").trigger('click');
//    });
//    shortcut.add("Ctrl+Shift+X",function() {
//	alert("Hi there!");
//    });

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

    #vertical {
        height: 750px;
        margin: 0 auto;
    }
    #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
    .pane-content {
        padding: 0 10px;
    }
</style>
    <?php
        if($session->read("undocked") == 'yes') {
    ?>
<script>
    $(window).bind("load", function () {
        //alert('sds');
        PdfPopup();
    });
</script>
    <?php
        }
        else if($session->read("leftpaneSize") > 0) {
    ?>
<script>
    $(window).bind("load", function () {
        var leftpaneSize = '<?php echo $session->read("leftpaneSize"); ?>';
        var splitter = $("#horizontal").data("kendoSplitter");
        splitter.size(".k-pane:first", leftpaneSize);
    });
</script>
    <?php
        }
    ?>

<script>
    $(window).unload(function () {
        myWindow.close();
    });


    function query()
    {
        document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block';

        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        var puValue = document.getElementById('qc_comments_puvalue');
        var attrName = document.getElementById('qc_comments_attributedisplayname');
        var ProjAttrId = document.getElementById('qc_comments_projectattributeid');
        var AttrId = document.getElementById('qc_comments_attributeid');
        var seq = document.getElementById('qc_comments_rowno');
        var controlName = document.getElementById('qc_comments_controlname');

        var prodvalue = puValue.value;
        var attribute = attrName.value;
        var ProjectAttributeMasterId = ProjAttrId.value;
        var AttributeMasterId = AttrId.value;
        var SequenceNumber = seq.value;
        //    var ButtonType = controlName.value;
        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var page = seq.value;


//        if (ButtonType == 'TextBox') {
//            ButtonType = '2';
//            $('#QcCtlTextbox').show();
//            $('#QcCtlDropdown').hide();
//            $('#QcCtlMultiTextbox').hide();
//            //$('#QcCtlCmnd').hide();
//        }
//        if (ButtonType == 'MultiTextBox') {
//            ButtonType = '3';
//            $('#QcCtlTextbox').hide();
//            $('#QcCtlDropdown').hide();
//            $('#QcCtlMultiTextbox').show();
//            //$('#QcCtlCmnd').show();
//        }
//        if (ButtonType == 'DropDownList') {
//            ButtonType = '1';
//            $('#QcCtlTextbox').hide();
//            $('#QcCtlDropdown').show();
//            $('#QcCtlMultiTextbox').hide();
//            //$('#QcCtlCmnd').hide();
//        }
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                if (resultData['tlAccept'] != '') {
                    $('#QuerySubmit').hide();
                    $('#Cancel').hide();
                    $('#Delete').hide();
                } else {
                    $('#QuerySubmit').show();
                    $('#Cancel').show();
                    $('#Delete').show();
                }
                if (resultData['attrId'] != '') {
                    $('#CommentsId').val(resultData['attrId']);
                } else {
                    $('#CommentsId').val(0);
                }
            }
        });
if(prodvalue == ''){
$('#PUvalue').text('--');
}
else{
        $('#PUvalue').text(prodvalue);
}
        $('#Attribute').text(attribute);

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetrebutaldata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('oldData').innerHTML = result;
            }
        });


        showOldData(prodvalue, attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, SequenceNumber);

    }

    function showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, SequenceNumber)
    {
        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";

        var result = new Array();

//        if (ButtonType == 1) {
//            $.ajax({
//                type: "POST",
//                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxLoadDropdown')); ?>",
//                data: ({ProjectId: ProjectId, RegionId: RegionId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId, SequenceNumber: SequenceNumber}),
//                dataType: 'text',
//                async: false,
//                success: function (result) {
//                    document.getElementById('QcCtlDropdown').innerHTML = result;
//                }
//            });
//        }

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxgetolddata')); ?>",
            data: ({InsId: PUvalue, attName: attname, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {

                if (result != 'null') {
//                    if (ButtonType == 1) {
//                        var resultData = JSON.parse(result);
//                        var element = document.getElementById('QCValueDropdown');
//                        element.value = resultData['QCValue'];
//                    }
//                    if (ButtonType == 2) {
//                        var resultData = JSON.parse(result);
//                        document.getElementById('QCValueTextbox').value = resultData['QCValue'];
//                    }
//                    if (ButtonType == 3) {
//                        var resultData = JSON.parse(result);
//                        document.getElementById('QCValueMultiTextbox').value = resultData['QCValue'];
//                    }
                    var resultData = JSON.parse(result);
                    document.getElementById('QCComments').value = resultData['QCComments'];
                    //  document.getElementById('Reference').value = resultData['Reference'];
                    var element = document.getElementById('CategoryName');
                    element.value = resultData['ErrorCategoryMasterId'];
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxSubCategory')); ?>",
                        data: ({CategoryId: resultData['ErrorCategoryMasterId']}),
                        dataType: 'text',
                        async: false,
                        success: function (result) {
                            document.getElementById('LoadSubCategory').innerHTML = result;
                        }
                    });
                    var element = document.getElementById('SubCategory');
                    element.value = resultData['SubErrorCategoryMasterId'];

//                    var element = document.getElementById('QCValueDropdown');
//                    element.value = resultData['QCValue'];
//
//                    var element = document.getElementById('QCValueTextbox');
//                    element.value = resultData['QCValue'];
//
//                    var element = document.getElementById('QCValueMultiTextbox');
//                    element.value = resultData['QCValue'];

                }


            }
        });
    }
    function cleartext()
    {
        //alert("inside");
        $("#CategoryName").val(0);
        $("#SubCategory").val(0);
//        $('#QCValueTextbox').val('');
//        $('#QCValueMultiTextbox').val('');
//        $('#QCValueDropdown').val('');
        //       $('#Reference').val('');
        $('#QCComments').val('');

    }

    function getCategory(CategoryId) {

        var result = new Array();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxSubCategory')); ?>",
            data: ({CategoryId: CategoryId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadSubCategory').innerHTML = result;
            }
        });
    }

    function DeleteQuery() {
        $('#QuerySubmit').hide();
        $('#Cancel').hide();
        $('#Delete').hide();
        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
        var ProductionEntityID = "<?php echo $productionjob['Id'];?>";
        var StatusId = "<?php echo $productionjob['StatusId'];?>";
        var UserId = "<?php echo $productionjob['UserId'];?>";
        var seq = document.getElementById('qc_comments_rowno');
        var SequenceNumber = seq.value;

        var AttributeStatus = $("#AttributeStatus").val();

        var ProjAttrId = document.getElementById('qc_comments_projectattributeid');
        var AttrId = document.getElementById('qc_comments_attributeid');

        var ProjectAttributeMasterId = ProjAttrId.value;
        var AttributeMasterId = AttrId.value;
        var Attribute = $("#Attribute").html();
        var temp = $("#PUvalue").html();
        var OldValue = temp.replace(/<br>/g, "||");

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxquerydelete'));?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, AttributeStatus: AttributeStatus, StatusId: StatusId, UserId: UserId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('QcDeletedMessage').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('QcDeletedMessage').style.display = 'none';
//                    $("#QCValueTextbox").val('');
//                    $("#QCValueMultiTextbox").val('');
//                    $("#QCValueDropdown").val('');
//                    $("#Reference").val('');
                    $("#QCComments").val('');
                    $("#CategoryName").val(0);
                    $("#SubCategory").val(0);
                    showOldData(OldValue, Attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntityId, SequenceNumber)
                }, 2000);
            }

        });
        $('#QuerySubmit').show();
        $('#Cancel').show();
        $('#Delete').show();
    }
    function valicateQuery()
    {

        //alert("TESTINGGG");
        $('#QuerySubmit').hide();
        $('#Cancel').hide();
        $('#Delete').hide();

        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
        var ProductionEntityID = "<?php echo $productionjob['Id'];?>";
        var StatusId = "<?php echo $productionjob['StatusId'];?>";
        var UserId = "<?php echo $productionjob['UserId'];?>";
        var AttributeMasterId = "<?php echo $fieldValue['AttributeMasterId'];?>";
        var seq = document.getElementById('qc_comments_rowno');
        var SequenceNumber = seq.value;

        var AttributeStatus = $("#AttributeStatus").val();

        var ProjAttrId = document.getElementById('qc_comments_projectattributeid');
        var AttrId = document.getElementById('qc_comments_attributeid');

        var ProjectAttributeMasterId = ProjAttrId.value;
        var AttributeMasterId = AttrId.value;
        var ErrCategory = $.trim($('#CategoryName').val());
        var ErrSubCategory = $.trim($('#SubCategory').val());

        //  var Reference = $.trim($('#Reference').val());
//        var QCValueTextbox = $.trim($('#QCValueTextbox').val());
//        var QCValueMultiTextbox = $.trim($('#QCValueMultiTextbox').val());
        var OldValue = $.trim($('#OldValue').val());
        var CommentsId = $('#CommentsId').val();

        var Category = document.getElementById('CategoryName');
        var SubCategory = document.getElementById('SubCategory');

        var CategoryName = Category.options[Category.selectedIndex].text;
        var SubCategoryName = SubCategory.options[SubCategory.selectedIndex].text;

        var CategoryId = Category.options[Category.selectedIndex].value;
        var SubCategoryId = SubCategory.options[SubCategory.selectedIndex].value;

//        var QCValue;
//        if (QCValueTextbox != '') {
//            QCValue = $.trim($('#QCValueTextbox').val());
//        } else if (QCValueMultiTextbox != '') {
//            QCValue = $.trim($('#QCValueMultiTextbox').val());
//        } else {
//            var QCValueDropdown = document.getElementById('QCValueDropdown');
//            QCValue = QCValueDropdown.options[QCValueDropdown.selectedIndex].value;
//        }
        if (ErrCategory == 0)
        {
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#Delete').show();
            alert("Select Error Category!");
            $("#CategoryName").focus();
            return false;
        }
        if (ErrSubCategory == 0)
        {
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#Delete').show();
            alert("Select Error Sub Category!");
            $("#SubCategory").focus();
            return false;
        }
//        if (QCValue == '')
//        {
//            $('#QuerySubmit').show();
//            $('#Cancel').show();
//            $('#Delete').show();
//            alert("Enter QCValue!");
//            // $("#QCValue").focus();
//            return false;
//        }

        var QCComments = $.trim($("#QCComments").val());
        if (QCComments == '')
        {
            $('#QuerySubmit').show();
            $('#Cancel').show();
            $('#Delete').show();
            alert("Enter QC Comments");
            $("#QCComments").focus();
            return false;
        }


        var Attribute = $("#Attribute").html();
        var temp = $("#PUvalue").html();
        var OldValue = temp.replace(/<br>/g, "||");

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxqueryinsert'));?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, CommentsId: CommentsId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, AttributeStatus: AttributeStatus, StatusId: StatusId, UserId: UserId, Attribute: Attribute, OldValue: OldValue, QCComments: QCComments, SequenceNumber: SequenceNumber, CategoryName: CategoryName, CategoryId: CategoryId, SubCategoryName: SubCategoryName, SubCategoryId: SubCategoryId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('QcsuccessMessage').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('QcsuccessMessage').style.display = 'none';
//                    $("#QCValueTextbox").val('');
//                    $("#QCValueMultiTextbox").val('');
//                    $("#QCValueDropdown").val(0);
//                    $("#Reference").val('');
                    $("#QCComments").val('');
                    $("#CategoryName").val(0);
                    $("#SubCategory").val(0);
                    showOldData(OldValue, Attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntityId, SequenceNumber)
                }, 2000);
            }

        });
        $('#QuerySubmit').show();
        $('#Cancel').show();
        $('#Delete').show();
    }

    function formSubmit() {

        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";
        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
        var UserId = "<?php echo $productionjob['UserId'];?>";
        var seq = document.getElementById('qc_comments_rowno');
        var SequenceNumber = seq.value;
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'rebutalCommentsCount')); ?>",
            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, UserId: UserId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result != '') {
                    $('#resultcnt').val(result);
                } else {
                    $('#resultcnt').val('');
                }
            }
        });
        var resultcnt = $('#resultcnt').val();
        if (resultcnt != '') {
            alert("TL Rebutal Records in row " + resultcnt + ". Please Mark Error or Delete");
            return false;
        } else {
            return true;
        }

         <?php
    if(isset($Mandatory)) {
    $js_array = json_encode($Mandatory);
    echo "var mandatoryArr = ". $js_array . ";\n";
    }
    ?>
        var mandatary = 0;

//        if (typeof mandatoryArr != 'undefined') {
//            $.each(mandatoryArr, function (key, elementArr) {
//                element = elementArr['AttributeMasterId']
//
//                if ($('#' + element).val() == '') {
//                    // alert(($('#' + element).val()));
//                    alert('Enter Value in ' + elementArr['DisplayAttributeName']);
//                    $('#' + element).focus();
//                    mandatary = '1';
//                    return false;
//                }
//            });
//        }


        if (mandatary == 0) {
            AjaxSave('');
            return true;

        } else
            return false;
    }
</script>