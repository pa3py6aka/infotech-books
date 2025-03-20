<?php

declare(strict_types=1);

/** @var \Book\Forms\BookForm $model */
/** @var yii\web\View $this */

?>
<div class="books-add">
    <?php echo $this->render('_form', ['model' => $model, 'is_create' => true]); ?>
</div>
