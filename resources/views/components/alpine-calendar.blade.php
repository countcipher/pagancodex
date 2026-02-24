@props(['startDate' => null, 'endDate' => null])

<div x-data="alpineCalendar('{{ old('start_date', $startDate) }}', '{{ old('end_date', $endDate) }}')" class="calendar">

    {{-- Hidden inputs for form submission --}}
    <input type="hidden" name="start_date" :value="startDate ? formatDate(startDate) : ''">
    <input type="hidden" name="end_date" :value="endDate ? formatDate(endDate) : ''">

    {{-- Selected Date Display --}}
    <div class="calendar__display">
        <span class="calendar__display-text">
            <template x-if="startDate && endDate">
                <span x-text="formatDisplay(startDate) + ' — ' + formatDisplay(endDate)"></span>
            </template>
            <template x-if="startDate && !endDate">
                <span x-text="formatDisplay(startDate) + ' (Single Day)'"></span>
            </template>
            <template x-if="!startDate">
                <span>Select a date or range</span>
            </template>
        </span>
        <button type="button" class="btn-link btn-link--danger" x-show="startDate" @click="clearDates()">Clear</button>
    </div>

    {{-- Calendar Header --}}
    <div class="calendar__header">
        <button type="button" class="calendar__nav-btn" @click="prevMonth()">&laquo;</button>
        <div class="calendar__month-year" x-text="monthNames[month] + ' ' + year"></div>
        <button type="button" class="calendar__nav-btn" @click="nextMonth()">&raquo;</button>
    </div>

    {{-- Calendar Grid --}}
    <div class="calendar__grid">
        <template x-for="day in ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa']">
            <div class="calendar__day-name" x-text="day"></div>
        </template>

        <template x-for="blank in blankDays">
            <div class="calendar__day empty"></div>
        </template>

        <template x-for="date in daysInMonth">
            <button type="button" class="calendar__day" :class="{
                        'is-selected': isSelected(date),
                        'is-range': isInRange(date),
                        'is-today': isToday(date)
                    }" @click="selectDate(date)" @mouseenter="hoverDate = new Date(year, month, date)"
                @mouseleave="hoverDate = null" x-text="date"></button>
        </template>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('alpineCalendar', (initialStart, initialEnd) => ({
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    month: new Date().getMonth(),
                    year: new Date().getFullYear(),
                    blankDays: [],
                    daysInMonth: [],
                    startDate: initialStart ? new Date(initialStart + 'T00:00:00') : null,
                    endDate: initialEnd ? new Date(initialEnd + 'T00:00:00') : null,
                    hoverDate: null,

                    init() {
                        if (this.startDate) {
                            this.month = this.startDate.getMonth();
                            this.year = this.startDate.getFullYear();
                        }
                        this.calculateDays();
                    },

                    calculateDays() {
                        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                        let dayOfWeek = new Date(this.year, this.month, 1).getDay();
                        this.blankDays = Array.from({ length: dayOfWeek }, (_, i) => i);
                        this.daysInMonth = Array.from({ length: daysInMonth }, (_, i) => i + 1);
                    },

                    prevMonth() {
                        if (this.month === 0) {
                            this.month = 11;
                            this.year--;
                        } else {
                            this.month--;
                        }
                        this.calculateDays();
                    },

                    nextMonth() {
                        if (this.month === 11) {
                            this.month = 0;
                            this.year++;
                        } else {
                            this.month++;
                        }
                        this.calculateDays();
                    },

                    formatDate(date) {
                        let d = date.getDate().toString().padStart(2, '0');
                        let m = (date.getMonth() + 1).toString().padStart(2, '0');
                        let y = date.getFullYear();
                        return `${y}-${m}-${d}`;
                    },

                    formatDisplay(date) {
                        return date.toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' });
                    },

                    isSameDate(d1, d2) {
                        if (!d1 || !d2) return false;
                        return d1.getFullYear() === d2.getFullYear() && d1.getMonth() === d2.getMonth() && d1.getDate() === d2.getDate();
                    },

                    isToday(date) {
                        return this.isSameDate(new Date(this.year, this.month, date), new Date());
                    },

                    isSelected(date) {
                        let d = new Date(this.year, this.month, date);
                        return this.isSameDate(d, this.startDate) || this.isSameDate(d, this.endDate);
                    },

                    isInRange(date) {
                        if (!this.startDate) return false;

                        let d = new Date(this.year, this.month, date).getTime();
                        let start = this.startDate.getTime();
                        let end = this.endDate ? this.endDate.getTime() : (this.hoverDate ? this.hoverDate.getTime() : null);

                        if (!end) return false;

                        return (d > start && d < end) || (d < start && d > end);
                    },

                    selectDate(date) {
                        let selected = new Date(this.year, this.month, date);

                        if (!this.startDate || (this.startDate && this.endDate)) {
                            // Fresh selection or starting over
                            this.startDate = selected;
                            this.endDate = null;
                        } else if (this.isSameDate(selected, this.startDate)) {
                            // Toggling the start date off
                            this.startDate = null;
                            this.endDate = null;
                        } else if (selected < this.startDate) {
                            // Clicked before start date, swap them
                            this.endDate = this.startDate;
                            this.startDate = selected;
                        } else {
                            // Valid end date after start date
                            this.endDate = selected;
                        }
                    },

                    clearDates() {
                        this.startDate = null;
                        this.endDate = null;
                    }
                }));
            });
        </script>
    @endpush
@endonce