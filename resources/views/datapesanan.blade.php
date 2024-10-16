@extends('layouts.maindashboard')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pesanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route ('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Data Pesanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
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
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Nama Pembeli</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Total Harga</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        <th>Update Status Pesanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $key => $order)
                                        @if($order->status->name != 'Dibatalkan' && $order->status->name != 'Selesai')
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>
                                                    @foreach($order->items as $item)
                                                        <span>{{ $item->product->nama }}</span><br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($order->items as $item)
                                                        <span>Jumlah: {{ $item->quantity }}</span><br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $order->total_price }}</td>
                                                <td>{{ $order->alamat_pengiriman }}</td>
                                                <td>
                                                    @php
                                                        $statusClass = '';
                                                        switch($order->status->name) {
                                                            case 'Pending':
                                                                $statusClass = 'badge badge-warning';
                                                                break;
                                                            case 'Diproses':
                                                                $statusClass = 'badge badge-info';
                                                                break;
                                                            case 'Dikirim':
                                                                $statusClass = 'badge badge-primary';
                                                                break;
                                                            case 'Selesai':
                                                                $statusClass = 'badge badge-success';
                                                                break;
                                                            default:
                                                                $statusClass = 'badge badge-secondary';
                                                        }
                                                    @endphp
                                                    <span class="{{ $statusClass }}">{{ $order->status->name }}</span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('order.updateStatus', $order->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group">
                                                            <select name="status_id" class="form-control">
                                                                @foreach($statuses as $status)
                                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="input-group-append">
                                                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
