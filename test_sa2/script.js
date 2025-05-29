
function toggleSubmenu(index) {
    const submenu = document.getElementById('submenu-' + index);
    if (submenu) {
        submenu.classList.toggle('show');
    }

}

function inicializarEstrelas(containerId, inputId) {
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    const estrelas = container.querySelectorAll('.estrela');
    let notaSelecionada = 0;

    estrelas.forEach((estrela) => {
      const valor = parseInt(estrela.dataset.value);

      // Hover
      estrela.addEventListener('mouseenter', () => {
        estrelas.forEach(e => {
          e.classList.toggle('hover', parseInt(e.dataset.value) <= valor);
        });
      });

      estrela.addEventListener('mouseleave', () => {
        estrelas.forEach(e => e.classList.remove('hover'));
      });

      // Clique
      estrela.addEventListener('click', () => {
        notaSelecionada = valor;
        input.value = valor;

        estrelas.forEach(e => {
          e.classList.toggle('selecionada', parseInt(e.dataset.value) <= valor);
        });
      });
    });
  }

  // Fecha submenus ao clicar fora

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