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

$pdf = new pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Dossiê '.$this -> config -> item('nome').' de \''.$candidato -> vc_nome.'\' para a vaga \''.$candidatura[0] -> vc_vaga.'\'');
//$pdf->setPageOrientation('P', false, 40);
//$pdf->SetAutoPageBreak(true, 100);
$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Processos Seletivos MG - SUGESP/SEPLAG MG');
$pdf->SetDisplayMode('real', 'default');

$pdf->AddPage();

$pdf->Image('./images/capa.jpg', 0, 0, 230, 300, 'JPG', '', false);
$pdf->Image('./images/logomg.jpg', 0, 260, 230, 35, 'JPG', '', false);

$pdf->setY(230);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 8, $candidatura[0] -> vc_vaga, 0, 1, 'R', 0);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 8, $candidatura[0] -> vc_instituicao, 0, 1, 'R', 0);

///////////////////////////////////////////////////

$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 20);

$pdf->SetMargins(15, 10, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, 'ÍNDICE', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '1.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Informações Básicas e Currículo', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '2.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Resultado da Análise Curricular', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '3.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Resultado da Entrevista por Competências', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '4.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Motivação e Momento de Carreira', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '5.', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'Análise de Antecedentes', 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(5, 6, '', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, 'ANEXO - CURRÍCULO', 0, 0, 'L', 0);
$pdf->Ln(6);

///////////////////////////////////////////////////

$pdf->AddPage();

$pdf->SetMargins(15, 10, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, '1.  Informações básicas', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'Nome do(a) Candidato(a):', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'CPF:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> ch_cpf, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'Município de Residência:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> vc_municipio.' / '.$candidato -> ch_sigla, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'E-mail:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 6, $candidato -> vc_email, 0, 0, 'L', 0);
$pdf->Ln(6);

$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(50, 6, 'Telefone:', 0, 0, 'L', 0);
$pdf->SetFont('helvetica', '', 10);
$telefones=$candidato -> vc_telefone;
if(strlen($candidato -> vc_telefoneOpcional)>0){
        $telefones.=' - '.$candidato -> vc_telefoneOpcional;
}
$pdf->Cell(0, 6, $telefones, 0, 0, 'L', 0);
$pdf->Ln(6);

///////////////////////////////////////////////////

$pdf->AddPage();
$pdf->SetMargins(15, 30, 15);

$pdf->setY(15);
$pdf->setX(100);
$pdf->SetTextColor(28, 150, 140);
$pdf->SetFont('helvetica', '', 11);
$pdf->Cell(25, 6, 'Candidato(a): ', 0, 0, 'L', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 6, $candidato -> vc_nome, 0, 0, 'L', 0);

$pdf->setY(40);
$pdf->setX(20);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, '2.  Resultado da Análise Curricular', 0, 0, 'L', 0);
$pdf->Ln(10);

$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Pré Requisitos', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
foreach($questoes1 as $linha){
        $res = "";
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);

        foreach ($respostas as $linha2){
                if($linha2 -> es_questao == $linha -> pr_questao){
                        $res = $linha2 -> tx_resposta;
                }
        }

        if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($linha -> vc_respostaAceita, 'Sim,')){

                if($res == '1'){
                        $res = 'Sim';
                }
                else if($res == '0'){
                        $res = 'Não';
                }

        }
        else if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
               $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
               $res = $valores[$res];
        }
        /*else if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){

        }
        else if($linha -> vc_respostaAceita == NULL || $linha -> in_tipo == 2){

        }*/


        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);
}

$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Requisitos desejáveis', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
foreach($questoes2 as $linha){
        $res = "";
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);

        foreach ($respostas as $linha2){
                if($linha2 -> es_questao == $linha -> pr_questao){
                        $res = $linha2 -> tx_resposta;
                }
        }

        if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($linha -> vc_respostaAceita, 'Sim,')){

                if($res == '1'){
                        $res = 'Sim';
                }
                else if($res == '0'){
                        $res = 'Não';
                }

        }
        else if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
               $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
               $res = $valores[$res];
        }


        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);
}
//**************************************
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Currículo', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
if(isset($formacoes)){
        $i=0;
        foreach($formacoes as $formacao){
                ++$i;
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Formação acadêmica {$i}", 0, 'L', 0);

                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Tipo", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                if($formacao->en_tipo == 'bacharelado'){
                        $res = 'Graduação - Bacharelado';
                }
                else if($formacao->en_tipo == 'tecnologo'){
                        $res = 'Graduação - Tecnológo';
                }
                else if($formacao->en_tipo == 'especializacao'){
                        $res = 'Pós-graduação - Especialização';
                }
                else if($formacao->en_tipo == 'mba'){
                        $res = 'MBA';
                }
                else if($formacao->en_tipo == 'mestrado'){
                        $res = 'Mestrado';
                }
                else if($formacao->en_tipo == 'doutorado'){
                        $res = 'Doutorado';
                }
                else if($formacao->en_tipo == 'posdoc'){
                        $res = 'Pós-doutorado';
                }

                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);


                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Nome do curso", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = $formacao->vc_curso;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);


                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Instituição de ensino", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = $formacao->vc_instituicao;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);


                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Ano de conclusão", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = $formacao->ye_conclusao;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);

                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Diploma / certificado", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = "";
                if($anexos && is_array($anexos[$formacao->pr_formacao])){
                        foreach($anexos[$formacao->pr_formacao] as $anexo){
                                $res = $anexo->vc_arquivo;
                        }
                }
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);
        }
}
//**************************************
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Experiência', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
if(isset($experiencias)){
        $i=0;
        foreach($experiencias as $experiencia){
                ++$i;
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Experiência profissional {$i}", 0, 'L', 0);

                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Instituição / empresa", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);

                $res = $experiencia->vc_empresa;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);

                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Ano de início", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = $experiencia->ye_inicio;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);

                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Ano de término", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = $experiencia->ye_fim;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);

                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->MultiCell(0, 6, "Principais atividades desenvolvidas", 0, 'L', 0);
                $pdf->SetFont('helvetica', '', 10);
                $res = $experiencia->tx_atividades;
                $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
                $pdf->Ln(10);

                $pdf->Ln(10);
        }
}
//**************************************
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(28, 150, 140);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 8, 'Avaliação do(a) candidato(a)', 0, 0, 'L', 1);
$pdf->Ln(6);
$pdf->Ln(6);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(240, 240, 240);
foreach($questoes3 as $linha){
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->MultiCell(0, 6, strip_tags($linha -> tx_questao), 0, 'L', 0);
        $pdf->SetFont('helvetica', '', 10);
        $res = "";
        foreach ($respostas as $linha2){
                if($linha2 -> es_questao == $linha -> pr_questao){
                        $res = $linha2 -> tx_resposta;
                }
        }

        if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'sim' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'não' || strstr($linha -> vc_respostaAceita, 'Sim,')){
                if($res == '1'){
                        $res = 'Sim';
                }
                else if($res == '0'){
                        $res = 'Não';
                }
        }

        else if(mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'básico' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'intermediário' || mb_convert_case($linha -> vc_respostaAceita, MB_CASE_LOWER, "UTF-8") == 'avançado'){
               $valores=array(0=>"Nenhum",1=>"Básico",2=>"Intermediário",3=>"Avançado");
               $res = $valores[$res];
        }
        $pdf->Cell(0, 6, $res, 0, 0, 'L', 0);
        $pdf->Ln(10);
}
//$pdf->Write(5, 'Some sample text');
$pdf->Output('dossie'.$candidatura[0] -> pr_candidatura.'.pdf', 'i');

?>