<?php
$this->breadcrumbs=array(
	'Types'=>array('index'),
	'Type ID #'.$model->id,
);

$this->menu=array(
	array('label'=>'List Type', 'url'=>array('index')),
	array('label'=>'Create Type', 'url'=>array('create')),
	array('label'=>'Update Type', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Type', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Type Detail</h1>
<hr />
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
	'htmlOptions'=>array(
		'class'=>''
	)
));

$this->widget('bootstrap.widgets.TbMenu', array(
	'type'=>'pills',
	'items'=>array(
		array('label'=>'Create', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create')),
		array('label'=>'Update', 'icon'=>'icon-edit', 'url'=>Yii::app()->controller->createUrl('update', array('id'=>$model->id))),
		array('label'=>'Print', 'icon'=>'icon-print', 'url'=>array('print'), 'linkOptions'=>array('class'=>'jprint')),
		array('label'=>'Help', 'icon'=>'icon-question-sign', 'linkOptions'=>array())
	),
));
$this->endWidget();
?>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
		
		array(
			'name'=>'name',
			'type'=>'html',
			'value'=>$model->name
		),
		
		
    ),
)); ?>
