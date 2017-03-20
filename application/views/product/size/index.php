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
                    <th>Product Size</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>
            </thead>
            <tbody >
                <tr id="product_size_display_row_1">
                    <th>1</th>
                    <th>sm</th>
                    <td><a href="<?php echo base_url(); ?>product/update_product_size">Update</a></td>
                    <td><a id="product_size_delete_button_1" >Delete</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_size_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal_background_color">
            <div class="modal-header">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="text-align: center; font-size: 20px;">
                <div class="row">
                    <div class="col-md-12">
                          Do you want to proceed?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-offset-8 col-md-2">
                        <input id="modal_ok_click_id" type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true" value="Yes">
                    </div>
                    <div class="col-md-2">
                        <input id="modal_no_click_id" type="button" class="btn btn-success" data-dismiss="modal" aria-hidden="true" value="No">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#modal_no_click_id').on('click', function() {
        $('#modal_size_delete').modal('hide');
    });
    $('#product_size_delete_button_1').on('click', function() {
        $('#modal_size_delete').modal('show');
    });
     $('#modal_ok_click_id').on('click', function() {
        $('#modal_size_delete').modal('hide');
        $('#product_size_display_row_1').hide();
    });
</script>

