<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editais extends CI_Controller {
        function __construct() {
                parent::__construct();
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Editais_model');
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
                else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'orgaos'){
                        redirect('Publico');
                }
        }
	public function index($inativo = 0)	{
                $this -> load -> helper('date');

                $pagina['menu1']='Editais';
                $pagina['menu2']='index';
                $pagina['url']='Editais/index';
                $pagina['nome_pagina']='Editais';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['adicionais'] = array('datatables' => true,'sweetalert' => true);

                $dados['editais'] = $this -> Editais_model -> get_editais('',false);
                $dados['inativo'] = $inativo;
                $this -> load -> view('editais', $dados);
        }
	public function create(){
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');

                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Editais';
                $pagina['menu2']='create';
                $pagina['url']='Editais/create';
                $pagina['nome_pagina']='Cadastrar e aprovar edital';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                //$dados += $this -> input -> post(null,true);

                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();

                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/create', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('TipoEdital', "'Nome completo'", 'required');
                        $this -> form_validation -> set_rules('Nome', "'Nome'", 'required');
                        $this -> form_validation -> set_rules('Aprovacao', "'Data de Aprovação'", 'required');
                        $this -> form_validation -> set_rules('Instituicao', "'Órgão Gestor do Edital'", 'required');
                        /*$this -> form_validation -> set_rules('Fundamental', "'Número de Vagas no Ensino Fundamental'", 'required');
                        $this -> form_validation -> set_rules('Medio', "'Número de Vagas no Ensino Médio'", 'required');
                        $this -> form_validation -> set_rules('Superior', "'Número de Vagas no Ensino Superior'", 'required');*/

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $dados_form = $this -> input -> post(null,true);
                                if(!($dados_form['Fundamental'] > 0)){
                                        $dados_form['Fundamental'] = '0';
                                }
                                if(!($dados_form['Medio'] > 0)){
                                        $dados_form['Medio'] = '0';
                                }
                                if(!($dados_form['Superior'] > 0)){
                                        $dados_form['Superior'] = '0';
                                }
                                $edital = $this -> Editais_model -> create_edital($dados_form);
                                if($edital > 0){
                                        $dados['sucesso'] = 'Edital aprovado com sucesso. <br/><br/><button class="btn btn-light"><a href="'.base_url('Editais/index').'">Voltar</a></button>';
                                        $dados['erro'] =  NULL;
                                        //Edital [Chave de identificação] aprovado por [Nome do usuário]
                                        $this -> Usuarios_model -> log('sucesso', 'Editais/create', "Edital {$edital} aprovado pelo usuário ".$this -> session -> uid.".", 'tb_editais', $edital);
                                }
                                else{
                                        $erro = $this -> db -> error();
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  'Erro no cadastro de edital. Os responsáveis já foram avisados.<br/><br/><button class="btn btn-light"><a href="'.base_url('Editais/index').'">Voltar</a></button>';
                                        $this -> Usuarios_model -> log('erro', 'Editais/create', 'Erro de criação de edital. Erro: '.$erro['message']);
                                }
                        }
                }
                $this -> load -> view('editais', $dados);
        }
        public function review(){
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');

                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Editais';
                $pagina['menu2']='review';
                $pagina['url']='Editais/review';
                $pagina['nome_pagina']='Rever edital aprovado';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                $edital = $this -> uri -> segment(3);
                $dados_form = $this -> input -> post(null,true);
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $edital = $dados_form['codigo'];
                }
                $dados_edital = $this -> Editais_model -> get_editais($edital,false);
                $dados['codigo'] = $edital;
                $dados += (array) $dados_edital;

                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();

                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/create', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('TipoEdital', "'Nome completo'", 'required');
                        $this -> form_validation -> set_rules('Nome', "'Nome'", 'required');
                        $this -> form_validation -> set_rules('Aprovacao', "'Data de Aprovação'", 'required');
                        $this -> form_validation -> set_rules('Instituicao', "'Órgão Gestor do Edital'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                if(!($dados_form['Fundamental'] > 0)){
                                        $dados_form['Fundamental'] = '0';
                                }
                                if(!($dados_form['Medio'] > 0)){
                                        $dados_form['Medio'] = '0';
                                }
                                if(!($dados_form['Superior'] > 0)){
                                        $dados_form['Superior'] = '0';
                                }
                                if(!isset($dados_form['restrito']) || !($dados_form['restrito'] == '1')){
                                        $dados_form['restrito'] = null;
                                }
                                $this -> Editais_model -> update_edital('en_tipo_edital',$dados_form['TipoEdital'], $edital);
                                //echo $dados_form['Nome'].$edital;
                                $this -> Editais_model -> update_edital('vc_edital',$dados_form['Nome'], $edital);
                                $this -> Editais_model -> update_edital('dt_aprovacao',$dados_form['Aprovacao'], $edital);
                                $this -> Editais_model -> update_edital('es_instituicao',$dados_form['Instituicao'], $edital);
                                $this -> Editais_model -> update_edital('nu_vagas_fundamental',$dados_form['Fundamental'], $edital);
                                $this -> Editais_model -> update_edital('nu_vagas_medio',$dados_form['Medio'], $edital);
                                $this -> Editais_model -> update_edital('nu_vagas_superior',$dados_form['Superior'], $edital);
                                $this -> Editais_model -> update_edital('bl_restrito', $dados_form['restrito'], $edital);

                                $dados['sucesso'] = 'Edital revisto com sucesso. <br/><br/><button class="btn btn-light"><a href="'.base_url('Editais/index').'">Voltar</a></button>';
                                $dados['erro'] =  NULL;
                                //Edital [Chave de identificação] aprovado por [Nome do usuário]
                                $this -> Usuarios_model -> log('sucesso', 'Editais/create', "Edital {$edital} revisto pelo usuário ".$this -> session -> uid.".", 'tb_editais', $edital);
                        }
                }
                $this -> load -> view('editais', $dados);
        }
	public function edit(){
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Editais';
                $pagina['menu2']='edit';
                $pagina['url']='Editais/edit';
                $pagina['nome_pagina']='Editar edital';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                $edital = $this -> uri -> segment(3);
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $edital = $dados_form['codigo'];
                }
                $dados_edital = $this -> Editais_model -> get_editais($edital,false);
                $dados['codigo'] = $edital;
                $dados += (array) $dados_edital;

                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                if($this -> session -> perfil != 'orgaos'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Editais/edit', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else if(!isset($dados_edital)){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Editais/edit', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('Publicacao', "'Data de Publicação'", 'required|callback_valida_publicacao');
                        $this -> form_validation -> set_rules('Vigencia', "'Vigência do Edital'", 'required');
                        $this -> form_validation -> set_rules('Link', "'Link para o edital'", 'required');
                        $this -> form_validation -> set_rules('Email', "'E-mail para o contato da comissão'", 'required');
                        $this -> form_validation -> set_rules('Inicio', "'Início das inscrições'", 'required');
                        $this -> form_validation -> set_rules('Fim', "'Término das inscrições'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $this -> Editais_model -> update_edital('dt_publicacao',$dados_form['Publicacao'], $edital);
                                $this -> Editais_model -> update_edital('nu_vigencia_meses',$dados_form['Vigencia'], $edital);
                                $this -> Editais_model -> update_edital('vc_link',$dados_form['Link'], $edital);

                                $this -> Editais_model -> update_edital('vc_email',$dados_form['Email'], $edital);

                                $this -> Editais_model -> update_edital('dt_inicio',$dados_form['Inicio'], $edital);
                                $this -> Editais_model -> update_edital('dt_fim',$dados_form['Fim'], $edital);

                                $this -> Usuarios_model -> log('sucesso', 'Editais/edit', "Edital {$edital} alterado com sucesso pelo usuário ".$this -> session -> uid, 'tb_editais', $edital);

                                $dados['sucesso'] = 'Edital alterado com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Editais/index').'">Voltar</a></button>';
                                $dados['erro'] = '';
                        }
                }
                $this -> load -> view('editais', $dados);
        }
        public function publicar(){
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Editais';
                $pagina['menu2']='publicar';
                $pagina['url']='Editais/publicar';
                $pagina['nome_pagina']='Publicar edital';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                $edital = $this -> uri -> segment(3);
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $edital = $dados_form['codigo'];
                }
                $dados_edital = $this -> Editais_model -> get_editais($edital,false);
                $dados['codigo'] = $edital;
                $dados += (array) $dados_edital;

                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                if($this -> session -> perfil != 'orgaos'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Editais/publicar', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else if(!isset($dados_edital)){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Editais/publicar', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('Publicacao', "'Data de Publicação'", 'required|callback_valida_publicacao');
                        $this -> form_validation -> set_rules('Vigencia', "'Vigência do Edital'", 'required');
                        $this -> form_validation -> set_rules('Link', "'Link para o edital'", 'required');
                        $this -> form_validation -> set_rules('Email', "'E-mail para o contato da comissão'", 'required');
                        $this -> form_validation -> set_rules('Inicio', "'Início das inscrições'", 'required');
                        $this -> form_validation -> set_rules('Fim', "'Término das inscrições'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $this -> Editais_model -> update_edital('dt_publicacao',$dados_form['Publicacao'], $edital);
                                $this -> Editais_model -> update_edital('nu_vigencia_meses',$dados_form['Vigencia'], $edital);
                                $this -> Editais_model -> update_edital('vc_link',$dados_form['Link'], $edital);

                                $this -> Editais_model -> update_edital('vc_email',$dados_form['Email'], $edital);

                                $this -> Editais_model -> update_edital('dt_inicio',$dados_form['Inicio'], $edital);
                                $this -> Editais_model -> update_edital('dt_fim',$dados_form['Fim'], $edital);
                                $this -> Editais_model -> update_edital('en_status','publicado', $edital);


                                $this -> Usuarios_model -> log('sucesso', 'Editais/publicar', "Edital {$edital} publicado com sucesso pelo usuário ".$this -> session -> uid, 'tb_editais', $edital);

                                $dados['sucesso'] = 'Edital publicado com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Editais/index').'">Voltar</a></button>';
                                $dados['erro'] = '';
                        }
                }
                $this -> load -> view('editais', $dados);
        }
        public function view(){
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Editais';
                $pagina['menu2']='view';
                $pagina['url']='Editais/view';
                $pagina['nome_pagina']='Visualizar edital';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true,'datatables' => true);
                $edital = $this -> uri -> segment(3);
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $se_prorrogacao = $this -> uri -> segment(4);

                $dados_form = $this -> input -> post(null,true);
                //var_dump($dados_form);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $edital = $dados_form['codigo'];
                }
                $dados['se_prorrogacao'] = $se_prorrogacao;
                $dados_edital = $this -> Editais_model -> get_editais($edital,false);
                $dados['codigo'] = $edital;
                $dados += (array) $dados_edital;

                $dados['prorrogacoes'] = $this -> Editais_model -> get_prorrogacao_edital('',$edital);
                $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                if($this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Editais/view', 'Tentativa de acesso por perfil ('.$this -> session -> perfil.') inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else if(!isset($dados_edital)){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Editais/view', 'Tentativa de acesso por usuário '.$this -> session -> uid.' sem acesso ao edital '.$edital);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('FimNovo', "'Nova data de término das inscrições'", 'required|callback_fim_novo');
                        $this -> form_validation -> set_rules('LinkProrrogacao', "'Link de publicação da prorrogação'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                                $dados['se_prorrogacao'] = '1';
                        }
                        else{
                                $dados_prorrogacao['Edital'] = $edital;
                                $dados_prorrogacao['Antigo'] = $dados_edital->dt_fim;
                                $dados_prorrogacao['Novo'] = $dados_form['FimNovo'];
                                $dados_prorrogacao['LinkProrrogacao'] = $dados_form['LinkProrrogacao'];

                                $this -> Editais_model -> create_prorrogacao($dados_prorrogacao);
                                $this -> Editais_model -> update_edital('dt_fim',$dados_form['FimNovo'], $edital);

                                $this -> Usuarios_model -> log('sucesso', 'Editais/view', "Edital {$edital} prorrogado com sucesso pelo usuário ".$this -> session -> uid, 'tb_editais', $edital);
                                echo "<script type=\"text/javascript\">alert('Edital prorrogado com sucesso');window.location='".base_url('Editais/view/'.$edital.'/1')."';</script>";
                                $dados['sucesso'] = 'Edital prorrogado com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Editais/view/'.$edital.'/1').'" class="btn btn-light">Atualizar</a>';
                                $dados['erro'] = '';
                        }
                }
                $this -> load -> view('editais', $dados);
        }
        function valida_publicacao($data){
                $publicacao = $data;
                $dados_edital = $this -> Editais_model -> get_editais($this -> input -> post('codigo'),false);
                $aprovacao = $dados_edital -> dt_aprovacao;
                if(strtotime($aprovacao) >= strtotime($publicacao)){
                        $this -> form_validation -> set_message('valida_publicacao', "A 'Data de Publicação' deve ser maior que a data de aprovação");
                        return false;
                }
                return true;
        }
	function fim_novo($data){
                $data = str_replace(" ","T",$data);
                $fim_novo = $data;
                $dados_edital = $this -> Editais_model -> get_editais($this -> input -> post('codigo'));
                $inicio = $dados_edital -> dt_inicio;
                $fim = $dados_edital -> dt_fim;

                if(strtotime($fim) >= strtotime($fim_novo)){
                        $this -> form_validation -> set_message('fim_novo', "A 'Nova data de término das inscrições' deve ser maior que a data de término atual");
                        return false;
                }
                else if(strtotime($inicio) >= strtotime($fim_novo)){
                        $this -> form_validation -> set_message('fim_novo', "A 'Nova data de término das inscrições' deve ser maior que a data de início atual");
                        return false;
                }

                return true;
        }
}