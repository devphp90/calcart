<style>
tr th {
	font-weight:bold;
	border-bottom:1px solid blue;
}

.even {
	background-color:#EFEFEF;
}
</style>

<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'type'=>'striped',
	'dataProvider'=>$dataProvider,
	'template'=>"{items}",
	'columns'=>array(
		array(
			'name'=>'date',
			'sortable'=>false,
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->date)',
			'headerHtmlOptions'=>array('width'=>'80'),
			'htmlOptions'=>array('width'=>'80'),
		),
		array(
			'name'=>'description',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'$data->description',
			'headerHtmlOptions'=>array('width'=>'200'),
			'htmlOptions'=>array('width'=>'200'),
		),
		array(
			'name'=>'type',
			'sortable'=>false,
			'type'=>'text',
			'value'=>'$data->types->name',
			'headerHtmlOptions'=>array('width'=>'80'),
			'htmlOptions'=>array('width'=>'80'),
		),
		array(
			'name'=>'amount',
			'sortable'=>false,
			'type'=>'raw',
			'value'=>'Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->amount), \'USD\')',
			'headerHtmlOptions'=>array('width'=>'100'),
			'htmlOptions'=>array(
				'style'=>'text-align:right',
				'width'=>'100',
			)
		)
	),
)); ?>