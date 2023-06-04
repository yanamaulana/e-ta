$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000,
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})

	$("#Tanggal_Lahir").flatpickr();
	$("#Tanggal_Join").flatpickr();

	$('#kt_sign_up_form').validate({
		errorElement: 'span',
		errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.fv-row').append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		}
	});
	$.validator.setDefaults({
		debug: true,
		success: 'valid'
	});

	$('#kt_sign_up_submit').click(function (e) {
		e.preventDefault();
		if ($("#kt_sign_up_form").valid()) {
			Swal.fire({
				title: 'System Message !',
				text: `Are you sure to submit your data ?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					Init_Submit_Form($('#kt_sign_up_form'))
				}
			})
		} else {
			$('html, body').animate({
				scrollTop: ($('.error:visible').offset().top - 200)
			}, 400);
		}
	});

	function Init_Submit_Form(DataForm) {
		let BtnAction = $('#kt_sign_up_submit');
		$.ajax({
			dataType: "json",
			type: "POST",
			url: $('meta[name="base_url"]').attr('content') + "Auth/Post_Register",
			data: DataForm.serialize(),
			beforeSend: function () {
				BtnAction.prop("disabled", true);
				Swal.fire({
					title: 'Loading....',
					html: '<div class="spinner-border text-primary"></div>',
					showConfirmButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false
				})
			},
			success: function (response) {
				Swal.close()
				if (response.code == 200) {
					DataForm[0].reset();
					Swal.fire({
						title: 'System Message!',
						text: response.msg,
						icon: 'success',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes'
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = $('meta[name="base_url"]').attr('content') + "Auth";
						}
					})
				} else {
					Toast.fire({
						icon: 'error',
						title: response.msg
					});
				}
				BtnAction.prop("disabled", false);
			},
			error: function () {
				Swal.close()
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'A error occured, please report this error to administrator !',
					footer: '<a href="javascript:void(0)">Notifikasi System</a>'
				});
				BtnAction.prop("disabled", false);
			}
		});
	}
})
