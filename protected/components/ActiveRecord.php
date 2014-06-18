<?php

class ActiveRecord extends CActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;
    const STATUS_DELETED = 2;
    
    public function beforeSave()
    {
        $parent = parent::beforeSave();
                
        return $parent;
    }
}
