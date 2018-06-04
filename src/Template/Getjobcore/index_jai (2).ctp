<<<<<<< .mine
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
        min-height: 200px;
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
        width: 12em;
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
                        <?php 
                       //pr($productionjob);
                       //pr($StaticFields);
                        $n= 0;
                        ?>
                          <div><b><?php  $n= 0; $prefix = '';
                        foreach ($staticFields as $key) { 
                          echo $prefix.$staticFields[$n]['AttributeValue'];
                            $prefix = ' | '; 
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
		
        <!-- Breadcrumb Ends -->
        <div class="panel m-l-30 m-r-30">
            <div class="panel-body">
                <div id="splitter">
					<span style="display:none;">
						<input type="checkbox" class="chk-wid-Url" onClick="checkAllUrlAtt()" id="chk-wid-Url" value="1" > Hide Other Fields
					</span>
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
                                            <a class="nav-link" data-toggle="tab" href="#googletab" aria-controls="googletab" role="tab">Google Search</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#mainurl" aria-controls="mainurl" role="tab">Website</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="leftpane">
                                        <div class="tab-pane active" id="exampleTabsOne" role="tabpanel" style="display:none !important;">
                                            <object width="100%" onload="onMyFrameLoad(this)" height="100%" style="visibility:visible" id="frame1" name="frame1" data="" width="auto" height="auto"></object>

                                        </div>
                                        <div class="tab-pane" id="googletab" role="tabpanel">
                                            <div>
                                                <div class="goto"><a href="javascript: void(0);" onclick="$('#frame2').attr('data', 'https://www.google.co.in').hide().show();"> Go to Google </a></div>
                                                <div><object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame2" sandbox="" data="https://www.google.com/ncr"></object></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="mainurl" role="tabpanel">
                                           <object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame3" sandbox="" data="<?php echo $getDomainUrl; ?>" ></object>
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

                                <input type="hidden" name="attrGroupId" id="attrGroupId">
                                <input type="hidden" name="attrSubGroupId" id="attrSubGroupId">
                                <input type="hidden" name="attrId" id="attrId">
                                <input type="hidden" name="ProjattrId" id="ProjattrId">
                                <input type="hidden" name="seq" id="seq">
                                <input type="hidden" name="refUrl" id="refUrl">

                                <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
                                    
                                            <?php
                                            $i = 0;
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
                                                <div class="col-md-6 row-title">
                                                
                                                                <?php if ($isDistinct !== false) {
                                                                    ?>
                                                                 <i id="subgrp-add-field" style="margin-top:5px;" class="fa fa-plus-circle pull-right add-field m-r-10 addSubgrpAttribute" data="<?php echo $keysub; ?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>"></i> 
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
                                                <i class="fa fa-info-circle m-r-10 m-l-10 pull-right"  onclick="loadhandsondatafinal_all('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>');" data-rel="page-tag" data-target="#exampleFillInHandson" data-toggle="modal"></i>
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
																					$ScoreFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Score']]['0'];
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
                                                                                    $inpOnClick = 'onclick="getThisId(this.id); loadWebpage(' . $valprodFields['AttributeMasterId'] . ', ' . $valprodFields['ProjectAttributeMasterId'] . ', ' . $valprodFields['MainGroupId'] . ', ' . $valprodFields['SubGroupId'] . ', ' . $tempSq . ', 0);" ';
                                                                            ?>
															<div class="commonClass commonclass_<?php echo $valprodFields['MainGroupId']?>" id="groupAttr_<?php echo $valprodFields['AttributeMasterId'].'_'.$grpseq?>">
                                                            <div id="MultiField_<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $thisseq; ?>" class="clearfix MultiField_<?php echo $valprodFields['AttributeMasterId']; ?> CampaignWiseFieldsDiv_<?php echo $key; ?> row form-responsive" style="<?php echo $disnone; ?>" >
                                                                
                                                                <div class="col-md-2 form-title">
                                                                <div class="form-group" style=""><p><?php echo $valprodFields['DisplayAttributeName'] ?></p>
                                                                    <input type="hidden" value="<?php echo $valprodFields['DisplayAttributeName'] ?>" id="attrdisp<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>">
                                                                </div>	
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                                <div class="form-group">
                                                                                    <?php
                                                                                    if ($inpuControlType == "TextBox") {
                                                                                        echo '<input type="text" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . '>';
                                                                                    } else if ($inpuControlType == "CheckBox") {
                                                                                        echo '<input type="checkbox" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . '>';
																					} else if ($inpuControlType == "MultiTextBox") {
                                                                                        echo '<textarea ' . $inpClass . $inpId . $inpName . $inpOnClick . '>'.$ProdFieldsValue.'</textarea>';
                                                                                    } else if ($inpuControlType == "RadioButton") {
                                                                                        
                                                                                        if ($ProdFieldsValue == "Yes")
                                                                                            $yesSel = 'checked="checked"';
                                                                                        if ($ProdFieldsValue == "No")
                                                                                            $noSel = ' checked="checked" ';
                                                                                        echo '<input value="Yes" style="position:static"  type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $yesSel . '> Yes  
																	<input style="position:static" value="No" type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $noSel . '> No';
                                                                                    }
                                                                                    else if ($inpuControlType == "DropDownList") {
                                echo '<select ' . $inpClass . $inpId . $inpName . $inpOnClick . '><option value="">--Select--</option>';
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
                                                                    <span class="lighttext" data-toggle="tooltip" title="<?php echo $InpValueFieldsValue; ?>"><?php echo $InpValueFieldsValue; ?></span><?php echo $ScoreFieldsValue; ?>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                                <div class="form-group comments">
                                                                    <textarea rows="1" cols="50" class="form-control <?php echo $dbClassName; ?>" id="" name="<?php echo $CommentsFieldsName; ?>" placeholder="Comments" onclick="loadWebpage(<?php echo $valprodFields['AttributeMasterId']; ?>, <?php echo $valprodFields['ProjectAttributeMasterId']; ?>, <?php echo $valprodFields['MainGroupId']; ?>, <?php echo $valprodFields['SubGroupId']; ?>,<?php echo $tempSq; ?>, 0);"><?php echo $CommentsFieldsValue; ?></textarea>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-4 form-status">
                                                                <div class="form-group status">
                                                                    <select id="" name="<?php echo $DispositionFieldsName; ?>"  class="<?php echo $dbClassName; ?> form-control CampaignWiseSelDone_<?php echo $key; ?> dispositionSelect">
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
               
                                    <?php if ($totalSeqCnt > 1) {
                                                                            ?>
                                                                 
                                                                <i class="fa fa-info-circle m-l-10" ata-target="#example-modal" onclick="loadhandsondatafinal('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>');" data-rel="page-tag" data-target="#exampleFillInHandson" data-toggle="modal"></i>
                                                                <i class="fa fa-angle-double-left " onclick="loadMultiField('previous', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i>
                                                                <i class="fa fa-angle-double-right m-r-5" onclick="loadMultiField('next', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i> 
                                                            
                                                                <?php
                                                            } ?>
                                                                     <?php if ($isDistinct === false) {
                                                                            if($valprodFields['IsDistinct']==1) {
                                                                                ?>
                                                                                <i id="add-field" class="fa fa-plus-circle add-field m-r-10 addAttribute" data="<?php echo $valprodFields['AttributeMasterId']; ?>" date-subgrpId="<?php echo $keysub;?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $valprodFields['DisplayAttributeName']; ?>"></i>
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
                <button type="button" href="#" class="btn btn-default offcanvas__trigger--open" onclick="multipleUrl();" id="multiplelinkbutton" data-rel="page-tag">Multiple Source Links</button>
                <button type="button" class="btn btn-default offcanvas__trigger--close" onclick="loadReferenceUrl();" data-rel="page-tag" data-target="#exampleFillIn" data-toggle="modal">View All</button>
                <!--                <button class="btn btn-default" name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>-->
            </div>
            <div class="col-lg-6 pull-right m-t-5 m-b-5">		
                <button type="submit" name='Submit' value="saveandexit" class="btn btn-primary pull-right m-r-5" onclick="return formSubmit();"> Submit & Exit </button>
                <button type="submit" name='Submit' value="saveandcontinue" class="btn btn-primary pull-right " onclick="return formSubmit();" style="margin-right: 5px;"> Submit & Continue </button>
                <button type="button" name='Save' value="Save" id="save_btn" class="btn btn-primary pull-right m-r-5" onclick="AjaxSave('');">Save</button>
                <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodal" data-toggle="modal">Query</button>
            </div>
        </div>
    </form>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-right-0 padding-left-0">
        <!--        <div class="modal fade modal-fill-in">-->
        <div id="page-tag" class="offcanvas multisourcediv">
            <div class="panel m-30">
                <div class="panel-body panel-height multiple-height">
                    <!-- <a class="panel-action fa fa-cog pull-right" data-toggle="panel-fullscreen" aria-hidden="true" style="color:red;"></a> -->
                    <div class="col-xs-12 col-xl-12" id="addnewurl"> 
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
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary pull-right m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button>		
                    <button type="button" class="btn btn-default pull-right m-r-5 offcanvas__trigger--close multisorcedivclose" data-rel="page-tag">Cancel</button>

                </div>
            </div>
        </div>
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
                        <div class="col-xs-12 col-xl-12">
                            <div id="LoadGroupAttrValue"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-xl-12 m-t-30">
                            <button type="button" class="btn btn-default pull-right m-r-5" data-dismiss="modal">Cancel</button>
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
                    <!--                        <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="HelpModelAttribute"></h4>
                                            </div>-->
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
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

    <script type="text/javascript">

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

            function getThisId(id) {
				//alert(id);
                AttrcopyId = $( "#"+id ).focus();
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
                        idoc.designMode = "off";    // Set design mode to off
                    });
                });
            });
            
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
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
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
                        } else if (obj['attrinitiallink'] != '' && obj['attrinitiallink'] != null) {
                            $('#exampleTabsOne').show();
                            document.getElementById('frame1').data = obj['attrinitiallink'];
                        }
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
            
            $('#attrGroupId').val(FirstGroupId);
                $('#attrSubGroupId').val(FirstSubGroupId);
                $('#attrId').val(FirstAttrId);
                $('#ProjattrId').val(FirstProjAttrId);
                $('#seq').val(sequence);
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
        });

        function focusProjeId(projId) {
//alert(projId);
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
            document.getElementById('prodInput_' + proKey).focus();
            $(href).height("4800");
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
			
			AttrcopyId = $( "#prodInput_"+attr ).focus();

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
                            $('.CntBadge').hide();
                            if (obj['attrval'] != '' && obj['attrval'] != null) {
                                obj['attrval'].forEach(function (element) {
                                    if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        var cols = "";
                                        cols += '<div class="col-xs-12 col-xl-4">';
                                        cols += '<div class="srcblock box1 update-cart offcanvas__trigger--close" id="demo">';
                                        cols += '<i class="fa fa-times-circle edit1 lite-blue" onclick="DeleteUrl(' + attr + ',' + projattr + ',' + maingroup + ',' + subgroup + ',' + element['Id'] + ');"></i>';
                                        if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
                                            var htmlfile = element['HtmlFileName'];
                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                        } else {
                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                        }
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
							if (typeof obj['attrcnt'] !== 'undefined' && obj['attrcnt'] != null) {
								obj['attrcnt'].forEach(function (element) {

									if (element['cnt'] > 0) {
										$('#CntBadge_' + element['AttributeMainGroupId']).show();
										$('#CntBadge_' + element['AttributeMainGroupId']).text(element['cnt']);
										//document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = ;
									}

								});
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

                        }
                    }
                });
                return true;
            } else {
                return false;
            }

        }

        function loadPDF(anchor,val)
        {
			if(val == 0){
				//$('.commonClass').hide();
				//$('.chk-wid-Url').hide();
			}
            $('#exampleTabsOne').show();
            $('#refUrl').val(anchor);
           // var cookieValue = anchor.getAttribute('value');
           var cookieValue = anchor;

            var htmlfile = "<?php echo HTMLfilesPath; ?>" + cookieValue;
            document.getElementById('frame1').data = htmlfile;

            var text = cookieValue;
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
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultipleurlcount')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                            //$('.commonClass').show();
                            //$('.chk-wid-Url').hide();
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
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

        function loadPDFUrl(file,val) {
        if(val == 0){
              //$('.commonClass').show();
                           // $('.chk-wid-Url').hide();
        }
            $('#exampleTabsOne').show();
            $('#refUrl').val(file);
            $('.update-cart').click(function (e) {
                e.preventDefault();
                return false;
            });
            //var file1 = file.getAttribute('value');
            var file1 = file;

            $("#frame1").attr('data', file1).hide().show();

            var text = file1;
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
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultiplelinkcount')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                           
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
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
					
					//$(".subgroupparentdivs_"+gotattributemaingrpid).each(function() {
					
				}
				
			}
			else {
				  $('.subgroupparentdivs').show();  
				  $('.commonClass').show();  
			}
		}
        function addReferenceUrl() {
            $('#addnewurl').show();
            $('#addurl').val('');

        }

        function loadReferenceUrl() {
			
            $('.chk-wid-Url').parent().show();
            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();

            var attrGrpid = $('#attrGroupId').val();
            var sequence = 1;
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, groupId: attrGrpid, seq: sequence}),
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
                                    if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
                                        var htmlfile = element['HtmlFileName'];
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,0);"  class="current text-center text update-cart info_link">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    } else if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id,0);" class="current text-center text">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    }
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

        function multipleUrl() {
            $('#addnewurl').hide();
        }
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
                $(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + nex).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(nex);
            }

            if (action == 'previous' && totalseq >= prev && prev > 0) {
                $(".MultiField_" + attributeMasterId).hide();
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
              currentSeq = $(".GroupSeq_" + subgrp + "").val();
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
			 
                    var mailing_street = $("#prodInput_3265"); //mailing_street - 209
                    var physical_street = $("#prodInput_3223") //physical_street - 209
                    var mailing_city = $("#prodInput_3266") //mailing_city - 209
                    var mailing_state = $("#prodInput_3267") //mailing_state - 209
                    var mailing_country = $("#prodInput_3268") //mailing_country - 209
                    var Mailing_Postal1 = $("#prodInput_3269") //mailing_postal - 209
                    var physical_city = $("#prodInput_3224") //physical_city - 209
                    var physical_state = $("#prodInput_3225") //physical_state - 209
                    var physical_country = $("#prodInput_3226") //physical_country - 209
                    var physical_Postal1 = $("#prodInput_3271") //physical_Postal1 - 209
                    
                    var mailing_street = $("#prodInput_2980"); //mailing_street - 18
                    var physical_street = $("#prodInput_2986") //physical_street - 18
                    var mailing_city = $("#prodInput_2981") //mailing_city - 18
                    var mailing_state = $("#prodInput_2982") //mailing_state - 18
                    var mailing_country = $("#prodInput_2983") //mailing_country - 18
                    var Mailing_Postal1 = $("#prodInput_2984") //mailing_postal - 18
                    var physical_city = $("#prodInput_2987") //physical_city - 18
                    var physical_state = $("#prodInput_2988") //physical_state - 18
                    var physical_country = $("#prodInput_2989") //physical_country - 18
                    var physical_Postal1 = $("#prodInput_2990") //physical_Postal1 - 18
                    
                    if(mailing_street.length){ 
             var mailing_street_value = mailing_street.val();
                    if (mailing_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_city.length){ 
                    var mailing_city_value = mailing_city.val();
                    if (mailing_street_value =='' && mailing_city_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(mailing_state.length){ 
                    var mailing_state_value = mailing_state.val();
                    if (mailing_street_value =='' && mailing_state_value!='') {
                        alert("mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(mailing_country.length){ 
                    var mailing_country_value = mailing_country.val();
                    if (mailing_street_value =='' && mailing_country_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(Mailing_Postal1.length){ 
                    var Mailing_Postal1_value = Mailing_Postal1.val();
                    if (mailing_street_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if (['caller', 'lockbox', 'drawer'].indexOf(mailing_street_value.toLowerCase()) >= 0) {
                alert("Remove invalid words in Mailing Street");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                }
                if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                     if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                if (mailing_street_value !='' && mailing_city_value=='') {
                        alert("Mailing city shouldn't be empty");
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    if (mailing_city_value.match(/\d+/g)){
                        alert('Remove numbers in mailing city');
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    if (!mailing_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in mailing city');
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us' || mailing_country_value=='united states'){
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_state_value=='') {
                        alert("Mailing state shouldn't be empty");
                        mailing_state.focus();
                        mailing_state.addClass('text-danger');
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_country_value=='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us' || mailing_country_value=='united states'){
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                    }
                if (mailing_country_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                if (mailing_country_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                var mailing_country_value = mailing_country_value.toLowerCase();
                if(mailing_country_value=='us' || mailing_country_value=='united states'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                    
                    
        }
        if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                    if (physical_street_value =='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                if(physical_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                if(physical_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                    
                var mailing_street_value = mailing_street.val();
                     var physical_street_value = physical_street.val();
                    if (mailing_street_value =='' && physical_street_value !='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                     }
                     if(physical_city.length){ 
                    var physical_city_value = physical_city.val();
                    if (physical_street_value =='' && physical_city_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_state.length){ 
                    var physical_state_value = physical_state.val();
                    if (physical_street_value =='' && physical_state_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_country.length){ 
                    var physical_country_value = physical_country.val();
                    if (physical_street_value =='' && physical_country_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_Postal1.length){ 
                    var physical_Postal1_value = physical_Postal1.val();
                    if (physical_street_value =='' && physical_Postal1_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                    
                }
                if(physical_city.length){ 
                var physical_city_value = physical_city.val();
                var physical_street_value = physical_street.val();
                var physical_country_value = physical_country.val();
                if (physical_street_value =='' && physical_city_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                if (physical_street_value !='' && physical_city_value=='') {
                        alert("Physical city shouldn't be empty");
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    if (physical_city_value.match(/\d+/g)){
                        alert('Remove numbers in physical city');
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    if (!physical_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in physical city');
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    
                    var physical_country_value = physical_country_value.toLowerCase();
                    if(physical_country_value=='us' || physical_country_value=='united states'){
                    var hyphen_replaced_val =physical_city_value.replace(/-/g, ' '); 
                    physical_city.val(hyphen_replaced_val);
                    }
                    
        }
        if(physical_state.length){ 
                var physical_state_value = physical_state.val();
                var physical_street_value = physical_street.val();
                    if (physical_street_value =='' && physical_state_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_state_value=='') {
                        alert("Physical state shouldn't be empty");
                        physical_state.focus();
                        physical_state.addClass('text-danger');
                        return false;
                    }
    
        }
        if(physical_country.length){ 
                var physical_country_value = physical_country.val();
                var physical_street_value = physical_street.val();
                var physical_city_value = physical_city.val();
                    if (physical_street_value =='' && physical_country_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_country_value=='') {
                        alert("Physical country shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                    var physical_country_value = physical_country_value.toLowerCase();
                    if(physical_country_value=='us' || physical_country_value=='united states'){
                    var hyphen_replaced_val =physical_city_value.replace(/-/g, ' '); 
                    physical_city.val(hyphen_replaced_val);
                    }
    
        }
        if(physical_Postal1.length){ 
                var physical_Postal1_value = physical_Postal1.val();
                var physical_country_value = physical_country.val();
                var physical_street_value = physical_street.val();
                if (physical_street_value =='' && physical_Postal1_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_Postal1_value=='') {
                        alert("Physical Postal shouldn't be empty");
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                    }
                if (physical_country_value !='' && physical_Postal1_value=='') {
                        alert("Physical Postal shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                if (physical_country_value =='' && physical_Postal1_value!='') {
                        alert("Physical country shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                var physical_country_value = physical_country_value.toLowerCase();
                if(physical_country_value=='us' || physical_country_value=='united states'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                    
                    
        }
			 
			var ret = true;
            ret = AjaxSave('');
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
			return true;
        }

            $(document).ready(function() {
                    
    });

    </script>
</body>
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
        var thisinpuval = thisObj.val().toLowerCase();

        var spaninpuval = thisObj.parent().find('.lighttext').text().toLowerCase();


        if (spaninpuval == thisinpuval && spaninpuval != "") {
            thisObj.parent().parent().find(".dispositionSelect").val('V');
        }

        if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('M');
        }

        if (spaninpuval != thisinpuval && spaninpuval == "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('A');
        }
        //}
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
			//alert('dfdf');
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
            var subgrpId = $(this).attr("date-subgrpId");
            
            var groupName = $(this).attr("data-groupName");
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
           element=[];
             $.each(subGrpAttArr, function (key, val) {
                 if(val['AttributeMasterId']==atributeId){
                     element=val;
                 }
             });
            
            var inpName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var commendName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
            var selName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
            //alert(nxtSeq);
            var toappendData = '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important" class="row form-responsive MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                    '<div class="col-md-2 form-title"><div class="form-group" style=""><p>' + groupName + '</p></div></div>' +
                    '<div class="col-md-3 form-text"><div class="form-group">' ;
                    if(element['ControlName']=='TextBox')
                        toappendData +='<input type="text" class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;
                    if(element['ControlName']=='MultiTextBox')
                        toappendData +='<textarea class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"></textarea>' ;
                
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input type="checkbox" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> Yes '+
                                        '<input value="No" type="radio" style="position:static" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select class="wid-100per form-control doOnBlur InsertFields"  id="prodInput_' + atributeId + '" name="' + inpName + '"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                    toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
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
                        '<div class="col-md-3 form-text"><div class="form-group">' ;
                if(element['ControlName']=='TextBox')
                        toappendData +='<input type="text" class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;
                if(element['ControlName']=='MultiTextBox')
                        toappendData +='<textarea class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"></textarea>' ;
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input type="checkbox" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static"  class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> Yes '+
                                        '<input value="No" type="radio" style="position:static"  class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select class="wid-100per form-control doOnBlur InsertFields"  id="prodInput_' + atributeId + '" name="' + inpName + '"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                       
                       
                        toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
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
//            url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'upddateUndockSession')); ?>",
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
    function loadhandsondatafinal(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
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
                    
                    row[0] = res.handson[i].AfterNormalized;
                    row[1] = res.handson[i].Comments;
                    row[2] = res.handson[i].AfterDisposition;
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
            colHeaders: ['After Normalized', 'Comments','After Disposition'],
            columns: [
                {readOnly: true},{readOnly: true},{readOnly: true}
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


    function loadhandsondatafinal_all(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,handskey:key,handskeysub:keysub},
            success: function (res) {
                //alert(res);
                var data = [], row;
                var j = 0;


                $.each(res.handson, function (key, val) {
                    $.each(val, function (key2, val2) {
                    attributeName=Object.keys(val2)[0];
                    row = []; 
                    row[0] = attributeName;
                    row[1] = res.handson[key][key2].AfterNormalized;
                    row[2] = res.handson[key][key2].Comments;
                    row[3] = res.handson[key][key2].AfterDisposition;
                    data[j] = row;
                    j++;
                });
                });



//                for (var i = 0, ilen = res.handson.length; i < ilen; i++) {
//                    row = [];
////                    row[0] = res.handson[i].DataId;
////                    row[1] = res.handson[i].AttributeName;
////                    row[2] = res.handson[i].AfterNormalized;
////                    row[3] = res.handson[i].Comments;
////                    row[4] = res.handson[i].AfterDisposition;
//                    
//                    //row[0] = res.handson[i].DataId;
//                    row[0] = res.handson[i].AttributeName;
//                    row[1] = res.handson[i].AfterNormalized;
//                    row[2] = res.handson[i].Comments;
//                    row[3] = res.handson[i].AfterDisposition;
////                row[0] = res.handson[i].Id;
////                row[0] = res.handson[i].AttributeValue;
//
//                    data[res.handson[i].Id] = row;
//                    j++;
//                }
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
            colHeaders: ['AttributeName' ,'After Normalized', 'Comments','After Disposition'],
            columns: [
                {readOnly: true},{readOnly: true},{readOnly: true},{readOnly: true}
//                {type:'text' },{type:'text' },{type:'text' },{ type: 'dropdown',source: ['A', 'D', 'M', 'V']}

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
</style>
<?php
if ($this->request->query['continue'] == 'yes') {
    echo "<script>getJob();</script>";
}
||||||| .r23720
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
        min-height: 200px;
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
        width: 12em;
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
                        <?php 
                       //pr($productionjob);
                       //pr($StaticFields);
                        $n= 0;
                        ?>
                          <div><b><?php  $n= 0; $prefix = '';
                        foreach ($staticFields as $key) { 
                          echo $prefix.$staticFields[$n]['AttributeValue'];
                            $prefix = ' | '; 
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
		
        <!-- Breadcrumb Ends -->
        <div class="panel m-l-30 m-r-30">
            <div class="panel-body">
                <div id="splitter">
					<span style="display:none;">
						<input type="checkbox" class="chk-wid-Url" onClick="checkAllUrlAtt()" id="chk-wid-Url" value="1" > Hide Other Fields
					</span>
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
                                            <a class="nav-link" data-toggle="tab" href="#googletab" aria-controls="googletab" role="tab">Google Search</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#mainurl" aria-controls="mainurl" role="tab">Website</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="leftpane">
                                        <div class="tab-pane active" id="exampleTabsOne" role="tabpanel" style="display:none !important;">
                                            <object width="100%" onload="onMyFrameLoad(this)" height="100%" style="visibility:visible" id="frame1" name="frame1" data="" width="auto" height="auto"></object>

                                        </div>
                                        <div class="tab-pane" id="googletab" role="tabpanel">
                                            <div>
                                                <div class="goto"><a href="javascript: void(0);" onclick="$('#frame2').attr('data', 'https://www.google.co.in').hide().show();"> Go to Google </a></div>
                                                <div><object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame2" sandbox="" data="https://www.google.com/ncr"></object></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="mainurl" role="tabpanel">
                                           <object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame3" sandbox="" data="<?php echo $getDomainUrl; ?>" ></object>
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

                                <input type="hidden" name="attrGroupId" id="attrGroupId">
                                <input type="hidden" name="attrSubGroupId" id="attrSubGroupId">
                                <input type="hidden" name="attrId" id="attrId">
                                <input type="hidden" name="ProjattrId" id="ProjattrId">
                                <input type="hidden" name="seq" id="seq">
                                <input type="hidden" name="refUrl" id="refUrl">

                                <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
                                    
                                            <?php
                                            $i = 0;
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
                                                <div class="col-md-6 row-title">
                                                
                                                                <?php if ($isDistinct !== false) {
                                                                    ?>
                                                                 <i id="subgrp-add-field" style="margin-top:5px;" class="fa fa-plus-circle pull-right add-field m-r-10 addSubgrpAttribute" data="<?php echo $keysub; ?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>"></i> 
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
                                                <i class="fa fa-info-circle m-r-10 m-l-10 pull-right"  onclick="loadhandsondatafinal_all('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>');" data-rel="page-tag" data-target="#exampleFillInHandson" data-toggle="modal"></i>
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
																					$ScoreFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Score']]['0'];
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
                                                                                    $inpOnClick = 'onclick="getThisId(this.id); loadWebpage(' . $valprodFields['AttributeMasterId'] . ', ' . $valprodFields['ProjectAttributeMasterId'] . ', ' . $valprodFields['MainGroupId'] . ', ' . $valprodFields['SubGroupId'] . ', ' . $tempSq . ', 0);" ';
                                                                            ?>
															<div class="commonClass commonclass_<?php echo $valprodFields['MainGroupId']?>" id="groupAttr_<?php echo $valprodFields['AttributeMasterId']?>">
                                                            <div id="MultiField_<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $thisseq; ?>" class="clearfix MultiField_<?php echo $valprodFields['AttributeMasterId']; ?> CampaignWiseFieldsDiv_<?php echo $key; ?> row form-responsive" style="<?php echo $disnone; ?>" >
                                                                
                                                                <div class="col-md-2 form-title">
                                                                <div class="form-group" style=""><p><?php echo $valprodFields['DisplayAttributeName'] ?></p>
                                                                    <input type="hidden" value="<?php echo $valprodFields['DisplayAttributeName'] ?>" id="attrdisp<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>">
                                                                </div>	
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                                <div class="form-group">
                                                                                    <?php
                                                                                    if ($inpuControlType == "TextBox") {
                                                                                        echo '<input type="text" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . '>';
                                                                                    } else if ($inpuControlType == "CheckBox") {
                                                                                        echo '<input type="checkbox" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . '>';
																					} else if ($inpuControlType == "MultiTextBox") {
                                                                                        echo '<textarea ' . $inpClass . $inpId . $inpName . $inpOnClick . '>'.$ProdFieldsValue.'</textarea>';
                                                                                    } else if ($inpuControlType == "RadioButton") {
                                                                                        
                                                                                        if ($ProdFieldsValue == "Yes")
                                                                                            $yesSel = 'checked="checked"';
                                                                                        if ($ProdFieldsValue == "No")
                                                                                            $noSel = ' checked="checked" ';
                                                                                        echo '<input value="Yes" style="position:static"  type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $yesSel . '> Yes  
																	<input style="position:static" value="No" type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $noSel . '> No';
                                                                                    }
                                                                                    else if ($inpuControlType == "DropDownList") {
                                echo '<select ' . $inpClass . $inpId . $inpName . $inpOnClick . '><option value="">--Select--</option>';
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
                                                                    <span class="lighttext" data-toggle="tooltip" title="<?php echo $InpValueFieldsValue; ?>"><?php echo $InpValueFieldsValue; ?></span><?php echo $ScoreFieldsValue; ?>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                                <div class="form-group comments">
                                                                    <textarea rows="1" cols="50" class="form-control <?php echo $dbClassName; ?>" id="" name="<?php echo $CommentsFieldsName; ?>" placeholder="Comments" onclick="loadWebpage(<?php echo $valprodFields['AttributeMasterId']; ?>, <?php echo $valprodFields['ProjectAttributeMasterId']; ?>, <?php echo $valprodFields['MainGroupId']; ?>, <?php echo $valprodFields['SubGroupId']; ?>,<?php echo $tempSq; ?>, 0);"><?php echo $CommentsFieldsValue; ?></textarea>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-4 form-status">
                                                                <div class="form-group status">
                                                                    <select id="" name="<?php echo $DispositionFieldsName; ?>"  class="<?php echo $dbClassName; ?> form-control CampaignWiseSelDone_<?php echo $key; ?> dispositionSelect">
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
               
                                    <?php if ($totalSeqCnt > 1) {
                                                                            ?>
                                                                 
                                                                <i class="fa fa-info-circle m-l-10" ata-target="#example-modal" onclick="loadhandsondatafinal('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>');" data-rel="page-tag" data-target="#exampleFillInHandson" data-toggle="modal"></i>
                                                                <i class="fa fa-angle-double-left " onclick="loadMultiField('previous', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i>
                                                                <i class="fa fa-angle-double-right m-r-5" onclick="loadMultiField('next', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i> 
                                                            
                                                                <?php
                                                            } ?>
                                                                     <?php if ($isDistinct === false) {
                                                                            if($valprodFields['IsDistinct']==1) {
                                                                                ?>
                                                                                <i id="add-field" class="fa fa-plus-circle add-field m-r-10 addAttribute" data="<?php echo $valprodFields['AttributeMasterId']; ?>" date-subgrpId="<?php echo $keysub;?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $valprodFields['DisplayAttributeName']; ?>"></i>
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
                <button type="button" href="#" class="btn btn-default offcanvas__trigger--open" onclick="multipleUrl();" id="multiplelinkbutton" data-rel="page-tag">Multiple Source Links</button>
                <button type="button" class="btn btn-default offcanvas__trigger--close" onclick="loadReferenceUrl();" data-rel="page-tag" data-target="#exampleFillIn" data-toggle="modal">View All</button>
                <!--                <button class="btn btn-default" name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>-->
            </div>
            <div class="col-lg-6 pull-right m-t-5 m-b-5">		
                <button type="submit" name='Submit' value="saveandexit" class="btn btn-primary pull-right m-r-5" onclick="return formSubmit();"> Submit & Exit </button>
                <button type="submit" name='Submit' value="saveandcontinue" class="btn btn-primary pull-right " onclick="return formSubmit();" style="margin-right: 5px;"> Submit & Continue </button>
                <button type="button" name='Save' value="Save" id="save_btn" class="btn btn-primary pull-right m-r-5" onclick="AjaxSave('');">Save</button>
                <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodal" data-toggle="modal">Query</button>
            </div>
        </div>
    </form>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-right-0 padding-left-0">
        <!--        <div class="modal fade modal-fill-in">-->
        <div id="page-tag" class="offcanvas multisourcediv">
            <div class="panel m-30">
                <div class="panel-body panel-height multiple-height">
                    <!-- <a class="panel-action fa fa-cog pull-right" data-toggle="panel-fullscreen" aria-hidden="true" style="color:red;"></a> -->
                    <div class="col-xs-12 col-xl-12" id="addnewurl"> 
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
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary pull-right m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button>		
                    <button type="button" class="btn btn-default pull-right m-r-5 offcanvas__trigger--close multisorcedivclose" data-rel="page-tag">Cancel</button>

                </div>
            </div>
        </div>
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
                        <div class="col-xs-12 col-xl-12">
                            <div id="LoadGroupAttrValue"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-xl-12 m-t-30">
                            <button type="button" class="btn btn-default pull-right m-r-5" data-dismiss="modal">Cancel</button>
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
                    <!--                        <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="HelpModelAttribute"></h4>
                                            </div>-->
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
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

    <script type="text/javascript">

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

            function getThisId(id) {
				//alert(id);
                AttrcopyId = $( "#"+id ).focus();
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
                        idoc.designMode = "off";    // Set design mode to off
                    });
                });
            });
            
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
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
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
                        } else if (obj['attrinitiallink'] != '' && obj['attrinitiallink'] != null) {
                            $('#exampleTabsOne').show();
                            document.getElementById('frame1').data = obj['attrinitiallink'];
                        }
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
            
            $('#attrGroupId').val(FirstGroupId);
                $('#attrSubGroupId').val(FirstSubGroupId);
                $('#attrId').val(FirstAttrId);
                $('#ProjattrId').val(FirstProjAttrId);
                $('#seq').val(sequence);
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
        });

        function focusProjeId(projId) {
//alert(projId);
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
            document.getElementById('prodInput_' + proKey).focus();
            $(href).height("4800");
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
			
			AttrcopyId = $( "#prodInput_"+attr ).focus();

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
                            $('.CntBadge').hide();
                            if (obj['attrval'] != '' && obj['attrval'] != null) {
                                obj['attrval'].forEach(function (element) {
                                    if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        var cols = "";
                                        cols += '<div class="col-xs-12 col-xl-4">';
                                        cols += '<div class="srcblock box1 update-cart offcanvas__trigger--close" id="demo">';
                                        cols += '<i class="fa fa-times-circle edit1 lite-blue" onclick="DeleteUrl(' + attr + ',' + projattr + ',' + maingroup + ',' + subgroup + ',' + element['Id'] + ');"></i>';
                                        if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
                                            var htmlfile = element['HtmlFileName'];
                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                        } else {
                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                        }
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
							if (typeof obj['attrcnt'] !== 'undefined' && obj['attrcnt'] != null) {
								obj['attrcnt'].forEach(function (element) {

									if (element['cnt'] > 0) {
										$('#CntBadge_' + element['AttributeMainGroupId']).show();
										$('#CntBadge_' + element['AttributeMainGroupId']).text(element['cnt']);
										//document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = ;
									}

								});
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

                        }
                    }
                });
                return true;
            } else {
                return false;
            }

        }

        function loadPDF(anchor,val)
        {
			if(val == 0){
				//$('.commonClass').hide();
				//$('.chk-wid-Url').hide();
			}
            $('#exampleTabsOne').show();
            $('#refUrl').val(anchor);
           // var cookieValue = anchor.getAttribute('value');
           var cookieValue = anchor;

            var htmlfile = "<?php echo HTMLfilesPath; ?>" + cookieValue;
            document.getElementById('frame1').data = htmlfile;

            var text = cookieValue;
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
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultipleurlcount')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                            //$('.commonClass').show();
                            //$('.chk-wid-Url').hide();
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
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

        function loadPDFUrl(file,val) {
        if(val == 0){
              //$('.commonClass').show();
                           // $('.chk-wid-Url').hide();
        }
            $('#exampleTabsOne').show();
            $('#refUrl').val(file);
            $('.update-cart').click(function (e) {
                e.preventDefault();
                return false;
            });
            //var file1 = file.getAttribute('value');
            var file1 = file;

            $("#frame1").attr('data', file1).hide().show();

            var text = file1;
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
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultiplelinkcount')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                           
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
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
		
		function checkAllUrlAtt(){
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
							$('#groupAttr_' + element['AttributeMasterId']).show();
							$('#groupAttr_' + element['AttributeMasterId']).addClass("myyourclass");
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
		}
		
        function addReferenceUrl() {
            $('#addnewurl').show();
            $('#addurl').val('');

        }

        function loadReferenceUrl() {
			
            $('.chk-wid-Url').parent().show();
            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();

            var attrGrpid = $('#attrGroupId').val();
            var sequence = 1;
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, groupId: attrGrpid, seq: sequence}),
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
                                    if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
                                        var htmlfile = element['HtmlFileName'];
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,0);"  class="current text-center text update-cart info_link">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    } else if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id,0);" class="current text-center text">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    }
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

        function multipleUrl() {
            $('#addnewurl').hide();
        }
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
                $(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + nex).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(nex);
            }

            if (action == 'previous' && totalseq >= prev && prev > 0) {
                $(".MultiField_" + attributeMasterId).hide();
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
			 
                    var mailing_street = $("#prodInput_3265"); //mailing_street - 209
                    var physical_street = $("#prodInput_3223") //physical_street - 209
                    var mailing_city = $("#prodInput_3266") //mailing_city - 209
                    var mailing_state = $("#prodInput_3267") //mailing_state - 209
                    var mailing_country = $("#prodInput_3268") //mailing_country - 209
                    var Mailing_Postal1 = $("#prodInput_3269") //mailing_postal - 209
                    var physical_city = $("#prodInput_3224") //physical_city - 209
                    var physical_state = $("#prodInput_3225") //physical_state - 209
                    var physical_country = $("#prodInput_3226") //physical_country - 209
                    var physical_Postal1 = $("#prodInput_3271") //physical_Postal1 - 209
                    
                    var mailing_street = $("#prodInput_2980"); //mailing_street - 18
                    var physical_street = $("#prodInput_2986") //physical_street - 18
                    var mailing_city = $("#prodInput_2981") //mailing_city - 18
                    var mailing_state = $("#prodInput_2982") //mailing_state - 18
                    var mailing_country = $("#prodInput_2983") //mailing_country - 18
                    var Mailing_Postal1 = $("#prodInput_2984") //mailing_postal - 18
                    var physical_city = $("#prodInput_2987") //physical_city - 18
                    var physical_state = $("#prodInput_2988") //physical_state - 18
                    var physical_country = $("#prodInput_2989") //physical_country - 18
                    var physical_Postal1 = $("#prodInput_2990") //physical_Postal1 - 18
                    
                    if(mailing_street.length){ 
             var mailing_street_value = mailing_street.val();
                    if (mailing_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_city.length){ 
                    var mailing_city_value = mailing_city.val();
                    if (mailing_street_value =='' && mailing_city_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(mailing_state.length){ 
                    var mailing_state_value = mailing_state.val();
                    if (mailing_street_value =='' && mailing_state_value!='') {
                        alert("mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(mailing_country.length){ 
                    var mailing_country_value = mailing_country.val();
                    if (mailing_street_value =='' && mailing_country_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(Mailing_Postal1.length){ 
                    var Mailing_Postal1_value = Mailing_Postal1.val();
                    if (mailing_street_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if (['caller', 'lockbox', 'drawer'].indexOf(mailing_street_value.toLowerCase()) >= 0) {
                alert("Remove invalid words in Mailing Street");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                }
                if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                     if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                if (mailing_street_value !='' && mailing_city_value=='') {
                        alert("Mailing city shouldn't be empty");
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    if (mailing_city_value.match(/\d+/g)){
                        alert('Remove numbers in mailing city');
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    if (!mailing_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in mailing city');
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us' || mailing_country_value=='united states'){
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_state_value=='') {
                        alert("Mailing state shouldn't be empty");
                        mailing_state.focus();
                        mailing_state.addClass('text-danger');
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_country_value=='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us' || mailing_country_value=='united states'){
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                    }
                if (mailing_country_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                if (mailing_country_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                var mailing_country_value = mailing_country_value.toLowerCase();
                if(mailing_country_value=='us' || mailing_country_value=='united states'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                    
                    
        }
        if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                    if (physical_street_value =='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                if(physical_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                if(physical_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                    
                var mailing_street_value = mailing_street.val();
                     var physical_street_value = physical_street.val();
                    if (mailing_street_value =='' && physical_street_value !='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                     }
                     if(physical_city.length){ 
                    var physical_city_value = physical_city.val();
                    if (physical_street_value =='' && physical_city_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_state.length){ 
                    var physical_state_value = physical_state.val();
                    if (physical_street_value =='' && physical_state_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_country.length){ 
                    var physical_country_value = physical_country.val();
                    if (physical_street_value =='' && physical_country_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_Postal1.length){ 
                    var physical_Postal1_value = physical_Postal1.val();
                    if (physical_street_value =='' && physical_Postal1_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                    
                }
                if(physical_city.length){ 
                var physical_city_value = physical_city.val();
                var physical_street_value = physical_street.val();
                var physical_country_value = physical_country.val();
                if (physical_street_value =='' && physical_city_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                if (physical_street_value !='' && physical_city_value=='') {
                        alert("Physical city shouldn't be empty");
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    if (physical_city_value.match(/\d+/g)){
                        alert('Remove numbers in physical city');
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    if (!physical_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in physical city');
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    
                    var physical_country_value = physical_country_value.toLowerCase();
                    if(physical_country_value=='us' || physical_country_value=='united states'){
                    var hyphen_replaced_val =physical_city_value.replace(/-/g, ' '); 
                    physical_city.val(hyphen_replaced_val);
                    }
                    
        }
        if(physical_state.length){ 
                var physical_state_value = physical_state.val();
                var physical_street_value = physical_street.val();
                    if (physical_street_value =='' && physical_state_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_state_value=='') {
                        alert("Physical state shouldn't be empty");
                        physical_state.focus();
                        physical_state.addClass('text-danger');
                        return false;
                    }
    
        }
        if(physical_country.length){ 
                var physical_country_value = physical_country.val();
                var physical_street_value = physical_street.val();
                var physical_city_value = physical_city.val();
                    if (physical_street_value =='' && physical_country_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_country_value=='') {
                        alert("Physical country shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                    var physical_country_value = physical_country_value.toLowerCase();
                    if(physical_country_value=='us' || physical_country_value=='united states'){
                    var hyphen_replaced_val =physical_city_value.replace(/-/g, ' '); 
                    physical_city.val(hyphen_replaced_val);
                    }
    
        }
        if(physical_Postal1.length){ 
                var physical_Postal1_value = physical_Postal1.val();
                var physical_country_value = physical_country.val();
                var physical_street_value = physical_street.val();
                if (physical_street_value =='' && physical_Postal1_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_Postal1_value=='') {
                        alert("Physical Postal shouldn't be empty");
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                    }
                if (physical_country_value !='' && physical_Postal1_value=='') {
                        alert("Physical Postal shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                if (physical_country_value =='' && physical_Postal1_value!='') {
                        alert("Physical country shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                var physical_country_value = physical_country_value.toLowerCase();
                if(physical_country_value=='us' || physical_country_value=='united states'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                    
                    
        }
			 
			var ret = true;
            ret = AjaxSave('');
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
			return true;
        }

            $(document).ready(function() {
                    
    });

    </script>
</body>
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
        var thisinpuval = thisObj.val().toLowerCase();

        var spaninpuval = thisObj.parent().find('.lighttext').text().toLowerCase();


        if (spaninpuval == thisinpuval && spaninpuval != "") {
            thisObj.parent().parent().find(".dispositionSelect").val('V');
        }

        if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('M');
        }

        if (spaninpuval != thisinpuval && spaninpuval == "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('A');
        }
        //}
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
			//alert('dfdf');
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
            var subgrpId = $(this).attr("date-subgrpId");
            
            var groupName = $(this).attr("data-groupName");
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
           element=[];
             $.each(subGrpAttArr, function (key, val) {
                 if(val['AttributeMasterId']==atributeId){
                     element=val;
                 }
             });
            
            var inpName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var commendName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
            var selName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
            //alert(nxtSeq);
            var toappendData = '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important" class="row form-responsive MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                    '<div class="col-md-2 form-title"><div class="form-group" style=""><p>' + groupName + '</p></div></div>' +
                    '<div class="col-md-3 form-text"><div class="form-group">' ;
                    if(element['ControlName']=='TextBox')
                        toappendData +='<input type="text" class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;
                    if(element['ControlName']=='MultiTextBox')
                        toappendData +='<textarea class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"></textarea>' ;
                
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input type="checkbox" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> Yes '+
                                        '<input value="No" type="radio" style="position:static" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select class="wid-100per form-control doOnBlur InsertFields"  id="prodInput_' + atributeId + '" name="' + inpName + '"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                    toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
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
                        '<div class="col-md-3 form-text"><div class="form-group">' ;
                if(element['ControlName']=='TextBox')
                        toappendData +='<input type="text" class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;
                if(element['ControlName']=='MultiTextBox')
                        toappendData +='<textarea class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"></textarea>' ;
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input type="checkbox" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static"  class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> Yes '+
                                        '<input value="No" type="radio" style="position:static"  class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select class="wid-100per form-control doOnBlur InsertFields"  id="prodInput_' + atributeId + '" name="' + inpName + '"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                       
                       
                        toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
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
//            url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'upddateUndockSession')); ?>",
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
    function loadhandsondatafinal(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
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
                    
                    row[0] = res.handson[i].AfterNormalized;
                    row[1] = res.handson[i].Comments;
                    row[2] = res.handson[i].AfterDisposition;
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
            colHeaders: ['After Normalized', 'Comments','After Disposition'],
            columns: [
                {readOnly: true},{readOnly: true},{readOnly: true}
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


    function loadhandsondatafinal_all(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,handskey:key,handskeysub:keysub},
            success: function (res) {
                //alert(res);
                var data = [], row;
                var j = 0;


                $.each(res.handson, function (key, val) {
                    $.each(val, function (key2, val2) {
                    attributeName=Object.keys(val2)[0];
                    row = []; 
                    row[0] = attributeName;
                    row[1] = res.handson[key][key2].AfterNormalized;
                    row[2] = res.handson[key][key2].Comments;
                    row[3] = res.handson[key][key2].AfterDisposition;
                    data[j] = row;
                    j++;
                });
                });



//                for (var i = 0, ilen = res.handson.length; i < ilen; i++) {
//                    row = [];
////                    row[0] = res.handson[i].DataId;
////                    row[1] = res.handson[i].AttributeName;
////                    row[2] = res.handson[i].AfterNormalized;
////                    row[3] = res.handson[i].Comments;
////                    row[4] = res.handson[i].AfterDisposition;
//                    
//                    //row[0] = res.handson[i].DataId;
//                    row[0] = res.handson[i].AttributeName;
//                    row[1] = res.handson[i].AfterNormalized;
//                    row[2] = res.handson[i].Comments;
//                    row[3] = res.handson[i].AfterDisposition;
////                row[0] = res.handson[i].Id;
////                row[0] = res.handson[i].AttributeValue;
//
//                    data[res.handson[i].Id] = row;
//                    j++;
//                }
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
            colHeaders: ['AttributeName' ,'After Normalized', 'Comments','After Disposition'],
            columns: [
                {readOnly: true},{readOnly: true},{readOnly: true},{readOnly: true}
//                {type:'text' },{type:'text' },{type:'text' },{ type: 'dropdown',source: ['A', 'D', 'M', 'V']}

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
</style>
<?php
if ($this->request->query['continue'] == 'yes') {
    echo "<script>getJob();</script>";
}
=======
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
        min-height: 200px;
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
        width: 12em;
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
                        <?php 
                       //pr($productionjob);
                       //pr($StaticFields);
                        $n= 0;
                        ?>
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
                            </label>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
		
        <!-- Breadcrumb Ends -->
        <div class="panel m-l-30 m-r-30">
            <div class="panel-body">
                <div id="splitter">
					<span style="display:none;">
						<input type="checkbox" class="chk-wid-Url" onClick="checkAllUrlAtt()" id="chk-wid-Url" value="1" > Hide Other Fields
					</span>
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
                                            <a class="nav-link" data-toggle="tab" href="#googletab" aria-controls="googletab" role="tab">Google Search</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#mainurl" aria-controls="mainurl" role="tab">Website</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="leftpane">
                                        <div class="tab-pane active" id="exampleTabsOne" role="tabpanel" style="display:none !important;">
                                            <object width="100%" onload="onMyFrameLoad(this)" height="100%" style="visibility:visible" id="frame1" name="frame1" data="" width="auto" height="auto"></object>

                                        </div>
                                        <div class="tab-pane" id="googletab" role="tabpanel">
                                            <div>
                                                <div class="goto"><a href="javascript: void(0);" onclick="$('#frame2').attr('data', 'https://www.google.co.in').hide().show();"> Go to Google </a></div>
                                                <div><object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame2" sandbox="" data="https://www.google.com/ncr"></object></div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="mainurl" role="tabpanel">
                                           <object onload="onMyFrameLoad(this)" width="100%" height="100%" id="frame3" sandbox="" data="<?php echo $getDomainUrl; ?>" ></object>
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

                                <input type="hidden" name="attrGroupId" id="attrGroupId">
                                <input type="hidden" name="attrSubGroupId" id="attrSubGroupId">
                                <input type="hidden" name="attrId" id="attrId">
                                <input type="hidden" name="ProjattrId" id="ProjattrId">
                                <input type="hidden" name="seq" id="seq">
                                <input type="hidden" name="refUrl" id="refUrl">

                                <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
                                    
                                            <?php
                                            $i = 0;
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
                                                <div class="col-md-6 row-title">
                                                
                                                                <?php if ($isDistinct !== false) {
                                                                    ?>
                                                                 <i id="subgrp-add-field" style="margin-top:5px;" class="fa fa-plus-circle pull-right add-field m-r-10 addSubgrpAttribute" data="<?php echo $keysub; ?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>"></i> 
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
                                                <i class="fa fa-info-circle m-r-10 m-l-10 pull-right"  onclick="loadhandsondatafinal_all('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>');" data-rel="page-tag" data-target="#exampleFillInHandson" data-toggle="modal"></i>
                                                                    <?php
                                                                }
                                                                ?>
                                                <input type="hidden" value="<?php echo $AttributeSubGroupMasterJSON[$key][$keysub]; ?>" id="attrsub<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>" class="removeinputclass">
                                                
                                                </div>
                                                </div>
                                                                <?php
                                                            }
                                                            //pr($GrpSercntArr);

                                                            if ($GroupSeqCnt == 0) {
                                                                $GroupSeqCnt = 1;
                                                            }
                                                            ?>
                                                <input value="1" type="hidden" data="<?php echo $GroupSeqCnt; ?>" name="GroupSeq_<?php echo $keysub; ?>" class="GroupSeq_<?php echo $keysub; ?> removeinputclass">

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
																					$ScoreFieldsValue = $processinputdata[$valprodFields['AttributeMasterId']][$tempSq][$DependentMasterIds['Score']]['0'];
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
                                                                                    $inpOnClick = 'onclick="getThisId(this.id); loadWebpage(' . $valprodFields['AttributeMasterId'] . ', ' . $valprodFields['ProjectAttributeMasterId'] . ', ' . $valprodFields['MainGroupId'] . ', ' . $valprodFields['SubGroupId'] . ', ' . $tempSq . ', 0);" ';
                                                                            ?>
															<div class="commonClass commonclass_<?php echo $valprodFields['MainGroupId']?>" id="groupAttr_<?php echo $valprodFields['AttributeMasterId']?>">
                                                            <div id="MultiField_<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $thisseq; ?>" class="clearfix MultiField_<?php echo $valprodFields['AttributeMasterId']; ?> CampaignWiseFieldsDiv_<?php echo $key; ?> row form-responsive" style="<?php echo $disnone; ?>" >
                                                                
                                                                <div class="col-md-2 form-title">
                                                                <div class="form-group" style=""><p><?php echo $valprodFields['DisplayAttributeName'] ?></p>
                                                                    <input type="hidden" value="<?php echo $valprodFields['DisplayAttributeName'] ?>" id="attrdisp<?php echo $valprodFields['AttributeMasterId']; ?>_<?php echo $i; ?>_<?php echo $key; ?>_<?php echo $keysub; ?>" class="removeinputclass">
                                                                </div>	
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                                <div class="form-group">
                                                                                    <?php
                                                                                    if ($inpuControlType == "TextBox") {
                                                                                        echo '<input type="text" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . '>';
                                                                                    } else if ($inpuControlType == "CheckBox") {
                                                                                        echo '<input type="checkbox" ' . $inpClass . $inpId . $inpName . $inpValue . $inpOnClick . '>';
																					} else if ($inpuControlType == "MultiTextBox") {
                                                                                        echo '<textarea ' . $inpClass . $inpId . $inpName . $inpOnClick . '>'.$ProdFieldsValue.'</textarea>';
                                                                                    } else if ($inpuControlType == "RadioButton") {
                                                                                        
                                                                                        if ($ProdFieldsValue == "Yes")
                                                                                            $yesSel = 'checked="checked"';
                                                                                        if ($ProdFieldsValue == "No")
                                                                                            $noSel = ' checked="checked" ';
                                                                                        echo '<input value="Yes" style="position:static"  type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $yesSel . '> Yes  
																	<input style="position:static" value="No" type="radio" ' . $inpClass . $inpId . $inpName . $inpOnClick . $noSel . '> No';
                                                                                    }
                                                                                    else if ($inpuControlType == "DropDownList") {
                                echo '<select ' . $inpClass . $inpId . $inpName . $inpOnClick . '><option value="">--Select--</option>';
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
                                                                    <span class="lighttext" data-toggle="tooltip" title="<?php echo $InpValueFieldsValue; ?>"><?php echo $InpValueFieldsValue; ?></span><?php echo $ScoreFieldsValue; ?>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-3 form-text">
                                                                <div class="form-group comments">
                                                                    <textarea rows="1" cols="50" class="form-control <?php echo $dbClassName; ?>" id="" name="<?php echo $CommentsFieldsName; ?>" placeholder="Comments" onclick="loadWebpage(<?php echo $valprodFields['AttributeMasterId']; ?>, <?php echo $valprodFields['ProjectAttributeMasterId']; ?>, <?php echo $valprodFields['MainGroupId']; ?>, <?php echo $valprodFields['SubGroupId']; ?>,<?php echo $tempSq; ?>, 0);"><?php echo $CommentsFieldsValue; ?></textarea>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-4 form-status">
                                                                <div class="form-group status">
                                                                    <select id="" name="<?php echo $DispositionFieldsName; ?>"  class="<?php echo $dbClassName; ?> form-control CampaignWiseSelDone_<?php echo $key; ?> dispositionSelect">
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
               
                                    <?php if ($totalSeqCnt > 1) {
                                                                            ?>
                                                                 
                                                                <i class="fa fa-info-circle m-l-10" ata-target="#example-modal" onclick="loadhandsondatafinal('<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $i; ?>', '<?php echo $key; ?>', '<?php echo $keysub; ?>');" data-rel="page-tag" data-target="#exampleFillInHandson" data-toggle="modal"></i>
                                                                <i class="fa fa-angle-double-left " onclick="loadMultiField('previous', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i>
                                                                <i class="fa fa-angle-double-right m-r-5" onclick="loadMultiField('next', '<?php echo $valprodFields['AttributeMasterId']; ?>', '<?php echo $totalSeqCnt; ?>');"></i> 
                                                            
                                                                <?php
                                                            } ?>
                                                                     <?php if ($isDistinct === false) {
                                                                            if($valprodFields['IsDistinct']==1) {
                                                                                ?>
                                                                                <i id="add-field" class="fa fa-plus-circle add-field m-r-10 addAttribute" data="<?php echo $valprodFields['AttributeMasterId']; ?>" date-subgrpId="<?php echo $keysub;?>" data-groupId="<?php echo $key; ?>" data-groupName="<?php echo $valprodFields['DisplayAttributeName']; ?>"></i>
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
                <button type="button" href="#" class="btn btn-default offcanvas__trigger--open" onclick="multipleUrl();" id="multiplelinkbutton" data-rel="page-tag">Multiple Source Links</button>
                <button type="button" class="btn btn-default offcanvas__trigger--close" onclick="loadReferenceUrl();" data-rel="page-tag" data-target="#exampleFillIn" data-toggle="modal">View All</button>
                <!--                <button class="btn btn-default" name='pdfPopUP' id='pdfPopUp' onclick="PdfPopup();" type="button">Undock</button>-->
            </div>
            <div class="col-lg-6 pull-right m-t-5 m-b-5">		
                <button type="submit" name='Submit' value="saveandexit" class="btn btn-primary pull-right m-r-5" onclick="return formSubmit();"> Submit & Exit </button>
                <button type="submit" name='Submit' value="saveandcontinue" class="btn btn-primary pull-right " onclick="return formSubmit();" style="margin-right: 5px;"> Submit & Continue </button>
                <button type="button" name='Save' value="Save" id="save_btn" class="btn btn-primary pull-right m-r-5" onclick="AjaxSave('');">Save</button>
                <button type="button" class="btn btn-default pull-right m-r-5" data-target="#querymodal" data-toggle="modal">Query</button>
            </div>
        </div>
    </form>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-right-0 padding-left-0">
        <!--        <div class="modal fade modal-fill-in">-->
        <div id="page-tag" class="offcanvas multisourcediv">
            <div class="panel m-30">
                <div class="panel-body panel-height multiple-height">
                    <!-- <a class="panel-action fa fa-cog pull-right" data-toggle="panel-fullscreen" aria-hidden="true" style="color:red;"></a> -->
                    <div class="col-xs-12 col-xl-12" id="addnewurl"> 
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
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary pull-right m-r-5" data-rel="page-tag" onclick="addReferenceUrl();">Add</button>		
                    <button type="button" class="btn btn-default pull-right m-r-5 offcanvas__trigger--close multisorcedivclose" data-rel="page-tag">Cancel</button>

                </div>
            </div>
        </div>
        <!--        </div>-->
        <!-- Right side flip canvas for Page Taggs ends -->	
        <!-- Modal -->

        <div class="modal fade modal-fill-in" id="exampleFillIn" aria-hidden="false" aria-labelledby="exampleFillIn" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Ã—</span>
                        </button>
                        <h4 class="modal-title" id="exampleFillInModalTitle">All Source Links</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-xl-12 panel p-t-30 p-b-20">
                            <div id="LoadGroupAttrValue"> 
                            </div>
                        </div>
                        <div class="col-xs-12 col-xl-12 m-t-30">
                            <button type="button" class="btn btn-default pull-right m-r-5" data-dismiss="modal">Cancel</button>
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
                    <!--                        <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="HelpModelAttribute"></h4>
                                            </div>-->
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Ã—</span>
                        </button>
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
                            <span aria-hidden="true">Ã—</span>
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
                            <span aria-hidden="true">Ã—</span>
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
                            <span aria-hidden="true">Ã—</span>
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

    <script type="text/javascript">

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

            function getThisId(id) {
				//alert(id);
                AttrcopyId = $( "#"+id ).focus();
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
                        idoc.designMode = "off";    // Set design mode to off
                    });
                });
            });
            
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
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
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
                        } else if (obj['attrinitiallink'] != '' && obj['attrinitiallink'] != null) {
                            $('#exampleTabsOne').show();
                            document.getElementById('frame1').data = obj['attrinitiallink'];
                        }
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
            
            $('#attrGroupId').val(FirstGroupId);
                $('#attrSubGroupId').val(FirstSubGroupId);
                $('#attrId').val(FirstAttrId);
                $('#ProjattrId').val(FirstProjAttrId);
                $('#seq').val(sequence);
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
        });

        function focusProjeId(projId) {
//alert(projId);
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
            document.getElementById('prodInput_' + proKey).focus();
            $(href).height("4800");
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
			
			AttrcopyId = $( "#prodInput_"+attr ).focus();

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
                            $('.CntBadge').hide();
                            if (obj['attrval'] != '' && obj['attrval'] != null) {
                                obj['attrval'].forEach(function (element) {
                                    if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        var cols = "";
                                        cols += '<div class="col-xs-12 col-xl-4">';
                                        cols += '<div class="srcblock box1 update-cart offcanvas__trigger--close" id="demo">';
                                        cols += '<i class="fa fa-times-circle edit1 lite-blue" onclick="DeleteUrl(' + attr + ',' + projattr + ',' + maingroup + ',' + subgroup + ',' + element['Id'] + ');"></i>';
                                        if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
                                            var htmlfile = element['HtmlFileName'];
                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                        } else {
                                            cols += '<a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id,1);" class="current text-center text update-cart">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                        }
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
							if (typeof obj['attrcnt'] !== 'undefined' && obj['attrcnt'] != null) {
								obj['attrcnt'].forEach(function (element) {

									if (element['cnt'] > 0) {
										$('#CntBadge_' + element['AttributeMainGroupId']).show();
										$('#CntBadge_' + element['AttributeMainGroupId']).text(element['cnt']);
										//document.getElementById('CntBadge_' + element['AttributeMainGroupId']).innerHTML = ;
									}

								});
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

                        }
                    }
                });
                return true;
            } else {
                return false;
            }

        }

        function loadPDF(anchor,val)
        {
			if(val == 0){
				//$('.commonClass').hide();
				//$('.chk-wid-Url').hide();
			}
            $('#exampleTabsOne').show();
            $('#refUrl').val(anchor);
           // var cookieValue = anchor.getAttribute('value');
           var cookieValue = anchor;

            var htmlfile = "<?php echo HTMLfilesPath; ?>" + cookieValue;
            document.getElementById('frame1').data = htmlfile;

            var text = cookieValue;
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
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultipleurlcount')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                            //$('.commonClass').show();
                            //$('.chk-wid-Url').hide();
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
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

        function loadPDFUrl(file,val) {
        if(val == 0){
              //$('.commonClass').show();
                           // $('.chk-wid-Url').hide();
        }
            $('#exampleTabsOne').show();
            $('#refUrl').val(file);
            $('.update-cart').click(function (e) {
                e.preventDefault();
                return false;
            });
            //var file1 = file.getAttribute('value');
            var file1 = file;

            $("#frame1").attr('data', file1).hide().show();

            var text = file1;
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
                    url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxloadmultiplelinkcount')); ?>",
                    data: ({NewUrl: text, ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, AttrGroup: attrGrpid, AttrSubGroup: attrSubGrpid, AttrId: attrid, ProjAttrId: Projattrid, seq: sequence}),
                    dataType: 'text',
                    async: true,
                    success: function (result) {
                        if (result != '' && result != null) {
                            var obj = JSON.parse(result);
                            $('.CntBadge').hide();
                           
                            $('#exampleFillIn').modal('hide');
                            $(".multisorcedivclose").trigger("click");
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
		
		function checkAllUrlAtt(){
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
							$('#groupAttr_' + element['AttributeMasterId']).show();
							$('#groupAttr_' + element['AttributeMasterId']).addClass("myyourclass");
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
		}
		
        function addReferenceUrl() {
            $('#addnewurl').show();
            $('#addurl').val('');

        }

        function loadReferenceUrl() {
			
            $('.chk-wid-Url').parent().show();
            var projectid = $('#ProjectId').val();
            var regionid = $('#RegionId').val();
            var inputentityid = $('#InputEntityId').val();
            var prodentityid = $('#ProductionEntity').val();

            var attrGrpid = $('#attrGroupId').val();
            var sequence = 1;
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetgroupurl')); ?>",
                data: ({ProjectId: projectid, RegionId: regionid, InputEntityId: inputentityid, ProdEntityId: prodentityid, groupId: attrGrpid, seq: sequence}),
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
                                    if (element['HtmlFileName'] != '' && element['HtmlFileName'] != null) {
                                        var htmlfile = element['HtmlFileName'];
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value="' + htmlfile + '" id="' + htmlfile + '" onclick="loadPDF(this.id,0);"  class="current text-center text update-cart info_link">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    } else if (element['AttributeValue'] != '' && element['AttributeValue'] != null) {
                                        cols += '<span class="badge CntBadge" style="display: inline-block;">' + element['attrcnt'] + '</span> <a href="#" title=' + element['AttributeValue'] + ' value=' + element['AttributeValue'] + ' id=' + element['AttributeValue'] + ' onclick="loadPDFUrl(this.id,0);" class="current text-center text">' + element['AttributeValue'].substring(0, 45) + '</a>';
                                    }
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

        function multipleUrl() {
            $('#addnewurl').hide();
        }
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
                $(".MultiField_" + attributeMasterId).hide();
                $("#MultiField_" + attributeMasterId + "_" + nex).show();
                $(".ShowingSeqDiv_" + attributeMasterId + "").val(nex);
            }

            if (action == 'previous' && totalseq >= prev && prev > 0) {
                $(".MultiField_" + attributeMasterId).hide();
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
			 
                    var mailing_street = $("#prodInput_3265"); //mailing_street - 209
                    var physical_street = $("#prodInput_3223"); //physical_street - 209
                    var mailing_city = $("#prodInput_3266"); //mailing_city - 209
                    var mailing_state = $("#prodInput_3267"); //mailing_state - 209
                    var mailing_country = $("#prodInput_3268"); //mailing_country - 209
                    var Mailing_Postal1 = $("#prodInput_3269"); //mailing_postal - 209
                    var physical_city = $("#prodInput_3224"); //physical_city - 209
                    var physical_state = $("#prodInput_3225"); //physical_state - 209
                    var physical_country = $("#prodInput_3226"); //physical_country - 209
                    var physical_Postal1 = $("#prodInput_3271"); //physical_Postal1 - 209
                    var country_calling_code = $("#prodInput_4185"); //country_calling_code - 209
                    var phone_number = $("#prodInput_580"); //phone number - 209
                    var first_name = $("#prodInput_3542"); //first_name - 209
                    var last_name = $("#prodInput_2062"); //last_name - 209
                    var first_name_status = $('[name="ProductionFields_3542_8_1"]'); //first_name_status - 209
                    var last_name_status = $('[name="ProductionFields_2062_8_1"]'); //last_name_status - 209
                    var area_code = $("#prodInput_4183"); //area_code - 209
                    var phone_type = $("#prodInput_4417"); //phone_type - 209
                    
                    var mailing_street = $("#prodInput_2980"); //mailing_street - 18
                    var physical_street = $("#prodInput_2986") //physical_street - 18
                    var mailing_city = $("#prodInput_2981"); //mailing_city - 18
                    var mailing_state = $("#prodInput_2982"); //mailing_state - 18
                    var mailing_country = $("#prodInput_2983"); //mailing_country - 18
                    var Mailing_Postal1 = $("#prodInput_2984"); //mailing_postal - 18
                    var physical_city = $("#prodInput_2987"); //physical_city - 18
                    var physical_state = $("#prodInput_2988"); //physical_state - 18
                    var physical_country = $("#prodInput_2989"); //physical_country - 18
                    var physical_Postal1 = $("#prodInput_2990"); //physical_Postal1 - 18
                    var country_calling_code = $("#prodInput_2997"); //country_calling_code - 18
                    var phone_number = $("#prodInput_264"); //phone_number - 18
                    var first_name = $("#prodInput_96"); //first_name - 18
                    var last_name = $("#prodInput_1354"); //last_name - 18
                    var first_name_status = $('[name="ProductionFields_96_1011_1"]'); //first_name_status - 18
                    var last_name_status = $('[name="ProductionFields_1354_1011_1"]'); //last_name_status - 18
                    var area_code = $("#prodInput_2995"); //area_code - 18
                    var phone_type = $("#prodInput_2994"); //phone_type - 18
                    
                    
                    if(mailing_street.length){ 
             var mailing_street_value = mailing_street.val();
                    if (mailing_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    mailing_street.focus();
                    mailing_street.addClass('text-danger');
                    return false;
                }
                if(mailing_city.length){ 
                    var mailing_city_value = mailing_city.val();
                    if (mailing_street_value =='' && mailing_city_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(mailing_state.length){ 
                    var mailing_state_value = mailing_state.val();
                    if (mailing_street_value =='' && mailing_state_value!='') {
                        alert("mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(mailing_country.length){ 
                    var mailing_country_value = mailing_country.val();
                    if (mailing_street_value =='' && mailing_country_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if(Mailing_Postal1.length){ 
                    var Mailing_Postal1_value = Mailing_Postal1.val();
                    if (mailing_street_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                }
                if (['caller', 'lockbox', 'drawer'].indexOf(mailing_street_value.toLowerCase()) >= 0) {
                alert("Remove invalid words in Mailing Street");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                }
                if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                     if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                if (mailing_street_value !='' && mailing_city_value=='') {
                        alert("Mailing city shouldn't be empty");
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    if (mailing_city_value.match(/\d+/g)){
                        alert('Remove numbers in mailing city');
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    if (!mailing_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in mailing city');
                        mailing_city.focus();
                        mailing_city.addClass('text-danger');
                        return false;
                    }
                    
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us' || mailing_country_value=='united states'){
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_state_value=='') {
                        alert("Mailing state shouldn't be empty");
                        mailing_state.focus();
                        mailing_state.addClass('text-danger');
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && mailing_country_value=='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                    var mailing_country_value = mailing_country_value.toLowerCase();
                    if(mailing_country_value=='us' || mailing_country_value=='united states'){
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
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                    }
                if (mailing_country_value !='' && Mailing_Postal1_value=='') {
                        alert("Mailing Postal shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                if (mailing_country_value =='' && Mailing_Postal1_value!='') {
                        alert("Mailing country shouldn't be empty");
                        mailing_country.focus();
                        mailing_country.addClass('text-danger');
                        return false;
                    }
                var mailing_country_value = mailing_country_value.toLowerCase();
                if(mailing_country_value=='us' || mailing_country_value=='united states'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(mailing_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(Mailing_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        Mailing_Postal1.focus();
                        Mailing_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                    
                    
        }
        if(physical_street.length){ 
                     var physical_street_value = physical_street.val();
                    if (physical_street_value =='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value.match(/^\s\s*/)){
                    alert('Remove Trailing white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                if(physical_street_value.match(/\s\s*$/)){
                    alert('Remove Preceding white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                if(physical_street_value.match(/  +/g)){
                   alert('Remove More than one white space');
                    physical_street.focus();
                    physical_street.addClass('text-danger');
                    return false;
                }
                    
                var mailing_street_value = mailing_street.val();
                     var physical_street_value = physical_street.val();
                    if (mailing_street_value =='' && physical_street_value !='') {
                        alert("Mailing street shouldn't be empty");
                        mailing_street.focus();
                        mailing_street.addClass('text-danger');
                        return false;
                    }
                    if (mailing_street_value!='' || physical_street_value!='') {
                    if (mailing_street_value == physical_street_value) {
                        alert("Mailing street and physical street shouldn't be same");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                     }
                     if(physical_city.length){ 
                    var physical_city_value = physical_city.val();
                    if (physical_street_value =='' && physical_city_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_state.length){ 
                    var physical_state_value = physical_state.val();
                    if (physical_street_value =='' && physical_state_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_country.length){ 
                    var physical_country_value = physical_country.val();
                    if (physical_street_value =='' && physical_country_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                if(physical_Postal1.length){ 
                    var physical_Postal1_value = physical_Postal1.val();
                    if (physical_street_value =='' && physical_Postal1_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                }
                    
                }
                if(physical_city.length){ 
                var physical_city_value = physical_city.val();
                var physical_street_value = physical_street.val();
                var physical_country_value = physical_country.val();
                if (physical_street_value =='' && physical_city_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                if (physical_street_value !='' && physical_city_value=='') {
                        alert("Physical city shouldn't be empty");
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    if (physical_city_value.match(/\d+/g)){
                        alert('Remove numbers in physical city');
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    if (!physical_city_value.match(/^[a-zA-Z- ]*$/)){
                        alert('Remove special characters in physical city');
                        physical_city.focus();
                        physical_city.addClass('text-danger');
                        return false;
                    }
                    
                    var physical_country_value = physical_country_value.toLowerCase();
                    if(physical_country_value=='us' || physical_country_value=='united states'){
                    var hyphen_replaced_val =physical_city_value.replace(/-/g, ' '); 
                    physical_city.val(hyphen_replaced_val);
                    }
                    
        }
        if(physical_state.length){ 
                var physical_state_value = physical_state.val();
                var physical_street_value = physical_street.val();
                    if (physical_street_value =='' && physical_state_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_state_value=='') {
                        alert("Physical state shouldn't be empty");
                        physical_state.focus();
                        physical_state.addClass('text-danger');
                        return false;
                    }
    
        }
        if(physical_country.length){ 
                var physical_country_value = physical_country.val();
                var physical_street_value = physical_street.val();
                var physical_city_value = physical_city.val();
                    if (physical_street_value =='' && physical_country_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_country_value=='') {
                        alert("Physical country shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                    var physical_country_value = physical_country_value.toLowerCase();
                    if(physical_country_value=='us' || physical_country_value=='united states'){
                    var hyphen_replaced_val =physical_city_value.replace(/-/g, ' '); 
                    physical_city.val(hyphen_replaced_val);
                    }
    
        }
        if(physical_Postal1.length){ 
                var physical_Postal1_value = physical_Postal1.val();
                var physical_country_value = physical_country.val();
                var physical_street_value = physical_street.val();
                if (physical_street_value =='' && physical_Postal1_value!='') {
                        alert("Physical street shouldn't be empty");
                        physical_street.focus();
                        physical_street.addClass('text-danger');
                        return false;
                    }
                    if (physical_street_value !='' && physical_Postal1_value=='') {
                        alert("Physical Postal shouldn't be empty");
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                    }
                if (physical_country_value !='' && physical_Postal1_value=='') {
                        alert("Physical Postal shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                if (physical_country_value =='' && physical_Postal1_value!='') {
                        alert("Physical country shouldn't be empty");
                        physical_country.focus();
                        physical_country.addClass('text-danger');
                        return false;
                    }
                var physical_country_value = physical_country_value.toLowerCase();
                if(physical_country_value=='us' || physical_country_value=='united states'){
                    var isValid = /^[0-9]{5}(?:-[0-9]{4})?$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='india'){
                    var isValid = /^[1-9][0-9]{5}?$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='canada'){
                    var isValid = /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                if(physical_country_value=='australia'){
                    var isValid = /^[0-9]{4}$/.test(physical_Postal1_value);
                        if (!isValid){
                        alert('Invalid ZipCode');
                        physical_Postal1.focus();
                        physical_Postal1.addClass('text-danger');
                        return false;
                        }
                    }
                    
                    
        }
			 
                    if(first_name.length){
                     var first_name_value = first_name.val();
                     var first_name_status_value = first_name_status.val();
                     first_name_status_value = first_name_status_value.toLowerCase();
                     if(first_name_value!=''){
                         if(first_name_status_value=='m'){
                          alert("First Name status shouldn't be as M");
                          first_name_status.focus();
                          first_name_status.addClass('text-danger');
                          return false;
                        }
                      }
                    }
                    if(last_name.length){
                     var last_name_value = last_name.val();
                     var last_name_status_value = last_name_status.val();
                     last_name_status_value = last_name_status_value.toLowerCase();
                     if(last_name_value!=''){
                         if(last_name_status_value=='m'){
                          alert("Last Name status shouldn't be as M");
                          last_name_status.focus();
                          last_name_status.addClass('text-danger');
                          return false;
                        }
                      }
                    }
                    if(country_calling_code.length){
                    var country_calling_code_value = country_calling_code.val();
                    var phone_number_value = phone_number.val();
                    var physical_country_value = physical_country.val();
                    var physical_country_value = physical_country_value.toLowerCase();
                    var area_code_value = area_code.val();
                    var phone_type_value = phone_type.val();
                    phone_type_value = phone_type_value.toLowerCase();
                    if(country_calling_code_value==''){
                        if(physical_country_value!='us' && physical_country_value!='united states' && physical_country_value!='canada'){
                            if((area_code_value!='800' && area_code_value!='855' && area_code_value!='866' && area_code_value!='888')||(phone_type_value!='toll-free' && phone_type_value!='fax')){
                                alert("Country calling code shouldn't be empty");
                                country_calling_code.focus();
                                country_calling_code.addClass('text-danger');
                                return false; 
                            }
                        }
                    }
                    if(physical_country_value=='us' || physical_country_value=='united states' || physical_country_value=='canada'){
                        //if(phone_number_value==''){
                        country_calling_code.val('');
                        //}
                    }
                }
			 
			var ret = true;
            ret = AjaxSave('');
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
			return true;
        }

            $(document).ready(function() {
                    
    });

    </script>
</body>
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
        var thisinpuval = thisObj.val().toLowerCase();

        var spaninpuval = thisObj.parent().find('.lighttext').text().toLowerCase();


        if (spaninpuval == thisinpuval && spaninpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('V');
        }

        if (spaninpuval != thisinpuval && spaninpuval != "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('M');
        }

        if (spaninpuval != thisinpuval && spaninpuval == "" && thisinpuval != "") {
            thisObj.parent().parent().parent().find(".dispositionSelect").val('A');
        }
        //}
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
			//alert('dfdf');
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
            var subgrpId = $(this).attr("date-subgrpId");
            
            var groupName = $(this).attr("data-groupName");
            var maxSeqCnt = $('.ShowingSeqDiv_' + atributeId).attr("data");
            var nxtSeq = parseInt(maxSeqCnt) + 1;
            var subGrpArr='<?php echo str_replace("'", "\\'", json_encode($AttributesListGroupWise))?>';
            var subGrpAtt = JSON.parse(subGrpArr);
            
            var subGrpAttArr = subGrpAtt[groupId][subgrpId];
           element=[];
             $.each(subGrpAttArr, function (key, val) {
                 if(val['AttributeMasterId']==atributeId){
                     element=val;
                 }
             });
            
            var inpName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['ProductionField']; ?>_' + nxtSeq;
            var commendName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Comments']; ?>_' + nxtSeq;
            var selName = 'NewProductionField_' + atributeId + '_<?php echo $DependentMasterIds['Disposition']; ?>_' + nxtSeq;
            //alert(nxtSeq);
            var toappendData = '<div id="MultiField_' + atributeId + '_' + nxtSeq + '" style="border-bottom: 1px dotted rgb(196, 196, 196) !important" class="row form-responsive MultiField_' + atributeId + ' CampaignWiseFieldsDiv_' + groupId + '">' +
                    '<div class="col-md-2 form-title"><div class="form-group" style=""><p>' + groupName + '</p></div></div>' +
                    '<div class="col-md-3 form-text"><div class="form-group">' ;
                    if(element['ControlName']=='TextBox')
                        toappendData +='<input type="text" class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;
                    if(element['ControlName']=='MultiTextBox')
                        toappendData +='<textarea class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"></textarea>' ;
                
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input type="checkbox" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> Yes '+
                                        '<input value="No" type="radio" style="position:static" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select class="wid-100per form-control doOnBlur InsertFields"  id="prodInput_' + atributeId + '" name="' + inpName + '"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                    toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
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
                        '<div class="col-md-3 form-text"><div class="form-group">' ;
                if(element['ControlName']=='TextBox')
                        toappendData +='<input type="text" class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;
                if(element['ControlName']=='MultiTextBox')
                        toappendData +='<textarea class="wid-100per form-control doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"></textarea>' ;
                if(element['ControlName']=='CheckBox')
                        toappendData +='<input type="checkbox" class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '">' ;  
                if(element['ControlName']=='RadioButton'){
                        toappendData +='<input value="Yes" type="radio" style="position:static"  class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> Yes '+
                                        '<input value="No" type="radio" style="position:static"  class="doOnBlur InsertFields" id="prodInput_' + atributeId + '" name="' + inpName + '"> No ' ;  
                            }
                   if(element['ControlName']=='DropDownList') {
                        toappendData +='<select class="wid-100per form-control doOnBlur InsertFields"  id="prodInput_' + atributeId + '" name="' + inpName + '"><option value="">--Select--</option>';
                       
                      jQuery.each(element['Options'], function (i, val) {
                          toappendData +='<option value="'+val+'">'+val+'</option>';
                      });
                      toappendData +='</select>';
                  }
                       
                       
                        toappendData +='<span class="lighttext" data-toggle="tooltip" title=""></span>' +
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
//            url: "<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'upddateUndockSession')); ?>",
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
    function loadhandsondatafinal(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
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
                    
                    row[0] = res.handson[i].AfterNormalized;
                    row[1] = res.handson[i].Comments;
                    row[2] = res.handson[i].AfterDisposition;
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
            colHeaders: ['After Normalized', 'Comments','After Disposition'],
            columns: [
                {readOnly: true},{readOnly: true},{readOnly: true}
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


    function loadhandsondatafinal_all(id, idval, key, keysub) {
        var ProductionEntityId = $("#ProductionEntity").val();
        $.ajax({
            url: '<?php echo Router::url(array('controller' => 'Getjobcore', 'action' => 'ajaxgetdatahandalldata')); ?>',
            dataType: 'json',
            type: 'POST',
            data: {ProductionEntityId: ProductionEntityId, AttributeMasterId: id ,handskey:key,handskeysub:keysub},
            success: function (res) {
                //alert(res);
                var data = [], row;
                var j = 0;


                $.each(res.handson, function (key, val) {
                    $.each(val, function (key2, val2) {
                    attributeName=Object.keys(val2)[0];
                    row = []; 
                    row[0] = attributeName;
                    row[1] = res.handson[key][key2].AfterNormalized;
                    row[2] = res.handson[key][key2].Comments;
                    row[3] = res.handson[key][key2].AfterDisposition;
                    data[j] = row;
                    j++;
                });
                });



//                for (var i = 0, ilen = res.handson.length; i < ilen; i++) {
//                    row = [];
////                    row[0] = res.handson[i].DataId;
////                    row[1] = res.handson[i].AttributeName;
////                    row[2] = res.handson[i].AfterNormalized;
////                    row[3] = res.handson[i].Comments;
////                    row[4] = res.handson[i].AfterDisposition;
//                    
//                    //row[0] = res.handson[i].DataId;
//                    row[0] = res.handson[i].AttributeName;
//                    row[1] = res.handson[i].AfterNormalized;
//                    row[2] = res.handson[i].Comments;
//                    row[3] = res.handson[i].AfterDisposition;
////                row[0] = res.handson[i].Id;
////                row[0] = res.handson[i].AttributeValue;
//
//                    data[res.handson[i].Id] = row;
//                    j++;
//                }
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
            colHeaders: ['AttributeName' ,'After Normalized', 'Comments','After Disposition'],
            columns: [
                {readOnly: true},{readOnly: true},{readOnly: true},{readOnly: true}
//                {type:'text' },{type:'text' },{type:'text' },{ type: 'dropdown',source: ['A', 'D', 'M', 'V']}

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
</style>
<?php
if ($this->request->query['continue'] == 'yes') {
    echo "<script>getJob();</script>";
}
>>>>>>> .r23724
?>