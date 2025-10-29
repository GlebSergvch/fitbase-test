<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%client}}".
 */
class Client extends \yii\db\ActiveRecord
{
    public $club_ids = []; // для multiselect

    public static function tableName()
    {
        return '{{%client}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => function () { return date('Y-m-d H:i:s'); },
            ],
            BlameableBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['full_name', 'gender', 'club_ids'], 'required'],
            [['birth_date'], 'date', 'format' => 'php:Y-m-d'],
            [['club_ids'], 'each', 'rule' => ['integer']],
            [['full_name'], 'string', 'max' => 255],
            [['gender'], 'in', 'range' => ['male', 'female']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'gender' => 'Пол',
            'birth_date' => 'Дата рождения',
            'club_ids' => 'Доступные клубы',
            'created_at' => 'Создано',
            'created_by' => 'Кем создано',
            'updated_at' => 'Обновлено',
            'updated_by' => 'Кем обновлено',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Удаляем старые связи
        Yii::$app->db->createCommand()
            ->delete('{{%client_club}}', ['client_id' => $this->id])
            ->execute();

        // Добавляем новые
        if (is_array($this->club_ids)) {
            foreach ($this->club_ids as $clubId) {
                Yii::$app->db->createCommand()->insert('{{%client_club}}', [
                    'client_id' => $this->id,
                    'club_id' => $clubId,
                ])->execute();
            }
        }
    }

    public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);
        if (isset($data['Client']['club_ids'])) {
            $this->club_ids = $data['Client']['club_ids'];
        }
        return $result;
    }

    public function getClubs()
    {
        return $this->hasMany(Club::class, ['id' => 'club_id'])
            ->viaTable('{{%client_club}}', ['client_id' => 'id']);
    }

    public function getClubNames()
    {
        return $this->getClubs()->select('name')->column();
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
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