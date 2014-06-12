<h3>Delete Expense Confirmation</h3>
<div class="form-background form-horizontal top-bottom-padding">
    <div class="row">
        <?php echo form_open("expense/delete_expense/".$expense_id, array('id' => 'form_delete_expense_confirmation', 'class' => 'form-horizontal')); ?>
        <div class="row" style="margin:0px">
            <div class="col-md-3"></div>
            <div class="col-md-3">Are you sure to delete expense?</div>
        </div>
        <div class="row" style="margin:0px">
            <div class="col-md-3"></div>
            <div class="col-md-1">
                <div class="form-group">
                    <div class ="col-md-12">
                        <?php echo form_input($submit_delete_expense_yes+array('class'=>'form-control btn-success')); ?>
                    </div> 
                </div>  
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <div class ="col-md-12 pull-left">
                        <?php echo form_input($submit_delete_expense_no+array('class'=>'form-control btn-success')); ?>
                    </div> 
                </div>
            </div>
        </div>    
        <?php echo form_close(); ?>
    </div>    
</div>