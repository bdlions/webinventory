<div class ="row form-background">
    <div class ="row">
        <div class="col-md-10">
            <div class ="col-md-1">
                Product Name
            </div>
            <div class ="col-md-1">
                Product Size
            </div>
            <div class ="col-md-1">
                Product Weight
            </div>
            <div class ="col-md-1">
                Product Warranty
            </div>
            <div class ="col-md-1">
                Product Quality 
            </div>
            <div class ="col-md-1">
                Brand Name
            </div>
            <div class ="col-md-1">
                Unit Price
            </div>
            <div class ="col-md-1">
                Manage
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        foreach ($product_list as $key => $prodduct_info) {
            ?>
            <div class="row">
                <div class="col-md-10">
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['size'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['weight'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['warranty'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['quality'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['brand_name'] ?>
                    </div>
                    <div class ="col-md-1">
                        <?php echo $prodduct_info['unit_price'] ?>
                    </div>
                    <div class ="col-md-1">
                        <a href="<?php echo base_url("./product/update_product/" . $prodduct_info['id']); ?>">Update</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
