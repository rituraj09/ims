// public/assets/js/app.js

"use strict";

/* ================================================
   GOVasset - Main Application JavaScript
================================================ */

const GovAsset = {
    /* ── Init ─────────────────────────────────── */
    init() {
        this.sidebar();
        this.toastr();
        this.select2();
        this.datepicker();
        this.datatables();
        this.deleteConfirm();
        this.tooltips();
        this.formValidation();
        this.characterCount();
        this.numberFormat();
    },

    /* ── SIDEBAR ──────────────────────────────── */
    sidebar() {
        const el = document.getElementById("sidebar");
        const overlay = document.getElementById("sbOverlay");
        const toggle = document.getElementById("sbToggle");
        const LS_KEY = "govAsset_sb";
        const MOBILE = () => window.innerWidth < 992;

        if (!el || !toggle) return;

        const openMobile = () => {
            el.classList.add("open");
            if (overlay) overlay.classList.add("active");
            document.body.style.overflow = "hidden";
        };

        const closeMobile = () => {
            el.classList.remove("open");
            if (overlay) overlay.classList.remove("active");
            document.body.style.overflow = "";
        };

        const toggleDesktop = () => {
            const isCollapsed = document.body.classList.toggle("sb-collapsed");
            localStorage.setItem(LS_KEY, isCollapsed ? "1" : "0");
        };

        toggle.addEventListener("click", () => {
            MOBILE()
                ? el.classList.contains("open")
                    ? closeMobile()
                    : openMobile()
                : toggleDesktop();
        });

        if (overlay) overlay.addEventListener("click", closeMobile);

        window.addEventListener("resize", () => {
            if (!MOBILE()) closeMobile();
        });

        // Restore
        if (!MOBILE() && localStorage.getItem(LS_KEY) === "1") {
            document.body.classList.add("sb-collapsed");
        }
    },

    /* ── TOASTR ───────────────────────────────── */
    toastr() {
        if (typeof toastr === "undefined") return;

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 4500,
            extendedTimeOut: 1000,
            preventDuplicates: true,
            newestOnTop: true,
        };
    },

    /* ── SELECT2 ──────────────────────────────── */
    select2() {
        if (typeof $.fn.select2 === "undefined") return;

        // Standard
        $("select.select2").select2({
            theme: "bootstrap-5",
            width: "100%",
            allowClear: true,
        });

        // No search
        $("select.select2-basic").select2({
            theme: "bootstrap-5",
            width: "100%",
            allowClear: true,
            minimumResultsForSearch: Infinity,
        });

        // AJAX
        $("select.select2-ajax").each(function () {
            const url = $(this).data("url");
            const placeholder = $(this).data("placeholder") || "Search...";
            const minChars = $(this).data("min-chars") || 0;

            $(this).select2({
                theme: "bootstrap-5",
                width: "100%",
                allowClear: true,
                placeholder: placeholder,
                minimumInputLength: minChars,
                ajax: {
                    url: url,
                    dataType: "json",
                    delay: 300,
                    data: (params) => ({
                        search: params.term,
                        page: params.page || 1,
                    }),
                    processResults: (data) => ({
                        results: data.data,
                        pagination: { more: !!data.next_page_url },
                    }),
                    cache: true,
                },
            });
        });
    },

    /* ── DATE PICKER ─────────────────────────── */
    datepicker() {
        if (typeof flatpickr === "undefined") return;

        flatpickr(".datepicker", {
            dateFormat: "d/m/Y",
            allowInput: true,
            disableMobile: false,
        });

        flatpickr(".datetimepicker", {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            allowInput: true,
        });

        flatpickr(".datepicker-future", {
            dateFormat: "d/m/Y",
            allowInput: true,
            minDate: "today",
        });

        flatpickr(".datepicker-past", {
            dateFormat: "d/m/Y",
            allowInput: true,
            maxDate: "today",
        });
    },

    /* ── DATATABLES ──────────────────────────── */
    datatables() {
        if (typeof $.fn.DataTable === "undefined") return;

        $("table.datatable").each(function () {
            if ($.fn.DataTable.isDataTable(this)) return;

            const hasExport = $(this).hasClass("dt-export");
            const order = $(this).data("order") || [[0, "desc"]];
            const length = parseInt($(this).data("length")) || 25;

            const buttons = hasExport
                ? [
                      {
                          extend: "collection",
                          text: '<i class="fas fa-download me-1"></i>Export',
                          className: "btn btn-outline-secondary btn-sm",
                          buttons: [
                              {
                                  extend: "excel",
                                  className: "dropdown-item",
                                  text: '<i class="fas fa-file-excel me-2 text-success"></i>Excel',
                              },
                              {
                                  extend: "pdf",
                                  className: "dropdown-item",
                                  text: '<i class="fas fa-file-pdf me-2 text-danger"></i>PDF',
                              },
                              {
                                  extend: "csv",
                                  className: "dropdown-item",
                                  text: '<i class="fas fa-file-csv me-2 text-info"></i>CSV',
                              },
                              {
                                  extend: "print",
                                  className: "dropdown-item",
                                  text: '<i class="fas fa-print me-2"></i>Print',
                              },
                          ],
                      },
                  ]
                : [];

            $(this).DataTable({
                responsive: true,
                pageLength: length,
                order: order,
                buttons: buttons,
                language: {
                    search: "",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No records found",
                    emptyTable: "No data available",
                    paginate: {
                        previous: '<i class="fas fa-chevron-left"></i>',
                        next: '<i class="fas fa-chevron-right"></i>',
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                    },
                },
                dom: hasExport
                    ? "<'row mb-2'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>><'row'<'col-12'tr>><'row mt-2'<'col-sm-5'i><'col-sm-7'p>>"
                    : "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-12'tr>><'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",
            });
        });
    },

    /* ── DELETE CONFIRM ──────────────────────── */
    deleteConfirm() {
        document.addEventListener("click", function (e) {
            const btn = e.target.closest("[data-confirm]");
            if (!btn) return;
            e.preventDefault();

            const form = btn.closest("form");
            const message =
                btn.getAttribute("data-confirm") ||
                "This action cannot be undone!";
            const title =
                btn.getAttribute("data-confirm-title") || "Confirm Delete";

            if (typeof Swal !== "undefined") {
                Swal.fire({
                    title,
                    text: message,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ef4444",
                    cancelButtonColor: "#94a3b8",
                    confirmButtonText:
                        '<i class="fas fa-trash me-1"></i>Delete',
                    cancelButtonText: "Cancel",
                    reverseButtons: true,
                    focusCancel: true,
                }).then((r) => {
                    if (r.isConfirmed && form) form.submit();
                });
            } else {
                if (confirm(title + "\n" + message) && form) form.submit();
            }
        });
    },

    /* ── TOOLTIPS ────────────────────────────── */
    tooltips() {
        document
            .querySelectorAll('[data-bs-toggle="tooltip"]')
            .forEach((el) => new bootstrap.Tooltip(el, { trigger: "hover" }));
    },

    /* ── FORM VALIDATION ─────────────────────── */
    formValidation() {
        document.querySelectorAll("form.needs-validation").forEach((form) => {
            form.addEventListener("submit", function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                    // Scroll to first error
                    const first = form.querySelector(".is-invalid, :invalid");
                    first?.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                }
                form.classList.add("was-validated");
            });
        });
    },

    /* ── CHARACTER COUNT ─────────────────────── */
    characterCount() {
        document.querySelectorAll("[data-maxlength]").forEach((el) => {
            const max = parseInt(el.getAttribute("data-maxlength"));
            const countEl = document.createElement("small");
            countEl.className = "text-muted float-end";
            el.parentNode.insertBefore(countEl, el.nextSibling);

            const update = () => {
                const remaining = max - el.value.length;
                countEl.textContent = `${el.value.length}/${max}`;
                countEl.className = `text-${remaining < 20 ? "danger" : "muted"} float-end`;
            };

            el.addEventListener("input", update);
            update();
        });
    },

    /* ── NUMBER FORMAT ───────────────────────── */
    numberFormat() {
        document.querySelectorAll(".num-format").forEach((el) => {
            el.addEventListener("blur", function () {
                const val = parseFloat(this.value);
                if (!isNaN(val)) {
                    this.value = val.toFixed(2);
                }
            });
        });
    },

    /* ── UTILITY: Toast ──────────────────────── */
    toast(type, message, title = "") {
        if (typeof toastr !== "undefined") {
            toastr[type](message, title);
        } else {
            alert(message);
        }
    },

    /* ── UTILITY: Confirm Dialog ─────────────── */
    async confirm(options = {}) {
        if (typeof Swal === "undefined") {
            return {
                isConfirmed: window.confirm(options.message || "Confirm?"),
            };
        }

        return Swal.fire({
            title: options.title || "Confirm?",
            text: options.message || "",
            icon: options.icon || "question",
            showCancelButton: true,
            confirmButtonText: options.confirm || "Yes",
            cancelButtonText: options.cancel || "No",
            confirmButtonColor: options.color || "#3b82f6",
            reverseButtons: true,
        });
    },

    /* ── UTILITY: Loading Button ─────────────── */
    loadingBtn(btn, loading = true) {
        if (!btn) return;
        if (loading) {
            btn.dataset.originalText = btn.innerHTML;
            btn.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            btn.disabled = true;
        } else {
            btn.innerHTML = btn.dataset.originalText || "Submit";
            btn.disabled = false;
        }
    },

    /* ── UTILITY: Format Currency ────────────── */
    formatCurrency(amount, symbol = "₹") {
        return (
            symbol +
            parseFloat(amount || 0).toLocaleString("en-IN", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            })
        );
    },
};

/* ── AJAX CSRF Setup ────────────────────────── */
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

if (typeof $ !== "undefined") {
    $.ajaxSetup({
        headers: { "X-CSRF-TOKEN": csrfToken },
    });
}

/* ── DOM Ready ──────────────────────────────── */
document.addEventListener("DOMContentLoaded", () => GovAsset.init());
window.GovAsset = GovAsset;
