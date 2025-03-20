<?php

declare(strict_types=1);

namespace Common\Widgets;

use User\Repository\UserRepository;
use yii\base\Widget;

class BestAuthorsWidget extends Widget
{
    public const string PARAM_YEAR = 'year';

    public string $year = '';

    public function __construct(private UserRepository $repository, $config = [])
    {
        parent::__construct($config);
    }

    public function run(): string
    {
        $top_authors = $this->repository->getTopAuthors($this->year);

        return $this->render('top-authors', [
            'authors' => $top_authors,
            'user' => \Yii::$app->user->identity,
        ]);
    }
}
