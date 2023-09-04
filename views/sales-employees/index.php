<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\Employees;
use yii\grid\ActionColumn;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\SalesEmployees;
use kartik\daterange\DateRangePicker;
/** @var yii\web\View $this */
/** @var app\models\SalesEmployeesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$employees=ArrayHelper::map(Employees::find()->all(), 'id', 'name');
$this->title = Yii::t('app', 'Sales Employees');
$this->params['breadcrumbs'][] = $this->title;

$date="";
if(isset($_GET['date_range'])){
    $date =$_GET['date_range'];
}
?>
<div class="sales-employees-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Sales Employees'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin([
            'action' => ['expenses/index'],
            'method' => 'get',
            'id'=>"form-date"
            
        ]); ?>
<div class="row">
<div class="col-xl-8 col-lg-8 col-md-8">
<?php
$addon = <<< HTML
<span class="input-group-text">
    <i class="fas fa-calendar-alt"></i>
</span>
HTML;
echo '<label class="control-label">Date Range</label>';
echo '<div class="input-group drp-container">';
echo DateRangePicker::widget([
    'name'=>'date_range',
    'language'=>"en",
    'value'=> $date,
    'convertFormat'=>true,
    'useWithAddon'=>true,
    'pluginOptions'=>[
        'locale'=>[
            'format' => 'y-m-d',
            'separator'=>'+',
        ],
        'opens'=>'left'
    ]
]) . $addon;
echo '</div>'; 
echo '</div>'; 



?>
<div class="col-md-4">
    <button class="btn btn-success"><?=Yii::t('app',"Search")?></button>
</div>

<?php ActiveForm::end(); ?>
</div>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'amount',
        

            [
                'label' => Yii::t('app', 'Amount'), // Footer label
                'attribute' => 'amount',
                'value' => function ($model) {
                    return $model->amount;
                },
                'footer' =>  $dataProvider->query->sum('amount'),
            ],

            [
                'label' => Yii::t('app', 'Tiger'), // Footer label
                'attribute' => 'tiger',
                'value' => function ($model) {
                    return $model->tiger;
                },
                'footer' =>  $dataProvider->query->sum('tiger'),
            ],

            [
                'attribute' => 'employee_id', // Replace with your attribute
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'language' => 'en',
                    'attribute' => 'employee_id', // Replace with your attribute
                    'data' => $employees,
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value'=> function($model){
                   return  $model->employee->name;
                },
            ],

            'note',

            [
                'attribute' => 'date', // Replace with your attribute
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'language' => 'en',
                    'attribute' => 'date', // Replace with your attribute
                    'pluginOptions' => [
                        'language' => 'en',
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ]),
            ],
            // 'date',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SalesEmployees $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
