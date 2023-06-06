$(document).ready(function () {
	$('.date-picker').flatpickr();

	const rupiah = (number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR"
		}).format(number);
	}

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
				url: $('meta[name="base_url"]').attr('content') + "Rapat/DT_Approval_Leader",
				dataType: "json",
				type: "POST",
			},
			columns: [{
					data: "No_Meeting",
					name: "No_Meeting",
				},
				{
					data: "Meeting_Date",
					name: "Meeting_Date",
				},
				{
					data: "Time_Start",
					name: "Time_Start",
				},
				{
					data: "Time_End",
					name: "Time_End",
				},
				{
					data: "Theme",
					name: "Theme",
				},
				{
					data: "Meeting_Room",
					name: "Meeting_Room",
				},
				{
					data: "Leader_Name",
					name: "Leader_Name",
				},
				{
					data: "Nominal_Tunjangan",
					name: "Nominal_Tunjangan",
					render: function (data) {
						return rupiah(data);
					}
				},
				{
					data: "Total_Participant",
					name: "Total_Participant",
				},
				{
					data: "Approve_Leader",
					name: "Approve_Leader",
					render: function (data, type, row, meta) {
						if (row.Approve_Leader == 0) {
							return `<button data-pk="${row.SysId}" class="btn btn-warning btn-icon btn-approve-leader" data-toggle="tooltip" title="Action Approve Leader"><i class="fas fa-sign-in-alt"></i></button>&nbsp;<button class="btn btn-primary btn-icon btn-list-peserta" data-pk="${row.SysId}" data-toggle="tooltip" title="List Peserta"><i class="fas fa-users"></i></button>`;
						} else {
							return `<button class="btn btn-success" data-toggle="tooltip" title="Leader telah approve ">Approved <i class="fas fa-check"></i></button>&nbsp;&nbsp;<button class="btn btn-primary btn-icon btn-list-peserta" data-pk="${row.SysId}" data-toggle="tooltip" title="List Peserta"><i class="fas fa-users"></i></button>`;
						}
					}
				}
			],
			order: [
				[1, "DESC"]
			],
			columnDefs: [{
				className: "align-middle text-center",
				targets: [0, 1, 2, 3, 4, 5, 6, 9],
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

	$(document).on('click', '.btn-list-peserta', function () {
		$("#location").empty()
		$.ajax({
			url: $('meta[name="base_url"]').attr('content') + "Rapat/M_list_peserta",
			type: "GET",
			data: {
				SysId: $(this).attr('data-pk'),
				Role: $('#Role').val()
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

	$(document).on('click', '.btn-approve-leader', function () {
		let data = $("#TableData").DataTable().row($(this).parents('tr')).data();
		let SysId = data.SysId;
		let No_Meeting = data.No_Meeting;
		Swal.fire({
			title: 'System message!',
			text: `Apakah anda yakin untuk approve kegiatan rapat : ${No_Meeting} !`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Approve!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "Rapat/Approve_Leader",
					type: "post",
					dataType: "json",
					data: {
						SysId: SysId,
						No_Meeting: No_Meeting
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
						if (response.code == 200) {
							Swal.fire({
								icon: 'success',
								title: 'Success!',
								text: response.msg,
								confirmButtonColor: '#3085d6',
								confirmButtonText: 'Yes, Confirm!'
							})
							$("#TableData").DataTable().ajax.reload();
						} else {
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: response.msg,
								confirmButtonColor: '#3085d6',
								confirmButtonText: 'Yes, Confirm!',
								footer: '<a href="javascript:void(0)">Notification System</a>'
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
	})
})
