<?php

declare(strict_types=1);

namespace Common\Forms\Auth;

use User\Entity\User;
use User\Repository\UserRepository;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    private ?User $user = null;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if (parent::validate($attributeNames, $clearErrors)) {
            $user = $this->getUser();
            if ($user === null || $user->validatePassword($this->password) === false) {
                $this->addError('password', 'Wrong email or/and password');
            }
        }
        return $this->hasErrors() === false;
    }

    public function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = Yii::$container->get(UserRepository::class)->getByEmail($this->email);
        }

        return $this->user;
    }
}
