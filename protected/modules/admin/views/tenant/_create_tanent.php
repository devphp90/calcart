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
		
		<?php echo $form->errorSummary($model, 'Opps!!!', null, array('class'=>'alert alert-error span12')); ?>
		
		<div class="control-group">		
			<div class="span4">
                               <div class="control-group <?php if ($model->hasErrors('name')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'name'); ?>
					<?php echo $form->textField($model,'name'); ?>
			       </div>
                               <div class="control-group <?php if ($model->hasErrors('username')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'username'); ?>
					<?php echo $form->textField($model,'username'); ?>
			       </div>
                             
                               <div class="control-group <?php if ($model->hasErrors('password')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'password'); ?>
					<?php echo $form->passwordField($model,'password'); ?>
			       </div>
 	                       <div class="control-group <?php if ($model->hasErrors('password_repeat')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'password_repeat'); ?>
					<?php echo $form->passwordField($model,'password_repeat'); ?>
			       </div>
                             
                               <div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'email'); ?>
					<?php echo $form->textField($model,'email'); ?>
			       </div>
                                <div class="control-group <?php if ($model->hasErrors('avatarfile')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'avatarfile'); ?>
					<?php echo $form->fileField($model,'avatarfile'); ?>
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
