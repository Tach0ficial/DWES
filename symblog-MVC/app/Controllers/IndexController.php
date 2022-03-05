<?php
namespace App\Controllers;
use App\Models\Blog;
use App\Models\Comment;
class IndexController extends BaseController{
    public function homeAction() {
        $blog = Blog::all();
        $comment=Comment::all();
        return $this->renderHTML("Page/home.html.twig", [ "blogs"=>$blog], ["latestComments"=>$comment] );
    }
    public function aboutAction(){
        return $this->renderHTML("Page/about.html.twig");
    }
    public function contactAction(){
        return $this->renderHTML("Page/contact.html.twig");
    }

    public function showAction($request){
        $getData=$request->getParsedBody();
        var_dump($getData["id"]);
        $blog=Blog::find($getData["id"]);
        return $this->renderHTML("Page/show.html.twig", [ "blogs"=>$blog]);
    }

}
