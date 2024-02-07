<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\Expenses;
use app\models\Employees;
use yii\grid\ActionColumn;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\TypesOfExpenses;
use kartik\daterange\DateRangePicker;

/** @var yii\web\View $this */
/** @var app\models\ExpensesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Expenses');
$this->params['breadcrumbs'][] = $this->title;
$employees = ArrayHelper::map(Employees::find()->all(), 'id', 'name');
$types = ArrayHelper::map(TypesOfExpenses::find()->all(), 'id', 'name');
$date = "";
if (isset($_GET['date_range'])) {
    $date = $_GET['date_range'];
}
?>
<div class="expenses-index">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Expenses'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $form = ActiveForm::begin([
        'action' => ['expenses/index'],
        'method' => 'get',
        'id' => "form-date"

    ]); ?>
    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8">
            <?php
            $addon = <<<HTML
<span class="input-group-text">
    <i class="fas fa-calendar-alt"></i>
</span>
HTML;
            echo '<label class="control-label">Date Range</label>';
            echo '<div class="input-group drp-container">';
            echo DateRangePicker::widget([
                'name' => 'date_range',
                'language' => "en",
                'value' => $date,
                'convertFormat' => true,
                'useWithAddon' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'y-m-d',
                        'separator' => '+',
                    ],
                    'opens' => 'left'
                ]
            ]) . $addon;
            echo '</div>';
            echo '</div>';



            ?>
            <div class="col-md-4">
                <button class="btn btn-success">
                    <?= Yii::t('app', "Search") ?>
                </button>
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
                'name',


                [
                    'attribute' => 'type_id', // Replace with your attribute
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'language' => 'en',
                        'attribute' => 'type_id', // Replace with your attribute
                        'data' => $types,
                        'options' => ['placeholder' => 'Select a type ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function ($model) {
                    return $model->typeOfExpense->name;
                },
                ],


                [
                    'attribute' => 'user_id', // Replace with your attribute
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'language' => 'en',
                        'attribute' => 'user_id', // Replace with your attribute
                        'data' => $employees,
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'value' => function ($model) {
                    return $model->employee->name ?? '';
                },
                ],

                [
                    'label' => Yii::t('app', 'Amount'), // Footer label
                    'attribute' => 'amount',
                    'value' => function ($model) {
                    return $model->amount;
                },
                    'footer' => $dataProvider->query->sum('amount'),
                ],
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
                'month',
                //'note:ntext',
                //'date',
                //'created_at',
                //'updated_at',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Expenses $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

    </div>