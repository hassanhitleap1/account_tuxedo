<?php

use app\models\User;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use app\models\Discounts;
use app\models\Employees;
use yii\grid\ActionColumn;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\DiscountsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$users = ArrayHelper::map(User::find()->all(), 'id', 'name');

$this->title = Yii::t('app', 'Discounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="discounts-index">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Discounts'), ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'user_id', // Replace with your attribute
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'language' => 'en',
                    'attribute' => 'user_id', // Replace with your attribute
                    'data' => $users,
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value' => function ($model) {
                        return $model->employee->name;
                    },
            ],
            'note:ntext',
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
                'urlCreator' => function ($action, Discounts $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>