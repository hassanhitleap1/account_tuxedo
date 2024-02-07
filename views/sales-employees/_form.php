<?php

use Carbon\Carbon;
use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$employees = ArrayHelper::map(Employees::find()->all(), 'id', 'name');
$today = Carbon::now("Asia/Amman");
$session = Yii::$app->session;
if ($model->isNewRecord) {
    if ($today->hour < 3) {
        $date = $today->subDay()->toDateString();
    } elseif ($session->has('date')) {
        $dateCarbon = Carbon::parse($session->get('date'));
        $date = $dateCarbon->toDateString();
        $session->remove('date');
    } else {
        $date = $today->toDateString();
    }
} else {
    $date = $model->date;
}
/** @var yii\web\View $this */
/** @var app\models\SalesEmployees $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sales-employees-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => $employees,
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

            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'language' => 'en',
                'options' => ['placeholder' => 'Enter  date ...', 'value' => $date],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'pickerPosition' => 'top-right',
                ]
            ]); ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'tiger')->textInput() ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'payment_method')->dropDownList(['cash' => 'cash', 'visa' => 'visa']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
        </div>


    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>