<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vagas extends CI_Controller {
        function __construct() {
                parent::__construct();
                if(!$this -> session -> logado){
                        redirect('Publico');
                }
                else if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador' && $this -> session -> perfil != 'avaliador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Vagas_model');
        }

	public function index($inativo='0'){
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $this -> load -> helper('date');
                $this -> load -> model('Candidaturas_model');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='index';
                $pagina['url']='Vagas/index';
                $pagina['nome_pagina']='Lista de vagas';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $dados['adicionais'] = array('datatables' => true);
                if($inativo == '0'){
                        if($this -> session -> perfil == 'avaliador'){
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object', '', 0, '', true,'',$this -> session -> uid);
                        }
                        else{
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object', '', 0, '', true,'');
                        }
                }
                else{
                        if($this -> session -> perfil == 'avaliador'){
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object', '', 0, '', false,'',$this -> session -> uid);
                        }
                        else{
                                $dados['vagas'] = $this -> Vagas_model -> get_vagas('', false, 'object');
                        }
                }

                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '','','','11');
                if(isset($candidaturas)){
                        foreach($candidaturas as $candidatura){
                                $dados['aguardando_decisao'][$candidatura -> es_vaga] = 1;
                        }
                }
                $dados['inativo'] = $inativo;
                $dados['sucesso'] = '';
                $dados['erro'] = '';

                //$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '','','','7');
                $this -> load -> view('vagas', $dados);
	}
        public function getData(){
                $retorno = array(1=>0,2=>0);
                $this -> load -> model('Editais_model');
                $dados_form = $this -> input -> post(null,true);
                if(isset($dados_form['edital'])){
                        $edital = $this -> Editais_model -> get_editais ($dados_form['edital']);
                        if(isset($edital)){
                                $retorno[1] = show_date($edital->dt_inicio,true);
                                $retorno[2] = show_date($edital->dt_fim,true);
                        }
                }
                //$retorno = $this -> GruposVagas_model -> get_grupos ();
                echo json_encode($retorno);
                //return json_encode($retorno);
        }
	public function create(){
                if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> model('GruposVagas_model');
                $this -> load -> model('Editais_model');
                $this -> load -> library('MY_Form_Validation');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='create';
                $pagina['url']='Vagas/create';
                $pagina['nome_pagina']='Nova vaga';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $dados['adicionais'] = array('pickers' => true, 'inputmasks' => true);
                //$dados += $this -> input -> post(null,true);

                $this -> form_validation -> set_rules('nome', "'Nome'", 'required|min_length[10]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome\'.'));
                $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
                $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
                $this -> form_validation -> set_rules('grupo', "'Grupo da vaga'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Grupo da vaga\' é obrigatório.'));
                $this -> form_validation -> set_rules('quant_avaliadores', "'Quantidade de avaliadores'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Quantidade de avaliadores\' é obrigatório.'));
                $this -> form_validation -> set_rules('edital', "'Edital'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Edital\' é obrigatório.'));
                $this -> form_validation -> set_rules('cargo', "'Cargo'", 'required');
                $this -> form_validation -> set_rules('remuneracao', "'Remuneração'", 'required');
                $this -> form_validation -> set_rules('documentacao', "'Documentação necessária'", 'required');
                $this -> form_validation -> set_rules('requisitos', "'Requisitos Mínimos'", 'required');

                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] = validation_errors();
                }
                else{
                        $dados_form = $this -> input -> post(null,true);
                        $dados_form['brumadinho'] = '1';
                        if(!isset($dados_form['ensinomedio']) || !($dados_form['ensinomedio'] == '1')){
                                $dados_form['ensinomedio'] = null;
                        }

                        $vaga = $this -> Vagas_model -> create_vaga($dados_form);
                        if($vaga > 0){
                                $dados['sucesso'] = 'Vaga cadastrada com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Vagas/index').'">Voltar</a></button>';
                                $dados['erro'] =  NULL;

                                $this -> Usuarios_model -> log('sucesso', 'Vagas/create', "Vaga {$vaga} criada com sucesso pelo usuario ".$this -> session -> uid.".", 'tb_vagas', $vaga);
                        }
                        else{
                                $dados['sucesso'] = '';
                                $dados['erro'] =  'Erro no cadastro da vaga. Os responsáveis já foram avisados.';
                                $this -> Usuarios_model -> log('erro', 'Vagas/create', 'Erro de criação da vaga. Erro: '.$this -> db -> error('message'));
                        }
                }
                $dados['editais'] = $this -> Editais_model -> get_editais();
                if($this -> session -> perfil == 'orgaos'){
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes($this -> session -> instituicao);
                }
                else{
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                }
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos();
                $this -> load -> view('vagas', $dados);
        }
        public function edit(){
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                else if($this -> uri -> segment(3) == 'Interna'){
                        redirect('Interna/index');
                        exit();
                }
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Instituicoes_model');
                $this -> load -> model('GruposVagas_model');
                $this -> load -> model('Editais_model');
                $this -> load -> library('MY_Form_Validation');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='edit';
                $pagina['url']='Vagas/edit';
                $pagina['nome_pagina']='Gerenciar vaga';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $dados['adicionais'] = array('pickers' => true, 'inputmasks' => true, 'datatables' => true);

                $dados_form = $this -> input -> post(null,true);
                $vaga = $this -> uri -> segment(3);
                $externo = $this -> uri -> segment(4);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $vaga = $dados_form['codigo'];
                }

                $dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
                $dados['codigo'] = $vaga;
                $dados += (array) $dados_vaga[0];

                $this -> form_validation -> set_rules('nome', "'Nome'", 'required|min_length[10]|minus_maius', array('minus_maius' => 'Não utilize somente maiúsculas ou minúsculas no campo \'Nome\'.'));
                $this -> form_validation -> set_rules('descricao', "'Descrição'", 'required|min_length[10]');
                $this -> form_validation -> set_rules('instituicao', "'Instituição'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Instituição\' é obrigatório.'));
                $this -> form_validation -> set_rules('grupo', "'Grupo da vaga'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Grupo da vaga\' é obrigatório.'));
                $this -> form_validation -> set_rules('quant_avaliadores', "'Quantidade de avaliadores'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Quantidade de avaliadores\' é obrigatório.'));
                $this -> form_validation -> set_rules('edital', "'Edital'", 'required|maior_que_zero', array('maior_que_zero' => 'O campo \'Edital\' é obrigatório.'));
                $this -> form_validation -> set_rules('cargo', "'Cargo'", 'required');
                $this -> form_validation -> set_rules('remuneracao', "'Remuneração'", 'required');
                $this -> form_validation -> set_rules('documentacao', "'Documentação necessária'", 'required');
                $this -> form_validation -> set_rules('requisitos', "'Requisitos Mínimos'", 'required');

                $dados['usuarios2'] = $this -> Usuarios_model -> get_usuarios ('', '', 2, '', true, "<>".$dados_vaga[0] -> es_instituicao);
                $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios ('', '', 2, '', true, $dados_vaga[0] -> es_instituicao);

                $usuarios = $dados['usuarios'];
                $usuarios2 = $dados['usuarios2'];

                $vagas_avaliadores = $this -> Vagas_model -> get_vagas_avaliadores($vaga);

                if($vagas_avaliadores){
                        foreach($vagas_avaliadores as $vaga_avaliador){
                               $dados['avaliador'][$vaga_avaliador->es_usuario] =  $vaga_avaliador->es_usuario;
                        }
                }

                if ($this -> form_validation -> run() == FALSE){
                        $dados['sucesso'] = '';
                        $dados['erro'] = validation_errors();
                }
                else{
                        $dados_form['brumadinho'] = '1';
                        if(!isset($dados_form['ensinomedio']) || !($dados_form['ensinomedio'] == '1')){
                                $dados_form['ensinomedio'] = null;
                        }
                        $this -> Vagas_model -> update_vaga('vc_vaga', $dados_form['nome'], $vaga);
                        $this -> Vagas_model -> update_vaga('tx_descricao', $dados_form['descricao'], $vaga);
                        $this -> Vagas_model -> update_vaga('es_instituicao', $dados_form['instituicao'], $vaga);
                        $this -> Vagas_model -> update_vaga('es_grupoVaga', $dados_form['grupo'], $vaga);
                        $this -> Vagas_model -> update_vaga('bl_brumadinho', $dados_form['brumadinho'], $vaga);
                        $this -> Vagas_model -> update_vaga('in_quant_avaliadores', $dados_form['quant_avaliadores'], $vaga);
                        $this -> Vagas_model -> update_vaga('bl_ensinomedio', $dados_form['ensinomedio'], $vaga);

                        $this -> Vagas_model -> update_vaga('es_edital', $dados_form['edital'], $vaga);
                        $this -> Vagas_model -> update_vaga('vc_cargo', $dados_form['cargo'], $vaga);
                        $dados_form['remuneracao'] = str_replace("R$","",$dados_form['remuneracao']);
                        $dados_form['remuneracao'] = str_replace(".","",$dados_form['remuneracao']);
                        $dados_form['remuneracao'] = str_replace(",",".",$dados_form['remuneracao']);

                        $this -> Vagas_model -> update_vaga('vc_remuneracao', $dados_form['remuneracao'], $vaga);
                        $this -> Vagas_model -> update_vaga('tx_orientacoes', $dados_form['orientacoes'], $vaga);
                        $this -> Vagas_model -> update_vaga('tx_documentacao', $dados_form['documentacao'], $vaga);
                        $this -> Vagas_model -> update_vaga('tx_requisitos', $dados_form['requisitos'], $vaga);

                        if(isset($usuarios)){
                                foreach($usuarios as $usuario){
                                        if(isset($dados_form['usuario'.$usuario->pr_usuario]) && $dados_form['usuario'.$usuario->pr_usuario] = $usuario->pr_usuario){
                                                //escreve no log se o avaliador for inserido
                                                if(!isset($dados['avaliador'][$usuario->pr_usuario])){
                                                        $this -> Vagas_model -> create_vaga_avaliador($dados_form,$vaga,$usuario->pr_usuario);
                                                        $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Avaliador {$usuario->pr_usuario} da vaga {$vaga} inserido/atualizado com sucesso pelo usuário ".$this -> session -> uid, 'rl_vagas_avaliadores', $vaga);
                                                }
                                        }
                                        else{
                                                //escreve no log se o avaliador for excluído
                                                if(isset($dados['avaliador'][$usuario->pr_usuario])){
                                                        $this -> Vagas_model -> delete_vaga_avaliador($vaga,$usuario->pr_usuario);
                                                        $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Avaliador {$usuario->pr_usuario} da vaga {$vaga} excluido com sucesso pelo usuário ".$this -> session -> uid, 'rl_vagas_avaliadores', $vaga);
                                                }
                                        }
                                }
                        }
                        if(isset($usuarios2)){
                                foreach($usuarios2 as $usuario){
                                        if(isset($dados_form['usuario'.$usuario->pr_usuario]) && $dados_form['usuario'.$usuario->pr_usuario] = $usuario->pr_usuario){
                                                //escreve no log se o avaliador for inserido
                                                if(!isset($dados['avaliador'][$usuario->pr_usuario])){
                                                        $this -> Vagas_model -> create_vaga_avaliador($dados_form,$vaga,$usuario->pr_usuario);
                                                        $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Avaliador {$usuario->pr_usuario} da vaga {$vaga} inserido/atualizado com sucesso pelo usuário ".$this -> session -> uid, 'rl_vagas_avaliadores', $vaga);
                                                }
                                        }
                                        else{
                                                //escreve no log se o avaliador for excluído
                                                if(isset($dados['avaliador'][$usuario->pr_usuario])){
                                                        $this -> Vagas_model -> delete_vaga_avaliador($vaga,$usuario->pr_usuario);
                                                        $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Avaliador {$usuario->pr_usuario} da vaga {$vaga} excluido com sucesso pelo usuário ".$this -> session -> uid, 'rl_vagas_avaliadores', $vaga);
                                                }
                                        }
                                }
                        }
                        $this -> Usuarios_model -> log('sucesso', 'Vagas/edit', "Vaga {$vaga} editada com sucesso pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);

                        $dados['sucesso'] = 'Vaga editada com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Vagas/index').'">Voltar</a></button>';
                        $dados['erro'] = '';
                }

                $dados['editais'] = $this -> Editais_model -> get_editais();
                if($this -> session -> perfil == 'orgaos'){
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes($this -> session -> instituicao);
                }
                else{
                        $dados['instituicoes'] = $this -> Instituicoes_model -> get_instituicoes();
                }
                $dados['grupos'] = $this -> GruposVagas_model -> get_grupos();

                $this -> load -> view('vagas', $dados);
        }
	public function resultado(){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $pagina['menu1']='Vagas';
                $pagina['menu2']='resultado';
                $pagina['url']='Vagas/resultado';
                $pagina['nome_pagina']='Resultados';
                $pagina['icone']='fa fa-sort-amount-desc';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                $dados['adicionais'] = array('datatables' => true);

                $vaga = $this -> uri -> segment(3);
                $paginacao = $this -> uri -> segment(4);
                if(!($paginacao > 0)){
                        $paginacao = 1;
                }
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $vaga = $dados_form['codigo'];
                }

                $dados['paginacao'] = $paginacao;

                //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
                $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');
                $dados['vaga'] = $vaga;
                if($this -> session -> perfil == 'avaliador'){
                        $vaga_avaliador = $this -> Vagas_model -> get_vagas_avaliadores($vaga,$this -> session -> uid);
                        if(!isset($vaga_avaliador)){
                                //redirect('Interna/index');
                        }
                }
                else{
                        if($this -> session -> perfil == 'orgaos'){
                                if(!isset($dados['vagas'])){
                                        redirect('Interna/index');
                                }
                                else if($dados['vagas'][0] -> es_instituicao != $this -> session -> instituicao){
                                        redirect('Interna/index');
                                }
                                else if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                                        //seleciona todos os tipos de editais
                                }
                                else if($this -> session -> brumadinho == '1' && $dados['vagas'][0] -> en_tipo_edital == 'pps'){
                                        redirect('Interna/index');
                                }
                                else if($this -> session -> pps == '1' && $dados['vagas'][0] -> en_tipo_edital == 'brumadinho'){
                                        redirect('Interna/index');
                                        $this -> db -> where('e.en_tipo_edital','pps');
                                }
                        }
                        else if($this -> session -> perfil == 'sugesp'){
                                if(!isset($dados['vagas'])){
                                        redirect('Interna/index');
                                }
                                else if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                                        //seleciona todos os tipos de editais
                                }
                                else if($this -> session -> brumadinho == '1' && $dados['vagas'][0] -> en_tipo_edital == 'pps'){
                                        redirect('Interna/index');
                                }
                                else if($this -> session -> pps == '1' && $dados['vagas'][0] -> en_tipo_edital == 'brumadinho'){
                                        redirect('Interna/index');
                                        $this -> db -> where('e.en_tipo_edital','pps');
                                }
                        }
                }

                $dados['status'] = $this -> Candidaturas_model -> get_status(0,'7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20');
                $dados_form = $this -> input -> post();
                if(!isset($dados_form['filtro_status'])){
                    $dados_form['filtro_status'] = '';
                }
                if(!isset($dados_form['filtro_nome'])){
                    $dados_form['filtro_nome'] = '';
                }

                $dados['filtro_status'] =  $dados_form['filtro_status'];
                $dados['filtro_nome'] = $dados_form['filtro_nome'];

                if(strlen($dados['filtro_status']) > 0 && $dados['filtro_status'] != '0'){
                        if($this -> session -> perfil == 'avaliador'){
                                $candidaturas = db_query("select c.*,ca.dt_nascimento,ca.vc_nome,v.dt_fim,e.*,s.*,IFNULL((select max(in_nota) from tb_notas where es_etapa = 3 and es_candidatura = c.pr_candidatura),0) as in_nota3,IFNULL((select max(in_nota) from tb_notas where es_etapa = 4 and es_candidatura = c.pr_candidatura and es_competencia is null and es_avaliador is null),0) as in_nota4 from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato join tb_status_candidaturas s on s.pr_status=c.es_status join tb_vagas v on v.pr_vaga = c.es_vaga left join tb_entrevistas e on c.pr_candidatura = e.es_candidatura where c.es_status = ".$dados['filtro_status']." and es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and (e.es_avaliador1 = ".$this -> session -> uid." or e.es_avaliador2 = ".$this -> session -> uid." or e.es_avaliador3 = ".$this -> session -> uid." or c.es_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario=".$this -> session -> uid.")) and ca.bl_removido='0' and c.bl_removido='0' order by in_nota3+in_nota4 desc limit 30".((($paginacao-1)*30)>0?",".(($paginacao-1)*30):""));
                        }
                        else{
                                $candidaturas = db_query("select c.*,ca.dt_nascimento,ca.vc_nome,v.dt_fim,e.*,s.*,IFNULL((select max(in_nota) from tb_notas where es_etapa = 3 and es_candidatura = c.pr_candidatura),0) as in_nota3,IFNULL((select max(in_nota) from tb_notas where es_etapa = 4 and es_candidatura = c.pr_candidatura and es_competencia is null and es_avaliador is null),0) as in_nota4 from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato join tb_status_candidaturas s on s.pr_status=c.es_status join tb_vagas v on v.pr_vaga = c.es_vaga left join tb_entrevistas e on c.pr_candidatura = e.es_candidatura where c.es_status = ".$dados['filtro_status']." and es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and ca.bl_removido='0' and c.bl_removido='0' order by in_nota3+in_nota4 desc limit 30".((($paginacao-1)*30)>0?",".(($paginacao-1)*30):""));
                        }
                        //$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', $dados['filtro_status'], '','',false, $dados['filtro_nome'], $paginacao);
                }
                else{
                        if($this -> session -> perfil == 'avaliador'){
                                $candidaturas = db_query("select c.*,ca.dt_nascimento,ca.vc_nome,v.dt_fim,e.*,s.*,IFNULL((select max(in_nota) from tb_notas where es_etapa = 3 and es_candidatura = c.pr_candidatura),0) as in_nota3,IFNULL((select max(in_nota) from tb_notas where es_etapa = 4 and es_candidatura = c.pr_candidatura and es_competencia is null and es_avaliador is null),0) as in_nota4 from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato join tb_status_candidaturas s on s.pr_status=c.es_status join tb_vagas v on v.pr_vaga = c.es_vaga left join tb_entrevistas e on c.pr_candidatura = e.es_candidatura where c.es_status in (7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20) and es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and (e.es_avaliador1 = ".$this -> session -> uid." or e.es_avaliador2 = ".$this -> session -> uid." or e.es_avaliador3 = ".$this -> session -> uid." or c.es_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario=".$this -> session -> uid.")) and ca.bl_removido='0' and c.bl_removido='0' order by in_nota3+in_nota4 desc limit 30".((($paginacao-1)*30)>0?",".(($paginacao-1)*30):""));
                        }
                        else{
                                $candidaturas = db_query("select c.*,ca.dt_nascimento,ca.vc_nome,v.dt_fim,e.*,s.*,IFNULL((select max(in_nota) from tb_notas where es_etapa = 3 and es_candidatura = c.pr_candidatura),0) as in_nota3,IFNULL((select max(in_nota) from tb_notas where es_etapa = 4 and es_candidatura = c.pr_candidatura and es_competencia is null and es_avaliador is null),0) as in_nota4 from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato join tb_status_candidaturas s on s.pr_status=c.es_status join tb_vagas v on v.pr_vaga = c.es_vaga left join tb_entrevistas e on c.pr_candidatura = e.es_candidatura where c.es_status in (7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20) and es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and ca.bl_removido='0' and c.bl_removido='0' order by in_nota3+in_nota4 desc limit 30".((($paginacao-1)*30)>0?",".(($paginacao-1)*30):""));
                        }
                        //$candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20', '','',false, $dados['filtro_nome'], $paginacao);
                }

                $dados['candidaturas'] = $candidaturas;
                if(strlen($dados['filtro_status']) > 0 && $dados['filtro_status'] != '0'){
                        //$candidaturas_total = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', $dados['filtro_status'], '','',false, $dados['filtro_nome']);
                        if($this -> session -> perfil == 'avaliador'){
                                $dados['total2'] = db_result("select count(1) from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato left join tb_entrevistas e on c.pr_candidatura = e.es_candidatura where c.es_status = ".$dados['filtro_status']." and es_vaga={$vaga} and ca.bl_removido='0' and c.bl_removido='0' and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and (e.es_avaliador1 = ".$this -> session -> uid." or e.es_avaliador2 = ".$this -> session -> uid." or e.es_avaliador3 = ".$this -> session -> uid." or c.es_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario=".$this -> session -> uid."))");
                        }
                        else{
                                $dados['total2'] = db_result("select count(1) from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato where c.es_status = ".$dados['filtro_status']." and es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and ca.bl_removido='0' and c.bl_removido='0'");
                        }
                }
                else{
                        if($this -> session -> perfil == 'avaliador'){
                                $dados['total2'] = db_result("select count(1) from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato left join tb_entrevistas e on c.pr_candidatura = e.es_candidatura where c.es_status in (7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20) and ca.bl_removido='0' and c.bl_removido='0' and c.es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and (e.es_avaliador1 = ".$this -> session -> uid." or e.es_avaliador2 = ".$this -> session -> uid." or e.es_avaliador3 = ".$this -> session -> uid." or c.es_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario=".$this -> session -> uid."))");
                        }
                        else{
                                $dados['total2'] = db_result("select count(1) from tb_candidaturas c join tb_candidatos ca on c.es_candidato = ca.pr_candidato where c.es_status in (7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20) and es_vaga={$vaga} and upper(remove_accents(ca.vc_nome)) like '%".strtoupper(retira_acentos($dados['filtro_nome']))."%' and ca.bl_removido='0' and c.bl_removido='0'");
                        }
                }

                $dados['total_paginas'] = ceil($dados['total2']/30);
                $this -> load -> view('vagas', $dados);
        }
        public function resultado2(){
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Questoes_model');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='resultado2';
                $pagina['nome_pagina']='Resultados por Competência';
                $pagina['icone']='fa fa-sort-amount-desc';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                $dados['adicionais'] = array('datatables' => true);

                $vaga = $this -> uri -> segment(3);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $vaga = $dados_form['codigo'];
                }
                //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
                $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 20');
                $dados['candidaturas'] = $candidaturas;
                if($candidaturas){
                        foreach($candidaturas as $candidatura){
                                $notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '4', 'todos');
                                if(isset($notas)){
                                        foreach($notas as $nota){
                                                if(!isset($dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia])){
                                                        $dados["notas"][$candidatura->pr_candidatura][$nota->es_competencia] = $nota -> in_nota;
                                                        $i[$candidatura->pr_candidatura]=1;
                                                }
                                        }
                                }
                        }
                }
                $dados['competencias'] = $this -> Questoes_model -> get_competencias();

                $this -> load -> view('vagas', $dados);
        }
	public function resultado3(){
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Candidaturas_model');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='resultado3';
                $pagina['url']='Vagas/resultado3';
                $pagina['nome_pagina']='Resultados Reprovados Habilitação';
                $pagina['icone']='fa fa-sort-amount-desc';

                $dados=$pagina;
                $dados['sucesso'] = '';
                $dados['erro'] = '';
                $dados['adicionais'] = array('datatables' => true);

                $vaga = $this -> uri -> segment(3);
                if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                        $vaga = $dados_form['codigo'];
                }
                //$dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);
                $dados['vagas'] = $this -> Vagas_model -> get_vagas($vaga, false, 'object');
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', '20');
                $dados['candidaturas'] = array();
                if($candidaturas){
                        foreach($candidaturas as $candidatura){
                                $notas = $this -> Candidaturas_model -> get_nota ('', $candidatura -> pr_candidatura, '');
                                if(isset($notas)){
                                        //$dados['selecao_entrevista'][$candidatura->es_vaga]=1;
                                        foreach($notas as $nota){

                                                if($nota -> es_etapa == '3'){
                                                        $candidatura -> in_nota3 = $nota -> in_nota;
                                                }
                                        }
                                }
                                $dados['candidaturas'][] = $candidatura;
                        }
                }

                $this -> load -> view('vagas', $dados);
        }
	public function delete(){
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='delete';
                $pagina['url']='Vagas/delete';
                $pagina['nome_pagina']='Desativar vaga';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $vaga = $this -> uri -> segment(3);

                $this -> Vagas_model -> update_vaga('bl_removido', '1', $vaga);
                $dados['sucesso'] = "A vaga foi desativada com sucesso.\n\n<a href=\"".base_url('Vagas/index').'">Voltar</a></button>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'Vagas/delete', "Vaga {$vaga} desativada pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);
                echo "<script type=\"text/javascript\">alert('A vaga foi desativada com sucesso.');window.location='".base_url('Vagas/index')."';</script>";
                //$this -> load -> view('vagas', $dados);
        }
	public function reactivate(){
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='reactivate';
                $pagina['url']='Vagas/reactivate';
                $pagina['nome_pagina']='Reativar vaga';
                $pagina['icone']='fa fa-thumbtack';

                $dados=$pagina;
                $vaga = $this -> uri -> segment(3);

                $this -> Vagas_model -> update_vaga('bl_removido', '0', $vaga);
                $dados['sucesso'] = "A vaga foi reativada com sucesso.\n\n<a href=\"".base_url('Vagas/index').'">Voltar</a></button>';
                $dados['erro'] = '';
                $this -> Usuarios_model -> log('sucesso', 'Vagas/reactivate', "Vaga {$vaga} reaativada pelo usuário ".$this -> session -> uid, 'tb_vagas', $vaga);
                echo "<script type=\"text/javascript\">alert('A vaga foi reativada com sucesso.');window.location='".base_url('Vagas/index')."';</script>";
                //$this -> load -> view('vagas', $dados);
        }
	public function AgendamentoEntrevista($candidatura,$tipo_entrevista='competencia'){ //agendamento - perfil gestores e avaliador
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');
                $this -> load -> library('email');

                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador'){ //gestores
                        $pagina['menu1']='Vagas';
                        $pagina['menu2']='AgendamentoEntrevista';
                        $pagina['url']='Vagas/AgendamentoEntrevista/'.$candidatura.'/'.$tipo_entrevista;
                        $pagina['nome_pagina']='Agendamento de entrevista';
                        $pagina['icone']='fa fa-edit';

                        $dados=$pagina;
                        $dados['adicionais'] = array('pickers' => true,'calendar' => true,'moment'=>true);
                        $dados_form = $this -> input -> post(null,true);
                        //$candidatura = $this -> uri -> segment(3);
                        if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                                $candidatura = $dados_form['codigo'];
                        }
                        $dados['codigo'] = $candidatura;
                        $dados['tipo_entrevista'] = $tipo_entrevista;
                        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

                        if(strlen($dados_candidatura[0] -> es_avaliador_competencia1) > 0){
                                redirect('Interna/index');
                        }
                        $vaga = $this -> Vagas_model -> get_vagas($dados_candidatura[0]->es_vaga, false);
                        $questoes = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 4);

                        if(!isset($questoes)){
                                echo "
                                        <script type=\"text/javascript\">
                                                alert('A entrevista por competência não pode ser aplicada para essa vaga.');
                                                window.location='/Vagas/resultado/".$dados_candidatura[0] -> es_vaga."';
                                        </script>";
                                exit();
                        }

                        if($dados_candidatura[0] -> in_quant_avaliadores > 1){
				$this -> form_validation -> set_rules('avaliador1', "'Avaliador 1'", 'required|differs[avaliador3]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 1\' é obrigatório.','differs'=>'O campo \'Avaliador 1\' deve ser diferente do \'Avaliador 3\'.'));
                                $this -> form_validation -> set_rules('avaliador2', "'Avaliador 2'", 'required|differs[avaliador1]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 2\' é obrigatório.','differs'=>'O campo \'Avaliador 2\' deve ser diferente do \'Avaliador 1\'.'));
				if($dados_candidatura[0] -> in_quant_avaliadores > 2){
                                        $this -> form_validation -> set_rules('avaliador3', "'Avaliador 3'", 'required|differs[avaliador2]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 2\' é obrigatório.','differs'=>'O campo \'Avaliador 3\' deve ser diferente do \'Avaliador 2\'.'));
                                }
                        }
                        else{
                                $this -> form_validation -> set_rules('avaliador1', "'Avaliador 1'", 'required|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 1\' é obrigatório.'));
                        }
                        $this -> form_validation -> set_rules('data', "'Horário da entrevista'", 'required|valida_data|callback_valida_unico3|callback_data_atual', array('required' => 'O campo \'Horário da entrevista\' é obrigatório.', 'valida_data' => 'A data do campo \'Horário da entrevista\' inserida é inválida.'));

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
                                if($entrevista_anterior != null){
                                        $config['protocol'] = 'smpt';
                                        $config['charset'] = 'UTF-8';
                                        $config['smtp_port'] = 25;
                                        $config['smtp_host'] = $this -> config -> item('smtp_host');
                                        $config['smtp_user'] = $this -> config -> item('smtp_user');
                                        $config['smtp_pass'] = $this -> config -> item('smtp_pass');

                                        $config['wordwrap'] = TRUE;
                                        $config['mailtype'] = 'html';

                                        $this->email->initialize($config);

                                        if($entrevista_anterior[0] -> es_avaliador1 != $dados_form['avaliador1']){
                                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                $this -> email -> to($entrevista_anterior[0] -> email1);
                                                $this -> email -> subject('['.$this -> config -> item('nome').'] Alteração de entrevista');
                                                $msg='Olá '.$entrevista_anterior[0] -> nome1.',\n\nOcorreu o cancelamento da sua participação na entrevista:\n\nCandidato(a): '.$entrevista_anterior[0] -> nome_candidato.'\nData: '.show_date($entrevista_anterior[0] -> dt_entrevista, true).'\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                                                $this -> email -> message($msg);
                                                if(!$this -> email -> send()){
                                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email1.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
                                                }
                                                else{
                                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email1.' pelo usuário '. $this -> session -> uid.' feita com sucesso.', 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
                                                }
                                        }
                                        if($entrevista_anterior[0] -> es_avaliador2 != $dados_form['avaliador2']){
                                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                $this -> email -> to($entrevista_anterior[0] -> email2);
                                                $this -> email -> subject('['.$this -> config -> item('nome').'] Alteração de entrevista');
                                                $msg='Olá '.$entrevista_anterior[0] -> nome2.',\n\nOcorreu o cancelamento da sua participação na entrevista:\n\nCandidato(a): '.$entrevista_anterior[0] -> nome_candidato.'\nData: '.show_date($entrevista_anterior[0] -> dt_entrevista, true).'\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                                                $this -> email -> message($msg);
                                                if(!$this -> email -> send()){
                                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email2.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
                                                }
                                                else{
                                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email2.' pelo usuário '. $this -> session -> uid.' feita com sucesso.', 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
                                                }
                                        }
                                        if($entrevista_anterior[0] -> es_avaliador3 != $dados_form['avaliador3']){
                                                $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                                                $this -> email -> to($entrevista_anterior[0] -> email3);
                                                $this -> email -> subject('['.$this -> config -> item('nome').'] Alteração de entrevista');
                                                $msg='Olá '.$entrevista_anterior[0] -> nome3.',\n\nOcorreu o cancelamento da sua participação na entrevista:\n\nCandidato(a): '.$entrevista_anterior[0] -> nome_candidato.'\nData: '.show_date($entrevista_anterior[0] -> dt_entrevista, true).'\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                                                $this -> email -> message($msg);
                                                if(!$this -> email -> send()){
                                                        $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email2.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
                                                }
                                                else{
                                                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$entrevista_anterior[0] -> email2.' pelo usuário '. $this -> session -> uid . ' feita com sucesso.', 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);
                                                }
                                        }
                                        if(substr($entrevista_anterior[0] -> dt_entrevista, 0, 16) != show_sql_date($dados_form['data'], true) || $entrevista_anterior[0] -> es_avaliador1 != $dados_form['avaliador1'] || $entrevista_anterior[0] -> es_avaliador2 != $dados_form['avaliador2'] || $entrevista_anterior[0] -> es_avaliador3 != $dados_form['avaliador3']){
                                                $partes = explode(" ",$dados_form['data']);
                                                $data = $partes[0];
                                                $hora = $partes[1];

                                                $this -> envio_email2($entrevista_anterior[0] -> nome1,$entrevista_anterior[0] -> email1,$entrevista_anterior[0]->nome_candidato,$dados_candidatura,$data,$hora,$dados_form['link']);
                                                //if($dados_candidatura[0] -> es_status==10){
                                                if(strlen($entrevista_anterior[0] -> nome2) > 0){
                                                        $this -> envio_email2($entrevista_anterior[0] -> nome2,$entrevista_anterior[0] -> email2,$entrevista_anterior[0]->nome_candidato,$dados_candidatura,$data,$hora,$dados_form['link']);
                                                }
                                                if(strlen($entrevista_anterior[0] -> nome3) > 0){
                                                        $this -> envio_email2($entrevista_anterior[0] -> nome3,$entrevista_anterior[0] -> email3,$entrevista_anterior[0]->nome_candidato,$dados_candidatura,$data,$hora,$dados_form['link']);
                                                }

                                                $this -> envio_email($dados_candidatura,$vaga,'reagendamento_candidato',array(),$data,$hora,$dados_form['link']);
                                        }
                                }
                                else{
                                        $dados_form['tipo_entrevista'] = $tipo_entrevista;
                                        $this -> Candidaturas_model -> atualiza_entrevista($dados_form);
                                        $entrevista_atual = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);

                                        $partes = explode(" ",$dados_form['data']);
                                        $data = $partes[0];
                                        $hora = $partes[1];

                                        $this -> envio_email3($entrevista_atual[0] -> nome1,$entrevista_atual[0] -> email1,$entrevista_atual[0]->nome_candidato,$dados_candidatura,$data,$hora,$dados_form['link']);
                                        if(strlen($entrevista_atual[0] -> email2) > 0){
                                                $this -> envio_email3($entrevista_atual[0] -> nome2,$entrevista_atual[0] -> email2,$entrevista_atual[0]->nome_candidato,$dados_candidatura,$data,$hora,$dados_form['link']);
                                        }
                                        if(strlen($entrevista_atual[0] -> email3) > 0){
                                                $this -> envio_email3($entrevista_atual[0] -> nome3,$entrevista_atual[0] -> email3,$entrevista_atual[0]->nome_candidato,$dados_candidatura,$data,$hora,$dados_form['link']);
                                        }

					$this -> envio_email($dados_candidatura,$vaga,'agendamento_entrevista',$entrevista_atual,$data,$hora,$dados_form['link']);
                                }
                                if(isset($entrevista_anterior[0])){
                                        $dados_form['tipo_entrevista'] = $tipo_entrevista;

                                        $this -> Candidaturas_model -> atualiza_entrevista($dados_form);
                                }
                                if($dados_candidatura[0] -> es_status == 8){
                                        $this -> Candidaturas_model -> update_candidatura('es_status', 10,  $candidatura);
                                }

                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Entrevista para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' agendada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                                $dados['sucesso'] = 'Entrevista agendada com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Vagas/resultado/'.$dados_candidatura[0]->es_vaga).'">Voltar</a></button>';
                                $dados['erro'] = '';
                        }

                        $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($dados_candidatura[0] -> es_candidato);
                        $dados['candidatura'] = $dados_candidatura;
                        $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios ('', '', 2,$dados_candidatura[0] -> es_vaga,true);
                        $dados['status'] = $this -> Candidaturas_model -> get_status ();
                        $dados['entrevista'] = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
                }
                else{
                        redirect('Interna/index');
                }
                $this -> load -> view('vagas', $dados);
        }

        public function AgendamentoEntrevista2($candidatura){ //modificação avaliador urgência
                if($this -> session -> perfil != 'sugesp' && $this -> session -> perfil != 'orgaos' && $this -> session -> perfil != 'administrador'){
                        redirect('Interna/index');
                }
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');
                $this -> load -> library('email');

                if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador'){ //gestores
                        $pagina['menu1']='Vagas';
                        $pagina['menu2']='AgendamentoEntrevista2';
                        $pagina['url']='Vagas/AgendamentoEntrevista2/'.$candidatura;
                        $pagina['nome_pagina']='Modificação emergencial de entrevistador';
                        $pagina['icone']='fa fa-edit';

                        $dados=$pagina;
                        $dados['adicionais'] = array('pickers' => true,'calendar' => true,'moment'=>true);
                        $dados_form = $this -> input -> post(null,true);
                        //$candidatura = $this -> uri -> segment(3);
                        if(isset($dados_form['codigo']) && $dados_form['codigo'] > 0){
                                $candidatura = $dados_form['codigo'];
                        }
                        $dados['codigo'] = $candidatura;

                        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

                        $dados['entrevista'] = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, 'competencia');
                        $dados['candidatura'] = $dados_candidatura;

                        if(!isset($dados['entrevista'])){
                                redirect('Interna/index');
                        }
                        else if(strtotime($dados['entrevista'][0] -> dt_entrevista) > time() || strlen($dados['candidatura'][0] -> es_avaliador_competencia1) > 0){
                                redirect('Interna/index');

                        }
                        $this -> form_validation -> set_rules('avaliador1', "'Avaliador 1'", 'required|differs[avaliador3]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 1\' é obrigatório.','differs'=>'O campo \'Avaliador 1\' deve ser diferente do \'Avaliador 3\'.'));
                        if($dados_candidatura[0] -> in_quant_avaliadores > 2){
                                $this -> form_validation -> set_rules('avaliador2', "'Avaliador 2'", 'required|differs[avaliador1]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 2\' é obrigatório.','differs'=>'O campo \'Avaliador 2\' deve ser diferente do \'Avaliador 1\'.'));
                                if($dados_candidatura[0] -> in_quant_avaliadores > 1){
                                        $this -> form_validation -> set_rules('avaliador3', "'Avaliador 3'", 'required|differs[avaliador2]|maior_que_zero|callback_valida_unico1', array('maior_que_zero' => 'O campo \'Avaliador 2\' é obrigatório.','differs'=>'O campo \'Avaliador 3\' deve ser diferente do \'Avaliador 2\'.'));
                                }

                        }
                        $this -> form_validation -> set_rules('justificativa', "'Justificativa'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();
                        }
                        else{
                                $dados_form = $this -> input -> post(null,true);
                                if($dados_candidatura[0] -> in_quant_avaliadores <= 2){
                                        $dados_form['avaliador3'] = null;

                                        if($dados_candidatura[0] -> in_quant_avaliadores == 1){
                                                $dados_form['avaliador2'] = null;
                                        }
                                }

                                $this -> Candidaturas_model -> update_entrevista('es_avaliador1',$dados_form['avaliador1'],$dados['entrevista'][0] -> pr_entrevista);
                                $this -> Candidaturas_model -> update_entrevista('es_avaliador2',$dados_form['avaliador2'],$dados['entrevista'][0] -> pr_entrevista);
                                $this -> Candidaturas_model -> update_entrevista('es_avaliador3',$dados_form['avaliador3'],$dados['entrevista'][0] -> pr_entrevista);
                                $dados_form['entrevista'] = $dados['entrevista'][0] -> pr_entrevista;
                                $dados_form['avaliador1_anterior'] = $dados['entrevista'][0] -> es_avaliador1;
                                $dados_form['avaliador2_anterior'] = $dados['entrevista'][0] -> es_avaliador2;
                                $dados_form['avaliador3_anterior'] = $dados['entrevista'][0] -> es_avaliador3;

                                $this -> Candidaturas_model -> salvar_entrevista_justificativa($dados_form);

                                $dados['sucesso'] = 'Alteração com justificativa inserida com sucesso.<br/><br/><button class="btn btn-light"><a href="'.base_url('Vagas/resultado/'.$dados_candidatura[0]->es_vaga).'">Voltar</a></button>';
                                $dados['erro'] = '';

                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista2', 'Entrevista para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' alterada de forma emergencial com sucesso '.$this -> session -> uid, 'tb_entrevistas_justificativa', $dados_candidatura[0] -> pr_candidatura);
                        }

                        $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($dados_candidatura[0] -> es_candidato);

                        $dados['usuarios'] = $this -> Usuarios_model -> get_usuarios ('', '', array(2,3),$dados_candidatura[0] -> es_vaga,true);
                        $dados['status'] = $this -> Candidaturas_model -> get_status ();
                }
                else{
                        redirect('Interna/index');
                }
                $this -> load -> view('vagas', $dados);
        }
        public function JustificarNaoComparecimento($candidatura){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                if($this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'avaliador'){
                        $pagina['menu1']='Vagas';
                        $pagina['menu2']='JustificarNaoComparecimento';
                        $pagina['url']='Vagas/JustificarNaoComparecimento/'.$candidatura;
                        $pagina['nome_pagina']='Justificativa pelo não comparecimento à entrevista';
                        $pagina['icone']='fa fa-edit';

                        $dados=$pagina;

                        $dados['codigo'] = $candidatura;
                        $dados['adicionais'] = array('pickers' => true,'calendar' => true,'moment'=>true);
                        $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

                        $dados['candidato'] = $this -> Candidatos_model -> get_candidatos ($dados_candidatura[0] -> es_candidato);
                        $dados['candidatura'] = $dados_candidatura;
                        if($dados_candidatura[0] -> es_status != '10'){
                                echo "
                                                <script type=\"text/javascript\">
                                                        alert('Só pode reprovar por não comparecimento as candidaturas com entrevistas marcadas.');
                                                        window.location='/Vagas/resultado/".$dados_candidatura[0] -> es_vaga."';
                                                </script>";
                        }

                        $dados['sucesso'] = '';
                        $dados['erro'] = '';

                        $dados_form = $this -> input -> post(null,true);
                        $this -> form_validation -> set_rules('justificativa', "'Justificativa'", 'required');

                        if ($this -> form_validation -> run() == FALSE){
                                $dados['sucesso'] = '';
                                $dados['erro'] = validation_errors();

                        }
                        else{
                                $this -> Candidaturas_model -> update_candidatura('es_status', 15,  $candidatura);
                                $this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura);
                                $this -> Candidaturas_model -> update_candidatura('dt_reprovacao_entrevista', date('Y-m-d H:i:s'),  $candidatura);
                                $this -> Candidaturas_model -> update_candidatura('tx_reprovacao_entrevista', $dados_form['justificativa'],  $candidatura);
                                $this -> Candidaturas_model -> update_candidatura('es_reprovador', $this -> session -> uid,  $candidatura);

                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/JustificarNaoComparecimento', 'Justificativa de não comparecimento da '.$dados_candidatura[0] -> pr_candidatura.' inserida com sucesso '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                                redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
                        }

                        $this -> load -> view('vagas', $dados);
                }
                else{
                        redirect('Interna/index');
                }
        }
        public function reprovar_restantes2($vaga){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
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

                $pagina['menu1']='Vagas';
                $pagina['menu2']='';
                $pagina['url']='Vagas/resultado';
                $pagina['nome_pagina']='Resultados';
                $pagina['icone']='fa fa-sort-amount-desc';
                $dados=$pagina;

                //$vaga = $this -> uri -> segment(3);
                if($vaga == ''){
                        $dados['sucesso'] = '';
                        $dados['erro'] = 'Você deve selecionar a vaga.<br /><br /><a href="'.base_url('Vagas/resultado/'.$vaga).'">Voltar</a></button>';
                }
                else{
                        $this -> Vagas_model -> update_vaga('bl_finalizado','1',$vaga);
                        $dados['sucesso'] = 'A vaga foi finalizada.<br /><br /><a href="'.base_url('Vagas/resultado/'.$vaga).'">Voltar</a></button>';
                        $dados['erro'] = '';
                }

                $this -> load -> view('vagas', $dados);
        }

        public function reprovar_restantes(){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
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

                $pagina['menu1']='Vagas';
                $pagina['menu2']='';
                $pagina['url']='Vagas/resultado';
                $pagina['nome_pagina']='Resultados';
                $pagina['icone']='fa fa-sort-amount-desc';
                $dados=$pagina;

                $vaga = $this -> uri -> segment(3);

                $candidaturas = $this -> Candidaturas_model -> get_candidaturas('', '', $vaga, '', 8);
                foreach($candidaturas as $candidatura){
                        $this -> Candidaturas_model -> update_candidatura('es_status', 9,  $candidatura -> pr_candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura -> pr_candidatura);

                        $candidato = $this -> Candidatos_model -> get_candidatos($candidaturas[0] -> es_candidato);

                        $this -> Usuarios_model -> log('sucesso', 'Vagas/reprovar_restantes', "Candidatura {$candidatura -> pr_candidatura} reprovada na análise curricular.", 'tb_candidaturas', $candidatura -> pr_candidatura);

                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                        $this -> email -> to($candidato -> vc_email);
                        $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação da candidatura na análise curricular');
                        $msg='Olá '.$candidato -> vc_nome.',\n\nObrigado por participar do processo seletivo, mas foi reprovado na análise curricular.\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação dessa candidatura. Acesse o sistema por meio do link: '.base_url();
                        $this -> email -> message($msg);
                        if(!$this -> email -> send()){
                                $this -> Usuarios_model -> log('erro', 'Vagas/reprovar_restantes', 'Erro de envio de e-mail de reprovação na análise curricular da candidatura '.$candidatura[0] -> pr_candidatura.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }
                }
                $dados['sucesso'] = 'As candidaturas sem agendamento de entrevistas foram marcadas como reprovadas.\n\n<a href="'.base_url('Vagas/resultado/'.$vaga).'">Voltar</a></button>';
                $dados['erro'] = '';

                $this -> load -> view('vagas', $dados);
        }
        public function reprovar_habilitacao($id){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');

                $pagina['menu1']='Vagas';
                $pagina['menu2']='';
                $pagina['url']='Vagas/resultado';
                $pagina['nome_pagina']='Resultados';
                $pagina['icone']='fa fa-sort-amount-desc';
                $dados=$pagina;

                $candidatura = $this -> Candidaturas_model -> get_candidaturas($id);

                $this -> Candidaturas_model -> update_candidatura('es_status', 21,  $candidatura[0] -> pr_candidatura);
                //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura[0] -> pr_candidatura);
                $vaga = $this -> Vagas_model -> get_vagas($candidatura[0] -> es_vaga, false);

                $this -> Usuarios_model -> log('sucesso', 'Vagas/reprovar_restantes', "Candidatura {$candidatura[0] -> pr_candidatura} reprovação na habilitação.", 'tb_candidaturas', $candidatura[0] -> pr_candidatura);

                $this -> envio_email($candidatura,$vaga,'reprovacao_curriculo');
                redirect('Vagas/resultado/'.$candidatura[0] -> es_vaga);
        }

        public function teste_aderencia($candidatura){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> model('Questoes_model');

                $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

                $vaga = $this -> Vagas_model -> get_vagas($dados_candidatura[0]->es_vaga, false);
                $questoes = $this -> Questoes_model -> get_questoes('', $vaga[0]->es_grupoVaga, 5);

                if(!isset($questoes)){
                        echo "
                                <script type=\"text/javascript\">
                                        alert('O teste de aderência não pode ser aplicado para essa vaga.');
                                        window.location='/Vagas/resultado/".$dados_candidatura[0] -> es_vaga."';
                                </script>";
                }
                else{
                        $this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Teste de aderência para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' habilitada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                        $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

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

                        $this -> email -> subject('['.$this -> config -> item('nome').'] Teste de aderência');
                        //$msg='Olá '.$dados_candidato->vc_nome.',\n\nO teste de aderência deve ser preenchido.\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                        $msg = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
        <div style=\"color:#304025;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
        <div style=\"font-size: 14px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #304025; mso-line-height-alt: 21px;\">
        <p style=\"font-size: 46px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Processos Seletivos MG</strong></span></p>
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
        <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
        <div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
        <div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
        <p style=\"font-size: 24px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Teste de Aderência</strong></span></p>
        <p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro <strong>{$dados_candidato -> vc_nome}</strong>, foi solicitado o seu Teste de Aderência!</span></p>
        <p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\"> </span><span style=\"color: #000000;\"></span></p>
        <p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Para preenchê-lo basta acessar o sistema, clicar no menu \"Suas Candidaturas\" e, em seguida, no botão amarelo na coluna \"Ações\".</span></span></p>
        <p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
        <p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Preencha o teste com <strong>urgência</strong> para passar para a próxima fase do processo de avaliação.</span></span></p>
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
        <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://200.198.9.206/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#304025\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://200.198.9.206/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #304025; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #304025; border-right: 1px solid #304025; border-bottom: 1px solid #304025; border-left: 1px solid #304025; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
        <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
        </div>
        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"divider\" role=\"presentation\" style=\"table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;\" valign=\"top\" width=\"100%\">
        <tbody>
        <tr style=\"vertical-align: top;\" valign=\"top\">
        <td class=\"divider_inner\" style=\"word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 5px; padding-right: 5px; padding-bottom: 5px; padding-left: 5px;\" valign=\"top\">
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
        <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
        <div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
        <div style=\"font-size: 14px; line-height: 1.8; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25px;\">
        <p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"https://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
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
                        $this -> email -> message($msg);
                        if(!$this -> email -> send()){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
                        }

                        redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
                }
        }

        public function reprovar_revisao_requisitos($candidatura){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('email');

                $this -> Candidaturas_model -> update_candidatura('es_status', 13,  $candidatura);

                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Teste de aderência para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' habilitada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);
                $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

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

                $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação na revisão de requisitos');

                //$msg='Olá '.$dados_candidato->vc_nome.',\n\nSua candidatura foi eliminada na revisão dos requisitos.\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                $msg="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 0px; padding-bottom: 10px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#304025;font-family:'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;line-height:1.5;padding-top:0px;padding-right:10px;padding-bottom:10px;padding-left:10px;\">
<div style=\"font-size: 14px; line-height: 1.5; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #304025; mso-line-height-alt: 21px;\">
<p style=\"font-size: 46px; line-height: 1.5; text-align: center; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 69px; margin: 0;\"><span style=\"color: #304025; font-size: 46px;\"><strong>Processos Seletivos MG</strong></span></p>
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
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Reprovação</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$dados_candidato -> vc_nome}</strong>, sua candidatura foi reprovada por revisão de requisitos!</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Em caso de dúvidas, verifique no sistema a sua situação e <a class=\"aqui\" href=\"https://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">entre em contato</a> com a equipe do Processos Seletivos.<br/></span></span></p>
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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-top: 5px; padding-right: 10px; padding-bottom: 5px; padding-left: 10px\" align=\"left\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"http://200.198.9.206/\" style=\"height:39pt; width:465pt; v-text-anchor:middle;\" arcsize=\"0%\" stroke=\"false\" fillcolor=\"#304025\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, sans-serif; font-size:16px\"><![endif]--><a class=\"botao\" href=\"http://200.198.9.206/\" style=\"-webkit-text-size-adjust: none; text-decoration: none; display: block; color: #ffffff; background-color: #304025; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; width: 100%; width: calc(100% - 2px); border-top: 1px solid #304025; border-right: 1px solid #304025; border-bottom: 1px solid #304025; border-left: 1px solid #304025; padding-top: 10px; padding-bottom: 10px; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; text-align: center; mso-border-alt: none; word-break: keep-all;\" target=\"_blank\"><span style=\"padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;\"><span style=\"font-size: 16px; line-height: 2; word-break: break-word; font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif; mso-line-height-alt: 32px;\"><strong>Acessar o sistema</strong></span></span></a>
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
<p style=\"font-size: 17px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Não consegue acessar o sistema?</span><br/><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Entre em contato <a class=\"aqui\" href=\"https://www.processoseletivo.mg.gov.br/Publico/contato\" rel=\"noopener\" style=\"text-decoration: underline; color: #0068A5;\" target=\"_blank\" title=\"Fale conosco\">aqui</a>.</span></p>
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
                $this -> email -> message($msg);
                if(!$this -> email -> send()){
                        $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
                }
                redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
        }
        public function reprovar_entrevista($candidatura){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
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

                //$candidatura = $this -> uri -> segment(3);
                $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);

                if($dados_candidatura[0] -> en_aderencia =='1'){
                        $this -> Candidaturas_model -> update_candidatura('es_status', 15,  $candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura);

                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Teste de aderência para a candidatura '.$dados_candidatura[0] -> pr_candidatura.' habilitada com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                        $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);
                        $this -> email -> from($this -> config -> item('email'), $this -> config -> item('nome'));
                        $this -> email -> to($dados_candidato -> vc_email);

                        $this -> email -> subject('['.$this -> config -> item('nome').'] Reprovação por não preenchimento do teste de aderência');
                        $msg='Olá '.$dados_candidato->vc_nome.',\n\nSua candidatura foi eliminada pelo não preenchimento do teste de aderência.\n\nEm caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                        $this -> email -> message($msg);
                        if(!$this -> email -> send()){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
                        }
                }
                redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
        }

        public function aguardar_decisao_final($candidatura){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                //$this -> load -> library('email');
                //
                //$candidatura = $this -> uri -> segment(3);
                $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);
                $entrevista = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, 'especialista');
                if((strlen($dados_candidatura[0] -> en_aderencia) == 0 || $dados_candidatura[0] -> en_aderencia == '2') && (($dados_candidatura[0] -> es_status == 11 && !isset($entrevista)) || $dados_candidatura[0] -> es_status == 12)){
                        $this -> Candidaturas_model -> update_candidatura('es_status', 14,  $candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura);

                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/teste_aderencia', 'Alteração do status da candidatura '.$dados_candidatura[0] -> pr_candidatura.' para aguardando decisão final com sucesso pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                        $this -> envio_email($dados_candidatura,'','decisao_final');
                }
                redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
        }

         public function aprovar_final($candidatura){
                $this -> load -> model('Candidaturas_model');
                $this -> load -> model('Candidatos_model');
                $this -> load -> model('Usuarios_model');
                $this -> load -> library('email');

                //$candidatura = $this -> uri -> segment(3);
                $dados_candidatura = $this -> Candidaturas_model -> get_candidaturas($candidatura);
                $entrevista = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, 'especialista');
                if($dados_candidatura[0] -> es_status == 11){
                        $this -> Candidaturas_model -> update_candidatura('es_status', 19,  $candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('en_aderencia', '1',  $candidatura);
                        //$this -> Candidaturas_model -> update_candidatura('dt_candidatura', date('Y-m-d H:i:s'),  $candidatura);

                        $this -> Usuarios_model -> log('sucesso', 'Vagas/aprovar_final', 'Candidatura '.$dados_candidatura[0] -> pr_candidatura.' aprovada, com status inserido pelo usuário '.$this -> session -> uid, 'tb_candidaturas', $dados_candidatura[0] -> pr_candidatura);

                        $dados_candidato = $this -> Candidatos_model -> get_candidatos($dados_candidatura[0] -> es_candidato);

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

                        $this -> email -> subject('['.$this -> config -> item('nome').'] Candidatura aprovada');
                        $msg='Olá '.$dados_candidato->vc_nome.',<br /><br />Sua candidatura foi aprovada.<br /><br />Em caso de dúvidas, verifique no sistema do '.$this -> config -> item('nome').' a situação deste agendamento. Acesse o sistema por meio do link: '.base_url();
                        $this -> email -> message($msg);
                        /*if(!$this -> email -> send()){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/teste_aderencia', 'Erro de envio de e-mail de entrevista do '.$dados_candidato->vc_nome);
                        }*/
                }
                redirect('Vagas/resultado/'.$dados_candidatura[0] -> es_vaga);
        }

        public function liberar_vaga($vaga){
               $dados_vaga = $this -> Vagas_model -> get_vagas ($vaga);

               $this -> load -> model('Questoes_model');
               $this -> load -> model('Usuarios_model');

               $questoes1 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 1);
               $questoes2 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 2);
               $questoes3 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 3);

               $questoes4 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 4);
               $questoes5 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 5);//formulário inicial
               //$questoes6 = $this -> Questoes_model -> get_questoes('', $dados_vaga[0] -> es_grupoVaga, 6);

               if((isset($questoes1) || isset($questoes5)) && isset($questoes3)){
                        if($dados_vaga[0] -> es_edital > 0){
                                $this -> Vagas_model -> update_vaga('bl_liberado', '1', $vaga);
                                $this -> Usuarios_model -> log('sucesso', 'Vagas/liberar_vaga', 'Vaga '.$vaga.' liberada com sucesso pelo usuário '.$this -> session -> uid, 'tb_vagas', $vaga);
                                echo "
                                <script type=\"text/javascript\">
                                        alert('Vaga liberada para preenchimento público.');
                                        window.location='/Vagas/index';
                                </script>";
                        }
                        else{
                                echo "
                                <script type=\"text/javascript\">
                                        alert('Insira o edital relativo a essa vaga.');
                                        window.location='/Editais/index';
                                </script>";
                        }
               }
               else{
                        echo "
                                <script type=\"text/javascript\">
                                        alert('Insira as questões de todas as etapas do grupo de vagas relativas a essa vaga.');
                                        window.location='/Questoes/index/".$dados_vaga[0] -> es_grupoVaga."';
                                </script>";
               }
        }
        function valida_unico1($avaliador){
                //return true;
                $candidatura = $this -> input -> post('$codigo');
                $tipo_entrevista = $this -> input -> post('tipo_entrevista');
                $codigo = $this -> input -> post('codigo');

                $data = show_sql_date($this -> input ->post('data'),true);
                $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
                if((isset($entrevista_anterior[0]->es_avaliador1) && $entrevista_anterior[0]->es_avaliador1==$avaliador) || (isset($entrevista_anterior[0]->es_avaliador2) && $entrevista_anterior[0]->es_avaliador2==$avaliador) || (isset($entrevista_anterior[0]->es_avaliador3) && $entrevista_anterior[0]->es_avaliador3==$avaliador)){
                        return true;
                }
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas ('', '', '', '', '', $avaliador);

                if(isset($candidaturas)){
                        foreach($candidaturas as $row){
                                if(substr($row -> dt_entrevista,0,-3) == $data && $row -> pr_candidatura != $codigo && ($avaliador == $row -> es_avaliador1 || $avaliador == $row -> es_avaliador2 || $avaliador == $row -> es_avaliador3)){
                                        $this -> form_validation -> set_message('valida_unico1', 'Já existe uma entrevista marcada para essa data para esse avaliador.');
                                        return false;
                                }
                        }
                }
                return true;

        }
        /*function valida_unico2($avaliador){
                $candidatura = $this -> input -> post('$codigo');
                $tipo_entrevista = $this -> input -> post('tipo_entrevista');
                $data = show_sql_date($this -> input ->post('data'));
                $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
                if(isset($entrevista_anterior[0]->es_avaliador2) && $entrevista_anterior[0]->es_avaliador2==$avaliador){
                        return true;
                }
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas ('', '', '', '', '', $avaliador);
                if(isset($candidaturas)){
                        foreach($candidaturas as $row){
                                if(substr($row -> dt_entrevista,0,-3) == $data){
                                        $this -> form_validation -> set_message('valida_unico2', 'Já existe uma entrevista marcada para essa data para o \'Avaliador 2\'.');
                                        return false;
                                }
                        }
                }
                return true;

        }*/
        function valida_unico3($data){
                //return true;
                $data = show_sql_date($data,true);
                $candidatura = $this -> input -> post('codigo');
                $tipo_entrevista = $this -> input -> post('tipo_entrevista');

                $entrevista_anterior = $this -> Candidaturas_model -> get_entrevistas('', $candidatura, $tipo_entrevista);
                //echo substr($entrevista_anterior[0] -> dt_entrevista,0,-3);
                if(isset($entrevista_anterior[0]->dt_entrevista) && substr($entrevista_anterior[0] -> dt_entrevista,0,-3)==$data){
                        return true;
                }

                $candidaturas2 = $this -> Candidaturas_model -> get_candidaturas ($candidatura);
                $candidato = $candidaturas2[0] -> es_candidato;
                $candidaturas = $this -> Candidaturas_model -> get_candidaturas ('', $candidato, '', '', '', '',1);
                if(isset($candidaturas)){
                        //echo $candidatura;
                        foreach($candidaturas as $row){
                                //echo substr($row -> dt_entrevista,0,-3);
                                if(substr($row -> dt_entrevista,0,-3) == $data){
                                        $this -> form_validation -> set_message('valida_unico3', 'Já existe uma entrevista marcada para essa data para esse candidato.');
                                        return false;
                                }
                        }
                }
                return true;
        }
        function data_atual($data){
                $data = show_sql_date($data);
                if(strtotime($data)<=strtotime(date('Y-m-d'))){
                        $this -> form_validation -> set_message('data_atual', 'A data de agendamento deve ser maior que a atual.');
                        return false;
                }
                //return false;
                return true;
        }
        function data_maior($data){
                $inicio = show_sql_date($data,true);
                $fim = show_sql_date($this -> input -> post('fim'),true);

                if(strtotime($inicio) >= strtotime($fim)){
                        $this -> form_validation -> set_message('data_maior', 'A data de Término deve ser maior que o \'Início das inscrições\'');
                        return false;
                }
                return true;
        }
        private function envio_email($candidatura,$vaga,$modelo,$entrevista='',$data='',$hora='',$link=''){
                $candidato = $this -> Candidatos_model -> get_candidatos ($candidatura[0] -> es_candidato);
                $titulo = array('reprovacao_curriculo'=>'] Reprovação da candidatura na análise curricular','agendamento_entrevista'=>'] Entrevista Marcada','reagendamento_candidato'=>'] Alteração de data/horário de entrevista','decisao_final'=>'] Aprovação para aguardando decisão final');

                if($modelo == 'reprovacao_curriculo'){
                        $msg['reprovacao_curriculo']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
                else if($modelo == 'agendamento_entrevista'){
                        $msg['agendamento_entrevista']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 24px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 43px; margin: 0;\"><span style=\"font-size: 24px; color: #000000;\"><strong>Marcação de Entrevista</strong></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro <strong>{$candidato->vc_nome}</strong>, sua entrevista foi marcada com sucesso!</span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\"> </span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Dia:</strong> <strong>{$data}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><strong><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Horário: {$hora}</span></strong><span style=\"color: #000000;\"></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Link para a entrevista: <strong>{$link}</strong></span></p>
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
                else if($modelo == 'reagendamento_candidato'){
                        $msg['reagendamento_candidato']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Reagendamento de Entrevista</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato -> vc_nome}</strong>, a sua entrevista foi remarcada!</span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\"> </span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Favor verificar a nova data e hora de sua entrevista abaixo:</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Data: {$data}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Horário: {$hora}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Link para a entrevista: <strong>{$link}</strong></span></p>
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
                else if($modelo == 'decisao_final'){
                        $msg['decisao_final']="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Aguardando decisão final</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$candidato -> vc_nome}</strong>, sua candidatura foi avaliada e aguarda decisão final!</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\">Fique atento a quaisquer notificações no sistema ou contatos por parte da equipe do Processos Seletivos Minas. </span></span></p>
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
                //$this -> email -> to($candidato -> vc_email);
                $email = $candidato -> vc_email;
                /*if(isset($entrevista[0] -> email1)){

                                $email .= ",".$entrevista[0] -> email1;
                }

                if(isset($entrevista[0] -> email2)){

                                $email .= ",".$entrevista[0] -> email2;
                }
                if(isset($entrevista[0] -> email3)){

                                $email .= ",".$entrevista[0] -> email3;
                }*/
                //}
                $this -> email -> to($email);
                $this -> email -> subject('['.$this -> config -> item('nome').$titulo[$modelo]);

                $this -> email -> message($msg[$modelo]);
                if(!$this -> email -> send()){
                        if($modelo == 'reprovacao_curriculo'){
                                $this -> Usuarios_model -> log('erro', 'Candidatos/AvaliacaoCurriculo', 'Erro de envio de e-mail de reprovação na habilitação da candidatura '.$candidatura[0] -> pr_candidatura.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }
                        else if($modelo == 'agendamento_entrevista'){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de entrevista do '.$candidato->vc_nome.' pelo usuário '. $this -> session -> uid);
                        }
                        else if($modelo == 'reagendamento_candidato'){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$candidato -> vc_email.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }
                        else if($modelo == 'decisao_final'){
                                $this -> Usuarios_model -> log('erro', 'Candidaturas/aguardar_decisao_final', 'Erro de envio de e-mail de agurdando decisão final do '.$candidato->vc_nome);
                        }
                }
                else{
                        if($modelo == 'agendamento_entrevista'){
                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de entrevista do '.$candidato->vc_nome.' pelo usuário '. $this -> session -> uid.' feita com sucesso.');
                        }
                        else if($modelo == 'reagendamento_candidato'){
                                $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$candidato -> vc_email.' pelo usuário '. $this -> session -> uid.' feita com sucesso.', 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                        }
                }
        }
        private function envio_email2($nome,$email,$nome_candidato,$candidatura,$data,$hora,$link){
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



                $this -> email -> subject('['.$this -> config -> item('nome')."Reagendamento da entrevista");

                $msg = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Reagendamento de Entrevista</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$nome}</strong>, a sua entrevista com o candidato <strong>{$nome_candidato}</strong> foi remarcada!</span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\"> </span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Favor verificar a nova data e hora de sua entrevista abaixo:</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Data: {$data}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Horário: {$hora}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Link para a entrevista: <strong>{$link}</strong></span></p>
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
                $this -> email -> message($msg);

                if(!$this -> email -> send()){
                        $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$email.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
                else{
                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$email.' pelo usuário '. $this -> session -> uid . ' feita com sucesso.', 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
        }
        private function envio_email3($nome,$email,$nome_candidato,$candidatura,$data,$hora,$link){
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



                $this -> email -> subject('['.$this -> config -> item('nome')."Agendamento de entrevista");

                $msg = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

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
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-family: Arial, sans-serif\"><![endif]-->
<div style=\"color:#555555;font-family:Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;line-height:1.8;padding-top:5px;padding-right:10px;padding-bottom:5px;padding-left:10px;\">
<div style=\"line-height: 1.8; font-size: 12px; color: #555555; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 22px;\">
<p style=\"font-size: 14px; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 24px;\"><strong>Reagendamento de Entrevista</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><br/><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Caro(a) <strong>{$nome}</strong>, a sua entrevista com o candidato <strong>{$nome_candidato}</strong> foi marcada!</span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\"> </span></p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"font-size: 17px; color: #000000; mso-ansi-font-size: 18px;\">Favor verificar a data e hora de sua entrevista abaixo:</span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Data: {$data}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"><span style=\"color: #000000;\"><span style=\"font-size: 17px; mso-ansi-font-size: 18px;\"><strong>Horário: {$hora}</strong></span></span></p>
<p style=\"font-size: 14px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 25px; margin: 0;\"> </p>
<p style=\"font-size: 17px; text-align: justify; line-height: 1.8; word-break: break-word; mso-line-height-alt: 31px; mso-ansi-font-size: 18px; margin: 0;\"><span style=\"color: #000000; font-size: 17px; mso-ansi-font-size: 18px;\">Link para a entrevista: <strong>{$link}</strong></span></p>
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
                $this -> email -> message($msg);

                if(!$this -> email -> send()){

                        $this -> Usuarios_model -> log('erro', 'Candidaturas/AgendamentoEntrevista', 'Erro de envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$email.' pelo usuário '. $this -> session -> uid, 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
                else{
                        $this -> Usuarios_model -> log('sucesso', 'Candidaturas/AgendamentoEntrevista', 'Envio de e-mail de alteração de agendamento de entrevista para o e-mail '.$email.' pelo usuário '. $this -> session -> uid . ' feita com sucesso.', 'tb_candidaturas', $candidatura[0] -> pr_candidatura);
                }
        }
}
