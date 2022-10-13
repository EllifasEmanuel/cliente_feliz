@extends('app')
@section('css')
<style>
    :root{
        --color_1: #24252A;
        --color_2: #ecf0f1;
        --color_3: #0a88a9;
        --color_4: rgba(0, 136, 169, 1);
        --color_5: rgba(0, 136, 169, 0.8);
    }
    *{
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    li, ul, a, button, p{
        font-family:  Helvetica, Arial, sans-serif;
        font-weight: 500;
        font-size: 16px;
        color: var(--color_1);
        text-decoration: none;
    }

    li, ul, a{
        transition: all 0.3s ease 0s;
    }

    header{
        background-color: var(--color_3) !important;
    }

    .logo{
        cursor: pointer;
    }

    a button{
        padding: 9px 25px;
        background-color: var(--color_4);
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease 0s;
    }

    a button:hover{
        background-color: var(--color_5);
    }

    .conteudo-obrigatorio{
      border-color: red !important;
    }

    .area-datatable{
        border: 2px solid var(--color_3);
        border-radius: 5px;
        padding: 5px;
    }

    .conteudo-apresentacao h3{
        color: var(--color_3);
        text-align: center;
    }

    #tabelaUsuarios{
        color: var(--color_3);
        text-align: center;
    }
    #tabelaUsuarios th{
        text-align: center;
    }

    #tabelaUsuarios button{
        background: none;
        padding: 5px;
        border-radius: 5px;
    }

</style>
@endsection
@section('content')
<div class="conteudo py-4">
    <div class="container">
        <div class="conteudo-apresentacao">
            <p>Seja bem-vindo: {{ Auth::user()->name }}</p>
            <h3>Gestão de Usuários</h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12 area-datatable">
                <table class="table" id="tabelaUsuarios">
                    <thead>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ações</th>
                    </thead>
                </table> 
            </div>

            <div> 
                <a href="{{URL::to('export')}}" target="_blank" rel="noopener noreferrer">
                    <button class="btn-primary">Baixar PDF</button>
                </a>
            </div>

            <div>
                <button>Novo usuário</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditar"  tabindex="-1">
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
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#tabelaUsuarios').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{URL::to('show')}}",
            columns:[
                {data:'id', class:'table_user_id', id:'id'},
                {data:'name', class:'table_user_name', name:'name'},
                {data: 'acoes', class:'table_acoes',
                render(data, type, trData) {
                    return `
                        <div class="area-action">
                            <button type="button" class="botaoEditar" button" title="Editar" onclick="abrirModalEdicao(this)">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="botaoExcluir" button" title="Remover" onclick="removerUsuario(this)">
                                <i class="fa-regular fa-pen-to-square"></i>
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

    const abrirModalEdicao = (el) =>{
        const user_id = el.parentElement.parentElement.parentElement.querySelector('.table_user_id').textContent;
        const user_name = el.parentElement.parentElement.parentElement.querySelector('.table_user_name').textContent;
        const modalTitle = document.querySelector('#tituloModal').textContent = `Edição de usuário - ${user_name}`;
        document.querySelector('.modal-body').setAttribute('data-user_id', user_id);
        jQuery('#modalEditar').modal('show');
    }

    const reloadDataTable = () =>{
        jQuery('#tabelaUsuarios').DataTable().ajax.reload();
    }

    const salvaInformacoesEdicao = () =>{
        const confirmar = confirm('Deseja atualizar?');
        if(confirmar){
            const area_user_name = document.querySelector('#inputName');
            const area_user_email = document.querySelector('#inputEmail');
            const area_user_senha = document.querySelector('#inputSenha');
            const area_user_senha_confirmacao = document.querySelector('#inputSenhaConfirmacao');
            const user_id = document.querySelector('.modal-body').getAttribute('data-user_id');
            const retornoFuncao = validaDadosEdicao(area_user_name, area_user_email, area_user_senha, area_user_senha_confirmacao);
            if(!retornoFuncao){
                alert('Não foi possível atualizar o usuário.');
            }else{
                const user_name = area_user_name.value
                const user_email = area_user_email.value
                const user_senha = area_user_senha.value
                const user_confirmacao_senha = area_user_senha_confirmacao
                jQuery.ajax({
                    type: 'GET',
                    url: "{{URL::to('update')}}",
                    data: {
                        user_id: user_id,
                        user_name: user_name,
                        user_email: user_email,
                        user_senha: user_senha,
                        user_confirmacao_senha: user_confirmacao_senha                        
                    }
                }).done(function(res){
                    console.log(res);
                })
            }
        }else{
            alert('Ação não realizada!');
        }        
        reloadDataTable();
    }

    const validaDadosEdicao = (area_user_name, area_user_email, area_user_senha, area_user_senha_confirmacao) => {
        if(!area_user_name.value || !area_user_email.value || !area_user_senha.value || !area_user_senha_confirmacao.value){
            if(!area_user_name.value)
                area_user_name.classList.add('conteudo-obrigatorio');
            else
                area_user_name.classList.remove('conteudo-obrigatorio');
            if(!area_user_email.value)
                area_user_email.classList.add('conteudo-obrigatorio');
            else
                area_user_email.classList.remove('conteudo-obrigatorio');
            if(!area_user_senha.value)
                area_user_senha.classList.add('conteudo-obrigatorio');
            else
                area_user_senha.classList.remove('conteudo-obrigatorio');
            if(!area_user_senha_confirmacao.value)
                area_user_senha_confirmacao.classList.add('conteudo-obrigatorio');
            else
                area_user_senha_confirmacao.classList.remove('conteudo-obrigatorio');
            return false;
        }

        area_user_name.classList.remove('conteudo-obrigatorio');
        area_user_email.classList.remove('conteudo-obrigatorio');
        area_user_senha.classList.remove('conteudo-obrigatorio');
        area_user_senha_confirmacao.classList.remove('conteudo-obrigatorio');
        return true;
        
    }

    const removerUsuario = (el) =>{
        const confirmar = confirm('Deseja remover o usuário?');
        if(confirmar){
            const user_id = el.parentElement.parentElement.parentElement.querySelector('.table_user_id').textContent;
            jQuery.ajax({
                type: 'GET',
                url: "{{URL::to('remove')}}",
                data: {
                    user_id: user_id                   
                }
            }).done(function(res){
                console.log(res);
            })
        }else{
            alert('Não foi possível remover o usuário.');
        }
        reloadDataTable();
    }
</script>
@endsection