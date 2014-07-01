<h1>Client Documents</h1>

<form action="/clientarea/aprove" method="post" id="approvedoc">
<table id="doc-table">
    <thead>
    <tr>
        <th>#</th>
        <th>Client ID</th>
        <th>filename</th>
        <th>Date Uploaded</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if(count($documents) > 0):
        foreach($documents as $item):
    ?>
    <tr>
        <td><input type="checkbox" name="document[<?php echo $item['id'];?>]" value="<?php echo $item['id']?>"/></td>
        <td><?php echo $item['client_id'];?></td>
        <td><a href="/clientarea/documents/view/<?php echo $item['id'];?>" target="_blank"><?php echo $item['filename'];?></a></td>
        <td><?php echo date('jS F Y', strtotime($item['created_at'])); ?></td>
        <td><?php echo $item['status'];?></td>
    </tr>
    <?php
        endforeach;
        else:
    ?>
    <tr>
        <td colspan="5">No Documents to approve</td>
    </tr>
    <?php endif; ?>
    </tbody>
</table>
<p style="padding:1em 0">
    <select name="action" class="form-control" id="bulk-action">
        <option value="0">- Bulk Action -</option>
        <option value="1">Pending</option>
        <option value="2">Approve</option>
        <option value="3">Decline</option>
    </select>
    <input class="btn btn-primary" type="submit" value="Update"/>
</p>
</form>

<?php echo asset::js('client-area.js'); ?>
