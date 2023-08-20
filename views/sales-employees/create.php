<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\SalesEmployees $model */

$this->title = Yii::t('app', 'Create Sales Employees');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-employees-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
