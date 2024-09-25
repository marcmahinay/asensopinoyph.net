document.addEventListener("DOMContentLoaded", function () {
    var options = {
        valueNames: [
            "beneficiary_id",
            "beneficiary_name",
            "barangay_name",
            "asenso_id",
            "sex",
            "birth_date",
            "status",
        ],
        item: `<tr>
        <th scope="row">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="chk_child" value="">
            </div>
        </th>
        <td class="beneficiary_id" style="display:none;"></td>
        <td class="beneficiary_name">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <img src="" alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                </div>
                <div class="flex-grow-1 ms-2 name"></div>
            </div>
        </td>
        <td class="barangay_name"></td>
        <td class="asenso_id"></td>
        <td class="sex"></td>
        <td class="birth_date"></td>
        <td class="status"><span class="badge"></span></td>
        <td>
           <ul class="list-inline hstack gap-2 mb-0">
                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                    <a class="beneficiary-link" href=""><i class="ri-eye-fill align-bottom text-muted"></i></a>
                </li>
            </ul>
        </td>
    </tr>`,
    };

    var beneficiaryList = new List("beneficiaryList", options);

    const searchInput = document.getElementById("searchBeneficiary");
    const beneficiaryTableBody = document.getElementById(
        "beneficiaryTableBody"
    );

    searchInput.addEventListener("keyup", function () {
        const query = this.value.trim();

        // Only proceed if the query is at least 3 characters long
        if (query.length < 3) {
            beneficiaryList.search();
            return;
        }

        fetch(`/beneficiaries/search?query=${encodeURIComponent(query)}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                beneficiaryList.clear();
                data.forEach((beneficiary) => {
                    beneficiaryList.add({
                        beneficiary_id: beneficiary.id,
                        beneficiary_name: `
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="${
                                        beneficiary.image_path ||
                                        "https://via.placeholder.com/128?text=No+Image"
                                    }"
                                        alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                                </div>
                                <div class="flex-grow-1 ms-2 name">
                                    ${
                                        beneficiary.last_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        beneficiary.last_name
                                            .slice(1)
                                            .toLowerCase()
                                    },
                                    ${
                                        beneficiary.first_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        beneficiary.first_name
                                            .slice(1)
                                            .toLowerCase()
                                    }
                                     ${
                                         beneficiary.middle_name
                                             ? beneficiary.middle_name
                                                   .charAt(0)
                                                   .toUpperCase() + "."
                                             : ""
                                     }
                                </div>
                            </div>`,
                        barangay_name: `${beneficiary.barangay.name}, ${beneficiary.barangay.municity.name}, ${beneficiary.barangay.municity.province.name}`,
                        asenso_id: beneficiary.asenso_id,
                        sex: beneficiary.sex,
                        birth_date: beneficiary.birth_date,
                        status: `<span class="badge ${
                            beneficiary.status == 1 ? "bg-success" : "bg-danger"
                        }">
                            ${beneficiary.status == 1 ? "Active" : "Inactive"}
                        </span>`,
                        actions: `
                            <ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a class="beneficiary-link" href=""><i class="ri-eye-fill align-bottom text-muted"></i></a>
                                </li>
                            </ul>`,
                    });

                    // Set the href attribute for the newly added item
                    const lastItem =
                        beneficiaryList.items[beneficiaryList.items.length - 1];
                    const link =
                        lastItem.elm.querySelector(".beneficiary-link");
                    if (link) {
                        link.href = `/beneficiaries/${beneficiary.id}`;
                    }
                });
                beneficiaryList.update();
            })
            .catch((error) => console.error("Error:", error));
    });

    /*   searchInput.addEventListener("keyup", function () {
        const query = this.value.trim();

        // Only proceed if the query is at least 3 characters long
        if (query.length < 3) {
            beneficiaryTableBody.innerHTML = ""; // Clear the table if less than 3 characters
            return;
        }
        console.log("Searching for:", query);

        fetch(`/beneficiary/search?query=${encodeURIComponent(query)}`, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                beneficiaryTableBody.innerHTML = "";
                data.forEach((beneficiary) => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <th scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="chk_child" value="${
                                    beneficiary.id
                                }">
                            </div>
                        </th>
                        <td class="beneficiary_id" style="display:none;">${
                            beneficiary.id
                        }</td>
                        <td class="beneficiary_name">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="${
                                        beneficiary.image_path
                                            ? beneficiary.image_path
                                            : "https://via.placeholder.com/128?text=No+Image"
                                    }"
                                        alt="" class="avatar-xxs rounded-circle image_src object-fit-cover">
                                </div>
                                <div class="flex-grow-1 ms-2 name">
                                    ${
                                        beneficiary.last_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        beneficiary.last_name
                                            .slice(1)
                                            .toLowerCase()
                                    },
                                    ${
                                        beneficiary.first_name
                                            .charAt(0)
                                            .toUpperCase() +
                                        beneficiary.first_name
                                            .slice(1)
                                            .toLowerCase()
                                    }
                                    ${beneficiary.middle_name
                                        .charAt(0)
                                        .toUpperCase()}.
                                </div>
                            </div>
                        </td>
                        <td class="barangay_name">${
                            beneficiary.barangay.name
                        }, ${beneficiary.barangay.municity.name}, ${
                        beneficiary.barangay.municity.province.name
                    }</td>
                        <td class="asenso_id">${beneficiary.asenso_id}</td>
                        <td class="sex">${beneficiary.sex}</td>
                        <td class="birth_date">${beneficiary.birth_date}</td>
                        <td class="status"><span class="badge ${
                            beneficiary.status == 1 ? "bg-success" : "bg-danger"
                        }">
                            ${beneficiary.status == 1 ? "Active" : "Inactive"}
                        </span></td>
                        <td>
                            <ul class="list-inline hstack gap-2 mb-0">
                                <li class="list-inline-item" data-bs-toggle="tooltip"
                                    data-bs-trigger="hover" data-bs-placement="top" title="View">
                                    <a href="/beneficiaries/${
                                        beneficiary.id
                                    }"><i
                                            class="ri-eye-fill align-bottom text-muted"></i></a>
                                </li>
                            </ul>
                        </td>
                    `;
                    beneficiaryTableBody.appendChild(row);
                });
            })
            .catch((error) => console.error("Error:", error));
    }); */
});
