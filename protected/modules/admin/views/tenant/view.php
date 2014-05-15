<?php
$this->breadcrumbs=array(
	//'Provider'=>array('index'),
	'Provider ID #'.$model->id,
);

$this->menu=array(
	array('label'=>'List Provider', 'url'=>array('index')),
	//array('label'=>'Create Tenant', 'url'=>array('create')),
	array('label'=>'Update Provider', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Provider', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Provider Detail</h1>
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
			//array('label'=>'Create', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create')),
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
				'name'=>'creation_date',
				'type'=>'raw',
				'value'=>Yii::app()->dateFormatter->format("MMM dd, yyyy", $model->creation_date)
			),
			array(
				'name'=>'name',
				'type'=>'html',
				'value'=>$model->name
			),
			array(
				'name'=>'username',
				'type'=>'html',
				'value'=>$model->username
			),
			array(
				'name'=>'email',
				'type'=>'html',
				'value'=>$model->email
			),
			'fPhone',
			'address1',
			'address2',
			'city',
			'state',
			'zip',
			array(
				'name'=>'isactive',
				'value'=>$model->isactive !=1 ? 'inactive':'active',
			),
			array(
				'label'=>'Avatar / Logo',
				'type'=>'html',
				'value'=>'<div class="scale-down" style="width:150px;height:150px;">'.CHtml::image(Yii::app()->controller->createUrl('loadImage', array('id'=>$model->id))).'</div>',
				'visible'=>(!empty($model->avatarfile)) ? true : false,
			)

		),
	)); ?>
