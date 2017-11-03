<?php

namespace app\modules\posoutorga\models;

/**
 * This is the ActiveQuery class for [[VisSiciCliente]].
 *
 * @see VisSiciCliente
 */
class VisSiciClienteQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return VisSiciCliente[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VisSiciCliente|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}