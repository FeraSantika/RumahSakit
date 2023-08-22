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
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{ asset($dtpasien->pasien_jenis_kelamin === 'Laki-laki' ? 'assets/images/male.png' : 'assets/images/female.png') }}"
                            class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                        <h4 class="mb-0 mt-2">{{ $dtpasien->pasien_nama }}</h4>
                        <p class="text-muted mt-1 font-14">{{ $dtpasien->pasien_kode }}</p>

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

                <!-- Messages-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="header-title">Riwayat pemeriksaan</h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                        </div>

                        <div class="inbox-widget">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-2.jpg') }}"
                                        class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Tomaslau</p>
                                <p class="inbox-item-text">I've finished it! See you so...</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                </p>
                            </div>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                        class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Stillnotdavid</p>
                                <p class="inbox-item-text">This theme is awesome!</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                </p>
                            </div>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                        class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Kurafire</p>
                                <p class="inbox-item-text">Nice to meet you</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                </p>
                            </div>

                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-5.jpg') }}"
                                        class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Shahedk</p>
                                <p class="inbox-item-text">Hey! there I'm available...</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                </p>
                            </div>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="{{ asset('assets/images/users/avatar-6.jpg') }}"
                                        class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Adhamdannaway</p>
                                <p class="inbox-item-text">This theme is awesome!</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info font-13"> Reply </a>
                                </p>
                            </div>
                        </div> <!-- end inbox-widget -->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->

            </div> <!-- end col-->

            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#diagnosa" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    Diagnosa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#obat" data-bs-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0 active">
                                    Obat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings" data-bs-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    Settings
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="diagnosa">
                                <form action="#" class="comment-area-box">
                                    <textarea rows="3" class="form-control border-0 resize-none" placeholder="Write something...."></textarea>
                                    <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="mdi mdi-account-circle"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="mdi mdi-map-marker"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="mdi mdi-camera"></i></a>
                                            <a href="#" class="btn btn-sm px-2 font-16 btn-light"><i
                                                    class="mdi mdi-emoticon-outline"></i></a>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-dark waves-effect">Post</button>
                                    </div>
                                </form>
                                <!-- end obat -->
                            </div> <!-- end tab-pane -->
                            <!-- end about me section content -->
                            <div class="tab-pane show active" id="obat">
                                <!-- comment box -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="text-end mb-3">
                                            <div class="input-group">
                                                <input type="text" class="typeahead form-control" name="search"
                                                    id="search" placeholder="Cari Obat">
                                                <button class="input-group-text btn btn-primary btn-sm" type="button"
                                                    id="search-btn"><i class="uil-search-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end .border-->
                            <!-- end comment box -->

                            <!-- Story Box-->
                            <div class="border border-light rounded p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle"
                                        src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                        alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">Jeremy Tomlinson</h5>
                                        <p class="text-muted"><small>about 2 minuts ago</small></p>
                                    </div>
                                </div>
                                <p>Story based around the idea of time lapse, animation to post soon!</p>

                                <img src="{{ asset('assets/images/small/small-1.jpg') }}" alt="post-img"
                                    class="rounded me-1" height="60" />
                                <img src="{{ asset('assets/images/small/small-2.jpg') }}" alt="post-img"
                                    class="rounded me-1" height="60" />
                                <img src="{{ asset('assets/images/small/small-3.jpg') }}" alt="post-img" class="rounded"
                                    height="60" />

                                <div class="mt-2">
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                            class="mdi mdi-reply"></i> Reply</a>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                            class="mdi mdi-heart-outline"></i> Like</a>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                            class="mdi mdi-share-variant"></i> Share</a>
                                </div>
                            </div>

                            <!-- Story Box-->
                            <div class="border border-light rounded p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle"
                                        src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                        alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">Thelma Fridley</h5>
                                        <p class="text-muted"><small>about 1 hour ago</small></p>
                                    </div>
                                </div>
                                <div class="font-16 text-center fst-italic text-dark">
                                    <i class="mdi mdi-format-quote-open font-20"></i> Cras sit amet nibh libero, in
                                    gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras
                                    purus odio, vestibulum in vulputate at, tempus viverra turpis. Duis
                                    sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper
                                    porta. Mauris massa.
                                </div>

                                <div class="mx-n2 p-2 mt-3 bg-light">
                                    <div class="d-flex">
                                        <img class="me-2 rounded-circle"
                                            src="{{ asset('assets/images/users/avatar-3.jpg') }}"
                                            alt="Generic placeholder image" height="32">
                                        <div>
                                            <h5 class="mt-0">Jeremy Tomlinson <small class="text-muted">3 hours
                                                    ago</small></h5>
                                            Nice work, makes me think of The Money Pit.

                                            <br />
                                            <a href="javascript: void(0);"
                                                class="text-muted font-13 d-inline-block mt-2"><i
                                                    class="mdi mdi-reply"></i> Reply</a>

                                            <div class="d-flex mt-3">
                                                <a class="pe-2" href="#">
                                                    <img src="{{ asset('assets/images/users/avatar-4.jpg') }}"
                                                        class="rounded-circle" alt="Generic placeholder image"
                                                        height="32">
                                                </a>
                                                <div>
                                                    <h5 class="mt-0">Thelma Fridley <small class="text-muted">5
                                                            hours ago</small></h5>
                                                    i'm in the middle of a timelapse animation myself! (Very different
                                                    though.) Awesome stuff.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-2">
                                        <a class="pe-2" href="#">
                                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                                class="rounded-circle" alt="Generic placeholder image" height="32">
                                        </a>
                                        <div class="w-100">
                                            <input type="text" id="simpleinput"
                                                class="form-control border-0 form-control-sm" placeholder="Add comment">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-danger"><i
                                            class="mdi mdi-heart"></i> Like (28)</a>
                                    <a href="javascript: void(0);" class="btn btn-sm btn-link text-muted"><i
                                            class="mdi mdi-share-variant"></i> Share</a>
                                </div>
                            </div>

                            <!-- Story Box-->
                            <div class="border border-light p-2 mb-3">
                                <div class="d-flex">
                                    <img class="me-2 rounded-circle"
                                        src="{{ asset('assets/images/users/avatar-6.jpg') }}"
                                        alt="Generic placeholder image" height="32">
                                    <div>
                                        <h5 class="m-0">Martin Williamson</h5>
                                        <p class="text-muted"><small>15 hours ago</small></p>
                                    </div>
                                </div>
                                <p>The parallax is a little odd but O.o that house build is awesome!!</p>

                                <iframe src='https://player.vimeo.com/video/87993762' height='300'
                                    class="img-fluid border-0"></iframe>
                            </div>

                            <div class="text-center">
                                <a href="javascript:void(0);" class="text-danger"><i
                                        class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                            </div>

                        </div>
                        <!-- end obat content-->

                        <div class="tab-pane" id="settings">
                            <form>
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal
                                    Info</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="firstname" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="firstname"
                                                placeholder="Enter first name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="lastname" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="lastname"
                                                placeholder="Enter last name">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="userbio" class="form-label">Bio</label>
                                            <textarea class="form-control" id="userbio" rows="4" placeholder="Write something..."></textarea>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="useremail"
                                                placeholder="Enter email">
                                            <span class="form-text text-muted"><small>If you want to change email
                                                    please <a href="javascript: void(0);">click</a>
                                                    here.</small></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="userpassword"
                                                placeholder="Enter password">
                                            <span class="form-text text-muted"><small>If you want to change password
                                                    please <a href="javascript: void(0);">click</a>
                                                    here.</small></span>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-office-building me-1"></i>
                                    Company Info</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="companyname" class="form-label">Company Name</label>
                                            <input type="text" class="form-control" id="companyname"
                                                placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cwebsite" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="cwebsite"
                                                placeholder="Enter website url">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-earth me-1"></i> Social
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-fb" class="form-label">Facebook</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-facebook"></i></span>
                                                <input type="text" class="form-control" id="social-fb"
                                                    placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-tw" class="form-label">Twitter</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-twitter"></i></span>
                                                <input type="text" class="form-control" id="social-tw"
                                                    placeholder="Username">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-insta" class="form-label">Instagram</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-instagram"></i></span>
                                                <input type="text" class="form-control" id="social-insta"
                                                    placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-lin" class="form-label">Linkedin</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-linkedin"></i></span>
                                                <input type="text" class="form-control" id="social-lin"
                                                    placeholder="Url">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-sky" class="form-label">Skype</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-skype"></i></span>
                                                <input type="text" class="form-control" id="social-sky"
                                                    placeholder="@username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="social-gh" class="form-label">Github</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="mdi mdi-github"></i></span>
                                                <input type="text" class="form-control" id="social-gh"
                                                    placeholder="Username">
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var path = "{{ route('autocomplete_obat') }}";
            $("#search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: path,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search').val(ui.item.label);
                    console.log(ui.item);
                    return false;
                }
            });
        });

        // var insertlist = "{{ route('insertlist_obat') }}";
        $('#add').click(function(e) {
            e.preventDefault();
            let kodetransaksi = $('#notransaksi').val();
            let qrcode = $('#qrcode').val();
            let search = $('#search').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: insertlist,
                type: "POST",
                cache: false,
                data: {
                    "kode_transaksi": kodetransaksi,
                    "kode_barang": qrcode,
                    "search": search,
                    "_token": token
                },

                success: function(response) {
                    let post = `
                    <tr id="list_id${response.data.list_id}">
                        <td>${response.data.kode}</td>
                        <td>${response.data.nama}</td>
                        <td>
                            <input type="text" name="qty" id="qty-${response.data.list_id}" class="form-control" value="${response.data.qty}">
                        </td>
                        <td>${response.data.diskon}%</td>
                        <td id="harga">${formatNumber(response.data.harga)}</td>
                        <td class="subtotal" id="jumlah">${formatNumber(response.data.jumlah)}</td>
                        <td>
                            <a href="javascript:void(0);" class="action-icon" onclick="edit('${response.data.list_id}')">
                                <i class="mdi mdi-square-edit-outline"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="hapus('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                `;
                    $('#barangList').append(post);
                    $('#search').val('');
                    console.log(response.data);
                    updateGrandTotal();
                }
            })
        })
    </script>
@endsection
