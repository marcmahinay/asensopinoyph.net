var checkAll = document.getElementById("checkAll"),
    perPage =
        (checkAll &&
            (checkAll.onclick = function () {
                for (
                    var e = document.querySelectorAll(
                            '.form-check-all input[type="checkbox"]'
                        ),
                        t = document.querySelectorAll(
                            '.form-check-all input[type="checkbox"]:checked'
                        ).length,
                        a = 0;
                    a < e.length;
                    a++
                )
                    (e[a].checked = this.checked),
                        e[a].checked
                            ? e[a].closest("tr").classList.add("table-active")
                            : e[a]
                                  .closest("tr")
                                  .classList.remove("table-active");
                document.getElementById("remove-actions").style.display =
                    0 < t ? "none" : "block";
            }),
        8),
    editlist = !1,
    options = {
        valueNames: ["id", "province_name", "province_region"],
        page: perPage,
        pagination: !0,
        plugins: [ListPagination({ left: 2, right: 2 })],
    },
    provinceList = new List("provinceList", options).on(
        "updated",
        function (e) {
            0 == e.matchingItems.length
                ? (document.getElementsByClassName(
                      "noresult"
                  )[0].style.display = "block")
                : (document.getElementsByClassName(
                      "noresult"
                  )[0].style.display = "none");
            var t = 1 == e.i,
                a = e.i > e.matchingItems.length - e.page;
            document.querySelector(".pagination-prev.disabled") &&
                document
                    .querySelector(".pagination-prev.disabled")
                    .classList.remove("disabled"),
                document.querySelector(".pagination-next.disabled") &&
                    document
                        .querySelector(".pagination-next.disabled")
                        .classList.remove("disabled"),
                t &&
                    document
                        .querySelector(".pagination-prev")
                        .classList.add("disabled"),
                a &&
                    document
                        .querySelector(".pagination-next")
                        .classList.add("disabled"),
                e.matchingItems.length <= perPage
                    ? (document.querySelector(
                          ".pagination-wrap"
                      ).style.display = "none")
                    : (document.querySelector(
                          ".pagination-wrap"
                      ).style.display = "flex"),
                0 < e.matchingItems.length
                    ? (document.getElementsByClassName(
                          "noresult"
                      )[0].style.display = "none")
                    : (document.getElementsByClassName(
                          "noresult"
                      )[0].style.display = "block");
        }
    );



var isValue = (isCount = new DOMParser().parseFromString(
        provinceList.items.slice(-1)[0]._values.id,
        "text/html"
    )).body.firstElementChild.innerHTML,
    idField = document.getElementById("id-field"),
    provinceNameField = document.getElementById("province_name-field"),
    provinceRegionField = document.getElementById("province_region-field"),
    addBtn = document.getElementById("add-btn"),
    editBtn = document.getElementById("edit-btn"),
    removeBtns = document.getElementsByClassName("remove-item-btn"),
    editBtns = document.getElementsByClassName("edit-item-btn"),
    table =
        (refreshCallbacks(),
        document
            .getElementById("showModal")
            .addEventListener("show.bs.modal", function (e) {
                e.relatedTarget.classList.contains("edit-item-btn")
                    ? ((document.getElementById("exampleModalLabel").innerHTML =
                          "Edit Province"),
                      (document
                          .getElementById("showModal")
                          .querySelector(".modal-footer").style.display =
                          "block"),
                      (document.getElementById("add-btn").innerHTML = "Update"))
                    : e.relatedTarget.classList.contains("add-btn")
                    ? ((document.getElementById("exampleModalLabel").innerHTML =
                          "Add Province"),
                      (document
                          .getElementById("showModal")
                          .querySelector(".modal-footer").style.display =
                          "block"),
                      (document.getElementById("add-btn").innerHTML =
                          "Add Province"))
                    : ((document.getElementById("exampleModalLabel").innerHTML =
                          "List Province"),
                      (document
                          .getElementById("showModal")
                          .querySelector(".modal-footer").style.display =
                          "none"));
            }),
        ischeckboxcheck(),
        document
            .getElementById("showModal")
            .addEventListener("hidden.bs.modal", function () {
                clearFields();
            }),
        document
            .querySelector("#provinceList")
            .addEventListener("click", function () {
                ischeckboxcheck();
            }),
        document.getElementById("customerTable")),
    tr = table.getElementsByTagName("tr"),
    trlist = table.querySelectorAll(".list tr"),
    count = 11,
    forms = document.querySelectorAll(".tablelist-form");

function ischeckboxcheck() {
    Array.from(document.getElementsByName("chk_child")).forEach(function (a) {
        a.addEventListener("change", function (e) {
            1 == a.checked
                ? e.target.closest("tr").classList.add("table-active")
                : e.target.closest("tr").classList.remove("table-active");
            var t = document.querySelectorAll(
                '[name="chk_child"]:checked'
            ).length;
            e.target.closest("tr").classList.contains("table-active"),
                (document.getElementById("remove-actions").style.display =
                    0 < t ? "block" : "none");
        });
    });
}
function refreshCallbacks() {
    removeBtns &&
        Array.from(removeBtns).forEach(function (e) {
            e.addEventListener("click", function (e) {
                e.target.closest("tr").children[1].innerText,
                    (itemId = e.target.closest("tr").children[1].innerText);
                e = provinceList.get({ id: itemId });
                Array.from(e).forEach(function (e) {
                    var t = (deleteid = new DOMParser().parseFromString(
                        e._values.id,
                        "text/html"
                    )).body.firstElementChild;
                    deleteid.body.firstElementChild.innerHTML == itemId &&
                        document
                            .getElementById("delete-record")
                            .addEventListener("click", function () {
                                provinceList.remove("id", t.outerHTML),
                                    document
                                        .getElementById("deleteRecord-close")
                                        .click();
                            });
                });
            });
        }),
        editBtns &&
            Array.from(editBtns).forEach(function (e) {
                e.addEventListener("click", function (e) {
                    e.target.closest("tr").children[1].innerText,
                        (itemId = e.target.closest("tr").children[1].innerText);
                    e = provinceList.get({ id: itemId });
                    Array.from(e).forEach(function (e) {
                        var t = (isid = new DOMParser().parseFromString(
                                e._values.id,
                                "text/html"
                            )).body.firstElementChild.innerHTML;

                        t == itemId &&
                            ((editlist = !0),
                            (idField.value = t),
                            (provinceNameField.value = e._values.province_name),
                            (provinceRegionField.value = e._values.province_region));
                    });
                });
            });
}
function clearFields() {
    (provinceNameField.value = ""),
        (provinceRegionField.value = "");
}
function deleteMultiple() {
    ids_array = [];
    var e,
        t = document.getElementsByName("chk_child");
    for (i = 0; i < t.length; i++)
        1 == t[i].checked &&
            ((e =
                t[i].parentNode.parentNode.parentNode.querySelector(
                    "td a"
                ).innerHTML),
            ids_array.push(e));
    "undefined" != typeof ids_array && 0 < ids_array.length
        ? Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: !0,
              confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
              cancelButtonClass: "btn btn-danger w-xs mt-2",
              confirmButtonText: "Yes, delete it!",
              buttonsStyling: !1,
              showCloseButton: !0,
          }).then(function (e) {
              if (e.value) {
                  for (i = 0; i < ids_array.length; i++)
                      provinceList.remove(
                          "id",
                          `<a href="javascript:void(0);" class="fw-medium link-primary">${ids_array[i]}</a>`
                      );
                  (document.getElementById("remove-actions").style.display =
                      "none"),
                      (document.getElementById("checkAll").checked = !1),
                      Swal.fire({
                          title: "Deleted!",
                          text: "Your data has been deleted.",
                          icon: "success",
                          confirmButtonClass: "btn btn-info w-xs mt-2",
                          buttonsStyling: !1,
                      });
              }
          })
        : Swal.fire({
              title: "Please select at least one checkbox",
              confirmButtonClass: "btn btn-info",
              buttonsStyling: !1,
              showCloseButton: !0,
          });
}
Array.prototype.slice.call(forms).forEach(function (l) {
    l.addEventListener(
        "submit",
        function (e) {
            var t, a;
            l.checkValidity()
                ? (e.preventDefault(),
                  "" === provinceNameField.value ||
                  "" === provinceRegionField.value ||
                  editlist
                      ? "" !== provinceNameField.value &&
                        "" !== provinceRegionField.value &&
                        editlist &&
                        ((t = provinceList.get({ id: idField.value })),
                        Array.from(t).forEach(function (e) {
                            var t = (isid = new DOMParser().parseFromString(
                                    e._values.id,
                                    "text/html"
                                )).body.firstElementChild.innerHTML;
                            Array.from(a).forEach((e, t) => {
                                l +=
                                    '<span class="badge bg-primary-subtle text-primary me-1">' +
                                    e +
                                    "</span>";
                            }),
                                t == itemId &&
                                    e.values({
                                        id:
                                            '<a href="javascript:void(0);" class="fw-medium link-primary">' +
                                            idField.value +
                                            "</a>",
                                        province_name: provinceNameField.value,
                                        province_region: provinceRegionField.value,
                                    });
                        }),
                        document.getElementById("close-modal").click(),
                        clearFields(),
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Lead updated Successfully!",
                            showConfirmButton: !1,
                            timer: 2e3,
                            showCloseButton: !0,
                        }))
                      : ((t = tagInputField.getValue(!0)),
                        (a = ""),
                        Array.from(t).forEach((e, t) => {
                            a +=
                                '<span class="badge bg-primary-subtle text-primary me-1">' +
                                e +
                                "</span>";
                        }),
                        provinceList.add({
                            id:
                                '<a href="javascript:void(0);" class="fw-medium link-primary">#VZ' +
                                count +
                                "</a>",
                            image_src: leadImg.src,
                            name: leadNameField.value,
                            company_name: company_nameField.value,
                            date: formatDate(dateField.value),
                            leads_score: leads_scoreField.value,
                            phone: phoneField.value,
                            location: locationField.value,
                            tags: a,
                        }),
                        provinceList.sort("id", { order: "desc" }),
                        document.getElementById("close-modal").click(),
                        clearFields(),
                        refreshCallbacks(),
                        count++,
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Lead inserted successfully!",
                            showConfirmButton: !1,
                            timer: 2e3,
                            showCloseButton: !0,
                        })))
                : (e.preventDefault(), e.stopPropagation());
        },
        !1
    );
}),
    document
        .querySelector(".pagination-next")
        .addEventListener("click", function () {
            document.querySelector(".pagination.listjs-pagination") &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active") &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active")
                    .nextElementSibling.children[0].click();
        }),
    document
        .querySelector(".pagination-prev")
        .addEventListener("click", function () {
            document.querySelector(".pagination.listjs-pagination") &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active") &&
                document
                    .querySelector(".pagination.listjs-pagination")
                    .querySelector(".active")
                    .previousSibling.children[0].click();
        });
