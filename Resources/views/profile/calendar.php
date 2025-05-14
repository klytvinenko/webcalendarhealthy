<?php
use App\Data;

?>
<div id="calendar">
  <div id="header">
    <h3 onclick="href('/profile/calendar?m=<?= $prev_month ?>&y=<?= $prev_year ?>')"
      title="<?= Data::$months["$prev_month"] . ' ' . $prev_year ?>">
      < <?= Data::$months["$prev_month"] ?>
        </h2>
        <h2 title="<?= Data::$months["$month"] . ' ' . $year ?>"><?= Data::$months["$month"] ?></h2>
        <h3 onclick="href('/profile/calendar?m=<?= $next_month ?>&y=<?= $next_year ?>')"
          title="<?= Data::$months["$next_month"] . ' ' . $next_year ?>"><?= Data::$months["$next_month"] ?> ></h3>
  </div>
  <div id="days_of_week">
    <div class="day-of-week">Понеділок</div>
    <div class="day-of-week">Вівторок</div>
    <div class="day-of-week">Середа</div>
    <div class="day-of-week">Четвер</div>
    <div class="day-of-week">П'ятниця</div>
    <div class="day-of-week">Субота</div>
    <div class="day-of-week">Неділя</div>
  </div>
  <div id="body">
    <?php

    foreach ($dates as $date) {
      if ($date['date'] == 0) {
        echo '<div class="day-cell empty"></div>';
      } else {
        ?>

        <div class="day-cell current">
          <div class="info">
            <div class="date"><?= $date['date'] ?></div>
            <div class="icons">
              <ion-icon onclick="" name="barbell-outline" class=""></ion-icon>
              <ion-icon onclick="" name="add-circle-outline"></ion-icon>
              <ion-icon onclick="" name="dice-outline"></ion-icon>
              <ion-icon onclick="" name="ellipsis-horizontal-circle-outline"></ion-icon>

            </div>
          </div>
          <p class="menu">
            <?php

            if (!empty($date['menu'])) {
              ?>
              <b>Сн.:</b> <?= $date['menu'][0] ?>
              <br><b>Пер. 1:</b> <?= $date['menu'][1] ?>
              <br><b>Об.:</b> <?= $date['menu'][2] ?>
              <br><b>Пер. 2:</b> <?= $date['menu'][3] ?>
              <br><b>Веч.:</b> <?= $date['menu'][4] ?>

              <?php
            }
            ?>

          </p>
        </div>

        <?php
      }
    }

    ?>
  </div>
</div>

