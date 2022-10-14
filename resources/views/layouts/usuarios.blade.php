@extends('app')

@section('content')
<div class="conteudo py-4">
    <div class="container area-data">
        <div class="conteudo-apresentacao">
            <p>Seja bem-vindo: {{ Auth::user()->name }}.</p>
            <h3>Gestão de Usuários</h3>
        </div>
        <div class="area-button-usuario mb-3">
            <button class="button-acao usuario" onclick="abrirModalNovoUsuario()">Novo usuário</button>
        </div>

        <div class="row">
            <div class="col-md-12 main-datatable">
                <div class="card_body">
                    <div class="overflow-x">
                        <table style="width: 100%;" id="tabelaUsuarios" class="table cust-datatable dataTable no-footer">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="area-button-pdf mt-3">
            <a href="{{URL::to('export')}}" target="_blank" rel="noopener noreferrer">
                <button class="button-acao pdf">Baixar PDF</button>
            </a>
        </div>
    </div>
</div>
<div class="modal fade" id="modalFormEditarUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tituloModalEditar"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reloadDataTable()"></button>
        </div>
        <div class="modal-body">
            <form id="usuarioEditForm" class="area-form">
                @csrf
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
                
                <button type="button" class="btn btn-primary form-edit-user">Salvar</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="reloadDataTable()" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormNovoUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tituloModalNovo"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reloadDataTable()"></button>
        </div>
        <div class="modal-body">
            <form id="usuarioNovoForm" class="area-form">
                @csrf
                <div class="mb-3">
                    <label for="inputNameNewUser" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="inputNameNewUser" placeholder="Matheus">
                </div>
                <div class="mb-3">
                    <label for="inputEmailNewUser" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmailNewUser" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="inputSenhaNewUser" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="inputSenhaNewUser">
                </div>
                <div class="mb-3">
                    <label for="inputSenhaConfirmacaoNewUser" class="form-label">Confirmação de Senha</label>
                    <input type="password" class="form-control" id="inputSenhaConfirmacaoNewUser">
                </div>
                
                <button type="button" class="btn btn-primary form-novo-user">Salvar</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="reloadDataTable()" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormRemoverUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="tituloModalRemover"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="reloadDataTable()"></button>
        </div>
        <div class="modal-body">
            <form id="usuarioRemoverForm" class="area-form">
                @csrf
                <div class="mb-3">
                    <label for="inputNameRemoveUser" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="inputNameRemoveUser" disabled>
                </div>
                <div class="mb-3">
                    <label for="inputEmailRemoveUser" class="form-label">Email</label>
                    <input type="email" class="form-control" id="inputEmailRemoveUser" disabled>
                </div>
                
                <button type="button" class="btn btn-primary form-remove-user">Remover</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="reloadDataTable()" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
</div>

<div class="modal" id="modalRetorno" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body conteudo-mensagem">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')

<script type="text/javascript">

    var CSRF_TOKEN = jQuery('meta[name="csrf-token"]').attr('content');

    jQuery(document).ready(function(){
        jQuery('#tabelaUsuarios').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{URL::to('show')}}",
            columns:[
                {data:'id', class:'table_user_id', id:'id'},
                {data:'name', class:'table_user_name', name:'name'},
                {data:'email', class:'table_user_email', email:'email'},
                {data: 'acoes', class:'table_acoes', orderable: false, searchable: false,
                render(data, type, trData) {
                    return `
                        <div class="btn-group">
                            <button type="button" class="button-acoes botaoEditar" button" title="Editar" onclick="abrirModalEdicao(this)">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="button-acoes botaoExcluir" button" title="Remover" onclick="abrirModalRemoverUsuarios(this)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    `;
                }}
            ],
            oLanguage: {
                sProcessing:   '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                sLengthMenu:   "Mostrar _MENU_ registros",
                sZeroRecords:  "Não foram encontrados resultados",
                sInfo:         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                sInfoEmpty:    "Mostrando de 0 até 0 de 0 registros",
                sInfoFiltered: "",
                sInfoPostFix:  "",
                sSearch:       "Buscar:",
                sUrl:          "",
                oPaginate: {
                    sFirst:    "Primeiro",
                    sPrevious: "Anterior",
                    sNext:     "Seguinte",
                    sLast:     "Último"
                }
            }
        })
        jQuery('#tabelaUsuarios').DataTable().ajax.reload();
    });

    const reloadDataTable = () =>{
        jQuery('#tabelaUsuarios').DataTable().ajax.reload();
    }

    const abrirModalEdicao = (el) =>{
        const user_id = el.parentElement.parentElement.parentElement.querySelector('.table_user_id').textContent;
        const user_name = el.parentElement.parentElement.parentElement.querySelector('.table_user_name').textContent;
        const user_email = el.parentElement.parentElement.parentElement.querySelector('.table_user_email').textContent;
        const modalTitle = document.querySelector('#tituloModalEditar').textContent = `Edição de usuário - ${user_name}`;
        document.querySelector('.modal-body').setAttribute('data-user_id', user_id);
        document.querySelector('#inputName').value = user_name;
        document.querySelector('#inputEmail').value = user_email;
        jQuery('#modalFormEditarUsuario').modal('show');
    }

    const abrirModalNovoUsuario = () =>{
        const modalTitle = document.querySelector('#tituloModalNovo').textContent = `Novo Usuário`;
        document.querySelector('#inputName').value = '';
        document.querySelector('#inputEmail').value = '';
        document.querySelector('#inputSenha').value = '';
        document.querySelector('#inputSenhaConfirmacao').value = '';
        jQuery('#modalFormNovoUsuario').modal('show');
    }

    const abrirModalRemoverUsuarios = (el) =>{
        const user_id = el.parentElement.parentElement.parentElement.querySelector('.table_user_id').textContent;
        const user_name = el.parentElement.parentElement.parentElement.querySelector('.table_user_name').textContent;
        const user_email = el.parentElement.parentElement.parentElement.querySelector('.table_user_email').textContent;
        const modalTitle = document.querySelector('#tituloModalRemover').textContent = `Remover usuário - ${user_name}`;
        document.querySelector('.modal-body').setAttribute('data-remove_user', user_id);
        document.querySelector('#inputNameRemoveUser').value = user_name;
        document.querySelector('#inputEmailRemoveUser').value = user_email;
        jQuery('#modalFormRemoverUsuario').modal('show');
    }

    jQuery(document).on("click", ".form-edit-user", function(e) {
        bootbox.confirm({
            message: "Deseja editar o usuário?",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                }
            },
            callback: function(result){ 
                if(result){
                    jQuery('#usuarioEditForm').submit()
                }else{
                    document.querySelector('.conteudo-mensagem').innerHTML =`<p>Nenhuma ação realizada.</p>`;
                    jQuery('#modalRetorno').modal('show');
                }
            }
        })
    })

    jQuery(document).on("click", ".form-novo-user", function(e) {
        bootbox.confirm({
            message: "Deseja adicionar o usuário?",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                }
            },
            callback: function(result){ 
                if(result){
                    jQuery('#usuarioNovoForm').submit()
                }else{
                    document.querySelector('.conteudo-mensagem').innerHTML =`<p>Nenhuma ação realizada.</p>`;
                    jQuery('#modalRetorno').modal('show');
                }
            }
        })
    })

    jQuery(document).on("click", ".form-remove-user", function(e) {
        bootbox.confirm({
            message: "Deseja remover o usuário?",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'Não',
                    className: 'btn-danger'
                }
            },
            callback: function(result){ 
                if(result){
                    jQuery('#usuarioRemoverForm').submit()
                }
                else{
                    document.querySelector('.conteudo-mensagem').innerHTML =`<p>Nenhuma ação realizada.</p>`;
                    jQuery('#modalRetorno').modal('show');
                }
            }
        })
    })

    jQuery("#usuarioEditForm").submit(function(e){
        e.preventDefault();
        const user_name = document.querySelector('#inputName').value;
        const user_email = document.querySelector('#inputEmail').value;
        const user_senha = document.querySelector('#inputSenha').value;
        const user_senha_confirmacao = document.querySelector('#inputSenhaConfirmacao').value;
        const user_id = document.querySelector('.modal-body').getAttribute('data-user_id');
        document.querySelector('.conteudo-mensagem').innerHTML = '';
        jQuery.ajax({
            url: "{{URL::to('update')}}",
            type: 'PUT',
            data: {
                _token: CSRF_TOKEN,
                user_id: user_id,
                user_name: user_name,
                user_email: user_email,
                user_senha: user_senha,
                user_senha_confirmacao: user_senha_confirmacao                        
            }
        }).done(function(res){
            jQuery('#modalFormEditarUsuario').modal('hide');
            if(!res.error)
                document.querySelector('.conteudo-mensagem').innerHTML =`<p>${res.message}</p>`;
            else
                document.querySelector('.conteudo-mensagem').innerHTML =`<p>Não foi possível realizar a ação</p>`;
            jQuery('#modalRetorno').modal('show');
        })
        reloadDataTable();
    })

    jQuery("#usuarioNovoForm").submit(function(e){
        e.preventDefault();
        const user_name = document.querySelector('#inputNameNewUser').value;
        const user_email = document.querySelector('#inputEmailNewUser').value;
        const user_senha = document.querySelector('#inputSenhaNewUser').value;
        const user_senha_confirmacao = document.querySelector('#inputSenhaConfirmacaoNewUser').value;
        document.querySelector('.conteudo-mensagem').innerHTML = ''
        jQuery.ajax({
            url: "{{URL::to('create')}}",
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                user_name: user_name,
                user_email: user_email,
                user_senha: user_senha,
                user_senha_confirmacao: user_senha_confirmacao                        
            }
        }).done(function(res){
            jQuery('#modalFormNovoUsuario').modal('hide');
            if(!res.error)
                document.querySelector('.conteudo-mensagem').innerHTML =`<p>${res.message}</p>`;
            else
                document.querySelector('.conteudo-mensagem').innerHTML =`<p>Não foi possível realizar a ação</p>`;
            jQuery('#modalRetorno').modal('show');
        })
        reloadDataTable();
    })

    jQuery("#usuarioRemoverForm").submit(function(e){
        e.preventDefault();
        const user_id = document.querySelector('.modal-body').getAttribute('data-remove_user');
        document.querySelector('.conteudo-mensagem').innerHTML = '';
        jQuery.ajax({
            url: "{{URL::to('remove')}}",
            type: 'DELETE',
            data: {
                _token: CSRF_TOKEN,
                user_id: user_id                   
            }
        }).done(function(res){
            jQuery('#modalFormRemoverUsuario').modal('hide');
            if(!res.error)
                document.querySelector('.conteudo-mensagem').innerHTML =`<p>${res.message}</p>`;
            else
                document.querySelector('.conteudo-mensagem').innerHTML =`<p>Não foi possível realizar a ação</p>`;
            jQuery('#modalRetorno').modal('show');
        })
        reloadDataTable();
    })
</script>
@endsection