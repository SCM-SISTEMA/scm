<?php

namespace app\modules\posoutorga\models;

/**
 * This is the ActiveQuery class for [[TabPlanosMenorMaior]].
 *
 * @see TabPlanosMenorMaior
 */
class TabPlanosMenorMaiorQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabPlanosMenorMaior[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabPlanosMenorMaior|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}