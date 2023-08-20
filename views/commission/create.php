<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Commission $model */

$this->title = Yii::t('app', 'Create Commission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
