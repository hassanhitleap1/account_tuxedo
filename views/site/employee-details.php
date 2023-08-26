<?php

use app\components\Calculator;

/** @var yii\web\View $this */

$this->title = $model->name;





$year = date('Y'); // Get the current year
$month = 8;        // August

// Calculate the number of days in the month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Create an array containing all the dates in the 8th month
$datesInAugust = range(1, $daysInMonth);


?>
<div class="">
  <h1 class="text-center"><?=$model->name?></h1>
  <hr/>
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
        <th scope="row"><?=$key?></th>
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