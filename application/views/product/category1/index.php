<div class="row">
    <div class="col-md-6">
        <h3>Product Sub Lot No</h3>
    </div>
    <div class="col-md-6">
        <a href="<?php echo base_url()?>product/create_product_category1">
            <button type="button" class="btn btn-success" style="margin: 10px 0; float: right;">Create Sub Lot No</button>
        </a>
    </div>
</div>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Product Sub Lot No</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody id="">
                <tr>
                    <th>1</th>
                    <th>1</th>
                    <td><a href="<?php echo base_url(); ?>product/update_product_category1">Update</a></td>
                    <td><a id="size_delete_button" >Delete</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $('#size_delete_button').on('click', function() {
        $('#modal_product_category1_delete').modal('show');
    });
</script>
<?php $this->load->view("product/category1/modal_product_category1_delete"); ?>

