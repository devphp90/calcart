<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Order Confirmation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport" />
</head>
<body style="margin: 0; padding: 20px;">


<p>ORDER CONFIRMATION</p>

<p>From: <?php echo $provider_name?></p>
<p>To: <?php echo $model->first_name; ?> <?php echo $model->last_name; ?> </p>
<br/>
<p>You scheduled the following service.</p>
<br/>
<p>Order Date:  <?php echo Yii::app()->dateFormatter->format("MMM dd, yyyy", $model->date); ?></p>
<p>Service Name:  <?php echo $model->service_name; ?></p>
<p>Description:  <?php echo $model->service_description; ?></p>
<p>Price:  <?php echo $model->service_price; ?></p>
<br/>
<p>Customer First Name: <?php echo $model->first_name; ?></p>
<p>Customer Last Name: <?php echo $model->last_name; ?></p>
<p>Customer Phone #:  <?php echo $model->phone; ?></p>
<p>Customer Email:  <?php echo $model->email; ?></p>
<br/>
<p>Customer Comments:  <?php echo $model->comment; ?></p>

</body>
</html>
