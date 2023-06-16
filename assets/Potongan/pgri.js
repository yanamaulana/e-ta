$(document).ready(function () {

});
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
			// paging: true,
			dom: 'lBfrtip',
			select: true,
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
				url: $('meta[name="base_url"]').attr('content') + "PotonganPgri/DT_Potongan_karyawan",
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
					data: "ID",
					name: "ID",
				},
				{
					data: "UserName",
					name: "UserName",
				},
				{
					data: "Nama",
					name: "Nama",
					visible: false,
				},
				{
					data: "Nominal",
					name: "Nominal",
					render: function (data) {
						return rupiah(data);
					}
				},
				{
					data: "Terbilang",
					name: "Terbilang",
				}
			],
			order: [
				[3, "ASC"]
			],
			columnDefs: [{
				className: "align-middle text-center",
				targets: [0, 1, 2, 3, 5],
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
				$('[data-toggle="tooltip"]').tooltip();
			},
			"buttons": [{
				text: `Export to :`,
				className: "btn disabled text-dark bg-white",
			}, {
				text: `<i class="far fa-copy fs-2"></i>`,
				extend: 'copy',
				className: "btn btn-light-warning",
			}, {
				text: `<i class="far fa-file-excel fs-2"></i>`,
				extend: 'excelHtml5',
				footer: true,
				title: $('#table-title-detail').text() + '~' + moment().format("YYYY-MM-DD"),
				className: "btn btn-light-success",
			}, {
				text: `<i class="far fa-file-pdf fs-2"></i>`,
				extend: 'pdfHtml5',
				title: $('#table-title-detail').text() + '~' + moment().format("YYYY-MM-DD"),
				className: "btn btn-light-danger",
				footer: true,
				orientation: "landscape"
			}, {
				text: `<i class="fas fa-print fs-2"></i>`,
				extend: 'print',
				footer: true,
				className: "btn btn-light-dark",
			}],
		}).buttons().container().appendTo('#TableData_wrapper .col-md-6:eq(0)');
	}

	Fn_Initialized_DataTable()

	$(document).on('click', '.btn-delete-dtl', function () {
		let data = $("#TableData").DataTable().row($(this).parents('tr')).data();
		let SysId = data.SysId;
		let No_Meeting_Hdr = data.No_Meeting_Hdr;
		Swal.fire({
			title: 'System message!',
			text: `Apakah anda yakin untuk menghapus kepesertaan anda dari rapat : ${No_Meeting_Hdr}, Data tidak dapat dikembalikan !`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, hapus!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: $('meta[name="base_url"]').attr('content') + "Rapat/Delete_Dtl",
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
})
