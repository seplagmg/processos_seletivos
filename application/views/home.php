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
                <div class=\"container\">
                    <div class=\"row\">
                        <div class=\"col-sm-12\">";

                            $attributes = array('class' => 'md-float-material form-material');
                            echo form_open($url, $attributes);

echo "                          <div class=\"text-center\">
                                    <img src=\"".base_url('images/logo.png')."\" alt=\"".$this -> config -> item('nome')."\" style=\"width:650px; height:200px; text-align:center;\"/>
                                </div>
                                <div class=\"row\">
";


if($menu2 == 'index' || $menu2 == 'recuperar'){
echo "                                    <div class=\"mx-auto mt-3 px-5 py-4\" style=\"min-width:620px; max-width:720px; min-height:350px;\">";
    if(strlen($erro)>0){
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



    echo "                                  <h2 class=\"text-center font-weight-bold mb-3\">{$nome_pagina}</h2>";
    if ($menu2 == 'recuperar') {
        echo "                              <div class=\"alert background-danger\">
                                                <h4>Atenção!</h4>
                                                <p>Caso já tenha solicitado a recuperação de senha recentemente, verifique sua caixa de spam e procure pelo remetente <b><i>nao.responda@planejamento.mg.gov.br</i></b>.</p>
                                                <p>Se ainda sim não recebeu seu e-mail, entre em contato pelo <a class=\"alert-info background-danger\" href=\"".base_url('/Publico/contato')."\" target=\"_blank\" style=\"text-decoration:underline\"><b>fale conosco</b></a>.</p>
                                                <p>Para mais orientações, acesse o <a class=\"alert-info background-danger\" href=\"https://ati-seplag.gitbook.io/processos-seletivos-candidatos/\" target=\"_blank\" style=\"text-decoration:underline\"><b>manual do candidato</b></a><p>
                                            </div>";

                                            $attributes = array('class' => 'control-label');
                                            echo form_label('Digite seu CPF:', "cpf", $attributes);
    }


                                            $attributes = array('name' => 'cpf',
                                                                'id' => 'cpf',
								                                'type' => 'tel',
                                                                'maxlength'=>'14',
                                                                'class' => 'form-control',
                                                                'style' => 'height: calc(2.5em + .75rem + 2px)',
                                                                'autocomplete'=>'off',
                                                                'placeholder'=>'CPF');
                                            if(strstr($erro, 'CPF')){
                                                    $attributes['class'] = 'form-control is-invalid';
                                            }
                                            echo form_input($attributes, set_value('cpf'));
                                            echo "
                                            <span class=\"form-bar\"></span>
";
}

if($menu2 == 'index'){

                                            $attributes = array('name' => 'senha',
                                                                'id' => 'senha',
                                                                'class' => 'form-control mt-4',
                                                                'style' => 'height: calc(2.5em + .75rem + 2px)',
                                                                'value'=>'',
                                                                'placeholder'=>'Senha');
                                            echo form_password($attributes);
                                            echo "
                                            <span class=\"form-bar\"><input type=\"checkbox\" onclick=\"mostrarSenha()\" style=\"padding-left:10px; margin-top:10px; text-align:center;\"> Mostrar senha </span>";

                                            $attributes = array('class' => 'btn btn-md btn-inline mt-4 efeitoa text-center text-uppercase',
                                                                'style'=>'width:100%; background:#6AA1CA; color:white; font-weight:600;');
                                            echo form_submit('logar_sistema', 'Entrar', $attributes);
                                            echo "

                                            <button type=\"button\" name=\"cadastrar\" class=\"btn btn-md mt-4 text-center text-uppercase btn-dark\" style=\"width:100%\" onclick=\"window.location='".base_url('/Candidatos/cadastro')."'\">Cadastrar</button>

                                            <hr class=\"mb-3 mt-4\">
                                            <a href=\"".base_url('Publico/recuperar')."\" class=\"btn btn-md w-100 efeitob\" style=\"font-size:1.2em;\">Esqueceu sua senha?</a>
                                            <a href=\"".base_url('Publico/contato')."\" class=\"btn btn-md w-100 efeitob\" style=\"font-size:1.2em;\">Fale conosco</a>
                                            ";
}
else if($menu2 == 'contato'){
        echo "                          <div class=\"mx-auto mt-3 px-5 py-4\" style=\"min-width:620px; min-height:350px;\">";

        if(strlen($erro)>0){
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

        echo "                                  <h2 class=\"text-center font-weight-bold pb-3\">{$nome_pagina}</h2>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'nome',
                            'id' => 'nome',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'style' => 'height: calc(2.5em + .75rem + 2px)',
                            'placeholder'=>'Nome completo');
        if(strstr($erro, "'Nome completo'")){
                $attributes['class'].=' is-invalid';
        }
        echo form_input($attributes, set_value('nome'));
        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'email',
                            'id' => 'email',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'style' => 'height: calc(2.5em + .75rem + 2px)',
                            'placeholder'=>'E-mail');
        if(strstr($erro, "'E-mail'")){
                $attributes['class'].=' is-invalid';
        }
        echo form_input($attributes, set_value('email'));
        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        //'seplag'=>"Edital 01/2020 SEPLAG/SEINFRA/SEE/SEDE",
        //,'sedese'=>"Edital 01/2020 SEDESE","meioambiente"=>"Edital 01/2020 SEMAD/FEAM/IEF/IGAM","agricultura"=>"SEAPA/IMA","epamig"=>"EPAMIG","saude"=>"SAÚDE","funed"=>"FUNED","secult"=>"SECULT/IEPHA"
        $destinatario = array(''=>"Destinatário");
        if(isset($editais)){
            foreach($editais as $edital){
                $destinatario[$edital -> pr_edital] = $edital -> vc_edital;
            }
        }

        if(strstr($erro, "'Destinatário'")){

                echo form_dropdown('destinatario', $destinatario, set_value('destinatario'), "class=\"form-control is-invalid\" id=\"destinatario\"");
        }
        else{
                echo form_dropdown('destinatario', $destinatario, set_value('destinatario'), "class=\"form-control\" id=\"destinatario\"");
        }

        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'assunto',
                            'id' => 'assunto',
                            'maxlength'=>'100',
                            'class' => 'form-control',
                            'style' => 'height: calc(2.5em + .75rem + 2px)',
                            'placeholder'=>'Assunto');
        if(strstr($erro, "'Assunto'")){
                $attributes['class'].=' is-invalid';
        }
        echo form_input($attributes, set_value('assunto'));
        echo "
                                            </div>
                                            <div class=\"form-group form-primary\">
                                                                                ";
        $attributes = array('name' => 'msg',
                            'id' => 'msg',
                            'rows'=>'3',
                            'class' => 'form-control',
                            'style' => 'height: calc(10.0em + .75rem + 2px)',
                            'placeholder' => 'Mensagem');
        if(strstr($erro, "'Mensagem'")){
                $attributes['class'].=' is-invalid';
        }
        echo form_textarea($attributes, set_value('msg'));
        echo "
                                            </div>";
                                            $attributes = array('class' => 'btn btn-md btn-inline mt-3 text-center text-uppercase',
                                                                'style'=>'width:100%; background:#6AA1CA; color:white; font-weight:600; ');
                                            echo form_submit('enviado', 'Enviar', $attributes);
                                            echo "
                                            <hr class=\"mY-3\">
                                            <a href=\"".base_url('Publico/index')."\" class=\"btn btn-md btn-dark w-100\">LOGIN</a>";
}
else if($menu2 == 'recuperar'){
                                            $attributes = array('class' => 'btn btn-md btn-inline mt-4 text-center text-uppercase',
                                                                'style'=>'width:100%; background:#6AA1CA; color:white; font-weight:600; ');
                                            echo form_submit('enviado', 'Recuperar', $attributes);
                                            echo "
                                            <hr class=\"mb-3 mt-4\">
                                            <a href=\"".base_url('Publico/index')."\" class=\"btn btn-md btn-dark w-100\">LOGIN</a>

";
}

echo "                              </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"column mx-auto mt-3\"\">
                                            <span style=\"font-size:1.1em;\">SUGESP - SEPLAG © Layout Adminty</span>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </section>
            <!--[if lt IE 10]>
                <div class=\"ie-warning\">
                    <h1>Alerta!!</h1>
                    <p>Você está usando uma versão desatualizada de um navegador não suportado. Favor fazer o download de algum dos navegadores abaixo.</p>
                    <div class=\"iew-container\">
                        <ul class=\"iew-download\">
                            <li>
                                <a href=\"http://www.google.com/chrome/\">
                                    <img src=\"".base_url('assets/images/browser/chrome.png')."\" alt=\"Chrome\">
                                    <div>Chrome</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"https://www.mozilla.org/en-US/firefox/new/\">
                                    <img src=\"".base_url('assets/images/browser/firefox.png')."\" alt=\"Firefox\">
                                    <div>Firefox</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"http://www.opera.com\">
                                    <img src=\"".base_url('assets/images/browser/opera.png')."\" alt=\"Opera\">
                                    <div>Opera</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"https://www.apple.com/safari/\">
                                    <img src=\"".base_url('assets/images/browser/safari.png')."\" alt=\"Safari\">
                                    <div>Safari</div>
                                </a>
                            </li>
                            <li>
                                <a href=\"http://windows.microsoft.com/en-us/internet-explorer/download-ie\">
                                    <img src=\"".base_url('assets/images/browser/ie.png')."\" alt=\"\">
                                    <div>IE (9 & above)</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <p>Nos desculpe pela inconveniência!</p>
                </div>
            <![endif]-->";
$pagina['js']="
                <script type=\"text/javascript\">
                    $(document).ready(function(){
                            $('#cpf').inputmask('999.999.999-99');
                    });
					function mostrarSenha(){
							var x = document.getElementById(\"senha\");
							  if (x.type === \"password\") {
								x.type = \"text\";
							  } else {
								x.type = \"password\";
							  }
					}

                </script>";


$this -> load -> view('publicoRodape', $pagina);
?>