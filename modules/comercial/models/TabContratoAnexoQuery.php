<?php

namespace app\modules\comercial\models;

/**
 * This is the ActiveQuery class for [[TabContratoAnexo]].
 *
 * @see TabContratoAnexo
 */
class TabContratoAnexoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabContratoAnexo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabContratoAnexo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}