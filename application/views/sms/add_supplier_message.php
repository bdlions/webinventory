<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
window.onload = function()
{
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
}
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var supplier_data = <?php echo json_encode($supplier_list_array) ?>;
        set_supplier_list(supplier_data);
        
        $("#all_supplier_message_form").on("submit", function(){
            $("#editortext").val(jQuery('<div />').text(CKEDITOR.instances.editor1.getData()).html());
            //return false;
        });
    });
</script>

<h3>Add Supplier Message</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open("sms/add_supplier_message", array('id' => 'all_supplier_message_form', 'class' => 'form-horizontal')); ?>
    <div class ="col-md-7 col-md-offset-2">
        <div class ="row">
            <div class="col-md-4"></div>
            <div class="col-md-8"><?php echo $message; ?></div>
        </div>
        
        <div class="form-group">
            <div class ="col-md-offset-3 col-md-8">
               <div class=" input-group search-box">
                   <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                   <div class="twitter-typeahead" style="position: relative;">
                       <input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);">
                       <input type="text" placeholder="Search for supplier" class="form-control tt-query" id="search_box" autocomplete="off" spellcheck="false" style="position: relative; vertical-align: top; background-color: transparent;" dir="auto">
                       <div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;">

                       </div>
                       <div class="tt-dropdown-menu dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">

                       </div>    
                   </div>
               </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="supplier_message" class="col-md-3 control-label requiredField">
                Message
            </label>
            <div class ="col-md-8">
                <?php echo form_textarea($editor1+array('class'=>'form-control')); ?>
            </div> 
        </div>
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

<?php $this->load->view("sms/modal_select_message"); ?>

<script type="text/javascript">
    $(function(){
        $("#search_box").typeahead([
            {
                name:"search_supplier",
                valuekey:"first_name",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_supplier',
                            ttl: 0
                        },
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Supplier</div>',
                template: [
                    '<div class="row"><div class="tt-suggestions col-md-11"><div class="form-horizontal"><span class="glyphicon glyphicon-user col-md-12">{{first_name}} {{last_name}}</span><span class="glyphicon glyphicon-phone col-md-12">{{phone}}</span><span class="glyphicon glyphicon- col-md-12">{{company}}</span></div><div class="tt-suggestions col-md-12" style="border-top: 1px dashed #CCCCCC;margin: 6px 0;"></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
           if(datum.first_name)
            {
                var s_list = get_supplier_list();
                for (var counter = 0; counter < s_list.length; counter++)
                {
                    var sup_info = s_list[counter];
                    if (datum.supplier_id === sup_info['supplier_id'])
                    {
                        update_fields_selected_supplier(sup_info);
                        return;
                    }
                }
            }
        });  
    });
    
    function update_fields_selected_supplier(sup_info)
    {
        $("#input_add_purchase_supplier_id").val(sup_info['supplier_id']);
        $("#input_add_purchase_supplier").val(sup_info['first_name']+' '+sup_info['last_name']);
    }
</script>