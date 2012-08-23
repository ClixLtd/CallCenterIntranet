<h2><?php echo $dialler_lead->title ?> <?php echo $dialler_lead->first_name ?> <?php echo $dialler_lead->last_name ?></h2>

<p>
	<b>Phone Number : </b><?php echo $dialler_lead->phone_number ?><br />
	<b>Alt Number : </b><?php echo $dialler_lead->alt_phone ?>
</p>

<p>
	<?php echo Html::anchor('dialler_lead/view/'.$previous_record, "Previous Lead") ?> - <?php echo Html::anchor('dialler_lead/view/'.$next_record, "Next Lead") ?>
</p>