<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StatusesBase]].
 *
 * @see StatusesBase
 */
class StatusesBaseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return StatusesBase[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return StatusesBase|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
