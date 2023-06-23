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

	const rupiah = (number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR"
		}).format(number);
	}

	$("#TableData").DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		paging: true,
		dom: 'lBfrtip',
		orderCellsTop: true,
		fixedHeader: {
			header: true,
			headerOffset: 48
		},
		"lengthMenu": [
			[15, 30, 90, 1000],
			[15, 30, 90, 1000]
		],
		ajax: {
			url: $('meta[name="base_url"]').attr('content') + "PotonganKasbon/DT_Master_Hdr_Kasbon",
			dataType: "json",
			type: "POST",
		},
		columns: [{
				data: "SysId",
				name: "SysId",
				searchable: false,
				orderable: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: "ID",
				name: "ID",
			},
			{
				data: "Nama",
				name: "Nama",
			},
			{
				data: "Saldo_Kasbon",
				name: "Saldo_Kasbon",
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "Nominal_Angsuran",
				name: "Nominal_Angsuran",
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "Sisa_Jumlah_Angsuran",
				name: "Sisa_Jumlah_Angsuran",
				render: function (data) {
					return parseFloat(data)
				}
			},
			{
				data: null,
				name: "action",
				searchable: false,
				orderable: false,
				render: function (data, type, row, meta) {
					return `<button data-pk="${row.SysId}" class="btn btn-info btn-icon btn-trx" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-pk="${row.SysId}" title="Angsuran & Kasbon"><i class="fas fa-book fs-2x" style="rotate: 45deg;"></i></button>`;
				}
			}
		],
		order: [
			[2, "ASC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 5, 6],
		}],
		autoWidth: false,
		responsive: true,
		"rowCallback": function (row, data) {
			// if (data.Approve == "0") {
			// $('td', row).css('background-color', 'pink');
			// }
		},
		preDrawCallback: function () {
			$("#TableData tbody td").addClass("blurry");
		},
		language: {
			processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" style="text-align:center" class="loading-text"></span> ',
			searchPlaceholder: "Search..."
		},
		drawCallback: function () {
			$("#TableData tbody td").addClass("blurry");
			setTimeout(function () {
				$("#TableData tbody td").removeClass("blurry");
			});
			$('[data-toggle="tooltip"]').tooltip();
		},
		"buttons": [{
			text: `Export to :`,
			className: "btn disabled text-dark bg-white",
		}, {
			text: `<i class="far fa-copy fs-2"></i>`,
			extend: 'copy',
			className: "btn btn-light-warning",
		}, {
			text: `<i class="far fa-file-excel fs-2"></i>`,
			extend: 'excelHtml5',
			footer: true,
			title: $('#table-title-detail').text() + '--' + moment().format("YYYY-MM-DD"),
			className: "btn btn-light-success",
		}, {
			text: `<i class="far fa-file-pdf fs-2"></i>`,
			extend: 'pdfHtml5',
			title: $('#table-title-detail').text() + '--' + moment().format("YYYY-MM-DD"),
			className: "btn btn-light-danger",
			footer: true,
			orientation: "landscape"
		}, {
			text: `<i class="fas fa-print fs-2"></i>`,
			extend: 'print',
			footer: true,
			className: "btn btn-light-dark",
		}],
	}).buttons().container().appendTo('#TableData_wrapper .col-md-6:eq(0)');

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
					$("#TableData").DataTable().ajax.reload();

					$("#nav-tab-1").removeClass('active')
					$("#nav-tab-2").addClass('active')
					$("#container-tab-1").removeClass('active')
					$("#container-tab-1").removeClass('show')
					$("#container-tab-2").addClass('active')
					$("#container-tab-2").addClass('show')

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

	$(document).on('click', '.btn-trx', function () {
		$("#location").empty()
		$.ajax({
			url: $('meta[name="base_url"]').attr('content') + "PotonganKasbon/M_detail_transaksi_kasbon",
			type: "GET",
			data: {
				SysId: $(this).attr('data-pk')
			},
			beforeSend: function () {
				Swal.fire({
					title: 'Loading....',
					html: '<div class="spinner-border text-primary"></div>',
					showConfirmButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false
				})
			},
			success: function (ajaxData) {
				Swal.close()
				$("#location").html(ajaxData);
				$("#Modal-Detail").modal('show');
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
	})
})
