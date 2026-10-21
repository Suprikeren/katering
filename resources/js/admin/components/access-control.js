import Alpine from "alpinejs";
import Swal from "sweetalert2";

window.Swal = Swal;

const setupDeleteConfirmation = () => {
  document.querySelectorAll("form[data-confirm]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();

      Swal.fire({
        title: form.dataset.confirmTitle || "Apakah Anda yakin?",
        text: form.dataset.confirm || "Data akan dihapus secara permanen.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d92d20",
        cancelButtonColor: "#667085",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        focusCancel: true,
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });
};

const setupSelectAll = () => {
  document.querySelectorAll("[data-check-all]").forEach((button) => {
    button.addEventListener("click", () => {
      const group = document.querySelector(button.dataset.checkAll);
      if (!group) {
        return;
      }

      const checkboxes = group.querySelectorAll('input[type="checkbox"]');
      const allChecked = [...checkboxes].every((checkbox) => checkbox.checked);

      checkboxes.forEach((checkbox) => {
        checkbox.checked = !allChecked;
      });
    });
  });
};

Alpine.data("permissionModal", (initial = null, baseUrl = "") => ({
  open: initial?.open ?? false,
  mode: initial?.mode ?? "create",
  permissionId: initial?.permissionId ?? null,
  name: initial?.name ?? "",

  get isEdit() {
    return this.mode === "edit";
  },

  get formAction() {
    return this.isEdit ? `${baseUrl}/${this.permissionId}` : baseUrl;
  },

  openCreate() {
    this.mode = "create";
    this.permissionId = null;
    this.name = "";
    this.open = true;
  },

  openEdit(id, name) {
    this.mode = "edit";
    this.permissionId = id;
    this.name = name;
    this.open = true;
  },

  close() {
    this.open = false;
  },
}));

document.addEventListener("DOMContentLoaded", () => {
  setupDeleteConfirmation();
  setupSelectAll();
});
