<?php /*
<div class="well">
<?php echo "<h1>".CHtml::link(CHtml::encode($data->name),array('site/checkout','id'=>CHtml::encode($data->id)))."</h1>";?>
<b>Description:</b><p><?php echo $data->description; ?></p>
<b>Price:</b><p><?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->price),'USD'); ?></p>
</div>
*/
?>


<div class="well" style="padding: 10px 10px 10px 10px;">
<?php echo "<h3>".CHtml::link(CHtml::encode($data->name),array('site/checkout','id'=>CHtml::encode($data->id)))."</h3>";?>
<b>Price:</b>  <?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($data->price),'USD'); ?><br/>
<b>Description:</b>  <?php echo $data->description; ?></p>
</div>






