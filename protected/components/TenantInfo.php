<?php

/**
  UserGroupDeals is a widget used to display a all deals of a user at backend
 */
class TenantInfo extends CWidget
{

    public $tenant_id;
    public $model;

    public function init()
    {
        $this->model = Tenant::model()->findbyPk($this->tenant_id);

        if ($this->model == null)
            throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function run()
    {
        $this->render('tenantInfo');
    }

}

?>
