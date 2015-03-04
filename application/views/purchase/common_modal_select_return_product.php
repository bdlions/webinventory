<script type="text/javascript">
      function check_all_checkbox(checked_all){
        if( $(checked_all).is(':checked') ){
            $('input[name^="product_checkbox_"]').each(function(){
            $(this).prop('checked', true);
            $(this).parents('tr').css('background-color', '#47A447');
        });
        }else{
            $('input[name^="product_checkbox_"]').each(function(){
            $(this).prop('checked', false);
            $(this).parents('tr').css('background-color', '#E4F2D9');
        });
        }
    }
    $(function() {
        //close button for modal hide
        $('#button_close_modal').on('click', function(){
           $('#common_modal_select_return_product').modal('hide') 
        });
        $("#tbody_purchased_product_list").on("click", "td", function() 
        {            
            var p_list = get_product_list();
            for (var counter = 0; counter < p_list.length; counter++)
            {
                var prod_info = p_list[counter];
                if ($(this).attr("id") === prod_info['id'])
                {
                    append_selected_product(prod_info);
                    $('div[class="clr dropdown open"]').removeClass('open');
                    $('#common_modal_select_return_product').modal('hide');
                    return;
                }
            }
            
        });
    });

</script>
<script type="text/x-tmpl" id="tmpl_purchased_product_list">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr>
    <td id="<?php echo '{%= product_info.product_id%}'; ?>"><?php echo '{%= product_info.product_name%}'; ?></td>
    <td><a target="_blank" href="<?php echo base_url() . "product/show_product/" . '{%= product_info.product_id%}'; ?>">view</a></td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<div class="modal fade" id="common_modal_select_return_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Product</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="row col-md-11">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_purchased_product_list">
                                
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button id="button_close_modal" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



