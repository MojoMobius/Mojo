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

<?php use Cake\Routing\Router; ?>
<input type="hidden" name='loaded' id='loaded' value="">
    <div id="example" class="container-fluid" style="margin-bottom:-10px;">
        <div id="vertical">
            <div id="top-pane">
                <div id="horizontal" style="height: 100%; width: 100%;">
                    <div id="right-pane">
                        <div class="col-md-12">
                            <div class="col-md-4  pull-left">
                                <?php //echo $this->Form->input('', array('options' => $Html, 'id' => 'status', 'name' => 'status', 'class' => 'form-control', 'onchange' => 'LoadPDF(this.value);','style' => 'width:400px; margin-top:-11px; margin-left:-25px;')); ?>
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
    <div id="fade3" class="black_overlay"></div>
<?php echo $this->Form->end(); ?>
    
    <script>
    var myWindow = null;
    function onMyFrameLoad() {
        $('#loaded').val('loaded');
    }
    
    ipValidatorRegexp = /^(?:\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b|null)$/;
    emailValidator = function (value, callback) {
        setTimeout(function () {
            if (value === '') {
            callback(true);
            }
            else if (/.+@.+/.test(value)) {
                callback(true);
            }
            else {
                callback(false);
            }
        }, 1000);
    };

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
        
        manualColumnMove: true,
        stretchH: 'all',
        rowHeaders: true,
        manualRowResize: true,
        manualColumnResize: true,
        comments: false,
        contextMenu: ['undo','redo','make_read_only','alignment','remove_row'],
		
        colHeaders: [
<?php

foreach ($TLRebutalHeader as $value) {
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
foreach ($ProductionHeader as $key => $val) {
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
     });
           var BatchId = "<?php echo $BatchId; ?>";
           //alert(BatchId);
    $.ajax({
        url: '<?php echo Router::url(array('controller' => 'TLRebutal', 'action' => 'ajaxcheckdata')); ?>',
        //data: ({BatchId:BatchId, projectId: projectId, RegionId: RegionId, ProcessId: ProcessId}),
        dataType: 'json',
        type: 'GET',
        success: function (res) {
            var data = [], row;
            for (var i = 0, ilen = res.handson.length; i < ilen; i++) {
                row = [];
                //row[0] = res.handson[i].DataId;
                var prodArr =<?php echo json_encode($ProductionHeaders); ?>;
                 var readArr ='';
                var readArr =<?php if(isset($ReadOnlyFields)){ echo json_encode($ReadOnlyFields); } else { echo "''";}  ?>;
                var cnt = 0;
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

</script>