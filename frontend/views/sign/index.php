<?php
$this->title = 'Регистрация аккаунта';
$cities = $signForm->getCities();
$this->params['sign'] = true;

use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Url;

?>

<div class="main-container page-container">
    <section class="registration__user">
        <h1>Регистрация аккаунта</h1>
        <div class="registration-wrapper">
            <?php $form = ActiveForm::begin([
                'id' => 'sign',
                'method' => 'post',
                'options' => ['class' => 'registration__user-form form-create'],
                'validationStateOn' => 'input',
                'errorCssClass' => 'input-danger',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'options' => ['style' => 'margin-bottom: 27px'],
                    'inputOptions' => [
                        'class' => 'input textarea',
                        'style' => 'width: 328px; margin-top: 12px; margin-bottom: 0px;',
                    ],
                    'errorOptions' => ['tag' => 'span'],
                    'labelOptions' => ['class' => null],
                ]]) ?>

            <?= $form->field($signForm, "email", [
                'inputOptions' => [
                    'id' => 16,
                    'rows' => 1
                ]
            ])->textArea() ?>

            <?= $form->field($signForm, "name", [
                'inputOptions' => [
                    'id' => 17,
                    'rows' => 1
                ]
            ])->textArea() ?>

            <?= $form->field($signForm, "city_id")->dropDownList($cities, [
                'class' => 'multiple-select input town-select registration-town',
                'size' => 1,
                'id' => 18,
                'style' => 'width: 360px; margin-top: 12px; margin-bottom: 0px;'
            ]); ?>

            <?= $form->field($signForm, "password", [
                'inputOptions' => [
                    'id' => 19
                ]
            ])->passwordInput()?>
            <button class="button button__registration" type="submit">Cоздать аккаунт</button>

            <?php ActiveForm::end(); ?>
        </div>
    </section>

</div>
