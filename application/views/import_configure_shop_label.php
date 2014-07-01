<h3><?php echo $this->lang->line("import_configure_shop_label_header");?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open_multipart("import/configure_shop_label", array('id' => 'form_upload_file', 'class' => 'form-horizontal')); ?>
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
                    <?php echo $this->lang->line("import_configure_shop_label_browse");?>
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
                    <?php echo form_input($submit_upload_file+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>        
               
    </div>
    <?php echo form_close(); ?>
    <div class="row">
    <?php echo form_open("import/download_sample_file", array('id' => 'download_sample_file', 'class' => 'form-horizontal')); ?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="phone" class="col-md-6 control-label requiredField">
                    &nbsp;
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($download_sample_file+array('class'=>'form-control btn-success')); ?>
                </div> 
            </div>
        </div>
    <?php echo form_close(); ?>
    </div>
</div>
