<?php
$this->breadcrumbs=array(
	'Type',
);

$this->menu=array(
	array('label'=>'Create Type', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('type-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Types</h1>
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
		array('label'=>'Export to PDF', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>($totalAmount > 0)),
		array('label'=>'Export to Excel', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>($totalAmount > 0)),
		array('label'=>'Print', 'icon'=>'icon-print', 'url'=>array('print'), 'linkOptions'=>array('class'=>'jprint')),
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
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
	'id'=>'type-grid',
    'dataProvider'=>$model->search(),
    'template'=>"{items}",
    'columns'=>array(
       
		array(
			'name'=>'name',
			'type'=>'html',
			'value'=>'CHtml::link($data->name, Yii::app()->controller->createUrl("view", array("id"=>$data->id)))'
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

