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
		// select: true,
		fixedHeader: {
			header: true,
			headerOffset: 48
		},
		"lengthMenu": [
			[10, 25, 100, 1000],
			[10, 25, 100, 1000]
		],
		ajax: {
			url: $('meta[name="base_url"]').attr('content') + "Master/DT_List_Office_Position",
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
				data: "Jabatan",
				name: "Jabatan",
			},
			{
				data: "Kode_Jabatan",
				name: "Kode_Jabatan",
			},
			{
				data: "is_active",
				name: "is_active",
				render: function (data, type, row, meta) {
					if (data == 1) {
						return `<button class="btn btn-sm btn-icon btn-success is-active" data-pk="${row.SysId}" data-toggle="tooltip" title="Status: aktif"><i class="fas fa-check-circle"></i></button>`;
					} else {
						return `<button class="btn btn-sm btn-icon btn-danger is-active" data-pk="${row.SysId}" data-toggle="tooltip" title="Status: non-aktif"><i class="fas fa-times-circle"></i></button>`;
					}
				}
			},
		],
		order: [
			[1, "ASC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3],
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
				$('#modal-add').modal('show');
			}
		}, {
			text: `<i class="fas fa-edit"></i>`,
			className: "btn btn-default disabled",
			action: function (e, dt, node, config) {
				var RowData = dt.rows({
					selected: true
				}).data();
				// if (RowData.length == 0) {
				// 	Swal.fire({
				// 		icon: 'warning',
				// 		title: 'Ooppss...',
				// 		text: 'Please select data to be update !',
				// 		footer: '<a href="javascript:void(0)" class="text-danger">Notifikasi System</a>'
				// 	});
				// } else {
				// 	Init_Append_Modal_Update(RowData[0].SysId)
				// }
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
			text: `Are you sure to change activation status ?`,
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
					url: $('meta[name="base_url"]').attr('content') + "Master/Toggle_status_general",
					data: {
						SysId: $(this).attr('data-pk'),
						TabelData: 'tmst_jabatan'
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

	$('#form_add').validate({
		errorElement: 'span',
		errorPlacement: function (error, element) {
			error.addClass('invalid-feedback');
			element.closest('.fv-row').append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		}
	});
	$.validator.setDefaults({
		debug: true,
		success: 'valid'
	});

	$('#submit--new--data').click(function (e) {
		e.preventDefault();
		if ($("#form_add").valid()) {
			Swal.fire({
				title: 'System Message !',
				text: `Are you sure to add new record ?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					Init_Submit_Form($('#form_add'))
				}
			})
		} else {
			$('html, body').animate({
				scrollTop: ($('.error:visible').offset().top - 200)
			}, 400);
		}
	});

	function Init_Submit_Form(DataForm) {
		let BtnAction = $('#submit--new--data');
		$.ajax({
			dataType: "json",
			type: "POST",
			url: $('meta[name="base_url"]').attr('content') + "Master/Store_New_Office_Position",
			data: DataForm.serialize(),
			beforeSend: function () {
				BtnAction.prop("disabled", true);
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
					$("#TableData").DataTable().ajax.reload(null, false);
					DataForm[0].reset();
					$('#modal-add').modal('hide');
				} else {
					Toast.fire({
						icon: 'error',
						title: response.msg
					});
				}
				BtnAction.prop("disabled", false);
			},
			error: function () {
				Swal.close()
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'A error occured, please report this error to administrator !',
					footer: '<a href="javascript:void(0)">Notifikasi System</a>'
				});
				BtnAction.prop("disabled", false);
			}
		});
	}


})
