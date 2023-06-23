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

	$('input[name="time_start[]"]').flatpickr({
		enableTime: true,
		noCalendar: true,
		time_24hr: true,
		dateFormat: "H:i",
	});
	$('input[name="time_over[]"]').flatpickr({
		enableTime: true,
		noCalendar: true,
		time_24hr: true,
		dateFormat: "H:i",
	});

	var TableData = $("#TableData").DataTable({
		paging: false,
		orderCellsTop: true,
		lengthChange: false,
		"info": false,
		fixedHeader: {
			header: true,
			headerOffset: 48
		},
		order: [
			[1, "ASC"]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3],
		}],
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
	});

	$('#add-row').on('click', function () {
		let LastNo = $('#TableData>tbody>tr:last-child').find('td:eq(0)').html();
		let NewNo = parseInt(LastNo) + 1;

		let Row = $('#TableData>tbody>tr:last-child').clone();
		let subject = $('#subject').clone()
		$('#TableData tbody').append(Row);
		$('#TableData>tbody>tr:last-child').find('td:eq(0)').html(NewNo);

		$('input[name="time_start[]"]').flatpickr({
			enableTime: true,
			noCalendar: true,
			time_24hr: true,
			dateFormat: "H:i",
		});
		$('input[name="time_over[]"]').flatpickr({
			enableTime: true,
			noCalendar: true,
			time_24hr: true,
			dateFormat: "H:i",
		});
		$('#TableData>tbody>tr:last-child').find('td:eq(4)').find('input').val('00:00');
		$('#TableData>tbody>tr:last-child').find('td:eq(5)').find('input').val('00:00');

		$('#TableData>tbody>tr:last-child').find('td:eq(3)').empty();
		let selectRaw = $('#raw_select').clone()
		$('#TableData>tbody>tr:last-child').find('td:eq(3)').html(selectRaw);
		$('#TableData>tbody>tr:last-child').find('td:eq(3) select').attr("id", "select_" + NewNo);
		$('#select_' + NewNo).select2()

		$(".subject").rules("add", {
			required: true,
		});
		$(".day").rules("add", {
			required: true,
		});
		$(".time_start").rules("add", {
			required: true,
		});
		$(".time_over").rules("add", {
			required: true,
		});
		$(".stand_hour").rules("add", {
			required: true,
		});
	})

	$('#remove-row').on('click', function () {
		var rowCount = $('#TableData tbody tr').length;
		if (rowCount > 1) {
			$('#TableData>tbody>tr:last-child').remove();
		} else {
			Toast.fire({
				icon: 'error',
				title: 'Cannot delete last row !'
			});
		}
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

	$('#submit--data').click(function (e) {
		e.preventDefault();
		if ($("#form_add").valid()) {
			Swal.fire({
				title: 'System Message !',
				text: `Are you sure to submit this schedule ?`,
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
		let BtnAction = $('#submit--data');
		$.ajax({
			dataType: "json",
			type: "POST",
			url: $('meta[name="base_url"]').attr('content') + "FormSchedule/Store_New_Schedule",
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
					$('#add-row').prop('disabled', true);
					$('#remove-row').prop('disabled', true);
					$('input').prop('disabled', true);
					$('select').prop('disabled', true);
					$('#submit--data').prop('disabled', true);
					$('#cancel-form').prop('disabled', true);

					$('#schedule_number').val(response.Schedule_Number)
					Swal.fire({
						title: 'System Message!',
						text: response.msg,
						icon: 'success',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes'
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = $('meta[name="base_url"]').attr('content') + "My_Schedule/index/" + response.ID;
						}
					})
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: response.msg,
						footer: '<a href="javascript:void(0)">Notifikasi System</a>'
					});
				}
				BtnAction.prop("disabled", false);
			},
			error: function (xhr, status, error) {
				var statusCode = xhr.status;
				var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.responseText ? xhr.responseText : "Terjadi kesalahan: " + error;
				Swal.fire({
					icon: "error",
					title: "Error!",
					html: `Kode HTTP: ${statusCode}<br\>Pesan: ${errorMessage}`,
				});
				BtnAction.prop("disabled", false);
			}
		});
	}
})
