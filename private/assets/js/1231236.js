// Destacar link ativo na sidebar com base no URL atual
document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('aside nav a.nav-link');
    links.forEach(function (link) {
        link.classList.remove('nav-link-active');
        if (link.href === window.location.href) {
            link.classList.add('nav-link-active');
        }
    });
});
