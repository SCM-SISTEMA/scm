<?php

namespace app\modules\posoutorga\models;

/**
 * This is the ActiveQuery class for [[TabPlanos]].
 *
 * @see TabPlanos
 */
class TabPlanosQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabPlanos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabPlanos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}