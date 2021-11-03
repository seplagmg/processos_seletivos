<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vagas_model extends CI_Model {
        function __construct() {
                parent::__construct();
        }
        public function get_vagas($id='', $vigentes=true, $tipo='array', $not_candidato='',$periodo=0,$grupovaga = '',$removido = false,$status_candidatura='',$avaliador='',$regra=true){
                if(strlen($id) > 0){
                        $this -> db -> where('v.pr_vaga', $id);
                }
                else if(strlen($grupovaga) > 0){
                        $this -> db -> where('v.es_grupoVaga', $grupovaga);
                }
                else {
                        if($vigentes){
                                $this -> db -> where('e.dt_fim >=', date('Y-m-d H:i:s'));
                                $this -> db -> where('v.bl_removido', '0');
                        }
                        else if($removido == true){
                                $this -> db -> where('v.bl_removido', '0');
                        }
                        if(strlen($not_candidato) > 0){
                                $this -> db -> where("v.pr_vaga not in (select es_vaga from tb_candidaturas where es_candidato={$not_candidato} and bl_removido='0') and (v.es_edital not in (select v2.es_edital from tb_candidaturas c2 join tb_vagas v2 on c2.es_vaga = v2.pr_vaga join tb_editais e2 on e2.pr_edital=v2.es_edital where c2.es_candidato='{$not_candidato}' and c2.bl_removido='0' and e2.bl_restrito='1'))");
                        }
                        if($periodo==1){
                                $this -> db -> where("e.dt_inicio<=now() and e.dt_fim>=now() and v.bl_liberado='1'");
                        }
                        else if($periodo==2){
                                $this -> db -> where("e.dt_fim<now() and v.bl_liberado='1'");
                        }
                }
                if(is_array($status_candidatura)){
                        $string_status="";
                        foreach($status_candidatura as $status){
                                $string_status.=$status.",";
                        }
                        $string_status=substr($string_status,0,-1);
                        $this -> db -> where("v.pr_vaga in (select es_vaga from tb_candidaturas where es_status in ({$string_status}))");
                }
                else if(strlen($status_candidatura) > 0){
                        $this -> db -> where("v.pr_vaga in (select es_vaga from tb_candidaturas where es_status in ({$status_candidatura}))");
                }
                if($regra){
                        if($this -> session -> perfil == 'orgaos'){
                                $this -> db -> where('v.es_instituicao',$this -> session -> instituicao);

                                if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                                        //seleciona todos os tipos de editais
                                }
                                else if($this -> session -> brumadinho == '1'){
                                        $this -> db -> where('e.en_tipo_edital','brumadinho');
                                }
                                else if($this -> session -> pps == '1'){
                                        $this -> db -> where('e.en_tipo_edital','pps');
                                }
                                else{
                                        //não retorna nada se não estiver nos dois grupos
                                        //$this -> db -> where('1 != 1');
                                }
                        }
                        else if($this -> session -> perfil == 'sugesp'){
                                //validação para o supervisor

                                if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                                        //seleciona todos os tipos de editais
                                }
                                else if($this -> session -> brumadinho == '1'){
                                        $this -> db -> where('e.en_tipo_edital','brumadinho');
                                }
                                else if($this -> session -> pps == '1'){
                                        $this -> db -> where('e.en_tipo_edital','pps');
                                }
                                else{
                                        //não retorna nada se não estiver nos dois grupos
                                        //$this -> db -> where('1 != 1');
                                }
                        }
                }

                if(strlen($avaliador) > 0){
                        $this -> db -> where("v.pr_vaga in (select es_vaga from rl_vagas_avaliadores where es_usuario={$avaliador})");
                }
                if($tipo == 'array' && $id == ''){
                    $this -> db -> select ('v.pr_vaga, v.vc_vaga');
                }
                else{
                    $this -> db -> select ('e.bl_restrito,e.en_tipo_edital,e.vc_link,v.in_quant_avaliadores, v.pr_vaga, v.vc_vaga, if(e.dt_inicio is not null, e.dt_inicio, v.dt_inicio) as dt_inicio, if(e.dt_fim is not null, e.dt_fim, v.dt_fim) as dt_fim, v.tx_descricao, v.es_instituicao, v.es_grupoVaga, v.bl_removido, g.vc_grupovaga, i.vc_sigla, i.vc_instituicao, v.bl_liberado, v.bl_brumadinho, v.bl_finalizado,v.bl_ensinomedio,v.es_edital,v.vc_cargo,v.vc_remuneracao,v.tx_orientacoes,v.tx_documentacao,e.vc_edital,e.dt_publicacao,e.nu_vigencia_meses,v.tx_requisitos');
                }

                $this -> db -> from('tb_vagas v');
                $this -> db -> join('tb_gruposvagas g', 'v.es_grupoVaga=g.pr_grupovaga');
                $this -> db -> join('tb_instituicoes2 i', 'v.es_instituicao=i.pr_instituicao');
                $this -> db -> join('tb_editais e', 'v.es_edital=e.pr_edital','left');
                $this -> db -> order_by('v.vc_vaga', 'ASC');
                $query = $this -> db -> get();

                if($query -> num_rows() > 0){
                        if(strlen($id) > 0){
                                return $query -> result();
                        }
                        else{
                                if($tipo=='array'){
                                        $results = $query -> result_array();
                                        $vagas = array_column($results, 'vc_vaga', 'pr_vaga');
                                        return $vagas;
                                }
                                else{
                                        $resultado = $query -> result();
                                        foreach ($resultado as $linha){
                                                $this -> db -> from('rl_questoes_vagas');
                                                $this -> db -> where('es_vaga', $linha -> pr_vaga);
                                                $linha -> cont = $this -> db -> count_all_results();
                                                $retorno[] = $linha;
                                        }
                                        return $retorno;
                                }
                        }
                }
                else{
                        return NULL;
                }
        }
        public function update_vaga($campo, $valor, $primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> set ('es_usuarioAlteracao', $this -> session -> uid);
                $this -> db -> set ('dt_alteracao', date('Y-m-d H:i:s'));
                $this -> db -> where('pr_vaga', $primaria);
                $this -> db -> update ('tb_vagas');
                return $this -> db -> affected_rows();
        }
        public function create_vaga($dados){
                $data=array(
                        'vc_vaga' => $dados['nome'],
                        'tx_descricao' => $dados['descricao'],

                        'es_instituicao' => $dados['instituicao'],
                        'es_grupoVaga' => $dados['grupo'],
                        'in_statusVaga' => '1',
			'bl_brumadinho' => $dados['brumadinho'],
                        'es_usuarioCadastro' => $this -> session -> uid,
                        'bl_ensinomedio' => $dados['ensinomedio'],
                        'es_edital' => $dados['edital'],
                        'vc_cargo' => $dados['cargo'],
                        'vc_remuneracao' => $dados['remuneracao'],
                        'tx_documentacao' => $dados['documentacao'],
                        'tx_orientacoes' => $dados['orientacoes'],
                        'tx_requisitos' => $dados['requisitos'],
                        'in_quant_avaliadores' => $dados['quant_avaliadores'],

                        'dt_cadastro' => date('Y-m-d H:i:s')
                );
                $this -> db -> insert ('tb_vagas', $data);
                return $this -> db -> insert_id();
        }

        public function get_vagas_avaliadores($vaga='',$usuario=''){
                if(strlen($vaga) > 0){
                        $this -> db -> where('es_vaga', $vaga);
                }
                if(strlen($usuario) > 0){
                        $this -> db -> where('es_usuario', $usuario);
                }
                $this -> db -> select('*');

                $query = $this -> db -> get('rl_vagas_avaliadores');
                if($query -> num_rows() >= 1){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }

        public function create_vaga_avaliador($dados,$vaga,$usuario){

                $data=array(
                        'es_vaga' => $vaga,
                        'es_usuario' => $dados["usuario{$usuario}"],
                );

                $this -> db -> replace ('rl_vagas_avaliadores', $data);

                 return $this -> db -> affected_rows();
        }

        public function delete_vaga_avaliador($id,$avaliador=''){
                if(strlen($id)==0){
                        return FALSE;
                }
                if(strlen($avaliador) >0){
                        $this -> db -> where('es_usuario', $avaliador);
                }
                $this -> db -> where('es_vaga', $id);
                $this -> db -> delete ('rl_vagas_avaliadores');
                return $this -> db -> affected_rows();
        }
}
