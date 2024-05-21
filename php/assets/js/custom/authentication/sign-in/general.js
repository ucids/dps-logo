KTSigninGeneral = (() => {
	let t;
	let e;
	let r;
	return {
		init: () => {
			t = document.querySelector("#kt_sign_in_form");
			e = document.querySelector("#kt_sign_in_submit");
			r = FormValidation.formValidation(t, {
				fields: {
					email: {
						validators: {
							notEmpty: { message: "El Usuario es Requerido" },
						},
					},
					password: {
						validators: { notEmpty: { message: "La Contraseña es requerida" } },
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: ".fv-row",
						eleInvalidClass: "",
						eleValidClass: "",
					}),
				},
			});
			e.addEventListener("click", (i) => {
				i.preventDefault();
				r.validate().then((r) => {
					if (r === "Valid") {
						e.setAttribute("data-kt-indicator", "on");
						e.disabled = true;
						axios
							.post(e.closest("form").getAttribute("action"), new FormData(t))
							.then((response) => {
								if (response.data.success) {
									t.reset();
									Swal.fire({
										text: "Bienvenido",
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: { confirmButton: "btn btn-primary" },
									});
									const redirectUrl = t.getAttribute("data-kt-redirect-url");
									if (redirectUrl) {
										location.href = redirectUrl;
									}
								} else {
									Swal.fire({
										text: "Sorry, the email or password is incorrect, please try again.",
										icon: "error",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: { confirmButton: "btn btn-primary" },
									});
								}
							})
							.catch(() => {
								Swal.fire({
									text: "Sorry, looks like there are some errors detected, please try again.",
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: { confirmButton: "btn btn-primary" },
								});
							})
							.then(() => {
								e.removeAttribute("data-kt-indicator");
								e.disabled = false;
							});
					} else {
						Swal.fire({
							text: "Sorry, looks like there are some errors detected, please try again.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, got it!",
							customClass: { confirmButton: "btn btn-primary" },
						});
					}
				});
			});
		},
	};
})();
KTUtil.onDOMContentLoaded(() => {
	KTSigninGeneral.init();
});
