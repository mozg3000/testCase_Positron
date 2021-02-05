<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Authors]].
 *
 * @see Authors
 */
class AuthorsQuery extends AuthorsBaseQuery
{
	public function byName(string $name):\yii\db\ActiveQuery{
		return $this->where(['name' => $name]);
	}
}
