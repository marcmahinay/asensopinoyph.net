<x-app-layout>
    <x-slot name="pageTitle">
        Asenso Pinoy Dashboard
    </x-slot>

    <x-slot name="headerScripts">

    </x-slot>


    <x-slot name="footerScripts">
        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- projects js -->
        <script src="assets/js/pages/dashboard-projects.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
    </x-slot>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row project-wrapper">
        <div class="col-xxl-8">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-primary rounded-2 fs-2">
                                        <i data-feather="users" class="text-warning"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Beneficiaries
                                    </p>
                                    <i class="fas fa-hand-holding-heart fa-2x"></i>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                data-target="{{ $active_beneficiaries }}"></span></h4>
                                        {{-- <span class="badge bg-danger-subtle text-danger fs-12"><i
                                                class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> --}}
                                    </div>
                                    <p class="text-muted text-truncate mb-0">Total Active Beneficiaries</p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->

                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                        <i data-feather="heart" class="text-primary"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-medium text-muted mb-3">Assistance Provided</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                data-target="{{$assistance_provided_current_year}}">0</span></h4>
                                        <span class="badge bg-{{ $percentage_change_year <= 0 ? 'danger' : 'success' }}-subtle text-{{ $percentage_change_year <= 0 ? 'danger' : 'success' }} fs-12">
                                            <i class="ri-arrow-{{ $percentage_change_year <= 0 ? 'down' : 'up' }}-s-line fs-13 align-middle me-1"></i>
                                            {{ number_format(abs($percentage_change_year), 2) }} %
                                        </span>
                                    </div>
                                    <p class="text-muted mb-0">Assistance Provided this year</p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->

                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-2 fs-2">
                                        <i data-feather="tag" class="text-primary"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Voucher</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value"
                                                data-target="{{$current_year_voucher_issued}}">0</span></h4>
                                        <span class="badge bg-{{ $percentage_change_voucher_issued <= 0 ? 'danger' : 'success' }}-subtle text-{{ $percentage_change_voucher_issued <= 0 ? 'danger' : 'success' }} fs-12">
                                            <i class="ri-arrow-{{ $percentage_change_voucher_issued <= 0 ? 'down' : 'up' }}-s-line fs-13 align-middle me-1"></i>
                                            {{ number_format(abs($percentage_change_voucher_issued), 2) }} %
                                        </span>
                                    </div>
                                    <p class="text-muted mb-0">Voucher Distributed this year</p>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0 align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Assistance Overview</h4>
                            <div>
                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                    ALL
                                </button>
                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                    1M
                                </button>
                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                    6M
                                </button>
                                <button type="button" class="btn btn-soft-primary btn-sm">
                                    1Y
                                </button>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-header p-0 border-0 bg-light-subtle">
                            <div class="row g-0 text-center">
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span class="counter-value" data-target="9851">0</span></h5>
                                        <p class="text-muted mb-0">Number of Projects</p>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1"><span class="counter-value" data-target="1026">0</span></h5>
                                        <p class="text-muted mb-0">Active Projects</p>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0">
                                        <h5 class="mb-1">$<span class="counter-value" data-target="228.89">0</span>k
                                        </h5>
                                        <p class="text-muted mb-0">Revenue</p>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-6 col-sm-3">
                                    <div class="p-3 border border-dashed border-start-0 border-end-0">
                                        <h5 class="mb-1 text-success"><span class="counter-value"
                                                data-target="10589">0</span>h</h5>
                                        <p class="text-muted mb-0">Working Hours</p>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body p-0 pb-2">
                            <div>
                                <div id="projects-overview-chart"
                                    data-colors='["--vz-primary", "--vz-primary-rgb, 0.1", "--vz-primary-rgb, 0.50"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end col -->

        <div class="col-xxl-4">
            <div class="card">
                <div class="card-header border-0">
                    <h4 class="card-title mb-0">Upcoming Schedules</h4>
                </div><!-- end cardheader -->
                <div class="card-body pt-0">
                    <div class="upcoming-scheduled">
                        <input type="text" class="form-control" data-provider="flatpickr"
                            data-date-format="d M, Y" data-deafult-date="today" data-inline-date="true">
                    </div>

                    <h6 class="text-uppercase fw-semibold mt-4 mb-3 text-muted">Events:</h6>
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span
                                class="mini-stat-icon avatar-title rounded-circle text-primary bg-primary-subtle fs-4">
                                09
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Development planning</h6>
                            <p class="text-muted mb-0">iTest Factory </p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">9:20 <span class="text-uppercase">am</span></p>
                        </div>
                    </div><!-- end -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span
                                class="mini-stat-icon avatar-title rounded-circle text-primary bg-primary-subtle fs-4">
                                12
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Design new UI and check sales</h6>
                            <p class="text-muted mb-0">Meta4Systems</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">11:30 <span class="text-uppercase">am</span></p>
                        </div>
                    </div><!-- end -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span
                                class="mini-stat-icon avatar-title rounded-circle text-primary bg-primary-subtle fs-4">
                                25
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Weekly catch-up </h6>
                            <p class="text-muted mb-0">Nesta Technologies</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">02:00 <span class="text-uppercase">pm</span></p>
                        </div>
                    </div><!-- end -->
                    <div class="mini-stats-wid d-flex align-items-center mt-3">
                        <div class="flex-shrink-0 avatar-sm">
                            <span
                                class="mini-stat-icon avatar-title rounded-circle text-primary bg-primary-subtle fs-4">
                                27
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">James Bangs (Client) Meeting</h6>
                            <p class="text-muted mb-0">Nesta Technologies</p>
                        </div>
                        <div class="flex-shrink-0">
                            <p class="text-muted mb-0">03:45 <span class="text-uppercase">pm</span></p>
                        </div>
                    </div><!-- end -->

                    <div class="mt-3 text-center">
                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">View all Events</a>
                    </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

</x-app-layout>
