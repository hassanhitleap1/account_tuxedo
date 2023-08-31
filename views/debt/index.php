<?php

use app\models\Debt;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use kartik\date\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\DebtSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Debts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="debt-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Debt'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'amount',
            'employee.name',
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
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Debt $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
