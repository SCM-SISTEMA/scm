<?php

namespace app\modules\comercial\controllers;

use app\models\TabAtributosSearch;
use app\modules\admin\controllers\AtributosValoresController;
use Yii;
use app\models\TabAtributosValores;
use app\models\TabAtributosValoresSearch;
use projeto\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoProdutoController implements the CRUD actions for TabAtributosValores model.
 */
class TipoProdutoController extends Controller
{

    public $id_atributo=TabAtributosSearch::TIPO_PRODUTO;
    /**
     * Lists all TabAtributosValores models.
     * @return mixed
     */
    public function actionIndex()
    {
       $searchModel = new TabAtributosValoresSearch(['fk_atributos_valores_atributos_id'=>$this->id_atributo]);
        ArrayHelper::merge(
            Yii::$app->request->queryParams,$searchModel
        );

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $this->titulo = 'Gerenciar produto';
        $this->subTitulo = '';



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabAtributosValores model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$this->titulo = 'Detalhar Produto';
		$this->subTitulo = '';
			
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
	
	/**
	 * Creates e Updates a new TabAtributosValores  model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionAdmin( $id = null )
	{

		if ($id)
		{
		
			$model = $this->findModel($id);
			$acao = 'update';
			$this->titulo = 'Alterar Produto';
			$this->subTitulo = '';
		}
		else
		{
		
			$acao = 'create';
			$model = new TabAtributosValoresSearch(['fk_atributos_valores_atributos_id'=>$this->id_atributo]);

            $this->titulo = 'Incluir Produto';
			$this->subTitulo = '';
		}

		if ($model->load( Yii::$app->request->post() ) && $model->save())
		{

			$this->session->setFlashProjeto( 'success', $acao );
			return $this->redirect( ['view', 'id' => $model->cod_atributos_valores ]);
		}

		return $this->render( 'admin', [
				'model' => $model,
			] );
	}
	
	
	
    /**
     * Creates a new TabAtributosValores model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabAtributosValoresSearch(['fk_atributos_valores_atributos_id'=>$this->id_atributo]);

		$this->titulo = 'Incluir Produto';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$this->session->setFlashProjeto( 'success', 'update' );
			
            return $this->redirect(['view', 'id' => $model->cod_atributos_valores]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabAtributosValores model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	
		$this->titulo = 'Alterar Produto';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			$this->session->setFlashProjeto( 'success', 'update' );
            
			return $this->redirect(['view', 'id' => $model->cod_atributos_valores]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabAtributosValores model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		
		$model = $this->findModel($id);
		$model->dte_exclusao = 'NOW()';
		
		if ($model->save())
		{
			
			$this->session->setFlashProjeto( 'success', 'delete' );
		}
		else
		{
			
			$this->session->setFlashProjeto( 'danger', 'delete' );
		}

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabAtributosValores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabAtributosValores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabAtributosValoresSearch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
