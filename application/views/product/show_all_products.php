<h3>Product List</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Product Name</th>
                    <th>Product Size</th>
                    <th>Product Weight</th>
                    <th>Product Unit</th>
                    <th>Product Warranty</th>
                    <th>Product Quality</th>
                    <th>Brand Name</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($product_list as $key => $product_info) {
                ?>
                    <tr>
                        <td><?php echo $product_info['serial_no'] ?></td>
                        <td><?php echo $product_info['name'] ?></td>                        
                        <td><?php echo $product_info['size'] ?></td>
                        <td><?php echo $product_info['weight'] ?></td>
                        <td><?php echo $product_info['category_unit'] ?></td>
                        <td><?php echo $product_info['warranty'] ?></td>
                        <td><?php echo $product_info['quality'] ?></td>
                        <td><?php echo $product_info['brand_name'] ?></td>
                        <td><a href="<?php echo base_url("./product/update_product/" . $product_info['id']); ?>">Update</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
