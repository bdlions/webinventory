 <script type="text/javascript">
     $(function() {
            $("#button_purchase_default_purchase_order_no_lock").on("click", function() {
            $('#purchase_order_no').attr("disabled", true);
            $('#div_unlock_purchase_order_no').show();
            $('#div_lock_purchase_order_no').hide();
            $('#div_button_warehouse_purchase_order').hide();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/update_purchase_order_no_in_shop_info ",
                data: {
                    purchase_default_purchase_order_no: $('#purchase_order_no').val()
                },
                success: function(data) {
                     alert(data['message']);
                    
                }
            });
        });
        $("#button_purchase_default_purchase_order_no_unlock").on("click", function() {
            $('#purchase_order_no').attr("disabled", false)
            $('#div_unlock_purchase_order_no').hide();
            $('#div_button_warehouse_purchase_order').show();
            $('#div_lock_purchase_order_no').show();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/update_purchase_order_no_in_shop_info",
                data: {
                    purchase_default_purchase_order_no: ''
                },
                success: function(data) {
                    alert(data['message']);
                    window.location.reload(true);
                }
            });
        });
    });
    function purchase_default_info(default_purchase_order_no){
        $('#purchase_order_no').val(default_purchase_order_no);
        $('#purchase_order_no').attr("disabled", true);
        $('#div_unlock_purchase_order_no').show();
        $('#div_lock_purchase_order_no').hide();
        
    }
    function purchase_info(){
        $('#purchase_order_no').attr("disabled", false);
        $('#div_unlock_purchase_order_no').hide();
        $('#div_lock_purchase_order_no').show();
    }
    
    </script>
     <div class ="col-md-5 form-horizontal margin-top-bottom">
                    <div class="form-group">
                        <label for="purchase_order_no" class="col-md-4 control-label requiredField">
                            Lot No
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input(array('name' => 'purchase_order_no', 'id' => 'purchase_order_no', 'class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group" id="div_lock_purchase_order_no">
                        <label for="button_purchase_default_purchase_order_no_lock" class="col-md-4 control-label requiredField">
                            &nbsp;
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_button(array('name' => 'button_purchase_default_purchase_order_no_lock', 'id' => 'button_purchase_default_purchase_order_no_lock', 'content' => 'Lock', 'class' => 'form-control btn-success')); ?>
                        </div> 
                    </div>
                    <div class="form-group" id="div_unlock_purchase_order_no">
                        <label for="button_purchase_default_purchase_order_no_unlock" class="col-md-4 control-label requiredField">
                            &nbsp;
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_button(array('name' => 'button_purchase_default_purchase_order_no_unlock', 'id' => 'button_purchase_default_purchase_order_no_unlock', 'content' => 'Unlock', 'class' => 'form-control btn-success')); ?>
                        </div> 
                    </div>
                </div>