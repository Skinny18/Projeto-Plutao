<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Salas]].
 *
 * @see Salas
 */
class SalasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Salas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Salas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
