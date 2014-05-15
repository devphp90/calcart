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
				    <?php 
				    if(Yii::app()->user->isAdmin)
				    	echo $form->textField($model,'username');
				    else
				    	echo $model->username;?>
				</div>

				<div class="control-group <?php if ($model->hasErrors('password')) echo "error"; ?>">
				 <?php echo $form->labelEx($model,'password'); ?>
				 <?php echo $form->passwordField($model,'password'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('email')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'email'); ?>
				    <?php echo $form->textField($model,'email'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('phone')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'phone'); ?>
				    <?php echo $form->textField($model,'phone'); ?>
				</div>
				
				<div class="control-group <?php if ($model->hasErrors('address1')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'address1'); ?>
				    <?php echo $form->textField($model,'address1'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('address2')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'address2'); ?>
				    <?php echo $form->textField($model,'address2'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('city')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'city'); ?>
				    <?php echo $form->textField($model,'city'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('state')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'state'); ?>
				    <?php echo $form->textField($model,'state'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('zip')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'zip'); ?>
				    <?php echo $form->textField($model,'zip'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('avatarfile')) echo "error"; ?>">
				    <?php echo $form->labelEx($model,'avatarfile',array('label'=>'Avatar / Logo (Best view 150x150)')); ?>
				    <?php echo $form->fileField($model,'avatarfile'); ?>
				</div>
				
				<div class="scale-down" style="width:150px;height:150px;">
				 <?php //echo CHtml::image(Yii::app()->controller->createUrl('loadImage', array('id'=>$model->id),'',array('htmlOptions'=>array("style"=>"width:150px;height:150px;"))));?>
				 	<img src="<?php echo Yii::app()->controller->createUrl('loadImage', array('id'=>$model->id)); ?>"                     style="width:150px;height:150px;" />
				</div>
				<div id="control-group <?php if ($model->hasErrors('isactive')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'isactive'); ?>
					<?php echo $form->dropDownList($model,'isactive',array('inactive','active'));?>
				</div>
			</div>
		</div>

		<div>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'remove', 'label'=>'Reset')); ?>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->
