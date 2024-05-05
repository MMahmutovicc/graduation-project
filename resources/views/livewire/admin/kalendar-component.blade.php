@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student-profil.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/kalendar.css') }}">
<link href='{{ asset('assets/fullcalendar/main.css') }}' rel='stylesheet' />
@endpush
<main>
    <div class="backdrop" wire:ignore></div>
    <div class="modal" wire:ignore.self>
        <form action="" wire:submit.prevent="addEvent()">
            <div class="calendar-form-header">
                <h2>Unesite Podatke</h2>
            </div>
            <div class="calendar-form-group">
                <label for="title">Naslov:</label>
                <input type="text" id="title" wire:model="title">
                @error('title')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="calendar-form-group">
                <label for="class">Razred:</label>
                <select name="" id="class" wire:model="class">
                    <option value="">Izaberite Razred</option>
                    @foreach ($razredi as $razred)
                        <option value="{{ $razred->id }}">{{ $razred->name }}</option>
                    @endforeach
                </select>
                @error('class')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="calendar-button">
                <button type="Submit">Potvrdi</button>
            </div>
        </form>
    </div>
    <div class="profil-box">
        @if (Session::has('kalendar_poruka'))
            <div role="alert">{{ Session::get('kalendar_poruka') }}</div>
        @endif
        <div wire:ignore>
            <div id="calendar">

            </div>
        </div>
    </div>
</main>
@push('scripts')
<script src='{{ asset('assets/fullcalendar/main.js') }}'></script>
<script>
    var modal = document.querySelector('.modal');
    var backdrop = document.querySelector('.backdrop');
    backdrop.addEventListener('click', function(){
        modal.style.display = "none";
        backdrop.style.display = "none";
    });
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var data = @this.events;
    var calendar = new FullCalendar.Calendar(calendarEl, {
      allDay: true,
      initialView: 'dayGridMonth',
      editable: true,
      eventInteractive: true,
      selectable: false,
      events: JSON.parse(data),
      dateClick:function (info) {
        var date = new Date(info.dateStr);
        @this.set('date', date);
        modal.style.display = "block";
        backdrop.style.display = "block";

      },
      eventDidMount: function(info) {
        var tooltip = new Tooltip(info.el, {
            title: info.event.extendedProps.description,
            placement: 'top',
            trigger: 'hover',
            container: 'body'
        });
      },
      eventClick: function(info){
        if (confirm('Da li ste sigurni da želite obrisati ovaj događaj?') == true)
        {
            var id = info.event.id;
            @this.deleteEvent(id);
        }
      },  
      eventDrop:function(info)
      {
        if(confirm('Da li ste sigurni da želite pomjeriti ovaj događaj?') == true)
        {
          var id = info.event.id;
          var start = info.event.startStr;
          @this.updateEvent(id, start);
        }
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