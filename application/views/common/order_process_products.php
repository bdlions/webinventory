<!--tamplate for append selected product for add,raise,return warehouse purchased raise ,return stock and add new seal 
    @written by Rashida 11th February 2015--> 

              
<script type="text/x-tmpl" id="tmpl_selected_product_info">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr id="product_row_<?php echo '{%= product_info.id%}'; ?>">
    <td style="padding: 0px" >
        <label for="<?php echo '{%= product_info.id%}'; ?>" style="padding: 13px 40px;">
            <input id="<?php echo '{%= product_info.id%}'; ?>" name="append_product_checkbox_<?php echo '{%= product_info.id%}'; ?>" class="" type="checkbox">
        </label>
    </td>
    <td id="<?php echo '{%= product_info.id%}'; ?>" style=" padding: 0px" >
        <label for="<?php echo '{%= product_info.id%}'; ?>" style="padding: 13px 40px">
            <input name="name" type="hidden" value="<?php echo '{%= product_info.name%}'; ?>"/><?php echo '{%= product_info.name%}'; ?>
        </label>
    </td>
    <td style=" padding: 0px" >
        <label for="<?php echo '{%= product_info.id%}'; ?>"  style="padding: 13px 40px">
            <?php echo '{%= product_info.category_unit %}'; ?>
        </label>
    </td>
    <td class="purchase_order_number_td"><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="purchase_order_no" type="text" value=""/></td>           
    <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="quantity" type="text" value=""/></td>
    {% if(product_info.readonly == 'true') { %}
    <td><input readonly="readonly" class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value="{%= product_info.unit_price %}"/></td>
    {% }else{ %} 
    <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value=""/></td>
    {% } %}
    <td><input class="input-width-table" name="product_price" type="text" readonly="true" value=""/></td>
    <td id=""><button onclick="delete_row(<?php echo '{%= product_info.id%}'; ?>)" id="<?php echo '{%= product_info.id%}'; ?>" name="delete_product_<?php echo '{%= product_info.id%}'; ?>"  class="glyphicon glyphicon-trash"></button></td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<script>
    function set_all_lot_no(lot_no_value){
        $("input", "#tbody_selected_product_list").each(function() {
            if ($(this).attr("name") === "purchase_order_no")
            {
                $(this).attr('value', $("#input_table_header_purchase_order_no").val());
            }
        });        
//        $('input[name^=purchase_order_no]').each(function(){
//            $(this).val($(lot_no_value).val());
//        });
    }
    function process_product_check_all_checkboxes(checked_all){
        if( $(checked_all).is(':checked') ){
            $('input[name^="append_product_checkbox_"]').each(function(){
                $(this).prop('checked', true);
                $(this).parents('tr').css('background-color', '#47A447');
            });
        }else{
            $('input[name^="append_product_checkbox_"]').each(function(){
                $(this).prop('checked', false);
                $(this).parents('tr').css('background-color', '#E4F2D9');
            });
        }
    }
    //bgcolor set 
    function color_setter(){
        $('input[name^="append_product_checkbox_"]').on('click', function(){
            if( $(this).is(':checked') ){
                $(this).parents('tr').css('background-color', '#47A447');
                $('#delete_seleted_product').show();
            }
            else{
                $(this).parents('tr').css('background-color', '#E4F2D9');
            }
        });
    }
//    $(color_setter());
    //remove selected product by modal window @rashida on 11th february
    function delete_row( product_id )
    {
        $("#delete_hidden_field").val(product_id);
        $("#modal_td_delete").modal('show');
    }
    $(function () 
    {
        $('#button_tr_delete').on('click', function(){
          var selection_id_fiddenfiled= $("#delete_hidden_field").val(); 
           var selection_id= $('input[name=delete_type]:checked').val();
          
           if(selection_id==1){
                $("#tbody_selected_product_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == true)
                    {
                        $(this).closest('tr').remove();
                        $("#modal_td_delete").modal('hide');
                    }
                });
             });
           }else if(selection_id==2){
                $("#tbody_selected_product_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == false)
                    {
                        $(this).closest('tr').remove();
                        $("#modal_td_delete").modal('hide');
                        
                    }
                });
             });
           }else if(selection_id==3){
               $("#tbody_selected_product_list tr").each(function() {
                  if(this.id=="product_row_"+selection_id_fiddenfiled){
                  $(this).remove();//kaj ka o korte pare
                   $("#modal_td_delete").modal('hide');
                  } 
               });
               
           }else{
               alert('Please select an option');
           }
           $('input[name=delete_type]:checked').attr('checked', false);
           $('#modal_td_delete').modal('hide');
        });
        
//       $("#tbody_selected_product_list").on("click", "tr", function()
//        {
//            
//            if($('input[type=checkbox]')){
//              $(this).attr('checked', true);  
//              $(this).parents('tr').css('background-color', '#47A447');  
//            }
////            elseif($('input[type=checkbox]:checked')){
////                $(this).attr('checked', false);  
////              $(this).parents('tr').css('background-color', 'transparent');  
////            }
//        });
           
    });
   
</script>
<div class="row col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><label style="padding: 5px 5px;"><input type="checkbox" onclick="process_product_check_all_checkboxes(this)" value="" style="margin: 10px,10px,0px,0px;"><span style="padding-left: 2px">Check All</span></label></th>
                    <th style="padding: 18px">Product Name</th>
                    <th style="padding: 18px">Product Unit</th>
                    <?php if($order_type == ORDER_TYPE_ADD_SALE){?>
                    <th style="padding-bottom: 16px"><span style="padding-right: 2px;">Lot No</span><input type="text" id="input_table_header_purchase_order_no" name="input_table_header_purchase_order_no" onkeyup="set_all_lot_no(this)" style="width: 70px; height: 20px;"></th>
                    <?php } ?>
                    <th style="padding: 18px">Quantity</th>                    
                    <th style="padding: 18px">Unit Price</th>
                    <th style="padding: 18px">Sub Total</th>
                    <th style="padding: 18px">Delete</th>
                </tr>
            </thead>
            <tbody id="tbody_selected_product_list">                        
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_td_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete products</h4>
            </div>
            <div class="modal-body">
                    <div class="row form-group">
                        <div class="col-sm-4"></div>
                        <div class ="col-sm-4">
                            <input type="radio" name="delete_type" class="row_selection" value="3"><span style="padding-left: 2px">delete this items only?</span>
                        </div>
                        <input type="hidden" id="delete_hidden_field">
                        <div class="col-sm-4"></div>
                    </div>   
                    <div class="row form-group">
                        <div class="col-sm-4"></div>
                        <div class ="col-sm-4">
                            <input type="radio" name="delete_type" class="row_selection" value="1"><span style="padding-left: 2px">delete selected items?</span>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>   
                    <div class="row form-group">
                        <div class="col-sm-4"></div>
                        <div class ="col-sm-4">
                            <input type="radio" name="delete_type" class="row_selection" value="2" ><span style="padding-left: 2px">delete unselected items?</span>
                            
                        </div>
                        <div class="col-sm-4"></div>
                    </div>   
                </div>                
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" id="button_tr_delete" name="button_tr_delete" value="" class="form-control btn btn-success pull-right">Delete</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->