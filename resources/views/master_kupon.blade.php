@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Master Kupon
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Master Kupon</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Error!</strong> {{ $error }}
                            </div>
                            @endforeach
                        @endif
                        <div class="table-responsive">
                            <br>
                            <button type="button" class="btn btn-sm btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#TambahModal">
                                <i class="mdi mdi-plus"></i>Tambah
                            </button>
                            <table class="table" id="table-id">
                                <thead>
                                    <tr>
                                        <th> No. </th>
                                        <th> Nama </th>
                                        <th> Kode </th>
                                        <th> Kredit </th>
                                        <th> Tanggal Mulai </th>
                                        <th> Tanggal Berakhir </th>
                                        <th> Status </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->nama }} </td>
                                        <td> {{ $item->kode }} </td>
                                        <td> {{ $item->kredit }} </td>
                                        <td> {{ $item->tanggal_mulai }} </td>
                                        <td> {{ $item->tanggal_berakhir }} </td>
                                        <td>
                                            @if($item->status == 0)
                                            <label class="badge badge-gradient-success">TIDAK AKTIF</label>
                                            @else
                                            <label class="badge badge-gradient-warning">AKTIF</label>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>
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
    <div class="modal fade" id="TambahModal" tabindex="-1" aria-labelledby="TambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahModalLabel">Tambah Kupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('master-kupon.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" maxlength="50" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" maxlength="20" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="kredit">Kredit</label>
                            <input type="text" class="form-control" id="kredit" name="kredit" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_berakhir">Tanggal Berakhir</label>
                            <input type="text" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir" placeholder="..." required>
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
                <form method="POST" action="{{ route('master-kupon.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="e_nama">Nama</label>
                            <input type="text" class="form-control" id="e_nama" name="nama" maxlength="50" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="e_kode">Kode</label>
                            <input type="text" class="form-control" id="e_kode" name="kode" maxlength="20" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="e_kredit">Kredit</label>
                            <input type="text" class="form-control" id="e_kredit" name="kredit" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="e_tanggal_mulai">Tanggal Mulai</label>
                            <input type="text" class="form-control" id="e_tanggal_mulai" name="tanggal_mulai" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="e_tanggal_berakhir">Tanggal Berakhir</label>
                            <input type="text" class="form-control" id="e_tanggal_berakhir" name="tanggal_berakhir" placeholder="..." required>
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

        flatpickr("#tanggal_mulai", {
            enableTime: true,
            minTime: "09:00"
        })
        
        flatpickr("#tanggal_berakhir", {
            enableTime: true,
            minTime: "09:00"
        })
        
        flatpickr("#e_tanggal_mulai", {
            enableTime: true,
            minTime: "09:00"
        })
        
        flatpickr("#e_tanggal_berakhir", {
            enableTime: true,
            minTime: "09:00"
        })
    });

    function edit(obj){
        var item = $(obj).data('item');
        console.log(item);
        $('#e_id').val(item.id);
        $('#e_nama').val(item.nama);
        $('#e_kode').val(item.kode);
        $('#e_kredit').val(item.kredit);
        $('#e_tanggal_mulai').val(item.tanggal_mulai);
        $('#e_tanggal_berakhir').val(item.tanggal_berakhir);
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
                window.location.href = "{{ url('master-kupon/delete') }}/"+id;
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