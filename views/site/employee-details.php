<?php

use yii\helpers\Html;
use app\components\Calculator;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */

$this->title = $model->name;





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
      foreach($workingHours as $workingHour){
        if($workingHour->date == $formattedDate){
          $start_time =  $workingHour->start_time;
          $end_time=$workingHour->end_time;
          break;
        }
      }
      foreach($debts as $debt){
        if($debt['date'] == $formattedDate){
          $sum_debt =  $debt['sum_debt'];
          break;
        }
      }
      foreach($commissions as $commission){
        if($commission['date'] == $formattedDate){
          $sum_commission =  $commission['sum_commission'];
          break;
        }
      }

      foreach($draws as $draw){
        if($draw['date'] == $formattedDate){
          $sum_draw =  $draw['sum_draw'];
          break;
        }
      }

      foreach($discounts as $discount){
        if($discount['date'] == $formattedDate){
          $sum_discount=  $discount['sum_discount'];
          break;
        }
      }

      foreach($tigers as $tiger){
        if($tiger['date'] == $formattedDate){
          $sum_tiger=  $tiger['sum_tiger'];
          break;
        }
      }

      
      foreach($discounts as $discount){
        if($discount['date'] == $formattedDate){
          $sum_discount=  $discount['sum_discount'];
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

        
      </tr>

    <?php endforeach;?>
   
   
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
