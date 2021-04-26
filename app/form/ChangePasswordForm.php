<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;

class ChangePasswordForm extends Form
{
    public function initialize()
    {
        // Old Password
        $oldPassword = new Password('oldPassword');

        $oldPassword->setLabel('Old Password');

        $oldPassword->addValidators([
            new PresenceOf([
                'message' => 'Password is required'
            ]),
            new StringLength([
                'min' => 3,
                'messageMinimum' => 'Password is too short. Minimum 3 characters'
            ]),
            new Confirmation([
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ])
        ]);

        $this->add($oldPassword);

        // Password
        $password = new Password('password');

        $password->setLabel('Password');

        $password->addValidators([
            new PresenceOf([
                'message' => 'Password is required'
            ]),
            new StringLength([
                'min' => 3,
                'messageMinimum' => 'Password is too short. Minimum 3 characters'
            ]),
            new Confirmation([
                'message' => 'Password doesn\'t match confirmation',
                'with' => 'confirmPassword'
            ])
        ]);

        $this->add($password);

        // Confirm Password
        $confirmPassword = new Password('confirmPassword');

        $confirmPassword->setLabel('Confirm Password');

        $confirmPassword->addValidators([
            new PresenceOf([
                'message' => 'The confirmation password is required'
            ])
        ]);

        $this->add($confirmPassword);
    }
}
