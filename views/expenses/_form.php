<?php

use Carbon\Carbon;
use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TypesOfExpenses;
$today=Carbon::now("Asia/Amman");
if($model->isNewRecord){
    if($today->hour < 3){
        $date= $today->subDay()->toDateString(); 
    }else{
        $date= $today->toDateString();  
    }
}else{
    $date= $model->date;  
}

$employees=ArrayHelper::map(Employees::find()->all(), 'id', 'name');
$types=ArrayHelper::map(TypesOfExpenses::find()->all(), 'id', 'name');

/** @var yii\web\View $this */
/** @var app\models\Expenses $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="expenses-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">

        <?= $form->field($model, 'type_id')->widget(Select2::classname(), [
            'data' => $types,
            'language' => 'en',
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
        <?= $form->field($model, 'employee_id')->widget(Select2::classname(), [
            'data' => $employees,
            'language' => 'en',
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true,

            ],
        ]); ?>
        </div>
        <div class="col-6">
        <?= $form->field($model, 'amount')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
        <?=  $form->field($model, 'date')->widget(DatePicker::classname(), [
           'options' => ['placeholder' => 'Enter  date ...', 'value'=> $date],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
            ]);?>
        </div>
        <div class="col-6">
        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
        </div>
    </div>


    

 



    




    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
