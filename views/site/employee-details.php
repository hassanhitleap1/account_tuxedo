<?php

use yii\helpers\Html;
use app\components\Calculator;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = $model->name;



$sum_debts=0;
$sum_commissions=0;
$sum_discounts=0;
$sum_tigers=0;
$sum_draws=0;
$sum_sales=0;


?>
<div class="">
  <h1 class="text-center"><?=$model->name?></h1>
  <hr/>

  <div class="row">
    <?php $form = ActiveForm::begin([
            'action' => ['site/employee-details?id='.$model->id],
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
    
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?= Yii::t('app','Date')?></th>
      <th scope="col"><?= Yii::t('app','Start Time')?></th>
      <th scope="col"><?= Yii::t('app','End Time')?></th>
      <th scope="col"><?= Yii::t('app','Time Hour')?></th>
      <th scope="col"><?= Yii::t('app','Draws')?></th>
      <th scope="col"><?= Yii::t('app','Debt')?></th>
      <th scope="col"><?= Yii::t('app','Commission')?></th>
      <th scope="col"><?= Yii::t('app','Tiger')?></th>
      <th scope="col"><?= Yii::t('app','Discounts')?></th>
      <th scope="col"><?= Yii::t('app','Sum Sales')?></th>

    </tr>
  </thead>
  <tbody>
    
  <?php foreach ($datesInAugust as  $key =>$day) :?>

    <?php $formattedDate = sprintf("%04d-%02d-%02d", $year, $month, $day);
      $start_time='';
      $end_time='';
      $sum_debt=0;
      $sum_commission=0;
      $sum_discount=0;
      $sum_tiger=0;
      $sum_draw=0;   
      $sum_sale=0;
  
      foreach($workingHours as $workingHour){
        if($workingHour->date == $formattedDate){
            $start_time =  $workingHour->start_time;
            $end_time = $workingHour->end_time;
          break;
        }
      }



      foreach($expenses as $expense){
        if($expense['date'] == $formattedDate){

          $sum_debt =  $expense['sum_debt'];
          $sum_commission=$expense['sum_commission'];
          $sum_draw=$expense['sum_draws'];

          $sum_debts+=(float)+$sum_debt;
          $sum_commissions+=(float)+$sum_commission;
          $sum_draws+=(float)+$sum_draw;
         
          break;
        }
      }


  

      foreach($discounts as $discount){
        if($discount['date'] == $formattedDate){
          $sum_discount=  $discount['sum_discount'];
          $sum_discounts+=(float)+$sum_discount;
          break;
        }
      }

      foreach($sales as $sale){
        if($sale['date'] == $formattedDate){
          $sum_tiger=  $sale['sum_tiger'];
          $sum_sale=  $sale['sum_sales'];
          $sum_sales+=(float)+$sum_sale;
          $sum_tigers+=(float)+$sum_tiger;
          break;
        }
      }

      
      foreach($discounts as $discount){
        if($discount['date'] == $formattedDate){
          $sum_discount=  $discount['sum_discount'];

          $sum_discounts+=(float)+$sum_discount;
          
          break;
        }
      }

      

      
    ?>

      <tr class="<?= $start_time ==''?'table-danger':''?> " >
        <th scope="row"><?= ++ $key?></th>
        <td><?= $formattedDate?></td>
        <td><?= $start_time ?></td>
        <td><?= $end_time ?></td>
        <td> <?= $start_time != '' && $end_time !='' ?Calculator::timeDifference($start_time,$end_time) :'' ?> </td></td>
        <td><?= $sum_draw?></td>
        <td><?= $sum_debt?></td>
        <td><?= $sum_commission?></td>
        <td><?= $sum_tiger?></td>
        <td><?= $sum_discount?></td>
        <td><?= $sum_sale?></td>
      </tr>

    <?php endforeach;?>
   
    <tfoot>
            <tr>
              <th scope="row"></th>
              <td><?= Yii::t('app','Total')?></td>
              <td></td>
              <td> </td>
              <th ></th>
              <td><?= $sum_draws?></td>
              <td><?= $sum_debts?></td>
              <td><?= $sum_commissions?></td>
              <td><?= $sum_tigers?></td>
              <td><?= $sum_discounts?></td>
              <td><?= $sum_sales?></td>
                
            </tr>
    </tfoot>

  </tbody>
</table>

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
