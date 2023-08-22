<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WorkingHours $model */

$this->title = Yii::t('app', 'Create Working Hours');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Working Hours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="working-hours-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
