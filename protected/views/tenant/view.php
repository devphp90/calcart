<?php
$this->breadcrumbs=array(
	'Tenants'=>array('index'),
	$model->username,
);

/*$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);*/
?>

<h1>View <?php echo $model->username; ?>&nbsp;<span style="font-size:12px;"><?php echo CHtml::link('Update', Yii::app()->controller->createUrl('update', array('id'=>$model->id))); ?></span></h1>
<br />
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'username',
		'email',
		array(
			'label'=>'Is Active',
			'type'=>'boolean',
			'value'=>$model->isactive
		),
		'creation_date',
	),
)); ?>
