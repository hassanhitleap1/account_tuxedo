<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Draws]].
 *
 * @see Draws
 */
class DrawsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Draws[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Draws|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
