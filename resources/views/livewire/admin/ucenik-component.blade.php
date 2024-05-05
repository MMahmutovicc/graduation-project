@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/student-profil.css') }}">
<link href='{{ asset('assets/fullcalendar/main.css') }}' rel='stylesheet' />
@endpush
<main>
    <div class="profil-box">
        {{-- <img class="profil-box_image" src="../slike/profilna-student.png" alt="Profilna"> --}}
        @if (Session::has('ucenik_poruka'))
            <div class="alert alert-success" role="alert">{{ Session::get('ucenik_poruka') }}</div>
        @endif
        @if ($ucenik)
            <table align="center" cellspacing=6px > 
                <tr>
                    <td class="label">Ime i Prezime:</td>
                    <td>{{ $ucenik->name }}</td>
                </tr>
                <tr>
                    <td class="label">Razred i Odjeljenje:</td>
                    <td>{{ $ucenik->razred->name }}</td>
                </tr>
                <tr>
                    <td class="label">Email Učenika:</td>
                    <td>{{ $ucenik->email }}</td>
                </tr>
            </table>
            {{-- <div class="lekcije-progress">
                <div class="lekcije-progress_group">
                    <label for="lekcija1">Lekcija 1:</label>
                    <progress id="lekcija1" max="100" min="1" value="33"></progress>
                    <label>33%</label>
                </div>
                <div class="lekcije-progress_group">
                    <label for="lekcija2">Lekcija 2:</label>
                    <progress id="lekcija2" max="100" min="1" value="65"></progress>
                    <label>65%</label>
                </div>
                <div class="lekcije-progress_group">
                    <label for="lekcija3">Lekcija 3:</label>
                    <progress id="lekcija3" max="100" min="1" value="10"></progress>
                    <label>10%</label>
                </div>
            </div> --}}
            <div wire:ignore>
                <div id="calendar">

                </div>
            </div>
        @endif
    </div>
    @if ($ucenik)
        <div class="remove-student">
            <a href="#" onclick="confirm('Da li ste sigurni da želite obrisati ovog učenika?') || event.stopImmediatePropagation()" wire:click.prevent="deleteStudent()" class="remove-student-button">Izbriši</a>
        </div>
    @endif
</main>
@push('scripts')
<script src='{{ asset('assets/fullcalendar/main.js') }}'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var data = @this.events;
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      editable: false,
      eventInteractive: true,
      selectable: false,
      events: JSON.parse(data)
    });
    calendar.render();
  });

</script>
@endpush