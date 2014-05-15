<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Order ID #'.$model->id,
);

$this->menu=array(
	array('label'=>'List Orders', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'Update Order', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Order', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Orders Detail</h1>
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
			array('label'=>'List', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'), 'linkOptions'=>array()),
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
				'name'=>'date',
				'type'=>'raw',
				'value'=>Yii::app()->dateFormatter->format("MMM dd, yyyy", $model->date)
			),
			'service_name',
			array(
				'name'=>'service_description',
				'type'=>'html',
				'value'=>nl2br($model->service_description)
			),
			array(
				'name'=>'first_name',
				'type'=>'html',
				'value'=>$model->first_name
			),
			array(
				'name'=>'last_name',
				'type'=>'html',
				'value'=>$model->last_name
			),
			array(
				'name'=>'fPhone',
				'label'=>'Phone',
			),
			array(
				'name'=>'email',
				'type'=>'html',
				'value'=>$model->email
			),
			array(
				'name'=>'comment',
				'type'=>'html',
				'value'=>$model->comment
			),
			array(
				'name'=>'provider_notes',
				'type'=>'html',
				'value'=>nl2br($model->provider_notes)
			),

		),
	)); 
?>
