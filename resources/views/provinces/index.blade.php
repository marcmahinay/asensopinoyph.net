<x-app-layout>
    <x-slot name="pageTitle">
        Provinces
    </x-slot>

    <x-slot name="headerScripts">
        <!-- Sweet Alert css-->
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    </x-slot>


    <x-slot name="footerScripts">
        <!-- list.js min js -->
        <script src="assets/libs/list.js/list.min.js"></script>
        <script src="assets/libs/list.pagination.js/list.pagination.min.js"></script>

        <!-- Sweet Alerts js -->
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <!-- crm leads init -->
        <script src="assets/js/pages/crm-leads.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Event listener for edit button click
                document.querySelectorAll('.edit-item-btn').forEach(function(button) {
                    button.addEventListener('click', function() {
                        // Find the closest row to the clicked edit button
                        var row = this.closest('tr');

                        // Retrieve data from the table row
                        var provinceId = this.getAttribute(
                            'data-id'); // Province ID from data attribute
                        var provinceName = row.querySelector('.province-name').textContent
                            .trim(); // Province name from the row
                        var provinceRegion = row.querySelector('.province-region').textContent
                            .trim(); // Province region from the row

                        // Populate the modal fields with the retrieved data
                        document.getElementById('province-name').value = provinceName;
                        document.getElementById('province-region').value = provinceRegion;

                        // Store the province ID in a data attribute of the save button or modal
                        document.getElementById('edit-province-form').setAttribute('data-id',
                            provinceId);

                        // Show the modal
                        var editProvinceModal = new bootstrap.Modal(document.getElementById(
                            'editProvince'));
                        editProvinceModal.show();
                    });
                });

                // Event listener for form submission
                document.getElementById('edit-province-form').addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent default form submission

                    var provinceId = this.getAttribute('data-id'); // Get province ID from data attribute

                    // Prepare form data
                    var formData = {
                        _method: 'PUT', // Specify the HTTP method to be used
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'), // Get CSRF token from meta tag
                        name: document.getElementById('province-name').value, // Province name
                        region: document.getElementById('province-region').value // Province region
                    };
                    console.log(JSON.stringify(formData));
                    // Use Fetch API to update province data
                    fetch('/provinces/' + provinceId, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content') // CSRF token for security
                            },
                            body: JSON.stringify(formData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            var editProvinceModal = bootstrap.Modal.getInstance(document.getElementById(
                                'editProvince'));
                            editProvinceModal.hide(); // Hide the modal
                            alert('Province updated successfully!');
                            location.reload(); // Reload the page to reflect changes
                        })
                        .catch(error => {
                            console.log('Error updating province:', error);
                            alert('Failed to update province. Please try again.');
                        });
                });
            });
        </script>
    </x-slot>

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Provinces</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Provinces</a></li>
                        <li class="breadcrumb-item active">Province List</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="provinceList">
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
                                {{-- <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i> Fliters</button> --}}
                                <button type="button" class="btn btn-soft-warning add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Add province</button>
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
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>

                                        <th class="" data-sort="province_name">Name</th>
                                        <th class="" data-sort="province_region">Region</th>
                                        <th class="" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($provinces as $province)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="{{$province->id}}">
                                                </div>
                                            </th>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">{{$province->id}}</a></td>
                                            <td class="province_name">{{$province->name}}</td>
                                            <td class="province_region">{{$province->region}}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">

                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="javascript:void(0);"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a class="edit-item-btn" href="#showModal"
                                                            data-bs-toggle="modal"><i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top"
                                                        title="Delete">
                                                        <a class="remove-item-btn" data-bs-toggle="modal"
                                                            href="#deleteRecordModal">
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
                                        <input type="hidden" id="id-field" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                nhrwaq
                                                <div>
                                                    <label for="leadname-field" class="form-label">Name</label>
                                                    <input type="text" id="leadname-field" class="form-control"
                                                        placeholder="Enter Name" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="company_name-field" class="form-label">Company
                                                        Name</label>
                                                    <input type="text" id="company_name-field"
                                                        class="form-control" placeholder="Enter company name"
                                                        required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="leads_score-field" class="form-label">Leads
                                                        Score</label>
                                                    <input type="text" id="leads_score-field" class="form-control"
                                                        placeholder="Enter lead score" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="phone-field" class="form-label">Phone</label>
                                                    <input type="text" id="phone-field" class="form-control"
                                                        placeholder="Enter phone no" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="location-field" class="form-label">Location</label>
                                                    <input type="text" id="location-field" class="form-control"
                                                        placeholder="Enter location" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="taginput-choices" class="form-label">Tags</label>
                                                    <select class="form-control" name="taginput-choices"
                                                        id="taginput-choices" multiple>
                                                        <option value="Lead">Lead</option>
                                                        <option value="Partner">Partner</option>
                                                        <option value="Exiting">Exiting</option>
                                                        <option value="Long-term">Long-term</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="date-field" class="form-label">Created Date</label>
                                                    <input type="date" id="date-field" class="form-control"
                                                        data-provider="flatpickr" data-date-format="d M, Y"
                                                        placeholder="Select Date" required />
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
                                                leads</button>
                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
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
                                        <h4 class="fs-semibold">You are about to delete a lead ?</h4>
                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting your lead will
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


                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel">
                        <div class="offcanvas-header bg-light">
                            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Leads Fliters</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <!--end offcanvas-header-->
                        <form action="" class="d-flex flex-column justify-content-end h-100">
                            <div class="offcanvas-body">
                                <div class="mb-4">
                                    <label for="datepicker-range"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Date</label>
                                    <input type="date" class="form-control" id="datepicker-range"
                                        data-provider="flatpickr" data-range="true" placeholder="Select date">
                                </div>
                                <div class="mb-4">
                                    <label for="country-select"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Country</label>
                                    <select class="form-control" data-choices data-choices-multiple-remove="true"
                                        name="country-select" id="country-select" multiple>
                                        <option value="">Select country</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Brazil" selected>Brazil</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Syria">Syria</option>
                                        <option value="United Kingdom" selected>United Kingdom</option>
                                        <option value="United States of America">United States of
                                            America</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="status-select"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Status</label>
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                    value="option1">
                                                <label class="form-check-label" for="inlineCheckbox1">New
                                                    Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                    value="option2">
                                                <label class="form-check-label" for="inlineCheckbox2">Old
                                                    Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox3"
                                                    value="option3">
                                                <label class="form-check-label" for="inlineCheckbox3">Loss
                                                    Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox4"
                                                    value="option4">
                                                <label class="form-check-label" for="inlineCheckbox4">Follow
                                                    Up</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="leadscore"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Lead
                                        Score</label>
                                    <div class="row g-2 align-items-center">
                                        <div class="col-lg">
                                            <input type="number" class="form-control" id="leadscore"
                                                placeholder="0">
                                        </div>
                                        <div class="col-lg-auto">
                                            To
                                        </div>
                                        <div class="col-lg">
                                            <input type="number" class="form-control" id="leadscore"
                                                placeholder="0">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="leads-tags"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Tags</label>
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="marketing"
                                                    value="marketing">
                                                <label class="form-check-label" for="marketing">Marketing</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="management"
                                                    value="management">
                                                <label class="form-check-label" for="management">Management</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="business"
                                                    value="business">
                                                <label class="form-check-label" for="business">Business</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="investing"
                                                    value="investing">
                                                <label class="form-check-label" for="investing">Investing</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="partner"
                                                    value="partner">
                                                <label class="form-check-label" for="partner">Partner</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lead"
                                                    value="lead">
                                                <label class="form-check-label" for="lead">Leads</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="sale"
                                                    value="sale">
                                                <label class="form-check-label" for="sale">Sale</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="owner"
                                                    value="owner">
                                                <label class="form-check-label" for="owner">Owner</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="banking"
                                                    value="banking">
                                                <label class="form-check-label" for="banking">Banking</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="banking"
                                                    value="banking">
                                                <label class="form-check-label" for="banking">Exiting</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="banking"
                                                    value="banking">
                                                <label class="form-check-label" for="banking">Finance</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="banking"
                                                    value="banking">
                                                <label class="form-check-label" for="banking">Fashion</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                <button class="btn btn-light w-100">Clear Filter</button>
                                <button type="submit" class="btn btn-primary w-100">Filters</button>
                            </div>
                            <!--end offcanvas-footer-->
                        </form>
                    </div>
                    <!--end offcanvas-->

                </div>
            </div>

        </div>
        <!--end col-->
    </div>
    <!--end row-->




</x-app-layout>
