<script type="text/javascript">
    $(function() {
        $('#show_attendance_start_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#show_attendance_start_date').text($('#show_attendance_start_date').data('date'));
            $('#show_attendance_start_date').datepicker('hide');
        });
        $('#show_attendance_end_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#show_attendance_end_date').text($('#show_attendance_end_date').data('date'));
            $('#show_attendance_end_date').datepicker('hide');
        });
        $("#button_search_attendance").on("click", function() {
            $.ajax({
                dataType: 'json',    
                type: "POST",
                url: '<?php echo base_url(); ?>' + "attendance/search_attendance",
                data: {
                    user_id: $("#salesman_list").val(),
                    start_date: $("#show_attendance_start_date").val(),
                    end_date: $("#show_attendance_end_date").val()
                },
                success: function(data) {
                    $("#tbody_attendance_list").html(tmpl("tmpl_attendance_list", data));
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_attendance_list">
    {% var i=0, attendance_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(attendance_info){ %}
    <tr>
    <td><?php echo '{%= attendance_info.login_date%}'; ?></td>
    <td><?php echo '{%= attendance_info.login_time%}'; ?></td>
    <td><?php echo '{%= attendance_info.logout_time%}'; ?></td>
    <td><?php echo '{%= attendance_info.attendance_comment%}'; ?></td>
    </tr>
    {% attendance_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class ="row form-background">
    <div class ="col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="salesman_list" class="col-md-6 control-label requiredField">
                                Select Staff
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_dropdown('salesman_list', $salesman_list, '','class="form-control" id="salesman_list"'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="button_search_attendance" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($button_search_attendance+array('class'=>'form-control btn-success')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <div class ="col-md-6">
        <div class ="row">
            <div class ="col-md-12 form-horizontal">
                <div class="row">
                    <div class ="col-md-6 margin-top-bottom">
                        <div class="form-group">
                            <label for="show_attendance_start_date" class="col-md-6 control-label requiredField">
                                Start Date
                            </label>
                            <div class ="col-md-6">
                               <?php echo form_input($show_attendance_start_date+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="show_attendance_end_date" class="col-md-6 control-label requiredField">
                                End Date
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($show_attendance_end_date+array('class'=>'form-control')); ?>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h2>Search Result</h2>
<div class="row form-background">
    <div class="row col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody id="tbody_attendance_list">                    
                
                </tbody>
            </table>
        </div>
    </div> 
</div>