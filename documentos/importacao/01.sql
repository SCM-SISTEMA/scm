
ALTER TABLE public.tab_cliente ADD COLUMN nome_contador character varying(100);

ALTER TABLE public.tab_cliente ADD COLUMN telefone_contador character varying(30);

ALTER TABLE public.tab_cliente ADD COLUMN nome_engenheiro_tecnico character varying(100);

ALTER TABLE public.tab_cliente ADD COLUMN telefone_engenheiro_tecnico character varying(30);

ALTER TABLE public.tab_cliente ADD COLUMN num0800 character varying(15);
COMMENT ON COLUMN public.tab_cliente.num0800 IS '0800';


ALTER TABLE public.tab_cliente ADD COLUMN velocidade character varying(10);
COMMENT ON COLUMN public.tab_cliente.velocidade IS 'Caso sim, qual a 
Velocidade?';

ALTER TABLE public.tab_cliente ADD COLUMN qnt_torres character varying(3);
COMMENT ON COLUMN public.tab_cliente.qnt_torres IS 'Possui quantas torres cadastradas?';



ALTER TABLE public.tab_cliente ADD COLUMN qnt_repetidora character varying(3);
COMMENT ON COLUMN public.tab_cliente.qnt_repetidora IS 'Possui Repetidoras? Quantas?';



ALTER TABLE public.tab_cliente ADD COLUMN notificacao_anatel boolean;
COMMENT ON COLUMN public.tab_cliente.notificacao_anatel IS 'Já recebeu notificação da ANATEL?';





ALTER TABLE comercial.tab_contrato ADD COLUMN obs text;
COMMENT ON COLUMN comercial.tab_contrato.obs IS 'Observação';

