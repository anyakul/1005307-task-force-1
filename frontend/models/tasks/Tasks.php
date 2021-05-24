<?php

namespace app\models\tasks;

use Yii;
use app\models\{cities\Cities,
    cities\CitiesQuery,
    categories\Categories,
    categories\CategoriesQuery,
    messages\Messages,
    messages\MessagesQuery,
    notifications\Notifications,
    notifications\NotificationsQuery,
    opinions\Opinions,
    opinions\OpinionsQuery,
    replies\Replies,
    replies\RepliesQuery,
    users\Users,
    users\UsersQuery};

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $dt_add
 * @property int|null $category_id
 * @property string $description
 * @property string|null $expire
 * @property string $name
 * @property string|null $address
 * @property int|null $budget
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $location_comment
 * @property int|null $city_id
 * @property int|null $doer_id
 * @property int $client_id
 * @property string|null $status_task
 *
 * @property FileTask[] $fileTasks
 * @property Messages[] $messages
 * @property Notifications[] $notifications
 * @property Opinions[] $opinions
 * @property Replies[] $replies
 * @property Categories $category
 * @property Cities $city
 * @property Users $client
 * @property Users $doer
 */

class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
 * {@inheritdoc}
 */
    public function rules()
    {
        return [
            [['dt_add', 'expire'], 'safe'],
            [['category_id', 'budget', 'city_id', 'doer_id', 'client_id'], 'integer'],
            [['description', 'name', 'client_id'], 'required'],
            [['description'], 'string'],
            [['name', 'address', 'latitude', 'longitude', 'location_comment', 'status_task'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Users::class, 'targetAttribute' => ['client_id' => 'id']],
            [['doer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['doer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dt_add' => 'Dt Add',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'expire' => 'Expire',
            'name' => 'Name',
            'address' => 'Address',
            'budget' => 'Budget',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'location_comment' => 'Location Comment',
            'city_id' => 'City ID',
            'doer_id' => 'Doer ID',
            'client_id' => 'Client ID',
            'status_task' => 'Status Task',
        ];
    }

    /**
     * Gets query for [[FileTasks]].
     *
     * @return \yii\db\ActiveQuery|FileTaskQuery
     */
    public function getFileTasks()
    {
        return $this->hasMany(FileTask::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery|NotificationsQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery|OpinionsQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinions::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery|CategoriesQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CitiesQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getClient()
    {
        return $this->hasOne(Users::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Doer]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getDoer()
    {
        return $this->hasOne(Users::class, ['id' => 'doer_id']);
    }

    /**
     * {@inheritdoc}
     * @return TasksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TasksQuery(get_called_class());
    }

    final public static function getNewTasksByFilters(TaskSearchForm $form) {
        $query = self::find()
            ->joinWith('replies')
            ->joinWith('city')
            ->where(['tasks.doer_id' => 'id'])
            ->select([
                'tasks.*',
                'count(replies.description) as replies_count'
            ])
            ->where(['status_task' => 'new'])
            ->with('category')
            ->with('city')
            ->groupBy('tasks.id')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray();

     //   $query->withoutRepliesFilter();
        //   $query->onlineFilter();
        //   $query->periodFilter();
       //    $query->nameSearch('Mr');

        return $query->all();
    }

    final public static function getNewTasksByDate() {
        return $query = self::find()
            ->where(['status_task' => 'new'])
            ->with('category')
            ->with('city')
            ->orderBy(['dt_add' => SORT_DESC])
            ->asArray()->all();
    }
}
