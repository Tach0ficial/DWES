<?php
namespace App\Controllers;
use App\Models\Blog;
use App\Controllers\BaseController;
use Respect\Validation\Validator as validator;


class BlogController extends BaseController{
    public function getAddBlogAction($request){
        
        $request->getBody();
        $request->getMethod();

        $responseMessage=null;
        if ($request->getMethod()=="POST") {
            $postData=$request->getParsedBody();

            $blogValidator=validator::key("title", validator::stringType()->notEmpty())
            ->key("blog", validator::stringType()->notEmpty());

            try{
            
                $blogValidator->assert($postData);
                $blog = new Blog();
                $blog->title = $postData['title'];
                $blog->blog = $postData['blog'];
                $blog->tags = $postData['tags'];
                $blog->author = $postData['author'];
            
                $files=$request->getUploadedFiles();
                $image=$files["image"];
               
                if($image->getError()==UPLOAD_ERR_OK){
                    $fileName=$image->getClientFilename();
                    $fileName=uniqid().$fileName;
                    $image->moveTo("img/$fileName");
                    $blog->image = $fileName;
                }
           
            $blog->save();
            $responseMessage="Saved";
        }catch(\Respect\Validation\Exceptions\ValidationException $e) {
            $responseMessage=$e->getMessage();

        }
            
        }

     return $this->renderHTML("Page/addBlog.html.twig", ["responseMessage"=>$responseMessage]);

    }
    
    public function showAction($request){
        $uri=explode('/',$request->getRequestTarget());
        $id=end($uri);
        $blog=Blog::find($id);
        $comments=Blog::find($id)->comments;
        return $this->renderHTML('Page/show.html.twig', [
            'blog' => $blog,
            'comments' => $comments
        ]);
    }
}
