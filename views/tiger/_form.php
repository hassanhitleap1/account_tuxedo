<?php

use Carbon\Carbon;
use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$today = Carbon::now("Asia/Amman");
if ($model->isNewRecord) {
    if ($today->hour < 3) {
        $date = $today->subDay()->toDateString();
    } else {
        $date = $today->toDateString();
    }
} else {
    $date = $model->date;
}
use app\models\user\User;

$users = ArrayHelper::map(User::find()->all(), 'id', 'name');

/** @var yii\web\View $this */
/** @var app\models\Tiger $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tiger-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => $users,
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
                'options' => ['placeholder' => 'Enter  date ...', 'value' => $date],
                'pluginOptions' => [
                    'language' => 'en',
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>
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