<div class="row col-md-11 form-background">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                </tr>
            </thead>
            <tbody>                
            <?php foreach($number_list as $number => $frequency){
                if($frequency == 1){
                ?>
                    <tr bgcolor="#00FF00">
                        <th><?php echo $number_name_map[$number];?></th>
                        <th><?php echo $number;?></th>
                    </tr>
                <?php    
                }
                else
                {
                    for($counter = 0; $counter < $frequency; $counter++)
                    {
                        if($counter == 0)
                        {
                        ?>
                            <tr bgcolor="#0000FF">
                                <th><?php echo $number_name_map[$number];?></th>
                                <th><?php echo $number;?></th>
                            </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                            <tr bgcolor="#FF0000">
                                <th><?php echo $number_name_map[$number];?></th>
                                <th><?php echo $number;?></th>
                            </tr>
                        <?php
                        }
                    }
                }
            }?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <?php echo form_open("sms/generate_number_file/", array('id' => 'form_generate_number_file', 'class' => 'form-horizontal')); ?>
        <div class="col-md-6"></div>
        <div class="col-md-4 form-group">
            <label for="operator_list" class="col-md-6 control-label requiredField">
                Select Operator
            </label>
            <div class ="col-md-6">
                <?php echo form_dropdown('operator_list', array(''=>'All')+$operator_list, '', 'class=form-control'); ?>
            </div> 
        </div>
        <div class="col-md-2">
            <input class="form-control btn-success pull-right" id="save_number" name="save_number" type="submit" value="Save"></input>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
