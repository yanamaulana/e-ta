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
		$('#TableData>tbody>tr:last-child').find('td:eq(1) select').val('')
		$('#TableData>tbody>tr:last-child').find('td:eq(2) select').val('')
		$('#TableData>tbody>tr:last-child').find('td:eq(4)').find('input').val('00:00');
		$('#TableData>tbody>tr:last-child').find('td:eq(5)').find('input').val('00:00');
		$('#TableData>tbody>tr:last-child').find('td:eq(6) select').val('')

		$('#TableData>tbody>tr:last-child').find('td:eq(3)').empty();
		let selectRaw = $('#raw_select').clone()
		$('#TableData>tbody>tr:last-child').find('td:eq(3)').html(selectRaw);
		$('#TableData>tbody>tr:last-child').find('td:eq(3) select').attr("id", "select_" + NewNo);
		$('#select_' + NewNo).select2()
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

	$('#form_update').validate({
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
		if ($("#form_update").valid()) {
			Swal.fire({
				title: 'System Message !',
				text: `Are you sure to save change this schedule ?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes'
			}).then((result) => {
				if (result.isConfirmed) {
					Init_Submit_Form($('#form_update'))
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
			url: $('meta[name="base_url"]').attr('content') + "My_Schedule/Store_Update_Schedule",
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
