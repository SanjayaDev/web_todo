const CORE = {
  csrfToken: document.querySelector(`[name="csrf-token"]`)?.content,
  allowSubmit: true,

  showLoading() {
    document.querySelector(".parent-loader").classList.remove("d-none");
  },

  removeLoading() {
    document.querySelector(".parent-loader").classList.add("d-none");
  },

  sweet(icon, title, text, timer = false) {
    let config = {
      icon: icon,
      title: title,
      text: text,
    };

    if (timer) {
      config["timer"] = timer;
    }

    Swal.fire(config);
  },

  async submitFormAjax(form) {
    if (CORE.allowSubmit) {
      CORE.allowSubmit = false;

      const url = form.action;
      const method = form.method;

      let options = {};
      if (method == "post") {
        options = {
          headers: {
            "X-CSRF-TOKEN": CORE.csrfToken,
            Accept: "application/json",
          },
          method: "POST",
          body: new FormData(form),
        };
      }

      const request = await fetch(url, options);
      CORE.allowSubmit = true;

      CORE.removeLoading();

      if (request.status == 200) {
        const response = await request.json();
        CORE.sweet("success", "Sukses!", response.message);

        if (response.next_url) {
          window.setTimeout(
            () => (window.location.href = response.next_url),
            1500
          );
        }
      } else if (request.status == 422) {
        CORE.sweet(
          "error",
          "Gagal!",
          "Terdapat input yang salah! Mohon cek kembali form anda!"
        );
      } else if (request.status != 500) {
        const response = await request.json();
        CORE.sweet("error", "Gagal!", response.message);
      } else {
        CORE.sweet("error", "Gagal!", "Terjadi kesalahan server!");
      }
    }
  },

  initSubmitCrud() {
    const forms = document.querySelectorAll(`form[with-submit-crud]`);

    forms.forEach((form) => {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        CORE.showLoading();
        CORE.submitFormAjax(this);
      });
    });
  },

  initNumberFormat() {
    let listInputNumber = document.querySelectorAll(".number-format");
    for (let i = 0; i < listInputNumber.length; i++) {
      listInputNumber[i].addEventListener("keyup", function (e) {
        if (e.keyCode !== 6 && e.keyCode !== 46) {
          this.value = CORE.numberFormat(this.value);
        }
      });
    }
  },

  showModal(modalId) {
    let showModal = new bootstrap.Modal(document.getElementById(modalId));
    showModal.show();
  },

  closeModal(modalId) {
    let showModal = bootstrap.Modal.getInstance(
      document.getElementById(modalId)
    );
    showModal.hide();
  },

  init() {
    CORE.initSubmitCrud();
    CORE.initNumberFormat();
  }
};

document.addEventListener("DOMContentLoaded", function() {
  CORE.init();
});