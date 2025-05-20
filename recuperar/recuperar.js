async function alterarSenha() {
  const usuario = document.getElementById('recuperar-usuario').value.trim();
  const email = document.getElementById('recuperar-email').value.trim();
  const senhaNova = document.getElementById('recuperar-senha').value;

  if (!usuario || !email || !senhaNova) {
    alert("Preencha todos os campos");
    return;
  }

  const formData = new FormData();
  formData.append('usuario', usuario);
  formData.append('email', email);
  formData.append('senhaNova', senhaNova);

  const res = await fetch('../api/alterarSenha.php', { method: 'POST', body: formData });
  const text = await res.text();

  if (res.ok && text === "ok") {
    alert("Senha alterada com sucesso!");
    window.location.href = "../login/login.html";
  } else {
    alert(text);
  }
}

document.querySelector('form').addEventListener('submit', e => {
  e.preventDefault();
  alterarSenha();
});
