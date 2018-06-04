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
} else if ($getNewJOb == 'getNewJOb') {
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
    echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms', 'name' => 'getjob'));
    ?>
<input type="hidden" name='loaded' id='loaded' value="">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        Production
                    </a>
                    <span class="buttongrp">
<!--                        <a  class="btn btn-primary btn-xs pull-right" href="#popup1" style="margin-top:-4px;">Query</a>-->
                        <button type="submit" id="SubmitForm" style="margin-right:3px;" name='Submit' value="Submit" class="btn btn-primary btn-xs pull-right" >Submit Production</button>
                        <a class="btn btn-primary btn-xs pull-right" href="#command" style="margin-top:-4px;" onclick = "OpenCommand();">Qc Comments</a>  
                    </span>
                </h3>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <span  class="form-horizontal" id="">        
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label"><b><?php echo $moduleName; ?> process</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
                                <?php foreach ($StaticFields as $key => $value) { ?>
                                <a style="color:#555b86 !important;" href="#"><u><?php echo $value['DisplayAttributeName']; ?>:<?php echo $productionjob[$value['AttributeMasterId']]; ?></u></a>
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
                            <div class="col-sm-6" style="padding-top: 3px;"> Production in Progress </div>
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
                                            <label for="inputEmail3" class="col-sm-6 control-label"><b><?php echo $value['DisplayAttributeName']; ?></b></label>
                                            <input type="hidden" name="CommonAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" id="CommonAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" value="<?php echo $dynamicData[$value['AttributeMasterId']]; ?>">
                                            <div class="col-sm-6 " style="padding-top: 3px;">
<!--                                                         <input id="1390" class="form-control" size="40" name="1390" value="" onblur="('1390', this.value, '', '', '', '')" maxlength="" minlength="" type="text">-->
                                                        <?php if ($value['ControlName'] == 'TextBox' || $value['ControlName'] == 'Label') { ?>
                                                <input class="form-control" type="text"  size="40" title="<?php echo $value['AttributeMasterId']; ?>" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" onblur="<?php echo $value['FunctionName']; ?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]', this.value, '<?php echo $value['AllowedCharacter']; ?>', '<?php echo $value['NotAllowedCharacter']; ?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']]; ?>">
                                                        <?php } elseif ($value['ControlName'] == 'DropDownList') { ?>
                                                <select class="form-control" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]">
                                                    <option value="yes" <?php if ($value['AttributeValue'] == 'yes') { echo 'Selected'; } ?>>Yes</option>
                                                    <option value="no" <?php if ($value['AttributeValue'] == 'no') { echo 'Selected'; } ?>>No</option>
                                                </select>
                                                        <?php } elseif ($value['ControlName'] == 'MultiTextBox') { ?>
                                                <textarea title="<?php echo $value['AttributeValue']; ?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]" onblur="<?php echo $value['FunctionName']; ?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId']; ?>]', this.value, '<?php echo $value['AllowedCharacter']; ?>', '<?php echo $value['NotAllowedCharacter']; ?>')"><?php echo $dynamicData[$value['AttributeValue']]; ?></textarea>
                                                        <?php } elseif ($value['ControlName'] == 'RadioButton') { ?>
                                                <input class="form-control" type="radio" <?php if ($value['AttributeValue'] == 'Valid') { echo 'checked'; } ?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId']; ?>_1" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                                <input class="form-control" type="radio" <?php if ($value['AttributeValue'] == 'InValid') { echo 'checked'; } ?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId']; ?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid
                                                        <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </span>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

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

    <?php if($QueryDetails['StatusID']==1) { ?>
<div id="popup1" class="overlay">
    <div class="popup">
        <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
        <h2>Query</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <table style="width:100%">
                <tr><td style="width:50%">Query</td><td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['Query'];?></textarea></td></tr>
                <tr><td></td>
                    <td style="padding-top:10px !important;"><input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                            <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-primary btn-sm','style'=>'margin-top: 8px;','onclick'=>"return valicateQuery();",'type'=>'button')).' '; ?>  
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php } else if($QueryDetails['StatusID']==3) { ?>
<div id="popup1" class="overlay">
    <div class="popup" style="width:50%;">
        <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
        <h2>TL Comments</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <table style="width:100%">
                <tr>
                    <td >User Query</td>
                    <td>TL Comments</td>
                </tr>
                <tr>
                    <td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['Query']; ?></textarea></td>
                    <td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['TLComments']; ?></textarea></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php } else { ?>
<div id="popup1" class="overlay">
    <div class="popup">
        <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
        <h2>Query</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
            <table style="width:100%">
                <tr><td style="width:50%">Query</td><td><textarea name="query" id="query" rows="5" cols="35"></textarea></td></tr>
                <tr>
                    <td></td>
                    <td><input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                            <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-primary btn-sm','style'=>'margin-top: 8px;','onclick'=>"return valicateQuery();",'type'=>'button')).' '; ?>  
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php } ?>
<div id="fade3" class="black_overlay"></div>

<?php echo $this->Form->create('', array('name' => 'updateCommandPopup', 'id' => 'updateCommandPopup', 'class' => 'form-group', 'inputDefaults' => array( 'div' => false),'type'=> 'post')); ?>
<div id="command" class="white_content" style="width:70%; margin-left: -130px;">
    <div class="rebute_popuptitle"><b style="padding-left:20px;float:left;width:40%;">Comments</b><div align='right'> <b><a onclick="commandPopupClose();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
    <div class="query_innerbdr_disble">
        <div class="query_outerbdr">
            <div class="form-group form-group-sm rebute_popuphgt" style="height:200px;">
                <div class="col-sm-8">
                    <label hidden style="color:#ff7f06" id="filename"></label>
                </div>
                <table width='100%' id="rebuteTable">
                    <tr class='Heading'>
                        <td class="Cell">S.No</td>
                        <td class="Cell">Attribute</td>
                        <td class="Cell">Old Value</td>
<!--                        <td class="Cell">QC Value</td>
                        <td class="Cell">Reference</td>-->
                        <td class="Cell">Error Category</td>
                        <td class="Cell">Sub Error Category</td>
                        <td class="Cell">QC Comments</td>
                        <td class="Cell">Accept</td>
                        <td class="Cell">Reject</td>
                        <td class="Cell">PU Rebutal Comments</td>
                    </tr>
                <?php $i=1; foreach($commandInfo as $val) { 
                    ?>
                    <tr class="Row">
                        <td class="Cell">
                            <?php echo $i;?><input type='hidden' id="cmmd" name='cmd[]' value='<?php echo $val['Id'];?>'>
                            <input type='hidden' name='AttributeMasterId<?php echo $val['Id'];?>' value='<?php echo $val['AttributeMasterId'];?>'>
                            <input type='hidden' name='ProjectAttributeMasterId<?php echo $val['Id'];?>' value='<?php echo $val['ProjectAttributeMasterId'];?>'>
                            <input type='hidden' name='InputEntityId<?php echo $val['Id'];?>' value='<?php echo $val['InputEntityId'];?>'>    
                            <input type='hidden' name='SequenceNumber<?php echo $val['Id'];?>' value='<?php echo $val['SequenceNumber'];?>'>    
<!--                            <input type='hidden' name='QCValue<?php echo $val['Id'];?>' value='<?php echo $val['QCValue'];?>'>
                            <input type='hidden' name='Reference<?php echo $val['Id'];?>' value='<?php echo $val['Reference'];?>'>-->
                            <input type='hidden' name='ModuleId' value='<?php echo $val['ModuleId'];?>'>
                        </td>
                        <td class="Cell"><?php echo $AttributeOrder[$val['RegionId']][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];?></td>
                        <td class="Cell"><?php echo $val['OldValue'];?></td>
<!--                        <td class="Cell"><?php echo $val['QCValue'];?></td>
                        <td class="Cell"><?php echo $val['Reference'];?></td>-->
                        <td class="Cell"><?php echo $val['ErrorCategoryName'];?></td>
                        <td class="Cell"><?php echo $val['SubCategoryName'];?></td>
                        <td class="Cell"><?php echo $val['QCComments'];?></td>
                        <?php if($val['StatusId']==4) {
                            echo '<td class="Cell" colspan="3" style="color:green"> Accepted</td>';   
                        } else if($val['StatusId']==5) {
                            echo '<td class="Cell" colspan="2" style="color:Red"> Rejected</td>';   ?>
                        <td class="Cell"><?php echo $val['UserReputedComments'];?></td>
                        <?php } else { ?>
                        <td class="Cell"><input type='radio' name='qcstatus<?php echo $val['Id'];?>' id='accept' value=4 onclick='return userRebuted(this.value,<?php echo $val['Id'];?>);'></td>
                        <td class="Cell" ><input type='radio' name='qcstatus<?php echo $val['Id'];?>' id='reject' value=5 onclick='return userRebuted(this.value,<?php echo $val['Id'];?>);'></td>
                        <td class="Cell"> <textarea disabled='disabled' name='UserReputedComments_<?php echo $val['Id'];?>' id='UserReputedComments_<?php echo $val['Id'];?>'><?php echo $val['UserReputedComments'];?></textarea></td>
                        <?php } ?>
                    </tr>
                <?php $i++; } ?>
                </table>           
                <label class="col-sm-4 control-label">&nbsp;</label>
                <div class="col-sm-10" align="center">
                    <button class="btn btn-default btn-sm" type="submit" value="updateCommandPopupsubmit" name='updateCommandPopupsubmit'  id='updateCommandPopupsubmit' onclick = "return updateProductionfn();">Submit</button>
                    &nbsp;
                </div>
            </div>
            &nbsp;
        </div>
    </div>
</div>
<div id="fade3" class="black_overlay"></div>

<?php echo $this->Form->end(); } ?>
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
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'upddateLeftPaneSizeSession')); ?>",
            data: ({leftpaneSize: leftpaneSize}),
            dataType: 'text',
            async: true,
            success: function (result) {
                loadHotWidth();
            }
        });
    }

    function onExpandSplitter() {
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'no'}),
            dataType: 'text',
            async: true,
            success: function (result) {
            }
        });
        if (myWindow)
            myWindow.close();
        loadHotWidth();
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
    function LoadPDF(file) {
        document.getElementById('frame').src = file;
    }
    function loadHotWidth() {
        hot.updateSettings({
            width: '100%'
        });
    }
</script>

<script>
    var hms = '<?php echo $hrms[0]; ?>';   // your input string
    if (hms != '') {
        var a = hms.split(':'); // split it at the colons
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    } else {
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

    function getJob() {
        window.location.href = "Getjobrework?job=newjob";
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

    function PdfPopup() {
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
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'yes'}),
            dataType: 'text',
            async: true,
            success: function (result) {
            }
        });
        loadHotWidth();
    }

    function valicateQuery() {
        if ($("#query").val() == '')
        {
            alert('Enter Query');
            $("#query").focus();
            return false;
        }
        query = $("#query").val();
        InputEntyId = $("#ProductionEntity").val();

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxqueryposing')); ?>",
            data: ({query: query, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('successMessage').style.display = 'block';
                setTimeout(function () {
                    document.getElementById('successMessage').style.display = 'none';
                    $("#query").val(result);
                }, 2000);
            }
        });
    }

    function LoadPDF(file) {
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
//        readOnly: true,
        readOnly: false,
        manualColumnMove: true,
        stretchH: 'all',
        rowHeaders: true,
        manualRowResize: true,
        manualColumnResize: true,
        comments: false,
        contextMenu: ['undo', 'redo', 'make_read_only', 'alignment', 'remove_row'],
        colHeaders: ['DataId',
<?php
foreach ($handsonHeaders as $value) {
    echo "'" . $value . "',";
}
?>],
        columns: [
            {readOnly: true},
<?php foreach ($ReadOnlyFields as $key => $val) {
    echo "{readOnly: true},";
} ?>
<?php foreach ($ProductionFields as $key => $val) {
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
    } elseif ($val['ControlName'] == 'Auto') {
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
            }
        },
        beforeRemoveRow: function (change, source) {
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxremoverow')); ?>',
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
                url: '<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxsavedatahand')); ?>',
                dataType: 'json',
                type: 'POST',
                data: {changes: change, data: hot.getData()}, // contains changed cells' data
                success: function (result) {
                }
            });
        },
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
            url: '<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxconvert')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {keyval: keyval, changed: changed, production: production}, // contains changed cells' data
            success: function (result) {
                if (result) {
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
        var ProductionEntity = $('#ProductionEntity').val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxgetdatahand')); ?>',
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
    .query_outerbdr {
        background: #fff none repeat scroll 0 0;
        border-radius: 5px;
        margin: 3px;
        padding: 6px;
    }
    .white_content {
        background: #fdfdfd url("../img/popupbg.png") repeat-x scroll left top;
        border: 5px solid #fff;
        display: none;
        height: auto;
        left: 25%;
        padding: 16px;
        position: absolute;
        top: 10%;
        width: 50%;
        z-index: 1002;
    }
    .Heading {
        display: table-row;
        font-weight: bold;
        text-align: left;
        background: rgb(255,255,255); /* Old browsers */
        background: -moz-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgb(255,255,255)), color-stop(100%, rgb(229,229,229))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* IE10+ */
        background: linear-gradient(to bottom, rgb(255,255,255) 0%, rgb(229,229,229) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5', GradientType=0 ); /* IE6-9 */
        color: #5C5C5C;
    }
    .Row {
        display: table-row;
    }
    .Row1 {
        display: table-row;
        background-color: #f7f7f7;
    }
    .Cell {
        display: table-cell;
        border: 1px solid #e4e1e1;
        padding: 5px;
        font-size: 12px;
        color:#000;
    }
</style>
    <?php
        if($session->read("undocked") == 'yes') {
    ?>
<script>
    $(window).bind("load", function () {
        PdfPopup();
    });
</script>
    <?php
        } else if($session->read("leftpaneSize") > 0) {
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
    function datacheck(id, value) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxdatacheck'));?>",
            data: ({id: id, value: value}),
            dataType: 'text',
            async: false,
            success: function (result) {

            }
        });
    }

    function OpenCommand() {
        document.getElementById('command').style.display = 'block';
        document.getElementById('fade3').style.display = 'block'
    }

    function commandPopupClose() {
        document.getElementById('command').style.display = 'none';
        document.getElementById('fade3').style.display = 'none'
    }

    function userRebuted(radioVal, chkval) {
        if (radioVal == 5)
        {
            $("#UserReputedComments_" + chkval).removeAttr("disabled", "disabled");
        }
        if (radioVal == 4)
        {
            $("#UserReputedComments_" + chkval).val('');
            $("#UserReputedComments_" + chkval).attr("disabled", "disabled");
        }
    }

    function updateProductionfn() {

        var Id = $('#cmmd').val();

        var radios = document.getElementsByName('qcstatus' + Id);
        var formValid = false;

        var i = 0;
        while (!formValid && i < radios.length) {
            if (radios[i].checked)
                formValid = true;
            i++;
        }

        if (!formValid)
            alert("Must check some option!");

        if ($("#UserReputedComments_" + Id).prop('disabled') == false) {
            if ($('#UserReputedComments_' + Id).val() == '') {
                alert('Please Enter UserReputed Comments');
                $('#UserReputedComments_' + Id).focus();
                return false;
            }
        } else {
            return formValid;
        }
    }
    $(window).unload(function () {
        myWindow.close();
    });
</script>