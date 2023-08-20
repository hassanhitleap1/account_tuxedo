<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TypesOfExpenses]].
 *
 * @see TypesOfExpenses
 */
class TypesOfExpensesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TypesOfExpenses[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TypesOfExpenses|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
