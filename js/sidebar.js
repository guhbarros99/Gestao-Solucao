// 1. Seleciona os elementos que vamos manipular
const sidebar = document.querySelector('.sidebar');
const menuIcon = document.querySelector('.menu-toggle i');

// 2. Adiciona um "ouvinte de evento" para o clique no ícone
menuIcon.addEventListener('click', () => {
  // 3. Usa classList.toggle para adicionar/remover a classe 'fechada'
  sidebar.classList.toggle('fechada');
});