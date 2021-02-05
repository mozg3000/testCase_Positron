<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Categories]].
 *
 * @see Categories
 */
class CategoriesQuery extends CategoriesBaseQuery
{
	public function byName(string $name):\yii\db\ActiveQuery{
		return $this->where(['name' => $name]);
	}
}
