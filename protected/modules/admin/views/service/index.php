<?php
$this->breadcrumbs=array(
	'Services',
);

$this->menu=array(
	array('label'=>'Create Service', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('service-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Service Session</h1>
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
//			array('label'=>'List', 'icon'=>'icon-th-list', 'url'=>Yii::app()->controller->createUrl('index'), 'linkOptions'=>array()),
			array('label'=>'Search', 'icon'=>'icon-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
			array('label'=>'Export to PDF', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank','title'=>'Coming soon', 'onclick' => 'return false'), 'visible'=>true,'htmlOptions'=>array('title'=>'123')),
			array('label'=>'Export to Excel', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank','title'=>'Coming soon','onclick' => 'return false'), 'visible'=>true),
//			array('label'=>'Print', 'icon'=>'icon-print', 'url'=>'javascript:void(0);return false', 'linkOptions'=>array('onclick'=>'printDiv();return false;')),
			array('label'=>'Help', 'icon'=>'icon-question-sign', 'url'=>array('#myModal'), 'linkOptions'=>array('data-toggle'=>'modal'))
		),
	));
$this->endWidget();
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div>
<div class='printableArea'>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped bordered condensed',
		'id'=>'service-grid',
		'dataProvider'=>$model->search(),
		'filter' => $model,
		'template'=>"{items}\n{pager}",
		'columns'=>array(

			array(
				'name'=>'name',
				'type'=>'html',
				'value'=>'CHtml::link($data->name, Yii::app()->controller->createUrl("view", array("id"=>$data->id)))'
			),
			array(
				'name'=>'description',
				'type'=>'html',
				'value'=>'$data->description'
			),
			array(
				'name'=>'price',
				'type'=>'html',
				'value'=>'Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->price), \'USD\')',
			),
			array(
				'name'=>'qty',
				'type'=>'html',
				'value'=>'$data->qty'
			),
			'qty_ordered',
			array(
				'name'=>'active',
				'value'=>'$data->active !=1 ? \'inactive\':\'active\'',
			),
			array(
				'name'=>'date',
				'header'=>'Date Created',
				'type'=>'raw',
				'value'=>'Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->date)',
				'htmlOptions'=>array('width'=>'80'),
			),
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
</div>
