$('document').ready ->

    $('#tabs').tabs()

    $('.monthpicker').monthpicker({pattern: "m/y"})

    $('#month-selector').bind "click", ->
        $(location).attr("href", statsUrl + $('.monthpicker').val() )