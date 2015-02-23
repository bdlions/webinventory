<style type="text/css">
    .modal-dialog-center {
        margin-top: 25%;
    }
</style>
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>resources/css/spinner/spinner.css'/>
<div class="modal fade" id="pleaseWaitDialog" tabindex="-1" role="dialog" aria-labelledby="pleaseWaitDialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-body loader" style="height: 80px;">
                <div class="col-md-offset-5 col-md-2">
                    <span class="spinner">Loading.....</span>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script type="text/javascript">
    var waitScreen;
        waitScreen = waitScreen || (function () {
        var pleaseWaitDiv = $('#pleaseWaitDialog');
        return {
            show: function() {
                pleaseWaitDiv.modal({backdrop: 'static', keyboard:false});
            },
            hide: function () {
                pleaseWaitDiv.modal('hide');
            },

        };
    })();
</script>