<?php
require_once '../utils/my_functions.php';
$this->title = 'Список исполнителей';
$formatter = \Yii::$app->formatter;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;

$categoriesFilter = $searchForm->getCategoriesFilter();
$additionalFilter = $searchForm->attributeLabels();
?>

<div class="main-container page-container">
    <section class="user__search">
        <?php foreach ($users as $user): ?>
            <div class="content-view__feedback-card user__search-wrapper">
                <div class="feedback-card__top">
                    <div class="user__search-icon">
                        <a href="<?= Url::to(['users/view', 'id' => $user['id']]) ?>"><?= $user['avatar'] ? Html::img(Yii::$app->request->baseUrl . '/img/' . $user['avatar'], ['width' => '65', 'height' => '65']) : Html::img(Yii::$app->request->baseUrl . '/img/no-avatar.png', ['width' => '65', 'height' => '65']) ?> </a>
                        <span><?= $user['finished_task_count'] ?> <?= get_noun_plural_form($user['finished_task_count'], 'задание', 'задания', 'заданий') ?></span>
                        <span><?= $user['opinions_count'] ?> <?= get_noun_plural_form($user['opinions_count'], 'отзыв', 'отзыва', 'отзывов') ?></span>
                    </div>
                    <div class="feedback-card__top--name user__search-card">
                        <p class="link-name"><a href="<?= Url::to(['users/view', 'id' => $user['id']]) ?>"
                                                class="link-regular"><?= $user['name'] ?></a></p>
                        <?php if ($user['rating'] > 0) : ?>
                            <?php $starCount = round((float)$user['rating']) ?>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                            <?php endfor; ?>
                            <b><?= floor($user['rating'] * 100) / 100 ?></b>
                        <?php endif; ?>
                        <p class="user__search-content">
                            <?= $user['about'] ?>
                        </p>
                    </div>
                    <span
                        class="new-task__time">Был на сайте <?= $formatter->asRelativeTime($user['last_activity_time']) ?></span>
                </div>
                <div class="link-specialization user__search-link--bottom">
                    <?php foreach ($user['userCategories'] as $category): ?>
                        <a href="#" class="link-regular"><?= $category['profession'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="new-task__pagination">
            <?= LinkPager::widget([
                'pagination' => $page,
                'options' => ([
                    'class' => 'new-task__pagination-list',
                ]),
                'activePageCssClass' => 'pagination__item pagination__item--current',
                'pageCssClass' => 'pagination__item',
                'prevPageCssClass' => 'pagination__item',
                'nextPageCssClass' => 'pagination__item',
                'prevPageLabel' => '',
                'nextPageLabel' => '',
                'linkOptions' => ([
                    'style' => 'padding-top: 40%; height: 100%; width: 100%; text-align: center'
                ])
            ]); ?>
    </section>
    <section class="search-task">
        <div class="search-task__wrapper">
            <?php $form = ActiveForm::begin([
                'id' => 'searchForm',
                'method' => 'post',
                'options' => [
                    'name' => 'test',
                    'class' => 'search-task__form'
                ]
            ]); ?>
            <fieldset class="search-task__categories">
                <legend>Категории</legend>
                <?php $i = 1; ?>
                <?php foreach ($categoriesFilter as $id => $name) : ?>
                    <?= $form->field($searchForm, 'searchedCategories[]', [
                        'template' => '{input}',
                        'options' => ['tag' => false]
                    ])->checkbox([
                        'label' => false,
                        'value' => $id,
                        'uncheck' => null,
                        'checked' => in_array($id, $searchForm->searchedCategories),
                        'id' => $id,
                        'class' => 'visually-hidden checkbox__input'
                    ]) ?>
                    <?php $i++; ?>
                    <label for="<?= $id ?>"><?= $name ?></label>
                <?php endforeach; ?>
            </fieldset>
            <fieldset class="search-task__categories">
                <legend>Дополнительно</legend>
                <?= $form->field($searchForm, 'isFreeNow', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'isFreeNow',
                    'uncheck' => null,
                    'id' => 'isFreeNow',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="isFreeNow">Сейчас свободен</label>
                <?= $form->field($searchForm, 'isOnlineNow', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'isOnlineNow',
                    'uncheck' => null,
                    'id' => 'isOnlineNow',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="isOnlineNow">Сейчас онлайн</label>
                <?= $form->field($searchForm, 'hasOpinions', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'hasOpinions',
                    'uncheck' => null,
                    'id' => 'hasOpinions',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="hasOpinions">С отзывами</label>
                <?= $form->field($searchForm, 'isFavourite', [
                    'template' => '{input}',
                    'options' => ['tag' => false]
                ])->checkbox([
                    'label' => false,
                    'value' => 'isFavourite',
                    'uncheck' => null,
                    'id' => 'isFavourite',
                    'class' => 'visually-hidden checkbox__input'
                ]) ?>
                <label for="isFavourite">В избранном</label>
            </fieldset>
            <label class="search-task__name" for="<?= $i ?>">Поиск по названию</label>
            <?= $form->field($searchForm, 'searchName', [
                'template' => "{input}",
                'options' => ['tag' => false],
                'inputOptions' => [
                    'class' => 'input-middle input',
                    'type' => 'search',
                    'id' => $i
                ]
            ]); ?>
            <?= Html::submitButton('Искать',
                ['class' => 'button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </section>
</div>
