<?php

declare(strict_types=1);

use Book\Forms\BookForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var BookForm $model */
/** @var bool $is_create */

$form = ActiveForm::begin([
    'id' => 'book-form',
    'fieldConfig' => [
        'template' => "{label}\n{input}\n{error}",
        'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
        'inputOptions' => ['class' => 'col-lg-3 form-control'],
        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
    ],
]); ?>

<?= $form->field($model, BookForm::FIELD_TITLE)->textInput(['autofocus' => true]) ?>

<?= $form->field($model, BookForm::FIELD_DESCRIPTION)->textarea() ?>

<?= $form->field($model, BookForm::FIELD_ISBN)->textInput() ?>

<?php // Здесь ещё нужно добавить какой-нибудь datepicker, или ввод по маске ?>
<?= $form->field($model, BookForm::FIELD_PUBLISHED_AT)->textInput(['placeholder' => 'ДД.ММ.ГГГГ']) ?>

<?php // Здесь заменить на нормальный виджет для выбора файла, в раках тестового задания не стал делать, времени не хватает ?>
<?= $form->field($model, BookForm::FIELD_IMAGE)->fileInput() ?>

<div class="form-group">
    <div>
        <?php echo Html::submitButton(
                $is_create ? 'Создать' : 'Обновить',
                ['class' => 'btn btn-primary', 'name' => 'login-button']
        ) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
