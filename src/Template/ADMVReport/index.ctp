
<?php

use Cake\Routing\Router; ?>

<script type="text/javascript">

</script>

<div class="container-fluid">
    <div class="jumbotron formcontent">
        <h4>ADMV Report</h4>
<?php echo $this->Form->create($ADMVReport, array('name' => 'inputSearch', 'class' => 'form-horizontal', 'id' => 'projectforms')); ?>

        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Project</label>
                <div class="col-sm-6">
<?php echo $ProListopt; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-6 control-label">Month</label>
                <div class="col-sm-6">
                    <?php
                    $Month = array(0 => '--Select--', 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
                    echo $this->Form->input('', array('options' => $Month, 'id' => 'month', 'name' => 'month', 'class' => 'form-control prodash-txt'));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-6 control-label">Year</label>
                <div class="col-sm-6">
                    <?php
                    $currentYear = date('Y');
                    $PreviousYear = $currentYear - 5;
                    $year = array();
                    $year[0].='--Select--';
                    for ($i = $currentYear; $i >= $PreviousYear; $i--) {
                        $year[$i].=$i;
                    }
                    echo $this->Form->input('', array('options' => $year, 'id' => 'year', 'name' => 'year', 'class' => 'form-control prodash-txt'));
                    ?>
                </div>
            </div>
        </div>
        <div id="LoadAttribute"></div>

        <div class="form-group" style="text-align:center;">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm" value="Submit" id="submit" name="submit" onclick="return validateForm()">Submit</button>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>

    </div>
</div>
<?php if (count($test) > 0) { ?>
<div class="bs-example">
    <table class="table table-striped table-center">

        <thead><tr>
                <th>Sub Group Name</th>
                <th>Field Name</th>
                <th>X</th>
                <th>A</th>
                <th>D</th>
                <th>M</th>
                <th>V</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($test as $query => $value) {
                ?>
                <?php
                $i = 0;
                foreach ($value as $vals => $val) {
                    echo '<tr>';
                    if ($i == 0)
                        echo '<td rowspan=' . count($value) . '>' . $query . '</td>';
                    $Total = $val['X'] + $val['A'] + $val['D'] + $val['M'] + $val['V'];
                    echo '<td>' . $vals . '</td>';
                    echo '<td>' . $val['X'] . '</td>';
                    echo '<td>' . $val['A'] . '</td>';
                    echo '<td>' . $val['D'] . '</td>';
                    echo '<td>' . $val['M'] . '</td>';
                    echo '<td>' . $val['V'] . '</td>';
                    echo '<td>' . $Total . '</td>';
                    echo '</tr>';
                    $i++;
                }
                ?>  
            <?php } ?>
        </tbody>

    </table>
</div>

<?php } ?>

