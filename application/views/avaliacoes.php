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

if ($menu2 != 'AvaliacaoCurriculo' && $menu2 != 'DetalheAvaliacao'){
    //Modelo padrão de página
    echo "              <div class=\"col-12 pr-\">
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
                                                                    <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}";

}
else if ($menu2 == 'AvaliacaoCurriculo' ){
        //Modelo de página de avaliação de currículo
        echo "
                        <div class=\"col-12\">
                            <div class=\"tsm-inner-content p-0\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper p-0\">
                                        <div class=\"page-body\">
                                            <div class=\"row\" style=\"position:relative;\">
                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:280px; min-width:240px;\">
                                                    <div class=\"menu1\">
                                                        <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'lkavaliacao')\"><span class=\"pcoded-mclass\">Avaliação</span><span class=\"pcoded-micon\"><i class=\"fas fa-tasks\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                        <hr>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkcompleta')\"><span class=\"pcoded-mclass\">Candidatura completa</span><span class=\"pcoded-micon\"><i class=\"fas fa-id-badge\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkdados')\"><span class=\"pcoded-mclass\">Dados da candidatura</span><span class=\"pcoded-micon\"><i class=\"fas fa-address-book\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkprereq')\"><span class=\"pcoded-mclass\">Pré Requisitos da Vaga</span><span class=\"pcoded-micon\"><i class=\"fas fa-address-book\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkformacoes')\"><span class=\"pcoded-mclass\">Formações Acadêmicas</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-graduate\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkcursos')\"><span class=\"pcoded-mclass\">Cursos e Seminários</span><span class=\"pcoded-micon\"><i class=\"fas fa-university\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkexperiencias')\"><span class=\"pcoded-mclass\">Experiências Profissionais</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-tie\" style=\"margin-left: 12px; font-size:1.2em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'lkdesejaveis')\"><span class=\"pcoded-mclass\">Habilitação Mínima</span><span class=\"pcoded-micon\"><i class=\"fas fa-portrait\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                    </div>
                                                </div>
                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">
                                                    <div class=\"w-100 h-100 p-3 pb-5\">";
        $attributes = array('class' => 'login-form',
                            'id' => 'form_avaliacoes');
        echo form_open($url, $attributes);

        // Início Formulário de Avaliação
        echo "
                                                        <div class=\"menu1conteudo menu1Primeiro\" id=\"lkavaliacao\">
                                                            <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-tasks\" style=\"font-size:0.9em;\"></i> &nbsp; Avaliação de: <b>". $candidato -> vc_nome ."</b> </h3>";

        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger\">
                                                                <div class=\"alert-text\">
                                                                    <strong>ERRO</strong>:<br/>$erro<br />
                                                                </div>
                                                            </div>";
                //$erro='';
        }

        $CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', true);

        echo "
                                                            <div>";

        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
        if(isset($questoes3)){
                echo form_input(array('name' => 'codigo_candidatura', 'type'=>'hidden', 'id' =>'codigo_candidatura','value'=>$codigo_candidatura));
                $attributes = array('class' => 'btn btn-primary');

                echo form_submit('salvar', 'Aprovar análise', $attributes);

                $attributes[' formnovalidate'] = ' formnovalidate';
                echo form_submit('salvar', 'Salvar', $attributes);
                //unset($attributes[' formnovalidate']);
                $attributes['id'] = "Reprovar";
                echo form_submit('salvar', 'Reprovar', $attributes);
        }
        else{
                echo "
                                                                <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('GruposVagas/index')."';\">Definir questões para essa etapa</button>";
        }
        if($id_vaga>0){
                echo "
                                                                <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$id_vaga)."';\">< Voltar</button>";
        }
        else{
                echo "
                                                                <button type=\"reset\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."';\">< Voltar</button>";
        }
        echo "
                                                            </div>
                                                        </div>";


        // Início Candidatura Completa
        echo "
                                                        <div class=\"menu1conteudo\" id=\"lkcompleta\">
                                                            <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-id-badge\" style=\"font-size:0.9em;\"></i> &nbsp; Candidatura Completa</h3>
                                                                <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
        echo "
                                                                    <div class=\"col-lg-9\">";
        echo $candidato -> vc_nome;
        echo "

                                                                        </div>
                                                                    </div>
                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('E-mail:', 'Email', $attributes);
        echo "
                                                                        <div class=\"col-lg-9\">";
        echo $candidato -> vc_email;
        echo "

                                                                        </div>
                                                                    </div>
                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Telefone(s):', 'Telefones', $attributes);
        echo "
                                                                        <div class=\"col-lg-6\">";
        echo $candidato -> vc_telefone;
        if(strlen($candidato -> vc_telefoneOpcional) > 0){
                echo ' - '.$candidato -> vc_telefoneOpcional;
        }
        echo "

                                                                        </div>
                                                                    </div>";
        if($this -> session -> perfil == 'candidato'){
                echo "
                                                                    <div class=\"row\">";

        //ACERTAR IDENTAÇÃO!!!

																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Logradouro:', 'logradouro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_logradouro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Complemento:', 'complemento', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_complemento;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Número:', 'numero', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_numero;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Bairro:', 'bairro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_bairro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}
																				echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Vaga:', 'Vaga', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidatura[0] -> vc_vaga;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				/*if(!($this -> session -> perfil != 'candidato' && $candidatura[0] -> es_status == '20')){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Status da candidatura:', 'status', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6') && $this -> session -> perfil == 'candidato'){
																								echo "Candidatura Pendente";
																						}
																						else{
																								echo $candidatura[0] -> vc_status;

																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}*/
																				echo "
																																							<div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de início:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_cadastro, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de última alteração:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_candidatura, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																				if($this -> session -> perfil != 'candidato'){
																						echo "
																																									<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Avaliação Curricular:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['3'])){
																								echo $notas['3'];
																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Entrevista por competência:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['4'])){
																								echo $notas['4'];
																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						if(isset($notas['5'])){
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota teste de aderência:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";

																								echo $notas['5'];

																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						if(isset($notas['6'])){
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota entrevista com especialista:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";

																								echo $notas['6'];

																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						echo "
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Geral:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						echo (isset($notas['3'])?intval($notas['3'].""):0)+(isset($notas['4'])?intval($notas['4'].""):0)+(isset($notas['5'])?intval($notas['5'].""):0)+(isset($notas['6'])?intval($notas['6'].""):0);
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																				";
																				}
                                                                                /*echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Curriculo:', 'curriculo', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo1[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma da graduação:', 'graduacao', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo2[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo3[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";*/
                                                                                echo form_fieldset_close();
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>
                                                                                    ";
                                                                                    echo "<div class=\"form-group row lx-3\"></div>";
        echo form_fieldset('Pré-requisitos básicos');

        /*if(isset($questoes1)){
                $x=0;

                foreach ($questoes1 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }
                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();

        $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false,'', $anexos_questao);
        echo form_fieldset_close();

        //**************************************
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Currículo');

        if(isset($formacoes)){
                $i=0;


                        foreach($formacoes as $formacao){
                                ++$i;
                                echo "

                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo "
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                else if($formacao->en_tipo == 'seminario'){
                                        $res = 'Curso/Seminário';
                                }
                                else if($formacao->en_tipo == 'licenciatura'){
                                        $res = 'Licenciatura';
                                }
                                else if($formacao->en_tipo == 'ensino_medio'){
                                        $res = 'Ensino Médio';
                                }
                                else if($formacao->en_tipo == 'producao_cientifica'){
                                        $res = 'Produção Científica';
                                }

                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Categoria', "curso{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Nome do curso', "curso{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Título da Pesquisa/Publicação', "instituicao{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                $res = $formacao->vc_instituicao;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Data de conclusão da Pesquisa/Publicação', "conclusao{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->dt_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",

                                                    'type' => 'date',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_input($attributes, $res);

                                echo "
                                                                                                    </div>

                                                                                            </div>
                                                                                            ";
                                if($formacao->en_tipo != 'producao_cientifica'){
                                        echo "
																							<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																																					";
        								$attributes = array('class' => 'esquerdo control-label');
        								echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
        								echo "
																											<br />";
        								/*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
        										$ye_conclusao[$i] = set_value("conclusao{$i}");
        								}*/
        								$res = $formacao->in_cargahoraria;
        								$attributes = array('name' => "cargahoraria{$i}",
        													'id' => "cargahoraria{$i}",
        													'maxlength' => '10',
        													'type' => 'number',
        													'class' => 'form-control',
        													'disabled' => 'disabled');

        								echo form_input($attributes, $res);

        								echo "
																									</div>
																							</div>";
                                }
                                echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Upload das Publicações/Produções Cientificas', "diploma{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                }

                                echo "
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
												echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                        }
                                }

                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>

                                                                        ";
                        }

        }
        //***********************************
        if(isset($experiencias)){
                $i = 0;
                foreach($experiencias as $experiencia){
                        ++$i;
                        echo "

                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "empresa{$i}",
                                            'id' => "empresa{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->vc_empresa);
                        echo "
                                                                                                </div>
                                                                                        </div>

																						<div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Data de início', "inicio{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "inicio{$i}",
                                            'id' => "inicio{$i}",

                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->dt_inicio);
                        echo "
                                                                                                </div>
                                                                                        </div>

                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Data de término', "fim{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "fim{$i}",
                                            'id' => "fim{$i}",

                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->dt_fim);
                        echo "
                                                                                                </div>
                                                                                        </div>

                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "atividades{$i}",
                                            'id' => "atividades{$i}",
                                            'rows' => '4',
                                            'class' => 'form-control',
                                        'disabled' => 'disabled');
                        echo form_textarea($attributes, $experiencia->tx_atividades);
                        echo "
                                                                                                </div>
                                                                                        </div>
																						<div class=\"form-group row\">
																								<div class=\"col-lg-12\">
																																			";
						$attributes = array('class' => 'esquerdo control-label');
						echo form_label('Comprovante', "comprovante{$i}", $attributes);
						echo "
																										<br />";
						/*$attributes = array('name' => "diploma{$i}",
											'class' => 'form-control',
											'disabled' => 'disabled');

						echo form_upload($attributes, '', 'class="form-control"');*/
						$vc_anexo='';
						$pr_arquivo='';
						if($anexos_experiencia[$experiencia->pr_experienca]){
								foreach($anexos_experiencia[$experiencia->pr_experienca] as $anexo){
										$vc_anexo = $anexo->vc_arquivo;
										$pr_arquivo = $anexo->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
						}

						echo "
																								</div>
																						</div>
                                                                                </fieldset>

                                                                        ";

                }
        }

        //***********************************
        echo "
                                                                                <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Habilitação Mínima');

        /*if(isset($questoes2)){
                $x=0;
                foreach ($questoes2 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }

                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false,'', $anexos_questao);
        echo form_fieldset_close();



echo "                                                      </div>";
// Fim Candidatura Completa


// Início conteúdo Dados do Candidato
echo "                                                      <div class=\"menu1conteudo\" id=\"lkdados\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-address-book\" style=\"font-size:0.9em;\"></i> &nbsp; Dados do candidato</h3>";
echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_nome;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('E-mail:', 'Email', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_email;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Telefone(s):', 'Telefones', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo $candidato -> vc_telefone;
                                                                                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                                                                        echo ' - '.$candidato -> vc_telefoneOpcional;
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				if($this -> session -> perfil == 'candidato'){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Logradouro:', 'logradouro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_logradouro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Complemento:', 'complemento', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_complemento;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Número:', 'numero', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_numero;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Bairro:', 'bairro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_bairro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}
																				echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Vaga:', 'Vaga', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidatura[0] -> vc_vaga;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				/*if(!($this -> session -> perfil != 'candidato' && $candidatura[0] -> es_status == '20')){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Status da candidatura:', 'status', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6') && $this -> session -> perfil == 'candidato'){
																								echo "Candidatura Pendente";
																						}
																						else{
																								echo $candidatura[0] -> vc_status;

																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}*/
																				echo "
																																							<div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de início:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_cadastro, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de última alteração:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_candidatura, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																				if($this -> session -> perfil != 'candidato'){
																						echo "
																																									<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Avaliação Curricular:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['3'])){
																								echo $notas['3'];
																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Entrevista por competência:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['4'])){
																								echo $notas['4'];
																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						if(isset($notas['5'])){
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota teste de aderência:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";

																								echo $notas['5'];

																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						if(isset($notas['6'])){
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota entrevista com especialista:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";

																								echo $notas['6'];

																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						echo "
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Geral:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						echo (isset($notas['3'])?intval($notas['3'].""):0)+(isset($notas['4'])?intval($notas['4'].""):0)+(isset($notas['5'])?intval($notas['5'].""):0)+(isset($notas['6'])?intval($notas['6'].""):0);
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																				";
																				}
                                                                                /*echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Curriculo:', 'curriculo', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo1[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma da graduação:', 'graduacao', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo2[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo3[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";*/
                                                                                echo form_fieldset_close();

echo "                                                      </div>";
// Fim conteúdo perfil

// Início Pré Requisitos
echo "                                                      <div class=\"menu1conteudo\" id=\"lkprereq\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-address-book\" style=\"font-size:0.9em;\"></i> &nbsp; Pré-Requisitos</h3>";

                                                            $CI =& get_instance();
                                                            $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false,'', $anexos_questao);

echo "                                                      </div>";
// Fim Pré Requisitos

// Início Formações Acadêmicas
echo "                                                      <div class=\"menu1conteudo\" id=\"lkformacoes\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-graduate\" style=\"font-size:0.9em;\"></i> &nbsp; Formações Acadêmicas</h3>";

        if(isset($formacoes)){
                $i=0;


                        foreach($formacoes as $formacao){
                                ++$i;
								if($formacao->en_tipo == 'seminario'){
										continue;
								}
                                echo "

                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo "
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                else if($formacao->en_tipo == 'seminario'){
                                        $res = 'Curso/Seminário';
                                }
                                else if($formacao->en_tipo == 'licenciatura'){
                                        $res = 'Licenciatura';
                                }
                                else if($formacao->en_tipo == 'ensino_medio'){
                                        $res = 'Ensino Médio';
                                }
                                else if($formacao->en_tipo == 'producao_cientifica'){
                                        $res = 'Produção Científica';
                                }

                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Categoria', "curso{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Nome do curso', "curso{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Título da Pesquisa/Publicação', "instituicao{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                $res = $formacao->vc_instituicao;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Data de conclusão da Pesquisa/Publicação', "conclusao{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->dt_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",

                                                    'type' => 'date',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_input($attributes, $res);

                                echo "
                                                                                                    </div>

                                                                                            </div>
                                ";
                                if($formacao->en_tipo != 'producao_cientifica'){
                                        echo "
																							<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																																					";
        								$attributes = array('class' => 'esquerdo control-label');
        								echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
        								echo "
																											<br />";
        								/*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
        										$ye_conclusao[$i] = set_value("conclusao{$i}");
        								}*/
        								$res = $formacao->in_cargahoraria;
        								$attributes = array('name' => "cargahoraria{$i}",
        													'id' => "cargahoraria{$i}",
        													'maxlength' => '10',
        													'type' => 'number',
        													'class' => 'form-control',
        													'disabled' => 'disabled');

        								echo form_input($attributes, $res);

        								echo "
																									</div>
																							</div>
                                                                                            ";
                                }
                                echo"
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Upload das Publicações/Produções Cientificas', "diploma{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                }

                                echo "
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
												echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                        }
                                }

                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>

                                                                        ";
                        }

        }

echo "                                                      </div>";
// Fim Formações Acadêmicas

// Início Cursos e Seminários
echo "                                                      <div class=\"menu1conteudo\" id=\"lkcursos\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-university\" style=\"font-size:0.9em;\"></i> &nbsp; Cursos e Seminários</h3>";
		if(isset($formacoes)){
                $i=0;


                        foreach($formacoes as $formacao){
                                ++$i;
								if($formacao->en_tipo != 'seminario'){
										continue;
								}
                                echo "

                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo "
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }
                                else if($formacao->en_tipo == 'seminario'){
                                        $res = 'Curso/Seminário';
                                }
                                else if($formacao->en_tipo == 'licenciatura'){
                                        $res = 'Licenciatura';
                                }
                                else if($formacao->en_tipo == 'ensino_medio'){
                                        $res = 'Ensino Médio';
                                }
                                else if($formacao->en_tipo == 'producao_cientifica'){
                                        $res = 'Produção Científica';
                                }

                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Categoria', "curso{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Nome do curso', "curso{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Título da Pesquisa/Publicação', "instituicao{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                $res = $formacao->vc_instituicao;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Data de conclusão da Pesquisa/Publicação', "conclusao{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                }

                                echo "
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->dt_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",

                                                    'type' => 'date',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_input($attributes, $res);

                                echo "
                                                                                                    </div>

                                                                                            </div>
                                ";
                                if($formacao->en_tipo != 'producao_cientifica'){
                                        echo "
																							<div class=\"form-group row\">
																									<div class=\"col-lg-12\">
																																					";
        								$attributes = array('class' => 'esquerdo control-label');
        								echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
        								echo "
																											<br />";
        								/*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
        										$ye_conclusao[$i] = set_value("conclusao{$i}");
        								}*/
        								$res = $formacao->in_cargahoraria;
        								$attributes = array('name' => "cargahoraria{$i}",
        													'id' => "cargahoraria{$i}",
        													'maxlength' => '10',
        													'type' => 'number',
        													'class' => 'form-control',
        													'disabled' => 'disabled');

        								echo form_input($attributes, $res);

        								echo "
																									</div>
																							</div>
                                                                                            ";
                                }
                                echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                if($formacao->en_tipo == 'producao_cientifica'){
                                        echo form_label('Upload das Publicações/Produções Cientificas', "diploma{$i}", $attributes);
                                }
                                else{
                                        echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                }

                                echo "
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
												echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                        }
                                }

                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>

                                                                        ";
                        }

        }



echo "                                                      </div>";
// Fim Cursos e Seminários

// Início Experiências Profissionais
echo "                                                      <div class=\"menu1conteudo\" id=\"lkexperiencias\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-tie\" style=\"font-size:0.9em;\"></i> &nbsp; Experiências Profissionais</h3>";


        if(isset($experiencias)){
                $i = 0;
                foreach($experiencias as $experiencia){
                        ++$i;
                        echo "

                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "empresa{$i}",
                                            'id' => "empresa{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->vc_empresa);
                        echo "
                                                                                                </div>
                                                                                        </div>

																						<div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Data de início', "inicio{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "inicio{$i}",
                                            'id' => "inicio{$i}",

                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->dt_inicio);
                        echo "
                                                                                                </div>
                                                                                        </div>

                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Data de término', "fim{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "fim{$i}",
                                            'id' => "fim{$i}",

                                            'type' => 'date',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->dt_fim);
                        echo "
                                                                                                </div>
                                                                                        </div>

                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "atividades{$i}",
                                            'id' => "atividades{$i}",
                                            'rows' => '4',
                                            'class' => 'form-control',
                                        'disabled' => 'disabled');
                        echo form_textarea($attributes, $experiencia->tx_atividades);
                        echo "
                                                                                                </div>
                                                                                        </div>
																						<div class=\"form-group row\">
																								<div class=\"col-lg-12\">
																																			";
						$attributes = array('class' => 'esquerdo control-label');
						echo form_label('Comprovante', "comprovante{$i}", $attributes);
						echo "
																										<br />";
						/*$attributes = array('name' => "diploma{$i}",
											'class' => 'form-control',
											'disabled' => 'disabled');

						echo form_upload($attributes, '', 'class="form-control"');*/
						$vc_anexo='';
						$pr_arquivo='';
						if($anexos_experiencia[$experiencia->pr_experienca]){
								foreach($anexos_experiencia[$experiencia->pr_experienca] as $anexo){
										$vc_anexo = $anexo->vc_arquivo;
										$pr_arquivo = $anexo->pr_anexo;
										echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
								}
						}

						echo "
																								</div>
																						</div>
                                                                                </fieldset>

                                                                        ";

                }
        }


echo "                                                      </div>";
// Fim Experiências Profissionais

// Início Habilitação Mínima
echo "                                                      <div class=\"menu1conteudo\" id=\"lkdesejaveis\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-portrait\" style=\"font-size:0.9em;\"></i> &nbsp; Habilitação Mínima</h3>";

                                                            $CI =& get_instance();
                                                            $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false,'', $anexos_questao);


echo "                                                      </div>";
// Fim Habilitação Mínima

// Fim da tela de avaliação
echo "                                              </form>";
echo "                                        </div>";
echo "                                    </div>
                                     </div>
                                </div>";

$pagina['js'] = "
                                                                    <script type=\"text/javascript\">
                                                                            jQuery(':submit').click(function (event) {
                                                                                                                                        if (this.id == 'Reprovar') {
                                                                                                                                                event.preventDefault();
                                                                                                                                                $(document).ready(function(){
                                                                                                                                                        event.preventDefault();
                                                                                                                                                        swal.fire({
                                                                                                                                                                title: 'Aviso de reprovação da candidatura',
                                                                                                                                                                text: 'Prezado avaliador(a), deseja reprovar essa candidatura?',
                                                                                                                                                                type: 'warning',
                                                                                                                                                                showCancelButton: true,
                                                                                                                                                                cancelButtonText: 'Não',
                                                                                                                                                                confirmButtonText: 'Sim, desejo reprovar'
                                                                                                                                                        })
                                                                                                                                                        .then(function(result) {
                                                                                                                                                                if (result.value) {
                                                                                                                                                                        //desfaz as configurações do botão
                                                                                                                                                                        $('#Reprovar').unbind(\"click\");
                                                                                                                                                                        //clica, concluindo o processo
                                                                                                                                                                        $('#Reprovar').click();
                                                                                                                                                                }

                                                                                                                                                        });


                                                                                                                                        });
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                });



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
                                                                        $('form').on('focus', 'input[type=number]', function (e) {
                                                                          $(this).on('wheel.disableScroll', function (e) {
                                                                            e.preventDefault()
                                                                          })
                                                                        })
                                                                        $('form').on('blur', 'input[type=number]', function (e) {
                                                                          $(this).off('wheel.disableScroll')
                                                                        })

                                                                    </script>
                                                                    ";

}
else if ($menu2 == 'DetalheAvaliacao' ) {
echo "          <div class=\"col-12 pl-0 pt-0\">
                            <div class=\"tsm-inner-content p-0\">
                                <div class=\"main-body\">
                                    <div class=\"page-wrapper p-0\">
                                        <div class=\"page-body\">
                                            <div class=\"row\" style=\"position:relative; left:15px;\">";
if($this -> session -> perfil != 'candidato'){
        echo "
                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:280px; min-width:240px;\">
                                                    <div class=\"menu1\">
                                                        <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'nlkcompleta')\"><span class=\"pcoded-mclass\">Candidatura completa</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-graduate\" style=\"margin-left: 11px; font-size:1.1em;\"></i></span></button>
                                                        <hr class=\"m-0 p-0\" style=\"border:none;\">
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'nlkavaliacao')\"><span class=\"pcoded-mclass\">Avaliação</span><span class=\"pcoded-micon\"><i class=\"fas fa-tasks\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'nlkentrevista')\"><span class=\"pcoded-mclass\">Entrevista</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-tie\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>";
        if($this -> session -> perfil != 'avaliador'){                                                 
                echo "
                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'nlkalteracao')\"><span class=\"pcoded-mclass\">Alterações de status</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-tie\" style=\"margin-left: 12px; font-size:1.1em\"></i></span></button>";
        }
                                                        
        echo "
                                                    </div>
                                                </div>";
}
echo "
                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">
                                                    <div class=\"w-100 h-100 p-3 pb-5\">";
$attributes = array('class' => 'login-form',
                    'id' => 'form_avaliacoes');
echo form_open($url, $attributes);

// Início Formulário de Avaliação
echo "                                                      <div class=\"menu1conteudo menu1Primeiro\" id=\"nlkcompleta\">";

echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-graduate\" style=\"font-size:0.9em;\"></i> &nbsp; Candidatura completa</h3>";
// Início Candidatura Completa
echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_nome;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('E-mail:', 'Email', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidato -> vc_email;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Telefone(s):', 'Telefones', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo $candidato -> vc_telefone;
                                                                                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                                                                        echo ' - '.$candidato -> vc_telefoneOpcional;
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				if($this -> session -> perfil == 'candidato'){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Logradouro:', 'logradouro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_logradouro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Complemento:', 'complemento', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_complemento;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Número:', 'numero', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_numero;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Bairro:', 'bairro', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
																						echo $candidato -> vc_bairro;
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}
																				echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Vaga:', 'Vaga', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-9\">";
                                                                                echo $candidatura[0] -> vc_vaga;
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				/*if(!($this -> session -> perfil != 'candidato' && $candidatura[0] -> es_status == '20')){
																						echo "
                                                                                                                                                            <div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Status da candidatura:', 'status', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(($candidatura[0] -> es_status == '1' || $candidatura[0] -> es_status == '4' || $candidatura[0] -> es_status == '6') && $this -> session -> perfil == 'candidato'){
																								echo "Candidatura Pendente";
																						}
																						else{
																								echo $candidatura[0] -> vc_status;

																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
																				}*/
																				echo "
																																							<div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de início:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_cadastro, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Data de última alteração:', 'data', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                echo show_date($candidatura[0] -> dt_candidatura, true);
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";

																				if($this -> session -> perfil != 'candidato'){
																						echo "
																																									<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Avaliação Curricular:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['3'])){
                                                                                                                                                                                        if($this -> session -> perfil == 'avalaidor'){
                                                                                                                                                                                                if($this -> session -> uid == $candidatura[0] -> es_avaliador_curriculo){
                                                                                                                                                                                                        echo $notas['3'];
                                                                                                                                                                                                }

                                                                                                                                                                                        }
                                                                                                                                                                                        else{
                                                                                                                                                                                                echo $notas['3'];
                                                                                                                                                                                        }

																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Entrevista por competência:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						if(isset($notas['4'])){
                                                                                                                                                                                        if($this -> session -> perfil == 'avalaidor'){
                                                                                                                                                                                                if($this -> session -> uid == $candidatura[0] -> es_avaliador_competencia1 || $this -> session -> uid == $candidatura[0] -> es_avaliador_competencia2 || $this -> session -> uid == $candidatura[0] -> es_avaliador_competencia3){
                                                                                                                                                                                                        echo $notas['4'];
                                                                                                                                                                                                }
                                                                                                                                                                                        }
                                                                                                                                                                                        else{
                                                                                                                                                                                                echo $notas['4'];
                                                                                                                                                                                        }

																						}
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						/*if(isset($notas['5'])){
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota teste de aderência:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";

																								echo $notas['5'];

																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}
																						if(isset($notas['6'])){
																								echo "
																																							<div class=\"row\">";
																								$attributes = array('class' => 'col-lg-3 direito bolder');
																								echo form_label('Nota entrevista com especialista:', 'nota', $attributes);
																								echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";

																								echo $notas['6'];

																								echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																																							";
																						}*/
																						echo "
																																							<div class=\"row\">";
																						$attributes = array('class' => 'col-lg-3 direito bolder');
																						echo form_label('Nota Geral:', 'nota', $attributes);
																						echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
																						echo (isset($notas['3'])?intval($notas['3'].""):0)+(isset($notas['4'])?intval($notas['4'].""):0);
																						echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
																				";
																				}
                                                                                /*echo "
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Curriculo:', 'curriculo', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo1[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma da graduação:', 'graduacao', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo2[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>
                                                                                                                                                            <div class=\"row\">";
                                                                                $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                                echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
                                                                                echo "
                                                                                                                                                                    <div class=\"col-lg-6\">";
                                                                                if(isset($anexo3[0] -> pr_anexo)){
                                                                                        echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
                                                                                }
                                                                                echo "

                                                                                                                                                                    </div>
                                                                                                                                                            </div>";*/
                                                                                echo form_fieldset_close();
                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                                                                                            echo "<div class=\"form-group row lx-3\"></div>";
                                                                                                                                                            echo form_fieldset('Pré-requisitos básicos');

                                                                                /*if(isset($questoes1)){
                                                                                        $x=0;

                                                                                        foreach ($questoes1 as $row){
                                                                                                $x++;
                                                                                                echo "
                                                                                                                                                            <div class=\"form-group row\">
                                                                                                                                                                    <div class=\"col-lg-12\">";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                $label=$x.') '.strip_tags($row -> tx_questao);
                                                                                                if($row -> bl_obrigatorio){
                                                                                                        $label.=' <abbr title="Obrigatório">*</abbr>';
                                                                                                }
                                                                                                echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                                                                                                echo '<br/>';
                                                                                                foreach ($respostas as $row2){
                                                                                                        if($row2 -> es_questao == $row -> pr_questao){
                                                                                                                $res = $row2 -> tx_resposta;
                                                                                                        }
                                                                                                }
                                                                                                if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        if($res == '1'){
                                                                                                                $res = 'Sim';
                                                                                                        }
                                                                                                        else if($res == '0'){
                                                                                                                $res = 'Não';
                                                                                                        }
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'rows' => 3,
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_textarea($attributes, $res);
                                                                                                }
                                                                                                echo "
                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
                                                                                        }
                                                                                }*/
                                                                                $CI =& get_instance();
                                                                                $questoes_form = array();
                                                                                /*if(isset($questoes_inicial)){
                                                                                        $questoes_form = $questoes_form + $questoes_inicial;
                                                                                }*/
                                                                                if(isset($questoes1)){
                                                                                        $questoes_form = $questoes_form + $questoes1;
                                                                                }
                                                                                $CI -> mostra_questoes($questoes_form, $respostas, $opcoes, '', false,'',$anexos_questao);
                                                                                //$CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false,'',$anexos_questao);
                                                                                echo form_fieldset_close();

                                                                                //**************************************
                                                                                echo "
                                                                                                                                                            <div class=\"kt-separator kt-separator-border-dashed kt-separator-space-lg\"></div>";
                                                                                echo form_fieldset('Currículo');



                                                                                if(isset($formacoes)){
                                                                                        $i=0;


                                                                                                foreach($formacoes as $formacao){
                                                                                                        ++$i;
                                                                                                        echo "

                                                                                                                                                            <fieldset>
                                                                                                                                                                    <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                                                                                                /*<div class=\"form-group row validated\">
                                                                                                                                                                                                                        ";*/
                                                                                                echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Tipo', "tipo{$i}", $attributes);
                                                                                                        /*echo "
                                                                                                                                                                                                                            <div class=\"col-lg-4\">";*/
                                                                                                        echo "
                                                                                                                                                                                    <br />";
                                                                                                        //var_dump($etapas);
                                                                                                        /*$attributes = array(
                                                                                                                    '' => '',
                                                                                                                    'bacharelado' => 'Graduação - Bacharelado',
                                                                                                                    'tecnologo' => 'Graduação - Tecnológo',
                                                                                                                    'especializacao' => 'Pós-graduação - Especialização',
                                                                                                                    'mba' => 'MBA',
                                                                                                                    'mestrado' => 'Mestrado',
                                                                                                                    'doutorado' => 'Doutorado',
                                                                                                                    'posdoc' => 'Pós-doutorado',
                                                                                                                    );*/
                                                                                                        $attributes = array('name' => "tipo{$i}",
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        $res = '';
                                                                                                        if($formacao->en_tipo == 'bacharelado'){
                                                                                                                $res = 'Graduação - Bacharelado';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'tecnologo'){
                                                                                                                $res = 'Graduação - Tecnológo';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'especializacao'){
                                                                                                                $res = 'Pós-graduação - Especialização';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'mba'){
                                                                                                                $res = 'MBA';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'mestrado'){
                                                                                                                $res = 'Mestrado';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'doutorado'){
                                                                                                                $res = 'Doutorado';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'posdoc'){
                                                                                                                $res = 'Pós-doutorado';
                                                                                                        }
																										else if($formacao->en_tipo == 'seminario'){
                                                                                                                $res = 'Curso/Seminário';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'licenciatura'){
                                                                                                                $res = 'Licenciatura';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'ensino_medio'){
                                                                                                                $res = 'Ensino Médio';
                                                                                                        }
                                                                                                        else if($formacao->en_tipo == 'producao_cientifica'){
                                                                                                                $res = 'Produção Científica';
                                                                                                        }

                                                                                                        echo form_input($attributes, $res);
                                                                                                        /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                                                                                                echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                                                                                        }
                                                                                                        else{
                                                                                                                echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                                                                                        }*/
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        if($formacao->en_tipo == 'producao_cientifica'){
                                                                                                                echo form_label('Categoria', "curso{$i}", $attributes);
                                                                                                        }
                                                                                                        else{
                                                                                                                echo form_label('Nome do curso', "curso{$i}", $attributes);
                                                                                                        }

                                                                                                        echo "
                                                                                                                                                                                    <br />";
                                                                                                        /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                                                                                                $vc_curso[$i] = set_value("curso{$i}");
                                                                                                        }*/
                                                                                                        $attributes = array('name' => "curso{$i}",
                                                                                                                            'id' => "curso{$i}",
                                                                                                                            'maxlength' => '100',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                                                                                                $attributes['class'] = 'form-control is-invalid';
                                                                                                        }*/
                                                                                                        $res = $formacao->vc_curso;
                                                                                                        echo form_input($attributes, $res);
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        if($formacao->en_tipo == 'producao_cientifica'){
                                                                                                                echo form_label('Título da Pesquisa/Publicação', "instituicao{$i}", $attributes);
                                                                                                        }
                                                                                                        else{
                                                                                                                echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                                                                                        }

                                                                                                        echo "
                                                                                                                                                                                    <br />";
                                                                                                        /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                                                                                                $vc_instituicao[$i] = set_value("instituicao{$i}");
                                                                                                        }*/
                                                                                                        $attributes = array('name' => "instituicao{$i}",
                                                                                                                            'id' => "instituicao{$i}",
                                                                                                                            'maxlength' => '100',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        $res = $formacao->vc_instituicao;
                                                                                                        echo form_input($attributes, $res);
                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        if($formacao->en_tipo == 'producao_cientifica'){
                                                                                                                echo form_label('Data de conclusão da Pesquisa/Publicação', "conclusao{$i}", $attributes);
                                                                                                        }
                                                                                                        else{
                                                                                                                echo form_label('Data de conclusão', "conclusao{$i}", $attributes);
                                                                                                        }

                                                                                                        echo "
                                                                                                                                                                                    <br />";
                                                                                                        /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                                                                                                $ye_conclusao[$i] = set_value("conclusao{$i}");
                                                                                                        }*/
                                                                                                        $res = $formacao->dt_conclusao;
                                                                                                        $attributes = array('name' => "conclusao{$i}",
                                                                                                                            'id' => "conclusao{$i}",

                                                                                                                            'type' => 'date',
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        echo form_input($attributes, $res);

                                                                                                        echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
																										";
                                                                                                        if($formacao->en_tipo != 'producao_cientifica'){
                                                                                                                echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                                echo form_label('Carga Horária total', "cargahoraria{$i}", $attributes);
                                                                                                                echo "
                                                                                                                                                                                    <br />";

                                                                                                                $res = $formacao->in_cargahoraria;
                                                                                                                $attributes = array('name' => "cargahoraria{$i}",
                                                                                                                                    'id' => "cargahoraria{$i}",
                                                                                                                                    'maxlength' => '10',
                                                                                                                                    'type' => 'number',
                                                                                                                                    'class' => 'form-control',
                                                                                                                                    'disabled' => 'disabled');

                                                                                                                echo form_input($attributes, $res);

                                                                                                                echo "
                                                                                                                                                                            </div>
                                                                                                                                                                    </div>
                                                                                                                ";
                                                                                                        }
                                                                                                        echo "
                                                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        if($formacao->en_tipo == 'producao_cientifica'){
                                                                                                                echo form_label('Upload das Publicações/Produções Cientificas', "diploma{$i}", $attributes);
                                                                                                        }
                                                                                                        else{
                                                                                                                echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                                                                                        }

                                                                                                        echo "
																																													<br />";
                                                                                                        /*$attributes = array('name' => "diploma{$i}",
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        echo form_upload($attributes, '', 'class="form-control"');*/
                                                                                                        $vc_anexo='';
                                                                                                        $pr_arquivo='';
                                                                                                        if($anexos[$formacao->pr_formacao]){
                                                                                                                foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                                                                                        $vc_anexo = $anexo->vc_arquivo;
                                                                                                                        $pr_arquivo = $anexo->pr_anexo;
																														echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                                                                                                }
                                                                                                        }


                                                                                                        echo "
																																											</div>
																																									</div>
																																							</fieldset>

                                                                                                                                                ";
                                                                                                }

                                                                                }
                                                                                //***********************************
                                                                                if(isset($experiencias)){
                                                                                        $i = 0;
                                                                                        foreach($experiencias as $experiencia){
                                                                                                ++$i;
                                                                                                echo "

																																							<fieldset>
																																									<legend>Experiência profissional {$i}</legend>";
																									echo "
																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                                                                                                echo "
																																													<br />";

                                                                                                $attributes = array('name' => "empresa{$i}",
                                                                                                                    'id' => "empresa{$i}",
                                                                                                                    'maxlength' => '100',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                echo form_input($attributes, $experiencia->vc_empresa);
                                                                                                echo "
																																											</div>
																																									</div>
																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Data de início', "inicio{$i}", $attributes);
                                                                                                echo "
																																													<br />";

                                                                                                $attributes = array('name' => "inicio{$i}",
                                                                                                                    'id' => "inicio{$i}",

                                                                                                                    'type' => 'date',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                echo form_input($attributes, $experiencia->dt_inicio);
                                                                                                echo "
																																											</div>
																																									</div>

																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Data de término', "fim{$i}", $attributes);
                                                                                                echo "
																																													<br />";

                                                                                                $attributes = array('name' => "fim{$i}",
                                                                                                                    'id' => "fim{$i}",

                                                                                                                    'type' => 'date',
                                                                                                                    'class' => 'form-control',
                                                                                                                    'disabled' => 'disabled');
                                                                                                echo form_input($attributes, $experiencia->dt_fim);
                                                                                                echo "
																																											</div>
																																									</div>

																																									<div class=\"form-group row\">
																																											<div class=\"col-lg-12\">
                                                                                                                                                                            ";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                                                                                                echo "
																																													<br />";

                                                                                                $attributes = array('name' => "atividades{$i}",
                                                                                                                    'id' => "atividades{$i}",
                                                                                                                    'rows' => '4',
                                                                                                                    'class' => 'form-control',
                                                                                                                'disabled' => 'disabled');
                                                                                                echo form_textarea($attributes, $experiencia->tx_atividades);
                                                                                                echo "
																																											</div>
																																									</div>
																																									<div class=\"form-group row\">
                                                                                                                                                                            <div class=\"col-lg-12\">
                                                                                                                                                                                                                            ";
                                                                                                        $attributes = array('class' => 'esquerdo control-label');
                                                                                                        echo form_label('Comprovante', "comprovante{$i}", $attributes);
                                                                                                        echo "
																																													<br />";
                                                                                                        /*$attributes = array('name' => "diploma{$i}",
                                                                                                                            'class' => 'form-control',
                                                                                                                            'disabled' => 'disabled');

                                                                                                        echo form_upload($attributes, '', 'class="form-control"');*/
                                                                                                        $vc_anexo='';
                                                                                                        $pr_arquivo='';
                                                                                                        if($anexos_experiencia[$experiencia->pr_experienca]){
                                                                                                                foreach($anexos_experiencia[$experiencia->pr_experienca] as $anexo){
                                                                                                                        $vc_anexo = $anexo->vc_arquivo;
                                                                                                                        $pr_arquivo = $anexo->pr_anexo;
																														echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                                                                                                }
                                                                                                        }

                                                                                                        echo "
																																											</div>
																																									</div>
																																							</fieldset>

                                                                                                                                                ";

                                                                                        }
                                                                                }

                                                                                //***********************************
                                                                                echo "
																																							<div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                echo form_fieldset('Habilitação Mínima');

                                                                                /*if(isset($questoes2)){
                                                                                        $x=0;
                                                                                        foreach ($questoes2 as $row){
                                                                                                $x++;
                                                                                                echo "
                                                                                                                                                            <div class=\"form-group row\">
                                                                                                                                                                    <div class=\"col-lg-12\">";
                                                                                                $attributes = array('class' => 'esquerdo control-label');
                                                                                                $label=$x.') '.strip_tags($row -> tx_questao);
                                                                                                if($row -> bl_obrigatorio){
                                                                                                        $label.=' <abbr title="Obrigatório">*</abbr>';
                                                                                                }
                                                                                                echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                                                                                                echo '<br/>';
                                                                                                foreach ($respostas as $row2){
                                                                                                        if($row2 -> es_questao == $row -> pr_questao){
                                                                                                                $res = $row2 -> tx_resposta;
                                                                                                        }
                                                                                                }

                                                                                                if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        if($res == '1'){
                                                                                                                $res = 'Sim';
                                                                                                        }
                                                                                                        else if($res == '0'){
                                                                                                                $res = 'Não';
                                                                                                        }
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_input($attributes, $res);
                                                                                                }
                                                                                                else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                                                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                                                                            'class' => 'form-control text-box single-line',
                                                                                                                            'rows' => 3,
                                                                                                                            'disabled' => 'disabled');
                                                                                                        echo form_textarea($attributes, $res);
                                                                                                }
                                                                                                echo "
                                                                                                                                                                    </div>
                                                                                                                                                            </div>";
                                                                                        }
                                                                                }*/
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false,'',$anexos_questao);
                                                                                echo form_fieldset_close();



echo "                                                      </div>";
// Fim Candidatura Completa

if($this -> session -> perfil != 'candidato'){
// Início conteúdo avaliação
echo "                                                      <div class=\"menu1conteudo\" id=\"nlkavaliacao\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-tasks\" style=\"font-size:0.9em;\"></i> &nbsp; Avaliação do candidato</h3>";
if($this -> session -> perfil == 'avaliador'){
        if($this -> session -> uid == $candidatura[0] -> es_avaliador_curriculo){
                echo form_fieldset('Avaliação do(a) candidato(a) pelo avaliador '.$candidatura[0] -> avaliador_curriculo. (strlen($candidatura[0] -> dt_curriculo) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_curriculo,true):''));
                $CI =& get_instance();
                $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);
                echo form_fieldset_close();
        }
        else{
                echo "Você não possui acesso a avaliação de currículo desse candidatura.";
        }

}
else{
        echo form_fieldset('Avaliação do(a) candidato(a) pelo avaliador '.$candidatura[0] -> avaliador_curriculo. (strlen($candidatura[0] -> dt_curriculo) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_curriculo,true):''));
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);
        echo form_fieldset_close();
}

echo "                                                      </div>";
// Fim conteúdo avaliação

// Início conteúdo entrevista
echo "                                                      <div class=\"menu1conteudo\" id=\"nlkentrevista\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-tie\" style=\"font-size:0.9em;\"></i> &nbsp; Entrevista</h3>";
                                                            if($candidatura[0] -> es_status == '15'){
                                                                        echo form_fieldset('Justificativa inserida pelo(a) '.$candidatura[0] -> reprovador. (strlen($candidatura[0] -> dt_reprovacao_entrevista) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_reprovacao_entrevista,true):''));
                                                                        echo "
                                                            <div class=\"row\">";
                                                                        $attributes = array('class' => 'col-lg-3 direito bolder');
                                                                        echo form_label('Justificativa da eliminação:', 'Justificativa', $attributes);
                                                                        echo "
                                                                        <div class=\"col-lg-9\">";
                                                                        echo $candidatura[0] -> tx_reprovacao_entrevista;
                                                                        echo "

                                                                        </div>
                                                            </div>
                                                                        ";
                                                            }
                                                            else if($entrevistas){
                                                                    if($this -> session -> perfil == 'avaliador'){
                                                                        $entrevistadores = array($entrevistas[0] -> es_avaliador1 =>$entrevistas[0]->nome1,$entrevistas[0] -> es_avaliador2 =>$entrevistas[0]->nome2,$entrevistas[0] -> es_avaliador3 =>$entrevistas[0]->nome3);

                                                                        if($this -> session -> uid == $candidatura[0] -> es_avaliador_competencia1){
                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.(isset($entrevistadores[$candidatura[0] -> es_avaliador_competencia1])?$entrevistadores[$candidatura[0] -> es_avaliador_competencia1]:"-"). (strlen($candidatura[0] -> dt_competencia1) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_competencia1,true):''));
                                                                                $CI =& get_instance();
                                                                                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false,(strlen($candidatura[0] -> es_avaliador_competencia1)>0?$candidatura[0] -> es_avaliador_competencia1:0));
                                                                                echo form_fieldset_close();
                                                                                echo "
                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                        }
                                                                        else if($this -> session -> uid == $candidatura[0] -> es_avaliador_competencia2){
                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.(isset($entrevistadores[$candidatura[0] -> es_avaliador_competencia2])?$entrevistadores[$candidatura[0] -> es_avaliador_competencia2]:"-"). (strlen($candidatura[0] -> dt_competencia2) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_competencia2,true):''));
                                                                                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false,(strlen($candidatura[0] -> es_avaliador_competencia2)>0?$candidatura[0] -> es_avaliador_competencia2:0));
                                                                                echo form_fieldset_close();
                                                                                echo "
                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                        }
                                                                        else if($this -> session -> uid == $candidatura[0] -> es_avaliador_competencia3){
                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.(isset($entrevistadores[$candidatura[0] -> es_avaliador_competencia3])?$entrevistadores[$candidatura[0] -> es_avaliador_competencia3]:"-"). (strlen($candidatura[0] -> dt_competencia3) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_competencia3,true):''));
                                                                                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false,(strlen($candidatura[0] -> es_avaliador_competencia3)>0?$candidatura[0] -> es_avaliador_competencia3:0));
                                                                                echo form_fieldset_close();
                                                                        }
                                                                        else{
                                                                                echo "Você não pussui acesso às entrevistas desta candidatura.";
                                                                        }

                                                                    }
                                                                    else{
                                                                        $entrevistadores = array($entrevistas[0] -> es_avaliador1 =>$entrevistas[0]->nome1,$entrevistas[0] -> es_avaliador2 =>$entrevistas[0]->nome2,$entrevistas[0] -> es_avaliador3 =>$entrevistas[0]->nome3);

                                                                        echo form_fieldset('Entrevista por competência pelo(a) '.(isset($entrevistadores[$candidatura[0] -> es_avaliador_competencia1])?$entrevistadores[$candidatura[0] -> es_avaliador_competencia1]:"-"). (strlen($candidatura[0] -> dt_competencia1) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_competencia1,true):''));
                                                                        $CI =& get_instance();
                                                                        $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false,(strlen($candidatura[0] -> es_avaliador_competencia1)>0?$candidatura[0] -> es_avaliador_competencia1:0));
                                                                        echo form_fieldset_close();

                                                                        echo "
                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";

                                                                        if(strlen($candidatura[0] -> es_avaliador_competencia2) >0 ){
                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.(isset($entrevistadores[$candidatura[0] -> es_avaliador_competencia2])?$entrevistadores[$candidatura[0] -> es_avaliador_competencia2]:"-"). (strlen($candidatura[0] -> dt_competencia2) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_competencia2,true):''));
                                                                                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false,(strlen($candidatura[0] -> es_avaliador_competencia2)>0?$candidatura[0] -> es_avaliador_competencia2:0));
                                                                                echo form_fieldset_close();
                                                                                echo "
                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                        }
                                                                        if(strlen($candidatura[0] -> es_avaliador_competencia3) >0 ){
                                                                                echo form_fieldset('Entrevista por competência pelo(a) '.(isset($entrevistadores[$candidatura[0] -> es_avaliador_competencia3])?$entrevistadores[$candidatura[0] -> es_avaliador_competencia3]:"-"). (strlen($candidatura[0] -> dt_competencia3) > 0 ?' no dia ' . show_date($candidatura[0] -> dt_competencia3,true):''));
                                                                                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false,(strlen($candidatura[0] -> es_avaliador_competencia3)>0?$candidatura[0] -> es_avaliador_competencia3:0));
                                                                                echo form_fieldset_close();
                                                                        }
                                                                    }



                                                                } else {
                                                                        echo "<span class=\"my-3\" style=\"line-height:1.5em;\">Sem dados de avaliação de entrevista.</span>";
                                                                }

        echo "                                                      </div>";
// Fim Pré Requisitos
}// Fim da verificação de perfil

// Alterações de status
if($this -> session -> perfil != 'avaliador'){ 
echo "                                                      <div class=\"menu1conteudo\" id=\"nlkalteracao\">";
echo "                                                      <h3 style=\"font-weight:600; margin-bottom:25px;\"><i class=\"fas fa-user-tie\" style=\"font-size:0.9em;\"></i> &nbsp; Alterações de status</h3>";
                                                                        
                                                            if($alteracoes){
                                                                    
                                                                        
                                                                        
                                                                        
                                                                       
                                                                        

                                                                        echo "
                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                        
                                                                        foreach($alteracoes as $alteracao){
                                                                                $alteracao -> dt_insercao = str_replace(" ","T",$alteracao -> dt_insercao);
                                                                                echo "
                                                                <fieldset>
                                                                        
                                                                        <div class=\"form-group row\">
                                                                                <div class=\"col-lg-12\"><label for=\"data_alteracao".$alteracao -> pr_alteracao."\" class=\"esquerdo control-label\">Data</label> 
                                                                                        <br><input type=\"datetime-local\" name=\"data_alteracao".$alteracao -> pr_alteracao."\" value=\"".$alteracao -> dt_insercao."\" class=\"form-control text-box single-line\" disabled=\"disabled\">

                                                                                </div>
                                                                        </div>
                                                                
                                                                        <div class=\"form-group row\">
                                                                                <div class=\"col-lg-12\"><label for=\"responsavel".$alteracao -> pr_alteracao."\" class=\"esquerdo control-label\">Responsável</label> 
                                                                                        <br><input type=\"text\" name=\"responsavel".$alteracao -> pr_alteracao."\" value=\"".$alteracao -> vc_nome."\" class=\"form-control text-box single-line\" disabled=\"disabled\">

                                                                                </div>
                                                                        </div>
                                                                        
                                                                        <div class=\"form-group row\">
                                                                                <div class=\"col-lg-12\"><label for=\"justificativa".$alteracao -> pr_alteracao."\" class=\"esquerdo control-label\">Justificativa</label> 
                                                                                        <br><br><textarea name=\"justificativa".$alteracao -> pr_alteracao."\" cols=\"40\" rows=\"4\" class=\"form-control\" disabled=\"disabled\">".$alteracao -> tx_justificativa."</textarea>

                                                                                </div>
                                                                        </div>
                                                                </fieldset>
                                                                                ";
                                                                        }
                                                                        echo form_fieldset_close();
                                                                        echo "
                                                                                                                                            <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                        

                                
                                                                } else {
                                                                echo "<span class=\"my-3\" style=\"line-height:1.5em;\">Sem dados de avaliação de entrevista.</span>";
                                                                }
    
echo "                                                      </div>";
}


                                                if($this -> session -> perfil == 'candidato'){
														echo "                                                                                          <div class=\"row\">
                                                                                                                                                    <div class=\"col-sm-12 pl-3\">
                                                                                                                                                        <div>
                                                                                                                                                            <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/index')."';\"> Voltar</button>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div> ";
												}
												else{
														echo "                                                                                          <div class=\"row\">
                                                                                                                                                    <div class=\"col-sm-12\">
                                                                                                                                                        <div class=\"pl-3\">
                                                                                                                                                            <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url($link)."';\">< Voltar</button>
                                                                                                                                                        </div>
                                                                                                                                                    </div>
                                                                                                                                                </div> ";
												}
// Fim da tela de avaliação
echo "                                              </form>";
echo "                                        </div>";
echo "                                    </div>
                                     </div>
                                </div>";

$pagina['js'] = "
                                                                    <script type=\"text/javascript\">
                                                                            jQuery(':submit').click(function (event) {
                                                                                                                                        if (this.id == 'Reprovar') {
                                                                                                                                                event.preventDefault();
                                                                                                                                                $(document).ready(function(){
                                                                                                                                                        event.preventDefault();
                                                                                                                                                        swal.fire({
                                                                                                                                                                title: 'Aviso de reprovação da candidatura',
                                                                                                                                                                text: 'Prezado avaliador(a), deseja reprovar essa candidatura?',
                                                                                                                                                                type: 'warning',
                                                                                                                                                                showCancelButton: true,
                                                                                                                                                                cancelButtonText: 'Não',
                                                                                                                                                                confirmButtonText: 'Sim, desejo reprovar'
                                                                                                                                                        })
                                                                                                                                                        .then(function(result) {
                                                                                                                                                                if (result.value) {
                                                                                                                                                                        //desfaz as configurações do botão
                                                                                                                                                                        $('#Reprovar').unbind(\"click\");
                                                                                                                                                                        //clica, concluindo o processo
                                                                                                                                                                        $('#Reprovar').click();
                                                                                                                                                                }

                                                                                                                                                        });


                                                                                                                                        });
                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                });



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
                                                                    </script>
                                                                    ";



}
// Fim da condição da tela de avaliação

$dados_status[0] = '';
foreach($status as $linha){
        $dados_status[$linha -> pr_status] = $linha -> vc_status;
}

if(strlen(set_value('filtro_instituicao')) > 0){
        echo '<span class="small"> - Instituição: '.$instituicoes[set_value('filtro_instituicao')].'</span>';
}
if(strlen(set_value('filtro_vaga')) > 0){
        echo '<span class="small"> - Vaga: '.$vagas[set_value('filtro_vaga')].'</span>';
}
if(strlen(set_value('filtro_status')) > 0){
        echo '<span class="small"> - Status: '.$dados_status[set_value('filtro_status')].'</span>';
}
echo "</h4>
                                                                    </div>";

if($menu2 == 'index'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                        <a href=\"".base_url('Usuarios/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Novo usuário </a>
                                                                    </div>";
}
else if($menu2 == 'create' || $menu2 == 'edit'){
        echo "
                                                                    <div class=\"col-lg-4 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_usuarios').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Usuarios/index')."'\">Cancelar</button>
                                                                    </div>";
}
echo "
                                                            </div>";

/*
if($this -> session -> perfil != 'candidato' && $this -> session -> perfil != 'avaliador' && $menu2 == 'AgendamentoEntrevista' && strlen($sucesso) == 0){
        echo "
                                                            <div class=\"kt-subheader__toolbar\">
                                                                    <a href=\"".base_url('Candidaturas/ListaAvaliacao')."\" class=\"btn btn-default btn-bold\"> Cancelar </a>
                                                                    <button type=\"button\" class=\"btn btn-primary btn-bold\" onclick=\"document.getElementById('form_avaliacoes').submit();\"> Salvar </button>
                                                            </div>";
}
else if($menu2 == 'AvaliacaoEntrevista'){
        echo "
                                                            <div class=\"kt-subheader__toolbar\">
                                                                    <a href=\"".base_url('Candidaturas/index')."\" class=\"btn btn-default btn-bold\"> Cancelar </a>
                                                                    <button type=\"button\" class=\"btn btn-primary btn-bold\" onclick=\"document.getElementById('form_avaliacoes').submit();\"> Salvar </button>
                                                                    <button type=\"button\" class=\"btn btn-primary btn-bold\" onclick=\"document.getElementById('form_avaliacoes').submit();\"> Concluir </button>
                                                            </div>";
}
echo "
                                                    </div>
                                                    <div class=\"kt-content kt-grid__item kt-grid__item--fluid\" id=\"kt_content\">
                                                            <div class=\"kt-portlet kt-portlet--mobile\">
                                                                    <div class=\"kt-portlet__head kt-portlet__head--lg\">
                                                                            <div class=\"kt-portlet__head-label\">
                                                                                    <h3 class=\"kt-portlet__head-title\">
                                                                                            <i class=\"$icone\"></i> &nbsp;&nbsp; {$nome_pagina}";*/
if($menu2 == 'ListaAvaliacao'){ //lista de candidaturas
        echo "
                                                            <div class=\"dt-responsive table-responsive\">";

        /*
        <h4>Instituição</h4>
                                                        <p>
                                                                ";
        $instituicoes=array('' => '')+$instituicoes;
        echo form_dropdown('filtro_instituicao', $instituicoes, set_value('filtro_instituicao'), "class=\"form-control\" id=\"filtro_instituicao\"");
        echo "
                                                         </p><br/>

                                                          <h4>Status</h4>
                                                        <p>
                                                                ";
        echo form_dropdown('filtro_status', $dados_status, set_value('filtro_status'), "class=\"form-control\" id=\"filtro_status\"");
        echo "
                                                        </p>
        */
        $attributes = array('class' => 'form-horizontal',
                                    'id' => 'form_filtros');
        echo form_open($url, $attributes);
        echo "
                                                                            <div class=\"modal-body\">
                                                                                    <!--<h5>Tipo de vaga</h5>
                                                                                    <br />
                                                                ";
        $tipos_vaga=array('1' => 'Concluídas','2'=>'Ativas');

        echo form_dropdown('filtro_tipo', $tipos_vaga, $tipo, "class=\"form-control\" id=\"filtro_tipo\" onchange=\"window.location = '/Candidaturas/ListaAvaliacao/' + this.value;\"");
        echo "

                                                                                    <br />-->
                                                                                    <h5>Vaga</h5>
                                                                                    <br />
                                                                ";
        if(isset($vagas)){
                $vagas=array('' => 'Todos')+$vagas;
        }
        else{
                $vagas=array('' => 'Todos');
        }


        echo form_dropdown('filtro_vaga', $vagas, $vaga, "class=\"form-control\" id=\"filtro_vaga\"");
        echo "


                                                                            </div>
                                                                            <div class=\"actions clearfix text-left my-5\">

                                                                                    <button type=\"button\" data-dismiss=\"modal\" class=\"btn default\">Cancelar</button>
                                                       ";
        $attributes = array('class' => 'btn btn-primary');
        echo form_submit('filtrar', 'Filtrar', $attributes);
        echo "

                                                                            </div>
                                                                    </form>
                                ";
        echo "

                                                                    <table id=\"avaliacoes_table\" class=\"table table-striped table-bordered table-hover\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Candidato</th>
                                                                                            <th>Data</th>
                                                                                            <th>Vaga</th>
                                                                                            <th>Tipo de Entrevista</th>
                                                                                            <th>Status</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";


        /*
        echo "
                                                                                    </h3>
                                                                            </div>
                                                                            <div class=\"kt-portlet__head-toolbar\">
                                                                                    <div class=\"kt-portlet__head-wrapper\">
                                                                                            <div class=\"kt-portlet__head-actions\">";
        if(strlen(set_value('filtro_instituicao')) > 0 || strlen(set_value('filtro_vaga')) > 0 || strlen(set_value('filtro_status')) > 0){
                echo "
                                                                                                    <button type=\"button\" class=\"btn btn-bold btn-sm\" onclick=\"window.location='".base_url($url)."'\">
                                                                                                            Limpar filtros
                                                                                                    </button>";
        }
        echo "
                                                                                                    <button type=\"button\" class=\"btn btn-bold btn-label-primary btn-sm\" data-toggle=\"modal\" data-target=\"#filtros\">
                                                                                                            <i class=\"fa fa-lg mr-1 fa-filter\"></i> Filtrar
                                                                                                    </button>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </div>";
        */
        //var_dump($candidaturas);
        if(isset($candidaturas)){
                $candidatura_anterior = -1;
				$atual = time();
                foreach ($candidaturas as $linha){
                        if(($linha -> es_status != 10 && $linha->es_status != 11) && $candidatura_anterior == $linha -> pr_candidatura){
                                continue;
                        }
                        $candidatura_anterior = $linha -> pr_candidatura;
                        $dt_candidatura = mysql_to_unix($linha -> dt_candidatura);
                        $dt_fim = strtotime($linha -> dt_fim);
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_candidatura)."\" data-order=\"$dt_candidatura\">".show_date($linha -> dt_candidatura)."</td>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td>";
                        if(strlen($linha -> bl_tipo_entrevista)>0){
                                if($linha->bl_tipo_entrevista == 'competencia'){
                                        echo "Competência";
                                }
                                else{
                                        echo "Especialista";
                                }
                        }
                        echo "</td>
                                ";

                        if($linha -> es_status == 2 || $linha -> es_status == 4 || $linha -> es_status == 8 || $linha -> es_status == 10 || $linha -> es_status == 12 || $linha -> es_status == 13 || $linha -> es_status == 20){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else{
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        echo "
                                                                                            <td class=\"text-center\">";
                        //if($linha -> es_status != 1){
                                echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-1 fa-search"></i>Detalhes', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                                //echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\"");
                        //}
                        if(($linha -> es_status == 7 || $linha -> es_status == 20)){ //aprovado 2ª etapa

                                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
                                        echo "<br />";
                                        echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-1 fa-file-alt"></i>Analisar Currículo', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");

                                }

                        }
                        if($linha -> es_status == 10){ //entrevista por competência

                                /*if((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($linha -> es_avaliador2) == 0 ){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                                        //}
                                }
                                else */
                                if((($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'avaliador') && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2 || $this -> session -> uid == $linha -> es_avaliador3)) && ($linha -> es_avaliador_competencia1 != $this -> session -> uid && $linha -> es_avaliador_competencia2 != $this -> session -> uid)){ //avaliador
                                        if(strlen($linha -> dt_entrevista) > 0 && strtotime($linha -> dt_entrevista) <= $atual){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-1 fa-video-camera"></i>Avaliar entrevista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                if(strlen($linha -> es_avaliador_competencia1) == 0){
                                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i>Confirmar não comparecimento da entrevista</a>";
                                                }
                                        }
                                }
                                else if($this -> session -> perfil == 'orgaos'){
                                        if(strlen($linha -> es_avaliador_competencia1) == 0){
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i>Confirmar não comparecimento da entrevista</a>";
                                        }
                                }


                                /*else{
                                        echo anchor('Candidaturas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista\"");
                                }*/
                        }
                        /*if($linha -> es_status == 11){ //entrevista por especialista

                                if((($this -> session -> perfil == 'sugesp' && $this -> session -> uid == $linha -> es_avaliador1) || $this -> session -> perfil == 'avaliador') && strlen($linha -> es_avaliador2) == 0 ){ //avaliador
                                        //if(strtotime($linha -> dt_entrevista) <= strtotime(date('Y-m-d'))){
                                                echo "<br />";
                                                echo anchor('Candidaturas/AvaliacaoEntrevistaEspecialista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-video-camera"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar não comparecimento da entrevista\" onclick=\"confirm_delete(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                                        //}
                                }

                                /*else{
                                        echo anchor('Candidaturas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista\"");
                                }*/
                        //}
                        /*if($linha -> es_status == 7){ //entrevista

                                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador'){
                                        echo "<br />";
                                        echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");

                                }

                        }*/
                        echo "
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
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma o não comparecimento à entrevista?',
                                                                        text: 'O candidato será eliminado por não comparecimento à entrevista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não',
                                                                        confirmButtonText: 'Sim, elimine'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Candidaturas/eliminar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    $('#avaliacoes_table').DataTable({
                                                        'pageLength': 15,
                                                        'lengthMenu': [
                                                            [ 15, 25, 50, -1 ],
                                                            [ '15', '25', '50', 'Todos' ]
                                                        ],
                                                        'order': [
                                                            [1, 'desc']
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
                                                        language: {
                                                            \"decimal\":        \"\",
                                                            \"emptyTable\":     \"Nenhum item encontrado\",
                                                            \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                            \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                            \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                            \"infoPostFix\":    \"\",
                                                            \"thousands\":      \",\",
                                                            \"lengthMenu\":     \"Mostrar _MENU_\",
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
                                            </script>";
}

if($menu2 == 'RevisaoRequisitos'){ //detalhamento da candidatura
        //var_dump($candidato);
        //var_dump($vaga);
        //var_dump($candidatura);
        //var_dump($anexo3);
        //var_dump($respostas);
        echo "
                                                                                    </h3>
                                                                            </div>

                                                                            ";
        $attributes = array('class' => 'login-form',
                            'id' => 'form_avaliacoes');
        echo form_open($url, $attributes);
        echo form_fieldset('Dados da candidatura');
        echo "
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidato -> vc_nome;
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('E-mail:', 'Email', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidato -> vc_email;
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Telefone(s):', 'Telefones', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo $candidato -> vc_telefone;
        if(strlen($candidato -> vc_telefoneOpcional) > 0){
                echo ' - '.$candidato -> vc_telefoneOpcional;
        }
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Vaga:', 'Vaga', $attributes);
        echo "
                                                                                            <div class=\"col-lg-9\">";
        echo $candidatura[0] -> vc_vaga;
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Status da candidatura:', 'status', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo $candidatura[0] -> vc_status;
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Data da candidatura:', 'data', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        echo show_date($candidatura[0] -> dt_candidatura, true);
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Nota:', 'nota', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        //echo $candidato -> vc_email;
        echo "

                                                                                            </div>
                                                                                    </div>";
        /*echo "
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Curriculo:', 'curriculo', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo1[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo1[0] -> pr_anexo, $anexo1[0] -> vc_arquivo);
        }
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Diploma da graduação:', 'graduacao', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo2[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo2[0] -> pr_anexo, $anexo2[0] -> vc_arquivo);
        }
        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
        $attributes = array('class' => 'col-lg-3 direito bolder');
        echo form_label('Diploma de pós-graduação:', 'pos', $attributes);
        echo "
                                                                                            <div class=\"col-lg-6\">";
        if(isset($anexo3[0] -> pr_anexo)){
                echo anchor('Interna/download/'.$anexo3[0] -> pr_anexo, $anexo3[0] -> vc_arquivo);
        }
        echo "

                                                                                            </div>
                                                                                    </div>";*/
        echo form_fieldset_close();
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                                                                                    echo "<div class=\"form-group row lx-3\"></div>";
        echo form_fieldset('Pré-requisitos básicos');

        /*if(isset($questoes1)){
                $x=0;

                foreach ($questoes1 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }
                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes1, $respostas, $opcoes, '', false);
        echo form_fieldset_close();

        //**************************************
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Currículo');

        if(isset($formacoes)){
                $i=0;


                        foreach($formacoes as $formacao){
                                ++$i;
                                echo "

                                                                                    <fieldset>
                                                                                            <legend>Formação acadêmica {$i}</legend>";
                                                                                                                                        /*<div class=\"form-group row validated\">
                                                                                                                                                ";*/
                        echo "
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Tipo', "tipo{$i}", $attributes);
                                /*echo "
                                                                                                                                                    <div class=\"col-lg-4\">";*/
                                echo "
                                                                                                            <br />";
                                //var_dump($etapas);
                                /*$attributes = array(
                                            '' => '',
                                            'bacharelado' => 'Graduação - Bacharelado',
                                            'tecnologo' => 'Graduação - Tecnológo',
                                            'especializacao' => 'Pós-graduação - Especialização',
                                            'mba' => 'MBA',
                                            'mestrado' => 'Mestrado',
                                            'doutorado' => 'Doutorado',
                                            'posdoc' => 'Pós-doutorado',
                                            );*/
                                $attributes = array('name' => "tipo{$i}",
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                $res = '';
                                if($formacao->en_tipo == 'bacharelado'){
                                        $res = 'Graduação - Bacharelado';
                                }
                                else if($formacao->en_tipo == 'tecnologo'){
                                        $res = 'Graduação - Tecnológo';
                                }
                                else if($formacao->en_tipo == 'especializacao'){
                                        $res = 'Pós-graduação - Especialização';
                                }
                                else if($formacao->en_tipo == 'mba'){
                                        $res = 'MBA';
                                }
                                else if($formacao->en_tipo == 'mestrado'){
                                        $res = 'Mestrado';
                                }
                                else if($formacao->en_tipo == 'doutorado'){
                                        $res = 'Doutorado';
                                }
                                else if($formacao->en_tipo == 'posdoc'){
                                        $res = 'Pós-doutorado';
                                }



                                echo form_input($attributes, $res);
                                /*if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\"");
                                }
                                else{
                                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\"");
                                }*/
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Nome do curso', "curso{$i}", $attributes);
                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                                        $vc_curso[$i] = set_value("curso{$i}");
                                }*/
                                $attributes = array('name' => "curso{$i}",
                                                    'id' => "curso{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');
                                /*if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                        $attributes['class'] = 'form-control is-invalid';
                                }*/
                                $res = $formacao->vc_curso;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Instituição de ensino', "instituicao{$i}", $attributes);
                                echo "
                                                                                                            <br />";
                                /*if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                                }*/
                                $attributes = array('name' => "instituicao{$i}",
                                                    'id' => "instituicao{$i}",
                                                    'maxlength' => '100',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                $res = $formacao->vc_instituicao;
                                echo form_input($attributes, $res);
                                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                            <div class=\"form-group row\">
                                                                                                    <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Ano de conclusão', "conclusao{$i}", $attributes);
                                echo "
                                                                                                            <br />";
                                /*if(!isset($ye_conclusao[$i]) || (strlen($ye_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $ye_conclusao[$i] != set_value("conclusao{$i}"))){
                                        $ye_conclusao[$i] = set_value("conclusao{$i}");
                                }*/
                                $res = $formacao->ye_conclusao;
                                $attributes = array('name' => "conclusao{$i}",
                                                    'id' => "conclusao{$i}",
                                                    'maxlength' => '4',
                                                    'type' => 'number',
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_input($attributes, $res);

                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                                                                    ";
                                $attributes = array('class' => 'esquerdo control-label');
                                echo form_label('Diploma / certificado', "diploma{$i}", $attributes);
                                echo "
                                                                                                        <br />";
                                /*$attributes = array('name' => "diploma{$i}",
                                                    'class' => 'form-control',
                                                    'disabled' => 'disabled');

                                echo form_upload($attributes, '', 'class="form-control"');*/
                                $vc_anexo='';
                                $pr_arquivo='';
                                if($anexos[$formacao->pr_formacao]){
                                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                                $vc_anexo = $anexo->vc_arquivo;
                                                $pr_arquivo = $anexo->pr_anexo;
                                        }
                                }
                                echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\">".$vc_anexo."</a>";
                                echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>

                                                                        ";
                        }

        }
        //***********************************
        if(isset($experiencias)){
                $i = 0;
                foreach($experiencias as $experiencia){
                        ++$i;
                        echo "

                                                                                <fieldset>
                                                                                        <legend>Experiência profissional {$i}</legend>";
                        echo "
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Instituição / empresa', "empresa{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "empresa{$i}",
                                            'id' => "empresa{$i}",
                                            'maxlength' => '100',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->vc_empresa);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Ano de início', "inicio{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "inicio{$i}",
                                            'id' => "inicio{$i}",
                                            'maxlength' => '4',
                                            'type' => 'number',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->ye_inicio);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Ano de término', "fim{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "fim{$i}",
                                            'id' => "fim{$i}",
                                            'maxlength' => '4',
                                            'type' => 'number',
                                            'class' => 'form-control',
                                            'disabled' => 'disabled');
                        echo form_input($attributes, $experiencia->ye_fim);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                        <div class=\"form-group row\">
                                                                                                <div class=\"col-lg-12\">
                                                                                                    ";
                        $attributes = array('class' => 'esquerdo control-label');
                        echo form_label('Principais atividades desenvolvidas', "atividades{$i}", $attributes);
                        echo "
                                                                                                        <br />";

                        $attributes = array('name' => "atividades{$i}",
                                            'id' => "atividades{$i}",
                                            'rows' => '4',
                                            'class' => 'form-control',
                                        'disabled' => 'disabled');
                        echo form_textarea($attributes, $experiencia->tx_atividades);
                        echo "
                                                                                                </div>
                                                                                        </div>
                                                                                </fieldset>

                                                                        ";

                }
        }

        //***********************************
        echo "
                                                                                <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        echo form_fieldset('Requisitos desejáveis');

        /*if(isset($questoes2)){
                $x=0;
                foreach ($questoes2 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                        echo '<br/>';
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                }
                        }

                        if(strtolower($row -> vc_respostaAceita) == 'sim' || strtolower($row -> vc_respostaAceita) == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                if($res == '1'){
                                        $res = 'Sim';
                                }
                                else if($res == '0'){
                                        $res = 'Não';
                                }
                                echo form_input($attributes, $res);
                        }
                        else if(strtolower($row -> vc_respostaAceita) == 'básico' || strtolower($row -> vc_respostaAceita) == 'intermediário' || strtolower($row -> vc_respostaAceita) == 'avançado'){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'disabled' => 'disabled');
                                echo form_input($attributes, $res);
                        }
                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'class' => 'form-control text-box single-line',
                                                    'rows' => 3,
                                                    'disabled' => 'disabled');
                                echo form_textarea($attributes, $res);
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        $CI =& get_instance();
        $CI -> mostra_questoes($questoes2, $respostas, $opcoes, '', false);
        echo form_fieldset_close();
        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
        //echo form_fieldset('Avaliação do(a) candidato(a)');
        echo form_fieldset('Avaliação curricular');

        $CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);
        echo form_fieldset_close();

        /*if(isset($questoes3)){
                $x=0;
                foreach ($questoes3 as $row){
                        $x++;
                        echo "
                                                                                    <div class=\"form-group row\">
                                                                                            <div class=\"col-lg-12\">";
                        $attributes = array('class' => 'esquerdo control-label');
                        $label=$x.') '.strip_tags($row -> tx_questao);
                        if($row -> bl_obrigatorio){
                                $label.=' <abbr title="Obrigatório">*</abbr>';
                        }
                        echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                        echo '<br/>';
                        $res = "";
                        foreach ($respostas as $row2){
                                if($row2 -> es_questao == $row -> pr_questao){
                                        $res = $row2 -> tx_resposta;
                                        $codigo_resposta = $row2->pr_resposta;
                                }
                        }
                        if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,')){

                                $valores=array(""=>"",0=>"Não",1=>"Sim");




                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control is-invalid\" id=\"{Questao'.$row -> pr_questao}\""
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control\" id=\"{Questao'.$row -> pr_questao}\""
                                }

                        }
                        else if(mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                }


                        }

                        else if($row -> vc_respostaAceita == NULL || $row -> in_tipo == 2){
                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                    'rows'=>'5');
                                echo form_textarea($attributes, $res, 'class="form-control"');
                        }
                        else if(isset($opcoes)){
                                $valores = array(""=>"");
                                foreach($opcoes as $opcao){
                                        if($opcao->es_questao==$row -> pr_questao){
                                                $valores[$opcao->pr_opcao]=$opcao->tx_opcao;
                                        }
                                }

                                if(strstr($erro, "'Questao{$row -> pr_questao}'")){
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                }
                                else{
                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" id=\"Questao{$row -> pr_questao}\"");
                                }
                        }
                        echo form_hidden('codigo_resposta'.$row -> pr_questao, $codigo_resposta);
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }
        }*/
        /*$CI =& get_instance();
        $CI -> mostra_questoes($questoes3, $respostas, $opcoes, '', false);*/

        //echo form_fieldset_close();
        if ($candidatura[0] -> bl_aderencia){
                echo form_fieldset('Teste de aderência');

                $CI =& get_instance();
                $CI -> mostra_questoes($questoes5, $respostas, $opcoes, '', false);
                echo form_fieldset_close();
        }

        echo form_fieldset('Entrevista por competência');

        $CI =& get_instance();
        $CI -> mostra_questoes($questoes4, $respostas, $opcoes, '', false);
        echo form_fieldset_close();

        echo form_fieldset('Revisão de requisitos');

        $CI =& get_instance();
        $CI -> mostra_questoes($questoes6, $respostas, $opcoes, '', true);
        echo form_fieldset_close();

        echo "
                                                                            <div>";

                        //echo form_submit('cadastrar', 'Candidatar-se', $attributes);
                        if(isset($questoes6)){
                                echo form_input(array('name' => 'codigo_candidatura', 'type'=>'hidden', 'id' =>'codigo_candidatura','value'=>$codigo_candidatura));
                                $attributes = array('class' => 'btn btn-primary');
                                echo form_submit('salvar', 'Salvar', $attributes);

                        }
                        echo "
                                                                                    <button type=\"reset\" class=\"btn btn-outline-dark\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."';\">< Voltar</button>
                                                                            </div>
                                                                    </form>
                                                            </div>
                                                    </div>
                                            </div>";
}

if($menu2 == 'AgendamentoEntrevista'){ //agendamento da entrevista ou calendário
        if($this -> session -> perfil == 'candidato' || $this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'sugesp'){ //avaliador
                //var_dump($candidaturas);
                echo "
                                                            <div class=\"row\">
                                                                    <div class=\"col-md-12\">
                                                                            <div id='calendar'>";
                $contador = 0;
                if(isset($candidaturas)){
                        foreach($candidaturas as $linha){
                                if(strlen($linha -> dt_entrevista)>0){
                                        ++$contador;
                                }
                        }
                }
                if($contador == 0){
                        echo "Sem entrevistas agendadas para o seu usuário.";
                }
                echo"</div>
                                                                    </div>

                                                            </div>
                                                    </div>
                                            </div>";
                if($contador > 0){
                        $pagina['js'] = "

        <script type=\"text/javascript\">
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    locale: 'pt-br',


                    axisFormat: 'H:mm',
                    timeFormat: 'H(:mm)',
                    buttonText: {
                        today: 'Hoje',
                        month: 'Mês',
                        week: 'Semana',
                        day: 'Dia'
                    },
                    header: {
                        left: '',
                        center: 'title'
                    },
                    eventRender: function(eventObj, \$el) {
                        \$el.popover({
                          title: eventObj.title,
                          content: eventObj.description,
                          trigger: 'hover',
                          html: true,
                          placement: 'top',
                          container: 'body'
                        });
                      },
                    events: [";

                        foreach($candidaturas as $linha){
                                if(strlen($linha -> dt_entrevista)>0){
                                        if($this -> session -> perfil == 'candidato'){
                                                $pagina['js'] .= "
                                    {
                                            title: 'Vaga: ".$linha -> vc_vaga."',
                                            start: '".$linha -> dt_entrevista."',
                                            description: 'Tipo:".($linha->bl_tipo_entrevista=='especialista'?"Especialista":"Competência")."',
                                            color: '".($linha->bl_tipo_entrevista=='especialista'?($linha->es_status=='12'?"green":($linha->es_status==15?"red":"#ab8c00")):($linha->es_status=='11'?"green":($linha->es_status==15?"red":"#ab8c00")))."'
                                    }, ";
                                        }
                                        else{
                                                $pagina['js'] .= "
                                    {
                                            title: 'Candidato: ".$linha -> vc_nome."',
                                            start: '".$linha -> dt_entrevista."',
                                            description: 'Tipo:".($linha->bl_tipo_entrevista=='especialista'?"Especialista":"Competência")."<br/>Vaga: ".$linha -> vc_vaga."',
                                            color: '".($linha->bl_tipo_entrevista=='especialista'?($linha->es_status=='12'?"green":($linha->es_status==15?"red":"#ab8c00")):($linha->es_status=='11'?"green":($linha->es_status==15?"red":"#ab8c00")))."'

                                    }, ";
                                        }
                                }
                        }



                        $pagina['js'] .= "
                    ]
                });
            });

        </script>";
                }
        }
        /*else{ //gestores
                if(strlen($erro)>0){
                        echo "
                                                                    <div class=\"alert alert-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
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
                                                                    </div>";
                }
                if(strlen($sucesso) == 0){
                        $attributes = array('class' => 'kt-form',
                                            'id' => 'form_avaliacoes');
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                        echo "
                                                                            <div class=\"kt-portlet__body\">";
                        echo form_fieldset('Dados da candidatura');
                        echo "
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        echo $candidato -> vc_nome;
                        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('E-mail:', 'Email', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        echo $candidato -> vc_email;
                        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Telefone(s):', 'Telefones', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-6\">";
                        echo $candidato -> vc_telefone;
                        if(strlen($candidato -> vc_telefoneOpcional) > 0){
                                echo ' - '.$candidato -> vc_telefoneOpcional;
                        }
                        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Vaga:', 'Vaga', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-9\">";
                        echo $candidatura[0] -> vc_vaga;
                        echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                        $attributes = array('class' => 'col-lg-3 direito bolder');
                        echo form_label('Status da candidatura:', 'status', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-6\">";
                        echo $candidatura[0] -> vc_status;
                        echo "

                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                        echo form_fieldset('Entrevista');
                        //var_dump($entrevista);
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 1 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $dados_usuarios[0] = '';
                        foreach($usuarios as $linha){
                                $dados_usuarios[$linha -> pr_usuario] = $linha -> vc_nome;
                        }
                        $avaliador1='';
                        if(isset($entrevista[0] -> es_avaliador1) && strlen($entrevista[0] -> es_avaliador1)>0){
                                $avaliador1=$entrevista[0] -> es_avaliador1;
                        }


                        if(strlen(set_value('avaliador1')) > 0){
                                $avaliador1 = set_value('avaliador1');
                        }
                        if(strstr($erro, "'Avaliador 1'")){
                                echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 2 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador2='';
                        if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                $avaliador2 = $entrevista[0] -> es_avaliador2;
                        }

                        if(strlen(set_value('avaliador2')) > 0){
                                $avaliador2 = set_value('avaliador2');
                        }
                        if(strstr($erro, "'Avaliador 2'")){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Horário da entrevista <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                        echo "
                                                                                            <div class=\"col-lg-3\">";
                        $data_entrevista = '';
                        if(isset($entrevista[0] -> dt_entrevista) && strlen($entrevista[0] -> dt_entrevista)>0){
                                $data_entrevista = $entrevista[0] -> dt_entrevista;
                        }

                        if(strlen(set_value('data')) > 0){
                                $data_entrevista = show_sql_date(set_value('data'), true);
                        }
                        $attributes = array('name' => 'data',
                                            'id' => 'data',
                                            'class' => 'form-control');
                        if(strstr($erro, "'Horário da entrevista'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        echo form_input($attributes, show_date($data_entrevista, true));
                        echo "
                                                                                            </div>
                                                                                    </div>";
                        echo form_fieldset_close();
                        echo "
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div>
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                        $attributes = array('class' => 'btn btn-primary');
                        echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                        $pagina['js']="
                <script type=\"text/javascript\">
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });
                </script>";
                }
        }*/
        echo "
                                                    </div>
                                            </div>";
}
if($menu2 == 'AvaliacaoEntrevista'){ //avaliação da entrevista - 4ª etapa
        echo "
                                                                                    </h3>
                                                                            </div>
                                                                    ";
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-exclamation-triangle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br /> $erro
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
                                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form pb-4 px-4',
                                    'id' => 'form_avaliacoes');
                if(isset($vaga) && $vaga > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo,'vaga' => $vaga));
                }
                else{
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }

                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                //var_dump($candidatura);
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "

                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($opcoes);
                /*
                if(isset($questoes4)){
                        $x=0;
                        foreach ($questoes4 as $row){
                                $x++;
                                echo "
                                                                                                                                    <div class=\"form-group row validated\">
                                                                                                                                            <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                //$label=$x.') '.strip_tags($row -> tx_questao);
                                echo $row -> tx_questao;
                                echo '<br/>';
                                //echo 'questao: '.$row -> pr_questao.'<br>';
                                if($row -> in_tipo == 1){ //customizadas
                                        foreach ($opcoes as $row2){
                                                //echo $row2 -> es_questao.': '.$row2 -> tx_opcao.'<br>';
                                                if($row2 -> es_questao == $row -> pr_questao){
                                                        //echo 'opcao: '.$row2 -> tx_opcao.'<br>';
                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                            'value'=> $row2 -> in_valor);
                                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)==$row2 -> in_valor && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                                        echo ' '.$row2 -> tx_opcao.'<br/>';
                                                }
                                        }
                                }
                                else if($row -> in_tipo == 2){ //aberta
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'rows'=>'5');
                                        echo form_textarea($attributes, set_value('Questao'.$row -> pr_questao), 'class="form-control"');
                                }
                                else if($row -> in_tipo == 3 || $row -> in_tipo == 4){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Sim<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Não<br/>';
                                }
                                else if($row -> in_tipo == 5){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Nenhum<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Básico<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'2');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='2' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Intermediário<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'3');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='3' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Avançado<br/>';
                                }

                                if(strstr($erro, 'questão '.$x.' ')){
                                        echo "
                                                                                                                                            <div class=\"invalid-feedback\">
                                                                                                                                                    Preencha essa questão!
                                                                                                                                            </div>";
                                }
                                echo "
                                                                                                                                    </div>
                                                                                                                            </div>";
                        }
                }
                */
                $CI =& get_instance();
                $CI -> mostra_questoes($questoes4, $respostas, $opcoes, $erro, true);
                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div>
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                $attributes[' formnovalidate'] = ' formnovalidate';
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                unset($attributes[' formnovalidate']);
                echo form_submit('concluir_entrevista', 'Concluir', $attributes);
                if($vaga > 0){
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vaga)."'\">Cancelar</button>";
                }
                else{
                        echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>";
                }


                echo "
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
        <script type=\"text/javascript\">

            $('form').on('focus', 'input[type=number]', function (e) {
                $(this).on('wheel.disableScroll', function (e) {
                    e.preventDefault()
                })
            })
            $('form').on('blur', 'input[type=number]', function (e) {
               $(this).off('wheel.disableScroll')
            })
        </script>";
        }
        echo "
                                                    </div>
                                            </div>";
}

if($menu2 == 'AvaliacaoEntrevistaEspecialista'){ //avaliação da entrevista especialista - 6ª etapa
        echo "
                                                                                    </h3>
                                                                            </div>
                                                                    ";
        if(strlen($erro)>0){
                echo "
                                                                            <div class=\"alert alert-danger\" role=\"alert\">
                                                                                    <div class=\"alert-icon\">
                                                                                            <i class=\"fa fa-exclamation-triangle\"></i>
                                                                                    </div>
                                                                                    <div class=\"alert-text\">
                                                                                            <strong>ERRO</strong>:<br /> $erro
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
                                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_avaliacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                //var_dump($candidatura);
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "

                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($opcoes);
                /*
                if(isset($questoes4)){
                        $x=0;
                        foreach ($questoes4 as $row){
                                $x++;
                                echo "
                                                                                                                                    <div class=\"form-group row validated\">
                                                                                                                                            <div class=\"col-lg-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                //$label=$x.') '.strip_tags($row -> tx_questao);
                                echo $row -> tx_questao;
                                echo '<br/>';
                                //echo 'questao: '.$row -> pr_questao.'<br>';
                                if($row -> in_tipo == 1){ //customizadas
                                        foreach ($opcoes as $row2){
                                                //echo $row2 -> es_questao.': '.$row2 -> tx_opcao.'<br>';
                                                if($row2 -> es_questao == $row -> pr_questao){
                                                        //echo 'opcao: '.$row2 -> tx_opcao.'<br>';
                                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                            'value'=> $row2 -> in_valor);
                                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)==$row2 -> in_valor && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                                        echo ' '.$row2 -> tx_opcao.'<br/>';
                                                }
                                        }
                                }
                                else if($row -> in_tipo == 2){ //aberta
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'rows'=>'5');
                                        echo form_textarea($attributes, set_value('Questao'.$row -> pr_questao), 'class="form-control"');
                                }
                                else if($row -> in_tipo == 3 || $row -> in_tipo == 4){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Sim<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Não<br/>';
                                }
                                else if($row -> in_tipo == 5){
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'0');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='0' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Nenhum<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'1');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='1' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Básico<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'2');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='2' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Intermediário<br/>';
                                        $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                            'value'=>'3');
                                        echo form_radio($attributes, set_value('Questao'.$row -> pr_questao), (set_value('Questao'.$row -> pr_questao)=='3' && strlen(set_value('Questao'.$row -> pr_questao))>0));
                                        echo ' Avançado<br/>';
                                }

                                if(strstr($erro, 'questão '.$x.' ')){
                                        echo "
                                                                                                                                            <div class=\"invalid-feedback\">
                                                                                                                                                    Preencha essa questão!
                                                                                                                                            </div>";
                                }
                                echo "
                                                                                                                                    </div>
                                                                                                                            </div>";
                        }
                }
                */
                $CI =& get_instance();
                $CI -> mostra_questoes($questoes6, $respostas, $opcoes, $erro, true);
                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\">
                                                                                    <div>
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                echo form_submit('concluir_entrevista', 'Concluir', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Candidaturas/ListaAvaliacao')."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
        <script type=\"text/javascript\">
            $('#data').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
        </script>";
        }
        echo "
                                                    </div>
                                            </div>";
}

echo "
                                    </div>";

$this -> load -> view('internaRodape', $pagina);
?>