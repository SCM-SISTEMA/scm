<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ViewContato]].
 *
 * @see ViewContato
 */
class ViewContatoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ViewContato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ViewContato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}