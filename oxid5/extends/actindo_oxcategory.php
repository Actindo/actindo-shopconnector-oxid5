<?php

require_once getShopBasePath() . 'application/models/oxcategory.php';

class actindo_oxCategory extends oxCategory
{
    public function __construct()
    {
      parent::__construct();
      $this->setEnableMultilang( FALSE );
    }
}


?>