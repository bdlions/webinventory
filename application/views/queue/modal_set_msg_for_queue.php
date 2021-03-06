<style type="text/css">
  tr.noBorder td {border: 0; }
</style>
<!-- Written by Omar -->
<script type="text/javascript">
    function openModal(val,id) {
        current_modal_id = id;
        var selected_queue_value = $('#no_of_queue_'+id).val();
        no_of_msg_in_current_queue = selected_queue_value;
        phone_list_under_queue = get_phone_list();
        
        //console.log(get_phone_list());
        //var message = {name:"John", phoneNo:533333450, msg:"bluesdf sf fsd "};
        //var message1 = {name:"Omar", phoneNo:533333777, msg:"Ths is your sf fsd "};
        //var message2 = {name:"John", phoneNo:533333111, msg:"here is my code sf fsd "};
        //var messageList = [message, message1, message2];
              
        $('#modal_message').html('');
        $("#tbody_list").html(tmpl("tmpl_message_list",  phone_list_under_queue));
        $('#modal_set_message_for_queue').modal('show');
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#set_in_queue").on("click", function() {
            var selected_array = Array();
            var counter = 0;
            $("#tbody_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.value.trim());
                        counter ++;
                    }
                });
            });
            
            //console.log(temp_phone_list);
            if(parseInt(counter) === parseInt(no_of_msg_in_current_queue) && ( parseInt(counter)!==0 && parseInt(no_of_msg_in_current_queue)!==0 ) ) {
               newArr = [];
               insetArr = [];
                var temp_phone_list = get_phone_list();
                //console.log(temp_phone_list);
                for(var i = 0; i< temp_phone_list.length; i++) {
                    var temp = temp_phone_list[i].number.trim();
                    if(selected_array.indexOf(temp) == -1 ) {
                         newArr.push(temp_phone_list[i]);
                    }else {
                        insetArr.push(temp_phone_list[i]);
                    }
                }
                var msg_for_queue = $('#msg_for_queue').val();
                var global_msg = $('#global_message').val();
                if((msg_for_queue !== '') || (global_msg !== '')) {
                    var msg = (msg_for_queue !== '')? msg_for_queue : global_msg;
                    $.ajax({
                        dataType: 'json',
                        type: "POST",
                        url: '<?php echo base_url(); ?>' + "queue/create_queue",
                        data: {
                            uploaded_phone_list_id: $('#uploaded_phone_list_id').val(),
                            queue_name: $('#queue_name_'+current_modal_id).val(),
                            unprocess_phone_list : insetArr,
                            msg_for_queue: msg
                        },
                        success: function(data) {
                            alert(data['message']);
                            if (data['status'] === 1)
                            {
                                //location.reload();
                                $('#total_no').text(update_inserted_sum);
                                set_phone_list(newArr);
                                phone_list_under_queue = get_phone_list(newArr);
                                $('#modal_message').html('');
                                $('#set_msg_for_q_'+current_modal_id).hide();
                                $('#modal_set_message_for_queue').modal('hide');
                            }
                        }
                    });
                } else {
                    $('#modal_message').html('Please type a message for your queue').css({ 'color': 'red', 'font-size': '100%' });
                } 
                
            } else {
                $('#modal_message').html('You can select only '+ no_of_msg_in_current_queue + ' number of message for this queue.').css({ 'color': 'red', 'font-size': '100%' });
            }
        });
    });
</script>
<div class="modal fade" id="modal_set_message_for_queue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Set Message</h4>
            </div>
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8" id="modal_message"></div>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check</th>
                                    <th>Phone No</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_list">
                               <script type="text/x-tmpl" id="tmpl_message_list">
                                    {% var i=0, messageInfo = ((o instanceof Array) ? o[i++] : o); %}
                                    {% while(messageInfo){ %}
                                    <tr>
                                        <td><input type="checkbox" name="phone_no_{%= i%}" id="phone_no_{%= i%}" value="{%=messageInfo.number%}"></td>
                                        <td><input readonly="true" type="text" name="phone_no_{%= i%}" id="phone_no_{%= i%}" onkeydown = "validateNumberAllowDecimal(event, false)" value="{%=messageInfo.number%}"></td>
                                    </tr>
                                    {% messageInfo = ((o instanceof Array) ? o[i++] : null); %}
                                    {% } %}
                             </script>
                            </tbody>
                            <?php if($global_message == ''): ?>
                                <tr>
                                    <td class="noBorder">Global Message for this queue: </td>
                                    <td class="noBorder">
                                        <textarea type="text" name="msg_for_queue" id="msg_for_queue" value=""></textarea>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="set_in_queue" name="set_in_queue" value="" class=" btn btn-success">Set Message</button>
                <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->