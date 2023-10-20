@extends('layouts.dashboard')
@section('content')
    <div class="md-col row">
        <div class="col-md-6 col-lg-4  mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Apply</h5>

                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar d-flex bg-ijo icon-container me-3">
                                <i class='bx bx-check ijo'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Lulus</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="lulus"></h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar bg-merah icon-container me-3">
                                <i class='bx bx-x merah'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Ditolak</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="ditolak"></h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar bg-biru icon-container me-3">
                                <i class='bx bx-timer biru'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Pending</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="pending"></h6>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4  mb-4">
            <div class="card h-auto">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Carrer</h5>

                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar d-flex bg-ijo icon-container me-3">
                                <i class='bx bx-list-ol ijo'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Batch</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="batch"></h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar bg-biru icon-container me-3">
                                <i class='bx bx-briefcase biru'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Lowongan</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="lowongan"></h6>
                                </div>
                            </div>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4  mb-4">
            <div class="card h-auto">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">User</h5>

                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar d-flex bg-ijo icon-container me-3">
                                <i class='bx bx-list-ol ijo'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">All</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="user"></h6>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar bg-biru icon-container me-3">
                                <i class='bx bx-briefcase biru'></i>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Pemagang</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0" id="pemagang"></h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-8 mb-4">
            <div class="w-full card p-3">
                <div class="col-3 mt-3">
                    <select name="" id="tahun" onchange="changeYear()" class="form-control">
                    </select>
                </div>
                <canvas id="charts"></canvas>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 ">
            <div class="card container-chart w-full p-3">
                <canvas id="charts-apply">d</canvas>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "/dashboard-data",
                success: function(response) {
                    // console.log(response.result);
                    $('#lulus').html(response.result.total_lulus);
                    $('#ditolak').html(response.result.total_ditolak);
                    $('#pending').html(response.result.total_pendaftar);
                    $('#batch').html(response.result.total_batch);
                    $('#lowongan').html(response.result.total_lowongan);
                    $('#user').html(response.result.total_user);
                    $('#pemagang').html(response.result.total_pemagang);
                }
            });
        })
    </script>
@endsection
