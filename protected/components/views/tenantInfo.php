<div class="row">
	<div class="span3" style="float:left;">
		<div class="thumbnail" style="width:150px;">
			<img src="<?php echo Yii::app()->controller->createUrl('loadImage', array('id'=>$this->model->id)); ?>"  style="width:150px;" />
		</div>
	</div>
	<div class="span3" style="float:left; margin-top: 10px;">
		<b><?php echo $this->model->name; ?></b> <br/>
		<?php echo $this->model->fPhone; ?><br/>
		<?php echo $this->model->email; ?>

	</div>
	<div class="span5" style="float:left; margin-top: 10px;">
	<?php echo $this->model->address1; ?><br/>
	<?php echo $this->model->address2; ?><br/>
	<?php echo $this->model->city; ?>,  <?php echo $this->model->state; ?>,  <?php echo $this->model->zip; ?><br/>
	</div>
	
</div>
<?php
/*
?>
<div class="row">
	<div class="span3">
		<div class="thumbnail" style="width:150px;height:80px;">
			<img src="<?php echo Yii::app()->controller->createUrl('loadImage', array('id'=>$this->model->id)); ?>"  style="width:150px;height:80px;" />
		</div>
	</div>
	<div class="span3">
		<b>Name:</b> <?php echo $this->model->name; ?><br/>
		<b>Phone:</b> <?php echo substr($this->model->phone,0,3),'-',substr($this->model->phone,3,3),'-',substr($this->model->phone,6); ?><br/>
		<b>E-mail:</b> <?php echo $this->model->email; ?>

	</div>
	<div class="span5">
		<b>Address1: </b><?php echo $this->model->address1; ?><br/>
		<b>Address2: </b><?php echo $this->model->address2; ?><br/>
		<b>City: </b><?php echo $this->model->city; ?><br/>
		<b>State: </b><?php echo $this->model->state; ?><br/>
		<b>Zip: </b><?php echo $this->model->zip; ?><br/>
	</div>
	
</div>

<?php
*/
?>

