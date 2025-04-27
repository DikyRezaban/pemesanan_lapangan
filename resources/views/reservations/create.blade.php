<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1 class="mb-4">Tambah Reservasi</h1>

        <form action="{{ route('reservations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="customer_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>No Telepon</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Reservasi</label>
                <input type="date" name="reservation_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jam Mulai</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Jam Selesai</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nama Lapangan</label>
                <input type="text" name="field_name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
