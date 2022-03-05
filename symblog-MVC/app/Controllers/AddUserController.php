<?php
namespace App\Controllers;
use App\Models\User;
use App\Controllers\BaseController;
use Respect\Validation\Validator as v;


class AddUserController extends BaseController{
    public function addAction($request){
        
        $request->getBody();
        $request->getMethod();
        

        $responseMessage=null;
        if ($request->getMethod()=="POST") {
            $postData=$request->getParsedBody();

                $user = new User();
                
                $user->email = $postData['email'];
                $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);

              $user->save();
            
        }

     return $this->renderHTML("Page/addUser.html.twig", ["responseMessage"=>$responseMessage]);

    }
}

?>