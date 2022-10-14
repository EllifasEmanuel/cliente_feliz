@extends(usuarios)

@section('modal')
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tituloModal"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="inputName" class="form-label">Nome</label>
                <input type="text" class="form-control" id="inputName" placeholder="Matheus">
            </div>
            <div class="mb-3">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="inputSenha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="inputSenha">
            </div>
            <div class="mb-3">
                <label for="inputSenhaConfirmacao" class="form-label">Confirmação de Senha</label>
                <input type="password" class="form-control" id="inputSenhaConfirmacao">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="reloadDataTable()" data-bs-dismiss="modal">Fechar</button>
            <button type="button" class="btn btn-primary" onclick="salvaInformacoesEdicao()">Salvar</button>
        </div>
        </div>
    </div>
</div>
@endsection