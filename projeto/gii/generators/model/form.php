<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\form\Generator */

echo $form->field($generator, 'tableName');
echo $form->field($generator, 'modelClass');
echo $form->field($generator, 'ns');
echo $form->field($generator, 'baseClass');
echo $form->field($generator, 'db');
echo $form->field($generator, 'useTablePrefix')->checkbox();
echo $form->field($generator, 'generateRelations')->checkbox();
echo $form->field($generator, 'generateLabelsFromComments')->checkbox();
echo $form->field($generator, 'generateQuery')->checkbox();
echo $form->field($generator, 'queryNs');
echo $form->field($generator, 'queryClass');
echo $form->field($generator, 'queryBaseClass');
echo $form->field($generator, 'enableI18N')->checkbox();
echo $form->field($generator, 'messageCategory');
echo $form->field($generator, 'glossario')->checkbox();
echo "<div id='formularioGlossario'>";
echo $form->field($generator, 'form', ['inputOptions'=>['maxlength'=>2]]);
echo $form->field($generator, 'siglaModulo', ['inputOptions'=>['maxlength'=>4]]);
echo $form->field($generator, 'anoColeta', ['inputOptions'=>['maxlength'=>4]]);
echo '</div>';

if ( ! $generator->glossario) {
	$js = "$('#formularioGlossario').hide()";
	$this->registerJs($js, \yii\web\View::POS_LOAD);
}
	$js = "$('#generator-glossario').change(function() {
		if($( this ).is(':checked')){
			$('#formularioGlossario').show();
		}else{
			$('#formularioGlossario').hide();
		}
	});";
	$this->registerJs($js, \yii\web\View::POS_LOAD);


