<?php

use yii\bootstrap5\Html;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;

$sumTiger = [];
$sumExpenses = [];
$TotalSalesEmployee = 0;
$totalExpenses = 0;
$totalSalesTiger = 0;
/** @var yii\web\View $this */


$this->title = 'tuxedo';
?>
<div class="site-index">

    <div class="row">
        <div class="col-md-3  col-xs-3 col-sm-3">
            <?= Html::a(Yii::t('app', 'Create Sales Employees'), ['sales-employees/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
            <?= Html::a(Yii::t('app', 'Create Expenses'), ['expenses/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="col-md-3 col-xs-3 col-sm-3">
            <?= Html::a(Yii::t('app', 'Create Working Hours'), ['working-hours/create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="row">
        <?php $form = ActiveForm::begin([
            'action' => ['site/index'],
            'method' => 'get',
            'id' => "form-date"

        ]); ?>

        <div class="col-xl-4 col-lg-6 col-md-6">
            <?= '<label class="form-label">Date</label>'; ?>
            <?= DatePicker::widget([
                'name' => 'date',
                'language' => 'en',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'value' => $date,
                'options' => ['placeholder' => 'Enter  date ...', 'id' => "date"],
                'pluginOptions' => [
                    'pickerPosition' => 'top-right',
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]); ?>

        </div>
        <div class="col-md-4">
            <button class="btn btn-success">
                <?= Yii::t('app', "Search") ?>
            </button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="row">
        <div class="row mt-4">
            <div class="col-xl-8 col-lg-8">
                <div class="card l-bg-cherry">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">
                                <?= Yii::t('app', 'Total Sales') ?> (
                                <?= $date ?>)
                            </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-3">
                                <h2 class="d-flex align-items-center mb-0">
                                    $
                                    <?= $sales_amount_daily ?>
                                </h2>
                            </div>
                            <div class="col-3 text-right">
                                <span> visa <i class="fa fa-arrow-up">
                                        <?= $sales_amount_daily_visa ?>
                                    </i></span>
                            </div>
                            <div class="col-3 text-right">
                                <span> cash <i class="fa fa-arrow-up">
                                        <?= $sales_amount_daily_cash ?>
                                    </i></span>
                            </div>

                            <div class="col-3 text-right">
                                <span> صافي النقد</i> <i class="fa fa-arrow-up">
                                        <?= $sales_amount_daily_cash - $expenses_daily ?>
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

            <div class="col-xl-4 col-lg-4">
                <div class="card l-bg-green-dark">
                    <div class="card-statistic-3 p-4">
                        <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                        <div class="mb-4">
                            <h5 class="card-title mb-0">
                                <?= Yii::t('app', 'Total Expenses') ?> (
                                <?= $date ?>)
                            </h5>
                        </div>
                        <div class="row align-items-center mb-2 d-flex">
                            <div class="col-8">
                                <h2 class="d-flex align-items-center mb-0">
                                    <?= $expenses_daily ?>
                                </h2>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <span>10% <i class="fa fa-arrow-up"></i></span> -->
                            </div>
                        </div>
                        <div class="progress mt-1" data-height="8" style="height: 8px;">
                            <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <h3>
                <?= Yii::t('app', 'Sales') ?>
            </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">
                            <?= Yii::t('app', 'Name') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Sales') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Payment Method') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Note') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Tiger') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Action') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salesEmployees as $key => $salesEmployee): ?>
                        <?php
                        $TotalSalesEmployee += (float) $salesEmployee->amount;
                        $totalSalesTiger += (float) $salesEmployee->tiger;

                        ?>

                        <tr>
                            <th scope="row">
                                <?= ++$key ?>
                            </th>
                            <td>
                                <?= $salesEmployee->user->name ?>
                            </td>

                            <td>
                                <?= $salesEmployee->amount ?>
                            </td>
                            <td>
                                <?= $salesEmployee->payment_method ?>
                            </td>
                            <td>
                                <?= $salesEmployee->note ?>
                            </td>
                            <td>
                                <?= $salesEmployee->tiger ?>
                            </td>

                            <td>
                                <?= Html::a('<span class="fa-solid fa-pen-to-square"></span>', ['sales-employees/update', 'id' => $salesEmployee->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <tfoot>
                    <tr>
                        <th scope="row"></th>
                        <td>
                            <?= Yii::t('app', 'Total') ?>
                        </td>
                        <td>
                            <?= $TotalSalesEmployee ?>
                        </td>
                        <td> </td>
                        <th scope="row"><button class="btn btn-success" id="insert_tiger">
                                <?= Yii::t('app', "insert_tiger") ?>
                            </button></th>

                        <th scope="row"><button class="btn btn-success" id="visaandcash">
                                <?= Yii::t('app', "visaandcash") ?>
                            </button></th>
                        <td>
                            <?= $totalSalesTiger ?>
                        </td>

                    </tr>
                </tfoot>

                </tbody>
            </table>


        </div>


    </div>


    <hr />
    <div class="row">
        <div class="col-md-12">
            <h3>
                <?= Yii::t('app', 'Expenses') ?>
            </h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">
                            <?= Yii::t('app', 'Name') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Amount') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Note') ?>
                        </th>
                        <th scope="col">
                            <?= Yii::t('app', 'Action') ?>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $key => $expense): ?>

                        <?php
                        $totalExpenses += (float) $expense->amount;
                        if (!is_null($expense->user)) {
                            if (isset($sumExpenses[$expense->user->id])) {
                                $sumExpenses[$expense->user->id]['expense'] += (float) $expense->amount;
                                $sumExpenses[$expense->user->id]['name'] = $expense->user->name;
                            } else {
                                $sumExpenses[$expense->user->id]['expense'] = (float) $expense->amount;
                                $sumExpenses[$expense->user->id]['name'] = $expense->user->name;
                            }
                        }



                        ?>
                        <tr>
                            <th scope="row">
                                <?= ++$key ?>
                            </th>
                            <td>
                                <?= is_null($expense->user) ? $expense->name : $expense->user->name ?>
                            </td>
                            <td>
                                <?= $expense->amount ?>
                            </td>
                            <td>
                                <?= $expense->note ?>
                            </td>

                            <td>
                                <?= Html::a('<span class="fa-solid fa-pen-to-square"></span>', ['expenses/update', 'id' => $expense->id]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <tfoot>
                    <tr>
                        <th scope="row"> </th>
                        <td>
                            <?= Yii::t('app', 'Total') ?>
                        </td>
                        <td>
                            <?= $totalExpenses ?>
                        </td>
                        <td></td>

                    </tr>
                </tfoot>


                </tbody>
            </table>


        </div>


    </div>


    <script>

        // Wait for the document to be fully loaded
        document.addEventListener("DOMContentLoaded", function () {
            // Get a reference to the Select2 dropdown
            var select = document.getElementById("btn-serach");


            select.addEventListener("click", function (event) {

                var form = document.getElementById("form-date"); // Replace with your actual form ID

                // Submit the form
                form.submit();
            });
        });


    </script>