<h3>Update Product Size</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row form-group">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="product_size" class="col-md-6 control-label requiredField">
                    Product Size
                </label>
                <div class ="col-md-6">
                    <select name="product_size" id="product_size" class="form-control">
                        <option value="lg">lg</option>
                        <option value="xl">xl</option>
                        <option value="sm">sm</option>
                    </select>
                </div> 
            </div>
            <div class="form-group">
                <label for="address" class="col-md-6 control-label requiredField"></label>
                <div class ="col-md-3 col-md-offset-3">
                    <button class="form-control btn-success">Update</button>
                </div> 
            </div>
        </div>
    </div>
</div>
