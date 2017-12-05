UPDATE public.tab_atributos_valores
   SET 
       dsc_descricao='Minuta contratual - RT CREA'
 WHERE sgl_valor='minuta-contratual-crea';


UPDATE public.tab_atributos_valores
   SET 
       dsc_descricao='Minuta consutoria gestão de obrigações SCM'
 WHERE sgl_valor='minuta-gestao-scm';



 INSERT INTO comercial.tab_modelo_contrato( cod_contrato_tipo_contrato_fk, txt_modelo)
    VALUES (
   (select cod_atributos_valores from public.tab_atributos_valores where sgl_valor ='minuta-gestao-scm'),  

    (select txt_modelo from comercial.tab_modelo_contrato limit 1)
    ),

(
   (select cod_atributos_valores from public.tab_atributos_valores where sgl_valor ='minuta-contratual-crea'),  

    (select txt_modelo from comercial.tab_modelo_contrato limit 1)
    ),
    (
   (select cod_atributos_valores from public.tab_atributos_valores where sgl_valor ='flex-scm-fidelidade'),  

    (select txt_modelo from comercial.tab_modelo_contrato limit 1)
    );




