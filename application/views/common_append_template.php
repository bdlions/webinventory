<!--tamplate for append selected product for add,raise,return warehouse purchased raise ,return stock and add new seal 
    @written by Rashida 11th February 2015--> 

              
<script type="text/x-tmpl" id="tmpl_selected_product_info">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr id="product_row_<?php echo '{%= product_info.id%}'; ?>">
    <td style="width: 20px; padding: 0px" ><label for="<?php echo '{%= product_info.id%}'; ?>" style="padding: 5px 40px;"><input id="<?php echo '{%= product_info.id%}'; ?>" name="product_checkbox_<?php echo '{%= product_info.id%}'; ?>" class="" type="checkbox"></label></td>
    <td id="<?php echo '{%= product_info.id%}'; ?>"><input name="name" type="hidden" value="<?php echo '{%= product_info.name%}'; ?>"/><?php echo '{%= product_info.name%}'; ?></td>
    <td class="purchase_order_number_td"><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="purchase_order_no" type="text" value=""/></td>           
    <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="quantity" type="text" value=""/></td>
        
    {% if(product_info.readonly == 'true') { %}
    <td><?php echo '{%= product_info.category_unit %}'; ?></td>
    <td><input readonly="readonly" class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value="{%= product_info.unit_price %}"/></td>
    {% }else{ %} 
    <td><?php echo '{%= product_info.category_unit %}'; ?></td>

    <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value=""/></td>
    {% } %}
        
    <td><input class="input-width-table" name="product_price" type="text" readonly="true" value=""/></td>
    <td id=""><button onclick="delete_row(<?php echo '{%= product_info.id%}'; ?>)" id="<?php echo '{%= product_info.id%}'; ?>" name="delete_product_<?php echo '{%= product_info.id%}'; ?>"  class="glyphicon glyphicon-trash"></button></td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<script>
    //bgcolor set 
    function color_setter(){
        $('input[name^="product_checkbox_"]').on('click', function(){
            if( $(this).is(':checked') ){
                $(this).parents('tr').css('background-color', '#47A447');
                $('#delete_seleted_product').show();
            }
            else{
                $(this).parents('tr').css('background-color', '#E4F2D9');
            }
        });
    }
    $(color_setter());
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
    });
   
</script>
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