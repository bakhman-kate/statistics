<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $created
 * @property string $status
 */
class Client extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_REGISTER = 'registered';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'phone'], 'required'],
            [['created'], 'safe'],
            [['status'], 'string'],
            [['name', 'surname'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'created' => 'Created',
            'status' => 'Status',
        ];
    }
}
