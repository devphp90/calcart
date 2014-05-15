<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'search-tenant-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'post',
	'htmlOptions'=>array(
		'class'=>'well form-search',
		'type'=>'horizontal',
	),
)); ?>
	
	<div class="control-group">
		<?php echo CHtml::label('Username', CHtml::activeId($model, 'username'), array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'username', array('maxlength'=>20, 'class'=>'span3')); ?>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::label('Email', CHtml::activeId($model, 'email'), array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'email', array('maxlength'=>45, 'class'=>'span3')); ?>
	</div>
	
	<div class="control-group">
		<?php echo CHtml::label('Is Active', CHtml::activeId($model, 'isactive'), array('class'=>'span2')); ?>
		<?php echo $form->dropdownList($model,'isactive', array('0' => 'No', '1' => 'Yes'), array('empty'=>'Select type', 'class'=>'span3')); ?>
	</div>

	<div class="control-group">
		<?php echo CHtml::label('Is Admin', CHtml::activeId($model, 'isadmin'), array('class'=>'span2')); ?>
		<?php echo $form->dropdownList($model,'isadmin', array('0' => 'No', '1' => 'Yes'), array('empty'=>'Select type', 'class'=>'span3')); ?>
	</div>	

	<div style="text-align:right">
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'search white', 'label'=>'Search')); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'button', 'icon'=>'icon-remove-sign white', 'label'=>'Reset', 'htmlOptions'=>array('class'=>'btnreset btn-small'))); ?>
	</div>

<?php $this->endWidget(); ?>