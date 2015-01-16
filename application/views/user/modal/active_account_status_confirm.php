<script type="text/javascript">
$(function() {
    $("#button_active").on("click", function() {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url()."user/active_user_account_status";?>',
            data: {
                user_id: $("#input_user_id").val()
            },
            success: function(data) {
                alert(data['message']);
                $("#modal_active_account_status_confirm").modal('hide');
                window.location.reload();
            }
        });
    });
});
function open_modal_active_account_status_confirm(user_id) {
    $('#input_user_id').val(user_id);
    $("#modal_active_account_status_confirm").modal('show');
}
</script>
<div class="modal fade" id="modal_active_account_status_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Inactive User</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-10 control-label">Are you sure to active account status?</label>
                        <input id="input_user_id" name="input_user_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                </div>
                <div class ="col-md-3">
                    <button style="width:100%; background-color: #5CB85C; color: white;" id="button_active" name="button_active" value="" class="form-control btn button-custom pull-right">Active</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%; background-color: #5CB85C; color: white;" type="button" class="btn button-custom" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->