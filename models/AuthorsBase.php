<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string|null $middle_name
 *
 * @property BooksAuthors[] $booksAuthors
 */
class AuthorsBase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name'], 'required'],
            [['last_name', 'first_name', 'middle_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
        ];
    }

    /**
     * Gets query for [[BooksAuthors]].
     *
     * @return \yii\db\ActiveQuery|BooksAuthorsQuery
     */
    public function getBooksAuthors()
    {
        return $this->hasMany(BooksAuthors::className(), ['authors_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AuthorsBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthorsBaseQuery(get_called_class());
    }
}
