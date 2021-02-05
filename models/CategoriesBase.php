<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Books[] $books
 */
class CategoriesBase extends ModelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery|BooksQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['id_categories' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesBaseQuery(get_called_class());
    }
}
