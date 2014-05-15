<div class="well">

	<?php echo CHtml::link('View Details', array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />
       	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br /> 
 
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />
        <b><?php echo CHtml::encode($data->getAttributeLabel('qty')); ?>:</b>
	<?php echo CHtml::encode($data->qty); ?>
	<br /> 
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->amount), 'USD'); ?>
	<br />

</div>
