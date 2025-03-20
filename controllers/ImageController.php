<?php

declare(strict_types=1);

namespace app\controllers;

use Common\Service\IFileService;
use yii\web\Controller;
use yii\web\Response;

class ImageController extends Controller
{
    public function __construct($id, $module, private IFileService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    // Наверное лучше так не делать, а сделать чтобы ссылка на изображение была прямая(например, настроить nginx на работу с папкой с картинками)
    public function actionShow(): Response
    {
        $filepath = $this->service->getImagePath(\Yii::$app->request->get('i'));
        return \Yii::$app->response->sendFile($filepath);
    }
}
