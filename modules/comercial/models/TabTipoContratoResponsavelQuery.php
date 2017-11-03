<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabTipoContratoResponsavel]].
 *
 * @see TabTipoContratoResponsavel
 */
class TabTipoContratoResponsavelQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabTipoContratoResponsavel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabTipoContratoResponsavel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}