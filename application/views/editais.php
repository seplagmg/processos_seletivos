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
                        <div class=\"col-12\">";

if($menu2 == 'create'){
        echo "
                                <div class=\"tsm-inner-content p-0\">
                                        <div class=\"main-body\">
                                        <div class=\"page-wrapper p-0\">
                                                <div class=\"page-body\">
                                                <div class=\"row\" style=\"position:relative; left:15px;\">
                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:280px; min-width:240px;\">
                                                        <div class=\"menu1\">
                                                                <button class=\"tablinks primeiro active\"><span class=\"pcoded-mclass\">Aprovação</span><span class=\"pcoded-micon\"><i class=\"fas fa-check\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                                <hr class=\"m-0 p-0\" style=\"border:none;\">

                                                        </div>
                                                </div>
                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">
                                                        <div class=\"w-100 h-100 p-3 pb-5\">
                                                                <div class=\"row sub-title mb-1\" style=\"letter-spacing:0px\">
                                                                        <div class=\"col-lg-8\">
                                                                                <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                        </div>
                                                                </div>
        ";
}
else if($menu2 == 'publicar' || $menu2 == 'edit'){
        echo "
                <div class=\"tsm-inner-content p-0\">
                        <div class=\"main-body\">
                                <div class=\"page-wrapper p-0\">
                                        <div class=\"page-body\">
                                                <div class=\"row\" style=\"position:relative; left:15px;\">
                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:280px; min-width:240px;\">
                                                        <div class=\"menu1\">
                                                                <button class=\"tablinks \" onclick=\"abreConteudo(event, 'div_aprovacao')\"><span class=\"pcoded-mclass\">Aprovação</span><span class=\"pcoded-micon\"><i class=\"fas fa-check\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                                <hr class=\"m-0 p-0\" style=\"border:none;\">
                                                                <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'div_publicacao')\"><span class=\"pcoded-mclass\">Complementar cadastro</span><span class=\"pcoded-micon\"><i class=\"fas fa-arrow-up\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                        </div>
                                                </div>
                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">
        ";
        echo "                                  <div class=\"w-100 h-100 p-3 pb-5\">";

        echo "                                                  <div class=\"row sub-title mb-1\" style=\"letter-spacing:0px\">
                                                                        <div class=\"col-lg-8\">
                                                                                <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                        </div>
                                                                </div>
";
}
else if($menu2 == 'view'){
        echo "
        <div class=\"tsm-inner-content p-0\">
                <div class=\"main-body\">
                        <div class=\"page-wrapper p-0\">
                                <div class=\"page-body\">
                                        <div class=\"row\" style=\"position:relative;\">
                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:240px; min-width:240px;\">
                                                        <div class=\"menu1\">";
        if(strlen($se_prorrogacao) > 0){
                echo "
                                                                <button class=\"tablinks primeiro\" onclick=\"abreConteudo(event, 'div_aprovacao')\"><span class=\"pcoded-mclass\">Aprovação</span><span class=\"pcoded-micon\"><i class=\"fas fa-check\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                                <hr class=\"m-0 p-0\" style=\"border:none;\">
                                                                <button class=\"tablinks\" onclick=\"abreConteudo(event, 'div_publicacao')\"><span class=\"pcoded-mclass\">Complementar cadastro</span><span class=\"pcoded-micon\"><i class=\"fas fa-arrow-up\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                                <button class=\"tablinks active\" onclick=\"abreConteudo(event, 'div_prorrogacao')\"><span class=\"pcoded-mclass\">Prorrogar inscrições</span><span class=\"pcoded-micon\"><i class=\"fas fa-calendar\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>";
        }
        else{
                echo "
                                                                <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'div_aprovacao')\"><span class=\"pcoded-mclass\">Aprovação</span><span class=\"pcoded-micon\"><i class=\"fas fa-check\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                                <hr class=\"m-0 p-0\" style=\"border:none;\">
                                                                <button class=\"tablinks\" onclick=\"abreConteudo(event, 'div_publicacao')\"><span class=\"pcoded-mclass\">Complementar cadastro</span><span class=\"pcoded-micon\"><i class=\"fas fa-arrow-up\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                                <button class=\"tablinks\" onclick=\"abreConteudo(event, 'div_prorrogacao')\"><span class=\"pcoded-mclass\">Prorrogar inscrições</span><span class=\"pcoded-micon\"><i class=\"fas fa-calendar\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>";
        }

        echo "
                                                        </div>
                                                </div>
                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">
        ";
        echo "                                          <div class=\"w-100 h-100 p-3 pb-5\">";

        echo "                                                  <div class=\"row sub-title mb-1\" style=\"letter-spacing:0px\">
                                                                        <div class=\"col-lg-8\">
                                                                                <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}</h4>
                                                                        </div>
                                                                </div>
        ";
}
else{
        echo "
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
                                                            </div>
        ";
}

if($menu2 == 'index' && ($this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'sugesp') ){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                        <a href=\"".base_url('Editais/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Cadastrar e aprovar edital </a>
                                                                    </div>";
}
else if(($menu2 == 'create') && ($sucesso != '' && $erro != '')){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_usuarios').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Editais/index')."'\">Cancelar</button>
                                                                    </div>";
}
if (($menu2 != 'view') && ($menu2 != 'create') && ($menu2 != 'publicar') && ($menu2 != 'edit')){
echo "
                                                            </div>";
}
if($menu2 == 'index'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" ".($inativo == 1? "checked=\"checked\" ":"")." /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table id=\"usuarios_table\" class=\"table table-striped table-bordered table-hover\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome do Edital</th>
                                                                                            <th>Ano</th>
                                                                                            <th>Órgão Gestor</th>
                                                                                            <th>Status</th>
                                                                                            <th>Início</th>
                                                                                            <th>Fim</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($usuarios);
        if(isset($editais)){
                $atual = time();
                foreach ($editais as $linha){
                        //$data_inicio = strtotime($linha->dt_inicio);
                        $dt_inicio = strtotime($linha -> dt_inicio);
                        $dt_fim = strtotime($linha -> dt_fim);
                        $date = DateTime::createFromFormat("Y-m-d", $linha -> dt_aprovacao);
                        //echo $date->format("Y");

                        echo "
                                                                                    <tr>
                                                                                            <td class=\"align-middle\">".$linha -> vc_edital."</td>
											    <td class=\"align-middle\">".$date->format("Y")."</td>
                                                                                            <td class=\"align-middle\">".$linha -> vc_instituicao."</td>

                                                                                            <td class=\"align-middle\">";
                        if($linha -> en_status == 'aprovado'){
                                echo "Aprovado";
                        }
                        if($linha -> en_status == 'publicado'){
                                if($dt_inicio > $atual){
                                        echo "Publicado";
                                }
                                else{

                                        if($dt_fim > $atual){
                                                echo "Em período de inscrições";
                                        }
                                        else if($linha -> total_vagas > 0 && $linha -> total_vagas == $linha -> total_finalizado){
                                                echo "Finalizado";
                                        }
                                        else{
                                                echo "Inscrições em Avaliação";
                                        }
                                }

                        }
                        echo "</td>
                                                                                            <td class=\"align-middle\">".show_date($linha->dt_inicio,true)."</td>
                                                                                            <td class=\"align-middle\">".show_date($linha->dt_fim,true)."</td>
                                                                                            <td class=\"align-middle text-center\">";
                        //if($linha -> bl_removido == '0'){

                                if($this -> session -> perfil == 'orgaos'){
                                        if($linha -> en_status == 'aprovado'){

                                                echo anchor('Editais/publicar/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-arrow-up"></i>Complementar cadastro', " class=\"btn btn-sm btn-square btn-primary\" title=\"Complementar cadastro\"");

                                        }
                                        else{
                                                if($dt_inicio > $atual){
                                                        echo anchor('Editais/edit/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-edit"></i>Editar', " class=\"btn btn-sm btn-square btn-warning\" title=\"Editar\"");
                                                }
                                                else{
                                                        echo anchor('Editais/view/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-search"></i>Visualizar', " class=\"btn btn-sm btn-square btn-warning\" title=\"Visualizar\"");
                                                }

                                        }

                                }
                                else if($this -> session -> perfil == 'sugesp'){
                                        if($linha -> en_status == 'publicado' && !($dt_inicio > $atual)){

                                                echo anchor('Editais/view/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-search"></i>Visualizar', " class=\"btn btn-sm btn-square btn-warning\" title=\"Visualizar\"");
                                        }
                                        else if($linha -> en_status == 'aprovado'){
                                                echo anchor('Editais/review/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-edit"></i>Rever', " class=\"btn btn-sm btn-square btn-warning\" title=\"Rever\"");
                                        }
                                }
                                else if($this -> session -> perfil == 'administrador'){
                                        if($linha -> en_status == 'publicado' && !($dt_inicio > $atual)){

                                                echo anchor('Editais/view/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-search"></i>Visualizar', " class=\"btn btn-sm btn-square btn-warning\" title=\"Visualizar\"");
                                        }
                                        else if($linha -> en_status == 'aprovado'){
                                                echo anchor('Editais/review/'.$linha -> pr_edital, '<i class="fa fa-lg mr-1 fa-edit"></i>Rever', " class=\"btn btn-sm btn-square btn-warning\" title=\"Rever\"");
                                        }
                                        /*if($linha -> en_status == 'aprovado'){
                                                echo anchor('Editais/publicar/'.$linha -> pr_edital, '<i class="fa fa-arrow-up">Publicar</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Publicar\"");
                                        }*/
                                }

                                //echo anchor('Usuarios/edit/'.$linha -> pr_edital, '<i class="fa fa-arrow-up"> Publicar</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Editar\"");

                                //echo "<button type=\"button\" class=\"btn btn-sm btn-square btn-danger alert-confirm\" title=\"Desativar usuário\" onclick=\"confirm_delete(".$linha -> pr_edital.");\"><i class=\"fa fa-lg fa-times-circle mr-0\"></i></a>";


                        /*}
                        else{

                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-success btn-square\" title=\"Reativar usuário\" onclick=\"confirm_reactivate(".$linha -> pr_edital.");\"><i class=\"fa fa-lg fa-plus-circle mr-0\"></i></a>";

                        }*/
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
        $pagina['js'] = "
                                            <script type=\"text/javascript\">
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
                                                            \"search\":         \"Pesquisar:\",
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
else if($menu2 == 'create' || $menu2 == 'review'){
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


                $attributes = array('id' => 'aprovar_edital');
                if($menu2 == 'review' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }

                echo "  <div id=\"div_aprovacao\" class=\"menu1conteudo menu1Primeiro\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Tipo de Edital <abbr title="Obrigatório">*</abbr>', 'TipoEdital', $attributes);

                                                if(!isset($en_tipo_edital) || (strlen($en_tipo_edital) == 0 && strlen(set_value('TipoEdital')) > 0)){
                                                        $en_tipo_edital = set_value('TipoEdital');
                                                }


                                                if(($this -> session -> brumadinho == '1' && $this -> session -> pps == '1') || $this -> session -> perfil == 'administrador'){
                                                        $attributes = array(

                                                                'brumadinho' => 'PSS Brumadinho',
                                                                'pps' => 'PSS Geral',

                                                                );
                                                }
                                                else if($this -> session -> brumadinho == '1'){
                                                        $attributes = array(

                                                                'brumadinho' => 'PSS Brumadinho',

                                                                );
                                                }
                                                else if($this -> session -> pps == '1'){
                                                        $attributes = array(

                                                                'pps' => 'PSS Geral',

                                                                );
                                                }
                                                else{
                                                        $attributes = array();
                                                }

                                                if(strstr($erro, "'TipoEdital'")){
                                                        echo form_dropdown('TipoEdital', $attributes, $en_tipo_edital, "class=\"form-control is-invalid\" id=\"perfil\"");
                                                }
                                                else{
                                                        echo form_dropdown('TipoEdital', $attributes, $en_tipo_edital, "class=\"form-control\" id=\"perfil\"");
                                                }

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Nome do Edital <abbr title="Obrigatório">*</abbr>', 'Nome', $attributes);

                                                if(!isset($vc_edital) || (strlen($vc_edital) == 0 && strlen(set_value('Nome')) > 0)){
                                                        $vc_edital = set_value('Nome');
                                                }
                                                $attributes = array('name' => 'Nome',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Nome'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $vc_edital);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Data de Aprovação <abbr title="Obrigatório">*</abbr>', 'Aprovacao', $attributes);

                                                if(!isset($dt_aprovacao) || (strlen($dt_aprovacao) == 0 && strlen(set_value('Aprovacao')) > 0)){
                                                        $dt_aprovacao = set_value('Aprovacao');
                                                }
                                                $attributes = array('name' => 'Aprovacao',
                                                                'type' => 'date',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Data de Aprovação'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes,  $dt_aprovacao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Órgão Gestor do Edital <abbr title="Obrigatório">*</abbr>', 'Instituicao', $attributes);

                                                if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('Instituicao')) > 0)){
                                                        $es_instituicao = set_value('Instituicao');
                                                }

                                                $instituicoes=array(''=>'')+$instituicoes;
                                                if(strstr($erro, "'Órgão Gestor do Edital'")){
                                                        echo form_dropdown('Instituicao', $instituicoes, $es_instituicao, "class=\"form-control is-invalid\"");
                                                }
                                                else{
                                                        echo form_dropdown('Instituicao', $instituicoes, $es_instituicao, "class=\"form-control\"");
                                                }

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número de Vagas no Ensino Superior <abbr title="Obrigatório">*</abbr>', 'Superior', $attributes);

                                                if(!isset($nu_vagas_superior) || (strlen($nu_vagas_superior) == 0 && strlen(set_value('Superior')) > 0)){
                                                        $nu_vagas_superior = set_value('Superior');
                                                }
                                                $attributes = array('name' => 'Superior',
                                                                'id' => 'Superior',
                                                                'type' => 'number',
                                                                'min' => 0,
                                                                'oninput' => "if(document.getElementById('Superior').value<0){document.getElementById('Superior').value=0;}",
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Número de Vagas no Ensino Superior'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $nu_vagas_superior);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número de Vagas no Ensino Médio <abbr title="Obrigatório">*</abbr>', 'Medio', $attributes);

                                                if(!isset($nu_vagas_medio) || (strlen($nu_vagas_medio) == 0 && strlen(set_value('Medio')) > 0)){
                                                        $nu_vagas_medio = set_value('Medio');
                                                }
                                                $attributes = array('name' => 'Medio',
                                                                'id' => 'Medio',
                                                                'type' => 'number',
                                                                'min' => 0,
                                                                'oninput' => "if(document.getElementById('Medio').value<0){document.getElementById('Medio').value=0;}",
                                                                'class' => 'form-control');
                                                if(strstr($erro, "Número de Vagas no Ensino Médio'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $nu_vagas_medio);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número de Vagas no Ensino Fundamental <abbr title="Obrigatório">*</abbr>', 'Fundamental', $attributes);

                                                if(!isset($nu_vagas_fundamental) || (strlen($nu_vagas_fundamental) == 0 && strlen(set_value('Fundamental')) > 0)){
                                                        $nu_vagas_fundamental = set_value('Fundamental');
                                                }
                                                $attributes = array('name' => 'Fundamental',
                                                                'id' => 'Fundamental',
                                                                'type' => 'number',
                                                                'min' => 0,
                                                                'oninput' => "if(document.getElementById('Fundamental').value<0){document.getElementById('Fundamental').value=0;}",
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Número de Vagas no Ensino Fundamental'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $nu_vagas_fundamental);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número total de vagas ofertadas', 'Total', $attributes);
                                                $total = 0;
                                                if($nu_vagas_fundamental > 0){
                                                        $total += $nu_vagas_fundamental;
                                                }
                                                if($nu_vagas_medio > 0){
                                                        $total += $nu_vagas_medio;
                                                }
                                                if($nu_vagas_superior > 0){
                                                        $total += $nu_vagas_superior;
                                                }
                                                //$total = $nu_vagas_fundamental + $nu_vagas_medio + $nu_vagas_superior;
                                                $attributes = array('name' => 'Total',
                                                                'id' => 'Total',
                                                                'type' => 'number',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');
                                                if(strstr($erro, "'E-mail'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $total);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Marque este campo caso não haja exigência de experiência profissional para a vaga', 'alt' => 'Vagas sem exigência de experiência');
                                                echo form_label('Vaga restrita por CPF no mesmo edital?', 'restrito', $attributes);

                                                $attributes = array('name' => 'restrito', 'value' => '1', 'class' => 'ml-3');
                                                if(!isset($bl_restrito) || (strlen($bl_restrito) == 0 && strlen(set_value('restrito')) > 0)){
                                                        $bl_restrito = set_value('restrito');
                                                }
                                                echo form_checkbox($attributes, '1', ($bl_restrito=='1'));

                                                echo "<div class=\"form-group row lx-3\"></div>";

                echo "                  </div>
                                </div>";

                echo "                                                  <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                    <div class=\"col-lg-12 text-left\">";
                $attributes = array('class' => 'btn btn-primary');
                if($menu2 == 'create'){
                        echo form_submit('aprovar_edital', 'Cadastrar e Aprovar', $attributes);
                }
                else{
                        echo form_submit('rever', 'Rever edital aprovado', $attributes);
                }

                echo "
                                                                                          <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Editais/index')."'\">Cancelar</button>
                                                                                    </div>
                                                                            </div>
                                                                        </div>

                        </div>";

                echo "  </form>
                        </div>
                </div>        ";

                $pagina['js']="
                        <script type=\"text/javascript\">
                        function total_notas(){
                                var total = 0;
                                if($('#Fundamental').val()){
                                        total += parseInt($('#Fundamental').val());
                                }
                                if($('#Medio').val()){
                                        total += parseInt($('#Medio').val());
                                }
                                if($('#Superior').val()){
                                        total += parseInt($('#Superior').val());
                                }

                                $('#Total').val(total);
                        }
                        $(document).ready(function(){

                                $('#Fundamental').change(function() {
                                        total_notas();
                                });
                                $('#Medio').change(function() {
                                        total_notas();
                                });
                                $('#Superior').change(function() {
                                        total_notas();
                                });

                        });
                        </script>

                        <script type=\"text/javascript\">
                                function abreConteudo(evt, link) {
                                        var i, tabcontent, tablinks;


                                        tabcontent = document.getElementsByClassName(\"menu1conteudo\");
                                        for (i = 0; i < tabcontent.length; i++) {
                                                tabcontent[i].style.display = \"none\";
                                        }


                                        tablinks = document.getElementsByClassName(\"tablinks\");
                                        for (i = 0; i < tablinks.length; i++) {
                                                tablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
                                        }


                                        document.getElementById(link).style.display = \"block\";
                                        evt.currentTarget.className += \" active\";

                                }




                                $(document).ready(function(){
                                        $('#div_aprovacao').show();


                                });
                        </script>";
        }
}

else if($menu2 == 'publicar' || $menu2 == 'edit'){
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
                $attributes = array('id' => 'form_usuarios');
                //if($menu2 == 'publicar' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                /*}
                else{
                        echo form_open($url, $attributes);
                }*/

                echo "  <div id=\"div_aprovacao\" class=\"menu1conteudo\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Tipo de Edital', 'TipoEdital', $attributes);

                                        if(!isset($en_tipo_edital) || (strlen($en_tipo_edital) == 0 && strlen(set_value('TipoEdital')) > 0)){
                                                $en_tipo_edital = set_value('TipoEdital');
                                        }

                                        $attributes = array('name' => "TipoEdital",

                                                                'maxlength' => '100',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');
                                        $res = "";
                                        if($en_tipo_edital == 'brumadinho'){
                                                $res = "PSS Brumadinho";
                                        }
                                        else if($en_tipo_edital == 'pps'){
                                                $res = "PSS Geral";
                                        }
                                        echo form_input( $attributes, $res);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Nome do Edital', 'Nome', $attributes);

                                        if(!isset($vc_edital) || (strlen($vc_edital) == 0 && strlen(set_value('Nome')) > 0)){
                                                $vc_edital = set_value('Nome');
                                        }
                                        $attributes = array('name' => 'Nome',
                                                        'maxlength'=>'200',
                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled'
                                                        );

                                        echo form_input($attributes, $vc_edital);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Data de Aprovação', 'Aprovacao', $attributes);

                                        if(!isset($dt_aprovacao) || (strlen($dt_aprovacao) == 0 && strlen(set_value('Aprovacao')) > 0)){
                                                $dt_aprovacao = set_value('Aprovacao');
                                        }
                                        $attributes = array('name' => 'Aprovacao',

                                                        'type' => 'date',
                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled');
                                        if(strstr($erro, "'Data de Aprovação'")){
                                                $attributes['class'] = 'form-control is-invalid';
                                        }
                                        echo form_input($attributes,  $dt_aprovacao);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Órgão Gestor do Edital', 'Instituicao', $attributes);

                                        if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('Instituicao')) > 0)){
                                                $es_instituicao = set_value('Instituicao');
                                        }

                                        $instituicoes=array(''=>'')+$instituicoes;
                                        $attributes = array('name' => 'Instituicao',


                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled');
                                        echo form_input($attributes,$instituicoes[$es_instituicao]);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Número de Vagas no Ensino Superior', 'Superior', $attributes);

                                        if(!isset($nu_vagas_superior) || (strlen($nu_vagas_superior) == 0 && strlen(set_value('Superior')) > 0)){
                                                $nu_vagas_superior = set_value('Superior');
                                        }
                                        $attributes = array('name' => 'Superior',
                                                        'id' => 'Superior',
                                                        'type' => 'number',
                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled');

                                        echo form_input($attributes, $nu_vagas_superior);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Número de Vagas no Ensino Médio', 'Medio', $attributes);

                                        if(!isset($nu_vagas_medio) || (strlen($nu_vagas_medio) == 0 && strlen(set_value('Medio')) > 0)){
                                                $nu_vagas_medio = set_value('Medio');
                                        }
                                        $attributes = array('name' => 'Medio',
                                                        'id' => 'Medio',
                                                        'type' => 'number',
                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled');

                                        echo form_input($attributes, $nu_vagas_medio);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Número de Vagas no Ensino Fundamental', 'Fundamental', $attributes);

                                        if(!isset($nu_vagas_fundamental) || (strlen($nu_vagas_fundamental) == 0 && strlen(set_value('Fundamental')) > 0)){
                                                $nu_vagas_fundamental = set_value('Fundamental');
                                        }
                                        $attributes = array('name' => 'Fundamental',
                                                        'id' => 'Fundamental',
                                                        'type' => 'number',
                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled');

                                        echo form_input($attributes, $nu_vagas_fundamental);

                                        echo "<div class=\"form-group row lx-3\"></div>";

                                        $attributes = array('class' => 'control-label');
                                        echo form_label('Número total de vagas ofertadas', 'Total', $attributes);

                                        $total = $nu_vagas_fundamental + $nu_vagas_medio + $nu_vagas_superior;
                                        $attributes = array('name' => 'Total',
                                                        'id' => 'Total',
                                                        'type' => 'number',
                                                        'class' => 'form-control',
                                                        'disabled' => 'disabled');

                                        echo form_input($attributes, $total);


                echo "
                                        </div>
                                </div>
                        </div>";

                echo "  <div id=\"div_publicacao\" class=\"menu1conteudo menu1Primeiro\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Data de Publicação <abbr title="Obrigatório">*</abbr>', 'Publicacao', $attributes);

                                                if(!isset($dt_publicacao) || (strlen($dt_publicacao) == 0 && strlen(set_value('Publicacao')) > 0)){
                                                        $dt_publicacao = set_value('Publicacao');
                                                }
                                                $attributes = array('name' => 'Publicacao',

                                                                'type' => 'date',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Data de Publicação'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes,  $dt_publicacao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Vigência do Edital (meses)<abbr title="Obrigatório">*</abbr>', 'Vigência', $attributes);

                                                if(!isset($nu_vigencia_meses) || (strlen($nu_vigencia_meses) == 0 && strlen(set_value('Vigencia')) > 0)){
                                                        $nu_vigencia_meses = set_value('Vigencia');
                                                }
                                                $attributes = array('name' => 'Vigencia',
                                                                'id' => 'Vigencia',
                                                                'type' => 'number',
                                                                'min' => 0,
                                                                'oninput' => "if(document.getElementById('Vigencia').value<0){document.getElementById('Vigencia').value=0;}",
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Vigência do Edital'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $nu_vigencia_meses);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Link para o edital <abbr title="Obrigatório">*</abbr>', 'Link', $attributes);

                                                if(!isset($vc_link) || (strlen($vc_link) == 0 && strlen(set_value('Link')) > 0)){
                                                        $vc_link = set_value('Link');
                                                }
                                                $attributes = array('name' => 'Link',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',

                                                                );
                                                if(strstr($erro, "'Link para o edital'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $vc_link);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('E-mail para o contato da comissão <abbr title="Obrigatório">*</abbr>', 'Email', $attributes);

                                                if(!isset($vc_email) || (strlen($vc_email) == 0 && strlen(set_value('Email')) > 0)){
                                                        $vc_email = set_value('Email');
                                                }
                                                $attributes = array('name' => 'Email',
                                                                'type' => 'email',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',
                                                                );
                                                if(strstr($erro, "'E-mail para o contato da comissão'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $vc_email);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Início das inscrições das vagas<abbr title="Obrigatório">*</abbr>', 'Inicio', $attributes);

                                                if(!isset($dt_inicio) || (strlen($dt_inicio) == 0 && strlen(set_value('Inicio')) > 0)){
                                                        $dt_inicio = set_value('Inicio');
                                                }
                                                $dt_inicio = str_replace(" ","T",$dt_inicio);
                                                $attributes = array('name' => 'Inicio',
                                                                'type' => 'datetime-local',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',

                                                                );
                                                if(strstr($erro, "'Início das inscrições'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $dt_inicio);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Término das inscrições das vagas <abbr title="Obrigatório">*</abbr>', 'Fim', $attributes);

                                                if(!isset($dt_fim) || (strlen($dt_fim) == 0 && strlen(set_value('Fim')) > 0)){
                                                        $dt_fim = set_value('Fim');
                                                }
                                                $dt_fim = str_replace(" ","T",$dt_fim);
                                                $attributes = array('name' => 'Fim',
                                                                'type' => 'datetime-local',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',

                                                                );
                                                if(strstr($erro, "'Término das inscrições'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, $dt_fim);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                echo "
                                                </div>
                                        </div>
                                ";

                echo "                                                  <div class=\"j-footer\">
                                                                                <div class=\"row\">
                                                                                        <div class=\"col-lg-12 text-left\">";
                                                                                                $attributes = array('class' => 'btn btn-primary');
                                                                                                if($menu2 == 'edit'){
                                                                                                        echo form_submit('salvar_edital', 'Editar', $attributes);
                                                                                                }
                                                                                                else{
                                                                                                        echo form_submit('salvar_edital', 'Complementar cadastro', $attributes);
                                                                                                }

                echo "
                                                                                           <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Editais/index')."'\">Cancelar</button>
                                                                                        </div>
                                                                                </div>

                                                                        </div>
                                                            </form>
                                                    </div>
                                                    </div>";

                $pagina['js']="
        <script type=\"text/javascript\">
                function abreConteudo(evt, link) {
                        var i, tabcontent, tablinks;


                        tabcontent = document.getElementsByClassName(\"menu1conteudo\");
                        for (i = 0; i < tabcontent.length; i++) {
                                tabcontent[i].style.display = \"none\";
                        }


                        tablinks = document.getElementsByClassName(\"tablinks\");
                        for (i = 0; i < tablinks.length; i++) {
                                tablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
                        }


                        document.getElementById(link).style.display = \"block\";
                        evt.currentTarget.className += \" active\";

                }




                $(document).ready(function(){
                        $('#div_publicacao').show();


                });
        </script>";
        }
}
else if($menu2 == 'view'){
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

                echo "  <div id=\"div_aprovacao\" class=\"menu1conteudo menu1Primeiro\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Tipo de Edital', 'TipoEdital', $attributes);

                                                if(!isset($en_tipo_edital) || (strlen($en_tipo_edital) == 0 && strlen(set_value('TipoEdital')) > 0)){
                                                        $en_tipo_edital = set_value('TipoEdital');
                                                }

                                                $attributes = array('name' => "TipoEdital",

                                                                        'maxlength' => '100',
                                                                        'class' => 'form-control',
                                                                        'disabled' => 'disabled');
                                                $res = "";
                                                if($en_tipo_edital == 'brumadinho'){
                                                        $res = "PSS Brumadinho";
                                                }
                                                else if($en_tipo_edital == 'pps'){
                                                        $res = "PSS Geral";
                                                }
                                                echo form_input( $attributes, $res);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Nome do Edital', 'Nome', $attributes);

                                                if(!isset($vc_edital) || (strlen($vc_edital) == 0 && strlen(set_value('Nome')) > 0)){
                                                        $vc_edital = set_value('Nome');
                                                }
                                                $attributes = array('name' => 'Nome',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled'
                                                                );

                                                echo form_input($attributes, $vc_edital);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Data de Aprovação', 'Aprovacao', $attributes);

                                                if(!isset($dt_aprovacao) || (strlen($dt_aprovacao) == 0 && strlen(set_value('Aprovacao')) > 0)){
                                                        $dt_aprovacao = set_value('Aprovacao');
                                                }
                                                $attributes = array('name' => 'Aprovacao',

                                                                'type' => 'date',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');
                                                if(strstr($erro, "'Data de Aprovação'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes,  $dt_aprovacao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Órgão Gestor do Edital', 'Instituicao', $attributes);

                                                if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('Instituicao')) > 0)){
                                                        $es_instituicao = set_value('Instituicao');
                                                }

                                                $instituicoes=array(''=>'')+$instituicoes;
                                                $attributes = array('name' => 'Instituicao',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');
                                                echo form_input($attributes,$instituicoes[$es_instituicao]);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número de Vagas no Ensino Superior', 'Superior', $attributes);

                                                if(!isset($nu_vagas_superior) || (strlen($nu_vagas_superior) == 0 && strlen(set_value('Superior')) > 0)){
                                                        $nu_vagas_superior = set_value('Superior');
                                                }
                                                $attributes = array('name' => 'Superior',
                                                                'id' => 'Superior',
                                                                'type' => 'number',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');

                                                echo form_input($attributes, $nu_vagas_superior);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número de Vagas no Ensino Médio', 'Medio', $attributes);

                                                if(!isset($nu_vagas_medio) || (strlen($nu_vagas_medio) == 0 && strlen(set_value('Medio')) > 0)){
                                                        $nu_vagas_medio = set_value('Medio');
                                                }
                                                $attributes = array('name' => 'Medio',
                                                                'id' => 'Medio',
                                                                'type' => 'number',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');

                                                echo form_input($attributes, $nu_vagas_medio);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número de Vagas no Ensino Fundamental', 'Fundamental', $attributes);

                                                if(!isset($nu_vagas_fundamental) || (strlen($nu_vagas_fundamental) == 0 && strlen(set_value('Fundamental')) > 0)){
                                                        $nu_vagas_fundamental = set_value('Fundamental');
                                                }
                                                $attributes = array('name' => 'Fundamental',
                                                                'id' => 'Fundamental',
                                                                'type' => 'number',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');

                                                echo form_input($attributes, $nu_vagas_fundamental);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Número total de vagas ofertadas', 'Total', $attributes);

                                                $total = $nu_vagas_fundamental + $nu_vagas_medio + $nu_vagas_superior;
                                                $attributes = array('name' => 'Total',
                                                                'id' => 'Total',
                                                                'type' => 'number',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');

                                                echo form_input($attributes, $total);

                                                echo "<div class=\"form-group row lx-3\"></div>";
                                                $attributes = array('class' => 'control-label', 'title' => 'Marque este campo caso não haja exigência de experiência profissional para a vaga', 'alt' => 'Vagas sem exigência de experiência');
                                                echo form_label('Vaga restrita por CPF no mesmo edital?', 'restrito', $attributes);

                                                $attributes = array('name' => 'restrito', 'value' => '1', 'class' => 'ml-3','disabled'=>'disabled');
                                                if(!isset($bl_restrito) || (strlen($bl_restrito) == 0 && strlen(set_value('restrito')) > 0)){
                                                        $bl_restrito = set_value('restrito');
                                                }
                                                echo form_checkbox($attributes, '1', ($bl_restrito=='1'));

                                                echo "<div class=\"form-group row lx-3\"></div>";

                echo "
                                        </div>
                                </div>
                        </div>";

                echo "  <div id=\"div_publicacao\" class=\"menu1conteudo\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Data de Publicação', 'Publicacao', $attributes);

                                                $attributes = array('name' => 'Publicacao',
                                                                'type' => 'date',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');

                                                echo form_input($attributes,  $dt_publicacao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Vigência do Edital (meses)', 'Vigência', $attributes);

                                                $attributes = array('name' => 'Vigencia',

                                                                'type' => 'number',

                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');

                                                echo form_input($attributes, $nu_vigencia_meses);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Link para o edital', 'Link', $attributes);

                                                $attributes = array('name' => 'Link',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled'
                                                                );

                                                echo form_input($attributes, $vc_link);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('E-mail para o contato da comissão', 'Email', $attributes);


                                                $attributes = array('name' => 'Email',
                                                                'type' => 'email',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled'
                                                                );

                                                echo form_input($attributes, $vc_email);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Início das inscrições das vagas', 'Inicio', $attributes);

                                                $dt_inicio = str_replace(" ","T",$dt_inicio);

                                                $attributes = array('name' => 'Inicio',
                                                                'type' => 'datetime-local',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled'
                                                                );

                                                echo form_input($attributes, $dt_inicio);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label');
                                                echo form_label('Término das inscrições das vagas', 'Fim', $attributes);

                                                $dt_fim = str_replace(" ","T",$dt_fim);

                                                $attributes = array('name' => 'Fim',
                                                                'type' => 'datetime-local',
                                                                'maxlength'=>'200',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled'
                                                                );

                                                echo form_input($attributes, $dt_fim);

                                                echo "<div class=\"form-group row lx-3\"></div>";


                        echo "
                                                </div>
                                        </div>
                                </div>";

                        echo "  <div id=\"div_prorrogacao\" class=\"menu1conteudo\">
                                        <div class=\"row\">
                                                <div class=\"col-sm-12\">
                                                        <div id=\"accordion\">
                                                                <h3 style=\"font-size:large\">Prorrogar inscrições</h3>
                                                                <div>";

                                                                        $attributes = array('id' => 'form_prorrogacoes');
                                                                        echo form_open($url, $attributes, array('codigo' => $codigo));

                                                                                $attributes = array('class' => 'control-label');
                                                                                echo form_label('Data atual de término das inscrições', 'Fim', $attributes);

                                                                                $dt_fim = str_replace(" ","T",$dt_fim);

                                                                                $attributes = array('name' => 'Fim',
                                                                                                'type' => 'datetime-local',
                                                                                                'maxlength'=>'200',
                                                                                                'class' => 'form-control',
                                                                                                'disabled' => 'disabled'
                                                                                                );

                                                                                echo form_input($attributes, $dt_fim);

                                                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                                                $attributes = array('class' => 'control-label');
                                                                                echo form_label('Nova data de término das inscrições <abbr title="Obrigatório">*</abbr>', 'FimNovo', $attributes);
                                                                                if(!isset($dt_fim2) || (strlen($dt_fim2) == 0 && strlen(set_value('FimNovo')) > 0)){
                                                                                        $dt_fim2 = set_value('FimNovo');
                                                                                }
                                                                                $attributes = array('name' => 'FimNovo',
                                                                                'type' => 'datetime-local',
                                                                                'maxlength'=>'200',
                                                                                'class' => 'form-control',

                                                                                );
                                                                                if(strstr($erro, "'Nova data de término das inscrições'")){
                                                                                        $attributes['class'] = 'form-control is-invalid';
                                                                                }
                                                                                echo form_input($attributes, $dt_fim2);

                                                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                                                $attributes = array('class' => 'control-label');
                                                                                echo form_label('Link de publicação da prorrogação<abbr title="Obrigatório">*</abbr>', 'LinkProrrogacao', $attributes);

                                                                                if(!isset($vc_link2) || (strlen($vc_link2) == 0 && strlen(set_value('LinkProrrogacao')) > 0)){
                                                                                        $vc_link2 = set_value('LinkProrrogacao');
                                                                                }
                                                                                $attributes = array('name' => 'LinkProrrogacao',
                                                                                'type' => 'text',
                                                                                'maxlength'=>'200',
                                                                                'class' => 'form-control',

                                                                                );
                                                                                if(strstr($erro, "'Link de publicação da prorrogação'")){
                                                                                        $attributes['class'] = 'form-control is-invalid';
                                                                                }
                                                                                echo form_input($attributes, $vc_link2);

                                                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                                                echo "

                                                                                <div class=\"j-footer\">
                                                                                        <div class=\"row\">
                                                                                                <div class=\"col-lg-12 text-left\">";

                                                                                                        $attributes = array('class' => 'btn btn-primary fa-clock','id'=>'salvar_edital');
                                                                                                        echo form_submit('salvar_edital', 'Prorrogar inscrições', $attributes);

                                                                                echo "          </div>
                                                                                        </div>
                                                                                </div>
                                                                        </form>
                                                                </div>

                                                        </div>";


                        echo "                         <div class=\"form-group row lx-3\"></div>";

                        echo "

                                                        <div class=\"dt-responsive table-responsive\">
                                                                <table id=\"prorrogacao_table\" class=\"table table-striped table-bordered table-hover\">
                                                                        <thead>
                                                                                <tr>
                                                                                        <th>Data de Prorrogação</th>
                                                                                        <th>Responsável</th>
                                                                                        <th>Data Anterior de Término</th>
                                                                                        <th>Nova Data de Término</th>
                                                                                        <th>Link de publicação da prorrogação</th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>";

                                                                                        if(isset($prorrogacoes)){
                                                                                                foreach ($prorrogacoes as $linha){
                                                                                                        //$date = DateTime::createFromFormat("Y-m-d", $linha -> dt_aprovacao);
                                                                                                        //echo $date->format("Y");

                                                                                                        echo "
                                                                                <tr>
                                                                                        <td class=\"align-middle\">".show_date($linha -> dt_prorrogacao,true)."</td>
                                                                                        <td class=\"align-middle\">".$linha -> vc_nome."</td>
                                                                                        <td class=\"align-middle\">".show_date($linha -> dt_fim_antigo,true)."</td>
                                                                                        <td class=\"align-middle\">".show_date($linha -> dt_fim_novo,true)."</td>
                                                                                        <td class=\"align-middle\">".$linha -> vc_link."</td>

                                                                                </tr>";
                                                                                                }
                                                                                        }

                                                        echo "          </tbody>
                                                                </table>
                                                        </div>";

                        echo "
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>";


                $pagina['js']="
                        <script type=\"text/javascript\">
                        $( function() {
                                $( '#accordion' ).accordion({ header: 'h3', collapsible: false, active: false, heightStyle: 'content' });

                        } );
                        jQuery(':submit').click(function (event) {
                                if (this.id == 'salvar_edital') {
                                        event.preventDefault();
                                        $(document).ready(function(){
                                                event.preventDefault();
                                                swal.fire({
                                                        title: 'Aviso de prorrogação do edital',
                                                        text: 'Prezado, ao prorrogar o edital irá alterar a data final de inscrições de todas as vagas vinculadas a esse edital. Deseja prorrogar?',
                                                        type: 'warning',
                                                        showCancelButton: true,
                                                        cancelButtonText: 'Não',
                                                        confirmButtonText: 'Sim, desejo prorrogar'
                                                })
                                                .then(function(result) {
                                                        if (result.value) {
                                                                //desfaz as configurações do botão
                                                                $('#salvar_edital').unbind(\"click\");
                                                                //clica, concluindo o processo
                                                                $('#salvar_edital').click();
                                                        }

                                                });


                                });
                                                                                                                                                                                                                }
                        });
                        </script>
                        <script type=\"text/javascript\">
                                function abreConteudo(evt, link) {
                                        var i, tabcontent, tablinks;


                                        tabcontent = document.getElementsByClassName(\"menu1conteudo\");
                                        for (i = 0; i < tabcontent.length; i++) {
                                                tabcontent[i].style.display = \"none\";
                                        }


                                        tablinks = document.getElementsByClassName(\"tablinks\");
                                        for (i = 0; i < tablinks.length; i++) {
                                                tablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
                                        }


                                        document.getElementById(link).style.display = \"block\";
                                        evt.currentTarget.className += \" active\";

                                }




                                $(document).ready(function(){";
                if(strlen($se_prorrogacao) > 0){
                        $pagina['js'].="
                                        $('#div_prorrogacao').show();
                                        $('#div_aprovacao').hide();
                                        ";
                }
                else{
                        $pagina['js'].="
                                        $('#div_aprovacao').show();";
                }


                $pagina['js'].="


                                });
                        </script>
                        <script type=\"text/javascript\">
                                $('#prorrogacao_table').DataTable({
                                        order: [
                                        [0, 'asc']
                                        ],
                                        columnDefs: [
                                                {
                                                'orderable': false,
                                                'targets': [-1]
                                                },
                                                {
                                                'searchable': false,
                                                'targets': [-1]
                                                }
                                        ],
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
                                                \"search\":         \"Pesquisar:\",
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
                                        }
                                });
                        </script>
                        ";
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