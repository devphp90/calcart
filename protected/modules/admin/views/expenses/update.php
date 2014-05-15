<?php
$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	'Expense ID #'.$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Expenses', 'url'=>array('index')),
	array('label'=>'Create Expenses', 'url'=>array('create')),
	array('label'=>'View Expenses', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Update Expense ID # <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'types'=>$types)); ?>