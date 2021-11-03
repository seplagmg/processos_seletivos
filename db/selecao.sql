--
-- Banco de dados: `selecao`
--

DELIMITER $$
--
-- Funções
--
DROP FUNCTION IF EXISTS `remove_accents`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `remove_accents` (`str` TEXT) RETURNS TEXT CHARSET utf8 NO SQL
    DETERMINISTIC
    SQL SECURITY INVOKER
BEGIN



    SET str = REPLACE(str,'Š','S');

    SET str = REPLACE(str,'š','s');

    SET str = REPLACE(str,'Ð','Dj');

    SET str = REPLACE(str,'Ž','Z');

    SET str = REPLACE(str,'ž','z');

    SET str = REPLACE(str,'À','A');

    SET str = REPLACE(str,'Á','A');

    SET str = REPLACE(str,'Â','A');

    SET str = REPLACE(str,'Ã','A');

    SET str = REPLACE(str,'Ä','A');

    SET str = REPLACE(str,'Å','A');

    SET str = REPLACE(str,'Æ','A');

    SET str = REPLACE(str,'Ç','C');

    SET str = REPLACE(str,'È','E');

    SET str = REPLACE(str,'É','E');

    SET str = REPLACE(str,'Ê','E');

    SET str = REPLACE(str,'Ë','E');

    SET str = REPLACE(str,'Ì','I');

    SET str = REPLACE(str,'Í','I');

    SET str = REPLACE(str,'Î','I');

    SET str = REPLACE(str,'Ï','I');

    SET str = REPLACE(str,'Ñ','N');

    SET str = REPLACE(str,'Ò','O');

    SET str = REPLACE(str,'Ó','O');

    SET str = REPLACE(str,'Ô','O');

    SET str = REPLACE(str,'Õ','O');

    SET str = REPLACE(str,'Ö','O');

    SET str = REPLACE(str,'Ø','O');

    SET str = REPLACE(str,'Ù','U');

    SET str = REPLACE(str,'Ú','U');

    SET str = REPLACE(str,'Û','U');

    SET str = REPLACE(str,'Ü','U');

    SET str = REPLACE(str,'Ý','Y');

    SET str = REPLACE(str,'Þ','B');

    SET str = REPLACE(str,'ß','Ss');

    SET str = REPLACE(str,'à','a');

    SET str = REPLACE(str,'á','a');

    SET str = REPLACE(str,'â','a');

    SET str = REPLACE(str,'ã','a');

    SET str = REPLACE(str,'ä','a');

    SET str = REPLACE(str,'å','a');

    SET str = REPLACE(str,'æ','a');

    SET str = REPLACE(str,'ç','c');

    SET str = REPLACE(str,'è','e');

    SET str = REPLACE(str,'é','e');

    SET str = REPLACE(str,'ê','e');

    SET str = REPLACE(str,'ë','e');

    SET str = REPLACE(str,'ì','i');

    SET str = REPLACE(str,'í','i');

    SET str = REPLACE(str,'î','i');

    SET str = REPLACE(str,'ï','i');

    SET str = REPLACE(str,'ð','o');

    SET str = REPLACE(str,'ñ','n');

    SET str = REPLACE(str,'ò','o');

    SET str = REPLACE(str,'ó','o');

    SET str = REPLACE(str,'ô','o');

    SET str = REPLACE(str,'õ','o');

    SET str = REPLACE(str,'ö','o');

    SET str = REPLACE(str,'ø','o');

    SET str = REPLACE(str,'ù','u');

    SET str = REPLACE(str,'ú','u');

    SET str = REPLACE(str,'û','u');

    SET str = REPLACE(str,'ý','y');

    SET str = REPLACE(str,'ý','y');

    SET str = REPLACE(str,'þ','b');

    SET str = REPLACE(str,'ÿ','y');

    SET str = REPLACE(str,'ƒ','f');





    RETURN str;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_experiencias_candidaturas`
--

DROP TABLE IF EXISTS `rl_experiencias_candidaturas`;
CREATE TABLE IF NOT EXISTS `rl_experiencias_candidaturas` (
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_experiencia` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_candidatura`,`es_experiencia`),
  KEY `es_experiencia` (`es_experiencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_formacoes_candidaturas`
--

DROP TABLE IF EXISTS `rl_formacoes_candidaturas`;
CREATE TABLE IF NOT EXISTS `rl_formacoes_candidaturas` (
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_formacao` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_candidatura`,`es_formacao`),
  KEY `es_formacao` (`es_formacao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_gruposvagas_questoes`
--

DROP TABLE IF EXISTS `rl_gruposvagas_questoes`;
CREATE TABLE IF NOT EXISTS `rl_gruposvagas_questoes` (
  `es_grupovaga` int(10) UNSIGNED NOT NULL,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `in_ordem` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_grupovaga`,`es_questao`),
  KEY `es_questao` (`es_questao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_instituicoes_usuarios`
--

DROP TABLE IF EXISTS `rl_instituicoes_usuarios`;
CREATE TABLE IF NOT EXISTS `rl_instituicoes_usuarios` (
  `es_instituicao` int(10) UNSIGNED NOT NULL,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`es_instituicao`,`es_usuario`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_questoes_vagas`
--

DROP TABLE IF EXISTS `rl_questoes_vagas`;
CREATE TABLE IF NOT EXISTS `rl_questoes_vagas` (
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `in_ordem` tinyint(3) UNSIGNED DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`es_vaga`,`es_questao`),
  KEY `es_questao` (`es_questao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rl_vagas_avaliadores`
--

DROP TABLE IF EXISTS `rl_vagas_avaliadores`;
CREATE TABLE IF NOT EXISTS `rl_vagas_avaliadores` (
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`es_vaga`,`es_usuario`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_anexos`
--

DROP TABLE IF EXISTS `tb_anexos`;
CREATE TABLE IF NOT EXISTS `tb_anexos` (
  `pr_anexo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED DEFAULT NULL,
  `es_questao` int(10) UNSIGNED DEFAULT NULL,
  `es_formacao` int(10) UNSIGNED DEFAULT NULL,
  `es_experiencia` int(10) UNSIGNED DEFAULT NULL,
  `in_tipo` tinyint(3) UNSIGNED NOT NULL,
  `vc_mime` varchar(255) COLLATE utf8_bin NOT NULL,
  `vc_arquivo` varchar(255) COLLATE utf8_bin NOT NULL,
  `bi_conteudo` mediumblob,
  `in_tamanho` int(10) UNSIGNED NOT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_anexo`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`,`es_questao`) USING BTREE,
  UNIQUE KEY `es_experiencia` (`es_experiencia`) USING BTREE,
  UNIQUE KEY `es_formacao` (`es_formacao`) USING BTREE,
  KEY `IDCandidatura` (`es_candidatura`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`),
  KEY `es_questao` (`es_questao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_candidatos`
--

DROP TABLE IF EXISTS `tb_candidatos`;
CREATE TABLE IF NOT EXISTS `tb_candidatos` (
  `pr_candidato` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_nome` varchar(250) COLLATE utf8_bin NOT NULL,
  `ch_cpf` char(14) COLLATE utf8_bin NOT NULL,
  `vc_rg` varchar(15) COLLATE utf8_bin NOT NULL,
  `in_genero` int(10) UNSIGNED NOT NULL,
  `vc_generoOptativo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `in_raca` int(10) UNSIGNED DEFAULT NULL,
  `vc_orgaoEmissor` varchar(15) COLLATE utf8_bin NOT NULL,
  `vc_email` varchar(250) COLLATE utf8_bin NOT NULL,
  `vc_telefone` varchar(15) COLLATE utf8_bin NOT NULL,
  `vc_telefoneOpcional` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `vc_linkedin` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `dt_nascimento` date DEFAULT NULL,
  `vc_pais` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `vc_cidadeEstrangeira` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_logradouro` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_numero` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `vc_bairro` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `vc_complemento` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `vc_cep` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `es_municipio` bigint(20) DEFAULT NULL,
  `in_nivelAcademico` int(10) UNSIGNED DEFAULT NULL,
  `tx_informacoesAcademicas` mediumtext COLLATE utf8_bin,
  `tx_experienciaSetorPublico` mediumtext COLLATE utf8_bin,
  `tx_experienciasProfissionais` mediumtext COLLATE utf8_bin,
  `tx_atividadesVoluntarias` mediumtext COLLATE utf8_bin,
  `tx_referenciasProfissionais` mediumtext COLLATE utf8_bin,
  `in_exigenciasComuns` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_sentenciado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_processoDisciplinar` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_ajustamentoFuncionalPorDoenca` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_elegivel` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_politicaPrivacidade` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED DEFAULT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `bl_aceiteTermo` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_aceitePrivacidade` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_brumadinho` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`pr_candidato`),
  UNIQUE KEY `ch_cpf` (`ch_cpf`),
  KEY `IdMunicipio` (`es_municipio`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_candidaturas`
--

DROP TABLE IF EXISTS `tb_candidaturas`;
CREATE TABLE IF NOT EXISTS `tb_candidaturas` (
  `pr_candidatura` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidato` int(10) UNSIGNED NOT NULL,
  `es_vaga` int(10) UNSIGNED NOT NULL,
  `es_status` tinyint(3) UNSIGNED NOT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `dt_curriculo` datetime DEFAULT NULL,
  `dt_competencia1` datetime DEFAULT NULL,
  `dt_competencia2` datetime DEFAULT NULL,
  `dt_competencia3` datetime DEFAULT NULL,
  `dt_realizada` datetime DEFAULT NULL,
  `dt_candidatura` datetime NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `vc_urlDocumentoIdentificacao` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `vc_urlCurriculum` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `en_aderencia` enum('0','1','2') COLLATE utf8_bin DEFAULT NULL COMMENT '1->teste de aderencia obrigatório, 2-> teste de aderência feito',
  `es_avaliador_competencia1` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador_competencia2` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador_competencia3` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador_curriculo` int(10) UNSIGNED DEFAULT NULL,
  `dt_reprovacao_entrevista` datetime DEFAULT NULL,
  `tx_reprovacao_entrevista` text COLLATE utf8_bin,
  `es_reprovador` int(10) UNSIGNED DEFAULT NULL,
  `bl_revisao` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_candidatura`),
  KEY `IdCandidato` (`es_candidato`),
  KEY `IdVaga` (`es_vaga`),
  KEY `es_status` (`es_status`),
  KEY `es_avaliador_competencia1` (`es_avaliador_competencia1`),
  KEY `es_avaliador_competencia2` (`es_avaliador_competencia2`),
  KEY `es_avaliador_competencia3` (`es_avaliador_competencia3`),
  KEY `es_avaliador_curriculo` (`es_avaliador_curriculo`),
  KEY `es_reprovador` (`es_reprovador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_competencias`
--

DROP TABLE IF EXISTS `tb_competencias`;
CREATE TABLE IF NOT EXISTS `tb_competencias` (
  `pr_competencia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_competencia` varchar(200) NOT NULL,
  `tx_descrição` text NOT NULL,
  PRIMARY KEY (`pr_competencia`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_competencias`
--

INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(1, 'ORIENTAÇÃO PARA RESULTADOS', 'É a capacidade de direcionar suas ações operacionais e/ou gerenciais para a concretização dos resultados planejados e alinhados com objetivos estratégicos definidos, buscando superação e estabelecendo patamares mais desafiadores em relação a prazos, produtividade e qualidade.');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(2, 'RESILIÊNCIA DIANTE DOS DESAFIOS', 'É a capacidade de ser tolerante e flexível nas adversidades sabendo manejar o estresse, conseguindo suportá-lo sem que isso afete a sua integridade física e emocional de forma a continuar perseguindo os objetivos e resultados propostos e combinados.');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(3, 'Influência e engajamento de pessoas', 'Capacidade de vislumbrar, com entusiasmo, um futuro compartilhado que seja interessante para todos os stakeholders.  Confia em si e nas pessoas para alcançar este futuro compartilhado (de curto ou longo prazo) sendo capaz de atrair muitos colaboradores. Fortalece a capacidade das pessoas de cumprir com os combinados usando o que elas têm de melhor.');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(4, 'Liderança', 'Capacidade de mobilizar pessoas e equipes para, voluntariamente, atingirem objetivos relevantes compartilhados.');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(5, 'TOMADA DE DECISÃO', 'Capacidade de analisar criteriosamente as informações e fatos relacionados a problemas simples ou complexos e tomar decisões avaliando as opções e alternativas possíveis e seus impactos nos processos e nos envolvidos, posicionando-se e assumindo a responsabilidade pelas decisões tomadas. ');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(6, 'DESAFIO DO STATUS QUO', 'Capacidade de pensar diferente do estado dos fatos, das situações e das coisas de forma a buscar novas alternativas para  as soluções de problemas e para o alcance dos resultados estratégicos do Governo.');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(7, 'COMUNICAÇÃO', 'Capacidade de se expressar e de transmitir mensagens (ideias, opiniões, emoções e sentimentos) com clareza,  que facilmente gerem compreensão, sabendo utilizar uma variedade de linguagens. Enfatiza a importância de que a comunicação ocorra por meio da escuta e do diálogo sabendo conectar suas mensagens com as colocações de outras pessoas, buscando o entendimento mútuo. ');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(8, 'Capacidade de trabalho em equipe', '');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(9, 'Iniciativa e comportamento proativo no âmbito da atuação', '');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(10, 'Habilidade de comunicação e articulação institucional', '');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(11, 'Conhecimento e domínio do conteúdo da área de atuação', '');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(12, 'Projeto (originalidade, relevância, mérito, objetividade e coerência na argumentação)', '');
INSERT INTO `tb_competencias` (`pr_competencia`, `vc_competencia`, `tx_descrição`) VALUES(13, 'Criatividade e capacidade para resolução de problemas', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_configuracao`
--

DROP TABLE IF EXISTS `tb_configuracao`;
CREATE TABLE IF NOT EXISTS `tb_configuracao` (
  `co_conf` varchar(30) COLLATE utf8_bin NOT NULL,
  `vc_conf` varchar(255) COLLATE utf8_bin NOT NULL,
  `no_conf` varchar(100) COLLATE utf8_bin NOT NULL,
  `in_ordenacao` int(11) NOT NULL,
  `ch_tipo` char(1) COLLATE utf8_bin NOT NULL DEFAULT 'T',
  `ch_restricao` char(1) COLLATE utf8_bin DEFAULT NULL,
  `in_tamanhomaximo` int(11) NOT NULL,
  PRIMARY KEY (`co_conf`),
  KEY `in_ordenacao` (`in_ordenacao`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_editais`
--

DROP TABLE IF EXISTS `tb_editais`;
CREATE TABLE IF NOT EXISTS `tb_editais` (
  `pr_edital` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `en_tipo_edital` enum('','brumadinho','pps') NOT NULL,
  `vc_edital` varchar(200) NOT NULL,
  `dt_aprovacao` date NOT NULL,
  `es_instituicao` int(10) UNSIGNED NOT NULL,
  `nu_vagas_fundamental` int(10) UNSIGNED NOT NULL,
  `nu_vagas_medio` int(10) UNSIGNED NOT NULL,
  `nu_vagas_superior` int(10) UNSIGNED NOT NULL,
  `en_status` enum('aprovado','publicado') NOT NULL,
  `dt_publicacao` date DEFAULT NULL,
  `nu_vigencia_meses` int(11) DEFAULT NULL,
  `vc_link` varchar(200) DEFAULT NULL,
  `vc_email` varchar(200) DEFAULT NULL,
  `dt_inicio` datetime DEFAULT NULL,
  `dt_fim` datetime DEFAULT NULL,
  `es_usuario_criacao` int(10) UNSIGNED DEFAULT NULL,
  `bl_inativo` enum('0','1') DEFAULT NULL,
  `bl_restrito` enum('0','1') DEFAULT NULL,
  UNIQUE KEY `pr_edital` (`pr_edital`),
  KEY `es_usuarioCriacao` (`es_usuario_criacao`),
  KEY `es_instituicao` (`es_instituicao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_entrevistas`
--

DROP TABLE IF EXISTS `tb_entrevistas`;
CREATE TABLE IF NOT EXISTS `tb_entrevistas` (
  `pr_entrevista` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_avaliador1` int(10) UNSIGNED NOT NULL,
  `es_avaliador2` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador3` int(10) UNSIGNED DEFAULT NULL,
  `dt_entrevista` datetime NOT NULL,
  `es_alterador` int(10) UNSIGNED NOT NULL,
  `dt_alteracao` date NOT NULL,
  `bl_tipo_entrevista` enum('competencia','especialista') DEFAULT NULL,
  `vc_link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pr_entrevista`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`,`bl_tipo_entrevista`) USING BTREE,
  KEY `es_avaliador1` (`es_avaliador1`),
  KEY `es_avaliador2` (`es_avaliador2`),
  KEY `es_alterador` (`es_alterador`),
  KEY `es_avaliador3` (`es_avaliador3`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_entrevistas_justificativa`
--

DROP TABLE IF EXISTS `tb_entrevistas_justificativa`;
CREATE TABLE IF NOT EXISTS `tb_entrevistas_justificativa` (
  `pr_justificativa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_entrevista` int(10) UNSIGNED NOT NULL,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  `dt_justificativa` datetime NOT NULL,
  `tx_justificativa` text NOT NULL,
  `es_avaliador1` int(10) UNSIGNED NOT NULL,
  `es_avaliador2` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador3` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador1_anterior` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador2_anterior` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador3_anterior` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`pr_justificativa`),
  KEY `es_entrevista` (`es_entrevista`),
  KEY `es_usuario` (`es_usuario`),
  KEY `es_avaliador1` (`es_avaliador1`),
  KEY `es_avaliador2` (`es_avaliador2`),
  KEY `es_avaliador3` (`es_avaliador3`),
  KEY `es_avaliador1_anterior` (`es_avaliador1_anterior`),
  KEY `es_avaliador2_anterior` (`es_avaliador2_anterior`),
  KEY `es_avaliador3_anterior` (`es_avaliador3_anterior`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_etapas`
--

DROP TABLE IF EXISTS `tb_etapas`;
CREATE TABLE IF NOT EXISTS `tb_etapas` (
  `pr_etapa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_etapa` varchar(250) COLLATE utf8_bin NOT NULL,
  `in_ordem` tinyint(3) UNSIGNED DEFAULT NULL,
  `vc_texto` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_etapa`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_etapas`
--

INSERT INTO `tb_etapas` (`pr_etapa`, `vc_etapa`, `in_ordem`, `vc_texto`, `bl_removido`) VALUES(1, 'Req. Obrigatórios', 1, 'Para participar do processo de certificação para Superintendente Regional de Ensino, na Secretaria de Estado de Educação de Minas Gerais, é necessário que você cumpra os pré-requisitos publicados no documento de descrição da posição. Por favor, preencha os campo abaixo para verificar se você é elegível para esta posição. ', '0');
INSERT INTO `tb_etapas` (`pr_etapa`, `vc_etapa`, `in_ordem`, `vc_texto`, `bl_removido`) VALUES(2, 'Etapa 1 - Habilitação Mínima', 2, 'Processo de Avaliação não eliminatório', '0');
INSERT INTO `tb_etapas` (`pr_etapa`, `vc_etapa`, `in_ordem`, `vc_texto`, `bl_removido`) VALUES(3, 'Etapa 2 - Aná. curricular', 3, 'Análise curricular pelo Avaliador ', '0');
INSERT INTO `tb_etapas` (`pr_etapa`, `vc_etapa`, `in_ordem`, `vc_texto`, `bl_removido`) VALUES(4, 'Etapa 3 - Entrevista', 4, 'Avaliação pelo Gestor', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_experiencias`
--

DROP TABLE IF EXISTS `tb_experiencias`;
CREATE TABLE IF NOT EXISTS `tb_experiencias` (
  `pr_experienca` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_experiencia_pai` int(11) UNSIGNED DEFAULT NULL,
  `es_candidato` int(10) UNSIGNED NOT NULL,
  `es_candidatura` int(10) UNSIGNED DEFAULT NULL,
  `vc_empresa` varchar(300) COLLATE utf8_bin NOT NULL,
  `ye_inicio` year(4) DEFAULT NULL,
  `me_inicio` int(2) DEFAULT NULL,
  `dt_inicio` date DEFAULT NULL,
  `ye_fim` year(4) DEFAULT NULL,
  `me_fim` int(2) DEFAULT NULL,
  `dt_fim` date DEFAULT NULL,
  `tx_atividades` text COLLATE utf8_bin NOT NULL,
  `bl_emprego_atual` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_experienca`),
  KEY `es_experiencia_pai` (`es_experiencia_pai`),
  KEY `es_candidatura` (`es_candidatura`),
  KEY `es_candidato` (`es_candidato`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_formacao`
--

DROP TABLE IF EXISTS `tb_formacao`;
CREATE TABLE IF NOT EXISTS `tb_formacao` (
  `pr_formacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_formacao_pai` int(10) UNSIGNED DEFAULT NULL,
  `es_candidato` int(10) UNSIGNED NOT NULL,
  `es_candidatura` int(10) UNSIGNED DEFAULT NULL,
  `vc_curso` varchar(300) COLLATE utf8_bin NOT NULL,
  `en_tipo` enum('bacharelado','tecnologo','especializacao','mba','mestrado','doutorado','posdoc','seminario','licenciatura','ensino_medio','producao_cientifica') COLLATE utf8_bin NOT NULL,
  `vc_instituicao` varchar(300) COLLATE utf8_bin NOT NULL,
  `ye_conclusao` year(4) DEFAULT NULL,
  `se_conclusao` int(2) DEFAULT NULL,
  `me_conclusao` int(2) DEFAULT NULL,
  `in_cargahoraria` int(10) UNSIGNED DEFAULT NULL,
  `dt_conclusao` date DEFAULT NULL,
  PRIMARY KEY (`pr_formacao`),
  KEY `es_formacao_pai` (`es_formacao_pai`),
  KEY `es_candidatura` (`es_candidatura`),
  KEY `es_candidato` (`es_candidato`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_gruposvagas`
--

DROP TABLE IF EXISTS `tb_gruposvagas`;
CREATE TABLE IF NOT EXISTS `tb_gruposvagas` (
  `pr_grupovaga` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_grupovaga` varchar(250) COLLATE utf8_bin NOT NULL,
  `es_instituicao` int(10) UNSIGNED DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` date DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_grupovaga`),
  KEY `es_usuarioCadastro` (`es_usuarioCadastro`),
  KEY `es_usuarioAlteracao` (`es_usuarioAlteracao`),
  KEY `es_instituicao` (`es_instituicao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_historicocandidaturas`
--

DROP TABLE IF EXISTS `tb_historicocandidaturas`;
CREATE TABLE IF NOT EXISTS `tb_historicocandidaturas` (
  `pr_historico` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  `es_avaliador` int(10) UNSIGNED DEFAULT NULL,
  `dt_avaliacao` datetime NOT NULL,
  `bl_apto` enum('0','1') COLLATE utf8_bin NOT NULL,
  `in_nota` tinyint(3) UNSIGNED DEFAULT NULL,
  `tx_observacao` mediumtext COLLATE utf8_bin,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED NOT NULL,
  `dt_alteracao` datetime NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_historico`),
  KEY `IdCandidatura` (`es_candidatura`),
  KEY `IdEtapa` (`es_etapa`),
  KEY `IdAvaliador` (`es_avaliador`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_instituicoes2`
--

DROP TABLE IF EXISTS `tb_instituicoes2`;
CREATE TABLE IF NOT EXISTS `tb_instituicoes2` (
  `pr_instituicao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `DDNRPESSOAFISJUR` int(10) UNSIGNED DEFAULT NULL,
  `vc_instituicao` varchar(255) NOT NULL,
  `in_tipounidade` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `vc_sigla` varchar(50) NOT NULL,
  `en_sexonome` enum('m','f') DEFAULT NULL,
  `bl_extinto` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_instituicao`),
  UNIQUE KEY `DDNRPESSOAFISJUR` (`DDNRPESSOAFISJUR`)
) ENGINE=InnoDB AUTO_INCREMENT=1260371 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tb_instituicoes2`
--

INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2, 2, 'Vice Governadoria do Estado', 2, 'VICEGOVERNADORIA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(9, NULL, 'Caixa de Amortização da Dívida', 8, 'CADIV', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1071, 1857449, 'Gabinete Militar do Governador do Estado', 4, 'GMG', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1081, 1858199, 'Advocacia Geral do Estado', 4, 'AGE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1101, 2939378, 'Ouvidoria Geral do Estado de Minas Gerais', 4, 'OGE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1111, 1857428, 'Escritório de Representação do Governo de Minas Gerais em Brasília', 4, 'ERGMG-BSB', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1121, 1857416, 'Secretaria do Governo', 3, 'SEGOV', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1141, 1791028, 'Escritório de Representação do Governo de Minas Gerais no RJ', 4, 'ERGMG-RJ', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1161, 1808437, 'Escritório de Representação do Governo de Minas Gerais em SP', 4, 'ERGMG-SP', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1171, 1858268, 'Secretaria de Estado de Recursos Humanos e Administração', 3, 'SERHA', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1191, 1858211, 'Secretaria de Estado de Fazenda', 3, 'SEF', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1201, 1858214, 'Secretaria de Estado de Planejamento e Coordenação', 3, 'SEPLAN', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1221, 1858203, 'Secretaria de Estado de Desenvolvimento Econômico, Ciência, Tecnologia e Ensino Superior', 3, 'SEDECTES', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1231, 1858202, 'Secretaria de Estado de Agricultura, Pecuária e Abastecimento', 3, 'SEAPA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1251, 1857466, 'Polícia Militar do Estado de Minas Gerais', 4, 'PMMG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1261, 1858210, 'Secretaria de Estado de Educação', 3, 'SEE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1271, 1858208, 'Secretaria de Estado de Cultura e Turismo', 3, 'SECULT', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1281, 1858209, 'Secretaria de Esportes', 1, 'SEESP', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1301, 1858216, 'Secretaria de Estado de Infraestrutura e Mobilidade', 3, 'SEINFRA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1311, 1858205, 'Secretaria de Indústria', 3, 'SEI', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1321, 1858213, 'Secretaria de Estado de Saúde', 3, 'SES', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1341, 1857419, 'Coordenadoria de Apoio e Assistência à Pessoa Deficiente', 4, 'CAADE', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1371, 1857447, 'Secretaria de Estado de Meio Ambiente e Desenvolvimento Sustentável', 3, 'SEMAD', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1381, 1858267, 'Secretaria de Estado do Trabalho, da Assistência Social, da Criança e do Adolescente', 3, 'SETASCAD', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1401, 2671339, 'Corpo de Bombeiros Militar de Minas Gerais', 4, 'CBMMG', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1411, 2716739, 'Secretaria de Estado de Turismo', 3, 'SETUR', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1421, 1791031, 'SECRETARIA COMUNICACAO SOCIAL ', 0, 'SECS', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1441, 2873312, 'Defensoria Pública do Estado de Minas Gerais', 4, 'DPMG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1451, 1858212, 'Secretaria de Estado de Administração Prisional', 3, 'SEAP', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1461, 2873313, 'Secretaria de Estado de Desenvolvimento Econômico', 3, 'SEDE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1471, 1858204, 'Secretaria de Estado de Cidades e de Integração Regional', 3, 'SECIR', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1481, 2873309, 'Secretaria de Estado de Trabalho e Desenvolvimento Social', 3, 'SEDESE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1491, 2873308, 'Secretaria de Estado de Governo', 3, 'SEGOV', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1501, 2873307, 'Secretaria de Estado de Planejamento e Gestão', 3, 'SEPLAG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1511, 1858215, 'Polícia Civil do Estado de Minas Gerais', 4, 'PCMG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1521, 2273949, 'Controladoria Geral do Estado', 4, 'CGE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1531, 3017980, 'Secretaria de Estado de Esportes e da Juventude', 3, 'SEEJ', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1541, 3017981, 'Escola de Saúde Pública de Minas Gerais', 4, 'ESP', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1571, 3189804, 'Secretaria de Estado de Casa Civil e de Relações Institucionais', 3, 'SECCRI', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1581, 3189872, 'Secretaria de Estado de Trabalho e Emprego', 3, 'SETE', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1591, 3189873, 'Secretaria de Estado de Desenvolvimento e Integração do Norte e Nordeste de Minas Gerais', 3, 'SEDINOR', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1601, 3190139, 'Escritório de Prioridades Estratégicas', 3, 'EPE', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1631, 3200569, 'Secretaria Geral', 1, 'SG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1641, 3347491, 'Secretaria de Estado de Desenvolvimento Agrário', 3, 'SEDA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1651, 3346710, 'Secretaria de Estado de Direitos Humanos, Participação Social e Cidadania', 3, 'SEDPAC', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1671, 3347506, 'Secretaria de Estado de Esportes ', 3, 'SEESP', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1691, 3408097, 'Secretaria de Estado de Segurança Pública', 3, 'SESP', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1692, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1693, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1701, 3414458, 'Secretaria de Estado Extraordinária de Desenvolvimento Integrado', 3, 'SEEDIF', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1941, 1853802, 'ENCARGOS GERAIS PLANEJAMENTO E GESTAO', 0, 'ENCARGOS', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2011, 1857455, 'Instituto de Previdência dos Servidores do Estado de Minas Gerais', 6, 'IPSEMG', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2041, 1857459, 'Loteria do Estado de Minas Gerais', 6, 'LEMG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2061, 1857440, 'Fundação João Pinheiro', 5, 'FJP', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2071, 1857430, 'Fundação de Amparo a Pesquisa do Estado de Minas Gerais', 5, 'FAPEMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2081, 1857417, 'Fundação Centro Tecnológico de Minas Gerais', 5, 'CETEC', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2091, 2273955, 'Fundação Estadual do Meio Ambiente', 5, 'FEAM', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2101, 1767133, 'Instituto Estadual de Florestas', 6, 'IEF', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2111, 1858201, 'Fundação Rural Mineira', 5, 'RURALMINAS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2121, 1857454, 'Instituto de Previdência dos Servidores Militares do Estado de Minas Gerais', 6, 'IPSM', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2141, 1857422, 'Departamento de Obras Públicas do Estado de Minas Gerais', 6, 'DEOP', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2151, 1857438, 'Fundação Helena Antipoff', 5, 'FHA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2161, 1857434, 'Fundação Educacional Caio Martins', 5, 'FUCAM', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2171, 1857429, 'Fundação de Arte de Ouro Preto', 5, 'FAOP', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2181, 1857432, 'Fundação Clóvis Salgado', 5, 'FCS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2201, 1857451, 'Instituto Estadual do Patrimônio Histórico e Artístico de Minas Gerais', 5, 'IEPHA', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2211, 1858561, 'Fundação TV Minas', 5, 'TVMINAS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2231, 1853800, 'Administração de Estádios do Estado de Minas Gerais', 6, 'ADEMG', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2241, 2273951, 'Instituto Mineiro de Gestão das Águas', 6, 'IGAM', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2251, 1857457, 'Junta Comercial do Estado de Minas Gerais', 6, 'JUCEMG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2261, 1857448, 'Fundação Ezequiel Dias', 5, 'FUNED', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2271, 1857431, 'Fundação Hospitalar do Estado de Minas Gerais', 5, 'FHEMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2281, 1858563, 'Fundação de Educação para o Trabalho de Minas Gerais', 5, 'UTRAMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2301, 1857424, 'Departamento de Edificações e Estradas de Rodagem do Estado de Minas Gerais', 6, 'DER', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2311, 1858562, 'Universidade Estadual de Montes Claros', 6, 'UNIMONTES', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2321, 1857439, 'Fundação Centro de Hematologia e Hemoterapia do Estado de Minas Gerais', 5, 'HEMOMINAS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2331, 1857456, 'Instituto de Metrologia e Qualidade', 6, 'IPEM', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2351, 1806206, 'Universidade do Estado de Minas Gerais', 6, 'UEMG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2371, 1862379, 'Instituto Mineiro de Agropecuária', 6, 'IMA', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2381, 1857423, 'Departamento Estadual de Telecomunicações de Minas Gerais', 6, 'DETEL', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2391, 1857452, 'Imprensa Oficial do Estado de Minas Gerais', 6, 'IOF', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2401, 2426354, 'Instituto de Geoinformação e Tecnologia', 6, 'IGTEC', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2411, 2855048, 'Instituto de Terras do Estado de Minas Gerais', 6, 'ITER', 'm', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2421, 1857418, 'Instituto de Desenvolvimento do Norte e Nordeste de Minas Gerais', 6, 'IDENE', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2431, 3115953, 'Agência de Desenvolvimento da Região Metropolitana de Belo Horizonte', 6, 'ARMBH', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2441, 3133385, 'Agência Reguladora de Serviços de Abastecimento de Água e de Esgotamento Sanitário do Estado de Minas Gerais', 6, 'ARSAE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2451, 3146991, 'Fundação Centro Internacional de Educação Capacitação e Pesquisa Aplicada em Águas', 5, 'HIDROEX', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(2461, 3230042, 'Agência Metropolitana do Vale do Aço', 6, 'ARMVA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(3001, NULL, 'Secretaria de Estado Extraordinária para Assuntos de Reforma Agrária', 3, 'SEARA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(3041, 2426998, 'Empresa de Assistência Técnica e Extensão Rural do Estado de Minas Gerais', 8, 'EMATER', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(3051, 2426999, 'Empresa de Pesquisa Agropecuária de Minas Gerais', 8, 'EPAMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(3151, 1858200, 'Rádio Inconfidência Ltda.', 8, 'INCONFIDENCIA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(3261, NULL, 'Transportes Metropolitanos de Belo Horizonte S.A.', 8, 'METROMINAS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5011, 2426992, 'Companhia de Desenvolvimento Econômico de Minas Gerais', 8, 'CODEMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5071, 2426982, 'Companhia de Habitação do Estado de Minas Gerais', 8, 'COHAB', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5080, NULL, 'Companhia de Saneamento de Minas Gerais', 8, 'COPASA', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5121, 2426989, 'Companhia Energética de Minas Gerais', 8, 'CEMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5131, 2427004, 'Instituto de Desenvolvimento Integrado de Minas Gerais', 6, 'INDI', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5141, 1764024, 'Companhia de Tecnologia da Informação do Estado de Minas Gerais', 8, 'PRODEMGE', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5181, 2426997, 'Distribuidora de Títulos e Valores Mobiliários de Minas Gerais S.A.', 8, 'DIMINAS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5191, 2427005, 'Minas Gerais Participações S.A.', 8, 'MGI', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5201, 2426925, 'Banco de Desenvolvimento de Minas Gerais S.A.', 8, 'BDMG', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5241, 2426990, 'Companhia Mineira de Promoções', 8, 'PROMINAS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5251, NULL, 'Companhia de Gás de Minas Gerais', 8, 'GASMIG', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(5381, 2427008, 'Minas Gerais Administração e Serviços S.A.', 8, 'MGS', 'f', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1260365, NULL, 'Secretaria de Estado Extraordinária da Copa do Mundo', 3, 'SECOPA', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1260366, NULL, 'Secretaria de Estado Extraordinária de Gestão Metropolitana', 3, 'SEEGM', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1260367, NULL, 'Secretaria de Estado Extraordinária de Regularização Fundiária', 3, 'SEERF', 'f', '1');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1260368, NULL, 'Conselho Estadual de Educação', 8, 'CEE', 'm', '0');
INSERT INTO `tb_instituicoes2` (`pr_instituicao`, `DDNRPESSOAFISJUR`, `vc_instituicao`, `in_tipounidade`, `vc_sigla`, `en_sexonome`, `bl_extinto`) VALUES(1260370, NULL, 'INSTITUICAO C/ CODIGO DE UNIDADE NAO INFORMADO', 0, 'INVALIDO', 'm', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_instituicoes3`
--

DROP TABLE IF EXISTS `tb_instituicoes3`;
CREATE TABLE IF NOT EXISTS `tb_instituicoes3` (
  `pr_instituicao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_instituicao` varchar(250) COLLATE utf8_bin NOT NULL,
  `vc_sigla` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `in_codigo` int(10) UNSIGNED DEFAULT NULL,
  `vc_cnpj` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_instituicao`),
  UNIQUE KEY `in_codigo` (`in_codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_instituicoes3`
--

INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(1, 'Gabinete Militar do Governador do Estado de Minas Gerais', 'GMG', 1071, '18.715.565/0001-10', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(2, 'Advocacia-Geral do Estado', 'AGE', 1081, '16.745.465/0001-01', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(3, 'Procuradoria Geral de Justiça', '', 1091, '20.971.057/0001-45', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(4, 'Ouvidoria Geral do Estado de Minas Gerais', 'OGE', 1101, '07.256.298/0001-44', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(5, 'Secretaria de Estado de Fazenda', 'SEF', 1191, '16.907.746/0001-13', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(6, 'Secretaria de Estado de Desenvolvimento Econômico, Ciência, Tecnologia e Ensino Superior', 'SECTES', 1221, '19.377.514/0001-99', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(7, 'Secretaria de Estado de Agricultura, Pecuária e Abastecimento', 'SEAPA', 1231, '18.715.573/0001-67', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(8, 'Polícia Militar do Estado de Minas Gerais', 'PMMG', 1251, '16.695.025/0001-97', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(9, 'Secretaria de Estado de Educação', 'SEE', 1261, '18.715.599/0001-05', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(10, 'Secretaria de Estado de Cultura', 'SEC', 1271, '19.138.890/0001-20', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(11, 'Secretaria de Estado de Transportes e Obras Públicas', 'SETOP', 1301, '18.715.581/0001-03', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(12, 'Secretaria de Estado de Saúde', 'SES', 1321, '18.715.516/0001-88', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(13, 'Secretaria de Estado de Meio Ambiente e Desenvolvimento Sustentável', 'SEMAD', 1371, '00.957.404/0001-78', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(14, 'Corpo de Bombeiros Militar do Estado de Minas Gerais', 'CBMG', 1401, '03.389.126/0001-98', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(15, 'Secretaria de Estado de Turismo', 'SETUR', 1411, '03.500.589/0001-85', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(16, 'Defensoria Pública do Estado de Minas Gerais', '', 1441, '05.599.094/0001-80', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(17, 'Secretaria de Estado de Administração Prisional', 'SEAP', 1451, '05.487.631/0001-09', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(18, 'Secretaria de Estado de Cidades e Integração Regional', 'SECIR', 1471, '05.475.097/0001-02', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(19, 'Secretaria de Estado de Trabalho e Desenvolvimento Social', 'SEDESE', 1481, '05.465.167/0001-41', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(20, 'Secretaria de Estado de Governo', 'SEGOV', 1491, '05.475.103/0001-21', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(21, 'Secretaria de Estado de Planejamento e Gestão', 'SEPLAG', 1501, '05.461.142/0001-70', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(22, 'Cidade Administrativa', 'CAMG', 1502, '05.461.142/0001-70', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(23, 'Polícia Civil do Estado de Minas Gerais', 'PCMG', 1511, '18.715.532/0001-70', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(24, 'Controladoria-Geral do Estado', 'CGE', 1521, '05.585.681/0001-10', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(25, 'Escola de Saúde Pública do Estado de Minas Gerais', 'ESF', 1541, '08.715.327/0001-51', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(26, 'Departamento de Trânsito de Minas Gerais', 'DETRAN', 1551, '18.715.532/0001-70', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(27, 'Secretaria de Estado de Casa Civil e de Relações Institucionais', 'SECCRI', 1571, '13.237.191/0001-51', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(28, 'Secretaria de Estado de Desenvolvimento e Integração do Norte e Nordeste de Minas Gerais', 'SEDINOR', 1591, '06.315.194/0001-09', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(29, 'Escritório de Prioridades Estratégicas', '', 1601, '13.199.738/0001-71', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(30, 'Secretaria-Geral', 'SG', 1631, '13.235.618.0001-82', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(31, 'Secretaria de Estado de Desenvolvimento Agrário', 'SEAPA', 1641, '22.287.872/0001-15', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(32, 'Secretaria de Estado de Direitos Humanos, Participação Social e Cidadania', '', 1651, '22.199.221/0001-73', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(33, 'Secretaria de Estado de Esportes', 'SEES', 1671, '08.631.821.0001-38', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(34, 'Secretaria de Estado de Segurança Pública', '', 1691, '26.245.509.0001-98', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(35, 'Secretaria de Estado Extraordinária de Desenvolvimento Integrado e Fóruns Regionais', 'Fóruns Regionais', 1701, '26.560.229.0001-74', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(36, 'Instituto de Previdência dos Servidores do Estado de Minas Gerais', 'IPSEMG', 2011, '17.217.332/0001-25', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(37, 'Loteria do Estado de Minas Gerais', 'LEMG', 2041, '17.255.670/0001-51', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(38, 'Instituto Estadual de Florestas', 'IEF', 2101, '18.746.164/0001-28', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(39, 'Instituto de Previdência dos Servidores Militares do Estado de Minas Gerais', '', 2121, '17.444.779/0001-37', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(40, 'Instituto Mineiro de Gestão das Águas', 'IGA', 2241, '17.387.481/0001-32', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(41, 'Junta Comercial do Estado de Minas Gerais', 'JUCEMG', 2251, '17.486.275/0001-80', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(42, 'Departamento de Edificações e Estradas de Rodagem do Estado de Minas Gerais', 'DER', 2301, '17.309.790/0001-94', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(43, 'Universidade Estadual de Montes Claros', 'UNIMONTES', 2311, '22.675.359/0001-00', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(44, 'Instituto de Metrologia e Qualidade do Estado de Minas Gerais', '', 2331, '17.322.264/0001-64', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(45, 'Universidade do Estado de Minas Gerais', 'UEMG', 2351, '65.172.579/0001-15', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(46, 'Instituto Mineiro de Agropecuária', 'IMA', 2371, '65.179.400/0001-51', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(47, 'Departamento Estadual de Telecomunicações de Minas Gerais', 'DETEL', 2381, '17.327.289/0001-50', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(48, 'Instituto de Desenvolvimento do Norte e Nordeste de Minas Gerais', 'IDENE', 2421, '04.888.232/0001-89', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(49, 'Agência de Desenvolvimento da Região Metropolitana de Belo Horizonte', '', 2431, '10.745.790/0001-98', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(50, 'Agência Reguladora de Serviços de Abastecimento de Água e de Esgotamento Sanitário', '', 2441, '11.099.618/0001-77', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(51, 'Agência de Desenvolvimento da Região Metropolitana de Vale do Aço', '', 2461, '15.438.067/0001-80', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(52, 'Fundação João Pinheiro', 'FJP', 2061, '17.464.652/0001-80', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(53, 'Fundação de Amparo à Pesquisa do Estado de Minas Gerais', 'FAPEMIG', 2071, '21.949.888/0001-83', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(54, 'Fundação Estadual do Meio Ambiente', 'FEAM', 2091, '25.455.858/0001-71', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(55, 'Fundação Helena Antipoff', 'FHA', 2151, '16.789.398/0001-27', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(56, 'Fundação Educacional Caio Martins', 'FUCAM', 2161, '19.169.713/0001-01', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(57, 'Fundação de Arte de Ouro Preto', 'FAOP', 2171, '23.070.071/0001-66', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(58, 'Fundação Clóvis Salgado', 'FCS', 2181, '17.498.205/0001-41', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(59, 'Instituto Estadual do Patrimônio Histórico e Artístico de Minas Gerais', 'IEPHA', 2201, '16.625.196/0001-40', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(60, 'Fundação TV Minas Cultural e Educativa', '', 2211, '21.229.281/0001-29', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(61, 'Fundação Ezequiel Dias', 'FUNED', 2261, '17.503.475/0001-01', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(62, 'Fundação Hospitalar do Estado de Minas Gerais', 'FHEMIG', 2271, '19.843.929/0001-00', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(63, 'Fundação de Educação para o Trabalho de Minas Gerais', '', 2281, '17.319.831/0001-23', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(64, 'Fundação Centro de Hematologia e Hemoterapia de Minas Gerais', 'Hemominas', 2321, '26.388.330/0001-90', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(65, 'Empresa de Assistência Técnica e Extensão Rural do Estado de Minas Gerais', 'EMATER', 3041, '19.198.118/0001-02', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(66, 'Empresa de Pesquisa Agropecuária de Minas Gerais', 'EPAMIG', 3051, '17.138.140/0001-23', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(67, 'Empresa Mineira de Comunicação', '', 3151, '20.234.423/0001-83', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(68, 'Banco de Desenvolvimento de Minas Gerais ', ' BDMG', NULL, '38.486.817/0001-94', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(69, 'Companhia de Desenvovimento Econômico de Minas Gerais', '', NULL, '19.791.581/0001-55', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(70, 'Companhia de Desenvovimento de Minas Gerais ', ' Codemge', NULL, '29.768.219/0001-17', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(71, 'Companhia de Gás de Minas Gerais ', ' Gasmig', NULL, '22.261.473/0001-85', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(72, 'Companhia de Habitação do Estado de Minas Gerais ', ' Cohab', NULL, '17.161.837/0001-15', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(73, 'Companhia de Saneamento de Minas Gerais ', ' Copasa', NULL, '17.281.106/0001-03', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(74, 'Companhia de Tecnologia da Informação do Estado de Minas Gerais ', ' Prodemge', NULL, '16.636.540/0001-04', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(75, 'Companhia Energética de Minas Gerais ', ' Cemig', NULL, '17.155.730/0001-64', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(76, 'COPASA - Serviços de Saneamento Integrado do Norte e Nordeste de Minas Gerais S/A', '', NULL, '09.104.426/0001-60', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(77, 'Instituto de Desenvolvimento Integrado de Minas Gerais ', ' INDI', NULL, '17.398.512/0001-50', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(78, 'Minas Gerais Administração e Serviços S/A', 'MGS', NULL, '33.224.254/0001-42', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(79, 'Minas Gerais Participações S/A ', ' MGI', NULL, '19.296.342/0001-29', '0');
INSERT INTO `tb_instituicoes3` (`pr_instituicao`, `vc_instituicao`, `vc_sigla`, `in_codigo`, `vc_cnpj`, `bl_removido`) VALUES(80, 'Trem Metropolitano de Belo Horizonte S.A. ', ' Metrominas', NULL, '03.919.139/0001-21', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_log`
--

DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE IF NOT EXISTS `tb_log` (
  `pr_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dt_log` datetime NOT NULL,
  `en_tipo` enum('erro','seguranca','sucesso','advertencia') COLLATE utf8_bin NOT NULL,
  `vc_local` varchar(100) COLLATE utf8_bin NOT NULL,
  `es_usuario` int(10) UNSIGNED DEFAULT NULL,
  `vc_tabela` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `in_chave` int(10) UNSIGNED DEFAULT NULL,
  `tx_texto` mediumtext COLLATE utf8_bin NOT NULL,
  `vc_ip` varchar(15) COLLATE utf8_bin NOT NULL,
  `vc_sessao` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_log`),
  KEY `es_usuario` (`es_usuario`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_municipios`
--

DROP TABLE IF EXISTS `tb_municipios`;
CREATE TABLE IF NOT EXISTS `tb_municipios` (
  `pr_municipio` bigint(20) NOT NULL AUTO_INCREMENT,
  `es_uf` int(10) UNSIGNED NOT NULL,
  `in_codigo` int(10) UNSIGNED NOT NULL,
  `vc_municipio` varchar(250) COLLATE utf8_bin NOT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_municipio`),
  KEY `es_uf` (`es_uf`)
) ENGINE=InnoDB AUTO_INCREMENT=5566 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_municipios`
--

INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1, 11, 3100104, 'ABADIA DOS DOURADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2, 11, 3100203, 'ABAETÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3, 11, 3100302, 'ABRE CAMPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4, 11, 3100401, 'ACAIACA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5, 11, 3100500, 'AÇUCENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(6, 11, 3100609, 'ÁGUA BOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(7, 11, 3100708, 'ÁGUA COMPRIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(8, 11, 3100807, 'AGUANIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(9, 11, 3100906, 'ÁGUAS FORMOSAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(10, 11, 3101003, 'ÁGUAS VERMELHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(11, 11, 3101102, 'AIMORÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(12, 11, 3101201, 'AIURUOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(13, 11, 3101300, 'ALAGOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(14, 11, 3101409, 'ALBERTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(15, 11, 3101508, 'ALÉM PARAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(16, 11, 3101607, 'ALFENAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(17, 11, 3101631, 'ALFREDO VASCONCELOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(18, 11, 3101706, 'ALMENARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(19, 11, 3101805, 'ALPERCATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(20, 11, 3101904, 'ALPINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(21, 11, 3102001, 'ALTEROSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(22, 11, 3102050, 'ALTO CAPARAÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(23, 11, 3153509, 'ALTO JEQUITIBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(24, 11, 3102100, 'ALTO RIO DOCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(25, 11, 3102209, 'ALVARENGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(26, 11, 3102308, 'ALVINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(27, 11, 3102407, 'ALVORADA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(28, 11, 3102506, 'AMPARO DO SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(29, 11, 3102605, 'ANDRADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(30, 11, 3102803, 'ANDRELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(31, 11, 3102852, 'ANGELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(32, 11, 3102902, 'ANTÔNIO CARLOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(33, 11, 3103009, 'ANTÔNIO DIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(34, 11, 3103108, 'ANTÔNIO PRADO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(35, 11, 3103207, 'ARAÇAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(36, 11, 3103306, 'ARACITABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(37, 11, 3103405, 'ARAÇUAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(38, 11, 3103504, 'ARAGUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(39, 11, 3103603, 'ARANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(40, 11, 3103702, 'ARAPONGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(41, 11, 3103751, 'ARAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(42, 11, 3103801, 'ARAPUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(43, 11, 3103900, 'ARAÚJOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(44, 11, 3104007, 'ARAXÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(45, 11, 3104106, 'ARCEBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(46, 11, 3104205, 'ARCOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(47, 11, 3104304, 'AREADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(48, 11, 3104403, 'ARGIRITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(49, 11, 3104452, 'ARICANDUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(50, 11, 3104502, 'ARINOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(51, 11, 3104601, 'ASTOLFO DUTRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(52, 11, 3104700, 'ATALÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(53, 11, 3104809, 'AUGUSTO DE LIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(54, 11, 3104908, 'BAEPENDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(55, 11, 3105004, 'BALDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(56, 11, 3105103, 'BAMBUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(57, 11, 3105202, 'BANDEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(58, 11, 3105301, 'BANDEIRA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(59, 11, 3105400, 'BARÃO DE COCAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(60, 11, 3105509, 'BARÃO DE MONTE ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(61, 11, 3105608, 'BARBACENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(62, 11, 3105707, 'BARRA LONGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(63, 11, 3105905, 'BARROSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(64, 11, 3106002, 'BELA VISTA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(65, 11, 3106101, 'BELMIRO BRAGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(66, 11, 3106200, 'BELO HORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(67, 11, 3106309, 'BELO ORIENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(68, 11, 3106408, 'BELO VALE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(69, 11, 3106507, 'BERILO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(70, 11, 3106655, 'BERIZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(71, 11, 3106606, 'BERTÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(72, 11, 3106705, 'BETIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(73, 11, 3106804, 'BIAS FORTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(74, 11, 3106903, 'BICAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(75, 11, 3107000, 'BIQUINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(76, 11, 3107109, 'BOA ESPERANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(77, 11, 3107208, 'BOCAINA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(78, 11, 3107307, 'BOCAIÚVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(79, 11, 3107406, 'BOM DESPACHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(80, 11, 3107505, 'BOM JARDIM DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(81, 11, 3107604, 'BOM JESUS DA PENHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(82, 11, 3107703, 'BOM JESUS DO AMPARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(83, 11, 3107802, 'BOM JESUS DO GALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(84, 11, 3107901, 'BOM REPOUSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(85, 11, 3108008, 'BOM SUCESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(86, 11, 3108107, 'BONFIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(87, 11, 3108206, 'BONFINÓPOLIS DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(88, 11, 3108255, 'BONITO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(89, 11, 3108305, 'BORDA DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(90, 11, 3108404, 'BOTELHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(91, 11, 3108503, 'BOTUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(92, 11, 3108701, 'BRÁS PIRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(93, 11, 3108552, 'BRASILÂNDIA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(94, 11, 3108602, 'BRASÍLIA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(95, 11, 3108909, 'BRAZÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(96, 11, 3108800, 'BRAÚNAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(97, 11, 3109006, 'BRUMADINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(98, 11, 3109105, 'BUENO BRANDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(99, 11, 3109204, 'BUENÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(100, 11, 3109253, 'BUGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(101, 11, 3109303, 'BURITIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(102, 11, 3109402, 'BURITIZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(103, 11, 3109451, 'CABECEIRA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(104, 11, 3109501, 'CABO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(105, 11, 3109600, 'CACHOEIRA DA PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(106, 11, 3109709, 'CACHOEIRA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(107, 11, 3102704, 'CACHOEIRA DE PAJEÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(108, 11, 3109808, 'CACHOEIRA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(109, 11, 3109907, 'CAETANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(110, 11, 3110004, 'CAETÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(111, 11, 3110103, 'CAIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(112, 11, 3110202, 'CAJURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(113, 11, 3110301, 'CALDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(114, 11, 3110400, 'CAMACHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(115, 11, 3110509, 'CAMANDUCAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(116, 11, 3110608, 'CAMBUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(117, 11, 3110707, 'CAMBUQUIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(118, 11, 3110806, 'CAMPANÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(119, 11, 3110905, 'CAMPANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(120, 11, 3111002, 'CAMPESTRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(121, 11, 3111101, 'CAMPINA VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(122, 11, 3111150, 'CAMPO AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(123, 11, 3111200, 'CAMPO BELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(124, 11, 3111309, 'CAMPO DO MEIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(125, 11, 3111408, 'CAMPO FLORIDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(126, 11, 3111507, 'CAMPOS ALTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(127, 11, 3111606, 'CAMPOS GERAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(128, 11, 3111903, 'CANA VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(129, 11, 3111705, 'CANAÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(130, 11, 3111804, 'CANÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(131, 11, 3112000, 'CANDEIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(132, 11, 3112059, 'CANTAGALO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(133, 11, 3112109, 'CAPARAÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(134, 11, 3112208, 'CAPELA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(135, 11, 3112307, 'CAPELINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(136, 11, 3112406, 'CAPETINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(137, 11, 3112505, 'CAPIM BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(138, 11, 3112604, 'CAPINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(139, 11, 3112653, 'CAPITÃO ANDRADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(140, 11, 3112703, 'CAPITÃO ENÉAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(141, 11, 3112802, 'CAPITÓLIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(142, 11, 3112901, 'CAPUTIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(143, 11, 3113008, 'CARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(144, 11, 3113107, 'CARANAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(145, 11, 3113206, 'CARANDAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(146, 11, 3113305, 'CARANGOLA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(147, 11, 3113404, 'CARATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(148, 11, 3113503, 'CARBONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(149, 11, 3113602, 'CAREAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(150, 11, 3113701, 'CARLOS CHAGAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(151, 11, 3113800, 'CARMÉSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(152, 11, 3113909, 'CARMO DA CACHOEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(153, 11, 3114006, 'CARMO DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(154, 11, 3114105, 'CARMO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(155, 11, 3114204, 'CARMO DO CAJURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(156, 11, 3114303, 'CARMO DO PARANAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(157, 11, 3114402, 'CARMO DO RIO CLARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(158, 11, 3114501, 'CARMÓPOLIS DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(159, 11, 3114550, 'CARNEIRINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(160, 11, 3114600, 'CARRANCAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(161, 11, 3114709, 'CARVALHÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(162, 11, 3114808, 'CARVALHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(163, 11, 3114907, 'CASA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(164, 11, 3115003, 'CASCALHO RICO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(165, 11, 3115102, 'CÁSSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(166, 11, 3115300, 'CATAGUASES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(167, 11, 3115359, 'CATAS ALTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(168, 11, 3115409, 'CATAS ALTAS DA NORUEGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(169, 11, 3115458, 'CATUJI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(170, 11, 3115474, 'CATUTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(171, 11, 3115508, 'CAXAMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(172, 11, 3115607, 'CEDRO DO ABAETÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(173, 11, 3115706, 'CENTRAL DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(174, 11, 3115805, 'CENTRALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(175, 11, 3115904, 'CHÁCARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(176, 11, 3116001, 'CHALÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(177, 11, 3116100, 'CHAPADA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(178, 11, 3116159, 'CHAPADA GAÚCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(179, 11, 3116209, 'CHIADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(180, 11, 3116308, 'CIPOTÂNEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(181, 11, 3116407, 'CLARAVAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(182, 11, 3116506, 'CLARO DOS POÇÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(183, 11, 3116605, 'CLÁUDIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(184, 11, 3116704, 'COIMBRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(185, 11, 3116803, 'COLUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(186, 11, 3116902, 'COMENDADOR GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(187, 11, 3117009, 'COMERCINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(188, 11, 3117108, 'CONCEIÇÃO DA APARECIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(189, 11, 3115201, 'CONCEIÇÃO DA BARRA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(190, 11, 3117306, 'CONCEIÇÃO DAS ALAGOAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(191, 11, 3117207, 'CONCEIÇÃO DAS PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(192, 11, 3117405, 'CONCEIÇÃO DE IPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(193, 11, 3117504, 'CONCEIÇÃO DO MATO DENTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(194, 11, 3117603, 'CONCEIÇÃO DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(195, 11, 3117702, 'CONCEIÇÃO DO RIO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(196, 11, 3117801, 'CONCEIÇÃO DOS OUROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(197, 11, 3117836, 'CÔNEGO MARINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(198, 11, 3117876, 'CONFINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(199, 11, 3117900, 'CONGONHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(200, 11, 3118007, 'CONGONHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(201, 11, 3118106, 'CONGONHAS DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(202, 11, 3118205, 'CONQUISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(203, 11, 3118304, 'CONSELHEIRO LAFAIETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(204, 11, 3118403, 'CONSELHEIRO PENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(205, 11, 3118502, 'CONSOLAÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(206, 11, 3118601, 'CONTAGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(207, 11, 3118700, 'COQUEIRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(208, 11, 3118809, 'CORAÇÃO DE JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(209, 11, 3118908, 'CORDISBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(210, 11, 3119005, 'CORDISLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(211, 11, 3119104, 'CORINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(212, 11, 3119203, 'COROACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(213, 11, 3119302, 'COROMANDEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(214, 11, 3119401, 'CORONEL FABRICIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(215, 11, 3119500, 'CORONEL MURTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(216, 11, 3119609, 'CORONEL PACHECO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(217, 11, 3119708, 'CORONEL XAVIER CHAVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(218, 11, 3119807, 'CÓRREGO DANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(219, 11, 3119906, 'CÓRREGO DO BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(220, 11, 3119955, 'CÓRREGO FUNDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(221, 11, 3120003, 'CÓRREGO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(222, 11, 3120102, 'COUTO DE MAGALHÃES DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(223, 11, 3120151, 'CRISÓLITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(224, 11, 3120201, 'CRISTAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(225, 11, 3120300, 'CRISTÁLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(226, 11, 3120409, 'CRISTIANO OTONI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(227, 11, 3120508, 'CRISTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(228, 11, 3120607, 'CRUCILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(229, 11, 3120706, 'CRUZEIRO DA FORTALEZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(230, 11, 3120805, 'CRUZÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(231, 11, 3120839, 'CUPARAQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(232, 11, 3120870, 'CURRAL DE DENTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(233, 11, 3120904, 'CURVELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(234, 11, 3121001, 'DATAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(235, 11, 3121100, 'DELFIM MOREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(236, 11, 3121209, 'DELFINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(237, 11, 3121258, 'DELTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(238, 11, 3121308, 'DESCOBERTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(239, 11, 3121407, 'DESTERRO DE ENTRE RIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(240, 11, 3121506, 'DESTERRO DO MELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(241, 11, 3121605, 'DIAMANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(242, 11, 3121704, 'DIOGO DE VASCONCELOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(243, 11, 3121803, 'DIONÍSIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(244, 11, 3121902, 'DIVINÉSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(245, 11, 3122009, 'DIVINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(246, 11, 3122108, 'DIVINO DAS LARANJEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(247, 11, 3122207, 'DIVINOLÂNDIA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(248, 11, 3122306, 'DIVINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(249, 11, 3122355, 'DIVISA ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(250, 11, 3122405, 'DIVISA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(251, 11, 3122454, 'DIVISÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(252, 11, 3122470, 'DOM BOSCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(253, 11, 3122504, 'DOM CAVATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(254, 11, 3122603, 'DOM JOAQUIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(255, 11, 3122702, 'DOM SILVÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(256, 11, 3122801, 'DOM VIÇOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(257, 11, 3122900, 'DONA EUZÉBIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(258, 11, 3123007, 'DORES DE CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(259, 11, 3123106, 'DORES DE GUANHÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(260, 11, 3123205, 'DORES DO INDAIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(261, 11, 3123304, 'DORES DO TURVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(262, 11, 3123403, 'DORESÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(263, 11, 3123502, 'DOURADOQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(264, 11, 3123528, 'DURANDÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(265, 11, 3123601, 'ELÓI MENDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(266, 11, 3123700, 'ENGENHEIRO CALDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(267, 11, 3123809, 'ENGENHEIRO NAVARRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(268, 11, 3123858, 'ENTRE FOLHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(269, 11, 3123908, 'ENTRE RIOS DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(270, 11, 3124005, 'ERVÁLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(271, 11, 3124104, 'ESMERALDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(272, 11, 3124203, 'ESPERA FELIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(273, 11, 3124302, 'ESPINOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(274, 11, 3124401, 'ESPÍRITO SANTO DO DOURADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(275, 11, 3124500, 'ESTIVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(276, 11, 3124609, 'ESTRELA DALVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(277, 11, 3124708, 'ESTRELA DO INDAIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(278, 11, 3124807, 'ESTRELA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(279, 11, 3124906, 'EUGENÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(280, 11, 3125002, 'EWBANK DA CÂMARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(281, 11, 3125101, 'EXTREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(282, 11, 3125200, 'FAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(283, 11, 3125309, 'FARIA LEMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(284, 11, 3125408, 'FELÍCIO DOS SANTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(285, 11, 3125606, 'FELISBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(286, 11, 3125705, 'FELIXLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(287, 11, 3125804, 'FERNANDES TOURINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(288, 11, 3125903, 'FERROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(289, 11, 3125952, 'FERVEDOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(290, 11, 3126000, 'FLORESTAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(291, 11, 3126109, 'FORMIGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(292, 11, 3126208, 'FORMOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(293, 11, 3126307, 'FORTALEZA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(294, 11, 3126406, 'FORTUNA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(295, 11, 3126505, 'FRANCISCO BADARÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(296, 11, 3126604, 'FRANCISCO DUMONT', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(297, 11, 3126703, 'FRANCISCO SÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(298, 11, 3126752, 'FRANCISCÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(299, 11, 3126802, 'FREI GASPAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(300, 11, 3126901, 'FREI INOCÊNCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(301, 11, 3126950, 'FREI LAGONEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(302, 11, 3127008, 'FRONTEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(303, 11, 3127057, 'FRONTEIRA DOS VALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(304, 11, 3127073, 'FRUTA DE LEITE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(305, 11, 3127107, 'FRUTAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(306, 11, 3127206, 'FUNILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(307, 11, 3127305, 'GALILÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(308, 11, 3127339, 'GAMELEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(309, 11, 3127354, 'GLAUCILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(310, 11, 3127370, 'GOIABEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(311, 11, 3127388, 'GOIANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(312, 11, 3127404, 'GONÇALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(313, 11, 3127503, 'GONZAGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(314, 11, 3127602, 'GOUVEIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(315, 11, 3127701, 'GOVERNADOR VALADARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(316, 11, 3127800, 'GRÃO MOGOL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(317, 11, 3127909, 'GRUPIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(318, 11, 3128006, 'GUANHÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(319, 11, 3128105, 'GUAPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(320, 11, 3128204, 'GUARACIABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(321, 11, 3128253, 'GUARACIAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(322, 11, 3128303, 'GUARANÉSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(323, 11, 3128402, 'GUARANI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(324, 11, 3128501, 'GUARARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(325, 11, 3128600, 'GUARDA-MOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(326, 11, 3128709, 'GUAXUPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(327, 11, 3128808, 'GUIDOVAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(328, 11, 3128907, 'GUIMARÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(329, 11, 3129004, 'GUIRICEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(330, 11, 3129103, 'GURINHATÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(331, 11, 3129202, 'HELIODORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(332, 11, 3129301, 'IAPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(333, 11, 3129400, 'IBERTIOGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(334, 11, 3129509, 'IBIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(335, 11, 3129608, 'IBIAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(336, 11, 3129657, 'IBIRACATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(337, 11, 3129707, 'IBIRACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(338, 11, 3129806, 'IBIRITÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(339, 11, 3129905, 'IBITIÚRA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(340, 11, 3130002, 'IBITURUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(341, 11, 3130051, 'ICARAÍ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(342, 11, 3130101, 'IGARAPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(343, 11, 3130200, 'IGARATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(344, 11, 3130309, 'IGUATAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(345, 11, 3130408, 'IJACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(346, 11, 3130507, 'ILICÍNEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(347, 11, 3130556, 'IMBÉ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(348, 11, 3130606, 'INCONFIDENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(349, 11, 3130655, 'INDAIABIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(350, 11, 3130705, 'INDIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(351, 11, 3130804, 'INGAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(352, 11, 3130903, 'INHAPIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(353, 11, 3131000, 'INHAÚMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(354, 11, 3131109, 'INIMUTABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(355, 11, 3131158, 'IPABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(356, 11, 3131208, 'IPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(357, 11, 3131307, 'IPATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(358, 11, 3131406, 'IPIAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(359, 11, 3131505, 'IPUIÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(360, 11, 3131604, 'IRAÍ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(361, 11, 3131703, 'ITABIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(362, 11, 3131802, 'ITABIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(363, 11, 3131901, 'ITABIRITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(364, 11, 3132008, 'ITACAMBIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(365, 11, 3132107, 'ITACARAMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(366, 11, 3132206, 'ITAGUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(367, 11, 3132305, 'ITAIPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(368, 11, 3132404, 'ITAJUBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(369, 11, 3132503, 'ITAMARANDIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(370, 11, 3132602, 'ITAMARATI DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(371, 11, 3132701, 'ITAMBACURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(372, 11, 3132800, 'ITAMBÉ DO MATO DENTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(373, 11, 3132909, 'ITAMOGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(374, 11, 3133006, 'ITAMONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(375, 11, 3133105, 'ITANHANDU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(376, 11, 3133204, 'ITANHOMI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(377, 11, 3133303, 'ITAOBIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(378, 11, 3133402, 'ITAPAGIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(379, 11, 3133501, 'ITAPECERICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(380, 11, 3133600, 'ITAPEVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(381, 11, 3133709, 'ITATIAIUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(382, 11, 3133758, 'ITAÚ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(383, 11, 3133808, 'ITAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(384, 11, 3133907, 'ITAVERAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(385, 11, 3134004, 'ITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(386, 11, 3134103, 'ITUETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(387, 11, 3134202, 'ITUIUTABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(388, 11, 3134301, 'ITUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(389, 11, 3134400, 'ITURAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(390, 11, 3134509, 'ITUTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(391, 11, 3134608, 'JABOTICATUBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(392, 11, 3134707, 'JACINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(393, 11, 3134806, 'JACUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(394, 11, 3134905, 'JACUTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(395, 11, 3135001, 'JAGUARAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(396, 11, 3135050, 'JAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(397, 11, 3135076, 'JAMPRUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(398, 11, 3135100, 'JANAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(399, 11, 3135209, 'JANUÁRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(400, 11, 3135308, 'JAPARAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(401, 11, 3135357, 'JAPONVAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(402, 11, 3135407, 'JECEABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(403, 11, 3135456, 'JENIPAPO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(404, 11, 3135506, 'JEQUERI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(405, 11, 3135605, 'JEQUITAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(406, 11, 3135704, 'JEQUITIBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(407, 11, 3135803, 'JEQUITINHONHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(408, 11, 3135902, 'JESUÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(409, 11, 3136009, 'JOAÍMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(410, 11, 3136108, 'JOANÉSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(411, 11, 3136207, 'JOÃO MONLEVADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(412, 11, 3136306, 'JOÃO PINHEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(413, 11, 3136405, 'JOAQUIM FELÍCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(414, 11, 3136504, 'JORDÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(415, 11, 3136520, 'JOSÉ GONÇALVES DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(416, 11, 3136553, 'JOSÉ RAYDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(417, 11, 3136579, 'JOSENÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(418, 11, 3136652, 'JUATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(419, 11, 3136702, 'JUIZ DE FORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(420, 11, 3136801, 'JURAMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(421, 11, 3136900, 'JURUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(422, 11, 3136959, 'JUVENÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(423, 11, 3137007, 'LADAINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(424, 11, 3137106, 'LAGAMAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(425, 11, 3137205, 'LAGOA DA PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(426, 11, 3137304, 'LAGOA DOS PATOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(427, 11, 3137403, 'LAGOA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(428, 11, 3137502, 'LAGOA FORMOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(429, 11, 3137536, 'LAGOA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(430, 11, 3137601, 'LAGOA SANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(431, 11, 3137700, 'LAJINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(432, 11, 3137809, 'LAMBARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(433, 11, 3137908, 'LAMIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(434, 11, 3138005, 'LARANJAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(435, 11, 3138104, 'LASSANCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(436, 11, 3138203, 'LAVRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(437, 11, 3138302, 'LEANDRO FERREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(438, 11, 3138351, 'LEME DO PRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(439, 11, 3138401, 'LEOPOLDINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(440, 11, 3138500, 'LIBERDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(441, 11, 3138609, 'LIMA DUARTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(442, 11, 3138625, 'LIMEIRA DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(443, 11, 3138658, 'LONTRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(444, 11, 3138674, 'LUISBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(445, 11, 3138682, 'LUISLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(446, 11, 3138708, 'LUMINÁRIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(447, 11, 3138807, 'LUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(448, 11, 3138906, 'MACHACALIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(449, 11, 3139003, 'MACHADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(450, 11, 3139102, 'MADRE DE DEUS DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(451, 11, 3139201, 'MALACACHETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(452, 11, 3139250, 'MAMONAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(453, 11, 3139300, 'MANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(454, 11, 3139409, 'MANHUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(455, 11, 3139508, 'MANHUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(456, 11, 3139607, 'MANTENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(457, 11, 3139805, 'MAR DE ESPANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(458, 11, 3139706, 'MARAVILHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(459, 11, 3139904, 'MARIA DA FÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(460, 11, 3140001, 'MARIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(461, 11, 3140100, 'MARILAC', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(462, 11, 3140159, 'MÁRIO CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(463, 11, 3140209, 'MARIPÁ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(464, 11, 3140308, 'MARLIÉRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(465, 11, 3140407, 'MARMELÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(466, 11, 3140506, 'MARTINHO CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(467, 11, 3140530, 'MARTINS SOARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(468, 11, 3140555, 'MATA VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(469, 11, 3140605, 'MATERLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(470, 11, 3140704, 'MATEUS LEME', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(471, 11, 3171501, 'MATHIAS LOBATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(472, 11, 3140803, 'MATIAS BARBOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(473, 11, 3140852, 'MATIAS CARDOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(474, 11, 3140902, 'MATIPÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(475, 11, 3141009, 'MATO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(476, 11, 3141108, 'MATOZINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(477, 11, 3141207, 'MATUTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(478, 11, 3141306, 'MEDEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(479, 11, 3141405, 'MEDINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(480, 11, 3141504, 'MENDES PIMENTEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(481, 11, 3141603, 'MERCÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(482, 11, 3141702, 'MESQUITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(483, 11, 3141801, 'MINAS NOVAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(484, 11, 3141900, 'MINDURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(485, 11, 3142007, 'MIRABELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(486, 11, 3142106, 'MIRADOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(487, 11, 3142205, 'MIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(488, 11, 3142254, 'MIRAVÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(489, 11, 3142304, 'MOEDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(490, 11, 3142403, 'MOEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(491, 11, 3142502, 'MONJOLOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(492, 11, 3142601, 'MONSENHOR PAULO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(493, 11, 3142700, 'MONTALVÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(494, 11, 3142809, 'MONTE ALEGRE DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(495, 11, 3142908, 'MONTE AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(496, 11, 3143005, 'MONTE BELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(497, 11, 3143104, 'MONTE CARMELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(498, 11, 3143153, 'MONTE FORMOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(499, 11, 3143203, 'MONTE SANTO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(500, 11, 3143401, 'MONTE SIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(501, 11, 3143302, 'MONTES CLAROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(502, 11, 3143450, 'MONTEZUMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(503, 11, 3143500, 'MORADA NOVA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(504, 11, 3143609, 'MORRO DA GARÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(505, 11, 3143708, 'MORRO DO PILAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(506, 11, 3143807, 'MUNHOZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(507, 11, 3143906, 'MURIAÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(508, 11, 3144003, 'MUTUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(509, 11, 3144102, 'MUZAMBINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(510, 11, 3144201, 'NACIP RAYDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(511, 11, 3144300, 'NANUQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(512, 11, 3144359, 'NAQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(513, 11, 3144375, 'NATALÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(514, 11, 3144409, 'NATÉRCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(515, 11, 3144508, 'NAZARENO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(516, 11, 3144607, 'NEPOMUCENO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(517, 11, 3144656, 'NINHEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(518, 11, 3144672, 'NOVA BELÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(519, 11, 3144706, 'NOVA ERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(520, 11, 3144805, 'NOVA LIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(521, 11, 3144904, 'NOVA MÓDICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(522, 11, 3145000, 'NOVA PONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(523, 11, 3145059, 'NOVA PORTEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(524, 11, 3145109, 'NOVA RESENDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(525, 11, 3145208, 'NOVA SERRANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(526, 11, 3136603, 'NOVA UNIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(527, 11, 3145307, 'NOVO CRUZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(528, 11, 3145356, 'NOVO ORIENTE DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(529, 11, 3145372, 'NOVORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(530, 11, 3145406, 'OLARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(531, 11, 3145455, 'OLHOS-D\'ÁGUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(532, 11, 3145505, 'OLÍMPIO NORONHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(533, 11, 3145604, 'OLIVEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(534, 11, 3145703, 'OLIVEIRA FORTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(535, 11, 3145802, 'ONÇA DE PITANGUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(536, 11, 3145851, 'ORATÓRIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(537, 11, 3145877, 'ORIZÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(538, 11, 3145901, 'OURO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(539, 11, 3146008, 'OURO FINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(540, 11, 3146107, 'OURO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(541, 11, 3146206, 'OURO VERDE DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(542, 11, 3146255, 'PADRE CARVALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(543, 11, 3146305, 'PADRE PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(544, 11, 3146552, 'PAI PEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(545, 11, 3146404, 'PAINEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(546, 11, 3146503, 'PAINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(547, 11, 3146602, 'PAIVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(548, 11, 3146701, 'PALMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(549, 11, 3146750, 'PALMÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(550, 11, 3146909, 'PAPAGAIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(551, 11, 3147105, 'PARÁ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(552, 11, 3147006, 'PARACATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(553, 11, 3147204, 'PARAGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(554, 11, 3147303, 'PARAISÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(555, 11, 3147402, 'PARAOPEBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(556, 11, 3147600, 'PASSA QUATRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(557, 11, 3147709, 'PASSA TEMPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(558, 11, 3147501, 'PASSABÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(559, 11, 3147808, 'PASSA-VINTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(560, 11, 3147907, 'PASSOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(561, 11, 3147956, 'PATIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(562, 11, 3148004, 'PATOS DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(563, 11, 3148103, 'PATROCÍNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(564, 11, 3148202, 'PATROCÍNIO DO MURIAÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(565, 11, 3148301, 'PAULA CÂNDIDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(566, 11, 3148400, 'PAULISTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(567, 11, 3148509, 'PAVÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(568, 11, 3148608, 'PEÇANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(569, 11, 3148707, 'PEDRA AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(570, 11, 3148756, 'PEDRA BONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(571, 11, 3148806, 'PEDRA DO ANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(572, 11, 3148905, 'PEDRA DO INDAIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(573, 11, 3149002, 'PEDRA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(574, 11, 3149101, 'PEDRALVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(575, 11, 3149150, 'PEDRAS DE MARIA DA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(576, 11, 3149200, 'PEDRINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(577, 11, 3149309, 'PEDRO LEOPOLDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(578, 11, 3149408, 'PEDRO TEIXEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(579, 11, 3149507, 'PEQUERI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(580, 11, 3149606, 'PEQUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(581, 11, 3149705, 'PERDIGÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(582, 11, 3149804, 'PERDIZES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(583, 11, 3149903, 'PERDÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(584, 11, 3149952, 'PERIQUITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(585, 11, 3150000, 'PESCADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(586, 11, 3150109, 'PIAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(587, 11, 3150158, 'PIEDADE DE CARATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(588, 11, 3150208, 'PIEDADE DE PONTE NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(589, 11, 3150307, 'PIEDADE DO RIO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(590, 11, 3150406, 'PIEDADE DOS GERAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(591, 11, 3150505, 'PIMENTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(592, 11, 3150539, 'PINGO-D\'ÁGUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(593, 11, 3150570, 'PINTÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(594, 11, 3150604, 'PIRACEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(595, 11, 3150703, 'PIRAJUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(596, 11, 3150802, 'PIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(597, 11, 3150901, 'PIRANGUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(598, 11, 3151008, 'PIRANGUINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(599, 11, 3151107, 'PIRAPETINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(600, 11, 3151206, 'PIRAPORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(601, 11, 3151305, 'PIRAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(602, 11, 3151404, 'PITANGUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(603, 11, 3151503, 'PIUMHI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(604, 11, 3151602, 'PLANURA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(605, 11, 3151701, 'POÇO FUNDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(606, 11, 3151800, 'POÇOS DE CALDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(607, 11, 3151909, 'POCRANE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(608, 11, 3152006, 'POMPÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(609, 11, 3152105, 'PONTE NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(610, 11, 3152131, 'PONTO CHIQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(611, 11, 3152170, 'PONTO DOS VOLANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(612, 11, 3152204, 'PORTEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(613, 11, 3152303, 'PORTO FIRME', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(614, 11, 3152402, 'POTÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(615, 11, 3152501, 'POUSO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(616, 11, 3152600, 'POUSO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(617, 11, 3152709, 'PRADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(618, 11, 3152808, 'PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(619, 11, 3152907, 'PRATÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(620, 11, 3153004, 'PRATINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(621, 11, 3153103, 'PRESIDENTE BERNARDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(622, 11, 3153202, 'PRESIDENTE JUSCELINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(623, 11, 3153301, 'PRESIDENTE KUBITSCHEK', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(624, 11, 3153400, 'PRESIDENTE OLEGÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(625, 11, 3153608, 'PRUDENTE DE MORAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(626, 11, 3153707, 'QUARTEL GERAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(627, 11, 3153806, 'QUELUZITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(628, 11, 3153905, 'RAPOSOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(629, 11, 3154002, 'RAUL SOARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(630, 11, 3154101, 'RECREIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(631, 11, 3154150, 'REDUTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(632, 11, 3154200, 'RESENDE COSTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(633, 11, 3154309, 'RESPLENDOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(634, 11, 3154408, 'RESSAQUINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(635, 11, 3154457, 'RIACHINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(636, 11, 3154507, 'RIACHO DOS MACHADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(637, 11, 3154606, 'RIBEIRÃO DAS NEVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(638, 11, 3154705, 'RIBEIRÃO VERMELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(639, 11, 3154804, 'RIO ACIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(640, 11, 3154903, 'RIO CASCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(641, 11, 3155108, 'RIO DO PRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(642, 11, 3155009, 'RIO DOCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(643, 11, 3155207, 'RIO ESPERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(644, 11, 3155306, 'RIO MANSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(645, 11, 3155405, 'RIO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(646, 11, 3155504, 'RIO PARANAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(647, 11, 3155603, 'RIO PARDO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(648, 11, 3155702, 'RIO PIRACICABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(649, 11, 3155801, 'RIO POMBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(650, 11, 3155900, 'RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(651, 11, 3156007, 'RIO VERMELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(652, 11, 3156106, 'RITÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(653, 11, 3156205, 'ROCHEDO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(654, 11, 3156304, 'RODEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(655, 11, 3156403, 'ROMARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(656, 11, 3156452, 'ROSÁRIO DA LIMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(657, 11, 3156502, 'RUBELITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(658, 11, 3156601, 'RUBIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(659, 11, 3156700, 'SABARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(660, 11, 3156809, 'SABINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(661, 11, 3156908, 'SACRAMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(662, 11, 3157005, 'SALINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(663, 11, 3157104, 'SALTO DA DIVISA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(664, 11, 3157203, 'SANTA BÁRBARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(665, 11, 3157252, 'SANTA BÁRBARA DO LESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(666, 11, 3157278, 'SANTA BÁRBARA DO MONTE VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(667, 11, 3157302, 'SANTA BÁRBARA DO TUGÚRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(668, 11, 3157336, 'SANTA CRUZ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(669, 11, 3157377, 'SANTA CRUZ DE SALINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(670, 11, 3157401, 'SANTA CRUZ DO ESCALVADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(671, 11, 3157500, 'SANTA EFIGÊNIA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(672, 11, 3157609, 'SANTA FÉ DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(673, 11, 3157658, 'SANTA HELENA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(674, 11, 3157708, 'SANTA JULIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(675, 11, 3157807, 'SANTA LUZIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(676, 11, 3157906, 'SANTA MARGARIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(677, 11, 3158003, 'SANTA MARIA DE ITABIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(678, 11, 3158102, 'SANTA MARIA DO SALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(679, 11, 3158201, 'SANTA MARIA DO SUAÇUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(680, 11, 3159209, 'SANTA RITA DE CALDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(681, 11, 3159407, 'SANTA RITA DE IBITIPOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(682, 11, 3159308, 'SANTA RITA DE JACUTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(683, 11, 3159357, 'SANTA RITA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(684, 11, 3159506, 'SANTA RITA DO ITUETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(685, 11, 3159605, 'SANTA RITA DO SAPUCAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(686, 11, 3159704, 'SANTA ROSA DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(687, 11, 3159803, 'SANTA VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(688, 11, 3158300, 'SANTANA DA VARGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(689, 11, 3158409, 'SANTANA DE CATAGUASES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(690, 11, 3158508, 'SANTANA DE PIRAPAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(691, 11, 3158607, 'SANTANA DO DESERTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(692, 11, 3158706, 'SANTANA DO GARAMBÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(693, 11, 3158805, 'SANTANA DO JACARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(694, 11, 3158904, 'SANTANA DO MANHUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(695, 11, 3158953, 'SANTANA DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(696, 11, 3159001, 'SANTANA DO RIACHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(697, 11, 3159100, 'SANTANA DOS MONTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(698, 11, 3159902, 'SANTO ANTÔNIO DO AMPARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(699, 11, 3160009, 'SANTO ANTÔNIO DO AVENTUREIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(700, 11, 3160108, 'SANTO ANTÔNIO DO GRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(701, 11, 3160207, 'SANTO ANTÔNIO DO ITAMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(702, 11, 3160306, 'SANTO ANTÔNIO DO JACINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(703, 11, 3160405, 'SANTO ANTÔNIO DO MONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(704, 11, 3160454, 'SANTO ANTÔNIO DO RETIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(705, 11, 3160504, 'SANTO ANTÔNIO DO RIO ABAIXO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(706, 11, 3160603, 'SANTO HIPÓLITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(707, 11, 3160702, 'SANTOS DUMONT', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(708, 11, 3160801, 'SÃO BENTO ABADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(709, 11, 3160900, 'SÃO BRÁS DO SUAÇUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(710, 11, 3160959, 'SÃO DOMINGOS DAS DORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(711, 11, 3161007, 'SÃO DOMINGOS DO PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(712, 11, 3161056, 'SÃO FÉLIX DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(713, 11, 3161106, 'SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(714, 11, 3161205, 'SÃO FRANCISCO DE PAULA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(715, 11, 3161304, 'SÃO FRANCISCO DE SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(716, 11, 3161403, 'SÃO FRANCISCO DO GLÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(717, 11, 3161502, 'SÃO GERALDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(718, 11, 3161601, 'SÃO GERALDO DA PIEDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(719, 11, 3161650, 'SÃO GERALDO DO BAIXIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(720, 11, 3161700, 'SÃO GONÇALO DO ABAETÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(721, 11, 3161809, 'SÃO GONÇALO DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(722, 11, 3161908, 'SÃO GONÇALO DO RIO ABAIXO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(723, 11, 3125507, 'SÃO GONÇALO DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(724, 11, 3162005, 'SÃO GONÇALO DO SAPUCAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(725, 11, 3162104, 'SÃO GOTARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(726, 11, 3162203, 'SÃO JOÃO BATISTA DO GLÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(727, 11, 3162252, 'SÃO JOÃO DA LAGOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(728, 11, 3162302, 'SÃO JOÃO DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(729, 11, 3162401, 'SÃO JOÃO DA PONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(730, 11, 3162450, 'SÃO JOÃO DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(731, 11, 3162500, 'SÃO JOÃO DEL REI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(732, 11, 3162559, 'SÃO JOÃO DO MANHUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(733, 11, 3162575, 'SÃO JOÃO DO MANTENINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(734, 11, 3162609, 'SÃO JOÃO DO ORIENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(735, 11, 3162658, 'SÃO JOÃO DO PACUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(736, 11, 3162708, 'SÃO JOÃO DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(737, 11, 3162807, 'SÃO JOÃO EVANGELISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(738, 11, 3162906, 'SÃO JOÃO NEPOMUCENO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(739, 11, 3162922, 'SÃO JOAQUIM DE BICAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(740, 11, 3162948, 'SÃO JOSÉ DA BARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(741, 11, 3162955, 'SÃO JOSÉ DA LAPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(742, 11, 3163003, 'SÃO JOSÉ DA SAFIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(743, 11, 3163102, 'SÃO JOSÉ DA VARGINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(744, 11, 3163201, 'SÃO JOSÉ DO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(745, 11, 3163300, 'SÃO JOSÉ DO DIVINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(746, 11, 3163409, 'SÃO JOSÉ DO GOIABAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(747, 11, 3163508, 'SÃO JOSÉ DO JACURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(748, 11, 3163607, 'SÃO JOSÉ DO MANTIMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(749, 11, 3163706, 'SÃO LOURENÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(750, 11, 3163805, 'SÃO MIGUEL DO ANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(751, 11, 3163904, 'SÃO PEDRO DA UNIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(752, 11, 3164100, 'SÃO PEDRO DO SUAÇUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(753, 11, 3164001, 'SÃO PEDRO DOS FERROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(754, 11, 3164209, 'SÃO ROMÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(755, 11, 3164308, 'SÃO ROQUE DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(756, 11, 3164407, 'SÃO SEBASTIÃO DA BELA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(757, 11, 3164431, 'SÃO SEBASTIÃO DA VARGEM ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(758, 11, 3164472, 'SÃO SEBASTIÃO DO ANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(759, 11, 3164506, 'SÃO SEBASTIÃO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(760, 11, 3164605, 'SÃO SEBASTIÃO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(761, 11, 3164704, 'SÃO SEBASTIÃO DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(762, 11, 3164803, 'SÃO SEBASTIÃO DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(763, 11, 3164902, 'SÃO SEBASTIÃO DO RIO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(764, 11, 3165206, 'SÃO THOMÉ DAS LETRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(765, 11, 3165008, 'SÃO TIAGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(766, 11, 3165107, 'SÃO TOMÁS DE AQUINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(767, 11, 3165305, 'SÃO VICENTE DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(768, 11, 3165404, 'SAPUCAÍ-MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(769, 11, 3165503, 'SARDOÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(770, 11, 3165537, 'SARZEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(771, 11, 3165560, 'SEM-PEIXE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(772, 11, 3165578, 'SENADOR AMARAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(773, 11, 3165602, 'SENADOR CORTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(774, 11, 3165701, 'SENADOR FIRMINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(775, 11, 3165800, 'SENADOR JOSÉ BENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(776, 11, 3165909, 'SENADOR MODESTINO GONÇALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(777, 11, 3166006, 'SENHORA DE OLIVEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(778, 11, 3166105, 'SENHORA DO PORTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(779, 11, 3166204, 'SENHORA DOS REMÉDIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(780, 11, 3166303, 'SERICITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(781, 11, 3166402, 'SERITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(782, 11, 3166501, 'SERRA AZUL DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(783, 11, 3166600, 'SERRA DA SAUDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(784, 11, 3166808, 'SERRA DO SALITRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(785, 11, 3166709, 'SERRA DOS AIMORÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(786, 11, 3166907, 'SERRANIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(787, 11, 3166956, 'SERRANÓPOLIS DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(788, 11, 3167004, 'SERRANOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(789, 11, 3167103, 'SERRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(790, 11, 3167202, 'SETE LAGOAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(791, 11, 3165552, 'SETUBINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(792, 11, 3167301, 'SILVEIRÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(793, 11, 3167400, 'SILVIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(794, 11, 3167509, 'SIMÃO PEREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(795, 11, 3167608, 'SIMONÉSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(796, 11, 3167707, 'SOBRÁLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(797, 11, 3167806, 'SOLEDADE DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(798, 11, 3167905, 'TABULEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(799, 11, 3168002, 'TAIOBEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(800, 11, 3168051, 'TAPARUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(801, 11, 3168101, 'TAPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(802, 11, 3168200, 'TAPIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(803, 11, 3168309, 'TAQUARAÇU DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(804, 11, 3168408, 'TARUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(805, 11, 3168507, 'TEIXEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(806, 11, 3168606, 'TEÓFILO OTONI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(807, 11, 3168705, 'TIMÓTEO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(808, 11, 3168804, 'TIRADENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(809, 11, 3168903, 'TIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(810, 11, 3169000, 'TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(811, 11, 3169059, 'TOCOS DO MOJI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(812, 11, 3169109, 'TOLEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(813, 11, 3169208, 'TOMBOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(814, 11, 3169307, 'TRÊS CORAÇÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(815, 11, 3169356, 'TRÊS MARIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(816, 11, 3169406, 'TRÊS PONTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(817, 11, 3169505, 'TUMIRITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(818, 11, 3169604, 'TUPACIGUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(819, 11, 3169703, 'TURMALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(820, 11, 3169802, 'TURVOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(821, 11, 3169901, 'UBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(822, 11, 3170008, 'UBAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(823, 11, 3170057, 'UBAPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(824, 11, 3170107, 'UBERABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(825, 11, 3170206, 'UBERLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(826, 11, 3170305, 'UMBURATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(827, 11, 3170404, 'UNAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(828, 11, 3170438, 'UNIÃO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(829, 11, 3170479, 'URUANA DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(830, 11, 3170503, 'URUCÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(831, 11, 3170529, 'URUCUIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(832, 11, 3170578, 'VARGEM ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(833, 11, 3170602, 'VARGEM BONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(834, 11, 3170651, 'VARGEM GRANDE DO RIO PARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(835, 11, 3170701, 'VARGINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(836, 11, 3170750, 'VARJÃO DE MINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(837, 11, 3170800, 'VÁRZEA DA PALMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(838, 11, 3170909, 'VARZELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(839, 11, 3171006, 'VAZANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(840, 11, 3171030, 'VERDELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(841, 11, 3171071, 'VEREDINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(842, 11, 3171105, 'VERÍSSIMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(843, 11, 3171154, 'VERMELHO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(844, 11, 3171204, 'VESPASIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(845, 11, 3171303, 'VIÇOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(846, 11, 3171402, 'VIEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(847, 11, 3171600, 'VIRGEM DA LAPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(848, 11, 3171709, 'VIRGÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(849, 11, 3171808, 'VIRGINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(850, 11, 3171907, 'VIRGOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(851, 11, 3172004, 'VISCONDE DO RIO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(852, 11, 3172103, 'VOLTA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(853, 11, 3172202, 'WENCESLAU BRAZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(854, 1, 1200013, 'ACRELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(855, 1, 1200054, 'ASSIS BRASIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(856, 1, 1200104, 'BRASILÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(857, 1, 1200138, 'BUJARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(858, 1, 1200179, 'CAPIXABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(859, 1, 1200203, 'CRUZEIRO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(860, 1, 1200252, 'EPITACIOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(861, 1, 1200302, 'FEIJÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(862, 1, 1200328, 'JORDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(863, 1, 1200336, 'MÂNCIO LIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(864, 1, 1200344, 'MANOEL URBANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(865, 1, 1200351, 'MARECHAL THAUMATURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(866, 1, 1200385, 'PLÁCIDO DE CASTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(867, 1, 1200807, 'PORTO ACRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(868, 1, 1200393, 'PORTO WALTER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(869, 1, 1200401, 'RIO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(870, 1, 1200427, 'RODRIGUES ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(871, 1, 1200435, 'SANTA ROSA DO PURUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(872, 1, 1200500, 'SENA MADUREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(873, 1, 1200450, 'SENADOR GUIOMARD', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(874, 1, 1200609, 'TARAUACÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(875, 1, 1200708, 'XAPURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(876, 2, 2700102, 'ÁGUA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(877, 2, 2700201, 'ANADIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(878, 2, 2700300, 'ARAPIRACA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(879, 2, 2700409, 'ATALAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(880, 2, 2700508, 'BARRA DE SANTO ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(881, 2, 2700607, 'BARRA DE SÃO MIGUEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(882, 2, 2700706, 'BATALHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(883, 2, 2700805, 'BELÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(884, 2, 2700904, 'BELO MONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(885, 2, 2701001, 'BOCA DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(886, 2, 2701100, 'BRANQUINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(887, 2, 2701209, 'CACIMBINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(888, 2, 2701308, 'CAJUEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(889, 2, 2701357, 'CAMPESTRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(890, 2, 2701407, 'CAMPO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(891, 2, 2701506, 'CAMPO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(892, 2, 2701605, 'CANAPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(893, 2, 2701704, 'CAPELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(894, 2, 2701803, 'CARNEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(895, 2, 2701902, 'CHÃ PRETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(896, 2, 2702009, 'COITÉ DO NÓIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(897, 2, 2702108, 'COLÔNIA LEOPOLDINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(898, 2, 2702207, 'COQUEIRO SECO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(899, 2, 2702306, 'CORURIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(900, 2, 2702355, 'CRAÍBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(901, 2, 2702405, 'DELMIRO GOUVEIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(902, 2, 2702504, 'DOIS RIACHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(903, 2, 2702553, 'ESTRELA DE ALAGOAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(904, 2, 2702603, 'FEIRA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(905, 2, 2702702, 'FELIZ DESERTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(906, 2, 2702801, 'FLEXEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(907, 2, 2702900, 'GIRAU DO PONCIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(908, 2, 2703007, 'IBATEGUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(909, 2, 2703106, 'IGACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(910, 2, 2703205, 'IGREJA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(911, 2, 2703304, 'INHAPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(912, 2, 2703403, 'JACARÉ DOS HOMENS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(913, 2, 2703502, 'JACUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(914, 2, 2703601, 'JAPARATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(915, 2, 2703700, 'JARAMATAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(916, 2, 2703759, 'JEQUIÁ DA PRAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(917, 2, 2703809, 'JOAQUIM GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(918, 2, 2703908, 'JUNDIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(919, 2, 2704005, 'JUNQUEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(920, 2, 2704104, 'LAGOA DA CANOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(921, 2, 2704203, 'LIMOEIRO DE ANADIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(922, 2, 2704302, 'MACEIÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(923, 2, 2704401, 'MAJOR ISIDORO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(924, 2, 2704906, 'MAR VERMELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(925, 2, 2704500, 'MARAGOGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(926, 2, 2704609, 'MARAVILHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(927, 2, 2704708, 'MARECHAL DEODORO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(928, 2, 2704807, 'MARIBONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(929, 2, 2705002, 'MATA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(930, 2, 2705101, 'MATRIZ DE CAMARAGIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(931, 2, 2705200, 'MESSIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(932, 2, 2705309, 'MINADOR DO NEGRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(933, 2, 2705408, 'MONTEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(934, 2, 2705507, 'MURICI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(935, 2, 2705606, 'NOVO LINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(936, 2, 2705705, 'OLHO D\'ÁGUA DAS FLORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(937, 2, 2705804, 'OLHO D\'ÁGUA DO CASADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(938, 2, 2705903, 'OLHO D\'ÁGUA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(939, 2, 2706000, 'OLIVENÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(940, 2, 2706109, 'OURO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(941, 2, 2706208, 'PALESTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(942, 2, 2706307, 'PALMEIRA DOS ÍNDIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(943, 2, 2706406, 'PÃO DE AÇÚCAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(944, 2, 2706422, 'PARICONHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(945, 2, 2706448, 'PARIPUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(946, 2, 2706505, 'PASSO DE CAMARAGIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(947, 2, 2706604, 'PAULO JACINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(948, 2, 2706703, 'PENEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(949, 2, 2706802, 'PIAÇABUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(950, 2, 2706901, 'PILAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(951, 2, 2707008, 'PINDOBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(952, 2, 2707107, 'PIRANHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(953, 2, 2707206, 'POÇO DAS TRINCHEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(954, 2, 2707305, 'PORTO CALVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(955, 2, 2707404, 'PORTO DE PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(956, 2, 2707503, 'PORTO REAL DO COLÉGIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(957, 2, 2707602, 'QUEBRANGULO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(958, 2, 2707701, 'RIO LARGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(959, 2, 2707800, 'ROTEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(960, 2, 2707909, 'SANTA LUZIA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(961, 2, 2708006, 'SANTANA DO IPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(962, 2, 2708105, 'SANTANA DO MUNDAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(963, 2, 2708204, 'SÃO BRÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(964, 2, 2708303, 'SÃO JOSÉ DA LAJE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(965, 2, 2708402, 'SÃO JOSÉ DA TAPERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(966, 2, 2708501, 'SÃO LUÍS DO QUITUNDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(967, 2, 2708600, 'SÃO MIGUEL DOS CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(968, 2, 2708709, 'SÃO MIGUEL DOS MILAGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(969, 2, 2708808, 'SÃO SEBASTIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(970, 2, 2708907, 'SATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(971, 2, 2708956, 'SENADOR RUI PALMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(972, 2, 2709004, 'TANQUE D\'ARCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(973, 2, 2709103, 'TAQUARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(974, 2, 2709152, 'TEOTÔNIO VILELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(975, 2, 2709202, 'TRAIPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(976, 2, 2709301, 'UNIÃO DOS PALMARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(977, 2, 2709400, 'VIÇOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(978, 3, 1300029, 'ALVARÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(979, 3, 1300060, 'AMATURÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(980, 3, 1300086, 'ANAMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(981, 3, 1300102, 'ANORI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(982, 3, 1300144, 'APUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(983, 3, 1300201, 'ATALAIA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(984, 3, 1300300, 'AUTAZES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(985, 3, 1300409, 'BARCELOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(986, 3, 1300508, 'BARREIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(987, 3, 1300607, 'BENJAMIN CONSTANT', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(988, 3, 1300631, 'BERURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(989, 3, 1300680, 'BOA VISTA DO RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(990, 3, 1300706, 'BOCA DO ACRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(991, 3, 1300805, 'BORBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(992, 3, 1300839, 'CAAPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(993, 3, 1300904, 'CANUTAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(994, 3, 1301001, 'CARAUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(995, 3, 1301100, 'CAREIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(996, 3, 1301159, 'CAREIRO DA VÁRZEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(997, 3, 1301209, 'COARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(998, 3, 1301308, 'CODAJÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(999, 3, 1301407, 'EIRUNEPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1000, 3, 1301506, 'ENVIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1001, 3, 1301605, 'FONTE BOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1002, 3, 1301654, 'GUAJARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1003, 3, 1301704, 'HUMAITÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1004, 3, 1301803, 'IPIXUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1005, 3, 1301852, 'IRANDUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1006, 3, 1301902, 'ITACOATIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1007, 3, 1301951, 'ITAMARATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1008, 3, 1302009, 'ITAPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1009, 3, 1302108, 'JAPURÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1010, 3, 1302207, 'JURUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1011, 3, 1302306, 'JUTAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1012, 3, 1302405, 'LÁBREA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1013, 3, 1302504, 'MANACAPURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1014, 3, 1302553, 'MANAQUIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1015, 3, 1302603, 'MANAUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1016, 3, 1302702, 'MANICORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1017, 3, 1302801, 'MARAÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1018, 3, 1302900, 'MAUÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1019, 3, 1303007, 'NHAMUNDÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1020, 3, 1303106, 'NOVA OLINDA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1021, 3, 1303205, 'NOVO AIRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1022, 3, 1303304, 'NOVO ARIPUANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1023, 3, 1303403, 'PARINTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1024, 3, 1303502, 'PAUINI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1025, 3, 1303536, 'PRESIDENTE FIGUEIREDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1026, 3, 1303569, 'RIO PRETO DA EVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1027, 3, 1303601, 'SANTA ISABEL DO RIO NEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1028, 3, 1303700, 'SANTO ANTÔNIO DO IÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1029, 3, 1303809, 'SÃO GABRIEL DA CACHOEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1030, 3, 1303908, 'SÃO PAULO DE OLIVENÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1031, 3, 1303957, 'SÃO SEBASTIÃO DO UATUMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1032, 3, 1304005, 'SILVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1033, 3, 1304062, 'TABATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1034, 3, 1304104, 'TAPAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1035, 3, 1304203, 'TEFÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1036, 3, 1304237, 'TONANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1037, 3, 1304260, 'UARINI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1038, 3, 1304302, 'URUCARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1039, 3, 1304401, 'URUCURITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1040, 4, 1600105, 'AMAPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1041, 4, 1600204, 'CALÇOENE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1042, 4, 1600212, 'CUTIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1043, 4, 1600238, 'FERREIRA GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1044, 4, 1600253, 'ITAUBAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1045, 4, 1600279, 'LARANJAL DO JARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1046, 4, 1600303, 'MACAPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1047, 4, 1600402, 'MAZAGÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1048, 4, 1600501, 'OIAPOQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1049, 4, 1600154, 'PEDRA BRANCA DO AMAPARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1050, 4, 1600535, 'PORTO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1051, 4, 1600550, 'PRACUÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1052, 4, 1600600, 'SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1053, 4, 1600055, 'SERRA DO NAVIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1054, 4, 1600709, 'TARTARUGALZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1055, 4, 1600808, 'VITÓRIA DO JARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1056, 5, 2900108, 'ABAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1057, 5, 2900207, 'ABARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1058, 5, 2900306, 'ACAJUTIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1059, 5, 2900355, 'ADUSTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1060, 5, 2900405, 'ÁGUA FRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1061, 5, 2900603, 'AIQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1062, 5, 2900702, 'ALAGOINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1063, 5, 2900801, 'ALCOBAÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1064, 5, 2900900, 'ALMADINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1065, 5, 2901007, 'AMARGOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1066, 5, 2901106, 'AMÉLIA RODRIGUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1067, 5, 2901155, 'AMÉRICA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1068, 5, 2901205, 'ANAGÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1069, 5, 2901304, 'ANDARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1070, 5, 2901353, 'ANDORINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1071, 5, 2901403, 'ANGICAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1072, 5, 2901502, 'ANGUERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1073, 5, 2901601, 'ANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1074, 5, 2901700, 'ANTÔNIO CARDOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1075, 5, 2901809, 'ANTÔNIO GONÇALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1076, 5, 2901908, 'APORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1077, 5, 2901957, 'APUAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1078, 5, 2902054, 'ARAÇAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1079, 5, 2902005, 'ARACATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1080, 5, 2902104, 'ARACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1081, 5, 2902203, 'ARAMARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1082, 5, 2902252, 'ARATACA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1083, 5, 2902302, 'ARATUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1084, 5, 2902401, 'AURELINO LEAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1085, 5, 2902500, 'BAIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1086, 5, 2902609, 'BAIXA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1087, 5, 2902658, 'BANZAÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1088, 5, 2902708, 'BARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1089, 5, 2902807, 'BARRA DA ESTIVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1090, 5, 2902906, 'BARRA DO CHOÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1091, 5, 2903003, 'BARRA DO MENDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1092, 5, 2903102, 'BARRA DO ROCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1093, 5, 2903201, 'BARREIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1094, 5, 2903235, 'BARRO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1095, 5, 2903300, 'BARRO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1096, 5, 2903276, 'BARROCAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1097, 5, 2903409, 'BELMONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1098, 5, 2903508, 'BELO CAMPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1099, 5, 2903607, 'BIRITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1100, 5, 2903706, 'BOA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1101, 5, 2903805, 'BOA VISTA DO TUPIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1102, 5, 2903904, 'BOM JESUS DA LAPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1103, 5, 2903953, 'BOM JESUS DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1104, 5, 2904001, 'BONINAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1105, 5, 2904050, 'BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1106, 5, 2904100, 'BOQUIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1107, 5, 2904209, 'BOTUPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1108, 5, 2904308, 'BREJÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1109, 5, 2904407, 'BREJOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1110, 5, 2904506, 'BROTAS DE MACAÚBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1111, 5, 2904605, 'BRUMADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1112, 5, 2904704, 'BUERAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1113, 5, 2904753, 'BURITIRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1114, 5, 2904803, 'CAATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1115, 5, 2904852, 'CABACEIRAS DO PARAGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1116, 5, 2904902, 'CACHOEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1117, 5, 2905008, 'CACULÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1118, 5, 2905107, 'CAÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1119, 5, 2905156, 'CAETANOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1120, 5, 2905206, 'CAETITÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1121, 5, 2905305, 'CAFARNAUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1122, 5, 2905404, 'CAIRU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1123, 5, 2905503, 'CALDEIRÃO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1124, 5, 2905602, 'CAMACA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1125, 5, 2905701, 'CAMAÇARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1126, 5, 2905800, 'CAMAMU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1127, 5, 2905909, 'CAMPO ALEGRE DE LOURDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1128, 5, 2906006, 'CAMPO FORMOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1129, 5, 2906105, 'CANÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1130, 5, 2906204, 'CANARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1131, 5, 2906303, 'CANAVIEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1132, 5, 2906402, 'CANDEAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1133, 5, 2906501, 'CANDEIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1134, 5, 2906600, 'CANDIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1135, 5, 2906709, 'CÂNDIDO SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1136, 5, 2906808, 'CANSANÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1137, 5, 2906824, 'CANUDOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1138, 5, 2906857, 'CAPELA DO ALTO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1139, 5, 2906873, 'CAPIM GROSSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1140, 5, 2906899, 'CARAÍBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1141, 5, 2906907, 'CARAVELAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1142, 5, 2907004, 'CARDEAL DA SILVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1143, 5, 2907103, 'CARINHANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1144, 5, 2907202, 'CASA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1145, 5, 2907301, 'CASTRO ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1146, 5, 2907400, 'CATOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1147, 5, 2907509, 'CATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1148, 5, 2907558, 'CATURAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1149, 5, 2907608, 'CENTRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1150, 5, 2907707, 'CHORROCHÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1151, 5, 2907806, 'CÍCERO DANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1152, 5, 2907905, 'CIPÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1153, 5, 2908002, 'COARACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1154, 5, 2908101, 'COCOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1155, 5, 2908200, 'CONCEIÇÃO DA FEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1156, 5, 2908309, 'CONCEIÇÃO DO ALMEIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1157, 5, 2908408, 'CONCEIÇÃO DO COITÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1158, 5, 2908507, 'CONCEIÇÃO DO JACUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1159, 5, 2908606, 'CONDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1160, 5, 2908705, 'CONDEÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1161, 5, 2908804, 'CONTENDAS DO SINCORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1162, 5, 2908903, 'CORAÇÃO DE MARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1163, 5, 2909000, 'CORDEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1164, 5, 2909109, 'CORIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1165, 5, 2909208, 'CORONEL JOÃO SÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1166, 5, 2909307, 'CORRENTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1167, 5, 2909406, 'COTEGIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1168, 5, 2909505, 'CRAVOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1169, 5, 2909604, 'CRISÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1170, 5, 2909703, 'CRISTÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1171, 5, 2909802, 'CRUZ DAS ALMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1172, 5, 2909901, 'CURAÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1173, 5, 2910008, 'DÁRIO MEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1174, 5, 2910057, 'DIAS D\'ÁVILA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1175, 5, 2910107, 'DOM BASÍLIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1176, 5, 2910206, 'DOM MACEDO COSTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1177, 5, 2910305, 'ELÍSIO MEDRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1178, 5, 2910404, 'ENCRUZILHADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1179, 5, 2910503, 'ENTRE RIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1180, 5, 2900504, 'ÉRICO CARDOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1181, 5, 2910602, 'ESPLANADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1182, 5, 2910701, 'EUCLIDES DA CUNHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1183, 5, 2910727, 'EUNÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1184, 5, 2910750, 'FÁTIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1185, 5, 2910776, 'FEIRA DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1186, 5, 2910800, 'FEIRA DE SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1187, 5, 2910859, 'FILADÉLFIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1188, 5, 2910909, 'FIRMINO ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1189, 5, 2911006, 'FLORESTA AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1190, 5, 2911105, 'FORMOSA DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1191, 5, 2911204, 'GANDU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1192, 5, 2911253, 'GAVIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1193, 5, 2911303, 'GENTIO DO OURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1194, 5, 2911402, 'GLÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1195, 5, 2911501, 'GONGOGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1196, 5, 2911600, 'GOVERNADOR MANGABEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1197, 5, 2911659, 'GUAJERU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1198, 5, 2911709, 'GUANAMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1199, 5, 2911808, 'GUARATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1200, 5, 2911857, 'HELIÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1201, 5, 2911907, 'IAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1202, 5, 2912004, 'IBIASSUCÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1203, 5, 2912103, 'IBICARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1204, 5, 2912202, 'IBICOARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1205, 5, 2912301, 'IBICUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1206, 5, 2912400, 'IBIPEBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1207, 5, 2912509, 'IBIPITANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1208, 5, 2912608, 'IBIQUERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1209, 5, 2912707, 'IBIRAPITANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1210, 5, 2912806, 'IBIRAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1211, 5, 2912905, 'IBIRATAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1212, 5, 2913002, 'IBITIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1213, 5, 2913101, 'IBITITÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1214, 5, 2913200, 'IBOTIRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1215, 5, 2913309, 'ICHU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1216, 5, 2913408, 'IGAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1217, 5, 2913457, 'IGRAPIÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1218, 5, 2913507, 'IGUAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1219, 5, 2913606, 'ILHÉUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1220, 5, 2913705, 'INHAMBUPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1221, 5, 2913804, 'IPECAETÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1222, 5, 2913903, 'IPIAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1223, 5, 2914000, 'IPIRÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1224, 5, 2914109, 'IPUPIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1225, 5, 2914208, 'IRAJUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1226, 5, 2914307, 'IRAMAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1227, 5, 2914406, 'IRAQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1228, 5, 2914505, 'IRARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1229, 5, 2914604, 'IRECÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1230, 5, 2914653, 'ITABELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1231, 5, 2914703, 'ITABERABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1232, 5, 2914802, 'ITABUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1233, 5, 2914901, 'ITACARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1234, 5, 2915007, 'ITAETÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1235, 5, 2915106, 'ITAGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1236, 5, 2915205, 'ITAGIBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1237, 5, 2915304, 'ITAGIMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1238, 5, 2915353, 'ITAGUAÇU DA BAHIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1239, 5, 2915403, 'ITAJU DO COLÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1240, 5, 2915502, 'ITAJUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1241, 5, 2915601, 'ITAMARAJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1242, 5, 2915700, 'ITAMARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1243, 5, 2915809, 'ITAMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1244, 5, 2915908, 'ITANAGRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1245, 5, 2916005, 'ITANHÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1246, 5, 2916104, 'ITAPARICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1247, 5, 2916203, 'ITAPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1248, 5, 2916302, 'ITAPEBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1249, 5, 2916401, 'ITAPETINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1250, 5, 2916500, 'ITAPICURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1251, 5, 2916609, 'ITAPITANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1252, 5, 2916708, 'ITAQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1253, 5, 2916807, 'ITARANTIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1254, 5, 2916856, 'ITATIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1255, 5, 2916906, 'ITIRUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1256, 5, 2917003, 'ITIÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1257, 5, 2917102, 'ITORORÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1258, 5, 2917201, 'ITUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1259, 5, 2917300, 'ITUBERÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1260, 5, 2917334, 'IUIÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1261, 5, 2917359, 'JABORANDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1262, 5, 2917409, 'JACARACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1263, 5, 2917508, 'JACOBINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1264, 5, 2917607, 'JAGUAQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1265, 5, 2917706, 'JAGUARARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1266, 5, 2917805, 'JAGUARIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1267, 5, 2917904, 'JANDAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1268, 5, 2918001, 'JEQUIÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1269, 5, 2918100, 'JEREMOABO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1270, 5, 2918209, 'JIQUIRIÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1271, 5, 2918308, 'JITAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1272, 5, 2918357, 'JOÃO DOURADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1273, 5, 2918407, 'JUAZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1274, 5, 2918456, 'JUCURUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1275, 5, 2918506, 'JUSSARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1276, 5, 2918555, 'JUSSARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1277, 5, 2918605, 'JUSSIAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1278, 5, 2918704, 'LAFAIETE COUTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1279, 5, 2918753, 'LAGOA REAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1280, 5, 2918803, 'LAJE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1281, 5, 2918902, 'LAJEDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1282, 5, 2919009, 'LAJEDINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1283, 5, 2919058, 'LAJEDO DO TABOCAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1284, 5, 2919108, 'LAMARÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1285, 5, 2919157, 'LAPÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1286, 5, 2919207, 'LAURO DE FREITAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1287, 5, 2919306, 'LENÇÓIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1288, 5, 2919405, 'LICÍNIO DE ALMEIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1289, 5, 2919504, 'LIVRAMENTO DE NOSSA SENHORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1290, 5, 2919553, 'LUÍS EDUARDO MAGALHÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1291, 5, 2919603, 'MACAJUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1292, 5, 2919702, 'MACARANI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1293, 5, 2919801, 'MACAÚBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1294, 5, 2919900, 'MACURURÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1295, 5, 2919926, 'MADRE DE DEUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1296, 5, 2919959, 'MAETINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1297, 5, 2920007, 'MAIQUINIQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1298, 5, 2920106, 'MAIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1299, 5, 2920205, 'MALHADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1300, 5, 2920304, 'MALHADA DE PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1301, 5, 2920403, 'MANOEL VITORINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1302, 5, 2920452, 'MANSIDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1303, 5, 2920502, 'MARACÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1304, 5, 2920601, 'MARAGOGIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1305, 5, 2920700, 'MARAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1306, 5, 2920809, 'MARCIONÍLIO SOUZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1307, 5, 2920908, 'MASCOTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1308, 5, 2921005, 'MATA DE SÃO JOÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1309, 5, 2921054, 'MATINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1310, 5, 2921104, 'MEDEIROS NETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1311, 5, 2921203, 'MIGUEL CALMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1312, 5, 2921302, 'MILAGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1313, 5, 2921401, 'MIRANGABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1314, 5, 2921450, 'MIRANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1315, 5, 2921500, 'MONTE SANTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1316, 5, 2921609, 'MORPARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1317, 5, 2921708, 'MORRO DO CHAPÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1318, 5, 2921807, 'MORTUGABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1319, 5, 2921906, 'MUCUGÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1320, 5, 2922003, 'MUCURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1321, 5, 2922052, 'MULUNGU DO MORRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1322, 5, 2922102, 'MUNDO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1323, 5, 2922201, 'MUNIZ FERREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1324, 5, 2922250, 'MUQUÉM DE SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1325, 5, 2922300, 'MURITIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1326, 5, 2922409, 'MUTUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1327, 5, 2922508, 'NAZARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1328, 5, 2922607, 'NILO PEÇANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1329, 5, 2922656, 'NORDESTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1330, 5, 2922706, 'NOVA CANAÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1331, 5, 2922730, 'NOVA FÁTIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1332, 5, 2922755, 'NOVA IBIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1333, 5, 2922805, 'NOVA ITARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1334, 5, 2922854, 'NOVA REDENÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1335, 5, 2922904, 'NOVA SOURE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1336, 5, 2923001, 'NOVA VIÇOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1337, 5, 2923035, 'NOVO HORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1338, 5, 2923050, 'NOVO TRIUNFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1339, 5, 2923100, 'OLINDINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1340, 5, 2923209, 'OLIVEIRA DOS BREJINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1341, 5, 2923308, 'OURIÇANGAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1342, 5, 2923357, 'OUROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1343, 5, 2923407, 'PALMAS DE MONTE ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1344, 5, 2923506, 'PALMEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1345, 5, 2923605, 'PARAMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1346, 5, 2923704, 'PARATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1347, 5, 2923803, 'PARIPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1348, 5, 2923902, 'PAU BRASIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1349, 5, 2924009, 'PAULO AFONSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1350, 5, 2924058, 'PÉ DE SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1351, 5, 2924108, 'PEDRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1352, 5, 2924207, 'PEDRO ALEXANDRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1353, 5, 2924306, 'PIATÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1354, 5, 2924405, 'PILÃO ARCADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1355, 5, 2924504, 'PINDAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1356, 5, 2924603, 'PINDOBAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1357, 5, 2924652, 'PINTADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1358, 5, 2924678, 'PIRAÍ DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1359, 5, 2924702, 'PIRIPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1360, 5, 2924801, 'PIRITIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1361, 5, 2924900, 'PLANALTINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1362, 5, 2925006, 'PLANALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1363, 5, 2925105, 'POÇÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1364, 5, 2925204, 'POJUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1365, 5, 2925253, 'PONTO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1366, 5, 2925303, 'PORTO SEGURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1367, 5, 2925402, 'POTIRAGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1368, 5, 2925501, 'PRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1369, 5, 2925600, 'PRESIDENTE DUTRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1370, 5, 2925709, 'PRESIDENTE JÂNIO QUADROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1371, 5, 2925758, 'PRESIDENTE TANCREDO NEVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1372, 5, 2925808, 'QUEIMADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1373, 5, 2925907, 'QUIJINGUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1374, 5, 2925931, 'QUIXABEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1375, 5, 2925956, 'RAFAEL JAMBEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1376, 5, 2926004, 'REMANSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1377, 5, 2926103, 'RETIROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1378, 5, 2926202, 'RIACHÃO DAS NEVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1379, 5, 2926301, 'RIACHÃO DO JACUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1380, 5, 2926400, 'RIACHO DE SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1381, 5, 2926509, 'RIBEIRA DO AMPARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1382, 5, 2926608, 'RIBEIRA DO POMBAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1383, 5, 2926657, 'RIBEIRÃO DO LARGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1384, 5, 2926707, 'RIO DE CONTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1385, 5, 2926806, 'RIO DO ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1386, 5, 2926905, 'RIO DO PIRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1387, 5, 2927002, 'RIO REAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1388, 5, 2927101, 'RODELAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1389, 5, 2927200, 'RUY BARBOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1390, 5, 2927309, 'SALINAS DA MARGARIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1391, 5, 2927408, 'SALVADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1392, 5, 2927507, 'SANTA BÁRBARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1393, 5, 2927606, 'SANTA BRÍGIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1394, 5, 2927705, 'SANTA CRUZ CABRÁLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1395, 5, 2927804, 'SANTA CRUZ DA VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1396, 5, 2927903, 'SANTA INÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1397, 5, 2928059, 'SANTA LUZIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1398, 5, 2928109, 'SANTA MARIA DA VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1399, 5, 2928406, 'SANTA RITA DE CÁSSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1400, 5, 2928505, 'SANTA TERESINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1401, 5, 2928000, 'SANTALUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1402, 5, 2928208, 'SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1403, 5, 2928307, 'SANTANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1404, 5, 2928604, 'SANTO AMARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1405, 5, 2928703, 'SANTO ANTÔNIO DE JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1406, 5, 2928802, 'SANTO ESTÊVÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1407, 5, 2928901, 'SÃO DESIDÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1408, 5, 2928950, 'SÃO DOMINGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1409, 5, 2929107, 'SÃO FELIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1410, 5, 2929008, 'SÃO FÉLIX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1411, 5, 2929057, 'SÃO FÉLIX DO CORIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1412, 5, 2929206, 'SÃO FRANCISCO DO CONDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1413, 5, 2929255, 'SÃO GABRIEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1414, 5, 2929305, 'SÃO GONÇALO DOS CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1415, 5, 2929354, 'SÃO JOSÉ DA VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1416, 5, 2929370, 'SÃO JOSÉ DO JACUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1417, 5, 2929404, 'SÃO MIGUEL DAS MATAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1418, 5, 2929503, 'SÃO SEBASTIÃO DO PASSÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1419, 5, 2929602, 'SAPEAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1420, 5, 2929701, 'SÁTIRO DIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1421, 5, 2929750, 'SAUBARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1422, 5, 2929800, 'SAÚDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1423, 5, 2929909, 'SEABRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1424, 5, 2930006, 'SEBASTIÃO LARANJEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1425, 5, 2930105, 'SENHOR DO BONFIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1426, 5, 2930204, 'SENTO SÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1427, 5, 2930154, 'SERRA DO RAMALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1428, 5, 2930303, 'SERRA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1429, 5, 2930402, 'SERRA PRETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1430, 5, 2930501, 'SERRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1431, 5, 2930600, 'SERROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1432, 5, 2930709, 'SIMÕES FILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1433, 5, 2930758, 'SÍTIO DO MATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1434, 5, 2930766, 'SÍTIO DO QUINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1435, 5, 2930774, 'SOBRADINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1436, 5, 2930808, 'SOUTO SOARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1437, 5, 2930907, 'TABOCAS DO BREJO VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1438, 5, 2931004, 'TANHAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1439, 5, 2931053, 'TANQUE NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1440, 5, 2931103, 'TANQUINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1441, 5, 2931202, 'TAPEROÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1442, 5, 2931301, 'TAPIRAMUTÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1443, 5, 2931350, 'TEIXEIRA DE FREITAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1444, 5, 2931400, 'TEODORO SAMPAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1445, 5, 2931509, 'TEOFILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1446, 5, 2931608, 'TEOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1447, 5, 2931707, 'TERRA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1448, 5, 2931806, 'TREMEDAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1449, 5, 2931905, 'TUCANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1450, 5, 2932002, 'UAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1451, 5, 2932101, 'UBAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1452, 5, 2932200, 'UBAITABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1453, 5, 2932309, 'UBATÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1454, 5, 2932408, 'UIBAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1455, 5, 2932457, 'UMBURANAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1456, 5, 2932507, 'UNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1457, 5, 2932606, 'URANDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1458, 5, 2932705, 'URUÇUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1459, 5, 2932804, 'UTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1460, 5, 2932903, 'VALENÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1461, 5, 2933000, 'VALENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1462, 5, 2933059, 'VÁRZEA DA ROÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1463, 5, 2933109, 'VÁRZEA DO POÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1464, 5, 2933158, 'VÁRZEA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1465, 5, 2933174, 'VARZEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1466, 5, 2933208, 'VERA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1467, 5, 2933257, 'VEREDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1468, 5, 2933307, 'VITÓRIA DA CONQUISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1469, 5, 2933406, 'WAGNER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1470, 5, 2933455, 'WANDERLEY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1471, 5, 2933505, 'WENCESLAU GUIMARÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1472, 5, 2933604, 'XIQUE-XIQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1473, 6, 2300101, 'ABAIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1474, 6, 2300150, 'ACARAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1475, 6, 2300200, 'ACARAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1476, 6, 2300309, 'ACOPIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1477, 6, 2300408, 'AIUABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1478, 6, 2300507, 'ALCÂNTARAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1479, 6, 2300606, 'ALTANEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1480, 6, 2300705, 'ALTO SANTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1481, 6, 2300754, 'AMONTADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1482, 6, 2300804, 'ANTONINA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1483, 6, 2300903, 'APUIARÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1484, 6, 2301000, 'AQUIRAZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1485, 6, 2301109, 'ARACATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1486, 6, 2301208, 'ARACOIABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1487, 6, 2301257, 'ARARENDÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1488, 6, 2301307, 'ARARIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1489, 6, 2301406, 'ARATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1490, 6, 2301505, 'ARNEIROZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1491, 6, 2301604, 'ASSARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1492, 6, 2301703, 'AURORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1493, 6, 2301802, 'BAIXIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1494, 6, 2301851, 'BANABUIÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1495, 6, 2301901, 'BARBALHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1496, 6, 2301950, 'BARREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1497, 6, 2302008, 'BARRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1498, 6, 2302057, 'BARROQUINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1499, 6, 2302107, 'BATURITÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1500, 6, 2302206, 'BEBERIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1501, 6, 2302305, 'BELA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1502, 6, 2302404, 'BOA VIAGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1503, 6, 2302503, 'BREJO SANTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1504, 6, 2302602, 'CAMOCIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1505, 6, 2302701, 'CAMPOS SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1506, 6, 2302800, 'CANINDÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1507, 6, 2302909, 'CAPISTRANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1508, 6, 2303006, 'CARIDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1509, 6, 2303105, 'CARIRÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1510, 6, 2303204, 'CARIRIAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1511, 6, 2303303, 'CARIÚS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1512, 6, 2303402, 'CARNAUBAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1513, 6, 2303501, 'CASCAVEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1514, 6, 2303600, 'CATARINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1515, 6, 2303659, 'CATUNDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1516, 6, 2303709, 'CAUCAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1517, 6, 2303808, 'CEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1518, 6, 2303907, 'CHAVAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1519, 6, 2303931, 'CHORÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1520, 6, 2303956, 'CHOROZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1521, 6, 2304004, 'COREAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1522, 6, 2304103, 'CRATEÚS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1523, 6, 2304202, 'CRATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1524, 6, 2304236, 'CROATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1525, 6, 2304251, 'CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1526, 6, 2304269, 'DEPUTADO IRAPUAN PINHEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1527, 6, 2304277, 'ERERÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1528, 6, 2304285, 'EUSÉBIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1529, 6, 2304301, 'FARIAS BRITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1530, 6, 2304350, 'FORQUILHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1531, 6, 2304400, 'FORTALEZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1532, 6, 2304459, 'FORTIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1533, 6, 2304509, 'FRECHEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1534, 6, 2304608, 'GENERAL SAMPAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1535, 6, 2304657, 'GRAÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1536, 6, 2304707, 'GRANJA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1537, 6, 2304806, 'GRANJEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1538, 6, 2304905, 'GROAÍRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1539, 6, 2304954, 'GUAIÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1540, 6, 2305001, 'GUARACIABA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1541, 6, 2305100, 'GUARAMIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1542, 6, 2305209, 'HIDROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1543, 6, 2305233, 'HORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1544, 6, 2305266, 'IBARETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1545, 6, 2305308, 'IBIAPINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1546, 6, 2305332, 'IBICUITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1547, 6, 2305357, 'ICAPUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1548, 6, 2305407, 'ICÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1549, 6, 2305506, 'IGUATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1550, 6, 2305605, 'INDEPENDÊNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1551, 6, 2305654, 'IPAPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1552, 6, 2305704, 'IPAUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1553, 6, 2305803, 'IPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1554, 6, 2305902, 'IPUEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1555, 6, 2306009, 'IRACEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1556, 6, 2306108, 'IRAUÇUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1557, 6, 2306207, 'ITAIÇABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1558, 6, 2306256, 'ITAITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1559, 6, 2306306, 'ITAPAGÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1560, 6, 2306405, 'ITAPIPOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1561, 6, 2306504, 'ITAPIÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1562, 6, 2306553, 'ITAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1563, 6, 2306603, 'ITATIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1564, 6, 2306702, 'JAGUARETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1565, 6, 2306801, 'JAGUARIBARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1566, 6, 2306900, 'JAGUARIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1567, 6, 2307007, 'JAGUARUANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1568, 6, 2307106, 'JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1569, 6, 2307205, 'JATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1570, 6, 2307254, 'JIJOCA DE JERICOACOARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1571, 6, 2307304, 'JUAZEIRO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1572, 6, 2307403, 'JUCÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1573, 6, 2307502, 'LAVRAS DA MANGABEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1574, 6, 2307601, 'LIMOEIRO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1575, 6, 2307635, 'MADALENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1576, 6, 2307650, 'MARACANAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1577, 6, 2307700, 'MARANGUAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1578, 6, 2307809, 'MARCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1579, 6, 2307908, 'MARTINÓPOLE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1580, 6, 2308005, 'MASSAPÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1581, 6, 2308104, 'MAURITI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1582, 6, 2308203, 'MERUOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1583, 6, 2308302, 'MILAGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1584, 6, 2308351, 'MILHÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1585, 6, 2308377, 'MIRAÍMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1586, 6, 2308401, 'MISSÃO VELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1587, 6, 2308500, 'MOMBAÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1588, 6, 2308609, 'MONSENHOR TABOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1589, 6, 2308708, 'MORADA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1590, 6, 2308807, 'MORAÚJO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1591, 6, 2308906, 'MORRINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1592, 6, 2309003, 'MUCAMBO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1593, 6, 2309102, 'MULUNGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1594, 6, 2309201, 'NOVA OLINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1595, 6, 2309300, 'NOVA RUSSAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1596, 6, 2309409, 'NOVO ORIENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1597, 6, 2309458, 'OCARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1598, 6, 2309508, 'ORÓS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1599, 6, 2309607, 'PACAJUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1600, 6, 2309706, 'PACATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1601, 6, 2309805, 'PACOTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1602, 6, 2309904, 'PACUJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1603, 6, 2310001, 'PALHANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1604, 6, 2310100, 'PALMÁCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1605, 6, 2310209, 'PARACURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1606, 6, 2310258, 'PARAIPABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1607, 6, 2310308, 'PARAMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1608, 6, 2310407, 'PARAMOTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1609, 6, 2310506, 'PEDRA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1610, 6, 2310605, 'PENAFORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1611, 6, 2310704, 'PENTECOSTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1612, 6, 2310803, 'PEREIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1613, 6, 2310852, 'PINDORETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1614, 6, 2310902, 'PIQUET CARNEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1615, 6, 2310951, 'PIRES FERREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1616, 6, 2311009, 'PORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1617, 6, 2311108, 'PORTEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1618, 6, 2311207, 'POTENGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1619, 6, 2311231, 'POTIRETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1620, 6, 2311264, 'QUITERIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1621, 6, 2311306, 'QUIXADÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1622, 6, 2311355, 'QUIXELÔ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1623, 6, 2311405, 'QUIXERAMOBIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1624, 6, 2311504, 'QUIXERÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1625, 6, 2311603, 'REDENÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1626, 6, 2311702, 'RERIUTABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1627, 6, 2311801, 'RUSSAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1628, 6, 2311900, 'SABOEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1629, 6, 2311959, 'SALITRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1630, 6, 2312205, 'SANTA QUITÉRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1631, 6, 2312007, 'SANTANA DO ACARAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1632, 6, 2312106, 'SANTANA DO CARIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1633, 6, 2312304, 'SÃO BENEDITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1634, 6, 2312403, 'SÃO GONÇALO DO AMARANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1635, 6, 2312502, 'SÃO JOÃO DO JAGUARIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1636, 6, 2312601, 'SÃO LUÍS DO CURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1637, 6, 2312700, 'SENADOR POMPEU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1638, 6, 2312809, 'SENADOR SÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1639, 6, 2312908, 'SOBRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1640, 6, 2313005, 'SOLONÓPOLE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1641, 6, 2313104, 'TABULEIRO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1642, 6, 2313203, 'TAMBORIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1643, 6, 2313252, 'TARRAFAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1644, 6, 2313302, 'TAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1645, 6, 2313351, 'TEJUÇUOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1646, 6, 2313401, 'TIANGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1647, 6, 2313500, 'TRAIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1648, 6, 2313559, 'TURURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1649, 6, 2313609, 'UBAJARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1650, 6, 2313708, 'UMARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1651, 6, 2313757, 'UMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1652, 6, 2313807, 'URUBURETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1653, 6, 2313906, 'URUOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1654, 6, 2313955, 'VARJOTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1655, 6, 2314003, 'VÁRZEA ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1656, 6, 2314102, 'VIÇOSA DO CEARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1657, 7, 5300108, 'BRASÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1658, 8, 3200102, 'AFONSO CLÁUDIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1659, 8, 3200169, 'ÁGUA DOCE DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1660, 8, 3200136, 'ÁGUIA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1661, 8, 3200201, 'ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1662, 8, 3200300, 'ALFREDO CHAVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1663, 8, 3200359, 'ALTO RIO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1664, 8, 3200409, 'ANCHIETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1665, 8, 3200508, 'APIACÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1666, 8, 3200607, 'ARACRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1667, 8, 3200706, 'ATILIO VIVACQUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1668, 8, 3200805, 'BAIXO GUANDU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1669, 8, 3200904, 'BARRA DE SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1670, 8, 3201001, 'BOA ESPERANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1671, 8, 3201100, 'BOM JESUS DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1672, 8, 3201159, 'BREJETUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1673, 8, 3201209, 'CACHOEIRO DE ITAPEMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1674, 8, 3201308, 'CARIACICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1675, 8, 3201407, 'CASTELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1676, 8, 3201506, 'COLATINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1677, 8, 3201605, 'CONCEIÇÃO DA BARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1678, 8, 3201704, 'CONCEIÇÃO DO CASTELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1679, 8, 3201803, 'DIVINO DE SÃO LOURENÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1680, 8, 3201902, 'DOMINGOS MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1681, 8, 3202009, 'DORES DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1682, 8, 3202108, 'ECOPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1683, 8, 3202207, 'FUNDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1684, 8, 3202256, 'GOVERNADOR LINDENBERG', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1685, 8, 3202306, 'GUAÇUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1686, 8, 3202405, 'GUARAPARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1687, 8, 3202454, 'IBATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1688, 8, 3202504, 'IBIRAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1689, 8, 3202553, 'IBITIRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1690, 8, 3202603, 'ICONHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1691, 8, 3202652, 'IRUPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1692, 8, 3202702, 'ITAGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1693, 8, 3202801, 'ITAPEMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1694, 8, 3202900, 'ITARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1695, 8, 3203007, 'IÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1696, 8, 3203056, 'JAGUARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1697, 8, 3203106, 'JERÔNIMO MONTEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1698, 8, 3203130, 'JOÃO NEIVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1699, 8, 3203163, 'LARANJA DA TERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1700, 8, 3203205, 'LINHARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1701, 8, 3203304, 'MANTENÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1702, 8, 3203320, 'MARATAÍZES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1703, 8, 3203346, 'MARECHAL FLORIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1704, 8, 3203353, 'MARILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1705, 8, 3203403, 'MIMOSO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1706, 8, 3203502, 'MONTANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1707, 8, 3203601, 'MUCURICI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1708, 8, 3203700, 'MUNIZ FREIRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1709, 8, 3203809, 'MUQUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1710, 8, 3203908, 'NOVA VENÉCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1711, 8, 3204005, 'PANCAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1712, 8, 3204054, 'PEDRO CANÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1713, 8, 3204104, 'PINHEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1714, 8, 3204203, 'PIÚMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1715, 8, 3204252, 'PONTO BELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1716, 8, 3204302, 'PRESIDENTE KENNEDY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1717, 8, 3204351, 'RIO BANANAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1718, 8, 3204401, 'RIO NOVO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1719, 8, 3204500, 'SANTA LEOPOLDINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1720, 8, 3204559, 'SANTA MARIA DE JETIBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1721, 8, 3204609, 'SANTA TERESA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1722, 8, 3204658, 'SÃO DOMINGOS DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1723, 8, 3204708, 'SÃO GABRIEL DA PALHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1724, 8, 3204807, 'SÃO JOSÉ DO CALÇADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1725, 8, 3204906, 'SÃO MATEUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1726, 8, 3204955, 'SÃO ROQUE DO CANAÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1727, 8, 3205002, 'SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1728, 8, 3205010, 'SOORETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1729, 8, 3205036, 'VARGEM ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1730, 8, 3205069, 'VENDA NOVA DO IMIGRANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1731, 8, 3205101, 'VIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1732, 8, 3205150, 'VILA PAVÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1733, 8, 3205176, 'VILA VALÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1734, 8, 3205200, 'VILA VELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1735, 8, 3205309, 'VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1736, 9, 5200050, 'ABADIA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1737, 9, 5200100, 'ABADIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1738, 9, 5200134, 'ACREÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1739, 9, 5200159, 'ADELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1740, 9, 5200175, 'ÁGUA FRIA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1741, 9, 5200209, 'ÁGUA LIMPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1742, 9, 5200258, 'ÁGUAS LINDAS DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1743, 9, 5200308, 'ALEXÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1744, 9, 5200506, 'ALOÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1745, 9, 5200555, 'ALTO HORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1746, 9, 5200605, 'ALTO PARAÍSO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1747, 9, 5200803, 'ALVORADA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1748, 9, 5200829, 'AMARALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1749, 9, 5200852, 'AMERICANO DO BRASIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1750, 9, 5200902, 'AMORINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1751, 9, 5201108, 'ANÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1752, 9, 5201207, 'ANHANGUERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1753, 9, 5201306, 'ANICUNS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1754, 9, 5201405, 'APARECIDA DE GOIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1755, 9, 5201454, 'APARECIDA DO RIO DOCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1756, 9, 5201504, 'APORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1757, 9, 5201603, 'ARAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1758, 9, 5201702, 'ARAGARÇAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1759, 9, 5201801, 'ARAGOIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1760, 9, 5202155, 'ARAGUAPAZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1761, 9, 5202353, 'ARENÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1762, 9, 5202502, 'ARUANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1763, 9, 5202601, 'AURILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1764, 9, 5202809, 'AVELINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1765, 9, 5203104, 'BALIZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1766, 9, 5203203, 'BARRO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1767, 9, 5203302, 'BELA VISTA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1768, 9, 5203401, 'BOM JARDIM DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1769, 9, 5203500, 'BOM JESUS DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1770, 9, 5203559, 'BONFINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1771, 9, 5203575, 'BONÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1772, 9, 5203609, 'BRAZABRANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1773, 9, 5203807, 'BRITÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1774, 9, 5203906, 'BURITI ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1775, 9, 5203939, 'BURITI DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1776, 9, 5203962, 'BURITINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1777, 9, 5204003, 'CABECEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1778, 9, 5204102, 'CACHOEIRA ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1779, 9, 5204201, 'CACHOEIRA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1780, 9, 5204250, 'CACHOEIRA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1781, 9, 5204300, 'CAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1782, 9, 5204409, 'CAIAPÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1783, 9, 5204508, 'CALDAS NOVAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1784, 9, 5204557, 'CALDAZINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1785, 9, 5204607, 'CAMPESTRE DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1786, 9, 5204656, 'CAMPINAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1787, 9, 5204706, 'CAMPINORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1788, 9, 5204805, 'CAMPO ALEGRE DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1789, 9, 5204854, 'CAMPO LIMPO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1790, 9, 5204904, 'CAMPOS BELOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1791, 9, 5204953, 'CAMPOS VERDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1792, 9, 5205000, 'CARMO DO RIO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1793, 9, 5205059, 'CASTELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1794, 9, 5205109, 'CATALÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1795, 9, 5205208, 'CATURAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1796, 9, 5205307, 'CAVALCANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1797, 9, 5205406, 'CERES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1798, 9, 5205455, 'CEZARINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1799, 9, 5205471, 'CHAPADÃO DO CÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1800, 9, 5205497, 'CIDADE OCIDENTAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1801, 9, 5205513, 'COCALZINHO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1802, 9, 5205521, 'COLINAS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1803, 9, 5205703, 'CÓRREGO DO OURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1804, 9, 5205802, 'CORUMBÁ DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1805, 9, 5205901, 'CORUMBAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1806, 9, 5206206, 'CRISTALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1807, 9, 5206305, 'CRISTIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1808, 9, 5206404, 'CRIXÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1809, 9, 5206503, 'CROMÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1810, 9, 5206602, 'CUMARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1811, 9, 5206701, 'DAMIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1812, 9, 5206800, 'DAMOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1813, 9, 5206909, 'DAVINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1814, 9, 5207105, 'DIORAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1815, 9, 5208301, 'DIVINÓPOLIS DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1816, 9, 5207253, 'DOVERLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1817, 9, 5207352, 'EDEALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1818, 9, 5207402, 'EDÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1819, 9, 5207501, 'ESTRELA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1820, 9, 5207535, 'FAINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1821, 9, 5207600, 'FAZENDA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1822, 9, 5207808, 'FIRMINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1823, 9, 5207907, 'FLORES DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1824, 9, 5208004, 'FORMOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1825, 9, 5208103, 'FORMOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1826, 9, 5208152, 'GAMELEIRA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1827, 9, 5208400, 'GOIANÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1828, 9, 5208509, 'GOIANDIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1829, 9, 5208608, 'GOIANÉSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1830, 9, 5208707, 'GOIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1831, 9, 5208806, 'GOIANIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1832, 9, 5208905, 'GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1833, 9, 5209101, 'GOIATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1834, 9, 5209150, 'GOUVELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1835, 9, 5209200, 'GUAPÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1836, 9, 5209291, 'GUARAÍTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1837, 9, 5209408, 'GUARANI DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1838, 9, 5209457, 'GUARINOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1839, 9, 5209606, 'HEITORAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1840, 9, 5209705, 'HIDROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1841, 9, 5209804, 'HIDROLINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1842, 9, 5209903, 'IACIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1843, 9, 5209937, 'INACIOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1844, 9, 5209952, 'INDIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1845, 9, 5210000, 'INHUMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1846, 9, 5210109, 'IPAMERI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1847, 9, 5210158, 'IPIRANGA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1848, 9, 5210208, 'IPORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1849, 9, 5210307, 'ISRAELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1850, 9, 5210406, 'ITABERAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1851, 9, 5210562, 'ITAGUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1852, 9, 5210604, 'ITAGUARU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1853, 9, 5210802, 'ITAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1854, 9, 5210901, 'ITAPACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1855, 9, 5211008, 'ITAPIRAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1856, 9, 5211206, 'ITAPURANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1857, 9, 5211305, 'ITARUMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1858, 9, 5211404, 'ITAUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1859, 9, 5211503, 'ITUMBIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1860, 9, 5211602, 'IVOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1861, 9, 5211701, 'JANDAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1862, 9, 5211800, 'JARAGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1863, 9, 5211909, 'JATAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1864, 9, 5212006, 'JAUPACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1865, 9, 5212055, 'JESÚPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1866, 9, 5212105, 'JOVIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1867, 9, 5212204, 'JUSSARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1868, 9, 5212253, 'LAGOA SANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1869, 9, 5212303, 'LEOPOLDO DE BULHÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1870, 9, 5212501, 'LUZIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1871, 9, 5212600, 'MAIRIPOTABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1872, 9, 5212709, 'MAMBAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1873, 9, 5212808, 'MARA ROSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1874, 9, 5212907, 'MARZAGÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1875, 9, 5212956, 'MATRINCHÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1876, 9, 5213004, 'MAURILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1877, 9, 5213053, 'MIMOSO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1878, 9, 5213087, 'MINAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1879, 9, 5213103, 'MINEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1880, 9, 5213400, 'MOIPORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1881, 9, 5213509, 'MONTE ALEGRE DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1882, 9, 5213707, 'MONTES CLAROS DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1883, 9, 5213756, 'MONTIVIDIU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1884, 9, 5213772, 'MONTIVIDIU DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1885, 9, 5213806, 'MORRINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1886, 9, 5213855, 'MORRO AGUDO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1887, 9, 5213905, 'MOSSÂMEDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1888, 9, 5214002, 'MOZARLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1889, 9, 5214051, 'MUNDO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1890, 9, 5214101, 'MUTUNÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1891, 9, 5214408, 'NAZÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1892, 9, 5214507, 'NERÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1893, 9, 5214606, 'NIQUELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1894, 9, 5214705, 'NOVA AMÉRICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1895, 9, 5214804, 'NOVA AURORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1896, 9, 5214838, 'NOVA CRIXÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1897, 9, 5214861, 'NOVA GLÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1898, 9, 5214879, 'NOVA IGUAÇU DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1899, 9, 5214903, 'NOVA ROMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1900, 9, 5215009, 'NOVA VENEZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1901, 9, 5215207, 'NOVO BRASIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1902, 9, 5215231, 'NOVO GAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1903, 9, 5215256, 'NOVO PLANALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1904, 9, 5215306, 'ORIZONA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1905, 9, 5215405, 'OURO VERDE DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1906, 9, 5215504, 'OUVIDOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1907, 9, 5215603, 'PADRE BERNARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1908, 9, 5215652, 'PALESTINA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1909, 9, 5215702, 'PALMEIRAS DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1910, 9, 5215801, 'PALMELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1911, 9, 5215900, 'PALMINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1912, 9, 5216007, 'PANAMÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1913, 9, 5216304, 'PARANAIGUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1914, 9, 5216403, 'PARAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1915, 9, 5216452, 'PEROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1916, 9, 5216809, 'PETROLINA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1917, 9, 5216908, 'PILAR DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1918, 9, 5217104, 'PIRACANJUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1919, 9, 5217203, 'PIRANHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1920, 9, 5217302, 'PIRENÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1921, 9, 5217401, 'PIRES DO RIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1922, 9, 5217609, 'PLANALTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1923, 9, 5217708, 'PONTALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1924, 9, 5218003, 'PORANGATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1925, 9, 5218052, 'PORTEIRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1926, 9, 5218102, 'PORTELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1927, 9, 5218300, 'POSSE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1928, 9, 5218391, 'PROFESSOR JAMIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1929, 9, 5218508, 'QUIRINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1930, 9, 5218607, 'RIALMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1931, 9, 5218706, 'RIANÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1932, 9, 5218789, 'RIO QUENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1933, 9, 5218805, 'RIO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1934, 9, 5218904, 'RUBIATABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1935, 9, 5219001, 'SANCLERLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1936, 9, 5219100, 'SANTA BÁRBARA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1937, 9, 5219209, 'SANTA CRUZ DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1938, 9, 5219258, 'SANTA FÉ DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1939, 9, 5219308, 'SANTA HELENA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1940, 9, 5219357, 'SANTA ISABEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1941, 9, 5219407, 'SANTA RITA DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1942, 9, 5219456, 'SANTA RITA DO NOVO DESTINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1943, 9, 5219506, 'SANTA ROSA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1944, 9, 5219605, 'SANTA TEREZA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1945, 9, 5219704, 'SANTA TEREZINHA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1946, 9, 5219712, 'SANTO ANTÔNIO DA BARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1947, 9, 5219738, 'SANTO ANTÔNIO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1948, 9, 5219753, 'SANTO ANTÔNIO DO DESCOBERTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1949, 9, 5219803, 'SÃO DOMINGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1950, 9, 5219902, 'SÃO FRANCISCO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1951, 9, 5220058, 'SÃO JOÃO DA PARAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1952, 9, 5220009, 'SÃO JOÃO D\'ALIANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1953, 9, 5220108, 'SÃO LUÍS DE MONTES BELOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1954, 9, 5220157, 'SÃO LUÍZ DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1955, 9, 5220207, 'SÃO MIGUEL DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1956, 9, 5220264, 'SÃO MIGUEL DO PASSA QUATRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1957, 9, 5220280, 'SÃO PATRÍCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1958, 9, 5220405, 'SÃO SIMÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1959, 9, 5220454, 'SENADOR CANEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1960, 9, 5220504, 'SERRANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1961, 9, 5220603, 'SILVÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1962, 9, 5220686, 'SIMOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1963, 9, 5220702, 'SÍTIO D\'ABADIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1964, 9, 5221007, 'TAQUARAL DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1965, 9, 5221080, 'TERESINA DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1966, 9, 5221197, 'TEREZÓPOLIS DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1967, 9, 5221304, 'TRÊS RANCHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1968, 9, 5221403, 'TRINDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1969, 9, 5221452, 'TROMBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1970, 9, 5221502, 'TURVÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1971, 9, 5221551, 'TURVELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1972, 9, 5221577, 'UIRAPURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1973, 9, 5221601, 'URUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1974, 9, 5221700, 'URUANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1975, 9, 5221809, 'URUTAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1976, 9, 5221858, 'VALPARAÍSO DE GOIÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1977, 9, 5221908, 'VARJÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1978, 9, 5222005, 'VIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1979, 9, 5222054, 'VICENTINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1980, 9, 5222203, 'VILA BOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1981, 9, 5222302, 'VILA PROPÍCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1982, 10, 2100055, 'AÇAILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1983, 10, 2100105, 'AFONSO CUNHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1984, 10, 2100154, 'ÁGUA DOCE DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1985, 10, 2100204, 'ALCÂNTARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1986, 10, 2100303, 'ALDEIAS ALTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1987, 10, 2100402, 'ALTAMIRA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1988, 10, 2100436, 'ALTO ALEGRE DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1989, 10, 2100477, 'ALTO ALEGRE DO PINDARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1990, 10, 2100501, 'ALTO PARNAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1991, 10, 2100550, 'AMAPÁ DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1992, 10, 2100600, 'AMARANTE DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1993, 10, 2100709, 'ANAJATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1994, 10, 2100808, 'ANAPURUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1995, 10, 2100832, 'APICUM-AÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1996, 10, 2100873, 'ARAGUANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1997, 10, 2100907, 'ARAIOSES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1998, 10, 2100956, 'ARAME', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(1999, 10, 2101004, 'ARARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2000, 10, 2101103, 'AXIXÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2001, 10, 2101202, 'BACABAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2002, 10, 2101251, 'BACABEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2003, 10, 2101301, 'BACURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2004, 10, 2101350, 'BACURITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2005, 10, 2101400, 'BALSAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2006, 10, 2101509, 'BARÃO DE GRAJAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2007, 10, 2101608, 'BARRA DO CORDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2008, 10, 2101707, 'BARREIRINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2009, 10, 2101772, 'BELA VISTA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2010, 10, 2101731, 'BELÁGUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2011, 10, 2101806, 'BENEDITO LEITE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2012, 10, 2101905, 'BEQUIMÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2013, 10, 2101939, 'BERNARDO DO MEARIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2014, 10, 2101970, 'BOA VISTA DO GURUPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2015, 10, 2102002, 'BOM JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2016, 10, 2102036, 'BOM JESUS DAS SELVAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2017, 10, 2102077, 'BOM LUGAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2018, 10, 2102101, 'BREJO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2019, 10, 2102150, 'BREJO DE AREIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2020, 10, 2102200, 'BURITI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2021, 10, 2102309, 'BURITI BRAVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2022, 10, 2102325, 'BURITICUPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2023, 10, 2102358, 'BURITIRANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2024, 10, 2102374, 'CACHOEIRA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2025, 10, 2102408, 'CAJAPIÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2026, 10, 2102507, 'CAJARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2027, 10, 2102556, 'CAMPESTRE DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2028, 10, 2102606, 'CÂNDIDO MENDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2029, 10, 2102705, 'CANTANHEDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2030, 10, 2102754, 'CAPINZAL DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2031, 10, 2102804, 'CAROLINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2032, 10, 2102903, 'CARUTAPERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2033, 10, 2103000, 'CAXIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2034, 10, 2103109, 'CEDRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2035, 10, 2103125, 'CENTRAL DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2036, 10, 2103158, 'CENTRO DO GUILHERME', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2037, 10, 2103174, 'CENTRO NOVO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2038, 10, 2103208, 'CHAPADINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2039, 10, 2103257, 'CIDELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2040, 10, 2103307, 'CODÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2041, 10, 2103406, 'COELHO NETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2042, 10, 2103505, 'COLINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2043, 10, 2103554, 'CONCEIÇÃO DO LAGO-AÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2044, 10, 2103604, 'COROATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2045, 10, 2103703, 'CURURUPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2046, 10, 2103752, 'DAVINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2047, 10, 2103802, 'DOM PEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2048, 10, 2103901, 'DUQUE BACELAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2049, 10, 2104008, 'ESPERANTINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2050, 10, 2104057, 'ESTREITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2051, 10, 2104073, 'FEIRA NOVA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2052, 10, 2104081, 'FERNANDO FALCÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2053, 10, 2104099, 'FORMOSA DA SERRA NEGRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2054, 10, 2104107, 'FORTALEZA DOS NOGUEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2055, 10, 2104206, 'FORTUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2056, 10, 2104305, 'GODOFREDO VIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2057, 10, 2104404, 'GONÇALVES DIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2058, 10, 2104503, 'GOVERNADOR ARCHER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2059, 10, 2104552, 'GOVERNADOR EDISON LOBÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2060, 10, 2104602, 'GOVERNADOR EUGÊNIO BARROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2061, 10, 2104628, 'GOVERNADOR LUIZ ROCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2062, 10, 2104651, 'GOVERNADOR NEWTON BELLO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2063, 10, 2104677, 'GOVERNADOR NUNES FREIRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2064, 10, 2104701, 'GRAÇA ARANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2065, 10, 2104800, 'GRAJAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2066, 10, 2104909, 'GUIMARÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2067, 10, 2105005, 'HUMBERTO DE CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2068, 10, 2105104, 'ICATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2069, 10, 2105153, 'IGARAPÉ DO MEIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2070, 10, 2105203, 'IGARAPÉ GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2071, 10, 2105302, 'IMPERATRIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2072, 10, 2105351, 'ITAIPAVA DO GRAJAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2073, 10, 2105401, 'ITAPECURU MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2074, 10, 2105427, 'ITINGA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2075, 10, 2105450, 'JATOBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2076, 10, 2105476, 'JENIPAPO DOS VIEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2077, 10, 2105500, 'JOÃO LISBOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2078, 10, 2105609, 'JOSELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2079, 10, 2105658, 'JUNCO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2080, 10, 2105708, 'LAGO DA PEDRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2081, 10, 2105807, 'LAGO DO JUNCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2082, 10, 2105948, 'LAGO DOS RODRIGUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2083, 10, 2105906, 'LAGO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2084, 10, 2105922, 'LAGOA DO MATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2085, 10, 2105963, 'LAGOA GRANDE DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2086, 10, 2105989, 'LAJEADO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2087, 10, 2106003, 'LIMA CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2088, 10, 2106102, 'LORETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2089, 10, 2106201, 'LUÍS DOMINGUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2090, 10, 2106300, 'MAGALHÃES DE ALMEIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2091, 10, 2106326, 'MARACAÇUMÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2092, 10, 2106359, 'MARAJÁ DO SENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2093, 10, 2106375, 'MARANHÃOZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2094, 10, 2106409, 'MATA ROMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2095, 10, 2106508, 'MATINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2096, 10, 2106607, 'MATÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2097, 10, 2106631, 'MATÕES DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2098, 10, 2106672, 'MILAGRES DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2099, 10, 2106706, 'MIRADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2100, 10, 2106755, 'MIRANDA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2101, 10, 2106805, 'MIRINZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2102, 10, 2106904, 'MONÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2103, 10, 2107001, 'MONTES ALTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2104, 10, 2107100, 'MORROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2105, 10, 2107209, 'NINA RODRIGUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2106, 10, 2107258, 'NOVA COLINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2107, 10, 2107308, 'NOVA IORQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2108, 10, 2107357, 'NOVA OLINDA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2109, 10, 2107407, 'OLHO D\'ÁGUA DAS CUNHÃS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2110, 10, 2107456, 'OLINDA NOVA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2111, 10, 2107506, 'PAÇO DO LUMIAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2112, 10, 2107605, 'PALMEIRÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2113, 10, 2107704, 'PARAIBANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2114, 10, 2107803, 'PARNARAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2115, 10, 2107902, 'PASSAGEM FRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2116, 10, 2108009, 'PASTOS BONS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2117, 10, 2108058, 'PAULINO NEVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2118, 10, 2108108, 'PAULO RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2119, 10, 2108207, 'PEDREIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2120, 10, 2108256, 'PEDRO DO ROSÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2121, 10, 2108306, 'PENALVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2122, 10, 2108405, 'PERI MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2123, 10, 2108454, 'PERITORÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2124, 10, 2108504, 'PINDARÉ-MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2125, 10, 2108603, 'PINHEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2126, 10, 2108702, 'PIO XII', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2127, 10, 2108801, 'PIRAPEMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2128, 10, 2108900, 'POÇÃO DE PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2129, 10, 2109007, 'PORTO FRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2130, 10, 2109056, 'PORTO RICO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2131, 10, 2109106, 'PRESIDENTE DUTRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2132, 10, 2109205, 'PRESIDENTE JUSCELINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2133, 10, 2109239, 'PRESIDENTE MÉDICI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2134, 10, 2109270, 'PRESIDENTE SARNEY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2135, 10, 2109304, 'PRESIDENTE VARGAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2136, 10, 2109403, 'PRIMEIRA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2137, 10, 2109452, 'RAPOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2138, 10, 2109502, 'RIACHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2139, 10, 2109551, 'RIBAMAR FIQUENE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2140, 10, 2109601, 'ROSÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2141, 10, 2109700, 'SAMBAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2142, 10, 2109759, 'SANTA FILOMENA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2143, 10, 2109809, 'SANTA HELENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2144, 10, 2109908, 'SANTA INÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2145, 10, 2110005, 'SANTA LUZIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2146, 10, 2110039, 'SANTA LUZIA DO PARUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2147, 10, 2110104, 'SANTA QUITÉRIA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2148, 10, 2110203, 'SANTA RITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2149, 10, 2110237, 'SANTANA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2150, 10, 2110278, 'SANTO AMARO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2151, 10, 2110302, 'SANTO ANTÔNIO DOS LOPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2152, 10, 2110401, 'SÃO BENEDITO DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2153, 10, 2110500, 'SÃO BENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2154, 10, 2110609, 'SÃO BERNARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2155, 10, 2110658, 'SÃO DOMINGOS DO AZEITÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2156, 10, 2110708, 'SÃO DOMINGOS DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2157, 10, 2110807, 'SÃO FÉLIX DE BALSAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2158, 10, 2110856, 'SÃO FRANCISCO DO BREJÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2159, 10, 2110906, 'SÃO FRANCISCO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2160, 10, 2111003, 'SÃO JOÃO BATISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2161, 10, 2111029, 'SÃO JOÃO DO CARÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2162, 10, 2111052, 'SÃO JOÃO DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2163, 10, 2111078, 'SÃO JOÃO DO SOTER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2164, 10, 2111102, 'SÃO JOÃO DOS PATOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2165, 10, 2111201, 'SÃO JOSÉ DE RIBAMAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2166, 10, 2111250, 'SÃO JOSÉ DOS BASÍLIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2167, 10, 2111300, 'SÃO LUÍS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2168, 10, 2111409, 'SÃO LUÍS GONZAGA DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2169, 10, 2111508, 'SÃO MATEUS DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2170, 10, 2111532, 'SÃO PEDRO DA ÁGUA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2171, 10, 2111573, 'SÃO PEDRO DOS CRENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2172, 10, 2111607, 'SÃO RAIMUNDO DAS MANGABEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2173, 10, 2111631, 'SÃO RAIMUNDO DO DOCA BEZERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2174, 10, 2111672, 'SÃO ROBERTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2175, 10, 2111706, 'SÃO VICENTE FERRER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2176, 10, 2111722, 'SATUBINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2177, 10, 2111748, 'SENADOR ALEXANDRE COSTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2178, 10, 2111763, 'SENADOR LA ROCQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2179, 10, 2111789, 'SERRANO DO MARANHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2180, 10, 2111805, 'SÍTIO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2181, 10, 2111904, 'SUCUPIRA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2182, 10, 2111953, 'SUCUPIRA DO RIACHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2183, 10, 2112001, 'TASSO FRAGOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2184, 10, 2112100, 'TIMBIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2185, 10, 2112209, 'TIMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2186, 10, 2112233, 'TRIZIDELA DO VALE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2187, 10, 2112274, 'TUFILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2188, 10, 2112308, 'TUNTUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2189, 10, 2112407, 'TURIAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2190, 10, 2112456, 'TURILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2191, 10, 2112506, 'TUTÓIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2192, 10, 2112605, 'URBANO SANTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2193, 10, 2112704, 'VARGEM GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2194, 10, 2112803, 'VIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2195, 10, 2112852, 'VILA NOVA DOS MARTÍRIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2196, 10, 2112902, 'VITÓRIA DO MEARIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2197, 10, 2113009, 'VITORINO FREIRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2198, 10, 2114007, 'ZÉ DOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2199, 12, 5000203, 'ÁGUA CLARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2200, 12, 5000252, 'ALCINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2201, 12, 5000609, 'AMAMBAI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2202, 12, 5000708, 'ANASTÁCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2203, 12, 5000807, 'ANAURILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2204, 12, 5000856, 'ANGÉLICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2205, 12, 5000906, 'ANTÔNIO JOÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2206, 12, 5001003, 'APARECIDA DO TABOADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2207, 12, 5001102, 'AQUIDAUANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2208, 12, 5001243, 'ARAL MOREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2209, 12, 5001508, 'BANDEIRANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2210, 12, 5001904, 'BATAGUASSU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2211, 12, 5002001, 'BATAYPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2212, 12, 5002100, 'BELA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2213, 12, 5002159, 'BODOQUENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2214, 12, 5002209, 'BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2215, 12, 5002308, 'BRASILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2216, 12, 5002407, 'CAARAPÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2217, 12, 5002605, 'CAMAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2218, 12, 5002704, 'CAMPO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2219, 12, 5002803, 'CARACOL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2220, 12, 5002902, 'CASSILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2221, 12, 5002951, 'CHAPADÃO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2222, 12, 5003108, 'CORGUINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2223, 12, 5003157, 'CORONEL SAPUCAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2224, 12, 5003207, 'CORUMBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2225, 12, 5003256, 'COSTA RICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2226, 12, 5003306, 'COXIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2227, 12, 5003454, 'DEODÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2228, 12, 5003488, 'DOIS IRMÃOS DO BURITI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2229, 12, 5003504, 'DOURADINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2230, 12, 5003702, 'DOURADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2231, 12, 5003751, 'ELDORADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2232, 12, 5003801, 'FÁTIMA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2233, 12, 5003900, 'FIGUEIRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2234, 12, 5004007, 'GLÓRIA DE DOURADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2235, 12, 5004106, 'GUIA LOPES DA LAGUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2236, 12, 5004304, 'IGUATEMI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2237, 12, 5004403, 'INOCÊNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2238, 12, 5004502, 'ITAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2239, 12, 5004601, 'ITAQUIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2240, 12, 5004700, 'IVINHEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2241, 12, 5004809, 'JAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2242, 12, 5004908, 'JARAGUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2243, 12, 5005004, 'JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2244, 12, 5005103, 'JATEÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2245, 12, 5005152, 'JUTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2246, 12, 5005202, 'LADÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2247, 12, 5005251, 'LAGUNA CARAPÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2248, 12, 5005400, 'MARACAJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2249, 12, 5005608, 'MIRANDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2250, 12, 5005681, 'MUNDO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2251, 12, 5005707, 'NAVIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2252, 12, 5005806, 'NIOAQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2253, 12, 5006002, 'NOVA ALVORADA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2254, 12, 5006200, 'NOVA ANDRADINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2255, 12, 5006259, 'NOVO HORIZONTE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2256, 12, 5006309, 'PARANAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2257, 12, 5006358, 'PARANHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2258, 12, 5006408, 'PEDRO GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2259, 12, 5006606, 'PONTA PORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2260, 12, 5006903, 'PORTO MURTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2261, 12, 5007109, 'RIBAS DO RIO PARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2262, 12, 5007208, 'RIO BRILHANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2263, 12, 5007307, 'RIO NEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2264, 12, 5007406, 'RIO VERDE DE MATO GROSSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2265, 12, 5007505, 'ROCHEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2266, 12, 5007554, 'SANTA RITA DO PARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2267, 12, 5007695, 'SÃO GABRIEL DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2268, 12, 5007802, 'SELVÍRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2269, 12, 5007703, 'SETE QUEDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2270, 12, 5007901, 'SIDROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2271, 12, 5007935, 'SONORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2272, 12, 5007950, 'TACURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2273, 12, 5007976, 'TAQUARUSSU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2274, 12, 5008008, 'TERENOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2275, 12, 5008305, 'TRÊS LAGOAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2276, 12, 5008404, 'VICENTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2277, 13, 5100102, 'ACORIZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2278, 13, 5100201, 'ÁGUA BOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2279, 13, 5100250, 'ALTA FLORESTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2280, 13, 5100300, 'ALTO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2281, 13, 5100359, 'ALTO BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2282, 13, 5100409, 'ALTO GARÇAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2283, 13, 5100508, 'ALTO PARAGUAI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2284, 13, 5100607, 'ALTO TAQUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2285, 13, 5100805, 'APIACÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2286, 13, 5101001, 'ARAGUAIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2287, 13, 5101209, 'ARAGUAINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2288, 13, 5101258, 'ARAPUTANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2289, 13, 5101308, 'ARENÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2290, 13, 5101407, 'ARIPUANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2291, 13, 5101605, 'BARÃO DE MELGAÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2292, 13, 5101704, 'BARRA DO BUGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2293, 13, 5101803, 'BARRA DO GARÇAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2294, 13, 5101852, 'BOM JESUS DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2295, 13, 5101902, 'BRASNORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2296, 13, 5102504, 'CÁCERES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2297, 13, 5102603, 'CAMPINÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2298, 13, 5102637, 'CAMPO NOVO DO PARECIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2299, 13, 5102678, 'CAMPO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2300, 13, 5102686, 'CAMPOS DE JÚLIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2301, 13, 5102694, 'CANABRAVA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2302, 13, 5102702, 'CANARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2303, 13, 5102793, 'CARLINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2304, 13, 5102850, 'CASTANHEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2305, 13, 5103007, 'CHAPADA DOS GUIMARÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2306, 13, 5103056, 'CLÁUDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2307, 13, 5103106, 'COCALINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2308, 13, 5103205, 'COLÍDER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2309, 13, 5103254, 'COLNIZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2310, 13, 5103304, 'COMODORO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2311, 13, 5103353, 'CONFRESA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2312, 13, 5103361, 'CONQUISTA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2313, 13, 5103379, 'COTRIGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2314, 13, 5103403, 'CUIABÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2315, 13, 5103437, 'CURVELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2316, 13, 5103452, 'DENISE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2317, 13, 5103502, 'DIAMANTINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2318, 13, 5103601, 'DOM AQUINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2319, 13, 5103700, 'FELIZ NATAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2320, 13, 5103809, 'FIGUEIRÓPOLIS D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2321, 13, 5103858, 'GAÚCHA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2322, 13, 5103908, 'GENERAL CARNEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2323, 13, 5103957, 'GLÓRIA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2324, 13, 5104104, 'GUARANTÃ DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2325, 13, 5104203, 'GUIRATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2326, 13, 5104500, 'INDIAVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2327, 13, 5104526, 'IPIRANGA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2328, 13, 5104542, 'ITANHANGÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2329, 13, 5104559, 'ITAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2330, 13, 5104609, 'ITIQUIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2331, 13, 5104807, 'JACIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2332, 13, 5104906, 'JANGADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2333, 13, 5105002, 'JAURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2334, 13, 5105101, 'JUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2335, 13, 5105150, 'JUÍNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2336, 13, 5105176, 'JURUENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2337, 13, 5105200, 'JUSCIMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2338, 13, 5105234, 'LAMBARI D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2339, 13, 5105259, 'LUCAS DO RIO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2340, 13, 5105309, 'LUCIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2341, 13, 5105580, 'MARCELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2342, 13, 5105606, 'MATUPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2343, 13, 5105622, 'MIRASSOL D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2344, 13, 5105903, 'NOBRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2345, 13, 5106000, 'NORTELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2346, 13, 5106109, 'NOSSA SENHORA DO LIVRAMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2347, 13, 5106158, 'NOVA BANDEIRANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2348, 13, 5106208, 'NOVA BRASILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2349, 13, 5106216, 'NOVA CANAÃ DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2350, 13, 5108808, 'NOVA GUARITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2351, 13, 5106182, 'NOVA LACERDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2352, 13, 5108857, 'NOVA MARILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2353, 13, 5108907, 'NOVA MARINGÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2354, 13, 5108956, 'NOVA MONTE VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2355, 13, 5106224, 'NOVA MUTUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2356, 13, 5106174, 'NOVA NAZARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2357, 13, 5106232, 'NOVA OLÍMPIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2358, 13, 5106190, 'NOVA SANTA HELENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2359, 13, 5106240, 'NOVA UBIRATÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2360, 13, 5106257, 'NOVA XAVANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2361, 13, 5106273, 'NOVO HORIZONTE DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2362, 13, 5106265, 'NOVO MUNDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2363, 13, 5106315, 'NOVO SANTO ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2364, 13, 5106281, 'NOVO SÃO JOAQUIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2365, 13, 5106299, 'PARANAÍTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2366, 13, 5106307, 'PARANATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2367, 13, 5106372, 'PEDRA PRETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2368, 13, 5106422, 'PEIXOTO DE AZEVEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2369, 13, 5106455, 'PLANALTO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2370, 13, 5106505, 'POCONÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2371, 13, 5106653, 'PONTAL DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2372, 13, 5106703, 'PONTE BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2373, 13, 5106752, 'PONTES E LACERDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2374, 13, 5106778, 'PORTO ALEGRE DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2375, 13, 5106802, 'PORTO DOS GAÚCHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2376, 13, 5106828, 'PORTO ESPERIDIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2377, 13, 5106851, 'PORTO ESTRELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2378, 13, 5107008, 'POXORÉO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2379, 13, 5107040, 'PRIMAVERA DO LESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2380, 13, 5107065, 'QUERÊNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2381, 13, 5107156, 'RESERVA DO CABAÇAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2382, 13, 5107180, 'RIBEIRÃO CASCALHEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2383, 13, 5107198, 'RIBEIRÃOZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2384, 13, 5107206, 'RIO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2385, 13, 5107578, 'RONDOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2386, 13, 5107602, 'RONDONÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2387, 13, 5107701, 'ROSÁRIO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2388, 13, 5107750, 'SALTO DO CÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2389, 13, 5107248, 'SANTA CARMEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2390, 13, 5107743, 'SANTA CRUZ DO XINGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2391, 13, 5107768, 'SANTA RITA DO TRIVELATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2392, 13, 5107776, 'SANTA TEREZINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2393, 13, 5107263, 'SANTO AFONSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2394, 13, 5107792, 'SANTO ANTÔNIO DO LESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2395, 13, 5107800, 'SANTO ANTÔNIO DO LEVERGER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2396, 13, 5107859, 'SÃO FÉLIX DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2397, 13, 5107297, 'SÃO JOSÉ DO POVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2398, 13, 5107305, 'SÃO JOSÉ DO RIO CLARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2399, 13, 5107354, 'SÃO JOSÉ DO XINGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2400, 13, 5107107, 'SÃO JOSÉ DOS QUATRO MARCOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2401, 13, 5107404, 'SÃO PEDRO DA CIPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2402, 13, 5107875, 'SAPEZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2403, 13, 5107883, 'SERRA NOVA DOURADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2404, 13, 5107909, 'SINOP', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2405, 13, 5107925, 'SORRISO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2406, 13, 5107941, 'TABAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2407, 13, 5107958, 'TANGARÁ DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2408, 13, 5108006, 'TAPURAH', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2409, 13, 5108055, 'TERRA NOVA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2410, 13, 5108105, 'TESOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2411, 13, 5108204, 'TORIXORÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2412, 13, 5108303, 'UNIÃO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2413, 13, 5108352, 'VALE DE SÃO DOMINGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2414, 13, 5108402, 'VÁRZEA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2415, 13, 5108501, 'VERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2416, 13, 5105507, 'VILA BELA DA SANTÍSSIMA TRINDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2417, 13, 5108600, 'VILA RICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2418, 14, 1500107, 'ABAETETUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2419, 14, 1500131, 'ABEL FIGUEIREDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2420, 14, 1500206, 'ACARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2421, 14, 1500305, 'AFUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2422, 14, 1500347, 'ÁGUA AZUL DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2423, 14, 1500404, 'ALENQUER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2424, 14, 1500503, 'ALMEIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2425, 14, 1500602, 'ALTAMIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2426, 14, 1500701, 'ANAJÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2427, 14, 1500800, 'ANANINDEUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2428, 14, 1500859, 'ANAPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2429, 14, 1500909, 'AUGUSTO CORRÊA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2430, 14, 1500958, 'AURORA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2431, 14, 1501006, 'AVEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2432, 14, 1501105, 'BAGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2433, 14, 1501204, 'BAIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2434, 14, 1501253, 'BANNACH', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2435, 14, 1501303, 'BARCARENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2436, 14, 1501402, 'BELÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2437, 14, 1501451, 'BELTERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2438, 14, 1501501, 'BENEVIDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2439, 14, 1501576, 'BOM JESUS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2440, 14, 1501600, 'BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2441, 14, 1501709, 'BRAGANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2442, 14, 1501725, 'BRASIL NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2443, 14, 1501758, 'BREJO GRANDE DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2444, 14, 1501782, 'BREU BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2445, 14, 1501808, 'BREVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2446, 14, 1501907, 'BUJARU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2447, 14, 1502004, 'CACHOEIRA DO ARARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2448, 14, 1501956, 'CACHOEIRA DO PIRIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2449, 14, 1502103, 'CAMETÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2450, 14, 1502152, 'CANAÃ DOS CARAJÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2451, 14, 1502202, 'CAPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2452, 14, 1502301, 'CAPITÃO POÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2453, 14, 1502400, 'CASTANHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2454, 14, 1502509, 'CHAVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2455, 14, 1502608, 'COLARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2456, 14, 1502707, 'CONCEIÇÃO DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2457, 14, 1502756, 'CONCÓRDIA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2458, 14, 1502764, 'CUMARU DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2459, 14, 1502772, 'CURIONÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2460, 14, 1502806, 'CURRALINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2461, 14, 1502855, 'CURUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2462, 14, 1502905, 'CURUÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2463, 14, 1502939, 'DOM ELISEU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2464, 14, 1502954, 'ELDORADO DOS CARAJÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2465, 14, 1503002, 'FARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2466, 14, 1503044, 'FLORESTA DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2467, 14, 1503077, 'GARRAFÃO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2468, 14, 1503093, 'GOIANÉSIA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2469, 14, 1503101, 'GURUPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2470, 14, 1503200, 'IGARAPÉ-AÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2471, 14, 1503309, 'IGARAPÉ-MIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2472, 14, 1503408, 'INHANGAPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2473, 14, 1503457, 'IPIXUNA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2474, 14, 1503507, 'IRITUIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2475, 14, 1503606, 'ITAITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2476, 14, 1503705, 'ITUPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2477, 14, 1503754, 'JACAREACANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2478, 14, 1503804, 'JACUNDÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2479, 14, 1503903, 'JURUTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2480, 14, 1504000, 'LIMOEIRO DO AJURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2481, 14, 1504059, 'MÃE DO RIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2482, 14, 1504109, 'MAGALHÃES BARATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2483, 14, 1504208, 'MARABÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2484, 14, 1504307, 'MARACANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2485, 14, 1504406, 'MARAPANIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2486, 14, 1504422, 'MARITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2487, 14, 1504455, 'MEDICILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2488, 14, 1504505, 'MELGAÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2489, 14, 1504604, 'MOCAJUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2490, 14, 1504703, 'MOJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2491, 14, 1504802, 'MONTE ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2492, 14, 1504901, 'MUANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2493, 14, 1504950, 'NOVA ESPERANÇA DO PIRIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2494, 14, 1504976, 'NOVA IPIXUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2495, 14, 1505007, 'NOVA TIMBOTEUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2496, 14, 1505031, 'NOVO PROGRESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2497, 14, 1505064, 'NOVO REPARTIMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2498, 14, 1505106, 'ÓBIDOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2499, 14, 1505205, 'OEIRAS DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2500, 14, 1505304, 'ORIXIMINÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2501, 14, 1505403, 'OURÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2502, 14, 1505437, 'OURILÂNDIA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2503, 14, 1505486, 'PACAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2504, 14, 1505494, 'PALESTINA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2505, 14, 1505502, 'PARAGOMINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2506, 14, 1505536, 'PARAUAPEBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2507, 14, 1505551, 'PAU D\'ARCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2508, 14, 1505601, 'PEIXE-BOI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2509, 14, 1505635, 'PIÇARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2510, 14, 1505650, 'PLACAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2511, 14, 1505700, 'PONTA DE PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2512, 14, 1505809, 'PORTEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2513, 14, 1505908, 'PORTO DE MOZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2514, 14, 1506005, 'PRAINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2515, 14, 1506104, 'PRIMAVERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2516, 14, 1506112, 'QUATIPURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2517, 14, 1506138, 'REDENÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2518, 14, 1506161, 'RIO MARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2519, 14, 1506187, 'RONDON DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2520, 14, 1506195, 'RURÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2521, 14, 1506203, 'SALINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2522, 14, 1506302, 'SALVATERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2523, 14, 1506351, 'SANTA BÁRBARA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2524, 14, 1506401, 'SANTA CRUZ DO ARARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2525, 14, 1506500, 'SANTA ISABEL DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2526, 14, 1506559, 'SANTA LUZIA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2527, 14, 1506583, 'SANTA MARIA DAS BARREIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2528, 14, 1506609, 'SANTA MARIA DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2529, 14, 1506708, 'SANTANA DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2530, 14, 1506807, 'SANTARÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2531, 14, 1506906, 'SANTARÉM NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2532, 14, 1507003, 'SANTO ANTÔNIO DO TAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2533, 14, 1507102, 'SÃO CAETANO DE ODIVELAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2534, 14, 1507151, 'SÃO DOMINGOS DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2535, 14, 1507201, 'SÃO DOMINGOS DO CAPIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2536, 14, 1507300, 'SÃO FÉLIX DO XINGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2537, 14, 1507409, 'SÃO FRANCISCO DO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2538, 14, 1507458, 'SÃO GERALDO DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2539, 14, 1507466, 'SÃO JOÃO DA PONTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2540, 14, 1507474, 'SÃO JOÃO DE PIRABAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2541, 14, 1507508, 'SÃO JOÃO DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2542, 14, 1507607, 'SÃO MIGUEL DO GUAMÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2543, 14, 1507706, 'SÃO SEBASTIÃO DA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2544, 14, 1507755, 'SAPUCAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2545, 14, 1507805, 'SENADOR JOSÉ PORFÍRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2546, 14, 1507904, 'SOURE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2547, 14, 1507953, 'TAILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2548, 14, 1507961, 'TERRA ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2549, 14, 1507979, 'TERRA SANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2550, 14, 1508001, 'TOMÉ-AÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2551, 14, 1508035, 'TRACUATEUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2552, 14, 1508050, 'TRAIRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2553, 14, 1508084, 'TUCUMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2554, 14, 1508100, 'TUCURUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2555, 14, 1508126, 'ULIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2556, 14, 1508159, 'URUARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2557, 14, 1508209, 'VIGIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2558, 14, 1508308, 'VISEU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2559, 14, 1508357, 'VITÓRIA DO XINGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2560, 14, 1508407, 'XINGUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2561, 15, 2500106, 'ÁGUA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2562, 15, 2500205, 'AGUIAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2563, 15, 2500304, 'ALAGOA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2564, 15, 2500403, 'ALAGOA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2565, 15, 2500502, 'ALAGOINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2566, 15, 2500536, 'ALCANTIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2567, 15, 2500577, 'ALGODÃO DE JANDAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2568, 15, 2500601, 'ALHANDRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2569, 15, 2500734, 'AMPARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2570, 15, 2500775, 'APARECIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2571, 15, 2500809, 'ARAÇAGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2572, 15, 2500908, 'ARARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2573, 15, 2501005, 'ARARUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2574, 15, 2501104, 'AREIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2575, 15, 2501153, 'AREIA DE BARAÚNAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2576, 15, 2501203, 'AREIAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2577, 15, 2501302, 'AROEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2578, 15, 2501351, 'ASSUNÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2579, 15, 2501401, 'BAÍA DA TRAIÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2580, 15, 2501500, 'BANANEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2581, 15, 2501534, 'BARAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2582, 15, 2501609, 'BARRA DE SANTA ROSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2583, 15, 2501575, 'BARRA DE SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2584, 15, 2501708, 'BARRA DE SÃO MIGUEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2585, 15, 2501807, 'BAYEUX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2586, 15, 2501906, 'BELÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2587, 15, 2502003, 'BELÉM DO BREJO DO CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2588, 15, 2502052, 'BERNARDINO BATISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2589, 15, 2502102, 'BOA VENTURA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2590, 15, 2502151, 'BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2591, 15, 2502201, 'BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2592, 15, 2502300, 'BOM SUCESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2593, 15, 2502409, 'BONITO DE SANTA FÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2594, 15, 2502508, 'BOQUEIRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2595, 15, 2502706, 'BORBOREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2596, 15, 2502805, 'BREJO DO CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2597, 15, 2502904, 'BREJO DOS SANTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2598, 15, 2503001, 'CAAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2599, 15, 2503100, 'CABACEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2600, 15, 2503209, 'CABEDELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2601, 15, 2503308, 'CACHOEIRA DOS ÍNDIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2602, 15, 2503407, 'CACIMBA DE AREIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2603, 15, 2503506, 'CACIMBA DE DENTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2604, 15, 2503555, 'CACIMBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2605, 15, 2503605, 'CAIÇARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2606, 15, 2503704, 'CAJAZEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2607, 15, 2503753, 'CAJAZEIRINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2608, 15, 2503803, 'CALDAS BRANDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2609, 15, 2503902, 'CAMALAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2610, 15, 2504009, 'CAMPINA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2611, 15, 2516409, 'TACIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2612, 15, 2504033, 'CAPIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2613, 15, 2504074, 'CARAÚBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2614, 15, 2504108, 'CARRAPATEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2615, 15, 2504157, 'CASSERENGUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2616, 15, 2504207, 'CATINGUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2617, 15, 2504306, 'CATOLÉ DO ROCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2618, 15, 2504355, 'CATURITÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2619, 15, 2504405, 'CONCEIÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2620, 15, 2504504, 'CONDADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2621, 15, 2504603, 'CONDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2622, 15, 2504702, 'CONGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2623, 15, 2504801, 'COREMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2624, 15, 2504850, 'COXIXOLA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2625, 15, 2504900, 'CRUZ DO ESPÍRITO SANTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2626, 15, 2505006, 'CUBATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2627, 15, 2505105, 'CUITÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2628, 15, 2505238, 'CUITÉ DE MAMANGUAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2629, 15, 2505204, 'CUITEGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2630, 15, 2505279, 'CURRAL DE CIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2631, 15, 2505303, 'CURRAL VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2632, 15, 2505352, 'DAMIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2633, 15, 2505402, 'DESTERRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2634, 15, 2505600, 'DIAMANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2635, 15, 2505709, 'DONA INÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2636, 15, 2505808, 'DUAS ESTRADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2637, 15, 2505907, 'EMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2638, 15, 2506004, 'ESPERANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2639, 15, 2506103, 'FAGUNDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2640, 15, 2506202, 'FREI MARTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2641, 15, 2506251, 'GADO BRAVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2642, 15, 2506301, 'GUARABIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2643, 15, 2506400, 'GURINHÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2644, 15, 2506509, 'GURJÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2645, 15, 2506608, 'IBIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2646, 15, 2502607, 'IGARACY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2647, 15, 2506707, 'IMACULADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2648, 15, 2506806, 'INGÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2649, 15, 2506905, 'ITABAIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2650, 15, 2507002, 'ITAPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2651, 15, 2507101, 'ITAPOROROCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2652, 15, 2507200, 'ITATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2653, 15, 2507309, 'JACARAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2654, 15, 2507408, 'JERICÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2655, 15, 2507507, 'JOÃO PESSOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2656, 15, 2507606, 'JUAREZ TÁVORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2657, 15, 2507705, 'JUAZEIRINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2658, 15, 2507804, 'JUNCO DO SERIDÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2659, 15, 2507903, 'JURIPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2660, 15, 2508000, 'JURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2661, 15, 2508109, 'LAGOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2662, 15, 2508208, 'LAGOA DE DENTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2663, 15, 2508307, 'LAGOA SECA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2664, 15, 2508406, 'LASTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2665, 15, 2508505, 'LIVRAMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2666, 15, 2508554, 'LOGRADOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2667, 15, 2508604, 'LUCENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2668, 15, 2508703, 'MÃE D\'ÁGUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2669, 15, 2508802, 'MALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2670, 15, 2508901, 'MAMANGUAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2671, 15, 2509008, 'MANAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2672, 15, 2509057, 'MARCAÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2673, 15, 2509107, 'MARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2674, 15, 2509156, 'MARIZÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2675, 15, 2509206, 'MASSARANDUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2676, 15, 2509305, 'MATARACA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2677, 15, 2509339, 'MATINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2678, 15, 2509370, 'MATO GROSSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2679, 15, 2509396, 'MATURÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2680, 15, 2509404, 'MOGEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2681, 15, 2509503, 'MONTADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2682, 15, 2509602, 'MONTE HOREBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2683, 15, 2509701, 'MONTEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2684, 15, 2509800, 'MULUNGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2685, 15, 2509909, 'NATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2686, 15, 2510006, 'NAZAREZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2687, 15, 2510105, 'NOVA FLORESTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2688, 15, 2510204, 'NOVA OLINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2689, 15, 2510303, 'NOVA PALMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2690, 15, 2510402, 'OLHO D\'ÁGUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2691, 15, 2510501, 'OLIVEDOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2692, 15, 2510600, 'OURO VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2693, 15, 2510659, 'PARARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2694, 15, 2510709, 'PASSAGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2695, 15, 2510808, 'PATOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2696, 15, 2510907, 'PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2697, 15, 2511004, 'PEDRA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2698, 15, 2511103, 'PEDRA LAVRADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2699, 15, 2511202, 'PEDRAS DE FOGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2700, 15, 2512721, 'PEDRO RÉGIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2701, 15, 2511301, 'PIANCÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2702, 15, 2511400, 'PICUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2703, 15, 2511509, 'PILAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2704, 15, 2511608, 'PILÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2705, 15, 2511707, 'PILÕEZINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2706, 15, 2511806, 'PIRPIRITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2707, 15, 2511905, 'PITIMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2708, 15, 2512002, 'POCINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2709, 15, 2512036, 'POÇO DANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2710, 15, 2512077, 'POÇO DE JOSÉ DE MOURA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2711, 15, 2512101, 'POMBAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2712, 15, 2512200, 'PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2713, 15, 2512309, 'PRINCESA ISABEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2714, 15, 2512408, 'PUXINANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2715, 15, 2512507, 'QUEIMADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2716, 15, 2512606, 'QUIXABÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2717, 15, 2512705, 'REMÍGIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2718, 15, 2512747, 'RIACHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2719, 15, 2512754, 'RIACHÃO DO BACAMARTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2720, 15, 2512762, 'RIACHÃO DO POÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2721, 15, 2512788, 'RIACHO DE SANTO ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2722, 15, 2512804, 'RIACHO DOS CAVALOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2723, 15, 2512903, 'RIO TINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2724, 15, 2513000, 'SALGADINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2725, 15, 2513109, 'SALGADO DE SÃO FÉLIX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2726, 15, 2513158, 'SANTA CECÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2727, 15, 2513208, 'SANTA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2728, 15, 2513307, 'SANTA HELENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2729, 15, 2513356, 'SANTA INÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2730, 15, 2513406, 'SANTA LUZIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2731, 15, 2513703, 'SANTA RITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2732, 15, 2513802, 'SANTA TERESINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2733, 15, 2513505, 'SANTANA DE MANGUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2734, 15, 2513604, 'SANTANA DOS GARROTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2735, 15, 2513653, 'JOCA CLAUDINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2736, 15, 2513851, 'SANTO ANDRÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2737, 15, 2513927, 'SÃO BENTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2738, 15, 2513901, 'SÃO BENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2739, 15, 2513968, 'SÃO DOMINGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2740, 15, 2513943, 'SÃO DOMINGOS DO CARIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2741, 15, 2513984, 'SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2742, 15, 2514008, 'SÃO JOÃO DO CARIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2743, 15, 2500700, 'SÃO JOÃO DO RIO DO PEIXE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2744, 15, 2514107, 'SÃO JOÃO DO TIGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2745, 15, 2514206, 'SÃO JOSÉ DA LAGOA TAPADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2746, 15, 2514305, 'SÃO JOSÉ DE CAIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2747, 15, 2514404, 'SÃO JOSÉ DE ESPINHARAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2748, 15, 2514503, 'SÃO JOSÉ DE PIRANHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2749, 15, 2514552, 'SÃO JOSÉ DE PRINCESA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2750, 15, 2514602, 'SÃO JOSÉ DO BONFIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2751, 15, 2514651, 'SÃO JOSÉ DO BREJO DO CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2752, 15, 2514701, 'SÃO JOSÉ DO SABUGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2753, 15, 2514800, 'SÃO JOSÉ DOS CORDEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2754, 15, 2514453, 'SÃO JOSÉ DOS RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2755, 15, 2514909, 'SÃO MAMEDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2756, 15, 2515005, 'SÃO MIGUEL DE TAIPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2757, 15, 2515104, 'SÃO SEBASTIÃO DE LAGOA DE ROÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2758, 15, 2515203, 'SÃO SEBASTIÃO DO UMBUZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2759, 15, 2515302, 'SAPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2760, 15, 2515401, 'SERIDÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2761, 15, 2515500, 'SERRA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2762, 15, 2515609, 'SERRA DA RAIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2763, 15, 2515708, 'SERRA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2764, 15, 2515807, 'SERRA REDONDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2765, 15, 2515906, 'SERRARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2766, 15, 2515930, 'SERTÃOZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2767, 15, 2515971, 'SOBRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2768, 15, 2516003, 'SOLÂNEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2769, 15, 2516102, 'SOLEDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2770, 15, 2516151, 'SOSSÊGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2771, 15, 2516201, 'SOUSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2772, 15, 2516300, 'SUMÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2773, 15, 2516508, 'TAPEROÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2774, 15, 2516607, 'TAVARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2775, 15, 2516706, 'TEIXEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2776, 15, 2516755, 'TENÓRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2777, 15, 2516805, 'TRIUNFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2778, 15, 2516904, 'UIRAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2779, 15, 2517001, 'UMBUZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2780, 15, 2517100, 'VÁRZEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2781, 15, 2517209, 'VIEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2782, 15, 2505501, 'VISTA SERRANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2783, 15, 2517407, 'ZABELÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2784, 16, 2600054, 'ABREU E LIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2785, 16, 2600104, 'AFOGADOS DA INGAZEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2786, 16, 2600203, 'AFRÂNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2787, 16, 2600302, 'AGRESTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2788, 16, 2600401, 'ÁGUA PRETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2789, 16, 2600500, 'ÁGUAS BELAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2790, 16, 2600609, 'ALAGOINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2791, 16, 2600708, 'ALIANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2792, 16, 2600807, 'ALTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2793, 16, 2600906, 'AMARAJI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2794, 16, 2601003, 'ANGELIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2795, 16, 2601052, 'ARAÇOIABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2796, 16, 2601102, 'ARARIPINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2797, 16, 2601201, 'ARCOVERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2798, 16, 2601300, 'BARRA DE GUABIRABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2799, 16, 2601409, 'BARREIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2800, 16, 2601508, 'BELÉM DE MARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2801, 16, 2601607, 'BELÉM DO SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2802, 16, 2601706, 'BELO JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2803, 16, 2601805, 'BETÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2804, 16, 2601904, 'BEZERROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2805, 16, 2602001, 'BODOCÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2806, 16, 2602100, 'BOM CONSELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2807, 16, 2602209, 'BOM JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2808, 16, 2602308, 'BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2809, 16, 2602407, 'BREJÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2810, 16, 2602506, 'BREJINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2811, 16, 2602605, 'BREJO DA MADRE DE DEUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2812, 16, 2602704, 'BUENOS AIRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2813, 16, 2602803, 'BUÍQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2814, 16, 2602902, 'CABO DE SANTO AGOSTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2815, 16, 2603009, 'CABROBÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2816, 16, 2603108, 'CACHOEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2817, 16, 2603207, 'CAETÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2818, 16, 2603306, 'CALÇADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2819, 16, 2603405, 'CALUMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2820, 16, 2603454, 'CAMARAGIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2821, 16, 2603504, 'CAMOCIM DE SÃO FÉLIX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2822, 16, 2603603, 'CAMUTANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2823, 16, 2603702, 'CANHOTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2824, 16, 2603801, 'CAPOEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2825, 16, 2603900, 'CARNAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2826, 16, 2603926, 'CARNAUBEIRA DA PENHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2827, 16, 2604007, 'CARPINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2828, 16, 2604106, 'CARUARU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2829, 16, 2604155, 'CASINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2830, 16, 2604205, 'CATENDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2831, 16, 2604304, 'CEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2832, 16, 2604403, 'CHÃ DE ALEGRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2833, 16, 2604502, 'CHÃ GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2834, 16, 2604601, 'CONDADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2835, 16, 2604700, 'CORRENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2836, 16, 2604809, 'CORTÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2837, 16, 2604908, 'CUMARU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2838, 16, 2605004, 'CUPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2839, 16, 2605103, 'CUSTÓDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2840, 16, 2605152, 'DORMENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2841, 16, 2605202, 'ESCADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2842, 16, 2605301, 'EXU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2843, 16, 2605400, 'FEIRA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2844, 16, 2605459, 'FERNANDO DE NORONHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2845, 16, 2605509, 'FERREIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2846, 16, 2605608, 'FLORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2847, 16, 2605707, 'FLORESTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2848, 16, 2605806, 'FREI MIGUELINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2849, 16, 2605905, 'GAMELEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2850, 16, 2606002, 'GARANHUNS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2851, 16, 2606101, 'GLÓRIA DO GOITÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2852, 16, 2606200, 'GOIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2853, 16, 2606309, 'GRANITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2854, 16, 2606408, 'GRAVATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2855, 16, 2606507, 'IATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2856, 16, 2606606, 'IBIMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2857, 16, 2606705, 'IBIRAJUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2858, 16, 2606804, 'IGARASSU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2859, 16, 2606903, 'IGUARACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2860, 16, 2607604, 'ILHA DE ITAMARACÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2861, 16, 2607000, 'INAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2862, 16, 2607109, 'INGAZEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2863, 16, 2607208, 'IPOJUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2864, 16, 2607307, 'IPUBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2865, 16, 2607406, 'ITACURUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2866, 16, 2607505, 'ITAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2867, 16, 2607653, 'ITAMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2868, 16, 2607703, 'ITAPETIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2869, 16, 2607752, 'ITAPISSUMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2870, 16, 2607802, 'ITAQUITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2871, 16, 2607901, 'JABOATÃO DOS GUARARAPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2872, 16, 2607950, 'JAQUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2873, 16, 2608008, 'JATAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2874, 16, 2608057, 'JATOBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2875, 16, 2608107, 'JOÃO ALFREDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2876, 16, 2608206, 'JOAQUIM NABUCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2877, 16, 2608255, 'JUCATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2878, 16, 2608305, 'JUPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2879, 16, 2608404, 'JUREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2880, 16, 2608453, 'LAGOA DO CARRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2881, 16, 2608503, 'LAGOA DE ITAENGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2882, 16, 2608602, 'LAGOA DO OURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2883, 16, 2608701, 'LAGOA DOS GATOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2884, 16, 2608750, 'LAGOA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2885, 16, 2608800, 'LAJEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2886, 16, 2608909, 'LIMOEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2887, 16, 2609006, 'MACAPARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2888, 16, 2609105, 'MACHADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2889, 16, 2609154, 'MANARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2890, 16, 2609204, 'MARAIAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2891, 16, 2609303, 'MIRANDIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2892, 16, 2614303, 'MOREILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2893, 16, 2609402, 'MORENO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2894, 16, 2609501, 'NAZARÉ DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2895, 16, 2609600, 'OLINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2896, 16, 2609709, 'OROBÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2897, 16, 2609808, 'OROCÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2898, 16, 2609907, 'OURICURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2899, 16, 2610004, 'PALMARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2900, 16, 2610103, 'PALMEIRINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2901, 16, 2610202, 'PANELAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2902, 16, 2610301, 'PARANATAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2903, 16, 2610400, 'PARNAMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2904, 16, 2610509, 'PASSIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2905, 16, 2610608, 'PAUDALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2906, 16, 2610707, 'PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2907, 16, 2610806, 'PEDRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2908, 16, 2610905, 'PESQUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2909, 16, 2611002, 'PETROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2910, 16, 2611101, 'PETROLINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2911, 16, 2611200, 'POÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2912, 16, 2611309, 'POMBOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2913, 16, 2611408, 'PRIMAVERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2914, 16, 2611507, 'QUIPAPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2915, 16, 2611533, 'QUIXABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2916, 16, 2611606, 'RECIFE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2917, 16, 2611705, 'RIACHO DAS ALMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2918, 16, 2611804, 'RIBEIRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2919, 16, 2611903, 'RIO FORMOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2920, 16, 2612000, 'SAIRÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2921, 16, 2612109, 'SALGADINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2922, 16, 2612208, 'SALGUEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2923, 16, 2612307, 'SALOÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2924, 16, 2612406, 'SANHARÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2925, 16, 2612455, 'SANTA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2926, 16, 2612471, 'SANTA CRUZ DA BAIXA VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2927, 16, 2612505, 'SANTA CRUZ DO CAPIBARIBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2928, 16, 2612554, 'SANTA FILOMENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2929, 16, 2612604, 'SANTA MARIA DA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2930, 16, 2612703, 'SANTA MARIA DO CAMBUCÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2931, 16, 2612802, 'SANTA TEREZINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2932, 16, 2612901, 'SÃO BENEDITO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2933, 16, 2613008, 'SÃO BENTO DO UNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2934, 16, 2613107, 'SÃO CAITANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2935, 16, 2613206, 'SÃO JOÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2936, 16, 2613305, 'SÃO JOAQUIM DO MONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2937, 16, 2613404, 'SÃO JOSÉ DA COROA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2938, 16, 2613503, 'SÃO JOSÉ DO BELMONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2939, 16, 2613602, 'SÃO JOSÉ DO EGITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2940, 16, 2613701, 'SÃO LOURENÇO DA MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2941, 16, 2613800, 'SÃO VICENTE FERRER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2942, 16, 2613909, 'SERRA TALHADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2943, 16, 2614006, 'SERRITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2944, 16, 2614105, 'SERTÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2945, 16, 2614204, 'SIRINHAÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2946, 16, 2614402, 'SOLIDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2947, 16, 2614501, 'SURUBIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2948, 16, 2614600, 'TABIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2949, 16, 2614709, 'TACAIMBÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2950, 16, 2614808, 'TACARATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2951, 16, 2614857, 'TAMANDARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2952, 16, 2615003, 'TAQUARITINGA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2953, 16, 2615102, 'TEREZINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2954, 16, 2615201, 'TERRA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2955, 16, 2615300, 'TIMBAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2956, 16, 2615409, 'TORITAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2957, 16, 2615508, 'TRACUNHAÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2958, 16, 2615607, 'TRINDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2959, 16, 2615706, 'TRIUNFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2960, 16, 2615805, 'TUPANATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2961, 16, 2615904, 'TUPARETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2962, 16, 2616001, 'VENTUROSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2963, 16, 2616100, 'VERDEJANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2964, 16, 2616183, 'VERTENTE DO LÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2965, 16, 2616209, 'VERTENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2966, 16, 2616308, 'VICÊNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2967, 16, 2616407, 'VITÓRIA DE SANTO ANTÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2968, 16, 2616506, 'XEXÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2969, 17, 2200053, 'ACAUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2970, 17, 2200103, 'AGRICOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2971, 17, 2200202, 'ÁGUA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2972, 17, 2200251, 'ALAGOINHA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2973, 17, 2200277, 'ALEGRETE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2974, 17, 2200301, 'ALTO LONGÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2975, 17, 2200400, 'ALTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2976, 17, 2200459, 'ALVORADA DO GURGUÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2977, 17, 2200509, 'AMARANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2978, 17, 2200608, 'ANGICAL DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2979, 17, 2200707, 'ANÍSIO DE ABREU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2980, 17, 2200806, 'ANTÔNIO ALMEIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2981, 17, 2200905, 'AROAZES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2982, 17, 2200954, 'AROEIRAS DO ITAIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2983, 17, 2201002, 'ARRAIAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2984, 17, 2201051, 'ASSUNÇÃO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2985, 17, 2201101, 'AVELINO LOPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2986, 17, 2201150, 'BAIXA GRANDE DO RIBEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2987, 17, 2201176, 'BARRA D\'ALCÂNTARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2988, 17, 2201200, 'BARRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2989, 17, 2201309, 'BARREIRAS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2990, 17, 2201408, 'BARRO DURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2991, 17, 2201507, 'BATALHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2992, 17, 2201556, 'BELA VISTA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2993, 17, 2201572, 'BELÉM DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2994, 17, 2201606, 'BENEDITINOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2995, 17, 2201705, 'BERTOLÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2996, 17, 2201739, 'BETÂNIA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2997, 17, 2201770, 'BOA HORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2998, 17, 2201804, 'BOCAINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(2999, 17, 2201903, 'BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3000, 17, 2201919, 'BOM PRINCÍPIO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3001, 17, 2201929, 'BONFIM DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3002, 17, 2201945, 'BOQUEIRÃO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3003, 17, 2201960, 'BRASILEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3004, 17, 2201988, 'BREJO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3005, 17, 2202000, 'BURITI DOS LOPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3006, 17, 2202026, 'BURITI DOS MONTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3007, 17, 2202059, 'CABECEIRAS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3008, 17, 2202075, 'CAJAZEIRAS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3009, 17, 2202083, 'CAJUEIRO DA PRAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3010, 17, 2202091, 'CALDEIRÃO GRANDE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3011, 17, 2202109, 'CAMPINAS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3012, 17, 2202117, 'CAMPO ALEGRE DO FIDALGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3013, 17, 2202133, 'CAMPO GRANDE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3014, 17, 2202174, 'CAMPO LARGO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3015, 17, 2202208, 'CAMPO MAIOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3016, 17, 2202251, 'CANAVIEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3017, 17, 2202307, 'CANTO DO BURITI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3018, 17, 2202406, 'CAPITÃO DE CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3019, 17, 2202455, 'CAPITÃO GERVÁSIO OLIVEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3020, 17, 2202505, 'CARACOL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3021, 17, 2202539, 'CARAÚBAS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3022, 17, 2202554, 'CARIDADE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3023, 17, 2202604, 'CASTELO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3024, 17, 2202653, 'CAXINGÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3025, 17, 2202703, 'COCAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3026, 17, 2202711, 'COCAL DE TELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3027, 17, 2202729, 'COCAL DOS ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3028, 17, 2202737, 'COIVARAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3029, 17, 2202752, 'COLÔNIA DO GURGUÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3030, 17, 2202778, 'COLÔNIA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3031, 17, 2202802, 'CONCEIÇÃO DO CANINDÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3032, 17, 2202851, 'CORONEL JOSÉ DIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3033, 17, 2202901, 'CORRENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3034, 17, 2203008, 'CRISTALÂNDIA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3035, 17, 2203107, 'CRISTINO CASTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3036, 17, 2203206, 'CURIMATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3037, 17, 2203230, 'CURRAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3038, 17, 2203271, 'CURRAL NOVO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3039, 17, 2203255, 'CURRALINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3040, 17, 2203305, 'DEMERVAL LOBÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3041, 17, 2203354, 'DIRCEU ARCOVERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3042, 17, 2203404, 'DOM EXPEDITO LOPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3043, 17, 2203453, 'DOM INOCÊNCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3044, 17, 2203420, 'DOMINGOS MOURÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3045, 17, 2203503, 'ELESBÃO VELOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3046, 17, 2203602, 'ELISEU MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3047, 17, 2203701, 'ESPERANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3048, 17, 2203750, 'FARTURA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3049, 17, 2203800, 'FLORES DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3050, 17, 2203859, 'FLORESTA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3051, 17, 2203909, 'FLORIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3052, 17, 2204006, 'FRANCINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3053, 17, 2204105, 'FRANCISCO AYRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3054, 17, 2204154, 'FRANCISCO MACEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3055, 17, 2204204, 'FRANCISCO SANTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3056, 17, 2204303, 'FRONTEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3057, 17, 2204352, 'GEMINIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3058, 17, 2204402, 'GILBUÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3059, 17, 2204501, 'GUADALUPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3060, 17, 2204550, 'GUARIBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3061, 17, 2204600, 'HUGO NAPOLEÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3062, 17, 2204659, 'ILHA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3063, 17, 2204709, 'INHUMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3064, 17, 2204808, 'IPIRANGA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3065, 17, 2204907, 'ISAÍAS COELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3066, 17, 2205003, 'ITAINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3067, 17, 2205102, 'ITAUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3068, 17, 2205151, 'JACOBINA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3069, 17, 2205201, 'JAICÓS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3070, 17, 2205250, 'JARDIM DO MULATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3071, 17, 2205276, 'JATOBÁ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3072, 17, 2205300, 'JERUMENHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3073, 17, 2205359, 'JOÃO COSTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3074, 17, 2205409, 'JOAQUIM PIRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3075, 17, 2205458, 'JOCA MARQUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3076, 17, 2205508, 'JOSÉ DE FREITAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3077, 17, 2205516, 'JUAZEIRO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3078, 17, 2205524, 'JÚLIO BORGES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3079, 17, 2205532, 'JUREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3080, 17, 2205557, 'LAGOA ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3081, 17, 2205573, 'LAGOA DE SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3082, 17, 2205565, 'LAGOA DO BARRO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3083, 17, 2205581, 'LAGOA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3084, 17, 2205599, 'LAGOA DO SÍTIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3085, 17, 2205540, 'LAGOINHA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3086, 17, 2205607, 'LANDRI SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3087, 17, 2205706, 'LUÍS CORREIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3088, 17, 2205805, 'LUZILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3089, 17, 2205854, 'MADEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3090, 17, 2205904, 'MANOEL EMÍDIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3091, 17, 2205953, 'MARCOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3092, 17, 2206001, 'MARCOS PARENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3093, 17, 2206050, 'MASSAPÊ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3094, 17, 2206100, 'MATIAS OLÍMPIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3095, 17, 2206209, 'MIGUEL ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3096, 17, 2206308, 'MIGUEL LEÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3097, 17, 2206357, 'MILTON BRANDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3098, 17, 2206407, 'MONSENHOR GIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3099, 17, 2206506, 'MONSENHOR HIPÓLITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3100, 17, 2206605, 'MONTE ALEGRE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3101, 17, 2206654, 'MORRO CABEÇA NO TEMPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3102, 17, 2206670, 'MORRO DO CHAPÉU DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3103, 17, 2206696, 'MURICI DOS PORTELAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3104, 17, 2206704, 'NAZARÉ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3105, 17, 2206720, 'NAZÁRIA ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3106, 17, 2206753, 'NOSSA SENHORA DE NAZARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3107, 17, 2206803, 'NOSSA SENHORA DOS REMÉDIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3108, 17, 2207959, 'NOVA SANTA RITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3109, 17, 2206902, 'NOVO ORIENTE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3110, 17, 2206951, 'NOVO SANTO ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3111, 17, 2207009, 'OEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3112, 17, 2207108, 'OLHO D\'ÁGUA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3113, 17, 2207207, 'PADRE MARCOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3114, 17, 2207306, 'PAES LANDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3115, 17, 2207355, 'PAJEÚ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3116, 17, 2207405, 'PALMEIRA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3117, 17, 2207504, 'PALMEIRAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3118, 17, 2207553, 'PAQUETÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3119, 17, 2207603, 'PARNAGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3120, 17, 2207702, 'PARNAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3121, 17, 2207751, 'PASSAGEM FRANCA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3122, 17, 2207777, 'PATOS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3123, 17, 2207793, 'PAU D\'ARCO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3124, 17, 2207801, 'PAULISTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3125, 17, 2207850, 'PAVUSSU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3126, 17, 2207900, 'PEDRO II', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3127, 17, 2207934, 'PEDRO LAURENTINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3128, 17, 2208007, 'PICOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3129, 17, 2208106, 'PIMENTEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3130, 17, 2208205, 'PIO IX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3131, 17, 2208304, 'PIRACURUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3132, 17, 2208403, 'PIRIPIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3133, 17, 2208502, 'PORTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3134, 17, 2208551, 'PORTO ALEGRE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3135, 17, 2208601, 'PRATA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3136, 17, 2208650, 'QUEIMADA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3137, 17, 2208700, 'REDENÇÃO DO GURGUÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3138, 17, 2208809, 'REGENERAÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3139, 17, 2208858, 'RIACHO FRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3140, 17, 2208874, 'RIBEIRA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3141, 17, 2208908, 'RIBEIRO GONÇALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3142, 17, 2209005, 'RIO GRANDE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3143, 17, 2209104, 'SANTA CRUZ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3144, 17, 2209153, 'SANTA CRUZ DOS MILAGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3145, 17, 2209203, 'SANTA FILOMENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3146, 17, 2209302, 'SANTA LUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3147, 17, 2209377, 'SANTA ROSA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3148, 17, 2209351, 'SANTANA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3149, 17, 2209401, 'SANTO ANTÔNIO DE LISBOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3150, 17, 2209450, 'SANTO ANTÔNIO DOS MILAGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3151, 17, 2209500, 'SANTO INÁCIO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3152, 17, 2209559, 'SÃO BRAZ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3153, 17, 2209609, 'SÃO FÉLIX DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3154, 17, 2209658, 'SÃO FRANCISCO DE ASSIS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3155, 17, 2209708, 'SÃO FRANCISCO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3156, 17, 2209757, 'SÃO GONÇALO DO GURGUÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3157, 17, 2209807, 'SÃO GONÇALO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3158, 17, 2209856, 'SÃO JOÃO DA CANABRAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3159, 17, 2209872, 'SÃO JOÃO DA FRONTEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3160, 17, 2209906, 'SÃO JOÃO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3161, 17, 2209955, 'SÃO JOÃO DA VARJOTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3162, 17, 2209971, 'SÃO JOÃO DO ARRAIAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3163, 17, 2210003, 'SÃO JOÃO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3164, 17, 2210052, 'SÃO JOSÉ DO DIVINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3165, 17, 2210102, 'SÃO JOSÉ DO PEIXE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3166, 17, 2210201, 'SÃO JOSÉ DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3167, 17, 2210300, 'SÃO JULIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3168, 17, 2210359, 'SÃO LOURENÇO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3169, 17, 2210375, 'SÃO LUIS DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3170, 17, 2210383, 'SÃO MIGUEL DA BAIXA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3171, 17, 2210391, 'SÃO MIGUEL DO FIDALGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3172, 17, 2210409, 'SÃO MIGUEL DO TAPUIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3173, 17, 2210508, 'SÃO PEDRO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3174, 17, 2210607, 'SÃO RAIMUNDO NONATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3175, 17, 2210623, 'SEBASTIÃO BARROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3176, 17, 2210631, 'SEBASTIÃO LEAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3177, 17, 2210656, 'SIGEFREDO PACHECO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3178, 17, 2210706, 'SIMÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3179, 17, 2210805, 'SIMPLÍCIO MENDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3180, 17, 2210904, 'SOCORRO DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3181, 17, 2210938, 'SUSSUAPARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3182, 17, 2210953, 'TAMBORIL DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3183, 17, 2210979, 'TANQUE DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3184, 17, 2211001, 'TERESINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3185, 17, 2211100, 'UNIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3186, 17, 2211209, 'URUÇUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3187, 17, 2211308, 'VALENÇA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3188, 17, 2211357, 'VÁRZEA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3189, 17, 2211407, 'VÁRZEA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3190, 17, 2211506, 'VERA MENDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3191, 17, 2211605, 'VILA NOVA DO PIAUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3192, 17, 2211704, 'WALL FERRAZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3193, 18, 4100103, 'ABATIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3194, 18, 4100202, 'ADRIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3195, 18, 4100301, 'AGUDOS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3196, 18, 4100400, 'ALMIRANTE TAMANDARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3197, 18, 4100459, 'ALTAMIRA DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3198, 18, 4128625, 'ALTO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3199, 18, 4100608, 'ALTO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3200, 18, 4100707, 'ALTO PIQUIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3201, 18, 4100509, 'ALTÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3202, 18, 4100806, 'ALVORADA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3203, 18, 4100905, 'AMAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3204, 18, 4101002, 'AMPÉRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3205, 18, 4101051, 'ANAHY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3206, 18, 4101101, 'ANDIRÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3207, 18, 4101150, 'ÂNGULO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3208, 18, 4101200, 'ANTONINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3209, 18, 4101309, 'ANTÔNIO OLINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3210, 18, 4101408, 'APUCARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3211, 18, 4101507, 'ARAPONGAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3212, 18, 4101606, 'ARAPOTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3213, 18, 4101655, 'ARAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3214, 18, 4101705, 'ARARUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3215, 18, 4101804, 'ARAUCÁRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3216, 18, 4101853, 'ARIRANHA DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3217, 18, 4101903, 'ASSAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3218, 18, 4102000, 'ASSIS CHATEAUBRIAND', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3219, 18, 4102109, 'ASTORGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3220, 18, 4102208, 'ATALAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3221, 18, 4102307, 'BALSA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3222, 18, 4102406, 'BANDEIRANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3223, 18, 4102505, 'BARBOSA FERRAZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3224, 18, 4102703, 'BARRA DO JACARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3225, 18, 4102604, 'BARRACÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3226, 18, 4102752, 'BELA VISTA DA CAROBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3227, 18, 4102802, 'BELA VISTA DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3228, 18, 4102901, 'BITURUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3229, 18, 4103008, 'BOA ESPERANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3230, 18, 4103024, 'BOA ESPERANÇA DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3231, 18, 4103040, 'BOA VENTURA DE SÃO ROQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3232, 18, 4103057, 'BOA VISTA DA APARECIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3233, 18, 4103107, 'BOCAIÚVA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3234, 18, 4103156, 'BOM JESUS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3235, 18, 4103206, 'BOM SUCESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3236, 18, 4103222, 'BOM SUCESSO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3237, 18, 4103305, 'BORRAZÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3238, 18, 4103354, 'BRAGANEY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3239, 18, 4103370, 'BRASILÂNDIA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3240, 18, 4103404, 'CAFEARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3241, 18, 4103453, 'CAFELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3242, 18, 4103479, 'CAFEZAL DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3243, 18, 4103503, 'CALIFÓRNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3244, 18, 4103602, 'CAMBARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3245, 18, 4103701, 'CAMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3246, 18, 4103800, 'CAMBIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3247, 18, 4103909, 'CAMPINA DA LAGOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3248, 18, 4103958, 'CAMPINA DO SIMÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3249, 18, 4104006, 'CAMPINA GRANDE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3250, 18, 4104055, 'CAMPO BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3251, 18, 4104105, 'CAMPO DO TENENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3252, 18, 4104204, 'CAMPO LARGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3253, 18, 4104253, 'CAMPO MAGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3254, 18, 4104303, 'CAMPO MOURÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3255, 18, 4104402, 'CÂNDIDO DE ABREU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3256, 18, 4104428, 'CANDÓI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3257, 18, 4104451, 'CANTAGALO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3258, 18, 4104501, 'CAPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3259, 18, 4104600, 'CAPITÃO LEÔNIDAS MARQUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3260, 18, 4104659, 'CARAMBEÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3261, 18, 4104709, 'CARLÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3262, 18, 4104808, 'CASCAVEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3263, 18, 4104907, 'CASTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3264, 18, 4105003, 'CATANDUVAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3265, 18, 4105102, 'CENTENÁRIO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3266, 18, 4105201, 'CERRO AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3267, 18, 4105300, 'CÉU AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3268, 18, 4105409, 'CHOPINZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3269, 18, 4105508, 'CIANORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3270, 18, 4105607, 'CIDADE GAÚCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3271, 18, 4105706, 'CLEVELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3272, 18, 4105805, 'COLOMBO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3273, 18, 4105904, 'COLORADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3274, 18, 4106001, 'CONGONHINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3275, 18, 4106100, 'CONSELHEIRO MAIRINCK', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3276, 18, 4106209, 'CONTENDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3277, 18, 4106308, 'CORBÉLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3278, 18, 4106407, 'CORNÉLIO PROCÓPIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3279, 18, 4106456, 'CORONEL DOMINGOS SOARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3280, 18, 4106506, 'CORONEL VIVIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3281, 18, 4106555, 'CORUMBATAÍ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3282, 18, 4106803, 'CRUZ MACHADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3283, 18, 4106571, 'CRUZEIRO DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3284, 18, 4106605, 'CRUZEIRO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3285, 18, 4106704, 'CRUZEIRO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3286, 18, 4106852, 'CRUZMALTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3287, 18, 4106902, 'CURITIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3288, 18, 4107009, 'CURIÚVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3289, 18, 4107108, 'DIAMANTE DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3290, 18, 4107124, 'DIAMANTE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3291, 18, 4107157, 'DIAMANTE D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3292, 18, 4107207, 'DOIS VIZINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3293, 18, 4107256, 'DOURADINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3294, 18, 4107306, 'DOUTOR CAMARGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3295, 18, 4128633, 'DOUTOR ULYSSES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3296, 18, 4107405, 'ENÉAS MARQUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3297, 18, 4107504, 'ENGENHEIRO BELTRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3298, 18, 4107538, 'ENTRE RIOS DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3299, 18, 4107520, 'ESPERANÇA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3300, 18, 4107546, 'ESPIGÃO ALTO DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3301, 18, 4107553, 'FAROL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3302, 18, 4107603, 'FAXINAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3303, 18, 4107652, 'FAZENDA RIO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3304, 18, 4107702, 'FÊNIX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3305, 18, 4107736, 'FERNANDES PINHEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3306, 18, 4107751, 'FIGUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3307, 18, 4107850, 'FLOR DA SERRA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3308, 18, 4107801, 'FLORAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3309, 18, 4107900, 'FLORESTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3310, 18, 4108007, 'FLORESTÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3311, 18, 4108106, 'FLÓRIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3312, 18, 4108205, 'FORMOSA DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3313, 18, 4108304, 'FOZ DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3314, 18, 4108452, 'FOZ DO JORDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3315, 18, 4108320, 'FRANCISCO ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3316, 18, 4108403, 'FRANCISCO BELTRÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3317, 18, 4108502, 'GENERAL CARNEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3318, 18, 4108551, 'GODOY MOREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3319, 18, 4108601, 'GOIOERÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3320, 18, 4108650, 'GOIOXIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3321, 18, 4108700, 'GRANDES RIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3322, 18, 4108809, 'GUAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3323, 18, 4108908, 'GUAIRAÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3324, 18, 4108957, 'GUAMIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3325, 18, 4109005, 'GUAPIRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3326, 18, 4109104, 'GUAPOREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3327, 18, 4109203, 'GUARACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3328, 18, 4109302, 'GUARANIAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3329, 18, 4109401, 'GUARAPUAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3330, 18, 4109500, 'GUARAQUEÇABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3331, 18, 4109609, 'GUARATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3332, 18, 4109658, 'HONÓRIO SERPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3333, 18, 4109708, 'IBAITI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3334, 18, 4109757, 'IBEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3335, 18, 4109807, 'IBIPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3336, 18, 4109906, 'ICARAÍMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3337, 18, 4110003, 'IGUARAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3338, 18, 4110052, 'IGUATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3339, 18, 4110078, 'IMBAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3340, 18, 4110102, 'IMBITUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3341, 18, 4110201, 'INÁCIO MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3342, 18, 4110300, 'INAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3343, 18, 4110409, 'INDIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3344, 18, 4110508, 'IPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3345, 18, 4110607, 'IPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3346, 18, 4110656, 'IRACEMA DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3347, 18, 4110706, 'IRATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3348, 18, 4110805, 'IRETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3349, 18, 4110904, 'ITAGUAJÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3350, 18, 4110953, 'ITAIPULÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3351, 18, 4111001, 'ITAMBARACÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3352, 18, 4111100, 'ITAMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3353, 18, 4111209, 'ITAPEJARA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3354, 18, 4111258, 'ITAPERUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3355, 18, 4111308, 'ITAÚNA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3356, 18, 4111407, 'IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3357, 18, 4111506, 'IVAIPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3358, 18, 4111555, 'IVATÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3359, 18, 4111605, 'IVATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3360, 18, 4111704, 'JABOTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3361, 18, 4111803, 'JACAREZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3362, 18, 4111902, 'JAGUAPITÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3363, 18, 4112009, 'JAGUARIAÍVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3364, 18, 4112108, 'JANDAIA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3365, 18, 4112207, 'JANIÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3366, 18, 4112306, 'JAPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3367, 18, 4112405, 'JAPURÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3368, 18, 4112504, 'JARDIM ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3369, 18, 4112603, 'JARDIM OLINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3370, 18, 4112702, 'JATAIZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3371, 18, 4112751, 'JESUÍTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3372, 18, 4112801, 'JOAQUIM TÁVORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3373, 18, 4112900, 'JUNDIAÍ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3374, 18, 4112959, 'JURANDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3375, 18, 4113007, 'JUSSARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3376, 18, 4113106, 'KALORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3377, 18, 4113205, 'LAPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3378, 18, 4113254, 'LARANJAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3379, 18, 4113304, 'LARANJEIRAS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3380, 18, 4113403, 'LEÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3381, 18, 4113429, 'LIDIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3382, 18, 4113452, 'LINDOESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3383, 18, 4113502, 'LOANDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3384, 18, 4113601, 'LOBATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3385, 18, 4113700, 'LONDRINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3386, 18, 4113734, 'LUIZIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3387, 18, 4113759, 'LUNARDELLI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3388, 18, 4113809, 'LUPIONÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3389, 18, 4113908, 'MALLET', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3390, 18, 4114005, 'MAMBORÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3391, 18, 4114104, 'MANDAGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3392, 18, 4114203, 'MANDAGUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3393, 18, 4114302, 'MANDIRITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3394, 18, 4114351, 'MANFRINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3395, 18, 4114401, 'MANGUEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3396, 18, 4114500, 'MANOEL RIBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3397, 18, 4114609, 'MARECHAL CÂNDIDO RONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3398, 18, 4114708, 'MARIA HELENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3399, 18, 4114807, 'MARIALVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3400, 18, 4114906, 'MARILÂNDIA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3401, 18, 4115002, 'MARILENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3402, 18, 4115101, 'MARILUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3403, 18, 4115200, 'MARINGÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3404, 18, 4115309, 'MARIÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3405, 18, 4115358, 'MARIPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3406, 18, 4115408, 'MARMELEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3407, 18, 4115457, 'MARQUINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3408, 18, 4115507, 'MARUMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3409, 18, 4115606, 'MATELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3410, 18, 4115705, 'MATINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3411, 18, 4115739, 'MATO RICO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3412, 18, 4115754, 'MAUÁ DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3413, 18, 4115804, 'MEDIANEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3414, 18, 4115853, 'MERCEDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3415, 18, 4115903, 'MIRADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3416, 18, 4116000, 'MIRASELVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3417, 18, 4116059, 'MISSAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3418, 18, 4116109, 'MOREIRA SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3419, 18, 4116208, 'MORRETES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3420, 18, 4116307, 'MUNHOZ DE MELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3421, 18, 4116406, 'NOSSA SENHORA DAS GRAÇAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3422, 18, 4116505, 'NOVA ALIANÇA DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3423, 18, 4116604, 'NOVA AMÉRICA DA COLINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3424, 18, 4116703, 'NOVA AURORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3425, 18, 4116802, 'NOVA CANTU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3426, 18, 4116901, 'NOVA ESPERANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3427, 18, 4116950, 'NOVA ESPERANÇA DO SUDOESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3428, 18, 4117008, 'NOVA FÁTIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3429, 18, 4117057, 'NOVA LARANJEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3430, 18, 4117107, 'NOVA LONDRINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3431, 18, 4117206, 'NOVA OLÍMPIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3432, 18, 4117255, 'NOVA PRATA DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3433, 18, 4117214, 'NOVA SANTA BÁRBARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3434, 18, 4117222, 'NOVA SANTA ROSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3435, 18, 4117271, 'NOVA TEBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3436, 18, 4117297, 'NOVO ITACOLOMI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3437, 18, 4117305, 'ORTIGUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3438, 18, 4117404, 'OURIZONA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3439, 18, 4117453, 'OURO VERDE DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3440, 18, 4117503, 'PAIÇANDU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3441, 18, 4117602, 'PALMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3442, 18, 4117701, 'PALMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3443, 18, 4117800, 'PALMITAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3444, 18, 4117909, 'PALOTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3445, 18, 4118006, 'PARAÍSO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3446, 18, 4118105, 'PARANACITY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3447, 18, 4118204, 'PARANAGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3448, 18, 4118303, 'PARANAPOEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3449, 18, 4118402, 'PARANAVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3450, 18, 4118451, 'PATO BRAGADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3451, 18, 4118501, 'PATO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3452, 18, 4118600, 'PAULA FREITAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3453, 18, 4118709, 'PAULO FRONTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3454, 18, 4118808, 'PEABIRU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3455, 18, 4118857, 'PEROBAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3456, 18, 4118907, 'PÉROLA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3457, 18, 4119004, 'PÉROLA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3458, 18, 4119103, 'PIÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3459, 18, 4119152, 'PINHAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3460, 18, 4119251, 'PINHAL DE SÃO BENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3461, 18, 4119202, 'PINHALÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3462, 18, 4119301, 'PINHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3463, 18, 4119400, 'PIRAÍ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3464, 18, 4119509, 'PIRAQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3465, 18, 4119608, 'PITANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3466, 18, 4119657, 'PITANGUEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3467, 18, 4119707, 'PLANALTINA DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3468, 18, 4119806, 'PLANALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3469, 18, 4119905, 'PONTA GROSSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3470, 18, 4119954, 'PONTAL DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3471, 18, 4120002, 'PORECATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3472, 18, 4120101, 'PORTO AMAZONAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3473, 18, 4120150, 'PORTO BARREIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3474, 18, 4120200, 'PORTO RICO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3475, 18, 4120309, 'PORTO VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3476, 18, 4120333, 'PRADO FERREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3477, 18, 4120358, 'PRANCHITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3478, 18, 4120408, 'PRESIDENTE CASTELO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3479, 18, 4120507, 'PRIMEIRO DE MAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3480, 18, 4120606, 'PRUDENTÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3481, 18, 4120655, 'QUARTO CENTENÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3482, 18, 4120705, 'QUATIGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3483, 18, 4120804, 'QUATRO BARRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3484, 18, 4120853, 'QUATRO PONTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3485, 18, 4120903, 'QUEDAS DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3486, 18, 4121000, 'QUERÊNCIA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3487, 18, 4121109, 'QUINTA DO SOL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3488, 18, 4121208, 'QUITANDINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3489, 18, 4121257, 'RAMILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3490, 18, 4121307, 'RANCHO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3491, 18, 4121356, 'RANCHO ALEGRE D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3492, 18, 4121406, 'REALEZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3493, 18, 4121505, 'REBOUÇAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3494, 18, 4121604, 'RENASCENÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3495, 18, 4121703, 'RESERVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3496, 18, 4121752, 'RESERVA DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3497, 18, 4121802, 'RIBEIRÃO CLARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3498, 18, 4121901, 'RIBEIRÃO DO PINHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3499, 18, 4122008, 'RIO AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3500, 18, 4122107, 'RIO BOM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3501, 18, 4122156, 'RIO BONITO DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3502, 18, 4122172, 'RIO BRANCO DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3503, 18, 4122206, 'RIO BRANCO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3504, 18, 4122305, 'RIO NEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3505, 18, 4122404, 'ROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3506, 18, 4122503, 'RONCADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3507, 18, 4122602, 'RONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3508, 18, 4122651, 'ROSÁRIO DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3509, 18, 4122701, 'SABÁUDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3510, 18, 4122800, 'SALGADO FILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3511, 18, 4122909, 'SALTO DO ITARARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3512, 18, 4123006, 'SALTO DO LONTRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3513, 18, 4123105, 'SANTA AMÉLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3514, 18, 4123204, 'SANTA CECÍLIA DO PAVÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3515, 18, 4123303, 'SANTA CRUZ DE MONTE CASTELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3516, 18, 4123402, 'SANTA FÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3517, 18, 4123501, 'SANTA HELENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3518, 18, 4123600, 'SANTA INÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3519, 18, 4123709, 'SANTA ISABEL DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3520, 18, 4123808, 'SANTA IZABEL DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3521, 18, 4123824, 'SANTA LÚCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3522, 18, 4123857, 'SANTA MARIA DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3523, 18, 4123907, 'SANTA MARIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3524, 18, 4123956, 'SANTA MÔNICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3525, 18, 4124020, 'SANTA TEREZA DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3526, 18, 4124053, 'SANTA TEREZINHA DE ITAIPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3527, 18, 4124004, 'SANTANA DO ITARARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3528, 18, 4124103, 'SANTO ANTÔNIO DA PLATINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3529, 18, 4124202, 'SANTO ANTÔNIO DO CAIUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3530, 18, 4124301, 'SANTO ANTÔNIO DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3531, 18, 4124400, 'SANTO ANTÔNIO DO SUDOESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3532, 18, 4124509, 'SANTO INÁCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3533, 18, 4124608, 'SÃO CARLOS DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3534, 18, 4124707, 'SÃO JERÔNIMO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3535, 18, 4124806, 'SÃO JOÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3536, 18, 4124905, 'SÃO JOÃO DO CAIUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3537, 18, 4125001, 'SÃO JOÃO DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3538, 18, 4125100, 'SÃO JOÃO DO TRIUNFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3539, 18, 4125308, 'SÃO JORGE DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3540, 18, 4125357, 'SÃO JORGE DO PATROCÍNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3541, 18, 4125209, 'SÃO JORGE D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3542, 18, 4125407, 'SÃO JOSÉ DA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3543, 18, 4125456, 'SÃO JOSÉ DAS PALMEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3544, 18, 4125506, 'SÃO JOSÉ DOS PINHAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3545, 18, 4125555, 'SÃO MANOEL DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3546, 18, 4125605, 'SÃO MATEUS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3547, 18, 4125704, 'SÃO MIGUEL DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3548, 18, 4125753, 'SÃO PEDRO DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3549, 18, 4125803, 'SÃO PEDRO DO IVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3550, 18, 4125902, 'SÃO PEDRO DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3551, 18, 4126009, 'SÃO SEBASTIÃO DA AMOREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3552, 18, 4126108, 'SÃO TOMÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3553, 18, 4126207, 'SAPOPEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3554, 18, 4126256, 'SARANDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3555, 18, 4126272, 'SAUDADE DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3556, 18, 4126306, 'SENGÉS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3557, 18, 4126355, 'SERRANÓPOLIS DO IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3558, 18, 4126405, 'SERTANEJA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3559, 18, 4126504, 'SERTANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3560, 18, 4126603, 'SIQUEIRA CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3561, 18, 4126652, 'SULINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3562, 18, 4126678, 'TAMARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3563, 18, 4126702, 'TAMBOARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3564, 18, 4126801, 'TAPEJARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3565, 18, 4126900, 'TAPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3566, 18, 4127007, 'TEIXEIRA SOARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3567, 18, 4127106, 'TELÊMACO BORBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3568, 18, 4127205, 'TERRA BOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3569, 18, 4127304, 'TERRA RICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3570, 18, 4127403, 'TERRA ROXA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3571, 18, 4127502, 'TIBAGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3572, 18, 4127601, 'TIJUCAS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3573, 18, 4127700, 'TOLEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3574, 18, 4127809, 'TOMAZINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3575, 18, 4127858, 'TRÊS BARRAS DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3576, 18, 4127882, 'TUNAS DO PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3577, 18, 4127908, 'TUNEIRAS DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3578, 18, 4127957, 'TUPÃSSI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3579, 18, 4127965, 'TURVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3580, 18, 4128005, 'UBIRATÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3581, 18, 4128104, 'UMUARAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3582, 18, 4128203, 'UNIÃO DA VITÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3583, 18, 4128302, 'UNIFLOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3584, 18, 4128401, 'URAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3585, 18, 4128534, 'VENTANIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3586, 18, 4128559, 'VERA CRUZ DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3587, 18, 4128609, 'VERÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3588, 18, 4128658, 'VIRMOND', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3589, 18, 4128708, 'VITORINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3590, 18, 4128500, 'WENCESLAU BRAZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3591, 18, 4128807, 'XAMBRÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3592, 19, 3300100, 'ANGRA DOS REIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3593, 19, 3300159, 'APERIBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3594, 19, 3300209, 'ARARUAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3595, 19, 3300225, 'AREAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3596, 19, 3300233, 'ARMAÇÃO DOS BÚZIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3597, 19, 3300258, 'ARRAIAL DO CABO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3598, 19, 3300308, 'BARRA DO PIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3599, 19, 3300407, 'BARRA MANSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3600, 19, 3300456, 'BELFORD ROXO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3601, 19, 3300506, 'BOM JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3602, 19, 3300605, 'BOM JESUS DO ITABAPOANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3603, 19, 3300704, 'CABO FRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3604, 19, 3300803, 'CACHOEIRAS DE MACACU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3605, 19, 3300902, 'CAMBUCI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3606, 19, 3301009, 'CAMPOS DOS GOYTACAZES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3607, 19, 3301108, 'CANTAGALO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3608, 19, 3300936, 'CARAPEBUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3609, 19, 3301157, 'CARDOSO MOREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3610, 19, 3301207, 'CARMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3611, 19, 3301306, 'CASIMIRO DE ABREU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3612, 19, 3300951, 'COMENDADOR LEVY GASPARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3613, 19, 3301405, 'CONCEIÇÃO DE MACABU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3614, 19, 3301504, 'CORDEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3615, 19, 3301603, 'DUAS BARRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3616, 19, 3301702, 'DUQUE DE CAXIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3617, 19, 3301801, 'ENGENHEIRO PAULO DE FRONTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3618, 19, 3301850, 'GUAPIMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3619, 19, 3301876, 'IGUABA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3620, 19, 3301900, 'ITABORAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3621, 19, 3302007, 'ITAGUAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3622, 19, 3302056, 'ITALVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3623, 19, 3302106, 'ITAOCARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3624, 19, 3302205, 'ITAPERUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3625, 19, 3302254, 'ITATIAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3626, 19, 3302270, 'JAPERI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3627, 19, 3302304, 'LAJE DO MURIAÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3628, 19, 3302403, 'MACAÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3629, 19, 3302452, 'MACUCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3630, 19, 3302502, 'MAGÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3631, 19, 3302601, 'MANGARATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3632, 19, 3302700, 'MARICÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3633, 19, 3302809, 'MENDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3634, 19, 3302858, 'MESQUITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3635, 19, 3302908, 'MIGUEL PEREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3636, 19, 3303005, 'MIRACEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3637, 19, 3303104, 'NATIVIDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3638, 19, 3303203, 'NILÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3639, 19, 3303302, 'NITERÓI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3640, 19, 3303401, 'NOVA FRIBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3641, 19, 3303500, 'NOVA IGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3642, 19, 3303609, 'PARACAMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3643, 19, 3303708, 'PARAÍBA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3644, 19, 3303807, 'PARATY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3645, 19, 3303856, 'PATY DO ALFERES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3646, 19, 3303906, 'PETRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3647, 19, 3303955, 'PINHEIRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3648, 19, 3304003, 'PIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3649, 19, 3304102, 'PORCIÚNCULA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3650, 19, 3304110, 'PORTO REAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3651, 19, 3304128, 'QUATIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3652, 19, 3304144, 'QUEIMADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3653, 19, 3304151, 'QUISSAMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3654, 19, 3304201, 'RESENDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3655, 19, 3304300, 'RIO BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3656, 19, 3304409, 'RIO CLARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3657, 19, 3304508, 'RIO DAS FLORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3658, 19, 3304524, 'RIO DAS OSTRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3659, 19, 3304557, 'RIO DE JANEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3660, 19, 3304607, 'SANTA MARIA MADALENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3661, 19, 3304706, 'SANTO ANTÔNIO DE PÁDUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3662, 19, 3304805, 'SÃO FIDÉLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3663, 19, 3304755, 'SÃO FRANCISCO DE ITABAPOANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3664, 19, 3304904, 'SÃO GONÇALO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3665, 19, 3305000, 'SÃO JOÃO DA BARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3666, 19, 3305109, 'SÃO JOÃO DE MERITI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3667, 19, 3305133, 'SÃO JOSÉ DE UBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3668, 19, 3305158, 'SÃO JOSÉ DO VALE DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3669, 19, 3305208, 'SÃO PEDRO DA ALDEIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3670, 19, 3305307, 'SÃO SEBASTIÃO DO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3671, 19, 3305406, 'SAPUCAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3672, 19, 3305505, 'SAQUAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3673, 19, 3305554, 'SEROPÉDICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3674, 19, 3305604, 'SILVA JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3675, 19, 3305703, 'SUMIDOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3676, 19, 3305752, 'TANGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3677, 19, 3305802, 'TERESÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3678, 19, 3305901, 'TRAJANO DE MORAES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3679, 19, 3306008, 'TRÊS RIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3680, 19, 3306107, 'VALENÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3681, 19, 3306156, 'VARRE-SAI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3682, 19, 3306206, 'VASSOURAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3683, 19, 3306305, 'VOLTA REDONDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3684, 20, 2400109, 'ACARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3685, 20, 2400208, 'AÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3686, 20, 2400307, 'AFONSO BEZERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3687, 20, 2400406, 'ÁGUA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3688, 20, 2400505, 'ALEXANDRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3689, 20, 2400604, 'ALMINO AFONSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3690, 20, 2400703, 'ALTO DO RODRIGUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3691, 20, 2400802, 'ANGICOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3692, 20, 2400901, 'ANTÔNIO MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3693, 20, 2401008, 'APODI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3694, 20, 2401107, 'AREIA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3695, 20, 2401206, 'ARÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3696, 20, 2401305, 'AUGUSTO SEVERO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3697, 20, 2401404, 'BAÍA FORMOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3698, 20, 2401453, 'BARAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3699, 20, 2401503, 'BARCELONA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3700, 20, 2401602, 'BENTO FERNANDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3701, 20, 2401651, 'BODÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3702, 20, 2401701, 'BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3703, 20, 2401800, 'BREJINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3704, 20, 2401859, 'CAIÇARA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3705, 20, 2401909, 'CAIÇARA DO RIO DO VENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3706, 20, 2402006, 'CAICÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3707, 20, 2402105, 'CAMPO REDONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3708, 20, 2402204, 'CANGUARETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3709, 20, 2402303, 'CARAÚBAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3710, 20, 2402402, 'CARNAÚBA DOS DANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3711, 20, 2402501, 'CARNAUBAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3712, 20, 2402600, 'CEARÁ-MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3713, 20, 2402709, 'CERRO CORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3714, 20, 2402808, 'CORONEL EZEQUIEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3715, 20, 2402907, 'CORONEL JOÃO PESSOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3716, 20, 2403004, 'CRUZETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3717, 20, 2403103, 'CURRAIS NOVOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3718, 20, 2403202, 'DOUTOR SEVERIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3719, 20, 2403301, 'ENCANTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3720, 20, 2403400, 'EQUADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3721, 20, 2403509, 'ESPÍRITO SANTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3722, 20, 2403608, 'EXTREMOZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3723, 20, 2403707, 'FELIPE GUERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3724, 20, 2403756, 'FERNANDO PEDROZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3725, 20, 2403806, 'FLORÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3726, 20, 2403905, 'FRANCISCO DANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3727, 20, 2404002, 'FRUTUOSO GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3728, 20, 2404101, 'GALINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3729, 20, 2404200, 'GOIANINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3730, 20, 2404309, 'GOVERNADOR DIX-SEPT ROSADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3731, 20, 2404408, 'GROSSOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3732, 20, 2404507, 'GUAMARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3733, 20, 2404606, 'IELMO MARINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3734, 20, 2404705, 'IPANGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3735, 20, 2404804, 'IPUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3736, 20, 2404853, 'ITAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3737, 20, 2404903, 'ITAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3738, 20, 2405009, 'JAÇANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3739, 20, 2405108, 'JANDAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3740, 20, 2405207, 'JANDUÍS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3741, 20, 2405306, 'JANUÁRIO CICCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3742, 20, 2405405, 'JAPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3743, 20, 2405504, 'JARDIM DE ANGICOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3744, 20, 2405603, 'JARDIM DE PIRANHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3745, 20, 2405702, 'JARDIM DO SERIDÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3746, 20, 2405801, 'JOÃO CÂMARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3747, 20, 2405900, 'JOÃO DIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3748, 20, 2406007, 'JOSÉ DA PENHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3749, 20, 2406106, 'JUCURUTU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3750, 20, 2406155, 'JUNDIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3751, 20, 2406205, 'LAGOA D\'ANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3752, 20, 2406304, 'LAGOA DE PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3753, 20, 2406403, 'LAGOA DE VELHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3754, 20, 2406502, 'LAGOA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3755, 20, 2406601, 'LAGOA SALGADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3756, 20, 2406700, 'LAJES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3757, 20, 2406809, 'LAJES PINTADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3758, 20, 2406908, 'LUCRÉCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3759, 20, 2407005, 'LUÍS GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3760, 20, 2407104, 'MACAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3761, 20, 2407203, 'MACAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3762, 20, 2407252, 'MAJOR SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3763, 20, 2407302, 'MARCELINO VIEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3764, 20, 2407401, 'MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3765, 20, 2407500, 'MAXARANGUAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3766, 20, 2407609, 'MESSIAS TARGINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3767, 20, 2407708, 'MONTANHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3768, 20, 2407807, 'MONTE ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3769, 20, 2407906, 'MONTE DAS GAMELEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3770, 20, 2408003, 'MOSSORÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3771, 20, 2408102, 'NATAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3772, 20, 2408201, 'NÍSIA FLORESTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3773, 20, 2408300, 'NOVA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3774, 20, 2408409, 'OLHO-D\'ÁGUA DO BORGES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3775, 20, 2408508, 'OURO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3776, 20, 2408607, 'PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3777, 20, 2408706, 'PARAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3778, 20, 2408805, 'PARAZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3779, 20, 2408904, 'PARELHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3780, 20, 2403251, 'PARNAMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3781, 20, 2409100, 'PASSA E FICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3782, 20, 2409209, 'PASSAGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3783, 20, 2409308, 'PATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3784, 20, 2409407, 'PAU DOS FERROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3785, 20, 2409506, 'PEDRA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3786, 20, 2409605, 'PEDRA PRETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3787, 20, 2409704, 'PEDRO AVELINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3788, 20, 2409803, 'PEDRO VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3789, 20, 2409902, 'PENDÊNCIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3790, 20, 2410009, 'PILÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3791, 20, 2410108, 'POÇO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3792, 20, 2410207, 'PORTALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3793, 20, 2410256, 'PORTO DO MANGUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3794, 20, 2410306, 'PRESIDENTE JUSCELINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3795, 20, 2410405, 'PUREZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3796, 20, 2410504, 'RAFAEL FERNANDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3797, 20, 2410603, 'RAFAEL GODEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3798, 20, 2410702, 'RIACHO DA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3799, 20, 2410801, 'RIACHO DE SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3800, 20, 2410900, 'RIACHUELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3801, 20, 2408953, 'RIO DO FOGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3802, 20, 2411007, 'RODOLFO FERNANDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3803, 20, 2411106, 'RUY BARBOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3804, 20, 2411205, 'SANTA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3805, 20, 2409332, 'SANTA MARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3806, 20, 2411403, 'SANTANA DO MATOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3807, 20, 2411429, 'SANTANA DO SERIDÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3808, 20, 2411502, 'SANTO ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3809, 20, 2411601, 'SÃO BENTO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3810, 20, 2411700, 'SÃO BENTO DO TRAIRÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3811, 20, 2411809, 'SÃO FERNANDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3812, 20, 2411908, 'SÃO FRANCISCO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3813, 20, 2412005, 'SÃO GONÇALO DO AMARANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3814, 20, 2412104, 'SÃO JOÃO DO SABUGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3815, 20, 2412203, 'SÃO JOSÉ DE MIPIBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3816, 20, 2412302, 'SÃO JOSÉ DO CAMPESTRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3817, 20, 2412401, 'SÃO JOSÉ DO SERIDÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3818, 20, 2412500, 'SÃO MIGUEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3819, 20, 2412559, 'SÃO MIGUEL DO GOSTOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3820, 20, 2412609, 'SÃO PAULO DO POTENGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3821, 20, 2412708, 'SÃO PEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3822, 20, 2412807, 'SÃO RAFAEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3823, 20, 2412906, 'SÃO TOMÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3824, 20, 2413003, 'SÃO VICENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3825, 20, 2413102, 'SENADOR ELÓI DE SOUZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3826, 20, 2413201, 'SENADOR GEORGINO AVELINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3827, 20, 2413300, 'SERRA DE SÃO BENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3828, 20, 2413359, 'SERRA DO MEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3829, 20, 2413409, 'SERRA NEGRA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3830, 20, 2413508, 'SERRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3831, 20, 2413557, 'SERRINHA DOS PINTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3832, 20, 2413607, 'SEVERIANO MELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3833, 20, 2413706, 'SÍTIO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3834, 20, 2413805, 'TABOLEIRO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3835, 20, 2413904, 'TAIPU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3836, 20, 2414001, 'TANGARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3837, 20, 2414100, 'TENENTE ANANIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3838, 20, 2414159, 'TENENTE LAURENTINO CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3839, 20, 2411056, 'TIBAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3840, 20, 2414209, 'TIBAU DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3841, 20, 2414308, 'TIMBAÚBA DOS BATISTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3842, 20, 2414407, 'TOUROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3843, 20, 2414456, 'TRIUNFO POTIGUAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3844, 20, 2414506, 'UMARIZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3845, 20, 2414605, 'UPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3846, 20, 2414704, 'VÁRZEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3847, 20, 2414753, 'VENHA-VER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3848, 20, 2414803, 'VERA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3849, 20, 2414902, 'VIÇOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3850, 20, 2415008, 'VILA FLOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3851, 21, 1100015, 'ALTA FLORESTA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3852, 21, 1100379, 'ALTO ALEGRE DOS PARECIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3853, 21, 1100403, 'ALTO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3854, 21, 1100346, 'ALVORADA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3855, 21, 1100023, 'ARIQUEMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3856, 21, 1100452, 'BURITIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3857, 21, 1100031, 'CABIXI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3858, 21, 1100601, 'CACAULÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3859, 21, 1100049, 'CACOAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3860, 21, 1100700, 'CAMPO NOVO DE RONDÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3861, 21, 1100809, 'CANDEIAS DO JAMARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3862, 21, 1100908, 'CASTANHEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3863, 21, 1100056, 'CEREJEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3864, 21, 1100924, 'CHUPINGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3865, 21, 1100064, 'COLORADO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3866, 21, 1100072, 'CORUMBIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3867, 21, 1100080, 'COSTA MARQUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3868, 21, 1100940, 'CUJUBIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3869, 21, 1100098, 'ESPIGÃO D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3870, 21, 1101005, 'GOVERNADOR JORGE TEIXEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3871, 21, 1100106, 'GUAJARÁ-MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3872, 21, 1101104, 'ITAPUÃ DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3873, 21, 1100114, 'JARU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3874, 21, 1100122, 'JI-PARANÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3875, 21, 1100130, 'MACHADINHO D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3876, 21, 1101203, 'MINISTRO ANDREAZZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3877, 21, 1101302, 'MIRANTE DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3878, 21, 1101401, 'MONTE NEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3879, 21, 1100148, 'NOVA BRASILÂNDIA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3880, 21, 1100338, 'NOVA MAMORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3881, 21, 1101435, 'NOVA UNIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3882, 21, 1100502, 'NOVO HORIZONTE DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3883, 21, 1100155, 'OURO PRETO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3884, 21, 1101450, 'PARECIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3885, 21, 1100189, 'PIMENTA BUENO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3886, 21, 1101468, 'PIMENTEIRAS DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3887, 21, 1100205, 'PORTO VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3888, 21, 1100254, 'PRESIDENTE MÉDICI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3889, 21, 1101476, 'PRIMAVERA DE RONDÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3890, 21, 1100262, 'RIO CRESPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3891, 21, 1100288, 'ROLIM DE MOURA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3892, 21, 1100296, 'SANTA LUZIA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3893, 21, 1101484, 'SÃO FELIPE D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3894, 21, 1101492, 'SÃO FRANCISCO DO GUAPORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3895, 21, 1100320, 'SÃO MIGUEL DO GUAPORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3896, 21, 1101500, 'SERINGUEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3897, 21, 1101559, 'TEIXEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3898, 21, 1101609, 'THEOBROMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3899, 21, 1101708, 'URUPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3900, 21, 1101757, 'VALE DO ANARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3901, 21, 1101807, 'VALE DO PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3902, 21, 1100304, 'VILHENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3903, 22, 1400050, 'ALTO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3904, 22, 1400027, 'AMAJARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3905, 22, 1400100, 'BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3906, 22, 1400159, 'BONFIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3907, 22, 1400175, 'CANTÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3908, 22, 1400209, 'CARACARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3909, 22, 1400233, 'CAROEBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3910, 22, 1400282, 'IRACEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3911, 22, 1400308, 'MUCAJAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3912, 22, 1400407, 'NORMANDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3913, 22, 1400456, 'PACARAIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3914, 22, 1400472, 'RORAINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3915, 22, 1400506, 'SÃO JOÃO DA BALIZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3916, 22, 1400605, 'SÃO LUIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3917, 22, 1400704, 'UIRAMUTÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3918, 23, 4300034, 'ACEGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3919, 23, 4300059, 'ÁGUA SANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3920, 23, 4300109, 'AGUDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3921, 23, 4300208, 'AJURICABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3922, 23, 4300307, 'ALECRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3923, 23, 4300406, 'ALEGRETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3924, 23, 4300455, 'ALEGRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3925, 23, 4300471, 'ALMIRANTE TAMANDARÉ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3926, 23, 4300505, 'ALPESTRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3927, 23, 4300554, 'ALTO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3928, 23, 4300570, 'ALTO FELIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3929, 23, 4300604, 'ALVORADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3930, 23, 4300638, 'AMARAL FERRADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3931, 23, 4300646, 'AMETISTA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3932, 23, 4300661, 'ANDRÉ DA ROCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3933, 23, 4300703, 'ANTA GORDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3934, 23, 4300802, 'ANTÔNIO PRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3935, 23, 4300851, 'ARAMBARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3936, 23, 4300877, 'ARARICÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3937, 23, 4300901, 'ARATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3938, 23, 4301008, 'ARROIO DO MEIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3939, 23, 4301073, 'ARROIO DO PADRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3940, 23, 4301057, 'ARROIO DO SAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3941, 23, 4301206, 'ARROIO DO TIGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3942, 23, 4301107, 'ARROIO DOS RATOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3943, 23, 4301305, 'ARROIO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3944, 23, 4301404, 'ARVOREZINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3945, 23, 4301503, 'AUGUSTO PESTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3946, 23, 4301552, 'ÁUREA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3947, 23, 4301602, 'BAGÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3948, 23, 4301636, 'BALNEÁRIO PINHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3949, 23, 4301651, 'BARÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3950, 23, 4301701, 'BARÃO DE COTEGIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3951, 23, 4301750, 'BARÃO DO TRIUNFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3952, 23, 4301859, 'BARRA DO GUARITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3953, 23, 4301875, 'BARRA DO QUARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3954, 23, 4301909, 'BARRA DO RIBEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3955, 23, 4301925, 'BARRA DO RIO AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3956, 23, 4301958, 'BARRA FUNDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3957, 23, 4301800, 'BARRACÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3958, 23, 4302006, 'BARROS CASSAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3959, 23, 4302055, 'BENJAMIN CONSTANT DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3960, 23, 4302105, 'BENTO GONÇALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3961, 23, 4302154, 'BOA VISTA DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3962, 23, 4302204, 'BOA VISTA DO BURICÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3963, 23, 4302220, 'BOA VISTA DO CADEADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3964, 23, 4302238, 'BOA VISTA DO INCRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3965, 23, 4302253, 'BOA VISTA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3966, 23, 4302303, 'BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3967, 23, 4302352, 'BOM PRINCÍPIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3968, 23, 4302378, 'BOM PROGRESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3969, 23, 4302402, 'BOM RETIRO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3970, 23, 4302451, 'BOQUEIRÃO DO LEÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3971, 23, 4302501, 'BOSSOROCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3972, 23, 4302584, 'BOZANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3973, 23, 4302600, 'BRAGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3974, 23, 4302659, 'BROCHIER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3975, 23, 4302709, 'BUTIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3976, 23, 4302808, 'CAÇAPAVA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3977, 23, 4302907, 'CACEQUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3978, 23, 4303004, 'CACHOEIRA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3979, 23, 4303103, 'CACHOEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3980, 23, 4303202, 'CACIQUE DOBLE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3981, 23, 4303301, 'CAIBATÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3982, 23, 4303400, 'CAIÇARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3983, 23, 4303509, 'CAMAQUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3984, 23, 4303558, 'CAMARGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3985, 23, 4303608, 'CAMBARÁ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3986, 23, 4303673, 'CAMPESTRE DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3987, 23, 4303707, 'CAMPINA DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3988, 23, 4303806, 'CAMPINAS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3989, 23, 4303905, 'CAMPO BOM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3990, 23, 4304002, 'CAMPO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3991, 23, 4304101, 'CAMPOS BORGES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3992, 23, 4304200, 'CANDELÁRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3993, 23, 4304309, 'CÂNDIDO GODÓI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3994, 23, 4304358, 'CANDIOTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3995, 23, 4304408, 'CANELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3996, 23, 4304507, 'CANGUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3997, 23, 4304606, 'CANOAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3998, 23, 4304614, 'CANUDOS DO VALE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(3999, 23, 4304622, 'CAPÃO BONITO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4000, 23, 4304630, 'CAPÃO DA CANOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4001, 23, 4304655, 'CAPÃO DO CIPÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4002, 23, 4304663, 'CAPÃO DO LEÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4003, 23, 4304689, 'CAPELA DE SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4004, 23, 4304697, 'CAPITÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4005, 23, 4304671, 'CAPIVARI DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4006, 23, 4304713, 'CARAÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4007, 23, 4304705, 'CARAZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4008, 23, 4304804, 'CARLOS BARBOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4009, 23, 4304853, 'CARLOS GOMES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4010, 23, 4304903, 'CASCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4011, 23, 4304952, 'CASEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4012, 23, 4305009, 'CATUÍPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4013, 23, 4305108, 'CAXIAS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4014, 23, 4305116, 'CENTENÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4015, 23, 4305124, 'CERRITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4016, 23, 4305132, 'CERRO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4017, 23, 4305157, 'CERRO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4018, 23, 4305173, 'CERRO GRANDE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4019, 23, 4305207, 'CERRO LARGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4020, 23, 4305306, 'CHAPADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4021, 23, 4305355, 'CHARQUEADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4022, 23, 4305371, 'CHARRUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4023, 23, 4305405, 'CHIAPETTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4024, 23, 4305439, 'CHUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4025, 23, 4305447, 'CHUVISCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4026, 23, 4305454, 'CIDREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4027, 23, 4305504, 'CIRÍACO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4028, 23, 4305587, 'COLINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4029, 23, 4305603, 'COLORADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4030, 23, 4305702, 'CONDOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4031, 23, 4305801, 'CONSTANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4032, 23, 4305835, 'COQUEIRO BAIXO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4033, 23, 4305850, 'COQUEIROS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4034, 23, 4305871, 'CORONEL BARROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4035, 23, 4305900, 'CORONEL BICACO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4036, 23, 4305934, 'CORONEL PILAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4037, 23, 4305959, 'COTIPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4038, 23, 4305975, 'COXILHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4039, 23, 4306007, 'CRISSIUMAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4040, 23, 4306056, 'CRISTAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4041, 23, 4306072, 'CRISTAL DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4042, 23, 4306106, 'CRUZ ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4043, 23, 4306130, 'CRUZALTENSE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4044, 23, 4306205, 'CRUZEIRO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4045, 23, 4306304, 'DAVID CANABARRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4046, 23, 4306320, 'DERRUBADAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4047, 23, 4306353, 'DEZESSEIS DE NOVEMBRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4048, 23, 4306379, 'DILERMANDO DE AGUIAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4049, 23, 4306403, 'DOIS IRMÃOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4050, 23, 4306429, 'DOIS IRMÃOS DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4051, 23, 4306452, 'DOIS LAJEADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4052, 23, 4306502, 'DOM FELICIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4053, 23, 4306601, 'DOM PEDRITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4054, 23, 4306551, 'DOM PEDRO DE ALCÂNTARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4055, 23, 4306700, 'DONA FRANCISCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4056, 23, 4306734, 'DOUTOR MAURÍCIO CARDOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4057, 23, 4306759, 'DOUTOR RICARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4058, 23, 4306767, 'ELDORADO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4059, 23, 4306809, 'ENCANTADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4060, 23, 4306908, 'ENCRUZILHADA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4061, 23, 4306924, 'ENGENHO VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4062, 23, 4306957, 'ENTRE RIOS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4063, 23, 4306932, 'ENTRE-IJUÍS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4064, 23, 4306973, 'EREBANGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4065, 23, 4307005, 'ERECHIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4066, 23, 4307054, 'ERNESTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4067, 23, 4307203, 'ERVAL GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4068, 23, 4307302, 'ERVAL SECO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4069, 23, 4307401, 'ESMERALDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4070, 23, 4307450, 'ESPERANÇA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4071, 23, 4307500, 'ESPUMOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4072, 23, 4307559, 'ESTAÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4073, 23, 4307609, 'ESTÂNCIA VELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4074, 23, 4307708, 'ESTEIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4075, 23, 4307807, 'ESTRELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4076, 23, 4307815, 'ESTRELA VELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4077, 23, 4307831, 'EUGÊNIO DE CASTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4078, 23, 4307864, 'FAGUNDES VARELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4079, 23, 4307906, 'FARROUPILHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4080, 23, 4308003, 'FAXINAL DO SOTURNO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4081, 23, 4308052, 'FAXINALZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4082, 23, 4308078, 'FAZENDA VILANOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4083, 23, 4308102, 'FELIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4084, 23, 4308201, 'FLORES DA CUNHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4085, 23, 4308250, 'FLORIANO PEIXOTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4086, 23, 4308300, 'FONTOURA XAVIER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4087, 23, 4308409, 'FORMIGUEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4088, 23, 4308433, 'FORQUETINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4089, 23, 4308458, 'FORTALEZA DOS VALOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4090, 23, 4308508, 'FREDERICO WESTPHALE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4091, 23, 4308607, 'GARIBALDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4092, 23, 4308656, 'GARRUCHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4093, 23, 4308706, 'GAURAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4094, 23, 4308805, 'GENERAL CÂMARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4095, 23, 4308854, 'GENTIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4096, 23, 4308904, 'GETÚLIO VARGAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4097, 23, 4309001, 'GIRUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4098, 23, 4309050, 'GLORINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4099, 23, 4309100, 'GRAMADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4100, 23, 4309126, 'GRAMADO DOS LOUREIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4101, 23, 4309159, 'GRAMADO XAVIER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4102, 23, 4309209, 'GRAVATAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4103, 23, 4309258, 'GUABIJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4104, 23, 4309308, 'GUAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4105, 23, 4309407, 'GUAPORÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4106, 23, 4309506, 'GUARANI DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4107, 23, 4309555, 'HARMONIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4108, 23, 4307104, 'HERVAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4109, 23, 4309571, 'HERVEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4110, 23, 4309605, 'HORIZONTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4111, 23, 4309654, 'HULHA NEGRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4112, 23, 4309704, 'HUMAITÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4113, 23, 4309753, 'IBARAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4114, 23, 4309803, 'IBIAÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4115, 23, 4309902, 'IBIRAIARAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4116, 23, 4309951, 'IBIRAPUITÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4117, 23, 4310009, 'IBIRUBÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4118, 23, 4310108, 'IGREJINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4119, 23, 4310207, 'IJUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4120, 23, 4310306, 'ILÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4121, 23, 4310330, 'IMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4122, 23, 4310363, 'IMIGRANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4123, 23, 4310405, 'INDEPENDÊNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4124, 23, 4310413, 'INHACORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4125, 23, 4310439, 'IPÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4126, 23, 4310462, 'IPIRANGA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4127, 23, 4310504, 'IRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4128, 23, 4310538, 'ITAARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4129, 23, 4310553, 'ITACURUBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4130, 23, 4310579, 'ITAPUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4131, 23, 4310603, 'ITAQUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4132, 23, 4310652, 'ITATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4133, 23, 4310702, 'ITATIBA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4134, 23, 4310751, 'IVORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4135, 23, 4310801, 'IVOTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4136, 23, 4310850, 'JABOTICABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4137, 23, 4310876, 'JACUIZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4138, 23, 4310900, 'JACUTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4139, 23, 4311007, 'JAGUARÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4140, 23, 4311106, 'JAGUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4141, 23, 4311122, 'JAQUIRANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4142, 23, 4311130, 'JARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4143, 23, 4311155, 'JÓIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4144, 23, 4311205, 'JÚLIO DE CASTILHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4145, 23, 4311239, 'LAGOA BONITA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4146, 23, 4311270, 'LAGOA DOS TRÊS CANTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4147, 23, 4311304, 'LAGOA VERMELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4148, 23, 4311254, 'LAGOÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4149, 23, 4311403, 'LAJEADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4150, 23, 4311429, 'LAJEADO DO BUGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4151, 23, 4311502, 'LAVRAS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4152, 23, 4311601, 'LIBERATO SALZANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4153, 23, 4311627, 'LINDOLFO COLLOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4154, 23, 4311643, 'LINHA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4155, 23, 4311718, 'MAÇAMBARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4156, 23, 4311700, 'MACHADINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4157, 23, 4311734, 'MAMPITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4158, 23, 4311759, 'MANOEL VIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4159, 23, 4311775, 'MAQUINÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4160, 23, 4311791, 'MARATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4161, 23, 4311809, 'MARAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4162, 23, 4311908, 'MARCELINO RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4163, 23, 4311981, 'MARIANA PIMENTEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4164, 23, 4312005, 'MARIANO MORO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4165, 23, 4312054, 'MARQUES DE SOUZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4166, 23, 4312104, 'MATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4167, 23, 4312138, 'MATO CASTELHANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4168, 23, 4312153, 'MATO LEITÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4169, 23, 4312179, 'MATO QUEIMADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4170, 23, 4312203, 'MAXIMILIANO DE ALMEIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4171, 23, 4312252, 'MINAS DO LEÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4172, 23, 4312302, 'MIRAGUAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4173, 23, 4312351, 'MONTAURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4174, 23, 4312377, 'MONTE ALEGRE DOS CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4175, 23, 4312385, 'MONTE BELO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4176, 23, 4312401, 'MONTENEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4177, 23, 4312427, 'MORMAÇO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4178, 23, 4312443, 'MORRINHOS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4179, 23, 4312450, 'MORRO REDONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4180, 23, 4312476, 'MORRO REUTER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4181, 23, 4312500, 'MOSTARDAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4182, 23, 4312609, 'MUÇUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4183, 23, 4312617, 'MUITOS CAPÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4184, 23, 4312625, 'MULITERNO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4185, 23, 4312658, 'NÃO-ME-TOQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4186, 23, 4312674, 'NICOLAU VERGUEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4187, 23, 4312708, 'NONOAI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4188, 23, 4312757, 'NOVA ALVORADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4189, 23, 4312807, 'NOVA ARAÇÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4190, 23, 4312906, 'NOVA BASSANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4191, 23, 4312955, 'NOVA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4192, 23, 4313003, 'NOVA BRÉSCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4193, 23, 4313011, 'NOVA CANDELÁRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4194, 23, 4313037, 'NOVA ESPERANÇA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4195, 23, 4313060, 'NOVA HARTZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4196, 23, 4313086, 'NOVA PÁDUA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4197, 23, 4313102, 'NOVA PALMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4198, 23, 4313201, 'NOVA PETRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4199, 23, 4313300, 'NOVA PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4200, 23, 4313334, 'NOVA RAMADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4201, 23, 4313359, 'NOVA ROMA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4202, 23, 4313375, 'NOVA SANTA RITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4203, 23, 4313490, 'NOVO BARREIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4204, 23, 4313391, 'NOVO CABRAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4205, 23, 4313409, 'NOVO HAMBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4206, 23, 4313425, 'NOVO MACHADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4207, 23, 4313441, 'NOVO TIRADENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4208, 23, 4313466, 'NOVO XINGU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4209, 23, 4313508, 'OSÓRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4210, 23, 4313607, 'PAIM FILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4211, 23, 4313656, 'PALMARES DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4212, 23, 4313706, 'PALMEIRA DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4213, 23, 4313805, 'PALMITINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4214, 23, 4313904, 'PANAMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4215, 23, 4313953, 'PANTANO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4216, 23, 4314001, 'PARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4217, 23, 4314027, 'PARAÍSO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4218, 23, 4314035, 'PARECI NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4219, 23, 4314050, 'PAROBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4220, 23, 4314068, 'PASSA SETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4221, 23, 4314076, 'PASSO DO SOBRADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4222, 23, 4314100, 'PASSO FUNDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4223, 23, 4314134, 'PAULO BENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4224, 23, 4314159, 'PAVERAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4225, 23, 4314175, 'PEDRAS ALTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4226, 23, 4314209, 'PEDRO OSÓRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4227, 23, 4314308, 'PEJUÇARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4228, 23, 4314407, 'PELOTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4229, 23, 4314423, 'PICADA CAFÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4230, 23, 4314456, 'PINHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4231, 23, 4314464, 'PINHAL DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4232, 23, 4314472, 'PINHAL GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4233, 23, 4314498, 'PINHEIRINHO DO VALE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4234, 23, 4314506, 'PINHEIRO MACHADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4235, 23, 4314555, 'PIRAPÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4236, 23, 4314605, 'PIRATINI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4237, 23, 4314704, 'PLANALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4238, 23, 4314753, 'POÇO DAS ANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4239, 23, 4314779, 'PONTÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4240, 23, 4314787, 'PONTE PRETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4241, 23, 4314803, 'PORTÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4242, 23, 4314902, 'PORTO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4243, 23, 4315008, 'PORTO LUCENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4244, 23, 4315057, 'PORTO MAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4245, 23, 4315073, 'PORTO VERA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4246, 23, 4315107, 'PORTO XAVIER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4247, 23, 4315131, 'POUSO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4248, 23, 4315149, 'PRESIDENTE LUCENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4249, 23, 4315156, 'PROGRESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4250, 23, 4315172, 'PROTÁSIO ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4251, 23, 4315206, 'PUTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4252, 23, 4315305, 'QUARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4253, 23, 4315313, 'QUATRO IRMÃOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4254, 23, 4315321, 'QUEVEDOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4255, 23, 4315354, 'QUINZE DE NOVEMBRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4256, 23, 4315404, 'REDENTORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4257, 23, 4315453, 'RELVADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4258, 23, 4315503, 'RESTINGA SECA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4259, 23, 4315552, 'RIO DOS ÍNDIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4260, 23, 4315602, 'RIO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4261, 23, 4315701, 'RIO PARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4262, 23, 4315750, 'RIOZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4263, 23, 4315800, 'ROCA SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4264, 23, 4315909, 'RODEIO BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4265, 23, 4315958, 'ROLADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4266, 23, 4316006, 'ROLANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4267, 23, 4316105, 'RONDA ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4268, 23, 4316204, 'RONDINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4269, 23, 4316303, 'ROQUE GONZALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4270, 23, 4316402, 'ROSÁRIO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4271, 23, 4316428, 'SAGRADA FAMÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4272, 23, 4316436, 'SALDANHA MARINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4273, 23, 4316451, 'SALTO DO JACUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4274, 23, 4316477, 'SALVADOR DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4275, 23, 4316501, 'SALVADOR DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4276, 23, 4316600, 'SANANDUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4277, 23, 4316709, 'SANTA BÁRBARA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4278, 23, 4316733, 'SANTA CECÍLIA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4279, 23, 4316758, 'SANTA CLARA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4280, 23, 4316808, 'SANTA CRUZ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4281, 23, 4316972, 'SANTA MARGARIDA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4282, 23, 4316907, 'SANTA MARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4283, 23, 4316956, 'SANTA MARIA DO HERVAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4284, 23, 4317202, 'SANTA ROSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4285, 23, 4317251, 'SANTA TEREZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4286, 23, 4317301, 'SANTA VITÓRIA DO PALMAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4287, 23, 4317004, 'SANTANA DA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4288, 23, 4317103, 'SANT\'ANA DO LIVRAMENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4289, 23, 4317400, 'SANTIAGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4290, 23, 4317509, 'SANTO ÂNGELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4291, 23, 4317608, 'SANTO ANTÔNIO DA PATRULHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4292, 23, 4317707, 'SANTO ANTÔNIO DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4293, 23, 4317558, 'SANTO ANTÔNIO DO PALMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4294, 23, 4317756, 'SANTO ANTÔNIO DO PLANALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4295, 23, 4317806, 'SANTO AUGUSTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4296, 23, 4317905, 'SANTO CRISTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4297, 23, 4317954, 'SANTO EXPEDITO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4298, 23, 4318002, 'SÃO BORJA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4299, 23, 4318051, 'SÃO DOMINGOS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4300, 23, 4318101, 'SÃO FRANCISCO DE ASSIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4301, 23, 4318200, 'SÃO FRANCISCO DE PAULA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4302, 23, 4318309, 'SÃO GABRIEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4303, 23, 4318408, 'SÃO JERÔNIMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4304, 23, 4318424, 'SÃO JOÃO DA URTIGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4305, 23, 4318432, 'SÃO JOÃO DO POLÊSINE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4306, 23, 4318440, 'SÃO JORGE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4307, 23, 4318457, 'SÃO JOSÉ DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4308, 23, 4318465, 'SÃO JOSÉ DO HERVAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4309, 23, 4318481, 'SÃO JOSÉ DO HORTÊNCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4310, 23, 4318499, 'SÃO JOSÉ DO INHACORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4311, 23, 4318507, 'SÃO JOSÉ DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4312, 23, 4318606, 'SÃO JOSÉ DO OURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4313, 23, 4318614, 'SÃO JOSÉ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4314, 23, 4318622, 'SÃO JOSÉ DOS AUSENTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4315, 23, 4318705, 'SÃO LEOPOLDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4316, 23, 4318804, 'SÃO LOURENÇO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4317, 23, 4318903, 'SÃO LUIZ GONZAGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4318, 23, 4319000, 'SÃO MARCOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4319, 23, 4319109, 'SÃO MARTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4320, 23, 4319125, 'SÃO MARTINHO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4321, 23, 4319158, 'SÃO MIGUEL DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4322, 23, 4319208, 'SÃO NICOLAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4323, 23, 4319307, 'SÃO PAULO DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4324, 23, 4319356, 'SÃO PEDRO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4325, 23, 4319364, 'SÃO PEDRO DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4326, 23, 4319372, 'SÃO PEDRO DO BUTIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4327, 23, 4319406, 'SÃO PEDRO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4328, 23, 4319505, 'SÃO SEBASTIÃO DO CAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4329, 23, 4319604, 'SÃO SEPÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4330, 23, 4319703, 'SÃO VALENTIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4331, 23, 4319711, 'SÃO VALENTIM DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4332, 23, 4319737, 'SÃO VALÉRIO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4333, 23, 4319752, 'SÃO VENDELINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4334, 23, 4319802, 'SÃO VICENTE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4335, 23, 4319901, 'SAPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4336, 23, 4320008, 'SAPUCAIA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4337, 23, 4320107, 'SARANDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4338, 23, 4320206, 'SEBERI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4339, 23, 4320230, 'SEDE NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4340, 23, 4320263, 'SEGREDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4341, 23, 4320305, 'SELBACH', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4342, 23, 4320321, 'SENADOR SALGADO FILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4343, 23, 4320354, 'SENTINELA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4344, 23, 4320404, 'SERAFINA CORRÊA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4345, 23, 4320453, 'SÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4346, 23, 4320503, 'SERTÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4347, 23, 4320552, 'SERTÃO SANTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4348, 23, 4320578, 'SETE DE SETEMBRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4349, 23, 4320602, 'SEVERIANO DE ALMEIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4350, 23, 4320651, 'SILVEIRA MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4351, 23, 4320677, 'SINIMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4352, 23, 4320701, 'SOBRADINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4353, 23, 4320800, 'SOLEDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4354, 23, 4320859, 'TABAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4355, 23, 4320909, 'TAPEJARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4356, 23, 4321006, 'TAPERA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4357, 23, 4321105, 'TAPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4358, 23, 4321204, 'TAQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4359, 23, 4321303, 'TAQUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4360, 23, 4321329, 'TAQUARUÇU DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4361, 23, 4321352, 'TAVARES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4362, 23, 4321402, 'TENENTE PORTELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4363, 23, 4321436, 'TERRA DE AREIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4364, 23, 4321451, 'TEUTÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4365, 23, 4321469, 'TIO HUGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4366, 23, 4321477, 'TIRADENTES DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4367, 23, 4321493, 'TOROPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4368, 23, 4321501, 'TORRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4369, 23, 4321600, 'TRAMANDAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4370, 23, 4321626, 'TRAVESSEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4371, 23, 4321634, 'TRÊS ARROIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4372, 23, 4321667, 'TRÊS CACHOEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4373, 23, 4321709, 'TRÊS COROAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4374, 23, 4321808, 'TRÊS DE MAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4375, 23, 4321832, 'TRÊS FORQUILHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4376, 23, 4321857, 'TRÊS PALMEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4377, 23, 4321907, 'TRÊS PASSOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4378, 23, 4321956, 'TRINDADE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4379, 23, 4322004, 'TRIUNFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4380, 23, 4322103, 'TUCUNDUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4381, 23, 4322152, 'TUNAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4382, 23, 4322186, 'TUPANCI DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4383, 23, 4322202, 'TUPANCIRETÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4384, 23, 4322251, 'TUPANDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4385, 23, 4322301, 'TUPARENDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4386, 23, 4322327, 'TURUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4387, 23, 4322343, 'UBIRETAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4388, 23, 4322350, 'UNIÃO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4389, 23, 4322376, 'UNISTALDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4390, 23, 4322400, 'URUGUAIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4391, 23, 4322509, 'VACARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4392, 23, 4322533, 'VALE DO SOL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4393, 23, 4322541, 'VALE REAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4394, 23, 4322525, 'VALE VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4395, 23, 4322558, 'VANINI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4396, 23, 4322608, 'VENÂNCIO AIRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4397, 23, 4322707, 'VERA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4398, 23, 4322806, 'VERANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4399, 23, 4322855, 'VESPASIANO CORREA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4400, 23, 4322905, 'VIADUTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4401, 23, 4323002, 'VIAMÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4402, 23, 4323101, 'VICENTE DUTRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4403, 23, 4323200, 'VICTOR GRAEFF', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4404, 23, 4323309, 'VILA FLORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4405, 23, 4323358, 'VILA LÂNGARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4406, 23, 4323408, 'VILA MARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4407, 23, 4323457, 'VILA NOVA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4408, 23, 4323507, 'VISTA ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4409, 23, 4323606, 'VISTA ALEGRE DO PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4410, 23, 4323705, 'VISTA GAÚCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4411, 23, 4323754, 'VITÓRIA DAS MISSÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4412, 23, 4323770, 'WESTFALIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4413, 23, 4323804, 'XANGRI-LÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4414, 24, 4200051, 'ABDON BATISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4415, 24, 4200101, 'ABELARDO LUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4416, 24, 4200200, 'AGROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4417, 24, 4200309, 'AGRONÔMICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4418, 24, 4200408, 'ÁGUA DOCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4419, 24, 4200507, 'ÁGUAS DE CHAPECÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4420, 24, 4200556, 'ÁGUAS FRIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4421, 24, 4200606, 'ÁGUAS MORNAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4422, 24, 4200705, 'ALFREDO WAGNER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4423, 24, 4200754, 'ALTO BELA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4424, 24, 4200804, 'ANCHIETA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4425, 24, 4200903, 'ANGELINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4426, 24, 4201000, 'ANITA GARIBALDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4427, 24, 4201109, 'ANITÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4428, 24, 4201208, 'ANTÔNIO CARLOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4429, 24, 4201257, 'APIÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4430, 24, 4201273, 'ARABUTÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4431, 24, 4201307, 'ARAQUARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4432, 24, 4201406, 'ARARANGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4433, 24, 4201505, 'ARMAZÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4434, 24, 4201604, 'ARROIO TRINTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4435, 24, 4201653, 'ARVOREDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4436, 24, 4201703, 'ASCURRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4437, 24, 4201802, 'ATALANTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4438, 24, 4201901, 'AURORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4439, 24, 4201950, 'BALNEÁRIO ARROIO DO SILVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4440, 24, 4202057, 'BALNEÁRIO BARRA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4441, 24, 4202008, 'BALNEÁRIO CAMBORIÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4442, 24, 4202073, 'BALNEÁRIO GAIVOTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4443, 24, 4212809, 'BALNEÁRIO PIÇARRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4444, 24, 4202081, 'BANDEIRANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4445, 24, 4202099, 'BARRA BONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4446, 24, 4202107, 'BARRA VELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4447, 24, 4202131, 'BELA VISTA DO TOLDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4448, 24, 4202156, 'BELMONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4449, 24, 4202206, 'BENEDITO NOVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4450, 24, 4202305, 'BIGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4451, 24, 4202404, 'BLUMENAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4452, 24, 4202438, 'BOCAINA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4453, 24, 4202503, 'BOM JARDIM DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4454, 24, 4202537, 'BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4455, 24, 4202578, 'BOM JESUS DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4456, 24, 4202602, 'BOM RETIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4457, 24, 4202453, 'BOMBINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4458, 24, 4202701, 'BOTUVERÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4459, 24, 4202800, 'BRAÇO DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4460, 24, 4202859, 'BRAÇO DO TROMBUDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4461, 24, 4202875, 'BRUNÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4462, 24, 4202909, 'BRUSQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4463, 24, 4203006, 'CAÇADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4464, 24, 4203105, 'CAIBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4465, 24, 4203154, 'CALMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4466, 24, 4203204, 'CAMBORIÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4467, 24, 4203303, 'CAMPO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4468, 24, 4203402, 'CAMPO BELO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4469, 24, 4203501, 'CAMPO ERÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4470, 24, 4203600, 'CAMPOS NOVOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4471, 24, 4203709, 'CANELINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4472, 24, 4203808, 'CANOINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4473, 24, 4203253, 'CAPÃO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4474, 24, 4203907, 'CAPINZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4475, 24, 4203956, 'CAPIVARI DE BAIXO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4476, 24, 4204004, 'CATANDUVAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4477, 24, 4204103, 'CAXAMBU DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4478, 24, 4204152, 'CELSO RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4479, 24, 4204178, 'CERRO NEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4480, 24, 4204194, 'CHAPADÃO DO LAGEADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4481, 24, 4204202, 'CHAPECÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4482, 24, 4204251, 'COCAL DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4483, 24, 4204301, 'CONCÓRDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4484, 24, 4204350, 'CORDILHEIRA ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4485, 24, 4204400, 'CORONEL FREITAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4486, 24, 4204459, 'CORONEL MARTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4487, 24, 4204558, 'CORREIA PINTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4488, 24, 4204509, 'CORUPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4489, 24, 4204608, 'CRICIÚMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4490, 24, 4204707, 'CUNHA PORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4491, 24, 4204756, 'CUNHATAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4492, 24, 4204806, 'CURITIBANOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4493, 24, 4204905, 'DESCANSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4494, 24, 4205001, 'DIONÍSIO CERQUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4495, 24, 4205100, 'DONA EMMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4496, 24, 4205159, 'DOUTOR PEDRINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4497, 24, 4205175, 'ENTRE RIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4498, 24, 4205191, 'ERMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4499, 24, 4205209, 'ERVAL VELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4500, 24, 4205308, 'FAXINAL DOS GUEDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4501, 24, 4205357, 'FLOR DO SERTÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4502, 24, 4205407, 'FLORIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4503, 24, 4205431, 'FORMOSA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4504, 24, 4205456, 'FORQUILHINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4505, 24, 4205506, 'FRAIBURGO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4506, 24, 4205555, 'FREI ROGÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4507, 24, 4205605, 'GALVÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4508, 24, 4205704, 'GAROPABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4509, 24, 4205803, 'GARUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4510, 24, 4205902, 'GASPAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4511, 24, 4206009, 'GOVERNADOR CELSO RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4512, 24, 4206108, 'GRÃO PARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4513, 24, 4206207, 'GRAVATAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4514, 24, 4206306, 'GUABIRUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4515, 24, 4206405, 'GUARACIABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4516, 24, 4206504, 'GUARAMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4517, 24, 4206603, 'GUARUJÁ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4518, 24, 4206652, 'GUATAMBÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4519, 24, 4206702, 'HERVAL D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4520, 24, 4206751, 'IBIAM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4521, 24, 4206801, 'IBICARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4522, 24, 4206900, 'IBIRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4523, 24, 4207007, 'IÇARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4524, 24, 4207106, 'ILHOTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4525, 24, 4207205, 'IMARUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4526, 24, 4207304, 'IMBITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4527, 24, 4207403, 'IMBUIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4528, 24, 4207502, 'INDAIAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4529, 24, 4207577, 'IOMERÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4530, 24, 4207601, 'IPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4531, 24, 4207650, 'IPORÃ DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4532, 24, 4207684, 'IPUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4533, 24, 4207700, 'IPUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4534, 24, 4207759, 'IRACEMINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4535, 24, 4207809, 'IRANI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4536, 24, 4207858, 'IRATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4537, 24, 4207908, 'IRINEÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4538, 24, 4208005, 'ITÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4539, 24, 4208104, 'ITAIÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4540, 24, 4208203, 'ITAJAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4541, 24, 4208302, 'ITAPEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4542, 24, 4208401, 'ITAPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4543, 24, 4208450, 'ITAPOÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4544, 24, 4208500, 'ITUPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4545, 24, 4208609, 'JABORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4546, 24, 4208708, 'JACINTO MACHADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4547, 24, 4208807, 'JAGUARUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4548, 24, 4208906, 'JARAGUÁ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4549, 24, 4208955, 'JARDINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4550, 24, 4209003, 'JOAÇABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4551, 24, 4209102, 'JOINVILLE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4552, 24, 4209151, 'JOSÉ BOITEUX', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4553, 24, 4209177, 'JUPIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4554, 24, 4209201, 'LACERDÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4555, 24, 4209300, 'LAGES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4556, 24, 4209409, 'LAGUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4557, 24, 4209458, 'LAJEADO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4558, 24, 4209508, 'LAURENTINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4559, 24, 4209607, 'LAURO MULLER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4560, 24, 4209706, 'LEBON RÉGIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4561, 24, 4209805, 'LEOBERTO LEAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4562, 24, 4209854, 'LINDÓIA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4563, 24, 4209904, 'LONTRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4564, 24, 4210001, 'LUIZ ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4565, 24, 4210035, 'LUZERNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4566, 24, 4210050, 'MACIEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4567, 24, 4210100, 'MAFRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4568, 24, 4210209, 'MAJOR GERCINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4569, 24, 4210308, 'MAJOR VIEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4570, 24, 4210407, 'MARACAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4571, 24, 4210506, 'MARAVILHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4572, 24, 4210555, 'MAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4573, 24, 4210605, 'MASSARANDUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4574, 24, 4210704, 'MATOS COSTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4575, 24, 4210803, 'MELEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4576, 24, 4210852, 'MIRIM DOCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4577, 24, 4210902, 'MODELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4578, 24, 4211009, 'MONDAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4579, 24, 4211058, 'MONTE CARLO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4580, 24, 4211108, 'MONTE CASTELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4581, 24, 4211207, 'MORRO DA FUMAÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4582, 24, 4211256, 'MORRO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4583, 24, 4211306, 'NAVEGANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4584, 24, 4211405, 'NOVA ERECHIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4585, 24, 4211454, 'NOVA ITABERABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4586, 24, 4211504, 'NOVA TRENTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4587, 24, 4211603, 'NOVA VENEZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4588, 24, 4211652, 'NOVO HORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4589, 24, 4211702, 'ORLEANS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4590, 24, 4211751, 'OTACÍLIO COSTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4591, 24, 4211801, 'OURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4592, 24, 4211850, 'OURO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4593, 24, 4211876, 'PAIAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4594, 24, 4211892, 'PAINEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4595, 24, 4211900, 'PALHOÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4596, 24, 4212007, 'PALMA SOLA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4597, 24, 4212056, 'PALMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4598, 24, 4212106, 'PALMITOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4599, 24, 4212205, 'PAPANDUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4600, 24, 4212239, 'PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4601, 24, 4212254, 'PASSO DE TORRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4602, 24, 4212270, 'PASSOS MAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4603, 24, 4212304, 'PAULO LOPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4604, 24, 4212403, 'PEDRAS GRANDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4605, 24, 4212502, 'PENHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4606, 24, 4212601, 'PERITIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4607, 24, 4212700, 'PETROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4608, 24, 4212908, 'PINHALZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4609, 24, 4213005, 'PINHEIRO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4610, 24, 4213104, 'PIRATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4611, 24, 4213153, 'PLANALTO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4612, 24, 4213203, 'POMERODE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4613, 24, 4213302, 'PONTE ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4614, 24, 4213351, 'PONTE ALTA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4615, 24, 4213401, 'PONTE SERRADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4616, 24, 4213500, 'PORTO BELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4617, 24, 4213609, 'PORTO UNIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4618, 24, 4213708, 'POUSO REDONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4619, 24, 4213807, 'PRAIA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4620, 24, 4213906, 'PRESIDENTE CASTELLO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4621, 24, 4214003, 'PRESIDENTE GETÚLIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4622, 24, 4214102, 'PRESIDENTE NEREU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4623, 24, 4214151, 'PRINCESA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4624, 24, 4214201, 'QUILOMBO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4625, 24, 4214300, 'RANCHO QUEIMADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4626, 24, 4214409, 'RIO DAS ANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4627, 24, 4214508, 'RIO DO CAMPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4628, 24, 4214607, 'RIO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4629, 24, 4214805, 'RIO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4630, 24, 4214706, 'RIO DOS CEDROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4631, 24, 4214904, 'RIO FORTUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4632, 24, 4215000, 'RIO NEGRINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4633, 24, 4215059, 'RIO RUFINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4634, 24, 4215075, 'RIQUEZA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4635, 24, 4215109, 'RODEIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4636, 24, 4215208, 'ROMELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4637, 24, 4215307, 'SALETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4638, 24, 4215356, 'SALTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4639, 24, 4215406, 'SALTO VELOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4640, 24, 4215455, 'SANGÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4641, 24, 4215505, 'SANTA CECÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4642, 24, 4215554, 'SANTA HELENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4643, 24, 4215604, 'SANTA ROSA DE LIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4644, 24, 4215653, 'SANTA ROSA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4645, 24, 4215679, 'SANTA TEREZINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4646, 24, 4215687, 'SANTA TEREZINHA DO PROGRESSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4647, 24, 4215695, 'SANTIAGO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4648, 24, 4215703, 'SANTO AMARO DA IMPERATRIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4649, 24, 4215802, 'SÃO BENTO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4650, 24, 4215752, 'SÃO BERNARDINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4651, 24, 4215901, 'SÃO BONIFÁCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4652, 24, 4216008, 'SÃO CARLOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4653, 24, 4216057, 'SÃO CRISTOVÃO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4654, 24, 4216107, 'SÃO DOMINGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4655, 24, 4216206, 'SÃO FRANCISCO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4656, 24, 4216305, 'SÃO JOÃO BATISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4657, 24, 4216354, 'SÃO JOÃO DO ITAPERIÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4658, 24, 4216255, 'SÃO JOÃO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4659, 24, 4216404, 'SÃO JOÃO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4660, 24, 4216503, 'SÃO JOAQUIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4661, 24, 4216602, 'SÃO JOSÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4662, 24, 4216701, 'SÃO JOSÉ DO CEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4663, 24, 4216800, 'SÃO JOSÉ DO CERRITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4664, 24, 4216909, 'SÃO LOURENÇO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4665, 24, 4217006, 'SÃO LUDGERO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4666, 24, 4217105, 'SÃO MARTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4667, 24, 4217154, 'SÃO MIGUEL DA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4668, 24, 4217204, 'SÃO MIGUEL DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4669, 24, 4217253, 'SÃO PEDRO DE ALCÂNTARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4670, 24, 4217303, 'SAUDADES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4671, 24, 4217402, 'SCHROEDER', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4672, 24, 4217501, 'SEARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4673, 24, 4217550, 'SERRA ALTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4674, 24, 4217600, 'SIDERÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4675, 24, 4217709, 'SOMBRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4676, 24, 4217758, 'SUL BRASIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4677, 24, 4217808, 'TAIÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4678, 24, 4217907, 'TANGARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4679, 24, 4217956, 'TIGRINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4680, 24, 4218004, 'TIJUCAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4681, 24, 4218103, 'TIMBÉ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4682, 24, 4218202, 'TIMBÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4683, 24, 4218251, 'TIMBÓ GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4684, 24, 4218301, 'TRÊS BARRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4685, 24, 4218350, 'TREVISO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4686, 24, 4218400, 'TREZE DE MAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4687, 24, 4218509, 'TREZE TÍLIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4688, 24, 4218608, 'TROMBUDO CENTRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4689, 24, 4218707, 'TUBARÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4690, 24, 4218756, 'TUNÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4691, 24, 4218806, 'TURVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4692, 24, 4218855, 'UNIÃO DO OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4693, 24, 4218905, 'URUBICI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4694, 24, 4218954, 'URUPEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4695, 24, 4219002, 'URUSSANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4696, 24, 4219101, 'VARGEÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4697, 24, 4219150, 'VARGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4698, 24, 4219176, 'VARGEM BONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4699, 24, 4219200, 'VIDAL RAMOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4700, 24, 4219309, 'VIDEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4701, 24, 4219358, 'VITOR MEIRELES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4702, 24, 4219408, 'WITMARSUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4703, 24, 4219507, 'XANXERÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4704, 24, 4219606, 'XAVANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4705, 24, 4219705, 'XAXIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4706, 24, 4219853, 'ZORTÉA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4707, 25, 2800100, 'AMPARO DE SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4708, 25, 2800209, 'AQUIDABÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4709, 25, 2800308, 'ARACAJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4710, 25, 2800407, 'ARAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4711, 25, 2800506, 'AREIA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4712, 25, 2800605, 'BARRA DOS COQUEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4713, 25, 2800670, 'BOQUIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4714, 25, 2800704, 'BREJO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4715, 25, 2801009, 'CAMPO DO BRITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4716, 25, 2801108, 'CANHOBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4717, 25, 2801207, 'CANINDÉ DE SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4718, 25, 2801306, 'CAPELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4719, 25, 2801405, 'CARIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4720, 25, 2801504, 'CARMÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4721, 25, 2801603, 'CEDRO DE SÃO JOÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4722, 25, 2801702, 'CRISTINÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4723, 25, 2801900, 'CUMBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4724, 25, 2802007, 'DIVINA PASTORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4725, 25, 2802106, 'ESTÂNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4726, 25, 2802205, 'FEIRA NOVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4727, 25, 2802304, 'FREI PAULO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4728, 25, 2802403, 'GARARU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4729, 25, 2802502, 'GENERAL MAYNARD', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4730, 25, 2802601, 'GRACHO CARDOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4731, 25, 2802700, 'ILHA DAS FLORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4732, 25, 2802809, 'INDIAROBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4733, 25, 2802908, 'ITABAIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4734, 25, 2803005, 'ITABAIANINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4735, 25, 2803104, 'ITABI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4736, 25, 2803203, 'ITAPORANGA D\'AJUDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4737, 25, 2803302, 'JAPARATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4738, 25, 2803401, 'JAPOATÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4739, 25, 2803500, 'LAGARTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4740, 25, 2803609, 'LARANJEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4741, 25, 2803708, 'MACAMBIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4742, 25, 2803807, 'MALHADA DOS BOIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4743, 25, 2803906, 'MALHADOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4744, 25, 2804003, 'MARUIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4745, 25, 2804102, 'MOITA BONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4746, 25, 2804201, 'MONTE ALEGRE DE SERGIPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4747, 25, 2804300, 'MURIBECA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4748, 25, 2804409, 'NEÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4749, 25, 2804458, 'NOSSA SENHORA APARECIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4750, 25, 2804508, 'NOSSA SENHORA DA GLÓRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4751, 25, 2804607, 'NOSSA SENHORA DAS DORES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4752, 25, 2804706, 'NOSSA SENHORA DE LOURDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4753, 25, 2804805, 'NOSSA SENHORA DO SOCORRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4754, 25, 2804904, 'PACATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4755, 25, 2805000, 'PEDRA MOLE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4756, 25, 2805109, 'PEDRINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4757, 25, 2805208, 'PINHÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4758, 25, 2805307, 'PIRAMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4759, 25, 2805406, 'POÇO REDONDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4760, 25, 2805505, 'POÇO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4761, 25, 2805604, 'PORTO DA FOLHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4762, 25, 2805703, 'PROPRIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4763, 25, 2805802, 'RIACHÃO DO DANTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4764, 25, 2805901, 'RIACHUELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4765, 25, 2806008, 'RIBEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4766, 25, 2806107, 'ROSÁRIO DO CATETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4767, 25, 2806206, 'SALGADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4768, 25, 2806305, 'SANTA LUZIA DO ITANHY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4769, 25, 2806503, 'SANTA ROSA DE LIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4770, 25, 2806404, 'SANTANA DO SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4771, 25, 2806602, 'SANTO AMARO DAS BROTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4772, 25, 2806701, 'SÃO CRISTÓVÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4773, 25, 2806800, 'SÃO DOMINGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4774, 25, 2806909, 'SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4775, 25, 2807006, 'SÃO MIGUEL DO ALEIXO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4776, 25, 2807105, 'SIMÃO DIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4777, 25, 2807204, 'SIRIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4778, 25, 2807303, 'TELHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4779, 25, 2807402, 'TOBIAS BARRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4780, 25, 2807501, 'TOMAR DO GERU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4781, 25, 2807600, 'UMBAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4782, 26, 3500105, 'ADAMANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4783, 26, 3500204, 'ADOLFO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4784, 26, 3500303, 'AGUAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4785, 26, 3500402, 'ÁGUAS DA PRATA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4786, 26, 3500501, 'ÁGUAS DE LINDÓIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4787, 26, 3500550, 'ÁGUAS DE SANTA BÁRBARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4788, 26, 3500600, 'ÁGUAS DE SÃO PEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4789, 26, 3500709, 'AGUDOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4790, 26, 3500758, 'ALAMBARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4791, 26, 3500808, 'ALFREDO MARCONDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4792, 26, 3500907, 'ALTAIR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4793, 26, 3501004, 'ALTINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4794, 26, 3501103, 'ALTO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4795, 26, 3501152, 'ALUMÍNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4796, 26, 3501202, 'ÁLVARES FLORENCE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4797, 26, 3501301, 'ÁLVARES MACHADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4798, 26, 3501400, 'ÁLVARO DE CARVALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4799, 26, 3501509, 'ALVINLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4800, 26, 3501608, 'AMERICANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4801, 26, 3501707, 'AMÉRICO BRASILIENSE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4802, 26, 3501806, 'AMÉRICO DE CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4803, 26, 3501905, 'AMPARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4804, 26, 3502002, 'ANALÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4805, 26, 3502101, 'ANDRADINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4806, 26, 3502200, 'ANGATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4807, 26, 3502309, 'ANHEMBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4808, 26, 3502408, 'ANHUMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4809, 26, 3502507, 'APARECIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4810, 26, 3502606, 'APARECIDA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4811, 26, 3502705, 'APIAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4812, 26, 3502754, 'ARAÇARIGUAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4813, 26, 3502804, 'ARAÇATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4814, 26, 3502903, 'ARAÇOIABA DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4815, 26, 3503000, 'ARAMINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4816, 26, 3503109, 'ARANDU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4817, 26, 3503158, 'ARAPEÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4818, 26, 3503208, 'ARARAQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4819, 26, 3503307, 'ARARAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4820, 26, 3503356, 'ARCO-ÍRIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4821, 26, 3503406, 'AREALVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4822, 26, 3503505, 'AREIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4823, 26, 3503604, 'AREIÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4824, 26, 3503703, 'ARIRANHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4825, 26, 3503802, 'ARTUR NOGUEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4826, 26, 3503901, 'ARUJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4827, 26, 3503950, 'ASPÁSIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4828, 26, 3504008, 'ASSIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4829, 26, 3504107, 'ATIBAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4830, 26, 3504206, 'AURIFLAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4831, 26, 3504305, 'AVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4832, 26, 3504404, 'AVANHANDAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4833, 26, 3504503, 'AVARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4834, 26, 3504602, 'BADY BASSITT', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4835, 26, 3504701, 'BALBINOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4836, 26, 3504800, 'BÁLSAMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4837, 26, 3504909, 'BANANAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4838, 26, 3505005, 'BARÃO DE ANTONINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4839, 26, 3505104, 'BARBOSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4840, 26, 3505203, 'BARIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4841, 26, 3505302, 'BARRA BONITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4842, 26, 3505351, 'BARRA DO CHAPÉU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4843, 26, 3505401, 'BARRA DO TURVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4844, 26, 3505500, 'BARRETOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4845, 26, 3505609, 'BARRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4846, 26, 3505708, 'BARUERI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4847, 26, 3505807, 'BASTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4848, 26, 3505906, 'BATATAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4849, 26, 3506003, 'BAURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4850, 26, 3506102, 'BEBEDOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4851, 26, 3506201, 'BENTO DE ABREU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4852, 26, 3506300, 'BERNARDINO DE CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4853, 26, 3506359, 'BERTIOGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4854, 26, 3506409, 'BILAC', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4855, 26, 3506508, 'BIRIGUI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4856, 26, 3506607, 'BIRITIBA-MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4857, 26, 3506706, 'BOA ESPERANÇA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4858, 26, 3506805, 'BOCAINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4859, 26, 3506904, 'BOFETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4860, 26, 3507001, 'BOITUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4861, 26, 3507100, 'BOM JESUS DOS PERDÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4862, 26, 3507159, 'BOM SUCESSO DE ITARARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4863, 26, 3507209, 'BORÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4864, 26, 3507308, 'BORACÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4865, 26, 3507407, 'BORBOREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4866, 26, 3507456, 'BOREBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4867, 26, 3507506, 'BOTUCATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4868, 26, 3507605, 'BRAGANÇA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4869, 26, 3507704, 'BRAÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4870, 26, 3507753, 'BREJO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4871, 26, 3507803, 'BRODOWSKI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4872, 26, 3507902, 'BROTAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4873, 26, 3508009, 'BURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4874, 26, 3508108, 'BURITAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4875, 26, 3508207, 'BURITIZAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4876, 26, 3508306, 'CABRÁLIA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4877, 26, 3508405, 'CABREÚVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4878, 26, 3508504, 'CAÇAPAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4879, 26, 3508603, 'CACHOEIRA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4880, 26, 3508702, 'CACONDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4881, 26, 3508801, 'CAFELÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4882, 26, 3508900, 'CAIABU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4883, 26, 3509007, 'CAIEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4884, 26, 3509106, 'CAIUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4885, 26, 3509205, 'CAJAMAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4886, 26, 3509254, 'CAJATI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4887, 26, 3509304, 'CAJOBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4888, 26, 3509403, 'CAJURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4889, 26, 3509452, 'CAMPINA DO MONTE ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4890, 26, 3509502, 'CAMPINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4891, 26, 3509601, 'CAMPO LIMPO PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4892, 26, 3509700, 'CAMPOS DO JORDÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4893, 26, 3509809, 'CAMPOS NOVOS PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4894, 26, 3509908, 'CANANÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4895, 26, 3509957, 'CANAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4896, 26, 3510005, 'CÂNDIDO MOTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4897, 26, 3510104, 'CÂNDIDO RODRIGUES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4898, 26, 3510153, 'CANITAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4899, 26, 3510203, 'CAPÃO BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4900, 26, 3510302, 'CAPELA DO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4901, 26, 3510401, 'CAPIVARI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4902, 26, 3510500, 'CARAGUATATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4903, 26, 3510609, 'CARAPICUÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4904, 26, 3510708, 'CARDOSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4905, 26, 3510807, 'CASA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4906, 26, 3510906, 'CÁSSIA DOS COQUEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4907, 26, 3511003, 'CASTILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4908, 26, 3511102, 'CATANDUVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4909, 26, 3511201, 'CATIGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4910, 26, 3511300, 'CEDRAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4911, 26, 3511409, 'CERQUEIRA CÉSAR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4912, 26, 3511508, 'CERQUILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4913, 26, 3511607, 'CESÁRIO LANGE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4914, 26, 3511706, 'CHARQUEADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4915, 26, 3557204, 'CHAVANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4916, 26, 3511904, 'CLEMENTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4917, 26, 3512001, 'COLINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4918, 26, 3512100, 'COLÔMBIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4919, 26, 3512209, 'CONCHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4920, 26, 3512308, 'CONCHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4921, 26, 3512407, 'CORDEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4922, 26, 3512506, 'COROADOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4923, 26, 3512605, 'CORONEL MACEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4924, 26, 3512704, 'CORUMBATAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4925, 26, 3512803, 'COSMÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4926, 26, 3512902, 'COSMORAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4927, 26, 3513009, 'COTIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4928, 26, 3513108, 'CRAVINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4929, 26, 3513207, 'CRISTAIS PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4930, 26, 3513306, 'CRUZÁLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4931, 26, 3513405, 'CRUZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4932, 26, 3513504, 'CUBATÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4933, 26, 3513603, 'CUNHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4934, 26, 3513702, 'DESCALVADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4935, 26, 3513801, 'DIADEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4936, 26, 3513850, 'DIRCE REIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4937, 26, 3513900, 'DIVINOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4938, 26, 3514007, 'DOBRADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4939, 26, 3514106, 'DOIS CÓRREGOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4940, 26, 3514205, 'DOLCINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4941, 26, 3514304, 'DOURADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4942, 26, 3514403, 'DRACENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4943, 26, 3514502, 'DUARTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4944, 26, 3514601, 'DUMONT', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4945, 26, 3514700, 'ECHAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4946, 26, 3514809, 'ELDORADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4947, 26, 3514908, 'ELIAS FAUSTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4948, 26, 3514924, 'ELISIÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4949, 26, 3514957, 'EMBAÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4950, 26, 3515004, 'EMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4951, 26, 3515103, 'EMBU-GUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4952, 26, 3515129, 'EMILIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4953, 26, 3515152, 'ENGENHEIRO COELHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4954, 26, 3515186, 'ESPÍRITO SANTO DO PINHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4955, 26, 3515194, 'ESPÍRITO SANTO DO TURVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4956, 26, 3557303, 'ESTIVA GERBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4957, 26, 3515301, 'ESTRELA DO NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4958, 26, 3515202, 'ESTRELA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4959, 26, 3515350, 'EUCLIDES DA CUNHA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4960, 26, 3515400, 'FARTURA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4961, 26, 3515608, 'FERNANDO PRESTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4962, 26, 3515509, 'FERNANDÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4963, 26, 3515657, 'FERNÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4964, 26, 3515707, 'FERRAZ DE VASCONCELOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4965, 26, 3515806, 'FLORA RICA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4966, 26, 3515905, 'FLOREAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4967, 26, 3516002, 'FLÓRIDA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4968, 26, 3516101, 'FLORÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4969, 26, 3516200, 'FRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4970, 26, 3516309, 'FRANCISCO MORATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4971, 26, 3516408, 'FRANCO DA ROCHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4972, 26, 3516507, 'GABRIEL MONTEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4973, 26, 3516606, 'GÁLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4974, 26, 3516705, 'GARÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4975, 26, 3516804, 'GASTÃO VIDIGAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4976, 26, 3516853, 'GAVIÃO PEIXOTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4977, 26, 3516903, 'GENERAL SALGADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4978, 26, 3517000, 'GETULINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4979, 26, 3517109, 'GLICÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4980, 26, 3517208, 'GUAIÇARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4981, 26, 3517307, 'GUAIMBÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4982, 26, 3517406, 'GUAÍRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4983, 26, 3517505, 'GUAPIAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4984, 26, 3517604, 'GUAPIARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4985, 26, 3517703, 'GUARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4986, 26, 3517802, 'GUARAÇAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4987, 26, 3517901, 'GUARACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4988, 26, 3518008, 'GUARANI D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4989, 26, 3518107, 'GUARANTÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4990, 26, 3518206, 'GUARARAPES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4991, 26, 3518305, 'GUARAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4992, 26, 3518404, 'GUARATINGUETÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4993, 26, 3518503, 'GUAREÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4994, 26, 3518602, 'GUARIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4995, 26, 3518701, 'GUARUJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4996, 26, 3518800, 'GUARULHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4997, 26, 3518859, 'GUATAPARÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4998, 26, 3518909, 'GUZOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(4999, 26, 3519006, 'HERCULÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5000, 26, 3519055, 'HOLAMBRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5001, 26, 3519071, 'HORTOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5002, 26, 3519105, 'IACANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5003, 26, 3519204, 'IACRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5004, 26, 3519253, 'IARAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5005, 26, 3519303, 'IBATÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5006, 26, 3519402, 'IBIRÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5007, 26, 3519501, 'IBIRAREMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5008, 26, 3519600, 'IBITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5009, 26, 3519709, 'IBIÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5010, 26, 3519808, 'ICÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5011, 26, 3519907, 'IEPÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5012, 26, 3520004, 'IGARAÇU DO TIETÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5013, 26, 3520103, 'IGARAPAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5014, 26, 3520202, 'IGARATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5015, 26, 3520301, 'IGUAPE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5016, 26, 3520426, 'ILHA COMPRIDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5017, 26, 3520442, 'ILHA SOLTEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5018, 26, 3520400, 'ILHABELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5019, 26, 3520509, 'INDAIATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5020, 26, 3520608, 'INDIANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5021, 26, 3520707, 'INDIAPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5022, 26, 3520806, 'INÚBIA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5023, 26, 3520905, 'IPAUSSU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5024, 26, 3521002, 'IPERÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5025, 26, 3521101, 'IPEÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5026, 26, 3521150, 'IPIGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5027, 26, 3521200, 'IPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5028, 26, 3521309, 'IPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5029, 26, 3521408, 'IRACEMÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5030, 26, 3521507, 'IRAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5031, 26, 3521606, 'IRAPURU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5032, 26, 3521705, 'ITABERÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5033, 26, 3521804, 'ITAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5034, 26, 3521903, 'ITAJOBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5035, 26, 3522000, 'ITAJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5036, 26, 3522109, 'ITANHAÉM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5037, 26, 3522158, 'ITAÓCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5038, 26, 3522208, 'ITAPECERICA DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5039, 26, 3522307, 'ITAPETININGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5040, 26, 3522406, 'ITAPEVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5041, 26, 3522505, 'ITAPEVI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5042, 26, 3522604, 'ITAPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5043, 26, 3522653, 'ITAPIRAPUÃ PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5044, 26, 3522703, 'ITÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5045, 26, 3522802, 'ITAPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5046, 26, 3522901, 'ITAPUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5047, 26, 3523008, 'ITAPURA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5048, 26, 3523107, 'ITAQUAQUECETUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5049, 26, 3523206, 'ITARARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5050, 26, 3523305, 'ITARIRI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5051, 26, 3523404, 'ITATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5052, 26, 3523503, 'ITATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5053, 26, 3523602, 'ITIRAPINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5054, 26, 3523701, 'ITIRAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5055, 26, 3523800, 'ITOBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5056, 26, 3523909, 'ITU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5057, 26, 3524006, 'ITUPEVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5058, 26, 3524105, 'ITUVERAVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5059, 26, 3524204, 'JABORANDI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5060, 26, 3524303, 'JABOTICABAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5061, 26, 3524402, 'JACAREÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5062, 26, 3524501, 'JACI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5063, 26, 3524600, 'JACUPIRANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5064, 26, 3524709, 'JAGUARIÚNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5065, 26, 3524808, 'JALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5066, 26, 3524907, 'JAMBEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5067, 26, 3525003, 'JANDIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5068, 26, 3525102, 'JARDINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5069, 26, 3525201, 'JARINU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5070, 26, 3525300, 'JAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5071, 26, 3525409, 'JERIQUARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5072, 26, 3525508, 'JOANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5073, 26, 3525607, 'JOÃO RAMALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5074, 26, 3525706, 'JOSÉ BONIFÁCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5075, 26, 3525805, 'JÚLIO MESQUITA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5076, 26, 3525854, 'JUMIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5077, 26, 3525904, 'JUNDIAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5078, 26, 3526001, 'JUNQUEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5079, 26, 3526100, 'JUQUIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5080, 26, 3526209, 'JUQUITIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5081, 26, 3526308, 'LAGOINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5082, 26, 3526407, 'LARANJAL PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5083, 26, 3526506, 'LAVÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5084, 26, 3526605, 'LAVRINHAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5085, 26, 3526704, 'LEME', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5086, 26, 3526803, 'LENÇÓIS PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5087, 26, 3526902, 'LIMEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5088, 26, 3527009, 'LINDÓIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5089, 26, 3527108, 'LINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5090, 26, 3527207, 'LORENA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5091, 26, 3527256, 'LOURDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5092, 26, 3527306, 'LOUVEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5093, 26, 3527405, 'LUCÉLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5094, 26, 3527504, 'LUCIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5095, 26, 3527603, 'LUÍS ANTÔNIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5096, 26, 3527702, 'LUIZIÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5097, 26, 3527801, 'LUPÉRCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5098, 26, 3527900, 'LUTÉCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5099, 26, 3528007, 'MACATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5100, 26, 3528106, 'MACAUBAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5101, 26, 3528205, 'MACEDÔNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5102, 26, 3528304, 'MAGDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5103, 26, 3528403, 'MAIRINQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5104, 26, 3528502, 'MAIRIPORÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5105, 26, 3528601, 'MANDURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5106, 26, 3528700, 'MARABÁ PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5107, 26, 3528809, 'MARACAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5108, 26, 3528858, 'MARAPOAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5109, 26, 3528908, 'MARIÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5110, 26, 3529005, 'MARÍLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5111, 26, 3529104, 'MARINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5112, 26, 3529203, 'MARTINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5113, 26, 3529302, 'MATÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5114, 26, 3529401, 'MAUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5115, 26, 3529500, 'MENDONÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5116, 26, 3529609, 'MERIDIANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5117, 26, 3529658, 'MESÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5118, 26, 3529708, 'MIGUELÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5119, 26, 3529807, 'MINEIROS DO TIETÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5120, 26, 3530003, 'MIRA ESTRELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5121, 26, 3529906, 'MIRACATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5122, 26, 3530102, 'MIRANDÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5123, 26, 3530201, 'MIRANTE DO PARANAPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5124, 26, 3530300, 'MIRASSOL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5125, 26, 3530409, 'MIRASSOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5126, 26, 3530508, 'MOCOCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5127, 26, 3530607, 'MOGI DAS CRUZES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5128, 26, 3530706, 'MOGI GUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5129, 26, 3530805, 'MOGI MIRIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5130, 26, 3530904, 'MOMBUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5131, 26, 3531001, 'MONÇÕES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5132, 26, 3531100, 'MONGAGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5133, 26, 3531209, 'MONTE ALEGRE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5134, 26, 3531308, 'MONTE ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5135, 26, 3531407, 'MONTE APRAZÍVEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5136, 26, 3531506, 'MONTE AZUL PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5137, 26, 3531605, 'MONTE CASTELO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5138, 26, 3531803, 'MONTE MOR', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5139, 26, 3531704, 'MONTEIRO LOBATO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5140, 26, 3531902, 'MORRO AGUDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5141, 26, 3532009, 'MORUNGABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5142, 26, 3532058, 'MOTUCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5143, 26, 3532108, 'MURUTINGA DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5144, 26, 3532157, 'NANTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5145, 26, 3532207, 'NARANDIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5146, 26, 3532306, 'NATIVIDADE DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5147, 26, 3532405, 'NAZARÉ PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5148, 26, 3532504, 'NEVES PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5149, 26, 3532603, 'NHANDEARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5150, 26, 3532702, 'NIPOÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5151, 26, 3532801, 'NOVA ALIANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5152, 26, 3532827, 'NOVA CAMPINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5153, 26, 3532843, 'NOVA CANAÃ PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5154, 26, 3532868, 'NOVA CASTILHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5155, 26, 3532900, 'NOVA EUROPA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5156, 26, 3533007, 'NOVA GRANADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5157, 26, 3533106, 'NOVA GUATAPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5158, 26, 3533205, 'NOVA INDEPENDÊNCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5159, 26, 3533304, 'NOVA LUZITÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5160, 26, 3533403, 'NOVA ODESSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5161, 26, 3533254, 'NOVAIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5162, 26, 3533502, 'NOVO HORIZONTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5163, 26, 3533601, 'NUPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5164, 26, 3533700, 'OCAUÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5165, 26, 3533809, 'ÓLEO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5166, 26, 3533908, 'OLÍMPIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5167, 26, 3534005, 'ONDA VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5168, 26, 3534104, 'ORIENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5169, 26, 3534203, 'ORINDIÚVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5170, 26, 3534302, 'ORLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5171, 26, 3534401, 'OSASCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5172, 26, 3534500, 'OSCAR BRESSANE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5173, 26, 3534609, 'OSVALDO CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5174, 26, 3534708, 'OURINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5175, 26, 3534807, 'OURO VERDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5176, 26, 3534757, 'OUROESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5177, 26, 3534906, 'PACAEMBU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5178, 26, 3535002, 'PALESTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5179, 26, 3535101, 'PALMARES PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5180, 26, 3535200, 'PALMEIRA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5181, 26, 3535309, 'PALMITAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5182, 26, 3535408, 'PANORAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5183, 26, 3535507, 'PARAGUAÇU PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5184, 26, 3535606, 'PARAIBUNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5185, 26, 3535705, 'PARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5186, 26, 3535804, 'PARANAPANEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5187, 26, 3535903, 'PARANAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5188, 26, 3536000, 'PARAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5189, 26, 3536109, 'PARDINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5190, 26, 3536208, 'PARIQUERA-AÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5191, 26, 3536257, 'PARISI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5192, 26, 3536307, 'PATROCÍNIO PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5193, 26, 3536406, 'PAULICÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5194, 26, 3536505, 'PAULÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5195, 26, 3536570, 'PAULISTÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5196, 26, 3536604, 'PAULO DE FARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5197, 26, 3536703, 'PEDERNEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5198, 26, 3536802, 'PEDRA BELA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5199, 26, 3536901, 'PEDRANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5200, 26, 3537008, 'PEDREGULHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5201, 26, 3537107, 'PEDREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5202, 26, 3537156, 'PEDRINHAS PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5203, 26, 3537206, 'PEDRO DE TOLEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5204, 26, 3537305, 'PENÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5205, 26, 3537404, 'PEREIRA BARRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5206, 26, 3537503, 'PEREIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5207, 26, 3537602, 'PERUÍBE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5208, 26, 3537701, 'PIACATU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5209, 26, 3537800, 'PIEDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5210, 26, 3537909, 'PILAR DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5211, 26, 3538006, 'PINDAMONHANGABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5212, 26, 3538105, 'PINDORAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5213, 26, 3538204, 'PINHALZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5214, 26, 3538303, 'PIQUEROBI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5215, 26, 3538501, 'PIQUETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5216, 26, 3538600, 'PIRACAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5217, 26, 3538709, 'PIRACICABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5218, 26, 3538808, 'PIRAJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5219, 26, 3538907, 'PIRAJUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5220, 26, 3539004, 'PIRANGI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5221, 26, 3539103, 'PIRAPORA DO BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5222, 26, 3539202, 'PIRAPOZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5223, 26, 3539301, 'PIRASSUNUNGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5224, 26, 3539400, 'PIRATININGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5225, 26, 3539509, 'PITANGUEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5226, 26, 3539608, 'PLANALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5227, 26, 3539707, 'PLATINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5228, 26, 3539806, 'POÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5229, 26, 3539905, 'POLONI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5230, 26, 3540002, 'POMPÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5231, 26, 3540101, 'PONGAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5232, 26, 3540200, 'PONTAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5233, 26, 3540259, 'PONTALINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5234, 26, 3540309, 'PONTES GESTAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5235, 26, 3540408, 'POPULINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5236, 26, 3540507, 'PORANGABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5237, 26, 3540606, 'PORTO FELIZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5238, 26, 3540705, 'PORTO FERREIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5239, 26, 3540754, 'POTIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5240, 26, 3540804, 'POTIRENDABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5241, 26, 3540853, 'PRACINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5242, 26, 3540903, 'PRADÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5243, 26, 3541000, 'PRAIA GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5244, 26, 3541059, 'PRATÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5245, 26, 3541109, 'PRESIDENTE ALVES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5246, 26, 3541208, 'PRESIDENTE BERNARDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5247, 26, 3541307, 'PRESIDENTE EPITÁCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5248, 26, 3541406, 'PRESIDENTE PRUDENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5249, 26, 3541505, 'PRESIDENTE VENCESLAU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5250, 26, 3541604, 'PROMISSÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5251, 26, 3541653, 'QUADRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5252, 26, 3541703, 'QUATÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5253, 26, 3541802, 'QUEIROZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5254, 26, 3541901, 'QUELUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5255, 26, 3542008, 'QUINTANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5256, 26, 3542107, 'RAFARD', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5257, 26, 3542206, 'RANCHARIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5258, 26, 3542305, 'REDENÇÃO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5259, 26, 3542404, 'REGENTE FEIJÓ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5260, 26, 3542503, 'REGINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5261, 26, 3542602, 'REGISTRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5262, 26, 3542701, 'RESTINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5263, 26, 3542800, 'RIBEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5264, 26, 3542909, 'RIBEIRÃO BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5265, 26, 3543006, 'RIBEIRÃO BRANCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5266, 26, 3543105, 'RIBEIRÃO CORRENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5267, 26, 3543204, 'RIBEIRÃO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5268, 26, 3543238, 'RIBEIRÃO DOS ÍNDIOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5269, 26, 3543253, 'RIBEIRÃO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5270, 26, 3543303, 'RIBEIRÃO PIRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5271, 26, 3543402, 'RIBEIRÃO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5272, 26, 3543600, 'RIFAINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5273, 26, 3543709, 'RINCÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5274, 26, 3543808, 'RINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5275, 26, 3543907, 'RIO CLARO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5276, 26, 3544004, 'RIO DAS PEDRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5277, 26, 3544103, 'RIO GRANDE DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5278, 26, 3544202, 'RIOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5279, 26, 3543501, 'RIVERSUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5280, 26, 3544251, 'ROSANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5281, 26, 3544301, 'ROSEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5282, 26, 3544400, 'RUBIÁCEA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5283, 26, 3544509, 'RUBINÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5284, 26, 3544608, 'SABINO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5285, 26, 3544707, 'SAGRES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5286, 26, 3544806, 'SALES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5287, 26, 3544905, 'SALES OLIVEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5288, 26, 3545001, 'SALESÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5289, 26, 3545100, 'SALMOURÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5290, 26, 3545159, 'SALTINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5291, 26, 3545209, 'SALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5292, 26, 3545308, 'SALTO DE PIRAPORA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5293, 26, 3545407, 'SALTO GRANDE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5294, 26, 3545506, 'SANDOVALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5295, 26, 3545605, 'SANTA ADÉLIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5296, 26, 3545704, 'SANTA ALBERTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5297, 26, 3545803, 'SANTA BÁRBARA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5298, 26, 3546009, 'SANTA BRANCA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5299, 26, 3546108, 'SANTA CLARA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5300, 26, 3546207, 'SANTA CRUZ DA CONCEIÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5301, 26, 3546256, 'SANTA CRUZ DA ESPERANÇA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5302, 26, 3546306, 'SANTA CRUZ DAS PALMEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5303, 26, 3546405, 'SANTA CRUZ DO RIO PARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5304, 26, 3546504, 'SANTA ERNESTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5305, 26, 3546603, 'SANTA FÉ DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5306, 26, 3546702, 'SANTA GERTRUDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5307, 26, 3546801, 'SANTA ISABEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5308, 26, 3546900, 'SANTA LÚCIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5309, 26, 3547007, 'SANTA MARIA DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5310, 26, 3547106, 'SANTA MERCEDES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5311, 26, 3547502, 'SANTA RITA DO PASSA QUATRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5312, 26, 3547403, 'SANTA RITA D\'OESTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5313, 26, 3547601, 'SANTA ROSA DE VITERBO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5314, 26, 3547650, 'SANTA SALETE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5315, 26, 3547205, 'SANTANA DA PONTE PENSA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5316, 26, 3547304, 'SANTANA DE PARNAÍBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5317, 26, 3547700, 'SANTO ANASTÁCIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5318, 26, 3547809, 'SANTO ANDRÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5319, 26, 3547908, 'SANTO ANTÔNIO DA ALEGRIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5320, 26, 3548005, 'SANTO ANTÔNIO DE POSSE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5321, 26, 3548054, 'SANTO ANTÔNIO DO ARACANGUÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5322, 26, 3548104, 'SANTO ANTÔNIO DO JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5323, 26, 3548203, 'SANTO ANTÔNIO DO PINHAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5324, 26, 3548302, 'SANTO EXPEDITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5325, 26, 3548401, 'SANTÓPOLIS DO AGUAPEÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5326, 26, 3548500, 'SANTOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5327, 26, 3548609, 'SÃO BENTO DO SAPUCAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5328, 26, 3548708, 'SÃO BERNARDO DO CAMPO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5329, 26, 3548807, 'SÃO CAETANO DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5330, 26, 3548906, 'SÃO CARLOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5331, 26, 3549003, 'SÃO FRANCISCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5332, 26, 3549102, 'SÃO JOÃO DA BOA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5333, 26, 3549201, 'SÃO JOÃO DAS DUAS PONTES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5334, 26, 3549250, 'SÃO JOÃO DE IRACEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5335, 26, 3549300, 'SÃO JOÃO DO PAU D\'ALHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5336, 26, 3549409, 'SÃO JOAQUIM DA BARRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5337, 26, 3549508, 'SÃO JOSÉ DA BELA VISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5338, 26, 3549607, 'SÃO JOSÉ DO BARREIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5339, 26, 3549706, 'SÃO JOSÉ DO RIO PARDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5340, 26, 3549805, 'SÃO JOSÉ DO RIO PRETO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5341, 26, 3549904, 'SÃO JOSÉ DOS CAMPOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5342, 26, 3549953, 'SÃO LOURENÇO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5343, 26, 3550001, 'SÃO LUÍS DO PARAITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5344, 26, 3550100, 'SÃO MANUEL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5345, 26, 3550209, 'SÃO MIGUEL ARCANJO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5346, 26, 3550308, 'SÃO PAULO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5347, 26, 3550407, 'SÃO PEDRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5348, 26, 3550506, 'SÃO PEDRO DO TURVO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5349, 26, 3550605, 'SÃO ROQUE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5350, 26, 3550704, 'SÃO SEBASTIÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5351, 26, 3550803, 'SÃO SEBASTIÃO DA GRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5352, 26, 3550902, 'SÃO SIMÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5353, 26, 3551009, 'SÃO VICENTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5354, 26, 3551108, 'SARAPUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5355, 26, 3551207, 'SARUTAIÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5356, 26, 3551306, 'SEBASTIANÓPOLIS DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5357, 26, 3551405, 'SERRA AZUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5358, 26, 3551603, 'SERRA NEGRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5359, 26, 3551504, 'SERRANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5360, 26, 3551702, 'SERTÃOZINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5361, 26, 3551801, 'SETE BARRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5362, 26, 3551900, 'SEVERÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5363, 26, 3552007, 'SILVEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5364, 26, 3552106, 'SOCORRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5365, 26, 3552205, 'SOROCABA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5366, 26, 3552304, 'SUD MENNUCCI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5367, 26, 3552403, 'SUMARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5368, 26, 3552551, 'SUZANÁPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5369, 26, 3552502, 'SUZANO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5370, 26, 3552601, 'TABAPUÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5371, 26, 3552700, 'TABATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5372, 26, 3552809, 'TABOÃO DA SERRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5373, 26, 3552908, 'TACIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5374, 26, 3553005, 'TAGUAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5375, 26, 3553104, 'TAIAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5376, 26, 3553203, 'TAIÚVA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5377, 26, 3553302, 'TAMBAÚ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5378, 26, 3553401, 'TANABI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5379, 26, 3553500, 'TAPIRAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5380, 26, 3553609, 'TAPIRATIBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5381, 26, 3553658, 'TAQUARAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5382, 26, 3553708, 'TAQUARITINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5383, 26, 3553807, 'TAQUARITUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5384, 26, 3553856, 'TAQUARIVAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5385, 26, 3553906, 'TARABAI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5386, 26, 3553955, 'TARUMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5387, 26, 3554003, 'TATUÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5388, 26, 3554102, 'TAUBATÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5389, 26, 3554201, 'TEJUPÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5390, 26, 3554300, 'TEODORO SAMPAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5391, 26, 3554409, 'TERRA ROXA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5392, 26, 3554508, 'TIETÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5393, 26, 3554607, 'TIMBURI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5394, 26, 3554656, 'TORRE DE PEDRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5395, 26, 3554706, 'TORRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5396, 26, 3554755, 'TRABIJU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5397, 26, 3554805, 'TREMEMBÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5398, 26, 3554904, 'TRÊS FRONTEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5399, 26, 3554953, 'TUIUTI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5400, 26, 3555000, 'TUPÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5401, 26, 3555109, 'TUPI PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5402, 26, 3555208, 'TURIÚBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5403, 26, 3555307, 'TURMALINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5404, 26, 3555356, 'UBARANA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5405, 26, 3555406, 'UBATUBA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5406, 26, 3555505, 'UBIRAJARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5407, 26, 3555604, 'UCHOA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5408, 26, 3555703, 'UNIÃO PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5409, 26, 3555802, 'URÂNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5410, 26, 3555901, 'URU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5411, 26, 3556008, 'URUPÊS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5412, 26, 3556107, 'VALENTIM GENTIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5413, 26, 3556206, 'VALINHOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5414, 26, 3556305, 'VALPARAÍSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5415, 26, 3556354, 'VARGEM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5416, 26, 3556404, 'VARGEM GRANDE DO SUL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5417, 26, 3556453, 'VARGEM GRANDE PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5418, 26, 3556503, 'VÁRZEA PAULISTA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5419, 26, 3556602, 'VERA CRUZ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5420, 26, 3556701, 'VINHEDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5421, 26, 3556800, 'VIRADOURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5422, 26, 3556909, 'VISTA ALEGRE DO ALTO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5423, 26, 3556958, 'VITÓRIA BRASIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5424, 26, 3557006, 'VOTORANTIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5425, 26, 3557105, 'VOTUPORANGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5426, 26, 3557154, 'ZACARIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5427, 27, 1700251, 'ABREULÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5428, 27, 1700301, 'AGUIARNÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5429, 27, 1700350, 'ALIANÇA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5430, 27, 1700400, 'ALMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5431, 27, 1700707, 'ALVORADA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5432, 27, 1701002, 'ANANÁS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5433, 27, 1701051, 'ANGICO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5434, 27, 1701101, 'APARECIDA DO RIO NEGRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5435, 27, 1701309, 'ARAGOMINAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5436, 27, 1701903, 'ARAGUACEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5437, 27, 1702000, 'ARAGUAÇU', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5438, 27, 1702109, 'ARAGUAÍNA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5439, 27, 1702158, 'ARAGUANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5440, 27, 1702208, 'ARAGUATINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5441, 27, 1702307, 'ARAPOEMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5442, 27, 1702406, 'ARRAIAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5443, 27, 1702554, 'AUGUSTINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5444, 27, 1702703, 'AURORA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5445, 27, 1702901, 'AXIXÁ DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5446, 27, 1703008, 'BABAÇULÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5447, 27, 1703057, 'BANDEIRANTES DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5448, 27, 1703073, 'BARRA DO OURO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5449, 27, 1703107, 'BARROLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5450, 27, 1703206, 'BERNARDO SAYÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5451, 27, 1703305, 'BOM JESUS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5452, 27, 1703602, 'BRASILÂNDIA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5453, 27, 1703701, 'BREJINHO DE NAZARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5454, 27, 1703800, 'BURITI DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5455, 27, 1703826, 'CACHOEIRINHA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5456, 27, 1703842, 'CAMPOS LINDOS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5457, 27, 1703867, 'CARIRI DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5458, 27, 1703883, 'CARMOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5459, 27, 1703891, 'CARRASCO BONITO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5460, 27, 1703909, 'CASEARA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5461, 27, 1704105, 'CENTENÁRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5462, 27, 1705102, 'CHAPADA DA NATIVIDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5463, 27, 1704600, 'CHAPADA DE AREIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5464, 27, 1705508, 'COLINAS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5465, 27, 1716703, 'COLMÉIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5466, 27, 1705557, 'COMBINADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5467, 27, 1705607, 'CONCEIÇÃO DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5468, 27, 1706001, 'COUTO MAGALHÃES', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5469, 27, 1706100, 'CRISTALÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5470, 27, 1706258, 'CRIXÁS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5471, 27, 1706506, 'DARCINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5472, 27, 1707009, 'DIANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5473, 27, 1707108, 'DIVINÓPOLIS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5474, 27, 1707207, 'DOIS IRMÃOS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5475, 27, 1707306, 'DUERÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5476, 27, 1707405, 'ESPERANTINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5477, 27, 1707553, 'FÁTIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5478, 27, 1707652, 'FIGUEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5479, 27, 1707702, 'FILADÉLFIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5480, 27, 1708205, 'FORMOSO DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5481, 27, 1708254, 'FORTALEZA DO TABOCÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5482, 27, 1708304, 'GOIANORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5483, 27, 1709005, 'GOIATINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5484, 27, 1709302, 'GUARAÍ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5485, 27, 1709500, 'GURUPI', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5486, 27, 1709807, 'IPUEIRAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5487, 27, 1710508, 'ITACAJÁ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5488, 27, 1710706, 'ITAGUATINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5489, 27, 1710904, 'ITAPIRATINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5490, 27, 1711100, 'ITAPORÃ DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5491, 27, 1711506, 'JAÚ DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5492, 27, 1711803, 'JUARINA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5493, 27, 1711902, 'LAGOA DA CONFUSÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5494, 27, 1711951, 'LAGOA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5495, 27, 1712009, 'LAJEADO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5496, 27, 1712157, 'LAVANDEIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5497, 27, 1712405, 'LIZARDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5498, 27, 1712454, 'LUZINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5499, 27, 1712504, 'MARIANÓPOLIS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5500, 27, 1712702, 'MATEIROS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5501, 27, 1712801, 'MAURILÂNDIA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5502, 27, 1713205, 'MIRACEMA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5503, 27, 1713304, 'MIRANORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5504, 27, 1713601, 'MONTE DO CARMO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5505, 27, 1713700, 'MONTE SANTO DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5506, 27, 1713957, 'MURICILÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5507, 27, 1714203, 'NATIVIDADE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5508, 27, 1714302, 'NAZARÉ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5509, 27, 1714880, 'NOVA OLINDA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5510, 27, 1715002, 'NOVA ROSALÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5511, 27, 1715101, 'NOVO ACORDO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5512, 27, 1715150, 'NOVO ALEGRE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5513, 27, 1715259, 'NOVO JARDIM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5514, 27, 1715507, 'OLIVEIRA DE FÁTIMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5515, 27, 1721000, 'PALMAS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5516, 27, 1715705, 'PALMEIRANTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5517, 27, 1713809, 'PALMEIRAS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5518, 27, 1715754, 'PALMEIRÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5519, 27, 1716109, 'PARAÍSO DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5520, 27, 1716208, 'PARANÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5521, 27, 1716307, 'PAU D\'ARCO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5522, 27, 1716505, 'PEDRO AFONSO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5523, 27, 1716604, 'PEIXE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5524, 27, 1716653, 'PEQUIZEIRO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5525, 27, 1717008, 'PINDORAMA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5526, 27, 1717206, 'PIRAQUÊ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5527, 27, 1717503, 'PIUM', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5528, 27, 1717800, 'PONTE ALTA DO BOM JESUS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5529, 27, 1717909, 'PONTE ALTA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5530, 27, 1718006, 'PORTO ALEGRE DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5531, 27, 1718204, 'PORTO NACIONAL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5532, 27, 1718303, 'PRAIA NORTE', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5533, 27, 1718402, 'PRESIDENTE KENNEDY', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5534, 27, 1718451, 'PUGMIL', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5535, 27, 1718501, 'RECURSOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5536, 27, 1718550, 'RIACHINHO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5537, 27, 1718659, 'RIO DA CONCEIÇÃO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5538, 27, 1718709, 'RIO DOS BOIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5539, 27, 1718758, 'RIO SONO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5540, 27, 1718808, 'SAMPAIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5541, 27, 1718840, 'SANDOLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5542, 27, 1718865, 'SANTA FÉ DO ARAGUAIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5543, 27, 1718881, 'SANTA MARIA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5544, 27, 1718899, 'SANTA RITA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5545, 27, 1718907, 'SANTA ROSA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5546, 27, 1719004, 'SANTA TEREZA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5547, 27, 1720002, 'SANTA TEREZINHA DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5548, 27, 1720101, 'SÃO BENTO DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5549, 27, 1720150, 'SÃO FÉLIX DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5550, 27, 1720200, 'SÃO MIGUEL DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5551, 27, 1720259, 'SÃO SALVADOR DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5552, 27, 1720309, 'SÃO SEBASTIÃO DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5553, 27, 1720499, 'SÃO VALÉRIO', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5554, 27, 1720655, 'SILVANÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5555, 27, 1720804, 'SÍTIO NOVO DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5556, 27, 1720853, 'SUCUPIRA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5557, 27, 1720903, 'TAGUATINGA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5558, 27, 1720937, 'TAIPAS DO TOCANTINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5559, 27, 1720978, 'TALISMÃ', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5560, 27, 1721109, 'TOCANTÍNIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5561, 27, 1721208, 'TOCANTINÓPOLIS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5562, 27, 1721257, 'TUPIRAMA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5563, 27, 1721307, 'TUPIRATINS', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5564, 27, 1722081, 'WANDERLÂNDIA', '0');
INSERT INTO `tb_municipios` (`pr_municipio`, `es_uf`, `in_codigo`, `vc_municipio`, `bl_removido`) VALUES(5565, 27, 1722107, 'XAMBIOÁ', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_notas`
--

DROP TABLE IF EXISTS `tb_notas`;
CREATE TABLE IF NOT EXISTS `tb_notas` (
  `pr_nota` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `in_nota` int(10) UNSIGNED NOT NULL,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  `es_competencia` int(10) UNSIGNED DEFAULT NULL,
  `es_avaliador` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`pr_nota`),
  KEY `es_candidatura` (`es_candidatura`),
  KEY `es_etapa` (`es_etapa`),
  KEY `es_competencia` (`es_competencia`),
  KEY `es_avaliador` (`es_avaliador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_opcoes`
--

DROP TABLE IF EXISTS `tb_opcoes`;
CREATE TABLE IF NOT EXISTS `tb_opcoes` (
  `pr_opcao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `tx_opcao` mediumtext COLLATE utf8_bin NOT NULL,
  `in_valor` int(10) UNSIGNED DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_opcao`),
  KEY `IDQuestao` (`es_questao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_prorrogacao_editais`
--

DROP TABLE IF EXISTS `tb_prorrogacao_editais`;
CREATE TABLE IF NOT EXISTS `tb_prorrogacao_editais` (
  `pr_prorrogacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_usuario` int(10) UNSIGNED NOT NULL,
  `dt_prorrogacao` datetime NOT NULL,
  `dt_fim_antigo` datetime NOT NULL,
  `dt_fim_novo` datetime NOT NULL,
  `es_edital` int(10) UNSIGNED NOT NULL,
  `vc_link` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pr_prorrogacao`),
  KEY `es_usuario` (`es_usuario`),
  KEY `es_edital` (`es_edital`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_questoes`
--

DROP TABLE IF EXISTS `tb_questoes`;
CREATE TABLE IF NOT EXISTS `tb_questoes` (
  `pr_questao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_etapa` int(10) UNSIGNED NOT NULL,
  `tx_questao` mediumtext COLLATE utf8_bin NOT NULL,
  `vc_respostaAceita` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `in_peso` tinyint(3) UNSIGNED DEFAULT NULL,
  `in_tipo` tinyint(3) UNSIGNED NOT NULL COMMENT '1: Customizadas; 2: Aberta; 3: Sim/Não (Sim positivo); 4: Sim/Não (Não positivo); 5: Nenhum/Básico/Intermediário/Avançado; 6 - Intervalo',
  `bl_eliminatoria` enum('0','1') COLLATE utf8_bin NOT NULL,
  `bl_obrigatorio` enum('0','1') COLLATE utf8_bin NOT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `es_competencia` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`pr_questao`),
  KEY `IdEtapa` (`es_etapa`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `idUsuarioUltimoAlterador` (`es_usuarioAlteracao`),
  KEY `es_competencia` (`es_competencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_respostas`
--

DROP TABLE IF EXISTS `tb_respostas`;
CREATE TABLE IF NOT EXISTS `tb_respostas` (
  `pr_resposta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidatura` int(10) UNSIGNED NOT NULL,
  `es_questao` int(10) UNSIGNED NOT NULL,
  `es_opcao` int(10) UNSIGNED DEFAULT NULL,
  `tx_resposta` mediumtext COLLATE utf8_bin NOT NULL,
  `dt_resposta` datetime NOT NULL,
  `in_avaliacao` tinyint(3) UNSIGNED DEFAULT NULL,
  `dt_avaliacao` datetime DEFAULT NULL,
  `es_avaliador` int(10) UNSIGNED DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED DEFAULT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`pr_resposta`),
  UNIQUE KEY `es_candidatura` (`es_candidatura`,`es_questao`,`es_avaliador`) USING BTREE,
  KEY `IdCandidatura` (`es_candidatura`),
  KEY `IdQuestao` (`es_questao`),
  KEY `IdAvaliador` (`es_avaliador`),
  KEY `IdUsuarioCadastrador` (`es_usuarioCadastro`),
  KEY `IdUsuarioUltimoAlterador` (`es_usuarioAlteracao`),
  KEY `es_opcao` (`es_opcao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_sessoes`
--

DROP TABLE IF EXISTS `tb_sessoes`;
CREATE TABLE IF NOT EXISTS `tb_sessoes` (
  `id` varchar(128) COLLATE utf8_bin NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  `es_usuario` int(10) UNSIGNED DEFAULT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`),
  KEY `es_usuario` (`es_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_sessoes`
--

INSERT INTO `tb_sessoes` (`id`, `ip_address`, `timestamp`, `data`, `es_usuario`) VALUES('dc37duvkpk8gc0fqgqbkeg5qoqbm7gfr', '::1', 1635359383, 0x5f5f63695f6c6173745f726567656e65726174657c693a313633353335393338333b, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_status_candidaturas`
--

DROP TABLE IF EXISTS `tb_status_candidaturas`;
CREATE TABLE IF NOT EXISTS `tb_status_candidaturas` (
  `pr_status` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `in_status_legado` tinyint(3) UNSIGNED DEFAULT NULL,
  `vc_status` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pr_status`),
  UNIQUE KEY `in_status_legado` (`in_status_legado`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_status_candidaturas`
--

INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(1, 1, 'Cadastro deferido');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(2, NULL, 'Cadastro indeferido');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(3, NULL, 'Currículo Cadastrado');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(4, 4, 'Aprovado(a) req. obrigatórios');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(5, 5, 'Eliminado(a) req.  obrigatórios');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(6, NULL, 'Currículo confirmado');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(7, 6, 'Candidatura realizada');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(8, NULL, 'Currículo Avaliado');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(9, 9, 'Reprovado(a) análise curricular');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(10, 8, 'Selecionado(a) para entrevista');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(11, NULL, 'Avaliado(a) Entrevista por Competência');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(12, NULL, 'Avaliado(a) Entrevista com especialista');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(13, NULL, 'Eliminado(a) Revisão de requisitos');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(14, 10, 'Aguardando decisão final');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(15, 11, 'Eliminado(a) na entrevista');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(16, NULL, 'Aguardando análise da autoridade máxima');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(17, NULL, 'Req. desejáveis preenchidos');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(18, NULL, 'Reprovado(a) no processo seletivo');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(19, NULL, 'Aprovado(a) no processo seletivo');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(20, NULL, 'Reprovado(a) Habilitação');
INSERT INTO `tb_status_candidaturas` (`pr_status`, `in_status_legado`, `vc_status`) VALUES(21, NULL, 'Reprovado(a) Habilitação (confirmado)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_uf`
--

DROP TABLE IF EXISTS `tb_uf`;
CREATE TABLE IF NOT EXISTS `tb_uf` (
  `pr_uf` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ch_sigla` char(2) COLLATE utf8_bin NOT NULL,
  `vc_uf` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pr_uf`),
  UNIQUE KEY `ds_sigla` (`ch_sigla`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_uf`
--

INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(1, 'AC', 'Acre');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(2, 'AL', 'Alagoas');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(3, 'AM', 'Amazonas');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(4, 'AP', 'Amapá');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(5, 'BA', 'Bahia');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(6, 'CE', 'Ceará');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(7, 'DF', 'Distrito Federal');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(8, 'ES', 'Espírito Santo');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(9, 'GO', 'Goiás');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(10, 'MA', 'Maranhão');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(11, 'MG', 'Minas Gerais');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(12, 'MS', 'Mato Grosso do Sul');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(13, 'MT', 'Mato Grosso');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(14, 'PA', 'Pará');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(15, 'PB', 'Paraíba');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(16, 'PE', 'Pernambuco');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(17, 'PI', 'Piauí');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(18, 'PR', 'Paraná');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(19, 'RJ', 'Rio de Janeiro');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(20, 'RN', 'Rio Grande do Norte');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(21, 'RO', 'Rondônia');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(22, 'RR', 'Roraima');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(23, 'RS', 'Rio Grande do Sul');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(24, 'SC', 'Santa Catarina');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(25, 'SE', 'Sergipe');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(26, 'SP', 'SÃ£o Paulo');
INSERT INTO `tb_uf` (`pr_uf`, `ch_sigla`, `vc_uf`) VALUES(27, 'TO', 'Tocantins');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuarios`
--

DROP TABLE IF EXISTS `tb_usuarios`;
CREATE TABLE IF NOT EXISTS `tb_usuarios` (
  `pr_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `es_candidato` int(10) UNSIGNED DEFAULT NULL,
  `en_perfil` enum('candidato','avaliador','sugesp','orgaos','administrador') COLLATE utf8_bin NOT NULL,
  `es_instituicao` int(10) UNSIGNED DEFAULT NULL,
  `vc_nome` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `vc_telefone` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `vc_login` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `vc_senha` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `vc_senha_temporaria` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `dt_cadastro` date DEFAULT NULL,
  `dt_alteracao` date DEFAULT NULL,
  `dt_ultimoacesso` datetime DEFAULT NULL,
  `bl_trocasenha` enum('0','1') COLLATE utf8_bin DEFAULT '1',
  `in_erros` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `bl_removido` enum('0','1') COLLATE utf8_bin DEFAULT '0',
  `bl_novotermo` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_brumadinho` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_pps` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`pr_usuario`),
  KEY `IdCandidato` (`es_candidato`),
  KEY `es_instituicao` (`es_instituicao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Extraindo dados da tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`pr_usuario`, `es_candidato`, `en_perfil`, `es_instituicao`, `vc_nome`, `vc_email`, `vc_telefone`, `vc_login`, `vc_senha`, `vc_senha_temporaria`, `dt_cadastro`, `dt_alteracao`, `dt_ultimoacesso`, `bl_trocasenha`, `in_erros`, `bl_removido`, `bl_novotermo`, `bl_brumadinho`, `bl_pps`) VALUES(1, NULL, 'administrador', 1501, 'Administrador padrão', 'naoresponda@planejamento.mg.gov.br', '', '999.999.999-99', '42a9a6f449ab8326ceb16621cbfcadba6a63010fc681144f00bbd2c70bf8a8024ec7c63a5e553ca57d1f6e107ad72c0fd9b4ab422edf0ef481c0e4d7a1a8e1e56VMzFgMMNEnyKw5bMsr9dKXZqxZiWSow+Xlpus38gZs=', NULL, NULL, '2021-08-25', '2021-10-27 18:29:15', '0', 0, '0', '1', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_vagas`
--

DROP TABLE IF EXISTS `tb_vagas`;
CREATE TABLE IF NOT EXISTS `tb_vagas` (
  `pr_vaga` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vc_vaga` varchar(250) CHARACTER SET utf8 NOT NULL,
  `tx_descricao` text CHARACTER SET utf8,
  `dt_inicio` datetime DEFAULT NULL,
  `dt_fim` datetime DEFAULT NULL,
  `vc_linkEntrevista` varchar(300) CHARACTER SET utf8 DEFAULT NULL,
  `in_statusVaga` tinyint(3) UNSIGNED NOT NULL,
  `es_instituicao` int(10) UNSIGNED DEFAULT NULL,
  `es_instituicao2` int(10) UNSIGNED DEFAULT NULL,
  `es_grupoVaga` int(10) UNSIGNED DEFAULT NULL,
  `es_usuarioCadastro` int(10) UNSIGNED NOT NULL,
  `dt_cadastro` datetime NOT NULL,
  `es_usuarioAlteracao` int(10) UNSIGNED DEFAULT NULL,
  `dt_alteracao` datetime DEFAULT NULL,
  `bl_removido` enum('0','1') CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `bl_liberado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_brumadinho` tinyint(1) DEFAULT NULL,
  `bl_finalizado` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `bl_ensinomedio` enum('0','1') COLLATE utf8_bin DEFAULT NULL,
  `es_edital` int(10) UNSIGNED DEFAULT NULL,
  `vc_cargo` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `vc_remuneracao` varchar(250) COLLATE utf8_bin NOT NULL,
  `tx_orientacoes` text COLLATE utf8_bin,
  `tx_documentacao` text COLLATE utf8_bin,
  `tx_requisitos` text COLLATE utf8_bin,
  `in_quant_avaliadores` tinyint(3) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`pr_vaga`),
  KEY `IdOrgao` (`es_instituicao2`),
  KEY `IdGrupoVaga` (`es_grupoVaga`),
  KEY `es_usuarioCadastro` (`es_usuarioCadastro`),
  KEY `es_usuarioAlteracao` (`es_usuarioAlteracao`),
  KEY `es_instituicao` (`es_instituicao`),
  KEY `es_edital` (`es_edital`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `rl_experiencias_candidaturas`
--
ALTER TABLE `rl_experiencias_candidaturas`
  ADD CONSTRAINT `rl_experiencias_candidaturas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `rl_experiencias_candidaturas_ibfk_2` FOREIGN KEY (`es_experiencia`) REFERENCES `tb_experiencias` (`pr_experienca`);

--
-- Limitadores para a tabela `rl_formacoes_candidaturas`
--
ALTER TABLE `rl_formacoes_candidaturas`
  ADD CONSTRAINT `rl_formacoes_candidaturas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `rl_formacoes_candidaturas_ibfk_2` FOREIGN KEY (`es_formacao`) REFERENCES `tb_formacao` (`pr_formacao`);

--
-- Limitadores para a tabela `rl_gruposvagas_questoes`
--
ALTER TABLE `rl_gruposvagas_questoes`
  ADD CONSTRAINT `rl_gruposvagas_questoes_ibfk_1` FOREIGN KEY (`es_grupovaga`) REFERENCES `tb_gruposvagas` (`pr_grupovaga`),
  ADD CONSTRAINT `rl_gruposvagas_questoes_ibfk_2` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`);

--
-- Limitadores para a tabela `rl_instituicoes_usuarios`
--
ALTER TABLE `rl_instituicoes_usuarios`
  ADD CONSTRAINT `rl_instituicoes_usuarios_ibfk_1` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes3` (`pr_instituicao`),
  ADD CONSTRAINT `rl_instituicoes_usuarios_ibfk_2` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `rl_questoes_vagas`
--
ALTER TABLE `rl_questoes_vagas`
  ADD CONSTRAINT `rl_questoes_vagas_ibfk_1` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `rl_questoes_vagas_ibfk_2` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`);

--
-- Limitadores para a tabela `rl_vagas_avaliadores`
--
ALTER TABLE `rl_vagas_avaliadores`
  ADD CONSTRAINT `rl_vagas_avaliadores_ibfk_1` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `rl_vagas_avaliadores_ibfk_2` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_anexos`
--
ALTER TABLE `tb_anexos`
  ADD CONSTRAINT `tb_anexos_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_anexos_ibfk_2` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_anexos_ibfk_3` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_anexos_ibfk_5` FOREIGN KEY (`es_experiencia`) REFERENCES `tb_experiencias` (`pr_experienca`);

--
-- Limitadores para a tabela `tb_candidatos`
--
ALTER TABLE `tb_candidatos`
  ADD CONSTRAINT `tb_candidatos_ibfk_1` FOREIGN KEY (`es_municipio`) REFERENCES `tb_municipios` (`pr_municipio`),
  ADD CONSTRAINT `tb_candidatos_ibfk_2` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidatos_ibfk_3` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_candidaturas`
--
ALTER TABLE `tb_candidaturas`
  ADD CONSTRAINT `tb_candidaturas_ibfk_1` FOREIGN KEY (`es_avaliador_competencia1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_2` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_3` FOREIGN KEY (`es_avaliador_competencia1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_4` FOREIGN KEY (`es_avaliador_competencia2`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_5` FOREIGN KEY (`es_avaliador_competencia3`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_6` FOREIGN KEY (`es_avaliador_curriculo`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_7` FOREIGN KEY (`es_vaga`) REFERENCES `tb_vagas` (`pr_vaga`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_8` FOREIGN KEY (`es_status`) REFERENCES `tb_status_candidaturas` (`pr_status`),
  ADD CONSTRAINT `tb_candidaturas_ibfk_9` FOREIGN KEY (`es_reprovador`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_editais`
--
ALTER TABLE `tb_editais`
  ADD CONSTRAINT `tb_editais4` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes2` (`pr_instituicao`),
  ADD CONSTRAINT `tb_editais_ibfk_1` FOREIGN KEY (`es_usuario_criacao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_editais_ibfk_2` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes2` (`pr_instituicao`),
  ADD CONSTRAINT `tb_editais_ibfk_3` FOREIGN KEY (`es_usuario_criacao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_entrevistas`
--
ALTER TABLE `tb_entrevistas`
  ADD CONSTRAINT `tb_entrevistas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_2` FOREIGN KEY (`es_avaliador1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_3` FOREIGN KEY (`es_avaliador2`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_4` FOREIGN KEY (`es_alterador`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_ibfk_5` FOREIGN KEY (`es_avaliador3`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_entrevistas_justificativa`
--
ALTER TABLE `tb_entrevistas_justificativa`
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_1` FOREIGN KEY (`es_entrevista`) REFERENCES `tb_entrevistas` (`pr_entrevista`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_2` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_3` FOREIGN KEY (`es_avaliador1`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_4` FOREIGN KEY (`es_avaliador2`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_5` FOREIGN KEY (`es_avaliador3`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_6` FOREIGN KEY (`es_avaliador1_anterior`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_7` FOREIGN KEY (`es_avaliador2_anterior`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_entrevistas_justificativa_ibfk_8` FOREIGN KEY (`es_avaliador3_anterior`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_experiencias`
--
ALTER TABLE `tb_experiencias`
  ADD CONSTRAINT `tb_experiencias_ibfk_1` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_experiencias_ibfk_2` FOREIGN KEY (`es_experiencia_pai`) REFERENCES `tb_experiencias` (`pr_experienca`) ON DELETE SET NULL,
  ADD CONSTRAINT `tb_experiencias_ibfk_3` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`);

--
-- Limitadores para a tabela `tb_formacao`
--
ALTER TABLE `tb_formacao`
  ADD CONSTRAINT `tb_formacao_ibfk_1` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_formacao_ibfk_2` FOREIGN KEY (`es_formacao_pai`) REFERENCES `tb_formacao` (`pr_formacao`) ON DELETE SET NULL,
  ADD CONSTRAINT `tb_formacao_ibfk_3` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`);

--
-- Limitadores para a tabela `tb_gruposvagas`
--
ALTER TABLE `tb_gruposvagas`
  ADD CONSTRAINT `tb_gruposvagas_ibfk_1` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_gruposvagas_ibfk_2` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_historicocandidaturas`
--
ALTER TABLE `tb_historicocandidaturas`
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_2` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_3` FOREIGN KEY (`es_avaliador`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_4` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_historicocandidaturas_ibfk_5` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_municipios`
--
ALTER TABLE `tb_municipios`
  ADD CONSTRAINT `tb_municipios_ibfk_1` FOREIGN KEY (`es_uf`) REFERENCES `tb_uf` (`pr_uf`);

--
-- Limitadores para a tabela `tb_notas`
--
ALTER TABLE `tb_notas`
  ADD CONSTRAINT `tb_notas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_notas_ibfk_2` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`),
  ADD CONSTRAINT `tb_notas_ibfk_3` FOREIGN KEY (`es_competencia`) REFERENCES `tb_competencias` (`pr_competencia`),
  ADD CONSTRAINT `tb_notas_ibfk_4` FOREIGN KEY (`es_avaliador`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_opcoes`
--
ALTER TABLE `tb_opcoes`
  ADD CONSTRAINT `tb_opcoes_ibfk_1` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`);

--
-- Limitadores para a tabela `tb_prorrogacao_editais`
--
ALTER TABLE `tb_prorrogacao_editais`
  ADD CONSTRAINT `tb_prorrogacao_editais_ibfk_1` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_prorrogacao_editais_ibfk_2` FOREIGN KEY (`es_edital`) REFERENCES `tb_editais` (`pr_edital`);

--
-- Limitadores para a tabela `tb_questoes`
--
ALTER TABLE `tb_questoes`
  ADD CONSTRAINT `tb_questoes_ibfk_1` FOREIGN KEY (`es_etapa`) REFERENCES `tb_etapas` (`pr_etapa`),
  ADD CONSTRAINT `tb_questoes_ibfk_2` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_questoes_ibfk_3` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_questoes_ibfk_4` FOREIGN KEY (`es_competencia`) REFERENCES `tb_competencias` (`pr_competencia`);

--
-- Limitadores para a tabela `tb_respostas`
--
ALTER TABLE `tb_respostas`
  ADD CONSTRAINT `tb_respostas_ibfk_1` FOREIGN KEY (`es_candidatura`) REFERENCES `tb_candidaturas` (`pr_candidatura`),
  ADD CONSTRAINT `tb_respostas_ibfk_2` FOREIGN KEY (`es_questao`) REFERENCES `tb_questoes` (`pr_questao`),
  ADD CONSTRAINT `tb_respostas_ibfk_3` FOREIGN KEY (`es_avaliador`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_respostas_ibfk_4` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_respostas_ibfk_5` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_respostas_ibfk_6` FOREIGN KEY (`es_opcao`) REFERENCES `tb_opcoes` (`pr_opcao`);

--
-- Limitadores para a tabela `tb_sessoes`
--
ALTER TABLE `tb_sessoes`
  ADD CONSTRAINT `tb_sessoes_ibfk_1` FOREIGN KEY (`es_usuario`) REFERENCES `tb_usuarios` (`pr_usuario`);

--
-- Limitadores para a tabela `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD CONSTRAINT `tb_usuarios_ibfk_1` FOREIGN KEY (`es_candidato`) REFERENCES `tb_candidatos` (`pr_candidato`),
  ADD CONSTRAINT `tb_usuarios_ibfk_2` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes2` (`pr_instituicao`);

--
-- Limitadores para a tabela `tb_vagas`
--
ALTER TABLE `tb_vagas`
  ADD CONSTRAINT `tb_vagas_ibfk_1` FOREIGN KEY (`es_instituicao2`) REFERENCES `tb_instituicoes3` (`pr_instituicao`),
  ADD CONSTRAINT `tb_vagas_ibfk_2` FOREIGN KEY (`es_grupoVaga`) REFERENCES `tb_gruposvagas` (`pr_grupovaga`),
  ADD CONSTRAINT `tb_vagas_ibfk_3` FOREIGN KEY (`es_usuarioCadastro`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_vagas_ibfk_4` FOREIGN KEY (`es_usuarioAlteracao`) REFERENCES `tb_usuarios` (`pr_usuario`),
  ADD CONSTRAINT `tb_vagas_ibfk_5` FOREIGN KEY (`es_instituicao`) REFERENCES `tb_instituicoes2` (`pr_instituicao`);
COMMIT;

