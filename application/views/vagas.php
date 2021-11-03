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

if ($menu2 == 'edit') {
        if(strlen($sucesso) == 0){
                echo "
                <div class=\"col-12\">
                        <div class=\"tsm-inner-content p-0\">
                                <div class=\"main-body\">
                                        <div class=\"page-wrapper p-0\">
                                                <div class=\"page-body\">
                                                        <div class=\"row\" style=\"position:relative;\">
                                                                <div class=\"col-sm-3 shadow-lg p-0\" style=\"max-width:280px; min-width:240px;\">
                                                                        <div class=\"menu1\">
                                                                        <button class=\"tablinks primeiro active\" onclick=\"abreConteudo(event, 'div_gestao')\"><span class=\"pcoded-mclass\">Gestão da vaga</span><span class=\"pcoded-micon\"><i class=\"fas fa-cog\" style=\"margin-left: 12px; font-size:1.3em;\"></i></span></button>
                                                                        <hr class=\"m-0 p-0\" style=\"border:none;\">
                                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'div_informacao')\"><span class=\"pcoded-mclass\">Informações da vaga</span><span class=\"pcoded-micon\"><i class=\"fas fa-info-circle\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                                        <hr class=\"m-0 p-0\" style=\"border:none;\">
                                                                        <button class=\"tablinks\" onclick=\"abreConteudo(event, 'div_avaliadores')\"><span class=\"pcoded-mclass\">Avaliadores da vaga</span><span class=\"pcoded-micon\"><i class=\"fas fa-user-cog\" style=\"margin-left: 12px; font-size:1.3em\"></i></span></button>
                                                                        </div>
                                                                </div>
                                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">";
                echo "                                                          <div class=\"w-100 h-100 p-3 pb-5\">";

        }
        else{
                echo "
                <div class=\"col-12\">
                        <div class=\"tsm-inner-content p-0\">
                                <div class=\"main-body\">
                                        <div class=\"page-wrapper p-0\">
                                                <div class=\"page-body\">
                                                        <div class=\"row\" style=\"position:relative; left:15px;\">
                                                                <!-- Retirado o submenu lateral -->
                                                                <div class=\"col p-0 pr-4\" style=\"background-color: white; min-height: calc(100vh - 70px);\">";
        echo "                                                          <div class=\"w-100 h-100 p-3 pb-5\">";

        }

}
else {
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
                                                                    <div class=\"col-lg-6\">
                                                                        <h4><i class=\"$icone\" style=\"color:black\"></i> &nbsp; {$nome_pagina}";
}

if($menu2 == 'questoes' || $menu2 == 'resultado' || $menu2 == 'resultado2'){
        echo ' - '.$vagas[0] -> vc_vaga;
}

if ($menu2 != 'edit'){
echo "</h4>
                                                                    </div>";
}

if($menu2 == 'index' && $this -> session -> perfil != 'avaliador'){
        echo "
                                                                    <div class=\"col-lg-6 text-right\">
                                                                            <a href=\"".base_url('Vagas/create')."\" class=\"btn btn-primary btn-square\"> <i class=\"fa fa-plus-circle\"></i> Nova vaga </a>
                                                                            <br />

                                                                    </div>";
}
if($menu2 != 'index' && strlen($sucesso) == 0 && ($menu2 == 'create')){
        echo "
                                                                    <div class=\"col-lg-6 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"document.getElementById('form_vagas').submit();\"> Salvar </button>
                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
                                                                    </div>";
}
/*
<button type=\"button\" class=\"btn btn-danger\" onclick=\"confirm_reprovacao(".$vagas[0] -> pr_vaga.");\"> Reprovar não agendados </button>
*/
if($menu2 == 'resultado' && $vagas[0] -> bl_finalizado != '1' && $this -> session -> perfil != 'avaliador'){
        echo "
                                                                    <div class=\"col-lg-6 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-danger\" onclick=\"window.location='".base_url('Vagas/resultado3/'.$vagas[0] -> pr_vaga)."'\">Reprovadas na Habilitação</button>
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"confirm_reprovacao2(".$vagas[0] -> pr_vaga.");\"> Concluir processo </button>
                                                                            ".//<button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Vagas/resultado2/'.$vagas[0] -> pr_vaga)."'\">Detalhamento por competência</button>
                                                                     "</div>";
}
if($menu2 == 'resultado2' || $menu2 == 'resultado3'){
        echo "
                                                                    <div class=\"col-lg-6 text-right\">
                                                                            <button type=\"button\" class=\"btn btn-primary\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vagas[0] -> pr_vaga)."'\">Voltar</button>
                                                                    </div>";
}

if ($menu2 != 'edit'){
echo "
                                                            </div>";
}

if($menu2 == 'index'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <input type=\"checkbox\" id=\"inativo\" onclick=\"check_inativo()\" style=\"margin: 10px 10px 20px 0px; line-height:1.5em;\" ".($inativo == 1? "checked=\"checked\" ":"")." /><span style=\"position:relative; top:-2px; line-height:1.5em;\">Mostrar inativos</span>
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Edital</th>
                                                                                            <th>Instituição</th>
                                                                                            <th>Grupo</th>
                                                                                            <th>Status da vaga</th>
                                                                                            <th>Início inscrição</th>
                                                                                            <th>Fim inscrição</th>";
        /*
        echo "
                                                                                            <th>Questões</th>";
        */
        echo "
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($vagas)){
		$atual = time();
                foreach ($vagas as $linha){
                        $dt_inicio = strtotime($linha -> dt_inicio);
                        $dt_fim = strtotime($linha -> dt_fim);

                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_vaga."</td>
                                                                                            <td>".$linha -> vc_edital."</td>
                                                                                            <td class=\"text-center\">".$linha -> vc_sigla."</td>
                                                                                            <td>".$linha -> vc_grupovaga."</td>
                                                                                            <td>";
                        if($linha -> bl_removido == '0'){
                                if($linha -> bl_liberado != '1'){
                                        echo "Não liberada";
                                }
                                else if($linha -> bl_finalizado == '1'){
                                        echo "Processo concluído";
                                }
                                else{
                                        if($dt_fim > $atual){
                                                echo "Liberada para inscrição";
                                        }
                                        else{
                                                if(isset($aguardando_decisao[$linha -> pr_vaga])){
                                                        echo "Aguardando decisão final";
                                                }
                                                else{
                                                        echo "Candidaturas sobre análise";
                                                }
                                        }
                                }
                        }
                        else{
                                echo "Vaga removida";
                        }
                        echo "</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_inicio,true)."\" data-order=\"$dt_inicio\">".show_date($linha -> dt_inicio,true)."</td>
                                                                                            <td class=\"text-center\" data-search=\"".show_date($linha -> dt_fim,true)."\" data-order=\"$dt_fim\">".show_date($linha -> dt_fim,true)."</td>";
                        /*
                        echo "
                                                                                            <td class=\"text-center\">".$linha -> cont."</td>";
                        */
                        echo "
                                                                                            <td class=\"text-center\">";
                        if($linha -> bl_removido == '0'){
				if($dt_fim < $atual){
                                //if(isset($visualizacao_nota[$linha -> pr_vaga])){
                                        //if(isset($selecao_entrevista[$linha -> pr_vaga])){
                                                //echo anchor('Vagas/selecionar_entrevista/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-edit"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Selecionar candidatos\"");
                                        //}
                                        //echo anchor('Vagas/visualizar_nota/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Visualizar candidato\"");
                                        echo anchor('Vagas/resultado/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-1 fa-sort-amount-down-alt"></i>Resultados', " class=\"btn btn-sm btn-square btn-info\" title=\"Resultados\"");
                                }
                                if($linha -> bl_finalizado != '1' && $this -> session -> perfil != 'avaliador'){
                                        echo anchor('Vagas/edit/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-1 fa-user-cog"></i>Gerenciar', " class=\"btn btn-sm btn-square btn-primary\" title=\"Gerenciar\"");
                                        if(!($linha -> bl_liberado == '1')){
                                                //echo anchor('Vagas/liberar_vaga/'.$linha -> pr_vaga, '<i class="fa fa-lg mr-0 fa-check-square">Liberar para inscrição</i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Liberar para inscrição\"");
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-primary\" title=\"Liberar vaga\" onclick=\"confirm_liberar(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-1 fa-check-square\"></i>Liberar para inscrição</a>";
                                        }
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Desativar vaga\" onclick=\"confirm_delete(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i>Desativar vaga</a>";
                                }
                        }
                        else{
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Reativar vaga\" onclick=\"confirm_reactivate(".$linha -> pr_vaga.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i>Reativar vaga</a>";
                        }

                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "
                                            <script type=\"text/javascript\">
                                                    function confirm_delete(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa desativação?',
                                                                        text: 'A vaga em questão será marcada como desativada.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, desative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/delete/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reactivate(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma essa reativação?',
                                                                        text: 'A vaga em questão voltará a ser considerada pelo sistema.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reative'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reactivate/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_liberar(id){
                                                        $(document).ready(function(){
                                                                swal.fire({
                                                                    title: 'Você confirma a liberação da vaga?',
                                                                    text: 'A vaga em questão será liberada para inscrições, esta ação é irreversível.',
                                                                    type: 'warning',
                                                                    showCancelButton: true,
                                                                    cancelButtonText: 'Não, cancelar',
                                                                    confirmButtonText: 'Sim, liberar'
                                                                })
                                                                .then(function(result) {
                                                                    if (result.value) {
                                                                        $(location).attr('href', '".base_url('Vagas/liberar_vaga/')."' + id)
                                                                    }
                                                                });
                                                        });
                                                }

                                                    function check_inativo(){
                                                            if(document.getElementById('inativo').checked == true){
                                                                    $(location).attr('href', '".base_url('Vagas/index/')."1')
                                                            }
                                                            else{
                                                                    $(location).attr('href', '".base_url('Vagas/index/')."')
                                                            }
                                                    }
                                            </script>
                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [0, 'asc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Exibir: &nbsp &nbsp_MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";
}
else if($menu2 == 'create'){
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }
        if(strlen($sucesso) == 0){
                if(!isset($bl_liberado)){
                        $bl_liberado = '0';
                }
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_vagas');
                if($menu2 == 'edit' && isset($codigo) && $codigo > 0){
                        echo form_open($url, $attributes, array('codigo' => $codigo));
                }
                else{
                        echo form_open($url, $attributes);
                }
                echo "
                <div class=\"kt-portlet__body\">
                        <div class=\"row\">
                                <div class=\"col-sm-12\">";

                echo "<h5 class=\"mb-3\">Gestão da vaga</h5>";

                        $attributes = array('class' => 'control-label', 'title' => 'Escolha a instituição responsável pela vaga', 'alt' => 'Campo com a instituição responsável pela vaga');
                        echo form_label('Instituição: <abbr title="Obrigatório">*</abbr>', 'instituicao', $attributes);

                        $instituicoes=array(0 => '')+$instituicoes;
                        if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('instituicao')) > 0)){
                                $es_instituicao = set_value('instituicao');
                        }
                        if($bl_liberado == '1'){
                                echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\" onchange=\"this.value = '{$es_instituicao}';alert('Não é possível modificar a instituição de uma vaga já liberada para inscrições!')\"");
                        }
                        else if(strstr($erro, "'Instituição'")){
                                echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\"");
                        }

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Escolha o edital ao qual a vaga pertence', 'alt' => 'Campo com a o edital da vaga');
                        echo form_label('Edital <abbr title="Obrigatório">*</abbr>', 'edital', $attributes);


                        $array_editais = array(0 => '');
                        foreach($editais as $edital){
                                $array_editais[$edital -> pr_edital] = $edital -> vc_edital;
                        }

                        if(!isset($es_edital) || (strlen($es_edital) == 0 && strlen(set_value('edital')) > 0)){
                                $es_edital = set_value('edital');
                        }
                        if($bl_liberado == '1'){
                                echo form_dropdown('edital', $array_editais, $es_edital, "id=\"edital\" class=\"form-control\" onchange=\"this.value = '{$es_edital}';alert('Não é possível modificar o edital de uma vaga já liberada para inscrições!')\"");
                        }
                        else if(strstr($erro, "'Edital'")){
                                echo form_dropdown('edital', $array_editais, $es_edital, "id=\"edital\" class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('edital', $array_editais, $es_edital, "id=\"edital\" class=\"form-control\"");
                        }

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Escolha o grupo de questões a ser utilizado na vaga', 'alt' => 'Campo com a indicação do grupo de questões da vaga');
                        echo form_label('Grupo da vaga: <abbr title="Obrigatório">*</abbr>', 'grupo', $attributes);

                        foreach ($grupos as $linha){
                                $dados_grupos[$linha -> pr_grupovaga] = $linha -> vc_grupovaga;
                        }
                        $dados_grupos=array(0 => '')+$dados_grupos;
                        if(!isset($es_grupoVaga) || (strlen($es_grupoVaga) == 0 && strlen(set_value('grupo')) > 0)){
                                $es_grupoVaga = set_value('grupo');
                        }

                        if($bl_liberado == '1'){
                                echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control\"  onchange=\"this.value = '{$es_grupoVaga}';alert('Não é possível modificar o grupo de questões de uma vaga já liberada para inscrições!')\"");
                        }
                        else{
                                if(strstr($erro, "'Grupo da vaga'")){
                                        echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control is-invalid\"");
                                }
                                else{
                                        echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control\"");
                                }
                        }

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Este campo herdou a data e hora definida em edital para início das inscrições', 'alt' => 'Data e hora de início das inscrições da vaga');
                        echo form_label('Início das inscrições: <abbr title="Obrigatório">*</abbr>', 'inicio', $attributes);

                        if(!isset($dt_inicio) || (strlen($dt_inicio) == 0 && strlen(set_value('inicio')) > 0)){
                                $dt_inicio = show_sql_date(set_value('inicio'), true);
                        }
                        $attributes = array('name' => 'inicio',
                                        'id' => 'inicio',
                                        'class' => 'form-control',
                                        'disabled' => 'disabled');
                        if(strstr($erro, "'Início das inscrições'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        echo form_input($attributes, show_date($dt_inicio, true));

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Este campo herdou a data e hora definida em edital para fim das inscrições', 'alt' => 'Data e hora de fim das inscrições da vaga');
                        echo form_label('Término das inscrições: <abbr title="Obrigatório">*</abbr>', 'fim', $attributes);

                        if(!isset($dt_fim) || (strlen($dt_fim) == 0 && strlen(set_value('inicio')) > 0)){
                                $dt_fim = show_sql_date(set_value('fim'), true);
                        }
                        $attributes = array('name' => 'fim',
                                        'id' => 'fim',
                                        'class' => 'form-control',
                                        'disabled' => 'disabled');
                        if(strstr($erro, "'Término das inscrições'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        echo form_input($attributes, show_date($dt_fim, true));

                        echo "<div class=\"form-group row lx-3\"></div>";


                        $attributes = array('class' => 'control-label', 'title' => 'Insira a quantidade de entrevistadores por candidatura', 'alt' => 'Quantidade de entrevistadores para cada candidato');
                        echo form_label('Quantidade de entrevistadores por candidatura: <abbr title="Obrigatório">*</abbr>', 'quant_avaliadores', $attributes);
                        if(!isset($in_quant_avaliadores) || (strlen($in_quant_avaliadores) == 0 && strlen(set_value('quant_avaliadores')) > 0)){
                                $in_quant_avaliadores = set_value('quant_avaliadores');
                        }

                        $attributes = array('name' => 'quant_avaliadores',
                        'id'=>'quant_avaliadores',
                        'maxlength'=>'1',
                        'type'=>'number',
                        'min'=>0,
                        'max'=>3,
                        'oninput' => "if(document.getElementById('quant_avaliadores').value<0){document.getElementById('quant_avaliadores').value=0;} else if(document.getElementById('quant_avaliadores').value>3){document.getElementById('quant_avaliadores').value=3;}",
                        'class' => 'form-control');
                        if(strstr($erro, "'Quantidade de avaliadores'")){
                        $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$in_quant_avaliadores}';alert('Não é possível modificar a quantidade de entrevistadores por candidatura de uma vaga já liberada para inscrições!')";
                        }
                        echo form_input($attributes, $in_quant_avaliadores);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Marque este campo caso não haja exigência de experiência profissional para a vaga', 'alt' => 'Vagas sem exigência de experiência');
                        echo form_label('Vaga sem exigência de experiência?', 'ensinomedio', $attributes);

                        $attributes = array('name' => 'ensinomedio', 'value' => '1', 'class' => 'ml-3');
                        if(!isset($bl_ensinomedio) || (strlen($bl_ensinomedio) == 0 && strlen(set_value('ensinomedio')) > 0)){
                                $bl_ensinomedio = set_value('ensinomedio');
                        }
                        echo form_checkbox($attributes, '1', ($bl_ensinomedio=='1'));

                        echo "<div class=\"form-group row lx-3\"></div>";





                echo "<h5 class=\"mb-3\">Informações da vaga</h5>";

                        $attributes = array('class' => 'control-label', 'title' => 'Digite aqui o nome da vaga', 'alt' => 'Nome da vaga');
                        echo form_label('Nome: <abbr title="Obrigatório">*</abbr>', 'nome', $attributes);
                        if(!isset($vc_vaga) || (strlen($vc_vaga) == 0 && strlen(set_value('nome')) > 0)){
                                $vc_vaga = set_value('nome');
                        }

                        $attributes = array('name' => 'nome',
                        'maxlength'=>'250',
                        'class' => 'form-control');
                        if(strstr($erro, "'Nome'")){
                        $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                        $attributes['onclick'] = "this.value = '{$vc_vaga}';alert('Não é possível modificar o nome uma vaga já liberada para inscrições!')";
                        }
                        echo form_input($attributes, $vc_vaga);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Digite aqui as atribuições da vaga', 'alt' => 'Campo com a descrição das atribuições da vaga');
                        echo form_label('Descrição/Atribuições da vaga: <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);

                        if(!isset($tx_descricao) || (strlen($tx_descricao) == 0 && strlen(set_value('descricao')) > 0)){
                                $tx_descricao = set_value('descricao');
                        }
                        $attributes = array('name' => 'descricao',
                                        'rows'=>'6',
                                        'class' => 'form-control');
                        if(strstr($erro, "'Descrição'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$tx_descricao}';alert('Não é possível modificar a descrição das atribuições de vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_descricao);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Digite aqui o nome do cargo equivalente da vaga', 'alt' => 'Cargo de referência');
                        echo form_label('Cargo estadual de referência: <abbr title="Obrigatório">*</abbr>', 'cargo', $attributes);
                        if(!isset($vc_cargo) || (strlen($vc_cargo) == 0 && strlen(set_value('cargo')) > 0)){
                                $vc_cargo = set_value('cargo');
                        }

                        $attributes = array('name' => 'cargo',
                        'maxlength'=>'250',
                        'class' => 'form-control');
                        if(strstr($erro, "'Cargo'")){
                        $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                        $attributes['onclick'] = "this.value = '{$vc_cargo}';alert('Não é possível modificar o cargo uma vaga já liberada para inscrições!')";
                        }
                        echo form_input($attributes, $vc_cargo);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Digite aqui a remuneração da vaga', 'alt' => 'Remuneração da vaga');
                        echo form_label('Remuneração: <abbr title="Obrigatório">*</abbr>', 'remuneracao', $attributes);
                        if(!isset($vc_remuneracao) || (strlen($vc_remuneracao) == 0 && strlen(set_value('remuneracao')) > 0)){
                                $vc_remuneracao = set_value('remuneracao');
                        }

                        $attributes = array('name' => 'remuneracao',
                        'id' => 'remuneracao',
                        'type' => 'text',
                        'maxlength'=>'250',
                        'class' => 'form-control',
                        'onpaste' => 'return false;',
                        'onKeyPress'=> "return(moeda(this,'.',',',event))");
                        if(strstr($erro, "'Remuneração'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$vc_remuneracao}';alert('Não é possível modificar a remuneração de uma vaga já liberada para inscrições!')";
                        }

                        echo form_input($attributes, $vc_remuneracao);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Insira neste campo a lista de documentos exigidos para habilitação do candidato à vaga', 'alt' => 'Lista de documentos exigidos e definidos em edital');
                        echo form_label('Documentação Necessária: <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);

                        if(!isset($tx_documentacao) || (strlen($tx_documentacao) == 0 && strlen(set_value('documentacao')) > 0)){
                                $tx_documentacao = set_value('documentacao');
                        }
                        $attributes = array('name' => 'documentacao',
                                        'rows'=>'6',
                                        'class' => 'form-control');
                        if(strstr($erro, "'Documentação necessária'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$tx_documentacao}';alert('Não é possível modificar a documentação necessária de vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_documentacao);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Insira neste campo os requisitos exigidos para habilitação do candidato à vaga', 'alt' => 'Requisitos de habilitação mínima definidos em edital');
                        echo form_label('Requisitos para habilitação: <abbr title="Obrigatório">*</abbr>', 'requisitos', $attributes);
                        if(!isset($tx_requisitos) || (strlen($tx_requisitos) == 0 && strlen(set_value('requisitos')) > 0)){
                                $tx_requisitos = set_value('requisitos');
                        }
                        $attributes = array('name' => 'requisitos',
                                        'rows'=>'6',
                                        'class' => 'form-control');
                        if(strstr($erro, "'Requisitos Mínimos'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$tx_requisitos}';alert('Não é possível modificar os requisitos para habilitação de vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_requisitos);

                        echo "<div class=\"form-group row lx-3\"></div>";

                        $attributes = array('class' => 'control-label', 'title' => 'Caso necessário, insira aqui quaisquer informações úteis ao candidato', 'alt' => 'Informações adicionais sobre a vaga');
                        echo form_label('Informações adicionais para o candidato:', 'orientacoes', $attributes);

                        if(!isset($tx_orientacoes) || (strlen($tx_orientacoes) == 0 && strlen(set_value('descricao')) > 0)){
                                $tx_orientacoes = set_value('orientacoes');
                        }
                        $attributes = array('name' => 'orientacoes',
                                        'rows'=>'6',
                                        'class' => 'form-control');
                        if(strstr($erro, "'Orientações'")){
                                $attributes['class'] = 'form-control is-invalid';
                        }
                        if($bl_liberado == '1'){
                                $attributes['onclick'] = "this.value = '{$tx_orientacoes}';alert('Não é possível modificar as informações adicionais de vaga já liberada para inscrições!')";
                        }
                        echo form_textarea($attributes, $tx_orientacoes);

                        echo "<div class=\"form-group row lx-3\"></div>";



                echo "          </div>
                        </div>
                </div>";

                echo "
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div class=\"row\">
                                                                                            <div class=\"col-lg-12 text-left\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_vaga', 'Salvar', $attributes);
                echo "
                                                                                                    <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>
                                                            </div>";
                $pagina['js']="

        <script type=\"text/javascript\">
           function moeda(a, e, r, t) {
                let n = \"\"
                  , h = j = 0
                  , u = tamanho2 = 0
                  , l = ajd2 = \"\"
                  , o = window.Event ? t.which : t.keyCode;
                if (13 == o || 8 == o)
                    return !0;
                if (n = String.fromCharCode(o),
                -1 == \"0123456789\".indexOf(n))
                    return !1;
                for (u = a.value.length,
                h = 0; h < u && (\"0\" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
                    ;
                for (l = \"\"; h < u; h++)
                    -1 != \"0123456789\".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
                if (l += n,
                0 == (u = l.length) && (a.value = \"\"),
                1 == u && (a.value = \"0\" + r + \"0\" + l),
                2 == u && (a.value = \"0\" + r + l),
                u > 2) {
                    for (ajd2 = \"\",
                    j = 0,
                    h = u - 3; h >= 0; h--)
                        3 == j && (ajd2 += e,
                        j = 0),
                        ajd2 += l.charAt(h),
                        j++;
                    for (a.value = \"\",
                    tamanho2 = ajd2.length,
                    h = tamanho2 - 1; h >= 0; h--)
                        a.value += ajd2.charAt(h);
                    a.value += r + l.substr(u - 2, u)
                }
                return !1
            }
            $('#inicio').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });
            $('#fim').datetimepicker({
                language: 'pt-BR',
                autoclose: true,
                format: 'dd/mm/yyyy hh:ii'
            });

            $(document).ready(function(){




                $('#edital').change(function(){
                        var edital = $(this).val();

                        $.ajax({
                                url:'".base_url('Vagas/getData')."',
                                method: 'post',
                                data : $('#edital').serialize(),
                                dataType: 'json',
                                success: function(response){



                                        // Read values


                                        $('#inicio').val(response[1]);
                                        $('#fim').val(response[2]);




                                }
                        });
                });

             });
        </script>";
        }
}
else if ($menu2 == 'edit'){
        if((!isset($es_edital) || !($es_edital > 0)) || (!isset($vc_cargo) || strlen($vc_cargo) ==0) || (!isset($tx_descricao) || strlen($tx_descricao) ==0) || (!isset($vc_cargo) || strlen($vc_cargo) ==0) || (!isset($vc_remuneracao) || strlen($vc_remuneracao) ==0) || (!isset($tx_requisitos) || strlen($tx_requisitos) ==0)){
                $bl_liberado = '0';
        }
        else if(isset($dt_inicio) && strtotime($dt_inicio) > time()){
                $bl_liberado = '0';
        }
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";

        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }

        if(strlen($sucesso) == 0){

                $attributes = array('id' => 'gerenciar_vaga');
                echo form_open($url, $attributes, array('codigo' => $codigo));

                echo "  <div id=\"div_gestao\" class=\"menu1conteudo menu1Primeiro\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">
                                                <h5 class=\"mb-3\"><i class=\"fas fa-cog\" style=\"margin-right: 12px; font-size:1.1em\"></i>Gestão da vaga</h5>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Escolha a instituição responsável pela vaga', 'alt' => 'Campo com a instituição responsável pela vaga');
                                                echo form_label('Instituição: <abbr title="Obrigatório">*</abbr>', 'instituicao', $attributes);

                                                $instituicoes=array(0 => '')+$instituicoes;
                                                if(!isset($es_instituicao) || (strlen($es_instituicao) == 0 && strlen(set_value('instituicao')) > 0)){
                                                        $es_instituicao = set_value('instituicao');
                                                }
                                                if($bl_liberado == '1'){
                                                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\" onchange=\"this.value = '{$es_instituicao}';alert('Não é possível modificar a instituição de uma vaga já liberada para inscrições!')\"");
                                                }
                                                else if(strstr($erro, "'Instituição'")){
                                                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control is-invalid\"");
                                                }
                                                else{
                                                        echo form_dropdown('instituicao', $instituicoes, $es_instituicao, "class=\"form-control\"");
                                                }

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Escolha o edital ao qual a vaga pertence', 'alt' => 'Campo com a o edital da vaga');
                                                echo form_label('Edital <abbr title="Obrigatório">*</abbr>', 'edital', $attributes);


                                                $array_editais = array(0 => '');
                                                foreach($editais as $edital){
                                                        $array_editais[$edital -> pr_edital] = $edital -> vc_edital;
                                                }

                                                if(!isset($es_edital) || (strlen($es_edital) == 0 && strlen(set_value('edital')) > 0)){
                                                        $es_edital = set_value('edital');
                                                }
                                                if($bl_liberado == '1'){
                                                        echo form_dropdown('edital', $array_editais, $es_edital, "id=\"edital\" class=\"form-control\" onchange=\"this.value = '{$es_edital}';alert('Não é possível modificar o edital de uma vaga já liberada para inscrições!')\"");
                                                }
                                                else if(strstr($erro, "'Edital'")){
                                                        echo form_dropdown('edital', $array_editais, $es_edital, "id=\"edital\" class=\"form-control is-invalid\"");
                                                }
                                                else{
                                                        echo form_dropdown('edital', $array_editais, $es_edital, "id=\"edital\" class=\"form-control\"");
                                                }

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Escolha o grupo de questões a ser utilizado na vaga', 'alt' => 'Campo com a indicação do grupo de questões da vaga');
                                                echo form_label('Grupo da vaga: <abbr title="Obrigatório">*</abbr>', 'grupo', $attributes);

                                                foreach ($grupos as $linha){
                                                        $dados_grupos[$linha -> pr_grupovaga] = $linha -> vc_grupovaga;
                                                }
                                                $dados_grupos=array(0 => '')+$dados_grupos;
                                                if(!isset($es_grupoVaga) || (strlen($es_grupoVaga) == 0 && strlen(set_value('grupo')) > 0)){
                                                        $es_grupoVaga = set_value('grupo');
                                                }

                                                if($bl_liberado == '1'){
                                                        echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control\"  onchange=\"this.value = '{$es_grupoVaga}';alert('Não pode modificar o grupo de vaga de uma vaga já liberada para inscrições!')\"");
                                                }
                                                else{
                                                        if(strstr($erro, "'Grupo da vaga'")){
                                                                echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control is-invalid\"");
                                                        }
                                                        else{
                                                                echo form_dropdown('grupo', $dados_grupos, $es_grupoVaga, "class=\"form-control\"");
                                                        }
                                                }

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label' , 'title' => 'Este campo herdou a data e hora definida em edital para início das inscrições', 'alt' => 'Data e hora de início das inscrições da vaga');
                                                echo form_label('Início das inscrições: <abbr title="Obrigatório">*</abbr>', 'inicio', $attributes);

                                                if(!isset($dt_inicio) || (strlen($dt_inicio) == 0 && strlen(set_value('inicio')) > 0)){
                                                        $dt_inicio = show_sql_date(set_value('inicio'), true);
                                                }
                                                $attributes = array('name' => 'inicio',
                                                                'id' => 'inicio',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');
                                                if(strstr($erro, "'Início das inscrições'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, show_date($dt_inicio, true));

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Este campo herdou a data e hora definida em edital para fim das inscrições', 'alt' => 'Data e hora de fim das inscrições da vaga');
                                                echo form_label('Término das inscrições: <abbr title="Obrigatório">*</abbr>', 'fim', $attributes);

                                                if(!isset($dt_fim) || (strlen($dt_fim) == 0 && strlen(set_value('inicio')) > 0)){
                                                        $dt_fim = show_sql_date(set_value('fim'), true);
                                                }
                                                $attributes = array('name' => 'fim',
                                                                'id' => 'fim',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled');
                                                if(strstr($erro, "'Término das inscrições'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                echo form_input($attributes, show_date($dt_fim, true));

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Insira a quantidade de entrevistadores por candidatura', 'alt' => 'Quantidade de entrevistadores para cada candidato');
                                                echo form_label('Quantidade de entrevistadores por candidatura: <abbr title="Obrigatório">*</abbr>', 'quant_avaliadores', $attributes);
                                                if(!isset($in_quant_avaliadores) || (strlen($in_quant_avaliadores) == 0 && strlen(set_value('quant_avaliadores')) > 0)){
                                                        $in_quant_avaliadores = set_value('quant_avaliadores');
                                                }

                                                $attributes = array('name' => 'quant_avaliadores',
                                                'id'=>'quant_avaliadores',
                                                'maxlength'=>'1',
                                                'type'=>'number',
                                                'min'=>0,
                                                'max'=>3,
                                                'oninput' => "if(document.getElementById('quant_avaliadores').value<0){document.getElementById('quant_avaliadores').value=0;} else if(document.getElementById('quant_avaliadores').value>3){document.getElementById('quant_avaliadores').value=3;}",
                                                'class' => 'form-control');
                                                if(strstr($erro, "'Quantidade de avaliadores'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$in_quant_avaliadores}';alert('Não é possível modificar a quantidade de entrevistadores por candidatura de uma vaga já liberada para inscrições!')";
                                                }
                                                echo form_input($attributes, $in_quant_avaliadores);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Marque este campo caso não haja exigência de experiência profissional para a vaga', 'alt' => 'Vagas sem exigência de experiência');
                                                echo form_label('Vaga sem exigência de experiência?', 'ensinomedio', $attributes);

                                                $attributes = array('name' => 'ensinomedio', 'value' => '1', 'class' => 'ml-3');
                                                if(!isset($bl_ensinomedio) || (strlen($bl_ensinomedio) == 0 && strlen(set_value('ensinomedio')) > 0)){
                                                        $bl_ensinomedio = set_value('ensinomedio');
                                                }
                                                echo form_checkbox($attributes, '1', ($bl_ensinomedio=='1'));

                                                echo "<div class=\"form-group row lx-3\"></div>";





                                                $attributes = array('class' => 'btn btn-primary');
                                                echo form_submit('gerenciar_vaga', 'Salvar alterações', $attributes);
                                                echo "
                                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>";

                echo "                  </div>
                                </div>
                        </div>        ";


                echo "        <div id=\"div_informacao\" class=\"menu1conteudo\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">
                                                <h5 class=\"mb-3\"><i class=\"fas fa-info-circle\" style=\"margin-right: 12px; font-size:1.1em\"></i>Informações da vaga</h5>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Digite aqui o nome da vaga', 'alt' => 'Nome da vaga');
                                                echo form_label('Nome: <abbr title="Obrigatório">*</abbr>', 'nome', $attributes);
                                                if(!isset($vc_vaga) || (strlen($vc_vaga) == 0 && strlen(set_value('nome')) > 0)){
                                                        $vc_vaga = set_value('nome');
                                                }

                                                $attributes = array('name' => 'nome',
                                                'maxlength'=>'250',
                                                'class' => 'form-control');
                                                if(strstr($erro, "'Nome'")){
                                                $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$vc_vaga}';alert('Não é possível modificar o nome uma vaga já liberada para inscrições!')";
                                                }
                                                echo form_input($attributes, $vc_vaga);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Digite aqui as atribuições da vaga', 'alt' => 'Campo com a descrição das atribuições da vaga');
                                                echo form_label('Descrição/Atribuições da vaga: <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);

                                                if(!isset($tx_descricao) || (strlen($tx_descricao) == 0 && strlen(set_value('descricao')) > 0)){
                                                        $tx_descricao = set_value('descricao');
                                                }
                                                $attributes = array('name' => 'descricao',
                                                                'rows'=>'6',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Descrição'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$tx_descricao}';alert('Não é possível modificar a descrição das atribuições de vaga já liberada para inscrições!')";
                                                }
                                                echo form_textarea($attributes, $tx_descricao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Digite aqui o nome do cargo equivalente da vaga', 'alt' => 'Cargo de referência');
                                                echo form_label('Cargo estadual de referência: <abbr title="Obrigatório">*</abbr>', 'cargo', $attributes);
                                                if(!isset($vc_cargo) || (strlen($vc_cargo) == 0 && strlen(set_value('cargo')) > 0)){
                                                        $vc_cargo = set_value('cargo');
                                                }

                                                $attributes = array('name' => 'cargo',
                                                'maxlength'=>'250',
                                                'class' => 'form-control');
                                                if(strstr($erro, "'Cargo'")){
                                                $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                $attributes['onclick'] = "this.value = '{$vc_cargo}';alert('Não é possível modificar o nome uma vaga já liberada para inscrições!')";
                                                }
                                                echo form_input($attributes, $vc_cargo);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Digite aqui a remuneração da vaga', 'alt' => 'Remuneração da vaga');
                                                echo form_label('Remuneração: <abbr title="Obrigatório">*</abbr>', 'remuneracao', $attributes);
                                                if(strlen($vc_remuneracao) > 0){
                                                        $vc_remuneracao = str_replace(".",",",$vc_remuneracao);
                                                }
                                                if(!isset($vc_remuneracao) || (strlen($vc_remuneracao) == 0 && strlen(set_value('remuneracao')) > 0)){
                                                        $vc_remuneracao = set_value('remuneracao');
                                                }

                                                $attributes = array('name' => 'remuneracao',
                                                'id' => 'remuneracao',
                                                'type' => 'text',
                                                'maxlength'=>'250',
                                                'class' => 'form-control',
                                                'onpaste' => 'return false;',
                                                'onKeyPress'=> "return(moeda(this,'.',',',event))");
                                                if(strstr($erro, "'Remuneração'")){
                                                $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$vc_remuneracao}';alert('Não é possível modificar a remuneração de uma vaga já liberada para inscrições!')";
                                                }

                                                echo form_input($attributes, $vc_remuneracao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Insira neste campo a lista de documentos exigidos para habilitação do candidato à vaga', 'alt' => 'Lista de documentos exigidos e definidos em edital');
                                                echo form_label('Documentação necessária: <abbr title="Obrigatório">*</abbr>', 'descricao', $attributes);

                                                if(!isset($tx_documentacao) || (strlen($tx_documentacao) == 0 && strlen(set_value('documentacao')) > 0)){
                                                        $tx_documentacao = set_value('documentacao');
                                                }
                                                $attributes = array('name' => 'documentacao',
                                                                'rows'=>'6',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Documentação necessária'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$tx_documentacao}';alert('Não é possível modificar a documentação necessária de vaga já liberada para inscrições!')";
                                                }
                                                echo form_textarea($attributes, $tx_documentacao);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Insira neste campo os requisitos exigidos para habilitação do candidato à vaga', 'alt' => 'Requisitos de habilitação mínima definidos em edital');
                                                echo form_label('Requisitos para habilitação: <abbr title="Obrigatório">*</abbr>', 'requisitos', $attributes);
                                                if(!isset($tx_requisitos) || (strlen($tx_requisitos) == 0 && strlen(set_value('requisitos')) > 0)){
                                                        $tx_requisitos = set_value('requisitos');
                                                }
                                                $attributes = array('name' => 'requisitos',
                                                                'rows'=>'6',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Requisitos Mínimos'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$tx_requisitos}';alert('Não é possível modificar os requisitos para habilitação de vaga já liberada para inscrições!')";
                                                }
                                                echo form_textarea($attributes, $tx_requisitos);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'control-label', 'title' => 'Caso necessário, insira aqui quaisquer informações úteis ao candidato', 'alt' => 'Informações adicionais sobre a vaga');
                                                echo form_label('Informações adicionais para o candidato:', 'orientacoes', $attributes);

                                                if(!isset($tx_orientacoes) || (strlen($tx_orientacoes) == 0 && strlen(set_value('descricao')) > 0)){
                                                        $tx_orientacoes = set_value('orientacoes');
                                                }
                                                $attributes = array('name' => 'orientacoes',
                                                                'rows'=>'6',
                                                                'class' => 'form-control');
                                                if(strstr($erro, "'Orientações'")){
                                                        $attributes['class'] = 'form-control is-invalid';
                                                }
                                                if($bl_liberado == '1'){
                                                        $attributes['onclick'] = "this.value = '{$tx_orientacoes}';alert('Não é possível modificar as informações adicionais para o candidato de vaga já liberada para inscrições!')";
                                                }
                                                echo form_textarea($attributes, $tx_orientacoes);

                                                echo "<div class=\"form-group row lx-3\"></div>";

                                                $attributes = array('class' => 'btn btn-primary');
                                                echo form_submit('gerenciar_vaga', 'Salvar alterações', $attributes);
                                                echo "
                                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>";

                echo "                  </div>
                                </div>
                        </div>        ";


                echo "  <div id=\"div_avaliadores\" class=\"menu1conteudo\">
                                <div class=\"row\">
                                        <div class=\"col-sm-4\">
                                                <h5 class=\"my-2\"><i class=\"fas fa-user-cog\" style=\"margin-right: 12px; font-size:1.1em;\"></i>Avaliadores da vaga</h5>
                                        </div>
                                        <div class=\"col-sm-8 text-right\">
                                                <button type=\"button\" class=\"btn btn-primary mb-3\" onclick=\"abreConteudo(event, 'div_avaliadores_ext')\">Cadastrar avaliador externo</button>
                                        </div>
                                </div>";

                echo "          <div class=\"row\">
                                        <div class=\"col-sm-12\">";

                                                        echo "
                                                                <div class=\"dt-responsive table-responsive\">
                                                                        <table class=\"table table-striped table-bordered table-hover\" id=\"cad_avaliadores_table\">
                                                                                <thead>
                                                                                        <tr>
                                                                                                <th>";
                                                        $attributes = array('id'=>'todos','name' => 'todos', 'value' => '1');
                                                        echo form_checkbox($attributes, FALSE);
                                                        echo "</th>
                                                                                                <th>Nome</th>
                                                                                                <th>CPF</th>
                                                                                                <th>Instituição</th>
                                                                                                <th>Identificação</th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>";

                                                        if(isset($usuarios) || isset($usuarios2)){
                                                                if(isset($usuarios)){
                                                                        foreach ($usuarios as $linha){
                                                                                echo "
                                                                                        <tr>
                                                                                                <td>";
                                                                                $attributes = array('id'=>'usuario'.$linha->pr_usuario,'name' => 'usuario'.$linha->pr_usuario, 'value' => $linha->pr_usuario, 'class'=>'usuario_checkbox');
                                                                                if(isset($avaliador[$linha->pr_usuario]) && $avaliador[$linha->pr_usuario] == $linha->pr_usuario){
                                                                                        echo form_checkbox($attributes,$linha->pr_usuario,TRUE);
                                                                                }
                                                                                else{
                                                                                        echo form_checkbox($attributes,$linha->pr_usuario,FALSE);
                                                                                }
                                                                                echo "</td>
                                                                                                <td>".$linha -> vc_nome."</td>
                                                                                                <td>".$linha -> vc_login."</td>
                                                                                                <td>".$linha -> vc_instituicao."</td>";

                                                                                                if ($linha -> es_instituicao == $this -> session -> instituicao) {
                                                                                                        echo "<td>Avaliador interno</td>";
                                                                                                } else {
                                                                                                        echo "<td>Avaliador externo</td>";
                                                                                                }

                                                                                echo "          </tr>";

                                                                        }
                                                                }
                                                                if(isset($usuarios2)){
                                                                        foreach ($usuarios2 as $linha){
                                                                                if(isset($avaliador[$linha->pr_usuario]) && $avaliador[$linha->pr_usuario] == $linha->pr_usuario){
                                                                                        echo "
                                                                                        <tr>
                                                                                                <td>";
                                                                                        $attributes = array('id'=>'usuario'.$linha->pr_usuario,'name' => 'usuario'.$linha->pr_usuario, 'value' => $linha->pr_usuario, 'class'=>'usuario_checkbox');

                                                                                        echo form_checkbox($attributes,$linha->pr_usuario,TRUE);


                                                                                        echo "</td>
                                                                                                <td>".$linha -> vc_nome."</td>
                                                                                                <td>".$linha -> vc_login."</td>
                                                                                                <td>".$linha -> vc_instituicao."</td>";

                                                                                                /*if ($linha -> es_instituicao == $linha -> es_instituicao) {
                                                                                                        echo "<td>Avaliador interno</td>";
                                                                                                } else {*/
                                                                                                        echo "<td>Avaliador externo</td>";
                                                                                                //}

                                                                                        echo "          </tr>";
                                                                                }

                                                                        }
                                                                }


                                                        }
                                                        else {
                                                                echo "                  <tr>
                                                                                                <td colspan=\"5\">Não foi encontrado nenhum avaliador cadastrado para o órgão</td>

                                                                                        </tr>";
                                                        }


                                                        echo "
                                                                                </tbody>
                                                                        </table>
                                                                </div>
                                        </div>
                                </div>        ";
                echo "          <div class=\"row\">
                                        <div class=\"col-sm-12 text-left\">";

                                                $attributes = array('class' => 'btn btn-primary');
                                                echo form_submit('gerenciar_vaga', 'Salvar Avaliadores', $attributes);
                                                echo "
                                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>";

                echo "
                                        </div>
                                </div>
                        </div>";

                echo "  <div id=\"div_avaliadores_ext\" class=\"menu1conteudo\">
                                <div class=\"row\">
                                        <div class=\"col-sm-12\">
                                                <h5 class=\"mb-3\"><i class=\"fas fa-user-cog\" style=\"margin-right: 12px; font-size:1.1em;\"></i>Avaliadores da vaga</h5>";

                                                        echo "
                                                                <div class=\"dt-responsive table-responsive\">
                                                                        <table class=\"table table-striped table-bordered table-hover\" id=\"cad_avaliadores_table2\">
                                                                                <thead>
                                                                                        <tr>
                                                                                                <th>";
                                                        $attributes = array('id'=>'todos2','name' => 'todos2', 'value' => '1');
                                                        echo form_checkbox($attributes, FALSE);
                                                        echo "</th>
                                                                                                <th>Nome</th>
                                                                                                <th>CPF</th>
                                                                                                <th>Instituição</th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>";

                                                        if(isset($usuarios2)){
                                                                foreach ($usuarios2 as $linha){
                                                                        if(!(isset($avaliador[$linha->pr_usuario]) && $avaliador[$linha->pr_usuario] == $linha->pr_usuario)){

                                                                                echo "
                                                                                        <tr>
                                                                                                <td>";
                                                                                $attributes = array('id'=>'usuario'.$linha->pr_usuario,'name' => 'usuario'.$linha->pr_usuario, 'value' => $linha->pr_usuario, 'class'=>'usuario_checkbox');
                                                                                echo form_checkbox($attributes,$linha->pr_usuario,FALSE);

                                                                                                echo"</td>
                                                                                                <td>".$linha -> vc_nome."</td>
                                                                                                <td>".$linha -> vc_login."</td>
                                                                                                <td>".$linha -> vc_instituicao."</td>";

                                                                                echo "          </tr>";
                                                                        }

                                                                }

                                                        }
                                                        else {
                                                                echo "                  <tr>
                                                                                                <td colspan=\"4\">Não foi encontrado nenhum avaliador cadastrado para o órgão</td>

                                                                                        </tr>";
                                                        }
                                                        echo "
                                                                                </tbody>
                                                                        </table>
                                                                </div>";

                echo "          <div class=\"row\">
                                        <div class=\"col-sm-12 text-left\">";

                                                $attributes = array('class' => 'btn btn-primary');
                                                echo form_submit('gerenciar_vaga', 'Salvar Avaliadores Externos', $attributes);
                                                echo "
                                                        <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/index')."'\">Cancelar</button>";

                echo "
                                        </div>
                                </div>
                        </div>";


                echo "
                                                        </div>
                                                </form>
                                        </div>";

                $pagina['js']="                <script type=\"text/javascript\">
                                        $('#cad_avaliadores_table').DataTable({
                                                order: [
                                                    [2, 'desc']
                                                ],
                                                columnDefs: [
                                                        {
                                                            'orderable': false,
                                                            'targets': [-1]
                                                        },
                                                        {
                                                            'searchable': false,
                                                            'targets': [-1]
                                                        }
                                                ],
                                                language: {
                                                            \"decimal\":        \"\",
                                                            \"emptyTable\":     \"Nenhum item encontrado\",
                                                            \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                            \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                            \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                            \"infoPostFix\":    \"\",
                                                            \"thousands\":      \",\",
                                                            \"lengthMenu\":     \"Mostrar _MENU_\",
                                                            \"loadingRecords\": \"Carregando...\",
                                                            \"processing\":     \"Carregando...\",
                                                            \"search\":         \"Pesquisar:\",
                                                            \"zeroRecords\":    \"Nenhum item encontrado\",
                                                            \"paginate\": {
                                                                \"first\":      \"Primeira\",
                                                                \"last\":       \"Última\",
                                                                \"next\":       \"Próxima\",
                                                                \"previous\":   \"Anterior\"
                                                            },
                                                            \"aria\": {
                                                                \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                            }
                                                },
                                                lengthMenu: [
                                                        [-1],
                                                        [\"Todos\"]
                                                    ]
                                        });
                                        $('#cad_avaliadores_table2').DataTable({
                                                order: [
                                                    [2, 'desc']
                                                ],
                                                columnDefs: [
                                                        {
                                                            'orderable': false,
                                                            'targets': [-1]
                                                        },
                                                        {
                                                            'searchable': false,
                                                            'targets': [-1]
                                                        }
                                                ],
                                                language: {
                                                            \"decimal\":        \"\",
                                                            \"emptyTable\":     \"Nenhum item encontrado\",
                                                            \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                            \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                            \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                            \"infoPostFix\":    \"\",
                                                            \"thousands\":      \",\",
                                                            \"lengthMenu\":     \"Mostrar _MENU_\",
                                                            \"loadingRecords\": \"Carregando...\",
                                                            \"processing\":     \"Carregando...\",
                                                            \"search\":         \"Pesquisar:\",
                                                            \"zeroRecords\":    \"Nenhum item encontrado\",
                                                            \"paginate\": {
                                                                \"first\":      \"Primeira\",
                                                                \"last\":       \"Última\",
                                                                \"next\":       \"Próxima\",
                                                                \"previous\":   \"Anterior\"
                                                            },
                                                            \"aria\": {
                                                                \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                            }
                                                },
                                                lengthMenu: [
                                                        [-1],
                                                        [\"Todos\"]
                                                    ]
                                        });
                                </script>";


        }
        if(!isset($pagina['js'])){
                $pagina['js'] = "";
        }
        $pagina['js'].="
        <script type=\"text/javascript\">
                        function moeda(a, e, r, t) {
                        let n = \"\"
                        , h = j = 0
                        , u = tamanho2 = 0
                        , l = ajd2 = \"\"
                        , o = window.Event ? t.which : t.keyCode;
                        if (13 == o || 8 == o)
                        return !0;
                        if (n = String.fromCharCode(o),
                        -1 == \"0123456789\".indexOf(n))
                        return !1;
                        for (u = a.value.length,
                        h = 0; h < u && (\"0\" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
                        ;
                        for (l = \"\"; h < u; h++)
                        -1 != \"0123456789\".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
                        if (l += n,
                        0 == (u = l.length) && (a.value = \"\"),
                        1 == u && (a.value = \"0\" + r + \"0\" + l),
                        2 == u && (a.value = \"0\" + r + l),
                        u > 2) {
                        for (ajd2 = \"\",
                        j = 0,
                        h = u - 3; h >= 0; h--)
                                3 == j && (ajd2 += e,
                                j = 0),
                                ajd2 += l.charAt(h),
                                j++;
                        for (a.value = \"\",
                        tamanho2 = ajd2.length,
                        h = tamanho2 - 1; h >= 0; h--)
                                a.value += ajd2.charAt(h);
                        a.value += r + l.substr(u - 2, u)
                        }
                        return !1
                }
                function abreConteudo(evt, link) {
                        var i, tabcontent, tablinks;


                        tabcontent = document.getElementsByClassName(\"menu1conteudo\");
                        for (i = 0; i < tabcontent.length; i++) {
                                tabcontent[i].style.display = \"none\";
                        }


                        tablinks = document.getElementsByClassName(\"tablinks\");
                        for (i = 0; i < tablinks.length; i++) {
                                tablinks[i].className = tablinks[i].className.replace(\" active\", \"\");
                        }


                        document.getElementById(link).style.display = \"block\";
                        evt.currentTarget.className += \" active\";

                }

                $('#inicio').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                });
                $('#fim').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                });


                $(document).ready(function(){

                        $('#div_gestao').show();
                        $( \"#todos\" ).click(function(){
                                if ($(\"#todos\").is(':checked')) {
                                        $(':checkbox').prop('checked', true);
                                }
                                else{
                                        $(':checkbox').prop('checked', false);
                                }
                        });
                        $( \"#todos2\" ).click(function(){
                                if ($(\"#todos2\").is(':checked')) {
                                        $(':checkbox').prop('checked', true);
                                }
                                else{
                                        $(':checkbox').prop('checked', false);
                                }
                        });





                        $('#edital').change(function(){
                                var edital = $(this).val();

                                $.ajax({
                                        url:'".base_url('Vagas/getData')."',
                                        method: 'post',
                                        data : $('#edital').serialize(),
                                        dataType: 'json',
                                        success: function(response){



                                                // Read values


                                                $('#inicio').val(response[1]);

                                                $('#fim').val(response[2]);




                                        }
                                });
                        });

                });
        </script>";


}
else if($menu2 == 'resultado'){
        echo "
                                                            <div id=\"accordion\">
                                                                <h3 style=\"font-size:large\">Filtros - Administradores</h3>
                                                                <div>
                                                                    ";
        $attributes = array('id' => 'form_filtros');
        echo form_open($url.'/'.$vaga, $attributes);
        echo "
                                                                        <div class=\"form-group row\">
                                                                            <label for=\"filtro_nome\" class=\"col-lg-2 col-form-label text-right\">Nome</label>
                                                                            <div class=\"col-xl-3 col-lg-4\">";
        $attributes = array('class' => 'form-control',
                            'name' => 'filtro_nome',
                            'id' => 'filtro_nome',
                            'maxlength' => '50');
        echo form_input($attributes, set_value('filtro_nome'));
        echo "
                                                                            </div>
                                                                        </div>

                                                                        <div class=\"form-group row\">
                                                                            <label for=\"nome\" class=\"col-lg-2 col-form-label text-right\">Status</label>
                                                                            <div class=\"col-xl-3 col-lg-4\">";
        //$status=array('' => 'Todos')+$status;
        $status_array = array(0=>'Todos');
        foreach($status as $linha){
            $status_array[$linha->pr_status] = $linha -> vc_status;
        }
        echo form_dropdown('filtro_status', $status_array, $filtro_status, "class=\"form-control\" id=\"filtro_vaga\"");
        echo "
                                                                            </div>
                                                                        </div>

                                                                        <div class=\"j-footer\">
                                                                            <div class=\"row\">
                                                                                <div class=\"col-lg-12 text-center\">";
        /*$attributes = array('class' => 'btn btn-primary');
        echo form_submit('servidores', 'Filtrar', $attributes);*/
        echo "
                                                                                    <button type=\"button\" class=\"btn btn-primary\" onclick=\"botao_submit();\">Filtrar</button>
                                                                                    <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$vaga)."'\">Limpar</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <hr>";
        $pagina['js']="
                                                        <script type=\"text/javascript\">
                                                        $( function() {
                                                                $( '#accordion' ).accordion({ header: 'h3', collapsible: true, active: false });

                                                        } );
                                                        </script>";
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            <th>Nota total</th>
                                                                                            <th>Nota - Anál. Curricular</th>
                                                                                            <th>Nota - Entr. Competência</th>
                                                                                            <th>Idade</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($candidaturas)){
		$atual = time();
                foreach ($candidaturas as $linha){
			$dt_fim = strtotime($linha -> dt_fim);

                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome.'</td>';
                        if($linha -> es_status == 7 || $linha -> es_status == 8){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-warning badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else if($linha -> es_status == 9 || $linha -> es_status ==13 || $linha -> es_status ==15 || $linha -> es_status ==18  || $linha -> es_status ==20){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                        }
                        else if($linha -> es_status == 10 || $linha -> es_status ==11 || $linha -> es_status ==12 || $linha -> es_status ==14 || $linha -> es_status ==16 || $linha -> es_status ==19){
                                echo "
                                                                                            <td class=\"text-center\"><span class=\"badge badge-success badge-lg\">".$linha -> vc_status.'</span></td>';
                        }

                        /*
                        echo "
                                                                                            <td class=\"text-center\">".$linha -> cont."</td>";
                        */


                        if(!isset($linha -> in_nota3) || !(strlen($linha -> in_nota3) > 0)){
                                $linha -> in_nota3 = 0;
                        }

                        if(!isset($linha -> in_nota4) || !(strlen($linha -> in_nota4) > 0)){
                                $linha -> in_nota4 = 0;

                        }

                        $total = 0;
                        if($linha -> in_nota3 != 0){
                                        $total += intval($linha -> in_nota3);
                        }
                        if($linha -> in_nota4 != 0){
                                        $total += intval($linha -> in_nota4);
                        }

                        echo "
                                                                                            <td class=\"text-center\">".$total."</td>
                                                                                            <td class=\"text-center\">".$linha -> in_nota3."</td>
                                                                                            <td class=\"text-center\">".$linha -> in_nota4."</td>
                                                                                            <td class=\"text-center\">";
                        $dataNascimento = $linha -> dt_nascimento;
                        $date = new DateTime($dataNascimento );
                        $interval = $date->diff( new DateTime( date('Y-m-d') ) );
                        echo $interval->format( '%Y anos, %m meses,%d dias' );
                        echo "</td>
                                                                                            <td class=\"text-center\">";


                        echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-search"></i>Detalhes', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                        /*
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i></a>";
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar currículo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                        */

                        if($vagas[0] -> bl_finalizado!= '1'){
                                if($linha -> es_status == 8 || $linha -> es_status == 10){ //candidatura realizada ou selecionado para entrevista por competência
                                        if($this -> session -> perfil != 'avaliador'){
                                                if(strlen($linha -> es_avaliador_competencia1) == 0){
                                                        echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-1 fa-calendar-check"></i>Agendar entrevista por competência', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista por competência\"");
                                                }
                                                //echo $linha -> dt_entrevista;
                                                if(strlen($linha -> dt_entrevista) > 0 && strtotime($linha -> dt_entrevista) <= $atual && strlen($linha -> es_avaliador_competencia1) == 0){
                                                        echo anchor('Vagas/AgendamentoEntrevista2/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-1 fa-calendar-check"></i>Modificação emergencial de entrevistador', " class=\"btn btn-sm btn-square btn-danger\" title=\"Modificação emergencial de entrevistador\"");
                                                }
                                                if(strlen($linha -> es_avaliador_competencia1) == 0 && $this -> session -> perfil == 'orgaos' && $linha -> es_status == 10){
                                                        echo anchor('Vagas/JustificarNaoComparecimento/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-times-circle"></i>Justificar não comparecimento a entrevista', " class=\"btn btn-sm btn-square btn-danger\" title=\"Justificar não comparecimento a entrevista\"");
                                                }
                                        }

                                        if($linha -> es_status == 10 && (($this -> session -> perfil == 'avaliador' ||$this -> session -> perfil == 'sugesp') && ($this -> session -> uid == $linha -> es_avaliador1 || $this -> session -> uid == $linha -> es_avaliador2 || $this -> session -> uid == $linha -> es_avaliador3)) && ($linha -> es_avaliador_competencia1 != $this -> session -> uid && $linha -> es_avaliador_competencia2 != $this -> session -> uid)){ //avaliador
                                                //echo $linha -> dt_entrevista . date('Y-m-d');
                                                if(strlen($linha -> dt_entrevista) > 0 && strtotime($linha -> dt_entrevista) <= $atual){
                                                        echo "<br />";
                                                        echo anchor('Candidaturas/AvaliacaoEntrevista/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-video-camera"></i>Avaliar entrevista', " class=\"btn btn-sm btn-square btn-primary\" title=\"Avaliar entrevista\"");
                                                        if(strlen($linha -> es_avaliador_competencia1) == 0){
                                                                echo anchor('Vagas/JustificarNaoComparecimento/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-times-circle"></i>Justificar não comparecimento a entrevista', " class=\"btn btn-sm btn-square btn-danger\" title=\"Justificar não comparecimento a entrevista\"");
                                                        }
                                                }
                                        }

                                        //if($linha -> es_status == 10 && $this -> session -> perfil == 'sugesp'){

                                        //}
                                        /*echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura.'/especialista', '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Agendar entrevista com especialista\"");*/
                                        /*if(strlen($linha -> en_aderencia) == 0 && $linha -> es_status == 10){
                                                echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-secondary\" title=\"Solicitar teste de aderência\"");
                                        }*/
                                }
                                else if($linha -> es_status == 11 && $this -> session -> perfil != 'avaliador'){ //candidatura com entrevista com competência aprovada
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar candidato\" onclick=\"confirm_aprovacao_final(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i>Aprovar candidato</a>";
                                        /*echo anchor('Vagas/AgendamentoEntrevista/'.$linha -> pr_candidatura.'/especialista', '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Agendar entrevista com especialista\"");
                                        if(strlen($linha -> en_aderencia) == 0){
                                                echo anchor('Vagas/teste_aderencia/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Solicitar teste de aderência\"");
                                        }
                                        if($linha -> en_aderencia == '1'){
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                                        }
                                        else{
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decisão final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i></a>";
                                        }*/
                                }
                                /*else if($linha -> es_status == 12){
                                        if($linha -> en_aderencia == '1'){
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura pelo não preenchimento do teste de aderência\" onclick=\"confirm_reprovacao_entrevista(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                                        }
                                        else{
                                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Mudar para aguardando decisão final\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i></a>";
                                        }
                                }*/
                                /*else if($linha -> es_status == 14){
                                        echo anchor('Candidaturas/Dossie/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-file-alt"></i>', " class=\"btn btn-sm btn-square btn-primary\" title=\"Dossiê\"");
                                }
                                else if($linha -> es_status == 16){
                                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar candidato\" onclick=\"confirm_aprovacao_final(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i></a>";
                                }*/
        						else if(($linha -> es_status == 20 || $linha -> es_status == 7) && $dt_fim < $atual){
        								if($this -> session -> perfil == 'sugesp' || $this -> session -> perfil == 'orgaos' || $this -> session -> perfil == 'administrador' || $this -> session -> perfil == 'avaliador'){
        										echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-file-alt"></i>Habilitar e Analisar Currículo', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");

        										/*if($linha -> es_status == 20 && $this -> session -> perfil != 'avaliador'){
        												echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprovação por habilitação\" onclick=\"confirm_reprovacao_habilitacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i>Confirmar reprovação por habilitação</a>";
        										}*/
        								}
        						}
                        }
                        /*if($linha -> es_status != 19 && $linha -> es_status != 20 && $linha -> es_status != 7){
                                echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Eliminar candidatura por revisão de requisitos\" onclick=\"confirm_reprovacao_requisitos(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                        }*/

                        //echo anchor('Candidaturas/RevisaoRequisitos/'.$linha -> pr_candidatura, '<i class="fa fa-lg mr-0 fa-calendar-check"></i>', " class=\"btn btn-sm btn-square btn-warning\" title=\"Revisão de requisitos\"");



                        echo "
                                                                                            </td>
                                                                                    </tr>";

                }

        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            ";
        if($paginacao > 0){
                echo "
                                                                <div class=\"row\">
                                                                        <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                <div class=\"dataTables_info\" id=\"vagas_table_info\" role=\"status\" aria-live=\"polite\">Mostrando de ".((($paginacao-1)*30)+1)." até ";
                if(($paginacao*30) > $total2){
                        echo $total2;
                }
                else{
                        echo ($paginacao*30);
                }
                echo " de {$total2} itens</div>
                                                                        </div>
                                                                        <div class=\"col-xs-12 col-sm-12 col-md-5\">
                                                                                <div class=\"dataTables_paginate paging_simple_numbers\" id=\"vagas_table_paginate\">
                                                                                        <ul class=\"pagination\">";
                $extra='';

                if($paginacao > 1){
                        echo "
                                                                                                <li class=\"paginate_button page-item previous\" id=\"vagas_table_previous\">
                                                                                                        <a onclick=\"ahref_lista(".($paginacao-1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                                </li>";
                }
                else{
                        echo "
                                                                                                <li class=\"paginate_button page-item previous disabled\" id=\"vagas_table_previous\">
                                                                                                        <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"0\" tabindex=\"0\" class=\"page-link\">Anterior</a>
                                                                                                </li>";
                }
                echo "
                                                                                                <li class=\"paginate_button page-item ";
                if($paginacao == 1){
                        echo 'active';
                }
                echo "\">
                                                                                                        <a onclick=\"ahref_lista(1);\" aria-controls=\"vagas_table\" data-dt-idx=\"1\" tabindex=\"0\" class=\"page-link\">1</a>
                                                                                                </li>";
                if($paginacao > 3){
                        echo "
                                                                                                <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                        <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                                </li>";
                }
                if($paginacao <= 2){
                        $inicio = 2;
                        $termino = 5;
                }
                else{
                        $inicio = $paginacao-1;
                        $termino = $paginacao+4;
                }
                for($i = $inicio; $i <= $total_paginas && $i <= $termino; $i++){
                        echo "
                                                                                                <li class=\"paginate_button page-item ";
                        if($paginacao == $i){
                                echo 'active';
                        }
                        echo "\">
                                                                                                        <a onclick=\"ahref_lista(".$i.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$i\" tabindex=\"0\" class=\"page-link\">$i</a>
                                                                                                </li>";
                }
                if($paginacao < ($total_paginas - 5)){
                        echo "
                                                                                                <li class=\"paginate_button page-item disabled\" id=\"vagas_table_ellipsis\">
                                                                                                        <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"6\" tabindex=\"0\" class=\"page-link\">…</a>
                                                                                                </li>";
                }
                if($paginacao < ($total_paginas - 4)){
                        echo "
                                                                                                <li class=\"paginate_button page-item \">
                                                                                                        <a onclick=\"ahref_lista(".$total_paginas.");\" aria-controls=\"vagas_table\" data-dt-idx=\"$total_paginas\" tabindex=\"0\" class=\"page-link\">$total_paginas</a>
                                                                                                </li>";
                }
                if($paginacao < $total_paginas){
                        echo "
                                                                                                <li class=\"paginate_button page-item next\" id=\"vagas_table_next\">
                                                                                                        <a onclick=\"ahref_lista(".($paginacao+1).");\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                                </li>";
                }
                else{
                        echo "
                                                                                                <li class=\"paginate_button page-item next disabled\" id=\"vagas_table_next\">
                                                                                                        <a href=\"#\" aria-controls=\"vagas_table\" data-dt-idx=\"8\" tabindex=\"0\" class=\"page-link\">Próxima</a>
                                                                                                </li>";
                }
                echo "
                                                                                        </ul>
                                                                                </div>
                                                                        </div>
                                                                </div>";
}
echo "
                                                        </div>
                                                </div>";

        $pagina['js'] .= "
                                            <script type=\"text/javascript\">";

        $pagina['js'] .= "
                                                    function ahref_lista(pagina){
                                                            document.getElementById('form_filtros').action='".base_url('Vagas/resultado/'.$vaga."/")."'+pagina;
                                                            document.getElementById('form_filtros').submit();
                                                    }
                                                    function botao_submit(){
                                                        ahref_lista(1);
                                                    }
                                                    function confirm_reprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação dos candidatos não agendados para entrevista?',
                                                                        text: 'Todo o restante de candidatos será reprovado.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_restantes/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_reprovacao2(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a conclusão desse processo? Não será possível realizar qualquer ação sobre as candidaturas após a confirmação.',
                                                                        text: 'O processo vai ser concluído.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, finalize'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_restantes2/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_reprovacao_requisitos(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação desse candidato por revisão de requisitos',
                                                                        text: 'Esse candidato será eliminado por revisão por requisitos.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_revisao_requisitos/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_reprovacao_entrevista(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a reprovação desse candidato por não preenchimento do teste de aderência',
                                                                        text: 'Esse candidato será eliminado pelo não preenchimento do teste de aderência.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, reprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_entrevista/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

						    function confirm_reprovacao_habilitacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma que esse candidato perdeu o recurso e será reprovado definitivamente',
                                                                        text: 'Esse candidato será eliminado no teste de habilitação em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, confirma'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_habilitacao/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                                    function confirm_aprovacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação para aguardando decisão final',
                                                                        text: 'Esse candidato terá o status alterado para aguardando decisão final, se não tiver entrevista com especialista.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/aguardar_decisao_final/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    function confirm_aprovacao_final(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma a aprovação final desse candidato',
                                                                        text: 'Esse candidato será aprovado no processo seletivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, aprove'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/aprovar_final/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }

                                            </script>
                                            ";

}
else if($menu2 == 'resultado2'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            ";
        foreach($competencias as $competencia){
                echo "
                                                                                            <th>{$competencia}</th>
                ";
        }
        echo "

                                                                                            <th>Nota total</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        $chaves = array_keys($competencias);
        if(isset($candidaturas)){
                foreach ($candidaturas as $linha){

                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome.'</td>';



                        echo "
                                                                                            <td class=\"text-center\">-</td>";

                        $total = 0;
                        $divisor = 0;
                        foreach($chaves as $chave){
                                if(isset($notas[$linha->pr_candidatura][$chave])){
                                        $total += $notas[$linha->pr_candidatura][$chave];
                                        ++$divisor;
                                }
                                else{
                                        $notas[$linha->pr_candidatura][$chave] = 0;
                                }
                                echo "
                                                                                            <td class=\"text-center\">{$notas[$linha->pr_candidatura][$chave]}</td>";
                        }
                        if($divisor == 0){
                                $divisor = 1;
                        }
                        $total = $total/$divisor;
                        echo "
                                                                                            <td class=\"text-center\">
                                                                                                    {$total}
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "

                                            <script type=\"text/javascript\">
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [2, 'desc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";
}
else if($menu2 == 'resultado3'){
        echo "
                                                            <div class=\"dt-responsive table-responsive\">
                                                                    <table class=\"table table-striped table-bordered table-hover\" id=\"vagas_table\">
                                                                            <thead>
                                                                                    <tr>
                                                                                            <th>Nome</th>
                                                                                            <th>Status</th>
                                                                                            <th>Nota - Anál. Curricular</th>
                                                                                            <th>Ações</th>
                                                                                    </tr>
                                                                            </thead>
                                                                            <tbody>";
        //var_dump($vagas);
        if(isset($candidaturas)){
                foreach ($candidaturas as $linha){
                        echo "
                                                                                    <tr>
                                                                                            <td>".$linha -> vc_nome."</td>
                                                                                            <td class=\"text-center\"><span class=\"badge badge-danger badge-lg\">".$linha -> vc_status.'</span></td>';
                        /*
                        echo "
                                                                                            <td class=\"text-center\">".$linha -> cont."</td>";
                        */
                        if(!isset($linha -> in_nota3) || !(strlen($linha -> in_nota3) > 0)){
                                $linha -> in_nota3 = 0;
                        }
                        echo "

                                                                                            <td class=\"text-center\">".$linha -> in_nota3."</td>
                                                                                            <td class=\"text-center\">";
                        echo anchor('Candidaturas/DetalheAvaliacao/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-search"></i>Detalhes', " class=\"btn btn-sm btn-square btn-primary\" title=\"Detalhes\"");
                        /*
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-success\" title=\"Aprovar para entrevista\" onclick=\"confirm_aprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-plus-circle\"></i></a>";
                        echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Reprovar currículo\" onclick=\"confirm_reprovacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i></a>";
                        */
			echo anchor('Candidaturas/AvaliacaoCurriculo/'.$linha -> pr_candidatura.'/'.$linha->es_vaga, '<i class="fa fa-lg mr-1 fa-file-alt"></i>Habilitar e Analisar Currículo', " class=\"btn btn-sm btn-square btn-primary\" title=\"Analisar Currículo\"");
                        if($this -> session -> perfil != 'avaliador'){
                               echo "<a href=\"javascript:/\" class=\"btn btn-sm btn-square btn-danger\" title=\"Confirmar reprovação por habilitação\" onclick=\"confirm_reprovacao_habilitacao(".$linha -> pr_candidatura.");\"><i class=\"fa fa-lg mr-1 fa-times-circle\"></i>Confirmar reprovação por habilitação</a>";
                        }
                        echo "
                                                                                            </td>
                                                                                    </tr>";
                }
        }
        echo "
                                                                            </tbody>
                                                                    </table>
                                                            </div>
                                                    </div>";

        $pagina['js'] = "


                                            <script type=\"text/javascript\">
													function confirm_reprovacao_habilitacao(id){
                                                            $(document).ready(function(){
                                                                    swal.fire({
                                                                        title: 'Você confirma que esse candidato perdeu o recurso e será reprovado definitivamente',
                                                                        text: 'Esse candidato será eliminado no teste de habilitação em definitivo.',
                                                                        type: 'warning',
                                                                        showCancelButton: true,
                                                                        cancelButtonText: 'Não, cancele',
                                                                        confirmButtonText: 'Sim, confirma'
                                                                    })
                                                                    .then(function(result) {
                                                                        if (result.value) {
                                                                            $(location).attr('href', '".base_url('Vagas/reprovar_habilitacao/')."' + id)
                                                                        }
                                                                    });
                                                            });
                                                    }
                                                    $('#vagas_table').DataTable({
                                                            order: [
                                                                [2, 'desc']
                                                            ],
                                                            columnDefs: [
                                                                    {
                                                                        'orderable': false,
                                                                        'targets': [-1]
                                                                    },
                                                                    {
                                                                        'searchable': false,
                                                                        'targets': [-1]
                                                                    }
                                                            ],
                                                            language: {
                                                                        \"decimal\":        \"\",
                                                                        \"emptyTable\":     \"Nenhum item encontrado\",
                                                                        \"info\":           \"Mostrando de  _START_ até _END_ de _TOTAL_ itens\",
                                                                        \"infoEmpty\":      \"Mostrando 0 até 0 de 0 itens\",
                                                                        \"infoFiltered\":   \"(filtrado de _MAX_ itens no total)\",
                                                                        \"infoPostFix\":    \"\",
                                                                        \"thousands\":      \",\",
                                                                        \"lengthMenu\":     \"Mostrar _MENU_\",
                                                                        \"loadingRecords\": \"Carregando...\",
                                                                        \"processing\":     \"Carregando...\",
                                                                        \"search\":         \"Pesquisar:\",
                                                                        \"zeroRecords\":    \"Nenhum item encontrado\",
                                                                        \"paginate\": {
                                                                            \"first\":      \"Primeira\",
                                                                            \"last\":       \"Última\",
                                                                            \"next\":       \"Próxima\",
                                                                            \"previous\":   \"Anterior\"
                                                                        },
                                                                        \"aria\": {
                                                                            \"sortAscending\":  \": clique para ordenar de forma crescente\",
                                                                            \"sortDescending\": \": clique para ordenar de forma decrescente\"
                                                                        }
                                                            }
                                                    });
                                            </script>";



}
else if($menu2 == 'AgendamentoEntrevista'){ //agendamento da entrevista
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_avaliacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo,'tipo_entrevista'=>$tipo_entrevista));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "

                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($entrevista);
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Avaliador 1 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                //var_dump($usuarios);
                //$usuarios=array(0 => '')+$usuarios;
                $dados_usuarios[0] = '';
                if(isset($usuarios)){
                        foreach($usuarios as $linha){
                                $dados_usuarios[$linha -> pr_usuario] = $linha -> vc_nome;
                        }
                }
                $avaliador1='';
                if(isset($entrevista[0] -> es_avaliador1) && strlen($entrevista[0] -> es_avaliador1)>0){
                        $avaliador1=$entrevista[0] -> es_avaliador1;
                }


                if(strlen(set_value('avaliador1')) > 0){
                        $avaliador1 = set_value('avaliador1');
                }
                if(($avaliador1 == $candidatura[0] -> es_avaliador_competencia1 && strlen($candidatura[0] -> es_avaliador_competencia1) > 0) || ($avaliador1 == $candidatura[0] -> es_avaliador_competencia2  && strlen($candidatura[0] -> es_avaliador_competencia2) > 0) || ($avaliador1 == $candidatura[0] -> es_avaliador_competencia3  && strlen($candidatura[0] -> es_avaliador_competencia3) > 0)){
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\" onchange=\"this.value = '{$avaliador1}';alert('Esse avaliador já fez a avaliação e não pode ser modificado!')\"");
                }
                else if(strstr($erro, "'Avaliador 1'")){
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\"");
                }
                echo "
                                                                                            </div>
                                                                                    </div>";
                if($candidatura[0] -> in_quant_avaliadores > 1){
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 2 <abbr title="Obrigatório">*</abbr>', 'avaliador2', $attributes);
                        echo "
                                                                                                    <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador2='';
                        if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                $avaliador2 = $entrevista[0] -> es_avaliador2;
                        }

                        if(strlen(set_value('avaliador2')) > 0){
                                $avaliador2 = set_value('avaliador2');
                        }

                        if(($avaliador2 == $candidatura[0] -> es_avaliador_competencia1  && strlen($candidatura[0] -> es_avaliador_competencia1) > 0) || ($avaliador2 == $candidatura[0] -> es_avaliador_competencia2  && strlen($candidatura[0] -> es_avaliador_competencia2) > 0) || ($avaliador2 == $candidatura[0] -> es_avaliador_competencia3  && strlen($candidatura[0] -> es_avaliador_competencia3) > 0)){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\" onchange=\"this.value = '{$avaliador2}';alert('Esse avaliador já fez a avaliação e não pode ser modificado!')\"");
                        }
                        else if(strstr($erro, "'Avaliador 2'")){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                        if($candidatura[0] -> in_quant_avaliadores > 2){
			        echo "
                                                                                        <div class=\"form-group row\">";
                                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                                echo form_label('Avaliador 3 <abbr title="Obrigatório">*</abbr>', 'avaliador3', $attributes);
                                echo "
                                                                                                        <div class=\"col-lg-3\">";
                                //var_dump($usuarios);
                                //$usuarios=array(0 => '')+$usuarios;
                                $avaliador3='';
                                if(isset($entrevista[0] -> es_avaliador3) && strlen($entrevista[0] -> es_avaliador3)>0){
                                        $avaliador3 = $entrevista[0] -> es_avaliador3;
                                }

                                if(strlen(set_value('avaliador3')) > 0){
                                        $avaliador3 = set_value('avaliador3');
                                }

                                if(($avaliador3 == $candidatura[0] -> es_avaliador_competencia1  && strlen($candidatura[0] -> es_avaliador_competencia1) > 0) || ($avaliador3 == $candidatura[0] -> es_avaliador_competencia2  && strlen($candidatura[0] -> es_avaliador_competencia2) > 0) || ($avaliador3 == $candidatura[0] -> es_avaliador_competencia3  && strlen($candidatura[0] -> es_avaliador_competencia3) > 0)){
                                        echo form_dropdown('avaliador3', $dados_usuarios, $avaliador3, "class=\"form-control\" onchange=\"this.value = '{$avaliador3}';alert('Esse avaliador já fez a avaliação e não pode ser modificado!')\"");
                                }
                                else if(strstr($erro, "'Avaliador 3'")){
                                        echo form_dropdown('avaliador3', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                                }
                                else{
                                        echo form_dropdown('avaliador3', $dados_usuarios, $avaliador3, "class=\"form-control\"");
                                }
                                echo "
                                                                                            </div>
                                                                                    </div>";
                        }
                }
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Horário da entrevista <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $data_entrevista = '';
                if(isset($entrevista[0] -> dt_entrevista) && strlen($entrevista[0] -> dt_entrevista)>0){
                        $data_entrevista = $entrevista[0] -> dt_entrevista;
                }

                if(strlen(set_value('data')) > 0){
                        $data_entrevista = show_sql_date(set_value('data'), true);
                }
                $attributes = array('name' => 'data',
                                    'id' => 'data',
                                    'class' => 'form-control');
                if(strstr($erro, "'Horário da entrevista'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, show_date($data_entrevista, true));
                echo "
                                                                                            </div>
                                                                                    </div>";

				echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Link para a entrevista <abbr title="Obrigatório">*</abbr>', 'link', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $link = '';
                if(isset($entrevista[0] -> vc_link) && strlen($entrevista[0] -> vc_link)>0){
                        $link = $entrevista[0] -> vc_link;
                }

                if(strlen(set_value('link')) > 0){
                        $link = set_value('link');
                }
                $attributes = array('name' => 'link',
                                    'id' => 'link',
									'type' => 'text',
									'maxlength' => '200',
                                    'class' => 'form-control');
                if(strstr($erro, "'Horário da entrevista'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, $link);
                echo "
                                                                                            </div>
                                                                                    </div>";

                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div>
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$candidatura[0] -> es_vaga)."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
                <script type=\"text/javascript\">
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });
                </script>";
        }

        echo "
                                                    </div>
                                            </div>";
}
else if($menu2 == 'AgendamentoEntrevista2'){ //alteração emergencial do entrevistador
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_avaliacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "

                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($entrevista);
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Avaliador 1 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                //var_dump($usuarios);
                //$usuarios=array(0 => '')+$usuarios;
                $dados_usuarios[0] = '';
                foreach($usuarios as $linha){
                        $dados_usuarios[$linha -> pr_usuario] = $linha -> vc_nome;
                }
                $avaliador1='';
                if(isset($entrevista[0] -> es_avaliador1) && strlen($entrevista[0] -> es_avaliador1)>0){
                        $avaliador1=$entrevista[0] -> es_avaliador1;
                }


                if(strlen(set_value('avaliador1')) > 0){
                        $avaliador1 = set_value('avaliador1');
                }

                // onchange=\"this.value = '{$es_instituicao}';alert('Não pode modificar o grupo de vaga de uma vaga já liberada para inscrições!')\"
                if($avaliador1 == $candidatura[0] -> es_avaliador_competencia1 || $avaliador1 == $candidatura[0] -> es_avaliador_competencia2 || $avaliador1 == $candidatura[0] -> es_avaliador_competencia3){
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\" onchange=\"this.value = '{$avaliador1}';alert('Esse avaliador já fez a avaliação e não pode ser modificado!')\"");
                }
                else if(strstr($erro, "'Avaliador 1'")){
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\"");
                }
                echo "
                                                                                            </div>
                                                                                    </div>";
                if($candidatura[0] -> in_quant_avaliadores > 1){
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 2 <abbr title="Obrigatório">*</abbr>', 'avaliador2', $attributes);
                        echo "
                                                                                                    <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador2='';
                        if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                $avaliador2 = $entrevista[0] -> es_avaliador2;
                        }

                        if(strlen(set_value('avaliador2')) > 0){
                                $avaliador2 = set_value('avaliador2');
                        }
                        if($avaliador2 == $candidatura[0] -> es_avaliador_competencia1 || $avaliador2 == $candidatura[0] -> es_avaliador_competencia2 || $avaliador2 == $candidatura[0] -> es_avaliador_competencia3){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\" onchange=\"this.value = '{$avaliador2}';alert('Esse avaliador já fez a avaliação e não pode ser modificado!')\"");
                        }
                        else if(strstr($erro, "'Avaliador 2'")){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                        if($candidatura[0] -> in_quant_avaliadores > 2){
			        echo "
                                                                                    <div class=\"form-group row\">";
                                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                                echo form_label('Avaliador 3 <abbr title="Obrigatório">*</abbr>', 'avaliador3', $attributes);
                                echo "
                                                                                                    <div class=\"col-lg-3\">";
                                //var_dump($usuarios);
                                //$usuarios=array(0 => '')+$usuarios;
                                $avaliador3='';
                                if(isset($entrevista[0] -> es_avaliador3) && strlen($entrevista[0] -> es_avaliador3)>0){
                                        $avaliador3 = $entrevista[0] -> es_avaliador3;
                                }

                                if(strlen(set_value('avaliador3')) > 0){
                                        $avaliador3 = set_value('avaliador3');
                                }
                                if($avaliador3 == $candidatura[0] -> es_avaliador_competencia1 || $avaliador3 == $candidatura[0] -> es_avaliador_competencia2 || $avaliador3 == $candidatura[0] -> es_avaliador_competencia3){
                                        echo form_dropdown('avaliador3', $dados_usuarios, $avaliador3, "class=\"form-control\" onchange=\"this.value = '{$avaliador3}';alert('Esse avaliador já fez a avaliação e não pode ser modificado!')\"");
                                }
                                else if(strstr($erro, "'Avaliador 3'")){
                                        echo form_dropdown('avaliador3', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                                }
                                else{
                                        echo form_dropdown('avaliador3', $dados_usuarios, $avaliador3, "class=\"form-control\"");
                                }
                                echo "
                                                                                            </div>
                                                                                    </div>";
                        }
                }

                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Justificativa <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $attributes = array('name' => 'justificativa',
                                        'rows'=>'3',
                                        'class' => 'form-control');
                if(strstr($erro, "'Justificativa'")){
                        $attributes['class'] = 'form-control is-invalid';
                }

                echo form_textarea($attributes, set_value('justificativa'));
                echo "
                                                                                            </div>
                                                                                    </div>";

                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div>
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_entrevista', 'Salvar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$candidatura[0] -> es_vaga)."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                $pagina['js']="
                <script type=\"text/javascript\">
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });
                </script>";
        }

        echo "
                                                    </div>
                                            </div>";
}
else if($menu2 == 'JustificarNaoComparecimento'){ //agendamento da entrevista
        if(strlen($erro)>0){
                echo "
                                                                    <div class=\"alert alert-danger background-danger\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-exclamation-triangle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    <strong>ERRO</strong>:<br /> $erro
                                                                            </div>
                                                                    </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                                    <div class=\"alert alert-success background-success\" role=\"alert\">
                                                                            <div class=\"alert-icon\">
                                                                                    <i class=\"fa fa-check-circle\"></i>
                                                                            </div>
                                                                            <div class=\"alert-text\">
                                                                                    $sucesso
                                                                            </div>
                                                                    </div>";
        }
        if(strlen($sucesso) == 0){
                $attributes = array('class' => 'kt-form',
                                    'id' => 'form_avaliacoes');
                echo form_open($url, $attributes, array('codigo' => $codigo));
                echo "
                                                                            <div class=\"kt-portlet__body\">";
                echo form_fieldset('Dados da candidatura');
                echo "
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Candidato(a):', 'NomeCompleto', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_nome;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('E-mail:', 'Email', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidato -> vc_email;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Telefone(s):', 'Telefones', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidato -> vc_telefone;
                if(strlen($candidato -> vc_telefoneOpcional) > 0){
                        echo ' - '.$candidato -> vc_telefoneOpcional;
                }
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Vaga:', 'Vaga', $attributes);
                echo "
                                                                                            <div class=\"col-lg-9\">";
                echo $candidatura[0] -> vc_vaga;
                echo "

                                                                                            </div>
                                                                                    </div>
                                                                                    <div class=\"row\">";
                $attributes = array('class' => 'col-lg-3 direito bolder');
                echo form_label('Status da candidatura:', 'status', $attributes);
                echo "
                                                                                            <div class=\"col-lg-6\">";
                echo $candidatura[0] -> vc_status;
                echo "

                                                                                            </div>
                                                                                    </div>";
                echo form_fieldset_close();
                /*echo "
                                                                                    <div class=\"kt-separator kt-separator--border-dashed kt-separator--space-lg\"></div>";
                echo form_fieldset('Entrevista');
                //var_dump($entrevista);
                echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Avaliador 1 <abbr title="Obrigatório">*</abbr>', 'avaliador1', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                //var_dump($usuarios);
                //$usuarios=array(0 => '')+$usuarios;
                $dados_usuarios[0] = '';
                foreach($usuarios as $linha){
                        $dados_usuarios[$linha -> pr_usuario] = $linha -> vc_nome;
                }
                $avaliador1='';
                if(isset($entrevista[0] -> es_avaliador1) && strlen($entrevista[0] -> es_avaliador1)>0){
                        $avaliador1=$entrevista[0] -> es_avaliador1;
                }


                if(strlen(set_value('avaliador1')) > 0){
                        $avaliador1 = set_value('avaliador1');
                }
                if(strstr($erro, "'Avaliador 1'")){
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control is-invalid\"");
                }
                else{
                        echo form_dropdown('avaliador1', $dados_usuarios, $avaliador1, "class=\"form-control\"");
                }
                echo "
                                                                                            </div>
                                                                                    </div>";
                if($tipo_entrevista == 'competencia'){
                        echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 2 <abbr title="Obrigatório">*</abbr>', 'avaliador2', $attributes);
                        echo "
                                                                                                    <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador2='';
                        if(isset($entrevista[0] -> es_avaliador2) && strlen($entrevista[0] -> es_avaliador2)>0){
                                $avaliador2 = $entrevista[0] -> es_avaliador2;
                        }

                        if(strlen(set_value('avaliador2')) > 0){
                                $avaliador2 = set_value('avaliador2');
                        }
                        if(strstr($erro, "'Avaliador 2'")){
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador2', $dados_usuarios, $avaliador2, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
						echo "
                                                                                    <div class=\"form-group row\">";
                        $attributes = array('class' => 'col-lg-3 col-form-label direito');
                        echo form_label('Avaliador 3 <abbr title="Obrigatório">*</abbr>', 'avaliador3', $attributes);
                        echo "
                                                                                                    <div class=\"col-lg-3\">";
                        //var_dump($usuarios);
                        //$usuarios=array(0 => '')+$usuarios;
                        $avaliador3='';
                        if(isset($entrevista[0] -> es_avaliador3) && strlen($entrevista[0] -> es_avaliador3)>0){
                                $avaliador3 = $entrevista[0] -> es_avaliador3;
                        }

                        if(strlen(set_value('avaliador3')) > 0){
                                $avaliador3 = set_value('avaliador3');
                        }
                        if(strstr($erro, "'Avaliador 3'")){
                                echo form_dropdown('avaliador3', $dados_usuarios, $avaliador2, "class=\"form-control is-invalid\"");
                        }
                        else{
                                echo form_dropdown('avaliador3', $dados_usuarios, $avaliador3, "class=\"form-control\"");
                        }
                        echo "
                                                                                            </div>
                                                                                    </div>";
                }*/
                /*echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Horário da entrevista <abbr title="Obrigatório">*</abbr>', 'data', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $data_entrevista = '';


                if(strlen(set_value('data')) > 0){
                        $data_entrevista = show_sql_date(set_value('data'), true);
                }
                $attributes = array('name' => 'data',
                                    'id' => 'data',
                                    'class' => 'form-control');
                if(strstr($erro, "'Horário da entrevista'")){
                        $attributes['class'] = 'form-control is-invalid';
                }
                echo form_input($attributes, show_date($data_entrevista, true));
                echo "
                                                                                            </div>
                                                                                    </div>";*/
                echo form_fieldset('Insira a justificativa e clique em \'Salvar e eliminar\' para eliminar pelo não comparecimento');

		echo "
                                                                                    <div class=\"form-group row\">";
                $attributes = array('class' => 'col-lg-3 col-form-label direito');
                echo form_label('Justificativa da eliminação <abbr title="Obrigatório">*</abbr>', 'link', $attributes);
                echo "
                                                                                            <div class=\"col-lg-3\">";
                $justificativa = '';
                if(strlen(set_value('justificativa')) > 0){
                        $justificativa = set_value('justificativa');
                }
                $attributes = array('name' => 'justificativa',
                                        'rows'=>'3',
                                        'class' => 'form-control');
                if(strstr($erro, "'Justificativa'")){
                        $attributes['class'] = 'form-control is-invalid';
                }

                echo form_textarea($attributes, $justificativa);

                echo "
                                                                                            </div>
                                                                                    </div>";

                echo form_fieldset_close();
                echo "
                                                                            </div>
                                                                            <div class=\"j-footer\"><hr>
                                                                                    <div>
                                                                                            <div class=\"row\">
                                                                                                    <div class=\"col-lg-12 text-center\">";
                $attributes = array('class' => 'btn btn-primary');
                echo form_submit('salvar_entrevista', 'Salvar e eliminar', $attributes);
                echo "
                                                                                                            <button type=\"button\" class=\"btn btn-default\" onclick=\"window.location='".base_url('Vagas/resultado/'.$candidatura[0] -> es_vaga)."'\">Cancelar</button>
                                                                                                    </div>
                                                                                            </div>
                                                                                    </div>
                                                                            </div>
                                                                    </form>";
                /*$pagina['js']="
                <script type=\"text/javascript\">
                    $('#data').datetimepicker({
                        language: 'pt-BR',
                        autoclose: true,
                        format: 'dd/mm/yyyy hh:ii'
                    });
                </script>";*/
        }

        echo "
                                                    </div>
                                            </div>";
}
else{
        if(strlen($erro)>0){
                echo "
                                                            <div class=\"alert alert-danger background-danger background-danger\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            <strong>ERRO</strong>:<br /> $erro
                                                                    </div>
                                                            </div>";
        //$erro='';
        }
        else if(strlen($sucesso) > 0){
                echo "
                                                            <div class=\"alert alert-success background-success background-success\" role=\"alert\">
                                                                    <div class=\"alert-text\">
                                                                            $sucesso
                                                                    </div>
                                                            </div>";
        }
}
echo "
                                                            </div>
                                                    </div>";
$this -> load -> view('internaRodape', $pagina);
?>