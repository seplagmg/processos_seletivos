<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
        function __construct() {
                parent::__construct();
                $this -> load -> model('Usuarios_model');
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
        }
	public function index($inativo = 0)	{
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $this -> load -> helper('date');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='index';
                $pagina['url']='Usuarios/index';
                $pagina['nome_pagina']='Usuários';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['adicionais'] = array('datatables' => true,'sweetalert' => true,'inputmasks' => true);


                $dados_form = $this -> input -> post(null,true);
                if(!isset($dados_form['cpf'])){
                        $dados_form['cpf'] = '';
                }
                if(!isset($dados_form['nome'])){
                        $dados_form['nome'] = '';
                }
                if(!isset($dados_form['email'])){
                        $dados_form['email'] = '';
                }

                if($this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'sugesp' &&  $this -> session -> perfil != 'orgaos'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/index', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                if($this -> session -> perfil == 'orgaos'){
                        if($inativo == 0){
                                $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', $dados_form['cpf'], '', '', true,$this -> session -> instituicao,$dados_form['nome'],$dados_form['email']);
                        }
                        else{
                                $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', $dados_form['cpf'], '', '', false,$this -> session -> instituicao,$dados_form['nome'],$dados_form['email']);
                        }
                }
                else{
                        if($inativo == 0){
                                $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', $dados_form['cpf'], '', '', true,'',$dados_form['nome'],$dados_form['email']);
                        }
                        else{
                                $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios('', $dados_form['cpf'], '', '', false,'',$dados_form['nome'],$dados_form['email']);
                        }
                }
                if(isset($dados['usuarios']) && strlen($dados_form['cpf']) > 0){
                        $usuarios = $dados['usuarios'];
                        $dados['usuarios'] = array();
                        $dados['usuarios'][0] = $usuarios;
                }
                $dados['inativo'] = $inativo;
                $this -> load -> view('usuarios', $dados);
        }
	public function create(){
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');


                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='create';
                $pagina['url']='Usuarios/create';
                $pagina['nome_pagina']='Novo usuário';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                //$dados += $this -> input -> post(null,true);
                if($this -> session -> perfil == 'orgaos'){
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes($this -> session -> instituicao);
                }
                else{
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                }


                if($this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'sugesp' &&  $this -> session -> perfil != 'orgaos'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/create', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('NomeCompleto', "'Nome completo'", 'required|min_length[8]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome completo\'.'));
                        $this -> form_validation -> set_rules('CPF', "'CPF'", 'required|verificaCPF|is_unique[tb_usuarios.vc_login]', array('required' => 'O campo \'CPF\' é obrigatório.', 'verificaCPF' => 'O CPF inserido é inválido.', 'is_unique' => 'O CPF inserido já está cadastrado.'));
                        $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                        $this -> form_validation -> set_rules('perfil', "'Perfil'", 'required|callback_perfil_permitido');
                        $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required');
                        $this -> form_validation -> set_rules('brumadinho',"'Acesso as vagas'",'callback_valida_brumadinho_pps');
                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $senha = random_string ('alnum', 8);
                                $dados_form = $this -> input -> post(null,true);
                                $dados_form['senha'] = $senha;
                                $dados_form['candidato'] = null;
                                $dados_form['Telefone'] = null;

                                if($this -> session -> brumadinho != '1'){
                                        $dados_form['brumadinho'] = null;
                                }
                                if($this -> session -> pps != '1'){
                                        $dados_form['pps'] = null;

                                }
                                $usuario = $this -> Usuarios_model -> create_usuario($dados_form);
                                if($usuario > 0){
					if(!$this -> envio_email($dados_form,$senha,$dados_form['Email'],'criacao',$usuario)){
                                                $this -> Usuarios_model -> log('erro', 'Usuarios/create', "Erro de envio de e-mail com senha de cadastro para o e-mail {$dados_form['Email']} do usuário {$usuario}.", 'tb_usuarios', $usuario);
                                        }
                                        $dados['sucesso'] = 'Cadastro realizado com sucesso. Você vai receber sua senha inicial de acesso por e-mail. Caso não receba, tente recuperar sua senha pela página inicial ou entre em contato pelo fale conosco.<br/><br/><button class="btn btn-light"><a href="'.base_url('Usuarios/index').'">Voltar</a></button>';
                                        $dados['erro'] =  NULL;
                                        $this -> Usuarios_model -> log('sucesso', 'Usuarios/create', "Usuário {$usuario} criado com sucesso.", 'tb_usuarios', $usuario);
                                }
                                else{
                                        $erro = $this -> db -> error();
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  'Erro no cadastro de usuário. Os responsáveis já foram avisados.<br/><br/><button class="btn btn-light"><a href="'.base_url('Usuarios/index').'">Voltar</a></button>';
                                        $this -> Usuarios_model -> log('erro', 'Usuarios/create', 'Erro de criação de usuário. Erro: '.$erro['message']);
                                }
                        }
                }
                $this -> load -> view('usuarios', $dados);
        }

	public function edit(){
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $this -> load -> library('email');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> library('MY_Form_Validation');
                $this -> load -> helper('string');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='edit';
                $pagina['url']='Usuarios/edit';
                $pagina['nome_pagina']='Editar usuário';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;
                $dados['adicionais'] = array('inputmasks' => true);
                $usuario = $this -> uri -> segment(3);
                $dados_usuario = $this -> Usuarios_model -> get_usuarios ($usuario);
                $dados['codigo'] = $usuario;
                $dados += (array) $dados_usuario;
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $usuario = $dados_form['codigo'];
                }
                if($this -> session -> perfil == 'orgaos'){
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes($this -> session -> instituicao);
                }
                else{
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                }
                if($usuario == $this -> session -> uid){
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Você não pode atualizar seus próprios dados por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/edit', "Usuário {$usuario} tentou atualizar seus próprios dados.", 'tb_usuarios', $usuario);
                }
                else if($this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'sugesp' &&  $this -> session -> perfil != 'orgaos'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/edit', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else if($this -> session -> perfil == 'orgaos' && $dados_usuario -> es_instituicao != $this -> session -> instituicao){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/edit', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                }
                else{
                        $this -> form_validation -> set_rules('NomeCompleto', "'Nome completo'", 'required|min_length[8]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome completo\'.'));
                        $this -> form_validation -> set_rules('Email', "'E-mail'", 'required|valid_email');
                        $this -> form_validation -> set_rules('perfil', "'Perfil'", 'required|callback_perfil_permitido');
                        $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required');
                        $this -> form_validation -> set_rules('brumadinho',"'Acesso as vagas'",'callback_valida_brumadinho_pps');
                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $this -> Usuarios_model -> update_usuario('vc_nome',$dados_form['NomeCompleto'], $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_email', $dados_form['Email'], $usuario);
                                $this -> Usuarios_model -> update_usuario('en_perfil', $dados_form['perfil'], $usuario);
                                if(!isset($dados_form['instituicao']) || strlen($dados_form['instituicao']) == 0){
                                        $dados_form['instituicao'] = null;
                                }
                                $this -> Usuarios_model -> update_usuario('es_instituicao', $dados_form['instituicao'], $usuario);

                                if(!isset($dados_form['brumadinho']) || strlen($dados_form['brumadinho']) == 0){
                                        $dados_form['brumadinho'] = null;
                                }
                                if($this -> session -> brumadinho == '1'){
                                        $this -> Usuarios_model -> update_usuario('bl_brumadinho', $dados_form['brumadinho'], $usuario);
                                }
                                if(!isset($dados_form['pps']) || strlen($dados_form['pps']) == 0){
                                        $dados_form['pps'] = null;
                                }
                                if($this -> session -> pps == '1'){
                                        $this -> Usuarios_model -> update_usuario('bl_pps', $dados_form['pps'], $usuario);
                                }

                                $this -> Usuarios_model -> update_usuario('dt_alteracao', date('Y-m-d H:i:s'), $usuario);

                                $this -> Usuarios_model -> log('sucesso', 'Usuarios/edit', "Usuário {$usuario} editado com sucesso pelo usuário ".$this -> session -> uid, 'tb_usuarios', $usuario);

                                $dados['sucesso'] = 'Usuário editado com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Usuarios/index').'">Voltar</a></button>';
                                $dados['erro'] = '';
                        }
                }
                $this -> load -> view('usuarios', $dados);
        }

	public function novaSenha(){
                $this -> load -> library('email');
                $this -> load -> helper('string');
                $this -> load -> library('encryption');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='novaSenha';
                $pagina['url']='Usuarios/novaSenha';
                $pagina['nome_pagina']='Nova senha';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;

                if($this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/novaSenha', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);

                        $dados['menu2']='';
                        echo "<script type=\"text/javascript\">alert('Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                }
                else{
                        $usuario = $this -> uri -> segment(3);
                        $dados['usuario'] = $this -> Usuarios_model -> get_usuarios($usuario);

                        if($dados['usuario'] -> pr_usuario > 0){
                                $senha = random_string ('alnum', 8);
                                $password = $this -> encryption -> encrypt($senha);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $usuario);
                                $this -> Usuarios_model -> update_usuario('bl_trocasenha', '1', $usuario);
                                $this -> Usuarios_model -> update_usuario('in_erros', '0', $usuario);

                                if(!$this -> envio_email($dados,$senha,$dados['usuario'] -> vc_email,'novasenha',$usuario)){
                                        $dados['sucesso'] = '';
                                        $dados['erro'] =  'Erro no envio do e-mail com a nova senha. Os responsáveis já foram avisados.';
                                        $this -> Usuarios_model -> log('erro', 'Usuarios/novaSenha', 'Erro de envio de e-mail com senha de cadastro para o e-mail '.$dados['usuario'] -> vc_email.' do usuário '.$dados['usuario'] -> pr_usuario. " feita pelo usuário ".$this -> session -> uid, 'tb_usuarios', $usuario);
                                        echo "<script type=\"text/javascript\">alert('Erro no envio do e-mail com a nova senha. Os responsáveis já foram avisados.');window.location='".base_url('Usuarios/index')."';</script>";
                                }
                                else{
                                        $dados['sucesso'] = 'Nova senha enviada com sucesso. A nova senha é '.$senha.'.<br/><br/><button class="btn btn-light"><a href="'.base_url('Usuarios/index').'">Voltar</a></button>';
                                        $dados['erro'] =  NULL;
                                        $this -> Usuarios_model -> log('sucesso', 'Usuarios/novaSenha', "Nova senha para Usuário {$usuario} enviada com sucesso pelo usuário ".$this -> session -> uid.".", 'tb_usuarios', $usuario);
                                        echo "<script type=\"text/javascript\">alert('Nova senha enviada com sucesso. A nova senha é ".$senha.".');window.location='".base_url('Usuarios/index')."';</script>";
                                }
                        }
                        else{
                                $erro = $this -> db -> error();
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'Usuarios/novaSenha', "Erro na recuperação dos dados do usuário {$usuario} pelo usuário ".$this -> session -> uid.". Erro: ".$erro['message']);
                                echo "<script type=\"text/javascript\">alert('Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                }

                //$this -> load -> view('usuarios', $dados);
        }
	public function delete(){
                $this -> load -> library('email');
                $this -> load -> helper('string');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='delete';
                $pagina['url']='Usuarios/delete';
                $pagina['nome_pagina']='Desativar usuário';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;

                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/index', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                        echo "<script type=\"text/javascript\">alert('Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                }
                else{
                        $usuario = $this -> uri -> segment(3);
                        $dados_usuario = $this -> Usuarios_model -> get_usuarios ($usuario);
                        $dados += (array) $dados_usuario;

                        if($usuario == $this -> session -> uid){
                                $dados['sucesso'] = '';
                                $dados['erro'] = 'Você não pode desativar seu próprio acesso por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.';
                                $this -> Usuarios_model -> log('seguranca', 'Usuarios/delete', "Usuário {$usuario} tentou se desativar.", 'tb_usuarios', $usuario);
                                echo "<script type=\"text/javascript\">alert('Você não pode desativar seu próprio acesso por essa funcionalidade. Essa tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                        else{
                                $this -> Usuarios_model -> update_usuario('bl_removido', '1', $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_senha', null, $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', null, $usuario);
                                $dados['sucesso'] = 'O usuário \''.$dados_usuario -> vc_nome.'\' foi desativado com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Usuarios/index').'">Voltar</a></button>';
                                $dados['erro'] = '';
                                $this -> Usuarios_model -> log('sucesso', 'Usuarios/delete', "Usuário {$usuario} desativado pelo usuário ".$this -> session -> uid, 'tb_usuarios', $usuario);
                                echo "<script type=\"text/javascript\">alert('O usuário \'".$dados_usuario -> vc_nome."\' foi desativado com sucesso.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                }

                //$this -> load -> view('usuarios', $dados);
        }
	public function reactivate(){
                $this -> load -> library('email');
                $this -> load -> helper('string');
                $this -> load -> library('encryption');

                $pagina['menu1']='Usuarios';
                $pagina['menu2']='reactivate';
                $pagina['url']='Usuarios/reactivate';
                $pagina['nome_pagina']='Reativar conta';
                $pagina['icone']='fa fa-users';

                $dados=$pagina;

                if($this -> session -> perfil != 'administrador'){
                        $dados['sucesso'] = '';
                        $dados['erro'] =  'Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.';
                        $this -> Usuarios_model -> log('seguranca', 'Usuarios/index', 'Tentativa de acesso por perfil inadequado, usuário '.$this -> session -> uid);
                        $dados['menu2']='';
                        echo "<script type=\"text/javascript\">alert('Você não tem acesso a esta página. Esta tentativa foi registrada para fins de auditoria.');window.location='".base_url('Usuarios/index')."';</script>";
                }
                else{
                        $usuario = $this -> uri -> segment(3);
                        $dados['usuario'] = $this -> Usuarios_model -> get_usuarios($usuario);
                        if($dados['usuario'] -> pr_usuario > 0){
                                $senha = random_string ('alnum', 8);
                                $password = $this -> encryption -> encrypt($senha);
                                $this -> Usuarios_model -> update_usuario('bl_removido', '0', $usuario);
                                $this -> Usuarios_model -> update_usuario('vc_senha_temporaria', $password, $usuario);
                                $this -> Usuarios_model -> update_usuario('dt_alteracao', date('Y-m-d H:i:s'), $usuario);

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
                                $this -> email -> to($dados['usuario'] -> vc_email);
                                $this -> email -> subject('['.$this -> config -> item('nome').'] Nova senha');
                                $msg='Olá '.$dados['usuario'] -> vc_nome.',<br><br>Foi solicitada uma nova senha do sistema do programa '.$this -> config -> item('nome').'. Seus dados para acesso são:<br><br>Usuário: '.$dados['usuario'] -> vc_login."<br>Senha inicial: $senha<br><br>Se não foi você que solicitou essa recuperação de senha, não se preocupe pois sua senha antiga ainda funciona.<br><br>Acesse o sistema por meio do link: ".base_url();
                                $this -> email -> message($msg);
                                if(!$this -> envio_email($dados,$senha,$dados['usuario'] -> vc_email,'novasenha',$usuario)){
                                        $this -> Usuarios_model -> log('erro', 'Usuarios/reactivate', 'Erro de envio de e-mail com senha de cadastro para o e-mail '.$dados['usuario'] -> vc_email.' do usuário '.$dados['usuario'] -> pr_usuario, 'tb_usuarios', $usuario);
                                }
                                else{
                                        $this -> Usuarios_model -> log('sucesso', 'Usuarios/reactivate', "Nova senha para Usuário {$usuario} enviada com sucesso.", 'tb_usuarios', $usuario);
                                }
                                $this -> Usuarios_model -> log('sucesso', 'Usuarios/reactivate', "Recuperação dos dados do usuário {$usuario} realizada com sucesso. Erro: ".$erro['message'],$usuario);
                                $dados['sucesso'] = 'Usuário reativado com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Usuarios/index').'">Voltar</a></button>';
                                $dados['erro'] =  NULL;
                                echo "<script type=\"text/javascript\">alert('Usuário reativado com sucesso.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                        else{
                                $erro = $this -> db -> error();
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'Usuarios/reactivate', "Erro na recuperação dos dados do usuário {$usuario}. Erro: ".$erro['message'],$usuario);
                                echo "<script type=\"text/javascript\">alert('Erro na recuperação dos dados do usuário. Os responsáveis já foram avisados.');window.location='".base_url('Usuarios/index')."';</script>";
                        }
                }

                //$this -> load -> view('usuarios', $dados);
        }


        function perfil_permitido($perfil){
                if($this -> session -> perfil == 'administrador'){
                        $perfis = array(
                        'avaliador',
                        'sugesp',
                        'orgaos',
                        'administrador'
                        );
                }
                else if($this -> session -> perfil == 'sugesp'){
                        $perfis = array(
                                'avaliador',
                                'orgaos',
                                );
                }
                else if($this -> session -> perfil == 'orgaos'){
                        $perfis = array(
                                'avaliador',
                                );
                }
                if(!in_array($perfil,$perfis)){
                        $this -> form_validation -> set_message('perfil_permitido', "'Perfil' fora dos grupos permitidos".$perfil);
                        return false;
                }
                //return false;
                return true;
        }

        function valida_brumadinho_pps($brumadinho){
                $brumadinho = $this -> input -> post('brumadinho');
                $pps = $this -> input -> post('pps');
                if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                        if(($brumadinho + $pps) == 0){
                                $this -> form_validation -> set_message('valida_brumadinho_pps', 'Deve ser escolhido ao menos uma opção  de \'Acesso as vagas\'');
                                return false;
                        }
                }
                else if($this -> session -> brumadinho == '1'){
                        if(!($brumadinho > 0)){
                                $this -> form_validation -> set_message('valida_brumadinho_pps', 'Deve ser escolhido ao menos uma opção  de \'Acesso as vagas\'');
                                return false;
                        }
                }
                else if($this -> session -> pps == '1'){
                        if(!($pps > 0)){
                                $this -> form_validation -> set_message('valida_brumadinho_pps', 'Deve ser escolhido ao menos uma opção  de \'Acesso as vagas\'');
                                return false;
                        }
                }

                return true;
        }

        function envio_email($dados,$senha,$email,$modelo,$usuario){
                $titulo = array('criacao'=>'] Confirmação de cadastro','novasenha'=>'] Nova senha');
                if($modelo == 'criacao'){
                        $msg['criacao']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<p style=\"font-size: 24px; line-height: 1.6; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Login e primeiro acesso:</strong></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$dados['NomeCompleto']}</strong>, o seu cadastro foi realizado com sucesso!</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 18px; color: #000000; mso-ansi-font-size: 18px;\"> </span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Para acessar o sistema clique no botão <em>\"Acessar o sistema\"</em> e insira as informações abaixo:</span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\"><em>Login:</em><strong> {$dados['CPF']}</strong></span><br/><span style=\"color: #000000;\"><span style=\"font-size: 18px; mso-ansi-font-size: 18px;\">Senha:<strong> {$senha}</strong></span></span></p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 18px; text-align: justify; line-height: 1.6; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 18px; mso-ansi-font-size: 18px;\">Altere a sua senha após o primeiro acesso.</span></p>
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
                else if($modelo == 'novasenha'){
                        $msg['novasenha']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#6AA1CA;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #6AA1CA; mso-line-height-alt: 21px;\">
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
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Alteração de senha</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$dados['usuario'] -> vc_nome}</strong>, foi solicitada uma nova senha para acesso ao sistema do Processos Seletivos Minas!</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Seus dados para acesso são:</span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><strong><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Usuário: {$dados['usuario'] -> vc_login}</span></span></strong></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><strong><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Senha: {$senha}</span></span></strong></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#6AA1CA\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://www.processoseletivo.mg.gov.br/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #6AA1CA; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #6AA1CA; border-right: 1px solid #6AA1CA; border-bottom: 1px solid #6AA1CA; border-left: 1px solid #6AA1CA; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
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
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"http://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
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
                $this -> email -> to($email);

                $this -> email -> subject('['.$this -> config -> item('nome').$titulo[$modelo]);

                $this -> email -> message($msg[$modelo]);
                return $this -> email -> send();
        }
}