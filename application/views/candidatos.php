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
if($menu2 != 'ListaCandidatos' && strlen($sucesso) == 0 && ($menu2 == 'create' || $menu2 == 'edit')){
        echo "
                                                                        <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_candidatos').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidatos/ListaCandidatos')."'\">Cancelar</button>
                                                                        </div>";
}
echo "
                                                                    </div>";
if($menu2 == 'ListaCandidatos'){
        echo "
                                                                    <div id=\"accordion\">
                                                                        <h3 style=\"font-size:large\">Filtros - Administradores</h3>
                                                                        <div>
                                                                            ";
        $attributes = array('id' => 'form_filtros');
        echo form_open($url, $attributes);
        echo "
                                                                                <div class=\"form-group row\">
                                                                                    <label for=\"cpf\" class=\"col-lg-2 col-form-label text-right\">CPF</label>
                                                                                    <div class=\"col-xl-3 col-lg-4\">";
        $attributes = array('class' => 'form-control',
                                                'name' => 'cpf',
                                                'id' => 'cpf',
                                                'maxlength' => '14');
        echo form_input($attributes, set_value('cpf'));
        echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\">
                                                                                    <label for=\"nome\" class=\"col-lg-2 col-form-label text-right\">Nome</label>
                                                                                    <div class=\"col-xl-3 col-lg-4\">";
        $attributes = array('class' => 'form-control',
                                                'name' => 'nome',
                                                'id' => 'nome',
                                                'maxlength' => '50');
        echo form_input($attributes, set_value('nome'));
        echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\">
                                                                                    <label for=\"email\" class=\"col-lg-2 col-form-label text-right\">E-mail</label>
                                                                                    <div class=\"col-xl-3 col-lg-4\">";
        $attributes = array('class' => 'form-control',
                                                'name' => 'email',
                                                'id' => 'email',
                                                'maxlength' => '50');
        echo form_input($attributes, set_value('email'));
        echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"j-footer\">
                                                                                    <div class=\"row\">
                                                                                        <div class=\"col-lg-12 text-center\">";
        /*$attributes = array('class' => 'btn btn-primary');
        echo form_submit('servidores', 'Filtrar', $attributes);*/
        echo "
                                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"botao_submit();\">Filtrar</button>
                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidatos/ListaCandidatos')."'\">Limpar</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <hr/>";
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
                                                                        <table class=\"table table-striped table-bordered table-hover\" id=\"candidatos_table\">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Nome</th>
                                                                                    <th>CPF</th>
                                                                                    <th>E-mail</th>
                                                                                    <th>Cadastro</th>
                                                                                    <th>Status</th>
                                                                                    <th>Ações</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($candidatos);
        if(isset($candidatos)){
                foreach ($candidatos as $linha){
                        $dt_cadastro = mysql_to_unix($linha -> dt_cadastro);
                        echo "
                                                                                <tr>
                                                                                    <td>".$linha -> vc_nome."</td>
                                                                                    <td>".$linha -> ch_cpf."</td>
                                                                                    <td>".$linha -> vc_email."</td>
                                                                                    <td class=\"text-center\" data-search=\"".show_date($linha -> dt_cadastro)."\" data-order=\"$dt_cadastro\">".show_date($linha -> dt_cadastro)."</td>";
                        if($linha -> bl_removido == '1' || $linha -> removido == '1'){
                                echo "
                                                                                    <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Desativado</span>";
                        }
                        else if(strlen($linha -> pr_usuario) == 0){
                                echo "
                                                                                    <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">Indeferido(a)</span>";
                        }
                        else{
                                echo "
                                                                                    <td class=\"text-center\">".$linha -> cont.' candidatura(s)';
                        }
                        echo "</td>
                                                                                    <td class=\"text-center\" style=\"white-space:nowrap\">";
                        echo anchor('Candidatos/view/'.$linha -> pr_candidato, '<i class="fa fa-lg mr-1 fa-search"></i>Dados', " class=\"btn btn-sm btn-square btn-warning\" title=\"Dados\"");

                        if($linha -> bl_removido == '0' && $linha -> removido == '0'){
                                if($linha -> pr_usuario != $this -> session -> uid){
                                        if(strlen($linha -> pr_usuario) > 0){
                                                echo anchor('Candidatos/changeName/'.$linha -> pr_candidato, '<i class="fa fa-lg mr-0 fa-edit"></i>Alterar nome', " class=\"btn btn-sm btn-square btn-danger\" title=\"Alterar nome\"");
                                                echo anchor('Candidatos/changeEmail/'.$linha -> pr_candidato, '<i class="fa fa-lg mr-0 fa-edit"></i>Alterar e-mail', " class=\"btn btn-sm btn-square btn-danger\" title=\"Alterar e-mail\"");
                                                echo "
                                                                                        <a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Nova senha\" onclick=\"confirm_senha(".$linha -> pr_candidato.");\"><i class=\"fa fa-lg mr-1 fa-envelope\"></i>Nova senha</a>
                                                                                        <a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar usuário\" onclick=\"confirm_delete(".$linha -> pr_candidato.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i>Desativar usuário</a>";
                                        }
                                }

                        }
                        else if(strlen($linha -> pr_usuario) > 0 && $linha -> pr_usuario != $this -> session -> uid){
                                echo "
                                                                                        <a href=\"javascript:/\" class=\"btn btn-sm btn-success btn-square\" title=\"Reativar usuário\" onclick=\"confirm_reactivate(".$linha -> pr_candidato.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i>Reativar usuário</a>";

                        }
                        echo "
                                                                                    </td>
                                                                                </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                        </table>";
        if($paginacao > 0){
                echo "
                                                                        <div class=\"row\">
                                                                            <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                <div class=\"dataTables_info\" id=\"vagas_table_info\" role=\"status\" aria-live=\"polite\">Mostrando de ".((($paginacao-1)*30)+1)." até ";
                if(($paginacao*30) > $total){
                                echo $total;
                }
                else{
                                echo ($paginacao*30);
                }
                echo " de {$total} itens</div>
                                                                                </div>
                                                                                <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                    <div class=\"dataTables_paginate paging_simple_numbers\" id=\"vagas_table_paginate\">
                                                                                        <ul class=\"pagination\">";
                $extra='';
                /*
                if(strlen($_POST['termo1'])>0){
                                $extra.='&amp;termo1='.$_POST['termo1'];
                }
                if(strlen($_POST['termo2'])>0){
                                $extra.='&amp;termo2='.$_POST['termo2'];
                }
                if(strlen($_POST['termo3'])>0){
                                $extra.='&amp;termo3='.$_POST['termo3'];
                }
                if(strlen($_POST['termo4'])>0){
                                $extra.='&amp;termo4='.$_POST['termo4'];
                }
                if(strlen($_POST['termo5'])>0){
                                $extra.='&amp;termo5='.$_POST['termo5'];
                }
                if(strlen($_POST['termo6'])>0){
                                $extra.='&amp;termo6='.$_POST['termo6'];
                }
                if(strlen($_POST['unidade'])>0){
                                $extra.='&amp;unidade='.$_POST['unidade'];
                }
                if(strlen($_POST['orgao'])>0){
                                $extra.='&amp;orgao='.$_POST['orgao'];
                }*/
                if($paginacao > 1){
                        echo "
                                                                                            <li class=\"paginate_button page-item previous\" id=\"vagas_table_previous\">
                                                                                                <a onclick=\"ahref_lista(".$inativo.','.($paginacao-1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                            </li>";
                }
                else{
                        echo "
                                                                                            <li class=\"paginate_button page-item previous disabled\" id=\"vagas_table_previous\">
                                                                                                <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                            </li>";
                }
                echo "
                                                                                            <li class=\"paginate_button page-item ";
                if($paginacao == 1){
                        echo 'active';
                }
                echo "\">
                                                                                                <a onclick=\"ahref_lista(".$inativo.",1);\" aria-controls=\"vagas_table\" data-dt-idx=\"1\" tabindex=\"0\" class=\"page-link\">1</a>
                                                                                            </li>";
                if($paginacao > 3){
                        echo "
                                                                                            <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                            </li>";
                }
                if($paginacao <= 2){
                        $inicio = 2;
                        $termino = 5;
                }
                else{
                        $inicio = $paginacao-1;
                        $termino = $paginacao+4;
                }
                for($i = $inicio; $i <= $total_paginas && $i <= $termino; $i++){
                        echo "
                                                                                            <li class=\"paginate_button page-item ";
                        if($paginacao == $i){
                                        echo 'active';
                        }
                        echo "\">
                                                                                                <a onclick=\"ahref_lista(".$inativo.','.$i.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$i\" tabindex=\"0\" class=\"page-link\">$i</a>
                                                                                            </li>";
                }
                if($paginacao < ($total_paginas - 5)){
                                echo "
                                                                                            <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                            </li>";
                }
                if($paginacao < ($total_paginas - 4)){
                                echo "
                                                                                            <li class=\"paginate_button page-item \">
                                                                                                <a href=\"".base_url('Candidatos/ListaCandidatos/'.$inativo.'/'.$total_paginas)."\" aria-controls=\"vagas_table\" data-dt-idx=\"$total_paginas\" tabindex=\"0\" class=\"page-link\">$total_paginas</a>
                                                                                            </li>";
                }
                if($paginacao < $total_paginas){
                                echo "
                                                                                            <li class=\"paginate_button page-item next\" id=\"vagas_table_next\">
                                                                                                <a onclick=\"ahref_lista(".$inativo.','.($paginacao+1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                            </li>";
                }
                else{
                                echo "
                                                                                            <li class=\"paginate_button page-item next disabled\" id=\"vagas_table_next\">
                                                                                                <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                            </li>";
                }
                echo "
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                            </div>";
        }
        echo "
                                                                        </div>
                                                                    </div>
                                                                </div><!-- ./card-block -->
                                                            </div><!-- ./card -->";

        $pagina['js'] .= "
        <script type=\"text/javascript\">
            function ahref_lista(inativo,pagina){
                    document.getElementById('form_filtros').action='".base_url('Candidatos/ListaCandidatos/')."'+inativo+'/'+pagina;
                    document.getElementById('form_filtros').submit();
            }
            function botao_submit(){
                    if(document.getElementById('inativo').checked == true){
                            ahref_lista(1,1);
                    }
                    else{
                            ahref_lista(0,1);
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
                                    $(location).attr('href', '".base_url('Candidatos/novaSenha/')."' + id)
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
                                    $(location).attr('href', '".base_url('Candidatos/delete/')."' + id)
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
                                    $(location).attr('href', '".base_url('Candidatos/reactivate/')."' + id)
                                }
                            });
                    });
            }
            function check_inativo(){
                    if(document.getElementById('inativo').checked == true){
                            $(location).attr('href', '".base_url('Candidatos/ListaCandidatos/')."1')
                    }
                    else{
                            $(location).attr('href', '".base_url('Candidatos/ListaCandidatos/')."')
                    }
            }
        </script>";
}
else if($menu2 == 'view'){
        echo "
                                                                    <div>";
        if(strlen($erro)>0){
                echo "
                                                                        <div class=\"alert alert-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                        <div class=\"alert alert-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                $sucesso
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        }
        echo "
                                                                        ";
        $attributes = array('class' => 'login-form',
                            'id' => 'form_candidatos');
        echo form_open($url, $attributes);
        echo "
                                                                            ";
        echo form_fieldset('Dados pessoais');
        echo "
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-9\">
                                                                                        <div class=\"form-group\">
                                                                                            ";
        $attributes = array('class' => 'control-label');
        echo form_label('Nome completo', 'nome', $attributes);

        $attributes = array('name' => 'NomeCompleto',
                            'id' => 'NomeCompleto',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_nome);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('CPF', 'CPF', $attributes);

        $attributes = array('name' => 'CPF',
                            'id' => 'CPF',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $ch_cpf);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('RG', 'RG', $attributes);

        $attributes = array('name' => 'RG',
                            'id' => 'RG',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_rg);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Órgão Emissor', 'OrgaoEmissor', $attributes);

        $attributes = array('name' => 'OrgaoEmissor',
                            'id' => 'OrgaoEmissor',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_orgaoEmissor);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Gênero', 'IdentidadeGenero', $attributes);

        $attributes = array('name' => 'Raca',
                            'id' => 'Raca',
                            'class' => 'form-control text-box single-line',
                            'readonly'=>'readonly');
        if($in_genero == 1){
                $vc_genero = 'Não informado';
        }
        else if($in_genero == 2){
                $vc_genero = 'Masculino';
        }
        else if($in_genero == 3){
                $vc_genero = 'Feminino';
        }
        else if($in_genero == 4){
                $vc_genero = 'Desejo informar';
        }
        echo form_input($attributes, $vc_genero);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Informe gênero optativo', 'IdentidadeGeneroOptativa', $attributes);

        $attributes = array('name' => 'IdentidadeGeneroOptativa',
                            'id' => 'IdentidadeGeneroOptativa',
                            'class' => 'form-control text-box single-line',
                            'readonly'=>'readonly');
        echo form_input($attributes, $vc_generoOptativo);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Raça', 'Raca', $attributes);

        $attributes = array('name' => 'Raca',
                            'id' => 'Raca',
                            'class' => 'form-control text-box single-line',
                            'readonly'=>'readonly');
        if($in_raca == 1){
                $vc_raca = 'Não informado';
        }
        else if($in_raca == 2){
                $vc_raca = 'Amarela';
        }
        else if($in_raca == 3){
                $vc_raca = 'Branca';
        }
        else if($in_raca == 4){
                $vc_raca = 'Indígena';
        }
        else if($in_raca == 5){
                $vc_raca = 'Parda';
        }
        else if($in_raca == 6){
                $vc_raca = 'Preta';
        }
        echo form_input($attributes, $vc_raca);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('E-mail', 'Email', $attributes);

        $attributes = array('name' => 'Email',
                            'id' => 'Email',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_email);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Telefone', 'Telefone', $attributes);

        $attributes = array('name' => 'Telefone',
                            'id' => 'Telefone',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_telefone);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Telefone opcional', 'TelefoneOpcional', $attributes);

        $attributes = array('name' => 'TelefoneOpcional',
                            'id' => 'TelefoneOpcional',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_telefoneOpcional);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-3\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Data de nascimento', 'DataNascimento', $attributes);

        $attributes = array('name' => 'DataNascimento',
                            'id' => 'DataNascimento',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, show_date($dt_nascimento));
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-9\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('LinkedIn', 'LinkedIn', $attributes);

        $attributes = array('name' => 'LinkedIn',
                            'id' => 'LinkedIn',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_linkedin);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-6\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Nacionalidade', 'Nacionalidade', $attributes);

        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'Nacionalidade',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_pais);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-6\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Cidade estrangeira', 'cidadeEstrangeira', $attributes);

        $attributes = array('name' => 'cidadeEstrangeira',
                            'id' => 'cidadeEstrangeira',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
        echo form_input($attributes, $vc_cidadeEstrangeira);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-2\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('CEP', 'CEP', $attributes);

        $attributes = array('name' => 'CEP',
                            'id' => 'CEP',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_cep, " onblur=\"pesquisacep(this.value);\"");
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-6\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Logradouro', 'Logradouro', $attributes);

        $attributes = array('name' => 'Logradouro',
                            'id' => 'Logradouro',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_logradouro);
                echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-2\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Número', 'Numero', $attributes);

        $attributes = array('name' => 'Numero',
                            'id' => 'Numero',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_numero);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-4\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Complemento', 'Complemento', $attributes);

        $attributes = array('name' => 'Complemento',
                            'id' => 'Complemento',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_complemento);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-6\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Bairro', 'Bairro', $attributes);

        $attributes = array('name' => 'Bairro',
                            'id' => 'Bairro',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_bairro);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-2\">
                                                                                        <div class=\"form-group\">";
        //var_dump($municipio);
        $attributes = array('class' => 'control-label');
        echo form_label('Estado', 'Estado', $attributes);

        $attributes = array('name' => 'Estado',
                            'id' => 'Estado',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $municipio[0]['ch_sigla']);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-4\">
                                                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Município', 'Municipio', $attributes);

        $attributes = array('name' => 'Municipio',
                            'id' => 'Municipio',
                            'readonly' => 'readonly',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $municipio[0]['vc_municipio']);
        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            ";
        echo form_fieldset_close();
        echo "
                                                                            <hr/>
                                                                            ";
        echo form_fieldset('Candidaturas');
        //var_dump($candidaturas);
        if(isset($candidaturas)){
                foreach ($candidaturas as $linha){
                        echo "
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-6\">
                                                                                        <div class=\"form-group\">";
                        $attributes = array('class' => 'control-label');
                        echo form_label('Vaga', 'Vaga', $attributes);

                        $attributes = array('name' => 'Vaga',
                                            'class' => 'form-control text-box single-line',
                                            'readonly' => 'readonly');
                        echo form_input($attributes, $linha -> vc_vaga);
                        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-4\">
                                                                                        <div class=\"form-group\">";
                        $attributes = array('class' => 'control-label');
                        echo form_label('Status', 'Status', $attributes);

                        $attributes = array('name' => 'Status',
                                            'class' => 'form-control text-box single-line',
                                            'readonly' => 'readonly');
                        echo form_input($attributes, $linha -> vc_status);
                        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class=\"col-md-2\">
                                                                                        <div class=\"form-group\">";
                        $attributes = array('class' => 'control-label');
                        echo form_label('Data', 'data_candidatura', $attributes);

                        $attributes = array('name' => 'data_candidatura',
                                            'class' => 'form-control text-box single-line',
                                            'readonly' => 'readonly');
                        echo form_input($attributes, show_date($linha -> dt_candidatura));
                        echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            ";
                }
        }
        echo form_fieldset_close();
        echo "
                                                                        </div>
                                                                        <div class=\"j-footer\">
                                                                            <div class=\"text-center\">
                                                                                <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidatos/ListaCandidatos')."'\">< Voltar</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div><!-- ./card-block -->
                                                            </div><!-- ./card -->";
}
else if($menu2 == 'changeName'){
        echo "
                                                                    <div>";
        if(strlen($erro)>0){
                echo "
                                                                        <div class=\"alert alert-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                        <div class=\"alert alert-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                $sucesso
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                echo "
                                                                        ";
                $attributes = array('class' => 'login-form',
                                'id' => 'form_candidatos');
                echo form_open($url, $attributes, array('codigo' => $codigo));
                echo "
                                                                            ";
                echo form_fieldset('Nome do candidato');
                echo "
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-12\">
                                                                                        <div class=\"form-group\">
                                                                                            ";
                $attributes = array('class' => 'control-label');
                echo form_label('Nome completo atual', 'NomeCompleto', $attributes);

                $attributes = array('name' => 'NomeCompleto',
                            'id' => 'NomeCompleto',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
                echo "
                                                                                            ";
                echo form_input($attributes, $vc_nome);
                echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"row\">
                                                                                    <div class=\"col-md-12\">
                                                                                        <div class=\"form-group\">
                                                                                            ";
                $attributes = array('class' => 'control-label');
                echo form_label('Nome completo novo', 'NomeNovo', $attributes);

                $attributes = array('name' => 'NomeNovo',
                                'id' => 'NomeNovo',
                                'class' => 'form-control text-box single-line');
                if(strstr($erro, "'Nome completo novo'")){
                        $attributes['class'] = 'form-control text-box single-line is-invalid';
                }
                echo "
                                                                                            ";
                echo form_input($attributes, set_value('NomeNovo'));
                echo "
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            ";

                echo form_fieldset_close();
                echo "
                                                                            <hr/>
                                                                            <div class=\"j-footer\">
                                                                                <div class=\"text-center\">
                                                                                    ";
                $attributes = array('class' => 'btn btn-primary');
                $attributes['id'] = "Salvar";
                echo form_submit('cadastrar', 'Salvar', $attributes);
                echo "
                                                                                <a href=\"".base_url('Candidatos/ListaCandidatos')."\" class=\"btn btn-default\"> Cancelar </a>
                                                                            </div>
                                                                        </form>
                                                                    </div>";
        }
}
else if($menu2 == 'changeEmail'){
        echo "
                                                                    <div>";
        if(strlen($erro)>0){
                echo "
                                                                        <div class=\"alert alert-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                        <div class=\"alert alert-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                $sucesso
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'login-form',
                                'id' => 'form_candidatos');
                echo form_open($url, $attributes, array('codigo' => $codigo));
                echo form_fieldset('E-mail do candidato');
                echo "
                                                                        <div class=\"row\">
                                                                            <div class=\"col-md-12\">
                                                                                <div class=\"form-group\">";
                $attributes = array('class' => 'control-label');
                echo form_label('E-mail atual', 'Email', $attributes);

                $attributes = array('name' => 'Email',
                            'id' => 'Email',
                            'class' => 'form-control text-box single-line',
                            'readonly' => 'readonly');
                echo form_input($attributes, $vc_email);
                echo "
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"row\">
                                                                            <div class=\"col-md-12\">
                                                                                <div class=\"form-group\">";
                $attributes = array('class' => 'control-label');
                echo form_label('E-mail novo', 'EmailNovo', $attributes);

                $attributes = array('name' => 'EmailNovo',
                                'id' => 'EmailNovo',
                                'class' => 'form-control text-box single-line');
                if(strstr($erro, "'E-mail novo'")){
                        $attributes['class'] = 'form-control text-box single-line is-invalid';
                }
                echo form_input($attributes, set_value('EmailNovo'));
                echo "
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    ";

                echo form_fieldset_close();
                echo "
                                                                    <hr/>
                                                                </div>
                                                                <div class=\"j-footer\">
                                                                    <div class=\"text-center\">
                                                                        ";
                $attributes = array('class' => 'btn btn-primary');
                $attributes['id'] = "Salvar";
                echo form_submit('cadastrar', 'Salvar', $attributes);
                echo "
                                                                                    <a href=\"".base_url('Candidatos/ListaCandidatos')."\" class=\"btn btn-default\"> Cancelar </a>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>";
        }
}
else{
        echo "
                                                                    <div>";
        if(strlen($erro)>0){
                echo "
                                                                        <div class=\"alert alert-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                        <div class=\"alert alert-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                $sucesso
                                                                            </div>
                                                                        </div>
                                                                    </div>";
        }
        echo "
                                                                </div><!-- ./card-block -->
                                                            </div><!-- ./card -->";
}
echo "
                                                        </div><!-- ./col-sm-12 -->
                                                    </div><!-- ./row -->
                                                </div><!-- ./page-body -->
                                            </div><!-- ./page-wrapper -->
                                        </div><!-- ./main-body -->
                                    </div><!-- ./tsm-inner-content -->
                                </div><!-- ./col-12 -->";
$this -> load -> view('internaRodape', $pagina);
?>