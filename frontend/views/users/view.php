<?php
  require_once '../utils/my_functions.php';
  $formatter = \Yii::$app->formatter;
use yii\helpers\html;
use yii\helpers\url;
?>

<div class="main-container page-container">
    <section class="content-view">
        <div class="user__card-wrapper">
            <div class="user__card">
                <?=Html::img( Yii::$app->request->baseUrl . '/img/' . $user['avatar'], [ 'alt' => 'Аватар пользователя', 'width' =>'120', 'height' => '120'])?>
                <div class="content-view__headline">
                    <?php $opinions = $user['opinions'] ?>
                    <?php $tasks = $user['tasksDoer'] ?>
                    <?php $opinions_rating = count($opinions['rate'])?>
                    <h1><?= $user['name'] ?></h1>
                    <p>Россия, <?= $user['city']['city'] ?>, <?= getAge($user['bd']) ?> <?= get_noun_plural_form(getAge($user['bd']), 'год', 'года', 'лет') ?></p>
                    <div class="profile-mini__name five-stars__rate">
                        <?php $starCount = round((float)$opinions_rating) ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="<?= $starCount < $i ? 'star-disabled' : '' ?>"></span>
                        <?php endfor; ?>
                        <b><?= floor($opinions_rating * 100) / 100 ?></b>
                    </div>
                    <b class="done-task">Выполнил <?= count($tasks) ?> <?= get_noun_plural_form(count($tasks), 'заказ', 'заказа', 'заказов') ?></b>
                    <b class="done-review"> Получил <?= count($opinions) ?> <?= get_noun_plural_form(count($opinions), 'отзыв', 'отзыва', 'отзывов') ?></b>
                </div>
                <div class="content-view__headline user__card-bookmark user__card-bookmark--current">
                    <span>Был на сайте <?= $formatter->asRelativeTime($user['last_activity_time'], strftime("%F %T"))  ?></span>
                    <a href="#"><b></b></a>
                </div>
            </div>
            <div class="content-view__description">
                <p><?= $user['about'] ?></p>
            </div>
            <div class="user__card-general-information">
                <div class="user__card-info">
                    <h3 class="content-view__h3">Специализации</h3>
                    <?php $categories = $user['userCategories'] ?>
                    <div class="link-specialization">
                        <?php foreach ($categories as $category) : ?>
                                <a href="#" class="link-regular"><?= $category['profession'] ?></a>
                        <?php endforeach; ?>
                    </div>
                    <h3 class="content-view__h3">Контакты</h3>
                    <div class="user__card-link">
                        <a class="user__card-link--tel link-regular" href="tel:<?= $user['phone'] ?>"><?= $user['phone'] ?></a>
                        <?= $formatter->asEmail($user['email'], ['class' => 'user__card-link--email link-regular']) ?>
                        <?php if ($user['skype']) : ?>
                          <a class="user__card-link--skype link-regular" href="skype:<?= $user['skype'] ?>"><?= $user['skype'] ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="user__card-photo">
                    <h3 class="content-view__h3">Фото работ</h3>
                    <?php $portfolio = $user['portfolioPhotos'] ?>
                    <?php foreach ($portfolio as $portfolio_photo) : ?>
                      <a href="#">
                          <?=Html::img( Yii::$app->request->baseUrl . '/img/' . $portfolio_photo['photo'], [ 'alt' => 'Фото работы', 'width' =>'85', 'height' => '86'])?>
                      </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="content-view__feedback">
            <h2>Отзывы<span>(<?= count($opinions) ?>)</span></h2>
            <div class="content-view__feedback-wrapper reviews-wrapper">
                <?php foreach ($opinions as $opinion) : ?>
                    <?php $task = $opinion['task'] ?>
                    <?php $writer = $opinion['writer'] ?>
                <div class="feedback-card__reviews">
                    <p class="link-task link">Задание <a href="<?= Url::to(['tasks/view', 'id' => $task['id']])?>" class="link-regular">«<?= $task['name']?>»</a></p>
                    <div class="card__review">
                        <a href="<?= Url::to(['users/view', 'id' => $writer['id']])?>"><?=Html::img( Yii::$app->request->baseUrl . '/img/' . $user['avatar'], [ 'width' =>'55', 'height' => '54'])?></a>
                        <div class="feedback-card__reviews-content">
                            <p class="link-name link"><a href="<?= Url::to(['users/view', 'id' => $writer['id']])?>" class="link-regular"><?= $writer['name'] ?></a></p>
                            <p class="review-text">
                                <?= $opinion['description'] ?>
                            </p>
                        </div>
                        <div class="card__review-rate">
                            <p class="<?= getRatingType(intval($opinion['rate'])) ?>-rate big-rate"><?= intval($opinion['rate']) ?><span></span></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
    </section>
    <section class="connect-desk">
        <div class="connect-desk__chat">

        </div>
    </section>
</div>