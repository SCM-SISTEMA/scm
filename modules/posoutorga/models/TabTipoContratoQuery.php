<?php

namespace app\modules\posoutorga\models;

/**
 * This is the ActiveQuery class for [[\app\modules\comercial\models\TabTipoContrato]].
 *
 * @see \app\modules\comercial\models\TabTipoContrato
 */
class TabTipoContratoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\modules\comercial\models\TabTipoContrato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\comercial\models\TabTipoContrato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}