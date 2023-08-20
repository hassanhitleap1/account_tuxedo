<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Debt]].
 *
 * @see Debt
 */
class DebtQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Debt[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Debt|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
