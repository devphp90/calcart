<br/>
<div class="alert alert-success">
<b>The Service you selected is: </b><?php echo $item->name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Price:</b>  <?php echo Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($item->price),'USD'); ?> <br/>
<b>Description:</b>  <?php echo $item->description; ?><br/> 
<b>Complete the form below and click Schedule.  A confirmation will be sent by email.</b>
</div>

<?php

$this->renderPartial("_checkoutform",array('model'=>$model));

?>
