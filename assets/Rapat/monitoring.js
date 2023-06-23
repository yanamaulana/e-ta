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
				url: $('meta[name="base_url"]').attr('content') + "Rapat/DT_Monitoring",
				dataType: "json",
				type: "POST",
				data: {
					from: $('#from').val(),
					until: $('#until').val(),
				}
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
							return `<button data-pk="${row.SysId}" class="btn btn-warning btn-icon btn-approve-leader" data-toggle="tooltip" title="Action Approve Leader"><i class="fas fa-sign-in-alt"></i></button>`;
						} else {
							return `<button class="btn btn-success" data-toggle="tooltip" title="Leader telah approve ">Approved <i class="fas fa-check"></i></button>`;
						}
					}
				},
				{
					data: "Approve_Admin",
					name: "Approve_Admin",
					render: function (data, type, row, meta) {
						if (row.Approve_Leader == 0) {
							return `<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Tunggu Leader Approve">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span class="button-text">Menunggu Leader</span>
                                    </button>`;
						} else if (row.Approve_Admin == 0) {
							return `<button data-pk="${row.SysId}" class="btn btn-warning btn-icon btn-approve-admin" data-toggle="tooltip" title="Approve Admin"><i class="fas fa-sign-in-alt"></i></button>`;
						} else {
							return `<button class="btn btn-success" data-toggle="tooltip" title="Admin telah approve ">Approved <i class="fas fa-check"></i></button>`;
						}
					}
				},
				{
					data: null,
					name: "action",
					orderable: false,
					render: function (data, type, row, meta) {
						if (row.Approve_Admin == 1) {
							return `<button type="button" disabled class="btn btn-secondary btn-icon" data-toggle="tooltip" title="Edit/Update data"><i class="fas fa-edit"></i></button>&nbsp;
							<button type="button" disabled class="btn btn-secondary btn-icon" data-toggle="tooltip" title="Delete Data"><i class="fas fa-trash-alt"></i></button>&nbsp;
							<button type="button" class="btn btn-primary btn-icon btn-list-peserta" data-pk="${row.SysId}" data-toggle="tooltip" title="List Peserta"><i class="fas fa-users"></i></button>`;
						} else {
							return `<button type="button" data-pk="${row.SysId}" class="btn btn-warning btn-icon btn-edit" data-toggle="tooltip" title="Edit/Update data"><i class="fas fa-edit"></i></button>&nbsp;
                        <button type="button" class="btn btn-danger btn-icon btn-delete" data-toggle="tooltip" title="Delete Data"><i class="fas fa-trash-alt"></i></button>&nbsp;
						<button type="button" class="btn btn-info btn-icon btn-add-peserta" data-pk="${row.SysId}" data-toggle="tooltip" title="Tambah Peserta"><i class="fas fa-user-plus"></i></button>&nbsp;
						<button type="button" class="btn btn-primary btn-icon btn-list-peserta" data-pk="${row.SysId}" data-toggle="tooltip" title="List Peserta"><i class="fas fa-users"></i></button>`;
						}
					}
				},

			],
			order: [
				[3, "DESC"]
			],
			columnDefs: [{
				className: "align-middle text-center",
				targets: [0, 1, 2, 3, 4, 6, 9, 10, 11],
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

	var TableData = $("#Table-Employee").DataTable({
		destroy: true,
		processing: true,
		serverSide: true,
		paging: true,
		dom: 'rtip',
		orderCellsTop: true,
		// select: true,
		fixedHeader: {
			header: true,
			headerOffset: 48
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
					return `<div class="form-check">
                    <input type="checkbox" value="${row.UserName}" id="${row.UserName}" name="IDs[]">
                  </div>`
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
				visible: false,
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
				data: "Label_Tunjangan_Lain",
				name: "Label_Tunjangan_Lain",
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
				visible: false,
			},
			{
				data: "No_Rekening",
				name: "No_Rekening",
				visible: false,
			},
			{
				data: "KTP",
				name: "KTP",
				visible: false,
			},
			{
				data: "Telpon",
				name: "Telpon",
			},
			{
				data: "Email",
				name: "Email",
				visible: false,
			},
			{
				data: "Gender",
				name: "Gender",
			},
			{
				data: "Status_Pernikahan",
				name: "Status_Pernikahan",
				visible: false,
			},
			{
				data: "Tanggal_Join",
				name: "Tanggal_Join",
				visible: false,
			},
			{
				data: "Full_address",
				name: "Full_address",
				visible: false,
			},
			{
				data: "is_active",
				name: "is_active",
				visible: false,
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

	$(document).on('click', '.btn-delete', function () {
		let data = $("#TableData").DataTable().row($(this).parents('tr')).data();
		let SysId = data.SysId;
		let No_Meeting = data.No_Meeting;
		Swal.fire({
			title: 'System message!',
			text: `Apakah anda yakin untuk menghapus data rapat : ${No_Meeting}, Data tidak dapat dikembalikan !`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "Rapat/Delete",
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

	$(document).on('click', '.btn-edit', function () {
		$("#location").empty()
		$.ajax({
			url: $('meta[name="base_url"]').attr('content') + "Rapat/Edit",
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

	$(document).on('click', '.btn-add-peserta', function () {
		let data = $("#TableData").DataTable().row($(this).parents('tr')).data();
		let SysId = data.SysId;
		let No_Meeting = data.No_Meeting;

		$('#form-add-member')[0].reset();

		$('#table-title-detail').text(`Form Penambahan Peserta Rapat, Pada Kegiatan Rapat : ${No_Meeting}`);
		$('#SysId_Add').val(SysId);
		$('#No_Meeting').val(No_Meeting);

		$('#Modal-add-member').modal('show');
	})

	$('#submit-peserta').click(function (e) {
		if ($('input:checked').length > 0) {
			Swal.fire({
				title: 'Loading....',
				html: '<div class="spinner-border text-primary"></div>',
				showConfirmButton: false,
				allowOutsideClick: false,
				allowEscapeKey: false
			});
			Fn_Submit_Form_Peserta($('#form-add-member').serialize())
		} else {
			Swal.fire({
				icon: 'warning',
				title: 'Oops...',
				text: 'Harap pilih peserta rapat !',
				footer: '<a href="javascript:void(0)">Notifikasi System</a>'
			});
		}

	});

	function Fn_Submit_Form_Peserta(DataForm) {
		$.ajax({
			dataType: "json",
			type: "POST",
			url: $('meta[name="base_url"]').attr('content') + "Rapat/Store_peserta_rapat",
			data: DataForm,
			success: function (response) {
				Swal.close()
				if (response.code == 200) {
					$("#TableData").DataTable().ajax.reload();
					$('#Modal-add-member').modal('hide');
					Swal.fire({
						icon: 'success',
						title: 'Success!',
						text: response.msg,
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ya, Confirm!'
					})
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: response.msg,
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

	$(document).on('click', '.btn-approve-admin', function () {
		let data = $("#TableData").DataTable().row($(this).parents('tr')).data();
		let SysId = data.SysId;
		let No_Meeting = data.No_Meeting;
		Swal.fire({
			title: 'System message!',
			text: `Apakah anda yakin untuk approve kegiatan rapat : ${No_Meeting}, setelahi approve admin, tunjangan rapat akan di kalkulasi pada payroll !`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Approve!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "Rapat/Approve_Admin",
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
})
