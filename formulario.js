//EXECUTAR MASCARAS
function mascara(o,f){
    objeto=o
    funcao=f
    setTimeout("executaMascara()")
}
function executaMascara(){
    objeto.value=funcao(objeto.value)
}
//MASCARAS

//MASCARA DO TELEFONE
function telefone(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/^(\d\d)(\d)/g,"($1) $2")
    variavel=variavel.replace(/(\d{4})(\d)/,"$1-$2")
    return variavel
}
//Mascara do RG e CPF
function RGeCPF(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2")
    variavel=variavel.replace(/(\d{3})(\d)/,"$1.$2")
    variavel=variavel.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
    return variavel

}
//Mascara do CEP
function cep(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/(\d{2})(\d)/,"$1.$2")
    variavel=variavel.replace(/(\d{3})(\d{1,3})$/,"$1-$2")
    return variavel
}
//Mascara do Data
function data(variavel){
    variavel=variavel.replace(/\D/g,"")
    variavel=variavel.replace(/(\d{2})(\d)/,"$1/$2")
    variavel=variavel.replace(/(\d{2})(\d)/,"$1/$2")
    return variavel
}
