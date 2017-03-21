<script type="text/javascript">
    $(function() {
        $("#button_delete").on("click", function() {
            //alert('gfdhfh');
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "product/delete_product_category1",
                data: {
                       id: $("#id").val()
                },
                success: function(data) {
                    $("#modal_delete_confirm_product_category1").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function modal_delete_confirm_product_category1(id) {
        $('#id').val(id);
        $("#modal_delete_confirm_product_category1").modal('show');
    }
</script>
<div class="modal fade" id="modal_delete_confirm_product_category1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Sub Lot No</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-10 control-label">Are you sure to delete this Sub Lot No?</label>
                        <input id="id" name="id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" id="button_delete" name="button_delete" value="" class="form-control btn btn-success pull-right">Delete</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->