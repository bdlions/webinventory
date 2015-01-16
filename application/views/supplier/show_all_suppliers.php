<h3>Supplier List</h3>
<div class ="form-background top-bottom-padding">
    <div class="table-responsive">        
        <div class="row" style="margin:0px;">
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
        </div><br>        
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
                    <th>Status</th>
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
                        <td><a href="<?php echo base_url("./supplier/update_supplier/" . $supplier_info['supplier_id']); ?>">Update</a></td>
                        <td><a href="<?php echo base_url("./supplier/show_supplier/" . $supplier_info['supplier_id']); ?>">Show</a></td>
                        <td><a href="<?php echo base_url().'transaction/show_supplier_transactions/'.$supplier_info['supplier_id']; ?>">Show</a></td>
                        <?php if($supplier_info['account_status_id'] == ACCOUNT_STATUS_ACTIVE){?>
                        <td><a onclick="open_modal_inactive_account_status_confirm(<?php echo $supplier_info['user_id'] ?>)"><?php echo $supplier_info['account_status'];?></a></td>
                        <?php }else if($supplier_info['account_status_id'] == ACCOUNT_STATUS_INACTIVE){?>
                        <td><a onclick="open_modal_active_account_status_confirm(<?php echo $supplier_info['user_id'] ?>)"><?php echo $supplier_info['account_status'];?></a></td>
                        <?php }?>
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
    $(function(){
        $("#search_box").typeahead([
            {
                name:"search_supplier",
                valuekey:"first_name",
                remote:'<?php echo base_url()?>search/get_suppliers?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{company}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.supplier_id)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "supplier/get_supplier_info",
                    data: {
                        supplier_id: datum.supplier_id
                    },
                    success: function(data) {
                        if(data.status == 1)
                        {
                            $("#tbody_supplier_list").html(tmpl("tmpl_supplier_list",  data.supplier_info));
                        }
                        else if(data.status == 0)
                        {
                            alert(data.message);
                        }
                    }
                });
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
        <td><a href="<?php echo base_url()."supplier/update_supplier/{%= supplier_info.supplier_id%}"; ?>">Update</a></td>
        <td><a href="<?php echo base_url()."supplier/show_supplier/{%= supplier_info.supplier_id%}"; ?>">Show</a></td>
        <td><a href="<?php echo base_url()."transaction/show_supplier_transactions/{%= supplier_info.supplier_id%}"; ?>">Show</a></td>
        {% if(supplier_info.account_status_id == <?php echo ACCOUNT_STATUS_ACTIVE?>){ %}
        <td><a onclick="open_modal_inactive_account_status_confirm({%= supplier_info.user_id%})">{%= supplier_info.account_status %}</a></td>
        {% }else if(supplier_info.account_status_id == <?php echo ACCOUNT_STATUS_INACTIVE?>){  %}
        <td><a onclick="open_modal_active_account_status_confirm({%= supplier_info.user_id%})">{%= supplier_info.account_status %}</a></td>
        {% } %}
    </tr>
    {% supplier_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<?php 
$this->load->view("user/modal/active_account_status_confirm");
$this->load->view("user/modal/inactive_account_status_confirm");