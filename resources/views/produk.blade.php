@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-flower"></i>
                </span> Produk
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Produk</h4>
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
                                        <th> Kategori </th>
                                        <th> Produk </th>
                                        <th> Harga </th>
                                        <th> Stok </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->RelasiKategori->kategori }} </td>
                                        <td> {{ $item->produk }} </td>
                                        <td> {{ $item->harga }} </td>
                                        <td> {{ $item->stok }} </td>
                                        <td>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="view(this)" class="btn btn-warning btn-rounded btn-sm"><i class="mdi mdi-information"></i></button>
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
                    <h5 class="modal-title" id="TambahModalLabel">Tambah Kategori Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_kategori">Kategori</label>
                            <select class="form-control" id="id_kategori" name="id_kategori" required>
                                @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="produk">Produk</label>
                            <input type="text" class="form-control" id="produk" name="produk" maxlength="50" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" placeholder="..." accept=".jpg,.jpeg,.png" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" maxlength="20" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" placeholder="..." required>
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
                    <h5 class="modal-title" id="EditModalLabel">Edit Kategori Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('produk.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="e_id_kategori" name="id_kategori" required>
                                @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="produk">Produk</label>
                            <input type="text" class="form-control" id="e_produk" name="produk" maxlength="50" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">
                                Gambar
                                <a href="#" id="gambar_sebelumnya" target="_blank" class="btn btn-sm btn-dark btn-lg btn-block">
                                    <i class="mdi mdi-folder-image"></i>
                                </a>
                            </label>
                            <input type="file" class="form-control" id="e_gambar" name="gambar" placeholder="..." accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" id="e_deskripsi" name="deskripsi" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="e_harga" name="harga" maxlength="20" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="e_stok" name="stok" placeholder="..." required>
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
    
    <div class="modal fade" id="ViewModal" tabindex="-1" aria-labelledby="ViewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewModalLabel">View Kategori Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('produk.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="v_id_kategori" name="id_kategori" required>
                                @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="produk">Produk</label>
                            <input type="text" class="form-control" id="v_produk" name="produk" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <a href="#" id="v_gambar_sebelumnya" target="_blank" class="btn btn-sm btn-dark btn-lg btn-block">
                                <i class="mdi mdi-folder-image"></i>
                            </a>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" id="v_deskripsi" name="deskripsi" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="v_harga" name="harga" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" id="v_stok" name="stok" placeholder="..." required>
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
        $('#e_id_kategori').val(item.id_kategori);
        $('#e_produk').val(item.produk);
        $('#gambar_sebelumnya').attr('href', '{{ asset("img_produk") }}/'+item.gambar);
        $('#e_deskripsi').val(item.deskripsi);
        $('#e_harga').val(item.harga);
        $('#e_stok').val(item.stok);

        $('#EditModal').modal('show');
    }

    function view(obj){
        var item = $(obj).data('item');

        $('#v_id_kategori').val(item.id_kategori);
        $('#v_produk').val(item.produk);
        $('#v_gambar_sebelumnya').attr('href', '{{ asset("img_produk") }}/'+item.gambar);
        $('#v_deskripsi').val(item.deskripsi);
        $('#v_harga').val(item.harga);
        $('#v_stok').val(item.stok);

        $('#ViewModal').modal('show');
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
                window.location.href = "{{ url('produk/delete') }}/"+id;
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