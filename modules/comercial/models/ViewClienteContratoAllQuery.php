<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[ViewClienteContratoAll]].
 *
 * @see ViewClienteContratoAll
 */
class ViewClienteContratoAllQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ViewClienteContratoAll[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewClienteContratoAll|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}