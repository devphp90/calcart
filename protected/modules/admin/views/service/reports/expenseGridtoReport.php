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
			'name'=>'pd_date',
			'sortable'=>false,
			'type'=>'raw',
			'value'=>'Yii::app()->dateFormatter->format("MMM dd, yyyy", $data->pd_date)',
			'headerHtmlOptions'=>array('width'=>'80'),
			'htmlOptions'=>array('width'=>'80'),
		),
               array(
			'name'=>'pd_name',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'$data->pd_name',
			'headerHtmlOptions'=>array('width'=>'150'),
			'htmlOptions'=>array('width'=>'150'),
		),
		array(
			'name'=>'pd_description',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'$data->pd_description',
			'headerHtmlOptions'=>array('width'=>'150'),
			'htmlOptions'=>array('width'=>'150'),
		),
                array(
			'name'=>'pd_qty',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'$data->pd_qty',
			'headerHtmlOptions'=>array('width'=>'50'),
			'htmlOptions'=>array('width'=>'50'),
		),
		array(
			'name'=>'pd_price',
			'sortable'=>false,
			'type'=>'ntext',
			'value'=>'Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->pd_price), \'USD\')',
			'headerHtmlOptions'=>array('width'=>'150'),
			'htmlOptions'=>array('width'=>'150'),
		),
          
		/*array(
			'name'=>'amount',
			'sortable'=>false,
			'type'=>'raw',
			'value'=>'Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->amount), \'USD\')',
			'headerHtmlOptions'=>array('width'=>'100'),
			'htmlOptions'=>array(
				'style'=>'text-align:right',
				'width'=>'100',
			)
		)*/
	),
)); ?>
