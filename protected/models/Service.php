<?php

/**
 * This is the model class for table "expenses".
 *
 * The followings are the available columns in table 'expenses':
 * @property integer $id
 * @property string $date
 * @property string $description
 * @property int type
 * @property blob binaryfile
 * @property double amount
 * @property string fileName
 * @property string fileType
 */
class Service extends CActiveRecord
{

	public $endDate;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Expenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('t_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('image,thumbnail', 'file',
				'types'=>'jpg, gif, png, bmp, jpeg',
				'maxSize'=>1024 * 1024 * 10, // 10MB
				'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
				'allowEmpty' => true
			),
			array('cat_id,name,description,image,thumbnail,date,last_update', 'safe'),
			array('qty_ordered,cat_id,active,qty', 'numerical', 'integerOnly'=>true),
			array('price','numerical'),
			//array('binaryfile', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,cat_id,name,description,price,qty,image,thumbnail,date,last_update', 'safe', 'on'=>'search'),
		);
	}

	public function scopes()
	{
		return array(
			'front'=>array(
				'condition'=>'active=1',
			),
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
			'cat_id' => 'Category',
			'name'=>'Service Name',
			'description' => 'Description',
			'price' => 'Price',
			'qty' => 'Capacity',
			'image' => 'Image',
			'thumbnail' => 'Thumbnail',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		/*$criteria->condition = 't_id=:t_id';
		$criteria->params = array(
			':t_id'=>Yii::app()->user->id,
		);
		$criteria->compare('id',$this->id);*/
        //if (isset($_GET['tid']) && $_GET['tid'] != '') {
        //    $criteria->compare('t_id', $_GET['tid']);
        //}
		$tenant = Tenant::model()->findByPk(Yii::app()->user->id);
		if($tenant!=null) {
			if($tenant->isadmin == 0) {
				$criteria->compare('t_id', $tenant->id);
			}
		}
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('name',$this->name, true);
		$criteria->compare('description',$this->description, true);
		$criteria->compare('price',$this->price);
		$criteria->compare('qty',$this->qty);

		if (!empty($this->date)) $criteria->addCondition('date >= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 00:00:01', $this->date).'"');
		if (!empty($this->endDate)) $criteria->addCondition('date <= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', $this->endDate).'"');

		//$criteria->with = array('types');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
	}
}
