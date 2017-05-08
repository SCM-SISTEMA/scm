<?php

namespace app\modules\posoutorga\models;

/**
 * This is the ActiveQuery class for [[TabSici]].
 *
 * @see TabSici
 */
class TabSiciQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabSici[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabSici|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}