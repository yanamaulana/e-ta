function check_uncheck_checkbox(isChecked, name) {
	if (isChecked) {
		$('input[name="' + name + '"]').each(function () {
			this.checked = true;
		});
	} else {
		$('input[name="' + name + '"]').each(function () {
			this.checked = false;
		});
	}
}
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

	$('.date-picker').flatpickr();

	const rupiah = (number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR"
		}).format(number);
	}


	$('#form-data').validate({
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

	$('#submit-form').click(function (e) {
		e.preventDefault();
		if ($("#form-data").valid()) {
			if ($('[name="IDs[]"]:checked ').length > 0) {
				Swal.fire({
					title: 'Loading....',
					html: '<div class="spinner-border text-primary"></div>',
					showConfirmButton: false,
					allowOutsideClick: false,
					allowEscapeKey: false
				});
				Fn_Submit_Form($('#form-data').serialize())
			} else {
				Swal.fire({
					icon: 'warning',
					title: 'Oops...',
					text: 'Please select employee !',
					footer: '<a href="javascript:void(0)">Notifikasi System</a>'
				});
			}
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
			url: $('meta[name="base_url"]').attr('content') + "CalculatePayroll/Generate_New_Payrol",
			data: DataForm,
			success: function (response) {
				Swal.close()
				if (response.code == 200) {
					$("#TableData").DataTable().ajax.reload();
					$('#form-data')[0].reset();
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
							window.location.href = $('meta[name="base_url"]').attr('content') + "HistoryPayroll";
						}
					})
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: response.msg,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Yes, Confirm!',
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



	var TableData = $("#TableData").DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		paging: true,
		dom: 'rt',
		orderCellsTop: true,
		// select: true,
		fixedHeader: {
			header: true,
			headerOffset: 60
		},
		"lengthMenu": [
			[1000],
			[1000]
		],
		ajax: {
			url: $('meta[name="base_url"]').attr('content') + "Master/DT_List_Employee_Active",
			dataType: "json",
			type: "POST",
		},
		columns: [{
				data: "SysId",
				name: "SysId",
				orderable: false,
				render: function (data, type, row, meta) {
					return `<div class="form-check form-check-sm form-check-custom text-center" data-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-dismiss="click" title="Include perhitungan Payroll">
                    <input type="checkbox" class="form-check-input text-center" value="${row.ID}" id="${row.SysId}" name="IDs[]">
                  </div>`
				}
			},
			{
				data: "ID",
				name: "ID",
				orderable: false,
			},
			{
				data: "Nama",
				name: "Nama",
				orderable: false,
			},
			{
				data: "Jabatan",
				name: "Jabatan",
				orderable: false,
			},
			{
				data: "Nominal_Salary",
				name: "Nominal_Salary",
				orderable: false,
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "Nominal_Tunjangan_Pokok",
				name: "Nominal_Tunjangan_Pokok",
				orderable: false,
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "Tunjangan_Jabatan_1",
				name: "Tunjangan_Jabatan_1",
				orderable: false,
			},
			{
				data: "Nominal_Tunjangan_Jabatan_1",
				name: "Nominal_Tunjangan_Jabatan_1",
				orderable: false,
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "Tunjangan_Jabatan_2",
				name: "Tunjangan_Jabatan_2",
				orderable: false,
			},
			{
				data: "Nominal_Tunjangan_Jabatan_2",
				name: "Nominal_Tunjangan_Jabatan_2",
				orderable: false,
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "Tunjangan_Jabatan_3",
				name: "Tunjangan_Jabatan_3",
				orderable: false,
			},
			{
				data: "Nominal_Tunjangan_Jabatan_3",
				name: "Nominal_Tunjangan_Jabatan_3",
				orderable: false,
				render: function (data) {
					return rupiah(data)
				}
			},
			{
				data: "SysId",
				name: "SysId",
				orderable: false,
				render: function (data, type, row, meta) {
					return `<div class="form-check form-check-sm form-check-custom text-center" data-toggle="tooltip" data-bs-placement="left" data-bs-custom-class="tooltip-dark" data-bs-dismiss="click" title="Total Thp akan di potong angsuran kasbon">
                    <input type="checkbox" class="form-check-input text-center" value="${row.ID}" id="${row.SysId}" name="Kasbons[]">
                  </div>`
				}
			},
		],
		order: [
			[2, "ASC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
		}],
		autoWidth: false,
		responsive: false,
		"rowCallback": function (row, data) {
			if (data.is_active == "0") {
				$('td', row).css('background-color', 'pink');
			}
		},
		preDrawCallback: function () {
			$("#TableData tbody td").addClass("blurry");
		},
		initComplete: function () {
			$('table#TableData th').css('font-size', '0.8em');
			$('table#TableData td').css('font-size', '0.8em');
			$('table#TableData td').css('color', 'black');
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
			text: `<i class="fas fa-plus"></i>`,
			className: "btn btn-info",
			action: function (e, dt, node, config) {
				window.location.href = $('meta[name="base_url"]').attr('content') + "Master/Add_Employee";
			}
		}, {
			text: `<i class="fas fa-edit"></i>`,
			className: "btn btn-warning",
			action: function (e, dt, node, config) {
				var RowData = dt.rows({
					selected: true
				}).data();
				if (RowData.length == 0) {
					Swal.fire({
						icon: 'warning',
						title: 'Ooppss...',
						text: 'Please select data to be update !',
						footer: '<a href="javascript:void(0)" class="text-danger">Notifikasi System</a>'
					});
				} else {
					Init_Append_Modal_Update(RowData[0].SysId)
				}
			}
		}, {
			text: `<i class="fas fa-trash"></i>`,
			className: "btn btn-default disabled",
			action: function (e, dt, node, config) {
				var RowData = dt.rows({
					selected: true
				}).data();
				// if (RowData.length == 0) {
				// 	Swal.fire({
				// 		icon: 'warning',
				// 		title: 'Ooppss...',
				// 		text: 'Please select data to be delete !',
				// 		footer: '<a href="javascript:void(0)" class="text-danger">Notifikasi System</a>'
				// 	});
				// } else {
				// 	Fn_Delete_RowData(RowData[0].SysId)
				// }
			}
		}, {
			text: `Export to :`,
			className: "btn disabled text-dark bg-white",
		}, {
			text: `<i class="far fa-copy fs-2"></i>`,
			extend: 'copy',
			className: "btn btn-light-warning",
		}, {
			text: `<i class="far fa-file-excel fs-2"></i>`,
			extend: 'excelHtml5',
			title: $('#table-title').text() + '~' + moment().format("YYYY-MM-DD"),
			className: "btn btn-light-success",
		}, {
			text: `<i class="far fa-file-pdf fs-2"></i>`,
			extend: 'pdfHtml5',
			title: $('#table-title').text() + '~' + moment().format("YYYY-MM-DD"),
			className: "btn btn-light-danger",
			orientation: "landscape"
		}, {
			text: `<i class="fas fa-print fs-2"></i>`,
			extend: 'print',
			className: "btn btn-light-dark",
		}],
	}).buttons().container().appendTo('#TableData_wrapper .col-md-6:eq(0)');
});
