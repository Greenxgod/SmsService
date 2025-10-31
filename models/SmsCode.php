<?php
namespace app\models;

use yii\db\ActiveRecord;

class SmsCode extends ActiveRecord
{
    public static function tableName()
    {
        return 'sms_codes'; 
    }

    public function rules()
    {
        return [
            [['phone', 'code', 'created_at'], 'required'],
            ['phone', 'match', 'pattern' => '/^\+7\d{10}$/'],
            ['code', 'string', 'length' => 4],
            [['verified'], 'boolean'],
            [['created_at', 'verified_at'], 'integer'],
        ];
    }
}