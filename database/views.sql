-- VISÃO DE TESTAMENTOS
DROP VIEW IF EXISTS `view_testamentos`;
CREATE VIEW `view_testamentos` AS
    SELECT `testamento_id`, `testamento_nome`, `testamento_abreviado`,
           COUNT(`livro_testamento_id`) `testamento_livros`
      FROM `testamentos`, `livros`
     WHERE `testamento_id` = `livro_testamento_id`
     GROUP BY `testamento_id`;

-- VISÃO DE AUTORES
DROP VIEW IF EXISTS `view_autores`;
CREATE VIEW `view_autores` AS
    SELECT `autor_id`, `autor_nome`, `autor_apelido`, `autor_sobre`,
           COUNT(`autores_livros_autor_id`) `autor_livros`
      FROM `autores`, `autores_livros`
     WHERE `autor_id` = `autores_livros_autor_id`
     GROUP BY `autor_id`;

-- VISÃO DE LIVROS
DROP VIEW IF EXISTS `view_livros`;
CREATE VIEW `view_livros` AS
    SELECT `livro_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`,
           COUNT(`autores_livros_livro_id`) `livro_autores`,
           `testamento_id`, `testamento_nome`, `testamento_abreviado`
      FROM `livros`, `testamentos`, `autores_livros`
     WHERE `livro_id` = `autores_livros_livro_id`
       AND `testamento_id` = `livro_testamento_id`
     GROUP BY `livro_id`;

-- VISÃO DE AUTORES X LIVROS
DROP VIEW IF EXISTS `view_autores_livros`;
CREATE VIEW `view_autores_livros` AS
    SELECT `autores_livros_id`, `autores_livros_exatidao`,
           `autor_id`, `autor_nome`, `autor_apelido`, `autor_sobre`,
           `livro_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`
      FROM `autores_livros`, `livros`, `autores`
     WHERE `autores_livros_autor_id` = `autor_id`
       AND `autores_livros_livro_id` = `livro_id`;

-- VISÃO DE CAPÍTULOS
DROP VIEW IF EXISTS `view_capitulos`;
CREATE VIEW `view_capitulos` AS
    SELECT `livro_id`, `livro_nome`, `livro_abreviado`, `livro_posicao`, `livro_sobre`, `livro_capitulos`,
           `testamento_id`, `testamento_nome`, `testamento_abreviado`,
           `versao_id`, `versao_nome`, `versao_abreviado`,
           `versiculo_capitulo` `capitulo_numero`,
           GROUP_CONCAT(`versiculo_texto` SEPARATOR ' ') `capitulo_texto`
      FROM `testamentos`, `livros`, `versoes`, `versiculos`
     WHERE `testamento_id` = `livro_testamento_id`
       AND `versao_id` = `versiculo_versao_id`
     GROUP BY `versao_id`;

-- VISÃO DE VERSÕES
DROP VIEW IF EXISTS `view_versoes`;
CREATE VIEW `view_versoes` AS
    SELECT `versao_id`, `versao_nome`, `versao_abreviado`,
           IF(REGEXP_SUBSTR(`versao_nome`, '[0-9]{4}+') = '', NULL, REGEXP_SUBSTR(`versao_nome`, '[0-9]+')) `versao_ano`
      FROM `versoes`;

-- VISÃO DE VERSÍCULOS
DROP VIEW IF EXISTS `view_versiculos`;
CREATE VIEW `view_versiculos` AS
    SELECT `versiculo_id`, `versiculo_capitulo`, `versiculo_numero`, `versiculo_texto`,
           `livro_id`, `livro_nome`, `livro_abreviado`,
           `testamento_id`, `testamento_nome`, `testamento_abreviado`,
           `versao_id`, `versao_nome`, `versao_abreviado`
      FROM `versiculos`, `livros`, `testamentos`, `versoes`
     WHERE `versiculo_livro_id` = `livro_id`
       AND `livro_testamento_id` = `testamento_id`
       AND `versiculo_versao_id` = `versao_id`;
