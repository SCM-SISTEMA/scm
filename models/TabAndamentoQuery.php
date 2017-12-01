<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabAndamento]].
 *
 * @see TabAndamento
 */
class TabAndamentoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabAndamento[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabAndamento|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}