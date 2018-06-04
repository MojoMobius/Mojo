<?php

use Cake\Routing\Router;
if($NoNewJob=='NoNewJob') {
?><br><br>
<div align="center" style="color:green;">
    <b><?php echo 'No New Job Available Now! <br> Check Later to have new job!';?></b>
    <br><br>
</div>
<?php   
} else if($this->request->query['job']=='completed' || $this->request->query['job']=='Query') {
?>
<br><br>
<div align="center" style="color:green;">
    <b>
        <?php
        if($this->request->query['job']=='completed')
            echo 'Job completed.<br>';
         else
            echo 'Query Posted Successfully.<br>';
        ?>
        <?php echo 'Click Get Job Button to get new Job';?>
    </b>
    <br><br>
    <div style="margin:0px 0px 5px 0px;">
        <button class="btn btn-default btn-sm" type="button" onclick="getJob()">Get Job</button>
    </div>
</div><br><br>   
<?php
} else if($getNewJOb=='getNewJOb' ) {
    echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms'));
?>
<br><br>
<div align="center" style="color:green;">
    <b><?php echo 'Click Get Job Button to get new Job';?></b>
    <br><br>
    <div style="margin:0px 0px 5px 0px;">
        <?php echo $this->Form->button('GetJob', array( 'id' => 'NewJob', 'name' => 'NewJob', 'value' => 'NewJob','class'=>'btn btn-default btn-sm')); ?>
    </div>
</div>
    <?php echo $this->Form->end();   
} else {
    echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms','name'=>'getjob'));
?>
<input type="hidden" name='QcCmdVal' id='QcCmdVal' >
<input type="hidden" name='loaded' id='loaded' >
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
    <div class="container-fluid">
        <div class="panel panel-default formcontent">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                        Production Rework
                    </a> 
                    <span class="buttongrp">    
<!--                        <a class="btn btn-primary btn-xs pull-right" href="#popup1" style="margin-top:-4px;">Query</a>-->
                        <button type="button" name='AddNew' value="AddNew" class="btn btn-primary btn-xs pull-right" style="margin-right:3px;" onclick="addnewpage();">Add New</button>
                        <button type="button" name='Save' value="Save" class="btn btn-primary btn-xs pull-right" onclick="AjaxSave('');">Save</button>
                        <button type="submit" name='Submit' value="Submit" class="btn btn-primary btn-xs pull-right" onclick="return formSubmit();">Submit Production</button>
                        <a class="btn btn-primary btn-xs pull-right" href="#command" style="margin-top:-4px;" onclick = "OpenCommand();">Qc Comments</a>    
                    </span>
                </h3>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <span  class="form-horizontal" id="">        
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label" ><b><?php echo $moduleName;?> process:</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
                                <?php foreach ($StaticFields as $key => $value) { ?>
                                <a style="color:#555b86 !important;" href="#"><u><?php echo $value['DisplayAttributeName']; ?>: <?php echo $productionjob[$value['AttributeMasterId']];?></u></a><br>
                                <input type="hidden" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" >
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group" >
                            <label for="inputEmail3" class="col-sm-6 control-label" ><b>Batch Name:</b></label>
                            <div class="col-sm-6 " style="padding-top: 3px;">
                                <?php echo $BatchName['BatchName']; ?>
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
                                           if(empty($productionjob['TimeTaken']))
                                                $hrms[0]='00:00:00';
                                            else
                                                $hrms=explode('.',$TimeTaken);
                                           ?><?php echo $hrms[0];?>
                                    </span>
                                    <?php echo $this->Form->input('', array( 'type'=>'hidden','id' => 'TimeTaken', 'name' => 'TimeTaken','value' => $hrms[0])); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label"><b>Status:</b></label>
                            <div class="col-sm-6" style="padding-top: 3px;">
                                Production Rework in Progress
                            </div>
                        </div>
                    </div>
                </span>	
                <div class="">
                    <div class="form-group">
                        <div class="col-sm-12">
                        </div>
                    </div>
                </div>
                <?php if(!empty($DynamicFields)){?>
                <div id="top-pane" readonly="readonly">
                    <div class="pane-content" style="width:99.7%;" >
                        <div class="form-horizontal">
                            <div class="form-group form-group-sm form-inline" id='appendNew' style="overflow-x: scroll;overflow-y:hidden !important; white-space: nowrap;padding-bottom: 15px;margin-left:10px;">
                                <?php foreach ($DynamicFields as $key => $value) { ?>
                                <span  class="form-horizontal" id="">        
                                    <div class="col-md-4" style="padding-left:40px;">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-6 control-label" style="padding-top: 12px;"><b><?php echo $value['DisplayAttributeName'];?></b></label>
                                            <div class="col-sm-6 " style="padding-top: 3px;">
                                                <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                                <input class="form-control" type="text"  size="40" title="<?php echo $value['AttributeMasterId'];?>" name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                                <select class="form-control"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" onchange="<?php echo $value['Reload'];?>" >
                                                    <option value="0">--select--</option>
                                                    <?php foreach($value['Options'] as $key_opt=>$opt) { ?>
                                                    <option value="<?php echo $key_opt;?>" <?php if($dynamicData[$value['AttributeMasterId']]==$key_opt) { echo 'Selected';} ?>><?php echo $opt;?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                                <textarea class="form-control" title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')"><?php echo $dynamicData[$value['AttributeValue']];?></textarea>
                                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                                <input class="form-control" type="radio" <?php if($dynamicData[$value['AttributeValue']]=='Valid') { echo 'checked';}?> id="<?php echo $value['AttributeMasterId']; ?>" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                                <input class="form-control" type="radio" <?php if($dynamicData[$value['AttributeValue']]=='InValid') { echo 'checked';}?> id="<?php echo $value['AttributeMasterId']; ?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid
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

<!-- /container -->
<?php //pr($productionjob);?>
<input type="hidden" name='ProductionId' id="ProductionId" value="<?php echo $productionjob['Id'];?>">
<input type="hidden" name='ProductionEntity' id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>">
<input type="hidden" name='StatusId' value="<?php echo $productionjob['StatusId'];?>">
<input type="hidden" name='RegionId' id='RegionId' value="<?php echo $productionjob['RegionId'];?>">
<input type="hidden" name="ADDNEW" id="ADDNEW" value="">
<?php
    echo $this->Form->input('', array( 'type'=>'hidden','id' => 'addnewActivityChange', 'name' => 'addnewActivityChange','value'=>$addnewActivityChange));
    echo $this->Form->input('', array( 'type'=>'hidden','id' => 'page', 'name' => 'page','value'=>$page));
    echo $this->Form->input('', array( 'type'=>'hidden','id' => 'prevPage', 'name' => 'prevPage','value'=>$this->request->params[paging][GetJob][prevPage]));
    echo $this->Form->input('', array( 'type'=>'hidden','id' => 'nextPage', 'name' => 'nextPage','value'=>$this->request->params[paging][GetJob][nextPage]));
?>
<div id="example" class="container-fluid" style="margin-bottom:-10px;">
    <div id="vertical">
        <div id="top-pane" class="tap-pane">
            <div id="horizontal" style="height: 100%; width: 100%;">
                <div id="left-pane">
                    <div class="pane-content">
                        <!-- Load pdf file starts -->
                        <div style="margin-top:10px;"><iframe onload="onMyFrameLoad(this)" id="frame" sandbox="" src="<?php echo $FirstLink;?>"></iframe>
                        </div> 
                        <!-- Load pdf file ends-->
                    </div>
                </div>
                <div id="right-pane">
                    <?php
                        $previous='true';
                        if($page>1)
                            $previous='false';
                         $next='disabled="disabled"';
                        if($page<$SequenceNumber)
                            $next='';
                    ?>                          
                    <div class="col-md-12">
                        <div class="col-md-6 pull-left" style="width:56%;">
                            <?php  echo $this->Form->input('',array('options' => $Html, 'id'=>'status', 'name' => 'status', 'class'=>'form-control pull-left','style'=>'margin-left:-10px;margin-top: 5px;','onchange' =>'LoadPDF(this.value);')); ?>
                        </div>
                        <div class="pull-right" style="cursor:pointer;padding-top:5px;">
                            <button class="btn btn-primary btn-xs " name='gopdf' id='gopdf' onclick="OpenPdf();" type="button">Go</button>
                            <button class="btn btn-primary btn-xs " name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>
                            <button class="btn btn-primary btn-xs" type="button" id="clicktoviewPre" name="clicktoviewPre" value='clicktoviewPre' disabled='<?php echo $previous;?>' onclick="loadNext('previous');">&lt;&lt;</button>
                            <button class="btn btn-primary btn-xs" type="button" id="clicktoviewNxt" name="clicktoviewNxt" value="Next" <?php echo $next; ?> onclick="loadNext('next');" >&gt;&gt;</button>
                            <button class="btn btn-primary btn-xs" type="button" onclick="DeletePage();">X</button>
                            <button class="btn btn-primary btn-xs" type="button"> No of pages <span class="badge" id="SequenceNumber"><?php echo $SequenceNumber;?></span> </button> 
                        </div>
                    </div>
                    <input type="hidden" name="seq" id="seq" value='<?php echo $SequenceNumber;?>' > 
                    <div class="form-inline">
                            <?php foreach ($ProductionFields as $key => $value) {
                                $value['SequenceNumber']=1;
                            ?>
                            <div class="form-group mar" style="margin-left:20px;">
                                <p class="form-control-static col-xs-6 for-wid"><?php echo $value['DisplayAttributeName']; ?></p>
                                <?php if($value['ControlName']=='TextBox'|| $value['ControlName']=='Label') { ?>
                                    <input type="text" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" maxlength="<?php echo $value['MaxLength'];?>" minlength="<?php echo $value['MinLength'];?>">
                                <?php if($OldDataresultError[$value['AttributeMasterId']]['OldDataCount'] > 0) {?>
<!--                                    <div class='qcGreen_popuptitle'  style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } else if($OldDataresultRebutal[$value['AttributeMasterId']]['OldDataCount'] > 0) {?>
<!--                                    <div class='qcRed_popuptitle'  style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } else { ?>
<!--                                    <div class='qc_popuptitle' style="cursor: pointer; margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } ?>
                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                    <select class="form-control"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" onchange="<?php echo $value['Reload'];?>" >
                                        <option value="0">--select--</option>
                                            <?php foreach($value['Options'] as $key_opt=>$opt) { ?>
                                        <option value="<?php echo $key_opt;?>" <?php if($productionjob[$value['AttributeMasterId']]==$key_opt) { echo 'Selected';} ?>><?php echo $opt;?></option>
                                            <?php } ?>
                                    </select>
                                <?php if($OldDataresultError[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
<!--                                    <div class='qcGreen_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } else if($OldDataresultRebutal[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
<!--                                    <div class='qcRed_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } else { ?>
<!--                                    <div class='qc_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } ?>
                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                    <textarea class="form-control" title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')"><?php echo $productionjob[$value['AttributeMasterId']];?></textarea>
                                <?php if($OldDataresultError[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
<!--                                    <div class='qcGreen_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } else if($OldDataresultRebutal[$value['AttributeMasterId']]['OldDataCount'] > 0) { ?>
<!--                                    <div class='qcRed_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } else { ?>
<!--                                    <div class='qc_popuptitle' style="cursor: pointer;margin-left:350px;margin-top: -21px;" id='Error_<?php echo $value['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $value['DisplayAttributeName'];?>', '<?php echo $value['AttributeMasterId'];?>', '<?php echo $value['ProjectAttributeMasterId'];?>', '<?php echo $productionjob[$value['AttributeMasterId']];?>', '<?php echo $value['ControlName'];?>');" style="margin-top:-4px;"> </div>-->
                                <?php } ?>
                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                <?php } elseif($value['ControlName']=='Auto') { ?>
                                    <input type="text" class="form-control" size="40"  name="<?php echo $value['AttributeMasterId']; ?>" id="<?php echo $value['AttributeMasterId']; ?>" value="<?php echo $productionjob[$value['AttributeMasterId']];?>" onblur="<?php echo $value['FunctionName'];?>('<?php echo $value['AttributeMasterId'];?>', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>', '<?php echo $value['Dateformat'];?>', '<?php echo $value['AllowedDecimalPoint'];?>')" maxlength="<?php echo $value['MaxLength'];?>" minlength="<?php echo $value['MinLength'];?>">
                                <?php } ?>
                            </div>
                            <?php }?>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="light" class="white_content" style="position:fixed;">
            <div class="query_popuptitle"><div style='float:left;width:40%'><b>PU Rework Comments</b></div><div align='right'> <b><a onclick="document.getElementById('light').style.display = 'none';document.getElementById('fade').style.display = 'none';cleartext();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
            <div class="query_innerbdr">
                <div class="query_outerbdr" style='height:250px;overflow:auto;'>
                    <div id='QcsuccessMessage' align='center' style='display:none;color:green;'><b>Comments Successfully Posted!</b></div>
                    <div id='QcDeletedMessage' align='center' style='display:none;color:green;'><b>Comments Deleted Successfully!</b></div>
                    <input type='hidden' name='CommentsId' Id ='CommentsId' value='0'>
                    <?php echo $this->Form->input('', array( 'type'=>'hidden','id' => 'inspectionId', 'name' => 'inspectionId')); ?>
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
                    <div id='ErrorCatname' style='dispaly:block;'>
                        <label class="col-sm-4 control-label"><b>Error Category&nbsp;</b></label>
                        <div class="col-sm-7">
                            <pre class="" style='background-color:white;border:0px;padding:0px;' id='ErrorCategoryName'>-</pre>
                        </div>
                    </div>
                    <div id='SubErrorCatname' style='dispaly:block;'>
                        <label class="col-sm-4 control-label"><b>Error Sub Category&nbsp;</b></label>
                        <div class="col-sm-7">
                            <pre class="" style='background-color:white;border:0px;padding:0px;' id='SubCategoryName'>-</pre>
                        </div>
                    </div>
                    <div id='ErrorQcVal' style='dispaly:block;'>
                        <label class="col-sm-4 control-label"><b>QC Comments &nbsp;</b></label>
                        <div class="col-sm-7">
                            <pre class="" style='background-color:white;border:0px;padding:0px;' id='ErrQcCmd'>-</pre>
                        </div>
                    </div>
                    <div id='ErrorQcVal' style='dispaly:block;'>
                        <label class="col-sm-4 control-label"><b>Page.No &nbsp;</b></label>
                        <div class="col-sm-7">
                            <pre class="" style='background-color:white;border:0px;padding:0px;' id='ErrPageNo'>-</pre>
                        </div>
                    </div>
                    
                    <div  class="col-sm-10" id='oldData' ></div>
                    <div class="col-sm-12" style="text-align:center;margin-top: 7px;">
                        <?php
//                            echo $this->Form->button('Mark Error', array( 'id' => 'QuerySubmit', 'name' => 'QuerySubmit', 'value' => 'QuerySubmit','class'=>'btn btn-primary btn-sm','onclick'=>"return valicateQuery('".$value['AttributeMasterId']."','".$value['ProjectAttributeMasterId']."');",'type'=>'button')).' '; 
//                            echo $this->Form->button('Close', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-primary btn-sm','onclick'=>"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';cleartext();")).' '; 
//                            echo $this->Form->button('Delete', array( 'type'=>'button','id' => 'Delete', 'name' => 'Delete', 'value' => 'Delete','class'=>'btn btn-primary btn-sm','onclick'=>"cleartext();return DeleteQuery();")); 
                        ?>   
                    </div> &nbsp;&nbsp; 
                </div>
            </div>
        </div>
    <div id="fade" class="black_overlay"></div>
<?php
if($QueryDetails['StatusID']==1) {
?>
    <div id="popup1" class="overlay">
        <div class="popup">
            <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
            <h2>Query</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                <table style="width:100%">
                    <tr><td style="width:50%">Query</td><td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['Query'];?></textarea></td></tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                                <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-primary btn-sm','style'=>'margin-top: 8px;','onclick'=>"return valicateQuery();",'type'=>'button')).' '; 
                           //echo $this->Form->button('Cancel', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-warning','onclick'=>"queryPopupClose();")); ?>  
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php
    } else if($QueryDetails['StatusID']==3) {
?>
    <div id="popup1" class="overlay">
        <div class="popup" style="width:50%;">
            <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
            <h2>TL Comments</h2>
            <a class="close" href="#">&times;</a>
            <div class="content">
                <table style="width:100%">
                    <tr>
                        <td >User Query</td>
                        <td>TL Comments</td></tr>
                    <tr>
                    <tr>
                        <td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['Query']; ?></textarea></td>
                        <td><textarea name="query" id="query" rows="5" cols="35"><?php echo $QueryDetails['TLComments']; ?></textarea></td></tr>
                </table>
            </div>
        </div>
    </div>
<?php
    } else {
?>
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
                        <td> <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity'];?>"> 
                                <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-primary btn-sm','style'=>'margin-top: 8px;','onclick'=>"return valicateQuery();",'type'=>'button')).' '; 
                           //echo $this->Form->button('Cancel', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-warning','onclick'=>"queryPopupClose();")); ?>  
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<?php
    }
?>
    <div id="fade" class="black_overlay"></div>
<?php
 echo $this->Form->end();   
}
?>

    <!--Commands popup start here -->
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
                            <td class="Cell">PU Value</td>
<!--                            <td class="Cell">QC Value</td>-->
                            <td class="Cell">Error Category</td>
                            <td class="Cell">Sub Error Category</td>
<!--                            <td class="Cell">Reference</td>-->
                            <td class="Cell">QC Comments</td>
                            <td class="Cell">Page.No</td>
                            <td class="Cell">Accept</td>
                            <td class="Cell">Reject</td>
                            <td class="Cell">PU Rebutal Comments</td>
                        </tr>
                <?php $i=1; foreach($commandInfo as $val) { 
                    ?>
                        <tr class="Row">
                            <td class="Cell">
                            <?php echo $i;?><input type='hidden' name='cmd[]' value='<?php echo $val['Id'];?>'>
                                <input type='hidden' name='AttributeMasterId<?php echo $val['Id'];?>' value='<?php echo $val['AttributeMasterId'];?>'>
                                <input type='hidden' name='ProjectAttributeMasterId<?php echo $val['Id'];?>' value='<?php echo $val['ProjectAttributeMasterId'];?>'>
                                <input type='hidden' name='InputEntityId<?php echo $val['Id'];?>' value='<?php echo $val['InputEntityId'];?>'>    
                                <input type='hidden' name='SequenceNumber<?php echo $val['Id'];?>' value='<?php echo $val['SequenceNumber'];?>'>    
                                <input type='hidden' name='QCValue<?php echo $val['Id'];?>' value='<?php echo $val['QCValue'];?>'>
                                <input type='hidden' name='Reference<?php echo $val['Id'];?>' value='<?php echo $val['Reference'];?>'>
                                <input type='hidden' name='ModuleId' value='<?php echo $val['ModuleId'];?>'>
                            </td>
                            <td class="Cell"><?php echo $AttributeOrder[$val['RegionId']][$val['ProjectAttributeMasterId']]['DisplayAttributeName'];?></td>
                            <td class="Cell"><?php echo $val['OldValue'];?></td>
                            <td class="Cell"><?php echo $val['ErrorCategoryName'];?></td>
                            <td class="Cell"><?php echo $val['SubCategoryName'];?></td>
                            <td class="Cell"><?php echo $val['QCComments'];?></td>
                            <td class="Cell"><?php echo $val['SequenceNumber'];?></td>
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
<?php echo $this->Form->end(); ?>
    <!-- comment popup ends here -->

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

            function onResizeSplitter(e) {

                var leftpaneSize = $('#left-pane').data('pane').size;
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'upddateLeftPaneSizeSession')); ?>",
                    data: ({leftpaneSize: leftpaneSize}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {

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
            }
            //setTimeout(window.stop,8000);
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
        });

    </script>
    <style>
        #vertical {
            height: 750px;
            margin: 0 auto;
        }
        #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
        .pane-content {
            padding: 0 10px;
        }
    </style>
</div>


<script>
    var hms = '<?php echo $hrms[0];?>';   // your input string
    if (hms != '') {
        var a = hms.split(':'); // split it at the colons
        var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    } else
    {
        var seconds = 0;
    }
    function LoadPDF(file)
    {
        document.getElementById('frame').src = file;
        $("body", myWindow.document).find('#pdfframe').attr('src', file);
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

    function formSubmit() {
    <?php
    if(isset($Mandatory)) {
    $js_array = json_encode($Mandatory);
    echo "var mandatoryArr = ". $js_array . ";\n";
    }
    ?>
        var mandatary = 0;
        if (typeof mandatoryArr != 'undefined') {
            $.each(mandatoryArr, function (key, elementArr) {
                element = elementArr['AttributeMasterId']

                if ($('#' + element).val() == '') {
                    alert('Enter Value in ' + elementArr['DisplayAttributeName']);
                    $('#' + element).focus();
                    mandatary = '1';
                    return false;
                }
            });
        }
        if (mandatary == 0) {
            AjaxSave('');
            //----------------------------Qc Comments Accept or reject Validation--------------------------------
            var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
            var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
            var RegionId = "<?php echo $productionjob['RegionId'];?>";
            
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxCommentsChk'));?>",
                data: ({InputEntyId: InputEntyId, ProjectId: ProjectId, RegionId: RegionId}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    if (result == 0) {
                        $("#QcCmdVal").val(result);
                        return true;
                    }else{
                        alert("Please Accept or Reject Qc Comments");
                        $("#QcCmdVal").val(result);
                        return false;
                    }
                }
            });
            //------------------------------------------------------------
        } else
            return false;
    }
    function getJob()
    {
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

    function PdfPopup()
    {
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
        myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:96%; overflow:hidden !important; margin-top:15px !important;"></iframe>');

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'yes'}),
            dataType: 'text',
            async: true,
            success: function (result) {

            }
        });
    }
    function valicateQuery()
    {
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
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxqueryposing'));?>",
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
    function LoadValue(id, value, toid) {

        var Region = $('#RegionId').val();
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxloadresult'));?>",
            data: ({id: id, value: value, toid: toid, Region: Region}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var obj = JSON.parse(result);
                var k = 1;
                var x = document.getElementById(toid);
                document.getElementById(toid).options.length = 0;
                var option = document.createElement("option");
                option.text = '--Select--';
                option.value = 0;
                x.add(option, x[0]);
                $.each(obj, function (key, element) {
                    var option = document.createElement("option");
                    option.text = element['Value'];
                    option.value = element['id'];
                    x.add(option, x[k]);
                    k++;
                });
            }
        });
    }
    $(function () {

<?php
if(isset($AutoSuggesstion)){
$AutoSuggesstion_json = json_encode($AutoSuggesstion);
echo "var autoArr = ". $AutoSuggesstion_json . ";\n";
}
?>
        if (typeof mandatoryArr != 'undefined') {
            $.each(autoArr, function (key, element) {
                //autoArr.forEach(function (element) {
                var result = new Array();
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxautofill'));?>",
                    data: ({element: element}),
                    dataType: 'text',
                    async: false,
                    success: function (result) {
                        availableTags = JSON.parse(result);
                    }
                });
                $("#" + element).autocomplete({
                    source: availableTags
                });
            });
        }
    });
    function AjaxSave(addnewpagesave) {
        document.getElementById('fade').style.display = 'block';
        <?php
        if(isset($Mandatory)) {
    $js_array = json_encode($Mandatory);
    echo "var mandatoryArr = ". $js_array . ";\n";
        }
    ?>
        var mandatary = 0;
        if (typeof mandatoryArr != 'undefined') {
            $.each(mandatoryArr, function (key, elementArr) {
                element = elementArr['AttributeMasterId']
                if ($('#' + element).val() == '') {
                    alert('Enter Value in ' + elementArr['DisplayAttributeName']);
                    $('#' + element).focus();
                    mandatary = '1';
                    return false;
                }
            });
        }
        if (mandatary == 0) {

        } else
            return false;

        var addnew = $('#ADDNEW').val();
        var productionData = new Array();
        var productionData_ely = new Array();
        var productionData_projatt = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var staticDatavar = new Array();
        var staticData_elyvar = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var staticArr =<?php if(isset($StaticFields)) { echo json_encode($StaticFields );} else echo "''";?>;
        var i = 0;
        var j = 0;
        var k = 0;

        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                var elts = element['ProjectAttributeMasterId'];
                productionData[i] = $('#' + elt).val();
                productionData_ely[j] = elt;
                productionData_projatt[k] = elts;
            }
            i++;
            j++;
            k++;
        });

        var i = 0;
        var j = 0;
        if (typeof dynamicArr != 'undefined') {
            $.each(dynamicArr, function (key, element) {
                if (element['AttributeMasterId'] != '') {
                    var elt = element['AttributeMasterId'];
                    dynamicData[i] = $('#' + elt).val();
                    dynamicData_ely[j] = elt;
                }
                i++;
                j++;
            });
        }
        s = 0;
        v = 0;

        if (typeof staticArr != 'undefined') {
            $.each(staticArr, function (key, element) {
                if (element['AttributeMasterId'] != '') {
                    var elt = element['AttributeMasterId'];
                    staticDatavar[s] = $('#' + elt).val();
                    staticData_elyvar[v] = elt;
                }
                s++;
                v++;
            });
        }

        var ProductionEntity = $('#ProductionEntity').val();
        var SequenceNumber = $('#page').val();
        var TimeTaken = $('#TimeTaken').val();
        var RegionId = $('#RegionId').val();
        $('#ADDNEW').val('');
        if (addnew == '') {
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxsave'));?>",
                data: ({productionData_ely: productionData_ely, productionData_projatt: productionData_projatt, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken, RegionId: RegionId}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    if (result === 'saved') {
                        if (addnewpagesave == '') {
                            alert('Entered Data Successfully saved!');
                            document.getElementById('fade').style.display = '';
                        }
                    } else {
                        window.location = "users";
                    }
                }
            });
        }
        if (addnew == 'ADDNEW') {
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxnewsave'));?>",
                data: ({staticDatavar: staticDatavar, staticData_elyvar: staticData_elyvar, productionData_ely: productionData_ely, productionData_projatt: productionData_projatt, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken, RegionId: RegionId}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    if (result === 'saved') {
                        alert('Additional Page Added Successfully');
                        document.getElementById('SequenceNumber').innerHTML = $('#seq').val();
                        loadNextAddnew('next');
                    } else {
                        window.location = "users";
                    }
                }
            });
        }
    }

    function loadNextAddnew(id) {
        document.getElementById('fade').style.display = 'block';
        var page = $('#page').val();
        var seq = $('#seq').val();
        if (id === 'next') {
            if (page == seq) {
                $("#clicktoviewNxt").prop("disabled", "disabled");
            }
            if (page == 1) {
                $("#clicktoviewPre").prop("disabled", "disabled");
            }
            if (page > 1) {
                $("#clicktoviewPre").prop("disabled", "");
            }
        }

        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var i = 0;
        j = 0;

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result == 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                $.each(prodArr, function (key, element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData[elt]);
                    i++;
                    j++;
                });
                document.getElementById('fade').style.display = '';
            }
        });
    }

    function loadNext(id) {
        AjaxSave('addnew');
        $('#ADDNEW').val('');
        document.getElementById('fade').style.display = 'block';
        var page = $('#page').val();
        var seq = $('#seq').val();
        if (id === 'next') {
            page = parseInt(page) + 1;
            if (page == seq) {
                $("#clicktoviewNxt").prop("disabled", "disabled");
            }
            if (page == 1) {
                $("#clicktoviewPre").prop("disabled", "disabled");
            }
            if (page > 1) {
                $("#clicktoviewPre").prop("disabled", "");
            }
        }
        if (id === 'previous') {
            page = parseInt(page) - 1;
            if (page == seq) {
                $("#clicktoviewNxt").prop("disabled", "disabled");
            }
            if (page == 1) {
                $("#clicktoviewPre").prop("disabled", "disabled");
            }
            if (page > 1) {
                $("#clicktoviewPre").prop("disabled", "");
            }
            if (page != seq && seq > 1) {
                $("#clicktoviewNxt").prop("disabled", "");
            }
        }
        $('#page').val(page);
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var readonlyArr =<?php echo json_encode($ReadOnlyFields );?>;
        var i = 0;
        j = 0;

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                $.each(prodArr, function (key, element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData[elt]);
                    i++;
                    j++;
                });
                document.getElementById('fade').style.display = '';
            }
        });
    }
    
    function addnewpage() {

    <?php
    if(isset($Mandatory)) {
    $js_array = json_encode($Mandatory);
    echo "var mandatoryArr = ". $js_array . ";\n";
    }
    ?>
        var mandatary = 0;
        if (typeof mandatoryArr != 'undefined') {
            $.each(mandatoryArr, function (key, elementArr) {
                element = elementArr['AttributeMasterId']
                if ($('#' + element).val() == '') {
                    alert('Enter Value in ' + elementArr['DisplayAttributeName']);
                    $('#' + element).focus();
                    mandatary = '1';
                    return false;
                }
            });
        }
        if (mandatary == 0) {
        } else
            return false;

        AjaxSave('addnew');
        document.getElementById('fade').style.display = 'block';
        var page = $('#seq').val();
        var newseq = parseInt(page) + 1;
        $('#page').val(newseq);
        $('#seq').val(newseq);

        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var i = 0;
        j = 0;
        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                $('#' + elt).val('');
            }
            i++;
            j++;
        });
        $('#ADDNEW').val('ADDNEW');
        document.getElementById('fade').style.display = '';
    }

    function AjaxNewSave() {
        document.getElementById('fade').style.display = 'block';
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var i = 0;
        j = 0;
        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                productionData[i] = $('#' + elt).val();
                productionData_ely[j] = elt;
            }
            i++;
            j++;
        });

        var i = 0;
        j = 0;
        if (typeof dynamicArr != 'undefined') {
            $.each(dynamicArr, function (key, element) {
                if (element['AttributeMasterId'] != '') {
                    var elt = element['AttributeMasterId'];
                    dynamicData[i] = $('#' + elt).val();
                    dynamicData_ely[j] = elt;
                }
                i++;
                j++;
            });
        }

        var ProductionEntity = $('#ProductionEntity').val();
        var SequenceNumber = $('#page').val();
        var TimeTaken = $('#TimeTaken').val();
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxnewsave'));?>",
            data: ({productionData_ely: productionData_ely, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                document.getElementById('fade').style.display = '';
            }
        });
    }
    
    function DeletePage() {
        document.getElementById('fade').style.display = 'block';
        var r = confirm("Are you sure want to delete this page?");
        if (r == true) {
        } else {
            return false;
        }
        var page = $('#page').val();
        var ProductionEntity = $('#ProductionEntity').val();
        var ProductionId = $('#ProductionId').val();
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxdelete'));?>",
            data: ({page: page, ProductionId: ProductionId, ProductionEntity: ProductionEntity}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result === 'expired') {
                    window.location = "users";
                }
                if (result === 'one') {
                    alert('Minimum one Row Required');
                    return false;
                }
                if (result === 'deleted') {
                    var newseq = parseInt($('#seq').val()) - 1;
                    alert('Deleted Successfully');
                    $('#seq').val(newseq);
                    document.getElementById('SequenceNumber').innerHTML = newseq;
                    if (page == 1) {
                        loadNext('next');
                    } else {
                        loadNext('previous');
                    }
                    return false
                }
                document.getElementById('fade').style.display = '';
            }
        });
    }
    
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

        var radios = document.getElementsByName('qcstatus<?php echo $val['Id'];?>');
        var formValid = false;

        var i = 0;
        while (!formValid && i < radios.length) {
            if (radios[i].checked)
                formValid = true;
            i++;
        }

        if (!formValid)
            alert("Must check some option!");

        if ($("#UserReputedComments_<?php echo $val['Id'];?>").prop('disabled') == false) {
            if ($('#UserReputedComments_<?php echo $val['Id'];?>').val() == '') {
                alert('Please Enter UserReputed Comments');
                $('#UserReputedComments_<?php echo $val['Id'];?>').focus();
                return false;
            }
        } else {
            return formValid;
        }
    }
    
    function query(attname, AttributeMasterId, ProjectAttributeMasterId, PUvalue, ButtonType)
    {
        document.getElementById('light').style.display = 'block';
        document.getElementById('fade').style.display = 'block';

        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
        if (Attribute == '')
            Attribute = '-';
        if (AttributeMasterId == '')
            AttributeMasterId = '-';
        if (ProjectAttributeMasterId == '')
            ProjectAttributeMasterId = '-';
        if (PUvalue == '')
            PUvalue = '-';

        if (ButtonType == 'TextBox') {
            ButtonType = '2';
            $('#QcCtlTextbox').show();
            $('#QcCtlDropdown').hide();
            $('#QcCtlMultiTextbox').hide();
        }
        if (ButtonType == 'MultiTextBox') {
            ButtonType = '3';
            $('#QcCtlTextbox').hide();
            $('#QcCtlDropdown').hide();
            $('#QcCtlMultiTextbox').show();
        }
        if (ButtonType == 'DropDownList') {
            ButtonType = '1';
            $('#QcCtlTextbox').hide();
            $('#QcCtlDropdown').show();
            $('#QcCtlMultiTextbox').hide();
        }
        var SequenceNumber = $('#page').val();
        if (SequenceNumber == '') {
            SequenceNumber = '1';
        }
        var page = $('#page').val();
        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxgetnextpagedata'));?>",
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
                var elt = AttributeMasterId;
                if (resultData['attrval'][elt] == '') {
                    $('#PUvalue').text('--');
                } else {
                    $('#PUvalue').text(resultData['attrval'][elt]);
                }
                if (resultData['ErrorCategoryName'] == null) {
                    $('#ErrorCategoryName').text('--');
                } else {
                    $('#ErrorCategoryName').text(resultData['ErrorCategoryName']);
                }
                if (resultData['SubCategoryName'] == null) {
                    $('#SubCategoryName').text('--');
                } else {
                    $('#SubCategoryName').text(resultData['SubCategoryName']);
                }
                if (resultData['ErrQcCmd'] == null) {
                    $('#ErrQcCmd').text('--');
                } else {
                    $('#ErrQcCmd').text(resultData['ErrQcCmd']);
                }
                if (resultData['ErrPageNo'] == null) {
                   $('#ErrPageNo').text('--');
                } else {
                    $('#ErrPageNo').text(resultData['ErrPageNo']);
                }
            }
        });

        $('#Attribute').text(attname);
        $('#AttributeMasterId').text(AttributeMasterId);
        $('#ProjectAttributeMasterId').text(ProjectAttributeMasterId);
        $('#ButtonType').text(ButtonType);

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobrework','action'=>'ajaxgetrebutaldata'));?>",
            data: ({page: page, next_status_id: next_status_id, ProductionEntity: ProductionEntity, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('oldData').innerHTML = result;
            }
        });

        showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, SequenceNumber, ButtonType);
    }
    
    function showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, SequenceNumber, ButtonType)
    {
        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
        var RegionId = "<?php echo $productionjob['RegionId'];?>";

        var result = new Array();

        if (ButtonType == 1) {
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxLoadDropdown')); ?>",
                data: ({ProjectId: ProjectId, RegionId: RegionId, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId, SequenceNumber: SequenceNumber}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    document.getElementById('QcCtlDropdown').innerHTML = result;
                }
            });
        }

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxgetolddata')); ?>",
            data: ({InsId: PUvalue, attName: attname, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId, SequenceNumber: SequenceNumber}),
            dataType: 'text',
            async: false,
            success: function (result) {

                if (result != 'null') {
                    if (ButtonType == 1) {
                        var resultData = JSON.parse(result);
                        var element = document.getElementById('QCValueDropdown');
                        element.value = resultData['QCValue'];
                    }
                    if (ButtonType == 2) {
                        var resultData = JSON.parse(result);
                        document.getElementById('QCValueTextbox').value = resultData['QCValue'];
                    }
                    if (ButtonType == 3) {
                        var resultData = JSON.parse(result);
                        document.getElementById('QCValueMultiTextbox').value = resultData['QCValue'];
                    }
                    var resultData = JSON.parse(result);
                    document.getElementById('QCComments').value = resultData['QCComments'];
                    document.getElementById('Reference').value = resultData['Reference'];
                    var element = document.getElementById('CategoryName');
                    element.value = resultData['ErrorCategoryMasterId'];
                    $.ajax({
                        type: "POST",
                        url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxSubCategory')); ?>",
                        data: ({CategoryId: resultData['ErrorCategoryMasterId']}),
                        dataType: 'text',
                        async: false,
                        success: function (result) {
                            document.getElementById('LoadSubCategory').innerHTML = result;
                        }
                    });
                    var element = document.getElementById('SubCategory');
                    element.value = resultData['SubErrorCategoryMasterId'];

                    var element = document.getElementById('QCValueDropdown');
                    element.value = resultData['QCValue'];

                    var element = document.getElementById('QCValueTextbox');
                    element.value = resultData['QCValue'];

                    var element = document.getElementById('QCValueMultiTextbox');
                    element.value = resultData['QCValue'];
                }
            }
        });
    }
    
    function getCategory(CategoryId) {
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'Getjobrework', 'action' => 'ajaxSubCategory')); ?>",
            data: ({CategoryId: CategoryId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('LoadSubCategory').innerHTML = result;
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
        top: 13%;
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
    $(window).unload(function () {
        myWindow.close();
    });
</script>