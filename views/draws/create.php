<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Draws $model */

$this->title = Yii::t('app', 'Create Draws');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Draws'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draws-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
