<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Expenses]].
 *
 * @see Expenses
 */
class ExpensesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Expenses[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Expenses|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
