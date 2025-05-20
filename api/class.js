export class Usuario {
  constructor(usuario, email, senha) {
    this.usuario = usuario;
    this.email = email;
    this.senha = senha;
  }
}

var listaUsuarios = []; // global para manter os usuários carregados
