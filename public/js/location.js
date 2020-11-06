function seleccionarRegion() {
    var region = $('#region').val();
    if(region && region > 0) {
        $.ajax({
            url: '/provincias',
            type: "Get",
            dataType: 'json',//this will expect a json response
            data: {
                id: $('#region').val()
            }, 
            success: function(response) {
                $('#provincia').empty();
                $('#comuna').empty();
                $('#provincia').append($('<option>', { 
                    value: 0,
                    text : '...'
                }));
                response.map(function(provincia) {
                    $('#provincia').append($('<option>', { 
                        value: provincia.id,
                        text : provincia.nombre
                    }));
                });
            }
        });
    } else {
        $('#provincia').empty();
        $('#comuna').empty();
    }
}

function seleccionarProvincia() {
    var provincia = $('#provincia').val();
    if(provincia && provincia > 0) {
        $.ajax({
            url: '/comunas',
            type: "Get",
            dataType: 'json',//this will expect a json response
            data: {
                id: $('#provincia').val()
            }, 
            success: function(response) {
                $('#comuna').empty();
                $('#comuna').append($('<option>', { 
                    value: 0,
                    text : '...'
                }));
                response.map(function(comuna) {
                    $('#comuna').append($('<option>', { 
                        value: comuna.id,
                        text : comuna.nombre
                    }));
                });
            }
        });
    } else {
        $('#comuna').empty();
    }
}