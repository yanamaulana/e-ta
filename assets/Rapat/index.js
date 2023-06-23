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

	$('input[name="tanggal"]').flatpickr({
		dateFormat: "Y-m-d",
	});

	$('input[name="start"]').flatpickr({
		dateFormat: "H:i",
		enableTime: true,
		noCalendar: true,
		time_24hr: true,
	});

	$('input[name="end"]').flatpickr({
		dateFormat: "H:i",
		enableTime: true,
		noCalendar: true,
		time_24hr: true,
	});

	$('#form-rapat').validate({
		errorElement: 'span',
		errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.form-group').append(error);
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

	$('#submit-main-form').click(function (e) {
		e.preventDefault();
		if ($("#form-rapat").valid()) {
			Swal.fire({
				title: 'Loading....',
				html: '<div class="spinner-border text-primary"></div>',
				showConfirmButton: false,
				allowOutsideClick: false,
				allowEscapeKey: false
			});
			Fn_Submit_Form($('#form-rapat').serialize())
		} else {
			$('html, body').animate({
				scrollTop: ($('.error:visible').offset().top - 200)
			}, 400);
		}
	});

	function Fn_Submit_Form(DataForm) {
		$.ajax({
			dataType: "json",
			type: "POST",
			url: $('meta[name="base_url"]').attr('content') + "Rapat/Store",
			data: DataForm,
			success: function (response) {
				Swal.close()
				if (response.code == 200) {
					$('#form-rapat')[0].reset();
					Swal.fire({
						icon: 'success',
						title: 'Success!',
						text: response.msg,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ya, Lihat Monitoring!',
						showCancelButton: true,
						cancelButtonText: 'Cancel !',
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = $('meta[name="base_url"]').attr('content') + "Rapat/Monitoring";
						}
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: response.msg,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ya, Confirm!',
						footer: '<a href="javascript:void(0)">Notifikasi System</a>'
					});
				}
			},
			error: function (xhr, status, error) {
				var statusCode = xhr.status;
				var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText ? xhr.responseText : "Terjadi kesalahan: " + error;
				Swal.fire({
					icon: "error",
					title: "Error!",
					html: `Kode HTTP: ${statusCode}<br\>Pesan: ${errorMessage}`,
				});
			}
		});
	}
})
