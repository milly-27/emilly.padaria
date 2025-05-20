async function cadastrarUsuario() {
  const usuario = document.getElementById('cadastro-usuario').value.trim();
  const email = document.getElementById('cadastro-email').value.trim();
  const senha = document.getElementById('cadastro-senha').value;

  if (!usuario || !email || !senha) {
    alert("Preencha todos os campos");
    return;
  }
  function mostrarSenha(id) {
    const campo = document.getElementById(id);
    campo.type = campo.type === 'password' ? 'text' : 'password';
  }
  
  const formData = new FormData();
  formData.append('usuario', usuario);
  formData.append('email', email);
  formData.append('senha', senha);

  const res = await fetch('../api/cadastrarUsuario.php', { method: 'POST', body: formData });
  const text = await res.text();

  if (res.ok && text === "ok") {
    alert("Cadastro realizado com sucesso!");
    window.location.href = "../login/login.html";
  } else {
    alert(text);
  }
}

document.querySelector('form').addEventListener('submit', e => {
  e.preventDefault();
  cadastrarUsuario();
});
