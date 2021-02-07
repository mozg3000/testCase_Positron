<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $form yii\widgets\ActiveForm */
// var_dump($status->errors);
?>

<div class="books-form">

    <?php $form = ActiveForm::begin([
		//'enableAjaxValidation'=>false,
	]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'page_count')->textInput() ?>

    <?= $form->field($model, 'publishedDate')->textInput() ?>

    <?= $model->thumbnail?Html::img('@web/thumbnails/'.$model->isbn .'/'.$model->thumbnail,[
		'alt' => 'book\'s thumbnail',
		'width' => '100px',
	  ]):'';?>
	
	<?= $form->field($model,'image')->fileInput()?>

    <?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'long_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($status, 'name')->textInput() ?>
    <?= $form->field($model, 'authorsList')->textInput() ?>
    <?= $form->field($model, 'categoriesList')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
