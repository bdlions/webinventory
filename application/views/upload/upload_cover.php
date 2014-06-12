<script src="<?php echo base_url();?>assets/js/image_upload/common.js"></script>
<script src="<?php echo base_url();?>assets/js/image_upload/square.js"></script>
<script type="text/javascript">
    var rotateValue = 0;
    var scaleSize = 1;
			
    var imageStartX = 0;
    var imageStartY = 0;
			
    var dragStartX = 0;
    var dragStartY = 0;
    var selectionObject = null;
			
    var imageCanvas = null;
				
    var canvasContext = null;
    var problemImage = null;
			
    //when a page is loading
    window.onload = function()
    {
	//get the image canvas instance
        imageCanvas = document.getElementById("imageCanvas");
				
				
        //the image that will be edited
        problemImage = new Image();
				
        //when browser support canvas element
        //otherwise we do not need to execute code
        if(imageCanvas.getContext)
        {
            //canvas context
            canvasContext = imageCanvas.getContext('2d');
					
            //set canvas height and width
            imageCanvas.width = 900 ;
            imageCanvas.height = 400 ;
					
            //by default selected object is square
            selectionObject = new Square(canvasContext);
            problemImage.onload = function()
            {
                //set the image start position x and y pos
                imageStartX = imageCanvas.width/2 - problemImage.width / 2;
                imageStartY = imageCanvas.height/2 - problemImage.height / 2;
						
                //canvasdrawing function is called every 10 milli seconds
                setInterval ('canvasDrawing()', 10);
            };
					
            //set the image
					
            problemImage.src = '<?php if(isset($shop_cover_photo)) echo $shop_cover_photo ?>'+"?src=" + new Date().getTime();
					
            //mouse move event
            imageCanvas.onmousemove = mouseMoveEvent;
            //mouse down event
            imageCanvas.onmousedown = mouseDownEvent;
            //mouse up event
            imageCanvas.onmouseup = mouseUpEvent;
					
        }
				
    }
			
			
    function mouseMoveEvent(event)
    {
        if(dragStartX > 0)
        {
            //calculate the new image start positoin
					
            imageStartX -= dragStartX - event.pageX;
            imageStartY -= dragStartY - event.pageY;
					
            //calculate new drag posiont
            dragStartX = event.pageX;
            dragStartY = event.pageY;
					
        }
    }
			
    function mouseDownEvent(event)
    {
        //calulate drag postion when mous is pressed
        dragStartX = event.pageX;
        dragStartY = event.pageY;
    }
			
    function mouseUpEvent(event)
    {
        //when mouse is up then recalculate the drag pos
        dragStartX = 0;
        dragStartY = 0;
    }
			
    function canvasDrawing()
    {
        //clear the whole canvas
        canvasContext.clearRect(0,0, imageCanvas.width, imageCanvas.height);
        //get the default canvas
        canvasContext.save();
        canvasContext.translate(imageCanvas.width/2,imageCanvas.height/2);
        //rotate if needed
        canvasContext.rotate(rotateValue*(Math.PI/180));
        //scale if needed
        canvasContext.scale(scaleSize, scaleSize);
        canvasContext.translate(-imageCanvas.width/2,-imageCanvas.height/2);
        //drawing the images
        canvasContext.drawImage(problemImage, imageStartX, imageStartY, problemImage.width, problemImage.height);
        //canvasContext.translate(-50,-50);
        //restore the canvas
        canvasContext.restore();
				
        //draw the selection object
        selectionObject.draw();
    }
			
					
    function clockWiseRotateImage()
    {
        //increasing the rotate value
        rotateValue += 5;
    }
			
    function antiClockWiseRotateImage()
    {
        //decreasing the rotate value
        rotateValue -= 5;
    }
			
    function zoomInImage()
    {
        //increasing the scale size
        if(scaleSize > 30)
        { 
            scaleSize = scaleSize;
        }
        else 
        {
            scaleSize += .1;
        }
    }
    function zoomOutImage()
    {
        //desreasing the scale size
        if(scaleSize < .15)
        { 
            scaleSize = scaleSize;
        }
        else 
        {
            scaleSize -= .1;
        }
    }		
    
    $(function() {
        $("#button_cover_photo_edit").on("click", function(){
            var url = '<?php echo base_url();?>'+"upload/save_cover_photo";
            var tempCanvas = document.getElementById("savedImage");
            var tempCanvasContext = tempCanvas.getContext('2d');
            var tempCanvasContext = tempCanvasContext;
            if( problemImage.height*scaleSize < 72 || problemImage.width*scaleSize < 459)
            {
                alert('Please upload an image with minimum height 72px and minimum width 460px');
                return false;
            }
            tempCanvasContext.canvas.height = selectionObject.getCroppedImage().height;
            tempCanvasContext.canvas.width = selectionObject.getCroppedImage().width;
            tempCanvasContext.putImageData(selectionObject.getCroppedImage(), 0 ,0);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    image_data: tempCanvasContext.canvas.toDataURL("image/png")
                },
                success: function (data) {
                    if( data == 1)
                    {
                        window.location = '<?php echo base_url()."upload/upload_cover";?>';
                    }
                    else
                    {
                        alert('Server Error while saving profile picture.');
                    }
                }

            });
        });
    });
    
</script>

<h3>Upload a cover photo for your shop...   </h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row" style="margin:0px;">
        <div class="row col-md-offset-1">
            <div id="divImageCanvas" class="row">
                <canvas id="imageCanvas"> 
                    Sorry, your browser doesn't support HTML5.
                </canvas>
            </div>
            <div class="row" style="margin:0px;">
                <div class="col-md-2">
                    <img src="<?php echo base_url() ?>resources/images/clockwiserotate.jpg" onclick="clockWiseRotateImage()"></img> 
                    <img src="<?php echo base_url() ?>resources/images/anticlockwise.jpg" onclick="antiClockWiseRotateImage()"></img>
                </div>
                <div class="col-md-2">
                    <img src="<?php echo base_url() ?>resources/images/zoomin.jpg" onclick="zoomInImage()"></img> 
                    <img src="<?php echo base_url() ?>resources/images/zoomout.jpg" onclick="zoomOutImage()"></img>
                </div>	
            </div>
        </div>
        <div class="row">                
            <?php echo form_open_multipart("upload/upload_cover", array('name' => 'form_upload_logo', 'class' => 'form-horizontal')); ?>
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
                        <?php echo form_input($submit_shop_cover_photo+array('class'=>'form-control btn-success')); ?>
                    </div> 
                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="" class="col-md-6 control-label requiredField">
                        &nbsp;
                    </label>
                    <div class ="col-md-6">
                        <input id="button_cover_photo_edit" name="button_cover_photo_edit" type="button" value="Save" class="form-control btn-success"/>
                    </div> 
                </div>
            </div>
        </div>    
        <canvas id="savedImage" style="visibility: hidden;" >
        </canvas>
    </div>    
</div>