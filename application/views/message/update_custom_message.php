<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>

<h3>Edit Custom Message</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-7 col-md-offset-2">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8" style="color:red;"><?php echo $message; ?></div>
            </div>
            <div class ="row">
                <div class="col-md-12"></div>
            </div>
            <div class ="row">
                <div class="col-md-12"></div>
            </div>

            <div class="form-group">
                <div class ="col-md-offset-3 col-md-8">
                   <div class=" input-group search-box">
                       <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                       <div class="twitter-typeahead" style="position: relative;">
                           <input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                           <input type="text" placeholder="Search for message" class="form-control tt-query" id="search_box" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
                           <div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;">

                           </div>
                           <div class="tt-dropdown-menu dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">

                           </div>    
                       </div>
                   </div>
                </div>
            </div>

            <!--<div class="form-group" >
                <label for="input_add_purchase_supplier" class="col-md-3 control-label requiredField">
                    Supplier Name
                </label> 
                <div class ="col-md-8">
                    <?php //echo form_input($supplier_id+array('name' => 'input_add_purchase_supplier_id', 'id' => 'input_add_purchase_supplier_id', 'class' => 'form-control', 'type' => 'hidden' )); ?>
                    <?php //echo form_input($name+array('name' => 'input_add_purchase_supplier', 'id' => 'input_add_purchase_supplier', 'class' => 'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_select_supplier')); ?>
                </div> 
            </div>-->
            <?php echo form_open("message/update_custom_message", array('id' => 'form_edit_message_1', 'name' => 'form_edit_message_1',  'class' => 'form-horizontal', 'onsubmit=return false')); ?>
            <div class="form-group">
                <label for="custom_message" class="col-md-3 control-label requiredField">
                    Message
                </label>
                <div class ="col-md-8">
                    <?php echo form_textarea($editor1+array('class'=>'form-control')); ?>
                </div> 
            </div>
            <input type="hidden" name="editortext" id="editortext"></input>
            <input type="hidden" name="message_id" id="message_id" value="<?php echo isset($sup_info)?$sup_info['id']:'';?>"></input>
            <div class="form-group">
                <div class ="col-md-offset-3 col-md-2">
                    <?php echo form_input($submit_update_message+array('class'=>'form-control btn-success','id'=>'submit_update_message','style'=>'display:none')); ?>
                </div>
                <div class ="col-md-offset-4 col-md-2">
                    <?php echo form_input($submit_create_message+array('class'=>'form-control btn-success','id'=>'submit_create_message')); ?>
                </div> 
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("#form_edit_message_1").on("submit", function(){
            var temp = CKEDITOR.instances.editor1.getData();
            $("#editortext").val(jQuery('<div />').text(temp).html());
            
        });
        
        CKEDITOR.replace('editor1', {
        toolbar: [
            { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', '-', 'Templates' ] },
            { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },

            { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
            '/',
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
            { name: 'forms', items: ['ImageButton'] },
        ],
            toolbarGroups: [
                    { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                    { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
            { name: 'links' },
            { name: 'colors' },
                    '/',																// Line break - next group will be placed in new line.
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'styles' },
            '/',
            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'forms' },
            ]
            }
        );

        $("#search_box").typeahead([
                {
                    name:"search_supplier",
                    valuekey:"first_name",
                    // with the prefatch in IE browser does not work so we use local
                    local:<?php echo $custom_messages;?>,
                    /*prefetch:{
                                url: '<?php echo base_url()?>message/get_custom_message',
                                ttl: 0
                            },*/
                    header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier Message</div>',
                    template: [
                        '<div class="row"><div class="tt-suggestions col-md-11 col-md-offset-1"><div class="form-horizontal"><span class="glyphicon glyphicon-envelope">{{value}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div></div>'
                      ].join(''),
                    engine: Hogan,
                }
        ]).on('typeahead:selected', function (obj, datum) {
            if(datum.value)
             {
                 update_fields_selected_message(datum);
             }
             $('#submit_update_message').show();
             $('#submit_create_message').hide();
         });  

    });
    function update_fields_selected_message(sup_info)
    {
        CKEDITOR.instances.editor1.setData(sup_info['message']);
        $('#editortext').val(sup_info['message']);
        $('#message_id').val(sup_info['id']);
    }
</script>
