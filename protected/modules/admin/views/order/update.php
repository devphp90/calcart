<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	'Order ID #'.$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Orders', 'url'=>array('index')),
	array('label'=>'Create Order', 'url'=>array('create')),
	array('label'=>'View Order', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Order ID # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'orderBlobModel'=>$orderBlobModel)); ?>
