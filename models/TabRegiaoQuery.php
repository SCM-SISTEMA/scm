<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabRegiao]].
 *
 * @see TabRegiao
 */
class TabRegiaoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabRegiao[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabRegiao|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}