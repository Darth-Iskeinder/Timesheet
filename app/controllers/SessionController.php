<?php

use Phalcon\Forms\Form;

class SessionController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function loginAction()
    {

    }

    public function registerSession($user)
    {
        $this->session->set('auth', array(
            'id'    => $user->getId(),
            'role'  => $user->getRole()
        ));
    }

    public function authorizeAction()
    {
        if($this->request->isPost()){

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = Users::findFirst([
                "conditions" => "email = ?0 AND password = ?1",
                "bind" => [
                    0 => $email,
                    1 => sha1($password)
                ]
            ]);


            if($user !== false){

                if($user->getActive() == 'N'){

                    $this->flash->error("User Deactivate");
                    return $this->response->redirect('session/login');
                }
                $this->registerSession($user);
                $this->flash->success("Welcome back " . $user->getName());
                if($user->getRole() === 'admin'){
                    return $this->response->redirect('user/index');
                }

                return $this->response->redirect('timesheet/index');
            }

            $this->flash->error('Wrong email/password');

        }
        return $this->response->redirect('session/login');


    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect('session/login');
    }
}