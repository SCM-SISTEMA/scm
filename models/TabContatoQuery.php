<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TabContato]].
 *
 * @see TabContato
 */
class TabContatoQuery extends \projeto\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TabContato[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TabContato|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}