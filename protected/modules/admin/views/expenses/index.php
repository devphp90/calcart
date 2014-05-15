<?php
$this->breadcrumbs=array(
	'Expenses',
);

$this->menu=array(
	array('label'=>'Create Expenses', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle('fast');
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('expenses-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<h1>Expenses</h1>
<h3>Total Spent: <?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($totalAmount), 'USD'); ?></h3>
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
	'types'=>$types
)); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
	'id'=>'expenses-grid',
    'dataProvider'=>$model->search(),
    'template'=>"{items}",
    'columns'=>array(
        array(
			'name'=>'date',
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->date)',
			'htmlOptions'=>array('width'=>'80'),
		),
		array(
			'name'=>'description',
			'type'=>'html',
			'value'=>'CHtml::link($data->description, Yii::app()->controller->createUrl("view", array("id"=>$data->id)))'
		),
		array(
			'name'=>'type',
			'type'=>'text',
			'value'=>'$data->types->name',
			'htmlOptions'=>array('width'=>'80'),
		),
		array(
			'name'=>'amount',
			'type'=>'raw',
			'value'=>'Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->amount), \'USD\')',
			'htmlOptions'=>array(
				'style'=>'text-align:right',
				'width'=>'100',
			)
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