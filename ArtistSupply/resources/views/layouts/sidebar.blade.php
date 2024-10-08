<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('home') }}" class="brand-link">
        <span class="brand-text font-weight-light">Artist Supply</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item user-panel">
                    <a href="{{ route('usuario.atualizar') }}" class="nav-link">
                        <p>{{ $authUser->name }}</p>
                    </a>                    
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('usuario.atualizar') }}" class="nav-link">
                                <i class="icon-user-edit nav-icon"></i>
                                <p>Perfil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block btn-sm">Sair</button>
                            </form>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/home" class="nav-link">
                        <i class="icon-dashboard nav-icon"></i>
                        <p>Página inicial</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/eventos" class="nav-link">
                        <i class="icon-building nav-icon"></i>
                        <p>Eventos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/categorias" class="nav-link">
                        <i class="icon-building nav-icon"></i>
                        <p>Categorias</p>
                    </a>
                </li>

                <li class="nav-item user-panel">
                    <a href="estoque" class="nav-link">
                        <p>Estoque</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/estoque" class="nav-link">
                                <i class="icon-user-edit nav-icon"></i>
                                <p>Gerenciar estoque</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/estoque/criar
                            " class="nav-link">
                                <i class="icon-user-edit nav-icon"></i>
                                <p>Cadastrar produto</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="https://docs.google.com/spreadsheets/u/0/d/1m0L1dx60k05oz-6jqm8h9NDiqRTBc9gOe5X14t2aYw0/htmlview" class="nav-link">
                                <i class="icon-user-edit nav-icon"></i>
                                <p>Fornecedores</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>


<div class="modal fade" id="newBoard">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Novo Quadro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="#">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome:<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" id="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModalNewBoard()" class="btn btn-danger">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openNewBoard() {
    $('#newBoard').modal('show');
}
function closeModalNewBoard() {
    $('#newBoard').modal('hide');
}
</script>

<style>
    .sidebar .nav-link {
    text-align: center; /* Centraliza o texto */
    }

    .sidebar .nav-item {
        margin-bottom: 10px; /* Espaço entre os itens */
    }

    .brand-link {
        display: flex;               /* Ativa flexbox */
        justify-content: center;     /* Centraliza horizontalmente */
        align-items: center;         /* Centraliza verticalmente */
        height: 60px;                /* Altura do container (ajuste conforme necessário) */
        text-align: center;          /* Centraliza o texto */
    }


</style>