@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Konfirmasi Pembayaran
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Konfirmasi Pembayaran</h4>
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
                                        <th> Pengguna </th>
                                        <th> No. Order </th>
                                        <th> Bank Asal </th>
                                        <th> Bank Tujuan </th>
                                        <th> Metode </th>
                                        <th> Nominal (Rp) </th>
                                        <th> Bukti </th>
                                        <th> Tanggal </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->RelasiUser->name }} </td>
                                        <td> {{ $item->no_order }} </td>
                                        <td> {{ $item->bank_asal }} </td>
                                        <td> {{ $item->bank_tujuan }} </td>
                                        <td> {{ $item->metode }} </td>
                                        <td> {{ number_format($item->nominal, 2, ",", ".") }} </td>
                                        <td> 
                                            <a href="{{ asset('img_bukti/'.$item->bukti) }}" target="_blank" class="btn btn-sm btn-dark btn-lg btn-block">
                                            <i class="mdi mdi-folder-image"></i></a>
                                        </td>
                                        <td> {{ $item->tanggal }} </td>
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
    <div class="modal fade" id="TambahModal" tabindex="-1" aria-labelledby="TambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahModalLabel">Tambah Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('master-banner.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept=".jpg,.jpeg,.png" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="0">TIDAK AKTIF</option>
                                <option value="1">AKTIF</option>
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

    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('master-banner.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="e_keterangan" name="keterangan" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">
                                Gambar
                                <a href="#" id="gambar_sebelumnya" target="_blank" class="btn btn-sm btn-dark btn-lg btn-block">
                                    <i class="mdi mdi-folder-image"></i>
                                </a>
                            </label>
                            <input type="file" class="form-control" id="e_gambar" name="gambar" accept=".jpg,.jpeg,.png" placeholder="...">
                            
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="e_status" name="status" required>
                                <option value="0">TIDAK AKTIF</option>
                                <option value="1">AKTIF</option>
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
@endsection

@section('javascript')
<script>
    $(document).ready( function () {
        $('#table-id').DataTable();
    });

    function edit(obj){
        var item = $(obj).data('item');
        console.log(item);
        $('#e_id').val(item.id);
        $('#e_keterangan').val(item.keterangan);
        $('#gambar_sebelumnya').attr('href', '{{ asset("img_banner") }}/'+item.gambar);
        $('#e_status').val(item.status);

        $('#EditModal').modal('show');
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