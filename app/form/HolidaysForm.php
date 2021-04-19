<?php

use Phalcon\Forms\Element\AbstractElement;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Text;

class HolidaysForm extends Form
{
    /**
     * Initialize the holiday form
     */
    public function initialize()
    {
        /**
         * Name text field
         */
        $name = new Text('name');
        $name->setLabel('Name of holiday');
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf(['message' => 'Name is required']),
        ]);

        $this->add($name);

        /**
         * Date text field
         */
        $date = new Text('date');
        $date->setLabel('Date');
        $date->setFilters('Date');
        $date->addValidators([
            new PresenceOf(['message' => 'Date is required']),
        ]);

        $this->add($date);

    }

}