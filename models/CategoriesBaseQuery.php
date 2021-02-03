<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CategoriesBase]].
 *
 * @see CategoriesBase
 */
class CategoriesBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CategoriesBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CategoriesBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
