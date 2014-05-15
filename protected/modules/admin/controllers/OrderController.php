<?php

class OrderController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column1';
    public $layout = 'main';

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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'loadBlob'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'loadImage', 'GeneratePdf', 'GenerateExcel', 'delete', 'blobDel'),
                'users' => array('@'),
            ),
            /* array('allow', // allow admin user to perform 'admin' and 'delete' actions
              'actions'=>array('admin','delete'),
              'users'=>array('admin'),
              ), */
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        ini_set('display_errors', 1);
        $model = new OrderAdmin;
        //$file = null;
        $model->date = date('Y-m-d', time());
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrderAdmin'])) {
            $model->attributes = $_POST['OrderAdmin'];
//                        $model->date=date('Y-m-d H:i:s',time());
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        ini_set('display_errors', 1);
        $model = $this->loadModelAdmin($id);
        $model->date = Yii::app()->dateFormatter->format("yyyy-MM-dd", $model->date);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['OrderAdmin'])) {
            $model->attributes = $_POST['OrderAdmin'];

            if (!empty($_FILES['OrderAdmin']['tmp_name']['file'])) {
                $file = CUploadedFile::getInstance($model, 'file');

                $orderBlobModel = new OrderBlob;
                $orderBlobModel->od_id = $model->id;
                $orderBlobModel->name = $file->name;
                $orderBlobModel->type = $file->type;
                $orderBlobModel->blob = file_get_contents($file->tempName);
                if (!$orderBlobModel->save())
                    exit;
            }
            $model->last_update = date('Y-m-d H:i:s', time());
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
        $orderBlobModel = OrderBlob::model()->find('od_id=?', array($id));
        //var_dump($orderBlobModel);
        $this->render('update', array(
            'model' => $model,
            'orderBlobModel' => $model->orderBlobs,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex($tid = null)
    {
        $model = new Order('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionloadImage($id)
    {
        $model = $this->loadModel($id);
        $this->renderPartial('image', array(
            'model' => $model
        ));
    }

    public function actionGenerateExcel()
    {
        $model = Order::model()->findAll();

        Yii::app()->request->sendFile(date('YmdHis') . '.xls', $this->renderPartial('reports/excelReport', array(
                    'model' => $model
                        ), true)
        );
    }

    public function actionGeneratePdf()
    {
        Yii::import('application.vendors.*');
        require_once('tcpdf/tcpdf.php');
        require_once('tcpdf/config/lang/eng.php');

        $dataProvider = new CActiveDataProvider('Order');
        $html = $this->renderPartial('/order/reports/expenseGridtoReport', array(
            'dataProvider' => $dataProvider
                ), true);

        //die($html);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AXEO');
        $pdf->SetTitle('Orders');
        $pdf->SetSubject('Order Report');
        //$pdf->SetKeywords('example, text, report');
        $pdf->SetHeaderData('', 0, "Example Report", '');
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Example Report by AXEO CalCart", "");
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
        $pdf->Output("order_002.pdf", "I");
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Order::model()->findByPk($id);
        if ($model === null || ($model->service->t_id != Yii::app()->user->id && $model->t_id != Yii::app()->user->id))
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadModelAdmin($id)
    {
        $model = OrderAdmin::model()->findByPk($id);
        if ($model === null || ($model->service->t_id != Yii::app()->user->id && $model->t_id != Yii::app()->user->id))
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionBlobDel($od_id, $id)
    {

        // we only allow deletion via POST request
        $model = OrderBlob::model()->findbyPk($id);
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('order/update', 'id' => $od_id));
    }

    public function actionLoadBlob($id)
    {
        $model = OrderBlob::model()->findbyPk($id);
        header('Content-Type: ' . $model->type);
        header("Content-length: " . strlen($model->blob));
        header('Content-Disposition: inline; filename="' . $model->name . '"');



        $this->renderPartial('file', array(
            'blob' => $model->blob
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
