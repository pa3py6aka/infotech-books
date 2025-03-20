<?php

declare(strict_types=1);

namespace app\commands;

use User\Service\UserService;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Команда для создания пользователей
 */
class UserController extends Controller
{
    public function __construct($id, $module, private UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate(): void
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $email = $this->prompt('Email:', ['required' => true]);
        $phone = $this->prompt('Телефон:', ['required' => true]);
        $password = $this->prompt('Пароль:', ['required' => true, 'validator' => function ($input, &$error) {
            if (strlen($input) < 6) {
                $error = 'Пароль должен быть не менее 6 символов';
                return false;
            }
            return true;
        }]);

        $user = $this->service->create($username, $email, $phone, $password);

        $this->stdout("Пользователь добавлен. ID: {$user->getId()}" . PHP_EOL, Console::FG_GREEN);
    }
}
