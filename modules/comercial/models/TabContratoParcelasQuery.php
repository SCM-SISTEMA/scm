<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabContratoParcelas]].
 *
 * @see TabContratoParcelas
 */
class TabContratoParcelasQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabContratoParcelas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabContratoParcelas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}