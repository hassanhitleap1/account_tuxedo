<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\WorkingHours $model */

$this->title = Yii::t('app', 'Create Working Hours');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Working Hours'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
?>
<div class="working-hours-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  if($session->has('message')):?>
        <div class="alert alert-success"> <?= $session->get("message") ?> </div>
        <?php  $session->remove('message');?>

    <?php endif; ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
