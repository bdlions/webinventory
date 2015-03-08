 <script type="text/javascript">
     $(function() {
            $("#button_purchase_default_purchase_order_no_lock").on("click", function() {
            $('#purchase_order_no').attr("disabled", true);
            $('#div_unlock_purchase_order_no').show();
            $('#div_lock_purchase_order_no').hide();
//            $('#div_button_purchase_order').hide();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/update_purchase_order_no_in_shop_info ",
                data: {
                    purchase_default_purchase_order_no: $('#purchase_order_no').val()
                },
                success: function(data) {
                    
                }
            });
        });
        $("#button_purchase_default_purchase_order_no_unlock").on("click", function() {
            $('#purchase_order_no').attr("disabled", false)
            $('#div_unlock_purchase_order_no').hide();
            $('#div_button_purchase_order').show();
            $('#div_lock_purchase_order_no').show();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "purchase/update_purchase_order_no_in_shop_info",
                data: {
                    purchase_default_purchase_order_no: ''
                },
                success: function(data) {
                    $('#purchase_order_no').val(null);
                    window.location.reload(true);
                }
            });
        });
    });
    
    </script>