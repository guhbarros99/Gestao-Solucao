document.addEventListener('DOMContentLoaded', () => {
    // Seleciona os elementos do DOM
    const openModalBtn = document.getElementById('open-modal-btn');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const modal = document.getElementById('my-modal');

    // Função para abrir o modal
    const openModal = () => {
        modal.classList.remove('hidden');
    };

    // Função para fechar o modal
    const closeModal = () => {
        modal.classList.add('hidden');
    };

    // Adiciona os ouvintes de eventos aos botões
    openModalBtn.addEventListener('click', openModal);
    closeModalBtn.addEventListener('click', closeModal);

    // Opcional: fechar o modal clicando fora dele
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Opcional: fechar o modal pressionando a tecla Esc
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
});