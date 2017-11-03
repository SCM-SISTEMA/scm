<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public.vis_atributos_valores".
 *
 * @property integer $cod_atributos
 * @property integer $cod_atributos_valores
 * @property string $descr_atributo
 * @property string $sgl_chave
 * @property string $sgl_valor
 * @property string $dsc_descricao
 */
class VisAtributosValores extends \projeto\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public.vis_atributos_valores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cod_atributos', 'cod_atributos_valores'], 'integer'],
            [['descr_atributo', 'sgl_chave', 'sgl_valor'], 'string'],
            [['dsc_descricao'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cod_atributos' => 'Cod Atributos',
            'cod_atributos_valores' => 'Cod Atributos Valores',
            'descr_atributo' => 'Descr Atributo',
            'sgl_chave' => 'Sgl Chave',
            'sgl_valor' => 'Sgl Valor',
            'dsc_descricao' => 'Dsc Descricao',
        ];
    }

    /**
     * @inheritdoc
     * @return VisAtributosValoresQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VisAtributosValoresQuery(get_called_class());
    }
}
