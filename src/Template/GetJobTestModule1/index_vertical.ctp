<?php use Cake\Routing\Router;
if($NoNewJob=='NoNewJob') {
?>
    <br><br>
    <div align="center" style="color:green;">
        <b>
            <?php echo 'No New Job Available Now! <br> Check Later to have new job!';?>
        </b>
        <br><br>
        
    </div>
<?php   
}
else if($this->request->query['job']=='completed' || $this->request->query['job']=='Query')
{
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
        </div>
        <br><br>   
         <?php
}
else if($getNewJOb=='getNewJOb' ) {
        echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms'));
        ?>
        <br><br>
         <div align="center" style="color:green;">
        <b>
            <?php echo 'Click Get Job Button to get new Job';?>
        </b>
        <br><br>
        <div style="margin:0px 0px 5px 0px;">
            <?php echo $this->Form->button('GetJob', array( 'id' => 'NewJob', 'name' => 'NewJob', 'value' => 'NewJob','class'=>'btn btn-default btn-sm')); ?>
        </div>
    </div>
        <?php
     echo $this->Form->end();   
}
else
{
    //pr($productionjob);
    echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms','name'=>'getjob'));
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin-top:10px;">
       <div class="container-fluid">

        <div class="panel panel-default formcontent">
			<div class="panel-heading" role="tab" id="headingTwo">
                <h3 class="panel-title">
					<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration:none;">
						<i class="more-less glyphicon glyphicon-plus"></i>
						Production
					</a> <span class="buttongrp">    
                        <a  class="btn btn-primary btn-xs pull-right" href="#popup1" style="margin-top:-4px;">Query</a>
                        
                      
                <button type="submit" style="margin-right:3px;" name='Submit' value="Submit" class="btn btn-primary
                       btn-xs pull-right" onclick="return formSubmit();" >Submit Production</button> </span>
                </h3>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				<div class="">
					 
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-6
                        control-label"><b>Core process</b></label>
                     <div class="col-sm-6">
                        &nbsp;
                     </div>
                  </div>
               </div>
                 
               <div class="col-md-2">
                  <div class="form-group"> <?php foreach ($StaticFields as $key => $value) { ?>
             
            <a style="color:#555b86 !important;"
               href="#"><u><?php echo $value['DisplayAttributeName']; ?>:<?php echo $productionjob[$value['AttributeMasterId']];?></u></a>
             
              <?php } ?></div>
                  
                </div>
               
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-6
                        control-label">Timer</label>
                     <div class="col-sm-6" style="margin-top:5px">
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
                                 </a><br>
                     </div> 
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3
                        control-label">Status</label>
                     <div class="col-sm-8">
                        <label for="inputEmail3" class="col-sm-9
                           control-label">Production in Progress</label>
                     </div>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-2
                        control-label">&nbsp;</label>
                  
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-12">
                  </div>
               </div>
           
				</div>
                             <?php if(!empty($DynamicFields)){?>
                <div id="top-pane" readonly="readonly">
                    <div class="pane-content" style="width:99.7%;" >
                        <div class="form-horizontal">
                            <div class="form-group form-group-sm form-inline" id='appendNew' style="overflow-x: scroll;overflow-y:hidden !important; white-space: nowrap;padding-bottom: 15px;">
                                <?php foreach ($DynamicFields as $key => $value) { ?>
                                <div class="col-md-2">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6
                                   control-label"><b><?php echo $value['DisplayAttributeName'];?></b></label>
                                   <input type="hidden" name="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" id="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                            
                        </div>
                    </div>
                                <div class="col-md-2">
                        <div class="form-group">
                            
                            <div class="col-sm-6">
<!--                                <input id="1390" class="form-control" size="40" name="1390" value="" onblur="('1390', this.value, '', '', '', '')" maxlength="" minlength="" type="text">-->
                                 <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                        <input class="form-control" type="text"  size="40" title="<?php echo $value['AttributeMasterId'];?>" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                        <select class="form-control" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]">
                                            <option value="yes" <?php if($value['AttributeValue']=='yes') { echo 'Selected';} ?>>Yes</option>
                                            <option value="no" <?php if($value['AttributeValue']=='no') { echo 'Selected';} ?>>No</option>
                                        </select>
                                                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                        <textarea title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]', this.value, '<?php echo $value['AllowedCharacter'];?>', '<?php echo $value['NotAllowedCharacter'];?>')"><?php echo $dynamicData[$value['AttributeValue']];?></textarea>
                                                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                        <input class="form-control" type="radio" <?php if($value['AttributeValue']=='Valid') { echo 'checked';}?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId'];?>_1" name="<?php echo $value['AttributeMasterId']; ?>" value="Valid"> Valid
                                        <input class="form-control" type="radio" <?php if($value['AttributeValue']=='InValid') { echo 'checked';}?> id="CommonPAM_<?php echo $value['ProjectAttributeMasterId'];?>_2" name="<?php echo $value['AttributeMasterId']; ?>" value="InValid" > InValid
                                                    <?php } 
                                                    
                                         ?>
                            </div>
                        </div>
                    </div>
                                <?php } ?>


                            </div>
                        </div>
                    </div>
                </div>
                            <?php } ?>
			</div>
		</div>    </div></div>
        
        
        
        
        
        <!--
<div class="container-fluid">
         <div class="jumbotron formcontent">
            <h4>Production</h4>
            
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-6
                        control-label"><b>Core process</b></label>
                     <div class="col-sm-6">
                        &nbsp;
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-6
                        control-label">Timer</label>
                     <div class="col-sm-6" style="margin-top:5px">
                                 <a href="#">
                                     <span class="badge" id='countdown'>
                                         <?php
                                            //if(empty($productionjob['TimeTaken']))
                                             //       $hrms[0]='00:00:00';
                                            //    else
                                             //       $hrms=explode('.',$TimeTaken);
                                            ?><?php //echo $hrms[0];?>
                                     </span>
                                     <?php //echo $this->Form->input('', array( 'type'=>'hidden','id' => 'TimeTaken', 'name' => 'TimeTaken','value' => $hrms[0])); ?>
                                 </a><br>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-3
                        control-label">Status</label>
                     <div class="col-sm-8">
                        <label for="inputEmail3" class="col-sm-9
                           control-label">Production in Progress</label>
                     </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <label for="inputEmail3" class="col-sm-2
                        control-label">&nbsp;</label>
                     <div class="col-sm-10">
                         <a  class="btn btn-primary
                           btn-sm pull-right" href="#popup1">Query</a>
                        
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-sm-12">
                  </div>
               </div>
            
         </div>
      </div>
      <div class="container-fluid">
         <div class="well">
             
              <?php //foreach ($StaticFields as $key => $value) { ?>
             
            <a style="color:#555b86 !important;"
               href="#"><u><?php //echo $value['DisplayAttributeName']; ?>:<?php echo $productionjob[$value['AttributeMasterId']];?></u></a>
             
              <?php //} ?>
            <div class="pull-right">
                <?php //pr($productionjob);?>
                <input type="hidden" name='ProductionId' value="<?php //echo $productionjob['Id'];?>">
                <input type="hidden" name='ProductionEntity' value="<?php //echo $productionjob['ProductionEntity'];?>">
                <input type="hidden" name='StatusId' value="<?php// echo $productionjob['StatusId'];?>">
                <input type="hidden" name="ADDNEW" id="ADDNEW" value="<?php //echo $ADDNEW;?>">
                <?php
                //echo $this->Form->input('', array( 'type'=>'hidden','id' => 'addnewActivityChange', 'name' => 'addnewActivityChange','value'=>$addnewActivityChange));
               // echo $this->Form->input('', array( 'type'=>'hidden','id' => 'page', 'name' => 'page','value'=>$page));
               // echo $this->Form->input('', array( 'type'=>'hidden','id' => 'prevPage', 'name' => 'prevPage','value'=>$this->request->params[paging][GetJob][prevPage]));
               // echo $this->Form->input('', array( 'type'=>'hidden','id' => 'nextPage', 'name' => 'nextPage','value'=>$this->request->params[paging][GetJob][nextPage]));
                ?>
                <button type="submit" name='AddNew' value="AddNew" class="btn btn-primary
                  btn-sm pull-right">Add New</button>
                <button type="submit" name='Save' value="Save" class="btn btn-primary
                  btn-sm pull-right">Save</button>
                <button type="submit" name='Submit' value="Submit" class="btn btn-primary
                       btn-sm pull-right" onclick="return formSubmit();">Submit Production</button>
                       
            </div>
         </div>
      </div> -->
      <!-- /container -->
      <?php //pr($productionjob);?>
                <input type="hidden" name='ProductionId' value="<?php echo $productionjob['Id'];?>">
                <input type="hidden" name='ProductionEntity' value="<?php echo $productionjob['ProductionEntity'];?>">
                <input type="hidden" name='StatusId' value="<?php echo $productionjob['StatusId'];?>">
                <input type="hidden" name="ADDNEW" id="ADDNEW" value="<?php echo $ADDNEW;?>">
                <?php
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'addnewActivityChange', 'name' => 'addnewActivityChange','value'=>$addnewActivityChange));
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'page', 'name' => 'page','value'=>$page));
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'prevPage', 'name' => 'prevPage','value'=>$this->request->params[paging][GetJob][prevPage]));
                echo $this->Form->input('', array( 'type'=>'hidden','id' => 'nextPage', 'name' => 'nextPage','value'=>$this->request->params[paging][GetJob][nextPage]));
                ?>
	  <div id="example" class="container-fluid" style="margin-bottom:10px;">
         <div id="vertical">
            <div id="top-pane">
               <div id="horizontal" style="height: 100%; width: 100%;">
                  <div id="left-pane">
                     <div class="pane-content" >
                          
                         
                         
                         
						<div style="margin:10px 0px 5px 0px;">
							<div class="col-md-4">
                                                            <?php  echo $this->Form->input('',array('options' => $Html, 'id'=>'status', 'name' => 'status', 'class'=>'form-control','onchange' =>'LoadPDF(this.value);','style'=>'width:400px;')); ?>
								 
							  </div>
							<div class="pull-right" style="margin-bottom:10px">
                                                            <button class="btn btn-primary btn-xs " name='gopdf' id='gopdf' onclick="OpenPdf();" type="button">Go</button>
							<button class="btn btn-primary btn-xs " name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>
							</div>
						</div>
						  <!-- Load pdf file starts -->
                                                  <div style="margin-top:10px;"><iframe id="frame" src="<?php //echo $FirstLink;?>" style="width:100%; height:430px; overflow:hidden !important;"></iframe>
						 </div> 
						  <!-- Load pdf file ends-->
						</div>
                   </div>
                    
                  <div id="right-pane">
                      
                      <?php //if(!empty($DynamicFields)){?>
<!--                                <div id="top-pane" readonly="readonly">
                                    <div class="pane-content" style="width:99.7%;" >
                                        <div class="form-horizontal">
                                            <div class="form-group form-group-sm form-inline" id='appendNew' style="overflow-x: scroll;overflow-y:hidden !important; white-space: nowrap;">

                                                <table class="pane-cont-table" width='90%' style="margin-left:10px">
                                                    <tr>
                                                        <?php //pr($Dynamic);
                                                        foreach ($DynamicFields as $key => $value) { ?>
                                                        <th><?php echo $value['DisplayAttributeName'];?></th>
                                                        <input type="hidden" name="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" id="CommonAM[<?php echo $value['ProjectAttributeMasterId'];?>]" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($DynamicFields as $key => $value) { ?>
                                                            <td align="center" style="border:1px solid #f79646;">
                                                                <?php if($value['ControlName']=='TextBox' || $value['ControlName']=='Label') { ?>
                                                                <input type="text"  size="40" title="<?php echo $value['AttributeMasterId'];?>" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]',this.value,'<?php echo $value['AllowedCharacter'];?>','<?php echo $value['NotAllowedCharacter'];?>')" value="<?php echo $dynamicData[$value['AttributeMasterId']];?>">
                                                                <?php } elseif($value['ControlName']=='DropDownList') { ?>
                                                                <select class="form-control" name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]">
                                                                    <option value="yes" <?php if($value['AttributeValue']=='yes') { echo 'Selected';} ?>>Yes</option>
                                                                    <option value="no" <?php if($value['AttributeValue']=='no') { echo 'Selected';} ?>>No</option>
                                                                </select>
                                                                <?php } elseif($value['ControlName']=='MultiTextBox') { ?>
                                                                <textarea title="<?php echo $value['AttributeValue'];?>"  name="<?php echo $value['AttributeMasterId']; ?>" id="CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]" onblur="<?php echo $value['FunctionName'];?>('CommonPAM[<?php echo $value['ProjectAttributeMasterId'];?>]',this.value,'<?php echo $value['AllowedCharacter'];?>','<?php echo $value['NotAllowedCharacter'];?>')"><?php echo $dynamicData[$value['AttributeValue']];?></textarea>
                                                                <?php } elseif($value['ControlName']=='RadioButton') {?>
                                                                <?php echo $value['AttributeValue']; ?>
                                                                <?php
                                                               }?>
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                     </div>
                                </div>-->
                            <?php //} ?>
                      <?php
                         
                                    if($SequenceNumber>1 && $ADDNEW!='Addnew' ) { 
                                        echo '&nbsp;';
                                    echo '</br>';
                                                    $previous='true';
                                                    if($page>1)
                                                        $previous='false';
                                                    $next=true;
                                                    if($page<$SequenceNumber)
                                                        $next='false';
                                                    
                                                echo '&nbsp;';
                                                echo $this->Form->button('Prev', array('id' => 'clicktoviewPre', 'name' => 'clicktoviewPre', 'value' => 'clicktoviewPre', 'disabled'=>$previous , 'class'=>'btn btn-default btn-sm'));
                                                echo '&nbsp;&nbsp;';
                                                echo $this->Form->button('Next', array('id' => 'clicktoviewNxt', 'name' => 'clicktoviewNxt', 'value' => 'Next', 'disabled'=>$next,'class'=>'btn btn-default btn-sm' )); 
                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    echo '<b>      Total No Of Pages : '.$SequenceNumber.'</b>';
                                     echo $this->Form->button('Delete', array('id' => 'DeleteVessel', 'style'=>'float:right;margin-right:10px;','name' => 'DeleteVessel', 'value' => 'DeleteVessel', 'disabled'=>"false",'class'=>'btn btn-default btn-sm', 'type'=>'submit' )); 
                                    }
                          ?>
			<div class="col-md-12" style="margin-top:10px">
                            <?php echo $out;?>
			</div>
                  </div>
               </div>
            </div>
         </div>
              
              <div id="popup1" class="overlay" >
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
                                <?php echo $this->Form->button('Submit', array( 'id' => 'Query', 'name' => 'Query', 'value' => 'Query','class'=>'btn btn-warning','onclick'=>"return valicateQuery();",'type'=>'button')).' '; 
                           //echo $this->Form->button('Cancel', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-warning','onclick'=>"queryPopupClose();")); ?>  
                            </td>
                        </tr>
			</table>
		</div>
	</div>
</div>
              <div id="fade3" class="black_overlay"></div>
<?php
//pr($productionjobNew);
 echo $this->Form->end();   
}
?>
         <script>
            $(document).ready(function() {
                $("#vertical").kendoSplitter({
                    orientation: "vertical",
                    panes: [
                        { collapsible: false },
                        { collapsible: false, size: "100px" },
                        { collapsible: false, resizable: false, size: "100px" }
                    ]
                });
            
                $("#horizontal").kendoSplitter({
                    panes: [
                        { collapsible: true },
                        { collapsible: false },
                        { collapsible: true}
                    ]
                });
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
if(hms!=''){
    var a = hms.split(':'); // split it at the colons
    var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
}
else
{
    var seconds = 0;
}
function secondPassed() {
    var hour = Math.round((Math.round((seconds - 30)/60) - 30)/60);
    var temp=hour*60*60;
    var minutes = Math.round(((seconds -temp) - 30)/60);
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
    document.getElementById('countdown').innerHTML =  hour + ":" + minutes + ":" + remainingSeconds;
    document.getElementById('TimeTaken').value =  hour + ":" + minutes + ":" + remainingSeconds;
    seconds++;
}
var countdownTimer = setInterval('secondPassed()', 1000);

function formSubmit() {
    <?php
    $js_array = json_encode($Mandatory);
    echo "var mandatoryArr = ". $js_array . ";\n";
    ?>
    var mandatary = 0;
    $.each( mandatoryArr, function( key, elementArr ) {  
        element=elementArr['AttributeMasterId']
            if ($('#' + element).val() == '') {
                alert('Enter Value in '+elementArr['DisplayAttributeName']);
                $('#' + element).focus();
                mandatary = '1';
                return false;
            }
        });
        if (mandatary == 0)
            return true;
        else
            return false;
    }
function getJob()
{
   window.location.href = "GetJobTestModule1?job=newjob"; 
}
var windowObjectReference;
var strWindowFeatures = "menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";
function OpenPdf() {
    str=$("#status").text();
    if(str.search("http://")>-1)
        file=$("#status").text();
    else if(str.search("https://")>-1)
        file=$("#status").text();
    else
      file='http://'+$("#status").text()+'/'; 
    windowObjectReference = window.open(file, "CNN_WindowName", strWindowFeatures);
}
var myWindow=null;
function PdfPopup()
{
    var splitterElement=$("#horizontal").kendoSplitter({
                    panes: [
                        { collapsible: true },
                        { collapsible: true },
                        { collapsible: true}
                    ]
                });
    
    var splitter = splitterElement.data("kendoSplitter");
    var leftPane = $("#left-pane");
    splitter["collapse"](leftPane);
    var file = $("#status option:selected").text();
    
    myWindow=window.open("", "myWindow", "width=500, height=500");
    myWindow.document.write('<iframe id="pdfframe"  src="'+file+'" style="width:100%; height:100%; overflow:hidden !important;"></iframe>');
    
}
function valicateQuery()
{
    if($("#query").val()=='')   
    {
        alert('Enter Query');
        $("#query").focus();
        return false;
    }
    query=$("#query").val();
    InputEntyId=$("#ProductionEntity").val();
   
    var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'GetJobTestModule1','action'=>'ajaxqueryposing'));?>",
            data: ({query :query,InputEntyId:InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('successMessage').style.display='block';
                setTimeout(function() { document.getElementById('successMessage').style.display='none'; $("#query").val(result);}, 2000);  
            }
        });
}
function LoadValue(id,value,toid,pid,pname){
//alert(pname);
pidArr=pid.split("_");
pid_org=pidArr[0];
docId=pid_org+'_'+pname;
//alert(docId);
var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'GetJobTestModule1','action'=>'ajaxloadresult'));?>",
            data: ({id :id,value:value,toid:toid}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var obj = JSON.parse(result);
                  // alert(JSON.stringify(obj));
                var k=1;
                //toid=225;
               // alert(toid);
                var x = document.getElementById(docId);
                  document.getElementById(docId).options.length = 0;
                    var option = document.createElement("option");
                    option.text = '--Select--';
                    option.value = 0;
                     x.add(option, x[0]);  
                     
                obj.forEach(function(element) {
                    //alert(element['Value'])
                  var option = document.createElement("option");
                    option.text = element['Value'];
                    option.value = element['id'];
                     x.add(option, x[k]);  
                     k++;
                });
                
              
            }
        });
}
  $( function() {
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    
    <?php

$AutoSuggesstion_json = json_encode($AutoSuggesstion);
echo "var autoArr = ". $AutoSuggesstion_json . ";\n";
?>
        //alert(availableTags);
        $.each( autoArr, function( key, element ) {
//autoArr.forEach(function(element) {
    
    var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'GetJobTestModule1','action'=>'ajaxautofill'));?>",
            data: ({element :element}),
            dataType: 'text',
            async: false,
            success: function (result) {
                availableTags=JSON.parse(result);
            }
        });
    
    
    $( "#"+element ).autocomplete({
      source: availableTags
    });
});
    
    
    
  } );


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
              </style>