<style>
    .navbar-custom {
    display: flex;
    align-items: center;
}

#themeToggle {
    display: flex;
    align-items: center;
    border: none;
    background-color: transparent;
    cursor: pointer;
    padding: 10px;
}

.color-circle {
    width: 24px;  /* Ajuste o tamanho do círculo conforme necessário */
    height: 24px; /* Ajuste o tamanho do círculo conforme necessário */
    border-radius: 50%;
    margin: 0 5px; /* Espaçamento entre círculos */
    border: 2px solid #ffffff; /* Borda branca para destacar */
    transition: transform 0.3s; /* Animação ao passar o mouse */
}

.color-circle:hover {
    transform: scale(1.2); /* Efeito de aumento ao passar o mouse */
}

</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars icon-white"></i>
            </a>
        </li>
    </ul>

    <div class="navbar-custom">
        <button id="themeToggle" class="btn btn-primary" title="Alternar Tema">
            <span class="color-circle" style="background-color: #121212;"></span> <!-- Cor do tema escuro -->
            <span class="color-circle" style="background-color: #ffffff;"></span> <!-- Cor do tema claro -->
        </button>
    </div>

    <ul class="navbar-nav ml-auto">  
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt icon-white"></i>
            </a>
        </li>
    </ul>
</nav>

<script>

document.getElementById('themeToggle').addEventListener('click', function() {
    // Alterna a classe de tema
    document.body.classList.toggle('blue-theme');
    
    // Alterna as classes de tema em outros elementos
    const elementsToToggle = [
        '.main-sidebar',
        '.navbar',
        '.content-wrapper',
        '.btn-create',
        '.btn-primary',
        '.btn-danger',
        '.form-control',
        '.invoice',
        '.btn-secondary',
        '.category-filter'
    ];

    elementsToToggle.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            element.classList.toggle('blue-theme');
        });
    });
});

</script>