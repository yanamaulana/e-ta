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

	var TableData = $("#TableData").DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		paging: true,
		dom: 'lfrtip',
		orderCellsTop: true,
		// select: true,
		fixedHeader: {
			header: true,
			headerOffset: 48
		},
		"lengthMenu": [
			[15, 30, 90, 1000],
			[15, 30, 90, 1000]
		],
		ajax: {
			url: $('meta[name="base_url"]').attr('content') + "ApprovalSchedule/DT_list_schedule_need_Approval",
			dataType: "json",
			type: "POST",
		},
		columns: [{
				data: "SysId",
				name: "SysId",
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},
			{
				data: "Schedule_Number",
				name: "Schedule_Number",
			},
			{
				data: "Nama",
				name: "Nama",
			},
			{
				data: "Work_Status",
				name: "Work_Status",
			},
			{
				data: "Jabatan",
				name: "Jabatan",
			},
			{
				data: "Date_create",
				name: "Date_create",
			},
			{
				data: "Approve",
				name: "Approve",
				render: function (data, type, row, meta) {
					return `<button class="btn btn-sm btn-icon btn-success btn-approve" data-pk="${row.SysId}" data-toggle="tooltip" title="Approve"><i class="fas fa-check"></i></button>
                    &nbsp;<button class="btn btn-sm btn-icon btn-info btn-preview" data-pk="${row.SysId}" data-toggle="tooltip" title="View Schedule"><i class="fas fa-clipboard-list"></i></button>
                    &nbsp;<button class="btn btn-sm btn-icon btn-danger btn-reject" data-pk="${row.SysId}" data-toggle="tooltip" title="Reject"><i class="fas fas fa-times"></i></button>`
				}
			},
		],
		order: [
			[5, "DESC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4, 5, 6],
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
		// "buttons": [{
		// 	text: `<i class="fas fa-plus"></i>`,
		// 	className: "btn btn-info",
		// 	action: function (e, dt, node, config) {
		// 		window.location.href = $('meta[name="base_url"]').attr('content') + "Master/Add_Employee";
		// 	}
		// }, {
		// 	text: `<i class="fas fa-edit"></i>`,
		// 	className: "btn btn-warning",
		// 	action: function (e, dt, node, config) {
		// 		var RowData = dt.rows({
		// 			selected: true
		// 		}).data();
		// 		if (RowData.length == 0) {
		// 			Swal.fire({
		// 				icon: 'warning',
		// 				title: 'Ooppss...',
		// 				text: 'Please select data to be update !',
		// 				footer: '<a href="javascript:void(0)" class="text-danger">Notifikasi System</a>'
		// 			});
		// 		} else {
		// 			Init_Append_Modal_Update(RowData[0].SysId)
		// 		}
		// 	}
		// }, {
		// 	text: `<i class="fas fa-trash"></i>`,
		// 	className: "btn btn-default disabled",
		// 	action: function (e, dt, node, config) {
		// 		var RowData = dt.rows({
		// 			selected: true
		// 		}).data();
		// 		if (RowData.length == 0) {
		// 			Swal.fire({
		// 				icon: 'warning',
		// 				title: 'Ooppss...',
		// 				text: 'Please select data to be delete !',
		// 				footer: '<a href="javascript:void(0)" class="text-danger">Notifikasi System</a>'
		// 			});
		// 		} else {
		// 			Fn_Delete_RowData(RowData[0].SysId)
		// 		}
		// 	}
		// }, {
		// 	text: `Export to :`,
		// 	className: "btn disabled text-dark bg-white",
		// }, {
		// 	text: `<i class="far fa-copy fs-2"></i>`,
		// 	extend: 'copy',
		// 	className: "btn btn-light-warning",
		// }, {
		// 	text: `<i class="far fa-file-excel fs-2"></i>`,
		// 	extend: 'excelHtml5',
		// 	title: $('#table-title').text() + '~' + moment().format("YYYY-MM-DD"),
		// 	className: "btn btn-light-success",
		// }, {
		// 	text: `<i class="far fa-file-pdf fs-2"></i>`,
		// 	extend: 'pdfHtml5',
		// 	title: $('#table-title').text() + '~' + moment().format("YYYY-MM-DD"),
		// 	className: "btn btn-light-danger",
		// 	orientation: "landscape"
		// }, {
		// 	text: `<i class="fas fa-print fs-2"></i>`,
		// 	extend: 'print',
		// 	className: "btn btn-light-dark",
		// }],
	}).buttons().container().appendTo('#TableData_wrapper .col-md-6:eq(0)');

	$(document).on('click', '.btn-approve', function () {
		Swal.fire({
			title: 'System Message!',
			text: `Are you sure to approve this schedule ?`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					dataType: "json",
					type: "POST",
					url: $('meta[name="base_url"]').attr('content') + "ApprovalSchedule/Approve_Schedule",
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
					success: function (response) {
						Swal.close()
						if (response.code == 200) {
							Toast.fire({
								icon: 'success',
								title: response.msg
							});
							$("#TableData").DataTable().ajax.reload(null, false)
						} else {
							Toast.fire({
								icon: 'error',
								title: response.msg
							});
						}
					},
					error: function () {
						Swal.close()
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'A error occured, please report this error to administrator !',
							footer: '<a href="javascript:void(0)">Notifikasi System</a>'
						});
					}
				});
			}
		})
	})
	$(document).on('click', '.btn-reject', function () {
		Swal.fire({
			title: 'System Message!',
			text: `Are you sure to reject this schedule ?`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					dataType: "json",
					type: "POST",
					url: $('meta[name="base_url"]').attr('content') + "ApprovalSchedule/Reject_Schedule",
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
					success: function (response) {
						Swal.close()
						if (response.code == 200) {
							Toast.fire({
								icon: 'success',
								title: response.msg
							});
							$("#TableData").DataTable().ajax.reload(null, false)
						} else {
							Toast.fire({
								icon: 'error',
								title: response.msg
							});
						}
					},
					error: function () {
						Swal.close()
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'A error occured, please report this error to administrator !',
							footer: '<a href="javascript:void(0)">Notifikasi System</a>'
						});
					}
				});
			}
		})
	})

	// btn-preview
	$(document).on('click', '.btn-preview', function () {
		$("#location").empty()
		$.ajax({
			url: $('meta[name="base_url"]').attr('content') + "ApprovalSchedule/Preview_Schedule",
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
})
