<?php

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
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><?= Yii::t('app','Date')?></th>
      <th scope="col"><?= Yii::t('app','Start Time')?></th>
      <th scope="col"><?= Yii::t('app','End Time')?></th>
      <th scope="col"><?= Yii::t('app','Draws')?></th>
      <th scope="col"><?= Yii::t('app','Debt')?></th>
      <th scope="col"><?= Yii::t('app','Commission')?></th>
      <th scope="col"><?= Yii::t('app','Tiger')?></th>
      <th scope="col"><?= Yii::t('app','Discounts')?></th>
    </tr>
  </thead>
  <tbody>
    
  <?php foreach ($datesInAugust as  $key =>$day) :?>

    <?php $formattedDate = sprintf("%04d-%02d-%02d", $year, $month, $day);?>

      <tr>
        <th scope="row"><?=$key?></th>
        <td><?= $formattedDate?></td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>

    <?php endforeach;?>
   
   
  </tbody>
</table>

</div>