<script type="text/javascript">
    $(function() {
        $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });
        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#end_date').text($('#end_date').data('date'));
            $('#end_date').datepicker('hide');
        });
    });
</script>

<script type="text/javascript">
    /*$(document).ready(function() {
         $("#button_search_supplier_message").on("click", function() {
             alert('dddddd');
        });
    });*/
</script>

<h3>Supplier Message List</h3>

<div class="row form-horizontal form-background top-bottom-padding">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 form-horizontal">
                <div class ="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8" style="color: red">
                        <?php echo $message; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 margin-top-bottom">
                        <!--<form class="form-horizontal" id="form_search_supplier_message" accept-charset="utf-8" method="post" action="">-->
                        <?php echo form_open("sms/all_supplier_message", array('id' => 'form_search_supplier_message', 'class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <label class="col-md-6 control-label requiredField" for="start_date">
                                    Start Date
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="start_date" value="" name="start_date">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label requiredField" for="end_date">
                                    End Date
                                </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="end_date" value="" name="end_date">
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-md-6 control-label requiredField" for="button">
                                </label>
                                <div class="col-md-6">
                                    <input type="submit" class="form-control btn-success" id="button_search_supplier_message" value="Search" name="button_search_supplier_message">                            
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h3>Search Result</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Message No</th>
                    <th>Supplier Name</th>
                    <th>Message Description</th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                $i = 1;
                foreach ($message_list as $key => $message_info) {
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $message_info['first_name']." " . $message_info['last_name']; ?></td>
                        <td><?php echo html_entity_decode(html_entity_decode($message_info['message'])) ?></td>
                        <td><a href="<?php echo base_url("./sms/update_supplier_message/".$message_info['id']);?>">Update</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>