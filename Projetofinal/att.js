const currentPage = window.location.pathname;
// Marcação
document.querySelectorAll('nav ul li a').forEach(link => {
    if (link.href.includes(currentPage)) {
        link.classList.add('active'); // Adiciona a classe 'active' ao link correspondente
    }
});

function registerItem() {
    // Aqui você pode validar e enviar os dados do formulário (se necessário)
    // Suponha que o registro foi bem-sucedido após essa ação
    alert('Registrado com sucesso!');
}



/* MOSTRAR SENHA E ESCONDER SENHA */
document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const passwordField = document.getElementById("user_password");

    togglePassword.addEventListener("click", function () {
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;
    });
}); 


//confirmDelete //usado para CONTAS
function confirmDelete(con_cod) {
    const confirmAction = confirm("Você tem certeza que deseja excluir esta conta?");
    if (confirmAction) {
        // Criar um formulário para enviar o POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = ''; // Deixe vazio para enviar ao mesmo arquivo PHP atual

        // Adicionar campo oculto com o ID da conta
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'con_cod';
        input.value = con_cod;
        form.appendChild(input);

        // Adicionar botão oculto para acionar o 'excluir'
        const excluirInput = document.createElement('input');
        excluirInput.type = 'hidden';
        excluirInput.name = 'excluir';
        excluirInput.value = '1';
        form.appendChild(excluirInput);

        document.body.appendChild(form); // Adiciona o formulário ao DOM
        form.submit(); // Envia o formulário
    }
}

//confirmUpdate 
function updateItem() {
    const confirmAction = confirm("Você tem certeza que deseja atualizar este item?");
    if (confirmAction) {
    }
}





function updateUser() {
    // Obtém os valores dos campos
    const userName = document.getElementById('user_name').value;
    const userEmail = document.getElementById('user_email').value;
    const userPassword = document.getElementById('user_password').value;

    // Verifica se os campos não estão vazios
    if (userName && userEmail && userPassword) {
        // Exibe a mensagem de sucesso
        document.getElementById('message').innerHTML = 'Usuário atualizado com sucesso!';

        // Aqui você pode enviar os dados para o backend, se necessário
        // Exemplo: enviar os dados para o PHP (opcional)
        // Para simplificação, não estou enviando para o backend neste exemplo.

    } else {
        // Se algum campo estiver vazio
        alert('Por favor, preencha todos os campos.');
    }
}
function deleteUser(userId) {
    // Confirmação para excluir o usuário
    const confirmDelete = confirm('Você tem certeza que deseja excluir este usuário?');

    if (confirmDelete) {
        // Exclui o usuário (Simulação)
        // Exibe a mensagem de sucesso
    } else {
        // Caso o usuário não confirme a exclusão
        alert('Exclusão cancelada');
    }
}


//vencimentos 
// Função para atualizar vencimento
function updateVencimento(venCod) {
    const descricao = document.getElementById('descricao-' + venCod).value;
    const valor = document.getElementById('valor-' + venCod).value;
    const data = document.getElementById('data-' + venCod).value;

    const formData = new FormData();
    formData.append('ven_cod', venCod);
    formData.append('ven_descricao', descricao);
    formData.append('ven_valor', valor);
    formData.append('ven_data', data);
    formData.append('atualizar_vencimento', true);

    // Envia os dados para o servidor
    fetch('vencimentos.php', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        alert('Vencimento atualizado com sucesso!');
        location.reload(); // Recarrega a página para mostrar os dados atualizados
    })
    .catch(error => {
        alert('Erro ao atualizar vencimento: ' + error);
        console.log('Erro ao atualizar vencimento:', error);
    });
}

// Função para excluir vencimento
function deleteVencimento(venCod) {
    const formData = new FormData();
    formData.append('ven_cod', venCod);
    formData.append('deletar_vencimento', true);

    // Envia os dados para o servidor
    fetch('vencimentos.php', {
        method: 'POST',
        body: formData
    })
    .then(() => {
        alert('Vencimento excluído com sucesso!');
        const row = document.getElementById('row-' + venCod);
        row.remove(); // Remove a linha da tabela sem recarregar a página
    })
    .catch(error => {
        alert('Erro ao excluir vencimento: ' + error);
        console.log('Erro ao excluir vencimento:', error);
    });
}




// Validação de Formulários

document.querySelector('form').addEventListener('submit', function (event) {
    const email = document.querySelector('[name="user_email"]');
    const password = document.querySelector('[name="user_password"]');

    if (!email.value.includes('@') || password.value.length < 1) {
        alert('Por favor, preencha os campos corretamente.');
    }
});


function showAlert() {
    const inputValue = document.querySelector('input[name="Dinheiro"]').value;
    alert(`Você tem  ${inputValue} na sua conta `);
}



