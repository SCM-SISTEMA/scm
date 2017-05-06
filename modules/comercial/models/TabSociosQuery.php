<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabSocios]].
 *
 * @see TabSocios
 */
class TabSociosQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabSocios[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabSocios|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}