<x-app-layout>
    <x-slot name="pageTitle">
        {{ $province->name }}
    </x-slot>

    <x-slot name="headerScripts">
        <!-- Sweet Alert css-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>


    <x-slot name="footerScripts">
        <!-- list.js min js -->
        <script src="{{ asset('assets/libs/list.js/list.min.js') }}"></script>
        <script src="{{ asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

        <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- crm leads init -->
        <script src="{{ asset('assets/js/app/provinces-show.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>


    </x-slot>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $province->name }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">{{ $province->name }}</li>
                        <li class="breadcrumb-item active">List of Cities/Municipalities</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="municityList">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-soft-warning add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Add municipality/city</button>
                                {{--  <span class="dropdown">
                                    <button class="btn btn-soft-primary btn-icon fs-14" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-settings-4-line"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">Copy</a></li>
                                        <li><a class="dropdown-item" href="#">Move to pipline</a></li>
                                        <li><a class="dropdown-item" href="#">Add to exceptions</a></li>
                                        <li><a class="dropdown-item" href="#">Switch to common form
                                                view</a></li>
                                        <li><a class="dropdown-item" href="#">Reset form view to
                                                default</a></li>
                                    </ul>
                                </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle" id="provinceTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>

                                        <th class="" data-sort="municity_name">Name</th>
                                        <th class="" data-sort="barangay_count">Barangay Count</th>
                                        <th class="" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($province->municipalities as $municity)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="{{ $municity->id }}">
                                                </div>
                                            </th>
                                            <td class="municity_id" style="display:none;">{{ $municity->id }}</td>
                                            <td class="municity_name">{{ $municity->name }}</td>
                                            <td class="barangay_count">{{ $municity->barangays->count() }}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('municities.show', $municity->id) }}"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a class="edit-item-btn" href="#showModal"
                                                            data-id="{{ $municity->id }}" data-bs-toggle="modal"><i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Delete">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal" data-id="{{ $municity->id }}">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#25a0e2,secondary:#00bd9d" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0"> We
                                        did not find any
                                        province for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-primary-subtle p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" autocomplete="off">
                                    <div class="modal-body">
                                        <input type="hidden" id="municity_id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div>
                                                    <input type="hidden" id="province_id-field"
                                                        value="{{ $province->id }}" />
                                                    <label for="province_name-field"
                                                        class="form-label">Province</label>
                                                    <input type="text" id="province_name-field"
                                                        class="form-control" value="{{ $province->name }}" required
                                                        disabled />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>

                                                    <label for="municity_name-field" class="form-label">Name</label>
                                                    <input type="text" id="municity_name-field"
                                                        class="form-control"
                                                        placeholder="Enter City/Municipality Name" required />
                                                </div>
                                            </div>
                                            <!--end col-->



                                        </div>
                                        <!--end row-->
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Add
                                                Province</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->

                    <!-- Modal -->
                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                        aria-labelledby="deleteRecordLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close" id="btn-close"></button>
                                </div>
                                <div class="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                        colors="primary:#25a0e2,secondary:#00bd9d"
                                        style="width:90px;height:90px"></lord-icon>
                                    <div class="mt-4 text-center">
                                        <h4 class="fs-semibold">You are about to delete a city/municipality ?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting your city/municipality will
                                            remove all of your information from our database.</p>
                                        <div class="hstack gap-2 justify-content-center remove">
                                            <button class="btn btn-link link-primary fw-medium text-decoration-none"
                                                id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                    class="ri-close-line me-1 align-middle"></i>
                                                Close</button>
                                            <button class="btn btn-primary" id="delete-record">Yes,
                                                Delete It!!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end modal -->



                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->




</x-app-layout>
