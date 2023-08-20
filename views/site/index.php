<?php

use yii\bootstrap5\Html;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'tuxedo';
?>
<div class="site-index">

<div class="col-md-12 ">
    <div class="row">
    <?php $form = ActiveForm::begin([
            'action' => ['site/index'],
            'method' => 'get',
            'id'=>"form-month"
            
        ]); ?>
        <div class="col-md-8">
            <?php
                echo Html::dropDownList('month', $month, [
                    1=>1,
                    2=>2,
                    3=>3,
                    4=>4,
                    5=>5,
                    6=>6,
                    7=>7,
                    8=>8,
                    9=>9, 
                    10=>10, 
                    11=>11, 
                    12=>12
                    ], ['prompt' => 'Select month','id'=>"month-drop-down-list"]);;?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="row ">
        <div class="col-xl-4 col-lg-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"><?=Yii::t('app','Total Sales')?> (<?=$month?>)</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                               $ <?= $sales_amount_monthly?>
                            </h2>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <span>12.5% <i class="fa fa-arrow-up"></i></span> -->
                        </div>
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"><?=Yii::t('app','total staff')?></h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                <?= count($employees)?>
                            </h2>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <span>9.23% <i class="fa fa-arrow-up"></i></span> -->
                        </div>
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"><?=Yii::t('app','Total Expenses')?> (<?=$month?>)</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                <?= $expenses_amount_monthly?>
                            </h2>
                        </div>
                        <div class="col-4 text-right">
                            <!-- <span>10% <i class="fa fa-arrow-up"></i></span> -->
                        </div>
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>


<div class="row">
    <?php foreach($employees as $employee):?>
        <div class="col-4">
        <div class="card">
            <img src="https://cdn.iconscout.com/icon/free/png-256/free-avatar-370-456322.png?f=webp" class="card-img-top avatar-employee" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $employee['name']?></h5>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-6">
                                <?= Yii::t('app','Salary') ?>: <?= $employee['salary']?>
                            </div>
                            <div class="col-6">
                                <?= Yii::t('app','Debt') ?>: <?= $employee['amount_debt']?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <?= Yii::t('app','Commissions') ?>: <?= $employee['amount_commission']?>
                            </div>
                            <div class="col-6">
                                <?= Yii::t('app','Draws') ?>: <?= $employee['amount_draws']?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <?= Yii::t('app','Tigers') ?>: <?= $employee['amount_tiger']?>
                            </div>
                            <div class="col-6">
                                <?= Yii::t('app','Sales') ?>: <?= $employee['amount_sales_employees']?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <?= Yii::t('app','Available debt') ?>: <?= $employee['available_debt']?>
                            </div>
                        </div>

                        
                    </div>

  
                </div>
            </div>
        </div>
     <?php endforeach;?>   
     </div>

</div>


<script>
 
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function () {
        // Get a reference to the Select2 dropdown
        var select = document.getElementById("month-drop-down-list");
     
     
        select.addEventListener("change", function () {
            // Get the form element
            var form = document.getElementById("form-month"); // Replace with your actual form ID
            
            // Submit the form
            form.submit();
        });
    });
</script>
