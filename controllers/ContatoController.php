<?php

namespace app\controllers;

use Yii;
use app\models\TabContato;
use app\models\TabContatoSearch;
use projeto\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContatoController implements the CRUD actions for TabContato model.
 */
class ContatoController extends Controller
{

    /**
     * Lists all TabContato models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabContatoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$this->titulo = 'Gerenciar Contato';
		$this->subTitulo = '';
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabContato model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$this->titulo = 'Detalhar Contato';
		$this->subTitulo = '';
			
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

	
	
	/**
	 * Creates e Updates a new TabContato  model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionAdmin( $id = null )
	{

		if ($id)
		{
		
			$model = $this->findModel($id);
			$acao = 'update';
			$this->titulo = 'Alterar Contato';
			$this->subTitulo = '';
		}
		else
		{
		
			$acao = 'create';
			$model = new TabContato();
			$this->titulo = 'Incluir Contato';
			$this->subTitulo = '';
		}

		if ($model->load( Yii::$app->request->post() ) && $model->save())
		{

			$this->session->setFlashProjeto( 'success', $acao );
			return $this->redirect( ['view', 'id' => $model->cod_contato ]);
		}

		return $this->render( 'admin', [
				'model' => $model,
			] );
	}
	
	
	
    /**
     * Creates a new TabContato model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabContato();

		$this->titulo = 'Incluir Contato';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			$this->session->setFlashProjeto( 'success', 'update' );
			
            return $this->redirect(['view', 'id' => $model->cod_contato]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TabContato model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	
		$this->titulo = 'Alterar Contato';
		$this->subTitulo = '';
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
		
			$this->session->setFlashProjeto( 'success', 'update' );
            
			return $this->redirect(['view', 'id' => $model->cod_contato]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TabContato model.
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
     * Finds the TabContato model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabContato the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabContato::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
