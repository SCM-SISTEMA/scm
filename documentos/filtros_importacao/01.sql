drop view public.view_contato;
create view public.view_contato as 
select * from (
SELECT chave_fk, tipo_tabela_fk, 
replace(
replace(
replace(array_agg(contato)::varchar,'}', '')
,'{', ''
),'"', ''
) as contato
  FROM public.tab_contato
GROUP BY chave_fk, tipo_tabela_fk) as contatos;



UPDATE public.tab_atributos_valores
   SET dsc_descricao='Cancelado'
 WHERE sgl_valor=4 and dsc_descricao = 'Financeiro';



DROP VIEW comercial.view_cliente_contrato;

CREATE OR REPLACE VIEW comercial.view_cliente_contrato AS 
 SELECT cl.cod_cliente,
    cl.cnpj,
    vc.contato,
    cl.razao_social,
    cl.responsavel,
    a.txt_notificacao,
    to_char(a.dt_retorno::timestamp with time zone, 'DD/MM/YYYY'::text) AS dt_retorno,
        CASE
            WHEN a.dt_retorno < 'now'::text::date THEN 1
            WHEN a.dt_retorno = 'now'::text::date THEN 2
            ELSE 3
        END AS status_andamento_retorno,
    "substring"(a.txt_notificacao, 1, 45) AS txt_notificacao_res,
    to_char(a.dt_inclusao, 'DD/MM/YYYY'::text) AS dt_inclusao_andamento,
    u.txt_login,
    u1.txt_login AS txt_login_andamento,
    a1.dsc_descricao AS dsc_tipo_produto,
    a1.cod_atributos_valores AS atributos_tipo_produto,
    a2.dsc_descricao AS dsc_tipo_contrato,
    a2.cod_atributos_valores AS atributos_tipo_contrato,
    a3.dsc_descricao AS dsc_status,
    a3.cod_atributos_valores AS atributos_status,
    a3.sgl_valor AS sgl_status,
    a4.dsc_descricao AS dsc_setor,
    a4.cod_atributos_valores AS atributos_setor,
    c.cod_contrato,
    c.tipo_contrato_fk,
    c.valor_contrato,
    c.qnt_parcelas,
    to_char(c.dt_prazo::timestamp with time zone, 'DD/MM/YYYY'::text) AS dt_prazo,
    to_char(c.dt_inclusao::timestamp with time zone, 'DD/MM/YYYY'::text) AS dt_inclusao_contrato,
    c.cod_cliente_fk,
    c.ativo AS ativo_contrato,
    s.cod_setor,
    s.cod_usuario_responsavel_fk,
    to_char(c.dt_vencimento::timestamp with time zone, 'DD/MM/YYYY'::text) AS dt_vencimento,
    s.cod_tipo_setor_fk,
    tc.cod_tipo_contrato
   FROM tab_cliente cl
     LEFT JOIN comercial.tab_contrato c ON c.cod_cliente_fk = cl.cod_cliente
     JOIN comercial.tab_tipo_contrato tc ON c.cod_contrato = tc.cod_contrato_fk
     LEFT JOIN tab_setores s ON tc.cod_tipo_contrato = s.cod_tipo_contrato_fk
     LEFT JOIN acesso.tab_usuarios u ON u.cod_usuario = s.cod_usuario_responsavel_fk
     JOIN tab_atributos_valores a1 ON tc.tipo_produto_fk = a1.cod_atributos_valores
     JOIN tab_atributos_valores a2 ON c.tipo_contrato_fk = a2.cod_atributos_valores
     LEFT JOIN tab_atributos_valores a3 ON c.status = a3.cod_atributos_valores
     LEFT JOIN tab_atributos_valores a4 ON s.cod_tipo_setor_fk = a4.cod_atributos_valores
     LEFT JOIN tab_andamento a ON a.cod_andamento = (( SELECT max(tab_andamento.cod_andamento) AS max
           FROM tab_andamento
          WHERE tab_andamento.cod_setor_fk = s.cod_setor))
     LEFT JOIN acesso.tab_usuarios u1 ON u1.cod_usuario = a.cod_usuario_inclusao_fk
     LEFT JOIN public.view_contato vc on vc.chave_fk=cl.cod_cliente and tipo_tabela_fk='tab_cliente'
  WHERE cl.situacao IS TRUE
  ORDER BY c.cod_contrato DESC, a3.sgl_valor, c.dt_inclusao DESC;

ALTER TABLE comercial.view_cliente_contrato
  OWNER TO postgres;
