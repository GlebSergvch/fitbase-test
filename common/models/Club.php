<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%club}}".
 */
class Club extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%club}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () { return date('Y-m-d H:i:s'); },
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['address'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
            'created_at' => 'Дата создания',
            'created_by' => 'Кем создано',
            'updated_at' => 'Дата обновления',
            'updated_by' => 'Кем обновлено',
            'deleted_at' => 'Дата удаления',
            'deleted_by' => 'Кем удалено',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getDeletedBy()
    {
        return $this->hasOne(User::class, ['id' => 'deleted_by']);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleted_at = date('Y-m-d H:i:s');
            $this->deleted_by = Yii::$app->user->id;
            $this->save(false);
            return false;
        }
        return false;
    }
}