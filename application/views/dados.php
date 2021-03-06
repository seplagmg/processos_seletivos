<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']='Candidatos';
$pagina['menu2']='index';
$pagina['url']='Candidatos/index';
$pagina['nome_pagina']='Seus dados';
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
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_dados').submit();\"> Salvar </button>
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
        /*if(strlen(set_value('num_formacao')) > 0){

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
        }*/
        $attributes = array('class' => 'login-form',
                            'id' => 'form_dados');
        //echo form_open_multipart($url, $attributes, array('num_formacao' => $num_formacao, 'num_experiencia' => $num_experiencia));
        echo form_open($url, $attributes);
        echo "
                                <div class=\"row\">
                                        <div class=\"col-md-9\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Nome completo <abbr title="Obrigat??rio">*</abbr>', 'nome', $attributes);

        $attributes = array('name' => 'NomeCompleto',
                            'id' => 'NomeCompleto',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $vc_nome);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('CPF <abbr title="Obrigat??rio">*</abbr>', 'CPF', $attributes);

        $attributes = array('name' => 'CPF',
                            'id' => 'CPF',
                            'maxlength'=>'14',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $ch_cpf);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('RG <abbr title="Obrigat??rio">*</abbr>', 'RG', $attributes);

        $attributes = array('name' => 'RG',
                            'id' => 'RG',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $vc_rg);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('??rg??o Emissor <abbr title="Obrigat??rio">*</abbr>', 'OrgaoEmissor', $attributes);

        $attributes = array('name' => 'OrgaoEmissor',
                            'id' => 'OrgaoEmissor',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line',
                            'disabled' => 'disabled');
        echo form_input($attributes, $vc_orgaoEmissor);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('G??nero <abbr title="Obrigat??rio">*</abbr>', 'IdentidadeGenero', $attributes);

        $attributes = array(
                            0 => '',
                            1 => 'N??o informado',
                            2 => 'Masculino',
                            3 => 'Feminino',
                            4 => 'Desejo informar'
                            );
        if(strstr($erro, "'G??nero'")){
                echo form_dropdown('IdentidadeGenero', $attributes, $in_genero, "class=\"form-control is-invalid\" id=\"IdentidadeGenero\"");
        }
        else{
                echo form_dropdown('IdentidadeGenero', $attributes, $in_genero, "class=\"form-control\" id=\"IdentidadeGenero\"");
        }
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Informe g??nero optativo <abbr title="Obrigat??rio">*</abbr>', 'IdentidadeGeneroOptativa', $attributes);

        $attributes = array('name' => 'IdentidadeGeneroOptativa',
                            'id' => 'IdentidadeGeneroOptativa',
                            'maxlength'=>'50',
                            'class' => 'form-control text-box single-line',
                            'disabled'=>'disabled');
        if(strstr($erro, "'G??nero optativo'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_generoOptativo);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Ra??a <abbr title="Obrigat??rio">*</abbr>', 'Raca', $attributes);

        $attributes = array(
                            0 => '',
                            1 => 'N??o informado',
                            2 => 'Amarela',
                            3 => 'Branca',
                            4 => 'Ind??gena',
                            5 => 'Parda',
                            6 => 'Preta'
                            );
        if(strstr($erro, "'Ra??a'")){
                echo form_dropdown('Raca', $attributes, $in_raca, "class=\"form-control is-invalid\" id=\"Raca\"");
        }
        else{
                echo form_dropdown('Raca', $attributes, $in_raca, "class=\"form-control\" id=\"Raca\"");
        }
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('E-mail <abbr title="Obrigat??rio">*</abbr>', 'Email', $attributes);

        $attributes = array('name' => 'Email',
                            'id' => 'Email',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'E-mail'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_email);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Telefone <abbr title="Obrigat??rio">*</abbr>', 'Telefone', $attributes);

        $attributes = array('name' => 'Telefone',
                            'id' => 'Telefone',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Telefone'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
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
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, $vc_telefoneOpcional);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-3\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Data de nascimento <abbr title="Obrigat??rio">*</abbr>', 'DataNascimento', $attributes);

        $attributes = array('name' => 'DataNascimento',
                            'id' => 'DataNascimento',
                            'maxlength'=>'15',

                            'class' => 'form-control text-box single-line');
        if(strstr($erro, 'data de nascimento')){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
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
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line',
                            'placeholder' => 'https://www.linkedin.com/in/');
        echo form_input($attributes, $vc_linkedin);
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-4\">
                                                <br/>
                                                <label>
                                                        Pa??s: &nbsp;
                                                </label>
                                                <div class=\"btn-group control-label\">
                                                        <label class=\"\">";
        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'Pais',
                            'value'=>'Brasil');
        echo form_radio($attributes, set_value('Nacionalidade'), ($vc_pais=='Brasil' || strlen($vc_pais)==0));
        echo " Brasil
                                                        </label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label class=\"\">";
        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'OutroPais',
                            'value'=>'Outro');
        echo form_radio($attributes, set_value('Nacionalidade'), ($vc_pais!='Brasil' && strlen($vc_pais)>0));
        echo " Exterior
                                                        </label>
                                                </div>
                                        </div>
                                        <div id=\"div_cidadeestrangeira\" class=\"col-md-8\" style=\"display:none\">
                                                <div class=\"col-md-4\">
                                                        <div class=\"form-group\" id=\"div_pais\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Pa??s estrangeiro <abbr title="Obrigat??rio">*</abbr>', 'Pais2', $attributes);

        $attributes = array('name' => 'Pais2',
                            'id' => 'Pais2',
                            'maxlength'=>'150',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Pa??s estrangeiro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_pais);
        echo "
                                                        </div>
                                                </div>
                                                <div class=\"col-md-4\">
                                                        <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Cidade estrangeira <abbr title="Obrigat??rio">*</abbr>', 'CidadeEstrangeira', $attributes);

        $attributes = array('name' => 'CidadeEstrangeira',
                            'id' => 'CidadeEstrangeira',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Cidade estrangeira'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_cidadeEstrangeira);
        echo "
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-2\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('CEP <abbr title="Obrigat??rio">*</abbr>', 'CEP', $attributes);

        $attributes = array('name' => 'CEP',
                            'id' => 'CEP',
                            'maxlength'=>'9',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'CEP'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_cep, " onblur=\"pesquisacep(this.value);\"");
        echo "
                                                </div>
                                        </div>
                                </div>
                                <div class=\"row\">
                                        <div class=\"col-md-6\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Logradouro <abbr title="Obrigat??rio">*</abbr>', 'Logradouro', $attributes);

        $attributes = array('name' => 'Logradouro',
                            'id' => 'Logradouro',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Logradouro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_logradouro);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('N??mero <abbr title="Obrigat??rio">*</abbr>', 'Numero', $attributes);

        $attributes = array('name' => 'Numero',
                            'id' => 'Numero',
                            'maxlength'=>'10',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'N??mero'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
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
                            'maxlength'=>'10',
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
                            'maxlength'=>'150',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Bairro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, $vc_bairro);
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-2\">
                                                <div class=\"form-group\">";
        $Estados=array(0 => '')+$Estados;
        $attributes = array('class' => 'control-label');
        echo form_label('Estado <abbr title="Obrigat??rio">*</abbr>', 'Estado', $attributes);

        if(strstr($erro, "'Estado'")){
                echo form_dropdown('Estado', $Estados, set_value('Estado'), "class=\"form-control is-invalid\" id=\"Estado\"");
        }
        else{
                echo form_dropdown('Estado', $Estados, set_value('Estado'), "class=\"form-control\" id=\"Estado\"");
        }
        echo "
                                                </div>
                                        </div>
                                        <div class=\"col-md-4\">
                                                <div class=\"form-group\">";
        $attributes = array('class' => 'control-label');
        echo form_label('Munic??pio <abbr title="Obrigat??rio">*</abbr>', 'Municipio', $attributes);

        if(strstr($erro, "'Munic??pio'")){
                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control is-invalid\" id=\"Municipio\"");
        }
        else{
                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control\" id=\"Municipio\"");
        }
        echo "
                                                </div>
                                        </div>
                                </div>";
        /*echo "
								<div class=\"alert alert-warning\">
										ATEN????O<br />
										As informa????es de Forma????o Acad??mica e Experi??ncia Profissional registradas aqui servir??o como curr??culo base na inscri????o de qualquer vaga. O sistema incluir?? uma c??pia dos dados inseridos aqui no formul??rio de ???Curr??culo??? da vaga escolhida, para que o candidato n??o precise preencher todas essas informa????es e incluir todos os comprovantes toda vez que se inscrever a uma vaga.<br />
										Os dados copiados para a vaga poder??o ser alterados pelo candidato durante a inscri????o, mas essas altera????es N??O ser??o refletidas no curr??culo base, ou seja, no formul??rio de Dados Pessoais.<br />
										Ap??s a escolha da vaga, qualquer altera????o no curr??culo base (neste formul??rio de Dados Pessoais) N??O ser?? refletida no Curr??culo que aparece na vaga.

								</div>
                                <div class=\"kt-wizard-v4__form\" id=\"div_formacao\">";
        for($i = 1; $i <= $num_formacao; $i++){
                echo "
                                        <div id=\"row_formacao{$i}\">
                                                <fieldset>
                                                        <legend>Forma????o acad??mica {$i}</legend>
                                                                <div class=\"form-group row\">
                                                                    <div class=\"col-md-4 col-lg-2\">";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Tipo <abbr title="Obrigat??rio">*</abbr>', "tipo{$i}", $attributes);

                echo "
                                                                    </div>
                                                                    <div class=\"col-md-8 col-lg-10\">";
                //var_dump($etapas);
                $attributes = array(
                            '' => '',
                            'bacharelado' => 'Gradua????o - Bacharelado',
                            'tecnologo' => 'Gradua????o - Tecnol??go',
                            'especializacao' => 'P??s-gradua????o - Especializa????o',
                            'mba' => 'MBA',
                            'mestrado' => 'Mestrado',
                            'doutorado' => 'Doutorado',
                            'posdoc' => 'P??s-doutorado',
							'seminario' => 'Curso/Semin??rio',
                            );
                if(!isset($en_tipo[$i]) || (strlen($en_tipo[$i]) == 0 && strlen(set_value("tipo{$i}")) > 0) || (strlen(set_value("tipo{$i}")) > 0 && $en_tipo != set_value("tipo{$i}"))){
                        $en_tipo[$i] = set_value("tipo{$i}");
                }
                if(strstr($erro, "tipo da 'Forma????o acad??mica {$i}'")){
                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control is-invalid\" id=\"tipo{$i}\" onchange=\"mostra_carga_horaria({$i})\"");
                }
                else{
                        echo form_dropdown("tipo{$i}", $attributes, $en_tipo[$i], "class=\"form-control\" id=\"tipo{$i}\" onchange=\"mostra_carga_horaria({$i})\"");
                }
                echo "
                                                                    </div>
                                                            </div>
                                                            <div class=\"form-group row\">
                                                                    <div class=\"col-md-4 col-lg-2\">
                                                                                                                                                    ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Nome do curso <abbr title="Obrigat??rio">*</abbr>', "curso{$i}", $attributes);
                echo "
                                                                    </div>
                                                                    <div class=\"col-md-8 col-lg-10\">";
                if(!isset($vc_curso[$i]) || (strlen($vc_curso[$i]) == 0 && strlen(set_value("curso{$i}")) > 0) || (strlen(set_value("curso{$i}")) > 0 && $vc_curso[$i] != set_value("curso{$i}"))){
                        $vc_curso[$i] = set_value("curso{$i}");
                }
                $attributes = array('name' => "curso{$i}",
                                    'id' => "curso{$i}",
                                    'maxlength' => '100',
                                    'class' => 'form-control');
                if(strstr($erro, "curso da 'Forma????o acad??mica {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_curso[$i]);
                echo "
                                                                    </div>
                                                            </div>
                                                            <div class=\"form-group row\">
                                                                    <div class=\"col-md-4 col-lg-2\">
                                                                                                                                                    ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Institui????o de ensino <abbr title="Obrigat??rio">*</abbr>', "instituicao{$i}", $attributes);
                echo "
                                                                    </div>
                                                                    <div class=\"col-md-8 col-lg-10\">";
                if(!isset($vc_instituicao[$i]) || (strlen($vc_instituicao[$i]) == 0 && strlen(set_value("instituicao{$i}")) > 0) || (strlen(set_value("instituicao{$i}")) > 0 && $vc_instituicao[$i] != set_value("instituicao{$i}"))){
                        $vc_instituicao[$i] = set_value("instituicao{$i}");
                }
                $attributes = array('name' => "instituicao{$i}",
                                    'id' => "instituicao{$i}",
                                    'maxlength' => '100',
                                    'class' => 'form-control');
                if(strstr($erro, "institui????o de ensino da 'Forma????o acad??mica {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $vc_instituicao[$i]);
                echo "
                                                                    </div>
                                                            </div>

															<div class=\"form-group row\">
                                                                    <div class=\"col-md-4 col-lg-2\">
                                                                                                                                                    ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Data de conclus??o <abbr title="Obrigat??rio">*</abbr>', "conclusao{$i}", $attributes);
                echo "
                                                                    </div>
                                                                    <div class=\"col-md-8 col-lg-10\">";
                if(!isset($dt_conclusao[$i]) || (strlen($dt_conclusao[$i]) == 0 && strlen(set_value("conclusao{$i}")) > 0) || (strlen(set_value("conclusao{$i}")) > 0 && $dt_conclusao[$i] != set_value("conclusao{$i}"))){
                        $dt_conclusao[$i] = set_value("conclusao{$i}");
                }
                $attributes = array('name' => "conclusao{$i}",
                                    'id' => "conclusao{$i}",

                                    'type' => 'date',
                                    'class' => 'form-control');
                if(strstr($erro, "data da conclus??o da 'Forma????o acad??mica {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                }

                echo form_input($attributes, $dt_conclusao[$i]);

                echo "
                                                                    </div>
                                                            </div>

															<div class=\"form-group row\" id=\"div_carga_horaria{$i}\">
                                                                    <div class=\"col-md-4 col-lg-2\">
                                                                                                                                                    ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Carga Hor??ria total (considerando 1 dia = 8h) <abbr title="Obrigat??rio no caso de ser \'Curso/Semin??rio\'">*</abbr>', "cargahoraria{$i}", $attributes);
                echo "
                                                                    </div>
                                                                    <div class=\"col-md-8 col-lg-10\">";
                if(!isset($in_cargahoraria[$i]) || (strlen($in_cargahoraria[$i]) == 0 && strlen(set_value("cargahoraria{$i}")) > 0) || (strlen(set_value("cargahoraria{$i}")) > 0 && $in_cargahoraria[$i] != set_value("conclusao{$i}"))){
                        $in_cargahoraria[$i] = set_value("cargahoraria{$i}");
                }
                $attributes = array('name' => "cargahoraria{$i}",
                                    'id' => "cargahoraria{$i}",
                                    'maxlength' => '10',
                                    'type' => 'number',
                                    'class' => 'form-control');
                if(strstr($erro, "carga hor??ria da 'Forma????o acad??mica {$i}'")){
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
                                                                    <div class=\"col-md-4 col-lg-2\">
                                                                                                                                                    ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Diploma / certificado <abbr title="Obrigat??rio">*</abbr>', "diploma{$i}", $attributes);
                echo "
                                                                    </div>
                                                                    <div class=\"col-md-8 col-lg-10\">";
                $attributes = array('name' => "diploma{$i}",
                                    'class' => 'form-control');
                if(strstr($erro, "diploma / certificado da 'Forma????o acad??mica {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
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
                echo form_upload($attributes, '', 'class="form-control"');
                echo "
                                                                    </div>
                                                            </div>
                                                    </fieldset>
                                            </div>
                                                                        ";
        }
        echo "
                                </div>
                                <div class=\"j-footer\">
                                        <div>
                                                <div class=\"col-lg-12 text-center\">
                                                        <button type=\"button\" id=\"adicionar_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-plus\"></i> Adicionar forma????o</button>
                                                        <button type=\"button\" id=\"remover_formacao\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-minus\"></i> Remover forma????o</button></div>
                                                </div>
                                        </div>
                                </div>
                                <div class=\"kt-wizard-v4__form\" id=\"div_experiencia\">";
        for($i = 1; $i <= $num_experiencia; $i++){
                if($i == 1){
                        echo "
                                        <div id=\"row_experiencia{$i}\">
                                                <fieldset>
                                                        <legend>Experi??ncia profissional {$i}<abbr title=\"Prezado(a) candidato (a) atente-se ao preenchimento da experi??ncia profissional, tal informa????o deve conter, necessariamente, n??o apenas os nomes das institui????es nas quais voc?? trabalhou, mas tamb??m o per??odo (ano de in??cio e t??rmino do v??nculo), o tempo de experi??ncia em determinada atividade, o tipo (se foi de lideran??a, coordena????o, parte da equipe t??cnica etc), a atividade realizada e o n??mero de liderados (se esta informa????o for requisito da vaga).\">?</abbr></legend>";

                }
                else{
                        echo "
                                        <div id=\"row_experiencia{$i}\">
                                                <fieldset>
                                                        <legend>Experi??ncia profissional {$i}</legend>";

                }
                echo "
                                                        <div class=\"form-group row\">
                                                                <div class=\"col-md-4 col-lg-2\">
                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Institui????o / empresa <abbr title="Obrigat??rio">*</abbr>', "empresa{$i}", $attributes);
                echo "
                                                                </div>
                                                                <div class=\"col-md-8 col-lg-10\">";
                if(!isset($vc_empresa[$i]) || (strlen($vc_empresa[$i]) == 0 && strlen(set_value("empresa{$i}")) > 0) || (strlen(set_value("empresa{$i}")) > 0 && $vc_empresa[$i] != set_value("empresa{$i}"))){
                        $vc_empresa[$i] = set_value("empresa{$i}");
                }
                $attributes = array('name' => "empresa{$i}",
                                    'id' => "empresa{$i}",
                                    'maxlength' => '100',
                                    'class' => 'form-control');
                echo form_input($attributes, $vc_empresa[$i]);
                echo "
                                                                </div>
                                                        </div>
                                                        <div class=\"form-group row\">
                                                                <div class=\"col-md-4 col-lg-2\">
                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Data de in??cio <abbr title="Obrigat??rio">*</abbr>', "inicio{$i}", $attributes);
                echo "
                                                                </div>
                                                                <div class=\"col-md-8 col-lg-10\">";
                if(!isset($dt_inicio[$i]) || (strlen($dt_inicio[$i]) == 0 && strlen(set_value("inicio{$i}")) > 0) || (strlen(set_value("inicio{$i}")) > 0 && $dt_inicio[$i] != set_value("inicio{$i}"))){
                        $dt_inicio[$i] = set_value("inicio{$i}");
                }
                $attributes = array('name' => "inicio{$i}",
                                    'id' => "inicio{$i}",

                                    'type' => 'date',
                                    'class' => 'form-control');
                echo form_input($attributes, $dt_inicio[$i]);
                echo "
                                                                </div>
                                                        </div>

                                                        <div class=\"form-group row\">
                                                                <div class=\"col-md-4 col-lg-2\">
                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Data de t??rmino', "fim{$i}", $attributes);
                echo "
                                                                </div>
                                                                <div class=\"col-md-8 col-lg-10\">";
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
                                                                <div class=\"col-md-4 col-lg-2\">
                                                                ";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Principais atividades desenvolvidas <abbr title="Obrigat??rio">*</abbr>', "atividades{$i}", $attributes);
                echo "
                                                                </div>
                                                                <div class=\"col-md-8 col-lg-10\">";
                if(!isset($tx_atividades[$i]) || (strlen($tx_atividades[$i]) == 0 && strlen(set_value("atividades{$i}")) > 0) || (strlen(set_value("fim{$i}")) > 0 && $tx_atividades[$i] != set_value("atividades{$i}"))){
                        $tx_atividades[$i] = set_value("atividades{$i}");
                }
                $attributes = array('name' => "atividades{$i}",
                                    'id' => "atividades{$i}",
                                    'rows' => '4',
                                    'class' => 'form-control');
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
																<div class=\"col-md-4 col-lg-2\">
																		";
                $attributes = array('class' => 'esquerdo control-label');
                echo form_label('Comprovante <abbr title="Obrigat??rio">*</abbr>', "comprovante{$i}", $attributes);
                echo "
																</div>
																<div class=\"col-md-8 col-lg-10\">";
                $attributes = array('name' => "comprovante{$i}",
                                    'class' => 'form-control');
                if(strstr($erro, "comprovante da 'Experi??ncia profissional {$i}'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
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
                echo form_upload($attributes, '', 'class="form-control"');
                echo "
																</div>
														</div>
                                                </fieldset>
                                        </div>
                                                                        ";
        }
        echo "
                                </div>
                                <div class=\"j-footer\" id=\"botoes_experiencia\">
                                        <div>
                                                <div class=\"col-lg-12 text-center\">
                                                        <button type=\"button\" id=\"adicionar_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-plus\"></i> Adicionar exp. profissional</button>
                                                        <button type=\"button\" id=\"remover_experiencia\" class=\"btn btn-default\"><i class=\"fa fa-lg mr-1 fa-minus\"></i> Remover exp. profissional</button></div>
                                                </div>
                                        </div>
                                </div>";*/
        echo "
                                <div class=\"j-footer\">
                                        <div class=\"text-center\">";
        $attributes = array('class' => 'btn btn-primary');
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

                            function limpa_formul??rio_cep() {
                                    //Limpa valores do formul??rio de cep.
                                    document.getElementById('Logradouro').value=(\"\");
                                    document.getElementById('Bairro').value=(\"\");
                                    document.getElementById('Municipio').value=(\"\");
                                    document.getElementById('Estado').value=(\"\");
                            }

                            function meu_callback(conteudo) {
                                    if (!(\"erro\" in conteudo)) {
                                            //Atualiza os campos com os valores.
                                            document.getElementById('Logradouro').value=(conteudo.logradouro);
                                            document.getElementById('Bairro').value=(conteudo.bairro);
                                            //document.getElementById('Estado').value=(conteudo.uf);

                                            var opts = document.getElementById('Estado').options;
                                            for (var opt, j = 0; opt = opts[j]; j++) {
                                                    if (opt.text == conteudo.uf) {
                                                            document.getElementById('Estado').selectedIndex = j;
                                                            break;
                                                    }
                                            }
                                            $(document).ready(function(){
                                                    var estado = $('#Estado').val();
                                                    if(estado != ''){
                                                            $.ajax({
                                                                    url:\"".base_url()."Candidatos/fetch_Municipios\",
                                                                    method:\"POST\",
                                                                    data:{estado:estado},
                                                                    success:function(data){
                                                                            $('#Municipio').html(data);
                                                                            $('#Municipio option').each(function () {
                                                                                    if ($(this).html() == conteudo.localidade.toUpperCase()) {
                                                                                        $(this).attr('selected', 'selected');
                                                                                        return;
                                                                                    }
                                                                            });
                                                                    }
                                                            })
                                                    }
                                            });
                                            //document.getElementById('Municipio').value=(conteudo.localidade);
                                            document.getElementById('Numero').focus();
                                    }
                                    else {
                                            //CEP n??o Encontrado.
                                            limpa_formul??rio_cep();
                                            alert(\"CEP n??o encontrado.\");
                                    }
                            }

                            function pesquisacep(valor) {

                                //Nova vari??vel \"cep\" somente com d??gitos.
                                var cep = valor.replace(/\D/g, '');

                                //Verifica se campo cep possui valor informado.
                                if (cep != '') {

                                    //Express??o regular para validar o CEP.
                                    var validacep = /^[0-9]{8}$/;

                                    //Valida o formato do CEP.
                                    if(validacep.test(cep)) {
                                        //Preenche os campos com \"...\" enquanto consulta webservice.
                                        document.getElementById('Logradouro').value=\"...\";
                                        document.getElementById('Bairro').value=\"...\";

                                        //Cria um elemento javascript.
                                        var script = document.createElement('script');

                                        //Sincroniza com o callback.
                                        script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                                        //Insere script no documento e carrega o conte??do.
                                        document.body.appendChild(script);

                                    }
                                    else {
                                        //cep ?? inv??lido.
                                        limpa_formul??rio_cep();
                                        alert('Formato de CEP inv??lido.');
                                    }
                                }
                                else {
                                    //cep sem valor, limpa formul??rio.
                                    limpa_formul??rio_cep();
                                }
                            };
        ";
        /*$pagina['js'] .= "
                            function mostra_carga_horaria(i){
                                    var tipo = $('#tipo'+i).val();
                                    if(tipo == 'seminario'){
                                            $('#div_carga_horaria'+i).show();
                                    }
                                    else{
                                            $('#div_carga_horaria'+i).hide();
                                    }
                            }

                            $( '#adicionar_formacao' ).click(function() {
                                    var valor_num = $('input[name=num_formacao]').val();
                                    valor_num++;
                                    var newElement = '<div id=\"row_formacao' + valor_num + '\"><div class=\"kt-separator kt-separator--border-dashed kt-separator--space-sm\"></div><fieldset><legend>Forma????o acad??mica ' + valor_num + '</legend><div class=\"form-group row validated\">";

                                    $attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Tipo <abbr title="Obrigat??rio">*</abbr>', "tipo' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<div class=\"col-md-8 col-lg-10\"><select name=\"tipo' + valor_num + '\" class=\"form-control\" id=\"tipo' + valor_num + '\" onchange=\"mostra_carga_horaria('+valor_num+')\"><option value=\"\" selected=\"selected\"></option><option value=\"bacharelado\">Gradua????o - Bacharelado</option><option value=\"tecnologo\">Gradua????o - Tecnol??go</option><option value=\"especializacao\">P??s-gradua????o - Especializa????o</option><option value=\"mba\">MBA</option><option value=\"mestrado\">Mestrado</option><option value=\"doutorado\">Doutorado</option><option value=\"posdoc\">P??s-doutorado</option><option value=\"seminario\">Curso/Semin??rio</option></select></div></div><div class=\"form-group row validated\">";
                                    $attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Nome do curso <abbr title="Obrigat??rio">*</abbr>', "curso' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<div class=\"col-md-8 col-lg-10\">";
                                    $pagina['js'] .= "<input type=\"text\" name=\"curso' + valor_num + '\" value=\"\" id=\"curso' + valor_num + '\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\">";
                                    $attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Institui????o de ensino <abbr title="Obrigat??rio">*</abbr>', "instituicao' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<div class=\"col-md-8 col-lg-10\">";
                                    $pagina['js'] .= "<input type=\"text\" name=\"instituicao' + valor_num + '\" value=\"\" id=\"instituicao' + valor_num + '\" maxlength=\"100\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\">";

									$attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Data de conclus??o <abbr title="Obrigat??rio">*</abbr>', "conclusao' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<div class=\"col-md-8 col-lg-10\">";
                                    $pagina['js'] .= "<input type=\"date\" name=\"conclusao' + valor_num + '\" value=\"\" id=\"conclusao' + valor_num + '\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\" id=\"div_carga_horaria' + valor_num + '\">";


									$attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Carga Hor??ria total (considerando 1 dia = 8h) <abbr title="Obrigat??rio no caso de ser Curso/Semin??rio">*</abbr>', "conclusao' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<div class=\"col-md-8 col-lg-10\">";
                                    $pagina['js'] .= "<input type=\"number\" name=\"cargahoraria' + valor_num + '\" value=\"\" id=\"cargahoraria' + valor_num + '\" maxlength=\"4\" class=\"form-control\"  /></div></div><div class=\"form-group row validated\">";

                                    $attributes = array('class' => 'col-lg-2 col-form-label');
                                    $pagina['js'] .= form_label('Diploma / comprovante <abbr title="Obrigat??rio">*</abbr>', "diploma' + valor_num + '", $attributes);
                                    $pagina['js'] .= "<div class=\"col-md-8 col-lg-10\"><input type=\"file\" name=\"diploma' + valor_num + '\"  class=\"form-control\" /></div>";
                                    $pagina['js'] .= "</div></fieldset>";
                                    $pagina['js'] .= "</div>';
                                    $( '#div_formacao' ).append( $(newElement) );
                                    $('input[name=num_formacao]').val(valor_num);
                                    $('#div_carga_horaria'+valor_num).hide();

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
                            });";*/
        $pagina['js'].="
                        </script>
                        <script type=\"text/javascript\">
                            $(document).ready(function(){
                                    $('#CPF').inputmask('999.999.999-99');
                                    
                                    $('#DataNascimento').inputmask('99/99/9999');

                                    $('#CEP').inputmask('99999-999');
                                    $('#Telefone').inputmask('(99)99999-9999');
                                    $('#TelefoneOpcional').inputmask('(99)99999-9999');
                            });
                        </script>
                        <script type=\"text/javascript\">
                            $(document).ready(function(){
                                    $('#OutroPais').click(function(){
                                            $('#div_cidadeestrangeira').show();
                                    });
                                    $('#Pais').click(function(){
                                            $('#div_cidadeestrangeira').hide();
                                    });";
        if(set_value('Nacionalidade')!='Brasil' && strlen(set_value('Nacionalidade'))){
                $pagina['js'].="
                                    $('#div_cidadeestrangeira').show();";
        }
        $pagina['js'].="
                                    $('#IdentidadeGenero').change(function(){
                                            if($(this).val()==4){
                                                $('#IdentidadeGeneroOptativa').prop('disabled', false);
                                            }
                                            else{
                                                $('#IdentidadeGeneroOptativa').prop('disabled', true);
                                                $('#IdentidadeGeneroOptativa').val('');
                                            }
                                    });
                                    if($('#IdentidadeGenero').val()==4){
                                        $('#IdentidadeGeneroOptativa').prop('disabled', false);
                                    }
                                    else{
                                        $('#IdentidadeGeneroOptativa').prop('disabled', true);
                                        $('#IdentidadeGeneroOptativa').val('');
                                    }
                                    $('#Estado').change(function(){
                                            var estado = $('#Estado').val();
                                            if(estado != ''){
                                                    $.ajax({
                                                            url:\"".base_url()."Candidatos/fetch_Municipios\",
                                                            method:\"POST\",
                                                            data:{estado:estado},
                                                            success:function(data){
                                                                    $('#Municipio').html(data);
                                                            }
                                                    })
                                            }
                                    });
                                    $('#Estado').trigger('change');
                                    $('#CEP').trigger('onblur');
                            });
                        </script>";
//}
echo "";

$this -> load -> view('internaRodape', $pagina);
?>