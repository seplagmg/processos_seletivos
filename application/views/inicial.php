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
                                                                        <h4 style=\"font-weight:700\"><i class=\"$icone\" style=\"font-weight:600\"></i> &nbsp; {$nome_pagina}</h4>
                                                                    </div>
                                                            </div>
                                                            <div class=\"col-lg-12\">
                                                                <!-- Default card start -->
                                                                <div class=\"card\">
                                                                    <div class=\"card-block\">
                                                                        <h5 class=\"mb-3\" style=\"font-weight:700;\">Bem vindo ao Sistema ".$this -> config -> item('nome')."</h5>
                                                                        Verifique se o seu nome completo est?? correto: <span class=\"alert-info\"><b>".$this -> session -> nome."</b></span>.<br/>
                                                                        Data e hora atual do sistema: <span class=\"alert-info\"><b>".date('d/m/Y - H:i:s')."</b></span>.<br/><br/>
                                                                        Caso haja algum problema com as verifica????es acima, saia do sistema e informe os respons??veis pelo sistema por meio do fale conosco (link na p??gina de login).<br/><br/>
                                                                        Se os dados acima estiverem corretos, utilize o menu ao lado para iniciar suas atividades.";

if($this -> session -> perfil == 'candidato'){
                                                                    echo "<br/><br/>Acesse o <a class=\"alert-info\" href=\"https://ati-seplag.gitbook.io/processos-seletivos-candidatos/\" target=\"_blank\" style=\"font-size:15px; text-decoration:underline\"><b>manual do candidato</b></a> para mais informa????es sobre sistema.";
} else {
                                                                    echo "<br/><br/>Caro ".$this -> session -> perfil.", para instru????es sobre o uso do sistema acesse o <a class=\"alert-info\" href=\"https://ati-seplag.gitbook.io/processos-seletivos-gestores-e-avaliadores/\" target=\"_blank\" style=\"font-size:15px; text-decoration:underline\"><b>manual dos usu??rios gestores</b></a> para mais informa????es sobre sistema.";
}


                                                                   echo "<h5 class=\"my-3\" style=\"font-weight:700;\">Avisos!</h5>
                                                                        <span class=\"my-3\" style=\"line-height:1.8em;\">
                                                                        1) Voc?? est?? acessando um sistema governamental, de responsabilidade do Governo do Estado de Minas Gerais, que dever?? ser utilizado de acordo com a legisla????o vigente.<br/>
                                                                        2) A utiliza????o do sistema ?? monitorada constantemente, sendo que para entrar voc?? deve concordar em ceder dados de uso e informa????es pessoais que podem ficar registradas para aplica????es legais.<br/>
                                                                        3) O uso n??o autorizado do sistema ?? proibido.</span>

";
if($this -> session -> perfil == 'candidato'){ //candidato
        echo "

                                                                    </div>
                                                                </div>";
/*
echo "                                                                                        <div id=\"dialog\" class=\"modal fade\" tabindex=\"-1\" aria-hidden=\"true\">
                                                                                                <div class=\"modal-dialog modal-lg\" style=\"margin:80px auto;\">
                                                                                                        <div class=\"modal-content\">
                                                                                                                        <div class=\"modal-header\">
                                                                                                                                        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\"></button>
                                                                                                                                        <h4 class=\"modal-title bolder\">Avisos</h4>
                                                                                                                        </div>
                                                                                                                        <div class=\"modal-body\">
                                                                                                                                        <fieldset>
                                                                                                                                                        <legend>Candidaturas pendentes</legend>
                                                                                                                                                        <p>Prezado candidato(a)</p>
                                                                                                                                                        <p>Caso tenha candidaturas pendentes, complete os dados e conclua que sua candidatura seja v??lida.</p>
                                                                                                                                        </fieldset>
                                                                                                                        </div>
                                                                                                                        <div class=\"modal-footer\">
                                                                                                                                        <button type=\"button\" data-dismiss=\"modal\" class=\"btn default\">Fechar</button>
                                                                                                                        </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                        ";
 */
}
echo "
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
$pagina['js'] = "
						<script type=\"text/javascript\">

						  $( function() {

							 $(\"#dialog\").modal('toggle');
						  } );
						</script>
";

$this -> load -> view('internaRodape', $pagina);
?>