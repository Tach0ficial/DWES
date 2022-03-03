<?php
namespace App\Controllers;
use App\Models\Blog;
class IndexController extends BaseController{
    public function homeAction() {
        $blogs = Blog::all();
        return $this->renderHTML('Page/home.html.twig',compact('blogs'));
    }
}
