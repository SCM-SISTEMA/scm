<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabMunicipios]].
 *
 * @see TabMunicipios
 */
class TabMunicipiosQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabMunicipios[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabMunicipios|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}