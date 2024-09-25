document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".tablelist-form");
    const addBtn = document.getElementById("add-btn");
    const closeModalBtn = document.getElementById("close-modal");
    const closeModalDelete = document.getElementById("btn-close");
    var assistanceTypeIdField = document.getElementById("id-field");
    var assistanceTypeNameField = document.getElementById("assistance_type_name-field");
    var assistanceTypeDescriptionField = document.getElementById("assistance_type_description-field");
    var removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn");

    var options = {
        valueNames: ["assistance_type_id", "assistance_type_name", "assistance_type_description"],
        page: 20,
        pagination: true,
    };

    var editlist = false;

    count = 100;

    var assistanceTypeList = new List("assistanceTypeList", options);
    // Add event listener to reapply event listeners after pagination changes
    assistanceTypeList.on("updated", function () {
        refreshCallback();
    });

    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            e.relatedTarget.classList.contains("edit-item-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                    "Edit Assistance Type"),
                    (document
                        .getElementById("showModal")
                        .querySelector(".modal-footer").style.display = "block"),
                    (document.getElementById("add-btn").innerHTML = "Update"))
                : e.relatedTarget.classList.contains("add-btn")
                    ? ((document.getElementById("exampleModalLabel").innerHTML =
                        "Add Assistance Type"),
                        (document
                            .getElementById("showModal")
                            .querySelector(".modal-footer").style.display = "block"),
                        (document.getElementById("add-btn").innerHTML =
                            "Add Assistance Type"))
                    : ((document.getElementById("exampleModalLabel").innerHTML =
                        "List Assistance Type"),
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
            var assistanceTypeId = this.getAttribute("data-id"); // Assistance Type ID from data attribute
            var assistanceTypeName = row
                .querySelector(".assistance_type_name")
                .textContent.trim(); // Assistance Type name from the row
            var assistanceTypeDescription = row
                .querySelector(".assistance_type_description")
                .textContent.trim(); // Assista nce Type description from the row

            // Populate the modal fields with the retrieved data
            document.getElementById("id-field").value = assistanceTypeId;
            document.getElementById("assistance_type_name-field").value = assistanceTypeName;
            document.getElementById("assistance_type_description-field").value =
                assistanceTypeDescription;
        });
    });

    // Event listener for edit button click
    document.querySelectorAll(".remove-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var assistanceTypeId = this.getAttribute("data-id");
            document.getElementById("delete-record").setAttribute("data-id", assistanceTypeId);
        });
    });

    document.getElementById("delete-record").addEventListener("click", function () {
        var assistanceTypeId = this.getAttribute("data-id");
        deleteAssistanceType(assistanceTypeId);
    });

    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const assistanceTypeIdField = document.getElementById("id-field").value;
        const assistanceTypeNameField = document.getElementById(
            "assistance_type_name-field"
        ).value;
        const assistanceTypeDescriptionField = document.getElementById(
            "assistance_type_description-field"
        ).value;
        if (form.checkValidity()) {
            if (assistanceTypeIdField !== "") {
                updateAssistanceType(
                    assistanceTypeIdField,
                    assistanceTypeNameField,
                    assistanceTypeDescriptionField
                );
            } else {
                addAssistanceType(assistanceTypeNameField, assistanceTypeDescriptionField);
            }
        } else {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function updateAssistanceType(assistanceTypeId, assistanceTypeName, assistanceTypeDescription) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`assistance-types/${assistanceTypeId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                id: assistanceTypeId,
                name: assistanceTypeName,
                description: assistanceTypeDescription,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    assistanceTypeList.items.forEach(function (item) {
                        if (item.values().assistance_type_id == assistanceTypeId) {
                            item.values({
                                assistance_type_id: assistanceTypeId,
                                assistance_type_name: assistanceTypeName,
                                assistance_type_description: assistanceTypeDescription,
                            });
                        }
                    });
                    closeModalBtn.click();
                    clearFields();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Assistance Type updated successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to update assistance type!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to update assistance type!",
                    showConfirmButton: true,
                });
            });
    }

    function addAssistanceType(assistanceTypeName, assistanceTypeDescription) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/assistance-types", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                name: assistanceTypeName,
                description: assistanceTypeDescription,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data.data.id);
                    assistanceTypeList.add({
                        assistance_type_id: data.data.id,
                        assistance_type_name: assistanceTypeName,
                        assistance_type_description: assistanceTypeDescription,
                    });
                    assistanceTypeList.sort("assistance_type_name", { order: "asc" });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Assistance Type inserted successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to insert assistance type!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to insert assistance type!",
                    showConfirmButton: true,
                });
            });
    }

    function deleteAssistanceType(assistanceTypeId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch(`assistance-types/${assistanceTypeId}`, {
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
                    assistanceTypeList.remove('assistance_type_id', assistanceTypeId);
                    closeModalDelete.click();
                    refreshCallback();
                    Swal.fire(
                        'Deleted!',
                        'Assistance Type has been deleted.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to delete assistance type.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred while deleting the assistance type.',
                    'error'
                );
            });
    }
    var assistanceTypeIdField = document.getElementById("id-field");
    var assistanceTypeNameField = document.getElementById("assistance_type_name-field");
    var assistanceTypeDescriptionField = document.getElementById("assistance_type_description-field");

    function clearFields() {
        (assistanceTypeIdField.value = ""),
            (assistanceTypeNameField.value = ""),
            (assistanceTypeDescriptionField.value = "");
    }

    function refreshCallback() {
        // Event listener for edit button click
        document.querySelectorAll(".edit-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                // Find the closest row to the clicked edit button
                var row = this.closest("tr");

                // Retrieve data from the table row
                var assistanceTypeId = this.getAttribute("data-id"); // Assistance Type ID from data attribute
                var assistanceTypeName = row
                    .querySelector(".assistance_type_name")
                    .textContent.trim(); // Assistance Type name from the row
                var assistanceTypeDescription = row
                    .querySelector(".assistance_type_description")
                    .textContent.trim(); // Assistance Type description from the row

                // Populate the modal fields with the retrieved data
                document.getElementById("id-field").value = assistanceTypeId;
                document.getElementById("assistance_type_name-field").value =
                    assistanceTypeName;
                document.getElementById("assistance_type_description-field").value =
                    assistanceTypeDescription;
            });

            //
        });

        document.querySelectorAll(".remove-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                var assistanceTypeId = this.getAttribute("data-id");
                document.getElementById("delete-record").setAttribute("data-id", assistanceTypeId);
            });
        });

    }

    function clearFields() {
        (assistanceTypeIdField.value = ""),
            (assistanceTypeNameField.value = ""),
            (assistanceTypeDescriptionField.value = "");
    }

    refreshCallback();
});

