<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidaturas extends CI_Controller {
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
        }
        //perfil candidato
        public function index(){ //lista de candidaturas - perfil candidato
                if($this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }
                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='index';
                $pagina['url']='Candidaturas/index';
                $pagina['nome_pagina']='Candidaturas';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                $dados['adicionais'] = array('datatables' => true);
                if($this -> session -> candidato > 0){
                        $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', $this -> session -> candidato);
                        $vagas = $this -> Vagas_model -> get_vagas('', true, 'array', $this -> session -> candidato,'1');
                        $dados['num_vagas'] = isset($vagas)?count($vagas):0;

                        $this -> load -> view('candidaturas', $dados);
                }
        }

	public function create(){ //escolha de vaga - perfil candidato
                if($this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }
                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='create';
                $pagina['url']='Candidaturas/create';
                $pagina['nome_pagina']='Nova candidatura';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;

                $vaga = $this -> uri -> segment(3);
                $dados['adicionais'] = array('wizard' => true,'datatables' => true);
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['vaga']) && $dados_form['vaga'] > 0){
                        $vaga = $dados_form['vaga'];
                }
                $dados['sucesso'] = '';
                $dados['erro'] = '';

                $liberado = true;
                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', true, '', $this -> session -> candidato,'1');
                if(count($dados['vagas'])==0){
                        $dados['erro'] = 'Não existem vagas disponíveis para inscrição no momento.';
                        $dados['sucesso'] = '';
                        $liberado = false;
                }
                else if($vaga >0){
                        $liberado = false;
                        foreach($dados['vagas'] as $linha){
                                if($linha -> pr_vaga == $vaga){
                                        $liberado = true;
                                }
                        }
                        if(!$liberado){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/create', 'Candidato '.$this -> session -> candidato.' tentou uma candidatura indevida na candidatura '.$vaga.': '.$erro['message'], 'tb_candidatos', $pr_candidatura);
                                $dados['sucesso'] = '';
                                $dados['erro'] = 'Tentativa indevida de inscrição em uma vaga não liberada.';
                        }
                }


                if(isset($dados_form['vaga']) && $dados_form['vaga'] > 0 && $liberado){
                        if ($dados_form['aceite_termo'] != 1){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $dados_form['candidato'] = null;
                                $dados_form['Telefone'] = '';
                                $dados_form['Vaga'] = $vaga;
                                $pr_candidatura = $this -> Candidaturas_model -> create_candidatura($dados_form);
                                if($pr_candidatura > 0){
                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/create', "Candidatura {$pr_candidatura} criado com sucesso pelo candidato ".$this -> session -> candidato.".", 'tb_candidaturas', $pr_candidatura);
                                        redirect('Candidaturas/Prova/'.$vaga);
                                        exit();
                                }
                                else{
                                        $erro = $this -> db -> error();
                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/create', 'Candidato '.$this -> session -> candidato.' não conseguiu cadastrar candidatura para a vaga '.$this -> input -> post('Vaga').': '.$erro['message'], 'tb_candidatos', $pr_candidatura);
                                        $dados['sucesso'] = '';
                                        $dados['erro'] = 'Ocorreu um erro no cadastro da sua candidatura. Os responsáveis já foram avisados.';
                                }
                        }
                }
                if($vaga > 0){
                        $dados['vaga_detalhe'] = $this -> Vagas_model -> get_vagas($vaga);
                        $dados['vaga'] = $vaga;
                }
                $dados['liberado'] = $liberado;

                $this -> load -> view('candidaturas', $dados);
        }
	public function Prova(){ //primeira etapa de avaliação - perfil candidato
                if($this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }
                else if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $config['upload_path'] = './anexos/';
                $config['allowed_types'] = '*';//validação feita posteriormente
                $config['max_size'] = 5120;
                $this -> load -> library('upload', $config);

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='Prova';
                $pagina['url']='Candidaturas/Prova';
                $pagina['nome_pagina']='Nova candidatura';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> input -> post('vaga') > 0){
                        $dados['vaga'] = $this -> input -> post('vaga');
                }
                else{
                        $dados['vaga'] = $this -> uri -> segment(3);
                }

                $dados['adicionais'] = array('wizard' => true);
                $candidatura = $this -> Candidaturas_model -> get_candidaturas('', $this -> session -> candidato, $dados['vaga']);

                $vaga = $this -> Vagas_model -> get_vagas($dados['vaga'], false);
                //var_dump($vaga);
                //echo 'vaga: '.$dados['vaga'].', '.$vaga['dt_fim'].'<br>';
                if(mysql_to_unix($vaga[0] -> dt_fim) < time()){
                        $dados['sucesso'] = '';
                        $dados['erro'] = "O prazo de preenchimento desta vaga encerrou-se em ".show_date($vaga[0] -> dt_fim, true).'. Essa tentativa foi registrada para fins de auditoria.<br/>';
                        $this -> Usuarios_model -> log('seguranca', 'Candidaturas/Prova', "Tentativa de preenchimento da candidatura ".$candidatura[0] -> pr_candidatura." pelo usuário ".$this -> session -> uid." fora do prazo.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
                else{
                        if(isset($candidatura[0]) ){
                                //&& $candidatura[0] -> es_status == '1'
                                //confirma a existência de candidatura com prova pendente
                                $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 1);
                                //$dados['questoes_inicial'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 5);
                                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);
                                //$dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);
                                $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);

                                $x=1;
                                $anexos = $this -> Anexos_model -> get_anexo('', '', $candidatura[0]->pr_candidatura);
                                $anexos_questao = array();
                                if(isset($anexos)){
                                        foreach($anexos as $anexo){
                                                $anexos_questao[$anexo -> es_questao] = $anexo;
                                        }
                                }
                                $dados['anexos']=$anexos_questao;
                                if($this -> input -> post('cadastrar') == 'Avançar'){
                                        if(isset($dados['questoes'] )){
                                                foreach ($dados['questoes'] as $row){
                                                        if($row -> in_tipo == 7){
                                                                if((!isset($_FILES['Questao'.$row -> pr_questao]['name']) || strlen($_FILES['Questao'.$row -> pr_questao]['name']) == 0) && (!isset($anexos_questao[$row -> pr_questao]))){
                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                                                }
                                                                else if(isset($_FILES['Questao'.$row -> pr_questao]['name']) && strlen($_FILES['Questao'.$row -> pr_questao]['name']) > 0){
                                                                        @unlink($config['upload_path'].$_FILES['Questao'.$row -> pr_questao]['name']);
                                                                        //$this -> upload -> do_upload('Questao'.$row -> pr_questao))
                                                                        if ( !($_FILES['Questao'.$row -> pr_questao]['type'] == 'application/pdf'  && $_FILES['Questao'.$row -> pr_questao]["size"] <= 5 * 1024 * 1024)){
                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "O envio da questão {$x} não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes."));
                                                                        }
                                                                        else{
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['file_type'] = $_FILES['Questao'.$row -> pr_questao]['type'];
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['file_size'] = $_FILES['Questao'.$row -> pr_questao]["size"];
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['orig_name'] = $_FILES['Questao'.$row -> pr_questao]["name"];
                                                                                //$dados_upload["envio_questao".$row -> pr_questao] = $this -> upload -> data();
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['candidatura'] = $candidatura[0]->pr_candidatura;
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['questao'] = $row -> pr_questao;

                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_questao".$row -> pr_questao], '1');

                                                                                if($id > 0){
                                                                                        /*rename($config['upload_path'].$dados_upload["envio_questao".$row -> pr_questao]['file_name'], $config['upload_path'].$id);*/
                                                                                        if(copy($_FILES['Questao'.$row -> pr_questao]['tmp_name'],$config['upload_path'].$id)){
                                                                                                if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){
                                                                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                                }
                                                                                                else{
                                                                                                        $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                                        $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                                }
                                                                                                $anexo = $this -> Anexos_model -> get_anexo($id);
                                                                                                if(isset($anexo)){
                                                                                                      $anexos_questao[$row -> pr_questao] = $anexo[0];
                                                                                                }

                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        else{
                                                                if($row -> bl_obrigatorio){
                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                                                }
                                                                else{
                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                }
                                                        }
                                                        $x++;
                                                }
                                        }

                                }
                                else{
                                        if(isset($dados['questoes'])){
                                                foreach ($dados['questoes'] as $row){
                                                        if($row -> in_tipo == 7){
                                                                if(isset($_FILES['Questao'.$row -> pr_questao]['name']) && strlen($_FILES['Questao'.$row -> pr_questao]['name']) > 0){
                                                                        @unlink($config['upload_path'].$_FILES['Questao'.$row -> pr_questao]['name']);
                                                                        //$this -> upload -> do_upload('Questao'.$row -> pr_questao))
                                                                        if ( !($_FILES['Questao'.$row -> pr_questao]['type'] == 'application/pdf'  && $_FILES['Questao'.$row -> pr_questao]["size"] <= 5 * 1024 * 1024)){
                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "O envio da questão {$x} não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes."));
                                                                        }
                                                                        else{
                                                                                //$dados_upload["envio_questao".$row -> pr_questao] = $this -> upload -> data();
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['file_type'] = $_FILES['Questao'.$row -> pr_questao]['type'];
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['file_size'] = $_FILES['Questao'.$row -> pr_questao]["size"];
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['orig_name'] = $_FILES['Questao'.$row -> pr_questao]["name"];
                                                                                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['candidatura'] = $candidatura[0]->pr_candidatura;
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['questao'] = $row -> pr_questao;

                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_questao".$row -> pr_questao], '1');

                                                                                if($id > 0){
                                                                                        //rename($config['upload_path'].$dados_upload["envio_questao".$row -> pr_questao]['file_name'], $config['upload_path'].$id);
                                                                                        if(copy($_FILES['Questao'.$row -> pr_questao]['tmp_name'],$config['upload_path'].$id)){
                                                                                                if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){
                                                                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                                }
                                                                                                else{
                                                                                                        $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                                        $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                                }
                                                                                                $anexo = $this -> Anexos_model -> get_anexo($id);
                                                                                                if(isset($anexo)){
                                                                                                      $anexos_questao[$row -> pr_questao] = $anexo[0];
                                                                                                }
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                        else{
                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                        }
                                                        $x++;
                                                }
                                        }
                                }
                                $dados['anexos']=$anexos_questao;
                                if ($this -> form_validation -> run() == FALSE){
                                        $dados['sucesso'] = '';
                                        $dados['erro'] = validation_errors();
                                        $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);
                                }
                                else{
                                        $dados_form = $this -> input -> post(null,true);
                                        $dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;

                                        $falha = false;
                                        $falha2 = false;
                                        if(isset($dados['questoes'])){
                                                foreach ($dados['questoes'] as $row){
                                                        if($row -> in_tipo == 7){ //upload
                                                                if(isset($_FILES["Questao".$row -> pr_questao]['name']) && strlen($_FILES["Questao".$row -> pr_questao]['name']) > 0){
                                                                        /*$dados_upload["envio_questao".$row -> pr_questao]['candidatura'] = $candidatura[0]->pr_candidatura;
                                                                        $dados_upload["envio_questao".$row -> pr_questao]['questao'] = $row -> pr_questao;

                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_questao".$row -> pr_questao], '1');

                                                                        if($id > 0){
                                                                                rename($config['upload_path'].$dados_upload["envio_questao".$row -> pr_questao]['file_name'], $config['upload_path'].$id);
                                                                                if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){
                                                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                }
                                                                                else{
                                                                                        $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                        $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                }
                                                                        }*/
                                                                }

                                                                else if(!isset($anexos_questao[$row -> pr_questao])){
                                                                        $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                        $dados_arquivo['Questao'.$row -> pr_questao] = '0';
                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                }
                                                                else{
                                                                        if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){
                                                                                $this -> Candidaturas_model -> update_resposta("tx_resposta", '1', $this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                        }
                                                                        else{
                                                                                $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                        }
                                                                }
                                                        }
                                                        else if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao))>0){
                                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",$this -> input -> post("Questao".$row -> pr_questao),$this -> input -> post("codigo_resposta".$row -> pr_questao));

                                                                        $this -> Candidaturas_model -> update_resposta("dt_alteracao",date('Y-m-d H:i:s'),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                }
                                                                else{
                                                                        $this -> Candidaturas_model -> delete_resposta($this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                }
                                                        }
                                                        else{
                                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_form, $row -> pr_questao);
                                                                }
                                                        }
                                                }
                                        }

                                        if($this -> input -> post('cadastrar') == 'Salvar'){
                                                $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Prova', "Etapa de Requisitos Obrigatórios da candidatura {$dados_form['candidatura']} salva com sucesso.", 'tb_candidaturas', $dados_form['candidatura']);
                                                $dados['sucesso'] = "Dados salvos com sucesso.";
                                                $dados['erro'] = '';
                                                $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);
                                                //redirect('Candidaturas/index');
                                        }
                                        else{
                                                if($this -> input -> post('cadastrar') == 'Avançar'){
                                                        if($candidatura[0] -> es_status == '1'){
                                                                $this -> Candidaturas_model -> update_candidatura('es_status', 4,  $candidatura[0] -> pr_candidatura);

                                                                $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Prova', "Etapa de Requisitos Obrigatórios da candidatura {$dados_form['candidatura']} respondida com sucesso.", 'tb_candidaturas', $dados_form['candidatura']);
                                                        }
                                                        redirect('Candidaturas/Curriculo/'.$dados['vaga']);
                                                }
                                        }
                                }
                        }
                        else{
                                $dados['sucesso'] = '';
                                $dados['erro'] = 'Não existe confirmação de cadastro de candidatura em seu nome para essa vaga.';
                        }
                }
                $this -> load -> view('candidaturas', $dados);
        }

	public function Curriculo(){ //etapa de currículo - perfil candidato
                if($this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }
                else if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $config['upload_path'] = './anexos/';
                $config['allowed_types'] = '*';//validação feita posteriormente
                $config['max_size'] = 5120;
                $this -> load -> library('upload', $config);

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='Curriculo';
                $pagina['url']='Candidaturas/Curriculo';
                $pagina['nome_pagina']='Nova candidatura';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> input -> post('vaga') > 0){
                        $dados['vaga'] = $this -> input -> post('vaga');
                }
                else{
                        $dados['vaga'] = $this -> uri -> segment(3);
                }
                $dados['adicionais'] = array(
                                            'wizard' => true);
                $candidatura = $this -> Candidaturas_model -> get_candidaturas('', $this -> session -> candidato, $dados['vaga']);

                $vaga = $this -> Vagas_model -> get_vagas($dados['vaga'], false);

                $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato,$candidatura[0]->pr_candidatura);
                if(!isset($dados_formacao) || count($dados_formacao)==0){
                        $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato);
                }
                $i=0;
                if(isset($dados_formacao) && count($dados_formacao)>0){
                        foreach($dados_formacao as $formacao){
                                ++$i;

                                $dados['en_tipo'][$i]=$formacao->en_tipo;
                                $dados['vc_curso'][$i]=$formacao->vc_curso;
                                $dados['vc_instituicao'][$i]=$formacao->vc_instituicao;
                                $dados['dt_conclusao'][$i]=$formacao->dt_conclusao;
                                $dados['in_cargahoraria'][$i]=$formacao->in_cargahoraria;

                                if(strlen($formacao->es_formacao_pai)>0){
                                        $dados['pr_formacao'][$i]=$formacao->pr_formacao;
                                        $dados['es_formacao_pai'][$i]=$formacao->es_formacao_pai;
                                        $dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                        $dados["anexos2_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->es_formacao_pai);
                                }
                                else{
                                        $dados['es_formacao_pai'][$i]=$formacao->pr_formacao;
					$dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                }
                        }
                }
                $dados['num_formacao']=$i;

                $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato,$candidatura[0]->pr_candidatura);
                if((!isset($dados_experiencia) || count($dados_experiencia)==0)){
                        $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato);
                }
                $i=0;
                if(isset($dados_experiencia) && count($dados_experiencia)>0){
                        foreach($dados_experiencia as $experiencia){
                                ++$i;
                                $dados['vc_empresa'][$i]=$experiencia->vc_empresa;
                                $dados['dt_inicio'][$i]=$experiencia->dt_inicio;
                                $dados['bl_emprego_atual'][$i]=$experiencia->bl_emprego_atual;
                                $dados['dt_fim'][$i]=$experiencia->dt_fim;
                                $dados['tx_atividades'][$i]=$experiencia->tx_atividades;

                                if(strlen($experiencia->es_experiencia_pai)>0){
                                        $dados['pr_experienca'][$i]=$experiencia->pr_experienca;
                                        $dados['es_experiencia_pai'][$i]=$experiencia->es_experiencia_pai;
                                        $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                        $dados["anexos_experiencia2"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->es_experiencia_pai);
                                }
                                else{
                                        $dados['es_experiencia_pai'][$i]=$experiencia->pr_experienca;
                                        $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                }
                        }
                }
                $dados['num_experiencia']=$i;

                if(mysql_to_unix($vaga[0] -> dt_fim) < time()){
                        $dados['sucesso'] = '';
                        $dados['erro'] = "O prazo de preenchimento desta vaga encerrou-se em ".show_date($vaga[0] -> dt_fim, true).'. Essa tentativa foi registrada para fins de auditoria.<br/>';
                        $this -> Usuarios_model -> log('seguranca', 'Candidaturas/Curriculo', "Tentativa de preenchimento da candidatura ".$candidatura[0] -> pr_candidatura." pelo usuário ".$this -> session -> uid." fora do prazo.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
                else{
                        $erro='';
                        $dados['sucesso'] = '';
                        $dados['erro'] = '';
                        if($this -> input -> post('cadastrar') != NULL){
                                if(isset($candidatura[0])){
                                        $erro='';
                                        $algum = false;
                                        if($this -> input -> post('cadastrar') == 'Avançar'){
                                                for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                                        if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0 || strlen($this -> input -> post("semestre_conclusao{$i}")) > 0 || strlen($this -> input -> post("mes_conclusao{$i}")) > 0){
                                                                $algum = true;
                                                                if(strlen($this -> input -> post("tipo{$i}")) == 0){
                                                                        $erro .= "Você deve escolher o tipo da 'Formação acadêmica {$i}'.<br/>";
                                                                }
                                                                else if($this -> input -> post("tipo{$i}")=='seminario' && strlen($this -> input -> post("cargahoraria{$i}")) == 0){
                                                                        $erro .= "A carga horária da 'Formação acadêmica {$i}' deve ser inserida quando o tipo de formação acadêmica for 'Curso Seminário'.<br/>";
                                                                }
                                                                if($this -> input -> post("tipo{$i}") == 'producao_cientifica'){
                                                                        if(strlen($this -> input -> post("curso{$i}")) == 0){
                                                                                $erro .= "Você deve inserir a categoria da 'Formação acadêmica {$i}'.<br/>";
                                                                        }

                                                                        if(strlen($this -> input -> post("instituicao{$i}")) == 0){
                                                                                $erro .= "Você deve inserir o título da pesquisa/publicação da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                        if(strlen($this -> input -> post("conclusao{$i}")) == 0){
                                                                                $erro .= "Você deve escolher a data da conclusão da pesquisa/publicação da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                }
                                                                else{
                                                                        if(strlen($this -> input -> post("curso{$i}")) == 0){
                                                                                $erro .= "Você deve inserir o nome do curso da 'Formação acadêmica {$i}'.<br/>";
                                                                        }

                                                                        if(strlen($this -> input -> post("instituicao{$i}")) == 0){
                                                                                $erro .= "Você deve inserir a instituição de ensino da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                        if(strlen($this -> input -> post("conclusao{$i}")) == 0){
                                                                                $erro .= "Você deve escolher a data da conclusão da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                }
                                                        }
                                                }
                                                if(!$algum){
                                                        $erro.='Você deve preencher ao menos uma formação acadêmica.<br/>';
                                                }
                                                $algum2 = false;

                                                for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                                        if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0  || strlen($this -> input -> post("fim{$i}")) > 0 || strlen($this -> input -> post("mes_fim{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                                $algum2 = true;
                                                                if(strlen($this -> input -> post("empresa{$i}")) == 0){
                                                                        $erro .= "Você deve inserir a instituição / empresa da 'Experiência profissional {$i}'.<br/>";
                                                                }
                                                                if(strlen($this -> input -> post("inicio{$i}")) == 0){
                                                                        $erro .= "Você deve inserir a data de início da 'Experiência profissional {$i}'.<br/>";
                                                                }
                                                                else if(strlen($this -> input -> post("fim{$i}")) > 0 && strtotime($this -> input -> post("fim{$i}"))<strtotime($this -> input -> post("inicio{$i}"))){
                                                                        $erro .= "A data de término deve ser igual ou maior à dta de início da 'Experiência profissional {$i}'.<br/>";
                                                                }
                                                                if(strlen($this -> input -> post("atividades{$i}")) == 0){
                                                                        $erro .= "Você deve inserir a descrição de atividades da 'Experiência profissional {$i}'.<br/>";
                                                                }
                                                        }
                                                }
                                                if(!$algum2 && $vaga[0] -> bl_ensinomedio != '1'){
                                                        $erro.='Você deve preencher ao menos uma experiência profissional.<br/>';
                                                }
                                        }

                                        for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                                if((!isset($_FILES["diploma{$i}"]['name']) || strlen($_FILES["diploma{$i}"]['name']) == 0) && $this -> input -> post('cadastrar') == 'Avançar'){
                                                        if(strlen($this -> input -> post("codigo_formacao{$i}"))>0){
                                                                $anexos = $this -> Anexos_model -> get_anexo('',$this -> input -> post("codigo_formacao{$i}"));
                                                                $anexos2 = $this -> Anexos_model -> get_anexo('',$this -> input -> post("codigo_formacao_pai{$i}"));
                                                                if(!isset($anexos) && !isset($anexos2)){
                                                                        if($this -> input -> post("tipo{$i}") == 'producao_cientifica'){
                                                                                $erro .= "Você deve anexar o comprovante da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                        else{
                                                                                $erro .= "Você deve anexar o diploma / certificado da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                }
                                                        }
                                                        else if(strlen($this -> input -> post("codigo_formacao_pai{$i}"))>0){
                                                                $anexos = $this -> Anexos_model -> get_anexo('',$this -> input -> post("codigo_formacao_pai{$i}"));
                                                                if(!isset($anexos)){
                                                                        if($this -> input -> post("tipo{$i}") == 'producao_cientifica'){
                                                                                $erro .= "Você deve anexar o upload da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                        else{
                                                                                $erro .= "Você deve anexar o diploma / certificado da 'Formação acadêmica {$i}'.<br/>";
                                                                        }
                                                                }
                                                        }
                                                        else{
                                                                if($this -> input -> post("tipo{$i}") == 'producao_cientifica'){
                                                                        $erro .= "Você deve anexar o upload da 'Formação acadêmica {$i}'.<br/>";
                                                                }
                                                                else{
                                                                        $erro .= "Você deve anexar o diploma / certificado da 'Formação acadêmica {$i}'.<br/>";
                                                                }
                                                        }
                                                }
                                                else if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                        if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                                                @unlink($config['upload_path'].$config['upload_path'].$_FILES["diploma{$i}"]['name']);
                                                                //
                                                                if (!($_FILES["diploma{$i}"]['type'] == 'application/pdf' && $_FILES["diploma{$i}"]["size"] <= 5 * 1024 * 1024)){
                                                                        if($this -> input -> post("tipo{$i}") == 'producao_cientifica'){
                                                                                $erro.=" O envio do upload da 'Formação acadêmica {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes.<br>";
                                                                        }
                                                                        else{
                                                                                $erro.=" O envio do diploma / certificado da 'Formação acadêmica {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes.<br>";
                                                                        }
                                                                }
                                                                else{
                                                                        //$dados_upload["envio_curriculo{$i}"] = $this -> upload -> data();
                                                                        $dados_upload["envio_curriculo{$i}"]['file_type'] = $_FILES["diploma{$i}"]['type'];
                                                                        $dados_upload["envio_curriculo{$i}"]['file_size'] = $_FILES["diploma{$i}"]["size"];
                                                                        $dados_upload["envio_curriculo{$i}"]['orig_name'] = $_FILES["diploma{$i}"]["name"];

                                                                        if(strlen($this -> input -> post("codigo_formacao{$i}")) > 0){
                                                                                $dados_upload["envio_curriculo{$i}"]['formacao'] = $this -> input -> post("codigo_formacao{$i}");

                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_curriculo{$i}"], '1');
                                                                                if($id > 0){
                                                                                        //rename($config['upload_path'].$dados_upload["envio_curriculo{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                        if(copy($_FILES["diploma{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                                                                                                                $dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$this -> input -> post("codigo_formacao{$i}"));
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                }
                                                                        }

                                                                }
                                                        }

                                                }
                                        }

                                        for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                                if((!isset($_FILES["comprovante{$i}"]['name']) || strlen($_FILES["comprovante{$i}"]['name']) == 0) && $this -> input -> post('cadastrar') == 'Avançar' && $algum2){
                                                        //$erro .= "Você deve anexar o comprovante da 'Experiência profissional {$i}'.<br/>";
                                                        //$vaga[0] -> bl_ensinomedio != '1'
                                                        if(strlen($this -> input -> post("codigo_experiencia{$i}"))>0){
                                                                $anexos = $this -> Anexos_model -> get_anexo('','','','',$this -> input -> post("codigo_experiencia{$i}"));
                                                                $anexos2 = $this -> Anexos_model -> get_anexo('','','','',$this -> input -> post("codigo_experiencia_pai{$i}"));
                                                                if(!isset($anexos) && !isset($anexos2)){
                                                                        $erro .= "Você deve anexar o comprovante da 'Experiência profissional {$i}'.<br/>";
                                                                }
                                                        }
                                                        else if(strlen($this -> input -> post("codigo_experiencia_pai{$i}"))>0){
                                                                $anexos = $this -> Anexos_model -> get_anexo('','','','',$this -> input -> post("codigo_experiencia_pai{$i}"));
                                                                if(!isset($anexos)){
                                                                        $erro .= "Você deve anexar o comprovante da 'Experiência profissional {$i}'.<br/>";
                                                                }
                                                        }
                                                        else{
                                                                $erro .= "Você deve anexar o comprovante da 'Experiência profissional {$i}'.<br/>";
                                                        }
                                                }
                                                else if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                        if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                                @unlink($config['upload_path'].$_FILES["comprovante{$i}"]['name']);
                                                                if ( ! ($_FILES["comprovante{$i}"]['type'] == 'application/pdf' && $_FILES["comprovante{$i}"]["size"] <= 5 * 1024 * 1024)){
                                                                        //echo 'Erro no envio do arquivo do currículo: '.$this -> upload -> display_errors().'.<br>';
                                                                        //$this -> upload -> display_errors().
                                                                        $erro.=" O envio do comprovante da 'Experiência profissional {$i}' não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes.<br>";
                                                                }
                                                                else{
                                                                        $dados_upload["envio_experiencia{$i}"]['file_type'] = $_FILES["comprovante{$i}"]['type'];
                                                                        $dados_upload["envio_experiencia{$i}"]['file_size'] = $_FILES["comprovante{$i}"]["size"];
                                                                        $dados_upload["envio_experiencia{$i}"]['orig_name'] = $_FILES["comprovante{$i}"]["name"];
                                                                        //$dados_upload["envio_experiencia{$i}"] = $this -> upload -> data();
                                                                        if(strlen($this -> input -> post("codigo_experiencia{$i}"))>0){
                                                                                $dados_upload["envio_experiencia{$i}"]['experiencia'] = $this -> input -> post("codigo_experiencia{$i}");

                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_experiencia{$i}"], '1');
                                                                                if($id > 0){
                                                                                        //rename($config['upload_path'].$dados_upload["envio_experiencia{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                        if(copy($_FILES["comprovante{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$this -> input -> post("codigo_experiencia{$i}"));
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                        }
                                        if (strlen($erro)>0){
                                                $dados['sucesso'] = '';
                                                $dados['erro'] = $erro;
                                                if($candidatura[0] -> es_status == '6'){
                                                        $this -> Candidaturas_model -> update_candidatura('es_status', 4,  $candidatura[0] -> pr_candidatura);
                                                }

                                        }
                                        else{
                                                //$dados_form = $this -> input -> post(null,true);
                                                //$dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                $dados_form = $this -> input -> post(null,true);

                                                for($i = 1; $i <= $this -> input -> post('num_formacao'); $i++){
                                                        if(strlen($this -> input -> post("tipo{$i}")) > 0 || strlen($this -> input -> post("instituicao{$i}")) > 0 || strlen($this -> input -> post("conclusao{$i}")) > 0){
                                                                if(strlen($this -> input -> post("codigo_formacao{$i}"))>0){

                                                                        /*$this -> Candidaturas_model -> delete_formacao_candidatura($this -> input -> post("codigo_formacao{$i}"),$candidatura[0] -> pr_candidatura);
                                                                        $this -> Candidaturas_model -> create_formacao_candidatura($this -> input -> post("codigo_formacao{$i}"),$candidatura[0] -> pr_candidatura);
                                                                        */
                                                                        $this -> Candidaturas_model -> update_formacao("vc_curso", $this -> input -> post("curso{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("en_tipo", $this -> input -> post("tipo{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("vc_instituicao", $this -> input -> post("instituicao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("dt_conclusao", $this -> input -> post("conclusao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        /*$this -> Candidaturas_model -> update_formacao("se_conclusao", $this -> input -> post("semestre_conclusao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        $this -> Candidaturas_model -> update_formacao("me_conclusao", $this -> input -> post("mes_conclusao{$i}") ,$this -> input -> post("codigo_formacao{$i}"));*/
                                                                        if(strlen($this -> input -> post("cargahoraria{$i}")) > 0){
                                                                                $this -> Candidaturas_model -> update_formacao("in_cargahoraria", $this -> input -> post("cargahoraria{$i}") ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        }
                                                                        else{
                                                                                $this -> Candidaturas_model -> update_formacao("in_cargahoraria", null ,$this -> input -> post("codigo_formacao{$i}"));
                                                                        }
                                                                }
                                                                else{
                                                                        if(!isset($dados_form["codigo_formacao_pai".$i]) || strlen($dados_form["codigo_formacao_pai".$i])==0){
                                                                                unset($dados_form["codigo_formacao_pai".$i]);
                                                                        }
                                                                        $dados_form["candidatura".$i]=$candidatura[0]->pr_candidatura;
                                                                        $formacao = $this -> Candidaturas_model -> create_formacao($dados_form, $i);
                                                                        $dados_formacao = $this -> Candidaturas_model -> get_formacao($formacao,$this -> session -> candidato,$candidatura[0]->pr_candidatura);

                                                                        $dados_upload["envio_curriculo{$i}"]['formacao'] = $dados_formacao[0] -> es_formacao_pai;
                                                                        if(isset($_FILES["diploma{$i}"]['name']) && strlen($_FILES["diploma{$i}"]['name']) > 0){
                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_curriculo{$i}"], '1');
                                                                                if($id > 0){
                                                                                        if(copy($_FILES["diploma{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                //$dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$id);
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                        //rename($config['upload_path'].$dados_upload["envio_curriculo{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                }
                                                                        }
                                                                }
                                                        }
                                                }
                                                for($i = 1; $i <= $this -> input -> post('num_experiencia'); $i++){
                                                        if(strlen($this -> input -> post("empresa{$i}")) > 0 || strlen($this -> input -> post("inicio{$i}")) > 0 || strlen($this -> input -> post("atividades{$i}")) > 0){
                                                                if(strlen($this -> input -> post("codigo_experiencia{$i}"))>0){
                                                                        /*$this -> Candidaturas_model -> delete_experiencia_candidatura($this -> input -> post("codigo_experiencia{$i}"),$candidatura[0] -> pr_candidatura);
                                                                        $this -> Candidaturas_model -> create_experiencia_candidatura($this -> input -> post("codigo_experiencia{$i}"),$candidatura[0] -> pr_candidatura);
                                                                        */
                                                                        $this -> Candidaturas_model -> update_experiencia("vc_empresa", $this -> input -> post("empresa{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        $this -> Candidaturas_model -> update_experiencia("dt_inicio", $this -> input -> post("inicio{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        $this -> Candidaturas_model -> update_experiencia("bl_emprego_atual", $this -> input -> post("emprego_atual{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
									if(strlen($this -> input -> post("fim{$i}"))>0){
                                                                                $this -> Candidaturas_model -> update_experiencia("dt_fim", $this -> input -> post("fim{$i}") ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        }
                                                                        else{
                                                                                $this -> Candidaturas_model -> update_experiencia("dt_fim", null ,$this -> input -> post("codigo_experiencia{$i}"));
                                                                        }
                                                                        $this -> Candidaturas_model -> update_experiencia("tx_atividades", $this -> input -> post("atividades{$i}"),$this -> input -> post("codigo_experiencia{$i}"));
                                                                }
                                                                else{
                                                                        if(!isset($dados_form["codigo_experiencia_pai".$i]) || strlen($dados_form["codigo_experiencia_pai".$i])==0){
                                                                                unset($dados_form["codigo_experiencia_pai".$i]);
                                                                        }
                                                                        $dados_form["candidatura".$i]=$candidatura[0]->pr_candidatura;
                                                                        $experiencia = $this -> Candidaturas_model -> create_experiencia($dados_form, $i);
                                                                        $dados_experiencia = $this -> Candidaturas_model -> get_experiencia($experiencia,$this -> session -> candidato,$candidatura[0]->pr_candidatura);
                                                                        if(isset($_FILES["comprovante{$i}"]['name']) && strlen($_FILES["comprovante{$i}"]['name']) > 0){
                                                                                $dados_upload["envio_experiencia{$i}"]['experiencia'] = $dados_experiencia[0] -> es_experiencia_pai;

                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_experiencia{$i}"], '1');
                                                                                if($id > 0){
                                                                                        //rename($config['upload_path'].$dados_upload["envio_experiencia{$i}"]['file_name'], $config['upload_path'].$id);
                                                                                        if(copy($_FILES["comprovante{$i}"]['tmp_name'],$config['upload_path'].$id)){
                                                                                                //$dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$id);
                                                                                        }
                                                                                        else{
                                                                                                $this -> Anexos_model -> delete_anexo($id);
                                                                                        }
                                                                                }
                                                                        }
                                                                        //$this -> Candidaturas_model -> create_experiencia_candidatura($experiencia,$candidatura[0] -> pr_candidatura);
                                                                }
                                                        }
                                                }
                                                if($this -> input -> post('cadastrar') == 'Salvar'){
                                                        $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Questionario', "Currículo da candidatura ".$candidatura[0] -> pr_candidatura." salva com sucesso.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                                                        $dados['sucesso'] = "Dados salvos com sucesso.";
                                                        $dados['erro'] = '';
                                                        //redirect('Candidaturas/index');

                                                        //recarrega os dados

                                                        $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato,$candidatura[0]->pr_candidatura);
                                                        if(!isset($dados_formacao) || count($dados_formacao)==0){
                                                                $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato);
                                                        }
                                                        $i=0;
                                                        if(isset($dados_formacao) && count($dados_formacao)>0){
                                                                foreach($dados_formacao as $formacao){
                                                                        ++$i;

                                                                        $dados['en_tipo'][$i]=$formacao->en_tipo;
                                                                        $dados['vc_curso'][$i]=$formacao->vc_curso;
                                                                        $dados['vc_instituicao'][$i]=$formacao->vc_instituicao;
                                                                        $dados['dt_conclusao'][$i]=$formacao->dt_conclusao;

                                                                        $dados['in_cargahoraria'][$i]=$formacao->in_cargahoraria;
                                                                        if(strlen($formacao->es_formacao_pai)>0){
                                                                                $dados['pr_formacao'][$i]=$formacao->pr_formacao;
                                                                                $dados['es_formacao_pai'][$i]=$formacao->es_formacao_pai;

                                                                                $dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                                                                $dados["anexos2_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->es_formacao_pai);
                                                                        }
                                                                        else{
                                                                                $dados['es_formacao_pai'][$i]=$formacao->pr_formacao;
                                                                                $dados["anexos_formacao"][$i] = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                                                        }
                                                                }
                                                        }
                                                        $dados['num_formacao']=$i;

                                                        $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato,$candidatura[0]->pr_candidatura);
                                                        if((!isset($dados_experiencia) || count($dados_experiencia)==0) && $candidatura[0] -> es_status != '6'){
                                                                $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato);
                                                        }
                                                        $i=0;
                                                        if(isset($dados_experiencia) && count($dados_experiencia)>0){
                                                                foreach($dados_experiencia as $experiencia){
                                                                        ++$i;
                                                                        $dados['vc_empresa'][$i]=$experiencia->vc_empresa;
                                                                        $dados['dt_inicio'][$i]=$experiencia->dt_inicio;
                                                                        $dados['bl_emprego_atual'][$i]=$experiencia->bl_emprego_atual;
                                                                        $dados['dt_fim'][$i]=$experiencia->dt_fim;

                                                                        $dados['tx_atividades'][$i]=$experiencia->tx_atividades;
                                                                        if(strlen($experiencia->es_experiencia_pai)>0){
                                                                                $dados['pr_experienca'][$i]=$experiencia->pr_experienca;
                                                                                $dados['es_experiencia_pai'][$i]=$experiencia->es_experiencia_pai;

                                                                                $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                                                                $dados["anexos_experiencia2"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->es_experiencia_pai);
                                                                        }
                                                                        else{
                                                                                $dados['es_experiencia_pai'][$i]=$experiencia->pr_experienca;
                                                                                $dados["anexos_experiencia"][$i] = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                                                        }
                                                                }
                                                        }
                                                        $dados['num_experiencia']=$i;
                                                }
                                                else{
                                                        if($candidatura[0] -> es_status == '4'){
                                                                $this -> Candidaturas_model -> update_candidatura('es_status', 6,  $candidatura[0] -> pr_candidatura);
                                                        }
                                                        $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Questionario', "Currículo da candidatura ".$candidatura[0] -> pr_candidatura." respondida com sucesso.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                                                        redirect('Candidaturas/Questionario/'.$dados['vaga']);
                                                }
                                        }
                                }
                                else{
                                        $dados['sucesso'] = '';
                                        $dados['erro'] = 'Não existe confirmação de cadastro de candidatura em seu nome para essa vaga.';
                                }
                        }
                }
                $this -> load -> view('candidaturas', $dados);
        }
	public function Questionario(){ //2ª etapa de avaliação - perfil candidato
                if($this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }
                else if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $config['upload_path'] = './anexos/';
                $config['allowed_types'] = '*';//validação feita posteriormente
                $config['max_size'] = 5120;
                $this -> load -> library('upload', $config);

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='Questionario';
                $pagina['url']='Candidaturas/Questionario';
                $pagina['nome_pagina']='Nova candidatura';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> input -> post('vaga') > 0){
                        $dados['vaga'] = $this -> input -> post('vaga');
                }
                else{
                        $dados['vaga'] = $this -> uri -> segment(3);
                }
                $dados['adicionais'] = array('wizard' => true);
                $candidatura = $this -> Candidaturas_model -> get_candidaturas('', $this -> session -> candidato, $dados['vaga']);
                $vaga = $this -> Vagas_model -> get_vagas($dados['vaga'], false);
                if(mysql_to_unix($vaga[0] -> dt_fim) < time()){
                        $dados['sucesso'] = '';
                        $dados['erro'] = "O prazo de preenchimento desta vaga encerrou-se em ".show_date($vaga[0] -> dt_fim, true).'. Essa tentativa foi registrada para fins de auditoria.<br/>';
                        $this -> Usuarios_model -> log('seguranca', 'Candidaturas/Questionario', "Tentativa de preenchimento da candidatura ".$candidatura[0] -> pr_candidatura." pelo usuário ".$this -> session -> uid." fora do prazo.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
                else{
                        if(isset($candidatura[0]) ){ //confirma a existência de candidatura com questionário pendente
                                $vaga = $this -> Vagas_model -> get_vagas($dados['vaga'], false);

                                $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 2);
                                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);
                                $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);

                                $x=1;
                                $anexos = $this -> Anexos_model -> get_anexo('', '', $candidatura[0]->pr_candidatura);
                                $anexos_questao = array();
                                if(isset($anexos)){
                                        foreach($anexos as $anexo){
                                                $anexos_questao[$anexo -> es_questao] = $anexo;
                                        }
                                }

                                $dados['sucesso'] = '';
                                $dados['erro'] = '';
                                $erro = "";
                                if($this -> input -> post('cadastrar') != NULL){

                                        if($this -> input -> post('cadastrar') == 'Concluir'){
                                                if(isset($dados['questoes'])){
                                                        foreach ($dados['questoes'] as $row){
                                                                if($row -> in_tipo == 7){
                                                                        if((!isset($_FILES['Questao'.$row -> pr_questao]['name']) || strlen($_FILES['Questao'.$row -> pr_questao]['name']) == 0) && !(isset($anexos_questao[$row -> pr_questao])) && $row -> bl_obrigatorio){
                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                                                        }

                                                                        else if(isset($_FILES['Questao'.$row -> pr_questao]['name']) && strlen($_FILES['Questao'.$row -> pr_questao]['name']) > 0){
                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                                @unlink($config['upload_path'].$_FILES['Questao'.$row -> pr_questao]['name']);
                                                                                //$this -> upload -> do_upload('Questao'.$row -> pr_questao)
                                                                                if ( ! ($_FILES['Questao'.$row -> pr_questao]['type'] == 'application/pdf' && $_FILES['Questao'.$row -> pr_questao]["size"] <= 5 * 1024 * 1024)){
                                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "O envio da questão {$x} não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes."));
                                                                                }
                                                                                else{
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['file_type'] = $_FILES['Questao'.$row -> pr_questao]['type'];
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['file_size'] = $_FILES['Questao'.$row -> pr_questao]["size"];
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['orig_name'] = $_FILES['Questao'.$row -> pr_questao]["name"];
                                                                                        //$dados_upload["envio_questao".$row -> pr_questao] = $this -> upload -> data();
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['candidatura'] = $candidatura[0]->pr_candidatura;
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['questao'] = $row -> pr_questao;

                                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_questao".$row -> pr_questao], '1');

                                                                                        if($id > 0){
                                                                                                //rename($config['upload_path'].$dados_upload["envio_questao".$row -> pr_questao]['file_name'], $config['upload_path'].$id);
                                                                                                if(copy($_FILES['Questao'.$row -> pr_questao]['tmp_name'],$config['upload_path'].$id)){
                                                                                                        if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){
                                                                                                                $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                                        }
                                                                                                        else{
                                                                                                                $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                                                $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                                                $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                                        }
                                                                                                        $anexos = $this -> Anexos_model -> get_anexo($id);
                                                                                                        $anexos_questao[$row -> pr_questao] = $anexos[0];;
                                                                                                }
                                                                                                else{
                                                                                                        $this -> Anexos_model -> delete_anexo($id);
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }
                                                                        else{
                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                        }
                                                                }
                                                                else{
                                                                        if($row -> bl_obrigatorio){
                                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                                                        }
                                                                        else{
                                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                        }
                                                                }
                                                                $x++;
                                                        }
                                                }
                                                $dados_formacao = $this -> Candidaturas_model -> get_formacao(null,$this -> session -> candidato,$candidatura[0]->pr_candidatura);
                                                if(isset($dados_formacao)){
                                                        foreach($dados_formacao as $formacao){
                                                                $anexos_formacao = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                                                $anexos_formacao2 = $this -> Anexos_model -> get_anexo('',$formacao->es_formacao_pai);
                                                                if(!isset($anexos_formacao) && !isset($anexos_formacao2)){
                                                                                $erro.="Você possui algum(s) anexo(s) faltante(s) na(s) sua(s) formação(s) acadêmica(s). Volte para fase de Currículo para adicionar o(s) anexo(s) faltante(s)<br />";
                                                                                break;
                                                                }
                                                        }
                                                }
                                                else{
                                                        $erro.="Você não possui formação acadêmica. Volte para fase de Currículo para adicionar ao menos 1 formação acadêmica.<br />";
                                                }

                                                $dados_experiencia = $this -> Candidaturas_model -> get_experiencia(null,$this -> session -> candidato,$candidatura[0]->pr_candidatura);

                                                if(isset($dados_experiencia)){
                                                            foreach($dados_experiencia as $experiencia){
                                                                    $anexos_experiencia = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                                                    $anexos_experiencia2 = $this -> Anexos_model -> get_anexo('','','','',$experiencia->es_experiencia_pai);
                                                                    if(!isset($anexos_experiencia) && !isset($anexos_experiencia2)){
                                                                            $erro.="Você possui algum(s) anexo(s) faltante(s) na(s) sua(s) experiência(s) profissional(s). Volte para fase de Currículo para adicionar o(s) anexo(s) faltante(s)<br />";
                                                                            break;
                                                                    }
                                                            }
                                                }
                                                else if($vaga[0] -> bl_ensinomedio != '1'){
                                                        $erro.="Você não possui experiência. Volte para fase de Currículo para adicionar ao menos 1 experiência profissional.<br />";
                                                }

                                        }
                                        else{
                                                if(isset($dados['questoes'])){
                                                        foreach ($dados['questoes'] as $row){

                                                                if($row -> in_tipo == 7){
                                                                        if(isset($_FILES['Questao'.$row -> pr_questao]['name']) && strlen($_FILES['Questao'.$row -> pr_questao]['name']) > 0){
                                                                                @unlink($config['upload_path'].$_FILES['Questao'.$row -> pr_questao]['name']);
                                                                                if ( ! ($_FILES['Questao'.$row -> pr_questao]['type'] == 'application/pdf' && $this -> upload -> do_upload('Questao'.$row -> pr_questao))){
                                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "O envio da questão {$x} não foi efetuado, são aceitos somente arquivos do tipo PDF de até 5 MBytes."));
                                                                                }
                                                                                else{
                                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                                        $dados_upload["envio_questao".$row -> pr_questao] = $this -> upload -> data();
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['candidatura'] = $candidatura[0]->pr_candidatura;
                                                                                        $dados_upload["envio_questao".$row -> pr_questao]['questao'] = $row -> pr_questao;

                                                                                        $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_questao".$row -> pr_questao], '1');

                                                                                        if($id > 0){
                                                                                                rename($config['upload_path'].$dados_upload["envio_questao".$row -> pr_questao]['file_name'], $config['upload_path'].$id);
                                                                                                if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){

                                                                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                                }
                                                                                                else{
                                                                                                        $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                                        $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                                }
                                                                                                $anexos = $this -> Anexos_model -> get_anexo($id);
                                                                                                $anexos_questao[$row -> pr_questao] = $anexos[0];
                                                                                        }
                                                                                }
                                                                        }
                                                                        else{
                                                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                        }
                                                                }
                                                                else{
                                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                                                }
                                                                $x++;
                                                        }
                                                }
                                        }
                                        if ($this -> form_validation -> run() == FALSE && isset($dados['questoes'])){
                                                $dados['sucesso'] = '';
                                                $dados['erro'] = validation_errors();
                                                $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);
                                        }
                                        else if(strlen($erro)>0){
                                                $dados['sucesso'] = '';
                                                $dados['erro'] = $erro;
                                                $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);
										}
                                        else{
                                                $dados_form = $this -> input -> post(null,true);
                                                $dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                //$this -> Questoes_model -> salvar_questionario($dados_form);
                                                $total = 0;
                                                $nota = 0;
                                                if(isset($dados['questoes'])){
                                                        foreach ($dados['questoes'] as $row){
                                                                if($row -> in_tipo == 7){
                                                                        if(isset($_FILES["Questao".$row -> pr_questao]['name']) && strlen($_FILES["Questao".$row -> pr_questao]['name']) > 0){
                                                                                /*$dados_upload["envio_questao".$row -> pr_questao]['candidatura'] = $candidatura[0]->pr_candidatura;
                                                                                $dados_upload["envio_questao".$row -> pr_questao]['questao'] = $row -> pr_questao;

                                                                                $id = $this -> Anexos_model -> salvar_anexo($dados_upload["envio_questao".$row -> pr_questao], '1');

                                                                                if($id > 0){
                                                                                                rename($config['upload_path'].$dados_upload["envio_questao".$row -> pr_questao]['file_name'], $config['upload_path'].$id);
                                                                                                if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){

                                                                                                                $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                                }
                                                                                                else{
                                                                                                                $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                                                $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                                                $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                                }
                                                                                }*/
                                                                        }

                                                                        else if(!isset($anexos_questao[$row -> pr_questao])){
                                                                                $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                $dados_arquivo["Questao".$row -> pr_questao] = '0';
                                                                                $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                        }
                                                                        else{
                                                                                if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao)) > 0){
                                                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",'1',$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                }
                                                                                else{
                                                                                        $dados_arquivo['candidatura'] = $candidatura[0] -> pr_candidatura;
                                                                                        $dados_arquivo["Questao".$row -> pr_questao] = '1';
                                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_arquivo, $row -> pr_questao);
                                                                                }
                                                                        }

                                                                }
                                                                else if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao))>0){
                                                                        if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                                                $this -> Candidaturas_model -> update_resposta("tx_resposta",$this -> input -> post("Questao".$row -> pr_questao),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                                $this -> Candidaturas_model -> update_resposta("dt_alteracao",date('Y-m-d H:i:s'),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                        }
                                                                        else{
                                                                                $this -> Candidaturas_model -> delete_resposta($this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                                        }
                                                                }
                                                                else{
                                                                        if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                                                        $this -> Candidaturas_model -> salvar_resposta($dados_form, $row -> pr_questao);
                                                                        }
                                                                }
                                                        }
                                                }
                                                if($this -> input -> post('cadastrar') == 'Salvar'){
                                                        $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);

                                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Questionario', "Candidatura ".$candidatura[0] -> pr_candidatura." salva com sucesso.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                                                        $dados['sucesso'] = "Dados salvos com sucesso";
                                                        $dados['erro'] = '';
                                                        $dados['respostas'] = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);
                                                }
                                                else{
                                                        $respostas = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura,'','',1);
                                                        $falha = false;
                                                        $falha2 = false;
                                                        //$falha3 = false;
							$respostas_filtradas = array();
                                                        $respostas_inicial = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura,'','',5);
                                                        if(isset($respostas_inicial)){
                                                                foreach($respostas_inicial as $resposta){
                                                                        if(isset($respostas_filtradas[$resposta->es_questao])){
                                                                                if($resposta -> tx_resposta == '1'){
                                                                                        $respostas_filtradas[$resposta->es_questao] = $resposta -> tx_resposta;
                                                                                }
                                                                        }
                                                                        else{
                                                                                $respostas_filtradas[$resposta->es_questao] = $resposta -> tx_resposta;
                                                                        }
                                                                }

                                                        }
                                                        if(strtotime($candidatura[0] -> dt_fim) < time()){
                                                                $falha2 = true;
                                                        }
                                                        foreach($respostas as $resposta){
                                                                if(isset($respostas_filtradas[$resposta->es_questao])){
                                                                        if($resposta -> tx_resposta == '1'){
                                                                                $respostas_filtradas[$resposta->es_questao] = $resposta -> tx_resposta;
                                                                        }
                                                                }
                                                                else{
                                                                        $respostas_filtradas[$resposta->es_questao] = $resposta -> tx_resposta;
                                                                }
                                                        }

                                                        $chaves=array_keys($respostas_filtradas);
                                                        foreach($chaves as $chave){
                                                                if($respostas_filtradas[$chave] == 0){
                                                                        //echo $respostas_filtradas[$chave],$chave;
                                                                        $falha = true;
                                                                        break;
                                                                }
                                                        }

                                                        if($falha2){
                                                                $this -> Candidaturas_model -> update_candidatura('es_status', 5,  $candidatura[0] -> pr_candidatura);
                                                                $this -> Candidaturas_model -> update_candidatura('dt_realizada', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
								$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                                $dados['sucesso'] = 'Seu preenchimento foi registrado mas infelizmente fora dos prazos da vaga. Em caso de dúvidas, favor entrar em contato com o fale conosco.<br/><br/><a href="'.base_url('Candidaturas/index').'">Voltar</a>';
                                                                $dados['erro'] = '';

                                                                $this -> envio_email($candidatura,$vaga,"eliminacao");

                                                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Prova', "Candidatura ".$dados_form['candidatura']." concluída com sucesso pelo usuário ".$this -> session -> uid.", mas com eliminação do candidato.", 'tb_candidaturas', $dados_form['candidatura']);
                                                        }
                                                        else if($falha){
                                                                $this -> Candidaturas_model -> update_candidatura('es_status', 5,  $candidatura[0] -> pr_candidatura);
                                                                $this -> Candidaturas_model -> update_candidatura('dt_realizada', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
								$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                                $dados['sucesso'] = 'Seu preenchimento foi registrado mas infelizmente você não cumpre com os requisitos mínimos da vaga. Em caso de dúvidas, favor entrar em contato com o fale conosco.<br/><br/><button class="btn btn-light"><a href="'.base_url('Candidaturas/index').'">Voltar</a></button>';
                                                                $dados['erro'] = '';

                                                                $this -> envio_email($candidatura,$vaga,"eliminacao");

                                                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Prova', "Candidatura ".$dados_form['candidatura']." concluída com sucesso pelo usuário ".$this -> session -> uid.", mas com eliminação do candidato.", 'tb_candidaturas', $dados_form['candidatura']);
                                                        }
                                                        else{
                                                                $this -> Candidaturas_model -> update_candidatura('es_status', 7,  $candidatura[0] -> pr_candidatura);
																$this -> Candidaturas_model -> update_candidatura('dt_realizada', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                                $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                                                $dados['sucesso'] = 'Obrigado pela participação. Seu cadastro foi concluído e agora faz parte do banco de dados do Processo Seletivo.<br/><br/>Em caso de dúvidas, favor entrar em contato com o fale conosco.<br/><br/><button class="btn btn-light"><a href="'.base_url('Candidaturas/index').'">Voltar</a></button>';
                                                                $dados['erro'] = '';

                                                                $this -> envio_email($candidatura,$vaga,"confirmacao");

                                                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Questionario', "Candidatura ".$dados_form['candidatura']." concluída com sucesso pelo usuário ".$this -> session -> uid.".", 'tb_candidaturas', $dados_form['candidatura']);
                                                        }
                                                }
                                        }

                                }
                        }
                        else{
                                $dados['sucesso'] = '';
                                $dados['erro'] = 'Não existe confirmação de cadastro de candidatura em seu nome para essa vaga.';
                        }
                }
                $dados['anexos'] = $anexos_questao;
                $this -> load -> view('candidaturas', $dados);
        }

        public function TesteAderencia(){ //teste de aderência - perfil candidato
                if($this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='TesteAderencia';
                $pagina['url']='Candidaturas/TesteAderencia';
                $pagina['nome_pagina']='Teste de aderência';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> input -> post('candidatura') > 0){
                        $dados['candidatura'] = $this -> input -> post('candidatura');
                }
                else{
                        $dados['candidatura'] = $this -> uri -> segment(3);
                }

                $dados['adicionais'] = array(
                                            'wizard' => true);

                $candidatura = $this -> Candidaturas_model -> get_candidaturas($dados['candidatura']);
                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);
                if(isset($candidatura[0]) && ($candidatura[0] -> es_status == '10' || $candidatura[0] -> es_status == '11' || $candidatura[0] -> es_status == '12')){
                        $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 5);
                        $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);
                        $dados['respostas'] = $resposta = $this -> Questoes_model -> get_respostas('',$candidatura[0]->pr_candidatura);

                        $x=1;
                        if($this -> input -> post('salvar') == 'Concluir'){
                                foreach ($dados['questoes'] as $row){
                                        if($row -> bl_obrigatorio){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                        }
                                        $x++;
                                }
                        }
                        else{
                                foreach ($dados['questoes'] as $row){
                                        if($row -> bl_obrigatorio){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                        }
                                        $x++;
                                }
                        }

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();

                        }
                        else{
                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;

                                $falha = false;
                                $falha2 = false;

                                $total = 0;
                                $nota = 0;

                                foreach ($dados['questoes'] as $row){
                                        if(strlen($row->in_peso)>0||$row -> in_tipo == '1'){
                                                if(($row -> in_tipo == '3' || $row -> in_tipo == '4') && (mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,'))){
                                                        if($this -> input -> post("Questao".$row -> pr_questao)=='1' && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim'){
                                                                $nota += intval($row->in_peso);
                                                        }
                                                        else if($this -> input -> post("Questao".$row -> pr_questao)=='1' && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não'){
                                                                $nota += intval($row->in_peso);
                                                        }
                                                        $total += intval($row->in_peso);
                                                }
                                                else if($row -> in_tipo == '5' && (mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado')){
                                                        if(intval($this -> input -> post("Questao".$row -> pr_questao))>=1 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
                                                                $nota += intval($row->in_peso);
                                                        }
                                                        else if(intval($this -> input -> post("Questao".$row -> pr_questao))>=2 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
                                                                $nota += intval($row->in_peso);
                                                        }
                                                        else if(intval($this -> input -> post("Questao".$row -> pr_questao))>=3 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                                                $nota += intval($row->in_peso);
                                                        }
                                                        $total += intval($row->in_peso);
                                                }
                                                else if($row -> in_tipo == '1'){
                                                        $opcoes = $this -> Questoes_model -> get_opcoes('',$row -> pr_questao);
                                                        $total_parcial=0;
                                                        foreach($opcoes as $opcao){

                                                                if($this -> input -> post("Questao".$row -> pr_questao)==$opcao->pr_opcao){
                                                                        //echo $opcao->in_valor;
                                                                        $nota += intval($opcao->in_valor);
                                                                }
                                                                if($total_parcial<intval($opcao->in_valor)){
                                                                        $total_parcial=intval($opcao->in_valor);
                                                                }
                                                        }
                                                        //echo $total_parcial."<br />";
                                                        $total += $total_parcial;
                                                }
                                                else if($row -> in_tipo == '6'){
                                                        $nota += intval($this -> input -> post("Questao".$row -> pr_questao));
                                                        $total += intval($row->in_peso);
                                                }
                                        }
                                        if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao))>0){
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",$this -> input -> post("Questao".$row -> pr_questao),$this -> input -> post("codigo_resposta".$row -> pr_questao));

                                                        $this -> Candidaturas_model -> update_resposta("dt_alteracao",date('Y-m-d H:i:s'),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                                else{
                                                        $this -> Candidaturas_model -> delete_resposta($this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                        }
                                        else{
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> salvar_resposta($dados_form, $row -> pr_questao);
                                                }
                                        }
                                }
                                $nota_etapa5=$nota;

                                $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura[0] -> pr_candidatura,5);
                                //echo $total;
                                if(isset($notas[0] -> pr_nota)){
                                        $this -> Candidaturas_model -> update_nota('in_nota',$nota_etapa5,$notas[0] -> pr_nota);
                                }
                                else{
                                        $dados_nota=array('candidatura'=>$candidatura[0] -> pr_candidatura,'nota'=>$nota_etapa5,'etapa'=>5);
                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                }
                                if($this -> input -> post('salvar') == 'Salvar'){
                                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Prova', "Prova da candidatura {$dados_form['candidatura']} salva com sucesso.", 'tb_candidaturas', $dados_form['candidatura']);
                                        redirect('Candidaturas/index');
                                }
                                else if ($this -> input -> post('salvar') == 'Concluir'){
                                        $this -> Candidaturas_model -> update_candidatura('en_aderencia', '2',  $candidatura[0] -> pr_candidatura);
                                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/Prova', "Prova da candidatura {$dados_form['candidatura']} respondida com sucesso.", 'tb_candidaturas', $dados_form['candidatura']);
                                        redirect('Candidaturas/index/');
                                }
                        }
                }
                else{
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Não existe confirmação de cadastro de candidatura em seu nome para essa vaga.';
                }
                $this -> load -> view('candidaturas', $dados);
        }

        public function valida_create($valor){ //callback de validação customizada do formulário de cadastro - perfil de candidato
                if($valor > 0){
                        if($this -> Candidaturas_model -> get_candidaturas('', $this -> session -> candidato, $valor)){
                                $this -> form_validation -> set_message('valida_create', 'Já existe um cadastro de candidatura em seu nome para esta vaga.');
                                return false;
                        }
                        else{
                                return true;
                        }
                }
                else{
                        $this -> form_validation -> set_message('valida_create', 'O campo \'Vaga\' é obrigatório.');
                        return false;
                }
        }

        //perfil gestores e avaliador
	public function ListaAvaliacao($tipo = 1){ //lista de candidaturas - perfil gestores e avaliador
                if($this -> session -> perfil != 'avaliador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Instituicoes_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='ListaAvaliacao';
                $pagina['url']='Candidaturas/ListaAvaliacao';
                if($this -> session -> perfil == 'avaliador'){
                        $pagina['nome_pagina']='Lista de avaliação';
                }
                else{
                        $pagina['nome_pagina']='Candidaturas';
                }
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                $dados['adicionais'] = array(
                                            'datatables' => true);
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['filtro_tipo']) && strlen($dados_form['filtro_tipo']) > 0){
                        $tipo = $dados_form['filtro_tipo'];
                }

                if($this -> session -> perfil == 'avaliador'){
                        if($tipo == 1){
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true,'7, 8, 9, 10, 11, 18, 19, 20, 21',$this -> session -> uid);
                        }
                        else{
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true,'7, 8, 9, 10, 11, 18, 19, 20, 21',$this -> session -> uid);
                        }
                }
                else{
                        if($tipo == 1){
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true,'7, 8, 9, 10, 11, 18, 19, 20, 21');
                        }
                        else{
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false,'array', '',0,'',true,'7, 8, 9, 10, 11, 18, 19, 20, 21');
                        }
                }

                $dados['tipo'] = $tipo;
                if(!isset($dados_form['filtro_vaga'])){
                        $dados['vaga']='';
                        $dados_form['filtro_vaga'] = '';
                        if($this -> session -> perfil != 'avaliador' && isset($dados['vagas'])){
                                $chaves = array_keys($dados['vagas']);
                                $dados['vaga'] = $chaves[0];
                                $dados_form['filtro_vaga'] = $chaves[0];
                        }
                }
                else{
                        $dados['vaga'] = $dados_form['filtro_vaga'];
                }
                if(!isset($dados_form['filtro_instituicao'])){
                        $dados_form['filtro_instituicao']='';
                }
                if($this -> session -> perfil == 'avaliador'){ //avaliador
                        $dados_form['filtro_status']='<>5';
                }
                if(!isset($dados_form['filtro_status'])){
                        $dados_form['filtro_status']='';
                }

                $dados['vaga'] =  $dados_form['filtro_vaga'];
                if($this -> session -> perfil == 'avaliador'){ //avaliador
                        $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', '', $dados['vaga'], $dados_form['filtro_instituicao'], '7, 8, 9, 10, 11, 18, 19, 20, 21', $this -> session -> uid);
                }
                else{
                        $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', '', $dados['vaga'], $dados_form['filtro_instituicao'], '7, 8, 9, 10, 11, 18, 19, 20, 21','','1');

                }
                //$dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes ('', true);

                $dados['status'] = $this -> Candidaturas_model -> get_status ();

                $this -> load -> view('avaliacoes', $dados);
        }
	public function DetalheAvaliacao($id_candidatura,$link=null){ //lista de candidaturas - perfil gestores e avaliador
                if($this -> session -> perfil != 'avaliador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'candidato'){
                        redirect('Interna/index');
                }

                //para customizar a ação do botão voltar
                if($link==null){
                        $link = 'Candidaturas/ListaAvaliacao';
                }
                else{
                        $link = 'Vagas/resultado/'.$link;
                }

                $this -> load -> model('Instituicoes_model');
                //$this -> load -> model('Candidatos_model');
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='DetalheAvaliacao';
                $pagina['url']='Candidaturas/DetalheAvaliacao';
                $pagina['nome_pagina']='Detalhes de avaliação';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> session -> perfil == 'avaliador'){
                        $candidatura = $this -> Candidaturas_model -> get_candidaturas($id_candidatura,'','','','', $this -> session -> uid);
                }
                else{
                        $candidatura = $this -> Candidaturas_model -> get_candidaturas($id_candidatura);
                }

                if($id_candidatura == "Interna"){
                        echo "<script type=\"text/javascript\">window.location='".base_url()."';</script>";

                        exit();
                }
                if($this -> session -> perfil == 'candidato' && $this -> session -> candidato != $candidatura[0] -> es_candidato){
                        $this -> Usuarios_model -> log('seguranca', 'Candidaturas/DetalheAvaliacao', "Tentativa de visualização da candidatura ".$candidatura[0] -> pr_candidatura." pelo candidato ".$this -> session -> candidato.".", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        echo "<script type=\"text/javascript\">alert('Acesso indevido a visualização de uma candidatura armazenada para fins de auditoria');window.location='".base_url()."';</script>";

                        exit();
                }
                else if($this -> session -> perfil == 'avaliador' && !isset($candidatura)){
                        $this -> Usuarios_model -> log('seguranca', 'Candidaturas/DetalheAvaliacao', "Tentativa de visualização da candidatura ".$id_candidatura." pelo avaliador ".$this -> session -> uid.".", 'tb_candidaturas', $id_candidatura);
                        echo "<script type=\"text/javascript\">alert('Acesso indevido a visualização de uma candidatura armazenada para fins de auditoria');window.location='".base_url()."';</script>";

                        exit();
                }

                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);

                $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);

				//$dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->pr_formacao,'', '');
                $anexos = $this -> Anexos_model -> get_anexo('','',$candidatura[0] -> pr_candidatura, '');
                $dados['anexos_questao'] = array();
                if(isset($anexos)){
                        foreach($anexos as $anexo){
                                $dados['anexos_questao'][$anexo -> es_questao] = $anexo;
                        }
                }

                //$dados['questoes_inicial'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 5);

                $dados['questoes1'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 1);
                $dados['questoes2'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 2);
                $dados['questoes3'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 3);

                $dados['entrevistas'] = $this -> Candidaturas_model -> get_entrevistas('',$this -> uri -> segment(3),'competencia');

                $dados['questoes4'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 4);
                //$dados['questoes5'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 5);
                //$dados['questoes6'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 6);
                $dados['respostas'] = $this -> Questoes_model -> get_respostas('', $candidatura[0] -> pr_candidatura);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);

                //$dados['vaga'] = $this -> Vagas_model -> get_vagas ($candidatura[0] -> es_vaga, false);
                $dados['candidatura'] = $this -> Candidaturas_model -> get_candidaturas ($candidatura[0] -> pr_candidatura);
                $dados['formacoes'] = $this -> Candidaturas_model -> get_formacao(null,$candidatura[0] -> es_candidato,$candidatura[0]->pr_candidatura);
                if(isset($dados['formacoes'])){
                        foreach($dados['formacoes'] as $formacao){
                                $dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->pr_formacao,'', '');
                                if(!isset($dados['anexos'][$formacao->pr_formacao][0]) && strlen($formacao->es_formacao_pai) > 0){
                                        $dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->es_formacao_pai,'', '');
                                }
                        }
                }

                $dados['experiencias'] = $this -> Candidaturas_model -> get_experiencia(null,$candidatura[0] -> es_candidato,$candidatura[0]->pr_candidatura);
                if(isset($dados['experiencias'])){
                        foreach($dados['experiencias'] as $experiencia){
                                $dados['anexos_experiencia'][$experiencia->pr_experienca] = $this -> Anexos_model -> get_anexo('', '','', '', $experiencia->pr_experienca);
                                if(!isset($dados['anexos_experiencia'][$experiencia->pr_experienca][0])  && strlen($experiencia->es_experiencia_pai) > 0){
                                        $dados['anexos_experiencia'][$experiencia->pr_experienca] =  $this -> Anexos_model -> get_anexo('', '','', '', $experiencia->es_experiencia_pai);
                                }
                        }
                }
                $notas = $this -> Candidaturas_model -> get_nota('',$candidatura[0]->pr_candidatura);
                if(isset($notas)){
                        foreach($notas as $nota){
                                $dados["notas"][$nota -> es_etapa] = $nota -> in_nota;
                        }
                }
                $dados['status'] = $this -> Candidaturas_model -> get_status ();
                $dados['link'] = $link;
                $this -> load -> view('avaliacoes', $dados);
        }

	public function AvaliacaoEntrevista(){ //primeira etapa de avaliação - perfil candidato
                if($this -> session -> perfil != 'avaliador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='AvaliacaoEntrevista';
                $pagina['url']='Candidaturas/AvaliacaoEntrevista';
                $pagina['nome_pagina']='Avaliação da entrevista';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> input -> post('codigo') > 0){
                        $dados['candidatura'] = $this -> input -> post('codigo');
                }
                else{
                        $dados['candidatura'] = $this -> uri -> segment(3);
                }
                if($this -> input -> post('vaga') > 0){
                        $dados['vaga'] = $this -> input -> post('vaga');
                }
                else{
                        $dados['vaga'] = $this -> uri -> segment(4);
                }
                $dados['codigo'] = $dados['candidatura'];
                $candidatura = $this -> Candidaturas_model -> get_candidaturas($dados['candidatura']);

                if($candidatura[0]->es_avaliador_competencia1 == $this -> session -> uid || $candidatura[0]->es_avaliador_competencia2 == $this -> session -> uid || $candidatura[0] -> es_avaliador_competencia3 ==$this -> session -> uid){
                        if($dados['vaga'] > 0){
                                redirect('Vagas/resultado/'.$dados['vaga']);
                        }
                        else{
                                redirect('Candidaturas/ListaAvaliacao/');
                        }
                }

                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);
                $dados['status'] = $this -> Candidaturas_model -> get_status ();
                if(isset($candidatura[0]) && $candidatura[0] -> es_status == '10' ){ //confirma a existência de candidatura com prova pendente
                        $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 4);
                        $x=1;
                        if(strlen($this -> input ->post('concluir_entrevista'))>0){
                                foreach ($dados['questoes'] as $row){
                                        if($row -> bl_obrigatorio){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                        }
                                        else{
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                        }
                                        $x++;
                                }
                        }
                        else{
                                foreach ($dados['questoes'] as $row){
                                        //if($row -> bl_obrigatorio){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                        //}
                                        $x++;
                                }
                        }

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();

                        }
                        else{

                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;
                                $dados_form['avaliador'] = $this -> session -> uid;
                                //$this -> Questoes_model -> salvar_prova($dados_form);

                                $falha = false;

                                $total = 0;
                                $nota = 0;
                                $notas_competencia = array();
                                $totais_competencia = array();
                                foreach ($dados['questoes'] as $row){
                                        if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao))>0){
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",$this -> input -> post("Questao".$row -> pr_questao),$this -> input -> post("codigo_resposta".$row -> pr_questao));

                                                        $this -> Candidaturas_model -> update_resposta("dt_alteracao",date('Y-m-d H:i:s'),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                                else{
                                                        $this -> Candidaturas_model -> delete_resposta($this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                        }
                                        else{
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> salvar_resposta($dados_form, $row -> pr_questao);
                                                }
                                        }
                                }

                                if(strlen($this -> input ->post('concluir_entrevista'))>0){
                                        if((!(strlen($candidatura[0] -> es_avaliador_competencia1) > 0) || $candidatura[0] -> es_avaliador_competencia1 == '') && $candidatura[0] -> in_quant_avaliadores > 1){
                                                $this -> Candidaturas_model -> update_candidatura('es_avaliador_competencia1', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);
                                                $this->calcula_nota($candidatura[0] -> pr_candidatura,4);
                                                $this -> Candidaturas_model -> update_candidatura('dt_competencia1', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        }
					else if((!(strlen($candidatura[0] -> es_avaliador_competencia2) > 0) || $candidatura[0] -> es_avaliador_competencia2 == '') && $candidatura[0] -> in_quant_avaliadores > 2){
						$this -> Candidaturas_model -> update_candidatura('es_avaliador_competencia2', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);
                                                $this->calcula_nota($candidatura[0] -> pr_candidatura,4);
                                                $this -> Candidaturas_model -> update_candidatura('dt_competencia2', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
					}
                                        else if((!(strlen($candidatura[0] -> es_avaliador_competencia1) > 0) || $candidatura[0] -> es_avaliador_competencia1 == '') && $candidatura[0] -> in_quant_avaliadores == 1){
                                                $this -> Candidaturas_model -> update_candidatura('es_avaliador_competencia1', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);
                                                $this->calcula_nota($candidatura[0] -> pr_candidatura,4);
                                                $this -> Candidaturas_model -> update_candidatura('es_status', 11,  $candidatura[0] -> pr_candidatura);
                                                $this -> Candidaturas_model -> update_candidatura('dt_competencia1', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        }
                                        else if((!(strlen($candidatura[0] -> es_avaliador_competencia2) > 0) || $candidatura[0] -> es_avaliador_competencia2 == '') && $candidatura[0] -> in_quant_avaliadores == 2){
                                                $this -> Candidaturas_model -> update_candidatura('es_avaliador_competencia2', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);
                                                $this->calcula_nota($candidatura[0] -> pr_candidatura,4);
                                                $this -> Candidaturas_model -> update_candidatura('es_status', 11,  $candidatura[0] -> pr_candidatura);
                                                $this -> Candidaturas_model -> update_candidatura('dt_competencia2', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        }
                                        else if(!(strlen($candidatura[0] -> es_avaliador_competencia3) > 0) || $candidatura[0] -> es_avaliador_competencia3 == ''){
                                                $this -> Candidaturas_model -> update_candidatura('es_avaliador_competencia3', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);
                                                $this->calcula_nota($candidatura[0] -> pr_candidatura,4);
                                                $this -> Candidaturas_model -> update_candidatura('es_status', 11,  $candidatura[0] -> pr_candidatura);
                                                $this -> Candidaturas_model -> update_candidatura('dt_competencia3', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        }
                                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AvaliacaoEntrevista', "Entrevista da candidatura {$dados_form['candidatura']} inserida com sucesso pelo avaliador ".$this -> session -> uid.".", 'tb_candidaturas', $dados_form['candidatura']);
                                        if($dados['vaga'] > 0){
                                                redirect('Vagas/resultado/'.$dados['vaga']);
                                        }
                                        else{
                                                redirect('Candidaturas/ListaAvaliacao/');
                                        }
					exit();

                                }
                                else if(strlen($this -> input -> post('salvar_entrevista')) > 0){
                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AvaliacaoEntrevista', "Entrevista da candidatura {$dados_form['candidatura']} salva com sucesso pelo avaliador ".$this -> session -> uid.".", 'tb_candidaturas', $dados_form['candidatura']);
                                        if($dados['vaga'] > 0){
                                                redirect('Candidaturas/AvaliacaoEntrevista/'.$dados['candidatura'].'/'.$dados['vaga']);
                                        }
                                        else{
                                                redirect('Candidaturas/AvaliacaoEntrevista/'.$dados['candidatura']);
                                        }
                                        exit();
                                }
                        }
                }
                else{
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Não existe confirmação de cadastro de candidatura em seu nome para essa vaga.';
                }

                $dados['candidatura'] = $this -> Candidaturas_model -> get_candidaturas ($candidatura[0] -> pr_candidatura);
                $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);
                $dados['questoes4'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 4);
                $dados['respostas'] = $this -> Questoes_model -> get_respostas('', $candidatura[0] -> pr_candidatura,'',$this -> session -> uid);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);

                $this -> load -> view('avaliacoes', $dados);
        }

        public function AvaliacaoEntrevistaEspecialista(){ //primeira etapa de avaliação - perfil candidato
                if($this -> session -> perfil != 'avaliador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> library('email');

                $this -> load -> model('Questoes_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='AvaliacaoEntrevistaEspecialista';
                $pagina['url']='Candidaturas/AvaliacaoEntrevistaEspecialista';
                $pagina['nome_pagina']='Avaliação da entrevista com especialista';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;
                if($this -> input -> post('codigo') > 0){
                        $dados['candidatura'] = $this -> input -> post('codigo');
                }
                else{
                        $dados['candidatura'] = $this -> uri -> segment(3);
                }
                $dados['codigo'] = $dados['candidatura'];

                $candidatura = $this -> Candidaturas_model -> get_candidaturas($dados['candidatura']);
                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);
                $dados['status'] = $this -> Candidaturas_model -> get_status ();
                //var_dump($vaga);
                if(isset($candidatura[0]) && ($candidatura[0] -> es_status == '11' || $candidatura[0] -> es_status == '10') ){ //confirma a existência de candidatura com prova pendente
                        $dados['questoes'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 6);
                        $x=1;
                        if(strlen($this -> input ->post('concluir_entrevista'))>0){
                                foreach ($dados['questoes'] as $row){
                                        if($row -> bl_obrigatorio){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                        }
                                        else{
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                        }
                                        $x++;
                                }
                        }
                        else{
                                foreach ($dados['questoes'] as $row){
                                        //if($row -> bl_obrigatorio){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                        //}
                                        $x++;
                                }
                        }
                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;
                                $dados_form['avaliador'] = $this -> session -> uid;

                                $falha = false;

                                $total = 0;
                                $nota = 0;

                                foreach ($dados['questoes'] as $row){
                                        if(strlen($row->in_peso)>0||$row -> in_tipo == '1'){
                                                if(($row -> in_tipo == '3' || $row -> in_tipo == '4') && (mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($row -> vc_respostaAceita, 'Sim,'))){
                                                        if($this -> input -> post("Questao".$row -> pr_questao)=='1' && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim'){
                                                                $nota += intval($row->in_peso);

                                                        }
                                                        else if($this -> input -> post("Questao".$row -> pr_questao)=='1' && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não'){
                                                                $nota += intval($row->in_peso);

                                                        }
                                                        $total += intval($row->in_peso);

                                                }
                                                else if($row -> in_tipo == '5' && (mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado')){
                                                        if(intval($this -> input -> post("Questao".$row -> pr_questao))>=1 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico'){
                                                                $nota += intval($row->in_peso);

                                                        }
                                                        else if(intval($this -> input -> post("Questao".$row -> pr_questao))>=2 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário'){
                                                                $nota += intval($row->in_peso);

                                                        }
                                                        else if(intval($this -> input -> post("Questao".$row -> pr_questao))>=3 && mb_convert_case($row -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
                                                                $nota += intval($row->in_peso);

                                                        }
                                                        $total += intval($row->in_peso);
                                                }
                                                else if($row -> in_tipo == '1'){
                                                        $opcoes = $this -> Questoes_model -> get_opcoes('',$row -> pr_questao);
                                                        $total_parcial=0;
                                                        foreach($opcoes as $opcao){
                                                                if($this -> input -> post("Questao".$row -> pr_questao)==$opcao->pr_opcao){
                                                                        echo $opcao->in_valor;
                                                                        $nota += intval($opcao->in_valor);
                                                                }
                                                                if($total_parcial<intval($opcao->in_valor)){
                                                                        $total_parcial=intval($opcao->in_valor);
                                                                }
                                                        }
                                                        $total += $total_parcial;
                                                }
                                                else if($row -> in_tipo == '6'){
                                                        $nota += intval($this -> input -> post("Questao".$row -> pr_questao));
                                                        $total += intval($row->in_peso);
                                                }
                                        }
                                        if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao))>0){
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",$this -> input -> post("Questao".$row -> pr_questao),$this -> input -> post("codigo_resposta".$row -> pr_questao));

                                                        $this -> Candidaturas_model -> update_resposta("dt_alteracao",date('Y-m-d H:i:s'),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                                else{
                                                        $this -> Candidaturas_model -> delete_resposta($this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                        }
                                        else{
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> salvar_resposta($dados_form, $row -> pr_questao);
                                                }
                                        }

                                }
                                if($total == 0){
                                        $total = 1;
                                }

                                $nota_etapa4=$nota;
                                $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura[0] -> pr_candidatura,6);

                                if(isset($notas[0] -> pr_nota)){
                                        $this -> Candidaturas_model -> update_nota('in_nota',$nota_etapa4,$notas[0] -> pr_nota);
                                }
                                else{
                                        $dados_nota=array('candidatura'=>$candidatura[0] -> pr_candidatura,'nota'=>$nota_etapa4,'etapa'=>6);
                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                }

                                if(strlen($this -> input ->post('concluir_entrevista'))>0){
                                        if(strlen($candidatura[0] -> en_aderencia) ==0 || $candidatura[0] -> en_aderencia == '2'){
                                                $this -> Candidaturas_model -> update_candidatura('es_status', 14,  $candidatura[0] -> pr_candidatura);

                                                $dados_candidato = $this -> Candidatos_model -> get_candidatos($candidatura[0] -> es_candidato);

                                                $config['protocol'] = 'smpt';
                                                $config['charset'] = 'UTF-8';
                                                $config['smtp_port'] = 25;
                                                $config['smtp_host'] = $this -> config -> item('smtp_host');
                                                $config['smtp_user'] = $this -> config -> item('smtp_user');
                                                $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                                                $config['wordwrap'] = TRUE;
                                                $config['mailtype'] = 'html';

                                                $this->email->initialize($config);

                                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                $this -> email -> to($dados_candidato -> vc_email);

                                                $this -> email -> subject('['.$this -> config -> item('nome').'] Aprovação para aguardando decisão final');
                                                $msg='Olá '.$dados_candidato->vc_nome.',\n\nSua candidatura está esperando a decisão final.\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                                                $this -> email -> message($msg);
                                                if(!$this -> email -> send()){
                                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
                                                }
                                        }
                                        else{
                                                $this -> Candidaturas_model -> update_candidatura('es_status', 12,  $candidatura[0] -> pr_candidatura);
                                        }
                                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AvaliacaoEntrevista', "Entrevista da candidatura {$dados_form['candidatura']} inserida com sucesso.", 'tb_candidaturas', $dados_form['candidatura']);

                                        redirect('Candidaturas/ListaAvaliacao/');
                                }
                                else{
                                        redirect('Candidaturas/ListaAvaliacao/');
                                }
                        }
                }
                else{
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Não existe confirmação de cadastro de candidatura em seu nome para essa vaga.';
                }

                $dados['candidatura'] = $this -> Candidaturas_model -> get_candidaturas ($candidatura[0] -> pr_candidatura);
                $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);
                $dados['questoes6'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 6);
                $dados['respostas'] = $this -> Questoes_model -> get_respostas('', $candidatura[0] -> pr_candidatura);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);

                $this -> load -> view('avaliacoes', $dados);
        }

	public function AgendamentoEntrevista(){ //agendamento - perfil gestores e avaliador
                $this -> load -> model('Candidatos_model');
                $this -> load -> library('email');

                if($this -> session -> perfil == 'candidato' || $this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'sugesp'){ //candidatos e avaliadores
                        $pagina['menu1']='Candidaturas';
                        $pagina['menu2']='AgendamentoEntrevista';
                        $pagina['url']='Candidaturas/AgendamentoEntrevista';
                        $pagina['nome_pagina']='Seus agendamentos';
                        $pagina['icone']='fa fa-calendar';

                        $dados=$pagina;
                        $dados['adicionais'] = array('calendar' => true,'moment'=>true);
                        //$dados['adicionais'] = array('calendar' => true, 'moment' => true);
                        $dados['status'] = $this -> Candidaturas_model -> get_status ();
                        if($this -> session -> perfil == 'candidato'){
                                $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', $this -> session -> candidato, '', '', '', '',1);
                        }
                        else if($this -> session -> perfil == 'avaliador' || $this -> session -> perfil == 'sugesp'){
                                $dados['candidaturas'] = $this -> Candidaturas_model -> get_candidaturas ('', '', '', '', '', $this -> session -> uid);
                        }
                }
                else{
                        redirect('Interna/index');
                }
                $this -> load -> view('avaliacoes', $dados);
        }
        public function Dossie(){ //lista de candidaturas - perfil gestores e avaliador
                if($this -> session -> perfil != 'avaliador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> library('pdf');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='Dossie';
                $pagina['url']='Candidaturas/Dossie';
                $pagina['nome_pagina']='';
                $pagina['icone']='';

                $dados=$pagina;

                $candidatura = $this -> Candidaturas_model -> get_candidaturas($this -> uri -> segment(3));
                //var_dump($dados_form);
                if($candidatura[0] -> es_status == 14){
                        $this -> Candidaturas_model -> update_candidatura('es_status', 16,  $candidatura[0] -> pr_candidatura);
                }
                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);

                $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);
                $dados['questoes1'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 1);
                $dados['questoes2'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 2);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);
                $anexos_questao =  $this -> Anexos_model -> get_anexo('','', $candidatura[0] -> pr_candidatura);
                if(isset($anexos_questao)){
                        foreach($anexos_questao as $anexo){
                                $dados['anexos_questao'][$anexo -> es_questao] = $anexo;
                        }
                }


                $dados['questoes3'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 3);
                $dados['respostas'] = $this -> Questoes_model -> get_respostas('', $candidatura[0] -> pr_candidatura);
                //$dados['vaga'] = $this -> Vagas_model -> get_vagas ($candidatura[0] -> es_vaga, false);
                $dados['candidatura'] = $this -> Candidaturas_model -> get_candidaturas ($candidatura[0] -> pr_candidatura);
                //$dados['anexo1'] = $this -> Anexos_model -> get_anexo ('', $candidatura[0] -> pr_candidatura, 1);
                /*$dados['anexo2'] = $this -> Anexos_model -> get_anexo ('', $candidatura[0] -> pr_candidatura, 2);
                $dados['anexo3'] = $this -> Anexos_model -> get_anexo ('', $candidatura[0] -> pr_candidatura, 3);*/
                $dados['formacoes'] = $this -> Candidaturas_model -> get_formacao(null,$candidatura[0] -> es_candidato,$candidatura[0]->pr_candidatura);

                foreach($dados['formacoes'] as $formacao){
                        $dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->pr_formacao,'', '');
                        if(!isset($dados['anexos'][$formacao->pr_formacao])){
                                $dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->es_formacao_pai,'', '');
                        }
                }
                $dados['experiencias'] = $this -> Candidaturas_model -> get_experiencia(null,$candidatura[0] -> es_candidato,$candidatura[0]->pr_candidatura);

                foreach($dados['experiencias'] as $experiencia){
                        $dados['anexos_experiencia'][$experiencia -> pr_experienca] =  $this -> Anexos_model -> get_anexo('', '','', '', $experiencia -> pr_experienca);
                        if(!isset($dados['anexos_experiencia'][$experiencia -> pr_experienca])){
                                $dados['anexos_experiencia'][$experiencia -> pr_experienca] =  $this -> Anexos_model -> get_anexo('', '','', '', $experiencia -> es_experiencia_pai);
                        }
                }

                $this -> load -> view('dossie', $dados);
        }

        public function AvaliacaoCurriculo($id,$id_vaga=''){
                if($this -> session -> perfil != 'avaliador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }

                $this -> load -> model('Instituicoes_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Anexos_model');

                $this -> load -> library('email');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='AvaliacaoCurriculo';
                if($id_vaga>0){
                        $pagina['url']='Candidaturas/AvaliacaoCurriculo/'.$id.'/'.$id_vaga;
                }
                else{
                        $pagina['url']='Candidaturas/AvaliacaoCurriculo/'.$id;
                }

                $pagina['nome_pagina']='Análise Curricular';
                $pagina['icone']='fa fa-edit';

                $dados=$pagina;

                $candidatura = $this -> Candidaturas_model -> get_candidaturas($id);
                //var_dump($dados_form);
                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);

                if(strlen($this->input->post('codigo_candidatura'))>0){
                        $id = $this->input->post('codigo_candidatura');
                }

                $dados['codigo_candidatura'] = $id;
                $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);
                $dados['questoes1'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 1);

                $anexos = $this -> Anexos_model -> get_anexo('','',$candidatura[0] -> pr_candidatura, '');
                $dados['anexos_questao'] = array();
                if(isset($anexos)){
                        foreach($anexos as $anexo){
                                $dados['anexos_questao'][$anexo -> es_questao] = $anexo;
                        }
                }

                $dados['questoes2'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 2);
                $dados['questoes3'] = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 3);
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);

                $x=1;
                if(strlen($this -> input -> post('salvar')) > 0){
                        if($this -> input -> post('salvar') == 'Aprovar análise'){
                                foreach ($dados['questoes3'] as $row){
                                        if($row -> bl_obrigatorio){
                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'required', array('required' => "A questão {$x} é obrigatória."));
                                        }
                                        else{
                                                        $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                        }
                                        $x++;
                                }
                        }
                        else{
                                foreach ($dados['questoes3'] as $row){
                                                $this -> form_validation -> set_rules('Questao'.$row -> pr_questao, "'Questão $x'", 'trim');
                                }
                        }
                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();

                        }
                        else{
                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['candidatura'] = $candidatura[0] -> pr_candidatura;

                                $nota = 0;
                                $total = 0;
                                $falha = false;
                                foreach ($dados['questoes3'] as $row){
                                        if(strlen($this -> input -> post("codigo_resposta".$row -> pr_questao))>0){
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> update_resposta("tx_resposta",$this -> input -> post("Questao".$row -> pr_questao),$this -> input -> post("codigo_resposta".$row -> pr_questao));

                                                        $this -> Candidaturas_model -> update_resposta("dt_alteracao",date('Y-m-d H:i:s'),$this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                                else{
                                                        $this -> Candidaturas_model -> delete_resposta($this -> input -> post("codigo_resposta".$row -> pr_questao));
                                                }
                                        }
                                        else{
                                                if(strlen($this -> input -> post("Questao".$row -> pr_questao))>0){
                                                        $this -> Candidaturas_model -> salvar_resposta($dados_form, $row -> pr_questao);
                                                }
                                        }
                                }

                                $config['protocol'] = 'smpt';
                                $config['charset'] = 'UTF-8';
                                $config['smtp_port'] = 25;
                                $config['smtp_host'] = $this -> config -> item('smtp_host');
                                $config['smtp_user'] = $this -> config -> item('smtp_user');
                                $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                                $config['wordwrap'] = TRUE;

                                $config['mailtype'] = 'html';

                                $this->email->initialize($config);

				if($this -> input -> post('salvar') == 'Aprovar análise'){
                                        $this->calcula_nota($candidatura[0] -> pr_candidatura,3);
                                        $this -> Candidaturas_model -> update_candidatura('es_status', 8,  $candidatura[0] -> pr_candidatura);
                                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Candidaturas_model -> update_candidatura('dt_curriculo', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Candidaturas_model -> update_candidatura('es_avaliador_curriculo', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);

                                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/AvaliacaoCurriculo', "Análise de currículo da candidatura ".$candidatura[0] -> pr_candidatura." entregue com sucesso pelo usuário ".$this -> session -> uid.".", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);

                                        //$this -> envio_email($candidatura,$vaga,'analise');
                                }
				else if($this -> input -> post('salvar') == 'Reprovar'){

                                        $this -> Candidaturas_model -> update_candidatura('es_status', 20,  $candidatura[0] -> pr_candidatura);
                                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Candidaturas_model -> update_candidatura('dt_curriculo', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                                        $this -> Candidaturas_model -> update_candidatura('es_avaliador_curriculo', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);


                                        $candidato = $this -> Candidatos_model -> get_candidatos($candidatura[0] -> es_candidato);

                                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/AvaliacaoCurriculo', "Candidatura ".$candidatura[0] -> pr_candidatura." reprovada na análise curricular pelo usuário ".$this -> session -> uid.".", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                                        //*********************
                                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                        $this -> email -> to($candidato -> vc_email);
                                        $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação da candidatura na análise curricular');
                                        $msg="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->

<meta content=\"width=device-width\" name=\"viewport\">
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\">
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}

		.botao:hover{
			background-color: #718066 !important;
		}

		.aqui:hover{
			color: #DF2935 !important;
		}


	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
	<!--<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]-->
	<!--<img align=\"center\" alt=\"Image\" border=\"0\" class=\"center autowidth\" src=\"images/logovermelho.jpg\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 123px; display: block;\" title=\"Image\" width=\"123\"/>-->
	<!--[if mso]></td></tr></table><![endif]-->
	<!--</div>-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:&#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.5; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; color: #555555; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Processos Seletivos MG</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:&#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"line-height: 1.6; font-size: 12px; color: #555555; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 24px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Candidatura reprovada!</strong></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato -> vc_nome}</strong>, a sua candidatura para a vaga <strong>{$vaga[0] -> vc_vaga}</strong> não passou da fase de habilitação por não atender aos critérios do edital.</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Em caso de dúvidas, entre em contato com o comitê gestor responsável pela vaga para maiores esclarecimentos.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"https://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:204pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"transparent\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"https://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #304025; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; border-top: 1px solid transparent; border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; padding-top: 10px; padding-bottom: 10px; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:&#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.6; color: #555555; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 18px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Em caso de dúvidas, entre em contato com a equipe pelo Fale Conosco da página inicial do sistema.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\">
<div style=\"font-size:1px;line-height:10px\">&nbsp;</div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->

</body></html>";
                                }
                                else{

                                        $this -> Candidaturas_model -> update_candidatura('es_avaliador_curriculo', $this -> session -> uid,  $candidatura[0] -> pr_candidatura);
                                        $this -> Usuarios_model -> log('sucesso', 'Candidatos/AvaliacaoCurriculo', "Candidatura ".$candidatura[0] -> pr_candidatura." editada na análise curricular pelo usuário ".$this -> session -> uid.".", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                                }
                                if($this -> input -> post('salvar') == 'Salvar'){
                                        redirect($pagina['url']);
                                }
                                else{
                                        if($id_vaga>0){
                                                redirect('Vagas/resultado/'.$id_vaga);
                                        }
                                        else{
                                                redirect('Candidaturas/ListaAvaliacao');
                                        }
                                }
                        }
                }
                else{
                        $dados['sucesso'] = '';
                        $dados['erro'] = '';
                }


                $dados['respostas'] = $this -> Questoes_model -> get_respostas('', $candidatura[0] -> pr_candidatura);
                //$dados['vaga'] = $this -> Vagas_model -> get_vagas ($candidatura[0] -> es_vaga, false);
                $dados['candidatura'] = $this -> Candidaturas_model -> get_candidaturas ($candidatura[0] -> pr_candidatura);
                //$dados['anexo1'] = $this -> Anexos_model -> get_anexo ('', $candidatura[0] -> pr_candidatura, 1);
                /*$dados['anexo2'] = $this -> Anexos_model -> get_anexo ('', $candidatura[0] -> pr_candidatura, 2);
                $dados['anexo3'] = $this -> Anexos_model -> get_anexo ('', $candidatura[0] -> pr_candidatura, 3);*/
                $dados['formacoes'] = $this -> Candidaturas_model -> get_formacao(null,$candidatura[0] -> es_candidato,$candidatura[0]->pr_candidatura);
                if(isset($dados['formacoes'])){
                        foreach($dados['formacoes'] as $formacao){
                                $dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->pr_formacao,'', '');
                                if(!isset($dados['anexos'][$formacao->pr_formacao][0])){
                                        $dados['anexos'][$formacao->pr_formacao] =  $this -> Anexos_model -> get_anexo('', $formacao->es_formacao_pai,'', '');
                                }
                        }
                }

                $dados['experiencias'] = $this -> Candidaturas_model -> get_experiencia(null,$candidatura[0] -> es_candidato,$candidatura[0]->pr_candidatura);
                if(isset($dados['experiencias'])){
        				foreach($dados['experiencias'] as $experiencia){
        						$dados['anexos_experiencia'][$experiencia->pr_experienca] = $this -> Anexos_model -> get_anexo('', '','', '', $experiencia->pr_experienca);
        						if(!isset($dados['anexos_experiencia'][$experiencia->pr_experienca][0])){
                                        $dados['anexos_experiencia'][$experiencia->pr_experienca] =  $this -> Anexos_model -> get_anexo('', '','', '', $experiencia->es_experiencia_pai);
                                }
        				}
                }

                $dados['status'] = $this -> Candidaturas_model -> get_status ();
                $dados['opcoes'] = $this -> Questoes_model -> get_opcoes('', '', $candidatura[0] -> es_vaga);

		$dados['id_vaga'] = $id_vaga;

                $this -> load -> view('avaliacoes', $dados);
        }
        public function mostra_questoes($questoes, $respostas, $opcoes, $erro, $edit=true, $avaliador='', $anexos_questao=array()){
                if(isset($questoes)){
                        $x=0;
                        foreach ($questoes as $row){
                                $x++;
                                $res = "";
                                $codigo_resposta = "";
                                echo "
                                                                                                                                    <div class=\"form-group row\">
                                                                                                                                            <div class=\"col-md-12\">";
                                $attributes = array('class' => 'esquerdo control-label');
                                $label=$x.') '.strip_tags($row -> tx_questao);
                                //$label=$x.') '.$row -> tx_questao;
                                if($row -> bl_obrigatorio && $edit == true){
                                        $label.=' <abbr title="Obrigatório" class="text-danger">*</abbr>';
                                }
								if($row -> in_tipo == 7 && $edit == true){
										$label.=' (inserir arquivo pdf com tamanho máximo de 2MB)';
								}
                                echo form_label($label, 'Questao'.$row -> pr_questao, $attributes);
                                echo "
                                                                                                                                            </div>
                                                                                                                                            <div class=\"col-md-12\">";

                                if($respostas){
                                        foreach ($respostas as $row2){
                                                if(strlen($avaliador) == 0){
                                                        if($row2 -> es_questao == $row -> pr_questao){
                                                                $res = $row2 -> tx_resposta;
                                                                $codigo_resposta = $row2->pr_resposta;
                                                        }
                                                }
                                                else{
                                                        if($row2 -> es_questao == $row -> pr_questao && $row2 -> es_avaliador == $avaliador){
                                                                $res = $row2 -> tx_resposta;
                                                                $codigo_resposta = $row2->pr_resposta;

                                                        }
                                                }
                                        }
                                }

                                if($row -> es_etapa == 5 && $res == "" && $edit && $row -> in_tipo != 7){
                                        $res = '1';
                                }

                                if((strlen($res) == 0 && strlen(set_value('Questao'.$row -> pr_questao)) > 0) || (strlen(set_value('Questao'.$row -> pr_questao)) > 0 && $res != set_value('Questao'.$row -> pr_questao))){
                                        $res = set_value('Questao'.$row -> pr_questao);
                                }
                                if($row -> in_tipo == 1){ //customizadas
                                        if($edit){
                                                $valores = array(""=>"");
                                                foreach($opcoes as $opcao){
                                                        if($opcao->es_questao==$row -> pr_questao){
                                                                $valores[$opcao->pr_opcao]=$opcao->tx_opcao;
                                                        }
                                                }
                                                $required="";
                                                if($row -> bl_obrigatorio){
                                                        $required="required=\"required\"";
                                                }
                                                if(strstr($erro, "questão {$x} ")){
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control is-invalid\" {$required} id=\"Questao{$row -> pr_questao}\"");
                                                }
                                                else{
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" {$required} id=\"Questao{$row -> pr_questao}\"");
                                                }
                                        }
                                        else{
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'class' => 'form-control text-box single-line',
                                                                    'disabled' => 'disabled');
                                                $res2='';
                                                foreach ($opcoes as $row2){
                                                        if($row2 -> pr_opcao == $res){
                                                                $res2 = $row2 -> tx_opcao;
                                                        }
                                                }
                                                echo form_textarea($attributes, $res2);
                                        }
                                }
                                else if($row -> in_tipo == 2){ //aberta
                                        if($edit){

                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'rows'=>'5');
                                                if($row -> bl_obrigatorio){
                                                        $attributes['required']="required";
                                                }
                                                echo form_textarea($attributes, $res, 'class="form-control"');
                                        }
                                        else{
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'class' => 'form-control text-box single-line',
                                                                    'rows' => 3,
                                                                    'disabled' => 'disabled');
                                                echo form_textarea($attributes, $res);
                                        }
                                }
                                else if($row -> in_tipo == 3 || $row -> in_tipo == 4){ //sim e não
                                        if($edit){
                                                $required="";
                                                if($row -> bl_obrigatorio){
                                                        $required="required=\"required\"";
                                                }
                                                if($row -> in_tipo == 3){
                                                        $valores=array(""=>"",0=>"Não",1=>"Sim");
                                                }
                                                else{
                                                        $valores=array(""=>"",0=>"Sim",1=>"Não");
                                                }
                                                if(strstr($erro, "questão {$x} ")){
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control {$required} is-invalid\" id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control is-invalid\" id=\"{Questao'.$row -> pr_questao}\""
                                                }
                                                else{
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" {$required} id=\"Questao{$row -> pr_questao}\"");//, set_value('Questao'.$row -> pr_questao), "class=\"form-control\" id=\"{Questao'.$row -> pr_questao}\""
                                                }
                                        }
                                        else{
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'class' => 'form-control text-box single-line',
                                                                    'disabled' => 'disabled');
                                                if($row -> in_tipo == 3){
                                                        if($res == '1'){
                                                                $res = 'Sim';
                                                        }
                                                        else if($res == '0'){
                                                                $res = 'Não';
                                                        }
                                                }
                                                else{
                                                        if($res == '0'){
                                                                $res = 'Sim';
                                                        }
                                                        else if($res == '1'){
                                                                $res = 'Não';
                                                        }
                                                }
                                                echo form_input($attributes, $res);
                                        }
                                }
                                else if($row -> in_tipo == 5){ //níveis
                                        if($edit){
                                                $required="";
                                                if($row -> bl_obrigatorio){
                                                        $required="required=\"required\"";
                                                }
                                                $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
                                                if(strstr($erro, "questão {$x} ")){
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control {$required} is-invalid\" id=\"Questao{$row -> pr_questao}\"");
                                                }
                                                else{
                                                        echo form_dropdown('Questao'.$row -> pr_questao, $valores, $res, "class=\"form-control\" {$required} id=\"Questao{$row -> pr_questao}\"");
                                                }
                                        }
                                        else{
                                                $valores=array(0=>'Nenhum',1=>'Básico',2=>'Intermediário',3=>'Avançado',''=>'');
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'class' => 'form-control text-box single-line',
                                                                    'disabled' => 'disabled');
                                                echo form_input($attributes, $valores[$res]);
                                        }
                                }
                                else if($row -> in_tipo == 6){
                                        if($edit){
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                            'id'=>'Questao'.$row -> pr_questao,
                                                                            'maxlength'=>'1',
                                                                            'class' => 'form-control',
                                                                            'min' => '0',
                                                                            'max' => $row -> in_peso,
                                                                            'oninput' => "if(document.getElementById('Questao".$row -> pr_questao."').value>".$row -> in_peso."){document.getElementById('Questao".$row -> pr_questao."').value=".$row -> in_peso.";}else{if(document.getElementById('Questao".$row -> pr_questao."').value<0){document.getElementById('Questao".$row -> pr_questao."').value=0;}}",
                                                                            'type' => 'number');
                                                if($row -> bl_obrigatorio){
                                                        $attributes['required']="required";
                                                }
                                                echo form_input($attributes, $res);
                                        }
                                        else{
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'class' => 'form-control text-box single-line',
                                                                    'disabled' => 'disabled');
                                                echo form_input($attributes, $res);
                                        }
                                }
                                else if($row -> in_tipo == 7){ //upload
                                        $vc_anexo='';
                                        $pr_arquivo='';
                                        if($edit){
                                                $attributes = array('name' => 'Questao'.$row -> pr_questao,
                                                                    'class' => 'form-control',
                                                                    'onchange' => 'checkFile(this)',
                                                                    'style' => 'height: calc(1.5em + .75rem + 8px);');
                                                if($res == '1'){
                                                        if(isset($anexos_questao[$row -> pr_questao])){
                                                                $vc_anexo = $anexos_questao[$row -> pr_questao]->vc_arquivo;
                                                                $pr_arquivo = $anexos_questao[$row -> pr_questao]->pr_anexo;
																echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                                        }
                                                        else if($row -> bl_obrigatorio){
                                                                $attributes['required'] = 'required';
                                                        }
                                                        //echo '(já enviado anteriormente)';
                                                }
                                                else if($row -> bl_obrigatorio){
                                                        $attributes['required'] = 'required';
                                                }

                                                if(isset($erro) && strstr($erro, "questão {$x} ")){
                                                        $attributes['class']="form-control is-invalid";
                                                }
                                                echo form_upload($attributes);
                                        }
                                        else{
                                                if(isset($anexos_questao[$row -> pr_questao])){
                                                        $vc_anexo = $anexos_questao[$row -> pr_questao]->vc_arquivo;
                                                        $pr_arquivo = $anexos_questao[$row -> pr_questao]->pr_anexo;
														echo "<a href=\"".site_url('Interna/download/'.$pr_arquivo)."\"><button type=\"button\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-download\"></i> ".$vc_anexo."</button></a>";
                                                }

                                        }
                                }
                                echo form_hidden('codigo_resposta'.$row -> pr_questao, $codigo_resposta);
                                if(isset($erro) && strstr($erro, "questão {$x} ")){
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
        }
        public function eliminar_entrevista($id,$vaga=''){
                $this -> Candidaturas_model -> update_candidatura('es_status', 15,  $id);
                $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/eliminar_entrevista', "Candidatura {$id} eliminado por não comparecimento.", 'tb_candidaturas', $id);
                if(strlen($vaga) > 0){
                        redirect('Vagas/resultado/'.$vaga);
                }
                else{
                        redirect('Candidaturas/ListaAvaliacao/');
                }
        }
        public function delete_formacao($id){
                $this -> load -> model('Anexos_model');
                $this -> Anexos_model -> delete_anexo('','',$id,'');
                $this -> Candidaturas_model -> delete_formacao($id);
        }
        public function delete_experiencia($id){
                $this -> load -> model('Anexos_model');
                $this -> Anexos_model -> delete_anexo('','','','', $id);

                $this -> Candidaturas_model -> delete_experiencia($id);
        }
	public function delete(){
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='Candidaturas';
                $pagina['menu2']='delete';
                $pagina['url']='Candidatura/delete';
                $pagina['nome_pagina']='Desativar candidatura';
                $pagina['icone']='fa fa-check-square';

                $dados=$pagina;
                $candidatura = $this -> uri -> segment(3);

                $candidaturas = $this -> Candidaturas_model -> get_candidaturas($candidatura);
                if(strtotime($candidaturas[0] -> dt_fim) < time()){

                        $this -> Usuarios_model -> log('seguranca', 'Candidaturas/Prova', "Tentativa de exclusão da candidatura da ".$candidatura[0] -> pr_candidatura." fora do prazo.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        echo "<script type=\"text/javascript\">alert('Não pode excluir uma candidatura fora do prazo.');window.location='".base_url('Candidaturas/index/')."'</script>";
                        exit();
                }

                $this -> Candidaturas_model -> update_candidatura('bl_removido', '1', $candidatura);
                $dados['sucesso'] = "A candidatura foi desativada com sucesso.<br/><br/><a href=\"".base_url('Candidaturas/index/').'">Voltar</a></button>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/delete', "Candidatura {$candidatura} desativada pelo usuário ".$this -> session -> uid, 'tb_candidaturas', $candidatura);

                $this -> load -> view('candidaturas', $dados);
        }
        function calcula_nota($candidatura,$etapa){
                $this -> load -> model('Questoes_model');
                $this -> load -> model('Vagas_model');

                $candidaturas = $this -> Candidaturas_model -> get_candidaturas($candidatura);
                $vagas = $this -> Vagas_model -> get_vagas($candidaturas[0] -> es_vaga, false, 'object');

                $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, $etapa,'', true, '1');
                if(isset($questoes)){
                        foreach($questoes as $questao){
                                $opcoes[$questao -> pr_questao] = $this -> Questoes_model -> get_opcoes('', $questao -> pr_questao);
                        }
                }

                if($etapa == 3){
                        $respostas_query = $this -> Questoes_model -> get_respostas('', $candidatura, '', '',$etapa);
                        $respostas = array();
                        foreach($respostas_query as $resposta){
                                $respostas[$resposta -> es_questao] = $resposta;
                        }

                        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, $etapa,'', true, '<>2');
                        $total = 0;
                        foreach($questoes as $questao){
                                if($questao -> in_tipo == '1'){
                                        $nota = 0;
                                        foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                if(@$respostas[$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                        $nota += intval($opcao->in_valor);
                                                }
                                        }

                                        $total+=$nota;
                                }
                                else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                        $total+=@intval($respostas[$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                }
                                else if($questao -> in_tipo == '5'){
                                        $nota = round((@intval($respostas[$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                        $total+=$nota;
                                }
                                else if($questao -> in_tipo == '6'){
                                        $total+=@intval($respostas[$questao -> pr_questao] -> tx_resposta);
                                }
                        }

                        $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura,3);

                        if(isset($notas[0] -> pr_nota)){
                                if($notas[0] -> in_nota != $total){
                                        $this -> Candidaturas_model -> update_nota('in_nota',$total,$notas[0] -> pr_nota);
                                }
                        }
                        else{
                                $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total,'etapa'=>$etapa);
                                $this -> Candidaturas_model -> create_nota($dados_nota);
                        }
                }
                else if($etapa == 4){
                        $respostas_query = $this -> Questoes_model -> get_respostas('', $candidatura, '', '',$etapa);
                        $respostas = array();
                        foreach($respostas_query as $resposta){
                                if(strlen($resposta -> es_avaliador)>0){
                                        $respostas[$resposta -> es_avaliador][$resposta -> es_questao] = $resposta;
                                }
                        }

                        $questoes = $this -> Questoes_model -> get_questoes('', $vagas[0] -> es_grupoVaga, $etapa,'', true, '<>2');
                        $total = 0;
                        $total_competencia = array();
                        if(strlen($candidaturas[0] -> es_avaliador_competencia1) >0){
                                $total1 = 0;
                                $total_competencia1 = array();
                                foreach($questoes as $questao){
                                        if(!isset($total_competencia[$questao->es_competencia])){
                                                $total_competencia[$questao->es_competencia]=0;
                                        }
                                        if(!isset($total_competencia1[$questao->es_competencia])){
                                                $total_competencia1[$questao->es_competencia]=0;
                                        }
                                        if($questao -> in_tipo == '1'){
                                                $nota = 0;
                                                foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                        if(@$respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                //echo $opcao->in_valor;
                                                                $nota += intval($opcao->in_valor);
                                                        }
                                                }

                                                $total+=$nota;
                                                $total1+=$nota;
                                                $total_competencia[$questao->es_competencia]+=$nota;
                                                $total_competencia1[$questao->es_competencia]+=$nota;
                                        }
                                        else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                                $total+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total1+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total_competencia[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total_competencia1[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                        }
                                        else if($questao -> in_tipo == '5'){
                                                $nota = round((@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));

                                                $total+=$nota;
                                                $total1+=$nota;
                                                $total_competencia[$questao->es_competencia]+=$nota;
                                                $total_competencia1[$questao->es_competencia]+=$nota;
                                        }
                                        else if($questao -> in_tipo == '6'){
                                                $total+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta);
                                                $total1+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta);
                                                $total_competencia[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta);
                                                $total_competencia1[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia1][$questao -> pr_questao] -> tx_resposta);
                                        }
                                }

                                $notas1 = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,'','',$candidaturas[0] -> es_avaliador_competencia1);

                                if(isset($notas1[0] -> pr_nota)){
                                        if($notas1[0] -> in_nota != $total1){
                                                $this -> Candidaturas_model -> update_nota('in_nota',$total1,$notas1[0] -> pr_nota);
                                        }
                                }
                                else{
                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total1,'etapa'=>$etapa,'avaliador'=>$candidaturas[0] -> es_avaliador_competencia1);
                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                }

                                if(count($total_competencia1) > 0){
                                        $chaves = array_keys($total_competencia1);
                                        foreach($chaves as $chave){
                                                $notas11 = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,$chave,'',$candidaturas[0] -> es_avaliador_competencia1);

                                                if(isset($notas11[0] -> pr_nota)){
                                                        if($notas11[0] -> in_nota != $total_competencia1[$chave]){
                                                              $this -> Candidaturas_model -> update_nota('in_nota',$total_competencia1[$chave],$notas11[0] -> pr_nota);
                                                        }
                                                }
                                                else{
                                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total_competencia1[$chave],'etapa'=>$etapa,'competencia'=>$chave,'avaliador'=>$candidaturas[0] -> es_avaliador_competencia1);
                                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                                }
                                        }
                                }
                        }
                        if(strlen($candidaturas[0] -> es_avaliador_competencia2) >0){
                                $total2 = 0;
                                $total_competencia2 = array();
                                foreach($questoes as $questao){
                                        if(!isset($total_competencia[$questao->es_competencia])){
                                                $total_competencia[$questao->es_competencia]=0;
                                        }
                                        if(!isset($total_competencia2[$questao->es_competencia])){
                                                $total_competencia2[$questao->es_competencia]=0;
                                        }
                                        if($questao -> in_tipo == '1'){
                                                $nota = 0;
                                                foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                        if(@$respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                //echo $opcao->in_valor;
                                                                $nota += intval($opcao->in_valor);
                                                        }
                                                }

                                                $total+=$nota;
                                                $total2+=$nota;
                                                $total_competencia[$questao->es_competencia]+=$$nota;
                                                $total_competencia2[$questao->es_competencia]+=$$nota;
                                        }
                                        else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){

                                                $total+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total2+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total_competencia[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total_competencia2[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                        }
                                        else if($questao -> in_tipo == '5'){
                                                $nota = round((@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                                $total+=$nota;
                                                $total2+=$nota;
                                                $total_competencia[$questao->es_competencia]+=$nota;
                                                $total_competencia2[$questao->es_competencia]+=$nota;
                                        }
                                        else if($questao -> in_tipo == '6'){
                                                $total+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta);
                                                $total2+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta);
                                                $total_competencia[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta);
                                                $total_competencia2[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia2][$questao -> pr_questao] -> tx_resposta);
                                        }

                                }
                                $notas2 = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,'','',$candidaturas[0] -> es_avaliador_competencia2);

                                if(isset($notas2[0] -> pr_nota)){
                                        if($notas2[0] -> in_nota != $total2){
                                                $this -> Candidaturas_model -> update_nota('in_nota',$total2,$notas2[0] -> pr_nota);
                                        }
                                }
                                else{
                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total2,'etapa'=>$etapa,'avaliador'=>$candidaturas[0] -> es_avaliador_competencia2);
                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                }
                                if(count($total_competencia2) > 0){
                                        $chaves = array_keys($total_competencia2);
                                        foreach($chaves as $chave){
                                                $notas22 = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,$chave,'',$candidaturas[0] -> es_avaliador_competencia2);

                                                if(isset($notas22[0] -> pr_nota)){
                                                        if($notas22[0] -> in_nota != $total_competencia2[$chave]){
                                                              $this -> Candidaturas_model -> update_nota('in_nota',$total_competencia2[$chave],$notas22[0] -> pr_nota);
                                                        }
                                                }
                                                else{
                                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total_competencia2[$chave],'etapa'=>$etapa,'competencia'=>$chave,'avaliador'=>$candidaturas[0] -> es_avaliador_competencia2);
                                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                                }
                                        }
                                }
                        }

                        if(strlen($candidaturas[0] -> es_avaliador_competencia3) >0){
                                $total3 = 0;
                                $total_competencia3 = array();
                                foreach($questoes as $questao){
                                        if(!isset($total_competencia[$questao->es_competencia])){
                                                $total_competencia[$questao->es_competencia]=0;
                                        }
                                        if(!isset($total_competencia3[$questao->es_competencia])){
                                                $total_competencia3[$questao->es_competencia]=0;
                                        }
                                        if($questao -> in_tipo == '1'){
                                                $nota = 0;
                                                foreach($opcoes[$questao -> pr_questao] as $opcao){
                                                        if(@$respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta==$opcao->pr_opcao){
                                                                //echo $opcao->in_valor;
                                                                $nota += intval($opcao->in_valor);
                                                        }
                                                }

                                                $total+=$nota;
                                                $total3+=$nota;
                                                $total_competencia[$questao->es_competencia]+=$nota;
                                                $total_competencia3[$questao->es_competencia]+=$nota;
                                        }
                                        else if($questao -> in_tipo == '3' || $questao -> in_tipo == '4'){
                                                $total+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total3+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total_competencia[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                                $total_competencia3[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta) * intval($questao -> in_peso);
                                        }
                                        else if($questao -> in_tipo == '5'){
                                                $nota = round((@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta)/3)*intval($questao->in_peso));
                                                $total+=$nota;
                                                $total3+=$nota;
                                                $total_competencia[$questao->es_competencia]+=$nota;
                                                $total_competencia3[$questao->es_competencia]+=$nota;
                                        }
                                        else if($questao -> in_tipo == '6'){
                                                $total+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta);
                                                $total3+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta);
                                                $total_competencia[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta);
                                                $total_competencia3[$questao->es_competencia]+=@intval($respostas[$candidaturas[0] -> es_avaliador_competencia3][$questao -> pr_questao] -> tx_resposta);
                                        }
                                }
                                $notas3 = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,'','',$candidaturas[0] -> es_avaliador_competencia3);

                                if(isset($notas3[0] -> pr_nota)){
                                        if($notas3[0] -> in_nota != $total3){
                                                $this -> Candidaturas_model -> update_nota('in_nota',$total3,$notas3[0] -> pr_nota);
                                        }
                                }
                                else{
                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total3,'etapa'=>$etapa,'avaliador'=>$candidaturas[0] -> es_avaliador_competencia3);
                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                }
                                if(count($total_competencia3) > 0){
                                        $chaves = array_keys($total_competencia3);
                                        foreach($chaves as $chave){
                                                $notas33 = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,$chave,'',$candidaturas[0] -> es_avaliador_competencia3);

                                                if(isset($notas33[0] -> pr_nota)){
                                                        if($notas33[0] -> in_nota != $total_competencia3[$chave]){
                                                              $this -> Candidaturas_model -> update_nota('in_nota',$total_competencia3[$chave],$notas33[0] -> pr_nota);
                                                        }

                                                }
                                                else{
                                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total_competencia3[$chave],'etapa'=>$etapa,'competencia'=>$chave,'avaliador'=>$candidaturas[0] -> es_avaliador_competencia3);
                                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                                }
                                        }
                                }
                        }
                        $avaliado_1 = ($candidaturas[0] -> in_quant_avaliadores == 1 && strlen($candidaturas[0] -> es_avaliador_competencia1) >0);
                        $avaliado_2 = ($candidaturas[0] -> in_quant_avaliadores == 2 && strlen($candidaturas[0] -> es_avaliador_competencia1) >0 && strlen($candidaturas[0] -> es_avaliador_competencia2) >0);
                        $avaliado_3 = ($candidaturas[0] -> in_quant_avaliadores == 3 && strlen($candidaturas[0] -> es_avaliador_competencia1) >0 && strlen($candidaturas[0] -> es_avaliador_competencia2) >0 && strlen($candidaturas[0] -> es_avaliador_competencia3) >0);
                        if($avaliado_1 || $avaliado_2 || $avaliado_3){
                                $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa);

                                $total = round($total/$candidaturas[0] -> in_quant_avaliadores);

                                if(isset($notas[0] -> pr_nota)){
                                        if($notas[0] -> in_nota != $total){
                                              $this -> Candidaturas_model -> update_nota('in_nota',$total,$notas[0] -> pr_nota);
                                        }
                                }
                                else{
                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total,'etapa'=>$etapa);
                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                }

                                if(count($total_competencia) > 0){
                                        $chaves = array_keys($total_competencia);
                                        foreach($chaves as $chave){
                                                $notas = $this -> Candidaturas_model -> get_nota ('',$candidatura,$etapa,$chave);
                                                $total_competencia[$chave] = round($total_competencia[$chave]/$candidaturas[0] -> in_quant_avaliadores);
                                                if(isset($notas[0] -> pr_nota)){
                                                        if($notas[0] -> in_nota != $total_competencia[$chave]){
                                                              $this -> Candidaturas_model -> update_nota('in_nota',$total_competencia[$chave],$notas[0] -> pr_nota);
                                                        }

                                                }
                                                else{
                                                        $dados_nota=array('candidatura'=>$candidatura,'nota'=>$total_competencia[$chave],'etapa'=>$etapa,'competencia'=>$chave);
                                                        $this -> Candidaturas_model -> create_nota($dados_nota);
                                                }
                                        }
                                }
                        }

                }

        }

        function script_excluir_anexo(){
                if($this -> session -> perfil == 'administrador'){
                        $this -> load -> model('Questoes_model');
                        $this -> load -> model('Anexos_model');
                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '7, 8, 9, 10 ,11 12, 13, 20');
                        $array_pendente=array();
                        foreach($candidaturas as $candidatura){
                                if($candidatura -> es_vaga != '94' && $candidatura -> es_vaga != '95' && $candidatura -> es_vaga != '96' && $candidatura -> es_vaga != '113'){
                                        $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                        $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);
                                        $questoes = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, '1', '', true, '7');

                                        foreach($questoes as $questao){
                                                $anexos = $this -> Anexos_model -> get_anexo('', '', $candidatura->pr_candidatura,'','',$questao->pr_questao);
                                                //$anexos = 1;
                                                if(!isset($anexos)){
                                                        echo $candidatura->pr_candidatura,";",$candidato -> vc_nome,";",$candidato -> ch_cpf,";",$candidato -> vc_email,";",$vaga[0]->vc_vaga,"<br />";
                                                        break;
                                                }
                                        }
                                }
                        }
                }
        }

        function script_confirmado(){
                if($this -> session -> perfil == 'administrador'){
                        $this -> load -> model('Questoes_model');
                        $this -> load -> model('Anexos_model');
                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '6');

                        foreach($candidaturas as $candidatura){
                                if($candidatura -> es_vaga != '94' && $candidatura -> es_vaga != '95' && $candidatura -> es_vaga != '96' && $candidatura -> es_vaga != '113'){
                                        $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                        $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);
                                        if(isset($candidato)){
                                                echo $candidatura->pr_candidatura,";",$candidato -> vc_nome,";",$candidato -> ch_cpf,";",$candidato -> vc_email,";",$vaga[0]->vc_vaga,"<br />";
                                        }
                                }
                        }
                }
        }

        function script_alterar_candidatura(){
                if($this -> session -> perfil == 'administrador'){
                        $this -> load -> model('Questoes_model');
                        $this -> load -> model('Anexos_model');
                        $this -> load -> library('email');

                        $config['protocol'] = 'smpt';
                        $config['charset'] = 'UTF-8';
                        $config['smtp_port'] = 25;
                        $config['smtp_host'] = $this -> config -> item('smtp_host');
                        $config['smtp_user'] = $this -> config -> item('smtp_user');
                        $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                        $config['wordwrap'] = TRUE;
                        $config['mailtype'] = 'html';

                        $this->email->initialize($config);

                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '7, 8, 9, 10 ,11 12, 13, 20');
                        foreach($candidaturas as $candidatura){
                                if($candidatura -> es_vaga != '94' && $candidatura -> es_vaga != '95' && $candidatura -> es_vaga != '96' && $candidatura -> es_vaga != '113'){
                                        $envio_email = false;
                                        $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);
                                        $questoes1 = $this -> Questoes_model -> get_questoes('', $vaga[0] -> es_grupoVaga, 1);
                                        foreach($questoes1 as $questao){
                                                $respostas = $this -> Questoes_model -> get_respostas('', $candidatura -> pr_candidatura, $questao->pr_questao);
                                                if(!isset($respostas)){
                                                        $envio_email = true;
                                                        break;
                                                }
                                        }

                                        $formacoes = $this -> Candidaturas_model -> get_formacao(null,$candidatura -> es_candidato,$candidatura->pr_candidatura);
                                        if(!isset($formacoes) || count($formacoes)==0){
                                                $envio_email = true;
                                        }

                                        if(isset($formacoes) && count($formacoes)>0){
                                                foreach($formacoes as $formacao){
                                                        $anexos = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                                        if(!isset($anexos)){
                                                                $anexos = $this -> Anexos_model -> get_anexo('',$formacao->es_formacao_pai);
                                                                if(!isset($anexos)){
                                                                        $envio_email = true;
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }

                                        $experiencias = $this -> Candidaturas_model -> get_experiencia(null,$candidatura -> es_candidato,$candidatura->pr_candidatura);
                                        if(!isset($experiencias) || count($experiencias)==0){
                                                $envio_email = true;
                                        }

                                        if(isset($experiencias) && count($experiencias)>0){
                                                foreach($experiencias as $experiencia){
                                                        $anexos = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                                        if(!isset($anexos)){
                                                                $anexos = $this -> Anexos_model -> get_anexo('','','','',$experiencia->es_experiencia_pai);
                                                                if(!isset($anexos)){
                                                                        $envio_email = true;
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }

                                        if($envio_email == true){
                                                $this -> Candidaturas_model -> update_candidatura('es_status', 1,  $candidatura -> pr_candidatura);
                                                //update `tb_candidaturas` set es_status = 7 where es_vaga not in (94,95,96,113);

                                                $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                                if(isset($candidato)){
                                                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                        $this -> email -> to($candidato -> vc_email);
                                                        $this -> email -> to('edital.brumadinho@planejamento.mg.gov.br');
                                                        $this -> email -> subject('['.$this -> config -> item('nome').'] IMPORTANTE');



                                                        //$msg = "Prezado candidato(a) {$candidato->vc_nome}, sua candidatura está com dados incompletos e precisa ser refeita.";
                                                        $msg = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->

<meta content=\"width=device-width\" name=\"viewport\">
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\">
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
	<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
	<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		.botao:hover{
			background-color: #718066 !important;
		}

		.aqui:hover{
			color: #DF2935 !important;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#304025;font-family:&#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; color: #304025; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; word-break: break-word; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Processos Seletivos MG</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Candidatura Pendente</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a)&nbsp;<strong>".$candidato -> vc_nome."</strong>, sua candidatura para a vaga <strong>".$vaga[0] -> vc_vaga."</strong> se encontra pendente no sistema e está disponível para revisão e edição.</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Para continuar o processo, você deverá entrar no sistema e revisar se todos os campos obrigatórios já foram preenchidos. Se houver algum campo obrigatório não preenchido, favor preenchê-los e inserir os devidos comprovantes para que seja possível concluir a candidatura e esta seja reconhecida pelo sistema.<br><br>Caso não seja readequada em tempo hábil, a candidatura não será deferida no sistema.
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>


<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão abaixo:</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://processoseletivo.mg.gov.br/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#304025\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #304025; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #304025; border-right: 1px solid #304025; border-bottom: 1px solid #304025; border-left: 1px solid #304025; padding-top: 10px; padding-bottom: 10px; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.8; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Em caso de dúvidas, entre em contato com a equipe pelo Fale Conosco da página inicial do sistema.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\">
<div style=\"font-size:1px;line-height:10px\">&nbsp;</div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->

</body></html>";
                                                        $this -> email -> message($msg);
                                                        if(!$this -> email -> send()){
                                                                $this -> Usuarios_model -> log('erro', 'Candidaturas/script_alterar_candidatura', "Erro de envio de solicitação para refazer a candidatura para o e-mail {$candidato ->vc_email} do candidato {$candidato -> pr_candidato}.", 'tb_candidaturas', $candidatura -> pr_candidatura);
                                                        }
                                                        echo $candidato -> vc_nome,";",$candidato -> vc_email,";",$candidato -> vc_telefone,";",$vaga[0] -> vc_vaga,"<br />";
                                                }
                                        }
                                }
                        }
                }
        }
        function script_verificar_candidatura(){
                if($this -> session -> perfil == 'administrador'){
                        $this -> load -> model('Questoes_model');
                        $this -> load -> model('Anexos_model');
                        $this -> load -> library('email');

                        $config['protocol'] = 'smpt';
                        $config['charset'] = 'UTF-8';
                        $config['smtp_port'] = 25;
                        $config['smtp_host'] = $this -> config -> item('smtp_host');
                        $config['smtp_user'] = $this -> config -> item('smtp_user');
                        $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                        $config['wordwrap'] = TRUE;
                        $config['mailtype'] = 'html';

                        $this->email->initialize($config);

                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '6, 7, 8, 9, 10 ,11 12, 13, 20');
                        foreach($candidaturas as $candidatura){
                                if($candidatura -> es_vaga == '141' || $candidatura -> es_vaga == '142' || $candidatura -> es_vaga == '143' || $candidatura -> es_vaga == '144' || $candidatura -> es_vaga == '145' || $candidatura -> es_vaga == '146' || $candidatura -> es_vaga == '147' || $candidatura -> es_vaga == '148' || $candidatura -> es_vaga == '149' || $candidatura -> es_vaga == '150' || $candidatura -> es_vaga == '151' || $candidatura -> es_vaga == '152' || $candidatura -> es_vaga == '153' || $candidatura -> es_vaga == '154' || $candidatura -> es_vaga == '155' || $candidatura -> es_vaga == '156' || $candidatura -> es_vaga == '157' || $candidatura -> es_vaga == '158' || $candidatura -> es_vaga == '159' || $candidatura -> es_vaga == '160' || $candidatura -> es_vaga == '161' || $candidatura -> es_vaga == '162' || $candidatura -> es_vaga == '163' || $candidatura -> es_vaga == '164' || $candidatura -> es_vaga == '165' || $candidatura -> es_vaga == '166' || $candidatura -> es_vaga == '167' || $candidatura -> es_vaga == '168' || $candidatura -> es_vaga == '169' || $candidatura -> es_vaga == '170' || $candidatura -> es_vaga == '171' || $candidatura -> es_vaga == '172' || $candidatura -> es_vaga == '173' || $candidatura -> es_vaga == '174' || $candidatura -> es_vaga == '175' || $candidatura -> es_vaga == '176' || $candidatura -> es_vaga == '177' || $candidatura -> es_vaga == '178'){
                                        $envio_email = false;
                                        $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);

                                        $formacoes = $this -> Candidaturas_model -> get_formacao(null,$candidatura -> es_candidato,$candidatura->pr_candidatura);
                                        if(!isset($formacoes) || count($formacoes)==0){
                                                $envio_email = true;
                                        }

                                        if(isset($formacoes) && count($formacoes)>0){
                                                foreach($formacoes as $formacao){
                                                        $anexos = $this -> Anexos_model -> get_anexo('',$formacao->pr_formacao);
                                                        if(!isset($anexos)){
                                                                $anexos = $this -> Anexos_model -> get_anexo('',$formacao->es_formacao_pai);
                                                                if(!isset($anexos)){
                                                                        $envio_email = true;
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }

                                        $experiencias = $this -> Candidaturas_model -> get_experiencia(null,$candidatura -> es_candidato,$candidatura->pr_candidatura);
                                        if(!isset($experiencias) || count($experiencias)==0){
                                                $envio_email = true;
                                        }

                                        if(isset($experiencias) && count($experiencias)>0){
                                                foreach($experiencias as $experiencia){
                                                        $anexos = $this -> Anexos_model -> get_anexo('','','','',$experiencia->pr_experienca);
                                                        if(!isset($anexos)){
                                                                $anexos = $this -> Anexos_model -> get_anexo('','','','',$experiencia->es_experiencia_pai);
                                                                if(!isset($anexos)){
                                                                        $envio_email = true;
                                                                        break;
                                                                }
                                                        }
                                                }
                                        }

                                        if($envio_email == true){
                                                $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                                if(isset($candidato)){
                                                        echo $candidatura->pr_candidatura.";".$candidato -> vc_nome,";",$candidato -> vc_email,";",$candidato -> vc_telefone,";",$vaga[0] -> vc_vaga,"<br />";
                                                }
                                        }
                                }
                        }
                }
        }
        function script_aviso_encerramento(){
                if($this -> session -> perfil == 'administrador'){
                        $this -> load -> model('Questoes_model');
                        $this -> load -> model('Anexos_model');
                        $this -> load -> library('email');

                        $config['protocol'] = 'smpt';
                        $config['charset'] = 'UTF-8';
                        $config['smtp_port'] = 25;
                        $config['smtp_host'] = $this -> config -> item('smtp_host');
                        $config['smtp_user'] = $this -> config -> item('smtp_user');
                        $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                        $config['wordwrap'] = TRUE;
                        $config['mailtype'] = 'html';

                        $this->email->initialize($config);

                        $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '1,4,6');
                        $i=0;
                        foreach($candidaturas as $candidatura){
                                if($candidatura -> es_vaga == '125' || $candidatura -> es_vaga == '126' || $candidatura -> es_vaga == '127' || $candidatura -> es_vaga == '128' || $candidatura -> es_vaga == '129' || $candidatura -> es_vaga == '130' || $candidatura -> es_vaga == '131' || $candidatura -> es_vaga == '132' || $candidatura -> es_vaga == '133' || $candidatura -> es_vaga == '134' || $candidatura -> es_vaga == '135' || $candidatura -> es_vaga == '136' || $candidatura -> es_vaga == '137' || $candidatura -> es_vaga == '138'){
                                        ++$i;
                                        if($i<526){
                                                continue;
                                        }

                                        $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);
                                        //$this -> Candidaturas_model -> update_candidatura('es_status', 1,  $candidatura -> pr_candidatura);
                                        //update `tb_candidaturas` set es_status = 7 where es_vaga not in (94,95,96,113);

                                        $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                        if(isset($candidato)){
                                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                $this -> email -> to($candidato -> vc_email);
                                                $this -> email -> to('edital.brumadinho@social.mg.gov.br');

                                                $avaliadores = $this -> Vagas_model -> get_vagas_avaliadores($candidatura -> es_vaga);
                                                if(isset($avaliadores)){
                                                        foreach($avaliadores as $avaliador){
                                                                $usuario = $this -> Usuarios_model -> get_usuarios($avaliador->es_usuario);
                                                                if(isset($usuario)){
                                                                        $this -> email -> to($usuario -> vc_email);
                                                                }
                                                        }
                                                }

                                                $this -> email -> subject('['.$this -> config -> item('nome').'] IMPORTANTE');

                                                //$msg = "Prezado candidato(a) {$candidato->vc_nome}, sua candidatura está com dados incompletos e precisa ser refeita.";
                                                $msg = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->

<meta content=\"width=device-width\" name=\"viewport\">
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\">
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
        body {
                margin: 0;
                padding: 0;
        }

        table,
        td,
        tr {
                vertical-align: top;
                border-collapse: collapse;
        }

        * {
                line-height: inherit;
        }

        .botao:hover{
                background-color: #02182B !important;
        }

        .aqui:hover{
                color: #DF2935 !important;
        }

        a[x-apple-data-detectors=true] {
                color: inherit !important;
                text-decoration: none !important;
        }
</style>
<style id=\"media-query\" type=\"text/css\">
        @media (max-width: 620px) {

                .block-grid,
                .col {
                        min-width: 320px !important;
                        max-width: 100% !important;
                        display: block !important;
                }

                .block-grid {
                        width: 100% !important;
                }

                .col {
                        width: 100% !important;
                }

                .col>div {
                        margin: 0 auto;
                }

                img.fullwidth,
                img.fullwidthOnMobile {
                        max-width: 100% !important;
                }

                .no-stack .col {
                        min-width: 0 !important;
                        display: table-cell !important;
                }

                .no-stack.two-up .col {
                        width: 50% !important;
                }

                .no-stack .col.num4 {
                        width: 33% !important;
                }

                .no-stack .col.num8 {
                        width: 66% !important;
                }

                .no-stack .col.num4 {
                        width: 33% !important;
                }

                .no-stack .col.num3 {
                        width: 25% !important;
                }

                .no-stack .col.num6 {
                        width: 50% !important;
                }

                .no-stack .col.num9 {
                        width: 75% !important;
                }

                .video-block {
                        max-width: none !important;
                }

                .mobile_hide {
                        min-height: 0px;
                        max-height: 0px;
                        max-width: 0px;
                        display: none;
                        overflow: hidden;
                        font-size: 0px;
                }

                .desktop_hide {
                        display: block !important;
                        max-height: none !important;
                }
        }
</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
        <div style=\"font-size: 18px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #555555; mso-line-height-alt: 21px;\">
        <p style=\"font-size: 46px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #6AA1CA; font-size: 46px;\"><strong>Processos Seletivos Minas</strong></span></p>
        <p style=\"font-size: 20px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #6AA1CA;\"><strong>Sistema de Gestão de Recrutamentos</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Candidatura Pendente</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato->vc_nome}</strong>, informamos que o prazo de inscrições para as vagas do Edital SEDESE nº 01/2020 foi prorrogado até 28/05 18:00 para adaptação e conclusão de candidaturas pendentes iniciadas até o dia 25/05 23:59. Você possui candidatura não concluída no sistema e, para que ela seja considerada para efeitos de participação no Processo Seletivo Simplificado, será necessário finalizá-la em tempo hábil.</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Você deverá acessar o sistema e revisar/preencher o formulário das etapas de requisitos obrigatórios e, se todos os campos obrigatórios já tiverem sido preenchidos, clicar no botão \"Concluir\" na etapa requisitos desejáveis.
<br><br>
Se houver algum campo obrigatório não preenchido, favor preenchê-lo e inserir a documentação comprobatória para que sua candidatura seja reconhecida pelo sistema como concluída.
<br><br>
O manual do sistema encontra-se disponível no site da SEDESE para orientações em relação ao sistema.
<br><br>
Caso tenha algum problema, gentileza encaminhar email para <strong> edital.brumadinho@social.mg.gov.br</strong> contendo nome completo, cpf, vaga pra a qual se candidatou, descrição do problema/erro, print das telas exibindo o problema retratado ou a mensagem de erro do sistema e os PDF's que tentou inserir.
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>


<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão abaixo:</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"https://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#6AA1CA\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"https://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #6AA1CA; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #6AA1CA; border-right: 1px solid #6AA1CA; border-bottom: 1px solid #6AA1CA; border-left: 1px solid #6AA1CA; padding-top: 10px; padding-bottom: 10px; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.8; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"http://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\">
<div style=\"font-size:1px;line-height:10px\">&nbsp;</div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->

</body></html>";
                                                $this -> email -> message($msg);
                                                if(!$this -> email -> send()){
                                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/script_alterar_candidatura', "Erro de envio de solicitação para refazer a candidatura para o e-mail {$candidato ->vc_email} do candidato {$candidato -> pr_candidato}.", 'tb_candidaturas', $candidatura -> pr_candidatura);
                                                }
                                                echo $candidato -> vc_nome,";",$candidato -> vc_email,";",$candidato -> vc_telefone,";",$vaga[0] -> vc_vaga,"<br />";
                                        }
                                }
                        }
                }
        }
        function script_unica_candidatura(){
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '7');
                $array_candidaturas=array();
                foreach($candidaturas as $candidatura){
                        if($candidatura -> es_vaga == '235' || $candidatura -> es_vaga == '236' || $candidatura -> es_vaga == '237' || $candidatura -> es_vaga == '238' || $candidatura -> es_vaga == '239' || $candidatura -> es_vaga == '240' ||  $candidatura -> es_vaga == '241' || $candidatura -> es_vaga == '242' ||  $candidatura -> es_vaga == '243' ||  $candidatura -> es_vaga == '244' ||  $candidatura -> es_vaga == '245' ||  $candidatura -> es_vaga == '246' ||  $candidatura -> es_vaga == '247' ||  $candidatura -> es_vaga == '248' ||  $candidatura -> es_vaga == '249' ||  $candidatura -> es_vaga == '250'){
                                $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);
                                $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                if(isset($candidato)){
                                        if(!isset($array_candidaturas[$candidatura -> es_candidato])){
                                                $array_candidaturas[$candidatura -> es_candidato] = $candidatura -> es_candidato;
                                                echo $candidato -> vc_nome,";",$candidato -> vc_email,";",$candidato -> vc_telefone,";",str_replace(";",",",$vaga[0] -> vc_vaga),"<br />";
                                        }
                                        else{
                                                echo $candidato -> vc_nome,"(removido);",$candidato -> vc_email,";",$candidato -> vc_telefone,";",str_replace(";",",",$vaga[0] -> vc_vaga),"<br />";
                                                $this -> Candidaturas_model -> update_candidatura('bl_removido', '1', $candidatura -> pr_candidatura);
                                        }
                                }
                        }
                }
        }
        function script_unica_candidatura2(){
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', '','' , '7');
                $array_candidaturas=array();
                $atual = strtotime('2020-07-03 13:15:13');

                $this -> load -> library('email');

                $config['protocol'] = 'smpt';
                $config['charset'] = 'UTF-8';
                $config['smtp_port'] = 25;
                $config['smtp_host'] = $this -> config -> item('smtp_host');
                $config['smtp_user'] = $this -> config -> item('smtp_user');
                $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                $config['wordwrap'] = TRUE;

                $config['mailtype'] = 'html';

                $this->email->initialize($config);

                foreach($candidaturas as $candidatura){
                        $data_realizada = strtotime($candidatura -> dt_realizada);

                        //|| $candidatura -> es_vaga == '196'
                        if(($candidatura -> es_vaga == '192' || $candidatura -> es_vaga == '193' || $candidatura -> es_vaga == '194' || $candidatura -> es_vaga == '195') && $atual > $data_realizada){
                                $vaga = $this -> Vagas_model -> get_vagas($candidatura -> es_vaga, false);


                                $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura -> es_candidato);
                                if(isset($candidato)){
                                        $this -> Candidaturas_model -> update_candidatura('es_status', 1,  $candidatura -> pr_candidatura);
                                        //$this -> Candidaturas_model -> update_candidatura();
                                        echo $candidato -> vc_nome,";",$candidato -> ch_cpf,";",$candidato -> vc_email,";",$candidato -> vc_telefone,";",str_replace(";",",",$vaga[0] -> vc_vaga),";",$candidatura -> dt_cadastro,";",$candidatura -> dt_realizada,"<br />";

                                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                        $this -> email -> to($candidato -> vc_email);
                                        $this -> email -> to('edital.brumadinho@planejamento.mg.gov.br');

                                        $this -> email -> subject('['.$this -> config -> item('nome').'] IMPORTANTE');

                                        //$msg = "Prezado candidato(a) {$candidato->vc_nome}, sua candidatura está com dados incompletos e precisa ser refeita.";
                                        $msg = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->

<meta content=\"width=device-width\" name=\"viewport\">
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\">
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
    <link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
        body {
            margin: 0;
            padding: 0;
        }

        table,
        td,
        tr {
            vertical-align: top;
            border-collapse: collapse;
        }

        * {
            line-height: inherit;
        }

        .botao:hover{
            background-color: #02182B !important;
        }

        .aqui:hover{
            color: #DF2935 !important;
        }

        a[x-apple-data-detectors=true] {
            color: inherit !important;
            text-decoration: none !important;
        }
    </style>
<style id=\"media-query\" type=\"text/css\">
        @media (max-width: 620px) {

            .block-grid,
            .col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col>div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }

            .no-stack .col {
                min-width: 0 !important;
                display: table-cell !important;
            }

            .no-stack.two-up .col {
                width: 50% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num8 {
                width: 66% !important;
            }

            .no-stack .col.num4 {
                width: 33% !important;
            }

            .no-stack .col.num3 {
                width: 25% !important;
            }

            .no-stack .col.num6 {
                width: 50% !important;
            }

            .no-stack .col.num9 {
                width: 75% !important;
            }

            .video-block {
                max-width: none !important;
            }

            .mobile_hide {
                min-height: 0px;
                max-height: 0px;
                max-width: 0px;
                display: none;
                overflow: hidden;
                font-size: 0px;
            }

            .desktop_hide {
                display: block !important;
                max-height: none !important;
            }
        }
    </style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
    <div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
        <div style=\"font-size: 18px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #555555; mso-line-height-alt: 21px;\">
        <p style=\"font-size: 46px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #6AA1CA; font-size: 46px;\"><strong>Processos Seletivos Minas</strong></span></p>
        <p style=\"font-size: 20px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #6AA1CA;\"><strong>Sistema de Gestão de Recrutamentos</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Candidatura liberada para edição!</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a)&nbsp;<strong>{$candidato -> vc_nome}</strong>, sua candidatura para a vaga <strong>{$vaga[0] -> vc_vaga}</strong> está disponível para revisão e edição.</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Com relação ao Anexo II - Critérios de Análise Curricular e Pontuação para o cargo Pesquisador, esclarecemos que fizemos o ajuste no sistema, conforme especificado abaixo, para que os candidatos possam incluir suas respectivas produções científicas no ato da inscrição.
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Para os candidatos(as) que já fizeram suas inscrições e não fizeram a inclusão de sua produção científica para avaliação e pontuação, estamos abrindo a edição da candidatura a uma das vagas, para que, seguindo os passos aqui estabelecidos, possam fazer a devida inclusão e em seguida sua inscrição seja finalizada.
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Orientações específicas vagas pesquisador EPAMIG:</strong>
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 2.1; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Utilize o campo Formação Acadêmica para preencher e anexar as informações referentes às suas Produções Científicas e Tecnológicas a partir de 2010 como autor ou coautor.</br></br>
Para cada Produção Científica a ser inserida siga os passos a seguir:</br></br>
 <b>1. Clique no item Adicionar Formação.</b></br>
 <b>2. Preencha o campo TIPO com a opção PRODUÇÃO CIENTÍFICA.</b></br>
 <b>3. Preencha uma das opções abaixo no campo CATEGORIA:</b></br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a. Artigo publicado em periódico A1 e A2.</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b. Artigo publicado em periódico B1, B2 e B3.</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c. Capítulo de livro.</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d. Livro (com corpo editorial).</br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e. Patente.</br>
&nbsp;&nbsp;f.  Coordenação de projeto de pesquisa e/ou transferência de tecnologias.</br>
 <b>4. Preencha o campo TÍTULO DA PESQUISA/PUBLICAÇÃO.</b></br>
 <b>5. Preencha o campo DATA DE CONCLUSÃO DA PESQUISA/PUBLICAÇÃO.</b></br>
&nbsp;&nbsp;a. Para pesquisas em andamento, insira a data de previsão de conclusão (caso não seja o caso, preencha a data atual)</br>
 <b>6. Insira um comprovante no campo UPLOAD DAS PUBLICAÇÕES/PRODUÇÕES CIENTIFICAS, conforme abaixo:</b></br>
&nbsp;&nbsp;a. Insira um comprovante para cada Formação, caso contrário o sistema não permitirá que avance para a próxima etapa.</br>
&nbsp;&nbsp;b. Para comprovar artigo publicado em periódico A1 e A2 -   Artigo publicado em periódico B1, B2 e B3 - Capítulo de livro e Patente   é necessário inserir a cópia da Produção.</br>
&nbsp;&nbsp;c. Para comprovar a publicação de Livro, insira a digitalização da capa e da ficha catalográfica onde contém o ISBN do livro.</br>
&nbsp;&nbsp;d. Para Coordenação de projeto de pesquisa e/ou transferência de tecnologias Inserir o Termo de Outorga da fonte financiadora.</br>
 <b>7. Clique em salvar.</b></br>
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>O prazo máximo para esta inclusão é até o dia 10/07/2020</strong>
</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\">&nbsp;</p>

<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão abaixo:</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"https://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#6AA1CA\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"https://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #6AA1CA; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #6AA1CA; border-right: 1px solid #6AA1CA; border-bottom: 1px solid #6AA1CA; border-left: 1px solid #6AA1CA; padding-top: 10px; padding-bottom: 10px; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.8; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"http://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\">
<div style=\"font-size:1px;line-height:10px\">&nbsp;</div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->

</body></html>";
                                        $this -> email -> message($msg);
                                        if(!$this -> email -> send()){
                                                $this -> Usuarios_model -> log('erro', 'Candidaturas/script_alterar_candidatura', "Erro de envio de solicitação para refazer a candidatura para o e-mail {$candidato ->vc_email} do candidato {$candidato -> pr_candidato}.", 'tb_candidaturas', $candidatura -> pr_candidatura);
                                        }
                                        //echo $candidato -> vc_nome,";",$candidato -> vc_email,";",$candidato -> vc_telefone,";",$vaga[0] -> vc_vaga,"<br />";
                                        //exit();
                                }
                        }
                }
        }

        private function envio_email($candidatura,$vaga,$modelo){
                $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);

                $titulo = array('eliminacao'=>'] Eliminação por requisitos','confirmacao'=>'] Confirmação de candidatura','analise'=>'] Aprovação da candidatura na análise curricular');

                if($modelo == 'eliminacao'){
                        $msg['eliminacao']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
<meta content=\"width=device-width\" name=\"viewport\"/>
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		.botao:hover{
			background-color: #02182B !important;
		}

		.aqui:hover{
			color: #DF2935 !important;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}
	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#1C8C81;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1C8C81; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #6AA1CA; font-size: 46px;\"><strong>Processos Seletivos Minas</strong></span></p>
<p style=\"font-size: 20px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #6AA1CA;\"><strong>Sistema de Gestão de Recrutamentos</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Candidatura Reprovada</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato -> vc_nome}</strong>, sua candidatura foi concluída, porém não atendeu aos requisitos especificados nos editais.</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão abaixo:</span></p>
<p style=\"line-height: 1.8; word-break: break-word; mso-line-height-alt: NaNpx; margin: 0;\"> </p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#1C8C81\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #6AA1CA; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #1C8C81; border-right: 1px solid #1C8C81; border-bottom: 1px solid #1C8C81; border-left: 1px solid #1C8C81; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 98%;\" valign=\"top\" width=\"98%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.8; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a href=\"http://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\"/>
<div style=\"font-size:1px;line-height:10px\"> </div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>";
                }
                else if($modelo == 'confirmacao'){
                        $msg['confirmacao']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\">
<head>
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\"/>
<meta content=\"width=device-width\" name=\"viewport\"/>
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\"/>
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}

		.botao:hover{
			background-color: #02182B !important;
		}

		.aqui:hover{
			color: #DF2935 !important;
		}


	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
	<!--<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]-->
	<!--<img align=\"center\" alt=\"Image\" border=\"0\" class=\"center autowidth\" src=\"images/logovermelho.jpg\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 123px; display: block;\" title=\"Image\" width=\"123\"/>-->
	<!--[if mso]></td></tr></table><![endif]-->
	<!--</div>-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #555555; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #6AA1CA; font-size: 46px;\"><strong>Processos Seletivos Minas</strong></span></p>
<p style=\"font-size: 20px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #6AA1CA;\"><strong>Sistema de Gestão de Recrutamentos</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"line-height: 1.6; font-size: 12px; color: #555555; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 24px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Candidatura realizada!</strong></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato -> vc_nome}</strong>, a sua candidatura para a vaga <strong>{$vaga[0] -> vc_vaga}</strong> foi realizada com sucesso!</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Utilize este e-mail como comprovante de inscrição da sua candidatura.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:204pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"transparent\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #6AA1CA; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; border-top: 1px solid transparent; border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.6; color: #555555; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 18px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"http://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\"/>
<div style=\"font-size:1px;line-height:10px\"> </div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->
</body>
</html>";
                        }
                        else if($modelo == 'analise'){
                                $msg['analise']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:v=\"urn:schemas-microsoft-com:vml\"><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->

<meta content=\"width=device-width\" name=\"viewport\">
<!--[if !mso]><!-->
<meta content=\"IE=edge\" http-equiv=\"X-UA-Compatible\">
<!--<![endif]-->
<title></title>
<!--[if !mso]><!-->
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\"/>
<!--<![endif]-->
<style type=\"text/css\">
		body {
			margin: 0;
			padding: 0;
		}

		table,
		td,
		tr {
			vertical-align: top;
			border-collapse: collapse;
		}

		* {
			line-height: inherit;
		}

		a[x-apple-data-detectors=true] {
			color: inherit !important;
			text-decoration: none !important;
		}

		.botao:hover{
			background-color: #02182B !important;
		}

		.aqui:hover{
			color: #DF2935 !important;
		}


	</style>
<style id=\"media-query\" type=\"text/css\">
		@media (max-width: 620px) {

			.block-grid,
			.col {
				min-width: 320px !important;
				max-width: 100% !important;
				display: block !important;
			}

			.block-grid {
				width: 100% !important;
			}

			.col {
				width: 100% !important;
			}

			.col>div {
				margin: 0 auto;
			}

			img.fullwidth,
			img.fullwidthOnMobile {
				max-width: 100% !important;
			}

			.no-stack .col {
				min-width: 0 !important;
				display: table-cell !important;
			}

			.no-stack.two-up .col {
				width: 50% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num8 {
				width: 66% !important;
			}

			.no-stack .col.num4 {
				width: 33% !important;
			}

			.no-stack .col.num3 {
				width: 25% !important;
			}

			.no-stack .col.num6 {
				width: 50% !important;
			}

			.no-stack .col.num9 {
				width: 75% !important;
			}

			.video-block {
				max-width: none !important;
			}

			.mobile_hide {
				min-height: 0px;
				max-height: 0px;
				max-width: 0px;
				display: none;
				overflow: hidden;
				font-size: 0px;
			}

			.desktop_hide {
				display: block !important;
				max-height: none !important;
			}
		}
	</style>
</head>
<body class=\"clean-body\" style=\"margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #ffffff;\">
<!--[if IE]><div class=\"ie-browser\"><![endif]-->
<table bgcolor=\"#ffffff\" cellpadding=\"0\" cellspacing=\"0\" class=\"nl-container\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top;\" valign=\"top\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color:#ffffff\"><![endif]-->
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
	<!--<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]-->
	<!--<img align=\"center\" alt=\"Image\" border=\"0\" class=\"center autowidth\" src=\"images/logovermelho.jpg\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 123px; display: block;\" title=\"Image\" width=\"123\"/>-->
	<!--[if mso]></td></tr></table><![endif]-->
	<!--</div>-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
	<div style=\"color:#555555;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
		<div style=\"font-size: 18px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #555555; mso-line-height-alt: 21px;\">
		<p style=\"font-size: 46px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #6AA1CA; font-size: 46px;\"><strong>Processos Seletivos Minas</strong></span></p>
		<p style=\"font-size: 20px; line-height: 1.5; text-align: center; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 30px; margin: 0;\"><span style=\"font-size: 20px; color: #6AA1CA;\"><strong>Sistema de Gestão de Recrutamentos</strong></span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:&#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"line-height: 1.6; font-size: 12px; color: #555555; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 24px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Candidatura habilitada e currículo avaliado!</strong></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato -> vc_nome}</strong>, a sua candidatura para a vaga <strong>{$vaga[0] -> vc_vaga}</strong> foi habilitada e o seu currículo avaliado com sucesso!</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Acompanhe o status da sua candidatura pelo sistema no menu <strong>\"Suas Candidaturas\"</strong>.</span></p>

</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"left\" class=\"button-container\" style=\"padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:204pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"transparent\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #6AA1CA; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; border-top: 1px solid transparent; border-right: 1px solid transparent; border-bottom: 1px solid transparent; border-left: 1px solid transparent; padding-top: 10px; padding-bottom: 10px; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; word-break: break-word; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
<!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;\" valign=\"top\">
<table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider_content\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 1px dotted #BBBBBB; width: 100%;\" valign=\"top\" width=\"100%\">
<tbody>
<tr style=\"vertical-align: top;\" valign=\"top\">
<td style=\"word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\"><span></span></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #ffffff;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#ffffff\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#ffffff;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:&#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif;line-height:1.6;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 18px; line-height: 1.6; color: #555555; font-family: &#39;Open Sans&#39;, &#39;Helvetica Neue&#39;, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
<p style=\"font-size: 18px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"http://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
</div>
</div>
<!--[if mso]></td></tr></table><![endif]-->
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<div style=\"background-color:transparent;\">
<div class=\"block-grid\" style=\"Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #312f2f;\">
<div style=\"border-collapse: collapse;display: table;width: 100%;background-color:#312f2f;\">
<!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"background-color:transparent;\"><tr><td align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width:600px\"><tr class=\"layout-full-width\" style=\"background-color:#312f2f\"><![endif]-->
<!--[if (mso)|(IE)]><td align=\"center\" width=\"600\" style=\"background-color:#312f2f;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;\"><![endif]-->
<div class=\"col num12\" style=\"min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;\">
<div style=\"width:100% !important;\">
<!--[if (!mso)&(!IE)]><!-->
<div style=\"border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\">
<!--<![endif]-->
<div align=\"center\" class=\"img-container center autowidth\" style=\"padding-right: 0px;padding-left: 0px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px\"><td style=\"padding-right: 0px;padding-left: 0px;\" align=\"center\"><![endif]--><img align=\"center\" alt=\"Governo do Estado de Minas Gerais\" border=\"0\" class=\"center autowidth\" src=\"http://planejamento.mg.gov.br/sites/default/files/Logo_Seplag2019-01.png\" style=\"text-decoration: none; -ms-interpolation-mode: bicubic; border: 0; height: auto; width: 100%; max-width: 304px; display: block;\" title=\"Governo do Estado de Minas Gerais\" width=\"304\">
<div style=\"font-size:1px;line-height:10px\">&nbsp;</div>
<!--[if mso]></td></tr></table><![endif]-->
</div>
<!--[if (!mso)&(!IE)]><!-->
</div>
<!--<![endif]-->
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
<!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
</div>
</div>
</div>
<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
</td>
</tr>
</tbody>
</table>
<!--[if (IE)]></div><![endif]-->

</body></html>";
                }
                $this->load->library('email');

                $config['protocol'] = 'smpt';
                $config['charset'] = 'UTF-8';
                $config['smtp_port'] = 25;
                $config['smtp_host'] = $this -> config -> item('smtp_host');
                $config['smtp_user'] = $this -> config -> item('smtp_user');
                $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                $config['wordwrap'] = TRUE;

                $config['mailtype'] = 'html';

                $this->email->initialize($config);

                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                $this -> email -> to($candidato -> vc_email);

                $this -> email -> subject('['.$this -> config -> item('nome').$titulo[$modelo]);

                $this -> email -> message($msg[$modelo]);
                if(!$this -> email -> send()){
                        if($modelo == 'eliminacao'){
                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/Questionario', "Erro de envio de confirmação de reprovação dos requisitos obrigatórios para o e-mail {$candidato ->vc_email} do candidato {$candidato -> pr_candidato}.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }
                        else if($modelo == 'confirmacao'){
                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/Questionario', "Erro de envio de confirmação de Candidatura para o e-mail {$candidato ->vc_email} do candidato {$candidato -> pr_candidato}.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }
                        else if($modelo == 'analise'){
                                        $this -> Usuarios_model -> log('erro', 'Candidatos/AvaliacaoCurriculo', 'Erro de envio de e-mail de reprovação na análise curricular da candidatura '.$candidatura[0] -> pr_candidatura.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }

                }
        }
}