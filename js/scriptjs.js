$(document).ready(function(){    
    var menuAtivo = $('.top .active').attr('id');
    var modalCadastro;
    
    $('.btncadastrarusuario').click(function(){
        var alturaInicioFundo = 0;
        var alturaInicio = window.innerHeight * 0.2;
        var tempoModalFundo = 1;
        var tempoModal = 500;
        modalCadastro = true;
        
        $('.modalcadastro').animate({top: alturaInicioFundo},tempoModalFundo);
        $('.modal_cadastro').animate({top: alturaInicio},tempoModal);                
    });
    
    $('.btnfecharcadastro').click(function(){
        var alturaFim = window.innerHeight + (window.innerHeight * 0.01);
        var tempoModal = 500;
        modalCadastro = false;

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
    
    $('input[name="submitPeladeiro"]').click(function(){
        var dados = $('.formcadastrousuario').serialize();
        
        $.ajax({
            type: "POST",
            url: "cadastrousuario.php",
            data: dados,
            success: function(retorno) {
                //alert(retorno);
                $(".modal-head-msg").html(retorno);
            }
        }); 
        return false;
    });    
});
