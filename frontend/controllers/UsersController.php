<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\users\Users;

class UsersController extends Controller
{
    public function actionIndex(): string
    {
        $users = Users::getDoersByDate();
        {
            return $this->render('index', ['users' => $users]);
        }
    }
}
