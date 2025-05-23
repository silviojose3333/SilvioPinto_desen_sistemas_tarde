function toggleSubmenu() {
    const submenu = document.getElementById('submenuForm');
    submenu.classList.toggle('show');
}

window.addEventListener('click', function (e) {
    const submenu = document.getElementById('submenuForm');
    const button = document.querySelector('.submenu-wrapper button');
    if (!submenu.contains(e.target) && !button.contains(e.target)) {
        submenu.classList.remove('show');
    }
});
function abrirModal(nome,serie,form) {
    document.getElementById(form).style.display = "flex";
    document.getElementById("nomeEscolhido").textContent = nome;
    document.getElementById("inputNome").value = serie;
    document.body.classList.add("modal-open");
  }
  function abrir(id) {
    document.getElementById(id).style.display = 'flex';
}
function fechar(id) {
    document.getElementById(id).style.display = 'none';
}
  function mostrarSenha(){
    var senha1=document.getElementById("senha");
    var senha2=document.getElementById("confirmar_senha");
    var tipo=senha1.type==="password"? "text":"password";
    senha1.type= tipo
    senha2.type= tipo
}
function pedidoLogar() {
    if (confirm("Loge na sua conta para avaliar essa obra")) {
        // Redireciona se o usuário clicar em "OK"
        window.location.href = "login.php";
    } 
}