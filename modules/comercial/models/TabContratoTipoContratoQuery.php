<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabContratoTipoContrato]].
 *
 * @see TabContratoTipoContrato
 */
class TabContratoTipoContratoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabContratoTipoContrato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabContratoTipoContrato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}