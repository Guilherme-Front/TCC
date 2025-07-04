// Seleciona o botão e o body
const escuro = document.querySelector("#button-tema");
const body = document.body;

// Verifica se o tema escuro está ativado no localStorage
let isDarkMode = localStorage.getItem("darkMode") === "true";

// Aplica o tema salvo ao carregar a página
if (isDarkMode) {
  ativarModoEscuro();
}

// Adiciona evento de clique no botão para alternar os temas
escuro.addEventListener("click", clickbutton);

function clickbutton() {
  isDarkMode = !isDarkMode; // Alterna entre claro e escuro
  localStorage.setItem("darkMode", isDarkMode); // Salva no localStorage

  if (isDarkMode) {
    ativarModoEscuro();
  } else {
    ativarModoClaro();
  }
}

function ativarModoEscuro() {
  /* Início Tela Principal */
  body.style.backgroundColor = "#1E1E1E";

  const car = document.querySelector(".car");
  if (car) car.style.color = "white";
  document.querySelectorAll(".nav-link").forEach((item) => {
    item.style.color = "white";
    item.style.setProperty("--after-background-color", "white");
  });

  const tlPa = document.querySelector("main");
  if (tlPa) tlPa.style.backgroundColor = "#1E1E1E";

  const tlP = document.querySelector(".tl-p");
  if (tlP) tlP.style.color = "white";

  const carousel3 = document.querySelector(".carousel-3");
  if (carousel3) carousel3.style.backgroundColor = "#212121";

  const prevTema = document.querySelector("#prev-tema");
  if (prevTema) prevTema.src = "../../public/img/angulo-esquerdo-tema.png";

  const nextTema = document.querySelector("#next-tema");
  if (nextTema) nextTema.src = "../../public/img/angulo-direito-tema.png";

  document
    .querySelectorAll(".cart-gatos")
    .forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  document
    .querySelectorAll(
      ".cart-titulo-gatos, .cart-titulo-dog, .cart-titulo-coelho, .cart-titulo-ham, .cart-titulo-PI"
    )
    .forEach((item) => (item.style.color = "white"));

  document
    .querySelectorAll(".cart-p-gatos")
    .forEach((item) => (item.style.color = "white"));

  const marca = document.querySelector(".marca");
  if (marca) marca.style.backgroundColor = "rgba(255, 110, 62)";

  const userIMG = document.querySelector(".user-img");
  if (userIMG) userIMG.src = "../../public/img/usuarioBranco.png";

  const headerTema = document.querySelector(".header-tema");
  if (headerTema) headerTema.src = "../../public/img/modo-escuro.png";
  /* Fim Tela Principal */

  /* Início Cadastro */
  const cadastroContent = document.querySelector(".cadastro-content");
  if (cadastroContent) cadastroContent.style.backgroundColor = "#1E1E1E";

  const cadastroT = document.querySelector(".cadastro-titulo");
  if (cadastroT) cadastroT.style.color = "white";

  const cadastroLabels = document.querySelectorAll(".cadastro-label");
  if (cadastroLabels.length > 0) {
    cadastroLabels.forEach((item) => (item.style.color = "white"));
  }

  const cadastroVoltar = document.querySelector(".cadastro-voltar");
  if (cadastroVoltar) cadastroVoltar.style.color = "white";

  const cadastroP = document.querySelector(".cadastro-p");
  if (cadastroP) cadastroP.style.color = "white";

  const inpC = document.querySelectorAll(".input-cadastro");
  inpC.forEach((item) => {
    item.style.backgroundColor = "#3e3e3e";
    item.style.color = "white";
  });
  /* Fim Cadastro */

  /* Início Login */
  const loginC = document.querySelector(".login-content");
  if (loginC) loginC.style.backgroundColor = "#1E1E1E";

  const loginT = document.querySelector(".login-titulo");
  if (loginT) loginT.style.color = "white";

  const loginLabels = document.querySelectorAll(".login-label");
  if (loginLabels.length > 0) {
    loginLabels.forEach((item) => (item.style.color = "white"));
  }

  const voltar = document.querySelector(".voltar");
  if (voltar) voltar.style.color = "white";

  const loginP = document.querySelector(".login-p");
  if (loginP) loginP.style.color = "white";

  const loginR = document.querySelector(".login-resto");
  if (loginR) loginR.style.color = "white";

  const loginConta = document.querySelector(".login-conect");
  if (loginConta) loginConta.style.color = "white";

  const senha = document.querySelector("#Senha");
  if (senha) {
    senha.style.backgroundColor = "#3e3e3e";
    senha.style.color = "white";
  }

  const email = document.querySelector("#Email");
  if (email) {
    email.style.backgroundColor = "#3e3e3e";
    email.style.color = "white";
  }
  /* Fim Login */

  /* Início Senha/Redefinir */
  const senhaT = document.querySelector(".senha-titulo");
  if (senhaT) senhaT.style.color = "white";

  const senhaI = document.querySelectorAll(".input");
  if (senhaI) {
    senhaI.forEach((item) => (item.style.backgroundColor = "#3e3e3e"));
    senhaI.forEach((item) => (item.style.color = "white"));
  }
  /* Fim Senha/Redefinir */

  /* Início FAQ */
  const perguntasF = document.querySelector(".faq-flex");
  if (perguntasF) perguntasF.style.backgroundColor = "rgb(53 180 127)";

  const titulo = document.querySelector(".faq-titulo");
  if (titulo) titulo.style.color = "white";

  const paragrafh = document.querySelectorAll(".faq-p");
  if (paragrafh) paragrafh.forEach((item) => (item.style.color = "white"));

  const question = document.querySelector(".faq-question");
  if (question) question.style.backgroundColor = "#3f3e3e";

  const h4 = document.querySelectorAll(".h4");
  if (h4) h4.forEach((item) => (item.style.color = "white"));

  const message = document.querySelectorAll(".text");
  if (message) message.forEach((item) => (item.style.color = "white"));

  const questions = document.querySelectorAll(".faq-questions");
  if (questions)
    questions.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));
  /* Fim FAQ */

  /* Início Fale Conosco */
  const faleC = document.querySelector(".fl-flex");
  if (faleC) faleC.style.backgroundColor = "rgb(53 180 127)";

  const faleP = document.querySelector(".fl-p");
  if (faleP) faleP.style.color = "white";

  const labelF = document.querySelectorAll(".inp-fl");
  if (labelF) labelF.forEach((item) => (item.style.color = "white"));

  const inputF = document.querySelectorAll(".fl-inp");
  if (inputF) {
    inputF.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));
    inputF.forEach((item) => (item.style.color = "white"));
  }
  /* Fim Fale Conosco */

  /* Início Pet Info */
  const petI = document.querySelector(".pet-flex");
  if (petI) petI.style.backgroundColor = "#212121";

  const petT = document.querySelectorAll(".pet-titulo");
  if (petT) petT.forEach((item) => (item.style.color = "white"));

  const petP = document.querySelectorAll(".pet-p");
  if (petP) petP.forEach((item) => (item.style.color = "white"));
  /* Fim Pet Info */

  /* Início Perfil*/
  const seta = document.querySelector(".botao-voltar");
  if (seta) seta.src = "../../public/img/desfazer.png";

  const formaP = document.querySelectorAll(".item-button");
  if (formaP)
    formaP.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  const texto = document.querySelectorAll(".texto");
  if (texto) texto.forEach((item) => (item.style.color = "white"));

  const resumoP = document.querySelector(".resumo");
  if (resumoP) resumoP.style.backgroundColor = "#3f3e3e";

  const dadosP = document.querySelector(".dados-pagamento");
  if (dadosP) dadosP.style.backgroundColor = "#3f3e3e";

  const carrinho = document.querySelector(".carrinho-compras");
  if (carrinho) carrinho.src = "../../public/img/carrinho-de-compras.png";

  const menu = document.querySelector(".menu-lateral");
  if (menu) menu.style.backgroundColor = "#212121";

  const menu2 = document.querySelector(".menu-lateral-fn");
  if (menu2) menu2.style.backgroundColor = "#212121";

  const files = document.querySelectorAll("#file");
  files.forEach((file) => {
    file.src = "../../public/img/usuario-do-arquivo.png";
  });

  const addproduto = document.querySelector("#addproduto");
  if (addproduto) addproduto.src = "../../public/img/adicionar-produto.png";

  const produtoc = document.querySelector("#produtoc");
  if (produtoc) produtoc.src = "../../public/img/produtos.png";

  const order = document.querySelector("#order");
  if (order) order.src = "../../public/img/historico-de-pedidos.png";

  const mapa = document.querySelector("#mapa");
  if (mapa) mapa.src = "../../public/img/sugestao.png";

  const home = document.querySelector("#house");
  if (home) home.src = "../../public/img/map-marker.png";

  /* Início Hover Inicial Dados */
  var greyI = document.querySelectorAll(".item-menu.ativo");
  greyI.forEach(function (item) {
    item.style.backgroundColor = "#3f3e3e"; // Defina a cor de fundo
  });
  /* Fim Hover Inicial Dados */

  /* Início Hover */
  var menuItem = document.querySelectorAll(".item-menu");
  function selectLink() {
    // Remove a classe 'ativo' de todos os itens
    menuItem.forEach((item) => {
      item.classList.remove("ativo");
      item.style.backgroundColor = ""; // Remove o estilo de cor de fundo quando não está ativo
    });

    this.classList.add("ativo");
    this.style.backgroundColor = "#3f3e3e";
  }

  // Definir a cor de fundo quando o mouse passar por cima
  function setHoverBackground() {
    if (!this.classList.contains("ativo")) {
      this.style.backgroundColor = "#545353";
    }
  }

  // Remover a cor de fundo quando o mouse sair do item (caso não esteja ativo)
  function removeHoverBackground() {
    if (!this.classList.contains("ativo")) {
      this.style.backgroundColor = "";
    }
  }

  menuItem.forEach((item) => {
    item.addEventListener("click", selectLink);
    item.addEventListener("mouseover", setHoverBackground);
    item.addEventListener("mouseout", removeHoverBackground);
  });

  const back = document.querySelector(".item-menu-logoff");
  if (back) {
    back.addEventListener("mouseover", sair);
    back.addEventListener("mouseout", volta);

    function sair() {
      back.style.backgroundColor = "#3f3e3e"; // Cor quando o mouse passar
    }

    function volta() {
      back.style.backgroundColor = ""; // Resetando o estilo para o original definido no CSS
    }
  }
  /* Fim Hover */

  const links = document.querySelectorAll(".txt-link");
  if (links.length > 0) {
    links.forEach((item) => {
      item.style.color = "white";
    });
  }

  const logoff = document.querySelector(".txt-logoff");
  if (logoff) logoff.style.color = "white";

  const section = document.querySelector("main");
  if (section) section.style.backgroundColor = "#212121";

  const bv = document.querySelector(".boas-vindas");
  if (bv) bv.style.color = "white";

  const dados = document.querySelectorAll(".dados");
  if (dados) dados.forEach((item) => (item.style.color = "white"));

  const enviar = document.querySelectorAll(".enviar-foto");
  if (enviar) enviar.forEach((item) => (item.style.color = "white"));

  const perfilD = document.querySelectorAll(".perfilD");
  if (perfilD)
    perfilD.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  const MinhaC = document.querySelector(".minha-conta");
  if (MinhaC) MinhaC.style.color = "white";

  const PC = document.querySelector(".titulo-categoria");
  if (PC) PC.style.backgroundColor = "#3f3e3e";

  const func = document.querySelector(".user-imgF");
  if (func) func.src = "../../public/img/adm.png";

  /* Fim Perfil */

  /* Início Tela Produtos */
  const circulo = document.querySelectorAll(".circulo");
  if (circulo)
    circulo.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  const tipo = document.querySelectorAll(".tipo");
  if (tipo) tipo.forEach((item) => (item.style.color = "white"));

  const products = document.querySelectorAll(".produtos");
  if (products)
    products.forEach((item) => (item.style.backgroundColor = "#212121"));

  const product = document.querySelectorAll(".produto");
  if (product)
    product.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  const desc = document.querySelectorAll(".descricao");
  if (desc) desc.forEach((item) => (item.style.color = "white"));

  const produtosP = document.querySelectorAll(".produto");
  produtosP.forEach((produto) => {
    produto.addEventListener("mouseover", () => {
      mudarBoxShadow("rgba(58, 58, 58, 0.3)", produto); // Muda para vermelho no hover
    });

    produto.addEventListener("mouseout", () => {
      mudarBoxShadow("rgba(0, 0, 0, 0.1)", produto);
    });
  });

  // Função para alterar o box-shadow
  function mudarBoxShadow(cor, produto) {
    produto.style.boxShadow = `0 3px 10px 10px ${cor}`;
  }

  const pFirst = document.querySelectorAll(".produto p:first-of-type");
  if (pFirst.length > 0) {
    pFirst.forEach((item) => {
      item.style.color = "white";
    });
  }

  /* Fim Tela Produtos */

  /* Início Info Gatos */
  const petC = document.querySelector("main");
  if (petC) petC.style.color = "white";

  const color3 = document.querySelector(".pet-info-curiosidade");
  if (color3) color3.style.backgroundColor = "#212121";

  const color = document.querySelector(".pet-info-alimentação");
  if (color) color.style.backgroundColor = "#212121";

  const color1 = document.querySelector(".pet-info-doenças");
  if (color1) color1.style.backgroundColor = "#212121";

  const color2 = document.querySelector(".pet-info-vacinas");
  if (color2) color2.style.backgroundColor = "#212121";
  /* Fim Info Gatos */

  /* Início Info Dogs */
  const petD = document.querySelector("main");
  if (petD) petD.style.color = "white";

  const fundo3 = document.querySelector(".pet-dog-vacinas");
  if (fundo3) fundo3.style.backgroundColor = "#212121";

  const fundo = document.querySelector(".pet-dog-curiosidade");
  if (fundo) fundo.style.backgroundColor = "#212121";

  const fundo1 = document.querySelector(".pet-dog-alimentação");
  if (fundo1) fundo1.style.backgroundColor = "#212121";

  const fundo2 = document.querySelector(".pet-dog-doenças");
  if (fundo2) fundo2.style.backgroundColor = "#212121";

  const fundo5 = document.querySelector(".pet-container-doenças");
  if (fundo5) fundo5.style.backgroundColor = "#212121";

  const fundo6 = document.querySelector(".pet-container-vacinas");
  if (fundo6) fundo6.style.backgroundColor = "#212121";
  /* Fim Info Dogs */

  /* Início Info Dogs */
  const petH = document.querySelector("main");
  if (petH) petH.style.color = "white";

  const background = document.querySelector(".pet-ham-vacinas");
  if (background) background.style.backgroundColor = "#212121";

  const background1 = document.querySelector(".pet-ham-curiosidade");
  if (background1) background1.style.backgroundColor = "#212121";

  const background2 = document.querySelector(".pet-ham-alimentação");
  if (background2) background2.style.backgroundColor = "#212121";

  const background3 = document.querySelector(".pet-ham-doenças");
  if (background3) background3.style.backgroundColor = "#212121";
  /* Fim Info Dogs */

  /* Início Info coelhos */
  const petM = document.querySelector("main");
  if (petM) petM.style.color = "white";

  const back4 = document.querySelector(".pet-coelhos-vacinas");
  if (back4) back4.style.backgroundColor = "#212121";

  const back1 = document.querySelector(".pet-coelhos-curiosidade");
  if (back1) back1.style.backgroundColor = "#212121";

  const back2 = document.querySelector(".pet-coelhos-alimentação");
  if (back2) back2.style.backgroundColor = "#212121";

  const back3 = document.querySelector(".pet-coelhos-doenças");
  if (back3) back3.style.backgroundColor = "#212121";
  /* Fim Info coelhos */

  /* Início Info porquinho */
  const main = document.querySelector("main");
  if (main) main.style.color = "white";

  const fundoE = document.querySelector(".pet-porquinho-vacinas");
  if (fundoE) fundoE.style.backgroundColor = "#212121";

  const fundoE1 = document.querySelector(".pet-porquinho-curiosidade");
  if (fundoE1) fundoE1.style.backgroundColor = "#212121";

  const fundoE2 = document.querySelector(".pet-porquinho-alimentação");
  if (fundoE2) fundoE2.style.backgroundColor = "#212121";

  const fundoE3 = document.querySelector(".pet-porquinho-doenças");
  if (fundoE3) fundoE3.style.backgroundColor = "#212121";
  /* Fim Info porquinho */

  /*Inicio Info Produtos */
  const description = document.querySelector(".descricao-container");
  if (description) description.style.backgroundColor = "#212121";

  const avaliação = document.querySelector(".avaliaçâo");
  if (avaliação) avaliação.style.backgroundColor = "rgb(42 41 41)";

  const information = document.querySelector(".Produto");
  if (information) information.style.backgroundColor = "rgb(42 41 41)";

  const regredir = document.querySelector(".voltar");
  if (regredir) regredir.style.backgroundColor = "rgb(42 41 41)";

  const pInfo = document.querySelector(".p-information");
  if (pInfo) pInfo.style.color = "white";

  const prev = document.querySelector(".carousel-control-prev");
  if (prev) prev.style.color = "white";

  const lr = document.querySelectorAll(".label-radio");
  if (lr) lr.forEach((item) => (item.style.backgroundColor = "#212121"));

  const radios = document.querySelectorAll('input[type="radio"]');
  radios.forEach((radio) => {
    radio.addEventListener("change", function () {
      document.querySelectorAll(".label-radio").forEach((label) => {
        label.style.border = "";
      });

      if (this.checked) {
        const label = this.nextElementSibling;
        label.style.border = "2px solid white";
      }
    });
  });

  const trycar = document.querySelector(".try-car");
  if (trycar) trycar.src = "../../public/img/adicionar-ao-carrinho.png";

  const petcomentario = document.querySelectorAll(
    ".txt-comentario p:nth-of-type(3)"
  );
  if (petcomentario) {
    petcomentario.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));
    petcomentario.forEach((item) => (item.style.color = "white"));
  }

  const quant = document.querySelector(".button-add");
  if (quant) quant.style.backgroundColor = "#3f3e3e";

  const quant1 = document.querySelector(".button-add2");
  if (quant1) quant1.style.backgroundColor = "#3f3e3e";

  const quant2 = document.querySelector(".input-add");
  if (quant2) quant2.style.backgroundColor = "#3f3e3e";

  const add = document.querySelector(".adicionar-comentario");
  if (add) add.style.backgroundColor = "#3f3e3e";

  const add2 = document.querySelectorAll(".comentario");
  if (add2) add2.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  const txt = document.querySelectorAll(".data-comentario");
  if (txt) txt.forEach((item) => (item.style.color = "white"));

  const txt2 = document.querySelectorAll(".texto-comentario");
  if (txt2) txt2.forEach((item) => (item.style.color = "white"));

  /*Fim Info Produtos */

  /* Inicio Cadastrar Produtos */
  const voltaIndex = document.querySelector(".voltar-index");
  if (voltaIndex) voltaIndex.style.color = "white";

  const containerInfo = document.querySelector(".container-info");
  if (containerInfo) containerInfo.style.color = "white";

  const spanC = document.querySelector(".spanC");
  if (spanC) spanC.style.color = "black";

  const style = document.createElement("style");
  style.textContent = `.txt::placeholder { color: black; }`;
  document.head.appendChild(style);

  const enviarIMG = document.querySelector(".container-img");
  if (enviarIMG) enviarIMG.style.backgroundColor = "white";
  /* Fim Cadastros produtos */

  /* Inicio Tela Pedido */
  const EspacoP = document.querySelector(".espaço-produtos");
  if (EspacoP) EspacoP.style.backgroundColor = "#3f3e3e";

  const EspacoT = document.querySelectorAll(".dolado");
  if (EspacoT) EspacoT.forEach((item) => (item.style.color = "black"));

  const spanT = document.querySelectorAll(".spam");
  if (spanT) spanT.forEach((item) => (item.style.color = "black"));

  const spanT1 = document.querySelectorAll(".spam1");
  if (spanT1) spanT1.forEach((item) => (item.style.color = "black"));

  const valorP = document.querySelectorAll(".valor");
  if (valorP) valorP.forEach((item) => (item.style.color = "black"));

  const user = document.querySelectorAll(".user");
  if (user)
    user.forEach((item) => (item.src = "../../public/img/usuarioBranco.png"));
  /* Fim Tela Pedido */

  /* Inicio Tela Carrinho */
  document.body.classList.add("tema-escuro");

  const dadosC = document.querySelectorAll(".dados");
  if (dadosC) dadosC.forEach((item) => (item.style.color = "white"));

  const totalP = document.querySelector(".total");
  if (totalP) totalP.style.backgroundColor = "#3f3e3e";

  const quantC = document.querySelectorAll(".button-add");
  if (quantC) quantC.forEach((item) => (item.style.color = "white"));

  const quantC2 = document.querySelectorAll(".button-add2");
  if (quantC2) quantC2.forEach((item) => (item.style.color = "white"));

  const inputC = document.querySelectorAll(".input-add");
  if (inputC) inputC.forEach((item) => (item.style.color = "white"));

  const carrinhoC = document.querySelector(".carrinhoC");
  if (carrinhoC) carrinhoC.src = "../../public/img/carrinho-de-compras.png";
  /* Fim Tela Carrinho */

  /* quem somos */
  const quem = document.querySelector(".quem-somos");
  if (quem) quem.style.backgroundColor = "#212121";
  /* fim quem somos */

  /* Inicio Cuidados */
  const cuidadoG = document.querySelector(".cuidados-gato");
  if (cuidadoG) cuidadoG.style.backgroundColor = "#212121";

  const cuidadoD = document.querySelector(".cuidados-dogs");
  if (cuidadoD) cuidadoD.style.backgroundColor = "#212121";

  const cuidadoH = document.querySelector(".cuidados-ham");
  if (cuidadoH) cuidadoH.style.backgroundColor = "#212121";

  const cuidadoC = document.querySelector(".cuidados-coelho");
  if (cuidadoC) cuidadoC.style.backgroundColor = "#212121";

  const cuidadoP = document.querySelector(".cuidados-porquinho");
  if (cuidadoP) cuidadoP.style.backgroundColor = "#212121";
  /* Fim Cuidados */
}

function ativarModoClaro() {
  /* Início Tela Principal */
  body.style.backgroundColor = "white";

  const car = document.querySelector(".car");
  if (car) car.style.color = "black";

  document.querySelectorAll(".nav-link").forEach((item) => {
    item.style.color = "black";
    item.style.setProperty("--after-background-color", "black");
  });

  const tlPa = document.querySelector("main");
  if (tlPa) tlPa.style.backgroundColor = "white";

  const tlP = document.querySelector(".tl-p");
  if (tlP) tlP.style.color = "black";

  const carousel3 = document.querySelector(".carousel-3");
  if (carousel3) carousel3.style.backgroundColor = "#f5f5f5";

  const prevTema = document.querySelector("#prev-tema");
  if (prevTema) prevTema.src = "../../public/img/angulo-esquerdo.png";

  const nextTema = document.querySelector("#next-tema");
  if (nextTema) nextTema.src = "../../public/img/angulo-direito.png";

  document
    .querySelectorAll(".cart-gatos")
    .forEach((item) => (item.style.backgroundColor = "#f3f3f3"));

  document
    .querySelectorAll(
      ".cart-titulo-gatos, .cart-titulo-dog, .cart-titulo-coelho, .cart-titulo-ham, .cart-titulo-PI"
    )
    .forEach((item) => (item.style.color = "black"));

  document
    .querySelectorAll(".cart-p-gatos")
    .forEach((item) => (item.style.color = "black"));

  const marca = document.querySelector(".marca");
  if (marca) marca.style.removeProperty("background-color");

  const userIMG = document.querySelector(".user-img");
  if (userIMG) userIMG.src = "../../public/img/user.png";

  const headerTema = document.querySelector(".header-tema");
  if (headerTema) headerTema.src = "../../public/img/tema.png";
  /* Fim Tela Principal */

  /* Início Cadastro */
  const cadastroContent = document.querySelector(".cadastro-content");
  if (cadastroContent) cadastroContent.style.backgroundColor = "white";

  const cadastroT = document.querySelector(".cadastro-titulo");
  if (cadastroT) cadastroT.style.color = "black";

  const cadastroLabels = document.querySelectorAll(".cadastro-label");
  if (cadastroLabels.length > 0) {
    cadastroLabels.forEach((item) => (item.style.color = "black"));
  }

  const cadastroVoltar = document.querySelector(".cadastro-voltar");
  if (cadastroVoltar) cadastroVoltar.style.color = "black";

  const cadastroP = document.querySelector(".cadastro-p");
  if (cadastroP) cadastroP.style.color = "black";

  const inpC = document.querySelectorAll(".input-cadastro");
  inpC.forEach((item) => {
    item.style.backgroundColor = "#a2a2a2";
    item.style.color = "black";
  });
  /* Fim Cadastro */

  /* Início Login */
  const loginC = document.querySelector(".login-content");
  if (loginC) loginC.style.backgroundColor = "white";

  const loginT = document.querySelector(".login-titulo");
  if (loginT) loginT.style.color = "black";

  const loginLabels = document.querySelectorAll(".login-label");
  if (loginLabels.length > 0) {
    loginLabels.forEach((item) => (item.style.color = "black"));
  }

  const voltar = document.querySelector(".voltar");
  if (voltar) voltar.style.color = "black";

  const loginP = document.querySelector(".login-p");
  if (loginP) loginP.style.color = "black";

  const loginR = document.querySelector(".login-resto");
  if (loginR) loginR.style.color = "black";

  const loginConta = document.querySelector(".login-conect");
  if (loginConta) loginConta.style.color = "black";

  const senha = document.querySelector("#Senha");
  if (senha) {
    senha.style.backgroundColor = "#a2a2a2";
    senha.style.color = "black";
  }

  const email = document.querySelector("#Email");
  if (email) {
    email.style.backgroundColor = "#a2a2a2";
    email.style.color = "black";
  }
  /* Fim Login */

  /* Início Senha/Redefinir */
  const senhaT = document.querySelector(".senha-titulo");
  if (senhaT) senhaT.style.color = "black";

  const senhaI = document.querySelectorAll(".input");
  if (senhaI) {
    senhaI.forEach((item) => (item.style.backgroundColor = "#a2a2a2"));
    senhaI.forEach((item) => (item.style.color = "black"));
  }
  /* Fim Senha/Redefinir */

  /* Início FAQ */
  const perguntasF = document.querySelector(".faq-flex");
  if (perguntasF) perguntasF.style.backgroundColor = "#034b31";

  const titulo = document.querySelector(".faq-titulo");
  if (titulo) titulo.style.color = "black";

  const paragrafh = document.querySelectorAll(".faq-p");
  if (paragrafh) paragrafh.forEach((item) => (item.style.color = "black"));

  const question = document.querySelector(".faq-question");
  if (question) question.style.backgroundColor = "#F4F4F4";

  const h4 = document.querySelectorAll(".h4");
  if (h4) h4.forEach((item) => (item.style.color = "black"));

  const message = document.querySelectorAll(".text");
  if (message) message.forEach((item) => (item.style.color = "black"));

  const questions = document.querySelectorAll(".faq-questions");
  if (questions)
    questions.forEach((item) => (item.style.backgroundColor = "#F4F4F4"));
  /* Fim FAQ */

  /* Início Fale Conosco */
  const faleC = document.querySelector(".fl-flex");
  if (faleC) faleC.style.backgroundColor = "#034b31";

  const faleP = document.querySelector(".fl-p");
  if (faleP) faleP.style.color = "white";

  const labelF = document.querySelectorAll(".inp-fl");
  if (labelF) labelF.forEach((item) => (item.style.color = "white"));

  const inputF = document.querySelectorAll(".fl-inp");
  if (inputF) {
    inputF.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));
    inputF.forEach((item) => (item.style.color = "white"));
  }
  /* Fim Fale Conosco */

  /* Início Pet Info */
  const petI = document.querySelector(".pet-flex");
  if (petI) petI.style.backgroundColor = "#F3F3E7";

  const petT = document.querySelector(".pet-info-titulo");
  if (petT) petT.style.color = "#772308";

  const petP = document.querySelector(".pet-p");
  if (petP) petP.style.color = "black";
  /* Fim Pet Info */

  /* Início Tela Produtos */
  const circulo = document.querySelectorAll(".circulo");
  if (circulo)
    circulo.forEach(
      (item) => (item.style.backgroundColor = "rgb(240, 240, 240)")
    );

  const tipo = document.querySelectorAll(".tipo");
  if (tipo) tipo.forEach((item) => (item.style.color = "#82371e"));

  const products = document.querySelectorAll(".produtos");
  if (products)
    products.forEach((item) => (item.style.backgroundColor = "#cecfc1"));

  const product = document.querySelectorAll(".produto");
  if (product)
    product.forEach(
      (item) => (item.style.backgroundColor = "rgb(255, 255, 255)")
    );

  const desc = document.querySelectorAll(".descricao");
  if (desc) desc.forEach((item) => (item.style.color = "black"));

  const produtosP = document.querySelectorAll(".produtos");
  produtosP.forEach((produto) => {
    produto.addEventListener("mouseover", () => {
      mudarBoxShadow("rgba(58, 58, 58, 0.3");
    });

    produto.addEventListener("mouseout", () => {
      mudarBoxShadow("rgba(0, 0, 0, 0.1)");
    });
  });

  // Função para alterar o box-shadow
  function mudarBoxShadow(cor, produto) {
    produto.style.boxShadow = `0 3px 10px 10px ${cor}`;
  }

  const pFirst = document.querySelectorAll(".produto p:first-of-type");
  if (pFirst.length > 0) {
    pFirst.forEach((item) => {
      item.style.color = "black";
    });
  }
  /* Fim Tela Produtos */

  /* Início Info Gatos */
  const petC = document.querySelector("main");
  if (petC) petC.style.color = "black";

  const pet1 = document.querySelector("#pet-p1");
  if (pet1) pet1.style.color = "black";

  const color3 = document.querySelector(".pet-info-curiosidade");
  if (color3) color3.style.backgroundColor = "#fafaa9";

  const color4 = document.querySelector(".pet-info-alimentação");
  if (color4) color4.style.backgroundColor = "#fafaa9";

  const color = document.querySelectorAll(".pet-flex");
  if (color) color.forEach((item) => (item.style.backgroundColor = "#fafaa9"));

  const color1 = document.querySelector(".pet-info-doenças");
  if (color1) color1.style.backgroundColor = "#fafaa9";

  const color2 = document.querySelector(".pet-info-vacinas");
  if (color2) color2.style.backgroundColor = "#fafaa9";
  /* Início Info Gatos */

  /* Início Info Dogs */
  const petD = document.querySelector("main");
  if (petD) petD.style.color = "black";

  const fundo = document.querySelector(".pet-dog-curiosidade");
  if (fundo) fundo.style.backgroundColor = "#fafaa9";

  const fundo1 = document.querySelector(".pet-dog-alimentação");
  if (fundo1) fundo1.style.backgroundColor = "#fafaa9";

  const fundo2 = document.querySelector(".pet-dog-doenças");
  if (fundo2) fundo2.style.backgroundColor = "#fafaa9";

  const fundo3 = document.querySelector(".pet-dog-vacinas");
  if (fundo3) fundo3.style.backgroundColor = "#fafaa9";

  const fundo5 = document.querySelector(".pet-container-doenças");
  if (fundo5) fundo5.style.backgroundColor = "#fafaa9";

  const fundo6 = document.querySelector(".pet-container-vacinas");
  if (fundo6) fundo6.style.backgroundColor = "#fafaa9";
  /* Início Info Dogs */

  /* Início Info Ham */
  const petH = document.querySelector("main");
  if (petH) petH.style.color = "black";

  const background = document.querySelector(".pet-ham-vacinas");
  if (background) background.style.backgroundColor = "#fafaa9";

  const background1 = document.querySelector(".pet-ham-curiosidade");
  if (background1) background1.style.backgroundColor = "#fafaa9";

  const background2 = document.querySelector(".pet-ham-alimentação");
  if (background2) background2.style.backgroundColor = "#fafaa9";

  const background3 = document.querySelector(".pet-ham-doenças");
  if (background3) background3.style.backgroundColor = "#fafaa9";
  /* Fim Info Ham */

  /* Início Info coelhos */
  const petM = document.querySelector("main");
  if (petM) petM.style.color = "black";

  const back = document.querySelector(".pet-coelhos-vacinas");
  if (back) back.style.backgroundColor = "#fafaa9";

  const back1 = document.querySelector(".pet-coelhos-curiosidade");
  if (back1) back1.style.backgroundColor = "#fafaa9";

  const back2 = document.querySelector(".pet-coelhos-alimentação");
  if (back2) back2.style.backgroundColor = "#fafaa9";

  const back3 = document.querySelector(".pet-coelhos-doenças");
  if (back3) back3.style.backgroundColor = "#fafaa9";
  /* Fim Info coelhos */

  /* Início Info porquinho */
  const main = document.querySelector("main");
  if (main) main.style.color = "black";

  const fundoE = document.querySelector(".pet-porquinho-vacinas");
  if (fundoE) fundoE.style.backgroundColor = "#fafaa9";

  const fundoE1 = document.querySelector(".pet-porquinho-curiosidade");
  if (fundoE1) fundoE1.style.backgroundColor = "#fafaa9";

  const fundoE2 = document.querySelector(".pet-porquinho-alimentação");
  if (fundoE2) fundoE2.style.backgroundColor = "#fafaa9";

  const fundoE3 = document.querySelector(".pet-porquinho-doenças");
  if (fundoE3) fundoE3.style.backgroundColor = "#fafaa9";
  /* Fim Info porquinhos */

  /*Inicio Info Produtos */
  const description = document.querySelector(".descricao-container");
  if (description) description.style.backgroundColor = "rgb(241, 241, 241)";

  const avaliação = document.querySelector(".avaliaçâo");
  if (avaliação) avaliação.style.backgroundColor = "white";

  const information = document.querySelector(".Produto");
  if (information) information.style.backgroundColor = "white";

  const regredir = document.querySelector(".voltar");
  if (regredir) regredir.style.backgroundColor = "white";

  const pInfo = document.querySelector(".p-information");
  if (pInfo) pInfo.style.color = "black";

  const lr = document.querySelectorAll(".label-radio");
  if (lr)
    lr.forEach((item) => (item.style.backgroundColor = "rgb(223, 223, 223)"));

  const radios = document.querySelectorAll('input[type="radio"]');
  radios.forEach((radio) => {
    radio.addEventListener("change", function () {
      document.querySelectorAll(".label-radio").forEach((label) => {
        label.style.border = "";
      });

      if (this.checked) {
        const label = this.nextElementSibling;
        label.style.border = "2px solid #353535";
      }
    });
  });

  const trycar = document.querySelector(".try-car");
  if (trycar) trycar.src = "../../public/img/add-cart.png";

  const petcomentario = document.querySelectorAll(
    ".txt-comentario p:nth-of-type(3)"
  );
  if (petcomentario) {
    petcomentario.forEach((item) => (item.style.backgroundColor = "#EFEFEF"));
    petcomentario.forEach((item) => (item.style.color = "black"));
  }

  const quant = document.querySelector(".button-add");
  if (quant) {
    quant.style.backgroundColor = "#d3d3d3";
    quant.style.color = "black";
  }

  const quant1 = document.querySelector(".button-add2");
  if (quant1) {
    quant1.style.backgroundColor = "#d3d3d3";
    quant1.style.color = "black";
  }

  const quant2 = document.querySelector(".input-add");
  if (quant2) {
    quant2.style.backgroundColor = "#ebebeb";
    quant2.style.color = "black";
  }

  const add = document.querySelector(".adicionar-comentario");
  if (add) add.style.backgroundColor = "#f8f9fa";

  const add2 = document.querySelectorAll(".comentario");
  if (add2) add2.forEach((item) => (item.style.backgroundColor = "#fff"));

  const txt = document.querySelectorAll(".data-comentario");
  if (txt) txt.forEach((item) => (item.style.color = "#6c757d"));

  const txt2 = document.querySelectorAll(".texto-comentario");
  if (txt2) txt2.forEach((item) => (item.style.color = "#6c757d"));
  /*Fim Info Produtos */

  /* Inicio Tela Carrinho */
  const dadosC = document.querySelectorAll(".dados");
  if (dadosC) dadosC.forEach((item) => (item.style.color = "white"));

  const totalP = document.querySelector(".total");
  if (totalP) totalP.style.backgroundColor = "#3f3e3e";

  const pedidoC = document.querySelectorAll(".pedido");
  if (pedidoC)
    pedidoC.forEach((item) => (item.style.backgroundColor = "#3f3e3e"));

  const quantC = document.querySelectorAll(".button-add");
  if (quantC) quantC.forEach((item) => (item.style.color = "white"));

  const quantC2 = document.querySelectorAll(".button-add2");
  if (quantC2) quantC2.forEach((item) => (item.style.color = "white"));

  const inputC = document.querySelectorAll(".input-add");
  if (inputC) inputC.forEach((item) => (item.style.color = "white"));

  const carrinhoC = document.querySelector(".carrinhoC");
  if (carrinhoC) carrinhoC.src = "../../public/img/carrinho-de-compras.png";
  /* Fim Tela Carrinho */

  /* quem somos */
  const quem = document.querySelector(".quem-somos");
  if (quem) quem.style.backgroundColor = "#fafaa9";

  const quem3 = document.querySelector(".pet-titulo");
  if (quem3) quem3.style.color = "black";
  /* fim quem somos */

  /* Inicio Cuidados */
  const cuidadoG = document.querySelector(".cuidados-gato");
  if (cuidadoG) cuidadoG.style.backgroundColor = "#fafaa9";

  const cuidadoD = document.querySelector(".cuidados-dogs");
  if (cuidadoD) cuidadoD.style.backgroundColor = "#fafaa9";

  const cuidadoH = document.querySelector(".cuidados-ham");
  if (cuidadoH) cuidadoH.style.backgroundColor = "#fafaa9";

  const cuidadoC = document.querySelector(".cuidados-coelho");
  if (cuidadoC) cuidadoC.style.backgroundColor = "#fafaa9";

  const cuidadoP = document.querySelector(".cuidados-porquinho");
  if (cuidadoP) cuidadoP.style.backgroundColor = "#fafaa9";
  /* Fim Cuidados */

  /* perfil */
  const func = document.querySelector(".user-imgF");
  if (func) func.src = "../../public/img/administrador.png";
}
