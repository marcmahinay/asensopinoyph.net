document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".tablelist-form");
    const addBtn = document.getElementById("add-btn");
    const closeModalBtn = document.getElementById("close-modal");
    const closeModalDelete = document.getElementById("btn-close");
    var provinceIdField = document.getElementById("id-field");
    var provinceNameField = document.getElementById("province_name-field");
    var provinceRegionField = document.getElementById("province_region-field");
    var removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn");

    var options = {
        valueNames: ["province_id", "province_name", "province_region"],
        page: 20,
        pagination: true,
    };

    var editlist = false;

    count = 100;

    var provinceList = new List("provinceList", options);
    // Add event listener to reapply event listeners after pagination changes
    provinceList.on("updated", function () {
        refreshCallback();
    });

    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            e.relatedTarget.classList.contains("edit-item-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                    "Edit Province"),
                    (document
                        .getElementById("showModal")
                        .querySelector(".modal-footer").style.display = "block"),
                    (document.getElementById("add-btn").innerHTML = "Update"))
                : e.relatedTarget.classList.contains("add-btn")
                    ? ((document.getElementById("exampleModalLabel").innerHTML =
                        "Add Province"),
                        (document
                            .getElementById("showModal")
                            .querySelector(".modal-footer").style.display = "block"),
                        (document.getElementById("add-btn").innerHTML =
                            "Add Province"))
                    : ((document.getElementById("exampleModalLabel").innerHTML =
                        "List Province"),
                        (document
                            .getElementById("showModal")
                            .querySelector(".modal-footer").style.display = "none"));
        });

    // Event listener for edit button click
    document.querySelectorAll(".edit-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            // Find the closest row to the clicked edit button
            var row = this.closest("tr");

            // Retrieve data from the table row
            var provinceId = this.getAttribute("data-id"); // Province ID from data attribute
            var provinceName = row
                .querySelector(".province_name")
                .textContent.trim(); // Province name from the row
            var provinceRegion = row
                .querySelector(".province_region")
                .textContent.trim(); // Province region from the row

            // Populate the modal fields with the retrieved data
            document.getElementById("id-field").value = provinceId;
            document.getElementById("province_name-field").value = provinceName;
            document.getElementById("province_region-field").value =
                provinceRegion;
        });
    });

    // Event listener for edit button click
    document.querySelectorAll(".remove-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var provinceId = this.getAttribute("data-id");
            document.getElementById("delete-record").setAttribute("data-id", provinceId);
        });
    });

    document.getElementById("delete-record").addEventListener("click", function () {
        var provinceId = this.getAttribute("data-id");
        deleteProvince(provinceId);
    });

    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const provinceIdField = document.getElementById("id-field").value;
        const provinceNameField = document.getElementById(
            "province_name-field"
        ).value;
        const provinceRegionField = document.getElementById(
            "province_region-field"
        ).value;
        if (form.checkValidity()) {
            if (provinceIdField !== "") {
                updateProvince(
                    provinceIdField,
                    provinceNameField,
                    provinceRegionField
                );
            } else {
                addProvince(provinceNameField, provinceRegionField);
            }
        } else {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function updateProvince(provinceId, provinceName, provinceRegion) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`provinces/${provinceId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                id: provinceId,
                name: provinceName,
                region: provinceRegion,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    provinceList.items.forEach(function (item) {
                        if (item.values().province_id == provinceId) {
                            item.values({
                                province_id: provinceId,
                                province_name: provinceName,
                                province_region: provinceRegion,
                            });
                        }
                    });
                    closeModalBtn.click();
                    clearFields();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Province updated successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to update province!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to update province!",
                    showConfirmButton: true,
                });
            });
    }

    function addProvince(provinceName, provinceRegion) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/provinces", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                name: provinceName,
                region: provinceRegion,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data.data.id);
                    provinceList.add({
                        province_id: data.data.id,
                        province_name: provinceName,
                        province_region: provinceRegion,
                    });
                    provinceList.sort("province_name", { order: "asc" });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Province inserted successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to insert province!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to insert province!",
                    showConfirmButton: true,
                });
            });
    }

    function deleteProvince(provinceId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch(`provinces/${provinceId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the item from the list
                    provinceList.remove('province_id', provinceId);
                    closeModalDelete.click();
                    refreshCallback();
                    Swal.fire(
                        'Deleted!',
                        'Province has been deleted.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to delete province.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred while deleting the province.',
                    'error'
                );
            });
    }
    var provinceIdField = document.getElementById("id-field");
    var provinceNameField = document.getElementById("province_name-field");
    var provinceRegionField = document.getElementById("province_region-field");

    function clearFields() {
        (provinceIdField.value = ""),
            (provinceNameField.value = ""),
            (provinceRegionField.value = "");
    }

    function refreshCallback() {
        // Event listener for edit button click
        document.querySelectorAll(".edit-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                // Find the closest row to the clicked edit button
                var row = this.closest("tr");

                // Retrieve data from the table row
                var provinceId = this.getAttribute("data-id"); // Province ID from data attribute
                var provinceName = row
                    .querySelector(".province_name")
                    .textContent.trim(); // Province name from the row
                var provinceRegion = row
                    .querySelector(".province_region")
                    .textContent.trim(); // Province region from the row

                // Populate the modal fields with the retrieved data
                document.getElementById("id-field").value = provinceId;
                document.getElementById("province_name-field").value =
                    provinceName;
                document.getElementById("province_region-field").value =
                    provinceRegion;
            });

            //
        });

        document.querySelectorAll(".remove-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                var provinceId = this.getAttribute("data-id");
                document.getElementById("delete-record").setAttribute("data-id", provinceId);
            });
        });

    }

    function clearFields() {
        (provinceIdField.value = ""),
            (provinceNameField.value = ""),
            (provinceRegionField.value = "");
    }

    refreshCallback();
});

