document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".tablelist-form");
    const addBtn = document.getElementById("add-btn");
    const closeModalBtn = document.getElementById("close-modal");
    const closeModalDelete = document.getElementById("btn-close");
    var municityIdField = document.getElementById("municity_id-field");
    var barangayIdField = document.getElementById("barangay_id-field");
    var asensoIdField = document.getElementById("asenso_id-field");
    var removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn");

    var options = {
        valueNames: [
            "beneficiary_id",
            "beneficiary_name",
            "asenso_id",
            "sex",
            "birth_date",
            "status"
        ],
        page: 25,
        pagination: true,
    };


    var beneficiaryList = new List("beneficiaryList", options);
    // Add event listener to reapply event listeners after pagination changes
    beneficiaryList.on("updated", function () {
        refreshCallback();
    });

    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            e.relatedTarget.classList.contains("edit-item-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                   "Edit Beneficiary"),
                    (document
                        .getElementById("showModal")
                        .querySelector(".modal-footer").style.display = "block"),
                    (document.getElementById("add-btn").innerHTML = "Update"))
                : e.relatedTarget.classList.contains("add-btn")
                    ? ((document.getElementById("exampleModalLabel").innerHTML =
                        "Add Beneficiary"),
                        (document
                            .getElementById("showModal")
                            .querySelector(".modal-footer").style.display = "block"),
                        (document.getElementById("add-btn").innerHTML =
                            "Add Beneficiary"))
                    : ((document.getElementById("exampleModalLabel").innerHTML =
                        "List Beneficiary"),
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
            var beneficiaryId = this.getAttribute("data-id"); // Barangay ID from data attribute
            /* var barangayName = row
                .querySelector(".barangay_name")
                .textContent.trim(); */ // Barangay name from the row
            //get beneficiary data from /beneficiaries/get/{beneficiaryId}

            // Populate the modal fields with the retrieved data
            beneficiaryIdField.value = beneficiaryId;
            //barangayNameField.value = barangayName;
        });

    });

    // Event listener for edit button click
    document.querySelectorAll(".remove-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var beneficiaryId= this.getAttribute("data-id");
            document.getElementById("delete-record").setAttribute("data-id", beneficiaryId);
        });
    });

    document.getElementById("delete-record").addEventListener("click", function () {
        var beneficiaryId = this.getAttribute("data-id");
        console.log(beneficiaryId);
        deleteBeneficiary(beneficiaryId);
    });

    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const barangayIdField = document.getElementById("barangay_id-field").value;
        const barangayNameField = document.getElementById(
            "barangay_name-field"
        ).value;
        const municityIdField = document.getElementById(
            "municity_id-field"
        ).value;
        if (form.checkValidity()) {
            if (barangayIdField !== "") {
                console.log(barangayIdField, barangayNameField);
                updateBarangay(
                    barangayIdField,
                    barangayNameField
                );
            } else {
                addBarangay(municityIdField, barangayNameField);
            }
        } else {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function updateBeneficiary(beneficiaryId, beneficiaryName) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`/beneficiaries/${beneficiaryId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                id: beneficiaryId,
                name: beneficiaryName,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    beneficiaryList.items.forEach(function (item) {
                        if (item.values().beneficiary_id == beneficiaryId) {
                            item.values({
                                beneficiary_id: beneficiaryId,
                                beneficiary_name: beneficiaryName,
                            });
                        }
                    });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Beneficiary updated successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to update Beneficiary!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to update Beneficiary!",
                    showConfirmButton: true,
                });
            });
    }

    function addBeneficiary(barangayId, beneficiaryName) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/beneficiaries", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                barangay_id: barangayId,
                last_name: beneficiaryName,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data.data.id);
                    beneficiaryList.add({
                        beneficiary_id: data.data.id,
                        beneficiary_name: data.data.last_name,
                    });
                    beneficiaryList.sort("beneficiary_name", { order: "asc" });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Beneficiary inserted successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to insert Beneficiary!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to insert Beneficiary!",
                    showConfirmButton: true,
                });
            });
    }

    function deleteBeneficiary(beneficiaryId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch(`/beneficiaries/${beneficiaryId}`, {
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
                    beneficiaryList.remove('beneficiary_id', beneficiaryId);
                    closeModalDelete.click();
                    refreshCallback();
                    Swal.fire(
                        'Deleted!',
                        'Beneficiary has been deleted.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to delete Beneficiary.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred while deleting the Beneficiary.',
                    'error'
                );
            });
    }

    function clearFields() {
        (barangayIdField.value = ""),
        (beneficiaryIdField.value = ""),
            (beneficiaryNameField.value = "");
    }

    function refreshCallback() {
        // Event listener for edit button click
        document.querySelectorAll(".edit-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                // Find the closest row to the clicked edit button
                var row = this.closest("tr");

                // Retrieve data from the table row
                var beneficiaryId = this.getAttribute("data-id"); // Barangay ID from data attribute
                /* var barangayName = row
                    .querySelector(".barangay_name")
                    .textContent.trim();  */// Barangay name from the row

                // Populate the modal fields with the retrieved data
                beneficiaryIdField.value = beneficiaryId;
               // beneficiaryNameField.value = beneficiaryName;
            });

        });

        document.querySelectorAll(".remove-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                var beneficiaryId = this.getAttribute("data-id");
                document.getElementById("delete-record").setAttribute("data-id", beneficiaryId);
            });
        });

    }


    refreshCallback();
});

