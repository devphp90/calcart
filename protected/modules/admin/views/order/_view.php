
<div class="well">
    <?php echo CHtml::link('View Details', array('view', 'id'=>$data->id)); ?><br>
    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b> <?php echo CHtml::encode($data->date); ?><br>
    <b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b> <?php echo CHtml::encode(first_name); ?><br>
    <b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b> <?php echo CHtml::encode($data->last_name); ?><br>
    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b> <?php echo CHtml::encode($data->email); ?><br>
</div>
od_