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

<?php echo $form->errorSummary($model, 'Opps!!!', null, array('class'=>'alert alert-error span12','style'=>'margin-left:0px;')); ?>




	<fieldset>
		<?php
		/*
		?>
		<legend>
			<p class="note">Fields with <span class="required">*</span> are required.</p>
		</legend>
		<?php
		*/
		?>
		
		
		<div class="control-group" >
		
			<div class="span5" style="margin-left:0px;">
				<div class="control-group <?php if ($model->hasErrors('first_name')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'first_name'); ?>
					<?php echo $form->textField($model,'first_name'); ?>
				</div>				
				<div class="control-group <?php if ($model->hasErrors('last_name')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'last_name'); ?>
					<?php echo $form->textField($model,'last_name'); ?>
				</div>	
                <div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'email'); ?>
					<?php echo $form->textField($model,'email'); ?>
				</div>	
				
			</div>
			<div class="span5">
				
				<div class="control-group <?php if ($model->hasErrors('phone')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'phone',array('label'=>'Phone')); ?>
					<?php echo $form->textField($model,'phone'); ?>
				</div>
				
				<div class="control-group <?php if ($model->hasErrors('comment')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'comment'); ?>
					<?php echo $form->textArea($model,'comment',array('rows'=>5)); ?>
				</div>	
				
			</div>
		</div>

		<div class="form-actions" style="padding-left:15px;">
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>$model->isNewRecord ? 'Schedule Service' : 'Save')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'remove', 'label'=>'Reset')); ?>
		</div>
	
	</fieldset>

<?php $this->endWidget(); ?>


