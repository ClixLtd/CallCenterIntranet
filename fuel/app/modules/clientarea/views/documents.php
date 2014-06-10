<h1>Client Documents</h1>

<table>
    <tr>
        <th></th>
        <th>Client ID</th>
        <th>filename</th>
        <th>Date Uploaded</th>
        <th>Status</th>
    </tr>
    <?php 
        if(count($documents) > 0):
        foreach($documents as $item):
    ?>
    <tr>
        <td><input type="checkbox" name="select" value="<?php echo $item['id']?>"/></td>
        <td><?php echo $item['client_id'];?></td>
        <td><?php echo $item['filename'];?></td>
        <td><?php echo date('jS F Y', strtotime($item['created_at'])); ?></td>
        <td><?php echo $item['status'];?></td>
    </tr>
    <?php
        endforeach;
        else:
    ?>
    <tr>
        <td colspan="3">No Documents to approve</td>
    </tr>
    <?php endif;?>
</table>