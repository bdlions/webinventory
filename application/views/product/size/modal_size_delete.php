<script type="text/javascript">
  
    $(function() {
        $('#button_close_modal').on('click', function(){
           $('#modal_size_delete').modal('hide') 
        });
    });

</script>

<div class="modal fade" id="modal_size_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Product Size</h4>
            </div>
            <div class="modal-body">
                <div class ="row col-md-offset-1">
                    <div class="row col-md-11">
                        <p>Do you want to delete this product size?</p>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button id="button_size_delete" type="button" class="btn btn-success" data-dismiss="modal">Yes</button>
                <button id="button_close_modal" type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>



