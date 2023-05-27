function loadAnimation() {
    loadingPercent("#loading-percent",0);
    setTimeout(showPage, 3000);
}
function loadingPercent(display,current) {
    $(display).text(current);      
    if(current < 100){
        setTimeout(()=>loadingPercent(display,current+1),17);
    }
}
function showPage() {
    $("#loading").css("display", "none");
    $("#login-form").css("display", "flex");
}
function format_curency(a) {
    a.value = a.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

$(document).ready(function () {
    
    function append0Letter(t) {
        if(t<10){
            return "0"+t;
        }else{
            return t;
        }
    }
    function getTime() {
        var today = new Date();
        var date = today.getDate();
        var month = today.getMonth()+1;
        var year = today.getFullYear();
        var hour = today.getHours() ;
        var minute = today.getMinutes();
        var second = today.getSeconds();

        date = append0Letter(date);
        month = append0Letter(month);
        hour = append0Letter(hour);
        minute = append0Letter(minute);
        second = append0Letter(second);

        this_day = date +"."+month+"."+year;
        this_time = hour +":"+minute+":"+second;

        $("#current-day").text(this_day);
        $("#current-time").text(this_time);
        setTimeout(getTime, 500);
    }
    getTime();

});

function showPassword() {
    const ipnElement = document.querySelector('#password')
    const currentType = ipnElement.getAttribute('type')
    if($(event.target).hasClass("ri-lock-password-fill")){
        $(event.target).removeClass("ri-lock-password-fill");
        $(event.target).addClass("ri-lock-unlock-fill");
    }else{
        $(event.target).addClass("ri-lock-password-fill");
        $(event.target).removeClass("ri-lock-unlock-fill");
    }
    ipnElement.setAttribute(
        'type',
        currentType === 'password' ? 'text' : 'password'
    )
}


