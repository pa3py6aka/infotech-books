<?php

declare(strict_types=1);

use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои книги';
?>
<div class="books-index">
    <a href="<?= Url::to(['/books/add']); ?>" class="btn btn-primary mb-3 d-block">Добавить книгу</a>
    <div class="d-block">
        <?php echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_card',
            'layout' => '{summary}<div class="d-flex p-2 flex-wrap">{items}</div>{pager}',
        ]); ?>
    </div>
</div>
