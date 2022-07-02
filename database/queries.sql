-- BUSCAR TESTAMENTOS
SELECT *
  FROM `view_testamentos`
 WHERE `testamentos_abreviado` = :testamentos_abreviado;

-- BUSCAR AUTORES
SELECT *
  FROM `view_autores`
 WHERE `autor_nome` = :autor_nome
    OR `autor_apelido` = :autor_apelido;

-- BUSCAR LIVROS
SELECT *
  FROM `view_livros`
 WHERE `livro_abreviado` = :livro_abreviado
    OR `testamento_abreviado` = :testamento_abreviado;

-- BUSCAR AUTORES X LIVROS
SELECT *
  FROM `view_autores_livros`
 WHERE `autor_nome` = :autor_nome
    OR `livro_abreviado` = :livro_abreviado;

-- BUSCAR VERSÕES
SELECT *
  FROM `view_versoes`
 WHERE `versao_nome` = :versao_nome
    OR `versao_abreviado` = :versao_abreviado;

-- BUSCAR CAPÍTULOS
SELECT *
  FROM `view_capitulos`
 WHERE `livro_abreviado` = :livro_abreviado
   AND `versao_abreviado` = :versao_abreviado
   AND `capitulo_numero` = :capitulo_numero;

-- BUSCAR VERSÍCULOS
SELECT *
  FROM `view_versiculos`
 WHERE `livro_abreviado` = :livro_abreviado
   AND `versao_abreviado` = :versao_abreviado
   AND `versiculo_capitulo` = :versiculo_capitulo;
