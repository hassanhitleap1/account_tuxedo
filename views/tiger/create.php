<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tiger $model */

$this->title = Yii::t('app', 'Create Tiger');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tigers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tiger-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
