<?php

declare(strict_types=1);

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use app\models\tasks\Tasks;
use app\models\tasks\TaskSearchForm;
use yii\web\Request;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{

    public function actionIndex(): string
    {
        $searchForm = new TaskSearchForm();
        $searchForm->load($this->request->post());
        $tasks = Tasks::getNewTasksByFilters($searchForm);
        return $this->render('index', compact('tasks', 'searchForm'));
    }

    public function actionView($id = null)
    {
        $task = Tasks::getOneTask($id);

        if (empty($task)) {
            throw new NotFoundHttpException('Страница не найдена...');
        }

        return $this->render('view', ['task' => $task]);
    }
}
