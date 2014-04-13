<h3>Upload a cover photo for your shop...   </h3>
<div class ="row form-horizontal form-background top-bottom-padding">
    <?php echo form_open_multipart("upload/upload_cover", array('name' => 'form_upload_logo', 'class' => 'form-horizontal')); ?>
    <div class="row">                
        <div class="col-md-3">
            <div class="form-group">
                <label for="file" class="col-md-6 control-label requiredField">
                    Browse Photo
                </label>
                <div class ="col-md-6">
                    <input class="form-control" type="file" name="userfile"/>
                </div> 
            </div>
        </div>        
        <div class="col-md-3">
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    &nbsp;
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($submit_upload_cover+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div> 
    </div>
    <?php echo form_close(); ?>
</div>