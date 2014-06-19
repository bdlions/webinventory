<h3>Customer List</h3>

<div class ="form-background top-bottom-padding">
    <div class="table-responsive">
        <div class="row" style="margin:0px;">
            <div class="col-md-offset-3 col-md-5">
                <div class=" input-group search-box">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                    <div style="position: relative;" class="twitter-typeahead">
                        <input type="text" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);" class="tt-hint form-control" autocomplete="off" spellcheck="off" disabled="">
                        <div class="twitter-typeahead" style="position: relative;"><input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% transparent;"><input type="text" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;" spellcheck="false" autocomplete="off" id="search_box_mid" class="form-control tt-query" placeholder="Search for customer"><div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></div><div class="tt-dropdown-menu dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"></div></div>
                        <div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;">

                        </div>
                        <div style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;" class="tt-dropdown-menu dropdown-menu">

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
                    <th>Manage</th>
                    <th>Show</th>
                    <th>Transactions</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">
                <?php
                foreach ($customer_list as $key => $customer_info) {
                    ?>
                    <tr>
                        <td><?php echo $customer_info['first_name'] ?></td>
                        <td><?php echo $customer_info['last_name'] ?></td>
                        <td><?php echo $customer_info['phone'] ?></td>
                        <td><?php echo $customer_info['address'] ?></td>
                        <td><a href="<?php echo base_url("./user/update_customer/" . $customer_info['customer_id']); ?>">Update</a></td>
                        <td><a href="<?php echo base_url("./user/show_customer/" . $customer_info['customer_id']); ?>">Show</a></td>
                        <td><a href="<?php echo base_url("./payment/show_customer_transactions/" . $customer_info['customer_id']); ?>">Show</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-9">

        </div>
        <div class="col-md-3">
            <?php echo form_open("user/download_search_customer", array('id' => 'form_download_search_customer_by_card_no_range', 'class' => 'form-horizontal')); ?>
            <div class="form-group">
                <label for="expense_categories" class="col-md-6 control-label requiredField">
                    Select Type
                </label>
                <div class ="col-md-6">
                    <?php
                    $options = array(
                        'name' => 'Name',
                        'mobile_no' => 'Mobile No',
                        'both' => 'Both'
                    );

                    echo form_dropdown('select_option_for_download', $options, 'both', 'class="form-control" id="select_option_for_download"');
                    ?>
                </div> 
            </div>

            <div class="form-group">
                <label for="button_download_customer" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-6 col-md-offset-6">
                    <?php echo form_input($button_download_customer + array('class' => 'form-control btn-success')); ?>
                </div> 
            </div>
            <?php echo form_close(); ?>
        </div>    
    </div>
    <?php
    if (isset($pagination)) {
        echo $pagination;
    }
    ?>
</div>
<script type="text/javascript">
    $(function() {
        $("#search_box_mid").typeahead([
            {
                name: "search_customer_med",
                valuekey: "first_name",
                remote:'<?php echo base_url()?>search/get_customers?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Customer</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                ].join(''),
                engine: Hogan
            }
        ]).on('typeahead:selected', function(obj, datum) {
            if (datum.customer_id)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "search/get_customer_info",
                    data: {
                        customer_id: datum.customer_id
                    },
                    success: function(data) {
                        if(data.status == 1)
                        {
                            $("#tbody_customer_list").html(tmpl("tmpl_customer_list",  data.customer_info));
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
<script type="text/x-tmpl" id="tmpl_customer_list">
    {% var i=0, customer_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(customer_info){ %}
    <tr>
    <td>{%= customer_info.first_name%}</td>
    <td>{%= customer_info.last_name%}</td>
    <td>{%= customer_info.phone%}</td>
    <td>{%= customer_info.address%}</td>
    <td>{%= customer_info.card_no%}</td>
    <td><a href="<?php echo base_url() . "user/update_customer/{%= customer_info.customer_id%}"; ?>">Update</a></td>
    <td><a href="<?php echo base_url() . "user/show_customer/{%= customer_info.customer_id%}"; ?>">Show</a></td>
    <td><a href="<?php echo base_url() . "payment/show_customer_transactions/{%= customer_info.customer_id%}"; ?>">Show</a></td>
    </tr>
    {% customer_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>