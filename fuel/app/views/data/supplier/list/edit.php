<h2>Editing Data_supplier_list</h2>
<br>

<?php echo render('data/supplier/list/_form'); ?>
<p>
	<?php echo Html::anchor('data/supplier/list/view/'.$data_supplier_list->id, 'View'); ?> |
	<?php echo Html::anchor('data/supplier/list', 'Back'); ?></p>
