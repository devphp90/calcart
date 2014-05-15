<?php
$this->pageTitle=Yii::app()->name . ' - Restore Password';
$this->breadcrumbs=array(
	'Restore Password',
);
?>

<h1>Restore your password</h1>

<?php if(Yii::app()->user->hasFlash('errorMessage')):?>
	<div class="info">
		<?php echo Yii::app()->user->getFlash('errorMessage'); ?>
	</div>
<?php endif; ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'restore-form'
)); ?>

	<?php echo $form->errorSummary($model)."<br />"; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'confirmpassword'); ?>
		<?php echo $form->passwordField($model,'confirmpassword'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Send'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
