<h3>Process File</h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open_multipart("queue/index", array('id' => 'form_upload_file', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class="form-group">
            <label for="" class="col-md-1">
                
            </label>
            <div class ="col-md-10">
                <?php echo form_textarea($textarea_details+array('class'=>'form-control')); ?>
            </div> 
        </div>
    </div>
    <div class="row">                
        <div class="col-md-3">
            <div class="form-group">
                <label for="file" class="col-md-6 control-label requiredField">
                    Browse
                </label>
                <div class ="col-md-6 hidden_upload_area">
                    <input id="browse_your_file" class="form-control" type="file" name="userfile"/>
                </div>
                <button onclick="sentIDvalue('browse_your_file');" title="Attach files." id="file1" class="btn btn-default dropdown-toggle" type="button">
                    <span class="glyphicon glyphicon-paperclip"></span>
                </button>
                <span class="" id ="show_file_name" style="display:none;"></span>
            </div>
            
        </div>        
        <div class="col-md-3">
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    &nbsp;
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($submit_upload_file+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>        
        <div class="col-md-5">
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    &nbsp;
                </label>
                <div class ="col-md-offset-2 col-md-4">
                    <?php echo form_input($submit_process_file+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>        
    </div>
    <?php echo form_close(); ?>
</div>

<style>
    .hidden_upload_area {
    height: 0;
    overflow: hidden;
    visibility: hidden;
    width: 0;
}
</style>

<script type="text/javascript">
//FUNCTION FOR SELECT THE INPUT TYPE FILE FIELD
function sentIDvalue(id_name)
{
    $('#'+id_name).click();
}

document.getElementById('browse_your_file').onchange = function () {
//alert('Selected file: ' + this.value);
 $('#show_file_name').show().html(this.value);
};

</script>