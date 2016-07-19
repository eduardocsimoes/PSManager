$(document).ready(function(){    
    var menuAtivo = $('.top .active').attr('id');

    $('.btncadastrarusuario').click(function(){
        var alturaInicio = 0;
        var tempoMenu = 500;
        
        $('.modalcadastro').animate({top: alturaInicio},tempoMenu);
    });
    
    $('.btnfecharcadastro').click(function(){
        var alturaFim = window.innerHeight + (window.innerHeight * 0.01);        
        var tempoMenu = 500;
        
        $('.modalcadastro').animate({top: alturaFim},tempoMenu);
    });         
});
