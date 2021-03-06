<?php
declare(strict_types = 1);

namespace frontend\models\replies;

use frontend\models\{
    tasks\Tasks,
    users\Users
};
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "replies".
 *
 * @property int $id
 * @property string $dt_add
 * @property float|null $rate
 * @property int budget
 * @property string $description
 * @property int $doer_id
 * @property int $task_id
 *
 * @property Users $doer
 * @property Tasks $task
 */

class Replies extends ActiveRecord
{

    public static function tableName(): string
    {
        return 'replies';
    }

    public function rules(): array
    {
        return [
            [['dt_add'], 'safe'],
            [['rate'], ['budget'], 'number'],
            [['description', 'doer_id', 'task_id'], 'required'],
            [['description'], 'string'],
            [['doer_id', 'task_id'], 'integer'],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['doer_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'rate' => 'Rate',
            'title' => 'Title',
            'description' => 'Description',
            'doer_id' => 'Doer ID',
            'task_id' => 'Task ID',
        ];
    }

    public function getTask(): ActiveQuery
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    public function getDoer(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    public static function find(): RepliesQuery
    {
        return new RepliesQuery(get_called_class());
    }
}
