<?php

use yii\helpers\Url;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = 'tuxedo';
?>
<div class="site-index">

    <div class="col-md-12 ">
        <div class="row">
            <?php $form = ActiveForm::begin([
                'action' => ['site/monthy'],
                'method' => 'get',
                'id' => "form-month"

            ]); ?>
            <div class="col-md-8">
                <?php
                echo Html::dropDownList('month', $month, [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    10 => 10,
                    11 => 11,
                    12 => 12
                ], ['prompt' => 'Select month', 'id' => "month-drop-down-list"]);
                ; ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="row ">
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">
                                <?= Yii::t('app', 'Total Sales') ?> (
                                <?= $month ?>)
                            </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-4">
                                <h2 class="d-flex align-items-center mb-0">
                                    $
                                    <?= $sales_amount_monthly ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <span> visa <i class="fa fa-arrow-up">
                                        <?= $sales_amount_monthly_visa ?>
                                    </i></span>
                            </div>
                            <div class="col-4 text-right">
                                <span> cash <i class="fa fa-arrow-up">
                                        <?= $sales_amount_monthly_cash ?>
                                    </i></span>
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-blue-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-users"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">
                                <?= Yii::t('app', 'total staff') ?>
                            </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <?= count($users) ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <span>9.23% <i class="fa fa-arrow-up"></i></span> -->
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">
                                <?= Yii::t('app', 'Total Expenses') ?> (
                                <?= $month ?>)
                            </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <?= $expenses_amount_monthly ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <span>10% <i class="fa fa-arrow-up"></i></span> -->
                            </div>
                        </div>
                        <div class="progress mt-1 " data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-6">
                <a class="card  text-decoration" href="<?= Url::to(['site/employee-details', 'id' => $user['id']]); ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <?= $user['name'] ?>
                        </h5>
                        <div class="card-text">
                            <div class="row">
                                <div class="col-6 mt-2">
                                    <?= Yii::t('app', 'Salary') ?>: (
                                    <?= $user['salary'] ?> )
                                </div>
                                <div class="col-6 mt-2">
                                    <?= Yii::t('app', 'Debt') ?>: (
                                    <?= round($user['amount_debt'], 2) ?>)
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-6 mt-2">
                                    <?= Yii::t('app', 'Commissions') ?>: (
                                    <?= round($user['amount_commission'], 2) ?>)
                                </div>
                                <div class="col-6 mt-2">
                                    <?= Yii::t('app', 'Draws') ?>: (
                                    <?= round($user['amount_draws'], 2) ?>)
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-6">
                                    <?= Yii::t('app', 'Tigers') ?>: (
                                    <?= round($user['amount_tiger'], 2) ?>)
                                </div>
                                <div class="col-6">
                                    <?= Yii::t('app', 'Sales') ?>: (
                                    <?= round($user['amount_sales_employees'], 2) ?>)
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-6">
                                    <?= Yii::t('app', 'Discounts') ?>: (
                                    <?= round($user['amount_discount'], 2) ?>)
                                </div>

                                <div class="col-6">
                                    <?= Yii::t('app', 'Available debt') ?>: (
                                    <?= round($user['available_debt'], 2) ?>)
                                </div>
                            </div>


                            <hr />

                            <div class="row">
                                <div class="col-6">
                                    <?= Yii::t('app', 'Round Balance') ?>: (
                                    <?= round($user['round_balance'], 2) ?>)
                                </div>

                                <div class="col-6">
                                    <?= Yii::t('app', 'Start Date') ?>:
                                    <?= $user['start_date'] ?>
                                </div>


                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
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