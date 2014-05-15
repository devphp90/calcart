<?php if ($model !== null):?>
<table border="1">
	<tr>
		<th width="80px">
			Date
		</th>
		<th width="100%">
			Shipping first name
		</th>
		<th width="80px">
			Shipping last name
		</th>
	</tr>
	<?php foreach($model as $expense):?>
	<tr>
		<td>

			<?php echo Yii::app()->dateFormatter->format("MMM dd, yyyy", $expense->od_date); ?>
		</td>
		<td>
			<?php echo $expense->od_shipping_first_name; ?>
		</td>
		<td>
			<?php echo $expense->od_shipping_last_name; ?>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif; ?>
