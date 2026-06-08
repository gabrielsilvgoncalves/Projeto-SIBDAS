document.getElementById('formContacto').addEventListener('submit', function (e) {
    e.preventDefault();
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const mensagem = document.getElementById('mensagem').value.trim();

    if (!nome || !email || !mensagem) {
        const inputs = [
            { id: 'nome', val: nome },
            { id: 'email', val: email },
            { id: 'mensagem', val: mensagem }
        ];
        inputs.forEach(function (item) {
            const el = document.getElementById(item.id);
            if (!item.val) {
                el.style.borderColor = '#dc3545';
            } else {
                el.style.borderColor = '';
            }
        });
        return;
    }

    // Repor estilos de erro
    ['nome', 'email', 'mensagem'].forEach(function (id) {
        document.getElementById(id).style.borderColor = '';
    });

    // Mostrar Toast Bootstrap
    const toastEl = document.getElementById('toastContacto');
    const toast = new bootstrap.Toast(toastEl, { delay: 5000 });
    toast.show();

    this.reset();
});
