<?php
declare(strict_types = 1);

namespace frontend\models\notifications;

use frontend\models\{
    tasks\Tasks,
    users\Users
};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "notifications".
 *
 * @property int $id
 * @property string $title
 * @property int $is_view
 * @property string $dt_add
 * @property string $type
 * @property int $user_id
 * @property int $task_id
 *
 * @property Tasks $task
 * @property Users $user
 */

class Notifications extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'notifications';
    }

    public function rules(): array
    {
        return [
            [['title', 'is_view', 'type', 'user_id', 'task_id'], 'required'],
            [['is_view', 'user_id', 'task_id'], 'integer'],
            [['dt_add'], 'safe'],
            [['title', 'type'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'is_view' => 'Is View',
            'dt_add' => 'Dt Add',
            'type' => 'Type',
            'user_id' => 'User ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find(): NotificationsQuery
    {
        return new NotificationsQuery(get_called_class());
    }
}
