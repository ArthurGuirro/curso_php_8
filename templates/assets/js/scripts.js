$( document ).ready(function() {
    $("#busca").keyup(function(){
        var busca = $(this).val();
        if (busca.length > 0){
            $.ajax({
                url:$('form').attr('data-url-busca'),
                method: 'POST',
                data: {
                    busca:busca
                },
                success: function (resultado){
                    
                        if (resultado){
                            $('#buscaResultado').html(resultado);
                        } else {
                            $('#buscaResultado').html('<div class ="alert alert-warning"Nenhum resultado encontrado!</div>');
                        }
                    
                    
                }
            });
            $('#buscaResultado').show();
        } else {
            $('#buscaResultado').hide();
        }
    });
});                







