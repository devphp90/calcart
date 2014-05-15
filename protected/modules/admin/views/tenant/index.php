<?php
$this->breadcrumbs=array(
	'Provider',
);

$this->menu=array(
	array('label'=>'Create Tenant', 'url'=>array('create')),
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

<h1>Accounts</h1>
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
			array('label'=>'Export to PDF', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
			array('label'=>'Export to Excel', 'icon'=>'icon-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
			array('label'=>'Print', 'icon'=>'icon-print', 'url'=>array('print'), 'linkOptions'=>array('class'=>'jprint')),
			array('label'=>'Help', 'icon'=>'icon-question-sign', 'url'=>array('#myModal'), 'linkOptions'=>array('data-toggle'=>'modal'))
		),
	));
$this->endWidget();
?>
<div class="search-form" style="display:none">
<?php

$this->renderPartial('_search',array(
		'model'=>$model,
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
				'header'=>'#',
			),
			array(
				'name'=>'creation_date',
				'type'=>'raw',
				'value'=>'Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->creation_date)',
				'htmlOptions'=>array('width'=>'80'),
			),
			array(
				'name'=>'name',
				'type'=>'html',
				'value'=>'CHtml::link($data->name, Yii::app()->controller->createUrl("view", array("id"=>$data->id)))'
			),
			array(
				'name'=>'username',
				'type'=>'html',
				'value'=>'$data->username'
			),
			array(
				'name'=>'email',
				'type'=>'html',
				'value'=>'$data->email'
			),

			array(
				'name'=>'isactive',
				'value'=>'$data->isactive !=1 ? \'inactive\':\'active\'',
			),
            array(
                'header'=>'View',
                'type'=>'raw',
                'value'=>'CHtml::link("Services", array("service/index", "tid" => $data->id))." | ".CHtml::link("Orders", array("order/index", "tid" => $data->id))'
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
