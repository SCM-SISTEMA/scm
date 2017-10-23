<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[ViewClienteContrato]].
 *
 * @see ViewClienteContrato
 */
class ViewClienteContratoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ViewClienteContrato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewClienteContrato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}