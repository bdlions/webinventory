<style type="text/css">
  tr.noBorder td {border: 0; }
</style>
<!-- Written by Omar -->
<script type="text/javascript">
    function openModal(val,id) {

        var selected_queue_value = $('#no_of_queue_'+id).val();
        //alert(selected_queue_value);
        var all_data = <?php echo json_encode($all_phone_record); ?>;
        set_phone_list(all_data);
        //console.log(get_phone_list());
        
        //var message = {name:"John", phoneNo:533333450, msg:"bluesdf sf fsd "};
        //var message1 = {name:"Omar", phoneNo:533333777, msg:"Ths is your sf fsd "};
        //var message2 = {name:"John", phoneNo:533333111, msg:"here is my code sf fsd "};
        //var messageList = [message, message1, message2];
        
        var messageList = get_phone_list();
        $("#tbody_list").html(tmpl("tmpl_message_list",  messageList));
        $('#modal_set_message_for_queue').modal('show');
    }
</script>

<script type="text/javascript">
    $(function() {
        $("#set_in_queue").on("click", function() {
            var selected_array = Array();
            var phone_no;
            $("#tbody_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.value.trim());
                        phone_no = this.value;
                    }
                });
            });
            
            //console.log(selected_array);
            var new_temp_phone_list = [];
            var temp_phone_list = get_phone_list();
            //console.log(temp_phone_list);
            for(var i = 0; i< temp_phone_list.length; i++) {
                var temp = temp_phone_list[i].number.trim();
                if(selected_array.indexOf(temp) != -1 ) {
                    //console.log('hy');
                    temp_phone_list.splice(i, 1);
                } else {
                    //console.log(i);
                    //new_temp_phone_list.push({number: temp_phone_list[i].number,});
                }
            }
            
            console.log(temp_phone_list.length);
            //set_phone_list(new_temp_phone_list);
            
            /*
             //console.log(selected_array);
            var new_temp_phone_list = [];
            var temp_phone_list = Array();
            var temp_phone_list = get_phone_list();
            console.log(temp_phone_list);
            for(var i = 0; i< temp_phone_list.length; i++) {
                var temp = temp_phone_list[i].number.trim();
                if(selected_array.indexOf(temp_phone_list[i].number) != -1 ) {
                    //temp_phone_list.splice(i, 1);
                    console.log('hy');
                    
                } else {
                    new_temp_phone_list.push({
                        number: temp_phone_list[i].number,
                    });
                }
            }
            //console.log(new_temp_phone_list);
            //set_phone_list(new_temp_phone_list);
             */
            
            
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
                            <tr>
                                <td class="noBorder">Global Message: </td>
                                <td class="noBorder">
                                    <textarea type="text" name="msg_for_queue" id="msg_for_queue" value="">
                                    </textarea>
                                </td>
                            </tr>
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