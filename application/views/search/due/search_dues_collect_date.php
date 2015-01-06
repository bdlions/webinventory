<script>
    $(function() {
        $("#start_date_datepicker").datepicker({dateFormat: 'dd-MM-yy'});
        $("#end_date_datepicker").datepicker({dateFormat: 'dd-MM-yy'});
        
    });
</script>
<h3>Search Due Collect by Date Range</h3>
<div class ="form-background top-bottom-padding">
    <div class="row">
        <div class="col-md-6">
            <div class="row form-group">
                <label for="expense_categories" class="col-md-offset-1 col-md-2 control-label requiredField">
                    Start Date
                </label>
                <div class ="col-md-4">
                    <input type="text" class="form-control" placeholder="Date" id="start_date_datepicker">
                </div> 
            </div>
            <div class="row form-group">
                <label for="item_list" class="col-md-offset-1 col-md-2 control-label requiredField">
                    End Date
                </label>
                <div class ="col-md-4">
                    <input type="text" class=" form-control" placeholder="Date" id="end_date_datepicker">
                </div> 
            </div>
            <div class="row form-group">
                <div class="col-md-offset-5 col-md-2">
                    <button type="submit" class="form-control" style="background-color: #5CB85C; color: white;">Search</button>
                </div>
            </div>
        </div>
    </div> 
    
    
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Time & Date</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Card No</th>
                    <th>Amount</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="tbody_product_list">
                <?php
                foreach ($due_collect_list as $due_collect) {
                ?>
                    <tr>
                        <td><?php echo $due_collect['created_on'] ?></td>
                        <td><?php echo $due_collect['first_name'] ?></td>
                        <td><?php echo $due_collect['last_name'] ?></td>  
                        <td><?php echo $due_collect['card_no'] ?></td>    
                        <td><?php echo $due_collect['amount'] ?></td>
                        <td><a role="menuitem" tabindex="-1" href="javascript:void(o)" onclick="open_modal_delete_confirm(<?php echo $due_collect['id'] ?>)">Delete</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view("search/due/search_modal_delete_confirm");