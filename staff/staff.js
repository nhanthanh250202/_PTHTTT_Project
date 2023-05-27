$(document).ready(function () {

    window.onclick = function(e) {
        if (!e.target.matches('label.hamburger') && !e.target.matches('input#action-menu')){
            $(".hamburger ~ div").css("display", "none");
            $("input#action-menu").prop('checked',false)
        }
    }



    function padTo2Digits(num) {
        return num.toString().padStart(2, '0');
    }
    function formatDate(date) {
        return (
            [
            date.getFullYear(),
            padTo2Digits(date.getMonth() + 1),
            padTo2Digits(date.getDate()),
            ].join('-') +
            ' ' +
            [
            padTo2Digits(date.getHours()),
            padTo2Digits(date.getMinutes()),
            ].join(':')
        );
    }
    
    function setCurrentTime() {
        const [date, time] = formatDate(new Date()).split(' ');
        return date + 'T' + time;
    }

    $("#ortime").val(setCurrentTime());
    $("#intime").val(setCurrentTime());

    $("#type").change(function () {     
        if($("#type").prop('checked')){
            $(".popping").css("display", "flex");
            // $("#input-checkbox").text("Thông thường");
            $("#input-checkbox").addClass("box-checked");
            $("#input-checkbox").addClass("box-unchecked");
        }else{
            $(".popping").css("display", "none");
            // $("#input-checkbox").text("Điền thông tin");
            $("#input-checkbox").removeClass("box-checked");
            $("#input-checkbox").addClass("box-unchecked");
        }
    });

    $("#refresh").click(function () {
        $("#room").css("display", "block");
        var key;
        var time = $("#intime").val();;
        if ($("#type-room").text() == "Phòng VIP") {
            $("#type-room").text("Phòng Thường");
            $("#type-of-room").val(2);
            key = 2;
        }else{
            $("#type-of-room").val(1);
            $("#type-room").text("Phòng VIP");
            key = 1;
        }
        $.ajax({
            type: "post",
            url: "dashboard.php",
            data: {key: key, time:time},
            success: function (response) {
                $("#room").html(response);
            }
        });
    });
    $("#intime").change(function () {
        $("#error").css("display", "none");
        $("#error").text("");
        var intime = Date.parse($("#intime").val());
        var ortime = Date.parse($("#ortime").val());

        if (ortime<intime) {
            $("#room").css("display", "block");
            var key;
            var time = $("#intime").val();;
            if ($("#type-room").text() == "Phòng VIP") {
                $("#type-room").text("Phòng Thường");
                $("#type-of-room").val(1);
                key = 1;
            }else{
                $("#type-of-room").val(2);
                $("#type-room").text("Phòng VIP");
                key = 2;
            }
            $.ajax({
                type: "post",
                url: "dashboard.php",
                data: {key: key, time:time},
                success: function (response) {
                    $("#room").html(response);
                }
            });
        }else{
            $("#error").css("display", "block");
            $("#error").text("Giờ vào phòng phải sau giờ đặt");
        }



    });
    $("#order-money").text(function format_curency(a) {
        a.value = a.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    });
});
function checkValid() {
    if ($("#room option:selected").val()=="") {
        $("#error-room").text("Vui lòng chọn phòng");
        return false;
    }
}