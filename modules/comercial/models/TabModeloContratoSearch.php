<?php

namespace app\modules\comercial\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\comercial\models\TabModeloContrato;

/**
 * TabModeloContratoSearch represents the model behind the search form about `app\modules\comercial\models\TabModeloContrato`.
 */
class TabModeloContratoSearch extends TabModeloContrato {

    public $cod_contrato_fk;
    public $assinatura;

    /**
     * @inheritdoc
     */
    public function rules() {

        $rules = [
                //exemplo [['txt_nome', 'cod_modulo_fk'], 'required'],
        ];

        return array_merge($rules, parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {

        $labels = [
                //exemplo 'campo' => 'label',         
        ];

        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
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

        $query->andWhere($this->tableName() . '.dt_exclusao IS NULL');

        return $dataProvider;
    }

    public function substituiVariaveis($contrato) {
        $endereco = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $contrato->cod_cliente, 'tipo_tabela_fk' => \app\models\TabClienteSearch::tableName()])->one();
        $socio = TabSociosSearch::find()->where(['cod_cliente_fk' => $contrato->cod_cliente, 'representante_comercial' => true])->all();
        $dt_parcelas = TabContratoParcelasSearch::find()->where(['numero' => '1', 'cod_contrato_fk' => $contrato->cod_contrato])->one();

        $mode = TabModeloContratoSearch::find()->all();

//        foreach ($mode as $key => $value) {
//            $value->txt_modelo = str_replace('{razao social}', '{razao_social}', $value->txt_modelo);
//            $value->save();
//        }

        //print_r($contrato->razao_social); exit;
        $this->txt_modelo = str_replace('{razao_social}', strtoupper($contrato->razao_social), $this->txt_modelo);
        $this->txt_modelo = str_replace('{logradouro}', $endereco->logradouro, $this->txt_modelo);
        $this->txt_modelo = str_replace('{numero}', $endereco->numero, $this->txt_modelo);
        $this->txt_modelo = str_replace('{bairro}', $endereco->bairro, $this->txt_modelo);
        $this->txt_modelo = str_replace('{municipio}', $endereco->tabMunicipios->txt_nome, $this->txt_modelo);
        $this->txt_modelo = str_replace('{estado}', $endereco->tabMunicipios->sgl_estado_fk, $this->txt_modelo);
        $this->txt_modelo = str_replace('{cep}', $endereco->cep, $this->txt_modelo);
        $this->txt_modelo = str_replace('{cnpj}', $contrato->cnpj, $this->txt_modelo);

        $this->txt_modelo = str_replace('{tipo_contrato}', $contrato->dsc_tipo_contrato, $this->txt_modelo);

        $this->txt_modelo = str_replace('{socios}', $this->geraHtmlSocios($socio), $this->txt_modelo);
        $this->txt_modelo = str_replace('{assinatura}', $this->geraHtmlAssinatura($socio, $contrato->razao_social), $this->txt_modelo);


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

        if ($contrato->valor_contrato && $contrato->qnt_parcelas) {
            $parcela = $contrato->valor_contrato / $contrato->qnt_parcelas;
        }
        $valor_parcela = \projeto\Util::decimalFormatToBank($parcela);
        $parcela_txt = \projeto\Util::converteNumeroEmLetras($parcela);
        $this->txt_modelo = str_replace('{prestacao}', $valor_parcela . ' (' . $parcela_txt . ')', $this->txt_modelo);

        $parcelas = TabContratoParcelasSearch::find()->where(['cod_contrato_fk' => $contrato->cod_contrato])->asArray()->all();

        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');
        if ($parcelas) {
            $this->txt_modelo = str_replace('{tabela_parcelas}', $this->geraHtml($parcelas), $this->txt_modelo);
        }


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

    public static function geraHtml($parcelas) {


        foreach ($parcelas as $key => $value) {
            $date = strftime("%d de %B de %Y", strtotime($value['dt_vencimento']));

            $htmlParcelas .= '<tr valign="top">
                    <td width="25">
                        <p align="justify">
                            ' . $value['numero'] . '
                        </p>
                    </td>
                    <td width="75">
                        <p align="justify">
                        R$ ' . \projeto\Util::decimalFormatToBank($value['valor']) . '
                        </p>
                    </td>
                    <td width="200">
                        <p align="justify">
                            ' . \projeto\Util::converteNumeroEmLetras($value['valor']) . '
                        </p>
                    </td>
                    <td width="171">
                        <p align="left">
                            ' . $date . '
                        </p>
                    </td>
                </tr>';
        }

        return ' <dl>
    <dd>
        <table width="527" cellpadding="7" border="1" cellspacing="0">
            <colgroup>
                <col width="25"/>
                <col width="75"/>
                <col width="200"/>
                <col width="171"/>
            </colgroup>
            <tbody>
                <tr valign="top">
                    <td width="25">
                        <p align="justify">
                            Nº
                        </p>
                    </td>
                    <td width="75">
                        <p align="justify">
                            Valor
                        </p>
                    </td>
                    <td width="200">
                        <p align="justify">
                            Descrição
                        </p>
                    </td>
                    <td width="171">
                        <p align="justify">
                            Data de Vencimento
                        </p>
                    </td>
                </tr>
                ' . $htmlParcelas . '
                
            </tbody>
        </table>
    </dd>
</dl>';
    }

    public static function geraHtmlSocios($socios) {

        $html = "<strong>{representate_comercial}</strong>, {nacionalidade}, {estado_civil},
    {profissao}, RG nº {rg} SSP/{ssp} CPF nº{cpf} Residente e Domiciliado na(o) {logradouro_r}
    nº{numero_r}, Bairro: {bairro_r} Cidade: {municipio_r}/{estado_r}, CEP:
{cep_r}, Fone: {telefone} e EMAIL  {email}";
        foreach ($socios as $key => $socio) {

            $txt_modelo = $html;

            if ($key > 0) {
                $txt_modelo = ' e por ' . $txt_modelo;
            }
            $txt_modelo = str_replace('{representate_comercial}', $socio->nome, $txt_modelo);
            $txt_modelo = str_replace('{ssp}', $socio->orgao_uf, $txt_modelo);

            $estado = \app\models\TabAtributosValoresSearch::find()->where(['cod_atributos_valores' => $socio->estado_civil_fk])->asArray()->one();
            $txt_modelo = str_replace('{estado_civil}', $estado['dsc_descricao'], $txt_modelo);

            $txt_modelo = str_replace('{nacionalidade}', $socio->nacionalidade, $txt_modelo);
            $txt_modelo = str_replace('{rg}', $socio->rg, $txt_modelo);
            $txt_modelo = str_replace('{nacionalidade}', $socio->nacionalidade, $txt_modelo);
            $txt_modelo = str_replace('{profissao}', $socio->profissao, $txt_modelo);
            $txt_modelo = str_replace('{cpf}', $socio->cpf, $txt_modelo);
            $txt_modelo = str_replace('{telefone}', $socio->telefone, $txt_modelo);
            $txt_modelo = str_replace('{email}', $socio->email, $txt_modelo);

            $endereco_r = \app\models\TabEnderecoSearch::find()->where(['chave_fk' => $socio->cod_socio, 'tipo_tabela_fk' => TabSociosSearch::tableName()])->one();

            if ($endereco_r) {
                $txt_modelo = str_replace('{logradouro_r}', $endereco_r->logradouro, $txt_modelo);
                $txt_modelo = str_replace('{numero_r}', $endereco_r->numero, $txt_modelo);
                $txt_modelo = str_replace('{bairro_r}', $endereco_r->bairro, $txt_modelo);
                $txt_modelo = str_replace('{municipio_r}', $endereco_r->tabMunicipios->txt_nome, $txt_modelo);
                $txt_modelo = str_replace('{estado_r}', $endereco_r->tabMunicipios->sgl_estado_fk, $txt_modelo);
                $txt_modelo = str_replace('{cep_r}', $endereco_r->cep, $txt_modelo);
            }
            $htmlModelo .= $txt_modelo;
        }

        return $htmlModelo;
    }

    public static function geraHtmlAssinatura($socios, $razao_social = null) {

        $html = '<br /><br /><p align="center">
    <strong>_______________________________________________</strong>
</p>
<p align="center">
    <strong>{razao_social}</strong>
</p><br/><br/>';

        if (count($socios) > 1) {
            foreach ($socios as $key => $socio) {

                $txt_modelo = $html;

                $txt_modelo = str_replace('{razao_social}', $socio->nome, $txt_modelo);

                $htmlModelo .= $txt_modelo;
            }
        } else {
            $txt_modelo = str_replace('{razao_social}', $razao_social, $html);
            $htmlModelo .= $txt_modelo;
        }
       
        return $htmlModelo;
    }

}
