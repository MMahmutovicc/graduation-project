@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student-profil.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/kalendar.css') }}">
<link href='{{ asset('assets/fullcalendar/main.css') }}' rel='stylesheet' />
@endpush
<main>
    <div class="profil-box">
        <div wire:ignore>
            <div id="calendar">

            </div>
        </div>
    </div>
</main>
@push('scripts')
<script src='{{ asset('assets/fullcalendar/main.js') }}'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var data = @this.events;
    var calendar = new FullCalendar.Calendar(calendarEl, {
      allDay: true,
      initialView: 'dayGridMonth',
      editable: false,
      eventInteractive: true,
      selectable: false,
      events: JSON.parse(data),
      eventDidMount: function(info) {
        var tooltip = new Tooltip(info.el, {
            title: info.event.extendedProps.description,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
        });
      }
    });
    calendar.render();
    @this.on(`refreshCalendar`, () => {
                calendar.refetchEvents()
            });
  });
</script>
<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
@endpush