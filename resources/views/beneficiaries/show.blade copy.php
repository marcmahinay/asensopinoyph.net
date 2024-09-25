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
                                                <h5 class="mb-0">{{$beneficiary->assistanceReceived()->count()}}</h5>
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

                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="alert alert-primary border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle text-primary me-2 icon-sm"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                        <div class="flex-grow-1 text-truncate">
                                            Your free trial expired in <b>17</b> days.
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                        </div>
                                    </div>

                                    <div class="row align-items-end">
                                        <div class="col-sm-8">
                                            <div class="p-3">
                                                <p class="fs-16 lh-base">Upgrade your plan from a <span class="fw-semibold">Free
                                                        trial</span>, to ‘Premium Plan’ <i class="mdi mdi-arrow-right"></i></p>
                                                <div class="mt-3">
                                                    <a href="pages-pricing.html" class="btn btn-primary">Upgrade
                                                        Account!</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="px-3">
                                                <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div>

                            {{-- <div class="row">
                                <div class="col-xl-6">
                                    <div class=" mt-4">
                                        <h5 class="fs-14">Sizes :</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio1" disabled>
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio1">S</label>
                                            </div>

                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio2">
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio2">M</label>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="06 Items Available">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio3">
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio3">L</label>
                                            </div>

                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                <input type="radio" class="btn-check" name="productsize-radio" id="productsize-radio4" disabled>
                                                <label class="btn btn-soft-primary avatar-xs rounded-circle p-0 d-flex justify-content-center align-items-center" for="productsize-radio4">XL</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-xl-6">
                                    <div class=" mt-4">
                                        <h5 class="fs-14">Colors :</h5>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Out of Stock">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-primary" disabled>
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="03 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-secondary">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="03 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-success">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="02 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-primary">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="01 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-warning">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-danger">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="03 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-light">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                            <div data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="04 Items Available">
                                                <button type="button" class="btn avatar-xs p-0 d-flex align-items-center justify-content-center border rounded-circle fs-20 text-body">
                                                    <i class="ri-checkbox-blank-circle-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row --> --}}

{{--                             <div class="mt-4 text-muted">
                                <h5 class="fs-14">Description :</h5>
                                <p>Tommy Hilfiger men striped pink sweatshirt. Crafted with cotton.
                                    Material composition is 100% organic cotton. This is one of the
                                    world’s leading designer lifestyle brands and is internationally
                                    recognized for celebrating the essence of classic American cool
                                    style, featuring preppy with a twist designs.</p>
                            </div> --}}

                            {{-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <h5 class="fs-14">Features :</h5>
                                        <ul class="list-unstyled">
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                Full Sleeve</li>
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                Cotton</li>
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                All Sizes available</li>
                                            <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i>
                                                4 Different Color</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-3">
                                        <h5 class="fs-14">Services :</h5>
                                        <ul class="list-unstyled product-desc-list">
                                            <li class="py-1">10 Days Replacement</li>
                                            <li class="py-1">Cash on Delivery available</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
 --}}

                            {{-- <div class="product-content mt-4">
                                <nav>
                                    <ul class="nav nav-tabs nav-tabs-custom nav-primary" id="nav-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="nav-avail-tab" data-bs-toggle="tab" href="#nav-avail" role="tab" aria-controls="nav-speci" aria-selected="true">Available Assistance</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci" role="tab" aria-controls="nav-speci" aria-selected="true">Assistance Received</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Vouchers</a>
                                        </li>
                                    </ul>
                                </nav>
                                <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-avail" role="tabpanel" aria-labelledby="nav-avail-tab">
                                        <div>
                                            <div class="table-responsive table-card mb-3">
                                                <table class="table align-middle table-nowrap mb-0" id="availableAssistanceTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th class="" data-sort="status" scope="col">Status</th>
                                                            <th class="" data-sort="name" scope="col">Event</th>
                                                            <th class="" data-sort="venue" scope="col">Venue</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">

                                                        @foreach ($eventSchedule as $index => $event)
                                                        <tr>
                                                            <td>
                                                                @if($event["received"])
                                                                <span class="badge bg-success">{{$event["received_at"]->format('F j, Y')}}</span>
                                                                <button class="btn btn-sm btn-danger cancel-assistance" data-beneficiary-id="{{ $beneficiary->id }}" data-event-id="{{ $event["event"]->id }}" id="cancel-assistance-{{ $event["event"]->id }}">Cancel</button>
                                                            @else
                                                                    <button class="btn btn-sm btn-primary receive-assistance" data-beneficiary-id="{{ $beneficiary->id }}" data-event-id="{{ $event["event"]->id }}">Avail</button>
                                                                @endif
                                                            </td>
                                                            <td class="assistance_event">{{$event["event"]->event_name}}</td>
                                                            <td><span class="assistance_type">{{$event["event"]->venue}}</span> </td>

                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                        <p class="text-muted mb-0">We've searched more than 150+ companies We did not find any
                                                            companies for you search.</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-speci" role="tabpanel" aria-labelledby="nav-speci-tab">
                                        <div>
                                            <div class="table-responsive table-card mb-3">
                                                <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                                    <thead class="table-light">
                                                        <tr>

                                                            <th class="" data-sort="name" scope="col">Event</th>
                                                            <th class="" data-sort="owner" scope="col">Assistance Type</th>
                                                            <th class="" data-sort="industry_type" scope="col">Received</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">

                                                        @foreach ($beneficiary->assistanceReceived()->orderBy('received_at', 'desc')->get() as $assistance)
                                                        <tr>
                                                            <td class="assistance_event">{{$assistance->assistanceEvent->event_name}}</td>
                                                            <td><span class="assistance_type">{{$assistance->assistanceEvent->assistanceType->name}}</span> </td>
                                                            <td class="location">{{$assistance->received_at->format('F j, Y')}}</td>
                                                            {{-- <td>
                                                                <ul class="list-inline hstack gap-2 mb-0">
                                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Call" data-bs-original-title="Call">
                                                                        <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                                            <i class="ri-phone-line fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Message" data-bs-original-title="Message">
                                                                        <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                                            <i class="ri-question-answer-line fs-16"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="View" data-bs-original-title="View">
                                                                        <a href="javascript:void(0);" class="view-item-btn"><i class="ri-eye-fill align-bottom text-muted"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                                        <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                                                                        <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </td> --}}
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center">
                                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:75px;height:75px">
                                                        </lord-icon>
                                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                                        <p class="text-muted mb-0">We've searched more than 150+ companies We did not find any
                                                            companies for you search.</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    {{-- </div>
                                    <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                        <div class="table-responsive table-card mb-3">
                                            <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                                <thead class="table-light">
                                                    <tr>

                                                        <th class="" data-sort="name" scope="col">Voucher Promo</th>
                                                        <th class="" data-sort="owner" scope="col">Promo Date</th>
                                                        <th class="" data-sort="owner" scope="col">Voucher Code</th>
                                                        <th class="" data-sort="industry_type" scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list form-check-all">

                                                    @foreach ($beneficiary->voucherCodes as $voucher)
                                                    <tr>
                                                        <td class="assistance_event">{{$voucher->voucher->name}}</td>
                                                        <td><span class="assistance_type">{{$voucher->voucher->start_date->format('F j, Y')}} - {{$voucher->voucher->end_date->format('F j, Y')}}</span> </td>
                                                        <td class="location">{{$voucher->code}}</td>
                                                        <td class="location">
                                                            @if($voucher->is_redeemed)
                                                                <span class="badge bg-success">Redeemed</span>
                                                            @endif
                                                        </td>
                                                        {{-- <td>
                                                            <ul class="list-inline hstack gap-2 mb-0">
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Call" data-bs-original-title="Call">
                                                                    <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                                        <i class="ri-phone-line fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Message" data-bs-original-title="Message">
                                                                    <a href="javascript:void(0);" class="text-muted d-inline-block">
                                                                        <i class="ri-question-answer-line fs-16"></i>
                                                                    </a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="View" data-bs-original-title="View">
                                                                    <a href="javascript:void(0);" class="view-item-btn"><i class="ri-eye-fill align-bottom text-muted"></i></a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Edit" data-bs-original-title="Edit">
                                                                    <a class="edit-item-btn" href="#showModal" data-bs-toggle="modal"><i class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                                </li>
                                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Delete" data-bs-original-title="Delete">
                                                                    <a class="remove-item-btn" data-bs-toggle="modal" href="#deleteRecordModal">
                                                                        <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td> --}}
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="noresult" style="display: none">
                                                <div class="text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:75px;height:75px">
                                                    </lord-icon>
                                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                                    <p class="text-muted mb-0">We've searched more than 150+ companies We did not find any
                                                        companies for you search.</p>
                                                </div>
                                            </div>
                                        </div>
                                   {{--  </div>
                                </div>
                            </div>   --}}
                            <!-- product-content -->

                            <!-- end card body -->

                           {{--  <div class="col-xxl-12 mt-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                                    Assistance
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                                    Assistance Received
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" href="#messages1" role="tab">
                                                    Vouchers
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content text-muted">
                                            <div class="tab-pane active" id="home1" role="tabpanel">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-checkbox-multiple-blank-fill text-success"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        Trust fund seitan letterpress, keytar raw denim keffiyeh etsy art party before they sold out master cleanse gluten-free squid scenester freegan cosby sweater. Fanny pack portland seitan DIY, art party locavore wolf cliche high life echo park Austin. Cred vinyl keffiyeh DIY salvia PBR.
                                                        <div class="mt-2">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-soft-primary">Read More <i class="ri-arrow-right-line ms-1 align-middle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="profile1" role="tabpanel">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-checkbox-multiple-blank-fill text-success"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        When, while the lovely valley teems with vapour around me, and the meridian sun strikes the upper surface of the impenetrable foliage of my trees, and but a few stray gleams steal into the inner sanctuary, I throw myself down among the tall grass by the trickling stream; and, as I lie close to the earth, a thousand unknown.
                                                        <div class="mt-2">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-soft-primary">Read More <i class="ri-arrow-right-line ms-1 align-middle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="messages1" role="tabpanel">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="ri-checkbox-multiple-blank-fill text-success"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ms-2">
                                                        Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                                                        <div class="mt-2">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-soft-primary">Read More <i class="ri-arrow-right-line ms-1 align-middle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div> --}}
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
