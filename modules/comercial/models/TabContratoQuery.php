<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabContrato]].
 *
 * @see TabContrato
 */
class TabContratoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabContrato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabContrato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}