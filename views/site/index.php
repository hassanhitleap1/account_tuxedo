<?php

use yii\bootstrap5\Html;
use kartik\date\DatePicker;
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
            'id'=>"form-date"
            
        ]); ?>
    <div class="col-xl-4 col-lg-6 col-md-6">
        <?='<label class="form-label">Date</label>';?>
        <?= DatePicker::widget([
                'name' => 'date',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'value' => $date,
                'options' => ['placeholder' => 'Enter  date ...','id'=>"date"],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]); ?> 
            
        </div>
        <div class="col-md-4">
            <button class="btn button-sccess"><?=Yii::t('app',"Search")?></button>
        </div>
  


    <?php ActiveForm::end(); ?>
</div>
    <div class="row mt-4">
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-shopping-cart"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"><?=Yii::t('app','Total Sales')?> (<?=$date?>)</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-4">
                            <h2 class="d-flex align-items-center mb-0">
                               $ <?= $sales_amount_daily?>
                            </h2>
                        </div>
                        <div class="col-4 text-right">
                            <span> visa <i class="fa fa-arrow-up"> <?=$sales_amount_daily_visa?></i></span>
                        </div>
                        <div class="col-4 text-right">
                            <span> cash <i class="fa fa-arrow-up"> <?=$sales_amount_daily_cash?></i></span>
                        </div>
                    </div>
                    <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon-large"><i class="fas fa-ticket-alt"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0"><?=Yii::t('app','Total Expenses')?> (<?=$date?>)</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                <?= $expenses_daily?>
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
<h3> <?= Yii::t('app','Sales')?></h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?=Yii::t('app','Name')?></th>
      <th scope="col"><?=Yii::t('app','Sales')?></th>
      <th scope="col"><?=Yii::t('app','Note')?></th>
      <th scope="col"><?=Yii::t('app','Tiger')?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($salesEmployees as $key=> $salesEmployee ): ?>
        <tr>
            <th scope="row"><?=++ $key?></th>
            <td><?=$salesEmployee->employee->name?></td>
            <td><?=$salesEmployee->amount?></td>
            <td><?=$salesEmployee->note?></td>
            <td><?=$salesEmployee->salesEmployee->amount??''?></td>
        </tr>
    <?php endforeach;?>
  
  
  </tbody>
</table>
</div>
<hr/>
<div class="row">
<h3> <?= Yii::t('app','Expenses')?></h3>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?=Yii::t('app','Name')?></th>
      <th scope="col"><?=Yii::t('app','Amount')?></th>
      <th scope="col"><?=Yii::t('app','Note')?></th>

    </tr>
  </thead>
  <tbody>
    <?php foreach($expenses as $key=> $expense ): ?>
        <tr>
            <th scope="row"><?=++ $key?></th>
            <td><?=$expense->employee->name?></td>
            <td><?=$expense->amount?></td>
            <td><?=$expense->note?></td>
          
        </tr>
    <?php endforeach;?>
  
  
  </tbody>
</table>
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