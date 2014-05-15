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
class Expenses extends CActiveRecord
{
	public $total;
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
		return 'expenses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, type, amount', 'required'),
			array('binaryfile', 'file', 
				'types'=>'jpg, gif, png, bmp, jpeg',
				'maxSize'=>1024 * 1024 * 10, // 10MB
                'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
				'allowEmpty' => true
			),
			array('date, description, type, amount, fileName, fileType', 'safe'),
			array('type, user', 'numerical', 'integerOnly'=>true),
			//array('binaryfile', 'unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, description, type, endDate', 'safe', 'on'=>'search'),
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
			'types' => array(self::BELONGS_TO, 'Type', 'type'),
			'user' => array(self::BELONGS_TO, 'User', 'user'),
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
			'date' => 'Date',
			'description' => 'Description',
			'type'=>'Type',
			'binaryfile'=>'Image File',
			'amount'=>'Amount',
			'fileName'=>'File Name',
			'fileType'=>'File Type',
			'user'=>'Owner',
			'total'=>'Total',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type);
		$criteria->compare('user', Yii::app()->user->id);
		if (!empty($this->date)) $criteria->addCondition('date >= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 00:00:01', $this->date).'"');
		if (!empty($this->endDate)) $criteria->addCondition('date <= "'.Yii::app()->dateFormatter->format('yyyy-MM-dd 23:59:59', $this->endDate).'"');
		
		$criteria->with = array('types');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}