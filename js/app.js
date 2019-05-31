$(document).ready(function () {

	$('#po_number').keyup(function (e) {
		var keycode = e.keyCode || e.which;

		if (keycode === 39) {
			e.preventDefault();

			$data = {'po_number': $(this).val()};
			ajaxCall('logic/plateNumber.php', $data, $('#plateNumber'), $('#message'));
		}
	});

	$('#peo_number').keyup(function (e) {
		var keycode = e.keyCode || e.which;

		if (keycode === 39) {
			e.preventDefault();
			
			$data = {'peo_number': $(this).val()};

			ajaxCall('logic/storePlateNumber.php', $data, $('#plateNo'), $('#message'));
		}
	});


	function ajaxCall(url, data, plate_element, message) {

		$.ajax({
			type: 'post',
			url: url,
			data: data,
			dataType: 'json',
			success: function (response) {
				if(response.plate_number === null) {
					message.text('Invalid PO').css("color", "red");
				}
				plate_element.val(response.plate_number);
			},
			error: function (e) {
				console.log(e);
			}
		});
	}


});