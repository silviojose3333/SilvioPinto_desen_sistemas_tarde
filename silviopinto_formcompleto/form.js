function mascara(o,f){
    objeto=o
    funcao=f
    setTimeout("executaMascara()")
}
function executaMascara(){
    objeto.value=funcao(objeto.value)
}
function RG(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/(\d{2})(\d)/,"$1.$2")
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2")
    variavel=variavel.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return variavel

}
function CPF(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2")
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2")
    return variavel

}
//Mascara do CEP
function cep(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/(\d{2})(\d)/,"$1.$2")
    return variavel
}
function Num(variavel){
    variavel=variavel.replace(/\D/g,"")
    return variavel
}
function Lt(variavel){
    variavel=variavel.replace(/[0-9]/g,"")
    return variavel
}