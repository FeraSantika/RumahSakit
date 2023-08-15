@extends('main')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-light" id="dash-daterange">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Customers">
                                        Customers</h5>
                                    <h3 class="mt-3 mb-3"></h3>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-cart-plus widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Products
                                    </h5>
                                    <h3 class="mt-3 mb-3"></h3>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="mdi mdi-currency-usd widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Transactions
                                    </h5>
                                    <h3 class="mt-3 mb-3"></h3>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <div class="float-end">
                                        {{-- <i class="mdi mdi-pulse widget-icon"></i> --}}
                                        <i class="mdi mdi-account-multiple widget-icon"></i>
                                    </div>
                                    <h5 class="text-muted fw-normal mt-0" title="Growth">Suppliers</h5>
                                    <h3 class="mt-3 mb-3"></h3>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <h4 class="header-title">Transaksi</h4>
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="chart-content-bg">
                                <div class="row text-center">
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0 mt-3">Transaksi Barang Masuk</p>
                                        <h2 class="fw-normal mb-3">
                                            <small
                                                class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                            <span></span>
                                        </h2>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="text-muted mb-0 mt-3">Transaksi Barang Keluar</p>
                                        <h2 class="fw-normal mb-3">
                                            <small
                                                class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                            <span></span>
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            <div dir="ltr">
                                <div id="chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
    </div>
    <!-- container -->
    </div>
@endsection

