<?php

namespace albertborsos\yii2historizer;

use albertborsos\yii2lib\db\ActiveRecord;
use albertborsos\yii2lib\helpers\S;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "ext_historizer_archives".
 *
 * @property integer $id
 * @property string $model_class
 * @property integer $model_id
 * @property string $model_attributes
 * @property integer $created_at
 * @property integer $created_user
 * @property integer $updated_at
 * @property integer $updated_user
 * @property string $status
 */
class Historizer extends ActiveRecord
{
    const STATUS_ACTIVE   = 'a';
    const STATUS_INACTIVE = 'i';
    const STATUS_DELETED  = 'd';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ext_historizer_archives';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_class', 'model_id', 'model_attributes', 'status'], 'required'],
            [['model_id', 'created_at', 'created_user', 'updated_at', 'updated_user'], 'integer'],
            [['model_attributes'], 'string'],
            [['model_class'], 'string', 'max' => 512],
            [['status'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_class' => 'Model Class',
            'model_id' => 'Model ID',
            'model_attributes' => 'Model Attributes',
            'created_at' => 'Created At',
            'created_user' => 'Created User',
            'updated_at' => 'Updated At',
            'updated_user' => 'Updated User',
            'status' => 'Status',
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()){
            $this->status = self::STATUS_ACTIVE;
            return true;
        }else{
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)){
            $this->setOwnerAndTime();
            return true;
        }else{
            return false;
        }
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param \albertborsos\yii2lib\db\ActiveRecord $model
     */
    public static function createArchive($model){
        $class = get_class($model); /** @var \albertborsos\yii2lib\db\ActiveRecord $class */

        $oldModel = $class::findOne(['id' => $model->getPrimaryKey()]);
        if (!self::attributesAreSame($model, $oldModel)){
            $archive = new Historizer();
            $archive->model_class      = $class;
            $archive->model_id         = $model->getPrimaryKey();
            $archive->model_attributes = Json::encode($oldModel->attributes);

            if (!$archive->save()){
                $archive->throwNewException('Archiválás nem sikerült!');
            }
        }else{
            return false;
        }
    }

    /**
     * @param \albertborsos\yii2lib\db\ActiveRecord $model
     * @param \albertborsos\yii2lib\db\ActiveRecord $oldModel
     */
    public static function attributesAreSame($model, $oldModel){
        $newAttributes = $model->attributes;
        $oldAttributes = $oldModel->attributes;
        foreach($newAttributes as $id => $value){
            $new = preg_replace('/\s+/', ' ', $newAttributes[$id]);
            $old = preg_replace('/\s+/', ' ', $oldAttributes[$id]);
            if ($new != $old){
                return false;
            }
        }
        return true;
    }
}
