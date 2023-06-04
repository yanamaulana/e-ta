$(document).ready(function () {
	// $.ajax({
	//     type: "GET",
	//     url: $('meta[name="base_url"]').attr('content') + "Dashboard/tbl_today_material_rcv",
	//     data: {
	//         company: 'self'
	//     },
	//     success: function (response) {
	//         $('#column--1').html(response);
	//     },
	//     error: function (e) {
	//         console.log(e)
	//     }
	// });

	// $.ajax({
	//     type: "GET",
	//     url: $('meta[name="base_url"]').attr('content') + "Dashboard/tbl_today_material_alloc_prd",
	//     data: {
	//         company: 'self'
	//     },
	//     success: function (response) {
	//         $('#column--2').html(response);
	//     },
	//     error: function (e) {
	//         console.log(e)
	//     }
	// });

	$('#Today-Schedule').DataTable({
		dom: 'frtip',
		"lengthMenu": [
			[1000],
			[1000]
		],
		columnDefs: [{
			className: "align-middle text-center",
			targets: [0, 1, 2, 3, 4],
		}],
		order: [3, 'asc'],
	});
})
