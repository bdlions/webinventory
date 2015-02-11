
<h3>Search Customer by Total Due</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="row form-group">
        <div class ="col-md-offset-1 col-md-2">
            <label style="margin-top: 5px;">Search Customer by Total Due:</label>
        </div>
        <div class ="col-md-2">
            <select class="form-control">
                <option class=""> Select an Option </option>
                <option class=""> Name </option>
                <option class=""> Date </option>
                <option class=""> Mobile No </option>
                <option class=""> Card No </option>
            </select>
        </div>
        <div class ="col-md-7"></div>
    </div>
    <div class="row form-group">
        <div class ="col-md-offset-3 col-md-2">
            <input id="button_search_customer" class="form-control">
        </div>
        <div class ="col-md-7"></div>
    </div>
    <div class="row form-group">
        <div class ="col-md-offset-3 col-md-2">
            <input id="button_search_customer" class="form-control btn-success" type="reset" value="Search" name="button_search_customer_due">
        </div>
        <div class ="col-md-7"></div>
    </div>
</div>
<h3>Search Result</h3>
<div class="form-background top-bottom-padding">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Mobile No</th>
                    <th>Card No</th>
                    <th>Total Due</th>
                </tr>
            </thead>
            <tbody id="tbody_customer_list">                
            
            </tbody>
        </table>
    </div>
</div>