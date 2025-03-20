<?php

declare(strict_types=1);

namespace app\controllers;

use User\Service\SubscribeService;
use Yii;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\Response;

class SubscribeController extends Controller
{
    public function __construct($id, $module, private SubscribeService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionSubscribe(bool $value, int $author_id): Response
    {
        try {
            $this->service->switchAuthorSubscription(\Yii::$app->user->getId(), $value, $author_id);
            $message = $value ? 'Вы успешно подписались на автора!' : 'Вы отписались от автора:(';
            Yii::$app->session->setFlash('success', $message);
        } catch (\Exception $exception) {
            Yii::$app->session->setFlash('error', 'Внутренняя ошибка сервера');
            Yii::getLogger()->log($exception->getMessage(), Logger::LEVEL_ERROR);
        } finally {
            return $this->goBack();
        }
    }
}
