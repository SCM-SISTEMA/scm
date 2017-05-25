<?php

namespace app\modules\posoutorga\models;

use Yii;

/**
 * This is the model class for table "pos_outorga.tab_planos".
 *
 * @property integer $cod_plano
 * @property string $valor_512
 * @property string $valor_512k_2m
 * @property string $valor_2m_12m
 * @property string $valor_12m_34m
 * @property string $valor_34m
 * @property integer $tipo_plano_fk
 * @property integer $cod_chave
 * @property string $obs
 * @property string $tipo_tabela_fk
 */
class TabPlanos extends \projeto\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pos_outorga.tab_planos';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['valor_512', 'valor_512k_2m', 'valor_2m_12m', 'valor_12m_34m', 'valor_34m'], 'number'],
            [['tipo_plano_fk', 'cod_chave'], 'integer'],
            [['obs'], 'string'],
            [['tipo_tabela_fk'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'cod_plano' => 'Cod Plano',
            'valor_512' => 'Menor ou igual a 521Kbps',
            'valor_512k_2m' => 'Entre 512 Kbps e 2 Mbps',
            'valor_2m_12m' => 'Entre 2 Mbps e 12 Mbps',
            'valor_12m_34m' => 'Entre 12 Mbps e 34 Mbps',
            'valor_34m' => 'Acima de 34 Mbps',
            'tipo_plano_fk' => 'atributos tipo-plano
pessoa fisica / juridica',
            'cod_chave' => 'Cod Chave',
            'obs' => 'Observação',
            'tipo_tabela_fk' => 'atributo tipo-cadastro-plano
se for plano ou por municipio',
        ];
    }

    /**
     * @inheritdoc
     * @return TabPlanosQuery the active query used by this AR class.
     */
    public static function find() {
        return new TabPlanosQuery(get_called_class());
    }

}
