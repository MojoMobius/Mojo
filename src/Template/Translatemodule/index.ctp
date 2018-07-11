<!--<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/handsontable.css">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/pikaday/pikaday.css">
<script data-jsfiddle="common" src="webroot/dist/pikaday/pikaday.js"></script>
<script data-jsfiddle="common" src="webroot/dist/moment/moment.js"></script>
<script data-jsfiddle="common" src="webroot/dist/zeroclipboard/ZeroClipboard.js"></script>
<script data-jsfiddle="common" src="webroot/dist/numbro/numbro.js"></script>
<script data-jsfiddle="common" src="webroot/dist/numbro/languages.js"></script>-->
<!--<script data-jsfiddle="common" src="webroot/dist/handsontable.js"></script>-->
<!--<script data-jsfiddle="common" src="webroot/dist/fSelect.js"></script>-->
<!--<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/fSelect.css">-->
<!--<script src="webroot/js/samples.js"></script>
<script src="webroot/js/validation_new.js"></script>
<script src="webroot/js/highlight/highlight.pack.js"></script>
<link rel="stylesheet" media="screen" href="webroot/js/highlight/styles/github.css">
<link rel="stylesheet" href="webroot/css/font-awesome/css/font-awesome.min.css">-->

<script>
$(document).ready(function () {
setTimeout(function() {
   $('.success_msg').fadeOut('fast');
}, 2500);
})
</script>
<script src="webroot/ckeditor/ckeditor.js"></script>
<script src="webroot/ckeditor/samples/js/sample.js"></script>
<?php
use Cake\Routing\Router;
?>


<?php

if ($NoNewJob == 'NoNewJob') {
    ?>
<div align="center" style="color:green;">
    <b>
    <?php echo 'No New Job Available Now! <br> Check Later to have new job!'; ?>
    </b>
    <br><br>
</div>
    <?php
} else if ($this->request->query['job'] == 'completed' || $this->request->query['job'] == 'Query') {
    ?>
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
    <div style="margin:0px 0px 5px 0px;">
        <button class="btn btn-default btn-sm" type="button" onclick="getJob()">Get Job</button>
    </div>
</div>
<?php
} else if ($getNewJOb == 'getNewJOb') {
    echo $this->Form->create('', array('class' => 'form-horizontal', 'id' => 'projectforms'));
    ?>
<div align="center" style="color:green;">
    <b>
            <?php echo 'Click Get Job Button to get new Job'; ?>
    </b>
    <div style="margin:0px 0px 5px 0px;">
    <?php echo $this->Form->button('GetJob', array('id' => 'NewJob', 'name' => 'NewJob', 'value' => 'NewJob', 'class' => 'btn btn-default btn-sm')); ?>
    </div>
</div>
    <?php
    echo $this->Form->end();
} else {
    //echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms','name'=>'getjob'));
    ?>
<!--    <div id="example" class="container-fluid" style="margin-bottom:-10px;">-->
<!-- Project List Starts -->

<link rel="stylesheet" href="webroot/css/translatehead.css">

<body class="animsition site-navbar-small app-work">
    <!-- Project List Starts -->
    <!-- Breadcrumb Starts -->

    <form name="ProductionArea" id="ProductionArea" method="post">
        <div class="panel-heading p-b-0">
            <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="page-header p-l-0 p-r-0">
                    <div class="projet-details">
                        <h3 class="page-title"><div class="col-md-8 font-size-14">
                        <?php 
                        $n= 0;
                        ?>
                                <div><b><?php  $n= 0; $prefix = '';
                        foreach ($staticFields as $key) { 
                            if(!empty($staticFields[$n])){
                          echo $prefix.$staticFields[$n];
                            $prefix = ' | '; 
                            }
                             $n++; 
                        }  
                        ?></b></div>

                            </div>

                            <label class="pull-right font-size-14">Timer 
                                <span class="badge" id='countdown'>
                                    <div class="col-md-4">
                                            <?php
                                            if (empty($productionjob['TimeTaken']))
                                                $hrms[0] = '00:00:00';
                                            else
                                                $hrms = explode('.', $TimeTaken);
                                            ?><?php echo $hrms[0]; ?>
                                    </div>
                                </span>
                                <?php echo $this->Form->input('', array('type' => 'hidden', 'id' => 'TimeTaken', 'name' => 'TimeTaken', 'value' => $hrms[0])); ?>
                            </label>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
	<?php 
        //pr($processinputdata);exit;
        ?>	
        <!-- Breadcrumb Ends -->
        <div class="panel m-l-30 m-r-30">
            <div class="panel-body">
                <div id="splitter">

                    <div id="splitter-block">
                        <div id="splitter-left">
                            <!-- Example Tabs -->
                            <div class="example-wrap">
                                <div class="nav-tabs-horizontal">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" data-toggle="tab" href="#exampleTabsOne" aria-controls="exampleTabsOne" role="tab">Source</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#mainurl" aria-controls="mainurl" role="tab">Website</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#googletab" aria-controls="googletab" role="tab">Google Search</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="leftpane">
                                        <div class="tab-pane active" id="exampleTabsOne" role="tabpanel" style="display:none !important;">
                                            <object width="100%" onload="onMyFrameLoad(this)" height="100%" style="visibility:visible" id="frame1" name="frame1" data="" width="auto" height="auto"></object>

                                        </div>
                                        <div class="tab-pane" id="googletab" role="tabpanel">
                                            <div>
                                                <div class="goto"><a href="javascript: void(0);" onclick="$('#frame2').attr('data', 'https://www.google.com/ncr').hide().show();"> Go to Google </a></div>
                                                <div><object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame2" sandbox="" data="https://www.google.com/ncr"></object></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="mainurl" role="tabpanel">
                                            <iframe onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame3" target='_parent' sandbox=""  src="<?php echo $getDomainUrl;?>" ></iframe>
      <!--<object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame3" sandbox="" data="<?php //echo $getDomainUrl; ?>" ></object> -->
                                           <?php if(empty($getDomainUrl)){
                                                echo '<p><span style="font-weight:bold">No Website found...</span></p>';
                                            }
                                           ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Example Tabs -->			
                        </div>
                        <div id="splitter-right">
                            <div>
                                <input type="hidden" name='ProductionId' id="ProductionId" value="<?php echo $productionjob['Id']; ?>">
                                <input class="UpdateFields" type="hidden" name='ProductionEntity' id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity']; ?>">
                                <input class="UpdateFields" type="hidden" name='ProductionEntityID' id="ProductionEntityID" value="<?php echo $productionjob['ProductionEntity']; ?>">
                                <input type="hidden" name='StatusId' value="<?php echo $productionjob['StatusId']; ?>">
                                <input class="UpdateFields" type="hidden" name='RegionId' id='RegionId' value="<?php echo $productionjob['RegionId']; ?>">
                                <input class="UpdateFields" type="hidden" name="ProjectId" id="ProjectId" value="<?php echo $productionjob['ProjectId']; ?>">
                                <input class="UpdateFields" type="hidden" name="InputEntityId" id="InputEntityId" value="<?php echo $productionjob['InputEntityId']; ?>">

                                <input type="hidden" name="attrGroupId" id="attrGroupId">
                                <input type="hidden" name="attrSubGroupId" id="attrSubGroupId">
                                <input type="hidden" name="attrId" id="attrId">
                                <input type="hidden" name="ProjattrId" id="ProjattrId">
                                <input type="hidden" name="seq" id="seq">
                                <input type="hidden" name="refUrl" id="refUrl">
                                <input type="hidden" name="pdffilename" id="pdffilename">
                                  <?php
//                                    $path = JSONPATH . '\\filenews.htm';
                                   // $path = JSONPATH . '\\sample.html';
                                    //$content = file_get_contents($path);
                                 
                                  ?>

                                <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">

                                    <div class="adjoined-bottom">
                                        <div class="grid-container">
                                            <div class="grid-width-100">
                                                <div id="editor" style="height:800px;">
                                                    <?php //echo $content;?>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <textarea class="hide" name="translatehtml" id="textid" cols="100" width="300" >
                                        
                                    </textarea>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Splitter Ends -->
        </div>

        <script>


            function ckeditorcall() {
                CKEDITOR.replace('editor', {
                    width: '98%',
                    height: 312
                });
            }
            ckeditorcall();

            function translatemod() {
                var data = CKEDITOR.instances.editor.getData();

                console.log(data);
                $("#textid").val(CKEDITOR.instances.editor.getData());
            }

            function loadhtmlforeditor(filename) {
				alert(filename);
                $.ajax({
                    url: filename,
                    context: document.body,
                    success: function (response) {
                        CKEDITOR.instances.editor.setData(response);
                    }
                });

            }

        </script>
        <!-- Project List Ends -->	
        <div class="view-sourcelink p-l-0 p-r-0">
            <!-- <a href="#" class="current button offcanvas__trigger--open m-l-10" data-rel="page-tag">View Source Link</a> -->
            <div class="col-lg-6" align="left">
                <button type="button" class="btn btn-default offcanvas__trigger--close" onclick="loadReferenceUrl();" data-rel="page-tag" data-target="#exampleFillIn" data-toggle="modal">View Source</button>
                <!--                <button class="btn btn-default" name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>-->
            </div>
             <?php if(!empty($QueryDetails['Query'])){
                        $style_endisble = "display:block;";
                        //$style_endisble = "display:none;";
                        }else{
                            $style_endisble = "display:none;";
                        }
               ?>

            <div class="col-lg-6 pull-right m-t-5 m-b-5">		
                <button type="submit" name='Submit' value="saveandexit" class="btn btn-primary pull-right m-r-5 formsubmit_validation_endisable" style="<?php echo $style_endisble;?>" onclick="return formSubmit();"> Submit & Exit </button>
                <button type="submit" name='Submit' value="saveandcontinue" class="btn btn-primary pull-right formsubmit_validation_endisable" onclick="return formSubmit();" style="margin-right: 5px;<?php echo $style_endisble;?>"> Submit & Continue </button>
                <!--<button type="submit" name='Submit' value="saveandcontinue" class="btn btn-primary pull-right " onclick="return skipformSubmit();" style="margin-right: 5px;"> Skip & Continue </button> -->
<!--                <button type="button" name='Save' value="Save" id="save_btn" class="btn btn-primary pull-right m-r-5" onclick="AjaxSave('');">Save</button>-->
<!--                <button type="button" name='Validation' value="validation" class="btn btn-primary pull-right m-r-5" onclick="AjaxValidation();">Validation</button>-->
                <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodal" data-toggle="modal">Query</button>
                <button type="submit" name='translate' value="Translate" class="btn btn-primary pull-right m-r-5" onclick="translatemod();" >Save Translate</button>

   <button type="submit" name='viewpdf' value="viewpdf" class="btn btn-primary pull-right m-r-5" onclick="translatemod();" formtarget="_blank">View pdf</button>

            </div>
        </div>
    </form>
   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-right-0 padding-left-0">


        <div class="modal fade modal-fill-in" id="exampleFillIn" aria-hidden="false" aria-labelledby="exampleFillIn" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleFillInModalTitle">All Source Links</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-xl-12 p-l-10" id="multiplelinkbutton">
                            <span><h4 style="
                                      display: inline-block;
                                      ">Attribute source link</h4></span>
                            <span style="
                                  float: right;
                                  "><button type="button" class="btn btn-primary m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button></span>
                            <div class="panel">
                                <div class="panel-body panel-height multiple-height p-0  p-t-30">
                                    <!-- <a class="panel-action fa fa-cog pull-right" data-toggle="panel-fullscreen" aria-hidden="true" style="color:red;"></a> -->
                                    <div class="col-xs-12 col-xl-12" id="addnewurl" style="display: none;"> 
                                        <div class="col-xs-12 col-xl-4">
                                            <div class="srcblock box">
                <!--                           <i class="fa fa-times-circle save"></i>-->
                                                <i class="fa fa-save save"></i>
                                                <input autocomplete="off" type="text" class="form-control" id="addurl" placeholder="Enter Url..">

                                            </div> </div> </div>
                                    <div class="col-xs-12 col-xl-12">
                                        <div id="LoadAttrValue">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-xl-12 p-b-20 p-l-10 ">
                            <h4>Other links</h4>
                            <div class="col-xs-12 col-xl-12 panel p-t-30 p-b-20">
                                <div id="LoadGroupAttrValue"> 
                                </div>
                            </div>
                            <div class="col-xs-12 col-xl-12 m-t-30 hide">
                                <button type="button" class="btn btn-default pull-right m-r-5" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->



        <!-- Help Modal Starts-->
        <div class="modal fade" id="helpmodal" aria-hidden="true" aria-labelledby="helpmodal" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
    <?php //foreach (){   ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="HelpModelAttribute"></h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <span id='HelpModelContent'>

                            </span>
                        </div>
                    </div>
    <?php // }   ?>
                </div>
            </div>
        </div>
        <!-- Help Modal End-->

        <!-- Handson Modal -->

        <div class="modal fade modal-fill-in" id="exampleFillInHandson" aria-hidden="false" aria-labelledby="exampleFillInHandson" role="dialog" tabindex="-1">
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
                                            <div id="example1" class="hot handsontable htColumnHeaders"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Handson Modal -->

        <!-- Modal -->
        <div class="modal fade" id="querymodal" aria-hidden="true" aria-labelledby="querymodal" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
    <?php
    if ($QueryDetails['StatusID'] == 1) {
        ?>

                    <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTitle">Query</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" action="/action_page.php">
                            <div class="form-group">
                                <label for="Query" class="query">Query</label>
                                <textarea name="query" id="query" rows="4" cols="30" placeholder="Enter Your Query"><?php echo $QueryDetails['Query']; ?></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity']; ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php echo $this->Form->button('Submit', array('id' => 'Query', 'type' => 'button', 'name' => 'Query', 'value' => 'Query', 'class' => 'btn btn-primary', 'onclick' => "return valicateQuery();")) . ' '; ?>
                        <!--                            <button type="button" class="btn btn-primary">Submit</button>-->
                    </div>

        <?php
    } else if ($QueryDetails['StatusID'] == 3) {
        ?>

                    <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTitle">Query</h4>
                    </div>
                    <div class="modal-body">
                        <table style="width:100%">
                            <tr>
                                <td >User Query</td>
                                <td>TL Comments</td></tr>
                            <tr>
                            <tr>
                                <td><textarea name="query" id="query" rows="4" cols="30"><?php echo $QueryDetails['Query']; ?></textarea></td>
                                <td><textarea name="query" id="query" rows="4" cols="30"><?php echo $QueryDetails['TLComments']; ?></textarea></td></tr>
                        </table>
                    </div>

        <?php
    } else {
        ?>

                    <div id='successMessage' align='center' style='display:none;color:green'><b>Query Successfully Posted!</b></div>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTitle">Query</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-inline" action="/action_page.php">
                            <div class="form-group">
                                <label for="Query" class="query">Query</label>
                                <textarea name="query" id="query" rows="4" cols="30" placeholder="Enter Your Query"><?php echo $QueryDetails['Query']; ?></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity']; ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php echo $this->Form->button('Submit', array('id' => 'Query', 'type' => 'button', 'name' => 'Query', 'value' => 'Query', 'class' => 'btn btn-primary', 'onclick' => "return valicateQuery();")) . ' '; ?>
                        <!--                            <button type="button" class="btn btn-primary">Submit</button>-->
                    </div>

        <?php
      
    }
     
    ?>
                </div>
            </div>
        </div>
        <!-- End Modal -->		
    </div>	

<?php //exit; ?>




    <script type="text/javascript">

        function checkAll(grp, subgrp) {
            var select_all_Disp = document.getElementById("subgrp_" + grp + "_" + subgrp).value;
            //   var Disp_Url = document.getElementsByClassName("subGrpDisp_"+grp+"_"+subgrp); 

            $(".subGrpDisp_" + grp + "_" + subgrp).val(select_all_Disp);

            if (select_all_Disp === 'D') {
                $(".inputsubGrp_" + grp + "_" + subgrp).val('');
            }

            if (select_all_Disp === 'V') {
                var subGrpArr = '<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
                var subGrpAtt = JSON.parse(subGrpArr);

                var subGrpAttArr = subGrpAtt[grp][subgrp];
                var maxSeqCntsub = $('.GroupSeq_' + subgrp).attr("data");
                var inpId = <?php echo $DependentMasterIds['ProductionField']; ?>;
                for (i = 1; i <= maxSeqCntsub; i++) {
                    $.each(subGrpAttArr, function (key, val) {
                        var data = $("#beforeText_" + grp + "_" + subgrp + "_" + val['AttributeMasterId'] + "_" + i).text();
                        $("#ProductionFields_" + val['AttributeMasterId'] + "_" + inpId + "_" + i).val(data);

                        var maxSeqCnt = $('.ShowingSeqDiv_' + val['AttributeMasterId']).attr("data");
                        if (maxSeqCnt > 1) {
                            for (j = 1; j <= maxSeqCnt; j++) {
                                var data = $("#beforeText_" + grp + "_" + subgrp + "_" + val['AttributeMasterId'] + "_" + j).text();
                                $("#ProductionFields_" + val['AttributeMasterId'] + "_" + inpId + "_" + j).val(data);
                            }
                        }
                    });
                }
            }
        }

        function checkLength(el, id, depd, seq, minval) {
            if (el.value.length > 0) {
                if (el.value.length < minval) {
                    alert("make sure the input is " + minval + " characters long");
                    setTimeout(function () {
                        document.getElementById('ProductionFields_' + id + '_' + depd + '_' + seq).focus();
                    }, 10);
                    return false;
                }
            }
        }

        $(document).keydown(function (e) {
            if (e.which == 65) {


            }
        });
        $(document).ready(function () {
            baseinfodivcount = 1;
            $("#MySplitter").splitter();
            $("#MySplitter").trigger("resize", [320]);
            $('#myCarousel').carousel({
                interval: 40000
            });



        });

        // Script for bottom side flip canvas starts
        $(document).ready(function () {
            $('#document-tag, #page-tag').iptOffCanvas({
                baseClass: 'offcanvas',
                type: 'bottom' // top, right, bottom, left.
            });
        });
        // Script for bottom side flip canvas ends

        //-------------------------ondblclick html start-----------------//

        function getThisId(thiss) {
            //alert(name);
            AttrcopyId = $(thiss).focus();
        }

        jQuery(function ($) {
            $('object').bind('load', function () {
                var childFrame = $(this).contents().find('body');
                childFrame.on('dblclick', function () {
                    var iframe = document.getElementById('frame1');
                    var idoc = iframe.contentDocument || iframe.contentWindow.document;
                    var seltext = idoc.getSelection();
                    $(AttrcopyId).val(seltext);
                });

                childFrame.bind('mouseup', function () {
                    var iframe = document.getElementById('frame1');
                    var idoc = iframe.contentDocument || iframe.contentWindow.document;
                    var seltext = idoc.getSelection();
                    if (seltext.rangeCount && seltext.getRangeAt) {
                        range = seltext.getRangeAt(0);
                    }
                    idoc.designMode = "on";     // Set design mode to on
                    if (range) {
                        seltext.removeAllRanges();
                        seltext.addRange(range);
                    }
                    //alert(AttrcopyId);
                    if (seltext != "" && typeof AttrcopyId != 'undefined')
                        $(AttrcopyId).val(seltext);
                    idoc.execCommand("hiliteColor", false, "yellow" || 'transparent');
                    idoc.designMode = "off";
                    //  idoc.designMode = "on";  

                    // Set design mode to off
                    //  $('#frame1 span:contains(' + seltext + ')').addClass('highlight');


                });



            });
        });

    //            (function($) {
    //                $(function() {
    //                    $('.testmulti').fSelect();
    //                });
    //            })(jQuery);

        //---------------Local Storage------------------
        $(document).ready(function (e) {


            // Load_totalAttInThisGrpCnt();
            //localStorage.clear();
            $(".UpdateFields").blur(function (e) {
                AttValue = $(this).val();
                Attname = $(this).attr("name");

                localStorage.setItem(Attname, AttValue);



            });

            $(".InsertFields").blur(function (e) {
                AttValue = $(this).val();
                Attname = $(this).attr("name");

                localStorage.setItem(Attname, AttValue);



            });


        });
        function addslashes(str) {
            str = str.replace(/'/g, "\\'");
            str = str.replace(/"/g, '\\"');
            return str;
        }



        //-------------------------ondblclick html end-----------------//


        $(document).ready(function () {
			

            $('#multiplelinkbutton').hide();
            //$('.chk-wid-Url').hide();

            var FirstAttrId = '<?php echo $FirstAttrId; ?>';
            var FirstProjAttrId = '<?php echo $FirstProjAttrId; ?>';
            var FirstGroupId = '<?php echo $FirstGroupId; ?>';
            var FirstSubGroupId = '<?php echo $FirstSubGroupId; ?>';

            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();

            i = 0;
            var spanArr = [];
            var sequence = 1;

            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxLoadfirstattribute')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, groupId: FirstGroupId, seq: sequence}),
                dataType: 'text',
                async: true,
                success: function (result) {
                    if (result != '' && result != null) {
                        $('.CntBadge').hide();
                        var obj = JSON.parse(result);

                        if (obj['attrinitialhtml'] != '' && obj['attrinitialhtml'] != null) {
                            $('#exampleTabsOne').show();
                            var htmlfileinitial = "<?php echo HTMLfilesPath; ?>" + obj['attrinitialhtml'];
                            
                            $("#pdffilename").val(obj['attrinitialhtml']);
                            loadhtmlforeditor(htmlfileinitial);
    
                            document.getElementById('frame1').data = htmlfileinitial;

                            var object = document.getElementById("frame1");
                            object.onload = function () {
                                //spanArr = $("object").contents().find('span');
                                $("object").contents().find('.annotated').each(function () {
                                    var $span = $(this);
                                    var spanId = $span.attr('data');
                                    if (typeof (spanId) != "undefined" && spanId !== null && $(this).text() != '') {
                                        $span.attr('onClick', "parent.focusProjeId('" + spanId + "');");
                                        $span.attr('id', spanId);
                                    }
                                });
                            };

                        } else if (obj['attrinitiallink'] != '' && obj['attrinitiallink'] != null) {
                            $('#exampleTabsOne').show();
                            document.getElementById('frame1').data = obj['attrinitiallink'];
                        }

                        if (typeof obj['attrcnt'] !== 'undefined' && obj['attrcnt'] != null) {
                            obj['attrcnt'].forEach(function (element) {

                                if (element['cnt'] > 0) {
                                    $('#CntBadge_' + element['AttributeMainGroupId']).show();
                                    $('#CntBadge_' + element['AttributeMainGroupId']).text(element['cnt']);
                                    //document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = ;
                                }
                            });
                        }
                    }
                }
            });

        });


        function focusProjeId(projId) {

            var projArr = projId.split('(');
            var ProjAttribute = projArr[0];
            var jsonArr = '<?php echo str_replace("'", "\\'",json_encode($ModuleAttributes)); ?>';
            jsonArr = JSON.parse(jsonArr);
            var proKey;
            var mainGrp;
            var subgroup;
            var sequence;
            var projattr;
            jQuery.each(jsonArr, function (i, val) {
                if (val['AttributeName'] == ProjAttribute) {
                    proKey = val['AttributeMasterId'];
                    projattr = val['ProjectAttributeMasterId'];
                    mainGrp = val['MainGroupId'];
                    subgroup = val['SubGroupId'];
                    sequence = 1;
                }
            });



            // $('#exampleAccordionContinuous').collapse('');
            $("#exampleAccordionContinuous>div>div>a.panel-title").addClass("collapsed");
            $("#exampleAccordionContinuous>div>div>a.panel-title").attr("aria-expanded", "false");

            $("#exampleAccordionContinuous>div>div.in").attr("aria-expanded", "false");
            ;
            $("#exampleAccordionContinuous>div>div.in").removeClass("in");



            $("#" + mainGrp).attr("aria-expanded", "true");
            $('#' + mainGrp).removeClass("collapsed");
            var href = $("#" + mainGrp).attr("href");
            $(href).attr("aria-expanded", "true");
            $(href).addClass("in");
            //$(href).attr( "style:4500!important" );
            depen = '<?php echo $dependency; ?>';
            //alert(depen);
            document.getElementById('ProductionFields_' + proKey + '_' + depen + '_1').focus();
            $(href).height("auto");
            //loadWebpage(proKey, projattr, mainGrp, subgroup, sequence, 0);

        }
        // Script for bottom side flip canvas starts
        $(document).ready(function () {
            $('#document-tag, #page-tag').iptOffCanvas({
                baseClass: 'offcanvas',
                type: 'bottom' // top, right, bottom, left.
            });
        });
        // Script for bottom side flip canvas ends

        // Script for bottom side flip canvas starts
        $(document).ready(function () {
            $('#document-tag, #page-tag').iptOffCanvas({
                baseClass: 'offcanvas',
                type: 'bottom' // top, right, bottom, left.
            });
        });
        // Script for bottom side flip canvas ends

        function loadHelpContent(AttributeMasterId, DisplayAttributeName) {
            var attributeId = AttributeMasterId;
            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();

            //            alert(projectid+"_"+regionid+"_"+attributeId);

            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxhelptooltip')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, attributeId: attributeId}),
                dataType: 'text',
                async: true,
                success: function (result) {
                    $("#HelpModelContent").html(result);
                    $("#HelpModelAttribute").html(DisplayAttributeName);
                }
            });
        }

        $('.save').click(function () {

            var text = $('#addurl').val();
            if (text == '') {
                alert("Enter Url..");
                $('#addurl').focus();
                return false;
            } else {
                var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
                if (!re.test(text)) {
                    alert("Enter Valid Url");
                    $('#addurl').focus();
                    return false;
                }
                var projectid = $('#ProjectId').val();
                var regionid = $('#RegionId').val();
                var inputentityid = $('#InputEntityId').val();
                var prodentityid = $('#ProductionEntity').val();
                var attrGrpid = $('#attrGroupId').val();
                var attrSubGrpid = $('#attrSubGroupId').val();
                var attrid = $('#attrId').val();
                var Projattrid = $('#ProjattrId').val();
                var sequence = $('#seq').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxinsertreferenceurl')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, Seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result === 'Inserted') {
                            //alert("Inserted Successfully");
                            // loadWebpage(attrid, Projattrid, attrGrpid, attrSubGrpid, sequence, 1);
                            loadReferenceUrl();

                        }
                    }
                });
                $('#addnewurl').hide();
            }
        });




        // Script for enhsplitter Starts
        jQuery(function ($) {
            //$('#splitter-block').enhsplitter();
            $('#splitter-block').enhsplitter({handle: 'bar', position: 350, leftMinSize: 0, fixed: false});
        });
        // Script for enhsplitter Ends

        // onclick website
        function loadWebpage(attr, projattr, maingroup, subgroup, seq, val) {

            var attrGrpid = $('#attrGroupId').val();
            var attrSubGrpid = $('#attrSubGroupId').val();
            var attrid = $('#attrId').val();
            var Projattrid = $('#ProjattrId').val();

            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();
            var sequence = $('#seq').val();

            //AttrcopyId = $( "#prodInput_"+attr ).focus();


            $('#multiplelinkbutton').show();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetafterreferenceurl')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, Attr: attr, ProjAttr: projattr, MainGrp: maingroup, SubGrp: subgroup, seq: seq}),
                dataType: 'text',
                async: true,
                success: function (result) {

                    $("#LoadAttrValue").empty();

                    if (result != '' && result != null) {
                        $("#LoadAttrValue").empty();
                        var obj = JSON.parse(result);
                        if (obj['attrval'] != '' && obj['attrval'] != null) {
                            obj['attrval'].forEach(function (element) {
                                if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                    var cols = "";
                                    cols += '<div class="col-xs-12 col-xl-4">';
                                    cols += '<div class="srcblock box1 update-cart offcanvas__trigger--close" id="demo">';
                                    cols += '<i class="fa fa-times-circle edit1 lite-blue" onclick="DeleteUrl(' + attr + ',' + projattr + ',' + maingroup + ',' + subgroup + ',' + element['Id'] + ');"></i>';
    //                                        if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
    //                                           
    //                                        } else {
                                    cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title="' + element['AttributeValue'] + '" value="' + element['AttributeValue'] + '" id="' + element['AttributeValue'] + '" onclick="loadPDF(this.id);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    // }
                                    cols += '</div>';
                                    cols += '</div>';
                                    $("#LoadAttrValue").append(cols);
                                } else {
                                    var colsEmpty = "";
                                    colsEmpty += "No URL found";
                                    $("#LoadAttrValue").append(colsEmpty);
                                }
                            });
                        } else {
                            var colsEmpty = "";
                            colsEmpty += "No URL found";
                            $("#LoadAttrValue").append(colsEmpty);
                        }

                    } else {
                        var colsEmpty = "";
                        colsEmpty += "No URL found";
                        $("#LoadAttrValue").append(colsEmpty);
                    }
                }
            });


            $('#attrGroupId').val(maingroup);
            $('#attrSubGroupId').val(subgroup);
            $('#attrId').val(attr);
            $('#ProjattrId').val(projattr);
            $('#seq').val(seq);

        }


        function loadPDF(file)
        {
            $('#exampleTabsOne').show();
            $('#refUrl').val(file);

            var text = file;
            if (text == '') {
                return false;
            } else {
                var projectid = $('#ProjectId').val();
                var regionid = $('#RegionId').val();
                var inputentityid = $('#InputEntityId').val();
                var prodentityid = $('#ProductionEntity').val();
                var attrGrpid = $('#attrGroupId').val();
                var attrSubGrpid = $('#attrSubGroupId').val();
                var attrid = $('#attrId').val();
                var Projattrid = $('#ProjattrId').val();
                var sequence = $('#seq').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultipleurl')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
                            if (obj['htmlfile'] != '' && obj['htmlfile'] != null) {
                                $('#exampleTabsOne').show();
                                var htmlfile = "<?php echo HTMLfilesPath; ?>" + obj['htmlfile'];
                                document.getElementById('frame1').data = htmlfile;

                                var object = document.getElementById("frame1");
                                object.onload = function () {
                                    //spanArr = $("object").contents().find('span');
                                    $("object").contents().find('.annotated').each(function () {
                                        var $span = $(this);
                                        var spanId = $span.attr('data');
                                        if (typeof (spanId) != "undefined" && spanId !== null && $(this).text() != '') {
                                            $span.attr('onClick', "parent.focusProjeId('" + spanId + "');");
                                        }
                                    });
                                };

                            } else {
                                $('#exampleTabsOne').show();
                                document.getElementById('frame1').data = text;
                            }

                            obj['attrCount'].forEach(function (element) {
                                if (element['cnt'] > 0) {
                                    $('#CntBadge_' + element['AttributeMainGroupId']).show();
                                    document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = element['cnt'];
                                }
                            });


                            gotattributeids = obj['attrid'];
                            gotattributemaingrpid = attrGrpid;
                            checkAllUrlAtt();
                        }
                    }
                });
            }
        }


        function loadPDFUrl(file) {

            $('#exampleTabsOne').show();
            $('#refUrl').val(file);
            $('.update-cart').click(function (e) {
                e.preventDefault();
                return false;
            });
            //$("#frame1").attr('data', file).hide().show();
            var text = file;
            if (text == '') {
                return false;
            } else {
                var projectid = $('#ProjectId').val();
                var regionid = $('#RegionId').val();
                var inputentityid = $('#InputEntityId').val();
                var prodentityid = $('#ProductionEntity').val();
                var attrGrpid = $('#attrGroupId').val();
                var attrSubGrpid = $('#attrSubGroupId').val();
                var attrid = $('#attrId').val();
                var Projattrid = $('#ProjattrId').val();
                var sequence = $('#seq').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadgroupurl')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
						alert(result);
                        if (result != '' && result != null) {
                            $('.CntBadge').hide();
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");

                            var obj = JSON.parse(result);
    //                        console.log(htmlfile);debugger;
                            if (obj['htmlfile'] != '' && obj['htmlfile'] != null) {
                                $('#exampleTabsOne').show();
                                var htmlfile = "<?php echo HTMLfilesPath; ?>" + obj['htmlfile'];
                                // call for html loader
                                $("#pdffilename").val(obj['htmlfile']);
                                loadhtmlforeditor(htmlfile);
                                
                                document.getElementById('frame1').data = htmlfile;
                                var object = document.getElementById("frame1");
    //                            object.onload = function () {
    //                                //spanArr = $("object").contents().find('span');
    //                                $("object").contents().find('.annotated').each(function () {
    //                                    var $span = $(this);
    //                                    var spanId = $span.attr('data');
    //                                    if (typeof (spanId) != "undefined" && spanId !== null && $(this).text() != '') {
    //                                        $span.attr('onClick', "parent.focusProjeId('" + spanId + "');");
    //                                    }
    //                                });
    //                            };

                            } else {
                                $('#exampleTabsOne').show();
                                document.getElementById('frame1').data = text;
                            }

    //                        obj['attrCount'].forEach(function (element) {
    //                            if (element['cnt'] > 0) {
    ////                                $('#CntBadge_' + element['AttributeMainGroupId']).show();
    ////                                document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = element['cnt'];
    //                            }
    //                        });

                            gotattributeids = obj['attrid'];
                            gotattributemaingrpid = attrGrpid;
                            checkAllUrlAtt();
                        }
                    }
                });
            }
        }

        function checkAllUrlAtt(Seq = 1){

            //alert(gotattributeids);
            $('.subgroupparentdivs').show();
            $('.commonClass').show();
            $('.commonClass').removeClass("myyourclass");
            var sat = $("#chk-wid-Url").prop("checked");
            if (sat) {
                //alert('dfdf');
                //$('.commonclass_'+gotattributemaingrpid).hide(); 
                if (gotattributeids.length > 0) {
                    $('.commonClass').hide();
                    gotattributeids.forEach(function (element) {
                        //alert(element['AttributeMasterId']);
                        if (element['AttributeMasterId'] > 0) {

                            $('#groupAttr_' + element['AttributeMasterId'] + '_' + Seq).css("display", "block");
                            $('#groupAttr_' + element['AttributeMasterId'] + '_' + Seq).addClass("myyourclass");
                        }
                    });

                    //$(".subgroupparentdivs_"+gotattributemaingrpid).each(function() {
                    $(".subgroupparentdivs").each(function () {
                        var count = $(this).find(".myyourclass").length;
                        if (count <= 0) {
                            $(this).hide();
                        }
                    });
                }

            }
            else {
                $('.subgroupparentdivs').show();
                $('.commonClass').show();
            }
            ShowUnVerifiedAtt();
        }

        function ShowUnVerifiedAtt() {
            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();
            var sequence = $('#seq').val();
            var unverified = $("#chk-wid-Url2").prop("checked");
            var subgroup = '<?php echo json_encode($AttributeSubGroupMasterJSON); ?>';
            var subgrpArr = JSON.parse(subgroup);
            var distinct = '<?php echo json_encode($distinct)?>';
            var distinctArr = JSON.parse(distinct);
            //alert(distinct);
            obj = [];
            i = 0;
            objAttr = [];
            j = 0;
            objshowAttr = [];
            k = 0;
            var sat = $("#chk-wid-Url").prop("checked");

            if (sat) {
                $('.myyourclass').find('.dispositionSelect').each(function () {

                    var selectedId = $(this).attr('id')

                    var selected = $('#' + selectedId).find(":selected").text();
                    var selectedIdArr = selectedId.split('_');
                    var distMatch = jQuery.inArray(selectedIdArr[1], distinctArr)
                    if (distMatch == -1)
                    {
                        if (selected != "--") {
                            objAttr[j] = selectedIdArr[2];
                            j++;
                        }
                        else {
                            objshowAttr[k] = selectedIdArr[2];
                            k++;
                        }
                    }
                    else {
                        if (selected == "--") {
                            obj[i] = selectedIdArr[1];
                            i++;
                        }
                    }
                });

            }
            else {
                $('.dispositionSelect').each(function () {
                    var selectedId = $(this).attr('id')
                    // alert(selectedId);
                    var selected = $('#' + selectedId).find(":selected").text();
                    var selectedIdArr = selectedId.split('_');
                    var distMatch = jQuery.inArray(selectedIdArr[1], distinctArr)
                    if (distMatch == -1)
                    {
                        if (selected != "--") {
                            objAttr[j] = selectedIdArr[2];
                            j++;
                        }
                        else {
                            objshowAttr[k] = selectedIdArr[2];
                            k++;
                        }
                    }
                    else {
                        if (selected == "--") {
                            obj[i] = selectedIdArr[1];
                            i++;
                        }
                    }
                });
            }

            $.unique(obj);
            $.unique(objAttr);
            //alert(JSON.stringify(obj));
            if (unverified) {
                $.each(subgrpArr, function (key, value) {
                    $.each(value, function (key2, value2) {
                        var keyMatch = jQuery.inArray(key2, obj)
                        var distMatch3 = jQuery.inArray(key2, distinctArr)
                        if (distMatch3 != -1) {

                            if (keyMatch == -1)
                            {
                                $("#MultiSubGroup_" + key2 + "_" + 1).css("display", "none");
                                $("#MultiSubGroup_" + key2 + "_" + 1).removeClass("showFilled");
                            }
                            else {
                                $("#MultiSubGroup_" + key2 + "_" + 1).css("display", "block");
                                $("#MultiSubGroup_" + key2 + "_" + 1).addClass("showFilled");
                            }

                        }
                    });
                });


                $.each(objAttr, function (key, value) {
                    $("#MultiField_" + value + "_" + 1).css("display", "none");
                    $("#MultiField_" + value + "_" + 1).removeClass("showFilled");
                }
                );
                $.each(objshowAttr, function (key, value) {
                    $("#MultiField_" + value + "_" + 1).css("display", "block");
                    $("#MultiField_" + value + "_" + 1).addClass("showFilled");
                }
                );

                $(".subgroupparentdivs").each(function () {
                    var count = $(this).find(".showFilled").length;
                    if (count <= 0) {
                        $(this).hide();
                    }
                    else {
                        $(this).show();
                    }
                });
            }
            else {
                $.each(subgrpArr, function (key, value) {
                    $.each(value, function (key2, value2) {
                        $("#MultiSubGroup_" + key2 + "_" + 1).css("display", "block");
                        $("#MultiSubGroup_" + key2 + "_" + 1).addClass("showFilled");
                    });
                });
                $(".subgroupparentdivs").each(function () {
                    $(this).css("display", "block");
                });

                if (sat) {
                    $(".subgroupparentdivs").each(function () {
                        var count = $(this).find(".myyourclass").length;
                        if (count <= 0) {
                            $(this).hide();
                        }
                    });
                }

                $.each(objAttr, function (key, value) {
                    $("#MultiField_" + value + "_" + 1).css("display", "block");
                    $("#MultiField_" + value + "_" + 1).addClass("showFilled");
                }
                );
            }
        }
        function addReferenceUrl() {
            $('#addnewurl').show();
            $('#addurl').val('');

        }

        function loadReferenceUrl() {


            $('#addnewurl').hide();
            $('.chk-wid-Url').parent().show();
            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();

            var attrGrpid = $('#attrGroupId').val();
            var attrSubGrpid = $('#attrSubGroupId').val();
            var attrid = $('#attrId').val();
            var Projattrid = $('#ProjattrId').val();
            var sequence = $('#seq').val();

            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                dataType: 'text',
                async: true,
                success: function (result) {
                    $("#LoadGroupAttrValue").empty();
                    if (result != '' && result != null) {
                        $("#LoadGroupAttrValue").empty();
                        var obj = JSON.parse(result);
                        if (obj['attrval'] != '' && obj['attrval'] != null) {
                            obj['attrval'].forEach(function (element) {
                                if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                    var cols = "";
                                    cols += '<div class="col-xs-12 col-xl-4">';
                                    cols += '<div class="srcblock box1 update-cart" id="demo" data-dismiss="modal">';

                                    cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title="' + element['AttributeValue'] + '" value="' + element['AttributeValue'] + '" id="' + element['AttributeValue'] + '" onclick="loadPDFUrl(this.id);" class="current text-center text">' + element['AttributeValue'].substring(0, 45) + '</a>';

                                    cols += '</div>';
                                    cols += '</div>';
                                    $("#LoadGroupAttrValue").append(cols);
                                } else {
                                    var colsEmpty = "";
                                    colsEmpty += "No URL found";
                                    $("#LoadGroupAttrValue").append(colsEmpty);
                                }
                            });
                        } else {
                            var colsEmpty = "";
                            colsEmpty += "No URL found";
                            $("#LoadGroupAttrValue").append(colsEmpty);
                        }
                    } else {
                        var colsEmpty = "";
                        colsEmpty += "No URL found";
                        $("#LoadGroupAttrValue").append(colsEmpty);
                    }
                }
            });
        }

    //        function multipleUrl() {
    //            $('#addnewurl').hide();
    //        }
        //  Query posting
        function valicateQuery() {
            if ($("#query").val() == '')
            {
                alert('Enter Query');
                $("#query").focus();
                return false;
            }
            var regionid = $('#RegionId').val();
            query = $("#query").val();
            InputEntyId = $("#ProductionEntity").val();

            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxqueryposing')); ?>",
                data: ({query: query, InputEntyId: InputEntyId, RegionId: regionid}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    document.getElementById('successMessage').style.display = 'block';
                    setTimeout(function () {
                        $(".formsubmit_validation_endisable").show(); // code added 
                        document.getElementById('successMessage').style.display = 'none';
                        $("#query").val(result);
                    }, 2000);
                }
            });
        }


        function formSubmit() {

            var ret = true;
    //        ret = AjaxSave('');
    //        $(".removeinputclass").remove();
            var data = CKEDITOR.instances.editor.getData();
    //            console.log(data);
            $("#textid").val(data);

            return ret;
        }

        function skipformSubmit() {
            var ret = true;
            $(".removeinputclass").remove();
            return ret;
        }

        function AjaxSave(addnewpagesave) {
            Updatedata = $(".UpdateFields").serialize();
            Inputdata = $(".InsertFields").serialize();
            ProjectId = $("#ProjectId").val();
            RegionId = $("#RegionId").val();
            ProductionEntityID = $("#ProductionEntityID").val();
            InputEntityId = $("#InputEntityId").val();
            $("#save_btn").html("Please wait! Saving...");
            //$("#save_btn").attr("disabled", "disabled");

            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxsave')); ?>",
                data: ({Updatedata: Updatedata, Inputdata: Inputdata, ProjectId: ProjectId, RegionId: RegionId, ProductionEntityID: ProductionEntityID, InputEntityId: InputEntityId}),
                dataType: 'json',
                async: false,
                success: function (result) {
                    //alert(result);
                    if (result == 'saved') {
                        //alert('Save successfully!');
                    } else {
                        alert('Error while saving data, please try again later.');
                    }
                    $("#save_btn").removeAttr("disabled");
                    $("#save_btn").html("Save");
                    $(".InsertFields").addClass("UpdateFields").removeClass("InsertFields");
                    return true;
                }
            });
            localStorage.clear();
            return true;
        }



    </script>
</body>
<?php //exit; ?>
<div id="fade" class="black_overlay"></div>
    <?php
    echo $this->Form->end();
}
?>
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

</script>


<script>



    function getJob()
    {
        window.location.href = "Getjobcore?job=newjob";
    }


    $(document).ready(function () {

        $('input[type="text"].form-control').keypress(function () {
            $(this).removeClass('text-danger');
        });

        $('input[type="text"].form-control').change(function () {
            $(this).removeClass('text-danger');
        });



    });

    function onMyFrameLoad() {
        $('#loaded').val('loaded');
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
//    function getCustomRenderer() {
//        return function (instance, td, row, col, prop, value, cellProperties) {
//            Handsontable.renderers.TextRenderer.apply(this, arguments);
//            td.hidden = true;
//        }
//    }
//    function calculateSize() {
//        var offset;
//
//
//        offset = Handsontable.Dom.offset(example1);
//        availableWidth = Handsontable.Dom.innerWidth(document.body) - offset.left + window.scrollX;
//        availableHeight = Handsontable.Dom.innerHeight(document.body) - offset.top + window.scrollY;
//
//        example1.style.width = availableWidth + 'px';
//        example1.style.height = availableHeight + 'px';
//
//    }



    $(document).ready(function () {
        $("#ProductionArea").bind("keypress", function (e) {
            if (e.keyCode == 13) {
                AjaxSave('');
                return false;
            }
        });
    });

//    (function ($) {
//        $(function () {
//            $('.testmulti').fSelect();
//        });
//    })(jQuery);



// Load_verifiedAttrCnt_forselect($('#' + selectId));
//        Load_totalAttInThisGrpCnt();
</script>
<style>
    .text-danger {
        border-color: #f55753 !important;
        border-width: 0.5px !important;
    }

    .lite-blue{
        color: #a0b6bd !important;
    }
    .wid-100per{
        width: 100% !important;
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

    #vertical {
        height: 750px;
        margin: 0 auto;
    }
    #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
    .pane-content {
        padding: 0 10px;
    }
    .link-style{
        cursor: pointer;
    }

</style>
<?php
if ($this->request->query['continue'] == 'yes') {
    echo "<script>getJob();</script>";
}
?>

<script>
    function GetFrameData(val) {
        goToMsg(val);
    }
    function goToMsg(id) {
        var iframe = document.getElementById("frame1");
        var elem = iframe.contentWindow.document.getElementById(id);
        iframe.contentWindow.location.hash = id;

        $("html, body")
                .animate({scrollTop: $(elem).offset().top}, 250, function () {
                    elements = iframe.contentWindow.document.getElementsByClassName('annotated');
                    for (var i = 0; i < elements.length; i++) {
                        elements[i].style.backgroundColor = "blue";
                    }

                    $(elem).css('background-color', 'red');

                })


    }

</script>