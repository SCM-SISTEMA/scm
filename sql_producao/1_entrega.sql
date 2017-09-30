ALTER TABLE comercial.tab_contrato ADD COLUMN status_do_contrato_fk bigint;
COMMENT ON COLUMN comercial.tab_contrato.status_do_contrato_fk IS 'atributos status do contrato';



ALTER TABLE acesso.tab_menus
  ADD COLUMN txt_login_alteracao character varying(150);
COMMENT ON COLUMN acesso.tab_menus.txt_login_alteracao IS 'Ultimo usuário a alterar';

ALTER TABLE acesso.rlc_menus_perfis
ADD COLUMN txt_login_alteracao character varying(150);
COMMENT ON COLUMN acesso.rlc_menus_perfis.txt_login_alteracao IS 'Ultimo usuário a alterar';



ALTER TABLE acesso.tab_funcionalidades
  ADD COLUMN dt_alteracao date DEFAULT now();
COMMENT ON COLUMN acesso.tab_funcionalidades.dt_alteracao IS ''DATA da alteração'';


ALTER TABLE public.tab_atributos_valores
  ADD COLUMN txt_login_inclusao character varying(150), -- Usuário da Inclusão
  ADD COLUMN txt_login_alteracao character varying(150),
  ADD COLUMN txt_login_exclusao character varying(150),
  ADD COLUMN dte_exclusao date DEFAULT now(),
  ADD COLUMN dt_alteracao date DEFAULT now();

COMMENT ON COLUMN public.tab_atributos_valores.txt_login_inclusao IS 'Usuário da Inclusão';
COMMENT ON COLUMN public.tab_atributos_valores.txt_login_alteracao IS 'Ultimo usuário a alterar';
COMMENT ON COLUMN public.tab_atributos_valores.txt_login_exclusao IS 'Usuário da exclusão';
COMMENT ON COLUMN public.tab_atributos_valores.dte_exclusao IS 'Data da exclusão';
COMMENT ON COLUMN public.tab_atributos_valores.dt_alteracao IS 'Data da alteração';