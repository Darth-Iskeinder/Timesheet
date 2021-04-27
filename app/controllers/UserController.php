<?php

/**
 * Class UserController
 */
class UserController extends ControllerBase
{
    /**
     *List of users for admin
     */
    public function indexAction()
    {
        $users = Users::find();
        $userTime = WorkTime::find();
        $this->view->setVars(
            [
                'year' => $this->getCurrentDateTime()->format('Y'),
                'month' => $this->getCurrentDateTime()->format('m'),
                'day' => $this->getCurrentDateTime()->format('d'),
                'users'    => $users,
                'userTime'    => $userTime,
            ]
        );
    }

    /**
     * Create new user
     */
    public function createAction()
    {
        $form = new UserForm();
        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                $this->flash->error('UserForm is not valid!');
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

    /**
     * Update user by id
     * @param int $id
     */
    public function updateAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('Product was not found');
            $this->response->redirect('/user');
        }
        $this->view->form = new UserForm($user, ['edit' => true]);
    }

    /**
     * Save updated user
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->response->redirect('/user');
        }
        $id = $this->request->getPost('id');
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found');
            $this->response->redirect('/user');
        }
        $form = new UserForm();
        $this->view->form = $form;
        $data = $this->request->getPost();
        if (!$form->isValid($data, $user)) {
            $this->flash->error('UserForm is not valid!');
            $this->dispatcher->forward([
                'action'     => 'update',
                'params'     => $id,
            ]);
        }
        if (!$user->save()) {
            $this->flash->error('User was not saved!');

            $this->dispatcher->forward([
                'action'     => 'update',
                'params'     => [$id],
            ]);
        }
        $form->clear();
        $this->flash->success('User was updated successfully');
        $this->response->redirect('/user');
    }

    /**
     * Deactivate user
     * @param int $id
     */
    public function deleteAction($id)
    {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error('User was not found');
            $this->response->redirect('/user');
        }
        $user->setActive('N');
        if (!$user->save()) {
            $this->flash->error('User active field not changed');
            $this->response->redirect('/user');
        }
        $this->flash->success("\"{$user->getName()}\" was deactivated");
        $this->response->redirect('/user');
    }
}