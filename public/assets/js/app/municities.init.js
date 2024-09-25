document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".tablelist-form");
    const addBtn = document.getElementById("add-btn");
    const closeModalBtn = document.getElementById("close-modal");
    const closeModalDelete = document.getElementById("btn-close");
    var municityIdField = document.getElementById("id-field");
    var provinceIdField = document.getElementById("province_id-field");
    var municityNameField = document.getElementById("municity_name-field");
    var municityBrgyCount = document.getElementById("municity_brgy_count-field");
    var removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn");

    var options = {
        valueNames: ["municity_id", "municity_name", "province_id","province_name"],
        page: 10,
        pagination: true,
    };


    var municityList = new List("municityList", options);
    // Add event listener to reapply event listeners after pagination changes
    municityList.on("updated", function () {
        refreshCallback();
    });

    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            e.relatedTarget.classList.contains("edit-item-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                    "Edit Municipality/City"),
                    (document
                        .getElementById("showModal")
                        .querySelector(".modal-footer").style.display = "block"),
                    (document.getElementById("add-btn").innerHTML = "Update"))
                : e.relatedTarget.classList.contains("add-btn")
                    ? ((document.getElementById("exampleModalLabel").innerHTML =
                        "Add Municipality/City"),
                        (document
                            .getElementById("showModal")
                            .querySelector(".modal-footer").style.display = "block"),
                        (document.getElementById("add-btn").innerHTML =
                            "Add Municipality/City"))
                    : ((document.getElementById("exampleModalLabel").innerHTML =
                        "List Municipality/City"),
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
            var municityId = this.getAttribute("data-id"); // Municipality/City ID from data attribute
            var municityName = row
                .querySelector(".municity_name")
                .textContent.trim(); // Municipality/City name from the row
            var provinceId = row
                .querySelector(".province_id")
                .textContent.trim(); // Municipality/City name from the row

            // Populate the modal fields with the retrieved data
            municityIdField.value = municityId;
            municityNameField.value = municityName;
            provinceIdField.value = provinceId;
        });

    });

    // Event listener for edit button click
    document.querySelectorAll(".remove-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var municityId = this.getAttribute("data-id");
            document.getElementById("delete-record").setAttribute("data-id", municityId);
        });
    });

    document.getElementById("delete-record").addEventListener("click", function () {
        var municityId = this.getAttribute("data-id");
        console.log(municityId);
        deleteMunicity(municityId);
    });

    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const provinceIdField = document.getElementById("province_id-field");
        const selectedProvinceId = provinceIdField.value;
        const selectedProvinceText = provinceIdField.options[provinceIdField.selectedIndex].text;
        const municityNameField = document.getElementById(
            "municity_name-field"
        ).value;
        const municityIdField = document.getElementById(
            "municity_id-field"
        ).value;
        if (form.checkValidity()) {
            if (municityIdField !== "") {
                console.log(municityIdField, municityNameField);
                updateMunicity(
                    municityIdField,
                    municityNameField
                );
            } else {
                addMunicity(selectedProvinceId,selectedProvinceText, municityNameField);
            }
        } else {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function updateMunicity(municityId, municityName) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`/municities/${municityId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                id: municityId,
                name: municityName,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    municityList.items.forEach(function (item) {
                        if (item.values().municity_id == municityId) {
                            item.values({
                                municity_id: municityId,
                                municity_name: municityName,
                            });
                        }
                    });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Municipality/City updated successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to update municipality/city!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to update municipality/city!",
                    showConfirmButton: true,
                });
            });
    }

    function addMunicity(provinceId, provinceName, municityName) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/municities", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                province_id: provinceId,
                name: municityName,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data.data);
                    municityList.add({
                        municity_id: data.data.id,
                        municity_name: municityName,
                        province_id: provinceId,
                        province_name: provinceName,
                    });
                    municityList.sort("municity_name", { order: "asc" });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Municipality/City inserted successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to insert municipality/city!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to insert municipality/city!",
                    showConfirmButton: true,
                });
            });
    }

    function deleteMunicity(municityId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        fetch(`/municities/${municityId}`, {
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
                    municityList.remove('municity_id', municityId);
                    closeModalDelete.click();
                    refreshCallback();
                    Swal.fire(
                        'Deleted!',
                        'Municipality/City has been deleted.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to delete municipality/city.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred while deleting the municipality/city.',
                    'error'
                );
            });
    }
    var municityIdField = document.getElementById("municity_id-field");
    var municityNameField = document.getElementById("municity_name-field");

    function clearFields() {
        (municityIdField.value = ""),
            (municityNameField.value = "");
    }

    function refreshCallback() {
        // Event listener for edit button click
        document.querySelectorAll(".edit-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                // Find the closest row to the clicked edit button
                var row = this.closest("tr");

                // Retrieve data from the table row
                var municityId = this.getAttribute("data-id"); // Municipality/City ID from data attribute
                var municityName = row
                    .querySelector(".municity_name")
                    .textContent.trim(); // Municipality/City name from the row

                // Populate the modal fields with the retrieved data
                municityIdField.value = municityId;
                municityNameField.value = municityName;
            });

        });

        document.querySelectorAll(".remove-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                var municityId = this.getAttribute("data-id");
                document.getElementById("delete-record").setAttribute("data-id", municityId);
            });
        });

    }




    refreshCallback();
});

