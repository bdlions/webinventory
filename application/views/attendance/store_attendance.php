<script type="text/javascript">
    $(function() {
        $('#login_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#login_date').text($('#login_date').data('date'));
            $('#login_date').datepicker('hide');
        });
        var salesman_list = <?php echo json_encode($salesman_list);?>;
        $("#div_salesman_list").html(tmpl("tmpl_salesman_list", salesman_list));
    });
</script>
<script type="text/x-tmpl" id="tmpl_salesman_list">
    {% var i=0, salesman_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(salesman_info){ %}
      <div class="checkbox">
        <label>
          <input type="checkbox" name="<?php echo '{%= salesman_info.user_id%}'; ?>"> <?php echo '{%= salesman_info.first_name%} {%= salesman_info.last_name%}'; ?>
        </label>
      </div>
    {% salesman_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<h3><?php echo $this->lang->line("attendance_store_attendance_heading"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">    
    <div class="row" style="margin:0px;">
        <?php echo form_open("attendance/store_attendance", array('id' => 'form_store_attendance', 'class' => 'form-horizontal')); ?>
        <div class="col-md-1"></div>
        <div class ="col-md-3 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="row" style=margin:0px" id="div_salesman_list">

            </div>
        </div>
        <div class ="col-md-4 margin-top-bottom">
            <div class="form-group">
                <label for="login_date" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("attendance_store_attendance_login_date"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($login_date+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="login_time" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("attendance_store_attendance_in_time"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($login_time+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="logout_time" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("attendance_store_attendance_out_time"); ?>
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($logout_time+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="attendance_comment" class="col-md-6 control-label requiredField">
                    <?php echo $this->lang->line("attendance_store_attendance_comment"); ?>
                    
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($attendance_comment+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="submit_store_attendance" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_store_attendance+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>    
        <?php echo form_close(); ?>
    </div>    
</div>
