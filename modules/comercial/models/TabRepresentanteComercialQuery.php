<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabRepresentanteComercial]].
 *
 * @see TabRepresentanteComercial
 */
class TabRepresentanteComercialQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabRepresentanteComercial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabRepresentanteComercial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}