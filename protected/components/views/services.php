
<?php
//echo "ok";
 $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$this->serviceDataProvider,
	'itemView'=>'_serviceView',
        'summaryText'=>'',//'{start}-{end} of {count} Services',
        'emptyText'=>'Currently, no services available', 
        'template' => '{summary}{pager} {items}  {pager}',
));

?>
