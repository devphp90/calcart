<?php
$this->pageTitle = Yii::app()->name." - Register";
?>

<h1>Sign-up for CalendarCart</h1>

<div class="form">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'register-form',
	'enableAjaxValidation'=>true,
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
			<?php echo $form->labelEx($model,'username',array('label'=>'Username (5-8 chars, A-z, 0-9)')); ?>
			<?php echo $form->textField($model,'username', array('class'=>'span4','placeHolder'=>'')); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>
		

		
		<div class="control-group <?php if ($model->hasErrors('password')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'password',array('label'=>'Password (5-8 chars, A-z, 0-9)')); ?>
			<?php echo $form->passwordField($model,'password', array('class'=>'span4')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>
		<div class="control-group <?php if ($model->hasErrors('repeatPassword')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'repeatPassword'); ?>
			<?php echo $form->passwordField($model,'repeatPassword', array('class'=>'span4')); ?>
			<?php echo $form->error($model,'repeatPassword'); ?>
		</div>
		
		<div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'email',array('label'=>'Email (go to your email account to confirm before login)')); ?>
			<?php echo $form->textField($model,'email', array('class'=>'span4')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
		<div class="control-group <?php if ($model->hasErrors('repeatEmail')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'repeatEmail'); ?>
			<?php echo $form->textField($model,'repeatEmail', array('class'=>'span4')); ?>
			<?php echo $form->error($model,'repeatEmail'); ?>
		</div>
		
		<?php if(CCaptcha::checkRequirements()) : ?>
		<div class="control-group <?php if ($model->hasErrors('verifyCode')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'verifyCode'); ?>
			<div>
				<?php $this->widget('CCaptcha'); ?>
				<br />
				<?php echo $form->textField($model,'verifyCode', array('class'=>'span4')); ?>
			</div>
			<?php echo $form->error($model,'verifyCode'); ?>
		</div>
		<?php endif; ?>
		
		<div class="control-group well">
			<div style="overflow:auto; height:150px;">
				<?php $this->renderPartial('/site/pages/termsText'); ?>
			</div>
			<hr />
			<div style="text-align:right;" class="control-group <?php if ($model->hasErrors('acceptTerms')) echo "error"; ?>">
				<?php echo $form->labelEx($model,'acceptTerms', array('style'=>'display:inline;')); ?>
				<?php echo $form->checkBox($model,'acceptTerms'); ?>
			</div>
		</div>


			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Sign Up')); ?>

		
	</fieldset>

<?php $this->endWidget(); ?>
</div><!-- form -->