<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']='Candidatos';
$pagina['menu2']='index';
$pagina['url']='Candidatos/curriculo_base';
$pagina['nome_pagina']='Currículo base';
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
                                                                </div>
                                                                <div class=\"col-lg-4 text-right\">
                                                                    <button type=\"button\" class=\"btn btn-primary\" onclick=\"$('#Salvar').click();\"> Salvar </button>
                                                                    <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url()."'\">Cancelar</button>
                                                                </div>
                                                            </div>";

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
//if(strlen($sucesso) == 0){
        if(strlen(set_value('num_formacao')) > 0){
                $num_formacao = set_value('num_formacao');
        }
        if(!($num_formacao>0)){
                $num_formacao = 1;
        }
        $navegar = 0;
        if(strlen(set_value('num_experiencia')) > 0){
                if(set_value('num_experiencia') > $num_experiencia){
                        $navegar = 1;
                }
                $num_experiencia = set_value('num_experiencia');
        }
        if(!($num_experiencia>0)){
                $num_experiencia = 1;
        }
        $attributes = array('class' => 'login-form',
                            'id' => 'form_dados');
        echo form_open_multipart($url, $attributes, array('num_formacao' => $num_formacao, 'num_experiencia' => $num_experiencia));
        echo "
                                                            <div class=\"alert alert-info\">
                                                                <b>ATENÇÃO</b>
                                                                <br/>
                                                                <br/>
                                                                Caso tenha problemas para salvar os anexos, <b>orientamos que salve o seu currículo a cada 03 (três) novos preenchimentos de experiências e/ou formações</b>, pois o sistema realiza o upload de 8mb por vez.
                                                                <br/><br/>
                                                                Ao final do envio dos arquivos, <b>faça o download de cada arquivo</b> para verificar se foram salvos corretamente.
                                                                <br/><br/>
                                                                Para mais informações a respeito do currículo base, veja o <a class=\"alert-info\" href=\"https://ati-seplag.gitbook.io/processos-seletivos-candidatos/\" target=\"_blank\" style=\"font-size:15px; text-decoration:underline\"><b>manual do candidato</b></a>.
                                                            </div>
                                                            <div id=\"div_formacao\">";
        for($i = 1; $i <= $num_formacao; $i++){
                echo "
                                                                <div id=\"row_formacao{$i}\">
                                                                    <fieldset>
                                                                        <legend>Formação acadêmica {$i}</legend>
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-lg-12\">";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Tipo <abbr title="Obrigatório">*</abbr>', "tipo{$i}", $attributes);
                echo "
                                                                            <br />";
                //var_dump($etapas);
                $attributes = array(
                            '' => '',
                            'bacharelado' => 'Graduação - Bacharelado',
                            'tecnologo' => 'Graduação - Tecnológo',
                            'especializacao' => 'Pós-graduação - Especialização',
                            'mba' => 'MBA',
                            'mestrado' => 'Mestrado',
                            'doutorado' => 'Doutorado',
                            'posdoc' => 'Pós-doutorado',
                            'seminario' => 'Curso/Seminário',
                            'licenciatura' => 'Licenciatura',
                            'ensino_medio' => 'Ensino Médio',
                            'producao_cientifica' => 'Produção Científica',
                            );
                if(!isset($en_tipo[$i]) || (strlen($en_tipo[$i]) == 0 && strlen(set_value("tipo{$i}")) > 0) || (strlen(set_value("tipo{$i}")) > 0 && $en_tipo != set_value("tipo{$i}"))){
                        $en_tipo[$i] = set_value("tipo{$i}");
                }
                if(strstr($erro, "tipo da 'Formação acadêmica {$i}'")){
                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\" onchange=\"altera_label({$i})\"");
                }
                else{
                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\" required=\"required\" onchange=\"altera_label({$i})\"");
                }
                echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-lg-12\">
                                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Nome do curso <abbr title="Obrigatório">*</abbr>', "curso{$i}", $attributes);
                echo "
                                                                                <br />";
                if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                        $vc_curso[$i] = set_value("curso{$i}");
                }
                $attributes = array('name' => "curso{$i}",
                                    'id' => "curso{$i}",
                                    'maxlength' => '300',
                                    'class' => 'form-control',
                                    'required' => 'required');

                if($en_tipo[$i] == 'producao_cientifica'){
                        if(strstr($erro, "categoria da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                else{
                        if(strstr($erro, "curso da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                echo form_input($attributes, $vc_curso[$i]);
                echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-lg-12\">
                                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Instituição de ensino <abbr title="Obrigatório">*</abbr>', "instituicao{$i}", $attributes);
                echo "
                                                                                <br />";
                if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                }
                $attributes = array('name' => "instituicao{$i}",
                                    'id' => "instituicao{$i}",
                                    'maxlength' => '300',
                                    'class' => 'form-control',
                                    'required' => 'required');
                if($en_tipo[$i] == 'producao_cientifica'){
                        if(strstr($erro, "título da pesquisa/publicação da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                else{
                        if(strstr($erro, "instituição de ensino da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                echo form_input($attributes, $vc_instituicao[$i]);
                echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-lg-12\">
                                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Data de conclusão <abbr title="Obrigatório">*</abbr>', "conclusao{$i}", $attributes);
                echo "
                                                                                <br />";
                if(!isset($dt_conclusao[$i]) || (strlen($dt_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $dt_conclusao[$i] != set_value("conclusao{$i}"))){
                        $dt_conclusao[$i] = set_value("conclusao{$i}");
                }
                $attributes = array('name' => "conclusao{$i}",
                                    'id' => "conclusao{$i}",
                                    'required' => 'required',
                                    'type' => 'date',
                                    'class' => 'form-control');
                if($en_tipo[$i] == 'producao_cientifica'){
                        if(strstr($erro, "data da conclusão da pesquisa/publicação da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                else{
                        if(strstr($erro, "data da conclusão da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }

                echo form_input($attributes, $dt_conclusao[$i]);
                echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-lg-12\">
                                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Carga Horária total (considerando 1 dia = 8h) <abbr title="Obrigatório no caso de ser \'Curso/Seminário\'">*</abbr>', "cargahoraria{$i}", $attributes);
                echo "
                                                                                <br />";
                if(!isset($in_cargahoraria[$i]) || (strlen($in_cargahoraria[$i]) == 0 && strlen(set_value("cargahoraria{$i}")) > 0) || (strlen(set_value("cargahoraria{$i}")) > 0 && $in_cargahoraria[$i] != set_value("conclusao{$i}"))){
                        $in_cargahoraria[$i] = set_value("cargahoraria{$i}");
                }
                $attributes = array('name' => "cargahoraria{$i}",
                                    'id' => "cargahoraria{$i}",
                                    'maxlength' => '10',
                                    'type' => 'number',
                                    'class' => 'form-control');
                if(strstr($erro, "carga horária da 'Formação acadêmica {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                }

                echo form_input($attributes, $in_cargahoraria[$i]);
                if(!isset($pr_formacao[$i]) || (strlen($pr_formacao[$i]) == 0 && strlen(set_value("codigo_formacao{$i}")) > 0) || (strlen(set_value("codigo_formacao{$i}")) > 0 && $pr_formacao[$i] != set_value("codigo_formacao{$i}"))){
                        $pr_formacao[$i] = set_value("codigo_formacao{$i}");
                }
                echo form_input(array('name' => 'codigo_formacao'.$i, 'type'=>'hidden', 'id' =>'codigo_formacao'.$i,'value'=>$pr_formacao[$i]));
                //echo form_hidden('codigo_formacao'.$i, $pr_formacao[$i]);
                echo "
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"form-group row\">
                                                                            <div class=\"col-lg-12\">
                                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Diploma / certificado <abbr title="Obrigatório">*</abbr>', "diploma{$i}", $attributes);
                echo "
                                                                                <br />";
                $attributes = array('name' => "diploma{$i}",
                                    'class' => 'form-control',
                                    'onchange' => 'checkFile(this)');

                if(isset($anexos_formacao[$i])){
                        $vc_anexo = $anexos_formacao[$i][0]->vc_arquivo;
                        $pr_arquivo = $anexos_formacao[$i][0]->pr_anexo;
                        echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                }
                else if(isset($anexos_formacao2[$i])){
                        $vc_anexo = $anexos_formacao2[$i][0]->vc_arquivo;
                        $pr_arquivo = $anexos_formacao2[$i][0]->pr_anexo;
                        echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                }
                else{
                        $attributes['required'] = "required";
                }
                if($en_tipo[$i] == 'producao_cientifica'){
                        if(strstr($erro, "upload da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                else{
                        if(strstr($erro, "diploma / certificado da 'Formação acadêmica {$i}'")){
                                $attributes['class'] = 'form-control is-invalid';
                                unset($attributes['required']);
                        }
                }
                echo form_upload($attributes, '', 'class="form-control"');
                echo "
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>";
        }
        echo "
                                                                </div>
                                                                <div class=\"j-footer\">
                                                                    <div>
                                                                        <div class=\"col-lg-12 text-center\">
                                                                                <button type=\"button\" id=\"adicionar_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-plus\"></i> Adicionar formação</button>
                                                                                <button type=\"button\" id=\"remover_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-minus\"></i> Remover formação</button>
                                                                        </div>
                                                                    </div>
                                                                    <div id=\"div_experiencia\">";
        for($i = 1; $i <= $num_experiencia; $i++){
                if($i == 1){
                        echo "
                                                                        <div id=\"row_experiencia{$i}\">
                                                                            <fieldset>
                                                                                <legend>Experiência profissional {$i}<abbr title=\"Prezado(a) candidato (a) atente-se ao preenchimento da experiência profissional, tal informação deve conter, necessariamente, não apenas os nomes das instituições nas quais você trabalhou, mas também o período (ano de início e término do vínculo), o tempo de experiência em determinada atividade, o tipo (se foi de liderança, coordenação, parte da equipe técnica etc), a atividade realizada e o número de liderados (se esta informação for requisito da vaga).\">?</abbr></legend>";

                }
                else{
                        echo "
                                                                        <div id=\"row_experiencia{$i}\">
                                                                            <fieldset>
                                                                                <legend>Experiência profissional {$i}</legend>";

                }
                echo "
                                                                                <div class=\"form-group row\">
                                                                                    <div class=\"col-lg-12\">
                                                                                        ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Instituição / empresa <abbr title="Obrigatório">*</abbr>', "empresa{$i}", $attributes);
                echo "
                                                                                        <br />";
                if(!isset($vc_empresa[$i]) || (strlen($vc_empresa[$i]) == 0 && strlen(set_value("empresa{$i}")) > 0) || (strlen(set_value("empresa{$i}")) > 0 && $vc_empresa[$i] != set_value("empresa{$i}"))){
                        $vc_empresa[$i] = set_value("empresa{$i}");
                }
                $attributes = array('name' => "empresa{$i}",
                                    'id' => "empresa{$i}",
                                    'maxlength' => '300',
                                    'class' => 'form-control',
                                    'required' => 'required');
                echo form_input($attributes, $vc_empresa[$i]);
                echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\">
                                                                                    <div class=\"col-lg-12\">
                                                                                        ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Data de início <abbr title="Obrigatório">*</abbr>', "inicio{$i}", $attributes);
                echo "
                                                                                        <br />";
                if(!isset($dt_inicio[$i]) || (strlen($dt_inicio[$i]) == 0 && strlen(set_value("inicio{$i}")) > 0) || (strlen(set_value("inicio{$i}")) > 0 && $dt_inicio[$i] != set_value("inicio{$i}"))){
                        $dt_inicio[$i] = set_value("inicio{$i}");
                }
                $attributes = array('name' => "inicio{$i}",
                                    'id' => "inicio{$i}",
                                    'required' => 'required',
                                    'type' => 'date',
                                    'class' => 'form-control');
                echo form_input($attributes, $dt_inicio[$i]);
                echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\">
                                                                                    <div class=\"col-lg-12\">
                                                                                        ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Emprego atual?', "emprego_atual{$i}", $attributes);
                echo "
                                                                        <br />";
                if(!isset($bl_emprego_atual[$i]) || (strlen($bl_emprego_atual[$i]) == 0 && strlen(set_value("emprego_atual{$i}")) > 0) || (strlen(set_value("emprego_atual{$i}")) > 0 && $bl_emprego_atual[$i] != set_value("emprego_atual{$i}"))){
                        $bl_emprego_atual[$i] = set_value("emprego_atual{$i}");
                }
                $attributes=array('0'=>'Não','1'=>'Sim');
                echo form_dropdown("emprego_atual{$i}", $attributes, $bl_emprego_atual[$i], "class=\"form-control\" id=\"emprego_atual{$i}\" onchange=\"esconde_data_termino({$i})\"");
                echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\" id=\"div_termino{$i}\">
                                                                                    <div class=\"col-lg-12\">
                                                                                        ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Data de término', "fim{$i}", $attributes);
                echo "
                                                                                        <br />";
                if(!isset($dt_fim[$i]) || (strlen($dt_fim[$i]) == 0 && strlen(set_value("fim{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $dt_fim[$i] != set_value("fim{$i}"))){
                        $dt_fim[$i] = set_value("fim{$i}");
                }
                $attributes = array('name' => "fim{$i}",
                                    'id' => "fim{$i}",

                                    'type' => 'date',
                                    'class' => 'form-control');
                echo form_input($attributes, $dt_fim[$i]);
                echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\">
                                                                                    <div class=\"col-lg-12\">
                                                                                        ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Principais atividades desenvolvidas <abbr title="Obrigatório">*</abbr>', "atividades{$i}", $attributes);
                echo "
                                                                                        <br />";
                if(!isset($tx_atividades[$i]) || (strlen($tx_atividades[$i]) == 0 && strlen(set_value("atividades{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $tx_atividades[$i] != set_value("atividades{$i}"))){
                        $tx_atividades[$i] = set_value("atividades{$i}");
                }
                $attributes = array('name' => "atividades{$i}",
                                    'id' => "atividades{$i}",
                                    'rows' => '4',
                                    'class' => 'form-control',
                                    'required' => 'required');
                echo form_textarea($attributes, $tx_atividades[$i]);
                if(!isset($pr_experienca[$i]) || (strlen($pr_experienca[$i]) == 0 && strlen(set_value("codigo_experiencia{$i}")) > 0) || (strlen(set_value("codigo_experiencia{$i}")) > 0 && $pr_experienca[$i] != set_value("codigo_experienci{$i}"))){
                        $pr_experienca[$i] = set_value("codigo_experiencia{$i}");
                }
                echo form_input(array('name' => 'codigo_experiencia'.$i, 'type'=>'hidden', 'id' =>'codigo_experiencia'.$i,'value'=>$pr_experienca[$i]));
                //echo form_hidden('codigo_experiencia'.$i, $pr_experienca[$i]);
                echo "
                                                                                    </div>
                                                                                </div>
                                                                                <div class=\"form-group row\">
                                                                                    <div class=\"col-lg-12\">
                                                                                        ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Comprovante <abbr title="Obrigatório">*</abbr>', "comprovante{$i}", $attributes);
                echo "
                                                                                        <br />";
                $attributes = array('name' => "comprovante{$i}",
                                    'class' => 'form-control',
                                    'onchange' => 'checkFile(this)');

                if(isset($anexos_experiencia[$i])){
                        $vc_anexo = $anexos_experiencia[$i][0]->vc_arquivo;
                        $pr_arquivo = $anexos_experiencia[$i][0]->pr_anexo;
                        echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                }
                else if(isset($anexos_experiencia2[$i])){
                        $vc_anexo = $anexos_experiencia2[$i][0]->vc_arquivo;
                        $pr_arquivo = $anexos_experiencia2[$i][0]->pr_anexo;
                        echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                }
                else{
                        $attributes['required'] = "required";
                }
                if(strstr($erro, "comprovante da 'Experiência profissional {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                        unset($attributes['required']);
                }
                echo form_upload($attributes, '', 'class="form-control"');
                echo "
                                                                                    </div>
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>";
    }
    echo "

                                                                        <div class=\"j-footer\" id=\"botoes_experiencia\">
                                                                            <div class=\"pb-3\">
                                                                                <div class=\"col-lg-12 text-center\">
                                                                                    <button type=\"button\" id=\"adicionar_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-plus\"></i> Adicionar exp. profissional</button>
                                                                                    <button type=\"button\" id=\"remover_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-minus\"></i> Remover exp. profissional</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class=\"j-footer\">
                                                                            <div class=\"text-right\">";
        $attributes = array('class' => 'btn btn-primary');
        $attributes['id'] = 'Salvar';
        echo form_submit('cadastrar', 'Salvar', $attributes);
        echo "
                                                                                <a href=\"".base_url()."\" class=\"btn btn-default\"> Cancelar </a>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
        $pagina['js']="
                <script type=\"text/javascript\" >
                    function checkFile(oFile){
                        if (oFile.files[0].size > 10485760) // 10 mb for bytes.
                        {
                            alert(\"Prezado(a) candidato(a), o sistema não aceita arquivos que ultrapassem o limite de 10mb (10240kb) de tamanho!\");
                            oFile.value='';
                        }
                        else if(oFile.files[0].size == 0){
                            alert(\"O arquivo não pode ser vazio!\");
                            oFile.value='';
                        }
                    }

                    function altera_label(i){
                        var tipo = $('#tipo'+i).val();
                        if(tipo == 'producao_cientifica'){
                            $('label[for=\"curso'+i+'\"]').html('Categoria (Artigo publicado em periódico A1 e A2, Artigo publicado em periódico B1, B2 e B3, Capítulo de Livro (com corpo editorial), Patente, Coordenação de projeto de pesquisa e/ou transferência de tecnologias) <abbr title=\"Obrigatório\">*</abbr>');
                            $('label[for=\"instituicao'+i+'\"]').html('Título da Pesquisa/Publicação <abbr title=\"Obrigatório\">*</abbr>');
                            $('label[for=\"conclusao'+i+'\"]').html('Data de conclusão da Pesquisa/Publicação <abbr title=\"Obrigatório\">*</abbr>');
                            $('label[for=\"diploma'+i+'\"]').html('Upload das Publicações/Produções Cientificas <abbr title=\"Obrigatório\">*</abbr> (Inserir Termo de outorga da fonte financiadora para a categoria coordenação de projeto de pesquisa e/ou transferência de tecnologias. Inserir arquivo pdf com tamanho máximo de 2MB)');

                        }
                        else{
                            $('label[for=\"curso'+i+'\"]').html('Nome do curso <abbr title=\"Obrigatório\">*</abbr>');
                            $('label[for=\"instituicao'+i+'\"]').html('Instituição de ensino <abbr title=\"Obrigatório\">*</abbr>');
                            $('label[for=\"conclusao'+i+'\"]').html('Data de conclusão <abbr title=\"Obrigatório\">*</abbr>');
                            $('label[for=\"diploma'+i+'\"]').html('Diploma / comprovante <abbr title=\"Obrigatório\">*</abbr> (inserir arquivo pdf com tamanho máximo de 2MB)');
                        }
                        if(tipo == 'seminario'){
                            $('#div_carga_horaria'+i).show();
                        }
                        else{
                            $('#div_carga_horaria'+i).hide();
                        }
                    }

                    function esconde_data_termino(i){
                        var emprego_atual = $('#emprego_atual'+i).val();

                        if(emprego_atual == '1'){
                                $('#div_termino'+i).hide();
                        }
                        else{
                                $('#div_termino'+i).show();
                        }
                    }

                    $( '#adicionar_formacao' ).click(function() {
                            var valor_num = $('input[name=num_formacao]').val();
                            valor_num++;
                            var newElement = '<div id=\"row_formacao' + valor_num + '\"><div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div><fieldset><legend>Formação acadêmica ' + valor_num + '</legend><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'esquerdo control-label');
        $pagina['js'] .= form_label('Tipo <abbr title="Obrigatório">*</abbr>', "tipo' + valor_num + '", $attributes);
        $pagina['js'] .= "<select name=\"tipo' + valor_num + '\" class=\"form-control\" required=\"required\" id=\"tipo' + valor_num + '\" onchange=\"altera_label('+ valor_num +')\"><option value=\"\" selected=\"selected\"></option><option value=\"bacharelado\">Graduação - Bacharelado</option><option value=\"tecnologo\">Graduação - Tecnológo</option><option value=\"especializacao\">Pós-graduação - Especialização</option><option value=\"mba\">MBA</option><option value=\"mestrado\">Mestrado</option><option value=\"doutorado\">Doutorado</option><option value=\"posdoc\">Pós-doutorado</option><option value=\"seminario\">Curso/Seminário</option><option value=\"licenciatura\">Licenciatura</option><option value=\"ensino_medio\">Ensino Médio</option><option value=\"producao_cientifica\">Produção Científica</option></select></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
        $attributes = array('class' => 'esquerdo control-label');
        $pagina['js'] .= form_label('Nome do curso <abbr title="Obrigatório">*</abbr>', "curso' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"text\" name=\"curso' + valor_num + '\" value=\"\" required=\"required\" id=\"curso' + valor_num + '\" maxlength=\"300\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";
        $attributes = array('class' => 'esquerdo control-label');
        $pagina['js'] .= form_label('Instituição de ensino <abbr title="Obrigatório">*</abbr>', "instituicao' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"text\" name=\"instituicao' + valor_num + '\" value=\"\" required=\"required\" id=\"instituicao' + valor_num + '\" maxlength=\"300\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'esquerdo control-label');
        $pagina['js'] .= form_label('Data de conclusão <abbr title="Obrigatório">*</abbr>', "conclusao' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"date\" name=\"conclusao' + valor_num + '\" value=\"\" required=\"required\" id=\"conclusao' + valor_num + '\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\" id=\"div_carga_horaria' + valor_num + '\"><div class=\"col-lg-12\">";


        $attributes = array('class' => 'esquerdo control-label');
        $pagina['js'] .= form_label('Carga Horária total (considerando 1 dia = 8h) <abbr title="Obrigatório no caso de ser Curso/Seminário">*</abbr>', "cargahoraria' + valor_num + '", $attributes);
        $pagina['js'] .= "<br />";
        $pagina['js'] .= "<input type=\"number\" name=\"cargahoraria' + valor_num + '\" value=\"\" id=\"cargahoraria' + valor_num + '\" maxlength=\"4\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\"><div class=\"col-lg-12\">";

        $attributes = array('class' => 'esquerdo control-label');
        $pagina['js'] .= form_label('Diploma / comprovante <abbr title="Obrigatório">*</abbr> (inserir arquivo pdf com tamanho máximo de 2MB)', "diploma' + valor_num + '", $attributes);
        $pagina['js'] .= "<br /><input type=\"file\" name=\"diploma' + valor_num + '\"  class=\"form-control\" onchange=\"checkFile(this)\" required=\"required\" /></div>";
        $pagina['js'] .= "</div></fieldset>";
        $pagina['js'] .= "</div>';
                            $( '#div_formacao' ).append( $(newElement) );
                            $('input[name=num_formacao]').val(valor_num);
                        });

                        $( '#remover_formacao' ).click(function() {
                                var valor_num = $('input[name=num_formacao]').val();
                                if($('#codigo_formacao'+valor_num).val()>0){
                                    $.get( \"/Candidatos/delete_formacao/\"+$('#codigo_formacao'+valor_num).val() );
                                }
                                $( '#row_formacao' + valor_num ).remove();

                                valor_num--;

                                $('input[name=num_formacao]').val(valor_num);
                        });

                        $( '#adicionar_experiencia' ).click(function() {
                                var valor_num = $('input[name=num_experiencia]').val();
                                valor_num++;

                                $('input[name=num_experiencia]').val(valor_num);
                                                                    document.getElementById('form_dados').submit();
                        });
                        $( '#remover_experiencia' ).click(function() {
                                var valor_num = $('input[name=num_experiencia]').val();
                                if($('#codigo_experiencia'+valor_num).val()>0){

                                    $.get( \"/Candidatos/delete_experiencia/\"+$('#codigo_experiencia'+valor_num).val() );
                                }
                                $( '#row_experiencia' + valor_num ).remove();
                                valor_num--;
                                $('input[name=num_experiencia]').val(valor_num);
                        });
                    </script>
                    <script type=\"text/javascript\">
                        $(document).ready(function(){";
        if($navegar == 1){
                $pagina['js'].="
                        $('html, body').animate({
                                scrollTop: $('#botoes_experiencia').offset().top
                        }, 'fast');";
        }
        for($i = 1; $i <= $num_formacao; $i++){
                $pagina['js'].="
                        $('#div_carga_horaria{$i}').hide();
                        altera_label({$i});";
        }
        for($i = 1; $i <= $num_experiencia; $i++){
                $pagina['js'].="
                        esconde_data_termino({$i});";
        }
        $pagina['js'].="
                    });
                </script>";

$this -> load -> view('internaRodape', $pagina);
?>