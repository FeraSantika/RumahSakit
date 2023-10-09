@extends('main')
@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Pasien</a></li>
                        </ol>
                    </div>
                    <h4 class="page-title">Detail Pasien</h4>
                    {{-- <h2>{{$dtpasien->daftar->kode_pendaftaran}}</h2> --}}
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ asset($dtpasien->pasien_jenis_kelamin === 'Laki-laki' ? 'assets/images/male.png' : 'assets/images/female.png') ?? ''  }}"
                        class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                    <h4 class="mb-0 mt-2">{{ $dtpasien->pasien_nama }}</h4>
                    <p class="text-muted mt-1 font-14">{{ $dtpasien->pasien_kode }}</p>
                    <input type="text" name="kode" id="kode" value="{{ $dtpasien->pasien_kode }}" hidden>
                    <div class="text-start mt-3">
                        <h4 class="font-13 text-uppercase">Tentang saya :</h4>
                        <p class="text-muted font-13 mb-3">
                            Hi saya {{ $dtpasien->pasien_nama }}, salah satu pasien Anda
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>NIK :</strong> <span class="ms-2">
                                {{ $dtpasien->pasien_NIK }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Nama :</strong> <span class="ms-2">
                                {{ $dtpasien->pasien_nama }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Tempat, tanggal lahir :</strong><span class="ms-2">
                                {{ $dtpasien->pasien_tempat_lahir }}, {{ $dtpasien->pasien_tgl_lahir }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Jenis kelamin :</strong> <span
                                class="ms-2 ">{{ $dtpasien->pasien_jenis_kelamin }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Kewarganegaraan :</strong> <span
                                class="ms-2 ">{{ $dtpasien->pasien_kewarganegaraan }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Alamat :</strong> <span
                                class="ms-2">{{ $dtpasien->pasien_alamat }}</span>
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Pekerjaan :</strong> <span
                                class="ms-2 ">{{ $dtpasien->pasien_pekerjaan }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Status Perkawinan :</strong> <span
                                class="ms-2 ">{{ $dtpasien->pasien_status }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Agama :</strong> <span
                                class="ms-2 ">{{ $dtpasien->pasien_agama }}</span></p>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
            <!-- end col-->
            <!-- end card body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
    </div>
    <!-- end row-->

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // var insertlist = "{{ route('listdaftarobat.insert') }}";
        // $("#add").click(function() {
        //     var search = $("#search").val();
        //     var kode = $("#kode").val();
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     $.ajax({
        //         url: insertlist,
        //         type: "POST",
        //         cache: false,
        //         data: {
        //             "search": search,
        //             "kode": kode,
        //             "_token": token
        //         },
        //         success: function(response) {
        //             var newRow = `
    //                 <tr id="row-${response.data.list_id}">
    //                     <td>${response.data.nama_obat}</td>
    //                     <td>${response.data.kategori_obat}</td>
    //                     <td>
    //                         <input type="text" name="qty" id="qty-${response.data.list_id}" class="form-control" value="${response.data.qty}" style="max-width: 100px;">
    //                     </td>
    //                     <td>
    //                         <a href="javascript:void(0);" class="action-icon" onclick="edit('${response.data.list_id}')">
    //                             <i class="mdi mdi-square-edit-outline"></i>
    //                         </a>
    //                         <a href="javascript:void(0)" onclick="hapus('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
    //                     </td>
    //                 </tr>
    //             `;
        //             $("#obatList").append(newRow);
        //             console.log(response.data);
        //         }
        //     });
        // });

        // function edit(list_id) {
        //     var url = "{{ route('listdaftarobat.update') }}";
        //     var currentQty = $('#qty-' + list_id).val();
        //     var newData = {
        //         'list_id': list_id,
        //         'qty': currentQty,
        //         '_token': $("meta[name='csrf-token']").attr("content")
        //     }
        //     $.ajax({
        //         url: url,
        //         type: "post",
        //         dataType: "JSON",
        //         data: newData,
        //         success: function(response) {
        //             Swal.fire({
        //                 toast: true,
        //                 position: 'top-end',
        //                 icon: 'success',
        //                 title: 'Data berhasil diubah',
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             });
        //             $('#qty-' + list_id).val(response.data.qty);
        //             console.log(response.data);
        //         }
        //     });
        // }

        // function hapusobat(list_id) {
        //     var url = "{{ route('listdaftarobat.destroy', ':list_id') }}";
        //     url = url.replace(':list_id', list_id);
        //     Swal.fire({
        //         title: "Yakin ingin menghapus data ini?",
        //         text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Ya, Hapus!"
        //     }).then((result) => {
        //         if (result.value) {
        //             $.ajax({
        //                 url: url,
        //                 type: "get",
        //                 dataType: "JSON",
        //                 success: function(data) {
        //                     Swal.fire({
        //                         toast: true,
        //                         position: 'top-end',
        //                         icon: 'success',
        //                         title: 'Data berhasil dihapus',
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     });
        //                     console.log("berhasil hapus data");
        //                     $("#row-" + list_id).remove();
        //                     $("#row-" + $obat.list_id).remove();
        //                 }
        //             })
        //         }
        //     })
        // }

        // $(document).ready(function() {
        //     var path = "{{ route('autocomplete_tindakan') }}";
        //     $("#search-tindakan").autocomplete({
        //         source: function(request, response) {
        //             $.ajax({
        //                 url: path,
        //                 type: 'GET',
        //                 dataType: "json",
        //                 data: {
        //                     cari: request.term
        //                 },
        //                 success: function(data) {
        //                     console.log(data);
        //                     response(data);
        //                 }
        //             });
        //         },
        //         select: function(event, ui) {
        //             $('#search-tindakan').val(ui.item.label);
        //             console.log(ui.item);
        //             return false;
        //         }
        //     });
        // });

        // $("#add-tindakan").click(function() {
        //     var listtindakan = "{{ route('listdaftartindakan.insert') }}";
        //     var search = $("#search-tindakan").val();
        //     var kode = $("#kode").val();
        //     let token = $("meta[name='csrf-token']").attr("content");
        //     $.ajax({
        //         url: listtindakan,
        //         type: "POST",
        //         cache: false,
        //         data: {
        //             "search": search,
        //             "kode": kode,
        //             "_token": token
        //         },
        //         success: function(response) {
        //             var newRow = `
    //                 <tr id="row-${response.data.list_id}">
    //                     <td>${response.data.nama_tindakan}</td>
    //                     <td>
    //                         <a href="javascript:void(0)" onclick="hapus('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
    //                     </td>
    //                 </tr>
    //             `;
        //             $("#tindakanList").append(newRow);
        //             console.log(response.data);
        //         }
        //     });
        // });

        // function hapus(list_id) {
        //     var url = "{{ route('listdaftartindakan.destroy', ':list_id') }}";
        //     url = url.replace(':list_id', list_id);
        //     Swal.fire({
        //         title: "Yakin ingin menghapus data ini?",
        //         text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Ya, Hapus!"
        //     }).then((result) => {
        //         if (result.value) {
        //             $.ajax({
        //                 url: url,
        //                 type: "get",
        //                 dataType: "JSON",
        //                 success: function(data) {
        //                     Swal.fire({
        //                         toast: true,
        //                         position: 'top-end',
        //                         icon: 'success',
        //                         title: 'Data berhasil dihapus',
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     });
        //                     console.log("berhasil hapus data");
        //                     $("#row-" + list_id).remove();
        //                     $("#row-" + $tindakan.list_id).remove();
        //                 }
        //             })
        //         }
        //     })
        // }
    </script>
@endsection
