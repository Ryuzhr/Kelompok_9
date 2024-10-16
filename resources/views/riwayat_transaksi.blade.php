@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Riwayat Transaksi</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Pengguna</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->status->name }}</td>
                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                <td>{{ $transaction->total }}</td> <!-- Pastikan kolom total ada dalam model Order -->
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
