<?php

use Phalcon\Forms\Element\AbstractElement;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Text;

class StartDayTimeForm extends Form
{
    /**
     * Initialize the Start day time form
     */
    public function initialize()
    {

        /**
         * StartDayTime text field
         */
        $date = new Text('time');
        $date->setLabel('Start day time');
        $date->setFilters('time');
        $date->addValidators([
            new PresenceOf(['message' => 'Time is required']),
        ]);

        $this->add($date);

    }

}