<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[VisPerfisFuncionalidadesAcoes]].
 *
 * @see VisPerfisFuncionalidadesAcoes
 */
class VisPerfisFuncionalidadesAcoesQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return VisPerfisFuncionalidadesAcoes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VisPerfisFuncionalidadesAcoes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}