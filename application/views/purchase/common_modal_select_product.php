<script type="text/javascript">
    //select all check box
     function check_all_checkbox(checked_all){
        if( $(checked_all).is(':checked') ){
            $('input[name^="product_checkbox_"]').each(function(){
            $(this).prop('checked', true);
            $(this).parents('tr').css('background-color', '#B5E61D');
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
        $('#modal_button_hide').on('click', function(){
           $('#common_modal_select_product').modal('hide') 
        });
        //search product by product name
        $("#button_search_product").on("click", function() {
            if ($("#dropdown_search_product")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if ($("#input_search_product").val().length == 0)
            {
                alert("Please assign value of search criteria");
                return false;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_product_order",
                data: {
                    search_category_name: $("#dropdown_search_product").val(),
                    search_category_value: $("#input_search_product").val()
                },
                success: function(data) {
                    $("#tbody_product_list").html(tmpl("tmpl_product_list", data));
                }
            });
        });
        
        $("#tbody_product_list").on("click", "td", function()
        {
            var p_list = get_product_list();
            for (var counter = 0; counter < p_list.length; counter++)
            {
                var prod_info = p_list[counter];
                if ($(this).attr("id") === prod_info['id'])
                {
                    append_selected_product(prod_info);
                    $('div[class="clr dropdown open"]').removeClass('open');
                    $('#common_modal_select_product').modal('hide');
                    return;
                }
            }

        });

        $("#button_add_select_product").on("click", function() {
            var selected_array = Array();
            $("#tbody_product_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            
            
            
            var p_list = get_product_list();
            for (var counter = 0; counter < p_list.length; counter++)
            {
                var prod_info = p_list[counter];
                for (var i = 0; i < selected_array.length; i++) {
                    if (selected_array[i] === prod_info['id'])
                    {
                        append_selected_product(prod_info);
                    }
                }
            }
            $('div[class="clr dropdown open"]').removeClass('open');
            $('#common_modal_select_product').modal('hide');
        });

        
        // clear input of modal when modal close
        $('#common_modal_select_product').on('hidden.bs.modal', function (e) {
            $(this).find("input,textarea,select").val('').end()
              .find("input[type=checkbox], input[type=radio]")
                 .prop("checked", "")
                 .end();
          });
        
    });
</script>
<script type="text/x-tmpl" id="tmpl_product_list">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr>
    <td style="width: 20px; padding: 0px" ><label for="<?php echo '{%= product_info.id%}'; ?>" style="padding: 5px 40px;"><input id="<?php echo '{%= product_info.id%}'; ?>" name="product_checkbox_<? echo '{%=product_info.id%}';?>" class="" type="checkbox"></label></td>
    <td id="<?php echo '{%= product_info.id%}'; ?>"><?php echo '{%= product_info.name%}'; ?></td>
    <td>700 pieces</td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<div class="modal fade" id="common_modal_select_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Product</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="row col-md-11">
                        <div class="row table-responsive pre-scrollable">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="check_all_checkbox(this)" value="" style="margin: 10px,10px,0px,0px;"><span style="padding-left: 2px">Check All</span></th>
                                        <th>Name</th>
                                        <th>Current stock</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_product_list">
                                    <?php
                                    foreach ($product_list_array as $key => $product) {
                                        ?>
                                        <tr>
                                            <td style="width: 20px; padding: 0px" ><label for="<?php echo $product['id'] ?>" style="padding: 5px 40px;"><input id="<?php echo $product['id'] ?>" name="product_checkbox_<?php echo $product['id'] ?>" class="" type="checkbox"></label></td>
                                            <td id="<?php echo $product['id'] ?>"><?php echo $product['name'] ?></td>
                                            <td>700 pieces</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                </tbody>
                            </table>                            
                        </div>
                        <div class ="row col-md-3 pull-right top-bottom-padding form-group">
                            <?php echo form_button(array('name' => 'button_add_select_product', 'class' => 'form-control btn btn-success', 'id' => 'button_add_select_product', 'content' => 'Add')); ?>
                        </div>
                    </div>
                    <div class ="row col-md-11 top-bottom-padding">
                        <div class ="col-md-3">
                            <span class="" style="vertical-align: top; font-size: 24px; line-height: 12px;">Search</span>
                        </div>
                        <div class="col-md-9 form-horizontal">
                            <div class="col-md-6">
                                <?php echo form_dropdown('dropdown_search_product', $product_search_category, '0', 'id="dropdown_search_product"'); ?>
                            </div>

                            <div class="col-md-6">
                                <div class="row form-group">
                                    <?php echo form_input(array('name' => 'input_search_product', 'id' => 'input_search_product', 'class' => 'form-control')); ?>
                                </div>
                                <div class="row form-group">
                                    <?php echo form_button(array('name' => 'button_search_product', 'class' => 'form-control btn btn-success', 'id' => 'button_search_product', 'content' => 'Search')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="new_product_add_div">      
                        <div class ="row col-md-11 top-bottom-padding">
                            <div class ="row col-md-4">
                                <span class="" style="vertical-align: top; font-size: 24px; line-height: 12px;">
                                    Add New
                                </span>
                            </div>
                            <div class="row col-md-8 form-horizontal">
                                <div class="row form-group">
                                    <label class="col-md-5 control-label requiredField" for="input_product_name">
                                        Product Name
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="input_product_name" value="" name="input_product_name">
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label requiredField" for="input_product_unit">
                                        Product Unit
                                    </label>
                                    <div id="unit_dropdown" class="col-md-7">
                                        <?php echo form_dropdown('product_unit_category_list', array('' => 'Select') + $product_unit_category_list, '', 'class=form-control id=dropdown'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label requiredField" for="input_new_unit">
                                        New Unit
                                    </label>
                                    <div class="col-md-7">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="input_new_unit" value="" name="input_new_unit">
                                        </div>
                                        <div class="col-md-6">
                                            <button id="button_add_new_unit" class="form-control btn btn-success" type="button" name="button_add_new_unit">
                                                Create
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-5 control-label requiredField" for="button_add_supplier">
                                    </label>
                                    <div class="col-md-offset-2 col-md-5">
                                        <button id="button_add_product" class="form-control btn btn-success" type="button" name="button_add_product">Add</button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_button_hide">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    // written by omar faruk
    $(function() {
        // here is new unit category is added
        $("#button_add_new_unit").on("click", function() {
            if ($("#input_new_unit").val().length == 0)
            {
                alert("Unit name is required.");
                return;
            }
            
            var unit_name = $("#input_new_unit").val();
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "product/create_product_unit",
                data: { unit_name: unit_name },
                success: function(data) {
                    alert(data.message);
                    
                    if (data['status'] === 1)
                    {
                        $("#dropdown").append("<option value='"+data['product_category_info'].id+"'>"+data['product_category_info'].description+"</option>");
                    }
                    
                }
            });
        });
        
        // here a product is added
        $("#button_add_product").on("click", function() {
            var input_product_name = $("#input_product_name").val();
            var product_unit_category = $("#dropdown").val();
            
            if (input_product_name.length == 0)
            {
                alert("product name is required.");
                return;
            }
            
            if (product_unit_category =='')
            {
                alert("please select a product unit.");
                return;
            }
            
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "product/create_product_by_ajax",
                data: { input_product_name: input_product_name, product_unit_category: product_unit_category},
                success: function(data) {
                    alert(data.message);
                    if (data['status'] === 1)
                    {
                        var p_list = get_product_list();
                        p_list[p_list.length] = data['product_info'];
                        set_product_list(p_list);
                        var product_info = data['product_info'];
                        $("#tbody_product_list").html($("#tbody_product_list").html()+tmpl("tmpl_product_list", product_info)); 
                    }
                    
                }
            });
        });
    });
    
</script>

