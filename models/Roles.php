<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property integer $parent_id
 * @property integer $child_id
 *
 * @property BasUser $parent
 * @property BasUser $child
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id'], 'integer'],
            [['child_id'], 'required'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => BasUser::className(), 'targetAttribute' => ['parent_id' => 'user_id']],
            [['child_id'], 'exist', 'skipOnError' => true, 'targetClass' => BasUser::className(), 'targetAttribute' => ['child_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Parent ID',
            'child_id' => 'Child ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(BasUser::className(), ['user_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild()
    {
        return $this->hasOne(BasUser::className(), ['user_id' => 'child_id']);
    }
}
