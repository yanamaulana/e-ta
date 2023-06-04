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
				url: $('meta[name="base_url"]').attr('content') + "Upacara/DT_Monitoring",
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
					data: "ID",
					name: "ID",
				},
				{
					data: "Nama",
					name: "Nama",
				},
				{
					data: "Tanggal",
					name: "Tanggal",
				},
				{
					data: "Jabatan_Upacara",
					name: "Jabatan_Upacara",
				},
				{
					data: "Nominal",
					name: "Nominal",
					render: function (data) {
						return rupiah(data);
					}
				},
				{
					data: "Calculated",
					name: "Calculated",
					render: function (data, type, row, meta) {
						if (data == 1) {
							return `<button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Paid</button>`;
						} else {
							return `<button class="btn btn-secondary btn-sm"><i class="fas fa-hourglass-half"></i> Un-Paid</button>`;
						}
					}
				},
				{
					data: null,
					name: "action",
					orderable: false,
					render: function (data, type, row, meta) {
						if (row.Calculated == 1) {
							return `<button disabled class="btn btn-secondary btn-icon" data-toggle="tooltip" title="Edit/Update data"><i class="fas fa-edit"></i></button>&nbsp;
							<button disabled class="btn btn-secondary btn-icon" data-toggle="tooltip" title="Delete Data"><i class="fas fa-trash-alt"></i></button>`;
						} else {
							return `<button data-pk="${row.SysId}" class="btn btn-warning btn-icon btn-edit" data-toggle="tooltip" title="Edit/Update data"><i class="fas fa-edit"></i></button>&nbsp;
                        <button class="btn btn-danger btn-icon btn-delete" data-toggle="tooltip" title="Delete Data"><i class="fas fa-trash-alt"></i></button>`;
						}
					}
				},

			],
			order: [
				[3, "DESC"]
			],
			columnDefs: [{
				className: "align-middle text-center",
				targets: [0, 1, 2, 3, 4, 6, 7],
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

	$(document).on('click', '.btn-delete', function () {
		let data = $("#TableData").DataTable().row($(this).parents('tr')).data();
		let SysId = data.SysId;
		let nama = data.Nama;
		Swal.fire({
			title: 'System message!',
			text: `Apakah anda yakin untuk menghapus data petugas upacara : ${nama}, Action ini tidak dapat dirollback !`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "Upacara/Delete",
					type: "post",
					dataType: "json",
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

	$(document).on('click', '.btn-edit', function () {
		$("#location").empty()
		$.ajax({
			url: $('meta[name="base_url"]').attr('content') + "Upacara/Edit",
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
				$("#Modal-Form-Edit").modal('show');
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
