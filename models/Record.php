<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "record".
 *
 * @property integer $id
 * @property string $name
 * @property string $message
 * @property string $image
 * @property datetime $create_date
 * @property datetime $ip
// * @property datetime $browser
// * @property datetime $country
 * @property integer $author_id
 *
 * @property Author $author
 */
class Record extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'message','create_date', 'author_id'], 'required'],
            [['create_date'], 'safe'],
            [['ip'], 'safe'],
            [['message'], 'string'],
            [['author_id'], 'integer'],
            [['file'], 'file'],
//            [['file'], 'file', 'extensions' => ['png, jpg, jpeg, gif']],
            [['name','image'], 'string', 'max' => 255]
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
            'message' => 'Message',
            'create_date' => 'Date Create Record',
            'file' => 'Image',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
