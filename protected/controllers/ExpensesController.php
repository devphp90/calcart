<?php

class ExpensesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','loadImage','GeneratePdf','GenerateExcel','delete'),
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
		$model=new Expenses;
		//$file = null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Expenses']))
		{
			$model->attributes=$_POST['Expenses'];
			
			if(!empty($_FILES['Expenses']['tmp_name']['binaryfile']))
			{
				$file = CUploadedFile::getInstance($model,'binaryfile');
				$model->fileName = $file->name;
				$model->fileType = $file->type;
				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->binaryfile = $content;
			}
			
			$model->user = Yii::app()->user->id;
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'types'=>Type::model()->findAll()
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

		if(isset($_POST['Expenses']))
		{
			$model->attributes=$_POST['Expenses'];
			
			if(!empty($_FILES['Expenses']['tmp_name']['binaryfile']))
			{
				$file = CUploadedFile::getInstance($model,'binaryfile');
				$model->fileName = $file->name;
				$model->fileType = $file->type;
				$fp = fopen($file->tempName, 'r');
				$content = fread($fp, filesize($file->tempName));
				fclose($fp);
				$model->binaryfile = $content;
			}
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'types'=>Type::model()->findAll()
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Expenses('search');
        $model->unsetAttributes();  // clear any default values
		
		$totalAmount = 0;
		
        if(isset($_GET['Expenses']))
		{
            $model->attributes=$_GET['Expenses'];
			
			$criteria = new CDbCriteria();
			$criteria->select = 'SUM(amount) as total';
			$criteria->condition = 'user = :user_id';
			if (!empty($model->type)) $criteria->addCondition('type = '.$model->type);
			if (!empty($model->date)) $criteria->addCondition('date >= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 00:00:01', $model->date).'"');
			if (!empty($model->endDate)) $criteria->addCondition('date <= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', $model->endDate).'"');
			$criteria->params = array(
				':user_id'=>Yii::app()->user->id
			);
			
			$totalAmount = Expenses::model()->find($criteria)->total;
		}
		else {
			$totalAmount = Expenses::model()->find(array(
				'select'=>'SUM(amount) as total',
				'condition' => 'user = :user_id',
					'params' => array(
						':user_id'=>Yii::app()->user->id
					)
				)
			)->total;
		}
		
		$this->render('index',array(
			'model'=>$model,
			'totalAmount'=>$totalAmount,
			'types'=>Type::model()->findAll()
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
		$model = Expenses::model()->findAll(array(
			'condition'=>'t.user = :user_id',
			'params'=>array(
				':user_id'=>Yii::app()->user->id
			),
		));
		
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
		
		$dataProvider = new CActiveDataProvider('Expenses',array(
			'criteria'=>array(
				'condition'=>'t.user = :user_id',
				'params'=>array(
					':user_id'=>Yii::app()->user->id
				)
			)
		));
		$html = $this->renderPartial('//expenses/reports/expenseGridtoReport', array(
			'dataProvider'=>$dataProvider
		), true);
		
		//die($html);
		
		$pdf = new TCPDF();
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Jackfiallos');
		$pdf->SetTitle('Example Report');
		$pdf->SetSubject('Example Subject Report');
		//$pdf->SetKeywords('example, text, report');
		$pdf->SetHeaderData('', 0, "Example Report", '');
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Example Report by Jackfiallos", "");
		$pdf->setHeaderFont(Array('helvetica', '', 8));
		$pdf->setFooterFont(Array('helvetica', '', 6));
		$pdf->SetMargins(15, 18, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->SetFont('dejavusans', '', 7);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->LastPage();
		$pdf->Output("example_002.pdf", "I");
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Expenses::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='expenses-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
