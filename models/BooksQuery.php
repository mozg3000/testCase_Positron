<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Books]].
 *
 * @see Books
 */
class BooksQuery extends BooksBaseQuery
{
	public function byISBN(string $isbn):\yii\db\ActiveQuery{
		return $this->where(['isbn' => $isbn]);
	}
	public function byTitle(string $title):\yii\db\ActiveQuery{
		return $this->where(['title' => $title]);
	}
}
