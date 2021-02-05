<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Statuses]].
 *
 * @see Statuses
 */
class StatusesQuery extends StatusesBaseQuery
{
  public function byName(string $name):\yii\db\ActiveQuery{
		return $this->where(['name' => $name]);
	}
	
}
