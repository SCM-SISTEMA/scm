<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[ViewContratos]].
 *
 * @see ViewContratos
 */
class ViewContratosQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ViewContratos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewContratos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}