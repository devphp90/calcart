<div class="form">

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'expenses-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'type'=>'horizontal',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'
	)
)); ?>

	<fieldset>
		<legend>
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		</legend>
		
		<?php echo $form->errorSummary($model, 'Opps!!!', null, array('class'=>'alert alert-error span12')); ?>
		
		<div class="control-group">
			<div class="span4 control-group <?php if ($model->hasErrors('description')) echo "error"; ?>">
				<?php echo $form->labelEx($model,'description'); ?>
				<?php echo $form->textArea($model,'description',array('rows'=>10, 'cols'=>50, 'class'=>'span4')); ?>
			</div>
			<div class="span4">
				<div class="control-group <?php if ($model->hasErrors('type')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'type'); ?>
					<?php echo $form->dropDownList($model,'type',CHtml::listData($types, 'id', 'name'), array('empty'=>'Select a type')); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('amount')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'amount'); ?>
					<?php echo $form->textField($model,'amount'); ?>
				</div>				
				<div class="control-group <?php if ($model->hasErrors('binaryfile')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'binaryfile'); ?>
					<?php echo $form->fileField($model,'binaryfile'); ?>
				</div>
			</div>
		</div>

		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'remove', 'label'=>'Reset')); ?>
		</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->