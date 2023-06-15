$(document).ready(function () {
	const Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 6000,
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
			url: $('meta[name="base_url"]').attr('content') + "ManageSalary/DT_List_Employee_Active",
			dataType: "json",
			type: "POST",
		},
		columns: [{
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
				visible: false,
			},
			{
				data: "Jabatan",
				name: "Jabatan",
			},
			{
				data: "Kode_Salary",
				name: "Kode_Salary",
			},
			{
				data: "Nominal_Salary",
				name: "Nominal_Salary",
			},
			{
				data: "Tunjangan_Pokok",
				name: "Tunjangan_Pokok",
				visible: false,
			},
			{
				data: "Nominal_Tunjangan_Pokok",
				name: "Nominal_Tunjangan_Pokok",
			},
			{
				data: "Tunjangan_Jabatan_1",
				name: "Tunjangan_Jabatan_1",
			},
			{
				data: "Nominal_Tunjangan_Jabatan_1",
				name: "Nominal_Tunjangan_Jabatan_1",
			},
			{
				data: "Tunjangan_Jabatan_2",
				name: "Tunjangan_Jabatan_2",
			},
			{
				data: "Nominal_Tunjangan_Jabatan_2",
				name: "Nominal_Tunjangan_Jabatan_2",
			},
			{
				data: "Tunjangan_Jabatan_3",
				name: "Tunjangan_Jabatan_3",
			},
			{
				data: "Nominal_Tunjangan_Jabatan_3",
				name: "Nominal_Tunjangan_Jabatan_3",
			},
			{
				data: "Label_Tunjangan_Lain",
				name: "Label_Tunjangan_Lain",
			},
			{
				data: "Nominal_Tunjangan_Lain",
				name: "Nominal_Tunjangan_Lain",
			}
		],
		order: [
			[1, "ASC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4, 6, 8],
		}],
		autoWidth: false,
		// responsive: true,
		"rowCallback": function (row, data) {
			// if (data.is_active == "0") {
			// 	$('td', row).css('background-color', 'pink');
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
			text: `<i class="fas fa-plus"></i>`,
			className: "btn btn-default disabled",
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

	function Init_Append_Modal_Update(SysId) {
		$.ajax({
			type: "GET",
			url: $('meta[name="base_url"]').attr('content') + "ManageSalary/Append_modal_update_salary",
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
			error: function () {
				Swal.close()
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Terjadi kesalahan teknis segera lapor pada admin!',
					footer: '<a href="javascript:void(0)">Notifikasi System</a>'
				});
			}
		});
	}

})
