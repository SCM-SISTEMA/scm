SELECT cod_tipo_contrato, tc.cod_usuario_fk, cod_contrato_fk, tipo_produto_fk, a1.dsc_descricao as dsc_tipo_produto,
       tc.ativo,
  cod_contrato, tipo_contrato_fk, a2.dsc_descricao as dsc_tipo_contrato, valor_contrato, dia_vencimento, 
       qnt_parcelas, dt_prazo, c.dt_inclusao, dt_vencimento, contador, 
       responsavel_fk, operando, qnt_clientes, link, zero800, parceiria, 
       consultoria_scm, engenheiro_tecnico, cod_cliente_fk, c.ativo, c.txt_login_inclusao, 
       c.txt_login_alteracao, c.dt_alteracao, status, a3.dsc_descricao as dsc_status, nome_responsavel, 
       contrato,cnpj, ie, fantasia, razao_social, cl.dt_inclusao,cl.dt_exclusao, cod_cliente, 
       situacao, fistel, obs, responsavel, natureza_juridica, dt_fechamento
       ,

  FROM 
   public.tab_cliente as cl 
   LEFT JOIN comercial.tab_contrato as c ON cl.cod_cliente=c.cod_cliente_fk
   JOIN comercial.tab_tipo_contrato AS tc ON c.cod_contrato=tc.cod_contrato_fk
   LEFT JOIN comercial.tab_tipo_contrato_responsavel AS cr ON tc.cod_tipo_contrato=cr.cod_tipo_contrato_fk
   LEFT JOIN acesso.tab_usuarios AS u ON u.cod_usuario=cr.cod_usuario_fk
   JOIN public.tab_atributos_valores a1 ON tc.tipo_produto_fk=a1.cod_atributos_valores
   JOIN public.tab_atributos_valores a2 ON c.tipo_contrato_fk=a2.cod_atributos_valores
   LEFT JOIN public.tab_atributos_valores a3 ON c.status=a3.cod_atributos_valores
where cl.situacao is true 
and tc.ativo is true



CREATE MATERIALIZED VIEW


select cod_atributos_valores from public.tab_atributos_valores where fk_atributos_valores_atributos_id=
(select cod_atributos from public.tab_atributos where sgl_chave='tipo-contato')
and sgl_valor in ('T', 'C')


	       
(select array_to_string(array(select contato from public.tab_contato where 
chave_fk in (3,4) and tipo_tabela_fk='tab_cliente' and ativo is true
and 



), ' / ')) as contato



SELECT *
FROM crosstab(
  $$select chave_fk, tipo, contato from public.tab_contato where 
chave_fk in (3,4) and tipo_tabela_fk='tab_cliente' and ativo is true$$)
AS ct(contato text, category_1 text);