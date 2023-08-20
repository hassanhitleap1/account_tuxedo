<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SalesEmployees]].
 *
 * @see SalesEmployees
 */
class SalesEmployeesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SalesEmployees[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SalesEmployees|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
