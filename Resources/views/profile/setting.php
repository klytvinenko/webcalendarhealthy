
<div id="settings">
    <div class="row">
        <div class="w-half list">
            <p><b>Логін:</b> <?= $user->login ?></p>
            <p><b>Електрона пошта:</b> <?= $user->email ?></p>
            <?php
            if ($user->norms != []) {
                ?>
                <p><b>Ккалорії:</b> <?= $user->norms["kcal"] ?> ккал</p>
                <p><b>Білки:</b> <?= $user->norms["protein"] ?> г</p>
                <p><b>Жири:</b> <?= $user->norms["fat"] ?> г</p>
                <p><b>Вуглеводи:</b> <?= $user->norms["carbonation"] ?> г</p>
                <p><b>Натрій:</b> <?= $user->norms["na"] ?> мг</p>
                <p><b>Клітковина:</b> <?= $user->norms["cellulose"] ?> г</p>
                <?php
            } ?>
            <?php
            ?>
            <p><b>Дієти:</b> <?= !empty($user->diets) ? implode(', ', $user->diets) : " - " ?></p>
            <p><b>Алергії:</b> <?= !empty($user->allergies) ? implode(', ', $user->allergies) : " - " ?></p>
            <button class="button" onclick="location.href='/profile/setting/diet'">Редагувати свою дієту</button>
            <button class="button" role="button" onclick="location.href='/profile/setting/norms'">Розрахувати норми ккалорій</button>
            <!-- <p><a href="/logout" class="logout">Вийти з акаунту</a></p> -->
        </div>
        <div class="w-half" style="justify-content: end;">
            <div id="chart_weight"></div>
        </div>
    </div>
</div>


<script>
    DrawChartWeights();
    async function DrawChartWeights() {
        let data = await Weigth.WeightsProgressForWeek();
        let new_data = [];
        let new_categories = [];
        data.forEach(w => {
            new_data.push(w.weigth);
            new_categories.push(w.date_of_update);
        });
        var options = {
            series: [{
                name: "Вага",
                data: new_data
            }],
            chart: {
                height: '90%',
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Графік прогресу зміни ваги',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['white', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: new_categories,
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_weight"), options);
        chart.render();
    }

</script>