<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabEndereco]].
 *
 * @see TabEndereco
 */
class TabEnderecoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabEndereco[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabEndereco|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}