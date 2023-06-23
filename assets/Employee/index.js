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
		dom: 'lBfrtip',
		orderCellsTop: true,
		select: true,
		fixedHeader: {
			header: true,
			headerOffset: 48
		},
		"lengthMenu": [
			[15, 30, 90, 1000],
			[15, 30, 90, 1000]
		],
		ajax: {
			url: $('meta[name="base_url"]').attr('content') + "Master/DT_List_Employee_All",
			dataType: "json",
			type: "POST",
		},
		columns: [{
				data: "SysId",
				name: "SysId",
				render: function (data, type, row, meta) {
					return null;
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
				data: "Work_Status",
				name: "Work_Status",
			},
			{
				data: "Jabatan",
				name: "Jabatan",
			},
			{
				data: "Kode_Salary",
				name: "Kode_Salary",
				visible: false,
			},
			{
				data: "Nominal_Salary",
				name: "Nominal_Salary",
				visible: false,
			},
			{
				data: "Tunjangan_Pokok",
				name: "Tunjangan_Pokok",
				visible: false,
			},
			{
				data: "Nominal_Tunjangan_Pokok",
				name: "Nominal_Tunjangan_Pokok",
				visible: false,
			},
			{
				data: "Tunjangan_Lain",
				name: "Tunjangan_Lain",
				visible: false,
			},
			{
				data: "Nominal_Tunjangan_Lain",
				name: "Nominal_Tunjangan_Lain",
				visible: false,
			},
			{
				data: "Bank",
				name: "Bank",
			},
			{
				data: "No_Rekening",
				name: "No_Rekening",
			},
			{
				data: "KTP",
				name: "KTP",
			},
			{
				data: "Telpon",
				name: "Telpon",
			},
			{
				data: "Email",
				name: "Email",
			},
			{
				data: "Gender",
				name: "Gender",
			},
			{
				data: "Status_Pernikahan",
				name: "Status_Pernikahan",
			},
			{
				data: "Tanggal_Join",
				name: "Tanggal_Join",
			},
			{
				data: "Full_address",
				name: "Full_address",
			},
			{
				data: "is_active",
				name: "is_active",
				render: function (data, type, row, meta) {
					if (data == 1) {
						return `<button class="btn btn-sm btn-success is-active" data-pk="${row.SysId}" data-toggle="tooltip" title="Status: aktif"><i class="fas fa-check-circle"></i></button>`
					} else {
						return `<button class="btn btn-sm btn-danger is-active" data-pk="${row.SysId}" data-toggle="tooltip" title="Status: non-aktif"><i class="fas fa-times-circle"></i></button>`
					}
				}
			},
		],
		order: [
			[2, "ASC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
		}],
		autoWidth: false,
		responsive: true,
		"rowCallback": function (row, data) {
			if (data.is_active == "0") {
				$('td', row).css('background-color', 'pink');
			}
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


	$(document).on('click', '.is-active', function () {
		Swal.fire({
			title: 'System Message!',
			text: `Are you sure to change activation status this employee ?`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					dataType: "json",
					type: "POST",
					url: $('meta[name="base_url"]').attr('content') + "Master/Toggle_status_employee",
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
	})

	function Init_Append_Modal_Update(SysId) {
		$.ajax({
			type: "GET",
			url: $('meta[name="base_url"]').attr('content') + "Master/Append_modal_update_employee",
			data: {
				SysId: SysId
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
				$('#location').html(response);
				$('#modal-update').modal('show');
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
