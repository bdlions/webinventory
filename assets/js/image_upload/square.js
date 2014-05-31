function Square(context)
{
	var canvasContext = context;
	
	var xPos ;
	var yPos ;
	var height = 72;
        var width = 459;
	var cropImage ;
	
	Square.prototype.draw = function()
	{
		//this is a square so height and width are same
		//var width = height;
		xPos = canvasContext.canvas.width / 2 - width / 2;
		yPos = canvasContext.canvas.height / 2 - height / 2;
		
		canvasContext.save();
		var imageData = canvasContext.getImageData(xPos,yPos, width, height);
		canvasContext.beginPath();
		canvasContext.rect(xPos,yPos, width, height);
		context.strokeStyle = "#000000";
		canvasContext.lineWidth = 2;
		canvasContext.closePath();
		context.stroke();
		
		cropImage = imageData;
		
		Common.setTransparency(canvasContext, "0.5");
		
		canvasContext.putImageData(imageData, xPos, yPos);
		canvasContext.restore();
		
		
	}
	
	Square.prototype.setSize = function(h)
	{
		height = h;
	}
	
	Square.prototype.getCroppedImage = function()
	{
		return cropImage;
	}
}