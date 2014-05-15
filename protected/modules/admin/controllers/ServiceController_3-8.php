<?php

class ServiceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column1';
	public $layout='main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			/*array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),*/
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','loadImage','GeneratePdf','GenerateExcel','delete'),
				'users'=>array('@'),
			),
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),*/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Service;
		//$file = null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Service']))
		{
			$model->attributes=$_POST['Service'];

			if(!empty($_FILES['Service']['tmp_name']['image']))
			{
				$file = CUploadedFile::getInstance($model,'image');
				$model->image_fileName = $file->name;
				$model->pg_image_fileType = $file->type;

				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->image = $content;
			}
			if(!empty($_FILES['Service']['tmp_name']['thumbnail']))
			{
				$file = CUploadedFile::getInstance($model,'thumbnail');
				$model->thumbnail_fileName = $file->name;
				$model->pg_thumbnail_fileType = $file->type;

				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->thumbnail = $content;
			}

			$model->date=date('Y-m-d H:i:s',time());
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
				'model'=>$model,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Service']))
		{
			$model->attributes=$_POST['Service'];

			if(!empty($_FILES['Service']['tmp_name']['image']))
			{
				$file = CUploadedFile::getInstance($model,'image');
				$model->image_fileName = $file->name;
				$model->image_fileType = $file->type;

				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->image = $content;
			}else
				unset($model->image);
			if(!empty($_FILES['Service']['tmp_name']['thumbnail']))
			{
				$file = CUploadedFile::getInstance($model,'thumbnail');
				$model->thumbnail_fileName = $file->name;
				$model->pg_thumbnail_fileType = $file->type;

				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->thumbnail = $content;
			}else
				unset($model->thumbnail);
			$model->last_update=date('Y-m-d H:i:s',time());
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
				'model'=>$model,
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Service('search');
		$model->unsetAttributes();  // clear any default values

		$totalAmount = 0;

		if(isset($_GET['Service']))
		{
			$model->attributes=$_GET['Service'];

			$criteria = new CDbCriteria();

			if (!empty($model->date)) $criteria->addCondition('date >= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 00:00:01', $model->date).'"');
			if (!empty($model->endDate)) $criteria->addCondition('date <= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', $model->endDate).'"');
			/*
			$criteria->params = array(
				':user_id'=>Yii::app()->user->id
			);
			 */

		}
		else {

		}

		$this->render('index',array(
				'model'=>$model,
			));
	}

	public function actionloadImage($id)
	{
		$model=$this->loadModel($id);
		$this->renderPartial('image', array(
				'model'=>$model
			));
	}

	public function actionGenerateExcel()
	{
		$model = Service::model()->findAll();

		Yii::app()->request->sendFile(date('YmdHis').'.xls',
			$this->renderPartial('reports/excelReport', array(
					'model'=>$model
				), true)
		);
	}

	public function actionGeneratePdf()
	{
		Yii::import('application.vendors.*');
		require_once('tcpdf/tcpdf.php');
		require_once('tcpdf/config/lang/eng.php');

		$dataProvider = new CActiveDataProvider('Service');
		$html = $this->renderPartial('/service/reports/expenseGridtoReport', array(
				'dataProvider'=>$dataProvider
			), true);

		//die($html);

		$pdf = new TCPDF();
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('AXEO CalCart');
		$pdf->SetTitle('Service Report');
		$pdf->SetSubject('Service Report');
		//$pdf->SetKeywords('example, text, report');
		$pdf->SetHeaderData('', 0, "Report", '');
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Example Report by AXEO CalCart", "");
		$pdf->setHeaderFont(array('helvetica', '', 8));
		$pdf->setFooterFont(array('helvetica', '', 6));
		$pdf->SetMargins(15, 18, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->SetFont('dejavusans', '', 7);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->LastPage();
		$pdf->Output("services_002.pdf", "I");
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Service::model()->findByPk($id);
		if($model===null || $model->t_id != Yii::app()->user->id)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='service-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
