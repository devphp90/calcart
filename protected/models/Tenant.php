<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $isactive
 * @property string $creation_date
 * @property string $isadmin
 * @property string $confirm_key
 */
class Tenant extends CActiveRecord
{
	public $repeatPassword;
	public $fPhone;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'Tenant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email', 'required'),
			array('password', 'required', 'on'=>'create'),
			array('isactive, isadmin', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>8, 'min'=>5),
			array('password', 'length', 'max'=>8, 'min'=>5),
			array('email', 'length', 'max'=>45),
			array('username', 'unique'),
			array('confirm_key', 'length', 'max'=>50),
			array('isactive, isadmin','default','value'=>0),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, isactive, creation_date, isadmin, confirm_key', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'isactive' => 'Is Active',
			'creation_date' => 'Creation Date',
			'isadmin' => 'Is Administrator',
			'confirm_key' => 'Confirm Key',
			'fPhone'=>'Phone',
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
		$criteria->compare('username',$this->username,true);
		//$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('isactive',$this->isactive, true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('isadmin',$this->isadmin);
		//$criteria->compare('confirm_key',$this->confirm_key,true);

		$dataProvider = new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
		//var_dump(count($dataProvider->getData()));
		
		return $dataProvider;
	}
	
	public function afterFind()
	{
		$this->fPhone = substr($this->phone,0,3).'-'.substr($this->phone,3,3).'-'.substr($this->phone,6);
		return true;
	}
	public function findByEmail($email)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('email',$email);
		
		return Tenant::model()->find($criteria);
	}
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if ($this->isNewRecord)
				$this->password = md5($this->password);
			else 
			{				
				//$tenant = Tenant::model()->findByPk($this->id);
				//if(!empty($this->password))
				//	$this->password = md5($this->password);
				//else
				//	$this->password = $tenant->password;
			}
			return true;
		}
		return false;
	}

      
}
