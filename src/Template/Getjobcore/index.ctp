<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/handsontable.css">
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/pikaday/pikaday.css">
<script data-jsfiddle="common" src="webroot/dist/pikaday/pikaday.js"></script>
<script data-jsfiddle="common" src="webroot/dist/moment/moment.js"></script>
<script data-jsfiddle="common" src="webroot/dist/zeroclipboard/ZeroClipboard.js"></script>
<script data-jsfiddle="common" src="webroot/dist/numbro/numbro.js"></script>
<script data-jsfiddle="common" src="webroot/dist/numbro/languages.js"></script>
<script data-jsfiddle="common" src="webroot/dist/handsontable.js"></script>
<script data-jsfiddle="common" src="webroot/dist/fSelect.js"></script>
<link data-jsfiddle="common" rel="stylesheet" media="screen" href="webroot/dist/fSelect.css">
<script src="webroot/js/samples.js"></script>
<script src="webroot/js/validation_new.js"></script>
<script src="webroot/js/highlight/highlight.pack.js"></script>
<link rel="stylesheet" media="screen" href="webroot/js/highlight/styles/github.css">
<link rel="stylesheet" href="webroot/css/font-awesome/css/font-awesome.min.css">

<?php 

    use Cake\Routing\Router;
    echo $this->Html->css('zebra_datepicker.css');
    echo $this->Html->script('zebra_datepicker');
    ?>
	<style>
	.Apped-Rent{
		padding:0px 10px;
	}
	.suc-msg{
		padding-left:30%;
		color:green;
		font-weight:600;
		font-size:15px;
	}
        .emptyerror{
            color: red;
            padding-left: 40%;
            font-size: 15px;
            font-weight: 500;
        }
		.rent-icon{
			padding:0px 5px;
		}
	</style>
 <script>	
  $('.IsDatepicker').Zebra_DatePicker({
                    direction: true,
                    format: 'd-m-Y'
                });


   </script>


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

<script>
    Breakpoints();
</script>
<style type="text/css">
    .modal-footer{border-top: 1px solid #e4eaec;}
    .modal-header{border-bottom: 1px solid #e4eaec;}
    .query{vertical-align:top;margin-right:30px;}
    body{padding-top:60px !important;}
    
    .site-menu-sub .site-menu-item > a{padding:0 !important;}
    .nav.navbar-toolbar.navbar-right.navbar-toolbar-right .dropdown-menu{left:auto !important;}
    .navbar-mega .dropdown-menu{left: 0px !important;width: 200px !important;}
    ul.site-menu-sub.site-menu-normal-list{    padding-left: 20px !important;}
    .site-menu-sub .site-menu-item > a:hover {
        color: rgba(179, 174, 174, 0.8) !important;
        background-color: rgba(255, 255, 255, .02);
    }
    .vsplitbar {
        width: 4px;
        background: #e4eaec;
    }
    textarea{border:1px solid #e4eaec;resize:none;}
    
    /*        iframe{border:none;width:100%;height: 369px;}*/
    object{height: 81% !important;
           position: absolute;}
    /*    object{border:none;width:100%;height: 369px;}*/
    
    .badge{display: inline-block;
           min-width: 10px;
           padding: 3px 7px;
           font-size: 12px;
           font-weight: 700;
           line-height: 1;
           color: #fff;
           text-align: center;
           white-space: nowrap;
           vertical-align: middle;
           background-color: #777;
           border-radius: 10px;}
    
    .lblcolor{color:#b7b7b7 !important;}

    /* ----------------------------------------------- */
    /* Fold out side bar using Canvas starts */
    /* ----------------------------------------------- */

    .offcanvas {
        position: fixed;
        z-index: 9999;
        display: none;
        transform: translate3d(0, 0, 0);
        transition: transform 800ms cubic-bezier(0.645, 0.045, 0.355, 1)
    }

    .offcanvas--top {
        top: -360px;
        left: 0;
        width: 100vw;
        height: 360px
    }

    .offcanvas--top--active { transform: translate3d(0, 360px, 0) }

    .offcanvas--right {
        top: 67px;
        right: -466px;
        width: 460px;
        height: 100vh;
    }

    .offcanvas--right--active { transform: translate3d(-466px, 0, 0);right:-466px; }

    .offcanvas--bottom {
        bottom: -360px;
        left: 0;
        width: 100vw;
        height: 360px
    }

    .offcanvas--bottom--active { transform: translate3d(0, -360px, 0) }

    .offcanvas--left {
        top: 0;
        left: -360px;
        width: 360px;
        height: 100vh;
    }

    .offcanvas--left--active { transform: translate3d(360px, 0, 0) }

    .offcanvas--initialized { display: block }
    #document-tag, #page-tag {
        /*        color: #fff;*/
        text-align: left;
        background-color: #f4f7f8;
        border: 1px solid #fff;
        box-shadow: 0px 0px 10px #5f5d5d;
    }
    
    .fa-chevron-circle-right{position:absolute;}
    .srcblock{border:1px solid #f4f7f8;padding:15px;margin-bottom:10px;word-wrap:break-word;}
    /*.panel-height{overflow: auto;
    max-height: 350px;}*/
    .hide{display:none;}

    .editable {
        border-color: #a0b6bd;
        box-shadow: inset 0 0 10px #a0b6bd;
        background: #ffffff;
    }

    .text {
        outline: none;
    }
    .text1{
        outline: none;
    }
    .text2{
        outline: none;
    }
    .multiple-height{
        min-height: 120px;
        max-height: 200px;
        overflow-y: auto;
    }
    .edit, .save {
        width: 30px;
        display: block;
        position: absolute;
        top: 0px;
        right: 10px;
        padding: 4px 0px;
        border-top-right-radius: 2px;
        border-bottom-left-radius: 10px;
        text-align: center;
        cursor: pointer;
    }
    .edit1, .save1 {
        width: 30px;
        display: block;
        position: absolute;
        top: 0px;
        right: 10px;
        padding: 4px 0px;
        border-top-right-radius: 2px;
        border-bottom-left-radius: 10px;
        text-align: center;
        cursor: pointer;
    }
    .edit2, .save2 {
        width: 30px;
        display: block;
        position: absolute;
        top: 0px;
        right: 10px;
        padding: 4px 0px;
        border-top-right-radius: 2px;
        border-bottom-left-radius: 10px;
        text-align: center;
        cursor: pointer;
    }
    .edit { 
        opacity: 0;
        transition: opacity .2s ease-in-out;
    }
    .edit1{ 
        opacity: 0;
        transition: opacity .2s ease-in-out;
    }
    .edit2{ 
        opacity: 0;
        transition: opacity .2s ease-in-out;
    }
    .save {
        opacity: 0;
        transition: opacity .2s ease-in-out;
    }
    /*    .save1 {
                display: none;
            }
            .save2 {
                display: none;
        }*/
    .box:hover .save {
        opacity: 1;
    }
    .box1:hover .edit1 {
        opacity: 1;
    }
    .box2:hover .edit2 {
        opacity: 1;
    }
    
    
    .spliticon{width:6px;height:45px;background:#000;right:0;margin-right: -5px;
               z-index: 999;top:40%;}
    .vsplitbar{z-index:0 !important;}
    .fixed-bottom{position: absolute;bottom: 0;width: 95%;}
    .view-sourcelink{line-height: 45px;
                     margin: 4px 0px;
                     position: fixed;
                     border-top: 1px solid #e4eaec;
                     bottom: 40px;
                     background: #fff;
                     width: 100%;
                     padding: 0px !important;
                     z-index: 999;}
    .fa-angle-double-left,.fa-angle-double-right{font-size:14px;background:#f2f2f2;border:1px solid #ccc;padding:3px 10px;margin-top:3px;cursor:pointer;margin-right:0 !important;}

    .form-control{ display: inline-block !important;width:94%;}
    .icon.fa.fa-user{ position: relative;
                      top: 0px;}

    li{display:inline;}

    #slidetrigger{
        width: 100px;
        height: 100px;
        background: grey;
        float: left;
        line-height: 100px;
        text-align: center;
        color: white;
        margin-bottom: 20px;
    }

    #slidecontent{
        width: 200px;
        display: none;
        height: 100px;
        float: left;
        padding-left: 10px;
        background: #F6953D;
        line-height: 100px;
        text-align: center;
    }

    .lighttext {
        font-size: 12px;
        color: #b1afaf;
        white-space: nowrap;
        width: 23em;
        overflow: hidden;
        text-overflow: ellipsis;
        float:left;
    }

   

   
    /* CSS for spliter*/
    dt {
        font: bold 14px Consolas, "Courier New", Courier, mono;
        color: steelblue;
        background-color: #f0f0f0;
        margin-top: 1.5em;
        padding: 0.2em 0.5em;
    }

    dd {
    }

    dd code {
        font: bold 12px Consolas, "Courier New", Courier, mono;
    }

    dd > code {
        display: block;
        color: #666666;
    }

    dd > code.default {
        color: #007700;
    }

    pre.codesample {
        font: bold 12px Consolas, "Courier New", Courier, mono;
        background: #ffffff;
        overflow: auto;
        width: 75%;
        border: solid gray;
        border-width: .1em .1em .1em .8em;
        padding: .2em .6em;
        margin: 0 auto;
        line-height: 125%
    }

    .splitter_panel > div {
        padding: 0 1em;
    }

    #splitter {

        height: 500px;
        border: 0px solid #666;
    }
    #splitter-left, #splitter-right{ padding:0px;}
    .splitter_container > .splitter_panel > :not(.splitter_container){overflow: none !important;}
    .panel-footer{height: 55px;
                  margin-top: 16px;}
   
    
    .splitter-vertical > .splitter_bar{width:4px !important;}
    .splitter_bar > .splitter_handle{    background-color: #000 !important;}


    /*Scrollbar customization for all page*/
    .scroll-wrapper {
        overflow: hidden !important;
        padding: 0 !important;
        position: relative;
    }
    .scroll-wrapper > .scroll-content {
        border: none !important;
        box-sizing: content-box !important;
        height: auto;
        left: 0;
        margin: 0;
        max-height: none !important;
        max-width: none !important;
        overflow: scroll !important;
        padding: 0;
        position: relative !important;
        top: 0;
        width: auto !important;}

    .scroll-wrapper > .scroll-content::-webkit-scrollbar {
        height: 0;
        width: 0;
    }
    .scroll-element {
        display: none;
    }
    .scroll-element, .scroll-element div {
        box-sizing: content-box;
    }
    .scroll-element .scroll-bar,
    .scroll-element .scroll-arrow {
        cursor: default;
    }
    ::-webkit-scrollbar { width: 7px; height: 10px;}
    /* Track */ ::-webkit-scrollbar-track { -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); -webkit-border-radius: 10px; border-radius: 10px; }
    /* Handle */ ::-webkit-scrollbar-thumb { -webkit-border-radius: 5px; border-radius: 5px;
                                             background: rgba(128, 128, 128,0.46);}
    
  .validationerrorcnt{
        display: block;
        text-align: right;
        color: red;
        padding: 1px 51px 7px 7px;
        font-size: 16px;
    }   
    
  .validationloader {
  border: 8px solid #f3f3f3;
  border-radius: 50%;
  border-top: 8px solid #62A8EA;
  border-bottom: 8px solid #62A8EA;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
    display: block;
    position: absolute;
    z-index: 9999;
    margin: 130px 355px 0px 355px;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
@media (min-width: 480px){
.multi-row {
    max-width: 1000px;
    margin: 30px auto;
}
}
.hot_query{
	height:250px;
	overflow-y:auto;
}
.hot table{
width:100%;
}
.modal-content{
   background:#fff!important; 
    min-height: 50%;    
	}
.modal-body{
   background:#fff!important; 
    height: 100%;    
    width:100%;
    overflow-y: auto;
    overflow-x: auto;
}


.modal-backdrop {
    visibility: hidden !important;
}
#exampleFillPopup .modal.in {
   /* background-color: rgba(0,0,0,0.5);*/
}
.modal-content{
    background-color:#fff;
}
#exampleFillPopup .modal-dialog { 
    z-index: 1; /* Sit on top */
    padding: 100px; /* Location of the box */
    min-height:100px;
    left: 0;
    top: 0;
    overflow: visible; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
 
        }
#exampleFillPopup .modal-header {
 
    background-color: #337AB7;
    width:100%;
 
    padding:16px 16px;
 
    color:#FFF;
 
    border-bottom:2px dashed #337AB7;
 
 }
 .loader {
  border: 8px solid #f3f3f3;
  border-radius: 50%;
  border-top: 8px solid #62A8EA;
  border-bottom: 8px solid #62A8EA;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
	display: block;
	position: absolute;
	z-index: 9999;
	margin: 130px 355px 0px 500px;
}


    </style>

    <body class="animsition site-navbar-small app-work">
    <!-- Project List Starts -->
    <!-- Breadcrumb Starts -->

    <form name="ProductionArea" id="ProductionArea" method="post">
        <div class="panel-heading p-b-0">
            <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="page-header p-l-0 p-r-0">
                    <div class="projet-details">
                        <h3 class="page-title">
                            <div class="col-md-4 font-size-14">
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
                            <div class="col-md-4 font-size-14">
                        <?php echo "Project Name : ". $ProjectName; ?>

                    </div> <button class="btn btn-default" type="button" onclick="search_mode();" data-target="#searchmodal" data-toggle="modal">Search</button>
			
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
                    <span style="visibility: hidden;">a</span>
			<div style="float: right;">
							 
                            <input type="checkbox" class="chk-wid-Url float-right" onclick="ShowUnVerifiedAtt()" id="chk-wid-Url2" value="2"> Hide Completed Fields 
                            <span style="display:none;">
			    <input type="checkbox" class="chk-wid-Url" onclick="checkAllUrlAtt()" id="chk-wid-Url" value="1"> Show Relevant Fields
                            </span>
							 	
							
			</div>
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
										
                                            <object width="100%" onload="onMyFrameLoad(this)" height="100%" style="visibility:visible" id="frame1" name="frame1" data="	" width="auto" height="auto"></object>

                                        </div>
                                        <div class="tab-pane" id="googletab" role="tabpanel">
                                            <div>
                                                <div class="goto"><a href="javascript: void(0);" onclick="$('#frame2').attr('data', 'https://www.google.com/ncr').hide().show();"> Go to Google </a></div>
                                                <div><object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame2" sandbox="" data="https://www.google.com/ncr"></object></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="mainurl" role="tabpanel">
										 <iframe onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame3" target='_parent'   src="http://mobiuslease.botminds.ai/login" ></iframe>
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

<div class="emptyerror" style="display:none;" >No Queries Posted!</div>
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

                                <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
                                      <div class="validationloader" style="display:none;"></div>
                                      <div class="validationerrorcnt" style="display:none;">
                                         Error's count : <span id="validationerrorcnt"></span>
                                      </div>
                                            <?php
                                            $i = 0;
                                            
//                                        $AttributeGroupMaster = array();
//                                        $AttributeGroupMaster[168] = "Base Information";
                                            
                                            foreach ($AttributeGroupMaster as $key => $GroupName) {
                                                if ($i < 0) {
                                                    $ariaexpanded = 'aria-expanded="true"';
                                                    $collapseIn = "collapse in";
                                                    $collapsed = "";
                                                } else {
                                                    $ariaexpanded = 'aria-expanded="false"';
                                                    $collapseIn = "collapse";
                                                    $collapsed = "collapsed";
                                                }
                                                // code for validation
                                                $attr1['id'] = $key;
                                                $attr1['name'] = $GroupName;
                                                $attr1['sub'] = array();
                                                
                                                ?>
                                    <div class="panel">
                                        <div class="panel-heading" id="exampleHeadingContinuousOne<?php echo $i; ?>" role="tab">

                                            <a id='<?php echo $key; ?>' class="panel-title <?php echo $collapsed; ?>" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne<?php echo $i; ?>" aria-controls="exampleCollapseContinuousOne<?php echo $i; ?>" <?php echo $ariaexpanded; ?>>
        <?php echo $GroupName; ?>
                                                <span class="badge CntBadge" id="CntBadge_<?php echo $key; ?>"></span>
                                                <span class="pull-right m-r-45">Status : 
                                                    <span id="currentADMVDoneCnt_<?php echo $key; ?>"></span>/
                                                    <span id="totalAttInThisGrpCnt_<?php echo $key; ?>"></span>
                                                </span>
                                            </a>
                                        </div>
                                        <!--                                    ----------------------------first campaign start--------------------------------------->
                                        <div class="panel-collapse <?php echo $collapseIn; ?> CampaignWiseMainDiv" data="<?php echo $key; ?>" id="exampleCollapseContinuousOne<?php echo $i; ?>" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
                                                        <?php
                                                      $attr_sub = array();
                                                        foreach ($AttributesListGroupWise[$key] as $keysub => $valuesSub) {
																															
																$ArrAttributes='';
																foreach ($valuesSub as $keys => $vals){
																 $ArrAttributes .=  $vals['AttributeMasterId']."-";
																 $MainGroupId =  $vals['MainGroupId'];
																 $SubGroupId =   $vals['SubGroupId'];
														}
                                                            ?>
															

                                            <div class="panel-body panel-height subgroupparentdivs subgroupparentdivs_<?php echo $key; ?>" style="border:0px;">
                                                            <?php
                                                            //echo $keysub;
                                                            if ($keysub != 0) {
                                                                //  pr($distinct);
                                                                $isDistinct = '';
                                                                $isDistinct = array_search($keysub, $distinct);
                                                                ?>
                                                <div class="col-md-12 row-title" style="padding:0px;">
                                                <div class="col-md-6 row-title" style="padding:0px;">
                                                <label class="form-control-label font-weight-400"> <?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?></label> 
                                                </div>
                                                    <div class="col-md-4 row-title" style="padding-right: 14px;">
                                                                <?php if ($isDistinct !== false) {
                                                                    ?>
                                                                 <i id="subgrp-add-field" style="margin-top:5px;" class="fa fa-plus-circle pull-right add-field m-l-10 m-r-5 addSubgrpAttribute" data="<?php echo $keysub; ?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>"></i> 
																 
                                                                
                                                                    <?php
                                                                    //pr($GrpSercntArr);
                                                                    $GroupSeqCnt = $GrpSercntArr[$keysub]['MaxSeq'];
                                                                } else { ?>
                                                                    <i style="margin-top:5px; padding:1px;" class="pull-right m-r-25"></i> 
                                                                    <?php $GroupSeqCnt = 1;
                                                                }
                                                                ?>
                                                                  <select onchange="checkAll(<?php echo $key; ?>,<?php echo $keysub; ?>);" id="subgrp_<?php echo $key; ?>_<?php echo $keysub; ?>" class="subgrp_<?php echo $key; ?>_<?php echo $keysub; ?> pull-right m-l-10 m-r-5 form-control">
                                                                     <option value="">--</option>
                                                                      <option value="V">V</option>    
                                                                     <option value="D">D</option>    
                                                                 </select>
                                                
                                                <?php
                                                                if ($GroupSeqCnt > 1) {
                                                                     // code added developer01-b2l
                                                                   $pagination_validation_class = "ProductionFields_" . $DependentMasterIds['ProductionField'];
					
																   
                                                                ?>
                                                <i id= "next_<?php echo $keysub; ?>" class="fa fa-angle-double-right pull-right m-r-5 <?php echo $pagination_validation_class; ?> validation_error_pagination" style="color:#4397e6"  onclick="Paginate('next', '<?php echo $keysub; ?>', '<?php echo $GroupSeqCnt; ?>');"></i> 
                                                <i id="previous_<?php echo $keysub; ?>" class="fa fa-angle-double-left pull-right <?php echo $pagination_validation_class; ?> validation_error_pagination" onclick="Paginate('previous', '<?php echo $keysub; ?>', '<?php echo $GroupSeqCnt; ?>');"></i>



                                                <i class="fa fa-info-circle m-r-10 m-l-10 pull-right"  onclick="loadhandsondatafinal_all('<?php echo $ArrAttributes; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>',' <?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>','<?php echo $ModuleId; ?>');" data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal"></i>
                                                                    <?php
                                                                }
                                                                ?>
                                                <input type="hidden" value="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>" id="attrsub<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>" class="removeinputclass">
												
                                                
                                                </div>
												<div class="col-md-2 row-title" style="padding:0px;">

																 <?php 
																// echo $AttributeSubGroupMasterJSON[$key][$keysub];
																 if($AttributeSubGroupMasterJSON[$key][$keysub]=="Brands"){ ?>
																 <input type="hidden" name="CurSeq" id="CurSeq" value="1">

																	<a href="" onclick="Rentcalc(<?php echo $valprodFields['AttributeMasterId'];?>,<?php echo $DependentMasterIds['ProductionField'];?>,<?php echo $DependentMasterIds['Comments']; ?>,<?php echo $DependentMasterIds['Disposition']; ?>,<?php echo $SubGroupId;?>,<?php echo $MainGroupId;?>,0);" data-target="#rentmodalAll" data-toggle="modal" class="rent-icon">
																		<?php echo $this->Html->image('../webroot/images/rent.png', array('alt' => 'Date Calculator', 'width' => '25'));?>
																	</a>	
																<?php } ?>
																</div>
												
                                                </div>
                                                <br/><br/>
                                                                <?php
                                                            }
                                                            //pr($GrpSercntArr);

                                                            if ($GroupSeqCnt == 0) {
                                                                $GroupSeqCnt = 1;
                                                            }
                                                            ?>
                                                <input value="1" type="hidden" data="<?php echo $GroupSeqCnt; ?>" name="GroupSeq_<?php echo $keysub; ?>" class="GroupSeq_<?php echo $keysub; ?> removeinputclass">

                                                            <?php
                                                             $attr3_ar = array();
                                                            for ($grpseq = 1; $grpseq <= $GroupSeqCnt; $grpseq++) {
                                                                if ($grpseq > 1)
                                                                    $disnone = "display:none;";
                                                                else
                                                                    $disnone = "";
                                                                ?>

                                                <div style="<?php echo $disnone; ?>Padding:0px;" id="MultiSubGroup_<?php echo $keysub; ?>_<?php echo $grpseq; ?>" class="clearfix">
                                                                <?php
																$rentset=0;
                                                            foreach ($valuesSub as $keyprodFields => $valprodFields) {
																
																
																
																
                                                                        if ($isDistinct !== false)
                                                                        $totalSeqCnt = 0;
                                                                    else
                                                                $totalSeqCnt = count($processinputdata[$valprodFields['AttributeMasterId']]);

                                                                        $projAvail = count($processinputdata[$valprodFields['AttributeMasterId']]);
                                                               

                                                                if ($totalSeqCnt == 0) {
                                                                    $totalSeqCnt = 1;
                                                                }
																
                                                                ?>
																
                                                    
                                                                        <?php
																		
																		
                                                                        for ($thisseq = 1; $thisseq <= $totalSeqCnt; $thisseq++) {
                                                                                    $tempSq = 1;
                                                                                    if ($isDistinct !== false) {
                                                                                        $tempSq = $grpseq;
                                                                                    } else
                                                                                        $tempSq = $thisseq;
																					
																					
																					$CommencementVal=$processinputdata[$Commencement][$tempSq][$DependentMasterIds['ProductionField']];
																
																$ExpirationVal=$processinputdata[$Expiration][$tempSq][$DependentMasterIds['ProductionField']];
																
																$BaseRentVal=$processinputdata[$BaseRent][$tempSq][$DependentMasterIds['ProductionField']];
																
																$RentIncVal=$processinputdata[$RentInc][$tempSq][$DependentMasterIds['ProductionField']];
																
																
																
                                                                                     
                                                                                    $ProdFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['ProductionField']];
                                                                                    $InpValueFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['InputValue']];
                                                                                    $DispositionFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Disposition']];
                                                                                    $CommentsFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Comments']];
										    $ScoreFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Score']];
                                                                                    $dependency=$DependentMasterIds['ProductionField'];
                                                                                    $ProdFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['ProductionField'] . "_" . $tempSq;
                                                                                    $ProdFieldsId = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['ProductionField'] . "_" . $tempSq;
                                                                                    $InpValueFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['InputValue'] . "_" . $tempSq;
                                                                                    $DispositionFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['Disposition'] . "_" . $tempSq;
                                                                                    $CommentsFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['Comments'] . "_" . $tempSq;
                                                                                    $dbClassName = "UpdateFields removeinputclass";
                                                                        if ($maxSeq[$DependentMasterIds['ProductionField']] < $tempSq) {
                                                                            $dbClassName = "InsertFields";
                                                                        }  else  $dbClassName = "UpdateFields removeinputclass";
                                                                        if ($maxSeq[$DependentMasterIds['Disposition']] < $tempSq) {
                                                                            $dbClassName_Disposition = "InsertFields";
                                                                        } else $dbClassName_Disposition = "UpdateFields removeinputclass";  
                                                                          if ($maxSeq[$DependentMasterIds['Comments']] < $tempSq) {
                                                                            $dbClassName_Comments = "InsertFields";
                                                                        } else $dbClassName_Comments = "UpdateFields removeinputclass";            

                                                                            if ($thisseq > 1)
                                                                                $disnone = "display:none;";
                                                                            else
                                                                                $disnone = "";

                                                                            $inpuControlType = $valprodFields['ControlName'];
//                                                                            if ($inpuControlType == "RadioButton" || $inpuControlType == "CheckBox")
//                                                                                $inpClass = 'onchange="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="doOnBlur ' . $dbClassName . '" ';
//                                                                            else
//                                                                                $inpClass = 'onchange="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="wid-100per form-control doOnBlur ' . $dbClassName . '" ';
                                                                            
                                                                            $inpId = 'id="' .$ProdFieldsId. '" ';
                                                                            $inpName = 'name="' . $ProdFieldsName . '" ';
                                                                            $inpValue = 'value="' . $ProdFieldsValue . '" ';
                                                                                    $inpOnClick = 'onclick="getThisId(this); loadWebpage(' . $valprodFields['AttributeMasterId'] . ', ' . $valprodFields['ProjectAttributeMasterId'] . ', ' . $valprodFields['MainGroupId'] . ', ' . $valprodFields['SubGroupId'] . ', ' . $tempSq . ', 0);" ';
                                                                            ?>
                                                                            <?php
                                                                            
                                                                            //Mandatory coding starts
                                                                            $IsMandatory=$validate[$valprodFields['ProjectAttributeMasterId']]['IsMandatory'];
                                                                            $DisplayAttributeName=$validate[$valprodFields['ProjectAttributeMasterId']]['DisplayAttributeName'];
                                                                            if($IsMandatory==1){
                                                                                $mandateFunction = "MandatoryValue(this.id,this.value,'$DisplayAttributeName');";
                                                                            }else{
                                                                               $mandateFunction =''; 
                                                                            }
                                                                            if(empty($validate[$valprodFields['ProjectAttributeMasterId']]['MinLength'])){
                                                                               $minlength = "null";
                                                                            }else{
                                                                              $minlength = $validate[$valprodFields['ProjectAttributeMasterId']]['MinLength']; 
                                                                            }
                                                                            if(empty($validate[$valprodFields['ProjectAttributeMasterId']]['IsDatepicker'])){
                                                                               $isDatePicker= '';
                                                                            }else{
                                                                              $isDatePicker = 1;
                                                                            }
                                                                       
                                                                            
                                                                            //Mandatory coding ends
                                                                            if($valprodFields['ControlName']=='TextBox' || $valprodFields['ControlName']=='Label') { 
                                                                             $inpOnBlur = 'onblur="checkLength(this,'.$valprodFields['AttributeMasterId'].','.$DependentMasterIds['ProductionField'].','.$tempSq.','.$minlength.');'.$mandateFunction.' '.$validate[$valprodFields['ProjectAttributeMasterId']]['FunctionName'].'(\'ProductionFields_' . $valprodFields['AttributeMasterId'].'_'.$DependentMasterIds['ProductionField'].'_'.$tempSq . '\', this.value,'.'\'' . $validate[$valprodFields['ProjectAttributeMasterId']]['AllowedCharacter'] . '\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['NotAllowedCharacter'].'\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['Dateformat'].'\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['AllowedDecimalPoint'].'\');" maxlength="'.$validate[$valprodFields['ProjectAttributeMasterId']]['MaxLength'].'" minlength="'.$validate[$valprodFields['ProjectAttributeMasterId']]['MinLength'].'"';   
                                                                             $inpClass = 'onchange="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="wid-100per inputsubGrp_'.$key.'_'.$keysub.' form-control doOnBlur ' . $dbClassName . '" ';
                                                                            }elseif($valprodFields['ControlName']=='DropDownList') {
                                                                             $inpOnBlur = 'onblur="'.$mandateFunction.' '.$validate[$valprodFields['ProjectAttributeMasterId']]['FunctionName'].'(\'ProductionFields_' . $valprodFields['AttributeMasterId'].'_'.$DependentMasterIds['ProductionField'].'_'.$tempSq . '\', this.value,'.'\'' . $validate[$valprodFields['ProjectAttributeMasterId']]['AllowedCharacter'] . '\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['NotAllowedCharacter'].'\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['Dateformat'].'\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['AllowedDecimalPoint'].'\');" ';      
                                                                           //  $call = ''.$validate[$valprodFields['ProjectAttributeMasterId']]['Reload'].','.$valprodFields['AttributeMasterId'].','.$DependentMasterIds['ProductionField'].','.$tempSq.'); autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');';
                                                                             $call = 'LoadValue('.$valprodFields['ProjectAttributeMasterId'].',this.value,'.$validate[$valprodFields['ProjectAttributeMasterId']]['Reload'].','.$valprodFields['AttributeMasterId'].','.$DependentMasterIds['ProductionField'].','.$tempSq.'); autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');';
                                                                             $inpClass = 'onchange="' . $call . '" class="inputsubGrp_'.$key.'_'.$keysub.' wid-100per form-control UpdatedQuery doOnBlur ' . $dbClassName . '" ';
                                                                            }elseif($valprodFields['ControlName']=='MultiTextBox') {
                                                                              $COpyTeXtId = 'id=COpyTeXt_'.$valprodFields['AttributeMasterId'].'_'.$tempSq;
                                                                              $inpOnBlur = 'onblur="'.$mandateFunction.' '.$validate[$valprodFields['ProjectAttributeMasterId']]['FunctionName'].'(\'ProductionFields_' . $valprodFields['AttributeMasterId'].'_'.$DependentMasterIds['ProductionField'].'_'.$tempSq . '\', this.value,' .'\''. $validate[$valprodFields['ProjectAttributeMasterId']]['AllowedCharacter'] . '\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['NotAllowedCharacter'].'\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['Dateformat'].'\', '.'\''.$validate[$valprodFields['ProjectAttributeMasterId']]['AllowedDecimalPoint'].'\');" ';       
                                                                              $inpClass = 'onclick="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="wid-100per inputsubGrp_'.$key.'_'.$keysub.' testmulti doOnBlur ' . $dbClassName . '"';
                                                                            }
                                                                            elseif($valprodFields['ControlName']=='RadioButton' || $valprodFields['ControlName']=='CheckBox') {
                                                                               $inpClass = 'onchange="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="inputsubGrp_'.$key.'_'.$keysub.' doOnBlur ' . $dbClassName . '" '; 
                                                                            }elseif($valprodFields['ControlName']=='Auto') {
                                                                                $inpClass = 'onchange="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="wid-100per inputsubGrp_'.$key.'_'.$keysub.' form-control doOnBlur ' . $dbClassName . '" ';
                                                                            }else{
                                                                                $inpClass = 'onchange="autoSave(' . $valprodFields['AttributeMasterId'] . ', ' . $DependentMasterIds['ProductionField'] . ', ' . $tempSq.');" class="wid-100per inputsubGrp_'.$key.'_'.$keysub.' form-control doOnBlur ' . $dbClassName . '" ';
                                                                            }
                                                                            ?>
                                                    
															<div class="commonClass commonclass_<?php echo $valprodFields['MainGroupId']?>" id="groupAttr_<?php echo $valprodFields['AttributeMasterId'].'_'.$grpseq?>">
                                                            <div id="MultiField_<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $thisseq; ?>" class="clearfix MultiField_<?php echo $valprodFields['AttributeMasterId']; ?> CampaignWiseFieldsDiv_<?php echo $key; ?> row form-responsive" style="<?php echo $disnone; ?>" >
                                                                
                                                                <div class="col-md-3 form-title">
                                                                <div class="form-group" style=""><p class="link-style"><a onclick="GetFrameData('<?php echo $valprodFields['AttributeName'] ?>');"><?php echo $valprodFields['DisplayAttributeName'] ?></a></p>

                                                                    <input type="hidden" value="<?php echo $valprodFields['DisplayAttributeName'] ?>" id="attrdisp<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>" class="removeinputclass">
																	  
																	   <input type="hidden" class="query_ids" name="queryall[<?php echo $valprodFields['AttributeMasterId'];?>]" id="queryall.<?php echo $valprodFields['AttributeMasterId']; ?>" value="<?php echo $valprodFields['AttributeMasterId'];?>">
                                        
										 <input type="hidden" class="query_names" name="querynameall[<?php echo $valprodFields['AttributeMasterId'];?>]" id="querynameall.<?php echo $valprodFields['AttributeMasterId']; ?>" value="<?php echo $valprodFields['DisplayAttributeName'];?>">
                                        
																	
                                                                </div>	
                                                                </div>
                                                                <div class="col-md-4 form-text">
                                                                <div class="form-group">
																
																

                                                                                    <?php
                                                                                    $readonly=array();
                                                                                    if($productionjob['isbotminds'] != 1){
                                                                                    foreach ($ReadOnlyFields as $ReadOnlyVal){
                                                                                        if($ReadOnlyVal['AttributeMasterId'] == $valprodFields['AttributeMasterId']){
                                                                                            $readonly[] = 'readonly="readonly"';
                                                                                        }
                                                                                    }
                                                                                    }
                                                                                    $readonly = $readonly[0];
                                                                                    if ($inpuControlType == "TextBox") {
                                                                                        echo '<input type="text" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . $inpOnBlur . $readonly . '>';
                                                                                    } else if ($inpuControlType == "CheckBox") {
                                                                                        echo '<input type="checkbox" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . $inpOnBlur .'>';
										} else if ($inpuControlType == "MultiTextBox") {
                                                                                    
                                                                                        echo '<textarea readonly="readonly" class="wid-100per form-control" ' . $COpyTeXtId . '>'.$ProdFieldsValue.'</textarea>';
                                                                                        //    if(!empty($valprodFields['Options'])){
                                                                                        //        $inpName = 'name="' . $ProdFieldsName . '[]" ';
                                                                                        //        $ProdFieldsValueArr=explode(',',$ProdFieldsValue);                                   
                                                                                        //            echo '<select ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur . 'multiple="true">';
                                                                                        //        foreach ($valprodFields['Options'] as $ke => $va) {
                                                                                        //        $sele = "";
                                                                                        //        if (in_array($va,$ProdFieldsValueArr))
                                                                                        //            $sele = "selected";
                                                                                        //            echo '<option value="' . $va . '" ' . $sele . '>' . $va . '</option>';
                                                                                        //        }
                                                                                        //    } else {
                                                                                        //        echo '<textarea ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur .'>'.$ProdFieldsValue.'</textarea>';
                                                                                        //    }
                                                                                        //       echo '</select>';

                                                                                        if(!empty($valprodFields['Options'])){
                                                                                            $inpName = 'name="' . $ProdFieldsName . '[]" ';
                                                                                            $ProdFieldsValueArr=explode(',',$ProdFieldsValue);
                                                                                            echo '<select ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur . ' multiple="true">';
                                                                                            foreach ($valprodFields['Options'] as $ke => $va) {
                                                                                            $sele = "";
                                                                                            if (in_array($va,$ProdFieldsValueArr))
                                                                                                $sele = "selected";
                                                                                                echo '<option value="' . $va . '" ' . $sele . '>' . $va . '</option>';
                                                                                            }
                                                                                             echo '</select>';
                                                                                        } else {
                                                                                            echo '<textarea ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur .'>'.$ProdFieldsValue.'</textarea>';
                                                                                        }


                                                                                    } else if ($inpuControlType == "RadioButton") {
                                                                                        
                                                                                        if (strtolower($ProdFieldsValue) == "yes")
                                                                                            $yesSel = ' checked="checked"';
                                                                                        if (strtolower($ProdFieldsValue) == "no")
                                                                                            $noSel = ' checked="checked"" ';
                                                                                       echo '<input value="Yes" style="position:static" type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur . $yesSel . '> Yes';  
										       echo '<input style="position:static" value="No" type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur . $noSel . '> No';
                                                                                    }
                                                                                    else if ($inpuControlType == "DropDownList") {
                                                                                        echo '<select ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur .'><option value="">--Select--</option>';
                                                                                        if(!empty($valprodFields['Options'])){
                                                                                        foreach ($valprodFields['Options'] as $ke => $va) {
                                                                                            $sele = "";
                                                                                            if ($va == $ProdFieldsValue)
                                                                                                $sele = "selected";
                                                                                            echo '<option value="' . $va . '" ' . $sele . '>' . $va . '</option>';
                                                                                        }
                                                                                        }
                                                                                        else{
                                                                                             $sele = "selected";
                                                                                           echo '<option ' . $inpValue . ' ' . $sele . '>' . $ProdFieldsValue . '</option>'; 
                                                                                        }
                                                                                        echo '</select>';
                                                                                    }
                                                                                    ?>
                                                                    <span class="lighttext" value="<?php echo $InpValueFieldsValue; ?>" id="beforeText_<?php echo $key; ?>_<?php echo $keysub; ?>_<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $tempSq; ?>" data-toggle="tooltip" title="<?php echo $InpValueFieldsValue; ?>"><?php echo $InpValueFieldsValue; ?></span><?php //echo $ScoreFieldsValue; ?>
																	<span style="color:red;display:none;" class="lighttext validation_error" data-toggle="tooltip" id="<?php echo $ProdFieldsId."_error";?>"></span>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-2 form-text">
                                                                <div class="form-group comments">
																<?php if($rentset==0){
																	$rentset++;
																	?>
																	 <input value="<?php echo $valprodFields['AttributeMasterId'];?>" type="hidden"  name="FirstAttrGroup_<?php echo $valprodFields['SubGroupId']."".$valprodFields['MainGroupId']."".$tempSq;?>" id="FirstAttrGroup_<?php echo $valprodFields['SubGroupId']."".$valprodFields['MainGroupId'];?>" >

															
																	<?php
																}
																?>
																
																	 
                                                                    <textarea rows="1" cols="50" class="form-control <?php echo $dbClassName_Disposition; ?>" id="" name="<?php echo $CommentsFieldsName; ?>" placeholder="Comments" onclick="loadWebpage(<?php echo $valprodFields['AttributeMasterId']; ?>, <?php echo $valprodFields['ProjectAttributeMasterId']; ?>, <?php echo $valprodFields['MainGroupId']; ?>, <?php echo $valprodFields['SubGroupId']; ?>,<?php echo $tempSq; ?>, 0);"><?php echo $CommentsFieldsValue; ?></textarea>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-3 form-status">
                                                                <div class="form-group status">
                                                                    <select style="padding-RIGHT:59px" id="<?php echo $key.'_'.$keysub.'_'.$valprodFields["AttributeMasterId"].'_'.$tempSq;?>" name="<?php echo $DispositionFieldsName; ?>"  class="<?php echo $dbClassName_Disposition; ?> form-control CampaignWiseSelDone_<?php echo $key; ?> dispositionSelect subGrpDisp_<?php echo $key; ?>_<?php echo $keysub; ?>">
                                                                        <option value="">--</option>
                                                                        <option value="A" <?php
                                                                       // echo "DispositionFieldsValue_".$DispositionFieldsValue;
                                                                    if ($DispositionFieldsValue == "A") {
                                                                                        echo 'selected';
                                                                    }
                                                                        ?>>A</option>
                                                                        <option value="D" <?php
                                                                                                if ($DispositionFieldsValue == "D") {
                                                                                        echo 'selected';
                                                                                                }
                                                                                                ?>>D</option>
                                                                        <option value="M" <?php
                                                                                                if ($DispositionFieldsValue == "M") {
                                                                                        echo 'selected';
                                                                                                }
                                                                                                ?>>M</option>
                                                                        <option value="V" <?php
                                                                                if ($DispositionFieldsValue == "V") {
                                                                echo 'selected';
                                                                                }
                                                                                                ?>>V</option>
                                                                    </select>
                                                                    <div>
                                                                                                                                        <?php if($isDatePicker != 1){   ?>
																	<a href="javascript: void(0);"
																		onclick='window.open ("<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'datecalculator', 'inputid'=> urlencode($inpId), 'prefix'=>false)); ?>", "mywindow","menubar=1,resizable=1,width=350,height=400");'>
																		<?php echo $this->Html->image('../webroot/images/calculator1.png', array('alt' => 'Date Calculator', 'width' => '25'));?>
																	</a>
																
                                                                                                                                        <?php }	?>
                                                                        <?php
                                                                $array1 = $valprodFields['AttributeMasterId'];
                                                                $array2 = $HelpContantDetails;
                                                                if (in_array($array1, $array2)) {
                                                                    ?>
                                                                         <i title="Help" class="fa fa-question-circle question m-r-10 m-l-10" data-target="#helpmodal" data-toggle="modal" onclick='loadHelpContent(<?php echo $valprodFields['AttributeMasterId']; ?>, "<?php echo $valprodFields['DisplayAttributeName']; ?>");'></i>
                                                                
                                                                <?php } ?>
               
                                    <?php if ($totalSeqCnt > 1) {
                                                                            ?>
                                                                 
                                                                <i class="fa fa-info-circle m-l-10" ata-target="#example-modal" onclick="loadhandsondatafinal('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $tempSq; ?>', '<?php echo $keysub; ?>','<?php echo $valprodFields['DisplayAttributeName']; ?>','<?php echo $ModuleId; ?>');"" data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal"></i>
                                                                <i class="fa fa-angle-double-left i_previous_<?php echo $valprodFields['AttributeMasterId']; ?>" onclick="loadMultiField('i_previous', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i>
                                                                <i class="fa fa-angle-double-right m-r-5 i_next_<?php echo $valprodFields['AttributeMasterId']; ?>" style="color:#4397e6" onclick="loadMultiField('i_next', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i> 
                                                            
                                                                <?php
                                                            } ?>
                                                                     <?php if ($isDistinct === false) {
                                                                            if($valprodFields['IsDistinct']==0) {
                                                                                ?>
                                                                <i id="add-field" class="fa fa-plus-circle add-field m-r-10 addAttribute" data="<?php echo $valprodFields['AttributeMasterId']; ?>" data-ProjAttrId="<?php echo $valprodFields['ProjectAttributeMasterId']; ?>" date-subgrpId="<?php echo $keysub;?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $valprodFields['DisplayAttributeName']; ?>"></i>
                                                                                <?php 
                                                                            }
                                                                            } ?>
                                                                </div>
                                                                </div>
                                                                </div>

                                                                
                                                            <!--<i class="fa fa-minus-circle remove-field"></i>-->
                                                            </div>
                                                </div>
                                                                            <?php
																			
                                                                        }
                                                                        ?>
                                                    <span style="padding:0px;" class="add_<?php echo $valprodFields['AttributeMasterId']; ?>"></span>

                                                            <input value="1" type="hidden" data="<?php echo $thisseq - 1; ?>" name="ShowingSeqDiv_<?php echo $valprodFields['AttributeMasterId']; ?>" class="ShowingSeqDiv_<?php echo $valprodFields['AttributeMasterId']; ?> removeinputclass">

                                                                        <?php
                                                                        
                                                            ?>
                                                        

                                                   
                                                                <?php // code for validation
                                                                 $attr3 = $valprodFields;
                                                                 $attr3['GroupSeqCnt'] = $GroupSeqCnt;
                                                                  unset($attr3['Options']);
                                                                  $attr3_ar[] = $attr3;
                                                                  
                                                                }
                                                                ?>

                                                </div>
                                                            <?php
                                                            } // group seq loop
            ?>
                                                <span style="" class="addGrp_<?php echo $keysub; ?>"></span>
                                            </div>
            <?php 
             // code for validation
            $attr_sub[$keysub] = $attr3_ar;
               }
            $attr1['sub'] = $attr_sub;
        ?>
		
		
                                        </div>
                                    </div>
                                        <!--                                    ----------------------------first campaign end--------------------------------------->
                                                <?php
                                                $i++;
                                                $attr_array[] = $attr1;
                                            }
                                            ?>
															
															
															
															<input type="hidden" name="CommencementId" id="CommencementId" value="<?php echo $Commencement;?>">
															<input type="hidden" name="ExpirationId" id="ExpirationId" value="<?php echo $Expiration;?>">
															<input type="hidden" name="BaseRentId" id="BaseRentId" value="<?php echo $BaseRent;?>">
															<input type="hidden" name="RentIncId" id="RentIncId" value="<?php echo $RentInc;?>">
															<input type="hidden" name="Rentseq" id="Rentseq" value="<?php echo $GroupSeqCnt;?>">
															
															<input type="hidden" name="RentComments" id="RentComments" value="">
															<input type="hidden" name="RentDisposition" id="RentDisposition" value="">
															<input type="hidden" name="RentProductionField" id="RentProductionField" value="">
															<input type="hidden" name="RentFirstAttrId" id="RentFirstAttrId" value="">
															<input type="hidden" name="RentFirstAttrVal" id="RentFirstAttrVal" value="">
															<input type="hidden" name="RentSubGroup" id="RentSubGroup" value="">
															<input type="hidden" name="RentGroup" id="RentGroup" value="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Splitter Ends -->
            </div>  
        </div>
        
        <!-- Project List Ends -->	
        <div class="view-sourcelink p-l-0 p-r-0">
            <!-- <a href="#" class="current button offcanvas__trigger--open m-l-10" data-rel="page-tag">View Source Link</a> -->
            <div class="col-lg-6" align="left">
<!--                <button type="button" href="#" class="btn btn-default offcanvas__trigger--open" onclick="multipleUrl();" id="multiplelinkbutton" data-rel="page-tag">Multiple Source Links</button>-->
                <button type="button" class="btn btn-default offcanvas__trigger--close" onclick="loadReferenceUrl();" data-rel="page-tag" data-target="#exampleFillIn" data-toggle="modal">View Source</button>
                               <button class="btn btn-default" name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>
                               <?php if($ModuleId == 145) { ?>
							   <button class="btn btn-default" name='fetchbotmind' id='fetchbotmind' onclick="fetchbotminds();" type="button">Fetch BotMinds</button>
                                                           
                               <?php } ?>
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
                <button type="button" name='Save' value="Save" id="save_btn" class="btn btn-primary pull-right m-r-5" onclick="AjaxSave('');">Save</button>
                 <button type="button" name='Validation' value="validation" class="btn btn-primary pull-right m-r-5" onclick="AjaxValidation();">Validation</button>
				 <?php if($levelModule == '1'){ ?>
                <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodalAll" onclick="ajaxQuerypopup();" data-toggle="modal">Query</button>
				 <?php } else{ ?>					
                <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodal" data-toggle="modal">Query</button>
				<?php } ?>
            </div>
        </div>
    </form>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-right-0 padding-left-0">
        <!--        <div class="modal fade modal-fill-in">-->
<!--        <div id="page-tag" class="offcanvas multisourcediv">
            <div class="panel m-30">
                <div class="panel-body panel-height multiple-height">
                     <a class="panel-action fa fa-cog pull-right" data-toggle="panel-fullscreen" aria-hidden="true" style="color:red;"></a> 
                    <div class="col-xs-12 col-xl-12" id="addnewurl"> 
                        <div class="col-xs-12 col-xl-4">
                            <div class="srcblock box">
                           <i class="fa fa-times-circle save"></i>
                                <i class="fa fa-save save"></i>
                                <input autocomplete="off" type="text" class="form-control" id="addurl" placeholder="Enter Url..">

                            </div> </div> </div>
                    <div class="col-xs-12 col-xl-12">
                        <div id="LoadAttrValue">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary pull-right m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button>		
                    <button type="button" class="btn btn-default pull-right m-r-5 offcanvas__trigger--close multisorcedivclose" data-rel="page-tag">Cancel</button>

                </div>
            </div>
        </div>-->
        <!--        </div>-->
        <!-- Right side flip canvas for Page Taggs ends -->	
        <!-- Modal -->

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
                <!-- <div class="panel-footer">
                    <button type="button" class="btn btn-primary pull-right m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button>		
<!--                    <button type="button" class="btn btn-default pull-right m-r-5 offcanvas__trigger--close multisorcedivclose" data-rel="page-tag">Cancel</button>-->

<!--</div> -->
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
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button> -->
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
            <div class="modal-dialog multi-row2">
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
		 <!-- Popup new Modal -->
<div class="modal fade modal-fill-in" id="exampleFillPopup" aria-hidden="false" aria-labelledby="exampleFillInHandson" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Ã—</span>
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

	<div class="loader" style="display:none;"></div>


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
        
        <!-- Modal -->
				 <div class="modal fade" id="searchmodal" aria-hidden="true" aria-labelledby="searchmodal" role="dialog" tabindex="-1">
            <div class="modal-dialog" style="max-width:1200px;">
                <div class="modal-content">
				<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTitle">Search Field</h4>
                    </div>
					<div class="modal-body" style="height:520px;overflow-y:auto;">                       
                            <div class="form-group">
							
                                <div class="form-group col-md-6">
								   <div class="col-md-6"> <label for="Query" >Transfer_Agent_Name</label></div>
								   <div class="col-md-6"><input type="text" name="OSF_CO_NAME" id="OSF_CO_NAME"  class="form-control" value="">
								   </div>
                                </div>
								 <div class="form-group col-md-6">
								   <div class="col-md-6"> <label for="Query" >Company Name</label></div>
								   <div class="col-md-6"><input type="text" name="FORMER_CO_NAME" id="FORMER_CO_NAME" class="form-control" value="">
								   </div>
                                </div>
								<!-- <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >First Name</label></div>
								   <div class="col-md-6"><input type="text" name="FIRST_NAME" id="FIRST_NAME"  class="form-control" value="">
								   </div>
                                </div>
								 <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Middle Name</label></div>
								   <div class="col-md-6"><input type="text" name="MIDDLE_NAME" id="MIDDLE_NAME"  class="form-control" value="">
								   </div>
                                </div>
								<div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Last Name</label></div>
								   <div class="col-md-6"><input type="text" name="LAST_NAME" id="LAST_NAME"  class="form-control" value="">
								   </div>
                                </div>
								<div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Competitor_Name</label></div>
								   <div class="col-md-6"><input type="text" name="RentIncVal1" id="RentIncVal1"  class="form-control" value="">
								   </div> -->
                                </div>
								 <div class="form-group col-md-6">
								    
								   <?php echo $this->Form->button('Search', array('id' => 'Query', 'type' => 'button', 'name' => 'Query', 'value' => 'Query', 'class' => 'btn btn-primary', 'onclick' => "Searchdata();")) . ' '; ?>
                                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
								 <div class="hot_search">
								 </div>
								</div>
                            </div>
                        </form>
                    </div>
					  
				</div>
            </div>
        </div>
			 <div class="modal fade" id="rentmodalAll" aria-hidden="true" aria-labelledby="rentmodalAll" role="dialog" tabindex="-1">
            <div class="modal-dialog" style="max-width:1250px;max-height:400px;">
                <div class="modal-content">
				<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTitle">Rent Calculation <span id="RentTitle"></span></h4>
                    </div>
					<div class="modal-body" style="height:450px;overflow-y:auto;">                       
                            <div class="form-group">
                                <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Commencement Date</label></div>
								   <div class="col-md-6"><input type="text" name="CommencementVal" id="CommencementVal"  class="datepickstart form-control" value="">
								   <input type="hidden" name="SequenceVal" id="SequenceVal"  class="form-control" value="">
								   
								   </div>
                                </div>
								 <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Expiration Date</label></div>
								   <div class="col-md-6"><input type="text" name="ExpirationVal" id="ExpirationVal" class="datepickend form-control" value="">
								   </div>
                                </div>
								 <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Base Rent Initial amount</label></div>
								   <div class="col-md-6"><input type="text" name="BaseRentVal" id="BaseRentVal"  class="form-control" value="">
								   </div>
                                </div>
								 <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Rent Inc</label></div>
								   <div class="col-md-6"><input type="text" name="RentIncVal" id="RentIncVal"  class="form-control" value="">
								   </div>
                                </div>
								 <div class="form-group col-md-12">
								   <div class="col-md-6"> <label for="Query" >Frequency</label></div>
								   <div class="col-md-6">
								   <select name="frequency" id="frequency" class="form-control">
									<option value="0">---Select---</option>
									<option value="6 month">6 Month</option>
									<option value="1 year">1 Year</option>
									<option value="2 year">2 Year</option>
									<option value="3 year">3 Year</option>
									<option value="4 year">4 Year</option>
									</select>
								   </div> 
								   <?php echo $this->Form->button('Get', array('id' => 'Query', 'type' => 'button', 'name' => 'Query', 'value' => 'Query', 'class' => 'btn btn-primary', 'onclick' => "Rentcalcsub();")) . ' '; ?>
                                
								 <div class="hot_rent">
								 </div>
</div>
                            </div>
                        </form>
                    </div>
					  <div class="modal-footer">
                        <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity']; ?>">                        
								
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="Rentcalcappend();">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                        <!--                            <button type="button" class="btn btn-primary">Submit</button>-->
                    </div>
				</div>
            </div>
        </div>
		
		
		
		 <div class="modal fade" id="querymodalAll" aria-hidden="true" aria-labelledby="querymodalAll" role="dialog" tabindex="-1">
            <div class="modal-dialog multi-row">
                <div class="modal-content">
				<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="exampleModalTitle">Query  <span class="suc-msg"></span></h4> 
					 
                    </div>
					<div class="modal-body">                       
                            <div class="hot_query">
                                
                            </div>
                        </form>
                    </div>
					  <div class="modal-footer">
                        <input type="hidden" name="ProductionEntity" id="ProductionEntity" value="<?php echo $productionjob['ProductionEntity']; ?>">
                        
        <?php echo $this->Form->button('Submit', array('id' => 'Query', 'type' => 'button', 'name' => 'Query', 'value' => 'Query', 'class' => 'btn btn-primary', 'onclick' => "return valicateQueryAll();")) . ' '; ?>
<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                        <!--                            <button type="button" class="btn btn-primary">Submit</button>-->
                    </div>
				</div>
            </div>
        </div>
		
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
       
         var attr_array = JSON.parse('<?php echo json_encode($attr_array); ?>' );
         var project_scope_id = "<?php echo $staticFields[0]; ?>";
    
       function AjaxValidation(){
            console.log(attr_array);
            $(".formsubmit_validation_endisable").show();
            $(".validationloader").show();
            $(".validation_error").hide();
             $(".validationerrorcnt").hide();
            $(".validation_error_pagination").css("color", "#4397e6");
            $(".panel-group").css("opacity",0.5);
         
            setTimeout(function(){
                AjaxValidationstart(); 
            }, 500);
            
    }
    
    function AjaxValidationstart(){
       
         var txt = "";
         var cunt = 1;
         var itemkey ="";
//         var listdata = jsnlist;
         var listerror = "";
         var strArray ="";
         var error_count ="";
            ProjectId = $("#ProjectId").val();
            RegionId = $("#RegionId").val();
            ProductionEntityID = $("#ProductionEntityID").val();
            InputEntityId = $("#InputEntityId").val();
	    TimeTaken = $("#TimeTaken").val();
            //$("#save_btn").html("Please wait! Saving...");
            var status = "<?php echo $productionjob['StatusId']; ?>";
            //$("#save_btn").attr("disabled", "disabled");
            
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxapidatapreparation')); ?>",
                data: ({ProjectId: ProjectId, RegionId: RegionId, ProductionEntityID: ProductionEntityID, InputEntityId: InputEntityId, StatusId: status,TimeTaken:TimeTaken,attr_array:attr_array,project_scope_id:project_scope_id}),
                dataType: 'json',
                async: true,
                success: function (result) {
                       var resultarray = jQuery.parseJSON(JSON.stringify(result));
//                        resultarray = JSON.parse(result);
                      
                          if(resultarray['status'] ==1){
                               listerror = resultarray['Validation Output'];
                        error_count = resultarray['Errors Count'];
                       $("#validationerrorcnt").html(error_count);
                       $(".validationerrorcnt").show();
                        if(error_count > 0){
                              $.each( listerror, function( key, val ) {
                             $.each( val, function( skey, sval ) {
                                 $.each( sval, function( sskey, ssval ) {
                                     strArray = ssval.ext.split(",");
                                     for (i = 0; i < strArray.length; i++) {
                                           if(strArray[i] > 1){
                                               $("."+ssval.pagination_key).css("color", "red");
                                           }

                                         if(strArray[i].length > 0){
                                           $("#"+ssval.key+"_"+strArray[i]+"_error").html(ssval[strArray[i]]["error_txt"]);
                                           $("#"+ssval.key+"_"+strArray[i]+"_error").show();
                                     }
                                     }
                                 });

                                 });
                         });
                        }else{
                             $(".formsubmit_validation_endisable").show(); // code added 
                        }
                        
                          }
                       
                          $(".panel-group").css("opacity","");
                          $(".validationloader").css({"display": "none"});
                }
            });
          
          return true;
             
         }
         
        function checkAll(grp,subgrp){
               var select_all_Disp = document.getElementById("subgrp_"+grp+"_"+subgrp).value; 
     //   var Disp_Url = document.getElementsByClassName("subGrpDisp_"+grp+"_"+subgrp); 
        
        $(".subGrpDisp_"+grp+"_"+subgrp).val(select_all_Disp);
        
        if(select_all_Disp === 'D'){
          $(".inputsubGrp_"+grp+"_"+subgrp).val('');  
        }
        
         if(select_all_Disp === 'V'){
         var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
    var subGrpAtt = JSON.parse(subGrpArr);     
console.log(subGrpAtt);
    var subGrpAttArr = subGrpAtt[grp][subgrp];   
     var maxSeqCntsub = $('.GroupSeq_' + subgrp).attr("data");
        var inpId = <?php echo $DependentMasterIds['ProductionField']; ?>;
   for (i = 1; i <= maxSeqCntsub; i++) {
             $.each(subGrpAttArr, function (key, val) {
                 var data = $("#beforeText_"+grp+"_"+subgrp+"_"+val['AttributeMasterId']+"_"+i).text(); 
                 $("#ProductionFields_"+val['AttributeMasterId']+"_"+inpId+"_"+i).val(data); 
                 
                  var maxSeqCnt = $('.ShowingSeqDiv_' + val['AttributeMasterId']).attr("data");
                  if(maxSeqCnt > 1){
                       for (j = 1; j <= maxSeqCnt; j++) {
                 var data = $("#beforeText_"+grp+"_"+subgrp+"_"+val['AttributeMasterId']+"_"+j).text(); 
                 $("#ProductionFields_"+val['AttributeMasterId']+"_"+inpId+"_"+j).val(data); 
             }
        }
             });
}      
}
        }
        
        function checkLength(el,id,depd,seq,minval) {
if(el.value.length > 0){
   if(el.value.length < minval){
        alert("make sure the input is " +minval+  " characters long");
        setTimeout(function() { 
            document.getElementById('ProductionFields_'+id+'_'+depd+'_'+seq).focus(); 
        }, 10);
        return false;
    }
   }
}
        
$(document).keydown(function(e) {
    		if(e.which == 65) { 
                    
			
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
            
            jQuery(function($) {
                $('object').bind('load', function() {
                   var childFrame = $(this).contents().find('body');
                    childFrame.on('dblclick', function() {
                        var iframe= document.getElementById('frame1');
                        var idoc= iframe.contentDocument || iframe.contentWindow.document;
                        var seltext = idoc.getSelection();
                        $(AttrcopyId).val(seltext);
                   });
                   
                   childFrame.bind('mouseup', function(){
                        var iframe= document.getElementById('frame1');
                        var idoc= iframe.contentDocument || iframe.contentWindow.document;
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
                        if(seltext!="" && typeof AttrcopyId != 'undefined')
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
                
                
                for (var key in localStorage){
                    if(key=='attrgrp') {
                       
                      arrtArr=JSON.parse(localStorage.getItem('attrgrp'));
                      
                      $.each(arrtArr, function(key, value) {
                         addSubgrpAttribute(value.subgrpId,value.groupId)
                      });
                       
                    }
                    if(key=='attradd') {
                       
                      arrtArr=JSON.parse(localStorage.getItem('attradd'));
                      
                      $.each(arrtArr, function(key, value) {
                         addAttribute(value.data,value.ProjAttributeId,value.groupId,value.subgrpId,value.groupName)
                      });
                       
                    }
                   
                    //Load_verifiedAttrCnt($this);
                }
                for (var key in localStorage){
                    
                    if(key!=='attradd') {
                        
                        $('input[name="'+key+'"]').val(localStorage.getItem(key));
                        $('textarea[name="'+key+'"]').text(localStorage.getItem(key));
                       // $('select[name="'+key+'"] > option').eq(localStorage.getItem(key)).attr('selected','selected')
                       $this=$('input[name="'+key+'"]');
                       $('select[name="'+key+'"] option').filter(function() { 
                           $this=$('select[name="'+key+'"]');
                        return ($(this).text() == localStorage.getItem(key)); //To select Blue
                        }).prop('selected', true); 
                        
                
                    }
                  //  Load_verifiedAttrCnt($this);
                }
                Load_totalAttInThisGrpCnt();
                //localStorage.clear();
                $(".UpdateFields").blur(function(e){
                    AttValue = $(this).val();
                    Attname=$(this).attr("name");
                  
                    localStorage.setItem(Attname, AttValue);
                    
                    
                    
                 });
                 
                 $(".InsertFields").blur(function(e){
                    AttValue = $(this).val();
                    Attname=$(this).attr("name");
                  
                    localStorage.setItem(Attname, AttValue);
                    
                    
                    
                 });
                
                
           });
            function addslashes(str) {
            str=str.replace(/'/g,"\\'");
            str=str.replace(/"/g,'\\"');
            return str;
            }
         
            function  addAttribute (atributeId,ProjAttributeId,groupId,subgrpId,groupName) {
            //var atributeId = $(this).attr("data");
            //var ProjAttributeId = $(this).attr("data-ProjAttrId");
            //var groupId = $(this).attr("data-groupId");
            //var subgrpId = $(this).attr("date-subgrpId");
            // var groupName = $(this).attr("data-groupName");
         
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            //var subGrpArrValidate='<?php //echo htmlspecialchars(str_replace("'", "\\'", json_encode($validate)))?>';
            //var subGrpArrValidate='<?php //echo str_replace("\\", "\\",(json_encode($validate)))?>';
            //var subGrpArrValidate='<?php //echo stripslashes(str_replace("\\\\", "\\",(json_encode($validate))))?>';
            var subGrpArrValidate='<?php echo stripslashes(json_encode($validate))?>';
            var subGrpAttValidate = JSON.parse(subGrpArrValidate);
            var elementValidate = subGrpAttValidate[ProjAttributeId];
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
           element=[];
             $.each(subGrpAttArr, function (key, val) {
                 if(val['AttributeMasterId']==atributeId){
                     element=val;
                 }
             });
             var inpId = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var inpName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var commendName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
            var selName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
            var prodDep='<?php echo $DependentMasterIds['ProductionField']; ?>';
            var cmdDep='<?php echo $DependentMasterIds['Comments']; ?>';
            var disDep='<?php echo $DependentMasterIds['Disposition']; ?>';
             maxSeq='<?php echo json_encode($maxSeq);?>';
            maxSeqArr=JSON.parse(maxSeq);
            if(nxtSeq<=maxSeqArr[prodDep])
                var dbClass='UpdateFields';
            else
                var dbClass='InsertFields';
            if(nxtSeq<=maxSeqArr[cmdDep]) 
                var dbClass_cmd='UpdateFields';
            else
                var dbClass_cmd='InsertFields';
            
            if(nxtSeq<=maxSeqArr[disDep]) 
                var dbClass_dis='UpdateFields';
            else
                var dbClass_dis='InsertFields';
            
            //alert(nxtSeq);
            var toappendData = '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important" class="row form-responsive MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                    '<div class="col-md-3 form-title"><div class="form-group" style=""><p>' + groupName + '</p></div></div>' +
                    '<div class="col-md-4 form-text"><div class="form-group">' ;
					
		var pam = element['ProjectAttributeMasterId'];
                 var reload = 'LoadValue('+pam+',this.value,'+elementValidate['Reload']+','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
                                      //  var reload = elementValidate['Reload'] +','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
                                        var IsMandatory=elementValidate['IsMandatory'];
                                        var DisplayAttributeName=elementValidate['DisplayAttributeName'];
                                        var mandateFunction ='';
                                         if(IsMandatory==1){
                                         var mandateFunction = 'MandatoryValue(this.id,this.value,'+'\''+DisplayAttributeName+'\');';
                                         }
                                         else{
                                          var mandateFunction =''; 
                                         }
                             var inpOnBlur ='';        
                             elementValidate['AllowedCharacter'] = addslashes(elementValidate['AllowedCharacter']);
                             elementValidate['NotAllowedCharacter'] = addslashes(elementValidate['NotAllowedCharacter']);
                     if(elementValidate['ControlName']=='TextBox'){
                         inpOnBlur =' onblur="checkLength(this,'+atributeId+','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+nxtSeq+','+elementValidate['MinLength']+'); '+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');" maxlength="'+elementValidate['MaxLength']+'" minlength="'+elementValidate['MinLength']+'"';   
                     }else if(elementValidate['ControlName']=='DropDownList'){
                         inpOnBlur =' onblur="'+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');"';   
                     }
                        //alert(inpOnBlur);
                        //onblur="NumbersOnly(this.id, this.value,'', '', '', 'null');" maxlength="null" minlength="null"
                    if(element['ControlName']=='TextBox')
                        toappendData +='<input '+inpOnBlur+' type="text" class="wid-100per inputsubGrp_'+groupId+'_'+subgrpId+' form-control doOnBlur '+dbClass+'" id="' + inpId + '"  name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;
                    if(element['ControlName']=='MultiTextBox') {
                    toappendData += '<textarea id=COpyTeXt_' + atributeId + '_' + nxtSeq + ' readonly="readonly" class="wid-100per inputsubGrp_'+groupId+'_'+subgrpId+' form-control"></textarea>';
                    if(element['Options'] != ''){
                        var inpName = 'ProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq+'[]';
                        toappendData +='<select multiple="true" '+inpOnBlur+' class="wid-100per inputsubGrp_'+groupId+'_'+subgrpId+' testmulti doOnBlur UpdateFields removeinputclass"  id="' + inpId + '" name="' + inpName + '" >';

                    jQuery.each(element['Options'], function (i, val) {
                        toappendData +='<option value="'+val+'">'+val+'</option>';
                    });
                    toappendData +='</select>';
                    } else {
                        toappendData +='<textarea '+inpOnBlur+' class="wid-100per inputsubGrp_'+groupId+'_'+subgrpId+' form-control doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"></textarea>' ;
                    }
                }
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input '+inpOnBlur+' type="checkbox" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '"  onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> Yes '+
                                        '<input value="No" type="radio" style="position:static" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select '+inpOnBlur+' onchange = '+reload+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'"  id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                    toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
                    '</div></div>' +
                    '<div class="col-md-2 form-text"><div class="form-group comments">' +
                    '<textarea '+inpOnBlur+' rows="1" cols="50" class="form-control '+dbClass_cmd+'" id="" name="' + commendName + '" placeholder="Comments"></textarea>' +
                    '</div></div>' +
                    '<div class="col-md-3 form-status"><div class="form-group status">' +
                    '<select '+inpOnBlur+' id="" name="' + selName + '" class="form-control CampaignWiseSelDone_' + groupId + ' subGrpDisp_'+groupId+'_'+subgrpId+' dispositionSelect '+dbClass_dis+'">' +
                    '<option value="">--</option>' +
                    '<option value="A">A</option>' +
                    '<option value="D">D</option>' +
                    '<option value="M">M</option>' +
                    '<option value="V">V</option>' +
                    '</select>' +
                    '<div><i class="fa fa-minus-circle remove-field m-r-10" style="padding:5px;" data="' + atributeId + '"></i></div></div>' +
                    '</div></div>';

            $('.add_' + atributeId).append(toappendData);
            $('.ShowingSeqDiv_' + atributeId).attr("data", nxtSeq);

            Load_totalAttInThisGrpCnt();
                    $('.testmulti').fSelect();
           //  checkAll(groupId,subgrpId);
        }
		
        function addSubgrpAttribute(subgrpId,groupId){
            

             var a = [];
            
           
             //alert('<?php //echo json_encode($AttributesListGroupWise); ?>');
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            //var subGrpArrValidate='<?php echo str_replace("'", "\\'", json_encode($validate))?>';
            var subGrpArrValidate='<?php echo stripslashes(json_encode($validate))?>';
            var subGrpAttValidate = JSON.parse(subGrpArrValidate);
			console.log(subGrpAtt);
			console.log(groupId);
			console.log(subgrpId);			
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
            var groupName = 'Organization Status';
              
            var maxSeqCnt = $('.GroupSeq_' + subgrpId).attr("data");
            maxSeq='<?php echo json_encode($maxSeq);?>';
            maxSeqArr=JSON.parse(maxSeq);
            //maxSeqCnt=1;
       
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            
        
            
            var prodDep='<?php echo $DependentMasterIds['ProductionField']; ?>';
            var cmdDep='<?php echo $DependentMasterIds['Comments']; ?>';
            var disDep='<?php echo $DependentMasterIds['Disposition']; ?>';
            if(nxtSeq<=maxSeqArr[prodDep])
                var dbClass='UpdateFields';
            else
                var dbClass='InsertFields';
            if(nxtSeq<=maxSeqArr[cmdDep]) 
                var dbClass_cmd='UpdateFields';
            else
                var dbClass_cmd='InsertFields';
            
            if(nxtSeq<=maxSeqArr[disDep]) 
                var dbClass_dis='UpdateFields';
            else
                var dbClass_dis='InsertFields';
            var FirstAttrId =$("#FirstAttrGroup_"+subgrpId+""+groupId+"").val();
            

            toappendData = '<div ><font style="color:#62A8EA">Page : <b>' + nxtSeq + '</b></font><a id = "' + subgrpId + '_' +groupId+ '_' +nxtSeq+ '" class="pull-right rent-icon" href="" onclick="Rentcalc('+FirstAttrId+',<?php echo $DependentMasterIds["ProductionField"];?>,<?php echo $DependentMasterIds["Comments"]; ?>,<?php echo $DependentMasterIds["Disposition"]; ?>,'+subgrpId+','+groupId+','+nxtSeq+');" data-target="#rentmodalAll" data-toggle="modal"><img src="images/rent.png" width="25" height="25"></a><i class="fa fa-minus-circle removeGroup-field pull-right" data="' + subgrpId + '" style="top:10px"></i><br>';			

            $.each(subGrpAttArr, function (key, element) {
                //alert (JSON.stringify(element));
                atributeId = element['AttributeMasterId'];
                ProjAttributeId = element['ProjectAttributeMasterId'];
                var elementValidate = subGrpAttValidate[ProjAttributeId];
                 var inpId = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
                var inpName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
                var commendName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
                var selName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
                
                
                //alert(inpName);
				
				var pam = element['ProjectAttributeMasterId'];
                                var reload = 'LoadValue('+pam+',this.value,'+elementValidate['Reload']+','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
				//  var reload = elementValidate['Reload'] +','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
                                var IsMandatory=elementValidate['IsMandatory'];
                                        var DisplayAttributeName=elementValidate['DisplayAttributeName'];
                                        var mandateFunction ='';
                                         if(IsMandatory==1){
                                         var mandateFunction = 'MandatoryValue(this.id,this.value,'+'\''+DisplayAttributeName+'\');';
                                         }
                                          else{
                                          var mandateFunction =''; 
                                         }
                             var inpOnBlur ='';
                             elementValidate['AllowedCharacter'] = addslashes(elementValidate['AllowedCharacter']);
                             elementValidate['NotAllowedCharacter'] = addslashes(elementValidate['NotAllowedCharacter']);
                     if(elementValidate['ControlName']=='TextBox'){
                         inpOnBlur =' onblur="checkLength(this,'+atributeId+','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+nxtSeq+','+elementValidate['MinLength']+'); '+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');" maxlength="'+elementValidate['MaxLength']+'" minlength="'+elementValidate['MinLength']+'"';   
                     }else if(elementValidate['ControlName']=='DropDownList'){
                         inpOnBlur =' onblur="'+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');"';   
                     }
				
                toappendData += '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important"  class=" row form-responsive clearfix MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                        '<div class="col-md-3 form-title"><div class="form-group" style=""><p>' + element['DisplayAttributeName'] + '</p></div></div>' +
                        '<div class="col-md-4 form-text"><div class="form-group">' ;
                if(element['ControlName']=='TextBox')
                        toappendData +='<input '+inpOnBlur+' type="text" class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;
//-------->>>>>>>>>>>>Onload MultiText Box<<<<<<<<<<<-----------
		if(element['ControlName']=='MultiTextBox') {
                    toappendData += '<textarea id=COpyTeXt_' + atributeId + '_' + nxtSeq + ' readonly="readonly" class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control"></textarea>';
                    if(element['Options'] != ''){
                        var inpName = 'ProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq+'[]';
                        toappendData +='<select multiple="true" '+inpOnBlur+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per testmulti doOnBlur UpdateFields removeinputclass hidden"  id="' + inpId + '" name="' + inpName + '" >';

                    jQuery.each(element['Options'], function (i, val) {
                        toappendData +='<option value="'+val+'">'+val+'</option>';
                    });
                    toappendData +='</select>';
                    } else {
                        toappendData +='<textarea '+inpOnBlur+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"></textarea>' ;
                    }
                }if(element['ControlName']=='CheckBox')
                        toappendData +='<input '+inpOnBlur+' type="checkbox" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input '+inpOnBlur+' value="Yes" type="radio" style="position:static"  class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur InsertFields" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> Yes '+
                                        '<input '+inpOnBlur+' value="No" type="radio" style="position:static"  class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur InsertFields" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select '+inpOnBlur+' onchange='+reload+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'"  id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                       
                       
                        toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
                        '</div></div>' +
                        '<div class="col-md-2 form-text"><div class="form-group comments">' +
                        '<textarea '+inpOnBlur+' rows="1" cols="50" class="form-control '+dbClass_cmd+'" id="" name="' + commendName + '" placeholder="Comments"></textarea>' +
                        '</div></div>' +
                        '<div class="col-md-3 form-status"><div class="form-group status">' +
                        '<select '+inpOnBlur+' id="" name="' + selName + '" class="form-control CampaignWiseSelDone_' + groupId + ' subGrpDisp_'+groupId+'_'+subgrpId+' dispositionSelect '+dbClass_dis+'">' +
                        '<option value="">--</option>' +
                        '<option value="A">A</option>' +
                        '<option value="D">D</option>' +
                        '<option value="M">M</option>' +
                        '<option value="V">V</option>' +
                        '</select>' +
                        '</div>' +
                        '</div></div>';

            });

            toappendData += '</div>';
            //alert(toappendData);
            $('.addGrp_' + subgrpId).append(toappendData);
            $('.GroupSeq_' + subgrpId).attr("data", nxtSeq);

            Load_totalAttInThisGrpCnt();
                    $('.testmulti').fSelect();
       //  checkAll(groupId,subgrpId);
        }
        
            
//            $( ".page-title" ).bind( "dblclick", function() {
//                var sel = (document.selection && document.selection.createRange().text) ||
//                          (window.getSelection && window.getSelection().toString());
//                $(AttrcopyId).val(sel);
//            });
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
				//	alert(result);
                    if (result != '' && result != null) {
                        $('.CntBadge').hide();
                        var obj = JSON.parse(result);

                        if (obj['attrinitialhtml'] != '' && obj['attrinitialhtml'] != null) {
							
                            $('#exampleTabsOne').show();
                            var htmlfileinitial = "<?php echo HTMLfilesPath; ?>" + obj['attrinitialhtml'];
							//alert(htmlfileinitial);
							//htmlfileinitial='SH_SH_US017P01-Lease.pdf';
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
            
//            $('#attrGroupId').val(FirstGroupId);
//                $('#attrSubGroupId').val(FirstSubGroupId);
//                $('#attrId').val(FirstAttrId);
//                $('#ProjattrId').val(FirstProjAttrId);
//                $('#seq').val(sequence);
                 });
//            $.ajax({
//                type: "POST",
//                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxLoadfirstattribute')); ?>",
//                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, Attr: FirstAttrId, ProjAttr: FirstProjAttrId, MainGrp: FirstGroupId, SubGrp: FirstSubGroupId}),
//                dataType: 'text',
//                async: true,
//                success: function (result) {
//                    $('#prodInput_' + FirstAttrId).focus();
//                    var obj = JSON.parse(result);
//
//                    //obj['attrinitialhtml']='1.html';
//
//                    if (obj['attrinitialhtml'] != '' && obj['attrinitialhtml'] != null) {
//
////                            $('#exampleTabsOne').show();
////                            var htmlfileinitial = "<?php echo HTMLfilesPath; ?>" + obj['attrinitialhtml'];
////                            document.getElementById('frame1').data = htmlfileinitial;
//
//                        var object = document.getElementById("frame1");
//
//                        object.onload = function () {
//                            //spanArr = $("object").contents().find('span');
//                            $("object").contents().find('.annotated').each(function () {
//                                var $span = $(this);
//                                var spanId = $span.attr('data');
//                                if (typeof (spanId) != "undefined" && spanId !== null && $(this).text() != '') {
//                                    $span.attr('onClick', "parent.focusProjeId('" + spanId + "');");
//                                }
//                            });
//                        };
//
//                        //      $('#prodInput_' + FirstAttrId).focus();
//
//
//                    } else if (obj['attrinitiallink'] != '' && obj['attrinitiallink'] != null) {
//
////                            $('#exampleTabsOne').show();
////                            document.getElementById('frame1').data = obj['attrinitiallink'];
//                        //  $('#prodInput_' + FirstAttrId).focus();
//                    }
//                }
//            });
            // loadWebpage(FirstAttrId, FirstProjAttrId, FirstGroupId, FirstSubGroupId, sequence, 0);
       

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
            ;
            $("#exampleAccordionContinuous>div>div.in").attr("aria-expanded", "false");
            ;
            $("#exampleAccordionContinuous>div>div.in").removeClass("in");



            $("#" + mainGrp).attr("aria-expanded", "true");
            $('#' + mainGrp).removeClass("collapsed");
            var href = $("#" + mainGrp).attr("href");
            $(href).attr("aria-expanded", "true");
            $(href).addClass("in");
            //$(href).attr( "style:4500!important" );
            depen='<?php echo $dependency; ?>';
            //alert(depen);
            document.getElementById('ProductionFields_'+proKey+'_'+depen+'_1').focus();
            $(href).height("auto");
            loadWebpage(proKey, projattr, mainGrp, subgroup, sequence, 0);

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
                            loadWebpage(attrid, Projattrid, attrGrpid, attrSubGrpid, sequence, 1);
                            loadReferenceUrl();

                        }
                    }
                });
                $('#addnewurl').hide();
            }
        });

        $('.multi-field-wrapper').each(function () {
            var $wrapper = $('.multi-fields', this);
            var $i = 1;
            $(".add-field", $(this)).click(function (e) {

                var AttrMasterId = document.getElementById("add-field").title;
                //                alert(AttrMasterId);
                $('.multi-field:last-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
                $('#prodInput_' + AttrMasterId).attr('id', 'prodInput_' + AttrMasterId + '_' + $i);
                $('#prodComments_' + AttrMasterId).attr('id', 'prodComments_' + AttrMasterId + '_' + $i);
                $('#prodStatus_' + AttrMasterId).attr('id', 'prodStatus_' + AttrMasterId + '_' + $i);
                $('#branch_inputvalue_' + AttrMasterId).attr('id', 'branch_inputvalue_' + AttrMasterId + '_' + $i);
                $('#prodInput_' + AttrMasterId).val('');
                $('#prodComments_' + AttrMasterId).val('');
                $('#prodStatus_' + AttrMasterId).val(0);
                $('#branch_inputvalue_' + AttrMasterId).empty();

                //                var spans = $('.lighttext');
                //                var spans = $('#branch_inputvalue_'+$i);
                //                spans.text(''); // clear the text
                //                spans.hide(); // make them display: none
                //                spans.remove(); // remove them from the DOM completely
                //                spans.empty();  // remove all their content

                $i++;
            });
            $('.multi-field .remove-field', $wrapper).click(function () {
                if ($('.multi-field', $wrapper).length > 1)
                    $(this).parent('.multi-field').remove();
            });

        });




        // Script for Add/Remove Ends

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

//            if (attr == attrid && Projattrid == projattr && attrGrpid == maingroup && attrSubGrpid == subgroup && val == 0 && (sequence == seq || sequence == 0)) {
//                return false;
//            } else {
                //   $('#exampleTabsOne').hide();
                //$('#exampleTabsTwo').hide();
                $('#multiplelinkbutton').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetafterreferenceurl')); ?>",
                    data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, Attr: attr, ProjAttr: projattr, MainGrp: maingroup, SubGrp: subgroup, seq: seq}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {

                        //   $('#exampleTabsOne').hide();
                        //   $('#exampleTabsTwo').hide();
                        $("#LoadAttrValue").empty();
						//alert('test');
                        //$('#exampleTabsOne').hide();
                        //$('#exampleTabsTwo').hide();
                        //$("#LoadAttrValue").empty();

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
//                                            var htmlfile = element['HtmlFileName'];
//                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
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
//                                if (val != 1) {
//                                    if (obj['attrinitialhtml'] != '' && obj['attrinitialhtml'] != null) {
//                                        $('#exampleTabsOne').show();
//
//                                        var htmlfileinitial = "<?php echo HTMLfilesPath; ?>" + obj['attrinitialhtml'];
//                                        document.getElementById('frame1').data = htmlfileinitial;
//                                    } else if (obj['attrinitiallink'] != '' && obj['attrinitiallink'] != null) {
//                                        $('#exampleTabsOne').show();
//
//                                        document.getElementById('frame1').data = obj['attrinitiallink'];
//                                    }
//                                }
//							if (typeof obj['attrcnt'] !== 'undefined' && obj['attrcnt'] != null) {
//								obj['attrcnt'].forEach(function (element) {
//
//									if (element['cnt'] > 0) {
//										$('#CntBadge_' + element['AttributeMainGroupId']).show();
//										$('#CntBadge_' + element['AttributeMainGroupId']).text(element['cnt']);
//										//document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = ;
//									}
//
//								});
//							}
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
          //  }

        }

        function DeleteUrl(attr, projattr, maingroup, subgroup, id) {

            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();
            var sequence = $('#seq').val();

            var getConform = confirm("Are You Sure you want to Delete?");
            if (getConform) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxdeletereferenceurl')); ?>",
                    data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, Attr: attr, ProjAttr: projattr, MainGrp: maingroup, SubGrp: subgroup, Id: id, Seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result === 'Deleted') {
                            //alert("Deleted Successfully");
                            loadWebpage(attr, projattr, maingroup, subgroup, sequence, 1);
                            loadReferenceUrl();
                        }
                    }
                });
                return true;
            } else {
                return false;
            }

        }

        function loadPDF(file)
        {
            $('#exampleTabsOne').show();
            $('#refUrl').val(file);
           // var cookieValue = anchor.getAttribute('value');
//           var cookieValue = file;
//
//            var htmlfile = "<?php echo HTMLfilesPath; ?>" + cookieValue;
//            document.getElementById('frame1').data = htmlfile;

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
                        if (result != '' && result != null) {
                             $('.CntBadge').hide();
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
                            
                            var obj = JSON.parse(result);
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
                            checkAllUrlAtt(sequence);
            }
        }
                });
            }
        }
		
		function checkAllUrlAtt(Seq=1){
               
			//alert(gotattributeids);
			$('.subgroupparentdivs').show();  
		    $('.commonClass').show(); 
		    $('.commonClass').removeClass("myyourclass");
			 var sat = $("#chk-wid-Url").prop("checked");
			 if(sat)  {
				 //alert('dfdf');
				//$('.commonclass_'+gotattributemaingrpid).hide(); 
				if (gotattributeids.length > 0) {
					$('.commonClass').hide(); 
					gotattributeids.forEach(function (element) {
						//alert(element['AttributeMasterId']);
						if (element['AttributeMasterId'] > 0) {
                                                   
							$('#groupAttr_' + element['AttributeMasterId']+'_'+Seq).css("display", "block");
                                                            $('#groupAttr_' + element['AttributeMasterId']+'_'+Seq).addClass("myyourclass");
						}
					});
					
					//$(".subgroupparentdivs_"+gotattributemaingrpid).each(function() {
					$(".subgroupparentdivs").each(function() {
						var count = $(this).find(".myyourclass").length;
						if(count<=0) {
							$(this).hide();
						}
					});
				}
				
			}
			else {
				  $('.subgroupparentdivs').show();  
				  $('.commonClass').show();  
			}
                        ShowUnVerifiedAtt(Seq);
		}
		function checkAllUrlAttPaginate(subgrp,Seq=1){
		
			//alert(gotattributeids);
			//$('.subgroupparentdivs').show();  
		    $( "#MultiSubGroup_" + subgrp + "_" + Seq ).has('.commonClass').show(); 
		    $( "#MultiSubGroup_" + subgrp + "_" + Seq ).has('.commonClass').removeClass("myyourclass");
			 var sat = $("#chk-wid-Url").prop("checked");
			 if(sat)  {
				 //alert('dfdf');
				//$('.commonclass_'+gotattributemaingrpid).hide(); 
				if (gotattributeids.length > 0) {
					$( "#MultiSubGroup_" + subgrp + "_" + Seq > '.commonClass').hide(); 
                                        
                                        
					gotattributeids.forEach(function (element) {
						//alert(element['AttributeMasterId']);
						if (element['AttributeMasterId'] > 0) {
                                                    
                                                    if($( "#MultiSubGroup_" + subgrp + "_" + Seq ).has('#groupAttr_' + element['AttributeMasterId']+'_'+Seq).length) {
							    $('#groupAttr_' + element['AttributeMasterId']+'_'+Seq).css("display", "block");
                                                            $('#groupAttr_' + element['AttributeMasterId']+'_'+Seq).addClass("myyourclass");
                                                        }
						}
					});
					$(".subgroupparentdivs").each(function() {
						var count = $(this).find(".myyourclass").length;
						if(count<=0) {
							$(this).hide();
						}
					});
					//$(".subgroupparentdivs_"+gotattributemaingrpid).each(function() {
					
				}
				
			}
			else {
				  $('.subgroupparentdivs').show();  
				  $('.commonClass').show();  
			}
		}
                function ShowUnVerifiedAtt(Seq) {
                    var projectid = $('#ProjectId').val();
                    var regionid = $('#RegionId').val();
                    var inputentityid = $('#InputEntityId').val();
                    var prodentityid = $('#ProductionEntity').val();
                    var sequence = $('#seq').val();
					//alert(sequence);
                    var unverified = $("#chk-wid-Url2").prop("checked");
                    var subgroup='<?php echo json_encode($AttributeSubGroupMasterJSON); ?>';       
                    var subgrpArr=JSON.parse(subgroup);
                    var distinct='<?php echo json_encode($distinct)?>';
                    var distinctArr=JSON.parse(distinct);
                    //alert(distinct);
                    obj=[];i=0;objAttr=[];j=0;objshowAttr=[];k=0;
                    var sat = $("#chk-wid-Url").prop("checked");
                   
                        if(sat) {
                                $('.myyourclass').find('.dispositionSelect').each(function() {
                                    
                                var selectedId=$(this).attr('id')
                                
                                var selected = $('#'+selectedId).find(":selected").text();
                                var selectedIdArr=selectedId.split('_');
                                var distMatch=jQuery.inArray( selectedIdArr[1], distinctArr )
                                if(distMatch==-1)
                                {
                                  if (selected != "--") {
                                     objAttr[j]=selectedIdArr[2];
                                     j++;
                                    }
                                    else {
                                        objshowAttr[k]=selectedIdArr[2];
                                        k++;
                                    }
                                }
                                else{
                                    if (selected == "--") {
                                        obj[i]=selectedIdArr[1];
                                        i++;
                                    }
                                }
                                }); 
                            
                            }
                            else {
                               $('.dispositionSelect').each(function() {
                                var selectedId=$(this).attr('id')
                               // alert(selectedId);
                                var selected = $('#'+selectedId).find(":selected").text();
                                var selectedIdArr=selectedId.split('_');
                                var distMatch=jQuery.inArray( selectedIdArr[1], distinctArr )
                                if(distMatch==-1)
                                {
                                  if (selected != "--") {
                                     objAttr[j]=selectedIdArr[2];
                                     j++;
                                    }
                                    else {
                                        objshowAttr[k]=selectedIdArr[2];
                                        k++;
                                    }
                                }
                                else{
                                    if (selected == "--") {
                                        obj[i]=selectedIdArr[1];
                                        i++;
                                    }
                                }
                                }); 
                            }
                          
                                $.unique(obj);
                                $.unique(objAttr);
                                  //alert(JSON.stringify(obj));
                                   if(unverified){
                                $.each( subgrpArr, function( key, value ) {
                                    $.each( value, function( key2, value2 ) {
                                        var keyMatch=jQuery.inArray( key2, obj )
                                        var distMatch3=jQuery.inArray( key2, distinctArr )
                                        if(distMatch3!=-1) {
                                       
                                        if(keyMatch==-1 )
                                           {
                                             $( "#MultiSubGroup_" + key2 + "_" + sequence).css("display", "none");
                                             $( "#MultiSubGroup_" + key2 + "_" + sequence).removeClass("showFilled");
                                            }
                                            else{
                                                    $( "#MultiSubGroup_" + key2 + "_" + sequence).css("display", "block");
                                                     $( "#MultiSubGroup_" + key2 + "_" + sequence).addClass("showFilled");
                                                }
                                                
                                            }
                                            });
                                        });
                                        
                                        
                                 $.each(objAttr,function(key,value){
                                        $( "#MultiField_" + value + "_" + sequence).css("display", "none");
                                             $( "#MultiField_" + value + "_" + sequence).removeClass("showFilled");
                                        }
                                 );       
                                $.each(objshowAttr,function(key,value){
                                        $( "#MultiField_" + value + "_" + sequence).css("display", "block");
                                             $( "#MultiField_" + value + "_" + sequence).addClass("showFilled");
                                        }
                                 );
                                   
                                $(".subgroupparentdivs").each(function() {
                                    var count = $(this).find(".showFilled").length;
                                    if(count<=0) {
    					$(this).hide();
                                    }
                                    else {
                                        $(this).show();
                                    }
                                    });
                            }
                            else {
                                    $.each( subgrpArr, function( key, value ) {
                                    $.each( value, function( key2, value2 ) {
                                        $( "#MultiSubGroup_" + key2 + "_" + sequence).css("display", "block");
                                        $( "#MultiSubGroup_" + key2 + "_" + sequence).addClass("showFilled");
                                     });
                                    }); 
                                    $(".subgroupparentdivs").each(function() {
                                        $(this).css("display", "block");
                                        });
                                    
                                    if(sat)  {
                                            $(".subgroupparentdivs").each(function() {
                                        var count = $(this).find(".myyourclass").length;
                                        if(count<=0) {
                                        $(this).hide();
                                        }
                                        });
                                    }
                                    
                                    $.each(objAttr,function(key,value){
                                        $( "#MultiField_" + value + "_" + sequence).css("display", "block");
                                             $( "#MultiField_" + value + "_" + sequence).addClass("showFilled");
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
//                                    if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
//                                        var htmlfile = element['HtmlFileName'];
//                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,0);"  class="current text-center text update-cart info_link">' + element['AttributeValue'].substring(0, 45) + '</a>';
//                                    } else if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title="' + element['AttributeValue'] + '" value="' + element['AttributeValue'] + '" id="' + element['AttributeValue'] + '" onclick="loadPDFUrl(this.id);" class="current text-center text">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                  //  }
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

        // load next attribute
        function loadMultiField(action, attributeMasterId, totalseq) {
            var currentSeq = $(".ShowingSeqDiv_" + attributeMasterId + "").val();
            var nex = parseInt(currentSeq) + 1;
            var prev = parseInt(currentSeq) - 1;

    
           if (currentSeq == totalseq){
                $('.i_next_' + attributeMasterId).css('color', 'grey');
                }
            else{
                $('.i_next_' + attributeMasterId).css('color', '#4397e6');
                }

            
            if (currentSeq == 1){
                    $('.i_previous_' + attributeMasterId).css('color', 'grey');
                }
                else{
                $('.i_previous_' + attributeMasterId).css('color', '#4397e6');
                }



            if (action == 'i_next' && totalseq >= nex) {
                //$(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + currentSeq).hide();
                $("#MultiField_" + attributeMasterId + "_" + nex).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(nex);

             if (nex == totalseq)
                    $('.i_next_' + attributeMasterId).css('color', 'grey');
                else
                    $('.i_next_' + attributeMasterId).css('color', '#4397e6');

                if (nex == 1)
                    $('.i_previous_' + attributeMasterId).css('color', 'grey');
                else
                    $('.i_previous_' + attributeMasterId).css('color', '#4397e6');

            }

            if (action == 'i_previous' && totalseq >= prev && prev > 0) {
                //$(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + currentSeq).hide();
                $("#MultiField_" + attributeMasterId + "_" + prev).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(prev);
                
                if (prev == totalseq)
                    $('.i_next_' + attributeMasterId).css('color', 'grey');
                else
                    $('.i_next_' + attributeMasterId).css('color', '#4397e6');

                if (prev == 1)
                    $('.i_previous_' + attributeMasterId).css('color', 'grey');
                else
                    $('.i_previous_' + attributeMasterId).css('color', '#4397e6');
                
            }
        }

        function Paginate(action, subgrp, totalseq) {
            var currentSeq = $(".GroupSeq_" + subgrp + "").val();
            var nex = parseInt(currentSeq) + 1;
            var prev = parseInt(currentSeq) - 1;

            //tot =3
            //current 1
            //prev 0
            //next 2
            if (currentSeq == totalseq)
                $('#next_' + subgrp).css('color', 'grey');
            else
                $('#next_' + subgrp).css('color', '#4397e6');

            if (currentSeq == 1)
                $('#previous_' + subgrp).css('color', 'grey');
            else
                $('#previous_' + subgrp).css('color', '#4397e6');

            if (action == 'next' && totalseq >= nex) {


                // alert(nex+'nex');
                $("#MultiSubGroup_" + subgrp + "_" + currentSeq).hide();
                $("#MultiSubGroup_" + subgrp + "_" + nex).show();
                $(".GroupSeq_" + subgrp + "").val(nex);
                if (nex == totalseq)
                    $('#next_' + subgrp).css('color', 'grey');
                else
                    $('#next_' + subgrp).css('color', '#4397e6');
                if (nex == 1)
                    $('#previous_' + subgrp).css('color', 'grey');
                else
                    $('#previous_' + subgrp).css('color', '#4397e6');


            }

            if (action == 'previous' && totalseq >= prev && prev > 0) {

                $("#MultiSubGroup_" + subgrp + "_" + currentSeq).hide();
                $("#MultiSubGroup_" + subgrp + "_" + prev).show();
                $(".GroupSeq_" + subgrp + "").val(prev);

                if (prev == totalseq)
                    $('#next_' + subgrp).css('color', 'grey');
                else
                    $('#next_' + subgrp).css('color', '#4397e6');

                if (prev == 1)
                    $('#previous_' + subgrp).css('color', 'grey');
                else
                    $('#previous_' + subgrp).css('color', '#4397e6');
            }
              currentSeq = $(".GroupSeq_" + subgrp + "").val();
			  
			 $('#CurSeq').val(currentSeq);
            checkAllUrlAttPaginate(subgrp,currentSeq);
            
        }

        function formSubmit() {
<?php /* if(isset($Mandatory)) {
  $js_array = json_encode($Mandatory);
  echo "var mandatoryArr = ". $js_array . ";\n";
  } */ ?>
            /*var mandatary = 0;
             if (typeof mandatoryArr != 'undefined') {
             $.each(mandatoryArr, function (key, elementArr) {
             element = elementArr['AttributeMasterId']
             
             if ($('#' + element).val() == '') {
             // alert(($('#' + element).val()));
             alert('Enter Value in ' + elementArr['DisplayAttributeName']);
             $('#' + element).focus();
             mandatary = '1';
             return false;
             }
             });
             }
             if (mandatary == 0) {
             AjaxSave('');
             return true;
             } else {
             return false;
             }*/
			 
			 
               
                    
			 
			var ret = true;
            ret = AjaxSave('');
			$(".removeinputclass").remove();
                       
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
			TimeTaken = $("#TimeTaken").val();
            $("#save_btn").html("Please wait! Saving...");
            var status = "<?php echo $productionjob['StatusId']; ?>";
            //$("#save_btn").attr("disabled", "disabled");
            
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxsave')); ?>",
                data: ({Updatedata: Updatedata, Inputdata: Inputdata, ProjectId: ProjectId, RegionId: RegionId, ProductionEntityID: ProductionEntityID, InputEntityId: InputEntityId, StatusId: status,TimeTaken:TimeTaken}),
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
//    function LoadPDF(file)
//    {
//        document.getElementById('frame').src = file;
//        $("body", myWindow.document).find('#pdfframe').attr('src', file);
//    }
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
    function Load_totalAttInThisGrpCnt() {
        $('.CampaignWiseMainDiv').each(function (i, obj) {
            var mainGrpId = $(this).attr("data");
            var count = $('.CampaignWiseFieldsDiv_' + mainGrpId).length;
            var countDone = $('.CampaignWiseSelDone_' + mainGrpId).filter(function () {
                if ($(this).val() != "")
                    return $(this).val();
            }).length;
            $('#totalAttInThisGrpCnt_' + mainGrpId).html(count);
            $('#currentADMVDoneCnt_' + mainGrpId).html(countDone);
        });
    }

   function Load_verifiedAttrCnt(thisObj) {
        
        var closestDisVal = thisObj.parent().parent().parent().find(".dispositionSelect").val();
        //if(closestDisVal=="") {
       // var thisinpuval = thisObj.val().toLowerCase();
        var ElementType=thisObj.is(':radio');
        //alert(ElementType);
        
        if(thisObj.is(':radio')){
             var thisinpuval =   thisObj.filter(':checked').val();
             if(typeof thisinpuval=='undefined')
                 thisinpuval='';
        }
        
        else
		var thisinpuval = thisObj.val();
            
           
       // var spaninpuval = thisObj.parent().find('.lighttext').text().toLowerCase();
		var spaninpuval = thisObj.parent().find('.lighttext').text();

//alert(thisinpuval+'-'+spaninpuval);
        if (spaninpuval === thisinpuval && spaninpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('V');
        }

        if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('M');
        }

        if (spaninpuval != thisinpuval && spaninpuval == "" && thisinpuval != "" ) {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('A');
        }
		
	if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval == "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('D');
        }
            
        if (spaninpuval == "" && thisinpuval == "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('');
        }
        //}
    }
    
    function Load_verifiedAttrCnt_forselect(thisObj) {
        var closestDisVal = thisObj.parent().parent().parent().parent().find(".dispositionSelect").val();
        var thisinpuval = thisObj.val();
         
        if(thisinpuval != null){
        var thisinpuval = thisObj.val().join(',');
       
   }
   else{
       var thisinpuval = thisObj.val();
   }
  
       // var spaninpuval = thisObj.parent().find('.lighttext').text().toLowerCase();
		var spaninpuval = thisObj.parent().next('.lighttext').text();
        if (spaninpuval === thisinpuval && spaninpuval != "") {
            thisObj.parent().parent().parent().parent().find(".dispositionSelect").val('V');
        }

        if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval != "") {
            thisObj.parent().parent().parent().parent().find(".dispositionSelect").val('M');
        }

        if (spaninpuval != thisinpuval && spaninpuval == "" && thisinpuval != "" ) {
            thisObj.parent().parent().parent().parent().find(".dispositionSelect").val('A');
        }
		
		if (spaninpuval != thisinpuval && spaninpuval != "" && (thisinpuval == "" || thisinpuval == null)) {
            thisObj.parent().parent().parent().parent().find(".dispositionSelect").val('D');
        }
  if (spaninpuval == "" && (thisinpuval == "" || thisinpuval == null)) {
            thisObj.parent().parent().parent().parent().find(".dispositionSelect").val('');
        }
    }

    function getJob()
    {
        window.location.href = "Getjobcore?job=newjob";
    }
    

    $(document).ready(function () {
		
		$('input[type="text"].form-control').keypress(function(){
			$(this).removeClass('text-danger');
		});
		
		$('input[type="text"].form-control').change(function(){
			$(this).removeClass('text-danger');
		});
		
        Load_totalAttInThisGrpCnt();

        $(document).on("blur", ".doOnBlur", function (e) {
            AttValue = $(this).val();
                    Attname=$(this).attr("name");
                  
                    localStorage.setItem(Attname, AttValue);
			//alert('dfdf');
            Load_verifiedAttrCnt($(this));
            Load_totalAttInThisGrpCnt();
        });

        $(document).on("change", ".dispositionSelect", function (e) {
            AttValue = $(this).val();
                    Attname=$(this).attr("name");
                  
                    localStorage.setItem(Attname, AttValue);
            Load_totalAttInThisGrpCnt();
        });

        $(document).on("click", ".remove-field", function (e) {
            var atributeId = $(this).attr("data");
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt);
            $( "#MultiField_"+atributeId+"_"+maxSeqCnt ).remove();
           // $(this).parent().remove();
            Load_totalAttInThisGrpCnt();

            var nxtSeq = nxtSeq - 1;
            $('.ShowingSeqDiv_' + atributeId).attr("data", nxtSeq);
        });
        $(document).on("click", ".removeGroup-field", function (e) {
            var groupId = $(this).attr("data");

            var maxSeqCnt = $('.GroupSeq_' + groupId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt);


            
            $(this).parent().remove();
            Load_totalAttInThisGrpCnt();

            var nxtSeq = nxtSeq - 1;



            $('.GroupSeq_' + groupId).attr("data", nxtSeq);
        });
        
        $('.addAttribute').on('click', function () {
         
        
            var a = [];
            
            if(localStorage.getItem('attradd')!=null)
            a =JSON.parse(localStorage.getItem('attradd'));
            var localStore = {'data':$(this).attr("data"),'ProjAttributeId':$(this).attr("data-ProjAttrId"),'groupId':$(this).attr("data-groupId"),'subgrpId':$(this).attr("date-subgrpId"),'groupName':$(this).attr("data-groupName")};
            a.push(localStore);
            localStorage.setItem('attradd', JSON.stringify(a));
            
            
            var atributeId = $(this).attr("data");
            var ProjAttributeId = $(this).attr("data-ProjAttrId");
            var groupId = $(this).attr("data-groupId");
            var subgrpId = $(this).attr("date-subgrpId");
            
             var selectedText = $('#subgrp_' + groupId + '_'+subgrpId).find("option:selected").text();

        var groupName = $(this).attr("data-groupName");
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            //var subGrpArrValidate='<?php //echo str_replace("'", "\\'", json_encode($validate))?>';
            var subGrpArrValidate='<?php echo stripslashes(json_encode($validate))?>';
            var subGrpAttValidate = JSON.parse(subGrpArrValidate);
            var elementValidate = subGrpAttValidate[ProjAttributeId];
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
           element=[];
             $.each(subGrpAttArr, function (key, val) {
                 if(val['AttributeMasterId']==atributeId){
                     element=val;
                 }
             });
             var inpId = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var inpName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var commendName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
            var selName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
            var prodDep='<?php echo $DependentMasterIds['ProductionField']; ?>';
            var cmdDep='<?php echo $DependentMasterIds['Comments']; ?>';
            var disDep='<?php echo $DependentMasterIds['Disposition']; ?>';
             maxSeq='<?php echo json_encode($maxSeq);?>';
            maxSeqArr=JSON.parse(maxSeq);
            if(nxtSeq<=maxSeqArr[prodDep])
                var dbClass='UpdateFields';
            else
                var dbClass='InsertFields';
            if(nxtSeq<=maxSeqArr[cmdDep]) 
                var dbClass_cmd='UpdateFields';
            else
                var dbClass_cmd='InsertFields';
            
            if(nxtSeq<=maxSeqArr[disDep]) 
                var dbClass_dis='UpdateFields';
            else
                var dbClass_dis='InsertFields';
            
            //alert(nxtSeq);
            var toappendData = '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important" class="row form-responsive MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                    '<div class="col-md-3 form-title"><div class="form-group" style=""><p>' + groupName + '</p></div></div>' +
                    '<div class="col-md-4 form-text"><div class="form-group">' ;
					
		var pam = element['ProjectAttributeMasterId'];
                var reload = 'LoadValue('+pam+',this.value,'+elementValidate['Reload']+','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
                                         //var reload = elementValidate['Reload'] +','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
                                        var IsMandatory=elementValidate['IsMandatory'];
                                        var DisplayAttributeName=elementValidate['DisplayAttributeName'];
                                        var mandateFunction ='';
                                         if(IsMandatory==1){
                                         var mandateFunction = 'MandatoryValue(this.id,this.value,'+'\''+DisplayAttributeName+'\');';
                                         }
                                          else{
                                          var mandateFunction =''; 
                                         }
                             var inpOnBlur ='';
                             elementValidate['AllowedCharacter'] = addslashes(elementValidate['AllowedCharacter']);
                             elementValidate['NotAllowedCharacter'] = addslashes(elementValidate['NotAllowedCharacter']);
                     if(elementValidate['ControlName']=='TextBox'){
                         inpOnBlur =' onblur="checkLength(this,'+atributeId+','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+nxtSeq+','+elementValidate['MinLength']+'); '+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');" maxlength="'+elementValidate['MaxLength']+'" minlength="'+elementValidate['MinLength']+'"';   
                     }else if(elementValidate['ControlName']=='DropDownList'){
                         inpOnBlur =' onblur="'+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');"';   
                     }
                        //alert(inpOnBlur);
                        //onblur="NumbersOnly(this.id, this.value,'', '', '', 'null');" maxlength="null" minlength="null"
                    if(element['ControlName']=='TextBox')
                        toappendData +='<input '+inpOnBlur+' type="text" class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'" id="' + inpId + '"  name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;
                    if(element['ControlName']=='MultiTextBox') {
                    toappendData += '<textarea id=COpyTeXt_' + atributeId + '_' + nxtSeq + ' readonly="readonly" class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control"></textarea>';
                    if(element['Options'] != ''){
                        var inpName = 'ProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq+'[]';
                        toappendData +='<select multiple="true" '+inpOnBlur+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per testmulti doOnBlur UpdateFields removeinputclass"  id="' + inpId + '" name="' + inpName + '" >';

                    jQuery.each(element['Options'], function (i, val) {
                        toappendData +='<option value="'+val+'">'+val+'</option>';
                    });
                    toappendData +='</select>';
                    } else {
                        toappendData +='<textarea '+inpOnBlur+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"></textarea>' ;
                    }
                }
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input '+inpOnBlur+' type="checkbox" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '"  onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> Yes '+
                                        '<input value="No" type="radio" style="position:static" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select '+inpOnBlur+' onchange = '+reload+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'"  id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
            toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
                    '</div></div>' +
                    '<div class="col-md-2 form-text"><div class="form-group comments">' +
                    '<textarea '+inpOnBlur+' rows="1" cols="50" class="form-control '+dbClass_cmd+'" id="" name="' + commendName + '" placeholder="Comments"></textarea>' +
                    '</div></div>' + 
                    '<div class="col-md-3 form-status"><div class="form-group status">' +
                    '<select '+inpOnBlur+' id="" name="' + selName + '" class="form-control CampaignWiseSelDone_' + groupId + ' subGrpDisp_'+groupId+'_'+subgrpId+' dispositionSelect '+dbClass_dis+'">' +
                    '<option value="">--</option>' +
                    '<option value="A">A</option>' +
                    '<option value="D">D</option>' +
                    '<option value="M">M</option>' +
                    '<option value="V">V</option>' +
                    '</select>' +
                    '<div><i class="fa fa-minus-circle remove-field m-r-10" style="padding:5px;" data="' + atributeId + '"></i></div></div>' +
                    '</div></div>';
            
          
            $('.add_' + atributeId).append(toappendData);
            $('.ShowingSeqDiv_' + atributeId).attr("data", nxtSeq);

            Load_totalAttInThisGrpCnt();
                    $('.testmulti').fSelect();
            // checkAll(groupId,subgrpId);
                });

        $('.addSubgrpAttribute').on('click', function () {
            //alert('coming');
             var a = [];
            
            if(localStorage.getItem('attrgrp')!=null)
            a =JSON.parse(localStorage.getItem('attrgrp'));
            var localStore = {'subgrpId':$(this).attr("data"),'groupId':$(this).attr("data-groupId")};
            a.push(localStore);
            localStorage.setItem('attrgrp', JSON.stringify(a));
            
            var subgrpId = $(this).attr("data");
            
            var groupId = $(this).attr("data-groupId");
            //alert('<?php //echo json_encode($AttributesListGroupWise); ?>');
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            //var subGrpArrValidate='<?php echo str_replace("'", "\\'", json_encode($validate))?>';
            var subGrpArrValidate='<?php echo stripslashes(json_encode($validate))?>';
            var subGrpAttValidate = JSON.parse(subGrpArrValidate);
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
            var groupName = 'Organization Status';

            var maxSeqCnt = $('.GroupSeq_' + subgrpId).attr("data");
            maxSeq='<?php echo json_encode($maxSeq);?>';
            maxSeqArr=JSON.parse(maxSeq);
            //maxSeqCnt=1;
             // alert(maxSeqCnt);
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            
            var prodDep='<?php echo $DependentMasterIds['ProductionField']; ?>';
            var cmdDep='<?php echo $DependentMasterIds['Comments']; ?>';
            var disDep='<?php echo $DependentMasterIds['Disposition']; ?>';
            if(nxtSeq<=maxSeqArr[prodDep])
                var dbClass='UpdateFields';
            else
                var dbClass='InsertFields';
            if(nxtSeq<=maxSeqArr[cmdDep]) 
                var dbClass_cmd='UpdateFields';
            else
                var dbClass_cmd='InsertFields';
            
            if(nxtSeq<=maxSeqArr[disDep]) 
                var dbClass_dis='UpdateFields';
            else
                var dbClass_dis='InsertFields';
            
            
            toappendData = '<div ><font style="color:#62A8EA">Page : <b>' + nxtSeq + '</b></font><i id = "' + subgrpId + '_' +groupId+ '_' +nxtSeq+ '" class="fa fa-minus-circle removeGroup-field pull-right" data="' + subgrpId + '" style="top:0px"></i><br>';
            $.each(subGrpAttArr, function (key, element) {
                //alert (JSON.stringify(element));
                atributeId = element['AttributeMasterId'];
                ProjAttributeId = element['ProjectAttributeMasterId'];
                var elementValidate = subGrpAttValidate[ProjAttributeId];
                 var inpId = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
                var inpName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
                var commendName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
                var selName = 'ProductionFields_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
                
                
                //alert(inpName);
				
				var pam = element['ProjectAttributeMasterId'];
                                var reload = 'LoadValue('+pam+',this.value,'+elementValidate['Reload']+','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+ nxtSeq +');';
				//  var reload = elementValidate['Reload'] +','+ atributeId +','+'<?php echo $DependentMasterIds['ProductionField']; ?>' +','+ nxtSeq +');';
                                var IsMandatory=elementValidate['IsMandatory'];
                                        var DisplayAttributeName=elementValidate['DisplayAttributeName'];
                                        var mandateFunction ='';
                                         if(IsMandatory==1){
                                         var mandateFunction = 'MandatoryValue(this.id,this.value,'+'\''+DisplayAttributeName+'\');';
                                         }
                                          else{
                                          var mandateFunction =''; 
                                         }
                             var inpOnBlur ='';           
                             elementValidate['AllowedCharacter'] = addslashes(elementValidate['AllowedCharacter']);
                             elementValidate['NotAllowedCharacter'] = addslashes(elementValidate['NotAllowedCharacter']);
                     if(elementValidate['ControlName']=='TextBox'){
                         inpOnBlur =' onblur="checkLength(this,'+atributeId+','+'<?php echo $DependentMasterIds['ProductionField']; ?>'+','+nxtSeq+','+elementValidate['MinLength']+'); '+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');" maxlength="'+elementValidate['MaxLength']+'" minlength="'+elementValidate['MinLength']+'"';   
                     }else if(elementValidate['ControlName']=='DropDownList'){
                         inpOnBlur =' onblur="'+mandateFunction+elementValidate['FunctionName']+'(this.id, this.value,'+'\''+elementValidate['AllowedCharacter'] + '\', '+'\''+elementValidate['NotAllowedCharacter']+'\', '+'\''+elementValidate['Dateformat']+'\', '+'\''+elementValidate['AllowedDecimalPoint']+'\');"';   
                     }
				
                toappendData += '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important"  class=" row form-responsive clearfix MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                        '<div class="col-md-3 form-title"><div class="form-group" style=""><p>' + element['DisplayAttributeName'] + '</p></div></div>' +
                        '<div class="col-md-4 form-text"><div class="form-group">' ;
                if(element['ControlName']=='TextBox')
                        toappendData +='<input '+inpOnBlur+' type="text" class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;

//-------->>>>>>>>>>>> Onclick MultiText Box <<<<<<<<<<<-----------
		if(element['ControlName']=='MultiTextBox') {
                    toappendData += '<textarea id=COpyTeXt_' + atributeId + '_' + nxtSeq + ' readonly="readonly" class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control"></textarea>';
                    if(element['Options'] != ''){
                        var inpName = 'ProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq+'[]';
                        toappendData +='<select multiple="true" '+inpOnBlur+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per testmulti doOnBlur UpdateFields removeinputclass"  id="' + inpId + '" name="' + inpName + '" >';

                    jQuery.each(element['Options'], function (i, val) {
                        toappendData +='<option value="'+val+'">'+val+'</option>';
                    });
                    toappendData +='</select>';
                    } else {
                        toappendData +='<textarea '+inpOnBlur+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"></textarea>' ;
                    }
                }if(element['ControlName']=='CheckBox')
                        toappendData +='<input '+inpOnBlur+' type="checkbox" class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur '+dbClass+'" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input '+inpOnBlur+' value="Yes" type="radio" style="position:static"  class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur InsertFields" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> Yes '+
                                        '<input '+inpOnBlur+' value="No" type="radio" style="position:static"  class="inputsubGrp_'+groupId+'_'+subgrpId+' doOnBlur InsertFields" id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select '+inpOnBlur+' onchange = '+reload+' class="inputsubGrp_'+groupId+'_'+subgrpId+' wid-100per form-control doOnBlur '+dbClass+'"  id="' + inpId + '" name="' + inpName + '" onclick="getThisId(this);loadWebpage('+atributeId+', '+pam+', '+groupId+', '+subgrpId+', '+nxtSeq+', 0);"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                       
                        toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
                        '</div></div>' +
                        '<div class="col-md-2 form-text"><div class="form-group comments">' +
                        '<textarea '+inpOnBlur+' rows="1" cols="50" class="form-control '+dbClass_cmd+'" id="" name="' + commendName + '" placeholder="Comments"></textarea>' +
                        '</div></div>' +
                        '<div class="col-md-3 form-status"><div class="form-group status">' +
                        '<select '+inpOnBlur+' id="" name="' + selName + '" class="form-control CampaignWiseSelDone_' + groupId + ' subGrpDisp_'+groupId+'_'+subgrpId+' dispositionSelect '+dbClass_dis+'">' +
                        '<option value="">--</option>' +
                        '<option value="A">A</option>' +
                        '<option value="D">D</option>' +
                        '<option value="M">M</option>' +
                        '<option value="V">V</option>' +
                        '</select>' +
                        '</div>' +
                        '</div></div>';

            });

            toappendData += '</div>';
            //alert(toappendData);
            $('.addGrp_' + subgrpId).append(toappendData);
            $('.GroupSeq_' + subgrpId).attr("data", nxtSeq);

            Load_totalAttInThisGrpCnt();
             $('.testmulti').fSelect();
            // checkAll(groupId,subgrpId);
            
//            (function($) {
//                $(function() {
//                    $('.testmulti').fSelect();
//                });
//            })(jQuery);
                });
        });

   function PdfPopup()
   {
/* 
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
 */

            //$('#splitter-block').enhsplitter();
            $('.splitter_panel').first().width('0');
			$('.splitter_bar').css({ left: 0});
			$('.splitter_panel').last().width('1200');
       
       var file = 'http://mobiuslease.botminds.ai/login';
       myWindow = window.open("", "myWindow", "width=500, height=500");
       myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:100%; overflow:hidden !important;"></iframe>');

      
   }
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
	    function loadhandsondatafinalold(id, idval, key, keysub, submenu,ModuleId) {
        var ProductionEntityId = $("#ProductionEntity").val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Purebuttallist', 'action' => 'ajaxgetdatahand')); ?>',
            dataType: 'text',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id, title:submenu,ModuleId:ModuleId},
            success: function (res) {                
                $(".hot").html(res);
            }
        });
    }
    function loadhandsondatafinal_old(id, idval, key, keysub,attrName) { var ProductionEntityId = $("#ProductionEntity").val();
        
        var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            var subGrpAttArr = subGrpAtt[key][keysub];
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetdatahand')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id},
            success: function (res) {
                //alert(res);
                var data = [], row;
                var j = 0;

                for (var i = 0, ilen = res.handson.length; i < ilen; i++) {
                    row = [];
//                    row[0] = res.handson[i].DataId;
//                    row[1] = res.handson[i].AfterNormalized;
//                    row[2] = res.handson[i].Comments;
//                    row[3] = res.handson[i].AfterDisposition;
                    
                    row[0] = res.handson[i].data;
                
//                row[0] = res.handson[i].Id;
//                row[0] = res.handson[i].AttributeValue;

                    data[res.handson[i].Id] = row;

                    j++;
                }
                //alert(data);
                hot.loadData(data);
            }
        });
        //alert(id);
        var attrsub = $("#attrsub" + idval + '_' + key + '_' + keysub).val();
        var attrdisp = $("#attrdisp" + id + '_' + idval + '_' + key + '_' + keysub).val();
        if (typeof attrsub === 'undefined' || typeof attrsub === '') {
            $("#exampleFillInHandsonModalTitle").text(attrdisp);
        } else {
            $("#exampleFillInHandsonModalTitle").text(attrsub);
        }
        var
                $container = $("#example1"),
                myattrid = id,
                $console = $("#exampleConsole"),
                $parent = $container.parent(),
                autosaveNotification,
                container3 = document.getElementById('example1'),
                hot;
        hot = new Handsontable($container[0], {
            colWidths: 100,
            height: 520,
            minSpareCols: 0,
            minSpareRows: 0,
            columnSorting: true,
            sortIndicator: true,
            manualColumnMove: true,
            stretchH: 'all',
            rowHeaders: true,
            manualRowResize: true,
            manualColumnResize: true,
            comments: false,
            contextMenu: ['undo', 'redo', 'make_read_only', 'alignment', 'remove_row'],
            colHeaders: attrName,
            columns: [
                {readOnly: true}
//                {type:'text' },{type:'text' },{ type: 'dropdown',source: ['A', 'D', 'M', 'V']}


            ],
            afterValidate: function (isValid, value, row, prop) {
                if (!isValid) {
                    $("#SubmitForm").hide();
                    alert("Data Entered is Invalid!");
                } else {
                    $("#SubmitForm").show();
                }
                if (value === '') {
                    $("#SubmitForm").show();
                }
            },
            beforeRemoveRow: function (change, source) {
                $.ajax({
                    url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxremoverow')); ?>',
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
                    url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxsavedatahand')); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {changes: change, data: hot.getData()}, // contains changed cells' data
                    success: function (result) {

                    }
                });
                //onChange(change, source);
            },
        });

        hot.addHook('afterChange', function (changes, source) {
            if (!changes) {
                return;

            }
            var changed = changes.toString().split(",");
            var keyval = changed[1] - 1;


            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxsavehandson')); ?>',
                dataType: 'json',
                type: 'POST',
                data: {keyval: keyval, changed: changes,ProductionEntityId:ProductionEntityId,data: hot.getData()}, // contains changed cells' data
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



        });



    }
function loadhandsondatafinal_all(id, idval, key, keysub,submenu,ModuleId) {
if(id ==''){
id = 0;
}
 var ProductionEntityId = $("#ProductionEntity").val();
 var InputEntityId = $("#InputEntityId").val();
 $(".loader").show();

        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'text',
            type: 'POST',
            data: {InputEntityId: InputEntityId,ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,handskey:key,handskeysub:keysub,title:submenu,ModuleId:ModuleId,singleAttr:"no"},
            success: function (res) {	
		 $(".loader").hide();
	
	     $(".hot").html(res);
            }
        });
	
}  
function loadhandsondatafinal(id, idval, key, keysub,submenu,ModuleId) {
if(id ==''){
id = 0;
}
 var ProductionEntityId = $("#ProductionEntity").val();
 var InputEntityId = $("#InputEntityId").val();
 $(".loader").show();


        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'text',
            type: 'POST',
            data: {InputEntityId: InputEntityId,ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,prvseq:key,handskeysub:keysub,title:submenu,ModuleId:ModuleId,singleAttr:"yes"},
            success: function (res) {	
	 $(".loader").hide();
	
       
	     $(".hot").html(res);
            }
        });
	
}  

    function loadhandsondatafinal_allold(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Purebuttallist', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,handskey:key,handskeysub:keysub},
            success: function (res) {
				var data = [];
                var j = 0;
				$.each(res.handson, function (key, val) {
                    $handle=0;row=[];
                    $.each(val, function (key2, val2) {
                    row[$handle] = val2;
                    $handle++;
                    
                });
                data[j] = row;
                    j++;
                });

                hot.loadData(data);
            }
        });
        
        var attrsub = $("#attrsub" + idval + '_' + key + '_' + keysub).val();
        var attrdisp = $("#attrdisp" + id + '_' + idval + '_' + key + '_' + keysub).val();
        if (typeof attrsub === 'undefined' || typeof attrsub === '') {
            $("#exampleFillInHandsonModalTitle").text(attrdisp);
        } else {
            $("#exampleFillInHandsonModalTitle").text(attrsub);
        }
        var
                $container = $("#example1"),
                myattrid = id,
                $console = $("#exampleConsole"),
                $parent = $container.parent(),
                autosaveNotification,
                container3 = document.getElementById('example1'),
                hot;
                
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            var subGrpAttArr = subGrpAtt[key][keysub];
            var j=0; var header=[]; var noofcolumn=[];
			//alert(JSON.stringify(subGrpAttArr));
            $.each( subGrpAttArr, function( key, value ) {
              //  alert(value['DisplayAttributeName'])
            header[j]=value['DisplayAttributeName'];
				noofcolumn[j]='{readOnly: true}';
            j++;
            });
          // alert(noofcolumn);
            
        hot = new Handsontable($container[0], {
            colWidths: 300,
            height: 520,
            minSpareCols: 0,
            minSpareRows: 0,
            columnSorting: true,
            sortIndicator: true,
            manualColumnMove: true,
            stretchH: 'all',
            rowHeaders: true,
            manualRowResize: true,
            manualColumnResize: true,
            comments: false,
            contextMenu: ['undo', 'redo', 'make_read_only', 'alignment', 'remove_row'],
            colHeaders: header,
            columns: noofcolumn,
			
            afterValidate: function (isValid, value, row, prop) {
                if (!isValid) {
                    $("#SubmitForm").hide();
                    alert("Data Entered is Invalid!");
                } else {
                    $("#SubmitForm").show();
                }
                if (value === '') {
                    $("#SubmitForm").show();
                }
            },
            beforeRemoveRow: function (change, source) {
                $.ajax({
                    url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxremoverow')); ?>',
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
                    url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxsavedatahand')); ?>',
                    dataType: 'json',
                    type: 'POST',
                    data: {changes: change, data: hot.getData()}, // contains changed cells' data
                    success: function (result) {

                    }
                });
                //onChange(change, source);
            },
        });

        hot.addHook('afterChange', function (changes, source) {
            if (!changes) {
                return;

            }
            var changed = changes.toString().split(",");
            var keyval = changed[1] - 1;


            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxsavehandson')); ?>',
                dataType: 'json',
                type: 'POST',
                data: {keyval: keyval, changed: changes,ProductionEntityId:ProductionEntityId,data: hot.getData()}, // contains changed cells' data
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




        });




    }
    
     function LoadValue(id, value, toid,toattrid, attrid, depdid, seq) {
   
        var Region=$('#RegionId').val();
      
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'Getjobcore','action'=>'ajaxloadresult'));?>",
            data: ({id: id, value: value, toid: toid,Region:Region}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var obj = JSON.parse(result);
                          if(obj['count'] == 1){
            var attrs = document.getElementById('ProductionFields_' + toattrid + '_' + depdid + '_' + seq).attributes;
                var html = "<input type='textbox' ";
                  $.each(attrs,function(i,elem){
                      if(elem.name != "value" && elem.name != "readonly" && elem.name != "type")
                          html = html+elem.name+'="'+elem.value+'" ';
                });
                html = html+" value='"+obj['arrvalue']['0']['Value']+"' readonly />";
                             var parentObj = $('#ProductionFields_' + toattrid + '_' + depdid + '_' + seq).parent();
                             $('#ProductionFields_' + toattrid + '_' + depdid + '_' + seq).remove();
                                     parentObj.prepend(html);  

                      }else{  
                         var attrs = document.getElementById('ProductionFields_' + toattrid + '_' + depdid + '_' + seq).attributes;
                var html = "<select ";     
                 $.each(attrs,function(i,elem){
                     if(elem.name != "value" && elem.name != "readonly" && elem.name != "type")
                          html = html+elem.name+'="'+elem.value+'" ';
                });
                  html = html+">";
                      html = html+"<option value=0></option>";
                html = html+"</select>";

                  var parentObj = $('#ProductionFields_' + toattrid + '_' + depdid + '_' + seq).parent();
                             $('#ProductionFields_' + toattrid + '_' + depdid + '_' + seq).remove();
                                     parentObj.prepend(html);  
  
                var k = 1;
                //toid = 225;
                var x = document.getElementById('ProductionFields_' + toattrid + '_' + depdid + '_' + seq);
               
                document.getElementById('ProductionFields_' + toattrid + '_' + depdid + '_' + seq).options.length = 0;
                var option = document.createElement("option");
                option.text = '--Select--';
                option.value = 0;
                x.add(option, x[0]);
              
            $.each(obj['arrvalue'], function( key, element ) {
             //   obj.forEach(function (element) {
                    var option = document.createElement("option");
                    option.text = element['Value'];
                    option.value = element['Value'];
                    x.add(option, x[k]);
                    k++;
                   // }
                });
                }
            }
        
        
        });
    }
    
    $(document).ready(function() {
        $("#ProductionArea").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                AjaxSave('');
                return false;
            }
        });
    });
    
    (function($) {
        $(function() {
            $('.testmulti').fSelect();
        });
    })(jQuery);
    
    //------------------------Multi Select Text-------------------------//
    $(document).on("click", ".fs-option", function () {
        var COpyTeXt = '';
        var selectId = $(this).parent().parent().parent().children(".testmulti").attr("id");
        var arr = selectId.split('_');
        var AttributeMasterId = arr[1];
        var tempSq = arr[3];
        COpyTeXt += $('#'+selectId).val();
        if(COpyTeXt == 'null'){
            COpyTeXt=" ";
        }
//        alert("AttributeMasterId_"+AttributeMasterId+'_'+tempSq+'_CopyText_'+COpyTeXt);
        $('#COpyTeXt_'+AttributeMasterId+'_'+tempSq).val(COpyTeXt);
        var selectedIdVal = $('#'+selectId).val();
        Load_verifiedAttrCnt_forselect($('#'+selectId));
        Load_totalAttInThisGrpCnt();

    });
    //------------------------Multi Select Text-------------------------//
            
            
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
        height: 350px;
        margin: 0 auto;
    }
    #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
    .pane-content {
        padding: 0 10px;
    }
	.link-style,.pu_cmts_seq{
	cursor: pointer;
	}
        .Zebra_DatePicker_Icon_Inside{
            left: 163px !important;
        }
        
        
</style>
<?php
if ($this->request->query['continue'] == 'yes') {
    echo "<script>getJob();</script>";
}
?>

<script>
function GetFrameData(val){
goToMsg(val);
}

		function setValue(id, oVal) {
			//alert(id+oVal);
            document.getElementById(id).value = oVal;

        }
		
function goToMsg(id){
      var iframe = document.getElementById("frame1");
      var elem = iframe.contentWindow.document.getElementById(id);
      iframe.contentWindow.location.hash = id;
	  		
     $("html, body")
     .animate({scrollTop:$( elem ).offset().top}, 250, function() {		
		elements = iframe.contentWindow.document.getElementsByClassName('annotated');
		for (var i = 0; i < elements.length; i++) {
			elements[i].style.backgroundColor="blue";
		}

		 $(elem).css('background-color', 'red');	

	//$(elem).css('cursor', 'pointer');
      // $(elem).fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200)
     })
	 
	 
   }
   function ajaxQuerypopup(){
 
 var arrayid = $('.query_ids').serialize() ;
 var arrayname = $('.query_names').serialize() ;
 var arraydata = $('.UpdatedQuery').serialize() ;
 ProductionEntity = $("#ProductionEntity").val();



	     $(".hot_query").html('Loading...');
            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'querysubmit')); ?>',
            
            data: {Query: arraydata,QueryId: arrayid, QueryName:arrayname,ProductionEntity:ProductionEntity},
            type: 'POST',
            success: function (res) { 
	     $(".hot_query").html(res);
            }
        });
       // location.reload();
   }
   		    function valicateQueryAll() {
				 $(".qryvalidation textarea").each(function() {
				   var element = $(this);
				   if (element.val() == "") {
					   alert("Query is Mandatory Please fill all query!");
					   exit;
				   }
				});
           var arraydata = $('.submit_query').serialize() ;
            var regionid = $('#RegionId').val();
            query = $("#query").val();
            InputEntyId = $("#ProductionEntity").val();

            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxquerypostingmulti')); ?>",
                data: ({multiquery: arraydata, InputEntyId: InputEntyId, RegionId: regionid}),               
                success: function (res) { 
                        if(res =="success"){
					   $(".suc-msg").show().html('Query Posted Successfully!');
					setTimeout(function() {
					   $(".suc-msg").hide();
                                           location.reload();
					}, 2000);
                                    }
                        else{

                $('#querymodalAll').modal('hide');
                                        $(".emptyerror").show();
					setTimeout(function() {
					   $(".emptyerror").hide();
					}, 2000);
                        }
                 }
                
            });
/*var url = window.location.href;    
if (url.indexOf('?') > -1){
   url += '&querysuccess=1'
}else{
   url += '?querysuccess=1'
}
window.location.href = url;
	*/		
        }
function fetchbotminds()
{
	$(".validationloader").show();
     ProjectId = $("#ProjectId").val();
     
       var domainId = "<?php echo $staticFields[0]; ?>";

	token='';
	 $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxGetAPIToken')); ?>",
                 data: ({ProjectId: ProjectId, domainId:domainId}),
                success: function (res) { 
                   resArr=JSON.parse(res);
						 $.each(resArr['singleAttr'], function( key, element ) {
                                                    if(element == 'A'){
                                                    $('select[name="'+key+'"]').val(element);
                                                    }else{
                                                  $('#'+key).val(element);
                                             } 
						 });
//                                                  var group;  var subGroup;
//                                              $.each(resArr['funcValGroup'], function( key, element ) {
//                                                  $.each(element, function( key, val ) {
//                                                  var values = val.split('_');   
//                                                   subGroup = values[0];
//                                                          group = values[1];
//                                                            var maxSeqCnt = $('.GroupSeq_' + subGroup).attr("data");
//                                                        //    alert(maxSeqCnt);
//                                                           // var nxtSeq = parseInt(maxSeqCnt);
//                                                           //   if(maxSeqCnt > 1) {
//                                                           // $('#'+subGroup+'_'+group+'_'+nxtSeq).parent().remove();
//                                                          //  $('#'+MultiSubGroup+'_'+subGroup+'_'+nxtSeq).remove();
//                                                           // Load_totalAttInThisGrpCnt();
//                                                         //   var nxtSeq = nxtSeq - 1;
//                                                         //   $('.GroupSeq_' + subGroup).attr("data", nxtSeq);
//                                                    //    }   
//                                                         });
//                                                          addSubgrpAttribute(subGroup,group);
//                                                         });
//                                                        var group;  var subGroup;
//                                                       $.each(resArr['funcValGroup'], function( key, element ) {
//                                                           
//                                                  $.each(element, function( key, val ) {
//                                                  var values = val.split('_');   
//                                                   subGroup = values[0];
//                                                          group = values[1];
//                                                   
//                                           	  });
//                                                  addSubgrpAttribute(subGroup,group);
//						 });
                                              $.each(resArr['funcValSingle'], function( key, element ) {
                                                      var values = element.split('_');   
                                                      var attrid = values[0];
                                                              var projattrid = values[1];
                                                              var group = values[2];
                                                              var subgroup = values[3];
                                                              var displayname = values[4];
                                                           var maxSeqCnt = $('.ShowingSeqDiv_' + attrid).attr("data");
                                                            var nxtSeq = parseInt(maxSeqCnt);
                                                            if(maxSeqCnt > 1) {
                                                            $("#MultiField_"+attrid+"_"+maxSeqCnt ).remove();
                                                            Load_totalAttInThisGrpCnt();
                                                            var nxtSeq = nxtSeq - 1;
                                                            $('.ShowingSeqDiv_' + attrid).attr("data", nxtSeq); 
                                              }
                                               });
                                               $.each(resArr['funcValSingle'], function( key, element ) {
                                                      var values = element.split('_');   
                                                      var attrid = values[0];
                                                              var projattrid = values[1];
                                                              var group = values[2];
                                                              var subgroup = values[3];
                                                              var displayname = values[4];
							 addAttribute(attrid,projattrid,group,subgroup,displayname);
                                               
						 });
                                                  $.each(resArr['addAttrSingle'], function( key, element ) {
                                                  //    if(element != ''){
							 if(element == 'A'){
                                                     $('select[name="'+key+'"]').val(element);
                                                    }else{
                                                  $('#'+key).val(element);
                                              }
                                           //  } 
						 });
                                                var group;  var subGroup;
                                                       $.each(resArr['funcValGroup'], function( key, element ) {
                                                           $.each(element, function( key, val ) {
                                                  var values = val.split('_');   
                                                   subGroup = values[0];
                                                           group = values[1];
                                                            var maxSeqCnt = $('.GroupSeq_' + subGroup).attr("data");
                                                            var nxtSeq = parseInt(maxSeqCnt);
                                                              if(maxSeqCnt > 1) {
                                                            $('#'+subGroup+'_'+group+'_'+nxtSeq).parent().remove();
                                                            Load_totalAttInThisGrpCnt();
                                                            var nxtSeq = nxtSeq - 1;
                                                            $('.GroupSeq_' + subGroup).attr("data", nxtSeq);
                                                        } 
                                                         });
                                                         });
                                                         var group;  var subGroup;
                                                         $.each(resArr['funcValGroup'], function( key, element ) {
                                                             $.each(element, function( key, val ) {
                                                  var values = val.split('_');   
                                                   subGroup = values[0];
                                                           group = values[1];
                                           	  });
                                                   addSubgrpAttribute(subGroup,group);
						 });
                                             
                                               $.each(resArr['addAttrGroup'], function( key, element ) {
                                                //     if(element != ''){
							 if(element == 'A'){
                                                     $('select[name="'+key+'"]').val(element);
                                                    }else{
                                                  $('#'+key).val(element);
                                             } 
                                        // }
						 });
                                                 
						  $(".validationloader").hide();
					}
                
            });
			//if(token!='')
			
}
function Rentcalc(AttrId,ProductionField,Comments,Disposition,SubGroupId,GroupId,Seq){
	if(Seq ==0){
	var Seq =$("#CurSeq").val();
	}
	/*if(Seq > 1){
	var newSubGroupId = SubGroupId;
	var newGroupId = GroupId;	
	}
	else{	
	//var newSubGroupId = parseInt(SubGroupId) + parseInt(1);
	//var newGroupId = parseInt(GroupId) + parseInt(1);
	}	*/
	var newSubGroupId = SubGroupId;
	var newGroupId = GroupId;

	var CommencementId = $("#CommencementId").val();
	var ExpirationId = $("#ExpirationId").val();	
	var BaseRentId = $("#BaseRentId").val();	
	var RentIncId = $("#RentIncId").val();
	
	var FirstAttrId =$("#FirstAttrGroup_"+newSubGroupId+""+newGroupId).val();	

	var Title = $("#ProductionFields_"+FirstAttrId+"_"+ProductionField+"_"+Seq+"").val();	
	var Commencement = $("#ProductionFields_"+CommencementId+"_"+ProductionField+"_"+Seq+"").val();	

	var Expiration = $("#ProductionFields_"+ExpirationId+"_"+ProductionField+"_"+Seq+"").val();	
	var BaseRent = $("#ProductionFields_"+BaseRentId+"_"+ProductionField+"_"+Seq+"").val();	
	var RentInc = $("#ProductionFields_"+RentIncId+"_"+ProductionField+"_"+Seq+"").val();
	
	var date= Commencement;
	var d=new Date(date.split("/").reverse().join("-"));
	var dd=d.getDate();
	var mm=d.getMonth()+1;
	var yy=d.getFullYear();
	 for ( var i=1;i < 10 ; i++ ) {
		  if(mm == i){
			mm =  "0" + mm;
		  }
	  }
	  for ( var i=1;i < 10 ; i++ ) {
		  if(dd == i){
			dd =  "0" + dd;
		  }
	  }
	var newCommencement=dd+"-"+mm+"-"+yy;
	
	var date= Expiration;
	var d=new Date(date.split("/").reverse().join("-"));
	var dd=d.getDate();
	var mm=d.getMonth()+1;
	var yy=d.getFullYear();
	  for ( var i=1;i < 10 ; i++ ) {
		  if(mm == i){
			mm =  "0" + mm;
		  }
	  }
	  for ( var i=1;i < 10 ; i++ ) {
		  if(dd == i){
			dd =  "0" + dd;
		  }
	  }
	var newExpiration=dd+"-"+mm+"-"+yy;
	

	var sequence=$(".GroupSeq_"+newSubGroupId).attr("data");
	$("#RentTitle").html(Title);///rent popup title
	$("#RentFirstAttrVal").val(Title);
	$("#RentFirstAttrId").val(FirstAttrId);///rent hidden file for append data load
	$("#RentSubGroup").val(newSubGroupId);
	$("#RentGroup").val(newGroupId);	
	$("#CommencementVal").val(Commencement);
	$("#SequenceVal").val(Seq);
	$("#ExpirationVal").val(Expiration);
	$("#BaseRentVal").val(BaseRent);
	$("#RentIncVal").val(RentInc);
	$("#Rentseq").val(sequence);	
	$("#RentComments").val(Comments);
	$("#RentDisposition").val(Disposition);
	$("#RentProductionField").val(ProductionField);
	$(".hot_rent").html("");
	$("#frequency").val("0");
	
}
function Rentcalcsub(){
	$(".hot_rent").html("");
	var proceed ="yes";
	var ProjectId = $("#ProjectId").val();
	var Commencement = $("#CommencementVal").val();	
	var Expiration = $("#ExpirationVal").val();	
	var BaseRent = $("#BaseRentVal").val();	
	var RentInc = $("#RentIncVal").val();
	var Frequency = $("#frequency").val();	
	

 var decimalOnly = /^\s*-?[1-9]\d*(\.\d{1,2})?\s*$/;
   
	if(Commencement=='' || Expiration=='' || BaseRent=='' || RentInc=='' || Frequency =='0'){
	   alert("Please Enter All details");
       proceed="no";
	}
	else if(!isDatecheck(Commencement)){
	  alert('Commencement Date invalid');
	  proceed="no";
	}
	else if(!isDatecheck(Expiration)){
		alert('Expiration Date invalid');
		proceed="no";
	}
	else if(!decimalOnly.test(RentInc) && RentInc !=''){ 
	   alert('RentInc is invalid!');
	   proceed="no";
	}
	else if(!decimalOnly.test(BaseRent) && BaseRent !=''){ 
	   alert('Base Rent Initial amount is invalid!' );
	   proceed="no";
	   
	}
	else{
	$(".hot_rent").html("Loading...");
	}
	if(proceed =="yes"){
	 $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxRentcal')); ?>",
                 data: ({ProjectId: ProjectId,Commencement: Commencement,Expiration: Expiration,BaseRent: BaseRent,RentInc: RentInc,Frequency: Frequency}),
                success: function (res) { 
						if(res == 0){
							alert("Date is Missmatch");
						}
						else{
							 $(".hot_rent").html(res);
						}
					}
                
            });
	}
}
function Rentcalcappend(){
	var Commencement = $("#CommencementId").val();	
	var GetSequence = $("#SequenceVal").val();
	var Expiration = $("#ExpirationId").val();	
	var BaseRent = $("#BaseRentId").val();	
	var RentInc = $("#RentIncId").val();
	var seq= $("#Rentseq").val();	
	var RentFirstAttrId = $("#RentFirstAttrId").val();

	var RentFirstAttrVal = $("#RentFirstAttrVal").val();
	var SequenceVal = $("#SequenceVal").val();	

	var RentSubGroup = $("#RentSubGroup").val();	
	var RentGroup = $("#RentGroup").val();

	//var Comments =$("#RentComments").val();
	//var Disposition=$("#RentDisposition").val();
	var ProductionField=$("#RentProductionField").val();	
	//var RentFirstAttrVal = $('input[name="ProductionFields_'+RentFirstAttrId+'_'+ProductionField+'_'+GetSequence+'"]').val();	
	
	    var Arrpercent = $('input[name^=percent]');
	    var Arramount = $('input[name^=totalamt]');
	    var Arrstartdate = $('input[name^=startdate]');
	    var Arrenddate = $('input[name^=enddate]');
		var totArr=Arrpercent.length;
        var postData = {
            Amountdata: [], // the videos is an array
            percentdata: [], // the videos is an array
            startdatedata: [], // the videos is an array
            enddatedata: [], // the videos is an array
        };
        $.each(Arramount, function(index, el) {
             postData.Amountdata.push($(el).val());
        });
		$.each(Arrpercent, function(index, el) {
             postData.percentdata.push($(el).val());
        });
		$.each(Arrstartdate, function(index, el) {
             postData.startdatedata.push($(el).val());
        });
		$.each(Arrenddate, function(index, el) {
             postData.enddatedata.push($(el).val());
        });
               
				
						for(var i=0;i < totArr;i++){
													
							
                         addSubgrpAttribute(RentSubGroup,RentGroup);
						   seq = parseInt(seq) + parseInt(1);
						   
						 $('#ProductionFields_'+RentFirstAttrId+'_'+ProductionField+'_'+seq+'').val(RentFirstAttrVal);
						 //$('input[name="ProductionFields_'+RentFirstAttrId+'_'+ProductionField+'_'+seq+'"]').val(RentFirstAttrVal);
						 $('input[name="ProductionFields_'+Commencement+'_'+ProductionField+'_'+seq+'"]').val(postData.startdatedata[i]);
						 $('input[name="ProductionFields_'+Expiration+'_'+ProductionField+'_'+seq+'"]').val(postData.enddatedata[i]);
						 $('input[name="ProductionFields_'+BaseRent+'_'+ProductionField+'_'+seq+'"]').val(postData.Amountdata[i]);
						 $('input[name="ProductionFields_'+RentInc+'_'+ProductionField+'_'+seq+'"]').val(postData.percentdata[i]);						
						  }
             
                
			

}

function search_mode(){
	
	$(".hot_search").html("");
	$("#OSF_CO_NAME").val("");
	$("#FORMER_CO_NAME").val("");
	

}
function Searchdata(){
	var OSF_CO_NAME = $("#OSF_CO_NAME").val();
	var FORMER_CO_NAME = $("#FORMER_CO_NAME").val();
	//var BaseRentVal1 = $("#BaseRentVal1").val();
	$(".hot_search").html("Loading...");
	
	$(".hot_search").html("Loading...");
	 $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxSearch')); ?>",
                 data: ({OSF_CO_NAME: OSF_CO_NAME,FORMER_CO_NAME:FORMER_CO_NAME}),
                success: function (res) { 
				
                     $(".hot_search").html(res);
					}
                
            });
} 
function populate(COMP_ENT_NBR,COMP_CO_ID,COMP_CO_NAME,Address1,City,State,Zip,Email,URL,Phone,Fax,Toll_Free,Address1,Address2,Address3,Postal_Code1,City,Province,Postal_Code2,Country,Postal_Code3,Email,URL,Phone,Fax,Toll_Free,Mailing_Address1,Mailing_City,Mailing_State,Mailing_Zip,Email,URL,Phone,Fax,Toll_Free,Mailing_Address1,Mailing_Address2,Mailing_Address3,Mailing_PostalCode1,Mailing_City,Mailing_Province,Mailing_Postal_Code2,Mailing_Country,Mailing_Postal_Code3,Email,URL,Phone,Fax,Toll_Free,Nbr_Employees,Revenue_Type,Sales,Upper_Sales_Range,Net_Income,Assets,Liabilities,Net_Worth,Fiscal_Yr_End_Date,FYE_MMDD,Nbr_Employee_Benefits,Pension_Type1,Pension_Assets,Pension_Ending_Date,Ticker,Stock_Exchange1,Cusip_Nbr,OSF_CO_NAME,OSF_ADDRESS1,OSF_CITY,OSF_COUNTRY,OSF_CO_NAME,OSF_ADDRESS1,OSF_CITY,OSF_COUNTRY,OSF_CO_NAME,OSF_ADDRESS1,OSF_CITY,OSF_COUNTRY,OSF_CO_NAME,OSF_ADDRESS1,OSF_CITY,OSF_COUNTRY,FIRST_NAME,MIDDLE_NAME,LAST_NAME,SUFFIX,Personnel_ID,Exec_Title,RESP_CODES,Board_Ind,Chairman_Ind,COMPENSATIONS,COMMITTEES,BD_START_DATE,BD_END_DATE,EXEC_TITLE_START_DATE,EXEC_TITLE_END_DATE,School,Degree,Area,Year,CERT_NAME,Year,AWARD_NAME,YEAR,ASSOC_COUNCIL_NAME,COMMITTEE,ROLE,START_DATE,END_DATE,GENDER,FORMER_CO_ENT_NBR,FORMER_CO_NAME,FORMER_EXEC_TITLE,DATE_OF_BIRTH,START_DATE,End_DATE,COMPENSATIONS,COMMITTEES,EXEC_LINK_ID,PERSONNEL_ID){
	 $('#searchmodal').modal('hide');
	

$('#ProductionFields_3263_101_1').val(COMP_ENT_NBR);
$('#ProductionFields_4783_101_1').val(COMP_CO_ID);
$('#ProductionFields_4657_101_1').val(COMP_CO_NAME);
$('#ProductionFields_4784_101_1').val(Address1);
$('#ProductionFields_4785_101_1').val(City);
$('#ProductionFields_4786_101_1').val(State);
$('#ProductionFields_4787_101_1').val(Zip);
$('#ProductionFields_4788_101_1').val(Email);
$('#ProductionFields_4789_101_1').val(URL);
$('#ProductionFields_4790_101_1').val(Phone);
$('#ProductionFields_4791_101_1').val(Fax);
$('#ProductionFields_4792_101_1').val(Toll_Free);
$('#ProductionFields_4793_101_1').val(Address1);
$('#ProductionFields_4794_101_1').val(Address2);
$('#ProductionFields_4795_101_1').val(Address3);
$('#ProductionFields_4796_101_1').val(Postal_Code1);
$('#ProductionFields_11254_101_1').val(City);
$('#ProductionFields_4798_101_1').val(Province);
$('#ProductionFields_4799_101_1').val(Postal_Code2);
$('#ProductionFields_4800_101_1').val(Country);
$('#ProductionFields_4801_101_1').val(Postal_Code3);
$('#ProductionFields_4802_101_1').val(Email);
$('#ProductionFields_4803_101_1').val(URL);
$('#ProductionFields_4804_101_1').val(Phone);
$('#ProductionFields_4805_101_1').val(Fax);
$('#ProductionFields_4806_101_1').val(Toll_Free);
$('#ProductionFields_4807_101_1').val(Mailing_Address1);
$('#ProductionFields_4808_101_1').val(Mailing_City);
$('#ProductionFields_4809_101_1').val(Mailing_State);
$('#ProductionFields_4810_101_1').val(Mailing_Zip);
$('#ProductionFields_4811_101_1').val(Email);
$('#ProductionFields_4812_101_1').val(URL);
$('#ProductionFields_4813_101_1').val(Phone);
$('#ProductionFields_4814_101_1').val(Fax);
$('#ProductionFields_4815_101_1').val(Toll_Free);
$('#ProductionFields_4816_101_1').val(Mailing_Address1);
$('#ProductionFields_4817_101_1').val(Mailing_Address2);
$('#ProductionFields_4818_101_1').val(Mailing_Address3);
$('#ProductionFields_4819_101_1').val(Mailing_PostalCode1);
$('#ProductionFields_4820_101_1').val(Mailing_City);
$('#ProductionFields_4821_101_1').val(Mailing_Province);
$('#ProductionFields_4822_101_1').val(Mailing_Postal_Code2);
$('#ProductionFields_4823_101_1').val(Mailing_Country);
$('#ProductionFields_4824_101_1').val(Mailing_Postal_Code3);
$('#ProductionFields_4825_101_1').val(Email);
$('#ProductionFields_4826_101_1').val(URL);
$('#ProductionFields_4827_101_1').val(Phone);
$('#ProductionFields_4828_101_1').val(Fax);
$('#ProductionFields_4829_101_1').val(Toll_Free);
$('#ProductionFields_4830_101_1').val(Nbr_Employees);
$('#ProductionFields_4251_101_1').val(Revenue_Type);
$('#ProductionFields_4831_101_1').val(Sales);
$('#ProductionFields_4832_101_1').val(Upper_Sales_Range);
$('#ProductionFields_4833_101_1').val(Net_Income);
$('#ProductionFields_4834_101_1').val(Assets);
$('#ProductionFields_4835_101_1').val(Liabilities);
$('#ProductionFields_4836_101_1').val(Net_Worth);
$('#ProductionFields_4837_101_1').val(Fiscal_Yr_End_Date);
$('#ProductionFields_4838_101_1').val(FYE_MMDD);
$('#ProductionFields_4840_101_1').val(Nbr_Employee_Benefits);
$('#ProductionFields_4841_101_1').val(Pension_Type1);
$('#ProductionFields_4842_101_1').val(Pension_Assets);
$('#ProductionFields_4843_101_1').val(Pension_Ending_Date);
$('#ProductionFields_4844_101_1').val(Ticker);
$('#ProductionFields_4845_101_1').val(Stock_Exchange1);
$('#ProductionFields_4846_101_1').val(Cusip_Nbr);
$('#ProductionFields_4847_101_1').val(OSF_CO_NAME);
$('#ProductionFields_4848_101_1').val(OSF_ADDRESS1);
$('#ProductionFields_4849_101_1').val(OSF_CITY);
$('#ProductionFields_4850_101_1').val(OSF_COUNTRY);
$('#ProductionFields_4851_101_1').val(OSF_CO_NAME);
$('#ProductionFields_4852_101_1').val(OSF_ADDRESS1);
$('#ProductionFields_4853_101_1').val(OSF_CITY);
$('#ProductionFields_4854_101_1').val(OSF_COUNTRY);
$('#ProductionFields_4855_101_1').val(OSF_CO_NAME);
$('#ProductionFields_4856_101_1').val(OSF_ADDRESS1);
$('#ProductionFields_4857_101_1').val(OSF_CITY);
$('#ProductionFields_4858_101_1').val(OSF_COUNTRY);
$('#ProductionFields_4859_101_1').val(OSF_CO_NAME);
$('#ProductionFields_4860_101_1').val(OSF_ADDRESS1);
$('#ProductionFields_4861_101_1').val(OSF_CITY);
$('#ProductionFields_4862_101_1').val(OSF_COUNTRY);
$('#ProductionFields_3542_101_1').val(FIRST_NAME);
$('#ProductionFields_2061_101_1').val(MIDDLE_NAME);
$('#ProductionFields_2062_101_1').val(LAST_NAME);
$('#ProductionFields_722_101_1').val(SUFFIX);
$('#ProductionFields_3242_101_1').val(Personnel_ID);
$('#ProductionFields_761_101_1').val(Exec_Title);
$('#ProductionFields_4863_101_1').val(RESP_CODES);
$('#ProductionFields_3105_101_1').val(Board_Ind);
$('#ProductionFields_3106_101_1').val(Chairman_Ind);
$('#ProductionFields_4867_101_1').val(COMPENSATIONS);
$('#ProductionFields_4868_101_1').val(COMMITTEES);
$('#ProductionFields_4869_101_1').val(BD_START_DATE);
$('#ProductionFields_4870_101_1').val(BD_END_DATE);
$('#ProductionFields_4871_101_1').val(EXEC_TITLE_START_DATE);
$('#ProductionFields_4872_101_1').val(EXEC_TITLE_END_DATE);
$('#ProductionFields_4873_101_1').val(School);
$('#ProductionFields_4874_101_1').val(Degree);
$('#ProductionFields_4875_101_1').val(Area);
$('#ProductionFields_4876_101_1').val(Year);
$('#ProductionFields_4877_101_1').val(CERT_NAME);
$('#ProductionFields_4876_101_1').val(Year);
$('#ProductionFields_4879_101_1').val(AWARD_NAME);
$('#ProductionFields_4876_101_1').val(YEAR);
$('#ProductionFields_4881_101_1').val(ASSOC_COUNCIL_NAME);
$('#ProductionFields_4882_101_1').val(COMMITTEE);
$('#ProductionFields_4883_101_1').val(ROLE);
$('#ProductionFields_5447_101_1').val(START_DATE);
$('#ProductionFields_5446_101_1').val(END_DATE);
$('#ProductionFields_4887_101_1').val(GENDER);
$('#ProductionFields_4888_101_1').val(FORMER_CO_ENT_NBR);
$('#ProductionFields_236_101_1').val(FORMER_CO_NAME);
$('#ProductionFields_761_101_1').val(FORMER_EXEC_TITLE);
$('#ProductionFields_4897_101_1').val(DATE_OF_BIRTH);
$('#ProductionFields_4869_101_1').val(START_DATE);
$('#ProductionFields_4870_101_1').val(End_DATE);
$('#ProductionFields_4867_101_1').val(COMPENSATIONS);
$('#ProductionFields_4868_101_1').val(COMMITTEES);
$('#ProductionFields_3103_101_1').val(EXEC_LINK_ID);
$('#ProductionFields_3242_101_1').val(PERSONNEL_ID);
			
}	

          function Pucmterrorclk(subgrp, clkseq) {
                $('#exampleFillPopup').modal('hide');
                var currentSeq = $(".GroupSeq_" + subgrp + "").val(); // 2
                var totalseq = $(".GroupSeq_"+subgrp).attr('data'); // 4
                
                   var action ="";
                if(currentSeq < clkseq){
                    action = "next";
                }else if(currentSeq > clkseq){
                    action = "previous";
                }
            var nex = parseInt(clkseq);
            var prev = parseInt(clkseq);
            
            if (currentSeq == totalseq)
                $('#next_' + subgrp).css('color', 'grey');
            else
                $('#next_' + subgrp).css('color', '#4397e6');

            if (currentSeq == 1)
                $('#previous_' + subgrp).css('color', 'grey');
            else
                $('#previous_' + subgrp).css('color', '#4397e6');

            if (action == 'next' && totalseq >= nex) {

                $("#MultiSubGroup_" + subgrp + "_" + currentSeq).hide();
                $("#MultiSubGroup_" + subgrp + "_" + nex).show();
                $(".GroupSeq_" + subgrp + "").val(nex);
                if (nex == totalseq)
                    $('#next_' + subgrp).css('color', 'grey');
                else
                    $('#next_' + subgrp).css('color', '#4397e6');
                if (nex == 1)
                    $('#previous_' + subgrp).css('color', 'grey');
                else
                    $('#previous_' + subgrp).css('color', '#4397e6');
            }

            if (action == 'previous' && totalseq >= prev && prev > 0) {

                $("#MultiSubGroup_" + subgrp + "_" + currentSeq).hide();
                $("#MultiSubGroup_" + subgrp + "_" + prev).show();
                $(".GroupSeq_" + subgrp + "").val(prev);

                if (prev == totalseq)
                    $('#next_' + subgrp).css('color', 'grey');
                else
                    $('#next_' + subgrp).css('color', '#4397e6');

                if (prev == 1)
                    $('#previous_' + subgrp).css('color', 'grey');
                else
                    $('#previous_' + subgrp).css('color', '#4397e6');
            }
              
          }  
		  function loadMultiFieldqcerror(attributeMasterId, clkseq,prvseq) {
        
                $('#exampleFillPopup').modal('hide');
				 $("#MultiField_" + attributeMasterId + "_" + prvseq).hide();
                $("#MultiField_" + attributeMasterId + "_" + clkseq).show();
				
//                $('#exampleFillInHandson').modal('hide');
                /*var currentSeq = $(".ShowingSeqDiv_" + attributeMasterId + "").val(); // 2
                var totalseq = $(".ShowingSeqDiv_"+attributeMasterId).attr('data'); // 4
                
                console.log(totalseq);
                
               var action ="";
                if(currentSeq < clkseq){
                    action = "next";
                }else if(currentSeq > clkseq){
                    action = "previous";
                }
            var nex = parseInt(clkseq);
            var prev = parseInt(clkseq);
        
          
            var nex = parseInt(currentSeq) + 1;
            var prev = parseInt(currentSeq) - 1;

            if (action == 'next' && totalseq >= nex) {
                //$(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + currentSeq).hide();
                $("#MultiField_" + attributeMasterId + "_" + nex).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(nex);
            }

            if (action == 'previous' && totalseq >= prev && prev > 0) {
                //$(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + currentSeq).hide();
                $("#MultiField_" + attributeMasterId + "_" + prev).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(prev);
            }
			*/
        }
		

</script> 
 

<script>

var C_dateformat = '<?php echo json_encode($JsonArray['ValidationRules'][$Commencement]['Dateformat']);?>';
var E_dateformat = '<?php echo json_encode($JsonArray['ValidationRules'][$Expiration]['Dateformat']);?>'; 

var newEndDate = '';

 if(E_dateformat =='"MM-dd-yy"'){
      newEndDate='m-d-Y';
 }
 else if(E_dateformat =='"y-M-d"'){
      newEndDate='Y-m-d';
 }
 else if(E_dateformat =='"M/d/y"'){
        newEndDate='m/d/Y';
 }
 else if(E_dateformat =='"M/d/y H:m"'){
      newEndDate='m/d/Y';
 }
 else{
      newEndDate='d-m-Y';
 }


var newStartDate = '';

 if(C_dateformat =='"MM-dd-yy"'){
      newStartDate='m-d-Y';
 }
 else if(C_dateformat =='"y-M-d"'){
      newStartDate='Y-m-d';
 }
 else if(C_dateformat =='"M/d/y"'){
        newStartDate='m/d/Y';
 }
 else if(C_dateformat =='"M/d/y H:m"'){
      newStartDate='m/d/Y';
 }
 else{
      newStartDate='d-m-Y';
 }


  $('.datepickstart').Zebra_DatePicker({
          format: newStartDate,
          direction: false,
          });
	$('.datepickend').Zebra_DatePicker({
            format: newEndDate,
            direction: false,
          });
		  
	function isDatecheck(txtDate)
   {
    var currVal = txtDate;
    if(currVal == '')
        return false;
    
    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?
       
    if (dtArray == null) 
        return false;
    
    //Checks for mm/dd/yyyy format.
    dtMonth = dtArray[3];
    dtDay= dtArray[1];
    dtYear = dtArray[5];    
   
    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}	       
</script>

	
