<?php
namespace App\Controllers;
use App\Models\Blog;
class BlogController extends BaseController{
    public function blogAction($request) {
        $uri = explode('/', $request->getRequestTarget());
        $id = end($uri);
        $blog = Blog::find($id);
        $comments = $blog::find($id)->comments;
        return $this->renderHTML('blog.html.twig',[
            'blog'=>$blog,
            'comments'=>$comments
        ]);
    }
}
