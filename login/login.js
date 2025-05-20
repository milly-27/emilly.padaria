async function fazerLogin() {
  // const usuario = document.getElementById('login-usuario').value.trim();
  const email = document.getElementById('login-email').value.trim();
  const senha = document.getElementById('login-senha').value;

  if (!email || !senha) {
    alert("Preencha todos os campos");
    return;
  }
  function mostrarSenha(id) {
    const campo = document.getElementById(id);
    campo.type = campo.type === 'password' ? 'text' : 'password';
  }
  
  // O login.php já trata os erros com script que ativa `esqueciSenhaLink` e mostra a mensagem de erro
  
  const formData = new FormData();
  // formData.append('usuario', usuario);
  formData.append('email', email);
  formData.append('senha', senha);

  const res = await fetch('http://localhost:3000/api/login.js', {
    method: 'POST',
    body: formData
  });

  const text = await res.text();

  if (res.ok && text === "ok") {
    alert("Login bem-sucedido");
    window.location.href = "principal.html";
  } else if (text === "Usuário não cadastrado") {
    if (confirm("Usuário não encontrado. Deseja cadastrar?")) {
      window.location.href = "../cadastro/cadastro.html";
    }
  } else {
    alert(text);
  }
}

document.querySelector('form').addEventListener('submit', e => {
  e.preventDefault();
  fazerLogin();
});
