<script type="text/javascript">
    $(function() {
        $("#button_active").on("click", function() {
            var id_array = [];
            $.each(searched_customer_list, function (index, value ){
                id_array.push(value.id);
            });
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/update_users",
                data: {
                    id_array: JSON.stringify(id_array),
                    status: '1'
                },
                success: function(data) {
                    alert(data['message']);
                    $("#admin_status_confirm_modal").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_active_confirm() {
        $("#admin_status_confirm_modal").modal('show');
    }
</script>
<div class="modal fade" id="admin_status_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">User Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-10 control-label">Are you sure to Active all user ?</label>
                        <input id="input_user_id" name="input_user_id" value="" type="hidden" class="form-control"/>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <div class ="col-md-6">
                    
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" id="button_active" name="button_delete" value="" class="form-control btn btn-success">Active</button>
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->