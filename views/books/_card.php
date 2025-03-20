<?php

declare(strict_types=1);

use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var \Book\Entity\Book $model */

?>
<div class="card m-2" style="width: 18rem;">
    <img src="<?= Url::to(['/image/show', 'i' => $model->getImageUrl()]) ?>" class="card-img-top">
    <div class="card-body">
        <h5 class="card-title">
            <a href="<?= Url::to(['/books/view', 'id' => $model->getId()]) ?>">
                <?= $model->getTitle() ?>
            </a>
        </h5>
        <p class="card-text"><?= $model->getDescription() ?></p>
    </div>
    <?php if (Yii::$app->user->getId() === $model->getAuthorId()): ?>
        <div class="card-body">
            <a href="<?= Url::to(['/books/edit', 'id' => $model->getId()]) ?>" class="btn btn-sm btn-primary">Редактировать</a>
            <a href="<?= Url::to(['/books/delete', 'id' => $model->getId()]) ?>" class="btn btn-sm btn-danger">Удалить</a>
        </div>
    <?php endif; ?>
</div>
