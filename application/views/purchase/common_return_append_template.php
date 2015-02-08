<!--tamplate for append selected product--> 
              
<script type="text/x-tmpl" id="tmpl_selected_product_info">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr>
    <td id="<?php echo '{%= product_info.id%}'; ?>"><input name="name" type="hidden" value="<?php echo '{%= product_info.name%}'; ?>"/><?php echo '{%= product_info.name%}'; ?></td>
    <td><input class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="quantity" type="text" value=""/></td>
    <td><?php echo '{%= product_info.category_unit %}'; ?></td>
    <td><input readonly="readonly" class="input-width-table" id="<?php echo '{%= product_info.id%}'; ?>" name="price" type="text" value="{%= product_info.unit_price %}"/></td>
    <td><input class="input-width-table" name="product_buy_price" type="text" readonly="true" value=""/></td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<script>
    function color_setter(){
        $('input[name^="product_checkbox_"]').on('click', function(){
            if( $(this).is(':checked') ){
                $(this).parents('tr').css('background-color', '#B5E61D');
            }
            else{
                $(this).parents('tr').css('background-color', '#E4F2D9');
            }
        });
    }
    $(color_setter());
</script>
<td id="purchase_order_number_td" style="display: none"></td>