<h3>Configure your Queue</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open("queue/config_queue", array('id' => 'form_create_operator', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="total_number" class="col-md-6 control-label requiredField">
                    Total number
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($total_number+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="total_no_of_queue" class="col-md-6 control-label requiredField">
                    Total no of queue
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($total_no_of_queue+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <div class="form-group">
                <label for="distribution" class="col-md-6 control-label requiredField">
                    Equally Distribute
                </label>
                <div class ="col-md-1">
                    <?php echo form_checkbox($eaqually_distribute+array('class'=>'form-control')); ?>
                </div> 
            </div>
            
            <div class="form-group">
                <label for="distribution" class="col-md-6 control-label requiredField">
                    Set Global mesage
                </label>
                <div class ="col-md-1">
                    <?php echo form_checkbox($global_message_chcecked+array('class'=>'form-control')); ?>
                </div> 
            </div>
            
            <div class="form-group" id="show_global_message">
                <label for="global_message" class="col-md-6 control-label requiredField">
                    Global Message
                </label>
                <div class ="col-md-6">
                    <?php echo form_textarea($global_message+array('class'=>'form-control')); ?>
                </div> 
            </div>
            
            <div class="form-group">
                <label for="submit_create_operator" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_ok+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(function (){
       $('#show_global_message').hide();
       
         $('#global_message_chcecked').change(function(){
            if($(this).prop('checked') === true){
                $('#show_global_message').show();
            }else{
                $('#show_global_message').hide();
            }
        });
        
    });
    
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