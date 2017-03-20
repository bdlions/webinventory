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
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel">Confirm Message</h2>
      </div>
      <div class="modal-body">
       Do You want to proceed?
      </div>
      <div class="modal-footer">          
        <button type="button" id ="modal_button_confirm" class="btn btn-primary">Yes</button>
        <button type="button" id ="modal_button_cancel" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $('#product_size_delete_button_1').on('click', function() {
        $('#modal_size_delete').modal('show');
    });
     $('#modal_button_confirm').on('click', function() {
        $('#modal_size_delete').modal('hide');
        $('#product_size_display_row_1').hide();
    });
    $('#modal_button_cancel').on('click', function() {
        $('#modal_size_delete').modal('hide');
    });
</script>

