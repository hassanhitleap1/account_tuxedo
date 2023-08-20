<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Commission]].
 *
 * @see Commission
 */
class CommissionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Commission[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Commission|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
