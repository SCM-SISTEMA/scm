<?php

namespace projeto\db;

use app\modules\drenagem\models\TabCampoMultiOpcoes;
use app\models\VisGlossarios;
use app\models\VisAtributosValores;
use projeto\Util;

class ActiveRecord extends \yii\db\ActiveRecord {

    use \projeto\Atalhos;

    // timestamps
    const AUDIT_CAMPO_INCLUSAO = 'dt_inclusao';
    const AUDIT_CAMPO_ALTERACAO = 'dt_alteracao';
    // usuário última alteração
    const AUDIT_CAMPO_USUARIO = 'txt_login_inclusao';
    const AUDIT_CAMPO_USUARIO_ALTERACAO = 'txt_login_alteracao';

    public function init() {

        parent::init();

        $this->configAtalhos();
    }

    public static function findOneAsArray(array $where = []) {
        return static::find()->where($where)->asArray()->one();
    }

    public static function findAllAsArray(array $where = []) {
        return static::find()->where($where)->orderBy('')->asArray()->all();
    }

    public function afterFind() {
        parent::afterFind();

        if ($this->getTableSchema()->columns) {
            foreach ($this->getTableSchema()->columns as $key => $value) {
                if ($value->type == 'date' && $this->$key) {

                    $this->$key = self::formataDataDoBanco($this->$key);
                }
            }
        }
        return true;
    }

    public function beforeSave($insert) {

        if ($this->getTableSchema()->columns) {
            foreach ($this->getTableSchema()->columns as $key => $value) {

                if ($this->isNewRecord && $value->name == 'txt_login_inclusao' && !\Yii::$app->user->isGuest) {

                    $this->$key = $this->user->identity->getId();
                    $this->txt_login_alteracao = $this->user->identity->getId();
                } elseif (!$this->isNewRecord && $value->name == 'txt_login_alteracao') {
                    $this->$key = $this->user->identity->getId();
                    $this->dt_alteracao = date('d/m/Y');
                }

                if ($value->type == 'date' && $this->$key) {

                    $this->$key = self::formataDataParaBanco($this->$key);
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public static function decimalFormatForBank($string) {
        if ($string != ",") {
            $string = str_replace(',', '.', str_replace('.', '', $string));
        } else {
            $string = null;
        }

        return $string;
    }

    public static function decimalFormatToBank($string) {
        if ($string) {
            $string = number_format($string, 2, ',', '.');
        }

        return $string;
    }

    public static function formataDataParaBanco($data) {
        $date = explode('/', $data);

        if ($date[0]) {
            $date = $date[2] . '-' . $date[1] . '-' . $date[0];
        } else {
            $date = null;
        }
        return $date;
    }

    public static function formataDataDoBanco($data) {
        $date = explode('-', $data);

        if ($date[0]) {
            $date = $date[2] . '/' . $date[1] . '/' . $date[0];
        } else {
            $date = null;
        }
        return $date;
    }

    /**
     * Carrega a descrição das chaves estrangeiras 
     * da tabela de atributos valores dentro da model em questão
     *
     * static::carregarDescricaoAtributoValor(['atributo_fk' => 'dsc_atributo'])
     */
    public function carregarDescricaoAtributoValor(array $pares) {
        foreach ($pares as $attrFk => $attrDsc) {
            $_attrFk = strpos($this->$attrFk, '@') !== false ? \sinisa\Util::attrId($this->$attrFk) : $this->$attrFk
            ;
            $r = VisAtributosValores::find()
                    ->where(['cod_atributos_valores' => $_attrFk])
                    ->asArray()
                    ->one()
            ;
            $this->$attrDsc = $r['dsc_descricao'];
        }
    }

    public function verificarChecks($checado = true) {

        $checar = function ($vals, $checado) {

            foreach ($vals as $key => $val) {

                if (strpos($key, '_check') !== false) {

                    if (!$checado) {
                        $this->$key = true;
                    }

                    if ($this->$key == false) {
                        return false;
                    }
                }
            }

            return true;
        };

        return $checar($this->attributes, $checado);
    }

    public function getErrosString() {

        foreach ($this->errors as $name => $es) {
            foreach ($es as $n => $e) {
                if (!empty($e)) {
                    $errors .= $e . '<br/>';
                }
            }
        }
        return $errors;
    }

}
