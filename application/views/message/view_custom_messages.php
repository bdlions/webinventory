<div >
    <h3>All messages</h2>
</div>
<div class="form-horizontal form-background top-bottom-padding">
    <div class="table-responsive">
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
                <td><a href="<?php echo base_url().'message/update_custom_message/'.$msg['id'];?>"><?php echo substr(html_entity_decode(html_entity_decode($msg['message'])), 0, 64);?></a> </td>
                <td><?php echo date('d-m-Y', $msg['created_on']);?> </td>
            </tr>
            <?php }?>
        </table>
    </div>    
</div>