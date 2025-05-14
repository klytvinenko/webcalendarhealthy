// Константи
const DAYS = [
    'Неділя',
    'Понеділок',
    'Вівторок',
    'Середа',
    'Четвер',
    'Пятниця',
    'Субота',
  ];
  
  const MONTHS = [
    'Січень',
    'Лютий',
    'Березень',
    'Квітень',
    'Травень',
    'Червень',
    'Липень',
    'Серпень',
    'Вересень',
    'Жовтень',
    'Листопад',
    'Грудень',
  ];
  
  // Стан календаря
  let state = {
    appointments: [], // тренування
    appointmentDates: [], // дати тренувань
    selectedDay: null,
    elements: {} // DOM елементи
  };
  
  // Ініціалізація календаря
  function initializeCalendar(date = new Date()) {
    // Зберігаємо посилання на DOM елементи
    state.elements = {
      calendar: document.getElementById('calendar-app'),
      calendarView: document.getElementById('calendar-view'),
      datesView: document.getElementById('dates'),
      calendarMonth: document.getElementById('calendar-month'),
      calendarMonthLast: document.getElementById('calendar-month-last'),
      calendarMonthNext: document.getElementById('calendar-month-next'),
      dayView: document.getElementById('day-view'),
      dayViewExit: document.getElementById('day-view-exit'),
      dayViewDate: document.getElementById('day-view-date'),
      addEvent: document.getElementById('add-event'),
      dayEventsList: document.getElementById('day-events-list'),
      dayEventBox: document.getElementById('add-day-event-box'),
      inspirationalQuote: document.getElementById('inspirational-quote'),
      dayEventsExists: document.getElementById('day-events-exists'),
      todayIs: document.getElementById('footer-date'),
      btnGenerateMeals: document.getElementById('btn-generate-meals'),
      btnAddMeal: document.getElementById('btn-add-meal'),
      AddDayMealBox: document.getElementById('add-day-meal-box'),
      eventForm: {
        cancelBtn: document.getElementById('add-event-cancel'),
        addBtn: document.getElementById('add-event-save'),
        nameEvent: document.getElementById('input-add-event-name'),
        startTime: document.getElementById('input-add-event-start-time'),
        endTime: document.getElementById('input-add-event-end-time'),
        startAMPM: document.getElementById('input-add-event-start-ampm'),
        endAMPM: document.getElementById('input-add-event-end-ampm'),
      },
      mealForm: {
        MealType: 'recept',
        toggleMealType: document.getElementById('toggle-meal-type'),
        cancelBtn: document.getElementById('add-meal-cancel'),
        addBtn: document.getElementById('add-meal-save'),
        mealSelect: document.getElementById('search-input'),
        suggestionsBox: document.getElementById('suggestions-box'),
        productWeigth: document.getElementById('product-weigth'),
        productWeigthBox: document.getElementById('product_weigth_input'),
        recipeIngredietns: document.getElementById('recipe-ingredietns'),
        recipeIngredietnsBox: document.getElementById('recipe_ingredients_list'),
        charts: {
          kcal: document.getElementById('meal_chart1'),
          protein: document.getElementById('meal_chart2'),
          fat: document.getElementById('meal_chart3'),
          carbonation: document.getElementById('meal_chart4'),
          na: document.getElementById('meal_chart5'),
          cellulose: document.getElementById('meal_chart6'),
        }
      }
    };
    state.current_date = null;
  
    // Встановлюємо поточну дату
    state.elements.todayIs.textContent = `Сьогодні ${MONTHS[date.getMonth()]}, ${date.getDate()}`;
  
    // Додаємо обробники подій
    addEventListeners();
  
    // Завантажуємо дані
    // loadTrainings(date);
    // loadMeal(date);
  
    state.appointments = [];
    state.appointmentDates = [];
    showCalendarView(date);
  }
  
  // Завантаження тренувань з сервера
  async function loadTrainings(date) {
    const data = await Workout.ByDate(date);
  
    return data.map(item => ({
      id: item.id,
      name: item.title,
      startTime: new Date(item.start_datetime),
      endTime: new Date(item.end_datetime),
      day: new Date(item.start_datetime).toString()
    }));
  
  }
  async function loadMeals(date) {
    const data = await Meal.ByDate(date);
    console.log("meals",data);
    return data;
  }
  async function loadProducts(search) {
    const data = await Product.Search(search);
    return data;
  }
  async function loadRecepts(search) {
    const data = await Recipe.Search(search);
    return data;
  }
  
  // Відображення календаря
  function showCalendarView(date) {
    if (!date || !(date instanceof Date)) date = new Date();
  
    const year = date.getFullYear();
    const month = date.getMonth();
    const today = new Date();
  
    // Очищаємо календар
    state.elements.datesView.innerHTML = '';
    state.elements.calendarMonth.classList.remove('cview__month-activate');
    state.elements.calendarMonth.classList.add('cview__month-reset');
  
    // Додаємо дні
    const firstDay = new Date(year, month, 1).getDay();
    const lastDay = new Date(year, month + 1, 0).getDate();
  
    // Додаємо пропуски для вирівнювання календаря
    for (let i = 0; i < firstDay; i++) {
      const spacer = document.createElement('div');
      spacer.className = 'cview--spacer';
      state.elements.datesView.appendChild(spacer);
    }
  
    // Додаємо дні місяця
    for (let day = 1; day <= lastDay; day++) {
      const currentDate = new Date(year, month, day);
      const dayElement = createDayElement(currentDate, today);
      state.elements.datesView.appendChild(dayElement);
    }
  
    // Оновлюємо заголовок місяця
    updateMonthHeader(date);
  }
  
  // Створення елемента дня
  function createDayElement(date, today) {
    const dayElement = document.createElement('div');
    dayElement.className = 'cview--date';
    dayElement.textContent = date.getDate();
    dayElement.setAttribute('data-date', date);
    dayElement.onclick = (e) => showDay(e, dayElement);
  
    // Додаємо клас для сьогоднішнього дня
    if (isSameDay(date, today)) {
      dayElement.classList.add('today');
    }
  
    // Додаємо клас якщо є події
    if (state.appointmentDates.includes(date.toString())) {
      dayElement.classList.add('has-events');
    }
  
    return dayElement;
  }
  
  // Перевірка чи дві дати це один і той самий день
  function isSameDay(date1, date2) {
    return date1.getDate() === date2.getDate() &&
      date1.getMonth() === date2.getMonth() &&
      date1.getFullYear() === date2.getFullYear();
  }
  
  // Оновлення заголовка місяця
  function updateMonthHeader(date) {
    const lastMonth = new Date(date.getFullYear(), date.getMonth() - 1, 1);
    const nextMonth = new Date(date.getFullYear(), date.getMonth() + 1, 1);
  
    state.elements.calendarMonth.textContent = `${MONTHS[date.getMonth()]} ${date.getFullYear()}`;
    state.elements.calendarMonthLast.textContent = `← ${MONTHS[lastMonth.getMonth()]}`;
    state.elements.calendarMonthNext.textContent = `${MONTHS[nextMonth.getMonth()]} →`;
  
    setTimeout(() => {
      state.elements.calendarMonth.classList.add('cview__month-activate');
    }, 50);
  }
  
  // Додавання обробників подій
  function addEventListeners() {
    // Обробники для календаря
    state.elements.calendar.addEventListener('click', handleCalendarClick);
    state.elements.calendarMonthLast.addEventListener('click', () => showNewMonth('last'));
    state.elements.calendarMonthNext.addEventListener('click', () => showNewMonth('next'));
  
    // Обробники для вікна дня
    state.elements.dayViewExit.addEventListener('click', closeDayWindow);
    state.elements.addEvent.addEventListener('click', showNewEventForm);
    state.elements.btnAddMeal.addEventListener('click', showNewMealForm);
  
    // Обробники для форми додавання події
    state.elements.eventForm.cancelBtn.addEventListener('click', closeNewEventForm);
    state.elements.eventForm.addBtn.addEventListener('click', saveNewEvent);
  
    // Обробники для форми додавання події
    state.elements.eventForm.cancelBtn.addEventListener('click', closeNewMealForm);
    state.elements.eventForm.addBtn.addEventListener('click', saveNewMeal);
  
    const options = state.elements.mealForm.toggleMealType.querySelectorAll('.toggle-option');
  
    options.forEach(option => {
      option.addEventListener('click', () => {
        options.forEach(o => o.classList.remove('active'));
        option.classList.add('active');
        state.elements.mealForm.MealType = option.dataset.value;
        changeMeallAddView()
      });
    });
    state.elements.mealForm.mealSelect.addEventListener('input', async () => {
      const query = state.elements.mealForm.mealSelect.value.trim();
  
      if (!query) {
        state.elements.mealForm.suggestionsBox.innerHTML = '';
        state.elements.mealForm.suggestionsBox.hidden = true;
        return;
      }
  
      // Фільтруємо по name
      let filtered = [];
      if (state.elements.mealForm.MealType == 'product') filtered = await loadProducts(query);
      else filtered = await loadRecepts(query);
  
      state.elements.mealForm.suggestionsBox.innerHTML = '';
  
      if (filtered.length === 0) {
        state.elements.mealForm.suggestionsBox.hidden = true;
        return;
      }
  
      filtered.forEach(item => {
        const div = document.createElement('div');
        div.className = 'suggestion-item';
        div.textContent = item.title;
  
        div.addEventListener('click', () => {
          state.elements.mealForm.mealSelect.value = item.title;
          state.elements.mealForm.suggestionsBox.innerHTML = '';
          state.elements.mealForm.suggestionsBox.hidden = true;
  
          console.log('Обране значення:', item.title);
          console.log('ID значення:', item.id);
  
          if (state.elements.mealForm.MealType == 'product') {
            PrintDataForProduct(item.id);
          }
          else {
            //print_ingredients
            PrintDataForRecept(item.id);
          }
        });
  
        state.elements.mealForm.suggestionsBox.appendChild(div);
      });
  
      state.elements.mealForm.suggestionsBox.hidden = false;
    });
  
    document.addEventListener('click', (e) => {
      if (!document.querySelector('.autocomplete-wrapper').contains(e.target)) {
        state.elements.mealForm.suggestionsBox.hidden = true;
      }
    });
  }
  async function PrintDataForProduct(product_id) {
    //todo calc with weigth
    const weigth=state.elements.mealForm.productWeigth.value;
    console.log("weigth",weigth);
    const product = await Product.find("products",product_id);
    const data = {
      kcal: product.kcal,
      protein: product.protein,
      fat: product.fat,
      carbonation: product.carbonation,
      na: product.na,
      cellulose: product.cellulose,
    };
    const norms = await User.getNorms();
  
    PrintChart("#meal_chart1", Math.round((data.kcal * 100) / norms.kcal), "Kcal " + data.kcal, "#073b4c");
    PrintChart("#meal_chart2", Math.round((data.protein * 100) / norms.protein), "Protein " + data.protein, "#073b4c");
    PrintChart("#meal_chart3", Math.round((data.fat * 100) / norms.fat), "Fat " + data.fat, "#073b4c");
    PrintChart("#meal_chart4", Math.round((data.carbonation * 100) / norms.carbonation), "Carbonation " + data.carbonation, "#073b4c");
    PrintChart("#meal_chart5", Math.round((data.na * 100) / norms.na), "Na " + data.na, "#073b4c");
    PrintChart("#meal_chart6", Math.round((data.cellulose * 100) / norms.cellulose), "Cellulose " + data.cellulose, "#073b4c");
  
  }
  async function PrintDataForRecept(recipe_id) {
    //todo
    const ingredietns = await Recipe.GetIngredients(recipe_id);
  
    //print charts
  }
  function changeMeallAddView() {
    console.log("state.elements.mealForm.MealType", state.elements.mealForm.MealType);
    if (state.elements.mealForm.MealType != 'recept') {
      state.elements.mealForm.productWeigthBox.classList.add('hide');
      state.elements.mealForm.recipeIngredietnsBox.classList.remove('hide');
    }
    else if (state.elements.mealForm.MealType != 'product') {
      state.elements.mealForm.productWeigthBox.classList.remove('hide');
      state.elements.mealForm.recipeIngredietnsBox.classList.add('hide');
    }
  }
  
  function PrintChart(chart_id, procent = 70, label = "", color = "Green") {
    if (procent > 100) color = "Red";
    var options = {
      series: [procent],
      chart: {
        height: 100,
        width: 100,
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
  
  // Обробка кліків по календарю
  function handleCalendarClick(e) {
    if (e.target === state.elements.dayView) {
      closeDayWindow();
    }
  }
  
  // Показ нового місяця
  function showNewMonth(direction) {
    const currentDate = new Date(state.elements.calendarMonth.getAttribute('data-date'));
    const newDate = new Date(currentDate);
  
    if (direction === 'last') {
      newDate.setMonth(currentDate.getMonth() - 1);
    } else {
      newDate.setMonth(currentDate.getMonth() + 1);
    }
  
    showCalendarView(newDate);
  }
  
  // Відображення дня
  function showDay(e, dayElement) {
    e.stopPropagation();
    const date = new Date(dayElement.getAttribute('data-date'));
    state.current_date = date;
    openDayWindow(date);
  }
  
  // Відкриття вікна дня
  async function openDayWindow(date) {
    state.elements.dayView.classList.add('calendar--day-view-active');
    state.elements.dayViewDate.textContent = `${MONTHS[date.getMonth()]} ${date.getDate()} ${date.getFullYear()}`;
  
  
    let month = (date.getMonth() + 1) >= 10 ? date.getMonth() + 1 : "0" + (date.getMonth() + 1);
    const date_for_query = `${date.getFullYear()}-${month}-${date.getDate()}`;
  
    let events_html = await createEventsListElement(date_for_query);
    if (events_html != null) state.elements.dayEventsExists.classList.add('hide');
    state.elements.dayEventsList.innerHTML = '';
  
    console.log("events_html", events_html);
  
    state.elements.dayEventsList.appendChild(events_html);
  
    let menu_html = await createMenuElement(date_for_query);
    console.log("menu_html", menu_html);
    state.elements.dayEventsList.appendChild(menu_html);
  }
  
  // Створення списку подій
  async function createEventsListElement(date) {
    let events = await loadTrainings(date);//todo
    console.log("events", events);
    if (events.length == 0) {
      return null;
    }
    const ul = document.createElement('ul');
    ul.className = 'day-event-list-ul';
    events.sort((a, b) => a.startTime - b.startTime);
  
    events.forEach(event => {
      const li = document.createElement('li');
      li.className = 'event-dates';
      li.innerHTML = `
        <div class="event-dates">
          <span class="start-time">${formatTime(event.startTime)}</span>
          <small>до</small>
          <span class="end-time">${formatTime(event.endTime)}</span>
          <span class="event-name">${event.name}</span>
          <span class="event-delete" data-id="${event.id}">видалити</span>
        </div>
      `;
  
      const deleteBtn = li.querySelector('.event-delete');
      deleteBtn.addEventListener('click', () => deleteEvent(event.id));
  
      ul.appendChild(li);
    });
  
    console.log("ul", ul);
    return ul;
  }
  
  async function createMenuElement(date) {
    let meals = await loadMeals(date);//todo
    const div = document.createElement('div');
    div.className = 'day-meals';
  
    const p = document.createElement('p');
    p.className='menu_text';
    p.innerHTML = meals;
    div.appendChild(p);
  
    return div;
  }
  
  // Форматування часу
  function formatTime(date) {
    return date.toLocaleTimeString(navigator.language, {
      hour: '2-digit',
      minute: '2-digit'
    });
  }
  
  // Видалення події
  function deleteEvent(id) {
    state.appointments = state.appointments.filter(apt => apt.id !== id);
    state.appointmentDates = state.appointments.map(apt => apt.day);
    Workout.Delete(id);
    showCalendarView(new Date());
  }
  
  // Закриття вікна дня
  function closeDayWindow() {
    state.elements.dayView.classList.remove('calendar--day-view-active');
    closeNewEventForm();
  }
  
  // Показ форми нової події
  function showNewEventForm() {
    //disable other button
    state.elements.btnGenerateMeals.classList.add('disabled');
    state.elements.btnAddMeal.classList.add('disabled');
    console.log("btnGenerateMeals", state.elements.btnGenerateMeals)
    console.log("btnAddMeal", state.elements.btnAddMeal)
    state.elements.dayEventBox.setAttribute('data-active', 'true');
  }
  
  // Закриття форми нової події
  function closeNewEventForm() {
    //activate other buttons
    state.elements.btnGenerateMeals.classList.remove('disabled');
    state.elements.btnAddMeal.classList.remove('disabled');
    state.elements.AddDayMealBox.setAttribute('data-active', 'false');
    resetEventForm();
  }
  function showNewMealForm() {
    //disable other button
    state.elements.btnGenerateMeals.classList.add('disabled');
    console.log("btnGenerateMeals", state.elements.btnGenerateMeals)
    console.log("btnAddMeal", state.elements.btnAddMeal)
    state.elements.AddDayMealBox.setAttribute('data-active', 'true');
  }
  
  function closeNewMealForm() {
    //activate other buttons
    state.elements.btnGenerateMeals.classList.remove('disabled');
    state.elements.AddDayMealBox.setAttribute('data-active', 'false');
    resetMealForm();
  }
  // Скидання форми події
  function resetEventForm() {
    state.elements.eventForm.nameEvent.value = '';
    state.elements.eventForm.startTime.value = '';
    state.elements.eventForm.endTime.value = '';
    state.elements.eventForm.startAMPM.value = '';
    state.elements.eventForm.endAMPM.value = '';
  }
  function resetMealForm() {
    //todo
    // state.elements.eventForm.nameEvent.value = '';
    // state.elements.eventForm.startTime.value = '';
    // state.elements.eventForm.endTime.value = '';
    // state.elements.eventForm.startAMPM.value = '';
    // state.elements.eventForm.endAMPM.value = '';
  }
  // Збереження нової події
  async function saveNewEvent() {
    const formData = {
      name: state.elements.eventForm.nameEvent.value.trim(),
      startTime: state.elements.eventForm.startTime.value,
      endTime: state.elements.eventForm.endTime.value,
      startAMPM: state.elements.eventForm.startAMPM.value,
      endAMPM: state.elements.eventForm.endAMPM.value
    };
  
    if (!validateEventForm(formData)) return;
    const date = state.current_date;
    date_str = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
    const event = {
      name: formData.name,
      startTime: new Date(`${date_str} ${formData.startTime} ${formData.startAMPM}`),
      endTime: new Date(`${date_str} ${formData.endTime} ${formData.endAMPM}`)
    }
    // post
    await Workout.store("workouts", event, "workouts");
  
    event.id = state.appointments.length + 1;
    state.appointments.push(event);
    state.appointmentDates = state.appointments.map(apt => apt.day);
  
    showCalendarView(new Date());
  
    closeNewEventForm();
  }
  // Збереження нової події
  async function saveNewMeal() {
    //todo
    const formData = {
      name: state.elements.eventForm.nameEvent.value.trim(),
      startTime: state.elements.eventForm.startTime.value,
      endTime: state.elements.eventForm.endTime.value,
      startAMPM: state.elements.eventForm.startAMPM.value,
      endAMPM: state.elements.eventForm.endAMPM.value
    };
  
    if (!validateEventForm(formData)) return;
    const date = state.current_date;
    date_str = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
    const event = {
      name: formData.name,
      startTime: new Date(`${date_str} ${formData.startTime} ${formData.startAMPM}`),
      endTime: new Date(`${date_str} ${formData.endTime} ${formData.endAMPM}`)
    }
    // post
    await Workout.store("workouts", event, "workouts");
  
    event.id = state.appointments.length + 1;
    state.appointments.push(event);
    state.appointmentDates = state.appointments.map(apt => apt.day);
  
    showCalendarView(new Date());
  
    closeNewEventForm();
  }
  // Валідація форми події
  function validateEventForm(data) {
    if (!data.name) {
      alert('Будь ласка, введіть назву тренування');
      return false;
    }
    if (!data.startTime || !data.endTime) {
      alert('Будь ласка, введіть час початку та закінчення');
      return false;
    }
    return true;
  }
  function validateMealForm(data) {
    //todo
  }
  
  // Ініціалізуємо календар при завантаженні сторінки
  document.addEventListener('DOMContentLoaded', () => {
    initializeCalendar();
  });
  