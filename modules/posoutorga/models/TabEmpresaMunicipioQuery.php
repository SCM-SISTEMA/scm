<?php

namespace app\modules\posoutorga\models;

/**
 * This is the ActiveQuery class for [[TabEmpresaMunicipio]].
 *
 * @see TabEmpresaMunicipio
 */
class TabEmpresaMunicipioQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabEmpresaMunicipio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabEmpresaMunicipio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}