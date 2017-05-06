<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabCliente]].
 *
 * @see TabCliente
 */
class TabClienteQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabCliente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabCliente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}