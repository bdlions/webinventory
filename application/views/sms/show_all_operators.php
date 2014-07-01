<h3><?php echo $this->lang->line("operator_show_all_operators_list");?></h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
         <table class="table table-bordered">
             <thead>
                 <tr>
                     <th><?php echo $this->lang->line("operator_show_all_operators_prefix");?></th>
                     <th><?php echo $this->lang->line("operator_show_all_operators_name");?></th>
                     <th><?php echo $this->lang->line("operator_show_all_operators_description");?></th>
                 </tr>
             </thead>
             <tbody id="tbody_product_list">
                 <?php foreach ($operator_list as $key => $operator_info): ?>
                     <tr>
                         <td><?php echo $operator_info['operator_prefix'] ?></td>
                         <td><?php echo $operator_info['operator_name'] ?></td>
                         <td><?php echo $operator_info['description'] ?></td>
                     </tr>
                 <?php endforeach; ?>
             </tbody>
         </table>
     </div>
</div>