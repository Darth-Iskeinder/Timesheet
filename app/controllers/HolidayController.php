<?php

/**
 * Class HolidayController
 */
class HolidayController extends ControllerBase
{
    /**
     * Create day for holiday
     */
    public function createAction()
    {
        $form = new HolidaysForm();
        if ($this->request->isPost()) {
            $holiday = new Holidays();
            $holiday->setName($this->request->getPost('name'));
            $holiday->setDate($this->request->getPost('date'));
            if (!$holiday->save()) {
                $this->flash->error('Holiday date was not saved');
            } else {
                $this->flash->success("Holiday was created successfully");
                $form->clear();
            }
        }
        $this->view->form = $form;
    }
}