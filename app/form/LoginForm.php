<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Email as EmailText;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\Identical;
use Phalcon\Forms\Element\Submit;

class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $email = new EmailText('email', [
            'placeholder' => 'Email',
            'required' => 'required'
        ]);
        $email->setLabel('Email');

        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required'
            ]),
            new Email([
                'message' => 'The e-mail is not valid'
            ])
        ]);

        $this->add($email);

        // Password
        $password = new Password('password', [
            'placeholder' => 'Password',
            'required' => 'required'
        ]);
        $password->setLabel('Password');

        $password->addValidator(new PresenceOf([
            'message' => 'The password is required'
        ]));

        $password->clear();

        $this->add($password);

        // CSRF
        $csrf = new Hidden('csrf');

        $csrf->addValidator(new Identical([
            'value' => $this->security->getSessionToken(),
            'message' => 'CSRF detect'
        ]));

        $csrf->clear();

        $this->add($csrf);

        $this->add(new Submit('go',[
            'value' => "Sign in"
        ]));

    }

}