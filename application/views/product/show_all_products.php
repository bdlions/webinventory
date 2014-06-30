
<h3><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_list"); ?></h3>

<div class ="form-horizontal form-background top-bottom-padding">
    <div class="" style="color: red; text-align: center;"><?php print_r($this->session->flashdata('message'));?></div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_name"); ?></th>
                    <th> <?php echo $this->lang->line("manage_stock_create_product_unit_category_product_size"); ?></th>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_weight"); ?></th>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_unit"); ?></th>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_Warranty"); ?></th>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_quality"); ?></th>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_brand_name"); ?></th>
                    <th><?php echo $this->lang->line("manage_stock_create_product_unit_category_product_manage"); ?></th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($product_list as $key => $product_info) {
                ?>
                    <tr>
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
