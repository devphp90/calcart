<div class="form">

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'order-form',
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
			<div class="span4"">
				<div class="control-group <?php if ($model->hasErrors('date')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'date'); ?>
					<?php //echo $form->textField($model,'date',array('placeholder'=>'yyyy-M-d H:m:s')); ?> 
				
				<?php
				$this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'attribute'=>'date',
                    'model'=>$model,
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=> 'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'style'=>'height:20px;'
                    ),
                ));
                ?>
                </div>
				<div class="control-group <?php if ($model->hasErrors('service_name')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'service_name'); ?>
					<?php echo $form->textField($model,'service_name'); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('service_description')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'service_description'); ?>
					<?php echo $form->textArea($model,'service_description',array('rows'=>5,'columns'=>40)); ?>
				</div>
				<div class="control-group <?php if ($model->hasErrors('service_price')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'service_price'); ?>
					<?php echo $form->textField($model,'service_price'); ?>
				</div>
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
			    <div class="control-group <?php if ($model->hasErrors('phone')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'phone'); ?>
					<?php echo $form->textField($model,'phone',array('placeholder'=>'xxx-xxx-xxxx')); ?>
			    </div>
			    <div class="control-group <?php if ($model->hasErrors('comment')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'comment'); ?>
					<?php echo $form->textArea($model,'comment',array('rows'=>5,'columns'=>40)); ?>
			    </div>
			    <div class="control-group <?php if ($model->hasErrors('provider_notes')) echo "error"; ?>">
					<?php echo $form->labelEx($model,'provider_notes'); ?>
					<?php echo $form->textArea($model,'provider_notes',array('rows'=>5,'columns'=>40)); ?>
			    </div>
			    
			</div>
		<?php
		/** 2012/06/09 odin
			only support when update**/
		if(!$model->isNewRecord){
		?>	
			<div class="span7">
				<table class="table table-striped">
				    <thead>
				    	<th>#</th>
				    	<th>File Name</th>
				    	<th>File Type</th>
				    	<th width="50"></th>
				    </thead>
				    <tbody>
				    	<?php
				    	foreach($orderBlobModel as $key=>$value):
				    	?>
				    	<tr>
				    		<td><?php echo $key+1?></td>
				    		<td><a rel="popover"  
				    		<?php if(preg_match("/image/",$value->type)){?> 
				    			title="<?php echo $value->name?>"
				    			data-content="<img src='<?php echo $this->createUrl('order/loadBlob',array('id'=>$value->id));?>'>"
				    		<?php }?>
				    		 href="<?php echo $this->createUrl('order/loadBlob',array('id'=>$value->id));?>"><?php echo $value->name?></a></td>
				    		<td><?php echo $value->type?></td>
				    		<td><a class="btn btn-small" title="Delete" href="<?php echo $this->createUrl('order/blobDel',array('od_id'=>$model->id,'id'=>$value->id))?>"><i class="icon-trash"></i></a></td>
				    	</tr>
				    	<?php
				    	endforeach;
				    	?>
				    </tbody>
				</table>
				<div class="control-group <?php if ($model->hasErrors('file')) echo "error"; ?>">
					<?php echo $form->fileField($model,'file'); ?>
				</div>
				<div>
					<ul class="thumbnails">
					
					<?php
				    	foreach($orderBlobModel as $key=>$value):
				    		if(preg_match("/image/",$value->type)){
				    ?>
                      	<li class="span2">
                        	<a href="#" class="thumbnail">
                        		<img src="<?php echo $this->createUrl('order/loadBlob',array('id'=>$value->id));?>" alt="">
                        	</a>
                        </li>
                    <?php
                    		}
				    	endforeach;
				    ?>
                    </ul>
					
				</div>
			</div>
		<?php	
		}
		?>
		</div>
		<script>
		
		</script>
		<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit', 
				'type'=>'primary', 
				'icon'=>'ok white', 
				'label'=>$model->isNewRecord ? 'Create' : 'Save')); 
			?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'reset', 
				'icon'=>'remove', 
				'label'=>'Reset')); 
			?>
		</div>
	
	</fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->
