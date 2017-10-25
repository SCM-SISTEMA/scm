<?php

namespace app\modules\comercial\controllers;

use Yii;
use projeto\web\Controller;

class InicioController extends Controller {

    public function actionIndex() {

        $ano = date('Y');
        $mes = date('m');

        $mesano = str_pad($mes, 2, '0', 0) . '/' . $ano;

        $total = \app\modules\comercial\models\TabContratoSearch::find()->where(["to_char(dt_inclusao, 'MM/YYYY')" => $mesano])->count();

        $totalN = \app\modules\comercial\models\TabContratoSearch::find()->where(["to_char(dt_inclusao, 'MM/YYYY')" => $mesano, "status" => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '1')])->count();

        $totalR = \app\modules\comercial\models\TabContratoSearch::find()->where(["to_char(dt_inclusao, 'MM/YYYY')" => $mesano, "status" => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '2')])->count();

        $totalF = \app\modules\comercial\models\TabContratoSearch::find()->where(["to_char(dt_inclusao, 'MM/YYYY')" => $mesano, "status" => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '3')])->count();

        $totalFF = \app\modules\comercial\models\TabContratoSearch::find()->where(["to_char(dt_inclusao, 'MM/YYYY')" => $mesano, "status" => \app\models\TabAtributosValoresSearch::getAtributoValorAtributo('status-contrato', '4')])->count();

        $totalF = +$totalFF;

        return $this->render('index', compact('total', 'totalN', 'totalR', 'totalF'));
    }

}
