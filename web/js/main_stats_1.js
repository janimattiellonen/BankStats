$('document').ready(function() {
    $('#tabs').tabs();
    $('.monthpicker').monthpicker({
      pattern: "m/y"
    });
    $('.datepicker').datepicker({
      dateFormat: "dd.mm.yy"
    });
    return $('#month-selector').bind("click", function() {
      return $(location).attr("href", statsUrl + $('.monthpicker').val());
    });
  });
