
<h3>Mange your Queue</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class="col-md-offset-4 col-md-5" id="show_error_message"></div>
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row form-horizontal form-background top-bottom-padding">
                <div class="table-responsive">
                     <input name="total_no_of_msg" type="hidden" id="total_no_of_msg" value="<?php echo $total_no; ?>">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Queue Name</th>
                                <th>Number of Message</th>
                                <?php if($global_msg != 1): ?>
                                    <th>Set Message</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_queue_list">
                            <?php for($i = 1; $i <= $no_of_queue; $i++): ?>
                                <tr>
                                    <td>
                                        <input style="text-align: center;" type="text" name="queue_name_<?php echo $i; ?>" id="queue_name_<?php echo $i; ?>" value="Q<?php echo $i; ?>">
                                    </td>
                                    <td>
                                        <input <?php echo ($euqally != 1) ? '' : 'readonly'; ?> style="text-align: center;" type="text" onchange="add_msg_number();" name="no_of_queue_<?php echo $i; ?>" onkeydown = "validateNumberAllowDecimal(event, false)" id="no_of_queue_<?php echo $i; ?>" value="<?php echo $msg_in_each_queue; ?>">
                                        <input type="hidden" name="global_message" id="global_message" value="<?php echo $global_message; ?>" >
                                    </td>
                                    <?php if($global_msg != 1): ?>
                                        <td>
                                            <button id="set_msg_for_q_<?php echo $i; ?>" class="form-control btn-success" type="button" name="set_msg_for_q_<?php echo $i; ?>" onclick="openModal('set_msg_for_q_<?php echo $i;?>','<?php echo $i; ?>')">
                                                Set Message
                                            </button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                        <tr>
                            <td>
                                Total No of Message:
                            </td>
                            <td>
                                <span id="total_no" ><?php echo $total_no; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" class="form-control btn-success" id="submit_final_queue" value="Final Submit" name="submit_final_queue">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<?php $this->load->view("queue/modal_set_msg_for_queue"); ?>

<script type="text/javascript">
    $(function (){
        
    });
    
    function add_msg_number () {
        
        var total_no_of_msg = $('#total_no_of_msg').val();
        var sum = parseInt(0);
        //var tdList = $('#tbody_queue_list tr').eq(1);
        $.each($('#tbody_queue_list tr'), function(key, tr){
            var noOfMessage = $(tr).children().eq(1).find('input').val();
            sum = sum + parseInt(noOfMessage);
        });
       if(parseInt(total_no_of_msg) < sum ) {
           $('#show_error_message').html("you are crossing the total number of message").css({ 'color': 'red', 'font-size': '100%' });
           $('#submit_final_queue').hide();
       } else {
           $('#show_error_message').html("");
           $('#submit_final_queue').show();
       }
    }
    
    function validateNumberAllowDecimal(event, isDecimal) {
        var keysWithDecimal;
        if (isDecimal) {
            // keycode 190 dot (.) without number pad
            // keycode 110 dot (.) on number pad
            keysWithDecimal = [46,8,9,27,13,190,110];
        } else {
            keysWithDecimal = [46,8,9,27,13];
        }

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(event.keyCode, keysWithDecimal) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        } else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    }
</script>