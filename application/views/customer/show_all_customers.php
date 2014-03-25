<h3>Customer List</h3>
<div class ="row form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Card No</th>
                    <th>Manage</th>
                    <th>Show</th>
                    <th>Transactions</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($customer_list as $key => $customer_info) {
                ?>
                    <tr>
                        <td><?php echo $customer_info['first_name'] ?></td>
                        <td><?php echo $customer_info['last_name'] ?></td>
                        <td><?php echo $customer_info['phone'] ?></td>
                        <td><?php echo $customer_info['address'] ?></td>
                        <td><?php echo $customer_info['card_no'] ?></td>
                        <td><a href="<?php echo base_url("./user/update_customer/" . $customer_info['user_id']); ?>">Update</a></td>
                        <td><a href="<?php echo base_url("./user/show_customer/" . $customer_info['user_id']); ?>">Show</a></td>
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
        <div class="col-md-2">
            <?php echo form_open("user/download_search_customer", array('id' => 'form_download_search_customer_by_card_no_range', 'class' => 'form-horizontal')); ?>
            <div class="form-group">
                <label for="button_download_customer" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-12">
                    <?php echo form_input($button_download_customer+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
            <?php echo form_close(); ?>
        </div>    
    </div>
    <?php 
        if(isset($pagination)){
            echo $pagination; 
        }
    ?>
</div>