<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bonus $model */

$this->title = Yii::t('app', 'Create Bonus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bonuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bonus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
