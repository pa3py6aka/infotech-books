<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\widgets\ListView;

$this->title = 'Книги';
?>
<div class="books-index">
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_card',
        'layout' => '{summary}<div class="d-flex p-2 flex-wrap">{items}</div>{pager}',
    ]); ?>
</div>
