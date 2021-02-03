<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AuthorsBase]].
 *
 * @see AuthorsBase
 */
class AuthorsBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AuthorsBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AuthorsBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
