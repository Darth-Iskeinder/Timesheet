<?php

use Phalcon\Forms\Element\AbstractElement;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;


class   UserForm extends Form
{
    /**
     * Initialize the user form
     *
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, $options = null)
    {
        // In edition the id is hidden
        if (isset($options['edit'])) {
            $this->add(new Hidden('id'));
        }
        /**
         * Name text field
         */
        $name = new Text('name');
        $name->setLabel('Your Full Name');
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf(['message' => 'Name is required']),
        ]);

        $this->add($name);

        /**
         * Email text field
         */
        $email = new Text('email');
        $email->setLabel('E-mail');
        $email->setFilters('email');
        $email->addValidators([
            new PresenceOf(['message' => 'E-mail is required']),
            new Email(['message' => 'E-mail is not valid']),
        ]);

        $this->add($email);

        /**
         * Active text field
         */
        $active = new Select(
            'active',
            [
                'Y' => "Y",
                'N' => "N"
            ]
        );
        $active->setLabel('Active');
        $active->addValidators([
            new PresenceOf(['message' => 'Active is required']),
        ]);

        $this->add($active);

        /**
         * Role text field
         */
        $role = new Select(
            'role',
            [
                'user' => 'user',
                'admin' => 'admin'
            ]
        );
        $role->setLabel('role');
        $role->addValidators([
            new PresenceOf(['message' => 'Role is required']),
        ]);

        $this->add($role);

        /**
         * Password field
         */
        $password = new Password('password');
        $password->setLabel('Password');
        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
        ]);

        $this->add($password);
    }
}