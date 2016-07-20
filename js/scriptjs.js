$(document).ready(function(){    
    var menuAtivo = $('.top .active').attr('id');

    $('.btncadastrarusuario').click(function(){
        var alturaInicioFundo = 0;
        var alturaInicio = window.innerHeight * 0.1;
        var tempoModalFundo = 1;
        var tempoModal = 500;
        
        $('.modalcadastro').animate({top: alturaInicioFundo},tempoModalFundo);
        $('.modal_cadastro').animate({top: alturaInicio},tempoModal);
    });
    
    $('.btnfecharcadastro').click(function(){
        var alturaFim = window.innerHeight + (window.innerHeight * 0.01);
        var tempoModal = 500;

        $('.modalcadastro').animate({top: alturaFim},tempoModal);
        $('.modal_cadastro').animate({top: alturaFim},tempoModal);
    }); 
    
    $('.auxiliar label').click(function(){
        var checked = $('.manterlogado').attr('checked');
        
        if(checked != 'checked'){
            $('.manterlogado').attr('checked','checked');
        }
        else{
            $('.manterlogado').removeAttr('checked');
        }
        /*
        $('.seuCheckbox').attr('checked','checked');
        //desmarcar
        $('.seuCheckbox').removeAttr('checked');*/
    });
});
