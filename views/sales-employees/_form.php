<?php

use Carbon\Carbon;
use yii\helpers\Html;
use app\models\Employees;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$employees=ArrayHelper::map(Employees::find()->all(), 'id', 'name');
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
        <?= $form->field($model, 'employee_id')->widget(Select2::classname(), [
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
 
        <?=  $form->field($model, 'date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Enter  date ...', 'value'=> $date],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                ]
            ]);?>
        </div>
        <div class="col-6">
        <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <button id="addDay" onclick="addDay()">Add Day</button>
    <button id="subtractDay" onclick="subtractDay()">Subtract Day</button>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function() {
        $("#datepicker").datepicker();
    });

    function addDay() {
        var selectedDate = $("#datepicker").datepicker("getDate");
        if (selectedDate !== null) {
            selectedDate.setDate(selectedDate.getDate() + 1);
            $("#datepicker").datepicker("setDate", selectedDate);
        }
    }

    function subtractDay() {
        var selectedDate = $("#datepicker").datepicker("getDate");
        if (selectedDate !== null) {
            selectedDate.setDate(selectedDate.getDate() - 1);
            $("#datepicker").datepicker("setDate", selectedDate);
        }
    }
</script>



</body>
