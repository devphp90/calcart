<?php
$this->breadcrumbs=array(
	'Tenants'=>array('index'),
	'Update',
);
?>

<h1>Update Tenant</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>