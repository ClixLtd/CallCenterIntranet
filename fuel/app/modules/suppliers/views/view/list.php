<div class="container">

    <table class="datatable">
        <thead>
        <tr>
            <th>Supplier Name</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($suppliers as $supplier): ?>
            <tr>
                <td><a href="/data/list/<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>