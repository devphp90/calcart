<?php
$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	'Expense ID #'.$model->id,
);

$this->menu=array(
	array('label'=>'List Expenses', 'url'=>array('index')),
	array('label'=>'Create Expenses', 'url'=>array('create')),
	array('label'=>'Update Expenses', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Expenses', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Expenses Detail</h1>
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
			'name'=>'date',
			'type'=>'raw',
			'value'=>Yii::app()->dateFormatter->format("MMM dd, yyyy", $model->date)
		),
		array(
			'name'=>'description',
			'type'=>'html',
			'value'=>$model->description
		),
		array(
			'name'=>'type',
			'type'=>'text',
			'value'=>$model->types->name
		),
		array(
			'name'=>'amount',
			'type'=>'raw',
			'value'=>Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($model->amount), 'USD'),
			'htmlOptions'=>array(
				'style'=>'text-align:right'
			)
		),
		array(
			'label'=>'File',
			'type'=>'html',
			'value'=>'<div class="scale-down">'.CHtml::image(Yii::app()->controller->createUrl('loadImage', array('id'=>$model->id))).'</div>',
			'visible'=>(!empty($model->binaryfile)) ? true : false,
		)
    ),
)); ?>
