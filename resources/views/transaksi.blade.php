@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Transaksi
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Transaksi</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Error!</strong> {{ $error }}
                            </div>
                            @endforeach
                        @endif
                        <div class="table-responsive">
                            <table class="table" id="table-id">
                                <thead>
                                    <tr>
                                        <th> No. </th>
                                        <th> No. Order </th>
                                        <th> Tanggal Transaksi </th>
                                        <th> Total Harga </th>
                                        <th> Kupon </th>
                                        <th> Alamat </th>
                                        <th> Status Transaksi </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->no_order }} </td>
                                        <td> {{ $item->tanggal_transaksi }} </td>
                                        <td> {{ $item->total_harga_transaksi }} </td>
                                        <td> {{ ($item->kupon) ? $item->kupon : '-' }} </td>
                                        <td> {{ $item->alamat }} </td>
                                        <td>
                                            @if($item->status_transaksi == 0)
                                            <label class="badge badge-gradient-warning">Menunggu Konfirmasi</label>
                                            @elseif($item->status_transaksi == 1)
                                            <label class="badge badge-gradient-success">Approve</label>
                                            @else
                                            <label class="badge badge-gradient-primary">Selesai</label>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>
                                            <button type="button" onclick="view({{ $item->id }})" class="btn btn-warning btn-rounded btn-sm"><i class="mdi mdi-information"></i></button>
                                            <button type="button" onclick="hapus({{ $item->id }})" class="btn btn-danger btn-rounded btn-sm"><i class="mdi mdi-delete"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pop Up --}}
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('transaksi.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="e_status_transaksi">Status Transaksi</label>
                            <select class="form-control" id="e_status_transaksi" name="status_transaksi" required>
                                <option value="0">Menunggu Konfirmasi</option>
                                <option value="1">Approve</option>
                                <option value="2">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="DetailModal" tabindex="-1" aria-labelledby="DetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DetailModalLabel">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('transaksi.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table" id="detail-table-id">
                                <thead>
                                    <tr>
                                        <th> No. </th>
                                        <th> Produk </th>
                                        <th> Harga </th>
                                        <th> Jumlah </th>
                                        <th> Total Harga </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready( function () {
        $('#table-id').DataTable();
    });

    function edit(obj){
        var item = $(obj).data('item');

        $('#e_id').val(item.id);
        $('#e_status_transaksi').val(item.status_transaksi);

        $('#EditModal').modal('show');
    }

    function view(id){
        $.ajax({
            type: 'GET',
            url: "{{ route('transaksi.detailProduk') }}",
            data: {
                id: id
            },
            success: function(response){
                var dataTable = $('#detail-table-id').DataTable();
                $.each(response, function(i, item) {
                    var no = i + 1;
                    dataTable.row.add([
                        no,
                        item.relasi_produk.produk,
                        item.relasi_produk.harga,
                        item.jumlah,
                        item.total_harga
                    ]).draw()
                })
            }
        });
        $('#DetailModal').modal('show');
    }

    function hapus(id) {
        Swal.fire({
            title: "Apa anda yakin?",
            text: "ingein menghapus data ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete!"
        }).then((result) => {
            if(result.isConfirmed) {
                window.location.href = "{{ url('master-banner/delete') }}/"+id;
            }else{
                Swal.fire({
                    title: "Batal!",
                    text: "Batal Hapus",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>

@if(Session::has('success'))
    <script type="text/javascript">
        Swal.fire({
        icon: 'success',
        text: '{{Session::get("success")}}',
        showConfirmButton: false,
        timer: 1500
    });
    </script>
    <?php
        Session::forget('success');
    ?>
@endif
@if(Session::has('error'))
    <script type="text/javascript">
        Swal.fire({
        icon: 'error',
        text: '{{Session::get("error")}}',
        showConfirmButton: false,
        timer: 1500
    });
    </script>
    <?php
        Session::forget('error');
    ?>
@endif
@endsection