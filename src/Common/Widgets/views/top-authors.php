<?php

declare(strict_types=1);

use User\Entity\User;
use yii\helpers\Url;

/** @var User[] $authors */
/** @var ?User $user */

?>
<div class="d-flex">
    <?php foreach ($authors as $author): ?>
        <div class="card text-bg-primary m-2" style="max-width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $author->getUsername() ?></h5>
                <p class="card-text">
                    Опубликовано книг: <?php echo $author->books_count ?>
                </p>
                <?php if (
                    $user !== null
                    && array_key_exists($author->getId(), $user->subscribedAuthors)
                ): ?>
                    <a href="<?= Url::to(['/subscribe/subscribe', 'value' => false, 'author_id' => $author->getId()]) ?>" class="btn btn-danger">Отписаться</a>
                <?php elseif ($user?->getId() !== $author->getId()): ?>
                    <a href="<?= Url::to(['/subscribe/subscribe', 'value' => true, 'author_id' => $author->getId()]) ?>" class="btn btn-success">Подписаться</a>
                <?php endif; ?>
                <?php //todo: Клики на кнопки подписки/отписки лучше конечно сделать через ajax ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
