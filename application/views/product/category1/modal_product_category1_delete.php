<script type="text/javascript">
    $(function() {
        $('#button_close_modal').on('click', function(){
           $('#modal_product_category1_delete').modal('hide') 
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="modal_product_category1_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
    </div>
  </div>
</div>

<script type="text/javascript">
    $('#modal_button_cancel').on('click', function() {
        $('#modal_delete_row_1').modal('hide');
    });
</script>


