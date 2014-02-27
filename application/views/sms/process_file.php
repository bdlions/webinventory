<h3>Process File</h3>
<div class="row form-horizontal form-background top-bottom-padding">
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
                    <tr bgcolor="#4DB849">
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
                            <tr bgcolor="#108DE6">
                                <th><?php echo $number_name_map[$number];?></th>
                                <th><?php echo $number;?></th>
                            </tr>
                        <?php
                        }
                        else
                        {
                        ?>
                            <tr bgcolor="#E9393E">
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
        <div class="col-md-2"></div>
        <div class="col-md-4 form-group">
            <label for="color_list" class="col-md-6 control-label requiredField">
                Select Color
            </label>
            <div class ="col-md-6">
                <?php echo form_dropdown('color_list', array(''=>'All')+$color_list, '', 'class=form-control'); ?>
            </div> 
        </div>
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
