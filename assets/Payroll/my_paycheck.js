$(document).ready(function () {
	moment.locale('id');
	$.ajaxSetup({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
		},
	});

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
	});

	const rupiah = (number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR"
		}).format(number);
	}

	function Fn_Initialized_DataTable_Hdr(NIK) {
		var tbl_hdr = $('#Table-Hdr').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			"ordering": true,
			// "select": true,
			"pageLength": 10,
			"order": [
				[3, 'asc']
			],
			"ajax": {
				"url": $('meta[name="base_url"]').attr('content') + "HistoryPayroll/Hdr_Payroll_DataTable_Paycheck",
				"type": "POST",
				data: {
					NIK: NIK
				}
			},
			"columns": [{
				data: "SysId",
				name: "SysId",
				visible: false,
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			}, {
				data: "TagID_PerNIK",
				name: "TagID_PerNIK"
			}, {
				data: "NIK",
				name: "NIK "
			}, {
				data: "Nama",
				name: "Nama "
			}, {
				data: "Jabatan",
				name: "Jabatan "
			}, {
				data: "Tgl_Dari",
				name: "Tgl_Dari "
			}, {
				data: "Tgl_Sampai",
				name: "Tgl_Sampai "
			}, {
				data: "Payment_Status",
				name: "Payment_Status ",
				render: function (data, type, row, meta) {
					if (data == 0) {
						return '<button class="btn btn-sm btn-secondary">Un-Paid</i></button>'
					} else {
						return '<button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Paid</i></button>'
					}
				}
			}, {
				data: "SysId",
				name: "action",
				orderable: false,
				render: function (data, type, row, meta) {
					if (row.kasbon == 0 || row.Payment_Status == 1) {
						return `<div class="btn-group-vertical" role="group">
                        <button data-pk="${row.SysId}" class="btn btn-sm btn-icon btn-success btn-detail" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="detail waktu absensi"><i class="fas fa-calendar-alt"></i></button>
                        <button class="btn btn-icon btn-primary btn-sm btn-icon btn-print-hdr" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Print slip gaji ${row.Nama}"><i class="fas fa-print"></i></button>
                        </div>`;
					} else {
						// <button data-pk="${row.SysId}" class="btn btn-sm btn-icon btn-warning btn-kasbon" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Potongan Kasbon"><i class="fas fa-fax"></i></button>
						return `<div class="btn-group-vertical" role="group">
                        <button data-pk="${row.SysId}" class="btn btn-sm btn-icon btn-success btn-detail" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="detail waktu absensi"><i class="fas fa-calendar-alt"></i></button>
                        <button class="btn btn-icon btn-primary btn-sm btn-print-hdr" data-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Print slip gaji ${row.Nama}"><i class="fas fa-print"></i></button>
                        </div>`;
					}
				}
			}],
			columnDefs: [{
				className: "text-center",
				targets: [1, 2, 3, 4, 5, 6, 7, 8],
			}],
			bAutoWidth: false,
			responsive: true,
			rowCallback: function (row, data) {
				// for change color tr
			},
			preDrawCallback: function () {
				$("#Table-Hdr  tbody td").addClass("blurry");
			},
			language: {
				processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" class="loading-text">Loading Data</span> ',
			},
			drawCallback: function () {
				Swal.close()
				setTimeout(function () {
					$("#Table-Hdr  tbody td").removeClass("blurry");
				});
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$(document).on('click', '.btn-print-hdr', function () {
			let data = tbl_hdr.row($(this).parents('tr')).data();

			window.open($('meta[name="base_url"]').attr('content') + `HistoryPayroll/Report_hdr/${data.SysId}`, 'WindowReport-Hdr', 'width=800,height=600');
		})
	}

	$(document).on('click', '.btn-detail', function () {
		let Row = $('#Table-Hdr').DataTable().row($(this).parents('tr')).data();
		$("#location").empty()
		$.ajax({
			url: $('meta[name="base_url"]').attr('content') + "/HistoryPayroll/AppendModal_Dtl_Payroll",
			data: {
				TagID_PerNIK: Row.TagID_PerNIK
			},
			type: "POST",
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
			error: function () {
				Swal.fire({
					title: "Error!",
					text: "Terjadi kesalahan teknis, Hubungi MIS dept!",
					icon: "error",
					allowOutsideClick: false,
				});
			}
		});
	})

	Fn_Initialized_DataTable_Hdr($('#NIK').val())
});
