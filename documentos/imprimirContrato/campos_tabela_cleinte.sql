
ALTER TABLE public.tab_cliente
  ADD COLUMN operando boolean;
ALTER TABLE public.tab_cliente
  ADD COLUMN parceria boolean;
ALTER TABLE public.tab_cliente
  ADD COLUMN qnt_clientes integer;
ALTER TABLE public.tab_cliente
  ADD COLUMN link_dedicado boolean;
ALTER TABLE public.tab_cliente
  ADD COLUMN zero800 boolean;
ALTER TABLE public.tab_cliente
  ADD COLUMN consultoria_mensal boolean;
ALTER TABLE public.tab_cliente
  ADD COLUMN engenheiro_tecnico boolean;
COMMENT ON COLUMN public.tab_cliente.operando IS 'Já está operando?';
COMMENT ON COLUMN public.tab_cliente.parceria IS 'Tem parceria?';
COMMENT ON COLUMN public.tab_cliente.qnt_clientes IS 'Quantidade de clientes';
COMMENT ON COLUMN public.tab_cliente.link_dedicado IS 'Possui link dedicado?';
COMMENT ON COLUMN public.tab_cliente.zero800 IS 'Possui 0800?';
COMMENT ON COLUMN public.tab_cliente.consultoria_mensal IS 'Paga consultoria SCM mensal?';
COMMENT ON COLUMN public.tab_cliente.engenheiro_tecnico IS 'Possui engenheiro ou técnico responsável?';

ALTER TABLE public.tab_cliente ALTER COLUMN operando SET DEFAULT false;
ALTER TABLE public.tab_cliente ALTER COLUMN parceria SET DEFAULT false;
ALTER TABLE public.tab_cliente ALTER COLUMN link_dedicado SET DEFAULT false;
ALTER TABLE public.tab_cliente ALTER COLUMN consultoria_mensal SET DEFAULT false;
ALTER TABLE public.tab_cliente ALTER COLUMN zero800 SET DEFAULT false;
ALTER TABLE public.tab_cliente ALTER COLUMN engenheiro_tecnico SET DEFAULT false;

update public.tab_cliente set operando=false, parceria=false, link_dedicado=false, consultoria_mensal=false, zero800=false, engenheiro_tecnico=false

INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES (80, 'S', 'Skype');
