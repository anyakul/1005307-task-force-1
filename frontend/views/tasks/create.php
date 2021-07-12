<?php
$this->title = 'Публикация нового задания';

//$cities = $signForm->getCities();

use yii\widgets\ActiveForm;

$categories = $createTaskForm->getCategories();

?>

<div class="main-container page-container">
    <section class="create__task">
        <h1>Публикация нового задания</h1>
        <div class="create__task-main">
            <?php $form = ActiveForm::begin([
                'id' => 'task-form',
                'method' => 'post',
                'options' => ['class' => 'create__task-form form-create',
                    'enctype' => "multipart/form-data"],
                'validationStateOn' => 'input',
                'action' => '/tasks/create',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'options' => ['style' => 'margin-top: 29px'],
                    'inputOptions' => [
                        'class' => 'input textarea',
                        'style' => 'width: 93%; margin-top: 12px; margin-bottom: 8px;',
                    ],
                    'errorOptions' => ['tag' => 'span', 'style' => 'color: red'],
                    'labelOptions' => [
                        'class' => null,
                    ],
           //         'enableAjaxValidation' => true,
                ]]) ?>
            <?= $form->field($createTaskForm, 'client_id', [
                'options' => ['style' => 'margin-top: 0'],
                'inputOptions' => [
                    'class' => 'input textarea',
                    'value' => $user['id'],
                    'type' => 'hidden',
                    'style' => 'margin-top: 0'
                ]
            ])->label(false); ?>
            <?= $form->field($createTaskForm, "name", [
                'inputOptions' => [
                    'class' => 'input textarea',
                    'id' => 10,
                    'rows' => 1
                ]
            ])->textArea() ?>
            <?= $form->field($createTaskForm, "description", [
                'inputOptions' => [
                    'class' => 'input textarea',
                    'id' => 11,
                    'rows' => 7
                ]
            ])->textArea() ?>
            <label>Файлы</label>
            <span>Загрузите файлы, которые помогут исполнителю лучше выполнить или оценить работу</span>
            <div class="create__file" style="position: relative">
                <span>Добавить новый файл</span>
                <label for="file_task" style="position: absolute; width: 100%; height: 100%;"></label>

                <?= $form->field($fileUploadForm, 'file_item[]', [
                    'inputOptions' => [
                        'class' => 'create__file',
                        'style' => 'display: none',
                        'multiple' => true,
                        'id' => 'file_task',

                        'widgetClientOptions' => [
                            'buttonsHide' => ['image', 'file'],
                        ]
                    ]
                ])->label(false)->fileInput(['multiple' => true, 'accept' => 'image/*']); ?>
            </div>
            <!--  $form->field($createTaskForm, "categories", [
             'options' => ['style' => 'margin-top: 27px; margin-bottom: 0;'],
             'inputOptions' => ['style' => 'width: 520px; margin-top: 12px; margin-bottom: 7px;']
         ])->dropDownList($categories, [
             'class' => 'multiple-select input multiple-select-big',
             'size' => 1,

             'prompt' => [
                 'text' => 'Курьер',
                 'options' => ['value' => 'cargo']
             ]
         ]) -->
            <label for="13">Локация</label>
            <input class="input-navigation input-middle input" id="13" type="search" name="q"
                   placeholder="Санкт-Петербург, Калининский район">
            <span>Укажите адрес исполнения, если задание требует присутствия</span>
            <div class="create__price-time">
                <div class="create__price-time--wrapper">
                    <?= $form->field($createTaskForm, "budget", [
                        'inputOptions' => [
                            'class' => 'input textarea input-money',
                            'id' => 14,
                            'rows' => 1
                        ]
                    ])->input('number') ?>
                </div>
                <div class="create__price-time--wrapper">
                    <?= $form->field($createTaskForm, "expire", [
                        'inputOptions' => [
                            'class' => 'input-middle input input-date',
                            'id' => 15,
                            'rows' => 1,
                        ]
                    ])->input('date') ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="create__warnings">
                <div class="warning-item warning-item--advice">
                    <h2>Правила хорошего описания</h2>
                    <h3>Подробности</h3>
                    <p>Друзья, не используйте случайный<br>
                        контент – ни наш, ни чей-либо еще. Заполняйте свои
                        макеты, вайрфреймы, мокапы и прототипы реальным
                        содержимым.</p>
                    <h3>Файлы</h3>
                    <p>Если загружаете фотографии объекта, то убедитесь,
                        что всё в фокусе, а фото показывает объект со всех
                        ракурсов.</p>
                </div>
                <?php if ($createTaskForm->hasErrors()): ?>
                    <div class="warning-item warning-item--error">
                        <h2>Ошибки заполнения формы</h2>
                        <?php $labels = $createTaskForm->attributeLabels(); ?>
                        <?php foreach ($createTaskForm->errors as $attribute => $message): ?>
                            <h3><?= $labels[$attribute] ?></h3>
                            <p><?= $message[0] ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <button form="task-form" class="button" type="submit">Опубликовать</button>
    </section>
</div>
