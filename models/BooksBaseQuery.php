<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[BooksBase]].
 *
 * @see BooksBase
 */
class BooksBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return BooksBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return BooksBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
