 i<?php if ($model !== null):?>
<table border="1">
	<tr>
		<th width="80px">
			Date
		</th>
		<th width="100%">
			Name
		</th>
		<th width="80px">
			Description
		</th>
		<th width="100px">
			Price
		</th>
               <th width="100px">
			Qty
	        </th>
	</tr>
	<?php foreach($model as $expense):?>
	<tr>
		<td>
			<?php echo Yii::app()->dateFormatter->format("MMM dd, yyyy", $expense->pd_date); ?>
		</td>
		<td>
			<?php echo $expense->pd_name; ?>
		</td>
		<td>
			<?php echo $expense->pd_description; ?>
		</td>
		<td style="text-align:right">
			<?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($expense->pd_price), 'USD'); ?>
		</td>
                <td>
			<?php echo $expense->pd_qty; ?>
		</td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif; ?>
