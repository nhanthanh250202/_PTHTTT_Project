$(document).ready(function () {
    const premoney = parseInt($("#premoney").val());
    const VND = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
      });
    $("#total").text(VND.format(calcuTotal()));
    $("#total_bill_text").text(VND.format(calcuTotal()-premoney));
    
    $("#preorder").text(VND.format($("#preorder").text()));
    function calcuTotal() {
        var total =  parseInt($("#room_price").val());
        var n = $(".service-table tr").length;
        for (let i = 1; i < n; i++) {
            price_val = $("#price-" + i).text().split(',').join('');
            amount_val = $("#amount-" + i).val();
            
            this_amount_val = parseInt(amount_val);
            this_price_val = parseInt(price_val);
            if ($("#check-" + i).is(':checked')) {
                total += this_amount_val* this_price_val;
            }
        }
        $.ajax({
            type: "post",
            url: "payment.php",
            data: {total:total},
            success: function (response) {
                $("#coupon").html(response);
            }
        });
        return(total);
    }

    $("#coupon").change(function (e) { 
        //@ ! Thực hiện trừ chiết khấu tại đây!!!!!
        
        coupon = $("#coupon").val();
        if(!$("#coupon").val()){
            coupon = 0;
        }
        discount_bill = parseInt($("#total").text().split('.').join('').split('₫').join(''));

        $.ajax({
            type: "post",
            url: "payment.php",
            data: { coupon:coupon, discount_bill:discount_bill},
            success: function (response) {
                $("#coupon-apply").html("-"+VND.format(response));
                total_bill = parseInt($("#total").text().split('.').join('').split('₫').join('')) + parseInt($("#coupon-apply").text().split('.').join('').split('₫').join(''));
                $("#coupon_discount").val(parseInt($("#coupon-apply").text().split('.').join('').split('₫').join('')));
                $("#total_bill").val(total_bill-premoney);
                $("#total_bill_text").text(VND.format(total_bill-premoney));
            }
        });
    });
    $("#print-btn").click(function (e) { 
        id = $("#id").val();
        var coupon_discount = parseInt($("#coupon-apply").text().split('.').join('').split('₫').join(''));
        var url = "print.php?print=" +id;
        $.ajax({
            type: "post",
            url: url,
            data: {coupon_discount: coupon_discount},
            success: function () {
                document.location.href= url;
            }
        });
    });
    $("#tab-2 #myTable tr td").click(function (e) { 
        var row_index = $(this).parent().index()+1;
        if ($("#check-"+row_index).is(':checked')==false){
            $("#check-"+row_index).prop('checked',true);
            $(".service-selector").change();
        }else{
            $("#check-"+row_index).prop('checked',false);
            $(".service-selector").change();
        }
    });
    $(".service-selector").change(function (e) { 
        $(this).closest('tr').toggleClass("highlight", this.checked);
        $("#coupon").change();
        $("#total").text(VND.format(calcuTotal()));
    });
    $(".amount-input").change(function (e) { 
        if($(".amount-input").val() <0){
            $(".amount-input").val(0);
        }
        $("#coupon").change();
        $("#total").text(VND.format(calcuTotal()));
        
    });
});