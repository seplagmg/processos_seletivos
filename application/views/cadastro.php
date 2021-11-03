<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$pagina['menu1']=$menu1;
$pagina['menu2']=$menu2;
$pagina['url']=$url;
$pagina['nome_pagina']=$nome_pagina;
if(isset($adicionais)){
        $pagina['adicionais']=$adicionais;
}

$this -> load -> view('publicoCabecalho');

echo "
            <section class=\"login-block\">
                <!-- Container-fluid starts -->
                <div class=\"container\" style=\"width:100% !important\">
                    <div class=\"row\">
                        <div class=\"col-sm-12\">
                            <!-- Authentication card start -->";
$attributes = array('class' => 'md-float-material form-material');
echo form_open($url, $attributes);
echo "
                                    <div class=\"text-center\">
                                        <img src=\"".base_url('images/logo.png')."\" width=\"400\" alt=\"".$this -> config -> item('nome')."\" />
                                    </div>
                                    <div class=\"card\" style=\"width:100% !important\">
                                        <div class=\"card-block\">
                                            <div class=\"row m-b-20\">
                                                <div class=\"col-12\">
                                                    <h3 class=\"text-center\">{$nome_pagina}</h3>
                                                </div>
                                            </div>";

if(strlen($erro)>0){
        if(isset($candidato)){
                //echo $candidato[0]->in_exigenciasComuns;
                if($candidato->in_exigenciasComuns == '0' || $candidato->bl_sentenciado == '1' || $candidato->bl_processoDisciplinar == '1' || $candidato->bl_ajustamentoFuncionalPorDoenca == '1'){
                        echo "
                                            <div class=\"text-center center-block\">
                                                    <button type=\"reset\" class=\"btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase\" onclick=\"window.location='".base_url('Candidatos/recuperar/'.set_value('CPF'))."';\">Recuperar candidato reprovado</button>
                                            </div>";
                }
        }
        echo "
                                            <div class=\"alert background-danger\">
                                                    <div class=\"alert-text\">
                                                            <strong>ERRO</strong>: {$erro}
                                                    </div>
                                            </div>";

}
if(strlen($sucesso)>0){
        echo "
                                            <div class=\"alert background-success\">
                                                    <div class=\"alert-text\">
                                                            <strong>{$sucesso}</strong>
                                                    </div>
                                            </div>";
}
echo "
                                            <div class=\"form-group form-primary\">";
if(strlen($sucesso) == 0){
        $attributes = array('class' => 'kt-form');
        echo form_open($url, $attributes);
        echo "
                                            <div class=\"row\">
                                                    <div class=\"col-md-9\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Nome completo <abbr title="Obrigatório" class="text-danger">*</abbr>', 'nome', $attributes);

        $attributes = array('name' => 'NomeCompleto',
                            'id' => 'NomeCompleto',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Nome completo'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('NomeCompleto'));
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('CPF <abbr title="Obrigatório" class="text-danger">*</abbr>', 'CPF', $attributes);

        $attributes = array('name' => 'CPF',
                            'id' => 'CPF',
                            'maxlength'=>'14',
                            'type' => 'tel',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'CPF'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('CPF'));
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('RG <abbr title="Obrigatório" class="text-danger">*</abbr>', 'RG', $attributes);

        $attributes = array('name' => 'RG',
                            'id' => 'RG',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'RG'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('RG'));
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Órgão Emissor <abbr title="Obrigatório" class="text-danger">*</abbr>', 'OrgaoEmissor', $attributes);

        $attributes = array('name' => 'OrgaoEmissor',
                            'id' => 'OrgaoEmissor',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Órgao Emissor'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('OrgaoEmissor'));
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Gênero <abbr title="Obrigatório" class="text-danger">*</abbr>', 'IdentidadeGenero', $attributes);

        $attributes = array(
                            0 => '',
                            1 => 'Não informado',
                            2 => 'Masculino',
                            3 => 'Feminino',
                            4 => 'Desejo informar'
                            );
        if(strstr($erro, "'Gênero'")){
                echo form_dropdown('IdentidadeGenero', $attributes, set_value('IdentidadeGenero'), "class=\"form-control is-invalid\" id=\"IdentidadeGenero\"");
        }
        else{
                echo form_dropdown('IdentidadeGenero', $attributes, set_value('IdentidadeGenero'), "class=\"form-control\" id=\"IdentidadeGenero\"");
        }
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Informe gênero optativo <abbr title="Obrigatório" class="text-danger">*</abbr>', 'IdentidadeGeneroOptativa', $attributes);

        $attributes = array('name' => 'IdentidadeGeneroOptativa',
                            'id' => 'IdentidadeGeneroOptativa',
                            'maxlength'=>'50',
                            'class' => 'form-control text-box single-line',
                            'disabled'=>'disabled');
        echo form_input($attributes, set_value('IdentidadeGeneroOptativa'));
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Raça <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Raca', $attributes);

        $attributes = array(
                            0 => '',
                            1 => 'Não informado',
                            2 => 'Amarela',
                            3 => 'Branca',
                            4 => 'Indígena',
                            5 => 'Parda',
                            6 => 'Preta'
                            );
        if(strstr($erro, "'Raça'")){
                echo form_dropdown('Raca', $attributes, set_value('Raca'), "class=\"form-control is-invalid\" id=\"Raca\"");
        }
        else{
                echo form_dropdown('Raca', $attributes, set_value('Raca'), "class=\"form-control\" id=\"Raca\"");
        }
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('E-mail <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Email', $attributes);

        $attributes = array('name' => 'Email',
                            'id' => 'Email',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'E-mail'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('Email'));
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Telefone <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Telefone', $attributes);

        $attributes = array('name' => 'Telefone',
                            'id' => 'Telefone',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Telefone'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('Telefone'));
        echo "
                                                            </div>
                                                    </div>
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Telefone opcional', 'TelefoneOpcional', $attributes);

        $attributes = array('name' => 'TelefoneOpcional',
                            'id' => 'TelefoneOpcional',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, set_value('TelefoneOpcional'));
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-3\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Data de nascimento <abbr title="Obrigatório" class="text-danger">*</abbr>', 'DataNascimento', $attributes);

        $attributes = array('name' => 'DataNascimento',
                            'id' => 'DataNascimento',
                            'maxlength'=>'15',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, 'Data de nascimento')){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('DataNascimento'));
        echo "
                                                    </div>
                                            </div>
                                            <div class=\"col-md-9\">
                                                    <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('LinkedIn', 'LinkedIn', $attributes);

        $attributes = array('name' => 'LinkedIn',
                            'id' => 'LinkedIn',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line',
                            'placeholder' => 'https://www.linkedin.com/in/');
        echo form_input($attributes, set_value('LinkedIn'));
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-4\">
                                                            <br/>
                                                            <label class=\"control-label font-weight-bold\">
                                                                    País: &nbsp;
                                                            </label>
                                                            <div class=\"btn-group control-label\">
                                                                    <label class=\"\">";
        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'Pais',
                            'value'=>'Brasil');
        echo form_radio($attributes, set_value('Nacionalidade'), (set_value('Nacionalidade')=='Brasil' || strlen(set_value('Nacionalidade'))==0));
        echo " Brasil
                                                                    </label>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                                    <label class=\"\">";
        $attributes = array('name' => 'Nacionalidade',
                            'id' => 'OutroPais',
                            'value'=>'Outro');
        echo form_radio($attributes, set_value('Nacionalidade'), (set_value('Nacionalidade')!='Brasil' && strlen(set_value('Nacionalidade'))>0));
        echo " Exterior
                                                                    </label>
                                                            </div>
                                                    </div>
                                                    <div id=\"div_cidadeestrangeira\" style=\"display:none\">
                                                            <div class=\"form-group\" id=\"div_pais\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('País estrangeiro <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Pais2', $attributes);

        $attributes = array('name' => 'Pais2',
                            'id' => 'Pais2',
                            'maxlength'=>'150',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'País estrangeiro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('Pais2'));
        echo "
                                                            </div>
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Cidade estrangeira <abbr title="Obrigatório" class="text-danger">*</abbr>', 'CidadeEstrangeira', $attributes);

        $attributes = array('name' => 'CidadeEstrangeira',
                            'id' => 'CidadeEstrangeira',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Cidade estrangeira'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('CidadeEstrangeira'));
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-2\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('CEP <abbr title="Obrigatório" class="text-danger">*</abbr>', 'CEP', $attributes);

        $attributes = array('name' => 'CEP',
                            'id' => 'CEP',
                            'maxlength'=>'9',
                            'type'=>'tel',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'CEP'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('CEP'), " onblur=\"pesquisacep(this.value);\"");
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-6\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Logradouro <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Logradouro', $attributes);

        $attributes = array('name' => 'Logradouro',
                            'id' => 'Logradouro',
                            'maxlength'=>'250',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Logradouro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('Logradouro'));
        echo "
                                                    </div>
                                            </div>
                                            <div class=\"col-md-2\">
                                                    <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Número <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Numero', $attributes);

        $attributes = array('name' => 'Numero',
                            'id' => 'Numero',
                            'maxlength'=>'10',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Número'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('Numero'));
        echo "
                                                    </div>
                                            </div>
                                            <div class=\"col-md-4\">
                                                    <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Complemento', 'Complemento', $attributes);

        $attributes = array('name' => 'Complemento',
                            'id' => 'Complemento',
                            'maxlength'=>'10',
                            'class' => 'form-control text-box single-line');
        echo form_input($attributes, set_value('Complemento'));
        echo "
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class=\"row\">
                                                    <div class=\"col-md-6\">
                                                            <div class=\"form-group\">";
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Bairro', 'Bairro', $attributes);

        $attributes = array('name' => 'Bairro',
                            'id' => 'Bairro',
                            'maxlength'=>'150',
                            'class' => 'form-control text-box single-line');
        if(strstr($erro, "'Bairro'")){
                $attributes['class'] = 'form-control text-box single-line is-invalid';
        }
        echo form_input($attributes, set_value('Bairro'));
        echo "
                                                    </div>
                                            </div>
                                            <div class=\"col-md-2\">
                                                    <div class=\"form-group\">";
        $Estados=array(0 => '')+$Estados;
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Estado <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Estado', $attributes);
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
        $attributes = array('class' => 'control-label font-weight-bold');
        echo form_label('Município <abbr title="Obrigatório" class="text-danger">*</abbr>', 'Municipio', $attributes);
        if(strstr($erro, "'Município'")){
                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control is-invalid\" id=\"Municipio\"");
        }
        else{
                echo form_dropdown('Municipio', $Municipios, set_value('Municipio'), "class=\"form-control\" id=\"Municipio\"");
        }
        echo "
                                                            </div>
                                                    </div>
                                            </div>";
        echo "
                                            <input type=\"hidden\" name=\"TransformaMinas\" value=\"0\" />";
        echo "


                                            <div class=\"text-center center-block\">";
        $attributes = array('class' => 'btn btn-primary btn-md btn-inline mt-2 waves-effect waves-light text-center text-uppercase',
                            'style'=>'width:60%');
        echo form_submit('cadastrar', 'Cadastre-se', $attributes);
        echo "
                                            </div>
                                            <hr />
                                            <div class=\"text-center center-block\">
                                                    <a href=\"".base_url('Publico/index')."\" style=\"font-size: 1.3rem;color: #6c7293;display: inline-block;\">Já possui cadastro na plataforma?</a>
                                            </div>
                                    </form>
				</div>
			</div>
		</div>";
        /*echo "

                <script src=\"".base_url('assets_6.0.3/vendors/general/jquery/dist/jquery.js')."\" type=\"text/javascript\"></script>
                <script src=\"".base_url('assets_6.0.3/vendors/general/bootstrap/dist/js/bootstrap.min.js')."\" type=\"text/javascript\"></script>
                <script src=\"".base_url('assets_6.0.3/vendors/general/inputmask/dist/jquery.inputmask.bundle.js')."\" type=\"text/javascript\"></script>";*/

        echo "

                <script type=\"text/javascript\" >
                        ";
		if(set_value('TransformaMinas')=='1'){
                        echo "document.getElementById('div_transformaminas').style.display='block';";
		}
		echo"
                    function limpa_formulário_cep() {
                            //Limpa valores do formulário de cep.
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
                                    //CEP não Encontrado.
                                    limpa_formulário_cep();
                                    alert(\"CEP não encontrado.\");
                            }
                    }

                    function pesquisacep(valor) {

                        //Nova variável \"cep\" somente com dígitos.
                        var cep = valor.replace(/\D/g, '');

                        //Verifica se campo cep possui valor informado.
                        if (cep != '') {

                            //Expressão regular para validar o CEP.
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

                                //Insere script no documento e carrega o conteúdo.
                                document.body.appendChild(script);

                            }
                            else {
                                //cep é inválido.
                                limpa_formulário_cep();
                                alert('Formato de CEP inválido.');
                            }
                        }
                        else {
                            //cep sem valor, limpa formulário.
                            limpa_formulário_cep();
                        }
                    };
                </script>";
        $pagina['js']="
                <script type=\"text/javascript\">
                    $(document).ready(function(){
                            $('#CPF').inputmask('999.999.999-99');
                            $('#DataNascimento').inputmask('99/99/9999');
                            $('#CEP').inputmask('99999-999');
                            $('#Telefone').inputmask('(99)99999-9999');
                            $('#TelefoneOpcional').inputmask('(99)99999-9999');

                            $('#OutroPais').click(function(){
                                    $('#div_cidadeestrangeira').show();
                            });
                            $('#Pais').click(function(){
                                    $('#div_cidadeestrangeira').hide();
                            });


                            ";
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
}
$this -> load -> view('publicoRodape',$pagina);
?>