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

	var tbl = $('#Table-Event').DataTable({
		"destroy": true,
		"processing": true,
		"serverSide": true,
		"ordering": true,
		// "select": true,
		"order": [
			[0, 'desc'],
		],
		"ajax": {
			"url": $('meta[name="base_url"]').attr('content') + "HistoryPayroll/Event_Payroll_DataTable",
			"type": "GET",
		},
		"columns": [{
			data: "SysId",
			name: "SysId",
			visible: false,
			order: false,
			render: function (data, type, row, meta) {
				return meta.row + meta.settings._iDisplayStart + 1;
			}
		}, {
			data: null,
			name: "Handle",
			orderable: false,
			render: function (data, type, row, meta) {
				if (row.Payment_Status == 0) {
					return `<div class="btn-group-vertical" role="group">
                    <button class="btn btn-icon btn-sm btn-warning btn-recalculate" data-toggle="tooltip" title="Recalculate slip ${row.Tot_Employee_Calculated} karyawan"><i class="fas fa-calculator"></i></button>
                    <button class="btn btn-icon btn-sm btn-primary btn-print-all" data-toggle="tooltip" title="Print slip ${row.Tot_Employee_Calculated} karyawan"><i class="fas fa-print"></i></button>
                    <button class="btn btn-icon btn-sm btn-success btn-finish" data-toggle="tooltip" title="Ubah status jadi selesai dibayarkan"><i class="fas fa-flag-checkered"></i></button>
                    <button class="btn btn-icon btn-sm btn-danger btn-delete" data-toggle="tooltip" title="delete"><i class="fas fa-trash"></i></button>
                    </div>`;
				} else {
					return `<div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-icon btn-secondary" data-toggle="tooltip" title="Gaji ${row.Tot_Employee_Calculated} karyawan Telah diBayar"><i class="fas fa-flag-checkered"></i></button>
                    <button class="btn btn-icon btn-primary btn-print-all" data-toggle="tooltip" title="Print slip ${row.Tot_Employee_Calculated} karyawan"><i class="fas fa-print"></i></button></div>`;
				}
			}
		}, {
			data: "TagID",
			name: "TagID "
		}, {
			data: "Tot_Employee_Calculated",
			name: "Tot_Employee_Calculated "
		}, {
			data: "Tgl_Dari",
			name: "Tgl_Dari "
		}, {
			data: "Tgl_Sampai",
			name: "Tgl_Sampai "
		}, {
			data: "Created_by",
			name: "Created_by "
		}, {
			data: "Payment_Status",
			name: "Payment_Status",
			render: function (data, type, row, meta) {
				if (row.Payment_Status == 0) {
					return `<span class="badge badge-warning blink_me">UnPaid</span>`;
				} else {
					return `<span class="badge badge-success">Paid</span>`;
				}
			}
		}],
		columnDefs: [{
			className: "text-center",
			targets: [1, 2, 3, 4, 5, 6, 7],
		}],
		bAutoWidth: false,
		responsive: true,
		rowCallback: function (row, data) {
			// for change color tr
		},
		preDrawCallback: function () {
			$("#Table-Event  tbody td").addClass("blurry");
		},
		language: {
			processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" class="loading-text">Loading Data</span> ',
		},
		drawCallback: function () {
			// Swal.close()
			setTimeout(function () {
				$("#Table-Event  tbody td").removeClass("blurry");
			});
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$(document).on('click', '.btn-delete', function () {
		let data = tbl.row($(this).parents('tr')).data();
		let sysid = data.SysId;
		let TagID = data.TagID;
		Swal.fire({
			title: 'Apakah Anda Yakin ?',
			text: `Untuk Menghapus data kalkulasi ${TagID}, Data tidak dapat dikembalikan!`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "HistoryPayroll/delete_event_payroll/" + sysid,
					type: "GET",
					dataType: "json",
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
						if (response.code == '200' || response.code == 200) {
							console.log(response);
							tbl.ajax.reload();
							$('#Table-Hdr').DataTable().destroy();
							return swal.fire({
								title: 'Terhapus!',
								text: response.msg,
								icon: 'success',
								showConfirmButton: true,
								allowOutsideClick: false,
								allowEscapeKey: false
							})
						} else {
							return swal.fire({
								title: "Error!",
								text: "Terjadi kesalahan teknis",
								icon: "error",
								allowOutsideClick: false,
							});
						}
					},
					error: function () {
						return swal.fire({
							title: "Error!",
							text: "Terjadi kesalahan teknis, Hubungi MIS dept!",
							icon: "error",
							allowOutsideClick: false,
						});
					}
				});
			}
		})
	})

	$(document).on('click', '.btn-finish', function () {
		let data = tbl.row($(this).parents('tr')).data();
		let sysid = data.SysId;
		let TagID = data.TagID;
		Swal.fire({
			title: 'Apakah Anda Yakin ?',
			text: `Untuk Menyatakan data gaji ${TagID}, Telah Paid !`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Confirm!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "HistoryPayroll/change_status_event_payroll/" + sysid,
					type: "GET",
					dataType: "json",
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
						Swal.close();
						if (response.code == 200) {
							$('#Table-Event').DataTable().ajax.reload();
							$('#Table-Hdr').DataTable().destroy();
							Swal.fire(
								'Status Diubah!',
								'Data Kalkulasi Berhasil dinyatakan paid !',
								'success'
							)
						} else {
							swal.fire({
								title: "Error!",
								text: "Terjadi kesalahan teknis",
								icon: "error",
								allowOutsideClick: false,
							});
						}
					},
					error: function () {
						swal.fire({
							title: "Error!",
							text: "Terjadi kesalahan teknis, Hubungi MIS dept!",
							icon: "error",
							allowOutsideClick: false,
						});
					}
				});
			}
		})
	})

	$(document).on('click', '.btn-print-all', function () {
		let data = tbl.row($(this).parents('tr')).data();

		window.open($('meta[name="base_url"]').attr('content') + `HistoryPayroll/Print_Event/${data.SysId}`, 'WindowReport-Event', 'width=800,height=600');
	})

	$(document).on('click', '.btn-recalculate', function () {
		let data = tbl.row($(this).parents('tr')).data();
		let sysid = data.SysId;
		let TagID = data.TagID;

		Swal.fire({
			title: 'Apakah Anda Yakin ?',
			text: `Untuk mengkalkulasikan ulang riwayat gaji ${TagID} ?`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, ulang!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "HistoryPayroll/Recalculate/" + sysid,
					type: "GET",
					dataType: 'json',
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
							$('#Table-Hdr').DataTable().destroy();
							$('#Table-Hdr tbody').empty();
							Swal.fire({
								title: "Berhasil!",
								text: response.msg,
								icon: "success",
								allowOutsideClick: false,
							});
							setTimeout(function () {
								window.location.href = window.location;
							}, 2000);
						} else {
							Swal.fire({
								title: "Error!",
								text: response.msg,
								icon: "error",
								allowOutsideClick: false,
							});
						}
					},
					error: function () {
						Swal.fire({
							title: "Error!",
							text: "Terjadi kesalahan teknis, Hubungi teknisi!",
							icon: "error",
							allowOutsideClick: false,
						});
					}
				});
			}
		});
	})

	function Fn_Initialized_DataTable_Hdr(TagID) {
		var tbl_hdr = $('#Table-Hdr').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			"ordering": true,
			// "select": true,
			dom: 'lfrtip',
			"pageLength": 10,
			"order": [
				[3, 'asc']
			],
			"ajax": {
				"url": $('meta[name="base_url"]').attr('content') + "HistoryPayroll/Hdr_Payroll_DataTable",
				"type": "POST",
				data: {
					TagID: TagID
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
				data: "Work_Status",
				name: "Work_Status "
			}, {
				data: "Jabatan",
				name: "Jabatan "
			}, {
				data: "is_active",
				name: "is_active ",
				render: function (data, type, row, meta) {
					if (data == 0) {
						return '<button class="btn btn-sm btn-secondary">Not-Active</i></button>'
					} else {
						return '<button class="btn btn-success btn-sm"><i class="fas fa-check"></i> Active</i></button>'
					}
				}
			}, {
				data: "SysId",
				name: "action",
				orderable: false,
				render: function (data, type, row, meta) {
					if (row.kasbon == 0 || row.Payment_Status == 1) {
						return `<div class="btn-group-vertical" role="group">
                        <button data-pk="${row.SysId}" class="btn btn-sm btn-icon btn-success btn-detail" data-toggle="tooltip" title="detail waktu absensi"><i class="fas fa-calendar-alt"></i></button>
                        <button class="btn btn-icon btn-primary btn-sm btn-icon btn-print-hdr" data-toggle="tooltip" title="Print slip gaji ${row.Nama}"><i class="fas fa-print"></i></button>
                        </div>`;
					} else {
						// <button data-pk="${row.SysId}" class="btn btn-sm btn-icon btn-warning btn-kasbon" data-toggle="tooltip" title="Potongan Kasbon"><i class="fas fa-fax"></i></button>
						return `<div class="btn-group-vertical" role="group">
                        <button data-pk="${row.SysId}" class="btn btn-sm btn-icon btn-success btn-detail" data-toggle="tooltip" title="detail waktu absensi"><i class="fas fa-calendar-alt"></i></button>
                        <button class="btn btn-icon btn-primary btn-sm btn-print-hdr" data-toggle="tooltip" title="Print slip gaji ${row.Nama}"><i class="fas fa-print"></i></button>
                        </div>`;
					}
				}
			}],
			columnDefs: [{
				className: "text-center",
				targets: [1, 2, 3, 4, 5, 6],
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

	$('#Table-Event tbody').on('dblclick', 'tr', function () {
		let Row = tbl.row(this).data();
		Fn_Initialized_DataTable_Hdr(Row.TagID)
		console.log(Row.TagID)
	});

	$('#Table-Hdr').DataTable();

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

	// ==================================================== Modul kasbon blm di perlukan
	// $(document).on('click', '.btn-kasbon', function () {
	// 	let sysid = $(this).attr('data-pk');
	// 	$("#location").empty()
	// 	$.ajax({
	// 		url: "/AppendModal/PotongKasbon/" + sysid,
	// 		type: "GET",
	// 		beforeSend: function () {
	// 			Swal.fire({
	// 				title: 'Loading....',
	// 				html: '<div class="spinner-border text-primary"></div>',
	// 				showConfirmButton: false,
	// 				allowOutsideClick: false,
	// 				allowEscapeKey: false
	// 			})
	// 		},
	// 		success: function (ajaxData) {
	// 			Swal.close()
	// 			$("#location").html(ajaxData);
	// 			$("#Modal-Kasbon").modal('show');
	// 		},
	// 		error: function () {
	// 			Swal.fire({
	// 				title: "Error!",
	// 				text: "Terjadi kesalahan teknis, Hubungi MIS dept!",
	// 				icon: "error",
	// 				allowOutsideClick: false,
	// 			});
	// 		}
	// 	});
	// })
});
