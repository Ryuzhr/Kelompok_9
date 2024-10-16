@extends('layouts.maindashboard')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Transaksi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Data Transaksi</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-12 text-right">
                    <!-- Filter Date Range -->
                    <div class="form-inline">
                        <label for="startDate" class="mr-2">Start Date:</label>
                        <input type="date" id="startDate" class="form-control mr-2">
                        <label for="endDate" class="mr-2">End Date:</label>
                        <input type="date" id="endDate" class="form-control mr-2">
                        <button class="btn btn-primary" onclick="printFilteredTable()">Print</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Data Transaksi</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table id="transactionTable" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Tanggal</th> <!-- Tambahkan kolom Tanggal -->
                                        <th>Nama Pembeli</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        @if($transaction->status && ($transaction->status->name == 'Dibatalkan' || $transaction->status->name == 'Selesai'))
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $transaction->id }}</td>
                                                <td>{{ $transaction->created_at->format('Y-m-d') }}</td> <!-- Format tanggal menjadi Y-m-d -->
                                                <td>{{ $transaction->user->name }}</td>
                                                <td>
                                                    @foreach($transaction->items as $item)
                                                        {{ $item->product->nama }}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($transaction->items as $item)
                                                        {{ $item->quantity }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $transaction->total_price }}</td>
                                                <td>{{ $transaction->alamat_pengiriman }}</td>
                                                <td>
                                                    @if($transaction->status->name == 'Selesai')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @else
                                                        <span class="badge badge-danger">Dibatalkan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script>
    function printFilteredTable() {
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        if (!startDate || !endDate) {
            alert('Please select both start and end dates.');
            return;
        }

        var divToPrint = document.getElementById("transactionTable");
        var rows = divToPrint.querySelectorAll("tbody tr");

        // Format tanggal dari input date sudah dalam bentuk YYYY-MM-DD
        var start = new Date(startDate);
        var end = new Date(endDate);
        
        // Tambahkan 1 hari ke endDate agar transaksi pada tanggal akhir juga diikutsertakan
        end.setDate(end.getDate() + 1);

        var filteredRows = Array.from(rows).filter(function(row) {
            var transactionDateText = row.querySelector("td:nth-child(3)").innerText.trim(); 
            var transactionDate = new Date(transactionDateText); // Mengubah string tanggal menjadi Date object
            
            return transactionDate >= start && transactionDate < end;
        });

        if (filteredRows.length === 0) {
            alert('No data found for the selected date range.');
            return;
        }

        var newWin = window.open("");
        newWin.document.write('<html><head><title>Print</title><style>');
        newWin.document.write('table { border-collapse: collapse; width: 100%; }');
        newWin.document.write('table, th, td { border: 1px solid black; }');
        newWin.document.write('th, td { padding: 8px; text-align: left; }');
        newWin.document.write('</style></head><body>');
        newWin.document.write('<table><thead>' + divToPrint.querySelector("thead").outerHTML + '</thead><tbody>');
        filteredRows.forEach(function(row) {
            newWin.document.write('<tr>' + row.innerHTML + '</tr>');
        });
        newWin.document.write('</tbody></table>');
        newWin.document.write('</body></html>');
        newWin.document.close();
        newWin.print();
        newWin.close();
    }
</script>

@endsection
