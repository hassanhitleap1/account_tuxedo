<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Sales $model */

$this->title = Yii::t('app', 'Create Sales');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
