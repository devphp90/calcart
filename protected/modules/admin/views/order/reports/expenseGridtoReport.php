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
			'name'=>'od_date',
			'sortable'=>false,
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->od_date)',
			'headerHtmlOptions'=>array('width'=>'80'),
			'htmlOptions'=>array('width'=>'80'),
		),
		array(
			'name'=>'od_shipping_first_name',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'$data->od_shipping_first_name',
			'headerHtmlOptions'=>array('width'=>'200'),
			'htmlOptions'=>array('width'=>'200'),
		),
		array(
			'name'=>'od_shipping_last_name',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'$data->od_shipping_last_name',
			'headerHtmlOptions'=>array('width'=>'200'),
			'htmlOptions'=>array('width'=>'200'),
		),
	),
)); ?>
