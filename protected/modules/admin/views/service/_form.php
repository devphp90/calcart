<div class="form">

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'service-form',
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
                        <div class="control-group <?php if ($model->hasErrors('description')) echo "error"; ?>">
                                <?php echo $form->labelEx($model,'description'); ?>
                                <?php echo $form->textArea($model,'description', array('rows' => 5, 'class' => 'span4')); ?>
                        </div>

                        <div class="control-group <?php if ($model->hasErrors('qty')) echo "error"; ?>">
                                <?php echo $form->labelEx($model,'qty'); ?>
                                <?php echo $form->textField($model,'qty'); ?>
                        </div>

                        <div class="control-group <?php if ($model->hasErrors('qty_ordered')) echo "error"; ?>">
                                <?php echo $form->labelEx($model,'qty_ordered'); ?>
                                <?php echo $form->textField($model,'qty_ordered'); ?>
                        </div>
                        <div class="control-group <?php if ($model->hasErrors('price')) echo "error"; ?>">
                                <?php echo $form->labelEx($model,'price'); ?>
                                <?php echo $form->textField($model,'price'); ?>
                        </div>
                        
                        <?php if (!$model->isNewRecord && !empty($model->image)) { ?>
                        <div class="control-group">
                            <label for="Service_qty">Current Image</label>
                            <img src="<?php echo $model->getImage(param('thumbs', 'small')) ?>"/>
                        </div>
                        <?php } ?>
                        
                        <div class="control-group <?php if ($model->hasErrors('image')) echo "error"; ?>">
                                <?php echo $form->labelEx($model,'image'); ?>
                                <?php echo $form->fileField($model,'image'); ?>
                        </div>
                        
                        <div id="control-group <?php if ($model->hasErrors('active')) echo "error"; ?>">
                                <?php echo $form->labelEx($model,'active'); ?>
                                <?php echo $form->dropDownList($model,'active',array('inactive','active'));?>
                        </div>
                    </div>
		</div>

		<div class="form-actions" style="padding-left: 30px;">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'icon'=>'ok white', 'label'=>$model->isNewRecord ? 'Create' : 'Save')); ?>
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'icon'=>'remove', 'label'=>'Reset')); ?>
		</div>

	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->
