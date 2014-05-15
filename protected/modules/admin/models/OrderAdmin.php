<?php

class OrderAdmin extends Order{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Expenses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		if($this->isNewRecord)
			$this->t_id = Yii::app()->user->id;
		return true;
	}
	public function afterSave(){
		
		return true;
	}
	
}

?>