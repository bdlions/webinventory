<div class ="row form-group">
    <div class="col-md-4"></div>
    <div class="col-md-8"><?php echo $message; ?></div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Product Sub Lot No</h3>
    </div>
    <div class="col-md-6">
        <a href="<?php echo base_url()?>product/create_product_category1">
            <button type="button" class="btn btn-success" style="margin: 10px 0; float: right;">Create New Sub Lot No</button>
        </a>
    </div>
</div>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Sub Lot No</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody >
                <?php
                foreach ($product_category1_list as $product_category1_info) {
                ?>
                <tr id="product_size_display_row_1">
                    <th><?php echo $product_category1_info['product_category1_id'] ?></th>
                    <th><?php echo $product_category1_info['title'] ?></th>
                    <td><a href="<?php echo base_url()."product/update_product_category1/".$product_category1_info['product_category1_id']; ?>">Update</a></td>
                    <td><a onclick="modal_delete_confirm_product_category1(<?php echo $product_category1_info['product_category1_id']; ?>)">Delete</a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php 
$this->load->view("product/category1/modal_confirm_delete_category1");
