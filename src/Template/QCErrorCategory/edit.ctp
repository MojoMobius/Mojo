
<?php 
 use Cake\Routing\Router
?>

<div class="container-fluid">
    <div class="formcontent">
        <h4>QC Error Category Edit</h4>
            <?php echo $this->Form->create('',array('class'=>'form-horizontal','id'=>'projectforms')); ?>

        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label" style="padding-top:10px;"><b>Category Name</b></label>
                <div class="col-sm-6" style="margin-top:3px;" >
                     <?php 
                    $i = 0;
                                if ($category_name[$i]['ErrorCategoryName'] != '') { ?>
                    <input name="CategoryName" class="form-control" id="CategoryName_<?php echo ($i + 1); ?>" type="text" value="<?php echo $category_name[$i]['ErrorCategoryName'] ?>"></td>
                             <?php }else {?>
                    <td class="non-bor"> <input name="CategoryName" id="CategoryName_<?php echo ($i + 1); ?>" style="width:141px;" class="form-control"></td>
                        <?php } ?>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label" style="padding-top:10px;"><b>Sub Category Name</b></label>
                <div class="col-sm-6" style="margin-top:3px;" >


                    <table class="table list-master" style="width: 25%; margin-left: 75px;" id="AddUniqueTable">
                        <thead><tr style="display:none"></tr></thead>
                        <tbody>
                  <?php   if($sub_category_name_cnt == 0){  ?>
                            <tr>
                                <td class="non-bor"><input name="SubCategoryName[]" class="form-control" id="SubCategoryName_<?php echo ($i + 1); ?>" type="text" autocomplete="off" value="<?php echo $sub_category_name[$i]['SubCategoryName'] ?>"></td>
                       <?php if ($i == 0) { ?>
                                <td class="non-bor"><a><?php echo $this->Html->image("images/add.png", array('name' => 'add', 'onclick' => 'AddRow();')); ?></a></td >
                            <?php } else { ?>
                                <td class="non-bor"><?php echo $this->Html->image("images/delete.png", array('onclick' => 'RemoveRow(' . ($i + 1) . ');')); ?></td >
                            <?php } ?>
                            </tr>
                <?php } 
                            for ($i = 0; $i < $sub_category_name_cnt; $i++) { ?>
                            <tr>
                                <td class="non-bor"><input name="SubCategoryName[]" class="form-control" id="SubCategoryName_<?php echo ($i + 1); ?>" type="text" autocomplete="off" value="<?php echo $sub_category_name[$i]['SubCategoryName'] ?>"></td>
                       <?php if ($i == 0) { ?>
                                <td class="non-bor"><a><?php echo $this->Html->image("images/add.png", array('name' => 'add', 'onclick' => 'AddRow();')); ?></a></td >
                            <?php } else { ?>
                                <td class="non-bor"><?php echo $this->Html->image("images/delete.png", array('onclick' => 'RemoveRow(' . ($i + 1) . ');')); ?></td >
                            <?php } ?>
                            </tr>
                      <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <button type="Save" class="btn btn-primary btn-sm" onclick="return ValidateForm()">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    function ValidateForm() {
        if ($('#CategoryName_1').val() == 0) {
            alert('Enter Category Name value');
            $('#CategoryName_1').focus();
            return false;
        }

        var regex = new RegExp(/^[a-z\d\s]+$/i);
        var value = $('#CategoryName_' + 1).val();
        var result = regex.test(value);

        if (result == false) {

            alert("Only allowed AlphaNumeric Values");
            $('#CategoryName_' + 1).focus();
            return false;
        }

        var counter = $('#AddUniqueTable tbody tr').length;
        for (i = 1; i <= counter; i++)
        {
            if ($.trim($('#SubCategoryName_' + i).val()) == '')
            {
                alert('Enter Sub Category Name Option in Row - ' + i);
                $('#SubCategoryName_' + i).focus();
                return false;
            }

            // var regex = new RegExp(/^[a-z0-9]+$/i);
            var regex = new RegExp(/^[a-z\d\s]+$/i);
            var value = $('#SubCategoryName_' + i).val();
            var result = regex.test(value);

            if (result == false) {

                alert("Only allowed AlphaNumeric Values");
                $('#SubCategoryName_' + i).focus();
                return false;
            }


            for (j = 1; j <= counter; j++)
            {
                if (i != j)
                {
                    if ($('#SubCategoryName_' + i).val() == $('#SubCategoryName_' + j).val())
                    {
                        alert("Sub Category Name Entered in Row " + i + " matched with Row " + j);
                        $('#SubCategoryName_' + j).focus();
                        return false;
                    }

                }
            }
        }
    }
    function AddRow() {

        var count = $('#AddUniqueTable  tr').length;
        var newRow = $("<tr>");
        var cols = "";
        cols += '<td class="non-bor"><input type="text" name="SubCategoryName[]" id="SubCategoryName_' + count + '" autocomplete="off" class="form-control"></td>';
        cols += '<td class="non-bor"><img src="<?php echo Router::url('/', true); ?>webroot/img/images/delete.png" onclick="RemoveRow(' + count + ');"></td>';

        newRow.append(cols);
        $("#AddUniqueTable").append(newRow);
    }
    function RemoveRow(r) {
        var counter = $('#AddUniqueTable tbody tr').length;
        //var r = count;
        if (counter > 1) {
            $("#AddUniqueTable tbody tr:nth-child(" + r + ")").remove();
            var table = document.getElementById('AddUniqueTable');

            for (var r = 1, n = table.rows.length; r < n; r++) {

                for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {

                    if (c == 0)
                    {
                        var nodes = table.rows[r].cells[c].childNodes;
                        for (var i = 0; i < nodes.length; i++) {
                            if (nodes[i].nodeName.toLowerCase() == 'input')
                                nodes[i].id = 'SubCategoryName_' + r;
                        }
                    }
                    if (c == 1 && r > 1) {
                        var nodes = table.rows[r].cells[c].childNodes;
                        for (var i = 0; i < nodes.length; i++) {
                            nodes[i].setAttribute('onclick', "RemoveRow(" + r + ")");

                        }
                    }
                }
            }

        } else
        {
            alert('Minimum One Row Required')
        }
    }

</script>

