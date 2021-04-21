<?php


class HolidayController extends ControllerBase
{
    public function createAction()
    {
        $form = new HolidaysForm();
        if ($this->request->isPost()) {
            if($form->isValid($this->request->getPost()) == false){
                foreach ($form->getMessages() as $message){
                    $this->flash->error($message);
                }
            } else {
                $holiday = new Holidays();

                $holiday->setName($this->request->getPost('name'));
                $holiday->setDate($this->request->getPost('date'));

                if (!$holiday->save()) {
                    $this->flash->error($holiday->getMessages());
                } else {
                    $this->flash->success("Holiday was created successfully");

                    $form->clear();
                }
            }
        }
        $this->view->form = $form;
    }
}