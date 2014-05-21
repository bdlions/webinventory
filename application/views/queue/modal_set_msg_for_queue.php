<!-- Written by Omar -->
<script type="text/javascript">
    function openModal(val,id) {
        var message = {name:"John", phoneNo:533333450, msg:"bluesdf sf fsd "};
        var messageList = [message, message, message];
        $("#tbody_list").html(tmpl("tmpl_message_list",  messageList));
        $('#modal_set_message_for_queue').modal('show');
    }
</script>

<div class="modal fade" id="modal_set_message_for_queue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Set Message</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_list">
                               <script type="text/x-tmpl" id="tmpl_message_list">
                                    {% var i=0, messageInfo = ((o instanceof Array) ? o[i++] : o); %}
                                    {% while(messageInfo){ %}
                                    <tr>
                                        <td><input type="text" name="name_of_customer_{%= i%}" id="name_of_customer_{%= i%}" value="{%=messageInfo.name%}"></td>
                                        <td><input type="text" name="phone_no_{%= i%}" id="phone_no_{%= i%}" onkeydown = "validateNumberAllowDecimal(event, false)" value="{%=messageInfo.phoneNo%}"></td>
                                        <td><textarea type="text" name="msg_{%= i%}" id="msg_{%= i%}" value="{%=messageInfo.msg%}"></textarea></td>
                                    </tr>
                                    {% messageInfo = ((o instanceof Array) ? o[i++] : null); %}
                                    {% } %}
                             </script> 
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="" name="" value="" class=" btn btn-success">Set Message</button>
                <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
