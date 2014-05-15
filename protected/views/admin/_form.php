<div class="form">

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'tenant-form',
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
		
		<?php echo $form->errorSummary($model, 'Opps!!!', null, array('class'=>'alert alert-error')); ?>
		
		<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
		
		<div class="control-group <?php if ($model->hasErrors('username')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'class'=>'span4')); ?>
		</div>

		<div class="control-group <?php if ($model->hasErrors('password')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>32,'maxlength'=>32, 'class'=>'span4','value'=>'')); ?>
			<?php if(!$model->isNewRecord):?>
			<p class="help-block">For security reasons password isn't show, if want to change it, type a new one.</p>
			<?php endif; ?>
		</div>

		<div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45, 'class'=>'span4')); ?>
		</div>
		
		<div class="control-group <?php if ($model->hasErrors('isactive')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'isactive'); ?>
			<?php echo $form->dropdownList($model,'isactive', array('0' => 'No', '1' => 'Yes'), array('class'=>'span4')); ?>
		</div>

		<div class="control-group <?php if ($model->hasErrors('isadmin')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'isadmin'); ?>
			<?php echo $form->dropdownList($model,'isadmin', array('0' => 'No', '1' => 'Yes'), array('class'=>'span4')); ?>
		</div>

		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'remove', 'label'=>'Reset')); ?>
		</div>
	
	</fieldset>

<?php $this->endWidget(); ?>
