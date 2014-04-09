$(function(){
    var specialKeys = new Array();
    specialKeys.push(8);
    $(document).on('click','.time-input',function(){ this.select(); });
    $(".time-input").bind("keypress", function (e) {
        var keyCode = e.which ? e.which : e.keyCode;
        var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
        return ret;
    });
    $(".time-input").bind("keyup", function (e) {
        var dhis = $(this);
        var value = parseInt(dhis.val());
        console.log(value);
        if((value < 0) || (value > 60)) {
            dhis.val('00');
            this.select();
        }

    });

    $(".time-input").bind("paste", function (e) {
        return false;
    });
    $(".time-input").bind("drop", function (e) {
        return false;
    });

});