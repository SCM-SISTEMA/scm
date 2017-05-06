<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use projeto\helpers\Html;
use projeto\web\View;
?>
<br />
<div class="login-box">
    <div class="login-box-body">
        <div class="row">
            <div class="col-md-12" style="color: red; text-align: center;">
                <?= Html::img('@web/img/logo_nome_branco.jpg') ?>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">	
                <?php
                $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'fieldConfig' => [
                                'template' => "<div>{input}</div>\n<div>{error}</div>",
                                'labelOptions' => ['class' => 'col-lg-1 control-label'],
                            ],
                ]);
                ?>
                <div class="form-group has-feedback">
                    <?= $form->field($model, 'txt_login')->textInput(['placeholder' => "Login"]); ?>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <?= $form->field($model, 'txt_senha')->passwordInput(['placeholder' => "Senha"]) ?>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group">
                    <?php /* if (false): ?>
                      <div class="row">
                      <div class="col-md-12">
                      <?= \himiklab\yii2\recaptcha\ReCaptcha::widget([
                      'name' => 'reCaptcha',
                      'widgetOptions' => ['class' => 'col-md-2']
                      ]) ?>
                      </div>
                      </div>
                      <p>&nbsp;</p>
                      <?php endif */ ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?=
                            Html::a(Html::icon('refresh', 'Esqueceu a senha?'), 'recuperar-senha', [
                                'class' => 'btn btn-default btn-block btn-flat'
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                            Html::submitButton(Html::icon('log-in', '&nbsp;Entrar'), [
                                'class' => ' btn btn-success btn-block btn-flat',
                                'name' => 'login-button'
                            ])
                            ?>
                        </div>
                    </div>

                   
                </div>

                <?php ActiveForm::end(); ?>

            </div>

            
        </div>
    </div>
</div>

<?php $this->registerJs("$('#mdlusuarios-txt_login').focus();", View::POS_READY) ?>

