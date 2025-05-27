<?php

use App\Data;
use App\Models\User;

require_once 'Resources/views/modals/add_meal.php';
require_once 'Resources/views/modals/add_training.php';
require_once 'Resources/views/modals/add_weigth.php';
require_once 'Resources/views/modals/generate_menu.php';

?>

<!-- Профиль -->
<div id="dayinfo">
    <?php
    $menu_today = '';
    for ($i = 0; $i < 5; $i++) {
        $meals = $menu['by_time'][$i];

        foreach ($meals as $meal) {
            $weight = $meal->weight == 0 ? "" : $meal->weight;
            $menu_today .= "<tr><td>" . $meal->title . "</td><td>" . $weight . "</td><td>" . $meal->kcal . "</td><td>" . $meal->protein . "</td><td>" . $meal->fat . "</td><td>" . $meal->carbonation . "</td></tr>";
        }

        $menu_today .= "<tr><td></td><td></td><td>" . $menu['sums'][$i]['kcal'] . "</td><td>" . $menu['sums'][$i]['protein'] . "</td><td>" . $menu['sums'][$i]['fat'] . "</td><td>" . $menu['sums'][$i]['carbonation'] . "</td></tr>";
    }
    $menu_today .= "<tr><td>Всього:</td><td></td><td>" . $menu['sums'][5]['kcal'] . "</td><td>" . $menu['sums'][5]['protein'] . "</td><td>" . $menu['sums'][5]['fat'] . "</td><td>" . $menu['sums'][5]['carbonation'] . "</td></tr>";



    ?>

    <div class="row j-c-center">
        <h3><?= $date ?></h3>
    </div>

    <div id="main">
        <div class='item-center'>
            <?php
            if (empty($menu['data'])) {
                echo "<p>Страв на сьогодні не додано </p>";
            } else {
                ?>
                <table id="menu_table">
                    <thead>
                        <tr>
                            <th>Час</th>
                            <th>Страва/продукт</th>
                            <th>Вага</th>
                            <th>Ккал</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $meals_breakfast = [];
                        foreach ($menu['data'] as $meal) {
                            if ($meal->time == 'breakfast')
                                array_push($meals_breakfast, $meal);
                        }
                        $is_first_row = true;
                        foreach ($meals_breakfast as $meal) {
                            ?>

                            <tr>
                                <?= $is_first_row ? '<td rowspan="' . count($meals_breakfast) . '">Сніданок</td>' : '' ?>

                                <td><?= $meal->title ?></td>
                                <td><?= $meal->weight ?> г</td>
                                <td><?= $meal->kcal ?></td>
                            </tr>


                            <?php
                            $is_first_row = false;
                        }
                        ?>
                        <?php
                        $meals_snack1 = [];
                        foreach ($menu['data'] as $meal) {
                            if ($meal->time == 'snack1')
                                array_push($meals_snack1, $meal);
                        }
                        $is_first_row = true;
                        foreach ($meals_snack1 as $meal) {
                            ?>

                            <tr>
                                <?= $is_first_row ? '<td rowspan="' . count($meals_snack1) . '">Перекус 1</td>' : '' ?>

                                <td><?= $meal->title ?></td>
                                <td><?= $meal->weight ?> г</td>
                                <td><?= $meal->kcal ?></td>
                            </tr>


                            <?php
                            $is_first_row = false;
                        }
                        ?>
                        <?php
                        $meals_lunch = [];
                        foreach ($menu['data'] as $meal) {
                            if ($meal->time == 'lunch')
                                array_push($meals_lunch, $meal);
                        }
                        $is_first_row = true;
                        foreach ($meals_lunch as $meal) {
                            ?>

                            <tr>
                                <?= $is_first_row ? '<td rowspan="' . count($meals_lunch) . '">Обід</td>' : '' ?>

                                <td><?= $meal->title ?></td>
                                <td><?= $meal->weight ?> г</td>
                                <td><?= $meal->kcal ?></td>
                            </tr>


                            <?php
                            $is_first_row = false;
                        }
                        ?>
                        <?php
                        $meals_snack2 = [];
                        foreach ($menu['data'] as $meal) {
                            if ($meal->time == 'snack2')
                                array_push($meals_snack2, $meal);
                        }
                        $is_first_row = true;
                        foreach ($meals_snack2 as $meal) {
                            ?>

                            <tr>
                                <?= $is_first_row ? '<td rowspan="' . count($meals_snack2) . '">Перекус 2</td>' : '' ?>

                                <td><?= $meal->title ?></td>
                                <td><?= $meal->weight ?> г</td>
                                <td><?= $meal->kcal ?></td>
                            </tr>


                            <?php
                            $is_first_row = false;
                        }
                        ?>
                        <?php
                        $meals_dinner = [];
                        foreach ($menu['data'] as $meal) {
                            if ($meal->time == 'dinner')
                                array_push($meals_dinner, $meal);
                        }
                        $is_first_row = true;
                        foreach ($meals_dinner as $meal) {
                            ?>

                            <tr>
                                <?= $is_first_row ? '<td rowspan="' . count($meals_dinner) . '">Вечеря</td>' : '' ?>

                                <td><?= $meal->title ?></td>
                                <td><?= $meal->weight ?> г</td>
                                <td><?= $meal->kcal ?></td>
                            </tr>


                            <?php
                            $is_first_row = false;
                        }
                        ?>
                        <tr>
                            <td rowspan="2">Всього</td>
                            <td><b>Ккал:</b> <?= $menu['sums'][5]['kcal'] ?> ккал</td>
                            <td><b>Білок:</b> <?= $menu['sums'][5]['protein'] ?> г</td>
                            <td><b>Жири:</b> <?= $menu['sums'][5]['fat'] ?> г</td>
                        </tr>
                        <tr>
                            <td><b>Вуглеводи:</b> <?= $menu['sums'][5]['carbonation'] ?> г</td>
                            <td><b>Натрій:</b> <?= $menu['sums'][5]['na'] ?> мг</td>
                            <td><b>Клітковина:</b> <?= $menu['sums'][5]['cellulose'] ?> мг</td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <div id="menu_chart"></div>
        <div id="weigth_and_training" class="column j-c-start">
            <p id="weigth"><b>Вага: </b>
                <?= empty($weigth) ? " <small>ваги сьогодні не додано</small>" : $weigth . " кг" ?>
            </p>
            <ol id="trainings"><b>Тренування: </b>
                <?php
                if (empty($trainings)) {
                    echo "<br><small>тренувань на сьогодні <br>не додано</small>";
                } else {
                    foreach ($trainings as $training) {
                        ?>
                        <li><?= $training['title'] ?> (<?= $training['times'][0] ?> - <?= $training['times'][1] ?>) -
                            <?= $training['kcal'] ?> ккал
                        </li>
                        <?php

                    }
                }
                ?>
            </ol>
        </div>
    </div>
</div>
<div class="row j-c-end">
    <button class="button" onclick="openModal('modalAddWeigth')">Додати вагу</button>
    <button class="button" onclick="openModal('modalAddTraining')">Додати тренування</button>
    <?php
    if (!empty((new User())->norms)) {
        ?>
        <button class="button" onclick="openModal('modalGenerateMenu')">Генерувати меню</button>
        <button class="button" onclick="openModal('modalAddMeal')">Додати страву</button>
        <?php
    } else {
        ?>
        <button class="button" onclick="location.href='/profile/setting/norms'">Розрахувати норми ккалорій</button>
        <?php
    }
    ?>
</div>
</div>
<!-- <section class="generall">
    <h2>12 правил здорового харчування</h2>
    <h4>Правильне харчування - не дієта!</h4>
    <img class="foto-omne" src="/Resources/img/caju-gomes-QDq3YliZg48-unsplash.jpg" alt="foto Adély Maříkové">
    <p>І це необхідно зрозуміти відразу. На відміну від правильної системи живлення, всі дієти короткострокові
        бо на
        одних овочах і воді людина не протягне. Зате правильне харчування протягом усього життя просто
        необхідно!
        Прощайте застуди, болячки і довгий вибір з безлічі дієт проблемна шкіра і зайві кілограми. Грамотно
        підібрана система харчування допоможе впоратися з усіма цими проблемами. Умовити себе відмовитися від
        жирного, хот-догів і гамбургерів може не кожен. Як і при дієті тут є правила і заборони. І хоча їх не
        так
        багато, але приборкати свої гастрономічні бажання і пристосуватись до певного режиму харчування все ж
        доведеться. Найважче в перші тижні, коли кожен раз в магазині або ресторані треба буде нагадувати собі
        про
        нові принципи життя і обмежувати себе. Зате, яке тренування характеру. Завзятим любителям дієт, мабуть
        буде
        легше на цьому етапі. Але от потім почнуться деякі проблеми, оскільки їх організм не звик до тривалих
        періодів самообмеження в їжі. До речі, можна долучити до режиму правильного харчування свою половинку.
        Удвох
        все-таки легше, та й він (вона) зрадіє такій довірі з вашого боку.</p>
    <p>Важливо відзначити, що для кожної людини, що має які-небудь хронічні захворювання або постійно хворіють з
        приводу і без, звернення до лікаря при складанні схеми живлення - обов'язково. Можливо, знадобитися не
        просто правильне, а лікувальне харчування. Сьогодні інформації з цього питання в різних довідниках
        народної
        медицини достатньо, але краще здати аналізи у спеціалізованому закладі.</p>
    <h4>12 принципів правильного харчування</h4>
    <ol>
        <li>Частота. Одне з головних правил правильного харчування - необхідність їсти кілька разів на день -
            бажано
            не менше 3-5 разів, але в маленьких пропорціях і в один той самий час.</li>
        <li>Різноманітність. Харчування має бути різноманітним і не надто екстравагантним. Не треба ставати
            маніяком
            садомазохістом, які намагаються насильно нагодує себе якимось шпинатом або кольоровий капустою,
            ненависними з дитинства. але все таки зовсім без мук обійтися не вийти. Кількість жирної, смаженої,
            гострої та кислої їжі доведеться обмежити. Людському організму для нормального функціонування
            потрібно
            величезна кількість органічних і мінеральних речовин, і вони обов'язково повинні бути присутніми у
            вашому раціоні.</li>
        <li>Поступовість. Відразу відмовитися від звичного харчування складно, тому включайте «здорові» продукти
            в
            свій раціон поступово. Придбайте собі або подаруєте своїй дівчині (дружині, мамі, бабусі) пароварку.
            Вона збереже всі корисні речовини, що містяться в продуктах, і при цьому захистить вас від жирів.
            Також,
            слід споживання солі і цукру.</li>
        <li>Енергетичний баланс. Люди як зайчики з відомої реклами батарейок. Не дійдуть до фінішу і не
            доберуться
            до вечірніх радостей, якщо запаси енергії вичерпаються. Їжа повинна заповнювати наші енергетичні
            втрати
            і система живлення повинна це враховувати.</li>
        <li>Сніданок обов'язковий. Він повинен бути повноцінним і різноманітним - кава з булочкою з сиром явно
            недостатньо. Найкращий варіант повернутися в дитинство до вівсянки і гречці. Що кому до смаку. Якщо
            з
            ранку часу немає, та й нікому готувати, можна перекусити яблуком, бананом або йогуртом. Добре з'їсти
            яйце в круту або омлет і замість кави випити чашку свіжо завареного чаю, краще зеленого і зрозуміло
            без
            цукру.</li>
        <li>Харчуйтеся за графіком. На роботу, до інституту можна захопити пшеничний хлібець, батончик з мюслі,
            суміш сухофруктів з горіхами, яблуко або шматочок сиру. Все це допоможе протриматися до обіду в
            гарному
            настрої. Тим, хто працює в нічну зміну, від прийому їжі відмовлятися не можна, при цьому обов'язково
            треба з'їсти що-небудь солодке (глюкоза допоможе організму впоратися зі стресом і підживить
            засипавши
            нервову систему).</li>
        <li>Розбавляйте раціон. Під час обіду і вечері не забувайте про густих супах. Вони сприяють кращому
            травленню і не перевантажують шлунок. Кількість алкоголю необхідно скоротити. Пийте сік, чай або
            мінеральну воду без газу. А ось будь-яку газовану воду забудьте як страшний сон. Будь-яка газована
            вода
            - негативно впливає на шлунково-кишковий тракт.</li>
        <li>Солодке - не означає корисне. Любителям солодкого порадимо не зловживати тортами і тістечками з
            кремом,
            великою кількістю шоколаду. Корисний, наприклад, свіжий сир з фруктами або ягодами, мармелад, мед.
            Десерти, до речі, всупереч усталеній думці краще з'їсти перед основним прийомом їжі - це допоможе
            знизити апетит і вбереже від переїдання. Фрукти, з'їдені в кінці щільного обіду або вечері, занадто
            довго перетравлюються і втрачають всі корисні речовини. Краще балувати себе яблуком, апельсином або
            бананом між прийомами їжі або прямо перед їжею.</li>
        <li>Не забудьте про гени. Підбираючи продукти, спробуйте заглибитися в генеалогію своєї родини.
            Наприклад,
            якщо ваші предки з Півночі, то риба та м'ясні страви вітаються у вашій системі живлення, а от
            екзотичним
            фруктам вхід заборонений. Можливо, гени ще не встигли «звикнути» до такого виду їжі, що, втім, не
            заважає вам поставити невеличкий експеримент.</li>
        <li>Фрукти і овочі необхідні. Це одна з основ правильного харчування. Вони обов'язково повинні бути
            присутніми у Вашому раціоні. У них міститься настільки необхідні нашому організму харчові волокна і
            вітаміни. Недолік фруктів у раціоні може стати причиною спраги (доводитися багато пити, підвищується
            навантаження на серце і нирки) і необхідність приймати «банкові вітаміни», які значно відрізняються
            від
            природних аналогів. Але не варто харчуватися цілими днями одними фруктами та салатами, оскільки це
            веде
            до розладу шлунка та інших проблем, зв'язковим з процесом травлення, бо протеїну в овочах, так
            скажемо,
            замало.</li>
    </ol>
    <h2>30 вправ, які допоможуть взяти максимум з домашніх занять спортом</h2>
    Займатись спортом вдома не для вас? Це нудно? Подумайте ще раз!
    При правильному виконанні вправи з власною вагою можуть показати хороший результат.
    Якщо думаєте, що на спортзал немає часу, зробіть собі простір в кімнаті і приготуйтесь виконувати вправи.
    <h4>Початківець</h4>
    <h5>5 простих вправ для початківців - повноцінне заняття спортом.
        Виконуйте 2 сети по 10-15 повторень кожної вправи. Між кожною вправою - хвилина відпочинку.
        Це має забрати у вас близько 15 хвилин. Хороший початок!</h5>
    <ol>
        <li>
            МОСТИК
            <ul>
                <li>Ляжте на спину, зігніть коліна, стопи на підлозі, руки по боках;</li>
                <li>Відштовхуючись ногами, підіймайте стегна вгору, поки можете, стискаючи сідниці.</li>
                <li>Повільно поверніться на початкову позицію, повторіть.
                </li>
            </ul>
        </li>
        <li>
            ПРИСІДАННЯ НА СТІЛЕЦЬ
            <ul>
                <li>Станьте перед кріслом, ноги на рівні плечей, носочки дивляться злегка в боки.</li>
                <li>І починайте присідати, згинаючи коліна, опускаючись, поки сідниці не торкнуться крісла, руки
                    можна виставляти вперед перед собою;</li>
                <li>Відштовхніться п’ятками та поверніться на початкову позицію.
                </li>
            </ul>
        </li>
        <li>
            ВІДТИСКАННЯ ВІД КОЛІН
            <ul>
                <li>Станьте в початкову позицію: долоні міцно стоять на підлозі, опора на коліна;</li>
                <li>Підтримуючи пряму лінію від голови до колін, згинайте лікті, опускаючись до підлоги, коліна
                    мають бути під кутом 45 градусів;</li>
                <li>Поверніться на початкову позицію.
                </li>
            </ul>
        </li>
        <li>
            ВИПАДИ ВПЕРЕД
            <ul>
                <li>Станьте на позицію, права нога попереду. Права нога має бути опорна, ліва - на носочках;
                </li>
                <li>Опускайтесь, поки праве стегно не буде паралельним до підлоги;</li>
                <li>Відштовхніться правою ногою, щоб повернутися в початкову позицію. Зробіть бажану кількість
                    повторів, поміняйте ногу.
                </li>
            </ul>
        </li>
        <li>
            BIRD DOG
            <ul>
                <li>Станьте на долоні рук та коліна, руки під плечима, коліна під сідницями;</li>
                <li>Шия не напружена, одночасно випрямляємо ліву руку й праву ногу, зупиняємось на 2 секунди;
                </li>
                <li>
                </li>
            </ul>
        </li>
    </ol>
</section> -->
<script>
    //test
    DrawChart();
    function DrawChart() {
        let data = JSON.parse('<?= json_encode($menu['sums'][5]) ?>');
        let user_norm_for_chart = JSON.parse('<?= json_encode($user->norms) ?>');
        console.log("norms ", user_norm_for_chart);
        console.log("data ", data);
        var options = {
            series: [
                (data.protein * user_norm_for_chart.protein) / 100,
                (data.fat * user_norm_for_chart.fat) / 100,
                (data.carbonation * user_norm_for_chart.carbonation) / 100,
                (data.na / 1000 * user_norm_for_chart.na) / 100,
                (data.callulose * user_norm_for_chart.callulose) / 100,],
            colors: ['#ef476f', '#ffd166', '#06d6a0', '#118ab2', '#073b4c'],
            chart: {
                height: 350,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                        },
                        value: {
                            fontSize: '16px',
                        },
                        total: {
                            show: true,
                            label: 'Ккал',
                            formatter: function (w) {
                                return data.kcal;
                            }
                        }
                    }
                }
            },
            labels: ['Білки', 'Жири', 'Вуглеводи', 'Натрій', 'Клітковина'],
        };
        today_kcal_chart = new ApexCharts(document.querySelector("#menu_chart"), options);
        today_kcal_chart.render();
    }
</script>
<script>
    let today_info_block = {
        menu_table: document.getElementById("menu_table"),
        menu_text: document.getElementById("menu_text"),
        menu_chart: document.getElementById("menu_chart"),
        weigth: document.getElementById("weigth"),
        trainings: document.getElementById("trainings"),
    };
</script>
<!-- update function -->
<script>
    async function updateWeight() {
        let new_value = await Weigth.get();
        today_info_block.weigth.innerHTML = "<b>Вага: </b>" + new_value.value + " кг";
    }

    async function updateTrainings() {
        let new_list = await Workout.today();
        let html="";
        new_list.forEach((training)=>{
            html+='<li>'+training.title+' ('+training.times[0]+' - '+training.times[1]+') - '+training.kcal+' ккал</li>'
        });
        today_info_block.trainings.innerHTML=html;
    }

    async function updateMenuTable() {
        // let new_value=await Weigth.get();
        // today_info_block.weigth.innerHTML = "<b>Вага: </b>" + new_value.value + " кг";
    }
    async function updateChart() {
        // let new_value=await Weigth.get();
        // today_info_block.weigth.innerHTML = "<b>Вага: </b>" + new_value.value + " кг";
    }
</script>
<script>
    let choosed_prouct_or_recipe = { id: null, weight: 0, time: '', type: null };
    let dropdown = document.getElementById('select_search_dropdown');
    let select_search = document.getElementById('select_search');
    let valid_message = document.getElementById('select_search_valid_message');
    let weight_input = document.getElementById('modal_add_meal_weight');
    let ingredient_list = document.getElementById('ingredient_list');

    weight_input.parentElement.style.display = "none";
    //for search
    async function SearchSelect(url, e) {
        if (e.value == "") HideDropdown();
        else {
            select_search.classList.remove('not-valid');
            valid_message.classList.add('hidden');

            select_search.classList.add('select-search-active');
            let items = await API.get(url + "?search=" + e.value);
            if (items.length == 0) {
                items.push({
                    id: null, title: "Не було знайдено рецептів чи продуктів"
                });
            }
            dropdown.innerHTML = '';
            dropdown.classList.remove('hidden');
            items.forEach(item => {
                const newOption = document.createElement("li");
                newOption.textContent = item.title;
                newOption.setAttribute('full_data', JSON.stringify(item.full_data));
                newOption.setAttribute('type', item.type)
                if (item.id == null) newOption.classList.add('unchoosed')
                else {
                    newOption.id = item.id;
                    newOption.addEventListener('click', function (e) {
                        choosed_prouct_or_recipe.id = e.target.id;
                        choosed_prouct_or_recipe.type = e.target.getAttribute('type');
                        choosed_prouct_or_recipe.full_data = JSON.parse(e.target.getAttribute('full_data'));
                        ShowData(choosed_prouct_or_recipe.id);

                        select_search.value = e.target.innerHTML;
                        HideDropdown();
                    })
                }
                dropdown.appendChild(newOption);
            });
        }
    }
    // 3. Закриття по кліку на екрані 

    document.addEventListener("click", (event) => {
        log(event.target, 'item')
        if (!event.target.contains(dropdown)) {
            HideDropdown()
        }
    });
    function HideDropdown() {
        dropdown.innerHTML = '';
        dropdown.classList.add('hidden');
        select_search.classList.remove('select-search-active');
    }
    //end of code for search
    PrintCharts();
    function ShowData(id) {
        if (choosed_prouct_or_recipe.time == "") {
            // alert("")
            console.warn("Невідомий час прийому їжі:", choosed_prouct_or_recipe.time);
        }
        else {
            let norms = JSON.parse('<?= json_encode($user_norms) ?>');
            console.log(norms.norms);
            let full_data = choosed_prouct_or_recipe.full_data;
            // Оголошуємо norms тут

            let norm_by_time = [];
            //print info for time
            switch (choosed_prouct_or_recipe.time) {
                case 'breakfast':
                    norm_by_time = norms.breakfast;
                    break;
                case 'snack1':
                    norm_by_time = norms.snack1;
                    break;
                case 'lunch':
                    norm_by_time = norms.lunch;
                    break;
                case 'snack2':
                    norm_by_time = norms.snack2;
                    break;
                case 'dinner':
                    norm_by_time = norms.dinner;
                    break;
                default:
                    console.warn("Невідомий час прийому їжі:", choosed_prouct_or_recipe.time);
                    // Можливо, потрібно ініціалізувати norm_by_time порожнім об'єктом або іншими значеннями за замовчуванням
                    // наприклад, norm_by_time = {};
                    break;
            }

            console.log("norm_by_time:", norm_by_time);

            console.log("full_data", full_data);
            //print info
            if (choosed_prouct_or_recipe.type == "p") {
                weight_input.parentElement.style.display = "flex";
                weight_input.parentElement.style.flexDirection = "column";
                // hide ingredients
                ingredient_list.parentElement.style.display = "none";
            } else {
                weight_input.parentElement.style.display = "none";
                //print ingredients
                ingredient_list.style.display = "block";
                let html = "";

                full_data.ingredients.forEach(i => {
                    html += "<li>" + i.title + "(" + i.weight + " г) - " + i.kcal + " ккал</li>"
                });

                ingredient_list.innerHTML = html;

            }

            //print charts
            PrintCharts(norm_by_time, norms.norms, full_data);
        }
    }
    function PrintCharts(norms_procent, all_norms, data) {
        console.log("norms_procent", norms_procent);
        console.log("all_norms", all_norms);
        console.log("data", data);
        if (data == null) {
            PrintChart('modal_add_meal_chart1', 0, 'Ккал', '#073b4c');
            PrintChart('modal_add_meal_chart2', 0, 'Білок', '#ef476f');
            PrintChart('modal_add_meal_chart3', 0, 'Жири', '#ffd166');
            PrintChart('modal_add_meal_chart4', 0, 'Вуглеводи', '#06d6a0');
            PrintChart('modal_add_meal_chart5', 0, 'Натрій', '#118ab2');
            PrintChart('modal_add_meal_chart6', 0, 'Клітковина', '#118ab2');
        }
        else {
            console.log("(" + norms_procent.avg + "*" + all_norms.kcal + ")/100");
            let norms_new = {

                kcal: (norms_procent.avg * all_norms.kcal) / 100,
                protein: (norms_procent.avg * all_norms.protein) / 100,
                fat: (norms_procent.avg * all_norms.fat) / 100,
                carbonation: (norms_procent.avg * all_norms.carbonation) / 100,
                na: (norms_procent.avg * all_norms.na) / 100,
                cellulose: (norms_procent.avg * all_norms.cellulose) / 100,
            };
            let procents = {
                kcal: Math.round((data.kcal * 100) / norms_new.kcal),
                protein: Math.round((data.protein * 100) / norms_new.protein),
                fat: Math.round((data.fat * 100) / norms_new.fat),
                carbonation: Math.round((data.carbonation * 100) / norms_new.carbonation),
                na: Math.round((data.na * 100) / norms_new.na),
                cellulose: Math.round((data.cellulose * 100) / norms_new.cellulose),

            };
            console.log("(" + data.kcal + "*" + 100 + ")/" + norms_new.kcal);
            PrintChart('modal_add_meal_chart1', procents.kcal, 'Ккал \r\n (' + data.kcal + ')', '#073b4c');
            PrintChart('modal_add_meal_chart2', procents.protein, 'Білок\r\n (' + data.protein + ')', '#ef476f');
            PrintChart('modal_add_meal_chart3', procents.fat, 'Жири\r\n (' + data.fat + ')', '#ffd166');
            PrintChart('modal_add_meal_chart4', procents.carbonation, 'Вуглеводи\r\n (' + data.carbonation + ')', '#06d6a0');
            PrintChart('modal_add_meal_chart5', procents.na, 'Натрій\r\n (' + data.na + ')', '#118ab2');
            PrintChart('modal_add_meal_chart6', procents.cellulose, 'Клітковина\r\n (' + data.cellulose + ')', '#118ab2');
        }


    }
    function PrintChart(chart_id, procent = 70, label = "", color = "Green") {
        if (procent > 100) color = "Red";

        var options = {
            series: [procent],
            chart: {
                height: 150,
                width: 150,
                type: 'radialBar',
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '70%',
                    }
                },
            },
            colors: [color],
            labels: [label],
        };


        var chart = new ApexCharts(document.querySelector("#" + chart_id), options);
        chart.render();



    }
    function ChooseWeigth(e) {
        choosed_prouct_or_recipe.weight = e.value;
    }
    function ChooseTime(e) {
        choosed_prouct_or_recipe.time = e.value;
        ShowData(choosed_prouct_or_recipe.id);
        let html_for_info = "";
        switch (choosed_prouct_or_recipe.time) {
            case 'breakfast':
                html_for_info += "<i>Прийом їжі сніданок має включати 25% від загальної норми ккал</i>";
                break;
            case 'snack1':
                html_for_info += "<i>Прийом їжі ранковий перекус має включати 5-10% від загальної норми ккал</i>"
                break;
            case 'lunch':
                html_for_info += "<i>Прийом їжі обід має включати 40-45% від загальної норми ккал</i>"
                break;
            case 'snack2':
                html_for_info += "<i>Прийом їжі після обідній перекус має включати 10-15% від загальної норми ккал</i>"
                break;
            case 'dinner':
                html_for_info += "<i>Прийом їжі вечеря має включати 15-20% від загальної норми ккал</i>"
                break;
        }

        document.getElementById("info_about_time").innerHTML = html_for_info;
    }


    async function SaveMeal() {
        let body = {
            "recipe_id": null,
            "product_id": null,
            "weigth": 0,
            "time": choosed_prouct_or_recipe.time,
        };
        if (choosed_prouct_or_recipe.type == "p") {
            body.product_id = choosed_prouct_or_recipe.id;
            body.weigth = choosed_prouct_or_recipe.weight;
        } else {
            body.recipe_id = choosed_prouct_or_recipe.id;
        }
        let res = await API.post('/api/meals/store/today', body);
        document.getElementById('select_search').value = "";
        document.getElementById('modal_add_meal_weight').value = "";
        document.getElementById('meal_time').value = "";
        href('/profile');
    }
</script>
<script>
    let trainings_list = JSON.parse('<?= json_encode($workoutsTypes) ?>');
    function calcKcalByTraining() {
        let training = document.getElementById('modal_add_training_select_training').value;
        let date_start = document.getElementById('modal_add_training_start_time').value;
        let date_end = document.getElementById('modal_add_training_end_time').value;

        if (training != '' && date_start != '' && date_end != '') {
            let calc_kcal = document.getElementById('calc_kcal_by_training');

            let minutes = diff_minutes(date_end, date_start);

            console.log('kcal', training);
            let kcal_on_1_hour = trainings_list.filter(x => x.id == training)[0].kcal;

            console.log('kcal on 1 hour', kcal_on_1_hour);
            console.log('min', minutes);
            let kcal = Math.round((kcal_on_1_hour / 60) * minutes);
            calc_kcal.value = kcal+" ккал";
        }
    }
    function diff_minutes(dt2, dt1) {
        let d2 = dt2.toString().split(":");
        let d1 = dt1.toString().split(":");
        let hres = (d2[0] - d1[0]) * 60;
        let mres = (d2[1] - d1[1]);
        return hres + mres;
    }

</script>
<!-- For modal (add meal) -->
<script>

    //     if (type == "r") {
    //         html += "<p><b>Дієти:</b> " + diets_text + "</p>";
    //         html += "<p><b>Алергени:</b> " + allergies_text + "</p>";

</script>