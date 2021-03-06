<?php

namespace frontend\models\users;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "portfolio_photo".
 *
 * @property int $id
 * @property string $photo
 * @property int $user_id
 *
 * @property Users $user
 */

class PortfolioPhoto extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'portfolio_photo';
    }

    public function rules(): array
    {
        return [
            [['photo', 'user_id'], 'required'],
            [['user_id'], 'integer'],
            [['photo'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'photo' => 'Photo',
            'user_id' => 'User ID',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public static function find(): PortfolioPhotoQuery
    {
        return new PortfolioPhotoQuery(get_called_class());
    }
}
