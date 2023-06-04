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

	$('#archive').click(function () {
		let SysId = $('#SysId').val();

		Swal.fire({
			title: 'System Message!',
			text: `Are you sure to archive your schedule ?`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					dataType: "json",
					type: "POST",
					url: $('meta[name="base_url"]').attr('content') + "My_Schedule/Store_Archive_Schedule",
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
						Swal.close()
						if (response.code == 200) {
							$('#el-action').hide();
							$('#el-status').html(`<button type="button" class="form-control btn btn-light-secondary"><i class="fas fa-archive"></i> Archive Schedule : Not-Active</button>`)
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
									window.location.href = $('meta[name="base_url"]').attr('content') + "FormSchedule";
								}
							})
						} else {
							Toast.fire({
								icon: 'error',
								title: response.msg
							});
						}
					},
					error: function () {
						Swal.close()
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'A error occured, please report this error to administrator !',
							footer: '<a href="javascript:void(0)">Notifikasi System</a>'
						});
					}
				});
			}
		})
	})
});
