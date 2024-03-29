<?php

use app\models\User;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\user\User $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
        </div>
    </div>



    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'name')->textInput() ?>
        </div>

        <div class="col-6">
            <?= $form->field($model, 'salary')->textInput() ?>
        </div>
    </div>



    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'round_balance')->textInput() ?>


        </div>
        <div class="col-6">
            <?= $form->field($model, 'commission')->textInput() ?>
        </div>
    </div>


    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'work_start_time')->textInput() ?>

        </div>
        <div class="col-6">
            <?= $form->field($model, 'work_end_time')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'type')->dropDownList([User::USER => 'USER', User::SUPER_ADMIN => 'SUPER ADMIN']) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter  date ...'],
                'language' => 'en',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'pickerPosition' => 'top-right',

                ]
            ]); ?>

        </div>
    </div>





    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>