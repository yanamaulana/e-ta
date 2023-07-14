$(document).ready(function () {
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
			headerOffset: 62
		},
		"lengthMenu": [
			[1000],
			[1000]
		],
		ajax: {
			url: $('meta[name="base_url"]').attr('content') + "ScheduleActive/DT_list_schedule_active_all",
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
				data: "ID_Access",
				name: "ID_Access",
			},
			{
				data: "Nama",
				name: "Nama",
			},
			{
				data: "Hari",
				name: "Hari",
			},
			{
				data: "Kelas",
				name: "Kelas",
			},
			{
				data: "Subject_Code",
				name: "Subject_Code",
			},
			{
				data: "Mata_Pelajaran",
				name: "Mata_Pelajaran",
			},
			{
				data: "Start_Time",
				name: "Start_Time",
			},
			{
				data: "Time_Over",
				name: "Time_Over",
			},
			{
				data: "Stand_Hour",
				name: "Stand_Hour",
				render: function (data) {
					return parseFloat(data)
				}
			},
		],
		order: [
			[4, 'DESC'],
			[8, 'ASC']
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4, 5, 6, 7],
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
			title: $('#table-title-detail').text() + '~' + moment().format("YYYY-MM-DD"),
			className: "btn btn-light-success",
		}, {
			text: `<i class="far fa-file-pdf fs-2"></i>`,
			extend: 'pdfHtml5',
			title: $('#table-title-detail').text() + '~' + moment().format("YYYY-MM-DD"),
			className: "btn btn-light-danger",
			footer: true,
			orientation: "landscape"
		}, {
			text: `<i class="fas fa-print fs-2"></i>`,
			extend: 'print',
			footer: true,
			className: "btn btn-light-dark",
		}]
	}).buttons().container().appendTo('#TableDataRekap_wrapper .col-md-6:eq(0)');

	var TableDataRekap = $("#TableDataRekap").DataTable({
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
			url: $('meta[name="base_url"]').attr('content') + "ScheduleActive/DT_list_schedule_active_rekap_guru",
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
					return `<button class="btn btn-sm btn-icon btn-info btn-preview" data-pk="${row.SysId}" data-toggle="tooltip" title="View Schedule"><i class="fas fa-clipboard-list"></i></button>`
				}
			},
		],
		order: [
			[2, 'ASC']
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
			$("#TableDataRekap tbody td").addClass("blurry");
		},
		language: {
			processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" style="text-align:center" class="loading-text"></span> ',
			searchPlaceholder: "Search..."
		},
		drawCallback: function () {
			$("#TableDataRekap tbody td").addClass("blurry");
			setTimeout(function () {
				$("#TableDataRekap tbody td").removeClass("blurry");
			});
			$('[data-toggle="tooltip"]').tooltip();
		}
	}).buttons().container().appendTo('#TableDataRekap_wrapper .col-md-6:eq(0)');

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
