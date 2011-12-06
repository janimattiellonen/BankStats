$('document').ready ->

    $('#tabs').tabs()

    $('.monthpicker').monthpicker({pattern: "m/y"})
    $('.datepicker').datepicker({dateFormat: "dd.mm.yy"})

    $('#month-selector').bind "click", ->
        $(location).attr("href", statsUrl + $('.monthpicker').val() )