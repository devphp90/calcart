<?php
$this->pageTitle=Yii::app()->name . ' - Recover';
$this->breadcrumbs=array(
	'Recover',
);
?>

<h1>Recover your password</h1>

<p>You can reset your password if you know the email address.</p>

<?php if(Yii::app()->user->hasFlash('errorMessage')):?>
	<div class="info">
		<?php echo Yii::app()->user->getFlash('errorMessage'); ?>
	</div>
<?php endif; ?>

<div class="form">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'recover-form',
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

		<div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email', array('class'=>'span4')); ?>
		</div>

		<div>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>'Send')); ?>
			<?php echo CHtml::link('Cancel', Yii::app()->createUrl('site/login')); ?>
		</div>

	</fieldset>
		
<?php $this->endWidget(); ?>
</div><!-- form -->
