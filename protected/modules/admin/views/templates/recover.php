<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport" />
</head>
<body style="margin: 0; padding: 20px;">
        <p>
        	You have requested to reset the password for your account.
		</p>
		<p>
			To continue with the password reset process, please click on the following link:<br  />
        	<?php echo CHtml::link(Yii::app()->createAbsoluteUrl('account/restore', array('k'=>$VerifyKey)), Yii::app()->createAbsoluteUrl('account/restore', array('k'=>$VerifyKey)));?>.
		</p>
        <p>
        	Regards,<br />
			Expense Tracker Team<br />
			<hr />
			This message was created by Expense Tracker
        </p>
	</div>
</body>
</html>