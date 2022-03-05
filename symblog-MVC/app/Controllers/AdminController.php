<?php
namespace App\Controllers;
use App\Models\Admin;
use App\Controllers\BaseController;

class AdminController extends BaseController{
    public function getIndex(){
        return $this->renderHTML("Page/admin.html.twig");
    }
}

?>