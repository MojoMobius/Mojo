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

//pr($processinputdata); //exit;
    use Cake\Routing\Router;

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
.morecontent span {
    display: none;
}
/*.morelink {
    display: block;
}*/
/*    .lighttext {
        font-size: 12px;
        color: #b1afaf;
        white-space: nowrap;
        width: 23em;
        overflow: hidden;
        text-overflow: ellipsis;
        float:left;
    }*/
  
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

/*rahamath code*/
.hot table{
width:100%;
}
.modal-content{
   background:#fff!important; 
    height: 100%;    
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
.modal-header {
 
    background-color: #337AB7;
    width:100%;
 
    padding:16px 16px;
 
    color:#FFF;
 
    border-bottom:2px dashed #337AB7;
 
 }
 .qcComments_accept{background:url("img/test-pass-icon.png") no-repeat left top;width:17px;height:16px; }
 .qcComments_reject{background:url("img/delete.png") no-repeat left top;width:17px;height:16px; }

    </style>

    <body class="animsition site-navbar-small app-work">
    <!-- Project List Starts -->
    <!-- Breadcrumb Starts -->

    <form name="ProductionArea" id="ProductionArea" method="post">
        <div class="panel-heading p-b-0">
            <div class="col-xxl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="page-header p-l-0 p-r-0">
                    <div class="projet-details">
                        <h3 class="page-title"><div class="col-md-8 font-size-14">
                          <div><b><?php  $n= 0; $prefix = '';
                        foreach ($staticFields as $key) { 
                          if(!empty($staticFields[$n]['AttributeValue'])){
                          echo $prefix.$staticFields[$n]['AttributeValue'];
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
    <?php echo $this->Form->input('', array('type' => 'hidden', 'id' => 'getreworkjob', 'name' => 'getreworkjob', 'value' => $QCStatus_find)); ?>
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
<!--			<div style="float: right;">
                            <input type="checkbox" class="chk-wid-Url float-right" onclick="ShowUnVerifiedAtt()" id="chk-wid-Url2" value="2"> Hide Completed Fields 
                            <span style="display:none;">
			    <input type="checkbox" class="chk-wid-Url" onclick="checkAllUrlAtt()" id="chk-wid-Url" value="1"> Show Relevant Fields
                            </span>
			</div>-->
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
                                <input class="UpdateFields" type="hidden" name="InputEntityId" id="InputEntityId" value="<?php echo $InputEntityId; ?>">

                                <input  type="hidden" name="qc_rework_nexeId" id="qc_rework_nexeId" value="<?php echo $QCrework_next_id; ?>">

                                <input type="hidden" name="attrGroupId" id="attrGroupId">
                                <input type="hidden" name="attrSubGroupId" id="attrSubGroupId">
                                <input type="hidden" name="attrId" id="attrId">
                                <input type="hidden" name="ProjattrId" id="ProjattrId">
                                <input type="hidden" name="seq" id="seq">
                                <input type="hidden" name="refUrl" id="refUrl">
                                <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
                                    
                                            <?php
                                            $i = 0;
										//	pr($AttributeGroupMaster);
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
                                                      //  pr($AttributesListGroupWise);
                                                        foreach ($AttributesListGroupWise[$key] as $keysub => $valuesSub) {
                                            ?>

                                            <div class="panel-body panel-height " style="border:0px;">
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
                                                <div class="col-md-6 row-title">
                                                
                                                                <?php if ($isDistinct !== false) {
                                                                    ?>
<!--                                                                 <i id="subgrp-add-field" style="margin-top:5px;" class="fa fa-plus-circle pull-right add-field m-r-10 addSubgrpAttribute" data="<?php echo $keysub; ?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>"></i> -->
													<?php 
                                                                    //pr($GrpSercntArr);
                                                                    $GroupSeqCnt = $GrpSercntArr[$keysub]['MaxSeq'];
                                                                } else {
                                                                    $GroupSeqCnt = 1;
													}
                                                                ?>
                                                
                                                <?php
                                                                if ($GroupSeqCnt > 1) {
                                                                    
                                                                ?>
                                                <i id= "next_<?php echo $keysub; ?>" class="fa fa-angle-double-right pull-right m-r-5" style="color:#4397e6"  onclick="Paginate('next', '<?php echo $keysub; ?>', '<?php echo $GroupSeqCnt; ?>');"></i> 
                                                <i id="previous_<?php echo $keysub; ?>" class="fa fa-angle-double-left pull-right" onclick="Paginate('previous', '<?php echo $keysub; ?>', '<?php echo $GroupSeqCnt; ?>');"></i>
                                              
					           <i class="fa fa-info-circle m-r-10 m-l-10 pull-right"  onclick="loadhandsondatafinal_all('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>',' <?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>');" data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal"></i>

                                                                    <?php
                                                                }
                                                                ?>
                                                <input type="hidden" value="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>" id="attrsub<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>">

                                                </div>
                                                </div>
                                                                <?php
                                                            }
                                                            //pr($GrpSercntArr);

                                                            if ($GroupSeqCnt == 0) {
                                                                $GroupSeqCnt = 1;
                                                            }
                                                            ?>
                                                <input value="1" type="hidden" data="<?php echo $GroupSeqCnt; ?>" name="GroupSeq_<?php echo $keysub; ?>" class="GroupSeq_<?php echo $keysub; ?>">

                                                            <?php
                                                            for ($grpseq = 1; $grpseq <= $GroupSeqCnt; $grpseq++) {
                                                                if ($grpseq > 1)
                                                                    $disnone = "display:none;";
                                                                else
                                                                    $disnone = "";
                                                                ?>

                                                <div style="<?php echo $disnone; ?>Padding:0px;" id="MultiSubGroup_<?php echo $keysub; ?>_<?php echo $grpseq; ?>" class="clearfix">
                                                                <?php
                                                            foreach ($valuesSub as $keyprodFields => $valprodFields) {
                                                                        if ($isDistinct !== false)
                                                                        $totalSeqCnt = 0;
                                                                    else
														$totalSeqCnt = count($processinputdata[$valprodFields['AttributeMasterId']]);
														
                                                                        $projAvail = count($processinputdata[$valprodFields['AttributeMasterId']]);
                                                                $dbClassName = "UpdateFields removeinputclass";
                                                                        if ($projAvail == 0) {
                                                                            $dbClassName = "InsertFields";
                                                                        }

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
                                                                                                                                       
                                                                                    $ProdFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['ProductionField']]['0'];
                                                                                    $InpValueFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['InputValue']]['0'];
                                                                                    $DispositionFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Disposition']]['0'];
                                                                                    $CommentsFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Comments']]['0'];
                                                                                    $ProdFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['ProductionField'] . "_" . $tempSq;
                                                                                    $InpValueFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['InputValue'] . "_" . $tempSq;
                                                                                    $DispositionFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['Disposition'] . "_" . $tempSq;
                                                                                    $CommentsFieldsName = "ProductionFields_" . $valprodFields['AttributeMasterId'] . "_" . $DependentMasterIds['Comments'] . "_" . $tempSq;
																	
                                                                            if ($thisseq > 1)
																		$disnone = "display:none;";
																	else
																		$disnone = "";
																	
																	$inpuControlType = $valprodFields['ControlName'];
                                                                            if ($inpuControlType == "RadioButton" || $inpuControlType == "CheckBox")
                                                                                $inpClass = 'class="doOnBlur ' . $dbClassName . '" ';
																	else
                                                                                $inpClass = 'class="wid-100per form-control doOnBlur ' . $dbClassName . '" ';
																	
                                                                            $inpId = 'id="prodInput_' . $valprodFields['AttributeMasterId'] . '" ';
                                                                            $inpName = 'name="' . $ProdFieldsName . '" ';
                                                                            $inpValue = 'value="' . $ProdFieldsValue . '" ';
																			$titleValue = 'title="' . $ProdFieldsValue . '" ';
																			
                                                                                    $inpOnClick = 'onclick="getThisId(this.id); loadWebpage(' . $valprodFields['AttributeMasterId'] . ', ' . $valprodFields['ProjectAttributeMasterId'] . ', ' . $valprodFields['MainGroupId'] . ', ' . $valprodFields['SubGroupId'] . ', ' . $tempSq . ', 0);" ';
																?>

                                                            <div id="MultiField_<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $thisseq; ?>" class="clearfix MultiField_<?php echo $valprodFields['AttributeMasterId']; ?> CampaignWiseFieldsDiv_<?php echo $key; ?> row form-responsive" style="<?php echo $disnone; ?>" >
<!--                                                                <div class="commonClass" id="groupAttr_<?php echo $valprodFields['AttributeMasterId']?>">-->
                                                                <div class="col-md-2 form-title">
                                                            <div class="form-group" style=""><p><?php echo $valprodFields['DisplayAttributeName'] ?></p>
                                                                <input type="hidden" value="<?php echo $valprodFields['DisplayAttributeName'] ?>" id="attrdisp<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>">
																
                                                            </div>	
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                            <div class="form-group">
																<?php 
																					$highlightRework=array();
																					$highlightReworkstyle=array();
                                                                                    if ((($QcErrorComments[$valprodFields['AttributeMasterId']]['seq']['StatusID'][$tempSq]) == '6') ){
                                                                                       $highlightRework[] = 'style="border-color: red"'; 
                                                                                       $highlightReworkstyle[] = 'border-color: red'; 
                                                                                    }
                                                                                    $highlightRework = $highlightRework[0];
                                                                                    $highlightReworkstyle = $highlightReworkstyle[0];
																
																
                                                                                    if ($inpuControlType == "TextBox") {
                                                                    echo '<input data-disposition="'.$DispositionFieldsValue.'" data-cmd="'.$CommentsFieldsValue.'" data-seq="'.$thisseq.'" data-disp="'.$valprodFields['DisplayAttributeName'].'" data-projectatt="'.$valprodFields['ProjectAttributeMasterId'].'" readonly="" data-toggle="tooltip" type="text" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . $titleValue .$highlightRework. '>';
                                                                                    } else if ($inpuControlType == "CheckBox") {
                                                                                        echo '<input data-disposition="'.$DispositionFieldsValue.'" data-cmd="'.$CommentsFieldsValue.'" data-seq="'.$thisseq.'" data-disp="'.$valprodFields['DisplayAttributeName'].'" data-projectatt="'.$valprodFields['ProjectAttributeMasterId'].'" readonly="" type="checkbox" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick .$highlightRework. '>';
                                                                } else if ($inpuControlType == "MultiTextBox") {
                                                                
                                                                    echo '<textarea data-disposition="'.$DispositionFieldsValue.'" data-cmd="'.$CommentsFieldsValue.'" data-seq="'.$thisseq.'" data-disp="'.$valprodFields['DisplayAttributeName'].'" data-projectatt="'.$valprodFields['ProjectAttributeMasterId'].'"  style="resize:both;" readonly="" ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur .$highlightReworkstyle.'>'.$ProdFieldsValue.'</textarea>';
                                                                
                                                                }else if ($inpuControlType == "RadioButton") {
                                                                                       if (strtolower($ProdFieldsValue) == "yes")
                                                                                            $yesSel = ' checked="checked"';
                                                                                        if (strtolower($ProdFieldsValue) == "no")
                                                                                            $noSel = ' checked="checked"" ';
                                                                                        echo '<input data-disposition="'.$DispositionFieldsValue.'" data-cmd="'.$CommentsFieldsValue.'" data-seq="'.$thisseq.'" data-disp="'.$valprodFields['DisplayAttributeName'].'" data-projectatt="'.$valprodFields['ProjectAttributeMasterId'].'" readonly="" disabled="disabled" value="Yes" type="radio" style="position:static"' . $inpClass . $inpId . $inpName . $inpOnClick . $yesSel . '> Yes  
																	<input data-disposition="'.$DispositionFieldsValue.'" data-cmd="'.$CommentsFieldsValue.'" data-seq="'.$thisseq.'" data-disp="'.$valprodFields['DisplayAttributeName'].'" data-projectatt="'.$valprodFields['ProjectAttributeMasterId'].'"  value="No" disabled="disabled" type="radio" style="position:static" ' . $inpClass . $inpId . $inpName . $inpOnClick . $noSel . '> No';
                                                                } else if ($inpuControlType == "DropDownList") {
                                                                    echo '<select data-disposition="'.$DispositionFieldsValue.'" data-cmd="'.$CommentsFieldsValue.'" data-seq="'.$thisseq.'" data-disp="'.$valprodFields['DisplayAttributeName'].'" data-projectatt="'.$valprodFields['ProjectAttributeMasterId'].'"  disabled="disabled" ' . $inpClass . $inpId . $inpName . $inpOnClick . $inpOnBlur .$highlightRework .'><option value="">--Select--</option>';
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
                                                                } ?>
                                                                <span class="lighttext more" title="<?php echo $InpValueFieldsValue; ?>"><?php echo $InpValueFieldsValue; ?></span>
																
																<p style="color:#FF0000;"><?php echo $QcErrorComments[$valprodFields['AttributeMasterId']]['seq']['QCTLRebuttedComments'][$tempSq]; ?></p>
                                                            </div>
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                            <div class="form-group comments">
                                                                    <textarea readonly="" rows="1" cols="50" class="form-control <?php echo $dbClassName; ?>" id="" name="<?php echo $CommentsFieldsName; ?>" placeholder="Comments" onclick="loadWebpage(<?php echo $valprodFields['AttributeMasterId']; ?>, <?php echo $valprodFields['ProjectAttributeMasterId']; ?>, <?php echo $valprodFields['MainGroupId']; ?>, <?php echo $valprodFields['SubGroupId']; ?>,<?php echo $tempSq; ?>, 0);" <?php echo $highlightRework;?>><?php echo $CommentsFieldsValue; ?></textarea>
                                                            </div>
                                                                </div>
                                                                <div class="col-md-4 form-status">
                                                            <div class="form-group status">
                                                                <select disabled="disabled" id="" name="<?php echo $DispositionFieldsName; ?>"  class="<?php echo $dbClassName; ?> form-control CampaignWiseSelDone_<?php echo $key; ?> dispositionSelect" <?php echo $highlightRework;?>>
                                                                    <option value="">--</option>
                                                                        <option value="A" <?php
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
                                                             <?php
                    $array1 = $valprodFields['AttributeMasterId'];
                    $array2 = $HelpContantDetails;
                    if (in_array($array1, $array2)) {
                        ?>
                                                                         <i title="Help" class="fa fa-question-circle question m-r-10 m-l-10" data-target="#helpmodal" data-toggle="modal" onclick='loadHelpContent(<?php echo $valprodFields['AttributeMasterId']; ?>, "<?php echo $valprodFields['DisplayAttributeName']; ?>");'></i>
                                                                           
                                                                <?php } ?>
               
                                                            <?php if ($totalSeqCnt > 1) { ?>
                                                                <i class="fa fa-info-circle m-l-10" ata-target="#example-modal" onclick="loadhandsondatafinal('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>','<?php echo $valprodFields['DisplayAttributeName']; ?>');" data-rel="page-tag" data-target="#exampleFillPopup" data-toggle="modal"></i>
                                                                <i class="fa fa-angle-double-left " onclick="loadMultiField('previous', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i>
                                                                <i class="fa fa-angle-double-right m-r-5" onclick="loadMultiField('next', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i> 
                                                            
                                                                <?php } ?>
<!--                                                                  <div style="cursor: pointer;" id='Error_<?php echo $valprodFields['AttributeMasterId']; ?>' style="margin-left:290px;margin-top: -65px;" value='' onclick="query('<?php echo $valprodFields['DisplayAttributeName'];?>', '<?php echo $valprodFields['AttributeMasterId'];?>', '<?php echo $valprodFields['ProjectAttributeMasterId'];?>', '<?php echo $ProdFieldsValue;?>', '<?php echo $CommentsFieldsValue;?>', '<?php echo $DispositionFieldsValue;?>', '<?php echo $thisseq;?>', '<?php echo $valprodFields['ControlName'];?>');" style="margin-top:-4px;"> 
                                                                <img src="img/comments.jpg" />
                                                            </div>-->
                                                                       <?php 

									    $QcCommentStatus = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq]['qccomment_status'];  
									    $QcCommentId = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq]['qccomment_id'];         
									    $QcCommentErrorcat= $processinputdata[$valprodFields['AttributeMasterId']][$tempSq]['qccomment_errorcat'];  
									    $QcCommentErrorsub = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq]['qccomment_errorsub'];   
										$errorcat=$CategoryName[$QcCommentErrorcat];
										$errorsub=$CategoryName[$QcCommentErrorsub];
										if($QcCommentStatus==8){
											$StatusInfo="Accepted";
										}
										else if($QcCommentStatus==9){											
											$StatusInfo="Rejected";
										}
										else{
											$StatusInfo="";
										}
                                        

										if($QcCommentStatus !='6' && $QcCommentStatus !='8' && $QcCommentStatus !='9'){										
																	   
                                     if (isset($OldDataresultError[$valprodFields['AttributeMasterId']]['seq'][$tempSq]) && !empty($tempSq) && !empty($OldDataresultError[$valprodFields['AttributeMasterId']]['seq'][$tempSq]) ) {?>

                            <div class='qcGreen_popuptitle' id='Error_<?php echo $valprodFields['AttributeMasterId']."_".$tempSq; ?>' style="cursor: pointer; margin-bottom: -9px;" value='' onclick="query('<?php echo $valprodFields['DisplayAttributeName'];?>', '<?php echo $valprodFields['AttributeMasterId'];?>', '<?php echo $valprodFields['ProjectAttributeMasterId'];?>', '<?php echo $ProdFieldsValue;?>', '<?php echo $CommentsFieldsValue;?>', '<?php echo $DispositionFieldsValue;?>', '<?php echo $tempSq;?>', '<?php echo $valprodFields['ControlName'];?>');">  </div>
                                        <?php }

                               else if(isset($OldDataresultRebutal[$valprodFields['AttributeMasterId']]['seq'][$tempSq]) && !empty($tempSq) && !empty($OldDataresultRebutal[$valprodFields['AttributeMasterId']]['seq'][$tempSq])) {?>

                            <div class='qcRed_popuptitle' id='Error_<?php echo $valprodFields['AttributeMasterId']."_".$tempSq; ?>' style="cursor: pointer; margin-bottom: -9px;" value='' onclick="query('<?php echo $valprodFields['DisplayAttributeName'];?>', '<?php echo $valprodFields['AttributeMasterId'];?>', '<?php echo $valprodFields['ProjectAttributeMasterId'];?>', '<?php echo $ProdFieldsValue;?>', '<?php echo $CommentsFieldsValue;?>', '<?php echo $DispositionFieldsValue;?>', '<?php echo $tempSq;?>', '<?php echo $valprodFields['ControlName'];?>');">  </div>
                                        <?php }
                                        else
                                           {
                                             
                                           ?>
                            <div class='qc_popuptitle' id='Error_<?php echo $valprodFields['AttributeMasterId']."_".$tempSq; ?>' style="cursor: pointer; margin-bottom: -9px;" value='' onclick="query('<?php echo $valprodFields['DisplayAttributeName'];?>', '<?php echo $valprodFields['AttributeMasterId'];?>', '<?php echo $valprodFields['ProjectAttributeMasterId'];?>', '<?php echo $ProdFieldsValue;?>', '<?php echo $CommentsFieldsValue;?>', '<?php echo $DispositionFieldsValue;?>', '<?php echo $tempSq;?>', '<?php echo $valprodFields['ControlName'];?>');">  </div>
                                           <?php
                                           }
                                           
										}
										else{
                                         ?>
										<div class='qcComments_accept' id='QcCommentsAccept_<?php echo $valprodFields['AttributeMasterId']."_".$thisseq; ?>' style="cursor: pointer;" value='' onclick="qcCommentsAccept('<?php echo $QcCommentId;?>','<?php echo $valprodFields['AttributeMasterId'];?>', '<?php echo $valprodFields['ProjectAttributeMasterId'];?>','<?php echo $thisseq;?>');">  </div>
                                        <div class='qcComments_reject' id='QcCommentsReject_<?php echo $valprodFields['AttributeMasterId']."_".$thisseq; ?>' style="cursor: pointer;" value='' onclick="QcCommentsReject('<?php echo $QcCommentId;?>','<?php echo $valprodFields['AttributeMasterId'];?>','<?php echo $valprodFields['DisplayAttributeName'];?>', '<?php echo $ProdFieldsValue;?>', '<?php echo $CommentsFieldsValue;?>', '<?php echo $DispositionFieldsValue;?>', <?php echo "'".$errorcat."'";?>, <?php echo "'".$errorsub."'";?>);">  </div>
                             	         <div class="qcstatusinfo<?php echo $valprodFields['AttributeMasterId'];?>"> <?php echo $StatusInfo;?></div>
										<?php	
										}
                                         ?>
                                                                     <?php if ($isDistinct === false) {
                                                                            if($valprodFields['IsDistinct']==1) {
                                                                                ?>
<!--                                                                                <i id="add-field" class="fa fa-plus-circle add-field m-r-10 addAttribute" data="<?php echo $valprodFields['AttributeMasterId']; ?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $valprodFields['DisplayAttributeName']; ?>"></i>-->
                                                                                <?php 
                                                                            }
                                                                            } ?>
                                                            </div>
                                                                </div>
                                                                </div>

                                                                
                                                                                                                        <!--<i class="fa fa-minus-circle remove-field"></i>-->
<!--                                                        </div>-->
                                                </div>
																<?php
																}
																?>
                                                    <span style="padding:0px;" class="add_<?php echo $valprodFields['AttributeMasterId']; ?>"></span>

                                                        <input value="1" type="hidden" data="<?php echo $thisseq - 1; ?>" name="ShowingSeqDiv_<?php echo $valprodFields['AttributeMasterId']; ?>" class="ShowingSeqDiv_<?php echo $valprodFields['AttributeMasterId']; ?>">

																<?php
                                                                        
																?>


                                                   
																<?php
																}
																?>

                                                </div>
													<?php 
                                                            } // group seq loop
            ?>
                                                <span style="" class="addGrp_<?php echo $keysub; ?>"></span>
                                            </div>
            <?php }
        ?>
                                        </div>
                                    </div>
                                        <!--                                    ----------------------------first campaign end--------------------------------------->
                                                <?php
                                                $i++;
                                            }
                                            ?>
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
                <!--                <button class="btn btn-default" name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>-->
            </div>
            <div class="col-lg-6 pull-right m-t-5 m-b-5">		
                <!--                <button type="button" class="btn btn-primary pull-right">Submit</button>-->
                <button type="Submit" name='Submit' value="Submit" class="btn btn-primary pull-right" onclick="return formSubmit();"> Submit </button>
                <!--                <button type="button" name='Save' value="Save" id="save_btn" class="btn btn-primary pull-right m-r-5" onclick="AjaxSave('');">Save</button>-->
                               <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodal" data-toggle="modal">Query</button>

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
   <span><h4 style="display: inline-block;">Attribute source link</h4></span>
<!--<span style="float: right;">
    <button type="button" class="btn btn-primary m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button></span>-->
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

		 <!-- Popup new Modal -->
<div class="modal fade modal-fill-in" id="exampleFillPopup" aria-hidden="false" aria-labelledby="exampleFillInHandson" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">x</span>
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
                <label class="col-sm-4 control-label"><b>Comments</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='PUcomments'>-</pre>
                </div>
                <label class="col-sm-4 control-label"><b>Disposition</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='disposition'>-</pre>
                </div>
                <label class="col-sm-4 control-label"><b>Error Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7">
                <?php 
                    echo $this->Form->input('',array('options' => $CategoryName,'default' => '0','name'=>'CategoryName','id'=>'CategoryName','style'=>'width:177px !important;','class'=>'form-control','onchange' => 'getCategory(this.value);')); 
                ?>
                    <br/>
                </div>
                
                <label style="margin-top:16px;" class="col-sm-4 control-label"><b>Error Sub Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7">
                <?php 
                        $SubCategory = array(0 => '-- Select --');
                        echo '<div id="LoadSubCategory">';
                        echo $this->Form->input('', array('options' => $SubCategory, 'id' => 'SubCategory', 'name' => 'SubCategory','style'=>'width:177px !important;', 'class' => 'form-control','value' => $SubCategory));
                        echo '</div>';
                ?>
                    &nbsp;
                </div>
<!--                <label class="col-sm-4 control-label"><b>QC Value&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
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
                  echo $this->Form->button('Mark Error', array( 'id' => 'QuerySubmit', 'name' => 'QuerySubmit', 'value' => 'QuerySubmit','class'=>'btn btn-primary btn-sm','onclick'=>"return valicateQueryInsert();",'type'=>'button')).' '; 
                 echo $this->Form->button('Close', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-primary btn-sm','onclick'=>"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';cleartext();")).' '; 
                    echo $this->Form->button('Delete', array( 'type'=>'button','id' => 'Delete', 'name' => 'Delete', 'value' => 'Delete','class'=>'btn btn-primary btn-sm','onclick'=>"cleartext();return DeleteQuery();")); ?>   
                </div>   
                &nbsp;
                &nbsp; 
            </div>


        </div>
    </div>
    <div id="rebuttal" class="white_content" style="position:fixed;">
        <div class="query_popuptitle"><div style='float:left;width:40%'><b>QC Comments</b></div><div align='right'> <b><a onclick="document.getElementById('rebuttal').style.display = 'none';document.getElementById('rebuttalfade').style.display = 'none';cleartext();"><?php echo $this->Html->image('cancel.png', array('width'=>'20px','height'=>'20px','alt' => 'Close'));?></a></b></div></div>
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
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='Attributeinfo'>-</pre>
                </div>
                <label hidden class="col-sm-4 control-label"><b>AttributeMasterId</b></label>
                <div hidden class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='AttributeMasterId'>-</pre>
                </div>
                <label hidden class="col-sm-4 control-label"><b>ProjectAttributeMasterId</b></label>
                <div hidden class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='ProjectAttributeMasterId'>-</pre>
                </div>
                <label class="col-sm-4 control-label"><b>QC Value</b></label>
                    <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='qcvalueinfo'>-</pre>
                    </div>
                <label class="col-sm-4 control-label"><b>Comments</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='commentsinfo'>-</pre>
                </div>
                <label class="col-sm-4 control-label"><b>Disposition</b></label>
                <div class="col-sm-7">
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='dispositioninfo'>-</pre>
                </div>
                <label class="col-sm-4 control-label"><b>Error Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7">
				
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='CategoryName'>-</pre>
                <?php 
				
                   // echo $this->Form->input('',array('options' => $CategoryName,'default' => '0','name'=>'CategoryName','id'=>'CategoryName','style'=>'width:177px !important;','class'=>'form-control','onchange' => 'getCategory(this.value);')); 
                ?>
                    <br/>
                </div>
                
                <label style="margin-top:16px;" class="col-sm-4 control-label"><b>Error Sub Category&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
                <div class="col-sm-7">
				
                    <pre class="" style='background-color:white;border:0px;padding:0px;' id='SubCategory'>-</pre>
                <?php /*
                        $SubCategory = array(0 => '-- Select --');
                        echo '<div id="LoadSubCategory">';
                        echo $this->Form->input('', array('options' => $SubCategory, 'id' => 'SubCategory', 'name' => 'SubCategory','style'=>'width:177px !important;', 'class' => 'form-control','value' => $SubCategory));
                        echo '</div>';
						*/
                ?>
                    &nbsp;
                </div>
<!--                <label class="col-sm-4 control-label"><b>QC Value&nbsp;<span style='color:red'>&nbsp;*</span></b></label>
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
                <?php 
				echo $this->Form->textarea('', array( 'type'=>'text','id' => 'QCComments', 'name' => 'QCComments','style'=>'margin-bottom:8px;'));
			    echo $this->Form->input('', array( 'type'=>'hidden','id' => 'Id', 'name' => 'Id','value' => '','style'=>'margin-bottom:8px;margin-top:10px;')); 
 			    echo $this->Form->input('', array( 'type'=>'hidden','id' => 'AttributeId', 'name' => 'AttributeId','value' => '','style'=>'margin-bottom:8px;margin-top:10px;')); 
 			    ?>
                </div>

                <div  class="col-sm-10" id='oldData' ></div>

                <div class="col-sm-12" style="text-align:center;margin-top: 7px;">
                <?php
                  echo $this->Form->button('QC Rebutal', array( 'id' => 'QuerySubmit', 'name' => 'QuerySubmit', 'value' => 'QuerySubmit','class'=>'btn btn-primary btn-sm','onclick'=>"return valicateQcrebutal();",'type'=>'button')).' '; 
                 echo $this->Form->button('Close', array( 'type'=>'button','id' => 'Cancel', 'name' => 'Cancel', 'value' => 'Cancel','class'=>'btn btn-primary btn-sm','onclick'=>"document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';cleartext();")).' '; 
                   ?>   
                </div>   
                &nbsp;
                &nbsp; 
            </div>


        </div>
    </div>

    <div id="rebuttalfade" class="black_overlay"></div>
    <div id="fade" class="black_overlay"></div>
    <script type="text/javascript">
    $(document).ready(function() {
    var showChar = 23;  // How many characters are shown by default
    var ellipsestext = "";
    var moretext = "more";
    var lesstext = "less";

$('.more').each(function() {
        var content = $(this).html();

        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
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
			$(document).ready(function() {
	$(document).keyup(function(e) {
		if(e.which == 17) {
			isCtrl = false;
		}
		if(e.which == 16) {
			isShift = false;
		}
	});
	// action on key down
	$(document).keydown(function(e) {
            //alert(e.which);
		if(e.which == 17) {
			isCtrl = true; 
		}
		if(e.which == 16) {
			isShift = true; 
		}
		if(e.which == 69 && isCtrl) {
                   // var focused = document.activeElement;
                    var $focused = $(':focus');
                    name=$focused.attr('name')
            
                    nameArr=name.split("_")
                    type=$focused.attr('type');
                    proj=$focused.attr('data-projectatt');
                    disp=$focused.attr('data-disp');
                    seq=$focused.attr('data-seq');
                    cmd=$focused.attr('data-cmd');
                    disposition=$focused.attr('data-disposition');
		query(disp, nameArr[1], proj, $focused.val(), cmd, disposition, seq, type);	
		} 
	});
	
});
            
        //    jQuery(function($) {
          //      $('object').bind('load', function() {
          //         var childFrame = $(this).contents().find('body');
         //           childFrame.on('dblclick', function() {
        //                var iframe= document.getElementById('frame1');
          //              var idoc= iframe.contentDocument || iframe.contentWindow.document;
            //            var seltext = idoc.getSelection();
              //          $(AttrcopyId).val(seltext);
                //   });
                   
                  // childFrame.bind('mouseup', function(){
                    //    var iframe= document.getElementById('frame1');
                      //  var idoc= iframe.contentDocument || iframe.contentWindow.document;
                      //  var seltext = idoc.getSelection();
                     //   if (seltext.rangeCount && seltext.getRangeAt) {
                       //     range = seltext.getRangeAt(0);
           //             }
             //           idoc.designMode = "on";     // Set design mode to on
                 //       if (range) {
               //             seltext.removeAllRanges();
             //        seltext.addRange(range);
             // }
              //alert(AttrcopyId);
             //   if(seltext!="" && typeof AttrcopyId != 'undefined')
            //         $(AttrcopyId).val(seltext);
           //       idoc.execCommand("hiliteColor", false, "yellow" || 'transparent');
           //         idoc.designMode = "off";    // Set design mode to off
          //       });
          //     });
         //   });
            
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
                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxLoadfirstattribute')); ?>",
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
                        document.getElementById('frame1').data = htmlfileinitial;
							
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
//                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxLoadfirstattribute')); ?>",
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
            //document.getElementById('ProductionFields_'+proKey+'_'+depen+'_1').focus();
			document.getElementById('prodInput_'+proKey).focus();
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
                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxhelptooltip')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, attributeId: attributeId}),
                dataType: 'text',
                async: true,
                success: function (result) {
                    $("#HelpModelContent").html(result);
                    $("#HelpModelAttribute").html(DisplayAttributeName);
                }
            });
        }

//        $('.save').click(function () {
//
//            var text = $('#addurl').val();
//            if (text == '') {
//                alert("Enter Url..");
//                $('#addurl').focus();
//                return false;
//            } else {
//                var re = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
//                if (!re.test(text)) {
//                    alert("Enter Valid Url");
//                    $('#addurl').focus();
//                    return false;
//                }
//                var projectid = $('#ProjectId').val();
//                var regionid = $('#RegionId').val();
//                var inputentityid = $('#InputEntityId').val();
//                var prodentityid = $('#ProductionEntity').val();
//                var attrGrpid = $('#attrGroupId').val();
//                var attrSubGrpid = $('#attrSubGroupId').val();
//                var attrid = $('#attrId').val();
//                var Projattrid = $('#ProjattrId').val();
//                var sequence = $('#seq').val();
//
//                $.ajax({
//                    type: "POST",
//                    url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxinsertreferenceurl')); ?>",
//                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, Seq: sequence}),
//                    dataType: 'text',
//                    async: true,
//                    success: function (result) {
//                        if (result === 'Inserted') {
//                            //alert("Inserted Successfully");
//                            loadWebpage(attrid, Projattrid, attrGrpid, attrSubGrpid, sequence, 1);
//
//                        }
//                    }
//                });
//                $('#addnewurl').hide();
//            }
//        });

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
                    url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxgetafterreferenceurl')); ?>",
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
                                            cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDF(this.id);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
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
                    url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxdeletereferenceurl')); ?>",
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
                    url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxloadmultipleurl')); ?>",
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
                    url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxloadgroupurl')); ?>",
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
                            checkAllUrlAtt();
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
                        ShowUnVerifiedAtt();
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
                function ShowUnVerifiedAtt() {
                    var projectid = $('#ProjectId').val();
                    var regionid = $('#RegionId').val();
                    var inputentityid = $('#InputEntityId').val();
                    var prodentityid = $('#ProductionEntity').val();
                    var sequence = $('#seq').val();
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
                                             $( "#MultiSubGroup_" + key2 + "_" + 1).css("display", "none");
                                             $( "#MultiSubGroup_" + key2 + "_" + 1).removeClass("showFilled");
                                            }
                                            else{
                                                    $( "#MultiSubGroup_" + key2 + "_" + 1).css("display", "block");
                                                     $( "#MultiSubGroup_" + key2 + "_" + 1).addClass("showFilled");
                                                }
                                                
                                            }
                                            });
                                        });
                                        
                                        
                                 $.each(objAttr,function(key,value){
                                        $( "#MultiField_" + value + "_" + 1).css("display", "none");
                                             $( "#MultiField_" + value + "_" + 1).removeClass("showFilled");
                                        }
                                 );       
                                $.each(objshowAttr,function(key,value){
                                        $( "#MultiField_" + value + "_" + 1).css("display", "block");
                                             $( "#MultiField_" + value + "_" + 1).addClass("showFilled");
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
                                        $( "#MultiSubGroup_" + key2 + "_" + 1).css("display", "block");
                                        $( "#MultiSubGroup_" + key2 + "_" + 1).addClass("showFilled");
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
                                        $( "#MultiField_" + value + "_" + 1).css("display", "block");
                                             $( "#MultiField_" + value + "_" + 1).addClass("showFilled");
                                        }
                                        );
                            }
                }
//        function addReferenceUrl() {
//            $('#addnewurl').show();
//            $('#addurl').val('');
//
//        }

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
                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxgetgroupurl')); ?>",
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
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id);" class="current text-center text">' + element['AttributeValue'].substring(0, 45) + '</a>';
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
                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxqueryposing')); ?>",
                data: ({query: query, InputEntyId: InputEntyId, RegionId: regionid}),
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

        // load next attribute
        function loadMultiField(action, attributeMasterId, totalseq) {
            var currentSeq = $(".ShowingSeqDiv_" + attributeMasterId + "").val();
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
        }

        function formSubmitold() {
            <?php /*if(isset($Mandatory)) {
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

            AjaxSave('');
			$(".removeinputclass").remove();
            return true;
        }

        function AjaxSave(addnewpagesave) {

                var mailing_street = $("#prodInput_3265"); //mailing_street - 209
                    var physical_street = $("#prodInput_3223") //physical_street - 209
                    var mailing_city = $("#prodInput_3266") //mailing_city - 209
                    var mailing_state = $("#prodInput_3267") //mailing_state - 209
                    var mailing_country = $("#prodInput_3268") //mailing_country - 209
                    var Mailing_Postal1 = $("#prodInput_3269") //mailing_postal - 209
                    
//                    var mailing_street = $("#prodInput_2980"); //mailing_street - 18
//                    var physical_street = $("#prodInput_2986") //physical_street - 18
//                    var mailing_city = $("#prodInput_2981") //mailing_city - 18
//                    var mailing_state = $("#prodInput_2982") //mailing_state - 18
//                    var mailing_country = $("#prodInput_2983") //mailing_country - 18
//                    var Mailing_Postal1 = $("#prodInput_2984") //mailing_postal - 18
                    
                    if(mailing_street.length){ 
             var mailing_street_value = mailing_street.val();
                    if (mailing_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    mailing_street.focus();
                    return false;
                }
                if(mailing_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    mailing_street.focus();
                    return false;
                }
                if(mailing_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    mailing_street.focus();
                    return false;
                }
                if(mailing_city.length){ 
                    var mailing_city_value = mailing_city.val();
                    if (mailing_street_value =='' && mailing_city_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                }
                if(mailing_state.length){ 
                    var mailing_state_value = mailing_state.val();
                    if (mailing_street_value =='' && mailing_state_value!='') {
                        alert("mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                }
                if(mailing_country.length){ 
                    var mailing_country_value = mailing_country.val();
                    if (mailing_street_value =='' && mailing_country_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                }
                if(Mailing_Postal1.length){ 
                    var Mailing_Postal1_value = Mailing_Postal1.val();
                    if (mailing_street_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                }
                if (['caller', 'lockbox', 'drawer'].indexOf(mailing_street_value.toLowerCase()) >= 0) {
                alert("Remove invalid words in Mailing Street");
                        mailing_street.focus();
                        return false;
                }
                if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                     if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        mailing_street.focus();
                        return false;
                    }
                     }
                }
        }
        if(mailing_city.length){ 
                var mailing_city_value = mailing_city.val();
                var mailing_street_value = mailing_street.val();
                var mailing_country_value = mailing_country.val();
                if (mailing_street_value =='' && mailing_city_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                if (mailing_street_value !='' && mailing_city_value=='') {
                        alert("Mailing city shouldn't be empty");
                        mailing_city.focus();
                        return false;
                    }
                    if (mailing_city_value.match(/\d+/g)){
                        alert('Remove numbers in mailing city');
                        mailing_city.focus();
                        return false;
                    }
                    if (!mailing_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in mailing city');
                        mailing_city.focus();
                        return false;
                    }
                    
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us'){
                    var hyphen_replaced_val =mailing_city_value.replace(/-/g, ' '); 
                    mailing_city.val(hyphen_replaced_val);
                    }
                    
        }
        if(mailing_state.length){ 
                var mailing_state_value = mailing_state.val();
                var mailing_street_value = mailing_street.val();
                    if (mailing_street_value =='' && mailing_state_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_state_value=='') {
                        alert("Mailing state shouldn't be empty");
                        mailing_state.focus();
                        return false;
                    }
    
        }
        if(mailing_country.length){ 
                var mailing_country_value = mailing_country.val();
                var mailing_street_value = mailing_street.val();
                var mailing_city_value = mailing_city.val();
                    if (mailing_street_value =='' && mailing_country_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_country_value=='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        return false;
                    }
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us'){
                    var hyphen_replaced_val =mailing_city_value.replace(/-/g, ' '); 
                    mailing_city.val(hyphen_replaced_val);
                    }
    
        }
        if(Mailing_Postal1.length){ 
                var Mailing_Postal1_value = Mailing_Postal1.val();
                var mailing_country_value = mailing_country.val();
                var mailing_street_value = mailing_street.val();
                if (mailing_street_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        return false;
                    }
                    if (mailing_street_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        Mailing_Postal1.focus();
                        return false;
                    }
                if (mailing_country_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        mailing_country.focus();
                        return false;
                    }
                if (mailing_country_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        return false;
                    }
                var mailing_country_value = mailing_country_value.toLowerCase();
                if(mailing_country_value=='us'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        return false;
                        }
                    }
                if(mailing_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        return false;
                        }
                    }
                if(mailing_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        return false;
                        }
                    }
                if(mailing_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        return false;
                        }
                    }
                    
                    
        }
        if(physical_street.length){ 
                var mailing_street_value = mailing_street.val();
                     var physical_street_value = physical_street.val();
                    if (mailing_street_value =='' && physical_street_value !='') {
                        alert("Mailing street shouldn't be empty");
                        physical_street.focus();
                        return false;
                    }
                    if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        physical_street.focus();
                        return false;
                    }
                     }
                    
                }

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
                url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxsave')); ?>",
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
                }
            });
        }

    </script>
</body>
<div id="fade" class="black_overlay"></div>
    <?php
       // echo $this->Form->end();   
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
        var closestDisVal = thisObj.parent().parent().find(".dispositionSelect").val();
        //if(closestDisVal=="") {
        var thisinpuval = thisObj.val().toLowerCase();
        ;
        var spaninpuval = thisObj.parent().find('.lighttext').text().toLowerCase();
        ;

        if (spaninpuval == thisinpuval && spaninpuval != "") {
            thisObj.parent().parent().find(".dispositionSelect").val('V');
        }

        if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval != "") {
            thisObj.parent().parent().find(".dispositionSelect").val('M');
        }

        if (spaninpuval != thisinpuval && spaninpuval == "" && thisinpuval != "") {
            thisObj.parent().parent().find(".dispositionSelect").val('A');
        }
        //}
    }

    function getJob()
    {
        window.location.href = "QCValidation?job=newjob";
    }

    $(document).ready(function () {
        Load_totalAttInThisGrpCnt();

        $(document).on("blur", ".doOnBlur", function (e) {
            Load_verifiedAttrCnt($(this));
            Load_totalAttInThisGrpCnt();
        });

        $(document).on("change", ".dispositionSelect", function (e) {
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
            var atributeId = $(this).attr("data");
            var groupId = $(this).attr("data-groupId");
            var groupName = $(this).attr("data-groupName");
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt) + 1;

            var inpName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var commendName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
            var selName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
            //alert(nxtSeq);
            var toappendData = '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important" class="row form-responsive MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                    '<div class="col-md-2 form-title"><div class="form-group" style=""><p>' + groupName + '</p></div></div>' +
                    '<div class="col-md-3 form-text"><div class="form-group">' +
                    '<input type="text" class="form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' +
                    '<span class="lighttext more" title=""></span>' +
                    '</div></div>' +
                    '<div class="col-md-3 form-text"><div class="form-group comments">' +
                    '<textarea rows="1" cols="50" class="form-control InsertFields" id="" name="' + commendName + '" placeholder="Comments"></textarea>' +
                    '</div></div>' +
                    '<div class="col-md-4 form-status"><div class="form-group status">' +
                    '<select id="" name="' + selName + '" class="form-control CampaignWiseSelDone_' + groupId + ' dispositionSelect InsertFields">' +
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
        });

        $('.addSubgrpAttribute').on('click', function () {


            var subgrpId = $(this).attr("data");
            ;
            var groupId = $(this).attr("data-groupId");
            //alert('<?php //echo json_encode($AttributesListGroupWise); ?>');
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
            var groupName = 'Organization Status';

            var maxSeqCnt = $('.GroupSeq_' + subgrpId).attr("data");
            //maxSeqCnt=1;
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            toappendData = '<div ><font style="color:#62A8EA">Page : <b>' + nxtSeq + '</b></font><i class="fa fa-minus-circle removeGroup-field pull-right" data="' + subgrpId + '" style="top:0px"></i><br>';
            $.each(subGrpAttArr, function (key, element) {
                //alert (JSON.stringify(element));
                atributeId = element['AttributeMasterId'];

                var inpName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
                var commendName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
                var selName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
                //alert(inpName);
                toappendData += '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important"  class=" row form-responsive clearfix MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                        '<div class="col-md-2 form-title"><div class="form-group" style=""><p>' + element['DisplayAttributeName'] + '</p></div></div>' +
                        '<div class="col-md-3 form-text"><div class="form-group">' +
                        '<input type="text" class="form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' +
                        '<span class="lighttext more" title=""></span>' +
                        '</div></div>' +
                        '<div class="col-md-3 form-text"><div class="form-group comments">' +
                        '<textarea rows="1" cols="50" class="form-control InsertFields" id="" name="' + commendName + '" placeholder="Comments"></textarea>' +
                        '</div></div>' +
                        '<div class="col-md-4 form-status"><div class="form-group status">' +
                        '<select id="" name="' + selName + '" class="form-control CampaignWiseSelDone_' + groupId + ' dispositionSelect InsertFields">' +
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
        });

    });

//    function PdfPopup()
//    {
//
//        var splitterElement = $("#horizontal"), getPane = function (index) {
//            index = Number(index);
//            var panes = splitterElement.children(".k-pane");
//            if (!isNaN(index) && index < panes.length) {
//                return panes[index];
//            }
//        };
//
//        var splitter = splitterElement.data("kendoSplitter");
//        var pane = getPane('0');
//        splitter.toggle(pane, $(pane).width() <= 0);
//
//
//        var file = $("#status option:selected").text();
//        myWindow = window.open("", "myWindow", "width=500, height=500");
//        myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:100%; overflow:hidden !important;"></iframe>');
//
//        $.ajax({
//            type: "POST",
//            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'upddateUndockSession')); ?>",
//            data: ({undocked: 'yes'}),
//            dataType: 'text',
//            async: true,
//            success: function (result) {
//
//            }
//        });
//    }
    function onMyFrameLoad() {
        $('#loaded').val('loaded');
    }
    </script>
<style>
    .black_overlay{display: none;position: fixed;top: 0%;left: 0%;width: 100%;height: 100%;background:#8F8F8F;z-index:1001;-moz-opacity: 0.8;opacity:.80;filter: alpha(opacity=80);}
    .white_content{display: none;position: absolute;top: 15%;left: 25%;width: 50%;height: auto;padding: 16px;border: 5px solid #fff;z-index:1002; background:url("img/popupbg.png") repeat-x  left top #fdfdfd;}
    .query_popuptitle{background:url("img/question.gif") no-repeat left top; margin:0px 30px 10px 0px;}
    .query_popuptitle{margin:0px 30px 10px 0px;}
    .query_innerbdr {background:#c8c8c8; padding:2px; border-radius:5px; }
    .query_outerbdr{background:#fff; margin:3px; border-radius:5px; padding:6px;}
    .query_popuptitle b,.query_popuptitle1 b, .comment_popuptitle b,.allocation_popuptitle b,.rebute_popuptitle b,.reallocation_popuptitle b{padding:0px 0px 0px 30px;font-size: 12px;text-transform:uppercase;}
    .qc_popuptitle{background:url("img/comment.png") no-repeat left top;width:21px;height:21px; }
    .qcGreen_popuptitle{background:url("img/commentGreen.png") no-repeat left top;width:21px;height:21px; }
    .qcRed_popuptitle{background:url("img/commentRed.png") no-repeat left top;width:21px;height:21px; }
</style>

<script>
    function query(attname, AttributeMasterId, ProjectAttributeMasterId, PUvalue, PUcomments, disposition, seq, ButtonType)
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
        if (PUvalue == '') {
            $('#PUvalue').text('--');
        } else {
            $('#PUvalue').text(PUvalue);
        }
        if (PUcomments == '') {
            $('#PUcomments').text('--');
        } else {
            $('#PUcomments').text(PUcomments);
        }
        if (disposition == '') {
            $('#disposition').text('--');
        } else {
            $('#disposition').text(disposition);
        }
//        if (ButtonType == 'RadioButton') {
//            ButtonType = '1';
//            $('#QcCtl').hide();
//            $('#QcCtlRadio').show();
//            //$('#QcCtlCmnd').hide();
//        }
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
//        var SequenceNumber = $('#page').val();
//        if (SequenceNumber == '') {
//            SequenceNumber = '1';
//        }
//var SequenceNumber = '1';
        //  var page = $('#page').val();
        // var page = 1;
        var next_status_id = '<?php echo $next_status_id;?>';
       
        var ProductionEntity = $('#ProductionEntity').val();
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: seq, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
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

        $('#Attribute').text(attname);
        $('#AttributeMasterId').text(AttributeMasterId);
        $('#ProjectAttributeMasterId').text(ProjectAttributeMasterId);
        //  $('#ButtonType').text(ButtonType);


        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetrebutaldata'));?>",
            data: ({page: seq, next_status_id: next_status_id, ProductionEntity: ProductionEntity, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('oldData').innerHTML = result;
            }
        });



        showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, seq);
	
                $('#attrId').val(AttributeMasterId);
                $('#ProjattrId').val(ProjectAttributeMasterId);
                $('#seq').val(seq);
    }
    //QC script
    function Rebuttalquery(attname, AttributeMasterId, ProjectAttributeMasterId, PUvalue, PUcomments, disposition, seq, ButtonType)
    {

        document.getElementById('rebuttal').style.display = 'block';
        document.getElementById('rebuttalfade').style.display = 'block';

        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        if (Attribute == '')
            Attribute = '-';
        if (AttributeMasterId == '')
            AttributeMasterId = '-';
        if (ProjectAttributeMasterId == '')
            ProjectAttributeMasterId = '-';
        if (PUvalue == '') {
            $('#PUvalue').text('--');
        } else {
            $('#PUvalue').text(PUvalue);
        }
        if (PUcomments == '') {
            $('#PUcomments').text('--');
        } else {
            $('#PUcomments').text(PUcomments);
        }
        if (disposition == '') {
            $('#disposition').text('--');
        } else {
            $('#disposition').text(disposition);
        }
//        if (ButtonType == 'RadioButton') {
//            ButtonType = '1';
//            $('#QcCtl').hide();
//            $('#QcCtlRadio').show();
//            //$('#QcCtlCmnd').hide();
//        }
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
//        var SequenceNumber = $('#page').val();
//        if (SequenceNumber == '') {
//            SequenceNumber = '1';
//        }
//var SequenceNumber = '1';
        //  var page = $('#page').val();
        // var page = 1;
        var next_status_id = '<?php echo $next_status_id;?>';
       
        var ProductionEntity = $('#ProductionEntity').val();
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";

        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: seq, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
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

        $('#Attribute').text(attname);
        $('#AttributeMasterId').text(AttributeMasterId);
        $('#ProjectAttributeMasterId').text(ProjectAttributeMasterId);
        //  $('#ButtonType').text(ButtonType);


        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetrebutaldata'));?>",
            data: ({page: seq, next_status_id: next_status_id, ProductionEntity: ProductionEntity, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                document.getElementById('oldData').innerHTML = result;
            }
        });



        showOldData(PUvalue, attname, AttributeMasterId, ProjectAttributeMasterId, InputEntyId, seq);
	
                $('#attrId').val(AttributeMasterId);
                $('#ProjattrId').val(ProjectAttributeMasterId);
                $('#seq').val(seq);
    }

</script>
<script>
//        function formSubmit() {
//        var ProjectId = "<?php echo $productionjob['ProjectId'];?>";
//        var RegionId = "<?php echo $productionjob['RegionId'];?>";
//        var InputEntityId = "<?php echo $productionjob['InputEntityId'];?>";
//        var UserId = "<?php echo $productionjob['UserId'];?>";
//        var SequenceNumber = $('#page').val();
//
//
//        $.ajax({
//            type: "POST",
//            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'rebutalCommentsCount')); ?>",
//            data: ({ProjectId: ProjectId, RegionId: RegionId, InputEntityId: InputEntityId, UserId: UserId, SequenceNumber: SequenceNumber}),
//            dataType: 'text',
//            async: false,
//            success: function (result) {
//                if (result != '') {
//                    $('#resultcnt').val(result);
//                } else {
//                    $('#resultcnt').val('');
//                }
//            }
//        });
//        var resultcnt = $('#resultcnt').val();
//        if (resultcnt != '') {
//            alert("TL Rebutal Records in page " + resultcnt + ". Please Mark Error or Delete");
//            return false;
//        } else {
//            return true;
//        }
//
//         <?php
if(isset($Mandatory)) {
$js_array = json_encode($Mandatory);
echo "var mandatoryArr = ". $js_array . ";\n";
}
?>//
//        var mandatary = 0;
//
////        if (typeof mandatoryArr != 'undefined') {
////            $.each(mandatoryArr, function (key, elementArr) {
////                element = elementArr['AttributeMasterId']
////
////                if ($('#' + element).val() == '') {
////                    // alert(($('#' + element).val()));
////                    alert('Enter Value in ' + elementArr['DisplayAttributeName']);
////                    $('#' + element).focus();
////                    mandatary = '1';
////                    return false;
////                }
////            });
////        }
//
//
//        if (mandatary == 0) {
//            AjaxSave('');
//            return true;
//
//        } else
//            return false;
//    }
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
//                {collapsible: true},
//                {collapsible: false},
//                {collapsible: true}
//            ]
//        });
//
//        var splitter = splitterElement.data("kendoSplitter");
//        var leftPane = $("#left-pane");
//        splitter["collapse"](leftPane);
//        var file = $("#status option:selected").text();
//
//        myWindow = window.open("", "myWindow", "width=500, height=500");
//        myWindow.document.write('<iframe id="pdfframe"  src="' + file + '" style="width:100%; height:100%; overflow:hidden !important;"></iframe>');

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
            url: "<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'upddateUndockSession')); ?>",
            data: ({undocked: 'yes'}),
            dataType: 'text',
            async: true,
            success: function (result) {

            }
        });

    }

    function cleartext()
    {
        //alert("inside");
        $("#CategoryName").val(0);
        $("#SubCategory").val(0);
        //  $('#QCValueTextbox').val('');
        //   $('#QCValueMultiTextbox').val('');
        //   $('#QCValueDropdown').val('');
        //   $('#Reference').val('');
        $('#QCComments').val('');

    }

    function LoadValue(id, value, toid) {

        var Region = $('#RegionId').val();
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxloadresult'));?>",
            data: ({id: id, value: value, toid: toid, Region: Region}),
            dataType: 'text',
            async: false,
            success: function (result) {
                var obj = JSON.parse(result);
                // alert(JSON.stringify(obj));
                var k = 1;
                //toid = 225;
                var x = document.getElementById(toid);
                document.getElementById(toid).options.length = 0;
                var option = document.createElement("option");
                option.text = '--Select--';
                option.value = 0;
                x.add(option, x[0]);
                $.each(obj, function (key, element) {
                    //   obj.forEach(function (element) {
                    //  alert(element['Value'])
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
                    url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxautofill'));?>",
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

        //alert($('#235').val());
        document.getElementById('fade').style.display = 'block';
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
//                // alert(element);
//                // alert(($('#' + element).val()));
//                if ($('#' + element).val() == '') {
//                    alert('Enter Value in ' + elementArr['DisplayAttributeName']);
//                    $('#' + element).focus();
//                    mandatary = '1';
//                    return false;
//                }
//            });
//        }
        if (mandatary == 0) {
            // AjaxSave('');
            // return true;

        } else
            return false;
        //alert('test');

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

        //alert($('#6233').val());

        $.each(prodArr, function (key, element) {
            if (element['AttributeMasterId'] != '') {
                var elt = element['AttributeMasterId'];
                var elts = element['ProjectAttributeMasterId'];
                // alert(elt);
                //alert($('#'+elt).val());
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
        //alert(productionData); 
        if (typeof dynamicArr != 'undefined') {
            $.each(dynamicArr, function (key, element) {
                //dynamicArr.forEach(function (element) {
                //alert(JSON.stringify(element));
                //alert(element['AttributeMasterId']);
                if (element['AttributeMasterId'] != '') {
                    var elt = element['AttributeMasterId'];
                    //alert(element.length);
                    dynamicData[i] = $('#' + elt).val();
                    dynamicData_ely[j] = elt;
                    //  alert(productionData[elt]);
                }
                i++;
                j++;
            });
        }
        s = 0;
        v = 0;


        if (typeof staticArr != 'undefined') {
            $.each(staticArr, function (key, element) {
                //dynamicArr.forEach(function (element) {
                //alert(JSON.stringify(element));
                //alert(element['AttributeMasterId']);
                if (element['AttributeMasterId'] != '') {
                    //alert('coming');
                    var elt = element['AttributeMasterId'];
                    //alert($('#' + elt).val());
                    staticDatavar[s] = $('#' + elt).val();
                    staticData_elyvar[v] = elt;
                    //  alert(productionData[elt]);
                }
                s++;
                v++;
            });
        }
//alert(staticDatavar);
        var ProductionEntity = $('#ProductionEntity').val();
        var SequenceNumber = $('#page').val();
        var TimeTaken = $('#TimeTaken').val();
        var RegionId = $('#RegionId').val();
        $('#ADDNEW').val('');
        if (addnew == '') {
            var result = new Array();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxsave'));?>",
                data: ({productionData_ely: productionData_ely, productionData_projatt: productionData_projatt, productionData: productionData, dynamicData: dynamicData, dynamicData_ely: dynamicData_ely, ProductionEntity: ProductionEntity, SequenceNumber: SequenceNumber, TimeTaken: TimeTaken, RegionId: RegionId}),
                dataType: 'text',
                async: false,
                success: function (result) {
                    //alert(result);
                    if (result === 'saved') {
                        // alert(addnewpagesave);
                        if (addnewpagesave == '') {
                            //    alert('Entered Data Successfully saved!');
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
                url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxnewsave'));?>",
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
            // page = parseInt(page) + 1;
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
        // $('#page').val(page);
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
        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
        var AttributeMasterId = 0;
        var ProjectAttributeMasterId = 0;
        var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxgetnextpagedata'));?>",
            data: ({page: page, next_status_id: next_status_id, AttributeMasterId: AttributeMasterId, ProjectAttributeMasterId: ProjectAttributeMasterId, ProductionEntity: ProductionEntity, InputEntyId: InputEntyId}),
            dataType: 'text',
            async: false,
            success: function (result) {
                if (result == 'expired') {
                    window.location = "users";
                }
                var resultData = JSON.parse(result);
                $.each(prodArr, function (key, element) {
                    // prodArr.forEach(function (element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData['attrval'][elt]);

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
                // alert('enter');
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

        var next_status_id = '<?php echo $next_status_id;?>';
        var ProductionEntity = $('#ProductionEntity').val();


        var AttributeMasterId = 0;
        var ProjectAttributeMasterId = 0;
        var productionData = new Array();
        var productionData_ely = new Array();
        var dynamicData = new Array();
        var dynamicData_ely = new Array();
        var prodArr =<?php echo json_encode($ProductionFields );?>;
        var dynamicArr =<?php if(isset($DynamicFields)) { echo json_encode($DynamicFields );} else echo "''";?>;
        var readonlyArr =<?php echo json_encode($ReadOnlyFields );?>;
        var i = 0;
        j = 0;

        var InputEntyId = "<?php echo $productionjob['InputEntityId'];?>";
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

                $.each(prodArr, function (key, element) {
                    //prodArr.forEach(function (element) {
                    var elt = element['AttributeMasterId'];
                    $('#' + elt).val(resultData['attrval'][elt]);

                    $('#Error_' + elt).removeClass("qcGreen_popuptitle");
                    $('#Error_' + elt).removeClass("qcRed_popuptitle");
                    $('#Error_' + elt).addClass("qc_popuptitle");

                    if (resultData['attrcnt'] != '') {
                        for (var k = 0; k < (resultData['attrcnt']).length; k++) {
                            if ((resultData['attrcnt'][k]) == elt) {
                                $('#Error_' + elt).addClass("qcGreen_popuptitle");
                                $('#Error_' + elt).removeClass("qc_popuptitle");
                            } else {
                                $('#Error_' + elt).addClass("qc_popuptitle");
                            }
                        }
                    }
                    if (resultData['attrRebutal'] != '') {
                        for (var k = 0; k < (resultData['attrRebutal']).length; k++) {
                            if ((resultData['attrRebutal'][k]) == elt) {
                                $('#Error_' + elt).addClass("qcRed_popuptitle");
                                $('#Error_' + elt).removeClass("qc_popuptitle");
                            } else {
                                $('#Error_' + elt).addClass("qc_popuptitle");
                            }
                        }
                    }
                    i++;
                    j++;

                });
                document.getElementById('fade').style.display = '';
            }
        });


    }

</script>
<style>

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
    #exampleFillPopup #vertical {
        height: 400px;
        margin: 0 auto;
    }
    #left-pane,#right-pane  { background-color: rgba(60, 70, 80, 0.05); }
    .pane-content {
        padding: 0 10px;
    }
</style>
 <?php
if ($this->request->query['continue'] == 'yes') {
    echo "<script>getJob();</script>";
        }
    ?>
<script>
    $(window).bind("load", function () {
        var leftpaneSize = '<?php echo $session->read("leftpaneSize"); ?>';
        var splitter = $("#horizontal").data("kendoSplitter");
        splitter.size(".k-pane:first", leftpaneSize);
    });
</script>


<script>
    $(window).unload(function () {
        myWindow.close();
    });


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
                    // document.getElementById('Reference').value = resultData['Reference'];
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
         //var SequenceNumber = 1;
        var SequenceNumber = $('#seq').val();
        var AttributeStatus = $("#AttributeStatus").val();
        var AttributeMasterId = $("#AttributeMasterId").html();
        var ProjectAttributeMasterId = $("#ProjectAttributeMasterId").html();
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
                    showOldData(OldValue, Attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntityId, SequenceNumber);
                     $('#Error_' + AttributeMasterId).removeClass("qcGreen_popuptitle");
                     $('#Error_' + AttributeMasterId).addClass("qc_popuptitle");
                }, 2000);
            }

        });
        $('#QuerySubmit').show();
        $('#Cancel').show();
        $('#Delete').show();

    }
    function valicateQueryInsert()
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
        var AttributeMasterId = $('#attrId').val();
         //var SequenceNumber = 1;
        var SequenceNumber = $('#seq').val();
        var AttributeStatus = $("#AttributeStatus").val();
    //    var AttributeMasterId = $("#AttributeMasterId").html();
       var ProjectAttributeMasterId = $('#ProjattrId').val();

        var ErrCategory = $.trim($('#CategoryName').val());
        var ErrSubCategory = $.trim($('#SubCategory').val());

        var Reference = $.trim($('#Reference').val());
        // var QCValueTextbox = $.trim($('#QCValueTextbox').val());
        //  var QCValueMultiTextbox = $.trim($('#QCValueMultiTextbox').val());
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
                //    $("#Reference").val('');
                 //   $("#QCComments").val('');
                   // $("#CategoryName").val(0);
                  //  $("#SubCategory").val(0);
               //     showOldData(OldValue, Attribute, AttributeMasterId, ProjectAttributeMasterId, InputEntityId, SequenceNumber);
//                    $('#Error_' + AttributeMasterId).removeClass("qc_popuptitle");
//                    $('#Error_' + AttributeMasterId).addClass("qcGreen_popuptitle");\

                    $('#Error_' + AttributeMasterId+'_'+SequenceNumber).removeClass("qc_popuptitle");
                    $('#Error_' + AttributeMasterId+'_'+SequenceNumber).addClass("qcGreen_popuptitle");
                    
                }, 2000);
            }

        });
        $('#QuerySubmit').show();
        $('#Cancel').show();
        $('#Delete').show();
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
    
    	
    
    function loadhandsondatafinal(id, idval, key, keysub, submenu) {
        var ProductionEntityId = $("#ProductionEntity").val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxgetdatahand')); ?>',
            dataType: 'text',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id, title:submenu},
            success: function (res) {
                $(".hot").html(res);
                }
        });
        }




function loadhandsondatafinal_all(id, idval, key, keysub,submenu) {
 var ProductionEntityId = $("#ProductionEntity").val();

            $.ajax({
            url: '<?php echo Router::url(array('controller' => 'QCValidation', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'text',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,handskey:key,handskeysub:keysub,title:submenu},
            success: function (res) {
                    

	     $(".hot").html(res);
            }
        });
        
        }
                
    //pu rework code
    function qcCommentsAccept(Id,AttributeMasterId, ProjectAttributeMasterId,seq){ 
        var result = new Array();
		$('.qcstatusinfo'+AttributeMasterId).text('Accepted');     
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxupdateacceptstatus'));?>",
            data: ({Id: Id}),
            dataType: 'text',
            async: false,
            success: function (result) {          
            }
        });
    }
            
	function QcCommentsReject(Id,AttributeMasterId,AttributeName,Attributeval,Comments,disposition,errorcat,errorsubcat){

      document.getElementById('rebuttal').style.display = 'block';
        document.getElementById('rebuttalfade').style.display = 'block';
        if(AttributeName==""){
			AttributeName="-";
		} 
		if(Comments==""){
			Comments="-";
		} 
		if(Attributeval==""){
			Attributeval="-";
		} 
		if(disposition==""){
			disposition="-";
		} 
		if(errorcat==""){
			errorcat="-";
		}
		if(errorsubcat==""){
			errorsubcat="-";
		}
        $('#Attributeinfo').text(AttributeName);
        $('#commentsinfo').text(Comments);
        $('#qcvalueinfo').text(Attributeval);
        $('#dispositioninfo').text(disposition);		
        $('#CategoryName').text(errorcat);		
        $('#SubCategory').text(errorsubcat);
        $('#Id').val(Id);
        $('#AttributeId').val(AttributeMasterId);
		
		
		
       
	}

function valicateQcrebutal(){		
		    var AttributeId = $('#AttributeId').val();
          $('.qcstatusinfo'+AttributeId).text('Rejected');  
        var commentstype = $('#QCComments').val();	
        var Id = $('#Id').val();
		 var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxupdaterejectstatus'));?>",
            data: ({Id: Id, comment: commentstype}),
            dataType: 'text',
            async: false,
            success: function (result) {
              
            }
        });
		document.getElementById('rebuttal').style.display = 'none';
		document.getElementById('rebuttalfade').style.display = 'none';
		cleartext();
			return true;
}
 function formSubmit() {
   
        var QCrework  = $('#getreworkjob').val();	
        var QCrework_next_id  = $('#qc_rework_nexeId').val();	
        var project  = $('#ProjectId').val();	
        var entity  = $('#InputEntityId').val();	
		 var result = new Array();
        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller'=>'QCValidation','action'=>'ajaxformsubmit'));?>",
            data: ({rework: QCrework, projectId: project, entityId: entity , nextId: QCrework_next_id}),
            dataType: 'text',
            async: false,
            success: function (result) {
              if(result > 0){
				// $( "#ProductionArea" ).submit();              		 
			  }
			  else{
				  /*
				   $('#submitinfo').show();
				   setTimeout(function() { $("#submitinfo").hide(); }, 5000);*/
				   alert("One or more QC Rework not verified!");
				   
				 return false;
                 				 
			  }
            }
        });
		
        }
    
    
</script>