    <div >
        <h3>All messages</h2>
    </div>
<div class="row col-md-12 top-bottom-padding" style="background-color: #E4F2D9">
    <table class="table table-bordered table-condensed" style="background-color: white">
        <tr class="warning">
            <th>Messege No.</th>
            <th>Messege ID</th>
            <th>Messege Body</th>
            <th>Messege Created On</th>
        </tr>
        
        <?php // $i=0; $msg = $all_messages[0];?>
        <?php $i=0;  foreach ($all_messages as $msg){ $i++;?>
        <tr>
            <td><?php echo $i;?> </td>
            <td><?php echo $msg['id'];?> </td>
            <td><a href="<?php echo base_url().'message/show_message/'.$msg['id'];?>"><?php echo html_entity_decode(html_entity_decode(substr($msg['message'], 0, 64)));?></a> </td>
            <td><?php echo date('d-m-Y', $msg['created_on']);?> </td>
        </tr>
        <?php }?>
    </table>
</div>