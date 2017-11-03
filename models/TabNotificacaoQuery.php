<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabNotificacao]].
 *
 * @see TabNotificacao
 */
class TabNotificacaoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabNotificacao[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabNotificacao|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}