<?php
$this->pageTitle=Yii::app()->name . ' - CalCart Admin Login';
$this->breadcrumbs=array(
	'CalCart Admin Login',
);
?>
<br/>
<br/>
<br/>

<h1>CalCart Admin Login</h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
	<div class="info">
		<?php echo Yii::app()->user->getFlash('success'); ?>
	</div>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('AuthController_confirm')):?>
	<div class="info">
		<?php echo Yii::app()->user->getFlash('AuthController_confirm'); ?>
	</div>
<?php endif; ?>

<div class="form">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'login-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'type'=>'horizontal',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data'
	)
)); ?>
<br/>
	<fieldset>


		<div class="control-group <?php if ($model->hasErrors('username')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'username',array('label'=>'Username '.CHtml::link('(Send me my username)', Yii::app()->createUrl('site/recoverName')))); ?>
			<?php echo $form->textField($model,'username', array('class'=>'span4')); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="control-group <?php if ($model->hasErrors('password')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'password',array('label'=>'Password '.CHtml::link('(Forgot your password?)', Yii::app()->createUrl('site/recover')))); ?>
			<?php echo $form->passwordField($model,'password', array('class'=>'span4')); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		

		<div class="control-group">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->labelEx($model,'rememberMe', array('style'=>'display:inline;')); ?>
		</div>
		
		<div>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Login')); ?>
		</div>
		
	</fieldset>

<?php $this->endWidget(); ?>
</div><!-- form -->
