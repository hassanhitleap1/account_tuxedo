<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[WorkingHours]].
 *
 * @see WorkingHours
 */
class WorkingHoursQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return WorkingHours[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return WorkingHours|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
