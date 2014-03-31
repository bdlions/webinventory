<h3>Supplier List</h3>
<div class ="row form-background top-bottom-padding">
    <div class="table-responsive">
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
            <tbody id="tbody_product_list">
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