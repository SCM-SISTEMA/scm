<?php

namespace app\modules\posoutorga\controllers;

use Yii;
use app\modules\posoutorga\models\TabPlanosMenorMaior;
use app\modules\posoutorga\models\TabPlanosMenorMaiorSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanosMenorMaiorController implements the CRUD actions for TabPlanosMenorMaior model.
 */
class PlanosMenorMaiorController extends Controller
{

    /**
     * Lists all TabPlanosMenorMaior models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabPlanosMenorMaiorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$this->titulo = 'Gerenciar PlanosMenorMaior';
		$this->subTitulo = '';
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabPlanosMenorMaior model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$this->titulo = 'Detalhar PlanosMenorMaior';
		$this->subTitulo = '';
			
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
	
	/**
	 * Creates e Updates a new TabPlanosMenorMaior  model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionAdmin( $id = null )
	{

		if ($id)
		{
		
			$model = $this->findModel($id);
			$acao = 'update';
			$this->titulo = 'Alterar PlanosMenorMaior';
			$this->subTitulo = '';
		}
		else
		{
		
			$acao = 'create';
			$model = new TabPlanosMenorMaior();
			$this->titulo = 'Incluir PlanosMenorMaior';
			$this->subTitulo = '';
		}

		if ($model->load( Yii::$app->request->post() ) && $model->save())
		{

			$this->session->setFlashProjeto( 'success', $acao );
			return $this->redirect( ['view', 'id' => $model->cod_plano_menor_maior ]);
		}

		return $this->render( 'admin', [
				'model' => $model,
			] );
	}
	
	
	
    /**
     * Creates a new TabPlanosMenorMaior model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabPlanosMenorMaior();

		$this->titulo = 'Incluir PlanosMenorMaior';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$this->session->setFlashProjeto( 'success', 'update' );
			
            return $this->redirect(['view', 'id' => $model->cod_plano_menor_maior]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabPlanosMenorMaior model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	
		$this->titulo = 'Alterar PlanosMenorMaior';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			$this->session->setFlashProjeto( 'success', 'update' );
            
			return $this->redirect(['view', 'id' => $model->cod_plano_menor_maior]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabPlanosMenorMaior model.
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
     * Finds the TabPlanosMenorMaior model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabPlanosMenorMaior the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabPlanosMenorMaior::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
