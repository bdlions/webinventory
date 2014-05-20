<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    
    $(function(){
        
        $("#custom_message_form").on("submit", function(){
            //alert($("#editortext").val(jQuery('<div />').text(CKEDITOR.instances.editor1.getData()).html()));
            $("#editortext").val(jQuery('<div />').text(CKEDITOR.instances.editor1.getData()).html());
            //return false;
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
    
    });  
</script>

<h3>Add Custom Message</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open("message/create_custom_message", array('id' => 'custom_message_form', 'class' => 'form-horizontal')); ?>
    <div class ="col-md-7 col-md-offset-2">
        <div class ="row">
            <div class="col-md-4"></div>
            <div class="col-md-8"><?php echo $message; ?></div>
        </div>

        <div class="form-group">
            <label for="supplier_message" class="col-md-3 control-label requiredField">
                Message
            </label>
            <div class ="col-md-8">
                <?php echo form_textarea($editor1+array('class'=>'form-control')); ?>
            </div> 
        </div>
        <input type="hidden" name="editortext" id="editortext"></input>
        <div class="form-group">
            <label for="address" class="col-md-3 control-label requiredField">

            </label>
            <div class ="col-md-offset-6 col-md-2">
                <?php echo form_input($submit_create_message+array('class'=>'form-control btn-success')); ?>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
