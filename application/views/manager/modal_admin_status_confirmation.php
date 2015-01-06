<script type="text/javascript">
    $(function() {
        $("#button_inactive").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "",
                data: {
                    client_id: $("#input_user_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#admin_status_confirm_modal").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_admin_status_confirm(user_id) {
        $('#input_user_id').val(user_id);
        $("#admin_status_confirm_modal").modal('show');
    }
</script>
<div class="modal fade" id="admin_status_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Admin Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-10 control-label">Are you sure to inactive this admin ?</label>
                        <input id="input_user_id" name="input_user_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" id="button_inactive" name="button_delete" value="" class="form-control btn btn-success">Inactive</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->