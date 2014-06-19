<?php

/**
  UserGroupDeals is a widget used to display a all deals of a user at backend
 */
class Services extends CWidget
{

    // public $user_id;

    public $serviceDataProvider;
    public $id;

    public function init()
    {
        //echo $id;
        //$this->user_id=Yii:app()->user->id;
        //  $this->category=Categories::model()->findbyPk($this->cat_id);

        $this->serviceDataProvider = new CActiveDataProvider('Service', array(
                    'pagination' => array(
                    //'pageSize'=>5,
                    ),
                    'criteria' => array(
                        'order' => 't.id desc',
                        'scopes' => array('front'),
                        'condition' => 'qty-qty_ordered>0 and t_id=:t_id',
                        'params' => array(
                            ':t_id' => $this->id,
                        ),
                    ),
                ));
    }

    public function run()
    {
        $this->render('services');
    }

}

?>
