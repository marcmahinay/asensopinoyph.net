document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".tablelist-form");
    const addBtn = document.getElementById("add-btn");
    const closeModalBtn = document.getElementById("close-modal");
    const closeModalDelete = document.getElementById("btn-close");

    var removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn");

    var options = {
        valueNames: [
            "event_id",
            "event_name",
            "event_venue",
            "event_date",
            "event_date_fmt",
            "event_amount",
            "assistance_type_name",
            "event_notes",
        ],
        page: 20,
        pagination: true,
    };

    var editlist = false;

    count = 100;

    var eventList = new List("eventList", options);
    // Add event listener to reapply event listeners after pagination changes
    eventList.on("updated", function () {
        refreshCallback();
    });

    document
        .getElementById("showModal")
        .addEventListener("show.bs.modal", function (e) {
            clearFields();
            e.relatedTarget.classList.contains("edit-item-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                      "Edit Event"),
                  (document
                      .getElementById("showModal")
                      .querySelector(".modal-footer").style.display = "block"),
                  (document.getElementById("add-btn").innerHTML = "Update"))
                : e.relatedTarget.classList.contains("add-btn")
                ? ((document.getElementById("exampleModalLabel").innerHTML =
                      "Add Event"),
                  (document
                      .getElementById("showModal")
                      .querySelector(".modal-footer").style.display = "block"),
                  (document.getElementById("add-btn").innerHTML = "Add Event"))
                : ((document.getElementById("exampleModalLabel").innerHTML =
                      "List Event"),
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
            var eventId = this.getAttribute("data-id"); // Assistance Type ID from data attribute
            var assistanceTypeName = row
                .querySelector(".assistance_type_name")
                .textContent.trim(); // Assistance Type name from the row
            var eventName = row.querySelector(".event_name").textContent.trim(); // Assista nce Type description from the row
            var eventDate = row.querySelector(".event_date").textContent.trim(); // Assista nce Type description from the row
            const eventDatePart = eventDate.split(" ")[0];
            var eventVenue = row
                .querySelector(".event_venue")
                .textContent.trim(); // Assista nce Type description from the row
            var eventAmountElement = row.querySelector(".event_amount");
            var eventAmount = eventAmountElement
                ? eventAmountElement.textContent.trim()
                : ""; // Check if element exists
            var eventNotesElement = row.querySelector(".event_notes");
            var eventNotes = eventNotesElement
                ? eventNotesElement.textContent.trim()
                : ""; // Check if element exists
            console.log("event date:", eventDate);
            // Populate the modal fields with the retrieved data
            document.getElementById("id-field").value = eventId;

            // ... existing code ...
            var selectElement = document.getElementById(
                "assistance_type_name-field"
            );
            Array.from(selectElement.options).forEach((option) => {
                if (option.text === assistanceTypeName) {
                    option.selected = true; // Select the option if the text matches
                }
            });
            // ... existing code ...
            const formattedNumber = eventAmount.replace(/,/g, ""); // "50000.00"
            document.getElementById("event_name-field").value = eventName;
            document.getElementById("event_date-field").value = eventDatePart;
            document.getElementById("event_venue-field").value = eventVenue;
            document.getElementById("event_notes-field").value = eventNotes;
            document.getElementById("event_amount-field").value =
                formattedNumber;
        });
    });

    // Event listener for edit button click
    document.querySelectorAll(".remove-item-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            var eventId = this.getAttribute("data-id");
            document
                .getElementById("delete-record")
                .setAttribute("data-id", eventId);
        });
    });

    document
        .getElementById("delete-record")
        .addEventListener("click", function () {
            var eventId = this.getAttribute("data-id");
            deleteEvent(eventId);
        });

    document
        .getElementById("showModal")
        .addEventListener("hidden.bs.modal", function () {
            clearFields();
        });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const eventIdField = document.getElementById("id-field").value;
        const assistanceType = document.getElementById(
            "assistance_type_name-field"
        );
        const assistanceTypeNameField =
            assistanceType.options[assistanceType.selectedIndex].text; // Get the selected text
        const assistanceTypeValueField = assistanceType.value;
        const eventNameField =
            document.getElementById("event_name-field").value;
        const eventVenueField =
            document.getElementById("event_venue-field").value;
        const eventDateField =
            document.getElementById("event_date-field").value;
        const eventAmountField =
            document.getElementById("event_amount-field").value;
        const eventNotesField =
            document.getElementById("event_notes-field").value;

        console.log(
            eventNameField,
            eventVenueField,
            eventDateField,
            eventAmountField,
            eventNotesField,
            assistanceTypeValueField
        );

        if (form.checkValidity()) {
            if (eventIdField !== "") {
                updateEvent(
                    eventIdField,
                    assistanceTypeValueField,
                    assistanceTypeNameField,
                    eventNameField,
                    eventVenueField,
                    eventDateField,
                    eventAmountField,
                    eventNotesField
                );
            } else {
                addEvent(
                    assistanceTypeValueField,
                    assistanceTypeNameField,
                    eventNameField,
                    eventVenueField,
                    eventDateField,
                    eventAmountField,
                    eventNotesField
                );
            }
        } else {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function updateEvent(
        eventId,
        assistanceTypeValueField,
        assistanceTypeNameField,
        eventNameField,
        eventVenueField,
        eventDateField,
        eventAmountField,
        eventNotesField
    ) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        fetch(`assistance-schedule/${eventId}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                id: eventId,
                assistance_type_id: assistanceTypeValueField,
                event_name: eventNameField,
                venue: eventVenueField,
                event_date: eventDateField,
                amount: eventAmountField,
                notes: eventNotesField,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data);
                    eventList.items.forEach(function (item) {
                        if (item.values().event_id == eventId) {
                            item.values({
                                event_id: eventId,
                                assistance_type_name: assistanceTypeNameField,
                                event_name: eventNameField,
                                event_venue: eventVenueField,
                                event_date: eventDateField,
                                event_date_fmt: new Date(
                                    eventDateField
                                ).toLocaleDateString("en-US", {
                                    year: "numeric",
                                    month: "short",
                                    day: "numeric",
                                }),
                                //event_amount: eventAmountField,
                                event_amount:
                                    parseFloat(
                                        eventAmountField
                                    ).toLocaleString(),
                                event_notes: eventNotesField,
                            });
                        }
                    });
                    closeModalBtn.click();
                    clearFields();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Event updated successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to update event!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to update event!",
                    showConfirmButton: true,
                });
            });
    }

    function addEvent(
        assistanceTypeValueField,
        assistanceTypeNameField,
        eventNameField,
        eventVenueField,
        eventDateField,
        eventAmountField,
        eventNotesField
    ) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        fetch("/assistance-schedule", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                assistance_type_id: assistanceTypeValueField,
                event_name: eventNameField,
                venue: eventVenueField,
                event_date: eventDateField,
                amount: eventAmountField,
                notes: eventNotesField,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(data.data.id);
                    eventList.add({
                        event_id: data.data.id,
                        assistance_type_name: assistanceTypeNameField,
                        event_name: eventNameField,
                        event_venue: eventVenueField,
                        event_date: eventDateField,
                        event_date_fmt: new Date(
                            eventDateField
                        ).toLocaleDateString("en-US", {
                            year: "numeric",
                            month: "short",
                            day: "numeric",
                        }),
                        //event_amount: eventAmountField,
                        event_amount:
                            parseFloat(eventAmountField).toLocaleString(),
                        event_notes: eventNotesField,
                    });
                    eventList.sort("event_date", { order: "desc" });
                    closeModalBtn.click();
                    clearFields();
                    refreshCallback();
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Event Schedule added successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Failed to add event schedule!",
                        showConfirmButton: true,
                    });
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Failed to add event schedule!",
                    showConfirmButton: true,
                });
            });
    }

    function deleteEvent(eventId) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content");

        if (!csrfToken) {
            console.error("CSRF token not found");
            return;
        }

        fetch(`assistance-schedule/${eventId}`, {
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
                    console.log(data);
                    eventList.remove("event_id", eventId);
                    closeModalDelete.click();
                    refreshCallback();
                    Swal.fire(
                        "Deleted!",
                        "Event Schedule has been deleted.",
                        "success"
                    );
                } else {
                    Swal.fire(
                        "Error!",
                        "Failed to delete Event Shedule.",
                        "error"
                    );
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire(
                    "Error!",
                    "An error occurred while deleting the event schedule.",
                    "error"
                );
            });
    }


    function clearFields() {
        // Retrieve values inside the function to ensure they are current
        var eventIdField = document.getElementById("id-field");
        var assistanceType = document.getElementById("assistance_type_name-field");
        var eventNameField = document.getElementById("event_name-field");
        var eventVenueField = document.getElementById("event_venue-field");
        var eventDateField = document.getElementById("event_date-field");
        var eventAmountField = document.getElementById("event_amount-field");
        var eventNotesField = document.getElementById("event_notes-field");

        // Clear the fields
        eventIdField.value = "";
        assistanceType.value = "";
        eventNameField.value = "";
        eventVenueField.value = "";
        eventDateField.value = "";
        eventAmountField.value = "";
        eventNotesField.value = "";
    }

    function refreshCallback() {
        // Event listener for edit button click
        document.querySelectorAll(".edit-item-btn").forEach(function (button) {
            button.addEventListener("click", function () {
                // Find the closest row to the clicked edit button
                var row = this.closest("tr");

                // Retrieve data from the table row
                var eventId = this.getAttribute("data-id"); // Assistance Type ID from data attribute
                var assistanceTypeName = row
                    .querySelector(".assistance_type_name")
                    .textContent.trim(); // Assistance Type name from the row
                var eventName = row
                    .querySelector(".event_name")
                    .textContent.trim(); // Assista nce Type description from the row
                var eventDate = row
                    .querySelector(".event_date")
                    .textContent.trim(); // Assista nce Type description from the row
                const eventDatePart = eventDate.split(" ")[0];
                var eventVenue = row
                    .querySelector(".event_venue")
                    .textContent.trim(); // Assista nce Type description from the row
                var eventAmountElement = row.querySelector(".event_amount");
                var eventAmount = eventAmountElement
                    ? eventAmountElement.textContent.trim()
                    : ""; // Check if element exists
                var eventNotesElement = row.querySelector(".event_notes");
                var eventNotes = eventNotesElement
                    ? eventNotesElement.textContent.trim()
                    : ""; // Check if element exists
                console.log("event date:", eventDate);
                // Populate the modal fields with the retrieved data
                document.getElementById("id-field").value = eventId;

                // ... existing code ...
                var selectElement = document.getElementById(
                    "assistance_type_name-field"
                );
                Array.from(selectElement.options).forEach((option) => {
                    if (option.text === assistanceTypeName) {
                        option.selected = true; // Select the option if the text matches
                    }
                });
                // ... existing code ...
                const formattedNumber = eventAmount.replace(/,/g, ""); // "50000.00"
                document.getElementById("event_name-field").value = eventName;
                document.getElementById("event_date-field").value =
                    eventDatePart;
                document.getElementById("event_venue-field").value = eventVenue;
                document.getElementById("event_notes-field").value = eventNotes;
                document.getElementById("event_amount-field").value =
                    formattedNumber;
            });
        });

        document
            .querySelectorAll(".remove-item-btn")
            .forEach(function (button) {
                button.addEventListener("click", function () {
                    var eventId = this.getAttribute("data-id");
                    document
                        .getElementById("delete-record")
                        .setAttribute("data-id", eventId);
                });
            });
    }

    refreshCallback();
});
