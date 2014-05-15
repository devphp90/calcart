<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'expenses':
 */
class Order extends CActiveRecord
{

    public $total;
    public $endDate;
    public $file;
    public $fPhone;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Expenses the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('first_name,last_name,phone,email', 'required'),
            array('first_name,last_name,email,phone,date,service_name,service_description,service_price', 'safe'),
            array('email', 'email'),
            array('comment, provider_notes', 'safe'),
            array('file', 'file',
                'types' => 'jpg, gif, png, bmp, jpeg,doc,docx,ppt,pptx,xls,xlsx,pdf,txt,rtf,zip,rar,7z',
                'maxSize' => 1024 * 1024 * 10, // 10MB
                'tooLarge' => 'The file was larger than 10MB. Please upload a smaller file.',
                'allowEmpty' => true
            ),
            array('file', 'unsafe'),
            array('date', 'date', 'format' => 'yyyy-M-d'),
            //array('phone','numerical'),
            array('phone', 'length', 'max' => 12),
            //array('type, user', 'numerical', 'integerOnly'=>true),
            //array('binaryfile', 'unsafe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('first_name,last_name,email,date,endDate', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'orderBlobs' => array(self::HAS_MANY, 'OrderBlob', 'od_id'),
            'service' => array(self::BELONGS_TO, 'Service', 'sv_id'),
                //'types' => array(self::BELONGS_TO, 'Type', 'type'),
                //'user' => array(self::BELONGS_TO, 'User', 'user'),
                //'totalAmount' => array(self::STAT, 'Expenses', 'id', 'select' => 'SUM(amount)')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'date' => 'Date Ordered',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        );
    }

    public function beforeSave()
    {
        $this->t_id = $this->service->t_id;
        return true;
    }

    public function afterSave()
    {
        $this->service->qty_ordered += 1;
        if (!$this->service->save())
            return false;

        return true;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;


        $tenant = Tenant::model()->findByPk(Yii::app()->user->id);
        if ($tenant != null) {
            if ($tenant->isadmin == 0) {
                $criteria->compare('t.t_id', $tenant->id);
            }
        }

        $criteria->compare('first_name', $this->first_name);
        $criteria->compare('last_name', $this->first_name);
        $criteria->compare('email', $this->first_name);
        //$criteria->defaultOrder = 'date';

        if (!empty($this->date))
            $criteria->addCondition('`t`.date >= "' . Yii::app()->dateFormatter->format('yyyy-MM-dd 00:00:01', $this->date) . '"');
        if (!empty($this->endDate))
            $criteria->addCondition('`t`.date <= "' . Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', $this->endDate) . '"');


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => array(
                        'defaultOrder' => '`t`.date DESC',
                    ),
                ));
    }

    public function afterFind()
    {
        $this->fPhone = substr($this->phone, 0, 3) . '-' . substr($this->phone, 3, 3) . '-' . substr($this->phone, 6);
        return true;
    }

    /*
      public function getConfirmationMailToUser()
      {
      $mail="
      Dear ".$model->first_name.",
      This mail is a confirm that you have ordered the below services,
      ".$this->getServiceList()."
      Thanx&Regards,<br/>
      CalCart
      ";
      return($mail);

      }
     */
    /*
      public function getConfirmationMailToAdmin()
      {
      $mail="
      Dear Admin,<br/>
      This mail is a confirm that the user ".$model->first_name." has ordered the below services,
      ".$this->getServiceList()."
      Thanx&Regards,<br/>
      CalCart
      ";
      return($mail);

      }
     */

    public function getServiceList()
    {
        $session = new CHttpSession; //making session object
        $session->open();
        $services = "<ol>";
        $cart = $session['cart'];
        $cart = $this->duplicate_elimination($cart);
        foreach ($cart as $c) {
            $model = Service::model()->findbyPk($c);
            $services.="<li>" . $model->name . "-" . Yii::app()->NumberFormatter->formatCurrency(CHtml::encode($model->price), 'USD') . "</li>";
        }
        $services.="</ol>";
        return($services);
    }

    function duplicate_elimination($arr)
    {
        for ($i = 0; $i < sizeof($arr); $i++) {
            for ($j = $i + 1; $j < sizeof($arr); $j++) {
                if ($arr[$i] == $arr[$j] && $arr[$i] != "" && $arr[$j] != "") {
                    // echo "Going to delete:".$arr['word'][$j]."<br/>";
                    unset($arr[$j]);
                }
            }
        }

        return($arr);
    }

}
