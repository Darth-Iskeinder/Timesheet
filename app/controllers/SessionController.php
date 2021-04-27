<?php

/**
 * Class SessionController
 */
class SessionController extends ControllerBase
{
    /**
     * Start login page
     */
    public function loginAction()
    {

    }

    /**
     * Register new session
     * @param $user
     */
    public function registerSession($user)
    {
        $this->session->set('auth', array(
            'id'    => $user->getId(),
            'role'  => $user->getRole()
        ));
    }

    /**
     * User authorization action
     * Check user credentials
     */
    public function authorizeAction()
    {
        if($this->request->isPost()){
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $user = Users::findFirst([
                "conditions" => "email = ?0",
                "bind" => [
                    $email,
                ]
            ]);
            if($user !== false){
                if($user->getPassword() === sha1($password)){
                    if($user->getActive() == 'N'){
                        $this->flash->error("User Deactivate");
                        $this->dispatcher->forward([
                            'action' => 'login'
                        ]);
                    }
                    $this->registerSession($user);
                    $this->flash->success("Welcome back \"{$user->getName()}\"");

                    if($user->getRole() === 'admin'){

                        return $this->dispatcher->forward([
                            'controller' => 'user',
                            'action' => 'index'
                        ]);
                    }

                    return $this->response->redirect('timesheet');
                }
            }
            $this->flash->error('Wrong email/password');
        }
        $this->dispatcher->forward([
            'action' => 'login'
        ]);
    }

    /**
     * Logout user
     */
    public function logoutAction()
    {
        $this->session->destroy();
        $this->dispatcher->forward([
            'action' => 'login'
        ]);
    }
}