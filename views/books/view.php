<?php

declare(strict_types=1);

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var \Book\Entity\Book $book */

$this->title = $book->getTitle();
$user = Yii::$app->user->identity;
?>
<div class="book-view">
    <h3 class="display-6"><?= $book->getTitle() ?></h3>
    <div class="d-flex flex-row">
        <div>
            <img src="<?= Url::to(['/image/show', 'i' => $book->getImageUrl()]) ?>" width="20%">
        </div>
        <div>
            <div class="d-flex flex-column">
                <ul>
                    <li>Автор: <?= $book->author->getUsername() ?></li>
                    <li>ISBN: <?= $book->getIsbn() ?></li>
                    <li>Дата публикации: <?= Yii::$app->formatter->asDate($book->getPublishedAt()) ?></li>
                </ul>
                <div class="m-3">
                    <?= $book->getDescription() ?>
                </div>
                <div>
                    <?php if (
                        $user !== null
                        && array_key_exists($book->author->getId(), $user->subscribedAuthors)
                    ): ?>
                        <a href="<?= Url::to(['/subscribe/subscribe', 'value' => false, 'author_id' => $book->author->getId()]) ?>" class="btn btn-danger">
                            Отписаться от автора
                        </a>
                    <?php else: ?>
                        <a href="<?= Url::to(['/subscribe/subscribe', 'value' => true, 'author_id' => $book->author->getId()]) ?>" class="btn btn-success">
                            Подписаться на автора
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
