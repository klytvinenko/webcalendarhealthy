<div id="profile_link">
    <a href="/profile/setting" title="Переглянути"><?= $data['user']['login'] ?></a>
    <a href="/logout" class="logout">Вихід</a>
</div>
<div class="calendar">
    <a href="/profile/calendar">Календар</a>
    <a href="/profile/products">Продукти</a>
    <a href="/profile/recipes">Рецепти</a>
    <a href="/profile/workouts">Тренування</a>
</div>
<?php
use App\Data;
require_once 'Resources/views/modals/add_meal.php';
require_once 'Resources/views/modals/add_training.php';
require_once 'Resources/views/modals/add_weigth.php';
require_once 'Resources/views/modals/generate_menu.php';

?>

<!-- Профиль -->
<div id="dayinfo">
    <?php
    $menu_today = $menu;
    ?>
    <h3><?= $data_text ?></h3>
    <div id="menu">
        <p id="menu_text"><?= empty($menu_today['text']) ? "Страв на сьогодні не додано" : $menu_today['text'] ?></p>
        <div id="menu_chart"></div>
        <div id="info">
            <p id="info_weigth"><b>Вага:</b>
                <?= empty($weigth) ? " <small>ваги сьогодні не додано</small>" : $weigth . " кг" ?>
            </p>
            <ol id="list_training"><b>Тренування:</b>
                <?= empty($trainings) ? " <small>тренувань на сьогодні не додано</small>" : $trainings ?>
            </ol>
        </div>
    </div>
    <div id="dayinfo_buttons">
        <button onclick="openModal('modalAddWeigth')">Вага</button>
        <button onclick="openModal('modalAddTraining')">Тренування</button>
        <?php
        if ($_SESSION['user']['norms']['kcal'] != 0) {
            ?>
            <button onclick="openModal('modalGenerateMenu')">Генерувати</button>
            <button onclick="openModal('modalAddMeal')">Додати страву</button>
            <?php
        } else {
            ?>
            <button onclick="location.href='/profile/setting/norms'">Розрахувати норми ккалорій</button>
            <?php
        }
        ?>
    </div>
</div>
<section class="generall">
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
</section>
<script>
    let today_info_block={
        menu:document.getElementById("menu"),
        menu_text:document.getElementById("menu_text"),
        menu_chart:document.getElementById("menu_chart"),
        info:document.getElementById("info"),
        info_weigth:document.getElementById("info_weigth"),
        list_training:document.getElementById("list_training"),
        menu:document.getElementById("menu"),
    };
</script>
<!-- <script>
    let today_kcal_chart = null;
    let norms = null;
    async function DrawChartTodayKcal() {

        norms = await User.getNorms();
        let data_today = await Meal.getMenuDataForToday();

        let data_calced_all = data_today.calced_all;

        var options = {
            series: [Math.round((data_calced_all.fat * 100) / norms.fats),
            Math.round((data_calced_all.protein * 100) / norms.protein),
            Math.round((data_calced_all.carbonation * 100) / norms.carbohydrates),
            Math.round((data_calced_all.na * 100) / norms.na),
            Math.round((data_calced_all.cellulose * 100) / norms.cellulose)],
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
                                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                return data_calced_all.kcal;
                            }
                        }
                    }
                }
            },
            labels: ['Жири', 'Білки', 'Вуглеводи', 'Натрій', 'Клітковина'],
        };
        today_kcal_chart = new ApexCharts(document.querySelector("#menu_chart"), options);
        today_kcal_chart.render();
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

        let chart = new ApexCharts(document.querySelector(chart_id), options);
        chart.render();


    }

</script>
<!-- main -->
<script>
    function generateMenu() {
        Meal.generateMenu();
        //reprint menu
    }

    DrawChartTodayKcal();
</script>
<!-- For modal (add meal) -->
<script>
    let form_add_meal_data = { meal: null, time: null, weigth: null };

    function ModalAddMealChoosedMeal(id) {
        form_add_meal_data.meal = id;
        if (form_add_meal_data.time != null) ModalAddMealPrintDataAboutChoosedMeal();
    }
    function ModalAddMealChoosedMealtime(e) {
        form_add_meal_data.time = e.value;
        if (form_add_meal_data.meal != null) ModalAddMealPrintDataAboutChoosedMeal();
    }
    function ModalAddMealChoosedWeigth(e) {
        form_add_meal_data.weigth = e.value;
        if (form_add_meal_data.meal != null && form_add_meal_data.time != null) ModalAddMealPrintDataAboutChoosedMeal();
    }
    async function AddMeal() {
        let weigth = form_add_meal_data.weigth;
        let res = Meal.store('meals', {
            meal: form_add_meal_data.meal,
            mealtime: form_add_meal_data.time,
            weight: weigth
        }, "meal");

        closeModal("modalAddMeal");
        let result = await Meal.getMenuDataForToday();
        console.log("result", result)
        console.log("today_kcal_chart", today_kcal_chart)

        document.getElementById("menu_text").innerHTML = result.text;

        console.log("result.calced_all", result.calced_all)
        console.log("norms", norms)
        try {
            let new_data = [Math.round((result.calced_all.fat * 100) / norms.fats),
            Math.round((result.calced_all.protein * 100) / norms.protein),
            Math.round((result.calced_all.carbonation * 100) / norms.carbohydrates),
            Math.round((result.calced_all.na * 100) / norms.na),
            Math.round((result.calced_all.cellulose * 100) / norms.cellulose)];
            console.log("new_data", new_data)
            //add kcal in chart
            // today_kcal_chart.updateSeries([{
            //     data: new_data
            // }]);
            today_kcal_chart.updateOptions({
                series: new_data,
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            total: {
                                formatter: function (w) {
                                    // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                                    return result.calced_all.kcal;
                                }
                            }
                        }
                    }
                },
            })
        } catch (error) {
            console.error("Error updating chart:", error);
        }
    }
    async function ModalAddMealPrintDataAboutChoosedMeal() {
        let array_of_params = form_add_meal_data.meal.split("_");
        let type = array_of_params[0];
        let id = array_of_params[1];

        // if(type=="p"&&form_add_meal_data.weigth==null) break; 

        let data = await Meal.getDataByProductOrRecipe(type, id);
        console.log("data 2", data);
        let modal_add_meal_choosed_order_description = document.getElementById("modal_add_meal_choosed_order_description");
        let html = "";
        switch (form_add_meal_data.time) {
            case 'Сніданок':
                html += "<i>Прийом їжі сніданок має включати 25% від загальної норми ккал</i>"
                break;
            case 'Ранковий перекус':
                html += "<i>Прийом їжі ранковий перекус має включати 5-10% від загальної норми ккал</i>"
                break;
            case 'Обід':
                html += "<i>Прийом їжі обід має включати 40-45% від загальної норми ккал</i>"
                break;
            case 'Після обідній перекус':
                html += "<i>Прийом їжі після обідній перекус має включати 10-15% від загальної норми ккал</i>"
                break;
            case 'Вечеря':
                html += "<i>Прийом їжі вечеря має включати 15-20% від загальної норми ккал</i>"
                break;
        }

        let diets = data.diets.map(x => x.name);
        let allergies = data.allergies.map(x => x.name);

        let diets_text = diets.length == 0 ? " - " : diets.join(',');
        let allergies_text = allergies.length == 0 ? " - " : allergies.join(',');

        if (type == "r") {
            html += "<p><b>Дієти:</b> " + diets_text + "</p>";
            html += "<p><b>Алергени:</b> " + allergies_text + "</p>";
            html += "<b>Інгрідієнти:</b>"
            html += "<ul>";
            data.ingredients.forEach(ingredient => {
                html += "<li>" + ingredient.title + "</li>";
            });

            html += "</ul>";
            ChangeFormControllForMeal(false);
        } else {
            html += "<p><b>Дієти:</b> " + diets_text + "</p>";
            html += "<p><b>Алергени:</b> " + allergies_text + "</p>";
            ChangeFormControllForMeal(true);
        }

        if (type == 'r') form_add_meal_data.weigth = null;
        PrintChart("#modal_add_meal_chart1", Meal.CalcNorm(norms.kcal, data.kcal, form_add_meal_data.weigth), "Kcal " + data.kcal, "#073b4c");
        PrintChart("#modal_add_meal_chart2", Meal.CalcNorm(norms.protein, data.protein, form_add_meal_data.weigth), "Protein " + data.protein, "#ef476f");
        PrintChart("#modal_add_meal_chart3", Meal.CalcNorm(norms.fat, data.fat, form_add_meal_data.weigth), "Fat " + data.fat, "#ffd166");
        PrintChart("#modal_add_meal_chart4", Meal.CalcNorm(norms.carbonation, data.carbonation, form_add_meal_data.weigth), "Carbonation " + data.carbonation, "#06d6a0");
        PrintChart("#modal_add_meal_chart5", Meal.CalcNorm(norms.na, data.na, form_add_meal_data.weigth), "Na " + data.na, "#118ab2");
        PrintChart("#modal_add_meal_chart6", Meal.CalcNorm(norms.cellulose, data.cellulose, form_add_meal_data.weigth), "Cellulose " + data.cellulose);
        modal_add_meal_choosed_order_description.innerHTML = html;
    }
    document.getElementById("modal_add_meal_form_control_weight_input").style.display = "none";
    function ChangeFormControllForMeal(isShow) {
        const form_control = document.getElementById("modal_add_meal_form_control_meal");
        const modal_add_meal_form_control_weight_input = document.getElementById("modal_add_meal_form_control_weight_input");
        const modal_add_meal_weight = document.getElementById("modal_add_meal_weight");
        if (isShow) {
            form_control.classList.add("w-half");
            form_control.classList.remove("w-full");
            modal_add_meal_form_control_weight_input.style.display = "block";
        } else {

            form_control.classList.add("w-full");
            form_control.classList.remove("w-half");
            modal_add_meal_form_control_weight_input.style.display = "none";
            modal_add_meal_weight.value = 0;
        }
    }

    async function AddWeigth() {
        let new_weigth = document.getElementById("modal_add_weigth_weigth").value;
        let res = await Weigth.store('weigths', {
            weigth: new_weigth
        }, "weigth");

        closeModal("modalAddWeigth");
        console.log(document.getElementById("info_weigth"))
        document.getElementById("info_weigth").innerHTML = "<b>Вага:</b>" + new_weigth + " кг";
    }
    async function AddTrainingFromModal(date_now) {
        try {
            let title = document.getElementById("modal_add_training_title").value;
            let starttime = document.getElementById("modal_add_training_start").value;
            let endtime = document.getElementById("modal_add_training_end").value;
            // API
            const response = await fetch("../ajax/workouts/store.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name: title,
                    startTime: new Date([date_now, starttime]),
                    endTime: new Date([date_now, endtime])
                })
            });

            const data = await response.json();
            if (data.status == 1) {
                let list_of_trainning = document.querySelectorAll('#info ol')[0];
                // if (list_of_trainning.textContent.include(" тренувань на сьогодні не додано")) list_of_trainning = "";

                let html = "<li>" + title + " (" + starttime + "-" + endtime + ")<span title='Видалити' onclick='deleteTrainingFromProfile(" + data.data + ")'>❌</span></li>";
                list_of_trainning.innerHTML += html;

                closeModal("modalAddTraining");
            }
            else console.error("Помилка додавання ваги");
        } catch (error) {
            console.error("Помилка додавання ваги", error);
        }

    }

    async function deleteTrainingFromProfile(id) {
        await Workout.delete("workouts", id);
        reWriteListOfTrainning()
    }
    async function reWriteListOfTrainning() {
        let list_of_trainning = document.querySelectorAll('#info ol')[0];
        list_of_trainning.innerHTML = "";
        let data = await Workout.getAllToday();
        if (data.length == 0) {
            list_of_trainning.innerHTML = "<b>Тренування:</b><small>тренувань на сьогодні не додано</small>";
        } else {
            data.forEach(item => {
                let html = "<li>" + item.name + " (" + item.startTime + "-" + item.endTime + ")<span title='Видалити' onclick='deleteTrainingFromProfile(" + item.id + ")'>❌</span></li>";
                list_of_trainning.innerHTML += html;
            });
        }
    }

</script>
<script>
    const input = document.getElementById('modal_add_meal_meal');
    const suggestionsBox = document.getElementById('suggestions-box');

    async function loadProducts(search) {
        let data = await Product.Search(search);
        data.forEach(product => {
            product.id = "p_" + product.id;
        });
        return data;
    }
    async function loadRecipes(search) {
        let data = await Recipe.Search(search);
        data.forEach(recipe => {
            recipe.id = "r_" + recipe.id;
        });
        return data;
    }

    input.addEventListener('input', async () => {
        const query = input.value.trim();

        if (!query) {
            suggestionsBox.innerHTML = '';
            suggestionsBox.hidden = true;
            return;
        }

        // Фільтруємо по name
        let filtered = await loadRecipes(query);
        let filtered_products = await loadProducts(query);
        filtered = filtered.concat(filtered_products);

        suggestionsBox.innerHTML = '';

        if (filtered.length === 0) {
            suggestionsBox.hidden = true;
            return;
        }

        console.log("filtered", filtered);

        filtered.forEach(item => {
            const div = document.createElement('div');
            div.className = 'suggestion-item';
            div.textContent = item.id[0] == 'r' ? item.title : "* " + item.title;

            div.addEventListener('click', () => {
                ModalAddMealChoosedMeal(item.id);
                input.value = item.id[0] == 'r' ? item.title : "* " + item.title;

                suggestionsBox.innerHTML = '';
                suggestionsBox.hidden = true;

            });

            //create span with emoji empty heart
            let span = document.createElement('span');
            span.className = 'emoji';
            span.textContent = '🤍';//white heart
            span.style.fontSize = '20px';
            span.style.marginLeft = '10px';
            //add event
            span.addEventListener('click', () => {
                // this.textContent = '❤️';//red heart
                // if (item.id[0] == 'r') Recipe.Like(item.id[1]);
                // else Product.Like(item.id[1]);

            });
            div.appendChild(span);

            suggestionsBox.appendChild(div);
        });

        suggestionsBox.hidden = false;
    });

    document.addEventListener('click', (e) => {
        if (!document.querySelector('.autocomplete-wrapper').contains(e.target)) {
            suggestionsBox.hidden = true;
        }
    });
</script> -->
<script>

async function DrawChartTodayKcal() {

var options = {
    series: [<?=$norms['fat']?>,<?=$norms['protein']?>,<?=$norms['carbonation']?>,<?=$norms['na']?>,<?=$norms['cellulose']?>],
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
                        return <?=$norms['kcal']?>;
                    }
                }
            }
        }
    },
    labels: ['Жири', 'Білки', 'Вуглеводи', 'Натрій', 'Клітковина'],
};
today_kcal_chart = new ApexCharts(document.querySelector("#menu_chart"), options);
today_kcal_chart.render();
</script>