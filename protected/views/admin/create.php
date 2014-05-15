<?php
$this->breadcrumbs=array(
	'Tenants'=>array('index'),
	'Create',
);
?>

<h1>Create Tenant</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>