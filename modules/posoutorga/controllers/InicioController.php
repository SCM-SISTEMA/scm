<?php

namespace app\modules\posoutorga\controllers;

use Yii;
use projeto\web\Controller;

class InicioController extends Controller
{
    public function actionIndex()
    {
        $mes = date('m');
        if($mes == 1){
            $ano = date('Y')-1;
            $mes = '12';
        }else{
            $ano = date('Y');
            $mes = date('m')-1;
        }
        $mesano = str_pad($mes, 2, '0', 0).'/'.$ano;
  
        $total = \app\modules\posoutorga\models\TabSiciSearch::find()->where(['mes_ano_referencia'=>$mesano])->count();
        
        $totalE = \app\modules\posoutorga\models\TabSiciSearch::find()->where(['mes_ano_referencia'=>$mesano, 'situacao_fk'=>\app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'E')])->count();
        
        $totalP = \app\modules\posoutorga\models\TabSiciSearch::find()->where(['mes_ano_referencia'=>$mesano, 'situacao_fk'=>\app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'P')])->count();
        
        $totalC = \app\modules\posoutorga\models\TabSiciSearch::find()->where(['mes_ano_referencia'=>$mesano, 'situacao_fk'=>\app\models\TabAtributosValoresSearch::getAtributoValorAtributo('situacao-sici', 'C')])->count();
        
        
        return $this->render('index', compact('total','totalP','totalE','totalC'));
    }
}
