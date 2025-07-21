
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    *{
      box-sizing: border-box; 
      padding: 0; 
      margin: 0; 
    }

    body {
      font-family: Arial, sans-serif;
      background:rgb(255, 255, 255);
      padding: 20px;
    }

    .calendar-container {
      display: flex;
      max-width: 900px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .calendar {
      width: 60%;
      padding: 20px;
    }

    .calendar header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .calendar header h3 {
      font-size: 1.5rem;
    }

    #prev, #next, #prevView, #nextView , #prevWeek, #nextWeek {
      background: none;
      border: none;
      cursor: pointer;
      width: 25px;
      height: 25px;
    }

    #prev::before, #next::before, #prevView::before, #nextView::before ,#prevWeek::before, #nextWeek::before {
      content: '';
      display: block;
      width: 10px;
      height: 10px;
      border-top: 2px solid #000;
      border-right: 2px solid #000;
      transform: rotate(45deg);
      margin: auto;
    }

    #prev::before,
    #prevView::before,
    #prevWeek::before {
      transform: rotate(-135deg);
    }

    #next::before,
    #nextView::before,
    #nextWeek::before {
      transform: rotate(45deg);
    }

    .days, .dates {
      list-style: none;
      display: flex;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .days li, .dates li {
      width: calc(100% / 7);
      text-align: center;
      margin-bottom: 10px;
      padding: 10px 0;
    }

    .dates li {
      cursor: pointer;
      border-radius: 10%;
      transition: background 0.3s;
    }

    .dates li:hover { 
      background: rgba(223, 113, 47, 0.5); 
    }
    .dates li.today { 
      background: #DF712F; color: #fff; 
    }
    .dates li.inactive { 
      color: #ccc; pointer-events: none; 
    }

    .time-slot-container {
      width: 40%;
      border-left: 1px solid #eee;
      padding: 20px;  
      background: #f9f9f9;
    }

    .time-slot-container h3 {
      margin-bottom: 15px;
      text-align: center;
    }

    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .checkbox-group {
      display: flex;
      flex-direction: column;
      align-items: stretch;
      width: 100%;
      margin-bottom: 20px;
    }

    button {
      width: 40%;
      padding: 10px;
      background-color: #DF712F;
      border: none;
      border-radius: 4px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    button:hover { 
      background: #c25e1c; 
      color: white;
    }

    .time-slot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 8px 0;
      padding: 10px 15px;
      background-color: #f2f2f2;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .time-slot:hover {
      filter: brightness(95%);
    }

    .time-slot.status-0 {
      background-color: #e0e0e0; 
    }

    .time-slot.status-1 {
      background-color: #a5d6a7; 
    }
    .time-slot.status-2 {
      background-color: #90caf9;; 
    }

    .time-slot.selected {
      border-color: #DF712F;
      box-shadow: 0 0 5px rgba(223, 113, 47, 0.5);
    }

    .status-legend {
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 15px;
      padding: 10px;
      background-color: #f9f9f9;
      border-radius: 6px;
    }

    .legend-item {
      display: flex;
      align-items: center;
      margin-right: 15px;
      margin-bottom: 5px;
    }

    .legend-color {
      width: 16px;
      height: 16px;
      margin-right: 5px;
      border-radius: 3px;
    }

    .status-dropdown {
      margin-left: auto;
      padding: 2px 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 0.9rem;
    }

    #appointments-list {
      width: 100%;
    }

    .appointment-item {
      background-color: #f9f9f9;
      border-left: 4px solid #DF712F;
      padding: 12px 15px;
      margin-bottom: 10px;
      border-radius: 0 6px 6px 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }

    .appointment-item:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .appointment-time {
      font-weight: bold;
      color: #DF712F;
      margin-bottom: 5px;
      display: block;
    }

    .appointment-name {
      color: #555;
    }
    
    .week-day {
      cursor: pointer;
      border-radius: 8px;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .week-day:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    
    .week-day.active {
      border-color: #DF712F;
      box-shadow: 0 6px 12px rgba(223, 113, 47, 0.3);
    }
    
    .day-badge {
      position: absolute;
      top: -8px;
      right: -8px;
      background: #DF712F;
      color: white;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 14px;
    }
    
    .empty-slot {
      background-color: #f0f0f0;
      border-left: 4px solid #ccc;
      padding: 12px 15px;
      margin-bottom: 10px;
      border-radius: 0 6px 6px 0;
      opacity: 0.7;
    }
  </style>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            orange: '#DF712F',
          }
        }
      }
    }
  </script>
</head>

<body class="h-screen bg-bg text-gray-800 flex">

  <aside class="w-64 bg-white border-r shadow-md flex flex-col p-6">
    <h2 class="text-3xl font-bold text-orange mb-6 text-center">SmileUp</h2>
    <nav class="flex flex-col gap-3">
      <a href="#" data-tab="dashboard" class="tab-link flex items-center gap-3 p-3 rounded-lg hover:bg-orange hover:text-white transition active bg-orange text-white">Dashboard</a>
      <a href="#" data-tab="schedule" class="tab-link flex items-center gap-3 p-3 rounded-lg hover:bg-orange hover:text-white transition">Schedule</a>
      <a href="#" data-tab="patients" class="tab-link flex items-center gap-3 p-3 rounded-lg hover:bg-orange hover:text-white transition">Patients</a>
    </nav>
  </aside>


  <main class="flex-1 p-8 overflow-y-auto">
    <section id="dashboard" class="tab-content block">
      <h1 class="text-3xl font-semibold text-orange mb-6">Dashboard</h1>

      <div class="flex justify-between items-center mb-4">
        <button id="prevWeek"></button>
        <h2 id="weekRangeHeader" class="text-xl font-bold text-gray-700">May 12 - May 18, 2025</h2>
        <button id="nextWeek"></button>
      </div>

      <div class="grid grid-cols-7 gap-4 mb-8" id="week-cards">
      </div>

      <div class="bg-white shadow rounded-lg p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
          <h2 id="selected-day-header" class="text-xl font-bold text-orange"></h2>
          <span id="appointment-count" class="bg-orange text-white px-3 py-1 rounded-full text-sm"></span>
        </div>
        <div id="day-appointments" class="space-y-3">
        </div>
      </div>

      <div class="grid grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Appointments</h3>
          <p class="text-3xl font-bold text-orange" id="total-appointments">0</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-700 mb-2">Available Hours</h3>
          <p class="text-3xl font-bold text-orange" id="available-hours">0</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h3 class="text-lg font-semibold text-gray-700 mb-2">Utilization</h3>
          <p class="text-3xl font-bold text-orange" id="utilization">0%</p>
        </div>
      </div>
    </section>

    <section id="schedule" class="tab-content hidden">
      <h1 class="text-3xl font-semibold text-orange mb-4">Schedule</h1>

      <div class="mb-6 border-b flex gap-4">
        <button class="subtab-link text-orange font-semibold border-b-2 border-orange pb-2" data-subtab="add-slots">Availability</button>
        <button class="subtab-link text-orange font-semibold border-b-2 border-orange pb-2" data-subtab="view-schedules">Schedule manager</button>
      </div>

      <div id="add-slots" class="subtab-content">
        <div class="status-legend mb-4">
          <div class="legend-item">
            <div class="legend-color" style="background-color: #e0e0e0;"></div>
            <span>Unavailable</span>
          </div>
          <div class="legend-item">
            <div class="legend-color" style="background-color: #a5d6a7;"></div>
            <span>Available</span>
          </div>
          <div class="legend-item">
            <div class="legend-color" style="background-color: #90caf9;"></div>
            <span>Booked</span>
          </div>
        </div>

        <div class="calendar-container">
          <div class="calendar">
            <header>
              <button id="prev"></button>
              <h3></h3>
              <button id="next"></button>
            </header>
            <ul class="days">
              <li>Sun</li><li>Mon</li><li>Tue</li><li>Wed</li><li>Thu</li><li>Fri</li><li>Sat</li>
            </ul>
            <ul class="dates"></ul>
          </div>

          <div class="time-slot-container">
            <h3 id="selected-date">Select a date</h3>
            <form method="POST">
              <input type="hidden" name="selected_date" id="form-date">
              <div class="checkbox-group" id="slot-checkboxes"></div>
              <button id="updateBtn" type="submit" style="display:none;">Update Time Slots</button>
            </form>
          </div>
        </div>
      </div>

      <div id="view-schedules" class="subtab-content hidden">

      </div>
    </section>

    <section id="patients" class="tab-content hidden">
      <h1 class="text-3xl font-semibold text-orange mb-4">Patients</h1>
    </section>
  </main>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
   //sidebar
    const links = document.querySelectorAll('.tab-link');
    const tabs = document.querySelectorAll('.tab-content');

    links.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = this.dataset.tab;

        links.forEach(l => l.classList.remove('bg-orange', 'text-white', 'active'));
        this.classList.add('bg-orange', 'text-white');

        tabs.forEach(tab => tab.classList.add('hidden'));
        document.getElementById(target).classList.remove('hidden');
      });
    });
    //sidebar

    //dashboard
    const weekCards = document.getElementById('week-cards');
    const weekRangeHeader = document.getElementById('weekRangeHeader');
    const totalAppointmentsEl = document.getElementById('total-appointments');
    const availableHoursEl = document.getElementById('available-hours');
    const utilizationEl = document.getElementById('utilization');
    const selectedDayHeader = document.getElementById('selected-day-header');
    const dayAppointmentsEl = document.getElementById('day-appointments');
    const appointmentCountEl = document.getElementById('appointment-count');

    function getMonday(d) {
      const day = d.getDay();
      const diff = d.getDate() - day + (day === 0 ? -6 : 1);
      return new Date(d.setDate(diff));
    }

    function formatDate(date) {
      return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
    }

    function fetchWeekAppointments(weekDates) {
      const formData = new FormData();
      formData.append('dates', JSON.stringify(weekDates));

      return fetch('/niyaw/Admin/weekly_data.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        return data;
      })
      .catch(error => {
        console.error('Error fetching week appointments:', error);
        const weekData = {};
        weekDates.forEach(dateStr => {
          const businessHours = Array.from({ length: 8 }, (_, i) => { 
            const hour = 9 + i;
            const nextHour = hour + 1;
            const time_slot = `${hour.toString().padStart(2, '0')}:00-${nextHour.toString().padStart(2, '0')}:00`;
            return {
              time_slot: time_slot,
              display_time: convertToDisplayTime(time_slot)
            };
          });

          weekData[dateStr] = {
            date: dateStr,
            appointments: [],
            emptySlots: businessHours
          };
        });
        return weekData;
      });
    }

    function convertToDisplayTime(timeSlot) {
      if (!timeSlot || !timeSlot.includes('-')) return timeSlot;
      const [startTime, endTime] = timeSlot.split('-');
      return `${convert24HourTo12Hour(startTime)} - ${convert24HourTo12Hour(endTime)}`;
    }

    function convert24HourTo12Hour(time) {
      if (!time || !time.includes(':')) return time;
      let [hours, minutes] = time.split(':');
      let period = 'AM';
      let hour = parseInt(hours, 10);

      if (hour >= 12) {
        period = 'PM';
        if (hour > 12) hour -= 12;
      }
      if (hour === 0) hour = 12;
      return `${hour}:${minutes}${period}`;
    }

    //appointment details
    function loadDayDetails(dateStr, dayData = null) {
      const [year, month, day] = dateStr.split('-');
      const date = new Date(year, month - 1, day);

      selectedDayHeader.textContent = date.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });

      dayAppointmentsEl.innerHTML = dayData ? '' : '<p class="text-red-500">No schedule available for this day.</p>';
      appointmentCountEl.textContent = dayData ? `${dayData.appointments.length} Appointment${dayData.appointments.length !== 1 ? 's' : ''}` : '';

      if (!dayData) return;

      const allSlots = [...dayData.appointments, ...dayData.emptySlots].sort((a, b) =>
        parseInt(a.time_slot.split(':')[0]) - parseInt(b.time_slot.split(':')[0])
      );

      allSlots.forEach(slot => {
        const slotEl = document.createElement('div');
        slotEl.className = slot.hasOwnProperty('first_name') ? 'appointment-item' : 'empty-slot';
        slotEl.innerHTML = `
          <span class="appointment-time">${slot.display_time || convertToDisplayTime(slot.time_slot)}</span>
          <span class="${slot.hasOwnProperty('first_name') ? 'appointment-name' : 'text-gray-500'}">${slot.first_name ? `${slot.first_name} ${slot.last_name}` : ''}</span>
        `;
        dayAppointmentsEl.appendChild(slotEl);
      });

      if (allSlots.length === 0) {
        dayAppointmentsEl.innerHTML = '<p class="text-center text-gray-500">No time slots available for this day.</p>';
      }
    }
    //weeklydata
    function loadWeekView(startDate) {
      weekCards.innerHTML = '';

      const endDate = new Date(startDate);
      endDate.setDate(endDate.getDate() + 6);

      const options = { month: 'short', day: 'numeric' };
      weekRangeHeader.textContent = `${startDate.toLocaleDateString('en-US', options)} - ${endDate.toLocaleDateString('en-US', options)}, ${endDate.getFullYear()}`;

      let weekDates = [];
      for (let i = 0; i < 7; i++) {
        const currentDate = new Date(startDate);
        currentDate.setDate(currentDate.getDate() + i);
        weekDates.push(formatDate(currentDate));
      }

      fetchWeekAppointments(weekDates).then(weekData => {
        let totalAppointments = 0;
        let totalAvailableHours = 0;
        let totalSlots = 0;

        for (let i = 0; i < 7; i++) {
          const currentDate = new Date(startDate);
          currentDate.setDate(currentDate.getDate() + i);
          const formattedDate = formatDate(currentDate);

          const isToday =
            currentDate.getDate() === new Date().getDate() &&
            currentDate.getMonth() === new Date().getMonth() &&
            currentDate.getFullYear() === new Date().getFullYear();

          const dayCard = document.createElement('div');
          dayCard.className = `week-day bg-white shadow rounded-lg p-4 border-2 ${isToday ? 'border-orange' : 'border-transparent'}`;
          dayCard.dataset.date = formattedDate;

          const dayFormat = { weekday: 'short' };
          const dateFormat = { day: 'numeric' };

          dayCard.innerHTML = `
            <h3 class="text-center font-bold text-lg ${isToday ? 'text-orange' : 'text-gray-700'}">${currentDate.toLocaleDateString('en-US', dayFormat)}</h3>
            <p class="text-center text-2xl font-bold ${isToday ? 'text-orange' : 'text-gray-800'} mt-2">${currentDate.toLocaleDateString('en-US', dateFormat)}</p>
            <div class="day-badge hidden">0</div>`;

          weekCards.appendChild(dayCard);

          const dayData = weekData[formattedDate] || { appointments: [], emptySlots: [] };
          const appointmentCount = dayData.appointments.length;
          const availableSlots = dayData.emptySlots.length;

          if (appointmentCount > 0) {
            const badge = dayCard.querySelector('.day-badge');
            badge.textContent = appointmentCount;
            badge.classList.remove('hidden');
          }

          totalAppointments += appointmentCount;
          totalAvailableHours += availableSlots;
          totalSlots += appointmentCount + availableSlots;

          dayCard.addEventListener('click', function() {
            document.querySelectorAll('.week-day').forEach(card => card.classList.remove('active'));
            this.classList.add('active');
            loadDayDetails(this.dataset.date, dayData);
          });
        }
        totalAppointmentsEl.textContent = totalAppointments;
        availableHoursEl.textContent = totalAvailableHours;
        utilizationEl.textContent = totalSlots > 0 ? `${Math.round((totalAppointments / totalSlots) * 100)}%` : '0%';

        const todayCard = document.querySelector('.week-day[data-date="' + formatDate(new Date()) + '"]');
        (todayCard || document.querySelector('.week-day')).click(); // simplified
      });
    }

    function initializeDashboard() {
      const today = new Date();
      let currentWeekStart = getMonday(today);
      loadWeekView(currentWeekStart);

      document.getElementById('prevWeek').addEventListener('click', () => {
        currentWeekStart.setDate(currentWeekStart.getDate() - 7);
        loadWeekView(currentWeekStart);
      });

      document.getElementById('nextWeek').addEventListener('click', () => {
        currentWeekStart.setDate(currentWeekStart.getDate() + 7);
        loadWeekView(currentWeekStart);
      });
    }
    initializeDashboard();
    //dashboard


    //calendar adn availability
    const calendarHeader = document.querySelector(".calendar h3");
    const calendarDates = document.querySelector(".dates");
    const navs = document.querySelectorAll("#prev, #next");
    const selectedDateEl = document.querySelector("#selected-date");
    const formDateInput = document.querySelector("#form-date");
    const slotContainer = document.querySelector("#slot-checkboxes");

    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];

    const statusLabels = {
      0: "Unavailable",
      1: "Available",
    };

    let date = new Date();
    let month = date.getMonth();
    let year = date.getFullYear();

    function renderCalendar() {
      const start = new Date(year, month, 1).getDay();
      const endDate = new Date(year, month + 1, 0).getDate();
      const end = new Date(year, month, endDate).getDay();
      const endDatePrev = new Date(year, month, 0).getDate();
      let datesHtml = "";

      for (let i = start; i > 0; i--) {
        datesHtml += `<li class="inactive">${endDatePrev - i + 1}</li>`;
      }

      for (let i = 1; i <= endDate; i++) {
        const isToday = (
          i === new Date().getDate() &&
          month === new Date().getMonth() &&
          year === new Date().getFullYear()
        );
        const dayOfWeek = new Date(year, month, i).getDay();
        const isDisabled = dayOfWeek === 0;
        datesHtml += `<li${isToday ? ' class="today"' : ''}${isDisabled ? ' class="inactive"' : ''} data-date="${i}">${i}</li>`;
      }

      for (let i = end; i < 6; i++) {
        datesHtml += `<li class="inactive">${i - end + 1}</li>`;
      }

      calendarDates.innerHTML = datesHtml;
      calendarHeader.textContent = `${months[month]} ${year}`;

      calendarDates.querySelectorAll('li:not(.inactive)').forEach(dayElement => {
        dayElement.addEventListener('click', (e) => {
          const day = e.target.dataset.date;
          if (day) showTimeSlots(day);
        });
      });
    }

    function showTimeSlots(day) {
      const selectedDate = new Date(year, month, day);
      const formatted = selectedDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
      const dbFormat = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

      selectedDateEl.innerHTML = `Time slots for <strong>${formatted}</strong>`;
      formDateInput.value = dbFormat;
      slotContainer.innerHTML = '<p class="text-center">Loading time slots...</p>';

      fetchTimeSlots(dbFormat)
        .then(timeSlots => {
          slotContainer.innerHTML = '';
          if (timeSlots.length === 0) {
            Array.from({ length: 8 }, (_, i) => { // Generate 9AM-5PM
              const hour = 9 + i;
              createTimeSlotElement(hour, 0, null);
            });
          } else {
            timeSlots.forEach(slot => {
              const hour = parseInt(slot.time_slot.split(':')[0]);
              createTimeSlotElement(hour, parseInt(slot.status), slot.id);
            });
          }
        })
        .catch(error => {
          slotContainer.innerHTML = '<p class="text-center text-red-500">Error loading time slots. Please try again later.</p>';
          console.error('Failed to load time slots:', error);
        });
    }

    function createTimeSlotElement(hour, status, id) {
      const displayHour = hour > 12 ? hour - 12 : hour;
      const ampm = hour >= 12 ? 'PM' : 'AM';
      const nextDisplayHour = (hour + 1) > 12 ? (hour + 1) - 12 : (hour + 1);
      const nextAmpm = (hour + 1) >= 12 ? 'PM' : 'AM';
      const timeLabel = `${displayHour}:00 ${ampm} - ${nextDisplayHour}:00 ${nextAmpm}`;
      const dbTimeLabel = `${hour.toString().padStart(2, '0')}:00-${(hour + 1).toString().padStart(2, '0')}:00`;

      const timeSlot = document.createElement("div");
      timeSlot.className = `time-slot status-${status}`;
      timeSlot.dataset.value = dbTimeLabel;
      timeSlot.dataset.status = status;
      if (id) {
        timeSlot.dataset.id = id;
      }

      const timeText = document.createElement("span");
      timeText.textContent = timeLabel;
      timeSlot.appendChild(timeText);

      if (status <= 1) {
        const statusDropdown = document.createElement("select");
        statusDropdown.className = "status-dropdown";
        [0, 1].forEach(statusCode => {
          const option = document.createElement("option");
          option.value = statusCode;
          option.textContent = statusLabels[statusCode];
          if (statusCode === status) {
            option.selected = true;
          }
          statusDropdown.appendChild(option);
        });

        statusDropdown.addEventListener("change", function(e) {
          const newStatus = parseInt(this.value);
          timeSlot.classList.remove(`status-${timeSlot.dataset.status}`);
          timeSlot.classList.add(`status-${newStatus}`);
          timeSlot.dataset.status = newStatus;

          if (timeSlot.dataset.id) {
            updateSingleTimeSlotStatus(timeSlot.dataset.id, newStatus)
              .then(response => {
                if (!response.success) {
                  alert('Failed to update status: ' + (response.error || 'Unknown error'));
                  timeSlot.classList.remove(`status-${newStatus}`);
                  timeSlot.classList.add(`status-${status}`);
                  timeSlot.dataset.status = status;
                  this.value = status;
                }
              })
              .catch(error => {
                console.error('Error updating time slot:', error);
                timeSlot.classList.remove(`status-${newStatus}`);
                timeSlot.classList.add(`status-${status}`);
                timeSlot.dataset.status = status;
                this.value = status;
              });
          } else {
            console.log(`New time slot ${timeSlot.dataset.value} changed to status ${newStatus} (will be saved when form is submitted)`);
          }
          e.stopPropagation();
        });
        timeSlot.appendChild(statusDropdown);
      } else {
        const statusText = document.createElement("span");
        statusText.textContent = "Booked";
        statusText.className = "text-sm ml-2";
        timeSlot.appendChild(statusText);
      }
      slotContainer.appendChild(timeSlot);
    }

    function fetchTimeSlots(dateStr) {
      return fetch(`/niyaw/Admin/get_time_slots.php?date=${dateStr}`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`Failed to fetch time slots: ${response.status} ${response.statusText}`);
          }
          return response.json();
        })
        .then(data => {
          if (data.error) {
            throw new Error(data.error);
          }
          return data.time_slots || [];
        })
        .catch(error => {
          console.error('Error fetching time slots:', error);
          throw error; 
        });
    }

    function updateSingleTimeSlotStatus(id, newStatus) {
      const formData = new FormData();
      formData.append('id', id);
      formData.append('status', newStatus);

      console.log(`Updating time slot ID: ${id} to status: ${newStatus}`);

      return fetch('/niyaw/Admin/update_single_time_slot.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`Network response was not ok: ${response.status}`);
        }
        return response.json();
      })
      .catch(error => {
        console.error('Error updating time slot:', error);
        return { success: false, error: error.message };
      });
    }

    document.querySelector("form").addEventListener("submit", function(e) {
      e.preventDefault();

      const selectedDate = document.getElementById("form-date").value;
      const timeSlots = Array.from(document.querySelectorAll(".time-slot")).map(slot => ({
        id: slot.dataset.id || null,
        time_slot: slot.dataset.value,
        status: parseInt(slot.dataset.status)
      }));

      if (timeSlots.length > 0 && selectedDate) {
        const payload = {
          selected_date: selectedDate,
          time_slots: timeSlots,
        };

        console.log('Submitting time slots:', payload);

        fetch('/niyaw/Admin/batch_update.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(payload),
        })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Server responded with status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            alert('Availability updated successfully!');
            showTimeSlots(parseInt(selectedDate.split('-')[2]));
          } else {
            alert('Error updating availability: ' + (data.message || 'Unknown error'));
          }
        })
        .catch(error => {
          console.error('Error sending data to server:', error);
          alert('An unexpected error occurred. Your changes may not have been saved.');
        });
      } else {
        alert("Please select a date and at least one time slot.");
      }
    });

    calendarDates.addEventListener("click", (e) => {
      const day = e.target.dataset.date;
      if (day) {
        showTimeSlots(day);
        // Show the button after clicking a date
        document.getElementById('updateBtn').style.display = 'inline-block';
      }
    });

    navs.forEach(nav => {
      nav.addEventListener("click", () => {
        month = nav.id === "prev" ? (month === 0 ? 11 : month - 1) : (month === 11 ? 0 : month + 1);
        year = month === (nav.id === "prev" ? 11 : 0) ? (nav.id === "prev" ? year - 1 : year + 1) : year;
        renderCalendar();
      });
    });
    renderCalendar();
      //calendar adn availability

  });

  // --- Schedule subtab switching ---
  const subtabs = document.querySelectorAll('.subtab-link');
  const subContents = document.querySelectorAll('.subtab-content');

  subtabs.forEach(btn => {
    btn.addEventListener('click', () => {
      subtabs.forEach(b => b.classList.remove('text-orange', 'border-orange'));
      btn.classList.add('text-orange', 'border-orange');
      subContents.forEach(s => s.classList.add('hidden'));
      document.getElementById(btn.dataset.subtab).classList.remove('hidden');
    });
  });

</script>


</body>
</html>