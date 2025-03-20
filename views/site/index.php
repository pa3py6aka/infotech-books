<?php

declare(strict_types=1);

use Common\Widgets\BestAuthorsWidget;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $last_books_data_provider */

$this->title = 'Booker';
?>
<div class="site-index">
    <div class="jumbotron bg-transparent mt-3 mb-4">
        <h1 class="display-4">Booker</h1>
        <p class="lead">Лучшее место для книг</p>
    </div>

    <div class="body-content">
        <div class="row">
            <h3>Последние публикации</h3>
            <?php echo ListView::widget([
                'dataProvider' => $last_books_data_provider,
                'itemView' => '/books/_card',
                'layout' => '{summary}<div class="d-flex p-2 flex-wrap">{items}</div>{pager}',
            ]); ?>
        </div>

        <div class="row">
            <h3>Топ авторов за всё время</h3>
            <?php echo BestAuthorsWidget::widget() ?>
        </div>

        <div class="row">
            <h3>Топ авторов за прошедший год</h3>
            <?php echo BestAuthorsWidget::widget([
                BestAuthorsWidget::PARAM_YEAR => (new DateTime())->sub(new DateInterval('P1Y'))->format('Y'),
            ]) ?>
        </div>
    </div>
</div>
