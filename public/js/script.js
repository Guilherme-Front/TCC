/* Inicio Verificação do Botão de Cadastro */
/* Inicio Verificação do Cadastro */
const Name = document.getElementById('Nome');
const Email = document.getElementById('Email');
const CPF = document.getElementById('CPF');
const Telefone = document.getElementById('Telefone');
const Data = document.getElementById('Data');
const Campos = [Name, Email, CPF, Telefone, Data];
const formCadastro = document.getElementById('formCadastro');

// Adiciona validação nos campos
if (Name) Name.addEventListener("blur", Feedback);
if (CPF) CPF.addEventListener("blur", VerificaCPF);
if (Telefone) Telefone.addEventListener("blur", Verificatel);
if (Data) Data.addEventListener("blur", Feedback);
if (Email) Email.addEventListener("blur", () => validateEmailField(Email));

// Remove o evento de click do botão e usa apenas o submit do formulário
if (formCadastro) {
    formCadastro.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validação dos campos antes de enviar
        let camposVazios = [];
        Campos.forEach(campo => {
            if (campo && campo.value.trim() === "") {
                campo.style.border = '2px solid red';
                camposVazios.push(campo.name || campo.placeholder);
            }
        });

        if (camposVazios.length > 0) {
            error(`Preencha: ${camposVazios.join(", ")}`, "#D43F3A");
            return; // Impede o envio se houver campos vazios
        }

        // Mostrar loading no botão
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = "Cadastrando...";

        // Enviar via AJAX
        fetch('../controllers/cadastro.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(response => {
            if (!response.ok) throw new Error("Erro no servidor");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Sucesso: Mostra Toastify e redireciona
                redirection("Muito bem, agora vamos definir sua senha!", data.redirect);
            } else {
                // Erro: Mostra mensagem do servidor
                error(data.message || "Erro desconhecido", "#D43F3A");
            }
        })
        .catch(err => {
            error("Falha na conexão", "#D43F3A");
            console.error(err);
        })
        .finally(() => {
            // Restaura o botão
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = "Cadastrar";
            }
        });
    });
}

// Verifica se está na página de senha
if (window.location.pathname.includes('senha.php')) {
    // Verifica via AJAX se a sessão de cadastro está ativa
    fetch('../controllers/verificaSessaoCadastro.php')
        .then(response => response.json())
        .then(data => {
            if (!data.sessaoAtiva) {
                window.location.href = 'cadastro.php';
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            window.location.href = 'cadastro.php';
        });
}
/* Fim Verificação do Cadastro */

/* Fim Verificação do Botão de Cadastro */

/* Inicio Verificação do Botão de Login Loading...99%*/

const Senha = document.getElementById('Senha');
const BotaoEntrar = document.getElementsByClassName('botao')[0]; 
const Login = [Email, Senha];

if (BotaoEntrar) {
    BotaoEntrar.addEventListener("click", Fim_Login);
}

/* Fim Verificação do Botão de Login Loading...99% */

/* Inicio Verificação do Botão de Senha */

const Pass = document.getElementById('pass');
const Password = document.getElementById('password');
const BotaoSenha = document.getElementsByClassName('botao-senha')[0];

if (BotaoSenha) {
    BotaoSenha.addEventListener('click', SenhaIgual);
}

if (Pass) {
    Pass.addEventListener('blur', VerificaPass);
}

if (Password) {
    Password.addEventListener('blur', VerificaPassword);
}

/* Fim Verificação do Botão de Senha */


/* Funções */

var picker = new Pikaday({
    field: document.getElementById('Data'),  // Campo de entrada
    format: 'DD/MM/YYYY',  // Formato da data
    minDate: new Date('1950-01-01'),  // Data mínima
    maxDate: new Date('2020-01-01'),  // Data máxima (2019)
    yearRange: [1950, 2019],  // Faixa de anos
    onSelect: function(date) {
        var day = ("0" + date.getDate()).slice(-2);  // Formata o dia
        var month = ("0" + (date.getMonth() + 1)).slice(-2);  // Formata o mês
        var year = date.getFullYear();  // Obtém o ano

        // Atualiza o campo com a data formatada
        document.getElementById('Data').value = day + '/' + month + '/' + year;
    },
    i18n: {
        previousMonth: 'Mês anterior',
        nextMonth: 'Próximo mês',
        months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
        weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb']
    }
});

picker.setDate(new Date(2019, 0, 1));  

function VerificaCPF() {
    if (CPF.value.trim() === "") {
        error("O campo CPF está vazio.", "linear-gradient(to right, #cd1809, #a01006)")
        CPF.style.border = '2px solid red';
    } else if (CPF.value.length < 14) {
        error("Está faltando algo no campo CPF, por favor verifique e tente novamente.", "linear-gradient(to right, #cd1809, #a01006)")
        CPF.style.border = '2px solid red';
    } else {
        CPF.style.border = '2px solid lime';
    }
}

function Verificatel() {
    if (Telefone.value.trim() === "") {
        error("O campo Telefone está vazio.", "linear-gradient(to right, #cd1809, #a01006)")
        Telefone.style.border = '2px solid red';
    } else if (Telefone.value.length < 11) {
        error("Está faltando algo no campo telefone, por favor verifique e tente novamente.", "linear-gradient(to right, #cd1809, #a01006)")
        Telefone.style.border = '2px solid red';
    } else {
        Telefone.style.border = '2px solid lime';
    }
}

function Feedback(event) {
    const campo = event.target; // Obtém o campo que acionou o evento

    if (campo.value.trim() === "") {
        error(`O campo ${campo.name} está vazio, por favor preencha.`, "linear-gradient(to right, #cd1809, #a01006)");
        campo.style.border = '2px solid red';
    } else {
        campo.style.border = '2px solid lime';
    }
}

// function Fim_Cadastro() {
//     let camposVazios = []; // Lista para armazenar os campos vazios

//     Campos.forEach(campo => {
//         if (campo.value.trim() === "") {
//             campo.style.border = '2px solid red'; 
//             camposVazios.push(campo.name); 
//         } else {
//             campo.style.border = '2px solid lime'; 
//         }
//     });

//     if (camposVazios.length > 0) {
//         error(`Por favor, preencha os seguintes campos: ${camposVazios.join(", ")}`, "linear-gradient(to right, #BD5532, #8e3315)");
//     } else {
//         redirection("Todos os campos estão preenchidos corretamente! Agora vamos definir a sua senha.", "senha.php", 3000);
//     }    
// }

// function Fim_Login() {
//     let LoginVazio = []; // Lista para armazenar os campos vazios

//     Login.forEach(campo => {
//         if (campo.value.trim() === "") {
//             campo.style.border = '2px solid red'; // Borda vermelha para campo vazio
//             LoginVazio.push(campo.name); // Adiciona o nome do campo vazio à lista
//         } else {
//             campo.style.border = '2px solid lime'; // Borda verde para campo preenchido
//         }
//     });

//     if (LoginVazio.length > 0) {
//         error(`Por favor, preencha os seguintes campos: ${LoginVazio.join(", ")}`, "linear-gradient(to right, #BD5532, #8e3315)");
//     } else {
//         // Caso todos os campos estejam preenchidos corretamente
//         redirection("Todos os campos estão preenchidos corretamente! Agora vamos definir a sua senha.", "senha.php", 3000);
//     }    
// }

function SenhaIgual() {
    if (Pass.value === "" || Password.value === "") {
        error("Verifique os campos, eles podem estar vazios.", "linear-gradient(to right, #cd1809, #a01006)");
        Pass.style.border = '1px solid red';
        Password.style.border = '1px solid red';
        return;
    }

    if (Pass.value !== Password.value) {
        error("As senhas não coincidem.", "linear-gradient(to right, #cd1809, #a01006)");
        Pass.style.border = '1px solid red';
        Password.style.border = '1px solid red';
    } else {
        // Se as senhas coincidem
        redirection("Você finalizou o cadastro. Agora faça o login", "Login.html");
        Pass.style.border = '1px solid lime';
        Password.style.border = '1px solid lime';
        return; 
    }
}

function VerificaPass() {
    let senha = Pass.value.trim(); // Obtém o valor sem espaços extras

    if (senha === "") {
        Pass.style.border = '2px solid red'; // Mantém a borda vermelha se o campo estiver vazio
        error("O campo senha está vazio.", "linear-gradient(to right, #cd1809, #a01006)");
    } else if (senha.length < 6) {
        Pass.style.border = '2px solid red'; // Mantém a borda vermelha se for menor que 6
        error("O campo senha está faltando caracteres.", "linear-gradient(to right, #cd1809, #a01006)");
    } else {
        Pass.style.border = 'none';
    }
}


function VerificaPassword() {
    let senha = Password.value.trim(); // Obtém o valor da senha sem espaços extras

    if (senha === "") {
        Password.style.border = '2px solid red'; // Sempre mantém vermelho se for inválido
        error("O campo confirmar senha está vazio.", "linear-gradient(to right, #cd1809, #a01006)");
    } else if (senha.length < 6) {
        Password.style.border = '2px solid red'; // Ainda vermelho se for menor que 6
        error("O campo confirmar senha está faltando caracteres.", "linear-gradient(to right, #cd1809, #a01006)");
    } else {
        Password.style.border = 'none';
    }
}

function SenhasC() {
    if (senhas.value === "" || Csenhas.value === "") {
        error("Verifique os campos, eles podem estar vazios.", "linear-gradient(to right, #cd1809, #a01006)");
        senhas.style.border = '1px solid red';
        Csenhas.style.border = '1px solid red';
        return;
    }

    if (senhas.value !== Csenhas.value) {
        error("As senhas não coincidem.", "linear-gradient(to right, #cd1809, #a01006)");
        senhas.style.border = '1px solid red';
        Csenhas.style.border = '1px solid red';
    } else {
        // Se as senhas coincidirem
        redirection("Você redefiniu sua senha. Agora faça o login", "Login.html");
        senhas.style.border = '1px solid lime';
        Csenhas.style.border = '1px solid lime';
        return; 
    }
}

function VerificaSenhas() {
    let senha = senhas.value.trim(); // Obtém o valor sem espaços extras

    if (senha === "") {
        senhas.style.border = '2px solid red'; // Mantém a borda vermelha se o campo estiver vazio
        error("O campo senha está vazio.", "linear-gradient(to right, #cd1809, #a01006)");
    } else if (senha.length < 6) {
        senhas.style.border = '2px solid red'; // Mantém a borda vermelha se for menor que 6
        error("O campo senha está faltando caracteres.", "linear-gradient(to right, #cd1809, #a01006)");
    } else {
        senhas.style.border = 'none';
    }
}

function VerificaCsenhas() {
    let senha = Csenhas.value.trim(); // Obtém o valor da senha sem espaços extras

    if (senha === "") {
        Csenhas.style.border = '2px solid red'; // Sempre mantém vermelho se for inválido
        error("O campo confirmar senha está vazio.", "linear-gradient(to right, #cd1809, #a01006)");
    } else if (senha.length < 6) {
        Csenhas.style.border = '2px solid red'; // Ainda vermelho se for menor que 6
        error("O campo confirmar senha está faltando caracteres.", "linear-gradient(to right, #cd1809, #a01006)");
    } else {
        Csenhas.style.border = 'none';
    }
}

function redirection(message, target) {
    Toastify({
        text: message,
        close: true,
        gravity: "top", // `top` ou `bottom`
        position: "right", // `left`, `center` ou `right`
        stopOnFocus: true, // Impede o fechamento ao passar o mouse
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
        onClick: function () { } // Callback após clicar
    }).showToast();

    // Redireciona após o tempo do toast
    setTimeout(() => {
        window.location.href = target;
    }, 3500); // Tempo em milissegundos
}

function error(message, color) {
    Toastify({
        text: message,
        duration: 3500,
        close: true,
        gravity: "top", // `top` ou `bottom`
        position: "right", // `left`, `center` ou `right`
        stopOnFocus: true, // Impede o fechamento ao passar o mouse
        style: {
            background: color,
        },
        onClick: function () { }
    }).showToast();
}

function validateEmailField(Email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(Email.value)) {
        error("Formato de e-mail inválido, ou o campo está vazio.", "linear-gradient(to right, #cd1809, #a01006)");
        Email.style.border = '2px solid red';
        return false;
    } else if (Email.value.trim() > 0) {
        Email.style.border = 'none';
    } else {
        error("Formato de e-mail válido!", "linear-gradient(to right, #00b09b, #96c93d)");
        Email.style.border = '2px solid lime';
    }
    return true; // E-mail válido
}

