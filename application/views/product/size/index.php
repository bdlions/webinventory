<div class ="row form-group">
    <div class="col-md-4"></div>
    <div class="col-md-8"><?php echo $message; ?></div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Product Size</h3>
    </div>
    <div class="col-md-6">
        <a href="<?php echo base_url()?>product/create_product_size">
            <button type="button" class="btn btn-success" style="margin: 10px 0; float: right;">Create New Size</button>
        </a>
    </div>
</div>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Size</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody >
                <?php
                foreach ($product_size_list as $product_size_info) {
                ?>
                <tr id="product_size_display_row_1">
                    <th><?php echo $product_size_info['product_size_id'] ?></th>
                    <th><?php echo $product_size_info['title'] ?></th>
                    <td><a href="<?php echo base_url()."product/update_product_size/".$product_size_info['product_size_id']; ?>">Update</a></td>
                    <td><a onclick="modal_delete_confirm_product_size(<?php echo $product_size_info['product_size_id']; ?>)">Delete</a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
$this->load->view("product/size/modal_confirm_delete_size");
