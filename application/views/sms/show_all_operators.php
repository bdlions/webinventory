<div class ="row">
    <div class="form-background col-md-11">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Operator Prefix</th>
                        <th>Operator Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="tbody_product_list">
                    <?php
                    foreach ($operator_list as $key => $operator_info) {
                    ?>
                        <tr>
                            <td><?php echo $operator_info['operator_prefix'] ?></td>
                            <td><?php echo $operator_info['operator_name'] ?></td>
                            <td><?php echo $operator_info['description'] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div> 
</div>