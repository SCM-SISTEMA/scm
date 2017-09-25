<?php

namespace app\modules\comercial\controllers;

use Yii;
use app\modules\comercial\models\TabTipoContratoResponsavel;
use app\modules\comercial\models\TabTipoContratoResponsavelSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoContratoResponsavelController implements the CRUD actions for TabTipoContratoResponsavel model.
 */
class TipoContratoResponsavelController extends Controller
{

    /**
     * Lists all TabTipoContratoResponsavel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabTipoContratoResponsavelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$this->titulo = 'Gerenciar TipoContratoResponsavel';
		$this->subTitulo = '';
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabTipoContratoResponsavel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$this->titulo = 'Detalhar TipoContratoResponsavel';
		$this->subTitulo = '';
			
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
	
	/**
	 * Creates e Updates a new TabTipoContratoResponsavel  model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionAdmin( $id = null )
	{

		if ($id)
		{
		
			$model = $this->findModel($id);
			$acao = 'update';
			$this->titulo = 'Alterar TipoContratoResponsavel';
			$this->subTitulo = '';
		}
		else
		{
		
			$acao = 'create';
			$model = new TabTipoContratoResponsavel();
			$this->titulo = 'Incluir TipoContratoResponsavel';
			$this->subTitulo = '';
		}

		if ($model->load( Yii::$app->request->post() ) && $model->save())
		{

			$this->session->setFlashProjeto( 'success', $acao );
			return $this->redirect( ['view', 'id' => $model->cod_responsavel_tipo_contrato ]);
		}

		return $this->render( 'admin', [
				'model' => $model,
			] );
	}
	
	
	
    /**
     * Creates a new TabTipoContratoResponsavel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabTipoContratoResponsavel();

		$this->titulo = 'Incluir TipoContratoResponsavel';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$this->session->setFlashProjeto( 'success', 'update' );
			
            return $this->redirect(['view', 'id' => $model->cod_responsavel_tipo_contrato]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabTipoContratoResponsavel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	
		$this->titulo = 'Alterar TipoContratoResponsavel';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			$this->session->setFlashProjeto( 'success', 'update' );
            
			return $this->redirect(['view', 'id' => $model->cod_responsavel_tipo_contrato]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabTipoContratoResponsavel model.
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
     * Finds the TabTipoContratoResponsavel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabTipoContratoResponsavel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabTipoContratoResponsavel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
