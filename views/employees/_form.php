<?php

use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;



/** @var yii\web\View $this */
/** @var app\models\Employees $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="employees-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'salary')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'commission')->textInput() ?>
        </div>
        
        <div class="col-6">
            <?= $form->field($model, 'round_balance')->textInput() ?>
        </div>
        <div class="col-6">
            <?=  $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter  date ...'],
                'language' => 'en',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'pickerPosition' => 'top-right',
                    
                ]
            ]);?>
        </div>
    </div>


    <div class="row">
        <div class="col-6">
        <?=$form->field($model, 'work_start_time')->widget(\janisto\timepicker\TimePicker::className(), [
            'language' => 'en',
            'mode' => 'time',
            'clientOptions'=>[
                'timeFormat' => 'HH:mm:ss',
                'showSecond' => true,
            ]
        ]);?>
        </div>
        <div class="col-6">
        <?=$form->field($model, 'work_end_time')->widget(\janisto\timepicker\TimePicker::className(), [
            'language' => 'en',
            'mode' => 'time',
            'clientOptions'=>[
                'timeFormat' => 'HH:mm:ss',
                'showSecond' => true,
            ]
        ]);?>
        </div>
    </div>

  






    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
