
<script type="text/javascript">
    $(function()
    {
        $("#button_search_supplier").on("click", function() {
            if ($("#dropdown_search_supplier")[0].selectedIndex == 0)
            {
                alert("Please select search criteria.");
                return false;
            }
            else if ($("#input_search_supplier").val().length == 0)
            {
                alert("Please assign value of search criteria");
                return false;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/search_supplier_purchase_order",
                data: {
                    search_category_name: $("#dropdown_search_supplier").val(),
                    search_category_value: $("#input_search_supplier").val()
                },
                success: function(data) {
                    $("#tbody_supplier_list").html(tmpl("tmpl_supplier_list", data));
                    set_supplier_list(data);
                }
            });
        });
        $("#tbody_supplier_list").on("click", "td", function() {
            var s_list = get_supplier_list();
            for (var counter = 0; counter < s_list.length; counter++)
            {
                var sup_info = s_list[counter];
                if ($(this).attr("id") === sup_info['supplier_id'])
                {
                    update_fields_selected_supplier(sup_info);
                    $('div[class="clr dropdown open"]').removeClass('open');
                    $('#modal_select_supplier').modal('hide');
                    return;
                }
            }
        });
        $("#button_close_modal_select_supplier").on("click", function() {
            $('#modal_select_supplier').modal('hide');
        });
    });
</script>

<script type="text/javascript">
    $(function(){
        $("#search_box").typeahead([
            {
                name:"search_supplier",
                valuekey:"first_name",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_supplier',
                            ttl: 0
                        },
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{company}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.first_name)
            {
                var s_list = get_supplier_list();
                for (var counter = 0; counter < s_list.length; counter++)
                {
                    var sup_info = s_list[counter];
                    if (datum.supplier_id === sup_info['supplier_id'])
                    {
                        update_fields_selected_supplier(sup_info);
                        $('#modal_select_supplier').modal('hide');
                        return;
                    }
                }
            }
        });  
    });
</script>

<div class="modal fade" id="modal_select_supplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Supplier</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="col-md-offset-2 col-md-6">
                            <div class=" input-group search-box">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                <div class="twitter-typeahead" style="position: relative;">
                                    <input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                                    <input type="text" placeholder="Search for supplier" class="form-control tt-query" id="search_box" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
                                    <div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;">
                                        
                                    </div>
                                    <div class="tt-dropdown-menu dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                                        
                                    </div>    
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    
                    
                </div>
            </div>
            <div class="modal-footer">
                <button id="button_close_modal_select_supplier" name="button_close_modal_select_supplier" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

