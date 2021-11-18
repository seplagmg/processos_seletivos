<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editais_model extends CI_Model {
        function __construct() {
                parent::__construct();
        }
        public function get_editais($id='',$publicado=true,$inativo = false){
                if(strlen($id) > 0){
                        $this -> db -> where('pr_edital', $id);
                }
                //validação para o órgão
                if($this -> session -> perfil == 'orgaos'){
                        $this -> db -> where('e.es_instituicao',$this -> session -> instituicao);

                        if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                                //seleciona todos os tipos de editais
                        }
                        else if($this -> session -> brumadinho == '1'){
                                $this -> db -> where('en_tipo_edital','brumadinho');
                        }
                        else if($this -> session -> pps == '1'){
                                $this -> db -> where('en_tipo_edital','pps');
                        }
                        else{
                                //não retorna nada se não estiver nos dois grupos
                                $this -> db -> where('1 != 1');
                        }
                }
                else if($this -> session -> perfil == 'sugesp'){
                        //validação para o supervisor

                        if($this -> session -> brumadinho == '1' && $this -> session -> pps == '1'){
                                //seleciona todos os tipos de editais
                        }
                        else if($this -> session -> brumadinho == '1'){
                                $this -> db -> where('en_tipo_edital','brumadinho');
                        }
                        else if($this -> session -> pps == '1'){
                                $this -> db -> where('en_tipo_edital','pps');
                        }
                        else{
                                //não retorna nada se não estiver nos dois grupos
                                $this -> db -> where('1 != 1');
                        }
                }
                if($publicado){
                        $this -> db -> where('en_status`','publicado');
                }
                $this -> db -> select('e.*,i.vc_instituicao,(select count(1) from tb_vagas where es_edital=e.pr_edital) as total_vagas,(select count(1) from tb_vagas where es_edital=e.pr_edital and bl_finalizado=\'1\') as total_finalizado');
                $this -> db -> from("tb_editais e");
                $this -> db -> join('tb_instituicoes2 i', 'e.es_instituicao=i.pr_instituicao');


                $this -> db -> order_by ('vc_edital', 'ASC');
                $query = $this -> db -> get();
                //echo $this -> db -> last_query();
                if(strlen($id) > 0){
                        return $query -> row();
                }
                else if($query -> num_rows() >= 1){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        public function create_edital($dados){
                if(!isset($dados['restrito']) || strlen($dados['restrito']) == 0){
                        $dados['restrito']=NULL;
                }
                $data=array(
                        'en_tipo_edital' => $dados['TipoEdital'],
                        'vc_edital' => $dados['Nome'],
                        'dt_aprovacao' => $dados['Aprovacao'],
                        'es_instituicao' => $dados['Instituicao'],
                        'nu_vagas_fundamental' => $dados['Fundamental'],
                        'nu_vagas_medio' => $dados['Medio'],
                        'en_status' => 'aprovado',
                        'nu_vagas_superior' => $dados['Superior'],
                        'bl_restrito' => $dados['restrito'],
                        'es_usuario_criacao' => $this -> session -> uid
                );
                $this -> db -> insert ('tb_editais', $data);
                //echo $this -> db -> last_query();
                return $this -> db -> insert_id();
        }
        public function update_edital($campo, $valor, $primaria){
                if(strlen($primaria)==0){
                        return FALSE;
                }
                if(strlen($campo)==0){
                        return FALSE;
                }
                $this -> db -> set ($campo, $valor);
                $this -> db -> where('pr_edital', $primaria);
                $this -> db -> update ('tb_editais');
                return $this -> db -> affected_rows();
        }
        public function get_prorrogacao_edital($id='',$edital=''){
                if(strlen($id) > 0){
                        $this -> db -> where('pr_prorrogacao', $id);
                }
                if(strlen($edital) > 0){
                        $this -> db -> where('es_edital', $edital);
                }

                $this -> db -> select('p.*,u.vc_nome');
                $this -> db -> from("tb_prorrogacao_editais p");
                $this -> db -> join('tb_usuarios u', 'p.es_usuario=u.pr_usuario');

                $this -> db -> order_by ('p.dt_prorrogacao', 'ASC');
                $query = $this -> db -> get();

                if(strlen($id) > 0){
                        return $query -> row();
                }
                else if($query -> num_rows() >= 1){
                        return $query -> result();
                }
                else{
                        return NULL;
                }
        }
        public function create_prorrogacao($dados){
                $data=array(
                        'es_edital' => $dados['Edital'],
                        'es_usuario' => $this -> session -> uid,
                        'dt_prorrogacao' => date('Y-m-d H:i:s'),
                        'dt_fim_antigo' => $dados['Antigo'],
                        'dt_fim_novo' => $dados['Novo'],
                        'vc_link' => $dados['LinkProrrogacao'],
                );
                $this -> db -> insert ('tb_prorrogacao_editais', $data);
                return $this -> db -> insert_id();
        }
}
