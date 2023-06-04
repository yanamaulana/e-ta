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

	$('input[name="Date_Att"]').flatpickr({
		dateFormat: "Y-m-d",
		maxDate: "today"
	});

	var TableBrowse = $("#TableBrowse").DataTable({
		dom: 'lfrtip',
		orderCellsTop: true,
		select: {
			style: 'single'
		},
		fixedHeader: {
			header: true,
			headerOffset: 48
		},
		columnDefs: [{
			"visible": false,
			"targets": 7
		}, {
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4, 5, 6]
		}],
		autoWidth: false,
		responsive: true,
		"rowCallback": function (row, data) {
			// if (data.is_active == "0") {
			// 	$('td', row).css('background-color', 'pink');
			// }
		},
		preDrawCallback: function () {
			$("#TableBrowse tbody td").addClass("blurry");
		},
		language: {
			processing: '<i style="color:#4a4a4a" class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only"></span><p><span style="color:#4a4a4a" style="text-align:center" class="loading-text"></span> ',
			searchPlaceholder: "Search..."
		},
		drawCallback: function () {
			$("#TableBrowse tbody td").addClass("blurry");
			setTimeout(function () {
				$("#TableBrowse tbody td").removeClass("blurry");
			});
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$('#select-data').on('click', function () {
		let Dataa = TableBrowse.rows({
			selected: true
		}).data()[0];

		$('#Schedule_ID').val(Dataa[7])
		$('#Schedule').val(Dataa[1] + ', ' + Dataa[2] + ', ' + Dataa[3] + ', ' + Dataa[4] + ' : Stand Hour (' + Dataa[6] + ')');
		$('#modal-browse').modal('hide');
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
				text: `Are you sure to submit this data ?`,
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
			url: $('meta[name="base_url"]').attr('content') + "SubmissionAttendance/Store_New_SubmissionAttendance",
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
					Swal.fire({
						title: 'System Message !',
						text: response.msg,
						icon: 'success',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes'
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = $('meta[name="base_url"]').attr('content') + "SubmissionAttendance";
						}
					})
					DataForm[0].reset();
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
});
