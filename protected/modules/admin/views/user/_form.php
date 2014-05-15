<div class="form">

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'user-form',
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

		<div class="control-group <?php if ($model->hasErrors('username')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="control-group <?php if ($model->hasErrors('password')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo $form->passwordField($model,'password',array('size'=>32,'maxlength'=>32,'readonly'=>true,'disabled'=>'disabled', 'class'=>'span4')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45, 'class'=>'span4')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'remove', 'label'=>'Reset')); ?>
		</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->