import { Usuario } from './usuario.js';

export let usuarios = [];

export function loadCSV() {
  return fetch('cadastro.csv')
    .then(response => {
      if (!response.ok) {
        throw new Error('Erro ao carregar o CSV');
      }
      return response.text();
    })
    .then(csv => {
      const lines = csv.split('\n');
      for (const line of lines) {
        const trimmed = line.trim();
        if (trimmed) {
          const data = trimmed.split(',');
          if (data.length >= 3) {
            const usuario = new Usuario(
              data[0], // usuario
              data[1], // email
              data[2]  // senha
            );
            usuarios.push(usuario);
          }
        }
      }
    })
    .catch(error => {
      console.error('Erro ao carregar o CSV:', error);
    });
}
