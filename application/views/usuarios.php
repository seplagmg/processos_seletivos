<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
$pagina['icone']=$icone;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this -> load -> view('internaCabecalho', $pagina);

echo "
                        <div class=\"col-12\">
                            <div class=\"tsm-inner-content\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper\">
                                        <div class=\"page-body\">
                                            <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                    <div class=\"card\">
                                                        <div class=\"card-block\">
                                                            <div class=\"row sub-title\" style=\"letter-spacing:0px\">
                                                                    <div class=\"col-lg-8\">
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>";
if($menu2 == 'index'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                        <a href=\"".base_url('Usuarios/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Novo usuário </a>
                                                                    </div>";
}
/*else if($menu2 == 'create' || $menu2 == 'edit'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_usuarios').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
                                                                    </div>";
}*/
echo "
                                                            </div>";
if($menu2 == 'index'){
        echo "
                <div id=\"accordion\">
                        <h3 style=\"font-size:large\">Filtros - Administradores</h3>
                        <div>";

                        $attributes = array('id' => 'form_filtros');
                        echo form_open($url, $attributes);

                                $attributes = array('class' => 'control-label');
                                echo form_label('CPF do usuário', 'cpf', $attributes);

                                $attributes = array('class' =>  'form-control',
                                                'name' => 'cpf',
                                                'id' => 'cpf',
                                                'maxlength' => '14');

                                echo form_input($attributes, set_value('cpf'));

                                echo "<div class=\"form-group row lx-3\"></div>";

                                $attributes = array('class' => 'control-label');
                                echo form_label('Nome do usuário', 'nome', $attributes);

                                $attributes = array('class' => 'form-control',
                                                    'name' => 'nome',
                                                    'id' => 'nome',
                                                    'maxlength' => '50');

                                echo form_input($attributes, set_value('nome'));

                                echo "<div class=\"form-group row lx-3\"></div>";

                                $attributes = array('class' => 'control-label');
                                echo form_label('E-mail do usuário', 'email', $attributes);

                                $attributes = array('class' => 'form-control',
                                                    'name' => 'email',
                                                    'id' => 'email',
                                                    'maxlength' => '50');

                                echo form_input($attributes, set_value('email'));

                                echo "<div class=\"form-group row lx-3\"></div>";

                                echo "  <div class=\"j-footer\">
                                                <div class=\"row\">
                                                        <div class=\"col-lg-12 text-left\">
                                                                <button type=\"button\" class=\"btn btn-primary\" onclick=\"botao_submit();\">Filtrar</button>
                                                                <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidatos/ListaCandidatos')."'\">Limpar</button>
                                                        </div>
                                                </div>
                                        </div>
                        </form>
                </div>
                </div>
                <hr>";
		$pagina['js']="
                <script type=\"text/javascript\">
                      $( function() {
                        $( '#accordion' ).accordion({ header: 'h3', collapsible: true, active: false });
			$('#cpf').inputmask('999.999.999-99');
                      } );
                </script>";
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" ".($inativo == 1? "checked=\"checked\" ":"")." /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table id=\"usuarios_table\" class=\"table table-striped table-bordered table-hover\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
										            <th>CPF</th>
                                                                                            <th>Perfil</th>
                                                                                            <th>E-mail</th>
                                                                                            <th>Instituição</th>
                                                                                            <th>Cadastro</th>

                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($usuarios);
        if(isset($usuarios)){
                foreach ($usuarios as $linha){
                        $dt_cadastro = human_to_unix($linha -> dt_cadastro.' 00:00:00');

                        $dt_ultimoacesso = human_to_unix($linha -> dt_ultimoacesso.' 00:00:00');
                        echo "
                                                                                    <tr>
                                                                                            <td class=\"align-middle\">".$linha -> vc_nome."</td>
											    <td class=\"align-middle\">".$linha -> vc_login."</td>
                                                                                            <td class=\"align-middle text-center\">";
                        if($linha -> en_perfil == 'candidato'){
                                echo 'Candidato';
                        }
                        else if($linha -> en_perfil == 'avaliador'){
                                echo 'Avaliador';
                        }
                        else if($linha -> en_perfil == 'sugesp'){
                                echo 'Supervisor Central';
                        }
                        else if($linha -> en_perfil == 'orgaos'){
                                echo 'Gestor do Órgão';
                        }
                        else if($linha -> en_perfil == 'administrador'){
                                echo 'Administrador';
                        }
                        echo "
                                                                                            <td class=\"align-middle\">".$linha -> vc_email."</td>
                                                                                            <td class=\"align-middle\">".$linha -> vc_instituicao."</td>
                                                                                            <td class=\"align-middle text-center\" data-search=\"".show_date($linha -> dt_cadastro)."\" data-order=\"$dt_cadastro\">".show_date($linha -> dt_cadastro)."</td>

                                                                                            <td class=\"align-middle text-center\">";
                        if($linha -> bl_removido == '0'){
                                if($linha -> pr_usuario != $this -> session -> uid){
                                        echo anchor('Usuarios/edit/'.$linha -> pr_usuario, '<i class="fa fa-lg mr-1 fa-edit"></i>Editar', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar\"");
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-warning\" title=\"Nova senha\" onclick=\"confirm_senha(".$linha -> pr_usuario.");\"><i class=\"fa fa-lg fa-envelope mr-1\"></i>Nova senha</a>";
                                        //echo anchor('#', '<i class="la la-envelope"></i>', " class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Nova senha\" onclick=\"confirma_senha(".$linha -> pr_usuario.");\"");
                                        //echo anchor('Usuarios/delete/'.$linha -> pr_usuario, '<i class="la la-times-circle"></i>', " class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"Excluir\"");
                                        echo "<button type=\"button\" class=\"btn btn-sm btn-square btn-danger alert-confirm\" title=\"Desativar usuário\" onclick=\"confirm_delete(".$linha -> pr_usuario.");\"><i class=\"fa fa-lg fa-times-circle mr-1\"></i>Desativar usuário</a>";
                                }

                        }
                        else{
                                if($linha -> pr_usuario != $this -> session -> uid){
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-success btn-square\" title=\"Reativar usuário\" onclick=\"confirm_reactivate(".$linha -> pr_usuario.");\"><i class=\"fa fa-lg fa-plus-circle mr-1\"></i>Reativar usuário</a>";
                                }
                        }
                        echo "</td>
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                        </div>
                                                    </div>";
        $pagina['js'] .= "
                                            <script type=\"text/javascript\">
                                                function ahref_lista(inativo,pagina){
                                                        document.getElementById('form_filtros').action='".base_url('Usuarios/index/')."'+inativo;
                                                        document.getElementById('form_filtros').submit();
                                                }
                                                function botao_submit(){
                                                        if(document.getElementById('inativo').checked == true){
                                                                ahref_lista(1);
                                                        }
                                                        else{
                                                                ahref_lista(0);
                                                        }
                                                }
                                                    function confirm_senha(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o envio de nova senha?',
                                                                        text: 'Será enviada uma nova senha para o e-mail do usuario.',
                                                                        type: 'info',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, envie'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Usuarios/novaSenha/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'O usuário perderá o acesso e seu CPF ficará como inativo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Usuarios/delete/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'O usuário voltará a ter acesso e receberá um e-mail com nova senha.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Usuarios/reactivate/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function check_inativo(){
                                                            if(document.getElementById('inativo').checked == true){
                                                                    $(location).attr('href', '".base_url('Usuarios/index/')."1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '".base_url('Usuarios/index/')."')
                                                            }
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#usuarios_table').DataTable({


                                                        'pageLength': 15,
                                                        'lengthMenu': [
                                                            [ 15, 25, 50, -1 ],
                                                            [ '15', '25', '50', 'Todos' ]
                                                        ],
                                                        'order': [
                                                            [0, 'asc']
                                                        ],
                                                        columnDefs: [
                                                            {  // set default column settings
                                                                'orderable': false,
                                                                'targets': [-1]
                                                            },
                                                            {
                                                                'searchable': false,
                                                                'targets': [-1]
                                                            }
                                                        ],
                                                        dom: 'Qfrtip',
                                                        searching: false,

                                                        language: {
                                                            \"decimal\":        \"\",
                                                            \"emptyTable\":     \"Nenhum item encontrado\",
                                                            \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                            \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                            \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                            \"infoPostFix\":    \"\",
                                                            \"thousands\":      \",\",
                                                            \"lengthMenu\":     \"Exibir: &nbsp &nbsp_MENU_\",
                                                            \"loadingRecords\": \"Carregando...\",
                                                            \"processing\":     \"Carregando...\",

                                                            \"zeroRecords\":    \"Nenhum item encontrado\",
                                                            \"paginate\": {
                                                                \"first\":      \"Primeira\",
                                                                \"last\":       \"Última\",
                                                                \"next\":       \"Próxima\",
                                                                \"previous\":   \"Anterior\"
                                                            },
                                                            \"aria\": {
                                                                \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                            }
                                                        },

                                                        deferRender: true
                                                    });
                                            </script>";
}
else if($menu2 == 'create' || $menu2 == 'edit'){
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }

        if(strlen($sucesso) == 0){
                $attributes = array('id' => 'salvar_usuario');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }

                echo "  <div class=\"row\">
                                <div class=\"col-sm-12\">";
                                        echo "<h5 class=\"mb-3\">Informações do usuário</h5>";

                $attributes = array('class' => 'control-label font-weight-normal');
                echo form_label('Nome completo <abbr title="Obrigatório">*:</abbr>', 'NomeCompleto', $attributes);
                if(!isset($vc_nome) || (strlen($vc_nome) == 0 && strlen(set_value('NomeCompleto')) > 0)){
                        $vc_nome = set_value('NomeCompleto');
                }
                $attributes = array('name' => 'NomeCompleto',
                                    'maxlength'=>'250',
                                    'class' => 'form-control');
                if(strstr($erro, "'Nome completo'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_nome);

                echo "<div class=\"form-group row lx-3\"></div>";

                $attributes = array('class' => 'control-label font-weight-normal');
                echo form_label('E-mail <abbr title="Obrigatório">*:</abbr>', 'Email', $attributes);

                if(!isset($vc_email) || (strlen($vc_email) == 0 && strlen(set_value('Email')) > 0)){
                        $vc_email = set_value('Email');
                }
                $attributes = array('name' => 'Email',
                                    'maxlength'=>'250',
                                    'class' => 'form-control');
                if(strstr($erro, "'E-mail'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_email);

                echo "<div class=\"form-group row lx-3\"></div>";

                $attributes = array('class' => 'control-label font-weight-normal');
                echo form_label('CPF <abbr title="Obrigatório">*:</abbr>', 'CPF', $attributes);

                if(!isset($vc_login) || (strlen($vc_login) == 0 && strlen(set_value('CPF')) > 0)){
                        $vc_login = set_value('CPF');
                }
                $attributes = array('name' => 'CPF',
                                    'id' => 'CPF',
                                    'maxlength'=>'14',
                                    'class' => 'form-control',
                                    'data-mask' => '999.999.999-99');
                if($menu2 != 'create'){
                        $attributes['readonly'] = 'readonly';
                }
                if(strstr($erro, "'CPF'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_login);

                echo "<div class=\"form-group row lx-3\"></div>";

                $attributes = array('class' => 'control-label font-weight-normal');
                echo form_label('Instituição <abbr title="Obrigatório">*:</abbr>', 'instituicao', $attributes);

                if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('instituicao')) > 0)){
                        $es_instituicao = set_value('instituicao');
                }
                /*$array_instituicoes = array();
                foreach($instituicoes as $instituicao){
                        $array_instituicoes[$instituicao -> pr_instituicao] = $instituicao -> vc_instituicao;
                }*/
                $instituicoes=array(''=>'')+$instituicoes;
                if(strstr($erro, "'Instituição'")){
                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\"");
                }

                echo "<div class=\"form-group row lx-3\"></div>";

                $attributes = array('class' => 'control-label font-weight-normal');
                echo form_label('Perfil <abbr title="Obrigatório">*:</abbr>', 'perfil', $attributes);

                if(!isset($en_perfil) || (strlen($en_perfil) == 0 && strlen(set_value('perfil')) > 0)){
                        $en_perfil = set_value('perfil');
                }
                if($this -> session -> perfil == 'administrador'){
                        $attributes = array(
                                '' => '',
                                'avaliador' => 'Avaliador',
                                'sugesp' => 'Supervisor Geral',
                                'orgaos' => 'Gestor do Órgão',
                                'administrador' => 'Administrador'
                                );
                }
                else if($this -> session -> perfil == 'sugesp'){
                        $attributes = array(
                                '' => '',
                                'avaliador' => 'Avaliador',
                                'orgaos' => 'Gestor do Órgão',

                                );
                }
                else if($this -> session -> perfil == 'orgaos'){
                        $attributes = array(
                                'avaliador' => 'Avaliador',

                                );
                }

                if(strstr($erro, "'Perfil'")){
                        echo form_dropdown('perfil', $attributes, $en_perfil, "class=\"form-control is-invalid\" id=\"perfil\"");
                }
                else{
                        echo form_dropdown('perfil', $attributes, $en_perfil, "class=\"form-control\" id=\"perfil\"");
                }

                echo "<div class=\"form-group row lx-3\"></div>";

                $attributes = array('class' => 'control-label font-weight-normal');
                echo form_label('Concede acesso às vagas:', '', $attributes);

                $inativo = 0;
                $attributes = array('name' => 'brumadinho', 'value' => '1');
                if(!isset($bl_brumadinho) || (strlen($bl_brumadinho) == 0 && strlen(set_value('brumadinho')) > 0)){
                        $bl_brumadinho = set_value('brumadinho');
                }
                if($this -> session -> brumadinho == '1'){
                        if($menu2 == 'create'){
                                $bl_brumadinho = '1';
                        }

                }
                else{
                        $attributes['disabled'] = 'disabled';
                }
                echo "<br/>";
                echo form_checkbox($attributes, '1', ($bl_brumadinho=='1'));
                echo "<label for=\"brumadinho\">PSS Brumadinho</label><br />";
                $attributes = array('name' => 'pps', 'value' => '1');
                if(!isset($bl_pps) || (strlen($bl_pps) == 0 && strlen(set_value('pps')) > 0)){
                        $bl_pps = set_value('pps');
                }
                if($this -> session -> pps == '1'){
                        if($menu2 == 'create'){
                                $bl_pps = '1';
                        }
                }
                else{
                        $attributes['disabled'] = 'disabled';
                }
                echo form_checkbox($attributes, '1', ($bl_pps=='1'));
                echo "<label for=\"pps\">PPS Geral</label>";

                echo "          </div>
                        </div>";

                echo "<div class=\"form-group row lx-3\"></div>";

                echo "
                                                                    <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                    <div class=\"col-lg-12 text-left\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_usuario', 'Salvar', $attributes);
                echo "
                                                                                    <button type=\"button\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
                                                                                    </div>
                                                                            </div>
                                                                    </div>

                                                            </form>
                                                    </div>";
                $pagina['js']="
        <script type=\"text/javascript\">

            $(document).ready(function(){

                    $('#CPF').inputmask('999.999.999-99');
            });
        </script>";
        }
}
else{
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                                    </div>
                                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                                    <div class=\"alert-text\">
                                                                                            $sucesso
                                                                                    </div>
                                                                            </div>";
        }
}
/*
echo "
                                                    </div>";*/
$this -> load -> view('internaRodape', $pagina);
?>