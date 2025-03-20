<?php

declare(strict_types=1);

namespace app\controllers;

use Book\Entity\Book;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex(): string
    {
        $last_books_data_provider = new ActiveDataProvider([
            'query' => Book::find()->orderBy(sprintf('%s DESC', Book::ATTR_CREATED_AT)),
        ]);

        return $this->render('index', ['last_books_data_provider' => $last_books_data_provider]);
    }
}
