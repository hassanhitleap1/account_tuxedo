<?php

use Carbon\Carbon;
use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\user\User;

$users = ArrayHelper::map(User::find()->all(), 'id', 'name');


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

/** @var yii\web\View $this */
/** @var app\models\WorkingHours $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="working-hours-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                'data' => $users,
                'language' => 'en',
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter  date ...', 'value' => $date],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?>

        </div>
    </div>


    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'start_time')->input('time') ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'end_time')->input('time') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
        </div>

    </div>













    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>