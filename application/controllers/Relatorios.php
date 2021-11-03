<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {
        function __construct() {
                parent::__construct();
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Vagas_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> helper('date');
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
                else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
        }
        public function index(){
                $pagina['menu1']='Relatorios';
                $pagina['menu2']='index';
                $pagina['url']='Relatorios/index';
                $pagina['nome_pagina']='Relatorios';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                $this -> load -> view('relatorios', $dados);
        }
        public function DocumentosObrigatorios(){
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $pagina['menu1']='Relatorios';
                $pagina['menu2']='DocumentosObrigatorios';
                $pagina['url']='Relatorios/DocumentosObrigatorios';

                if(!isset($_POST["vaga"])){
                        $pagina['nome_pagina']='Relatorios';
                }
                else{
                        $vaga = $_POST['vaga'];
                        $vagas = $this ->Vagas_model -> get_vagas ($vaga);
                        $pagina['nome_pagina']='Relatorios - '.$vagas[0] -> vc_vaga;
                }
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;

                $dados['adicionais'] = array('datatables' => true);
                if(!isset($_POST["vaga"])){
                        $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true);
                }
                else{
                        $vaga = $_POST['vaga'];
                        $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
                        $dados['vaga'] = $this ->Vagas_model -> get_vagas ($vaga);
                        $questoes1 = $this -> Questoes_model -> get_questoes('', $dados['vaga'][0] -> es_grupoVaga, 1);
                        $dados['questoes'] = $questoes1;
                        $questoes2 = $this -> Questoes_model -> get_questoes('', $dados['vaga'][0] -> es_grupoVaga, 2);
                        if(isset($questoes2)){
                                $dados['questoes'] = array_merge($questoes1,$questoes2);
                        }
                        if(isset($dados['candidaturas']) && isset($dados['questoes'])){
                                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '','1');

                                $respostas2 = $this -> Questoes_model -> get_respostas('', '', '', '','2');
                                if(isset($respostas2)){
                                        $respostas = $respostas + $respostas2;
                                }
                                foreach($respostas as $resposta){
                                        $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                                }
                                foreach($dados['candidaturas'] as $candidatura){
                                        $dados['candidato'][$candidatura -> pr_candidatura] = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                        foreach($dados['questoes'] as $questao){
                                                if($questao -> in_tipo == '7'){
                                                        $dados['anexos'][$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('','', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
                                                }
                                        }
                                }
                        }
                }
                $this -> load -> view('relatorios', $dados);
        }
        public function csv_DocumentosObrigatorios($vaga){
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');
                $this -> load -> library('csvmodel');

                $candidaturas = $this -> Candidaturas_model -> get_candidaturas ('', '', $vaga, '', '');//7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21
                $vagas = $this ->Vagas_model -> get_vagas ($vaga);
                $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 1);
                $questoes2 = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 2);
                if(isset($questoes2)){
                        $questoes = array_merge($questoes,$questoes2);
                }

                $campos=array('nome','cpf','documento','idade','status','inicio','ultima');

                if(isset($questoes)){
                        foreach ($questoes as $questao){
                                $campos[] = 'campo'.$questao->pr_questao;
                                /*echo "
                                                                                                                                                        <th>{$questao -> tx_questao}</th>
                                ";*/
                        }
                }

                $this->csvmodel->setCampos($campos);

                $cabecalho = array('nome'=>'Nome do candidato','cpf'=>'CPF','documento'=>utf8_decode('Documento de identificação'),'idade'=>"Idade",'status'=>'Status','inicio'=>utf8_decode("Data de início"),'ultima'=>utf8_decode("Data de última alteração"));
                if(isset($questoes)){
                        foreach ($questoes as $questao){
                                $cabecalho['campo'.$questao->pr_questao] = utf8_decode($questao -> tx_questao);
                        }
                }
                $this->csvmodel->escreveCache($cabecalho);



                if(isset($candidaturas) && isset($questoes)){
                        $respostas = $this -> Questoes_model -> get_respostas('', '', '', '','1');
                        $respostas_et_2 = $this -> Questoes_model -> get_respostas('', '', '', '','2');
                        if(isset($respostas_et_2)){
                                $respostas = $respostas + $respostas_et_2;
                        }
                        $respostas2 = array();
                        foreach($respostas as $resposta){
                                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                        }
                        foreach($candidaturas as $candidatura){
                                $candidato[$candidatura -> pr_candidatura] = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                if(isset($candidato[$candidatura -> pr_candidatura])){
                                        $dataNascimento = $candidato[$candidatura -> pr_candidatura]-> dt_nascimento;
                                        $date = new DateTime($dataNascimento );
                                        $interval = $date->diff( new DateTime( date('Y-m-d') ) );

                                        $conteudo = array('nome'=>utf8_decode($candidato[$candidatura -> pr_candidatura]  -> vc_nome),'cpf'=>$candidato[$candidatura -> pr_candidatura]  -> ch_cpf,'documento'=>$candidato[$candidatura -> pr_candidatura] -> vc_rg,'idade'=>$interval->format( '%Y anos' ),'status'=>utf8_decode($candidatura -> vc_status),'inicio'=>show_date($candidatura -> dt_cadastro,true),'ultima'=>show_date($candidatura -> dt_candidatura,true));

                                        foreach($questoes as $questao){
                                                if($questao -> in_tipo == '7'){
                                                        $anexos[$candidatura -> pr_candidatura][$questao -> pr_questao] = $this -> Anexos_model -> get_anexo('','', $candidatura -> pr_candidatura, '', '', $questao -> pr_questao);
                                                        if(isset($anexos[$candidatura -> pr_candidatura][$questao -> pr_questao])){
                                                                $conteudo['campo'.$questao->pr_questao] = "Inserido";
                                                        }
                                                        else{
                                                                $conteudo['campo'.$questao->pr_questao] = utf8_decode("Não inserido");
                                                        }
                                                }
                                                else if($questao -> in_tipo == '3'){
                                                        $array_resposta = array(""=>"","0"=>utf8_decode("Não"),"1"=>"Sim");

                                                        $conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
                                                }
                                                else if($questao -> in_tipo == '4'){
                                                        $array_resposta = array(""=>"","0"=>"Sim","1"=>utf8_decode("Não"));

                                                        $conteudo['campo'.$questao->pr_questao] = @$array_resposta[$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta];
                                                }
                                        }
                                        $this->csvmodel->escreveCache($conteudo);
                                }
                        }
                }
                $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_DocumentosObrigatorios', "CSV de documentos obrigatórios da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
                $this->csvmodel->printCache('documentos_obrigatorios.csv');

        }
        public function AvaliacaoCurricular(){
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='Relatorios';
                $pagina['menu2']='AvaliacaoCurricular';
                $pagina['url']='Relatorios/AvaliacaoCurricular';
                $pagina['nome_pagina']='Resultados da Avaliação Curricular';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                $dados['adicionais'] = array('datatables' => true);

                if(!isset($_POST["vaga"])){
                        $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true,'7, 8, 9, 10, 11, 15, 18, 19, 20, 21');
                }
                else{
                        $vaga = $_POST["vaga"];
                        //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
                        $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

                        //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 15, 18, 19, 20, 21');
                        $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 3);

                        //var_dump($candidaturas);
                        $dados['candidaturas'] = array();
                        if($candidaturas){
                                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '','3');
                                foreach($respostas as $resposta){
                                        $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                                }
                                foreach($dados['questoes'] as $questao){
                                        $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                                }
                                foreach($candidaturas as $candidatura){
                                        //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                                        $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                                        if(isset($candidatos)){
                                                //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                                                $candidatura -> vc_email = $candidatos -> vc_email;
                                                $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                                                $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;

                                                $dados['candidaturas'][] = $candidatura;
                                        }
                                }
                        }
                }
                //$dados['competencias'] = $this -> Questoes_model -> get_competencias();

                //var_dump($dados['candidaturas']);

                $this -> load -> view('relatorios', $dados);
        }

        public function csv_AvaliacaoCurricular($vaga){
                $this -> load -> model('Questoes_model');
                $this -> load -> library('csvmodel');

                $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 15, 18, 19, 20, 21');
                $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 3);

                $campos=array('nome','email','cpf','idade','documento','status');

                if(isset($questoes)){
                        foreach ($questoes as $questao){
                                $campos[] = 'campo'.$questao->pr_questao;
                        }
                }
                $campos[]='total';
                $this->csvmodel->setCampos($campos);

                $cabecalho = array('nome'=>'Nome do candidato','email'=>'E-mail','cpf'=>'CPF','idade'=>'Idade','documento'=>utf8_decode('Documento de identificação'),'status'=>'Status');
                if(isset($questoes)){
                        foreach ($questoes as $questao){
                                $cabecalho['campo'.$questao->pr_questao] = utf8_decode($questao -> tx_questao);
                        }
                }
                $cabecalho['total'] = utf8_decode("Nota da Avaliação Curricular");
                $this->csvmodel->escreveCache($cabecalho);

                if($candidaturas){
                        $respostas = $this -> Questoes_model -> get_respostas('', '', '', '','3');
                        foreach($respostas as $resposta){
                                $respostas2[$resposta -> es_candidatura][$resposta -> es_questao] = $resposta;
                        }

                        foreach($questoes as $questao){
                                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                        }

                        foreach($candidaturas as $candidatura){
                                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                                $candidato[$candidatura -> pr_candidatura] = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                                if(isset($candidato)){
                                        $dataNascimento = $candidato[$candidatura -> pr_candidatura] -> dt_nascimento;
                                        $date = new DateTime($dataNascimento );
                                        $interval = $date->diff( new DateTime( date('Y-m-d') ) );

                                        $conteudo = array('nome'=>utf8_decode($candidato[$candidatura -> pr_candidatura]  -> vc_nome),'email'=>utf8_decode($candidato[$candidatura -> pr_candidatura]  -> vc_email),'cpf'=>$candidato[$candidatura -> pr_candidatura]  -> ch_cpf,'idade'=>$interval->format( '%Y anos' ),'documento'=>$candidato[$candidatura -> pr_candidatura] -> vc_rg,'status'=>utf8_decode($candidatura -> vc_status));
                                        $total = 0;
                                        foreach($questoes as $questao){
                                                if($questao -> in_tipo == '1'){
                                                        $nota = 0;
                                                        foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                                if(@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                        //echo $opcao->in_valor;
                                                                        $nota += intval($opcao->in_valor);
                                                                }
                                                        }
                                                        $conteudo['campo'.$questao->pr_questao] = $nota;
                                                        $total+=$nota;
                                                }
                                                else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                                        $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                        $total+=@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                }
                                                else if($questao -> in_tipo == '5'){
                                                        $nota = 0;
                                                        $nota = round((@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                                        /*if(@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)>=1 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
                                                                        $nota += intval($row->in_peso);
                                                        }
                                                        else if(@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)>=2 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
                                                                        $nota += intval($row->in_peso);
                                                        }
                                                        else if(@intval($respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta)>=3 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                                                        $nota += intval($row->in_peso);
                                                        }*/
                                                        $conteudo['campo'.$questao->pr_questao] = $nota;
                                                        $total+=$nota;
                                                }
                                                else if($questao -> in_tipo == '6'){
                                                        $conteudo['campo'.$questao->pr_questao] = @$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta;
                                                        $total+=@$respostas2[$candidatura -> pr_candidatura][$questao -> pr_questao] -> tx_resposta;
                                                        //$total+=@intval($respostas[$linha -> pr_candidatura][$questao -> pr_questao] -> tx_resposta);
                                                }
                                                else{
                                                        $conteudo['campo'.$questao->pr_questao] = "Campo sem nota";
                                                }

                                        }
                                        $conteudo['total'] = $total;
                                        $this->csvmodel->escreveCache($conteudo);
                                }
                        }
                }
                $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_AvaliacaoCurricular', "CSV de avaliação curricular da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
                $this->csvmodel->printCache('avaliacao_curricular.csv');
        }

        public function AvaliacaoCompetencia(){
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='Relatorios';
                $pagina['menu2']='AvaliacaoCompetencia';
                $pagina['url']='Relatorios/AvaliacaoCompetencia';
                $pagina['nome_pagina']='Resultados da Avaliação por competência';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                $dados['adicionais'] = array('datatables' => true);

                if(!isset($_POST["vaga"])){
                        $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true,'10,11,15,18,19');
                        //$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '10,11,18,19');
                }
                else{
                        $vaga = $_POST["vaga"];
                        //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
                        $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

                        //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '10, 11,15, 18, 19');
                        $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $dados['vagas'][0] -> es_grupoVaga, 4,'', true, '<>2');

                        //var_dump($candidaturas);
                        $dados['candidaturas'] = array();
                        if($candidaturas){
                                $respostas = $this -> Questoes_model -> get_respostas('', '', '', '','4');
                                foreach($respostas as $resposta){
                                        if(strlen($resposta -> es_avaliador)>0){
                                                $dados['respostas'][$resposta -> es_candidatura][$resposta -> es_avaliador][$resposta -> es_questao] = $resposta;
                                        }
                                }
                                foreach($dados['questoes'] as $questao){
                                        $dados['opcoes'][$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                                }
                                foreach($candidaturas as $candidatura){
                                        //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                                        $entrevistas = $this -> Candidaturas_model -> get_entrevistas('',$candidatura -> pr_candidatura,'competencia');

                                        foreach($entrevistas as $entrevista){
                                                $dados["entrevista"][$candidatura -> pr_candidatura] = $entrevista;
                                        }

                                        $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                                        if(isset($candidatos)){
                                                //$candidatura -> vc_nome = $candidatos[0] -> vc_nome;
                                                $candidatura -> vc_email = $candidatos -> vc_email;
                                                $candidatura -> ch_cpf = $candidatos -> ch_cpf;
                                                $candidatura -> dt_nascimento = $candidatos -> dt_nascimento;
                                                /*if(isset($notas)){

                                                                foreach($notas as $nota){
                                                                                $candidatura -> in_nota3 = $nota -> in_nota;


                                                                }
                                                }
                                                else{
                                                                $candidatura -> in_nota3 = "0";
                                                }*/

                                                $dados['candidaturas'][] = $candidatura;
                                        }
                                }
                        }
                }
                //$dados['competencias'] = $this -> Questoes_model -> get_competencias();

                //var_dump($dados['candidaturas']);

                $this -> load -> view('relatorios', $dados);
        }

        public function csv_AvaliacaoCompetencia($vaga){
                $this -> load -> library('csvmodel');
                $this -> load -> model('Questoes_model');

                $vagas = $this -> Vagas_model -> get_vagas($vaga, false, 'object');

                //$dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas('', '', $dados_vaga[0] -> pr_vaga, '');
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '10, 11, 15, 18, 19');
                $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, 4,'', true, '<>2');

                $campos=array('nome','email','cpf','status','idade','avaliador');

                if(isset($questoes)){
                        foreach ($questoes as $questao){
                                $campos[] = 'campo'.$questao->pr_questao;
                        }
                }
                $campos[]='total';
                $this->csvmodel->setCampos($campos);

                $cabecalho = array('nome'=>'Nome do candidato','email'=>'E-mail','cpf'=>'CPF','idade'=>'Idade','status'=>'Status','avaliador'=>'Avaliador');
                if(isset($questoes)){
                        foreach ($questoes as $questao){
                                $cabecalho['campo'.$questao->pr_questao] = utf8_decode($questao -> tx_questao);
                        }
                }
                $cabecalho['total'] = utf8_decode("Nota da Avaliação por Competência");
                $this->csvmodel->escreveCache($cabecalho);

                if(isset($candidaturas) && isset($questoes)){
                        $respostas = $this -> Questoes_model -> get_respostas('', '', '', '','4');
                        foreach($respostas as $resposta){
                                if(strlen($resposta -> es_avaliador)>0){
                                        $respostas2[$resposta -> es_candidatura][$resposta -> es_avaliador][$resposta -> es_questao] = $resposta;
                                }

                        }

                        foreach($questoes as $questao){
                                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                        }

                        foreach($candidaturas as $candidatura){
                                //$notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '3');
                                $entrevistas = $this -> Candidaturas_model -> get_entrevistas('',$candidatura -> pr_candidatura,'competencia');

                                foreach($entrevistas as $entrevista){
                                        $entrevista2[$candidatura -> pr_candidatura] = $entrevista;
                                }

                                $candidatos = $this -> Candidatos_model -> get_candidatos($candidatura -> es_candidato);
                                if($candidatos){
                                        if(strlen($candidatura -> es_avaliador_competencia1) > 0){
                                                $dataNascimento = $candidatos -> dt_nascimento;
                                                $date = new DateTime($dataNascimento );
                                                $interval = $date->diff( new DateTime( date('Y-m-d') ) );
                                                $total = 0;
                                                $conteudo = array('nome'=>utf8_decode($candidatos  -> vc_nome),'email'=>$candidatos -> vc_email,'cpf'=>$candidatos  -> ch_cpf,'idade'=>$interval->format( '%Y anos' ),'status'=>utf8_decode($candidatura -> vc_status));
                                                if($candidatura -> es_avaliador_competencia1 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador1){
                                                        $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome1;
                                                }
                                                else if($candidatura -> es_avaliador_competencia1 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador2){
                                                        $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome2;
                                                }
                                                else if($candidatura -> es_avaliador_competencia1 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador3){
                                                        $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome3;
                                                }

                                                foreach ($questoes as $questao){
                                                        if($candidatura -> es_status == 15){
                                                                $conteudo['campo'.$questao->pr_questao] = '-';
                                                        }
                                                        else if($questao -> in_tipo == '1'){
                                                                $nota = 0;
                                                                foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                                        if(@$respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$candidatura -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                                //echo $opcao->in_valor;
                                                                                $nota += intval($opcao->in_valor);
                                                                        }
                                                                }
                                                                $conteudo['campo'.$questao->pr_questao] = $nota;
                                                                $total+=$nota;
                                                        }
                                                        else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                                                $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);

                                                                $total+=@intval($respostas[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                        }
                                                        else if($questao -> in_tipo == '5'){
                                                                $nota = 0;
                                                                $nota = round((@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                                                /*if(@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta)>=1 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
                                                                                $nota += intval($questao->in_peso);
                                                                }
                                                                else if(@intval($respostas2[$linha -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta)>=2 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
                                                                                $nota += intval($questao->in_peso);
                                                                }
                                                                else if(@intval($respostas2[$linha -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta)>=3 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                                                                $nota += intval($questao->in_peso);
                                                                }*/
                                                                $conteudo['campo'.$questao->pr_questao] = $nota;
                                                                $total+=$nota;
                                                        }
                                                        else if($questao -> in_tipo == '6'){
                                                                $conteudo['campo'.$questao->pr_questao] = @$respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta;
                                                                $total+=@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta);
                                                        }
                                                }
                                                $conteudo['total'] = $total;
                                                $this->csvmodel->escreveCache($conteudo);
                                        }

                                        if(strlen($candidatura -> es_avaliador_competencia2) > 0 && $candidatura -> es_status != 15){
                                                $total = 0;
                                                $dataNascimento = $candidatos -> dt_nascimento;
                                                $date = new DateTime($dataNascimento );
                                                $interval = $date->diff( new DateTime( date('Y-m-d') ) );
                                                $conteudo = array('nome'=>utf8_decode($candidatos  -> vc_nome),'email'=>$candidatos -> vc_email,'cpf'=>$candidatos  -> ch_cpf,'idade'=>$interval->format( '%Y anos' ),'status'=>utf8_decode($candidatura -> vc_status));
                                                if($candidatura -> es_avaliador_competencia2 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador1){
                                                        $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome1;
                                                }
                                                else if($candidatura -> es_avaliador_competencia2 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador2){
                                                        $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome2;
                                                }
                                                else if($candidatura -> es_avaliador_competencia2 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador3){
                                                        $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome3;
                                                }

                                                foreach ($questoes as $questao){
                                                        if($questao -> in_tipo == '1'){
                                                                $nota = 0;
                                                                foreach($opcoes[$questao -> pr_questao] as $opcao){

                                                                                if(@$respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$candidatura -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                                                //echo $opcao->in_valor;
                                                                                                $nota += intval($opcao->in_valor);
                                                                                }

                                                                }
                                                                $conteudo['campo'.$questao->pr_questao] = $nota;
                                                                $total+=$nota;
                                                        }
                                                        else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                                                $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);

                                                                $total+=@intval($respostas[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                        }
                                                        else if($questao -> in_tipo == '5'){
                                                                $nota = 0;
                                                                /*if(@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta)>=1 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
                                                                                $nota += intval($questao->in_peso);
                                                                }
                                                                else if(@intval($respostas2[$linha -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta)>=2 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
                                                                                $nota += intval($questao->in_peso);
                                                                }
                                                                else if(@intval($respostas2[$linha -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta)>=3 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                                                                $nota += intval($questao->in_peso);
                                                                }*/
                                                                $nota = round((@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                                                $conteudo['campo'.$questao->pr_questao] = $nota;
                                                                $total+=$nota;
                                                        }
                                                        else if($questao -> in_tipo == '6'){
                                                                $conteudo['campo'.$questao->pr_questao] = @$respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta;
                                                                $total+=@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta);
                                                        }
                                                }
                                                $conteudo['total'] = $total;
                                                $this->csvmodel->escreveCache($conteudo);
                                        }

                                        if(strlen($candidatura -> es_avaliador_competencia3) > 0 && $candidatura -> es_status != 15){
                                                $total = 0;
                                                $dataNascimento = $candidatos -> dt_nascimento;
                                                $date = new DateTime($dataNascimento );
                                                $interval = $date->diff( new DateTime( date('Y-m-d') ) );
                                                $conteudo = array('nome'=>utf8_decode($candidatos  -> vc_nome),'email'=>$candidatos -> vc_email,'cpf'=>$candidatos  -> ch_cpf,'idade'=>$interval->format( '%Y anos' ),'status'=>utf8_decode($candidatura -> vc_status));
                                                if($candidatura -> es_avaliador_competencia3 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador1){
                                                                $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome1;
                                                }
                                                else if($candidatura -> es_avaliador_competencia3 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador2){
                                                                $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome2;
                                                }
                                                else if($candidatura -> es_avaliador_competencia3 == $entrevista2[$candidatura -> pr_candidatura]->es_avaliador3){
                                                                $conteudo['avaliador'] = $entrevista2[$candidatura -> pr_candidatura] -> nome3;
                                                }

                                                foreach ($questoes as $questao){
                                                        if($questao -> in_tipo == '1'){
                                                                $nota = 0;
                                                                foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                                        if(@$respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$candidatura -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                                        //echo $opcao->in_valor;
                                                                                        $nota += intval($opcao->in_valor);
                                                                        }
                                                                }
                                                                $conteudo['campo'.$questao->pr_questao] = $nota;
                                                                $total+=$nota;
                                                        }
                                                        else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                                                $conteudo['campo'.$questao->pr_questao] = @intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);

                                                                $total+=@intval($respostas[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                        }
                                                        else if($questao -> in_tipo == '5'){
                                                                $nota = 0;
                                                                /*if(@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta)>=1 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
                                                                                $nota += intval($questao->in_peso);
                                                                }
                                                                else if(@intval($respostas2[$linha -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta)>=2 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
                                                                                $nota += intval($questao->in_peso);
                                                                }
                                                                else if(@intval($respostas2[$linha -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta)>=3 && mb_convert_case($questao -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                                                                $nota += intval($questao->in_peso);
                                                                }*/
                                                                $nota = round((@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                                                $conteudo['campo'.$questao->pr_questao] = $nota;
                                                                $total+=$nota;
                                                        }
                                                        else if($questao -> in_tipo == '6'){
                                                                $conteudo['campo'.$questao->pr_questao] = @$respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta;
                                                                $total+=@intval($respostas2[$candidatura -> pr_candidatura][$candidatura -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta);
                                                        }
                                                }
                                                $conteudo['total'] = $total;
                                                $this->csvmodel->escreveCache($conteudo);
                                        }
                                }
                        }
                }
                $this -> Usuarios_model -> log('sucesso', 'Relatorios/csv_AvaliacaoCompetencia', "CSV de avaliação por competência da vaga {$vaga} gerado com sucesso pelo usuário ". $this -> session -> uid, 'tb_vagas', $vaga);
                $this->csvmodel->printCache('avaliacao_competencia.csv');
        }
}
?>