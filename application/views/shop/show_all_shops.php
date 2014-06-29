<h3><?php echo $this->lang->line("shop_shop_list_header"); ?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line("shop_shop_list_shop_no"); ?></th>
                    <th><?php echo $this->lang->line("shop_shop_list_shop_name"); ?></th>
                    <th><?php echo $this->lang->line("shop_shop_list_shop_phone"); ?></th>
                    <th><?php echo $this->lang->line("shop_shop_list_shop_address"); ?></th>
                    <th><?php echo $this->lang->line("shop_shop_list_shop_type"); ?></th>
                    <th><?php echo $this->lang->line("shop_shop_list_shop_manage"); ?></th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($shop_list as $key => $shop_info) {
                ?>
                    <tr>
                        <td><?php echo $shop_info['shop_no'] ?></td>
                        <td><?php echo $shop_info['name'] ?></td>
                        <td><?php echo $shop_info['shop_phone'] ?></td>
                        <td><?php echo $shop_info['address'] ?></td>
                        <td><?php echo $shop_info['shop_type'] ?></td>
                        <td><a href="<?php echo base_url("./shop/update_shop/".$shop_info['id']);?>"><?php echo $this->lang->line("shop_shop_list_shop_update"); ?>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>