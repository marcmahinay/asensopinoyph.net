document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".tablelist-form");
    const addBtn = document.getElementById("add-btn");
    const closeModalBtn = document.getElementById("close-modal");
    const closeModalDelete = document.getElementById("btn-close");
    var municityIdField = document.getElementById("municity_id-field");
    var barangayIdField = document.getElementById("barangay_id-field");
    var barangayNameField = document.getElementById("barangay_name-field");
    var provinceIdField = document.getElementById("province_id-field");
    const provinceSelect = document.getElementById("province_id-field");
    const municitySelect = document.getElementById("municity_id-field");
    var removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn");

    var options = {
        valueNames: [
            "barangay_id",
            "barangay_name",
            "municity_id",
            "municity_name",
            "province_id",
            "province_name",
        ],
        page: 10,
        pagination: true,
    };

    var barangayList = new List("barangayList", options);
    // Add event listener to reapply event listeners after pagination changes
    barangayList.on("updated", function () {
        refreshCallback();
    });

    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            if (e.relatedTarget.classList.contains("edit-item-btn")) {
                document.getElementById("exampleModalLabel").innerHTML =
                    "Edit Barangay";
                document
                    .getElementById("showModal")
                    .querySelector(".modal-footer").style.display = "block";
                document.getElementById("add-btn").innerHTML = "Update";
                provinceIdField.setAttribute("disabled", "disabled");
                municityIdField.setAttribute("disabled", "disabled");
            } else if (e.relatedTarget.classList.contains("add-btn")) {
                document.getElementById("exampleModalLabel").innerHTML =
                    "Add Barangay";
                document
                    .getElementById("showModal")
                    .querySelector(".modal-footer").style.display = "block";
                document.getElementById("add-btn").innerHTML = "Add Barangay";
                provinceIdField.removeAttribute("disabled");
                municityIdField.removeAttribute("disabled");
            } else {
                document.getElementById("exampleModalLabel").innerHTML =
                    "List Barangay";
                document
                    .getElementById("showModal")
                    .querySelector(".modal-footer").style.display = "none";
            }
        });

    // Event listener for edit button click
    document.querySelectorAll(".edit-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            // Find the closest row to the clicked edit button
            var row = this.closest("tr");

            // Retrieve data from the table row
            var barangayId = this.getAttribute("data-id"); // Barangay ID from data attribute
            var barangayName = row
                .querySelector(".barangay_name")
                .textContent.trim(); // Barangay name from the row
            var municityId = row
                .querySelector(".municity_id")
                .textContent.trim(); // Barangay name from the row
            var municityName = row
                .querySelector(".municity_name")
                .textContent.trim(); // Barangay name from the row
            var provinceId = row
                .querySelector(".province_id")
                .textContent.trim(); // Barangay name from the row
            // Populate the modal fields with the retrieved data
            barangayIdField.value = barangayId;
            barangayNameField.value = barangayName;
            provinceIdField.value = provinceId;

            // Select the correct option in the province select field
            if (provinceSelect.querySelector(`option[value="${provinceId}"]`)) {
                provinceSelect.value = provinceId;
                // Trigger the change event to populate the municity select
                provinceSelect.dispatchEvent(new Event("change"));

                // Set timeout to allow municities to populate
                setTimeout(() => {
                    municityIdField.value = municityId;
                }, 1000); // Adjust
            }
        });
    });

    // Event listener for edit button click
    document.querySelectorAll(".remove-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var barangayId = this.getAttribute("data-id");
            document
                .getElementById("delete-record")
                .setAttribute("data-id", barangayId);
        });
    });

    document
        .getElementById("delete-record")
        .addEventListener("click", function () {
            var barangayId = this.getAttribute("data-id");
            console.log(barangayId);
            deleteBarangay(barangayId);
        });

    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const provinceSelect = document.getElementById("province_id-field");
        const provinceId = provinceSelect.value;
        const provinceNameField =
            provinceSelect.options[provinceSelect.selectedIndex].text;
        const municitySelect = document.getElementById("municity_id-field");
        const municityId = municitySelect.value;
        const municityNameField =
            municitySelect.options[municitySelect.selectedIndex].text;
        const barangayIdField =
            document.getElementById("barangay_id-field").value;
        const barangayNameField = document.getElementById(
            "barangay_name-field"
        ).value;
        if (form.checkValidity()) {
            if (barangayIdField !== "") {
                console.log(barangayIdField, barangayNameField);
                updateBarangay(barangayIdField, barangayNameField);
            } else {
                addBarangay(
                    barangayNameField,
                    provinceId,
                    provinceNameField,
                    municityId,
                    municityNameField
                );
            }
        } else {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function updateBarangay(barangayId, barangayName) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`/barangays/${barangayId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                id: barangayId,
                name: barangayName,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    barangayList.items.forEach(function (item) {
                        if (item.values().barangay_id == barangayId) {
                            item.values({
                                barangay_id: barangayId,
                                barangay_name: barangayName,
                            });
                        }
                    });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Barangay updated successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to update Barangay!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to update Barangay!",
                    showConfirmButton: true,
                });
            });
    }

    function addBarangay(
        barangayName,
        provinceId,
        provinceName,
        municityId,
        municityName
    ) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/barangays", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                municity_id: municityId,
                name: barangayName,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data);
                    barangayList.add({
                        barangay_id: data.data.id,
                        barangay_name: barangayName,
                        municity_id: municityId,
                        municity_name: municityName,
                        province_id: provinceId,
                        province_name: provinceName,
                    });
                    barangayList.sort("barangay_name", { order: "asc" });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Barangay inserted successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to insert Barangay!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to insert Barangay!",
                    showConfirmButton: true,
                });
            });
    }

    function deleteBarangay(barangayId) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        if (!csrfToken) {
            console.error("CSRF token not found");
            return;
        }

        fetch(`/barangays/${barangayId}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Remove the item from the list
                    barangayList.remove("barangay_id", barangayId);
                    closeModalDelete.click();
                    refreshCallback();
                    Swal.fire(
                        "Deleted!",
                        "Barangay has been deleted.",
                        "success"
                    );
                } else {
                    Swal.fire("Error!", "Failed to delete Barangay.", "error");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire(
                    "Error!",
                    "An error occurred while deleting the Barangay.",
                    "error"
                );
            });
    }

    function clearFields() {
        provinceIdField.value = "";
        municityIdField.innerHTML =
            '<option value="">Select City/Municipality</option>';
        barangayIdField.value = "";
        barangayNameField.value = "";
        municityIdField.value = "";
    }

    provinceSelect.addEventListener("change", function () {
        const provinceId = this.value;
        fetch(`/provinces/${provinceId}/municities`)
            .then((response) => response.json())
            .then((data) => {
                console.log("Fetched data:", data.municities);
                municitySelect.innerHTML =
                    '<option value="">Select City/Municipality</option>';

                if (Array.isArray(data.municities)) {
                    // Sort the data alphabetically by name
                    data.municities.sort((a, b) =>
                        a.name.localeCompare(b.name)
                    );

                    data.municities.forEach((municity) => {
                        const option = document.createElement("option");
                        option.value = municity.id;
                        option.textContent = municity.name;
                        municitySelect.appendChild(option);
                    });
                } else {
                    console.error(
                        "Expected an array of municities, but received:",
                        data
                    );
                    // Optionally, display an error message to the user
                }
            })
            .catch((error) => {
                console.error("Error fetching municities:", error);
            });
    });

    function refreshCallback() {
        // Event listener for edit button click
        document.querySelectorAll(".edit-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                // Find the closest row to the clicked edit button
                var row = this.closest("tr");

                // Retrieve data from the table row
                var barangayId = this.getAttribute("data-id"); // Barangay ID from data attribute
                var barangayName = row
                    .querySelector(".barangay_name")
                    .textContent.trim(); // Barangay name from the row
                var municityId = row
                    .querySelector(".municity_id")
                    .textContent.trim(); // Barangay name from the row
                var municityName = row
                    .querySelector(".municity_name")
                    .textContent.trim(); // Barangay name from the row
                var provinceId = row
                    .querySelector(".province_id")
                    .textContent.trim(); // Barangay name from the row
                // Populate the modal fields with the retrieved data
                barangayIdField.value = barangayId;
                barangayNameField.value = barangayName;
                provinceIdField.value = provinceId;

                // Select the correct option in the province select field
                if (
                    provinceSelect.querySelector(
                        `option[value="${provinceId}"]`
                    )
                ) {
                    provinceSelect.value = provinceId;
                    // Trigger the change event to populate the municity select
                    provinceSelect.dispatchEvent(new Event("change"));

                    // Set timeout to allow municities to populate
                    setTimeout(() => {
                        municityIdField.value = municityId;
                    }, 1000); // Adjust
                }
            });
        });

        document
            .querySelectorAll(".remove-item-btn")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    var barangayId = this.getAttribute("data-id");
                    document
                        .getElementById("delete-record")
                        .setAttribute("data-id", barangayId);
                });
            });
    }

    refreshCallback();
});
