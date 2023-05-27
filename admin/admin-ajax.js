$(document).ready(function () {
    $("#room").change(function (e) { 
        var selected_room = $("#room").val();
        $.ajax({
            type: "post",
            url: "fcmanager.php",
            data: {selected_room: selected_room},
            success: function (data) {
                $("#device-room-table").html(data);
            }
        });
    });
});