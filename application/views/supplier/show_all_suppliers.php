<h3>Supplier List</h3>
<div class ="row form-background top-bottom-padding">
    <div class="table-responsive">
        
        <div class="row">
            <div class="col-md-offset-3 col-md-5">
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
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Company</th>
                    <th>Manage</th>
                    <th>Show</th>
                    <th>Transactions</th>
                </tr>
            </thead>
            <tbody id="tbody_supplier_list">
                <?php
                foreach ($supplier_list as $key => $supplier_info) {
                ?>
                    <tr>
                        <td><?php echo $supplier_info['first_name'] ?></td>
                        <td><?php echo $supplier_info['last_name'] ?></td>
                        <td><?php echo $supplier_info['phone'] ?></td>
                        <td><?php echo $supplier_info['address'] ?></td>
                        <td><?php echo $supplier_info['company'] ?></td>
                        <td><a href="<?php echo base_url("./user/update_supplier/" . $supplier_info['supplier_id']); ?>">Update</a></td>
                        <td><a href="<?php echo base_url("./user/show_supplier/" . $supplier_info['supplier_id']); ?>">Show</a></td>
                        <td><a href="<?php echo base_url("./payment/show_supplier_transactions/" . $supplier_info['supplier_id']); ?>">Show</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php 
        if(isset($pagination)){
            echo $pagination; 
        }
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var supplier_data = <?php echo json_encode($all_suppliers) ?>;
        set_supplier_list(supplier_data);
    });
</script>
<script type="text/javascript">
    $(function(){
        $("#search_box").typeahead([
            {
                name:"search_supplier",
                valuekey:"first_name",
                local:<?php echo $searched_suppliers;?>,
                /*prefetch:{
                            url: '<?php echo base_url()?>search/get_supplier',
                            ttl: 0
                        },*/
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
                        $("#tbody_supplier_list").html(tmpl("tmpl_supplier_list",  sup_info));
                    }
                }
            }
        });  
    });
</script>
<script type="text/x-tmpl" id="tmpl_supplier_list">
    {% var i=0, supplier_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(supplier_info){ %}
    <tr>
        <td>{%= supplier_info.first_name%}</td>
        <td>{%= supplier_info.last_name%}</td>
        <td>{%= supplier_info.phone%}</td>
        <td>{%= supplier_info.address%}</td>
        <td>{%= supplier_info.company%}</td>
        <td><a href="<?php echo base_url()."user/update_supplier/{%= supplier_info.supplier_id%}"; ?>">Update</a></td>
        <td><a href="<?php echo base_url()."user/show_supplier/{%= supplier_info.supplier_id%}"; ?>">Show</a></td>
        <td><a href="<?php echo base_url()."payment/show_supplier_transactions/{%= supplier_info.supplier_id%}"; ?>">Show</a></td>
    </tr>
    {% supplier_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>