$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 4000,
		customClass: {
			width: '200px'
		},
		timerProgressBar: true,
		didOpen: (toast) => {
			toast.addEventListener('mouseenter', Swal.stopTimer)
			toast.addEventListener('mouseleave', Swal.resumeTimer)
		}
	})

	$('select[name="employee"]').select2({
		minimumInputLength: 0,
		allowClear: true,
		placeholder: '-Pilih-',
		ajax: {
			dataType: 'json',
			url: $('meta[name="base_url"]').attr('content') + "Master/select_employee_active",
			delay: 800,
			data: function (params) {
				return {
					search: params.term
				}
			},
			processResults: function (data, page) {
				return {
					results: $.map(data, function (obj) {
						return {
							id: obj.id,
							text: obj.text
						};
					})
				};
			},
			cache: true
		}
	})

	$("#nominal_kasbon, #jumlah_angsuran, #saldo_kasbon").on('input', function () {
		// Mendapatkan nilai dari input "nominal_kasbon" dan "jumlah_angsuran"
		var nominal_kasbon = parseFloat($("#nominal_kasbon").val());
		var jumlah_angsuran = parseFloat($("#jumlah_angsuran").val());
		var saldo_kasbon = parseFloat($("#saldo_kasbon").val());

		// Memastikan nilai nominal_kasbon dan jumlah_angsuran adalah angka yang valid
		if (!isNaN(nominal_kasbon) && !isNaN(jumlah_angsuran) && !isNaN(saldo_kasbon) && jumlah_angsuran !== 0) {
			// Menghitung hasil bagi
			var nominal_angsuran = (saldo_kasbon + nominal_kasbon) / jumlah_angsuran;

			// Mengisi nilai hasil bagi pada input "nominal_angsuran"
			$("#nominal_angsuran").val(nominal_angsuran);
		} else {
			// Jika nilai tidak valid, mengosongkan input "nominal_angsuran"
			$("#nominal_angsuran").val("0");
		}
	});
	$("#nominal_kasbon, #jumlah_angsuran, #saldo_kasbon").on('change', function () {
		// Mendapatkan nilai dari input "nominal_kasbon" dan "jumlah_angsuran"
		var nominal_kasbon = parseFloat($("#nominal_kasbon").val());
		var jumlah_angsuran = parseFloat($("#jumlah_angsuran").val());
		var saldo_kasbon = parseFloat($("#saldo_kasbon").val());

		// Memastikan nilai nominal_kasbon dan jumlah_angsuran adalah angka yang valid
		if (!isNaN(nominal_kasbon) && !isNaN(jumlah_angsuran) && !isNaN(saldo_kasbon) && jumlah_angsuran !== 0) {
			// Menghitung hasil bagi
			var nominal_angsuran = (saldo_kasbon + nominal_kasbon) / jumlah_angsuran;

			// Mengisi nilai hasil bagi pada input "nominal_angsuran"
			$("#nominal_angsuran").val(nominal_angsuran);
		} else {
			// Jika nilai tidak valid, mengosongkan input "nominal_angsuran"
			$("#nominal_angsuran").val("0");
		}
	});

	function Generate_Nominal_Angsuran() {
		var nominal_kasbon = parseFloat($("#nominal_kasbon").val());
		var jumlah_angsuran = parseFloat($("#jumlah_angsuran").val());
		var saldo_kasbon = parseFloat($("#saldo_kasbon").val());

		// Memastikan nilai nominal_kasbon dan jumlah_angsuran adalah angka yang valid
		if (!isNaN(nominal_kasbon) && !isNaN(jumlah_angsuran) && !isNaN(saldo_kasbon) && jumlah_angsuran !== 0) {
			// Menghitung hasil bagi
			var nominal_angsuran = (saldo_kasbon + nominal_kasbon) / jumlah_angsuran;

			// Mengisi nilai hasil bagi pada input "nominal_angsuran"
			$("#nominal_angsuran").val(nominal_angsuran);
		} else {
			// Jika nilai tidak valid, mengosongkan input "nominal_angsuran"
			$("#nominal_angsuran").val("0");
		}
	}

	$('#main-form').validate({
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
		if ($("#main-form").valid()) {
			Swal.fire({
				title: 'Loading....',
				html: '<div class="spinner-border text-primary"></div>',
				showConfirmButton: false,
				allowOutsideClick: false,
				allowEscapeKey: false
			});
			Fn_Submit_Form($('#main-form').serialize())
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
			url: $('meta[name="base_url"]').attr('content') + "PotonganKasbon/Store",
			data: DataForm,
			success: function (response) {
				Swal.close()
				if (response.code == 200) {
					$('#main-form')[0].reset();
					Swal.fire({
						icon: 'success',
						title: 'Notifikasi System',
						text: response.msg,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ya, Confirm!',
						footer: '<a href="javascript:void(0)">Notifikasi System</a>'
					})
				} else if (response.code == 302) {
					$('#saldo_kasbon').val(response.saldo)
					$('#el-saldo-lama').show()
					Swal.fire({
						icon: 'info',
						title: 'Notifikasi System',
						text: response.msg,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ya, Confirm!',
						footer: '<a href="javascript:void(0)">Notifikasi System</a>'
					}).then((result) => {
						$('#el-saldo-lama').show()
					});
					Generate_Nominal_Angsuran()
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
			error: function () {
				Swal.close()
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'A error occured, please report this error to administrator !',
					footer: '<a href="javascript:void(0)">Notification System</a>'
				});
			}
		});
	}
})
