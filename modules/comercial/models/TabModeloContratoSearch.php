<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabModeloContrato;

/**
 * TabModeloContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabModeloContrato`.
 */
class TabModeloContratoSearch extends TabModeloContrato
{
    
    public $cod_contrato_fk;
    /**
     * @inheritdoc
     */ 
    public function rules()
    {

		$rules =  [
             //exemplo [['txt_nome', 'cod_modulo_fk'], 'required'],
        ];
		
		return array_merge($rules, parent::rules());
    }
	
	/**
    * @inheritdoc
    */
	public function attributeLabels()
    {

		$labels = [
            //exemplo 'campo' => 'label',         
        ];
		
		return array_merge( parent::attributeLabels(), $labels);
    }
	
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TabModeloContratoSearch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->andFilterWhere([
            $this->tableName() . '.cod_modelo_contrato' => $this->cod_modelo_contrato,
            $this->tableName() . '.cod_contrato_tipo_contrato_fk' => $this->cod_contrato_tipo_contrato_fk,
        ]);

        $query->andFilterWhere(['ilike', $this->tableName() . '.txt_modelo', $this->txt_modelo]);

		$query->andWhere($this->tableName().'.dt_exclusao IS NULL');
		
        return $dataProvider;
    }
    
        
      public function substituiVariaveis($contrato) {
        $endereco = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $contrato->cod_cliente, 'tipo_tabela_fk' => \app\models\TabClienteSearch::tableName()])->one();
        $socio = TabSociosSearch::find()->where(['cod_cliente_fk' => $contrato->cod_cliente, 'representante_comercial' => true])->one();
        $dt_parcelas = TabContratoParcelasSearch::find()->where(['numero' => '1', 'cod_contrato_fk' => $contrato->cod_contrato])->one();

        //print_r($endereco->attributes); exit;
        $this->txt_modelo = str_replace('{razao_social}', $contrato->razao_social, $this->txt_modelo);
        $this->txt_modelo = str_replace('{logradouro}', $endereco->logradouro, $this->txt_modelo);
        $this->txt_modelo = str_replace('{numero}', $endereco->numero, $this->txt_modelo);
        $this->txt_modelo = str_replace('{bairro}', $endereco->bairro, $this->txt_modelo);
        $this->txt_modelo = str_replace('{municipio}', $endereco->tabMunicipios->txt_nome, $this->txt_modelo);
        $this->txt_modelo = str_replace('{estado}', $endereco->tabMunicipios->sgl_estado_fk, $this->txt_modelo);
        $this->txt_modelo = str_replace('{cep}', $endereco->cep, $this->txt_modelo);
        $this->txt_modelo = str_replace('{estado_civil}', $contrato->estado_civil, $this->txt_modelo);
        $this->txt_modelo = str_replace('{nacionalidade}', $contrato->nacionalidade, $this->txt_modelo);
        $this->txt_modelo = str_replace('{rg}', $contrato->rg, $this->txt_modelo);
        $this->txt_modelo = str_replace('{nacionalidade}', $contrato->nacionalidade, $this->txt_modelo);
        $this->txt_modelo = str_replace('{nacionalidade}', $contrato->nacionalidade, $this->txt_modelo);
        $this->txt_modelo = str_replace('{cnpj}', $contrato->cnpj, $this->txt_modelo);

        $this->txt_modelo = str_replace('{representate_comercial}', $socio->nome, $this->txt_modelo);
        //$this->txt_modelo = str_replace('{mas_fem}', 'a', $this->txt_modelo);
        $this->txt_modelo = str_replace('{profissao}', $socio->profissao, $this->txt_modelo);
        $this->txt_modelo = str_replace('{cpf}', $socio->cpf, $this->txt_modelo);
        $this->txt_modelo = str_replace('{telefone}', $socio->telefone, $this->txt_modelo);
        $this->txt_modelo = str_replace('{email}', $socio->email, $this->txt_modelo);
        $this->txt_modelo = str_replace('{tipo_contrato}', $contrato->dsc_tipo_contrato, $this->txt_modelo);

        $qnt_parcelas_txt = \projeto\Util::converteNumeroEmLetras($contrato->qnt_parcelas, false);
        $meses = $contrato->qnt_parcelas . ' (' . $qnt_parcelas_txt . ')';
        $this->txt_modelo = str_replace('{qnt_parcelas}', $meses, $this->txt_modelo);

        $valor_isencao = \projeto\Util::converteNumeroEmLetras('2500.00');

        $this->txt_modelo = str_replace('{valor_isencao}', '2.500,00 (' . $valor_isencao . ')', $this->txt_modelo);

        $valor_total = \projeto\Util::decimalFormatToBank($contrato->valor_contrato);

        $valor_total_desc = \projeto\Util::converteNumeroEmLetras($contrato->valor_contrato);
        $this->txt_modelo = str_replace('{valor_total_contrato}', $valor_total . ' (' . $valor_total_desc . ')', $this->txt_modelo);


        //{dia_primeira_parcela}

        $qnt_parcelas_txt = \projeto\Util::converteNumeroEmLetras($contrato->qnt_parcelas);
        $meses = $contrato->qnt_parcelas . ' (' . $qnt_parcelas_txt . ')';
        $this->txt_modelo = str_replace('{num_parcelas}', $meses, $this->txt_modelo);
        
        if($contrato->valor_contrato && $contrato->qnt_parcelas){
            $parcela = $contrato->valor_contrato / $contrato->qnt_parcelas;
        }
        $valor_parcela = \projeto\Util::decimalFormatToBank($parcela);
        $parcela_txt = \projeto\Util::converteNumeroEmLetras($parcela);
        $this->txt_modelo = str_replace('{prestacao}', $valor_parcela . ' (' . $parcela_txt . ')', $this->txt_modelo);

        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $date = date('Y-m-d');
        $date = strftime("%d de %B de %Y", strtotime($date));
        $this->txt_modelo = str_replace('{data}', $date, $this->txt_modelo);

        $date = strftime("%d de %B de %Y", strtotime(\projeto\Util::formataDataParaBanco($dt_parcelas->dt_vencimento)));

        $this->txt_modelo = str_replace('{dia_primeira_parcela}', $date, $this->txt_modelo);




        // print_r($contrato->attributes); exit;
//        razao_social
//        logradouro
//        numero
//        bairro
//        municipio
//        estado
//        cep
//        cnpj
//        representante_comercial
//        mas_fem
//        profissao
//        cpf
//        telefone
//        email
//        valor_isencao
//      
    }

}
