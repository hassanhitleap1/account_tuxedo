<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Sales $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sales-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-6">
        <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-6">
        <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    


    <div class="row">
        <div class="col-6">
        <?=  $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter  date ...'],
            'language' => 'en',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'pickerPosition' => 'top-right',
            ]
            ]);?>

        </div>
        <div class="col-6">
        <?= $form->field($model, 'payment_method')->dropDownList(['cash' => 'cash', 'visa' => 'visa']) ?>

        </div>
    </div>
  

   


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
