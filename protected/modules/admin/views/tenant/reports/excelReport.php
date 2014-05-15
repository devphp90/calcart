<?php if ($model !== null):?>
<table border="1">
	<tr>
		<th width="80px">
			Date
		</th>
		<th width="100%">
			Description
		</th>
		<th width="80px">
			Type
		</th>
		<th width="100px">
			Amount
		</th>
	</tr>
	<?php foreach($model as $expense):?>
	<tr>
		<td>
			<?php echo Yii::app()->dateFormatter->format("MMM dd, yyyy", $expense->date); ?>
		</td>
		<td>
			<?php echo $expense->description; ?>
		</td>
		<td>
			<?php echo $expense->types->name; ?>
		</td>
		<td style="text-align:right">
			<?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($expense->amount), 'USD'); ?>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif; ?>