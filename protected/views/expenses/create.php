<?php
$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Expenses', 'url'=>array('index')),
);
?>

<h1>Create new Expense</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'types'=>$types)); ?>