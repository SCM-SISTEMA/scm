<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabAtividade]].
 *
 * @see TabAtividade
 */
class TabAtividadeQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabAtividade[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabAtividade|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}