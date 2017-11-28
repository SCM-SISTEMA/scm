<?php

return [
	// ano de referência
	'ano-ref' => 2015,
	// modo do sistema, quando em produção desabilita os debugs do yii
	'php-sistema-modo-producao' => false,
	// error_reporting do PHP
	'php-error-reporting' => E_ALL ^ E_NOTICE,
	// 1|0 - registra ou não os erros ocorridos no log do apache
	'php-log-erros' => 0,
	// habilita/desabilita o caching global manual do sistema
	'habilitar-cache-global' => false,
	// Nome do sistema
	'nome-sistema' => 'SCM',
	// Descrição do sistema
	'descr-sistema' => 'SCM Engenharia',
];
