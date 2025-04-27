<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Reservasi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar v5.11.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        #calendar {
            margin-top: 30px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Reservasi Lapangan</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">
                Halo, {{ Auth::user()->name }}
            </span>
        </div>
    </div>
</nav>

<div class="container">
    <h1 class="mb-4">Daftar Reservasi</h1>

    <!-- Tombol tambah -->
    <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-4">Tambah Reservasi</a>

    <!-- Notifikasi sukses -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Ringkasan diatas Kalender -->
    <div class="mb-4">
        <h4>List Reservasi</h4>
        <table class="table table-bordered table-striped" id="reservasiTable">
            <thead class="table-secondary">
                <tr>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Lapangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->customer_name }}</td>
                    <td>{{ $reservation->phone_number }}</td>
                    <td>{{ $reservation->reservation_date }}</td>
                    <td>{{ $reservation->start_time }}</td>
                    <td>{{ $reservation->end_time }}</td>
                    <td>{{ $reservation->field_name }}</td>
                    <td>{{ $reservation->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Kalender -->
    <div id="calendar"></div>

</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Detail Reservasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nama:</strong> <span id="modalName"></span></p>
        <p><strong>No Telepon:</strong> <span id="modalPhone"></span></p>
        <p><strong>Lapangan:</strong> <span id="modalField"></span></p>
        <p><strong>Jam:</strong> <span id="modalTime"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Script Kalender dan DataTables -->
<script>
$(document).ready(function() {
    // DataTables aktif
    $('#reservasiTable').DataTable();

    // FullCalendar aktif
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            @foreach($reservations as $reservation)
            {
                title: '{{ $reservation->customer_name }} - {{ $reservation->start_time }} s/d {{ $reservation->end_time }} ({{ $reservation->field_name }})',
                start: '{{ $reservation->reservation_date }}T{{ $reservation->start_time }}',
                end: '{{ $reservation->reservation_date }}T{{ $reservation->end_time }}',
                color: 
                    @if($reservation->status == 'Pending') 
                        'orange'
                    @elseif($reservation->status == 'Approved') 
                        'green'
                    @else 
                        'red'
                    @endif,
                extendedProps: {
                    phone_number: '{{ $reservation->phone_number }}',
                    field_name: '{{ $reservation->field_name }}',
                    start_time: '{{ $reservation->start_time }}',
                    end_time: '{{ $reservation->end_time }}',
                    status: '{{ $reservation->status }}'
                }
            },
            @endforeach
        ],
        eventClick: function(info) {
            document.getElementById('modalName').innerText = info.event.title;
            document.getElementById('modalPhone').innerText = info.event.extendedProps.phone_number;
            document.getElementById('modalField').innerText = info.event.extendedProps.field_name;
            document.getElementById('modalTime').innerText = info.event.extendedProps.start_time + " - " + info.event.extendedProps.end_time;
            document.getElementById('modalStatus').innerText = info.event.extendedProps.status;

            var modal = new bootstrap.Modal(document.getElementById('reservationModal'));
            modal.show();
        }
    });

    calendar.render();
});
</script>

</body>
</html>
