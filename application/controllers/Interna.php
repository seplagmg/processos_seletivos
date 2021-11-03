<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Interna extends CI_Controller {
        private $pagina=array();
        function __construct() {
                parent::__construct();
                $this -> load -> model('Usuarios_model');

                if(!$this -> session -> logado){
                        redirect('/Publico');
                }
                else{
                        //alteração para impedir login simultâneo em várias máquinas, matando as sessões mais antigas
                        $this -> db -> where('id', session_id());
                        $this -> db -> where('timestamp < (SELECT max(timestamp) FROM `tb_sessoes` where es_usuario = '.$this -> session -> uid.')', null, false);

                        $this -> db -> select('*');
                        $query = $this -> db -> get('tb_sessoes');
                        if($query -> num_rows() > 0){
                               redirect('/Interna/logout');
                        }
                }
        }
	public function index()	{
                $pagina['menu1']='Interna';
                $pagina['menu2']='index';
                $pagina['url']='Interna/index';
                $pagina['nome_pagina']='Página inicial';
                $pagina['icone']='fa fa-home';

                $dados = array();
                $dados += $pagina;

                $this -> load -> view('inicial', $dados);
	}
        public function logout(){ //faz o logout da sessão
                $this -> Usuarios_model -> log('sucesso', 'Interna', 'Usuário '.$this -> session -> uid.' deslogado com sucesso.', 'tb_usuarios', $this -> session -> uid);

                $this -> session -> set_userdata('uid', 0);
                $this -> session -> set_userdata('perfil', '');
                $this -> session -> set_userdata('candidato', '');
                $this -> session -> set_userdata('nome', '');
                $this -> session -> set_userdata('logado', false);
                $this -> session -> set_userdata('erro', '');
                $this -> session -> set_userdata('brumadinho', '');
                $this -> session -> set_userdata('pps', '');
                $this -> session -> set_userdata('instituicao', '');

                $this -> db -> set ('es_usuario', NULL);
                $this -> db -> where('id', session_id());
                $this -> db -> update ('tb_sessoes');

                session_unset();
                session_destroy();
                redirect('Publico');
        }
        public function alterar_senha(){ //função de preenchimento da combo da view de cadastro
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('encryption');
                if($this -> input -> post ('senhaAtual') && $this -> input -> post ('senhaNova') && $this -> input -> post ('senhaConfirmacao')){
                        if(strlen($this -> input -> post ('senhaNova')) < 8){
                                echo 'ERRO: Insira uma nova senha com no mínimo 8 caracteres.';
                        }
                        else if(strlen($this -> input -> post ('senhaNova')) > 20){
                                echo 'ERRO: Insira uma nova senha com no máximo 20 caracteres.';
                        }
                        else if($this -> input -> post ('senhaNova') != $this -> input -> post ('senhaConfirmacao')){
                                echo 'ERRO: A confirmação não corresponde à nova senha inserida!';
                        }
                        else if($this -> input -> post ('senhaAtual') == $this -> input -> post ('senhaNova')){
                                echo 'ERRO: A senha atual não deve ser a mesma que a nova senha!';
                        }
                        else{
                                $this -> db -> select ('vc_senha');
                                $this -> db -> from ('tb_usuarios');
                                $this -> db -> where('pr_usuario', $this -> session -> uid);
                                $query = $this -> db -> get();
                                $row = $query -> row();
                                if($this -> encryption -> decrypt($row -> vc_senha) != $this -> input -> post ('senhaAtual')){
                                        echo 'ERRO: Sua senha atual está incorreta!';
                                }
                                else{
                                        if($this -> Usuarios_model -> alterar_senha ($this -> input -> post ('senhaNova'))){
                                                $this -> Usuarios_model -> update_usuario('bl_trocasenha', '0', $this -> session -> uid);
                                                $this -> session -> set_userdata('trocasenha', false);
                                                echo 'Sucesso na alteração da sua senha!';
                                                $this -> Usuarios_model -> log('sucesso', 'Interna/alterar_senha', 'Senha alterada com sucesso para o usuário '.$this -> session -> uid, 'tb_usuarios', $this -> session -> uid);
                                        }
                                        else{
                                                echo 'ERRO: indefinido';
                                                $this -> Usuarios_model -> log('erro', 'Interna/alterar_senha', 'Erro indefinido na alteração de senha para o usuário '.$this -> session -> uid, 'tb_usuarios', $this -> session -> uid);
                                        }
                                }
                        }
                }
                else{
                        echo 'ERRO: Favor preencher todos os campos';
                }
        }
        public function novo_termo(){ //função para aceitar os novos termos
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('encryption');
                if($this -> input -> post ('AceiteTermo') && $this -> input -> post ('AceitePrivacidade')){
                        if(strlen($this -> input -> post ('AceiteTermo')) != 1){
                                echo 'ERRO: Aceite o termo de compromisso.';
                        }
                        else if(strlen($this -> input -> post ('AceitePrivacidade')) != 1){
                                echo 'ERRO: Aceite o termo de privacidade.';
                        }
                        else{
                                $this -> Usuarios_model -> update_usuario('bl_novotermo', '1', $this -> session -> uid);
                                $this -> session -> set_userdata('novotermo', '1');
                                echo 'Termos aceitos com sucesso!';
                                $this -> Usuarios_model -> log('sucesso', 'Interna/novo_termo', 'Novos termos aceitos pelo usuário '.$this -> session -> uid, 'tb_usuarios', $this -> session -> uid);
                        }
                }
                else{
                        echo 'ERRO: Favor preencher todos os campos'.$this -> input -> post ('AceiteTermo');
                }
        }
        public function download(){
                $this -> load -> model('Anexos_model');
                $this -> load -> model('Usuarios_model');

                $anexo = $this -> uri -> segment(3);
                $dados['anexo'] = $this -> Anexos_model -> get_anexo ($anexo);
                $arq='./anexos/'.$dados['anexo'][0] -> pr_anexo;
                $fp = fopen($arq, 'rb');
                $tamanho=filesize($arq);

                $content = fread($fp, $tamanho);

                fclose($fp);

                if(strlen($content)>0){
                        header("Content-length: {$tamanho}");
                        header('Content-type: '.$dados['anexo'][0] -> vc_mime);
                        header('Content-Disposition: attachment; filename='.str_replace(",","",$dados['anexo'][0] -> vc_arquivo));

                        //$content = addslashes($content);
                        echo $content;
                }
                else{
                        log_site(1, 'Download', 'Erro no download do arquivo '.$dados['anexo'][0] -> pr_anexo, '', '');
                                                $this -> Usuarios_model -> log('erro', 'Interna/download', 'Erro no download do arquivo '.$dados['anexo'][0] -> pr_anexo, 'tb_anexos', $dados['anexo'][0] -> pr_anexo);
                        echo "<script type=\"text/javascript\">alert('Erro no download do arquivo. O arquivo está corrompido.');</script>";
                        //echo "<script type=\"text/javascript\">window.location=\"/home_js\";</script>";
                        echo "<noscript>Erro no download do arquivo. O arquivo está corrompido.<br /><a href=\"/home\">Voltar</a></noscript>";
                }
        }
        public function avatar(){
                $this -> load -> model('Usuarios_model');

                $erro=false;
                $codigo = $this -> uri -> segment(3);
                if(strlen($codigo)>0){
                        $arq="pics/{$codigo}";
                        $fp = fopen($arq, 'rb');
                        $tamanho=filesize($arq);

                        $content = fread($fp, $tamanho);

                        fclose($fp);

                        if($tamanho>0){
                                if(strlen($content)>0){
                                        header("Content-length: {$tamanho}");
                                        header("Content-type: image/jpeg");
                                        header("Content-Disposition: inline; filename=\"{$codigo}.jpg\"");

                                        //$content = addslashes($content);
                                        echo $content;
                                }
                                else{
                                        $this -> Usuarios_model -> log('erro', 'Interna/avatar', "Erro na exibição do avatar {$codigo}", 'tb_usuarios', $this -> session -> uid);
                                        $erro=true;
                                }
                        }
                        else{
                                //log_site(2, 'Download', "Tentativa de download de arquivo inexistente {$_SESSION['sindesp']['id']}_{$_GET['mes']}_{$_GET['ano']}.pdf pelo EPPGG {$_SESSION['sindesp']['id']}.", '', '');
                                $erro=true;
                        }
                }
                else{
                        //log_site(2, 'Download', "Tentativa de download de arquivo inexistente {$_SESSION['sindesp']['id']}_{$_GET['mes']}_{$_GET['ano']}.pdf pelo EPPGG {$_SESSION['sindesp']['id']}.", '', '');
                        $erro=true;
                }
                if($erro){
                        $arq2='images/nopic.jpg';
                        $fp2 = fopen($arq2, 'rb');
                        $tamanho2=filesize($arq2);
                        $content = fread($fp2, $tamanho2);
                        header("Content-length: {$tamanho2}");
                        header("Content-type: image/jpeg");
                        header("Content-Disposition: inline; filename=\"nopic.jpg\"");
                        fclose($fp2);
                        echo $content;
                        //echo "<script type=\"text/javascript\">alert('Erro no download do arquivo. O arquivo está corrompido. Entre em contato com os responsáveis pelo sistema.');</script>";
                        //echo "<noscript>Erro no download do arquivo. O arquivo está corrompido. Entre em contato com os responsáveis pelo sistema.<br /><a href=\"index.php\">Voltar</a></noscript>";
                }
        }
	public function auditoria(){
                $this -> load -> helper('date');
                if($this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $pagina['menu1']='Interna';
                $pagina['menu2']='auditoria';
                $pagina['url']='Interna/auditoria';
                $pagina['nome_pagina']='Auditoria';
                $pagina['icone']='fa fa-gear';

                $dados=$pagina;
                $dados['adicionais'] = array(
                                            'datatables' => true);

                $dados['log'] = $this -> Usuarios_model -> get_log('');
                $this -> load -> view('auditoria', $dados);
        }
}
