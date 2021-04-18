<?php

use Phalcon\Forms\Form;
use Phalcon\Mvc\Model;

class UserController extends ControllerBase
{
    public function indexAction()
    {
        $currentDate = new DateTime();
        $this->view->year = $currentDate->format('Y');
        $this->view->month = $currentDate->format('m');
        $this->view->day = $currentDate->format('d');
        $users = Users::find();
        $this->view->users = $users;
        $userTime = WorkTime::find();
        $this->view->userTime = $userTime;

    }

    public function createAction()
    {
        $form = new UserForm();

        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                foreach ($form->getMessages() as $message){
                    $this->flash->error($message);
                }
            } else {
                $user = new Users();

                $user->setName($this->request->getPost('name'));
                $user->setEmail($this->request->getPost('email'));
                $user->setActive($this->request->getPost('active'));
                $user->setRole($this->request->getPost('role'));
                $user->setPassword(sha1($this->request->getPost('password')));

                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {
                    $this->flash->success("User was created successfully");

                    $form->clear();
                }
            }

        }
        $this->view->form = $form;

    }

    public function updateAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('Product was not found');

            $this->dispatcher->forward([
                'controller' => 'products',
                'action'     => 'index',
            ]);

            return;
        }

        $this->view->form = new UserForm($user, ['edit' => true]);

    }

    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->response->redirect('user/index');
        }
        $id = $this->request->getPost('id');
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found');

            $this->dispatcher->forward([
                'controller' => 'user',
                'action'     => 'index',
            ]);

            return;
        }
        $form = new UserForm();
        $this->view->form = $form;
        $data = $this->request->getPost();
        if (!$form->isValid($data, $user)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'user',
                'action'     => 'update',
                'params'     => [$id],
            ]);

            return;
        }
        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'user',
                'action'     => 'update',
                'params'     => [$id],
            ]);

            return;
        }
        $form->clear();
        $this->flash->success('User was updated successfully');

        $this->dispatcher->forward([
            'controller' => 'user',
            'action'     => 'index',
        ]);

    }

    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found');

            $this->dispatcher->forward([
                'controller' => 'user',
                'action'     => 'index',
            ]);

            return;
        }
        $user->setActive('N');
        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => 'user',
                'action'     => 'index',
            ]);

            return;
        }
        $this->flash->success($user->getName() .' '.'was deactivated');

        $this->dispatcher->forward([
            'controller' => 'user',
            'action'     => 'index',
        ]);


    }

    public function changePasswordAction()
    {
        $form = new ChangePasswordForm();

        if ($this->request->isPost()) {
            if (!$form->isValid($this->request->getPost())) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {
                $auth = $this->session->get('auth');
                $user = Users::findFirstById($auth['id']);

                $user->setPassword(sha1($this->request->getPost('password')));;

                if (!$user->save()) {
                    $this->flash->error($user->getMessages());
                } else {
                    $this->flash->success('Your password was successfully changed');

                    $form->clear();
                }
            }
        }

        $this->view->form = $form;
    }


}