<?php

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\Employees;
use yii\grid\ActionColumn;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use app\models\WorkingHours;
use yii\helpers\ArrayHelper;
/** @var yii\web\View $this */
/** @var app\models\WorkingHoursSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$employees=ArrayHelper::map(Employees::find()->all(), 'id', 'name');

$this->title = Yii::t('app', 'Working Hours');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-hours-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Working Hours'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
          
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
                   return  $model->employee->name??'';
                },
            ],
            'start_time',
            'end_time',
            // 'note:ntext',
     
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
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, WorkingHours $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
