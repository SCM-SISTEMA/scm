<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace projeto\filters;

use Yii;
use yii\base\Action;
use projeto\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;
use app\modules\admin\models\VisUsuariosPerfisSearch;
use app\modules\admin\models\VisPerfisFuncionalidadesAcoesModulosSearch;

/**
 * AccessControl provides simple access control based on a set of rules.
 *
 * AccessControl is an action filter. It will check its [[rules]] to find
 * the first rule that matches the current context variables (such as user IP address, user role).
 * The matching rule will dictate whether to allow or deny the access to the requested controller
 * action. If no rule matches, the access will be denied.
 *
 * To use AccessControl, declare it in the `behaviors()` method of your controller class.
 * For example, the following declarations will allow authenticated users to access the "create"
 * and "update" actions and deny all other users from accessing these two actions.
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'access' => [
 *             'class' => \yii\filters\AccessControl::className(),
 *             'only' => ['create', 'update'],
 *             'rules' => [
 *                 // deny all POST requests
 *                 [
 *                     'allow' => false,
 *                     'verbs' => ['POST']
 *                 ],
 *                 // allow authenticated users
 *                 [
 *                     'allow' => true,
 *                     'roles' => ['@'],
 *                 ],
 *                 // everything else is denied
 *             ],
 *         ],
 *     ];
 * }
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AccessControl extends ActionFilter
{

	/**
	 * @var User|array|string the user object representing the authentication status or the ID of the user application component.
	 * Starting from version 2.0.2, this can also be a configuration array for creating the object.
	 */
	public $user = 'user';

	/**
	 * @var callable a callback that will be called if the access should be denied
	 * to the current user. If not set, [[denyAccess()]] will be called.
	 *
	 * The signature of the callback should be as follows:
	 *
	 * ```php
	 * function ($rule, $action)
	 * ```
	 *
	 * where `$rule` is the rule that denies the user, and `$action` is the current [[Action|action]] object.
	 * `$rule` can be `null` if access is denied because none of the rules matched.
	 */
	public $denyCallback;

	/**
	 * @var array the default configuration of access rules. Individual rule configurations
	 * specified via [[rules]] will take precedence when the same property of the rule is configured.
	 */
	public $ruleConfig = ['class' => 'yii\filters\AccessRule'];

	/**
	 * @var array a list of access rule objects or configuration arrays for creating the rule objects.
	 * If a rule is specified via a configuration array, it will be merged with [[ruleConfig]] first
	 * before it is used for creating the rule object.
	 * @see ruleConfig
	 */
	public $rules = [];

	/**
	 * Initializes the [[rules]] array by instantiating rule objects from configurations.
	 */
	public function init()
	{
		
		parent::init();
		$this->user = Instance::ensure($this->user, User::className());
		foreach ($this->rules as $i => $rule) {
			if (is_array($rule)) {
				$this->rules[$i] = Yii::createObject(array_merge($this->ruleConfig, $rule));
			}
		}

	}

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters.)
	 * You may override this method to do last-minute preparation for the action.
	 * @param Action $action the action to be executed.
	 * @return boolean whether the action should continue to be executed.
	 */
	public function beforeAction($action)
	{
		$user	 = $this->user;
		if ($user->getIsGuest()) {
			if($action->controller->id=='login' && $action->id=='index'){
				return true;
			}
			$this->denyAccess($user);
			return false;
			
		}
		elseif( (strpos($action->id, 'lista') === false || strpos($action->id, 'combo') === false)) {
			return true;
		}

		$codUsuario	 = $this->user->identity->getId();
		$moduloID	 = $action->controller->module->id;

		// consulta o usuário tem o módulo
		$userPerfil = VisUsuariosPerfisSearch::getUsuarioPerfilModulos($moduloID, $codUsuario);

		//verifica se o usuário pode acessar esse módulo e se o modulo esta na pagina inicial
		if ($userPerfil && $action->controller->id == 'inicio') {
			return true;
		}

		// consulta se o usuario tem perfil para acessar a acao da funcionalidade do modulo
		$acesso = VisPerfisFuncionalidadesAcoesModulosSearch::getUsrFuncionalidadesAcoesModulos([
			'moduloID'		 => $moduloID,
			'codUsuario'	 => $codUsuario,
			'controllerID'	 => $action->controller->id,
			'actionID'		 => $action->id,
		]);

		if ($acesso) {
			return true;
		} else {
			$this->denyAccess($user);
		}

		return false;
	}

	/**
	 * Denies the access of the user.
	 * The default implementation will redirect the user to the login page if he is a guest;
	 * if the user is already logged, a 403 HTTP exception will be thrown.
	 * @param User $user the current user
	 * @throws ForbiddenHttpException if the user is already logged in.
	 */
	protected function denyAccess($user)
	{
		if ($user->getIsGuest()) {
			$user->loginRequired();
		} else {
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
		}
	}
}
