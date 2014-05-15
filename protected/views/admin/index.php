<?php
$this->breadcrumbs=array(
	'Tenants',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle('fast');
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tenant-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Tenants</h1>
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
		array('label'=>'Create', 'icon'=>'icon-plus', 'url'=>Yii::app()->controller->createUrl('create'), 'linkOptions'=>array()),
		array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
		array('label'=>'Print', 'icon'=>'icon-print', 'url'=>array('print'), 'linkOptions'=>array('class'=>'jprint')),
		array('label'=>'Help', 'icon'=>'icon-question-sign', 'url'=>array('#myModal'), 'linkOptions'=>array('data-toggle'=>'modal'))
	),
));
$this->endWidget();
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model
)); ?>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
	'id'=>'tenant-grid',
    'dataProvider'=>$model->search(),
    'template'=>"{items}",
    'columns'=>array(
        array(
			'name'=>'id',
			'type'=>'text',
			'value'=>'$data->id',
		),
		array(
			'name'=>'username',
			'type'=>'text',
			'value'=>'$data->username',
		),
		array(
			'name'=>'email',
			'type'=>'text',
			'value'=>'$data->email',
		),
		array(
			'name'=>'isactive',
			'type'=>'boolean',
			'value'=>'$data->isactive',
		),
		'creation_date',
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}',
			'buttons' => array(
				'update' => array(
					'label'=> 'Update',
					'options'=>array(
						'class'=>'btn btn-small update'
					)
				),
				'delete' => array(
					'label'=> 'Delete',
					'options'=>array(
						'class'=>'btn btn-small delete'
					)
				)
			),
            'htmlOptions'=>array('style'=>'width: 80px'),
        )
    ),
)); ?>
