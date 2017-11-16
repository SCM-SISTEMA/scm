<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabModeloContrato]].
 *
 * @see TabModeloContrato
 */
class TabModeloContratoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabModeloContrato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabModeloContrato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}