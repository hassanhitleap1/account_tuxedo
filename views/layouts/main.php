<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php 
$menuItemsleft = [];
$menuItems = [];

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
}else{

    $menuItems[] =  ['label' => Yii::t('app', 'Home') , 'url' => ['/site/index']];
    $menuItems[] =  ['label' => Yii::t('app', 'Monthy') , 'url' => ['/site/monthy']];



    $menuItems[] = [
        'label' => Yii::t('app', 'Employees'),
        'items' => [
            ['label' =>  Yii::t('app', 'Employees') , 'url' => ['/employees/index']],
            ['label' =>  Yii::t('app', 'Draws') , 'url' => ['/draws/index']],
            ['label' =>  Yii::t('app', 'Debts')  , 'url' => ['/debt/index']],
            ['label' =>  Yii::t('app', 'Commissions'), 'url' => ['/commission/index']],
            ['label' =>  Yii::t('app', 'Tigers'), 'url' => ['/tiger/index']],
            ['label' =>  Yii::t('app', 'Discounts'), 'url' => ['/discounts/index']],
            ['label' =>  Yii::t('app', 'Working Hours'), 'url' => ['/working-hours/index']],
            
            
            
      
        ],
    ];

    $menuItems[] = [
        'label' => Yii::t('app', 'Expenses'),
        'items' => [
            ['label' => Yii::t('app', 'Expenses') , 'url' => ['/expenses/index']],
            ['label' => Yii::t('app', 'Types Of Expenses'), 'url' => ['/types-of-expenses/index']],
        ],
    ];


    $menuItems[] = ['label' =>  Yii::t('app', 'Sales') , 'url' => ['/sales/index']];
   
    $menuItems[] = ['label' =>Yii::t('app', 'Sales Employees') , 'url' => ['/sales-employees/index']];
  

   
   
    $menuItems[] = '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
        '( ' . Yii::t('app', 'Logout') . ' ' . Yii::$app->user->identity->username . ')',
        ['class' => 'btn btn-link logout']
    )
    . Html::endForm()
    . '</li>';


}

?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right ms-auto'],
        'items' => $menuItems
    ]);

   
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; car <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
