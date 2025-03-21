<?php

declare(strict_types=1);

namespace app\controllers;

use Book\Entity\Book;
use Book\Forms\BookForm;
use Book\Service\BookService;
use Psr\Log\LogLevel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

class BooksController extends Controller
{
    public function __construct($id, $module, private BookService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => static fn () => Yii::$app->response->redirect('/'),
                'only' => ['my', 'add', 'edit'],
                'rules' => [
                    [
                        'actions' => [
                            'my',
                            'add',
                            'edit',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView(int $id): string
    {
        $book = $this->service->getById($id);
        return $this->render('view', ['book' => $book]);
    }

    public function actionMy(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find()->where([Book::ATTR_AUTHOR_ID => \Yii::$app->user->getId()]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('my', ['dataProvider' => $dataProvider]);
    }

    public function actionAdd(): Response|string
    {
        $form = new BookForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->image = UploadedFile::getInstance($form, BookForm::FIELD_IMAGE);
                $this->service->create($form, Yii::$app->user->getId());
                Yii::$app->session->setFlash('success', 'Книга успешно добавлена.');
                return $this->redirect(Url::to(['/books/my']));
            } catch (\Throwable $exception) {
                Yii::$app->session->setFlash('error', 'Не удалось добавить книгу.');
                Yii::getLogger()->log($exception->getMessage(), LogLevel::ERROR);
                return $this->redirect(Url::to(['/books/add']));
            }
        }

        return $this->render('add', ['model' => $form]);
    }

    public function actionEdit(int $id): Response|string
    {
        $book = $this->service->getById($id);
        $form = new BookForm($book->getEditableAttributes());
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->image = UploadedFile::getInstance($form, BookForm::FIELD_IMAGE);
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Книга успешно отредактирована.');
                return $this->redirect(Url::to(['/books/my']));
            } catch (\Throwable $exception) {
                Yii::$app->session->setFlash('error', 'Не удалось добавить книгу.');
                Yii::getLogger()->log($exception->getMessage(), LogLevel::ERROR);
                return $this->redirect(Url::to(['/books/add']));
            }
        }

        return $this->render('edit', ['model' => $form]);
    }

    public function actionDelete(int $id): Response
    {
        if ($this->service->deleteBook($id)) {
            Yii::$app->session->setFlash('success', 'Книга успешно удалена.');
            return $this->goBack();
        }

        Yii::$app->session->setFlash('error', 'Не удалось удалить книгу.');
        return $this->goBack();
    }
}
