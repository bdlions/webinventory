var Common = function(){};

Common.setTransparency = function(canvasContext, transparency)
{
	canvasContext.save();
	canvasContext.fillStyle = "rgba(255, 255, 255," + transparency+" )";
	//canvasContext.globalCompositeOperation = "lighter";
	//canvasContext.globalAlpha = parseInt(transparency);
	canvasContext.rect(0,0, canvasContext.canvas.width, canvasContext.canvas.height);
	canvasContext.fill();
	canvasContext.restore();
}

Common.saveImage = function(croppedImage, savedImageCanvas, imageData, labelImageCanvas)
{
	var tempCanvasContext = savedImageCanvas;
	tempCanvasContext.canvas.height = croppedImage.height;
	tempCanvasContext.canvas.width = croppedImage.width;
	tempCanvasContext.putImageData(croppedImage, 0 ,0);
	var xmlhttp;
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			Common.saveCommentImage(imageData, labelImageCanvas, croppedImage.height);
		}
	}
	xmlhttp.open("POST","uploader.php",true);
	var multipart ="";

	var boundary = Math.random().toString().substr(2);
	var data = tempCanvasContext.canvas.toDataURL("image/png")
	xmlhttp.setRequestHeader("content-type",
			  "multipart/form-data; charset=utf-8; boundary=" + boundary);
	//for(var key in data)
	{
		multipart += "--" + boundary
			   + "\r\nContent-Disposition: form-data; name=data"
			   + "\r\nContent-type: image/jpeg"
			   + "\r\n\r\n" + data + "\r\n";
	}
	multipart += "--"+boundary+"--\r\n";
	xmlhttp.send(multipart);
	
	
	
}

Common.saveCommentImage = function(croppedImage, savedImageCanvas, firstImageHeight)
{

	var modalWindowHeight = firstImageHeight+croppedImage.height+80;
	var tempCanvasContext = savedImageCanvas;
	tempCanvasContext.canvas.height = croppedImage.height;
	tempCanvasContext.canvas.width = croppedImage.width;
	tempCanvasContext.putImageData(croppedImage, 0 ,0);
	var xmlhttp;
	if (window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var uiWidth = modalWindowHeight+"px";
			$.unblockUI();
			var file_name = xmlhttp.responseText;
			var image_file_name = "cropped_image/"+file_name; 
			var comment_file_name = "cropped_image/L"+file_name; 
			
			/*$.blockUI({ message: "<html><body><table style='width:100%; align:center'><tr><td align='center'><img  src='"+image_file_name+"'></img><br/><img  src='"+comment_file_name+"'></img><br/><input style='width:500px' type='text' value='"+location.href+image_file_name+"'></input></td></tr><tr><td align='center'><button id='button_ok' onclick='button_ok_pressed()' type='button'>Ok</button></td></tr></table></body></html>" ,
			theme: false,
			baseZ: 500,
			css:{'width':'550px','height':modalWindowHeight}
			}); */
			
			$("#image_src").attr("src",image_file_name);
			$("#label_src").attr("src",comment_file_name);
			$("#image_src_url").attr("value",location.href+image_file_name);
			$("#label_src_url").attr("value",location.href+comment_file_name);
			$("#savedModalWindow").dialog("open");
			
			
			/*var win = window.open("about:blank");
			self.focus();
			
			
			win.document.open();
			win.document.write("<html><body><table style='width:100%; align:center'><tr><td align='center'><img  src='"+file_name+"'></img><br/><h5>Image path: "+location.href+file_name+"</h5></td></tr></table></body></html>");
			
			win.document.close();*/
			
		}
	}
	xmlhttp.open("POST","uploader_label.php",true);
	var multipart ="";

	var boundary = Math.random().toString().substr(2);
	var data = tempCanvasContext.canvas.toDataURL("image/png")
	xmlhttp.setRequestHeader("content-type",
			  "multipart/form-data; charset=utf-8; boundary=" + boundary);
	//for(var key in data)
	{
		multipart += "--" + boundary
			   + "\r\nContent-Disposition: form-data; name=data"
			   + "\r\nContent-type: image/jpeg"
			   + "\r\n\r\n" + data + "\r\n";
	}
	multipart += "--"+boundary+"--\r\n";
	xmlhttp.send(multipart);
	
	
	
}