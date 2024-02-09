<?php

use Carbon\Carbon;
use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TypesOfExpenses;
use app\models\user\User;

$users = ArrayHelper::map(User::find()->all(), 'id', 'name');

$months = [
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4,
    5 => 5,
    6 => 6,
    7 => 7,
    8 => 8,
    9 => 9,
    10 => 10,
    11 => 11,
    12 => 12,
];

$today = Carbon::now("Asia/Amman");

$month = $today->month;
$session = Yii::$app->session;
if ($model->isNewRecord) {
    if ($today->hour < 3) {
        $date = $today->subDay()->toDateString();
        $month = $today->month;
    } elseif ($session->has('date')) {
        $dateCarbon = Carbon::parse($session->get('date'));
        $date = $dateCarbon->toDateString();
        $session->remove('date');
    } else {
        $date = $today->toDateString();
    }


} else {
    $date = $model->date;
    $month = $model->month;
}


$types = ArrayHelper::map(TypesOfExpenses::find()->all(), 'id', 'name');



/** @var yii\web\View $this */
/** @var app\models\Expenses $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="expenses-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => "name"]) ?>
        </div>
        <div class="col-6">

            <?= $form->field($model, 'type_id')->widget(Select2::classname(), [
                'data' => $types,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a state ...', "id" => "type_id"],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => $users,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true,

                ],
            ]); ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'month')->dropDownList($months, ['prompt' => 'ارجوالتحديد', 'value' => $month]); ?>

        </div>
        <div class="col-3">
            <?= $form->field($model, 'charity_account')->dropDownList([0 => "لا", 1 => "نعم"]); ?>

        </div>

    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter  date ...', 'value' => $date],
                'language' => 'en',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',

                ]
            ]); ?>
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