<h3>Search Staff Sale by Customer Card No</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("search/search_staff_sales_customer_card_no", array('method'=>'get', 'id' => 'form_search_staff_sales_customer_card_no', 'class' => 'form-horizontal')); ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <label for="cell" class="col-md-6 control-label requiredField">
                            Mobile No
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_input($cell+array('class'=>'form-control')); ?>
                        </div> 
                    </td>
                    <td>
                        <label for="staff_list" class="col-md-6 control-label requiredField">
                            Select Staff
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_dropdown('staff_list', array('0' => 'All')+$staff_list, $staff_id,'class="form-control" id="staff_list" name="staff_list"'); ?>
                        </div>
                    </td> 
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Sale Price : 
                        </label>
                        <label id="label_total_sale_price" class="col-md-6 control-label requiredField">
                            <?php echo $total_sale_price;?> 
                        </label>
                    </td>
                    <td>                        
                        <label class="col-md-6 control-label requiredField">
                            Total Quantity : 
                        </label>
                        <label id="label_total_quantity" class="col-md-6 control-label requiredField">
                            <?php echo $total_quantity;?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="card_no" class="col-md-6 control-label requiredField">
                            Card No
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_input($card_no+array('class'=>'form-control')); ?>
                        </div>
                    </td>
                    <td>
                                                
                    </td>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            <?php 
                                if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                                {                                    
                                    echo 'Total Profit : ';
                                }
                            ?>
                            
                        </label>
                        <label id="label_total_profit" class="col-md-6 control-label requiredField">
                            <?php 
                                if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                                {                                    
                                    echo $total_profit;
                                }
                            ?>
                        </label>
                    </td>
                    <td>
                        <label for="button_search_sale" class="col-md-6 control-label requiredField">

                        </label>
                        <div class ="col-md-6">
                            <?php echo form_input($button_search_sale+array('class'=>'form-control btn-success')); ?>
                        </div>
                    </td>
                </tr>                
            </tbody>  
        </table>
    </div> 
    <?php echo form_close(); ?>
</div>
<h3>Search Result</h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Card No</th>
                    <th>Staff</th>
                    <th>Product Name</th>
                    <th>Lot No</th>
                    <th>Sub Lot No</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Purchase Unit Price</th>';
                        }                            
                    ?>
                    <th>Sale Unit Price</th>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Total Purchase Price</th>';
                        }                            
                    ?>
                    <th>Total Sale Price</th>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Net Profit</th>';
                        }                            
                    ?> 
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Transactions</th>';
                        }                            
                    ?> 
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Return</th>';
                        }                            
                    ?>
                    <?php 
                        if($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER)
                        {                                    
                            echo '<th>Delete</th>';
                        }                            
                    ?>
                </tr>
            </thead>
            <tbody id="tbody_customer_sale_list">                
                <?php foreach ($sale_list as $sale_info) { ?>
                    <tr>
                        <td><?php echo $sale_info['card_no']; ?></td>
                        <td><?php echo $sale_info['salesman_first_name'].' '.$sale_info['salesman_last_name']; ?></td>
                        <td><?php echo $sale_info['product_name']; ?></td>
                        <td><?php echo $sale_info['purchase_order_no']; ?></td>
                        <td><?php echo $sale_info['product_category1']; ?></td>
                        <td><?php echo $sale_info['product_size']; ?></td>
                        <td><?php echo $sale_info['total_sale']; ?></td>
                        <?php
                        if ($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER) {
                            echo '<td>'.$sale_info['purchase_unit_price'].'</td>';
                        }
                        ?> 
                        <td><?php echo $sale_info['sale_unit_price']; ?></td>
                        <?php
                        if ($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER) {
                            echo '<td>'.$sale_info['total_sale']*$sale_info['purchase_unit_price'].'</td>';
                        }
                        ?>
                        <td><?php echo $sale_info['total_sale']*$sale_info['sale_unit_price']; ?></td>
                        <?php
                        if ($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER) {
                            echo '<td>'.($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price']) * $sale_info['total_sale'].'</td>';
                        }
                        ?>
                        <?php
                        if ($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER) {
                            echo '<td>';
                            echo '<a href="' . base_url() . 'transaction/show_customer_transactions/' . $sale_info['customer_id'] . '">Show</a>';
                            echo '</td>';
                        }
                        ?>
                        <?php
                        if ($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER) {
                            echo '<td>';
                            echo '<a href="' . base_url() . 'sale/return_sale_order/' . $sale_info['sale_order_no'] . '">Return</a>';
                            echo '</td>';
                        }
                        ?>
                        <?php
                        if ($user_group['id'] == USER_GROUP_ADMIN || $user_group['id'] == USER_GROUP_MANAGER) {
                            echo '<td>';
                            echo '<a href="' . base_url() . 'sale/delete_sale/' . $sale_info['sale_order_no'] . '">Delete</a>';
                            echo '</td>';
                        }
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="row col-md-12">
        <?php for($counter = 1; $counter <= $total_pages; $counter++)
        {
            if($counter == $page_index)
            {
                echo "<strong>".$page_index."</strong>&nbsp;";
            }
            else
            {
                echo "<a href='".base_url()."search/search_staff_sales_customer_card_no?page_id=" . $counter . $search_params . "'>" . $counter . "</a>&nbsp;";
            }
        ?>
        <?php 
        }
        ?>
    </div>
</div>