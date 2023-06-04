$(document).ready(function () {
	$('.date-picker').flatpickr();

	function Fn_Initialized_DataTable() {
		$("#TableData").DataTable({
			destroy: true,
			processing: true,
			serverSide: true,
			paging: true,
			dom: 'lfrtip',
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
				url: $('meta[name="base_url"]').attr('content') + "MonitoringAttendance/DT_Monitoring_Attendance",
				dataType: "json",
				type: "POST",
				data: {
					from: $('#from').val(),
					until: $('#until').val(),
					employee: $('#employee').val()
				}
			},
			columns: [{
					data: "SysId",
					name: "SysId",
					orderable: false,
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{
					data: "Name",
					name: "Name",
				},
				{
					data: "Day",
					name: "Day",
				},
				{
					data: "Kelas",
					name: "Kelas",
				},
				{
					data: "Mata_Pelajaran",
					name: "Mata_Pelajaran",
				},
				{
					data: "Time_Start",
					name: "Time_Start",
				},
				{
					data: "Time_Over",
					name: "Time_Over",
				},
				{
					data: "Date_Att",
					name: "Date_Att",
				},
				{
					data: "Time_Att",
					name: "Time_Att",
				},
				{
					data: "Stand_Hour",
					name: "Stand_Hour",
				},
				{
					data: "Card",
					name: "Card",
				},


			],
			order: [
				[0, "DESC"]
			],
			columnDefs: [{
				className: "align-middle text-center",
				targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 10],
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
			}
		})
	}

	$('#do--filter').on('click', function () {
		$("#TableData").DataTable().clear().destroy(), Fn_Initialized_DataTable()
	})

	Fn_Initialized_DataTable()
})
