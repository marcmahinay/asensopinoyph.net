document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // Use event delegation for both receive and cancel actions
    document.addEventListener("click", function(event) {
        if (event.target.classList.contains("receive-assistance")) {
            handleReceiveAssistance(event.target);
        } else if (event.target.classList.contains("cancel-assistance")) {
            handleCancelAssistance(event.target);
        }
    });

    function handleReceiveAssistance(button) {
        const eventId = button.getAttribute("data-event-id");
        const beneficiaryId = button.getAttribute("data-beneficiary-id");
        const cancelDiv = document.getElementById("cancel-"+eventId);
        const claimeDiv = document.getElementById("claime-"+eventId);
        const assistanceReceived = document.getElementById("received");

        console.log("textcontet",assistanceReceived.textContent);

        fetch("/assistance/receive", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                event_id: eventId,
                beneficiary_id: beneficiaryId,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    //button.outerHTML = `<span class="badge bg-success">Availed</span>`;
                    const newReceiveButton = `<button type="button" class="btn btn-soft-success waves-effect claimed-assistance">Claimed</button>`;
                    const newCanceButton = `<button class="btn btn-sm btn-danger cancel-assistance" data-beneficiary-id="${beneficiaryId}" data-event-id="${eventId}" id="cancel-assistance-${eventId}">Cancel</button>`;
                    cancelDiv.innerHTML = newCanceButton;
                    claimeDiv.innerHTML = newReceiveButton;
                    assistanceReceived.textContent = parseInt(assistanceReceived.textContent) + 1; // Increment by 1
                    //button.outerHTML =  `<button class="btn btn-sm btn-warning cancel-assistance" data-event-id="${eventId}" data-beneficiary-id="${beneficiaryId}">Cancel</button>`;
                    //alert("Assistance received successfully!");
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Assistance received!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred while processing your request.");
            });
    }

    function handleCancelAssistance(button) {
        const eventId = button.getAttribute("data-event-id");
        const beneficiaryId = button.getAttribute("data-beneficiary-id");
        const cancelDiv = document.getElementById("cancel-"+eventId);
        const claimeDiv = document.getElementById("claime-"+eventId);
        const assistanceReceived = document.getElementById("received");
        //console.log('text content', assistanceReceived.textContent);

        fetch("/assistance/cancel", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                event_id: eventId,
                beneficiary_id: beneficiaryId,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    const newAvailButton = `<button class="btn btn-primary receive-assistance" data-event-id="${eventId}" data-beneficiary-id="${beneficiaryId}">Claim Assistance</button>`;
                    claimeDiv.innerHTML = newAvailButton;
                    cancelDiv.innerHTML = "";
                    assistanceReceived.textContent = parseInt(assistanceReceived.textContent) - 1;
                    Swal.fire({
                        position: "center",
                        icon: "warning",
                        title: "Assistance Cancelled!",
                        showConfirmButton: false,
                        timer: 2000,
                        showCloseButton: true,
                    });
                } else {
                    console.error("Server reported failure:", data.message);
                    alert("Failed to cancel assistance: " + data.message);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("An error occurred while processing the cancellation: " + error.message);
            });
    }
});
