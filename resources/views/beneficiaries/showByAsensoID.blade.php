<x-app-layout>
    <x-slot name="pageTitle">
        {{ ucfirst(strtolower($beneficiary->last_name)) }}
                                                        , {{ ucfirst(strtolower($beneficiary->first_name)) }}
                                                        {{ substr($beneficiary->middle_name, 0, 1) . '.' }}
    </x-slot>

    <x-slot name="headerScripts">
        <!-- Sweet Alert css-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>


    <x-slot name="footerScripts">


        <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- ecommerce product details init -->
        <script src="{{ asset('assets/js/app/beneficiaries.show.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

    </x-slot>

   <!-- start page title -->
   <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('provinces.show', $beneficiary->barangay->municity->province->id) }}">{{ $beneficiary->barangay->municity->province->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('municities.show', $beneficiary->barangay->municity->id) }}">{{ $beneficiary->barangay->municity->name }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('barangays.show', $beneficiary->barangay->id) }}">{{ $beneficiary->barangay->name }}</a></li>
                    <li class="breadcrumb-item active">{{ ucfirst(strtolower($beneficiary->last_name)) }}
                        , {{ ucfirst(strtolower($beneficiary->first_name)) }}
                        {{ substr($beneficiary->middle_name, 0, 1) . '.' }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row gx-lg-5">
                    <div class="col-xl-4 col-md-8">

                        <div class="text-center mt-3">
                            <img src="{{ $beneficiary->image_path ? asset($beneficiary->image_path) : 'https://via.placeholder.com/128?text=No+Image' }}" alt="" class="img-thumbnail rounded-circle avatar-xl" style="width: 220px; height: 220px; object-fit: cover; object-position: top;" />
                        </div>
                        <div class="text-center mt-3">
                            <span class="badge bg-warning fs-5 px-3 py-2">{{$beneficiary->asenso_id}}</span>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-8">
                        <div class="mt-xl-0 mt-5">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h4>{{ ucfirst(strtolower($beneficiary->last_name)) }}
                                        , {{ ucfirst(strtolower($beneficiary->first_name)) }}
                                        {{ ucfirst(strtolower($beneficiary->middle_name)) }}</h4>
                                    <div class="hstack gap-3 flex-wrap">
                                        <div class="badge {{ $beneficiary->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $beneficiary->status == 1 ? 'Active' : 'Inactive' }}
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Sex : <span class="text-body fw-medium">{{ $beneficiary->sex }}</span>
                                        </div>
                                        <div class="vr"></div>
                                        <div class="text-muted">Birth Date : <span class="text-body fw-medium">{{$beneficiary->birth_date}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    {{-- <div>
                                        <a href="apps-ecommerce-add-product.html" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="ri-pencil-fill align-bottom"></i></a>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                                <div class="text-muted">{{$beneficiary->barangay->name}},  {{$beneficiary->barangay->municity->name}}</div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-lg-6 col-sm-12 mt-3">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                    <i class="ri-stack-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Assistance Received :</p>
                                                <h5 class="mb-0" id="received">{{$beneficiary->assistanceReceived()->count()}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                                <div class="col-lg-6 col-sm-12 mt-3">
                                    <div class="p-2 border border-dashed rounded">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                                    <i class="ri-inbox-archive-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-1">Redeemed Voucher :</p>
                                                <h5 class="mb-0">{{$beneficiary->voucherCodeRedeemedCount()}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->




</x-app-layout>
