<script type="text/javascript">
var timerID = null;
var timerRunning = false;
 
  
//--Reset the clock before its starts   
function stoptimer()
{      
   if(timerRunning)
   {     
       clearTimeout(timerID);
       timerRunning = false;
    }
}
 
 
       //--Clear the timerId value to reset the clock.
//--Start the timer and display the Date and time
function showtime()
{
    //--Retrieve Current Date and Time
        var now = new Date();
   
    //--Retrieve Hours from Current Date and Time object
        var hours = now.getHours();
   
     //--Retrieve Minutes from Current Date and Time object
        var minutes = now.getMinutes();
   
     //--Retrieve Seconds from Current Date and Time object
        var seconds = now.getSeconds();
   
    //--Retrive current Date from Current Date and Time object
        var date = now.getDate();
   
     //--Retrieve current Date from Current Date and Time object
        var month = now.getMonth();
       var month=(month+1);
   
    //--Retrieve current Date from Current Date and Time object
        var year = now.getFullYear();
   
    //--Append the date,month and year value as digital numbers
       var dateValue = ((month < 10) ? "0" : "") + month ;
    dateValue += ((date < 10) ? "/0" : "/") + date;
    dateValue += "/" + year;
    //--Append the hours,minutes and seconds value as digital numbers
        var timeValue = ((hours < 10) ? "0" : "") + hours ;
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds ;
 
 
   
    //--Append the current date and time
    dateValue += " " + timeValue ;
   
    //--Display the value in a button control
    //document.form.btnDisplay.value = dateValue;
    $("#time_display").html(dateValue);
   
    //--Set timer to display time at each interval of time.
    timerID = setTimeout("showtime()",1000);
   
    //--Set the timerrunning is true
    timerRunning = true;
}
 
 
//--Function call for start timer and display the Output
function startclock()
{
    stoptimer();
    showtime();
}

</script>


<script type="text/javascript">
    $(function(){
        startclock();
        $( "#product_list" ).change(function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "search/get_daily_sales",
                data: {
                    product_id: $("#product_list").val()
                },
                success: function(data) {
                    $("#tbody_daily_sale_list").html(tmpl("tmpl_daily_sale_list", data['sale_list'])); 
                    $("#label_total_product_sold").html(data['total_product_sold']+" pieces");
                    if(data['total_profit'])
                    {
                        $("#label_total_profit").html(data['total_profit']);
                    }                    
                    $("#label_total_sale_price").html(data['total_sale_price']);
                }
            });
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_daily_sale_list">
    {% var i=0, sale_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sale_info){ %}
    <tr>
        <td >{%= sale_info.created_on%}</td>
        <td >{%= sale_info.purchase_order_no%}</td>
        <td >{%= sale_info.product_name%}</td>
        <td >{%= sale_info.total_sale%}</td>
        <td >{%= sale_info.sale_unit_price%}</td>
        <td >{%= sale_info.total_sale*sale_info.sale_unit_price %}</td>        
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
            {                                    
                echo '<td>';
                echo '{%= (sale_info.sale_unit_price-sale_info.purchase_unit_price)*sale_info.quantity %}'; 
                echo '</td>';
            }        
        ?>
        <td >{%= sale_info.salesman_first_name%} {%=sale_info.salesman_last_name %}</td>
        <td >{%= sale_info.card_no%}</td>
        <td ><?php echo '<a href="'.base_url().'payment/show_customer_transactions/{%= sale_info.customer_id%}">Show</a>';?></td>
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
            {                                    
                echo '<td>';
                echo '<a href="'.base_url().'sale/return_sale_order/{%= sale_info.sale_order_no%}">Return</a>'; 
                echo '</td>';
            }        
        ?>
        <?php 
            if($this->session->userdata('user_type') != SALESMAN)
            {                                    
                echo '<td>';
                echo '<a href="'.base_url().'sale/delete_sale/{%= sale_info.sale_order_no%}">Delete</a>'; 
                echo '</td>';
            }        
        ?>
    </tr>
    {% sale_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="row">
    <div class="col-md-4">
        <h3>Daily Sale Page</h3>
    </div>
    <div class="col-md-2 pull-right">
        <div id="time_display"></div>
    </div>
</div>

<div class ="row form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <label for="product_list" class="col-md-6 control-label requiredField">
                            Select Product
                        </label>
                        <div class ="col-md-6">
                            <?php echo form_dropdown('product_list', $product_list+array('0' => 'All'), '0','class="form-control" id="product_list"'); ?>
                        </div> 
                    </td> 
                    <td>
                        <label class="col-md-8 control-label requiredField">
                            Total Expense : 
                        </label>
                        <label id="label_total_expense" class="col-md-4 control-label requiredField">
                            <?php echo $total_expense;?>
                        </label>
                    </td>
                    <td>                        
                        <label class="col-md-8 control-label requiredField">
                            Total Due Collect <a href="<?php echo base_url().'payment/show_due_collect'?>">View</a> : 
                        </label>
                        <label id="label_total_due_collect" class="col-md-4 control-label requiredField">
                            <?php echo $total_due_collect;?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Product Sold : 
                        </label>
                        <label id="label_total_product_sold" class="col-md-6 control-label requiredField">
                            <?php echo $total_product_sold;?> pieces 
                        </label>                        
                    </td>
                    <td>
                        <label class="col-md-8 control-label requiredField">
                            Total Due <a href="<?php echo base_url().'payment/show_total_due'?>">View</a> : 
                        </label>
                        <label id="label_total_due" class="col-md-4 control-label requiredField">
                            <?php echo $total_due;?>
                        </label>
                    </td>
                    <td>
                        <label class="col-md-8 control-label requiredField">
                            Suppliers total returned balance <a href="<?php echo base_url().'payment/show_suppliers_returned_payment_list'?>">View</a> : 
                        </label>
                        <label id="label_total_due_collect" class="col-md-4 control-label requiredField">
                            <?php echo $suppliers_total_returned_payment_today;?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            Total Sale Price : 
                        </label>
                        <label id="label_total_sale_price" class="col-md-6 control-label requiredField">
                            <?php echo $total_sale_price;?> 
                        </label>
                    </td>
                    <td>
                        <label class="col-md-8 control-label requiredField">
                            Customers total returned balance <a href="<?php echo base_url().'payment/show_customers_returned_payment_list'?>">View</a> : 
                        </label>
                        <label id="label_total_due_collect" class="col-md-4 control-label requiredField">
                            <?php echo $customers_total_returned_payment_today;?>
                        </label>
                    </td>
                    <td>
                        <label class="col-md-8 control-label requiredField">
                            Previous Balance : 
                        </label>
                        <label id="label_previous_balance" class="col-md-4 control-label requiredField">
                            <?php echo $previous_balance?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="col-md-6 control-label requiredField">
                            <?php 
                                if($this->session->userdata('user_type') != SALESMAN)
                                {                                    
                                    echo 'Total Profit : ';
                                }
                            ?>
                            
                        </label>
                        <label id="label_total_profit" class="col-md-6 control-label requiredField">
                            <?php 
                                if($this->session->userdata('user_type') != SALESMAN)
                                {                                    
                                    echo $total_profit;
                                }
                            ?>
                        </label> 
                    </td>
                    <td>
                                              
                    </td>
                    <td>
                        <label class="col-md-8 control-label requiredField">
                            Total Net Balance : 
                        </label>
                        <label id="label_total_net_balance" class="col-md-4 control-label requiredField">
                            <?php echo $current_balance?>
                        </label>
                    </td>
                </tr>
            </tbody>  
        </table>
    </div>     
</div>
<h3>Search Result</h3>
<div class="row form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Lot No</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Sale Unit Price</th>
                    <th>Sub Total</th>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>Profit</th>';
                        }                            
                    ?> 
                    <th>Sale by Staff</th>
                    <th>Card No</th>
                    <th>Transactions</th>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>Return</th>';
                        }                            
                    ?>
                    <?php 
                        if($this->session->userdata('user_type') != SALESMAN)
                        {                                    
                            echo '<th>Delete</th>';
                        }                            
                    ?>
                </tr>
            </thead>
            <tbody id="tbody_daily_sale_list">                
                <?php foreach($sale_list as $sale_info) { ?>
                    <tr>
                        <td><?php echo $sale_info['created_on'];?></td>
                        <td><?php echo $sale_info['purchase_order_no'];?></td>
                        <td><?php echo $sale_info['product_name'];?></td>
                        <td><?php echo $sale_info['total_sale'];?></td>
                        <td><?php echo $sale_info['sale_unit_price'];?></td>
                        <td><?php echo $sale_info['total_sale']*$sale_info['sale_unit_price'];?></td>
                        <?php 
                            if($this->session->userdata('user_type') != SALESMAN)
                            {                                    
                                echo '<td>';
                                echo ($sale_info['sale_unit_price'] - $sale_info['purchase_unit_price'])*$sale_info['total_sale'];
                                echo '</td>';
                            }                            
                        ?>
                        <td><?php echo $sale_info['salesman_first_name'].' '.$sale_info['salesman_last_name'];?></td>
                        <td><?php echo $sale_info['card_no'];?></td>
                        <td><?php echo '<a href="'.base_url().'payment/show_customer_transactions/'.$sale_info['customer_id'].'">Show</a>'?></td> 
                        <?php 
                            if($this->session->userdata('user_type') != SALESMAN)
                            {                                    
                                echo '<td>';
                                echo '<a href="'.base_url().'sale/return_sale_order/'.$sale_info['sale_order_no'].'">Return</a>';
                                echo '</td>';
                            }                            
                        ?>
                        <?php 
                            if($this->session->userdata('user_type') != SALESMAN)
                            {                                    
                                echo '<td>';
                                echo '<a href="'.base_url().'sale/delete_sale/'.$sale_info['sale_order_no'].'">Delete</a>';
                                echo '</td>';
                            }                            
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>