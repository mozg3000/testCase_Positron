<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "statuses".
 *
 * @property int $id
 * @property string|null $name
 */
class Statuses extends StatusesBase
{
	/**
     * {@inheritdoc}
     * @return StatusesBaseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatusesQuery(get_called_class());
    }
		public function attributeLabels()
    {
        return [
            'name' => 'Статус',
        ];
    }
}
