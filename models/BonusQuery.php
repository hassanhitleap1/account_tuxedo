<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Bonus]].
 *
 * @see Bonus
 */
class BonusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Bonus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Bonus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
