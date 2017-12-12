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
    tc.cod_tipo_contrato,
    c.contrato_html
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
     LEFT JOIN view_contato vc ON vc.chave_fk = cl.cod_cliente AND vc.tipo_tabela_fk::text = 'tab_cliente'::text
  WHERE cl.situacao IS TRUE
  ORDER BY c.cod_contrato DESC, a3.sgl_valor, c.dt_inclusao DESC;

ALTER TABLE comercial.view_cliente_contrato
  OWNER TO postgres;

------------------------------------------------------------------------
UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA PARA OBTENÇÃO DE
        OUTORGA SCM
    </strong>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>, com sede em C 01
    Lote 01/12 Sala 338, CEP: 72010-010 Edifício Taguatinga Trade Center –
    Taguatinga Centro - Brasília - DF, inscrita no CNPJ sob o
    n.º10.225.044/0001-73, neste ato representado por seus sócios Engenheiro
    Rodrigo Silva Oliveira, brasileiro, natural de Goiânia/GO, solteiro,
    nascido em 13 de Novembro de 1980, Empresário, portador do documento de
    identidade n.º 1.857.494 SSP-DF e do CPF n.º 701.815.431-68, residente em
    AV do Contorno Lote 02 AC. Rabelo Vila Planalto, Brasília / DF, CEP
    70803-210; e Engenheira Ana Paula de Lira Meira, brasileira, natural de
    Brasília/DF, casada, nascida em 16 de Abril de 1980, portador do documento
    de identidade n.º1.882.723 SSP-DF e do CPF n.º 883.079.721-91, residente na
    QNE 21 CASA 15 Taguatinga Norte, Brasília/DF, CEP 72125-210, adiante
designada apenas <strong>CONTRATADA</strong> e    <strong>{razao_social}</strong>, situada no endereço {logradouro}
    nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado}, CEP: {cep}
Inscrito no CNPJ Sob o nº {cnpj} neste ato representado por: {socios}, doravante denominada
    CONTRATANTE, têm, entre si, justas e acertadas o presente Contrato de
    Prestação de Serviços de Consultoria Técnica para Obtenção de Outorga SCM,
    que se regerá pelas cláusulas e condições a seguir entabuladas:
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    É objeto do presente contrato a prestação de consultoria, pela CONTRATADA à
    CONTRATANTE, a fim de auxiliá-la na obtenção de autorização para exploração
    do Serviço de Comunicação Multimídia.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA</strong>
</p>
<p align="justify">
    A princípio, o contrato perdurará enquanto persistir o período de obtenção
    da outorga e quitação do preço ora alinhado entre as partes, se extinguindo
    automaticamente uma vez concluídas as obrigações recíprocas.
</p>
<p align="justify">
    No entanto, o pacto também poderá ser rescindido nas hipóteses delineadas
    na Cláusula Oitava, com as consequências também delimitadas por aquela
    disposição, as quais ora são mutuamente aceitas e comprometidas.
</p>
<p align="justify">
    <strong>CLÁUSULA TERCEIRA - DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    São deveres da CONTRATADA<strong>:</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção de
            autorização do Serviço de Comunicação Multimídia, junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente, em
            especial o disposto na Lei n.° 9.472, no Decreto n.° 2.617/98, no
            Decreto n.° 2.534/98, na Resolução n.° 73 da Anatel, na Resolução
            n.° 65, da Anatel, e na Resolução n.° 272, da Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto Básico conforme disposto no Anexo II da Resolução
            n.° 272 da Anatel, e tendo como base informações técnicas passadas
            pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto de Instalação conforme disposto no Anexo III da
            Resolução n.° 272 da Anatel, e tendo como base informações técnicas
            passadas pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações do Serviço
            Comunicação Multimídia.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar a Estação de Telecomunicações Principal no banco de dados
            da Anatel, ficando consignado<strong> </strong>que se inclui no
escopo deste contrato apenas o            <strong>Cadastramento de um 01 (Um) Pop Principal</strong>, de modo
            que, caso a CONTRATANTE desejar posteriormente cadastrar estações
            adicionais, deverá arcar com custos extras de tais serviços,
            mediante novo acordo com a CONTRATADA.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>CLÁUSULA QUARTA - DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e pelo
            Direito de Exploração do Serviço de Comunicação Multimídia (SCM) e
            a Taxa de Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Entregar tempestivamente todos os documentos e informações exigidos
            para a conclusão do procedimento de outorga, sob pena de não o
            fazendo e tal omissão desencadear em prejuízo dos trabalhos ora
            avençados, arcar com as consequências legais e contratuais de sua
            desídia.
        </p>
    </li>
    <li>
        <p align="justify">
            A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo
            de contrato, modelo de carta, projeto, apresentação, panfleto ou
            qualquer documento criado e utilizado pela CONTRATADA, salvo com
            sua autorização prévia por escrito.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento tempestivamente, conforme disposto na Cláusula
            Quinta deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>CLÁUSULA QUINTA - DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    A consultoria para auxiliar na obtenção de autorização do Serviço de
Comunicação Multimídia, junto à Anatel, possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, através de boletos bancários, conforme programação abaixo:
</p>
<br>
<p align="center">
    {tabela_parcelas}
</p>
<br>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
multa pecuniária de 2%, além de juros de mora de 1% ao mês, calculados    <em>pro rata die</em>, e correção monetária pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo Segundo.</strong>
    Em caso de a inadimplência implicar em necessidade de cobrança judicial dos
    valores ora acordados, a CONTRATANTE deve arcar, ainda, com as custas e
    despesas processuais, além de honorários advocatícios contratuais de 20%
    sobre o valor da causa, sem prejuízo dos honorários sucumbenciais.
</p>
<p align="justify">
    <strong>Parágrafo Terceiro</strong>
    . Na hipótese do atraso no pagamento de algum dos boletos acima persistir
    por mais de 10 (dez) dias após o seu respectivo vencimento, a CONTRATADA
    suspenderá imediatamente a prestação dos serviços, sem prejuízo da
    exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros. Caso, ainda assim, perdure o atraso até se atingir 30 (trinta)
    dias do vencimento do boleto, faculta-se à CONTRATADA, independentemente de
    notificação ou aviso, considerar rescindido o instrumento, implicando no
vencimento antecipado das demais parcelas vincendas, exigíveis    <em>incontinenti</em>, com o devido acréscimo dos encargos moratórios e
    multa da cláusula oitava deste instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA - DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Parágrafo Segundo.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA INDEPENDÊNCIA DOS CONTRATANTES</strong>
</p>
<p align="justify">
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Parágrafo Único.</strong>
    Ademais, não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DA RESCISÃO E DAS PENALIDADES</strong>
</p>
<p align="justify">
    Caso quaisquer das partes der causa à rescisão, por descumprimento ou
    infração de suas obrigações, deverá indenizar a parte inocente por sua
    conduta violadora ou desidiosa, imputando-se à CONTRATADA, caso incorrer
    nestas hipóteses, reverter à CONTRATANTE 20% do valor total deste
    instrumento, o que poderá ocorrer mediante devolução de valores já pagos ou
    desconsideração de parcelas vincendas; ou na hipótese de tal conduta ser
    atribuível à CONTRATANTE, especialmente na infração ao disposto nas alíneas
    da Cláusula Quarta e Parágrafo Terceiro da Cláusula Quinta, também
    continuará obrigada ao valor total do preço ora consignado, com o acréscimo
    dos encargos moratórios e cláusula penal de 20% sobre o valor global deste
    contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA - DO FORO</strong>
</p>
<p align="justify">
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    Brasília, {data}.
</p><br/>
{assinatura}
<br/><br/>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p><br/><br/>
<p align="left">
    <strong>Testemunhas:</strong>
</p><br/><br/>
<p align="left">
    <strong>________________________________</strong>
</p>
<p align="left">
    <strong>Nome</strong>
</p>
<p align="left">
    <strong>CPF</strong>
</p><br/><br/>
<p align="left">
    <strong>________________________________</strong>
</p>
<p align="left">
    <strong>Nome</strong>
</p>
<p align="left">
    <strong>CPF</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='minuta');

------------------------------------------------------------------------------MINUTA


  

UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA</strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    <strong>CONTRATANTE:</strong>
    <strong>{razao_social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj}, neste
    ato representado pelos sócios: {socios}.
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Autorização para prestação do Serviço de Telefonia Fixa Comutada –
            STFC e Serviço de Acesso Condicionado - SeAC.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção de
            autorização do Serviço de Telefonia Fixa Comutada E Serviço de
            Acesso Condicionado , junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto conforme Resolução n.° 283 da Anatel, e tendo como
            base informações técnicas passadas pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar as Estações de Telecomunicações no banco de dados da
            Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e a Taxa de
            Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar na obtenção de autorização do Serviço de
    Telefonia Fixa Comutada e Serviço de Acesso Condicionado, junto à Anatel,
    possui custo total de R$ <strong>{valor_total_contrato}</strong> a ser pago
    pela CONTRATANTE à CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª.</strong>
    A Consultoria para auxiliar no Licenciamento das Estações de
Telecomunicações possui custo total de R$ 700,00 (Setecentos reais),    <strong>por estação,</strong> a ser pago pela CONTRATANTE à CONTRATADA até
    5 dias após terem sido entregues, na Anatel, os documentos necessários para
    o licenciamento da estação.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O número de estações a serem licenciadas será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA</strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA suspenderá a prestação dos serviços, sem prejuízo
    da exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros, de acordo com os trabalhos desenvolvidos até o momento da
    notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>PARÁGRAFO PRIMEIRO</strong>
    : Para efeitos de rescisão, o processo de prestação de serviços para
    emissão de licença junto a ANATEL está dividida em 3 (três) partes,sendo:
</p>
<p align="justify">
    1ª A primeira parte implica na realização da adequação do contrato social
    da empresa as normas estabelecidas pela ANATEL no tocante ao seu objeto e
    atividade fim, bem como ao registro de responsável técnico junto ao CREA.
    Tal serviço corresponde a 30% (trinta por cento) do valor do contrato;
</p>
<p align="justify">
    2ª A segunda parte implica na elaboração do projeto por Engenheiro, bem
    como o posterior envio da documentação regular a ANATEL com o
    acompanhamento dos trâmites até a respectiva aprovação e o consequente
    envio do Boleto e os Termos da licença. Tais serviços correspondem a 70%
    (setenta por cento) do contrato.
</p>
<p align="justify">
    3ª A terceira e última parte implica no recebimento do cadastro da
    contratante e posterior elaboração e aprovação do projeto de instalação,
    bem como o cadastramento da estação, que representará 100% (cem por cento)
    do valor deste contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p><br /><br />
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='stfc');



------------------------------------------------------------------------------STFC
 

UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA</strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    <strong>CONTRATANTE:</strong>
    <strong>{razao_social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj}, neste
    ato representado pelos sócios: {socios}.
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Autorização para prestação do Serviço de Telefonia Fixa Comutada –
            STFC e Serviço de Acesso Condicionado - SeAC.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção de
            autorização do Serviço de Telefonia Fixa Comutada E Serviço de
            Acesso Condicionado , junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto conforme Resolução n.° 283 da Anatel, e tendo como
            base informações técnicas passadas pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar as Estações de Telecomunicações no banco de dados da
            Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e a Taxa de
            Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar na obtenção de autorização do Serviço de
    Telefonia Fixa Comutada e Serviço de Acesso Condicionado, junto à Anatel,
    possui custo total de R$ <strong>{valor_total_contrato}</strong> a ser pago
    pela CONTRATANTE à CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª.</strong>
    A Consultoria para auxiliar no Licenciamento das Estações de
Telecomunicações possui custo total de R$ 700,00 (Setecentos reais),    <strong>por estação,</strong> a ser pago pela CONTRATANTE à CONTRATADA até
    5 dias após terem sido entregues, na Anatel, os documentos necessários para
    o licenciamento da estação.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O número de estações a serem licenciadas será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA</strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA suspenderá a prestação dos serviços, sem prejuízo
    da exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros, de acordo com os trabalhos desenvolvidos até o momento da
    notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>PARÁGRAFO PRIMEIRO</strong>
    : Para efeitos de rescisão, o processo de prestação de serviços para
    emissão de licença junto a ANATEL está dividida em 3 (três) partes,sendo:
</p>
<p align="justify">
    1ª A primeira parte implica na realização da adequação do contrato social
    da empresa as normas estabelecidas pela ANATEL no tocante ao seu objeto e
    atividade fim, bem como ao registro de responsável técnico junto ao CREA.
    Tal serviço corresponde a 30% (trinta por cento) do valor do contrato;
</p>
<p align="justify">
    2ª A segunda parte implica na elaboração do projeto por Engenheiro, bem
    como o posterior envio da documentação regular a ANATEL com o
    acompanhamento dos trâmites até a respectiva aprovação e o consequente
    envio do Boleto e os Termos da licença. Tais serviços correspondem a 70%
    (setenta por cento) do contrato.
</p>
<p align="justify">
    3ª A terceira e última parte implica no recebimento do cadastro da
    contratante e posterior elaboração e aprovação do projeto de instalação,
    bem como o cadastramento da estação, que representará 100% (cem por cento)
    do valor deste contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p><br /><br />
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='spda');

------------------------------------------------------------------------------SPDA









UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA </strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    <strong>CONTRATANTE: </strong>
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado pelos sócios: {sócios}.
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Cadastramento de Estação ao SCM.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para o
            Cadastramento de Estação Associado ao SCM, junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o cadastramento.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar as Estações no banco de dados da Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Uso de Radiofrequência (PPDUR) e a Taxa de Fiscalização
            de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar no Cadastramento de Estação Associado ao SCM,
junto à Anatel, possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª.</strong>
    O número de estações a serem cadastrados será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA </strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA
    <u>
        suspenderá a prestação dos serviços com a retirada da responsabilidade
        pelo cadastramento de estações, objeto deste contrato junto a Anatel
    </u>
    , sem prejuízo da exigibilidade dos encargos contratuais, ficando o seu
    restabelecimento condicionado ao pagamento do(s) valor(es) em atraso,
    acrescido (s) da multa e dos juros, de acordo com os trabalhos
    desenvolvidos até o momento da notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora.
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='calculo-estrutural');

------------------------------------------------------------------------------calculo estrutural







UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇO PARA SOLICITAÇÃO DE AUTORIZAÇÃO PARA
        USO COMPARTILHADO DE POSTES
    </strong>
</p>
<p align="justify">
    A<strong> </strong><strong>{razao social}</strong><strong> </strong>
    estabelecida na
    <strong>
        {logradouro} nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado},
        CEP: {cep}
    </strong>
    , inscrita no CNPJ sob nº {cnpj}, representada na forma pelo seu Contrato
Social, designada apenas <strong>CONTRATANTE</strong>, e a firma    <u><strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong></u>,com
    endereço comercial na
    <u>
        <strong>
            C 01 Lote 01/12 Sala 338, CEP: 72010-010 Edifício Taguatinga Trade
            Center – Taguatinga Centro – Brasília - DF
        </strong>
    </u>
    , inscrita sob CNPJ nº <u><strong>10.225.044/0001-73</strong></u>,
legalmente representada e doravante designada apenas    <strong>CONTRATADA</strong>, têm entre si ajustado o presente CONTRATO,
    mediante as condições que constam das seguintes cláusulas:
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA-OBJETO DO CONTRATO </strong>
</p>
<p align="justify">
    Constitui objeto deste Contrato a execução, pela CONTRATADA, dos SERVIÇOS
    de:
</p>
<p align="justify">
    Projeto técnico para compartilhamento de 200 unidades de poste;
</p>
<p align="justify">
    <strong>1</strong>
    : A contratante deve fornecer todas as informações solicitadas pela
    contratada, no prazo de 72 (setenta e duas horas), após solicitado, sob
    pena de atraso na entrega do projeto.
</p>
<p align="justify">
    <strong>2</strong>
    : As informações fornecidas pela contratante são de sua inteira
    responsabilidade, e caso haja alguma informação incorreta, o projeto estará
    automaticamente desqualificado e a responsabilidade será do contratante.
</p>
<p align="justify">
    <strong>
        CLÁUSULA SEGUNDA-DESCRIÇÃO DOS SERVIÇOS A SEREM REALIZADOS:
    </strong>
</p>
<p align="justify">
    A CONTRATANTE deverá fornecer à CONTRATADA todas as informações necessárias
    para a realização do serviço, tais como: Identificação dos postes, mapa com
    a localização de cada poste, cargas que são aplicadas e as cargas limites,
    descrição dos cabos e equipamentos a serem utilizados, dentre outros, para
    que não haja dúvidas de como obter tais dados. Ou se preferir, a CONTRATADA
    disponibilizará um técnico para o recolhimento das informações necessárias
    para realização dos serviços, ficando a CONTRATANTE responsável pelos
    custos de locomoção, alimentação e hospedagem do mesmo.
</p>
<p align="justify">
    A CONTRATADA deverá realizar o projeto de Compartilhamento de Postes de
    acordo com as exigências e normas em vigor e entregar num prazo máximo de
    30 dias após o fornecimento de todas as informações necessárias.
</p>
<p align="justify">
    O acompanhamento da análise do projeto pela concessionária de energia local
    será feita pela CONTRATADA, porém o tempo desta análise é de inteira
    responsabilidade da própria concessionária de energia local, não tendo a
    CONTRATADA responsabilidade sobre atraso na análise do projeto.
</p>
<p align="justify">
    <strong>CLÁUSULA TERCEIRA-VALOR DO SERVIÇO </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    A consultoria para auxiliar na obtenção de autorização do Compartilhamento
de Postes, junto à Concessionária Local, possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<ul>
    <li>
        <p align="justify">
            O não pagamento do SERVIÇO até a data do vencimento ensejará a
            aplicação das seguintes penalidades a CONTRATANTE:
        </p>
    </li>
</ul>
<p align="justify">
    a) Multa moratória de 2% (dois por cento) sobre o valor do débito,
    acrescida de juros de 1% (um por cento) ao mês, bem como correção monetária
    até a data do efetivo pagamento;
</p>
<p align="justify">
    b) O pagamento não efetuado, em até 30 (trinta) dias após seu vencimento se
    reveste de caráter de dívida líquida, certa, e exigível para os fins de
    cobrança judicial, podendo a CONTRATADA transformá-la em duplicata de
    serviços, protestá-la e executar a mesma perante o órgão jurisdicional
    competente.
</p>
<p align="justify">
    c) Se o atraso persistir após os 60 (sessenta) dias subsequentes ao do
    vencimento será incluso o nome da CONTRATANTE no serviço de proteção ao
    crédito.
</p>
<p align="justify">
    <strong>CLÁUSULA QUARTA: CONDIÇÕES GERAIS </strong>
</p>
<p align="justify">
    1. A CONTRATADA cumprirá rigorosamente seus deveres de observância de
    sigilo e da ética profissional, fazendo as recomendações oportunas e
    desenvolvendo todos os demais atos e funções, necessárias ou convenientes
    ao bom cumprimento das atribuições contratadas.
</p>
<p align="justify">
    2. A CONTRATADA se compromete ainda, a manter o caráter sigiloso das
    informações às quais poderá ter acesso em função deste contrato, tomando
    todas as medidas cabíveis para que tais informações somente sejam
    divulgadas àquelas pessoas que delas dependam para a execução dos serviços
    objeto deste contrato.
</p>
<p align="justify">
    3. Caberá à CONTRATANTE efetuar o pagamento, consoante o disposto na
    cláusula terceira deste instrumento e a realizar a entrega das informações
    e documentos necessários para a execução do serviço.
</p>
<p align="justify">
    4. Para fiscalização da Concessionária, bem como para manter a segurança de
    todo o sistema, as empresas prestadoras de serviços de telecomunicações no
    regime privado devem manter o sistema nos padrões de projeto indicados,
    assim, a contratada irá informar o tempos de revisão/manutenção, evitando
    punições e acidentes.
</p>
<p align="justify">
    5. Quanto ao custo com deslocamento, caso o engenheiro responsável pelo
    desenvolvimento do projeto julgue necessário o deslocamento até o local,
    estes custos (Deslocamento, alimentação, etc) ficaram a cargo da
    contratante.
</p>
<p align="justify">
    6. As partes reconhecem o correio eletrônico como meio válido, eficaz e
    suficiente de comunicação.
</p>
<p align="justify">
    <strong>CLÁUSULA QUINTA-RESCISÃO </strong>
</p>
<p align="justify">
    1. Após 30 (trinta) dias do vencimento de uma das parcelas, os serviços
    serão suspensos, respondendo o contratante junto aos órgãos os quais a
    contratada atua pela desídia ou falta de continuidade nos serviços até
    então prestados.
</p>
<p align="justify">
    2. Caso sejam descumpridas algumas das cláusulas integrantes deste
    contrato, será fixada multa no importe de 20% (vinte por cento) do valor do
    presente contrato ao causador.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA: ADITIVOS E ALTERAÇÕES CONTRATURAIS</strong>
</p>
<p align="justify">
    <a name="_GoBack"></a>
    1. A contratada poderá alterar, modificar ou aditar o presente instrumento,
    inclusive no que diz respeito às condições dos serviços, através de
    comunicados ou termos aditivos, sempre com o objetivo de aprimorá-lo com
    vistas às melhorias das condições de funcionamento do presente Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA: FÔRO </strong>
</p>
<p align="justify">
    As partes elegem o foro da cidade de Brasília/DF para dirimir quaisquer
    litígios oriundos do presente instrumento, com expressa renúncia a qualquer
    outro, por mais privilegiado que se apresente. Assim, havendo ajustado,
    fizeram imprimir este instrumento em duas vias, que são assinadas pelos
    seus representantes legais e pelas testemunhas presentes para os efeitos
    jurídicos.
</p>
<p align="justify">
    <strong>Brasília - DF</strong>
    <strong>, {data}.</strong>
</p>
<p align="center">
    {assinatura}
</p>
<p align="center">
    ____________________________________________________
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='postes');

------------------------------------------------------------------------------postes








UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA</strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    <strong>CONTRATANTE: </strong>
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado pelos sócios: {socios}
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Autorização para prestação do Serviço de Acesso Condicionado –
            SeAC.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção de
            autorização do Serviço de Acesso Condicionado, junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto conforme Resolução n.° 581 da Anatel, e tendo como
            base informações técnicas passadas pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar as Estações de Telecomunicações no banco de dados da
            Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e a Taxa de
            Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar na obtenção de autorização do Serviço de Acesso
Condicionado, junto à Anatel, possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª.</strong>
    A Consultoria para auxiliar no Licenciamento das Estações de
Telecomunicações possui custo total de R$ 700,00 (Setecentos reais),    <strong>por estação,</strong> a ser pago pela CONTRATANTE à CONTRATADA até
    5 dias após terem sido entregues, na Anatel, os documentos necessários para
    o licenciamento da estação.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O número de estações a serem licenciadas será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA</strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA suspenderá a prestação dos serviços, sem prejuízo
    da exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros, de acordo com os trabalhos desenvolvidos até o momento da
    notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>PARÁGRAFO PRIMEIRO</strong>
    : Para efeitos de rescisão, o processo de prestação de serviços para
    emissão de licença junto a ANATEL está dividida em 3 (três) partes,sendo:
</p>
<p align="justify">
    1ª A primeira parte implica na realização da adequação do contrato social
    da empresa as normas estabelecidas pela ANATEL no tocante ao seu objeto e
    atividade fim, bem como ao registro de responsável técnico junto ao CREA.
    Tal serviço corresponde a 30% (trinta por cento) do valor do contrato;
</p>
<p align="justify">
    2ª A segunda parte implica na elaboração do projeto por Engenheiro, bem
    como o posterior envio da documentação regular a ANATEL com o
    acompanhamento dos trâmites até a respectiva aprovação e o consequente
    envio do Boleto e os Termos da licença. Tais serviços correspondem a 70%
    (setenta por cento) do contrato.
</p>
<p align="justify">
    3ª A terceira e última parte implica no recebimento do cadastro da
    contratante e posterior elaboração e aprovação do projeto de instalação,
    bem como o cadastramento da estação, que representará 100% (cem por cento)
    do valor deste contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='seac');

------------------------------------------------------------------------------seac











UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA-SLP</strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    <strong>CONTRATANTE:</strong>
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj}, neste
    ato representado pelos sócios: {socios}.
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Autorização para prestação do Serviço Limitado Privado – SLP.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção de
            autorização do Serviço Limitado Privado, junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto conforme Resolução n.° 617 da Anatel, e tendo como
            base informações técnicas passadas pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar as Estações de Telecomunicações no banco de dados da
            Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e a Taxa de
            Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar na obtenção de autorização do Serviço Limitado
Privado, junto à Anatel, possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª.</strong>
    A Consultoria para auxiliar no Licenciamento das Estações de
Telecomunicações possui custo total de R$ 700,00 (Setecentos reais),    <strong>por estação,</strong> a ser pago pela CONTRATANTE à CONTRATADA até
    5 dias após terem sido entregues, na Anatel, os documentos necessários para
    o licenciamento da estação.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O número de estações a serem licenciadas será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA</strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA suspenderá a prestação dos serviços, sem prejuízo
    da exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros, de acordo com os trabalhos desenvolvidos até o momento da
    notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>PARÁGRAFO PRIMEIRO</strong>
    : Para efeitos de rescisão, o processo de prestação de serviços para
    emissão de licença junto a ANATEL está dividida em 3 (três) partes,sendo:
</p>
<p align="justify">
    1ª A primeira parte implica na realização da adequação do contrato social
    da empresa as normas estabelecidas pela ANATEL no tocante ao seu objeto e
    atividade fim, bem como ao registro de responsável técnico junto ao CREA.
    Tal serviço corresponde a 30% (trinta por cento) do valor do contrato;
</p>
<p align="justify">
    2ª A segunda parte implica na elaboração do projeto por Engenheiro, bem
    como o posterior envio da documentação regular a ANATEL com o
    acompanhamento dos trâmites até a respectiva aprovação e o consequente
    envio do Boleto e os Termos da licença. Tais serviços correspondem a 70%
    (setenta por cento) do contrato.
</p>
<p align="justify">
    3ª A terceira e última parte implica no recebimento do cadastro da
    contratante e posterior elaboração e aprovação do projeto de instalação,
    bem como o cadastramento da estação, que representará 100% (cem por cento)
    do valor deste contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='slp');

------------------------------------------------------------------------------slp













UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA-SEAC e STFC
    </strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    <strong>CONTRATANTE: </strong>
    <strong>{razao social}</strong>
    <strong> </strong>
    , {logradouro} nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado},
    CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato representado por:
    {socios}, neste ato representado pelos sócios: {socios}
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Autorização para prestação do Serviço de Acesso Condicionado
            (Seac), Serviço de Telefonia Fixa Comutada (STFC) e Serviço de
            Comunicação Multimídia (SCM)
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção de
            autorização do Serviço de Acesso Condicionado (Seac), Serviço de
            Telefonia Fixa Comutada (STFC), e Serviço de Comunicação Multimídia
            (SCM) junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente.
        </p>
    </li>
    <li>
        <p align="justify">
            Elaborar Projeto conforme Resolução n.° 581 da Anatel, e tendo como
            base informações técnicas passadas pela CONTRATANTE.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar as Estações de Telecomunicações no banco de dados da
            Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e a Taxa de
            Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar na obtenção de autorização do Serviço Serviço
    de Acesso Condicionado (Seac), Serviço de Telefonia Fixa Comutada (STFC) e
    Serviço de Comunicação Multimídia (SCM), junto à Anatel, possui custo total
    de R$ <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª. </strong>
    Quanto a Consultoria para auxiliar no Licenciamento das Estações de
Telecomunicações, esta incluso neste contrato o    <strong>Cadastramento de um 01 (Um) Pop Principal</strong>, caso venha
    posteriormente cadastrar mais estações devera ser verificado junto a
    CONTRATADA o valor do serviço a ser prestado.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O número de estações a serem licenciadas será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA</strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA suspenderá a prestação dos serviços, sem prejuízo
    da exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros, de acordo com os trabalhos desenvolvidos até o momento da
    notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>PARÁGRAFO PRIMEIRO</strong>
    : Para efeitos de rescisão, o processo de prestação de serviços para
    emissão de licença junto a ANATEL está dividida em 3 (três) partes,sendo:
</p>
<p align="justify">
    1ª A primeira parte implica na realização da adequação do contrato social
    da empresa as normas estabelecidas pela ANATEL no tocante ao seu objeto e
    atividade fim, bem como ao registro de responsável técnico junto ao CREA.
    Tal serviço corresponde a 30% (trinta por cento) do valor do contrato;
</p>
<p align="justify">
    2ª A segunda parte implica na elaboração do projeto por Engenheiro, bem
    como o posterior envio da documentação regular a ANATEL com o
    acompanhamento dos trâmites até a respectiva aprovação e o consequente
    envio do Boleto e os Termos da licença. Tais serviços correspondem a 70%
    (setenta por cento) do contrato.
</p>
<p align="justify">
    3ª A terceira e última parte implica no recebimento do cadastro da
    contratante e posterior elaboração e aprovação do projeto de instalação,
    bem como o cadastramento da estação, que representará 100% (cem por cento)
    do valor deste contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='seac-stfc');

------------------------------------------------------------------------------seac-stfc





UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA </strong>
</p>
<p align="center">
    <strong>IDENTIFICAÇÃO DAS PARTES CONTRATANTES</strong>
</p>
<p align="justify">
    CONTRATANTE: <strong>{razao social}</strong>, situada no endereço
    {logradouro} nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado},
    CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato representado por:
    {socios}, neste ato representado pelos sócios: {socios}
</p>
<p align="justify">
    <strong>CONTRATADA:</strong>
    SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA, com sede em C 01 Lote 01/12 Sala
    338, CEP: 72010-010 Edifício Taguatinga Trade Center – Taguatinga Centro -
    Brasília - DF, inscrita no CNPJ sob o n.º10.225.044/0001-73, neste ato
    representado por seus sócios Engenheiro Rodrigo Silva Oliveira, brasileiro,
    natural de Goiânia/GO, solteiro, nascido em 13 de Novembro de 1980,
    Empresário, portador do documento de identidade n.º 1.857.494 SSP-DF e do
    CPF n.º 701.815.431-68, residente em AV do Contorno Lote 02 AC. Rabelo Vila
    Planalto, Brasília / DF, CEP 70803-210; e Engenheira Ana Paula de Lira
    Meira, brasileira, natural de Brasília/DF, casada, nascida em 16 de Abril
    de 1980, portador do documento de identidade n.º1.882.723 SSP-DF e do CPF
    n.º 883.079.721-91, residente na QNE 21 CASA 15 Taguatinga Norte,
    Brasília/DF, CEP 72125-210.
</p>
<p align="justify">
    As partes acima identificadas têm, entre si, justas e acertadas o presente
    Contrato de Prestação de Serviços de Consultoria Técnica, que se regerá
    pelas cláusulas seguintes e pelas condições descritas no presente.
</p>
<p align="justify">
    <strong>DO OBJETO DO CONTRATO</strong>
</p>
<p align="justify">
    <strong>Cláusula 1ª.</strong>
    É objeto do presente contrato a prestação de consultoria por parte da
    CONTRATADA à CONTRATANTE, sobre as seguintes matérias:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Cadastramento de Radioenlaces Associados ao SCM.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    <strong>Cláusula 2ª.</strong>
    São deveres da <strong>CONTRATADA</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para o
            Cadastramento de Radioenlaces Associados ao SCM, junto à Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o cadastramento.
        </p>
    </li>
    <li>
        <p align="justify">
            Cadastrar os Radioenlaces no banco de dados da Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            licenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    <strong>Cláusula 3ª.</strong>
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção da autorização.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Uso de Radiofrequência (PPDUR) e a Taxa de Fiscalização
            de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento conforme disposto nas cláusulas 4ª, 5ª e 6ª
            deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    <strong>Cláusula 4ª.</strong>
    A consultoria para auxiliar no cadastramento de Radioenlaces Associados ao
SCM, junto à Anatel, possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, em boleto bancário conforme abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Cláusula 5ª.</strong>
    O número de enlaces a serem cadastrados será definido posteriormente pela
    CONTRATANTE.
</p>
<p align="justify">
    <strong>Cláusula 6ª.</strong>
    Os pagamentos referidos nas cláusulas 4ª e 5ª poderão ser feitos por meio
    de boleto bancário.
</p>
<p align="justify">
    <strong>DA MULTA </strong>
</p>
<p align="justify">
    <strong>Cláusula 7ª.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
    multa pecuniária de 2%, juros de mora de 1% ao mês, acrescido de correção
    monetária calculada “pro rata temporis” pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    Em caso de cobrança judicial, devem ser acrescidas custas processuais e 20%
    de honorários advocatícios.
</p>
<p align="justify">
    <strong>Cláusula 8ª.</strong>
    O Pagamento não sendo efetuado em até 10(dez) dias após o seu respectivo
    vencimento, a CONTRATADA
    <u>
        suspenderá a prestação dos serviços com a retirada da responsabilidade
        pelo cadastramento dos enlances objeto deste contrato junto a Anatel
    </u>
    , sem prejuízo da exigibilidade dos encargos contratuais, ficando o seu
    restabelecimento condicionado ao pagamento do(s) valor(es) em atraso,
    acrescido (s) da multa e dos juros, de acordo com os trabalhos
    desenvolvidos até o momento da notificação formal de rescisão.
</p>
<p align="justify">
    <strong>DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    <strong>Cláusula 9ª. </strong>
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora.
</p>
<p align="justify">
    <strong>Cláusula 10ª.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Cláusula 11ª.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    <strong>Cláusula 12ª.</strong>
    A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo de
    contrato, modelo de carta, projeto, apresentação, panfleto ou qualquer
    documento criado e utilizado pela CONTRATADA, salvo com sua autorização
    prévia por escrito.
</p>
<p align="justify">
    <strong>Cláusula 13ª.</strong>
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Cláusula 14ª.</strong>
    Não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>Cláusula 15ª. </strong>
    Em caso de Rescisão Contratual por parte da Contratante, será devido pela
    mesma o valor referente ao trabalho desenvolvido até o momento da
    notificação por escrito com a intenção de rescisão do contrato.
</p>
<p align="justify">
    <strong>Cláusula 16ª</strong>
    . Não serão gerados, em hipótese alguma, novos boletos de pagamento,
    devendo os vencimentos atrasados serem pagos, inseridos de juros de acordo
    como explicita a cláusula 7ª do presente instrumento.
</p>
<p align="justify">
    <strong>DO FORO</strong>
</p>
<p align="justify">
    <strong>Cláusula 17ª. </strong>
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    <strong>Brasília - DF, {data}.</strong>
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='enlace');

------------------------------------------------------------------------------enlace


UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <img src="" align="left" hspace="12" vspace="1"/>
    <strong>CONSULTORIA MENSAL PÓS OUTORGA</strong>
</p>
<p align="center">
    <u><strong>Combo Light</strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, neste ato representado pelos sócios: {socios},
    doravante denominada CONTRATANTE, declaram que, nesta data, ajustam entre
    si, de comum acordo e na melhor forma de direito, o presente
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA MENSAL PÓS OUTORGA
    </strong>
    , que será regido pela legislação vigente e pelas cláusulas e condições
    seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA </strong>
</p>
<p align="justify">
O contrato perdurará pelo prazo inicial de <strong>{meses</strong>    <strong>}</strong> <strong>mes(es)</strong>, renovando-se automaticamente
    por igual período subsequente, exceto se houver prévia comunicação, por
    escrito, no prazo de 30 (trinta) dias, do desejo de pôr termo ao contrato
    ao término de sua vigência.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p>
    <strong>CLÁUSULA TERCEIRA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <strong>COMBO LIGHT</strong>, que conterá todos os serviços abaixo
    delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condencine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores.
</p>
<p align="justify">
    <strong>CLÁUSULA QUARTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel) e demais órgãos junto aos
    quais a CONTRATADA eventualmente diligenciar.
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA QUINTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ {valor_total_contrato}</strong>, eis que a CONTRATANTE
    aderiu ao <u><strong>{tipo_contrato}</strong></u>, pelo período estipulado
    na cláusula segunda desta avença, o qual, por mera liberalidade da
CONTRATADA, será adimplido mediante {meses}<strong> prestações de </strong><strong>{prestacao}</strong> cada uma, vencendo a primeira parcela no dia    <u><strong>{dia_primeira_parcela}</strong></u> e as demais no mesmo dia dos
    meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATANTE se compromete expressamente, através do presente, a
    tomar todas as precauções necessárias para salvaguardar o sigilo das
    mesmas, bem como evitar e prevenir revelação a terceiros, não podendo
    utilizá-las para outros projetos que por ventura esteja desenvolvendo,
    exceto se devidamente autorizado por escrito pela CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATANTE serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATANTE obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATADA danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATADA, legítima detentora do direito a tais informações, poderá tomar
    todas as medidas judiciais e extrajudiciais, inclusive de caráter cautelar
    ou de antecipação de tutela jurisdicional, que julgar cabíveis à defesa de
    seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA RESCISÃO</strong>
</p>
<p align="justify">
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor
    restante do contrato à parte que originou o descumprimento.
</p>
<p align="justify">
    <a name="_GoBack"></a>
    VII.II – Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 15 (quinze) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.III - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA– DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    Brasília, {data}.
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>_______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-light');

------------------------------------------------------------------------------pos-outorga-light





UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <strong>CONSULTORIA MENSAL PÓS OUTORGA</strong>
</p>
<p align="center">
    <u><strong>Combo Flex</strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, neste ato representado pelos sócios: {socios},
    doravante denominada CONTRATANTE, declaram que, nesta data, ajustam entre
    si, de comum acordo e na melhor forma de direito, o presente
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA MENSAL PÓS OUTORGA
    </strong>
    , que será regido pela legislação vigente e pelas cláusulas e condições
    seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA </strong>
</p>
<p align="justify">
O contrato perdurará pelo prazo inicial de <strong> </strong>    <strong>{meses}</strong><strong> mês(es)</strong>, renovando-se
    automaticamente por igual período subsequente, exceto se houver prévia
    comunicação, por escrito, no prazo de 30 (trinta) dias, do desejo de pôr
    termo ao contrato ao término de sua vigência.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p>
    <strong>CLÁUSULA TERCEIRA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <u><strong>COMBO FLEX</strong></u><u> </u>e conterá todos os serviços
    abaixo delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condecine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores, além de indicar revistas especializadas, com o escopo de
    propiciar o crescimento e solidificação do Provedor.
</p>
<p align="justify">
    <strong>III.VI – Inovação</strong>
    : serviço voltado a divulgar e a orientar a CONTRATANTE em novos processos
    e projetos na área de telecomunicações, objetivando o crescimento e
    desenvolvimento de sua empresa com soluções inovadoras, criativas e com
    alto valor agregado no mercado, englobando, também, a divulgação de Editais
    e Licitações vigentes para participação na área de Telecomunicações.
</p>
<p align="justify">
    <strong>III.VII – Organização de Documentos</strong>
    : Orientações sobre a necessidade de obtenção, guarda e exibição de
    documentos obrigatórios em caso de fiscalização da Anatel.
</p>
<p align="justify">
    <strong>III.VIII – Sistemas Interativos da Anatel</strong>
    : recomendações e direções sobre a utilização e registros no sistema FOCUS
    da Anatel.
</p>
<p align="justify">
    <strong>III.IX – Consultoria Jurídica Básica</strong>
    : elaboração de contratos SCM, Link Dedicado, Permanência e Termo de
    Adesão, atualização dos instrumentos de acordo com modificações
    legislativas ou normativas, orientações da rescisão dos contratos dos
    provedores com seus usuários finais, indicação das medidas jurídicas a
    serem tomadas em caso de procedimentos administrativos na Anatel e
    divulgação de informativos acerca de inovações regulatórias.
</p>
<p align="justify">
    <strong>III.X – Orientações Contábeis Básicas:</strong>
    Auxilio sobre requerimento e confecção da Nota Fiscal modelo 21, Indicação
    dos CNAE´s específico para licença e atividade de SCM e Indicação quanto à
    filiação sindical e o recolhimento das contribuições sindicais.
</p>
<p align="justify">
    <strong>III.XI -</strong>
    <strong>Auxilio Boletos com usuário final – </strong>
    A CONTRATADA auxiliará a CONTRATANTE na confecção dos boletos bancários a
    serem emitidos para adimplir a relação jurídica entre a prestadora de
    serviços de telecomunicações e seu usuário final, sempre em estrita
    obediência às exigências da Anatel.
</p>
<p align="justify">
    <strong>
        III.XII – Informativo de Situação Financeira perante a Anatel:
    </strong>
    A CONTRATADA divulgará o CONTRATANTE acerca de eventuais débitos em aberto
    na Anatel e o orientará quanto às condições de regularização.
</p>
<p align="justify">
    <strong>III.XIII – Cobrança do CONDENCINE:</strong>
    Auxílio na emissão do documento de cobrança do CONDENCINE.
</p>
<p align="justify">
    <strong>
        III.XIV – Informativo de Alterações Administrativas e/ou Técnicas:
    </strong>
    A CONTRATADA atualizará o CONTRATANTE acerca de novas exigências ou
    parâmetros da Anatel sobre questões técnicas e administrativas, se
    responsabilizando, também, por elaborar o ofício de comunicação à Agência
    quando sobrevier alteração no contrato social do cliente.
</p>
<p align="justify">
    <strong>III.XV - Auxilio</strong>
    <strong> inclusão ou retirada responsável técnico CREA</strong>
    Cumprirá à CONTRATADA guiar a CONTRATANTE nos procedimentos de inclusão,
    modificação ou retirada de responsáveis técnicos junto ao CREA e à Anatel.
</p>
<p align="justify">
    <strong>III.XVI - Cadastramento de POP junto a Anatel</strong>
    : Isenção do custo de projeto mediante o custeio das taxas administrativas
    (Anatel e CREA), limitado a um laudo mensal não acumulativo.
</p>
<p align="justify">
    <strong>III.XVII - Orientação Técnica em Licitação</strong>
    : Sugestões no âmbito exclusivamente técnico ao CONTRATANTE para norteá-lo
    na participação em Licitações de Serviços em Telecomunicações.
</p>
<p align="justify">
    <strong>III.XVIII - 30 Tickets de Call Center Transbordo:</strong>
    O CONTRATADO fará jus a 30 atendimentos de Call Center receptivo dentro do
    exercício mensal, exclusivamente para transbordo, não acumulativos nos
    meses posteriores.
</p>
<p align="justify">
    Orientações:
</p>
<ol>
    <li>
        <p>
            O CONTRANTE deverá avisar com 24hrs de antecedência que será
            realizado o transbordo. Caso não seja avisada a transferência,
            poderão ocorrer filas no atendimento;
        </p>
    </li>
</ol>
<ol start="2">
    <li>
        <p>
            Ligações excedentes possuem o custo de R$ 10,00 (dez reais);
        </p>
    </li>
</ol>
<ol start="3">
    <li>
        <p align="justify">
            As ligações recebidas pela CONTRATANTE serão transferidas para a
            CONTRATADA, através de sistema voip (voz sobre ip), sendo de
            obrigação da contratante a disponibilização de um canal voip e uma
            conexão estável de pelo menos 256 kbps durante o fluxo das
            ligações;
        </p>
    </li>
</ol>
<ol start="4">
    <li>
        <p align="justify">
            <a name="page2"></a>
            A CONTRATADA não se responsabiliza por prejuízo em detrimento da má
            configuração ou má qualidade do equipamento da parte CONTRATANTE,
            bem como a infraestrutura utilizada. Caso necessário, a CONTRATADA
            poderá oferecer um equipamento adequado para os atendimentos, com
            um custo à parte.
        </p>
    </li>
</ol>
<ol start="5">
    <li>
        <p align="justify">
            O número de atendimento (sac) deve ser fornecido pela CONTRATANTE e
            colocado juntamente ao cadastro para que sejam feitos testes.
        </p>
    </li>
</ol>
<ol start="6">
    <li>
        <p align="justify">
            Este serviço não substitui as outras formas de atendimento e
            gerenciamento do atendimento da parte CONTRATANTE, o contrato em
            referência trata-se apenas do atendimento de primeiro nível,
            abertura de chamados.
        </p>
    </li>
</ol>
<ol start="7">
    <li>
        <p align="justify">
            A CONTRATANTE terá acesso ao sistema por login e senha exclusiva,
            limitado a 03 (três) usuários. O custo para usuários adicionais é
            de R$ 50,00 (cinquenta reais)
        </p>
    </li>
</ol>
<ol start="8">
    <li>
        <p align="justify">
            É obrigação da CONTRATANTE fechar os chamados abertos no sistema de
            gerenciamento da CONTRATADA com as tratativas realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>CLÁUSULA QUARTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel).
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA QUINTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ {valor_total_contrato}</strong>, eis que a CONTRATANTE
    aderiu ao <u><strong>{tipo_contrato}</strong></u>, pelo período estipulado
    na cláusula segunda desta avença, o qual, por mera liberalidade da
CONTRATADA, será adimplido mediante <strong>{meses</strong><strong>}</strong><strong> prestações de </strong><strong>{prestacao}</strong> cada uma, vencendo a primeira parcela no dia    <u><strong>{dia_primeira_parcela}</strong></u> e as demais no mesmo dia dos
    meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATANTE se compromete expressamente, através do presente, a
    tomar todas as precauções necessárias para salvaguardar o sigilo das
    mesmas, bem como evitar e prevenir revelação a terceiros, não podendo
    utilizá-las para outros projetos que por ventura esteja desenvolvendo,
    exceto se devidamente autorizado por escrito pela CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATANTE serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATANTE obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATADA danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATADA, legítima detentora do direito a tais informações, poderá tomar
    todas as medidas judiciais e extrajudiciais, inclusive de caráter cautelar
    ou de antecipação de tutela jurisdicional, que julgar cabíveis à defesa de
    seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA RESCISÃO</strong>
</p>
<p align="justify">
    <a name="_GoBack"></a>
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor
    restante do contrato à parte que originou o descumprimento.
</p>
<p align="justify">
    VII.II – Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 15 (quinze) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.III - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA– DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    <a name="__DdeLink__3625_103137086"></a>
    Brasília, {data}.
</p>
<p align="center">
    <a name="__DdeLink__1670_103137086"></a>
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>_______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-flex');

------------------------------------------------------------------------------pos-outorga-flex







UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <strong>CONSULTORIA MENSAL PÓS OUTORGA</strong>
</p>
<p align="center">
    <u><strong>Combo Ultra</strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, neste ato representado pelos sócios: {socios},
    doravante denominada CONTRATANTE, declaram que, nesta data, ajustam entre
    si, de comum acordo e na melhor forma de direito, o presente
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA MENSAL PÓS OUTORGA
    </strong>
    , que será regido pela legislação vigente e pelas cláusulas e condições
    seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA </strong>
</p>
<p align="justify">
O contrato perdurará pelo prazo inicial de <strong> </strong>    <strong>{meses}</strong><strong> mês(es)</strong><strong>,</strong>
    renovando-se automaticamente por igual período subsequente, exceto se
    houver prévia comunicação, por escrito, no prazo de 30 (trinta) dias, do
    desejo de pôr termo ao contrato ao término de sua vigência.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p>
    <strong>CLÁUSULA TERCEIRA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <u><strong>COMBO ULTRA</strong></u><u> </u>e conterá todos os serviços
    abaixo delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condencine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores, além de indicar revistas especializadas, com o escopo de
    propiciar o crescimento e solidificação do Provedor.
</p>
<p align="justify">
    <strong>III.VI – Inovação</strong>
    : serviço voltado a divulgar e a orientar a CONTRATANTE em novos processos
    e projetos na área de telecomunicações, objetivando o crescimento e
    desenvolvimento de sua empresa com soluções inovadoras, criativas e com
    alto valor agregado no mercado, englobando, também, a divulgação de Editais
    e Licitações vigentes para participação na área de Telecomunicações.
</p>
<p align="justify">
    <strong>III.VII – Organização de Documentos</strong>
    : Orientações sobre a necessidade de obtenção, guarda e exibição de
    documentos obrigatórios em caso de fiscalização da Anatel.
</p>
<p align="justify">
    <strong>III.VIII – Sistemas Interativos da Anatel</strong>
    : recomendações e direções sobre a utilização e registros no sistema FOCUS
    da Anatel.
</p>
<p align="justify">
    <strong>III.IX – Consultoria Jurídica Básica</strong>
    : elaboração de contratos SCM, Link Dedicado, Permanência e Termo de
    Adesão, atualização dos instrumentos de acordo com modificações
    legislativas ou normativas, orientações da rescisão dos contratos dos
    provedores com seus usuários finais, indicação das medidas jurídicas a
    serem tomadas em caso de procedimentos administrativos na Anatel e
    divulgação de informativos acerca de inovações regulatórias.
</p>
<p align="justify">
    <strong>III.X – Orientações Contábeis Básicas:</strong>
    Auxilio sobre requerimento e confecção da Nota Fiscal modelo 21, Indicação
    dos CNAE´s específico para licença e atividade de SCM e Indicação quanto à
    filiação sindical e o recolhimento das contribuições sindicais.
</p>
<p align="justify">
    <strong>III.XI -</strong>
    <strong>Auxilio Boletos com usuário final – </strong>
    A CONTRATADA auxiliará a CONTRATANTE na confecção dos boletos bancários a
    serem emitidos para adimplir a relação jurídica entre a prestadora de
    serviços de telecomunicações e seu usuário final, sempre em estrita
    obediência às exigências da Anatel.
</p>
<p align="justify">
    <strong>
        III.XII – Informativo de Situação Financeira perante a Anatel:
    </strong>
    A CONTRATADA divulgará à CONTRATANTE acerca de eventuais débitos em aberto
    na Anatel e o orientará quanto às condições de regularização.
</p>
<p align="justify">
    <strong>III.XIII – Cobrança do CONDENCINE:</strong>
    Auxílio na emissão do documento de cobrança do CONDENCINE.
</p>
<p align="justify">
    <strong>
        III.XIV – Informativo de Alterações Administrativas e/ou Técnicas:
    </strong>
    A CONTRATADA atualizará a CONTRATANTE acerca de novas exigências ou
    parâmetros da Anatel sobre questões técnicas e administrativas, se
    responsabilizando, também, por elaborar o ofício de comunicação à Agência
    quando sobrevier alteração no contrato social do cliente.
</p>
<p align="justify">
    <strong>III.XV - Auxilio</strong>
    <strong> inclusão ou retirada responsável técnico CREA</strong>
    Cumprirá à CONTRATADA guiar a CONTRATANTE nos procedimentos de inclusão,
    modificação ou retirada de responsáveis técnicos junto ao CREA e à Anatel.
</p>
<p align="justify">
    <strong>III.XVI - Cadastramento de POP junto a Anatel</strong>
    : Isenção do custo de projeto mediante o custeio das taxas administrativas
    (Anatel e CREA), limitado a um laudo mensal não acumulativo.
</p>
<p align="justify">
    <strong>III.XVII - Orientação Técnica em Licitação</strong>
    : Sugestões no âmbito exclusivamente técnico ao CONTRATANTE para norteá-lo
    na participação em Licitações de Serviços em Telecomunicações.
</p>
<p align="justify">
    <strong>III.XVIII - 30 Tickets de Call Center:</strong>
    A CONTRATANTE fará jus a 30 atendimentos de Call Center ativo ou receptivo
    dentro do exercício mensal, não acumulativos nos meses posteriores.
</p>
<p align="justify">
    <u>Orientações Call Center Receptivo:</u>
</p>
<ol>
    <li>
        <p>
            O CONTRANTE deverá avisar com 24hrs de antecedência que será
            realizado o transbordo. Caso não seja avisada a transferência,
            poderão ocorrer filas no atendimento;
        </p>
    </li>
</ol>
<ol start="2">
    <li>
        <p>
            Ligações excedentes possuem o custo de R$ 10,00 (dez reais);
        </p>
    </li>
</ol>
<ol start="3">
    <li>
        <p align="justify">
            As ligações recebidas pela CONTRATANTE serão transferidas para a
            CONTRATADA, através de sistema voip (voz sobre ip), sendo de
            obrigação da contratante a disponibilização de um canal voip e uma
            conexão estável de pelo menos 256 kbps durante o fluxo das
            ligações;
        </p>
    </li>
</ol>
<ol start="4">
    <li>
        <p align="justify">
            <a name="page2"></a>
            A CONTRATADA não se responsabiliza por prejuízo em detrimento da má
            configuração ou má qualidade do equipamento da parte CONTRATANTE,
            bem como a infraestrutura utilizada. Caso necessário, a CONTRATADA
            poderá oferecer um equipamento adequado para os atendimentos, com
            um custo à parte.
        </p>
    </li>
</ol>
<ol start="5">
    <li>
        <p align="justify">
            O número de atendimento (sac) deve ser fornecido pela CONTRATANTE e
            colocado juntamente ao cadastro para que sejam feitos testes.
        </p>
    </li>
</ol>
<ol start="6">
    <li>
        <p align="justify">
            Este serviço não substitui as outras formas de atendimento e
            gerenciamento do atendimento da parte CONTRATANTE, o contrato em
            referência trata-se apenas do atendimento de primeiro nível,
            abertura de chamados.
        </p>
    </li>
</ol>
<ol start="7">
    <li>
        <p align="justify">
            A CONTRATANTE terá acesso ao sistema por login e senha exclusiva,
            limitado a 03 (três) usuários. O custo para usuários adicionais é
            de R$ 50,00 (cinquenta reais)
        </p>
    </li>
</ol>
<ol start="8">
    <li>
        <p align="justify">
            É obrigação da CONTRATANTE fechar os chamados abertos no sistema de
            gerenciamento da CONTRATADA com as tratativas realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <u>Orientações Call Center Receptivo:</u>
</p>
<ol>
    <li>
        <p align="justify">
            Solicitação deverá ser realizado ate o final de cada mês anterior
            ao mês de execução.
        </p>
    </li>
    <li>
        <p align="justify">
            Envio de dados solicitados pela CONTRATANTE à CONTRATADA para
            execução de call center ativo.
        </p>
    </li>
    <li>
        <p align="justify">
            A CONTRANTANTE passará mensalmente relatório de ligações
            realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>III.XIX –</strong>
    <strong>Auxilio com a Central de atendimento gratuito</strong>
    - As Prestadoras devem disponibilizar central de atendimento aos seus
    clientes, motivo pelo qual a CONTRATADA auxiliará na contratação de central
    de atendimento gratuito para seu cliente final (número 0800), cabendo à
    CONTRATADA assessorar a CONTRATANTE em relação à observância das normas do
    sistema do tele atendimento.
</p>
<p align="justify">
    <strong>III.XX – Orientação Customizada sobre Link Dedicado: </strong>
    Consulta técnica à especialista sobre a necessidade de contratação,
    levantamento de disponibilidade e custos referentes à implementação do link
    dedicado na localidade pretendida pela CONTRATANTE.
</p>
<p align="justify">
    <strong>III.XXI - Orientação de Gestão Comercial: </strong>
    Consulta à especialista sobre a formatação do modelo de negócio e
    composição comercial e societária da CONTRATANTE.
</p>
<p align="justify">
    <strong>II</strong>
    <strong>I.XXII - Denúncias contra provedores ilegais </strong>
    <strong>- </strong>
    A CONTRATADA orientará a CONTRATANTE no tocante a elaboração e remessa de
    denúncias anônimas, ou não, à Anatel a respeito de práticas ilegais ou
    inadequadas de demais prestadoras de serviços de Telecomunicações.
</p>
<p align="justify">
    <strong>III.XXIII – Instruções sobre Notificação e Cobrança</strong>
    : Orientação Jurídica para notificação e cobrança de clientes finais dos
    Provedores, de acordo com a legislação aplicável e com as normas da Anatel
    a respeito do tema.
</p>
<p align="justify">
    <strong>III.XXIV - Pesq</strong>
    <strong>uisa de Qualidade e Satisfação cliente final (PQS) - </strong>
    A CONTRATADA realizará pesquisa mensal com clientes ativos de seu provedor,
    a fim de verificar o grau de satisfação com os serviços de telecomunicações
    ofertados e fornecerá à CONTRATANTE o respectivo relatório, o qual conterá
    sugestões, elogios e possíveis reclamações. Limitado a 30 entrevistados por
    mês, não cumulativos para os exercícios seguintes.
</p>
<p align="justify">
    III.XXIV.I – Importa elucidar que a Anatel impõe alguns parâmetros de
    qualidade para o SCM, como o rápido atendimento e reclamações dos clientes,
    sobre os quais a Agência poderá fiscalizar e solicitar a qualquer tempo.
</p>
<p align="justify">
    <strong>III.XXV - Licenciamento de Rádio Enlace</strong>
    : Isenção do custo de consultoria para licenciamento de Enlaces junto à
    Anatel. A CONTRATANTE se responsabilizará pelo custeio das taxas
    administrativas (Anatel e CREA).
</p>
<p align="justify">
    <strong>III.XXVI - Monitoramento ou Gerenciamento de Servidor</strong>
    : 1vCPU, 1Gb RAM, 20 GB HD, com <em>uptime</em> de 99,8% (noventa e nove
    por cento e oito décimos).
</p>
<p align="justify">
    <strong>CLÁUSULA QUARTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel).
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA QUINTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ {valor_total_contrato}</strong>, eis que a CONTRATANTE
    aderiu ao <u><strong>{tipo_contrato}</strong></u>, pelo período estipulado
    na cláusula segunda desta avença, o qual, por mera liberalidade da
CONTRATADA, será adimplido mediante    <strong> {meses} prestações de {prestacao}</strong> cada uma, vencendo a
    primeira parcela no dia <u><strong>{dia_primeira_parcela}</strong></u> e as
    demais no mesmo dia dos meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATANTE se compromete expressamente, através do presente, a
    tomar todas as precauções necessárias para salvaguardar o sigilo das
    mesmas, bem como evitar e prevenir revelação a terceiros, não podendo
    utilizá-las para outros projetos que por ventura esteja desenvolvendo,
    exceto se devidamente autorizado por escrito pela CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATANTE serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATANTE obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATADA danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATADA, legítima detentora do direito a tais informações, poderá tomar
    todas as medidas judiciais e extrajudiciais, inclusive de caráter cautelar
    ou de antecipação de tutela jurisdicional, que julgar cabíveis à defesa de
    seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA RESCISÃO</strong>
</p>
<p align="justify">
    <a name="_GoBack"></a>
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor
    restante do contrato à parte que originou o descumprimento.
</p>
<p align="justify">
    VII.II – Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 15 (quinze) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.III - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA– DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    Brasília, {data}.
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>_______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-ultra');

------------------------------------------------------------------------------pos-outorga-ultra





UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <img src="" align="left" hspace="12" vspace="1"/>
    <strong>CONSULTORIA MENSAL PÓS OUTORGA - SCM</strong>
</p>
<p align="center">
    <u><strong>Pacote Light</strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>
        <br/>
    </strong>
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, neste ato representado pelos sócios: {socios},
    doravante denominada CONTRATANTE, declaram que, nesta data, ajustam entre
    si, de comum acordo e na melhor forma de direito, o presente
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA MENSAL PÓS OUTORGA
    </strong>
    , que será regido pela legislação vigente e pelas cláusulas e condições
    seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA </strong>
</p>
<p align="justify">
O contrato perdurará pelo prazo inicial de <strong>{meses}</strong>    <strong> mês(es)</strong>, renovando-se automaticamente por igual período
    subsequente, exceto se houver prévia comunicação, por escrito, no prazo de
    30 (trinta) dias, do desejo de pôr termo ao contrato ao término de sua
    vigência.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo Segundo. </strong>
    Mediante a assinatura neste instrumento, a CONTRATANTE se compromete a se
manter na base de clientes da CONTRATADA pelo período mínimo estipulado no    <em>caput</em> desta cláusula e, como contrapartida, recebe a isenção da
    assessoria para obtenção e manutenção da outorga perante a Anatel, que
    possui valor nominal avulso de R$2.500,00 (dois mil e quinhentos reais).
</p>
<p align="justify">
    <strong>Parágrafo Terceiro. </strong>
    Na eventualidade de a CONTRATANTE rescindir este instrumento antes de finda
    sua vigência, além da multa preconizada no item VII.I, deverá reembolsar à
    CONTRATADA todo o descontos que obteve em razão da fidelização.
</p>
<p>
    <strong>CLÁUSULA TERCEIRA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <strong>PACOTE LIGHT</strong>, que conterá todos os serviços abaixo
    delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condencine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores.
</p>
<p align="justify">
    <strong>CLÁUSULA QUARTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel) e demais órgãos junto aos
    quais a CONTRATADA eventualmente diligenciar.
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA QUINTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ {valor_total_contrato}</strong><strong>,</strong> eis
    que a CONTRATANTE aderiu ao <u><strong>{tipo_contrato}</strong></u>, pelo
    período estipulado na cláusula segunda desta avença, o qual, por mera
liberalidade da CONTRATADA, será adimplido mediante    <strong>{meses} prestações de {prestacao}</strong> cada uma, vencendo a
    primeira parcela no dia <u><strong>{dia_primeira_parcela}</strong></u> e as
    demais no mesmo dia dos meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATADA se compromete expressamente, através do presente, a tomar
    todas as precauções necessárias para salvaguardar o sigilo das mesmas, bem
    como evitar e prevenir revelação a terceiros, não podendo utilizá-las para
    outros projetos que por ventura esteja desenvolvendo, exceto se devidamente
    autorizado por escrito pela CONTRATANTE.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATADA serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATADA obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATANTE danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATANTE, desde que legítima detentora do direito a tais informações,
    poderá tomar todas as medidas judiciais e extrajudiciais, inclusive de
    caráter cautelar ou de antecipação de tutela jurisdicional, que julgar
    cabíveis à defesa de seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA RESCISÃO</strong>
</p>
<p align="justify">
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor global
    do contrato à parte que originou o descumprimento.
</p>
<p align="justify">
    VII.II – Conforme avençado alhures, uma vez que a CONTRATADA rescinda o
    presente pacto antes de transcorrido integralmente o prazo de 36 (trinta e
    seis) meses, também deverá ressarcir a CONTRATANTE na exata quantia da
    isenção que obteve em função da contratação nesta modalidade, qual seja, de
    R$2.500,00 (dois mil e quinhentos reais), nos moldes do previsto no
    parágrafo segundo da cláusula segunda desta avença.
</p>
<p align="justify">
    VII.III - Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 30 (trinta) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.IV - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA– DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    Brasília, {data}.
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>__________________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-light-scm');

------------------------------------------------------------------------------pos-outorga-light-scm






UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <strong>CONSULTORIA MENSAL PÓS OUTORGA - SCM</strong>
</p>
<p align="center">
    <u><strong>Pacote Ultra</strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, neste ato representado pelos sócios: {socios},
    doravante denominada CONTRATANTE, declaram que, nesta data, ajustam entre
    si, de comum acordo e na melhor forma de direito, o presente
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA MENSAL PÓS OUTORGA
    </strong>
    , que será regido pela legislação vigente e pelas cláusulas e condições
    seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DA VIGÊNCIA </strong>
</p>
<p align="justify">
O contrato perdurará pelo prazo inicial de <strong>{meses}</strong>    <strong> mês(es)</strong> meses, renovando-se automaticamente por igual
    período subsequente, exceto se houver prévia comunicação, por escrito, no
    prazo de 30 (trinta) dias, do desejo de pôr termo ao contrato ao término de
    sua vigência.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo Segundo. </strong>
    Mediante a assinatura neste instrumento, a CONTRATANTE se compromete a se
    manter na base de clientes da CONTRATADA pelo período mínimo estipulado no
    caput desta cláusula e, como contrapartida, recebe a isenção da assessoria
    para obtenção e manutenção da outorga perante a Anatel, que possui valor
    nominal avulso de R$2.500,00 (dois mil e quinhentos reais).
</p>
<p align="justify">
    <strong>Parágrafo Terceiro. </strong>
    Na eventualidade de a CONTRATANTE rescindir este instrumento antes de finda
    sua vigência, além da multa preconizada no item VII.I, deverá reembolsar à
    CONTRATADA todos os descontos que obteve em razão da fidelização.
</p>
<p>
    <strong>CLÁUSULA TERCEIRA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <u><strong>PACOTE ULTRA</strong></u> e conterá todos os serviços abaixo
    delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condencine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores, além de indicar revistas especializadas, com o escopo de
    propiciar o crescimento e solidificação do Provedor.
</p>
<p align="justify">
    <strong>III.VI – Inovação</strong>
    : serviço voltado a divulgar e a orientar a CONTRATANTE em novos processos
    e projetos na área de telecomunicações, objetivando o crescimento e
    desenvolvimento de sua empresa com soluções inovadoras, criativas e com
    alto valor agregado no mercado, englobando, também, a divulgação de Editais
    e Licitações vigentes para participação na área de Telecomunicações.
</p>
<p align="justify">
    <strong>III.VII – Organização de Documentos</strong>
    : Orientações sobre a necessidade de obtenção, guarda e exibição de
    documentos obrigatórios em caso de fiscalização da Anatel.
</p>
<p align="justify">
    <strong>III.VIII – Sistemas Interativos da Anatel</strong>
    : recomendações e direções sobre a utilização e registros no sistema FOCUS
    da Anatel.
</p>
<p align="justify">
    <strong>III.IX – Consultoria Jurídica Básica</strong>
    : elaboração de contratos SCM, Link Dedicado, Permanência e Termo de
    Adesão, atualização dos instrumentos de acordo com modificações
    legislativas ou normativas, orientações da rescisão dos contratos dos
    provedores com seus usuários finais, indicação das medidas jurídicas a
    serem tomadas em caso de procedimentos administrativos na Anatel e
    divulgação de informativos acerca de inovações regulatórias.
</p>
<p align="justify">
    <strong>III.X – Orientações Contábeis Básicas:</strong>
    Auxilio sobre requerimento e confecção da Nota Fiscal modelo 21, Indicação
    dos CNAE´s específico para licença e atividade de SCM e Indicação quanto à
    filiação sindical e o recolhimento das contribuições sindicais.
</p>
<p align="justify">
    <strong>III.XI -</strong>
    <strong>Auxilio Boletos com usuário final – </strong>
    A CONTRATADA auxiliará a CONTRATANTE na confecção dos boletos bancários a
    serem emitidos para adimplir a relação jurídica entre a prestadora de
    serviços de telecomunicações e seu usuário final, sempre em estrita
    obediência às exigências da Anatel.
</p>
<p align="justify">
    <strong>
        III.XII – Informativo de Situação Financeira perante a Anatel:
    </strong>
    A CONTRATADA divulgará à CONTRATANTE acerca de eventuais débitos em aberto
    na Anatel e o orientará quanto às condições de regularização.
</p>
<p align="justify">
    <strong>III.XIII – Cobrança do CONDENCINE:</strong>
    Auxílio na emissão do documento de cobrança do CONDENCINE.
</p>
<p align="justify">
    <strong>
        III.XIV – Informativo de Alterações Administrativas e/ou Técnicas:
    </strong>
    A CONTRATADA atualizará a CONTRATANTE acerca de novas exigências ou
    parâmetros da Anatel sobre questões técnicas e administrativas, se
    responsabilizando, também, por elaborar o ofício de comunicação à Agência
    quando sobrevier alteração no contrato social do cliente.
</p>
<p align="justify">
    <strong>III.XV - Auxilio</strong>
    <strong> inclusão ou retirada responsável técnico CREA</strong>
    Cumprirá à CONTRATADA guiar a CONTRATANTE nos procedimentos de inclusão,
    modificação ou retirada de responsáveis técnicos junto ao CREA e à Anatel.
</p>
<p align="justify">
    <strong>III.XVI - Cadastramento de POP junto a Anatel</strong>
    : Isenção do custo de projeto mediante o custeio das taxas administrativas
    (Anatel e CREA), limitado a um laudo mensal não acumulativo.
</p>
<p align="justify">
    <strong>III.XVII - Orientação Técnica em Licitação</strong>
    : Sugestões no âmbito exclusivamente técnico ao CONTRATANTE para norteá-lo
    na participação em Licitações de Serviços em Telecomunicações.
</p>
<p align="justify">
    <strong>III.XVIII - 30 Tickets de Call Center:</strong>
    A CONTRATANTE fará jus a 30 atendimentos de Call Center ativo ou receptivo
    dentro do exercício mensal, não acumulativos nos meses posteriores.
</p>
<p align="justify">
    <u>Orientações Call Center Receptivo:</u>
</p>
<ol>
    <li>
        <p>
            O CONTRANTE deverá avisar com 24hrs de antecedência que será
            realizado o transbordo. Caso não seja avisada a transferência,
            poderão ocorrer filas no atendimento;
        </p>
    </li>
</ol>
<ol start="2">
    <li>
        <p>
            Ligações excedentes possuem o custo de R$ 10,00 (dez reais);
        </p>
    </li>
</ol>
<ol start="3">
    <li>
        <p align="justify">
            As ligações recebidas pela CONTRATANTE serão transferidas para a
            CONTRATADA, através de sistema voip (voz sobre ip), sendo de
            obrigação da contratante a disponibilização de um canal voip e uma
            conexão estável de pelo menos 256 kbps durante o fluxo das
            ligações;
        </p>
    </li>
</ol>
<ol start="4">
    <li>
        <p align="justify">
            <a name="page2"></a>
            A CONTRATADA não se responsabiliza por prejuízo em detrimento da má
            configuração ou má qualidade do equipamento da parte CONTRATANTE,
            bem como a infraestrutura utilizada. Caso necessário, a CONTRATADA
            poderá oferecer um equipamento adequado para os atendimentos, com
            um custo à parte.
        </p>
    </li>
</ol>
<ol start="5">
    <li>
        <p align="justify">
            O número de atendimento (sac) deve ser fornecido pela CONTRATANTE e
            colocado juntamente ao cadastro para que sejam feitos testes.
        </p>
    </li>
</ol>
<ol start="6">
    <li>
        <p align="justify">
            Este serviço não substitui as outras formas de atendimento e
            gerenciamento do atendimento da parte CONTRATANTE, o contrato em
            referência trata-se apenas do atendimento de primeiro nível,
            abertura de chamados.
        </p>
    </li>
</ol>
<ol start="7">
    <li>
        <p align="justify">
            A CONTRATANTE terá acesso ao sistema por login e senha exclusiva,
            limitado a 03 (três) usuários. O custo para usuários adicionais é
            de R$ 50,00 (cinquenta reais)
        </p>
    </li>
</ol>
<ol start="8">
    <li>
        <p align="justify">
            É obrigação da CONTRATANTE fechar os chamados abertos no sistema de
            gerenciamento da CONTRATADA com as tratativas realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <u>Orientações Call Center Receptivo:</u>
</p>
<ol>
    <li>
        <p align="justify">
            Solicitação deverá ser realizado ate o final de cada mês anterior
            ao mês de execução.
        </p>
    </li>
    <li>
        <p align="justify">
            Envio de dados solicitados pela CONTRATANTE à CONTRATADA para
            execução de call center ativo.
        </p>
    </li>
    <li>
        <p align="justify">
            A CONTRANTANTE passará mensalmente relatório de ligações
            realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>III.XIX –</strong>
    <strong>Auxilio com a Central de atendimento gratuito</strong>
    - As Prestadoras devem disponibilizar central de atendimento aos seus
    clientes, motivo pelo qual a CONTRATADA auxiliará na contratação de central
    de atendimento gratuito para seu cliente final (número 0800), cabendo à
    CONTRATADA assessorar a CONTRATANTE em relação à observância das normas do
    sistema do tele atendimento.
</p>
<p align="justify">
    <strong>III.XX – Orientação Customizada sobre Link Dedicado: </strong>
    Consulta técnica à especialista sobre a necessidade de contratação,
    levantamento de disponibilidade e custos referentes à implementação do link
    dedicado na localidade pretendida pela CONTRATANTE.
</p>
<p align="justify">
    <strong>III.XXI - Orientação de Gestão Comercial: </strong>
    Consulta à especialista sobre a formatação do modelo de negócio e
    composição comercial e societária da CONTRATANTE.
</p>
<p align="justify">
    <strong>II</strong>
    <strong>I.XXII - Denúncias contra provedores ilegais </strong>
    <strong>- </strong>
    A CONTRATADA orientará a CONTRATANTE no tocante a elaboração e remessa de
    denúncias anônimas, ou não, à Anatel a respeito de práticas ilegais ou
    inadequadas de demais prestadoras de serviços de Telecomunicações.
</p>
<p align="justify">
    <strong>III.XXIII – Instruções sobre Notificação e Cobrança</strong>
    : Orientação Jurídica para notificação e cobrança de clientes finais dos
    Provedores, de acordo com a legislação aplicável e com as normas da Anatel
    a respeito do tema.
</p>
<p align="justify">
    <strong>III.XXIV - Pesq</strong>
    <strong>uisa de Qualidade e Satisfação cliente final (PQS) - </strong>
    A CONTRATADA realizará pesquisa mensal com clientes ativos de seu provedor,
    a fim de verificar o grau de satisfação com os serviços de telecomunicações
    ofertados e fornecerá à CONTRATANTE o respectivo relatório, o qual conterá
    sugestões, elogios e possíveis reclamações. Limitado a 30 entrevistados por
    mês, não cumulativos para os exercícios seguintes.
</p>
<p align="justify">
    III.XXIV.I – Importa elucidar que a Anatel impõe alguns parâmetros de
    qualidade para o SCM, como o rápido atendimento e reclamações dos clientes,
    sobre os quais a Agência poderá fiscalizar e solicitar a qualquer tempo.
</p>
<p align="justify">
    <strong>III.XXV - Licenciamento de Rádio Enlace</strong>
    : Isenção do custo de consultoria para licenciamento de Enlaces junto à
    Anatel. A CONTRATANTE se responsabilizará pelo custeio das taxas
    administrativas (Anatel e CREA).
</p>
<p align="justify">
    <strong>III.XXVI - Monitoramento ou Gerenciamento de Servidor</strong>
    : 1vCPU, 1Gb RAM, 20 GB HD, com <em>uptime</em> de 99,8% (noventa e nove
    por cento e oito décimos).
</p>
<p align="justify">
    <strong>CLÁUSULA QUARTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel).
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA QUINTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ {valor_total_contrato}</strong>, eis que a CONTRATANTE
    aderiu ao <u><strong>{tipo_contrato}</strong></u>, pelo período estipulado
    na cláusula segunda desta avença, o qual, por mera liberalidade da
CONTRATADA, será adimplido mediante <strong>{meses</strong><strong>}</strong><strong> prestações de </strong><strong>{prestacao}</strong> cada uma, vencendo a primeira parcela no dia    <u><strong>{dia_primeira_parcela}</strong></u> e as demais no mesmo dia dos
    meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATADA se compromete expressamente, através do presente, a tomar
    todas as precauções necessárias para salvaguardar o sigilo das mesmas, bem
    como evitar e prevenir revelação a terceiros, não podendo utilizá-las para
    outros projetos que por ventura esteja desenvolvendo, exceto se devidamente
    autorizado por escrito pela CONTRATANTE.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATADA serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATADA obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATANTE danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATANTE, desde que legítima detentora do direito a tais informações,
    poderá tomar todas as medidas judiciais e extrajudiciais, inclusive de
    caráter cautelar ou de antecipação de tutela jurisdicional, que julgar
    cabíveis à defesa de seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA RESCISÃO</strong>
</p>
<p align="justify">
    <a name="_GoBack"></a>
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor
    restante do contrato à parte que originou o descumprimento, com vencimento
    para 5 (cinco) dias úteis após a ocorrência.
</p>
<p align="justify">
    VII.II – Conforme avençado alhures, uma vez que a CONTRATADA rescinda o
    presente pacto antes de transcorrido integralmente o prazo de 36 (trinta e
    seis) meses, também deverá ressarcir a CONTRATANTE na exata quantia da
    isenção que obteve em função da contratação nesta modalidade, qual seja, de
    R$2.500,00 (dois mil e quinhentos reais), nos moldes do previsto no
    parágrafo segundo da cláusula segunda desta avença.
</p>
<p align="justify">
    VII.III - Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 30 (trinta) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.IV - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA– DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    Brasília, {data}.
</p>
<p align="center">
    <a name="__DdeLink__1670_103137086"></a>
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>_______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-ultra-scm');

------------------------------------------------------------------------------pos-outorga-ultra-scm





UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <strong>CONSULTORIA MENSAL PÓS OUTORGA – SCM </strong>
</p>
<p align="center">
    <u><strong>Pacote Flex </strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, doravante denominada CONTRATANTE, declaram que,
    nesta data, ajustam entre si, de comum acordo e na melhor forma de direito,
    o presente
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA MENSAL PÓS OUTORGA
    </strong>
    , que será regido pela legislação vigente e pelas cláusulas e condições
    seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>
        CLÁUSULA SEGUNDA – DA VIGÊNCIA E DO PRAZO DE PERMANÊNCIA MÍNIMO
    </strong>
</p>
<p align="justify">
O contrato perdurará pelo prazo inicial de <strong>{meses}</strong>    <strong> mês(es)</strong>, renovando-se automaticamente por igual período
    subsequente, exceto se houver prévia comunicação, por escrito, no prazo de
    30 (trinta) dias, do desejo de pôr termo ao contrato ao término de sua
    vigência.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo Segundo. </strong>
    Mediante a assinatura neste instrumento, a CONTRATANTE se compromete a se
manter na base de clientes da CONTRATADA pelo período mínimo estipulado no    <em>caput</em> desta cláusula e, como contrapartida, recebe a isenção da
    assessoria para obtenção e manutenção da outorga perante a Anatel, que
    possui valor nominal avulso de R$2.500,00 (dois mil e quinhentos reais).
</p>
<p align="justify">
    <strong>Parágrafo Terceiro. </strong>
    Na eventualidade de a CONTRATANTE rescindir este instrumento antes de finda
    sua vigência, além da multa preconizada no item VII.I, deverá reembolsar à
    CONTRATADA todo o descontos que obteve em razão da fidelização.
</p>
<p>
    <strong>CLÁUSULA TERCEIRA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <u><strong>PACOTE FLEX</strong></u><strong> </strong>e conterá todos os
    serviços abaixo delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condencine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores, além de indicar revistas especializadas, com o escopo de
    propiciar o crescimento e solidificação do Provedor.
</p>
<p align="justify">
    <strong>III.VI – Inovação</strong>
    : serviço voltado a divulgar e a orientar a CONTRATANTE em novos processos
    e projetos na área de telecomunicações, objetivando o crescimento e
    desenvolvimento de sua empresa com soluções inovadoras, criativas e com
    alto valor agregado no mercado, englobando, também, a divulgação de Editais
    e Licitações vigentes para participação na área de Telecomunicações.
</p>
<p align="justify">
    <strong>III.VII – Organização de Documentos</strong>
    : Orientações sobre a necessidade de obtenção, guarda e exibição de
    documentos obrigatórios em caso de fiscalização da Anatel.
</p>
<p align="justify">
    <strong>III.VIII – Sistemas Interativos da Anatel</strong>
    : recomendações e direções sobre a utilização e registros no sistema FOCUS
    da Anatel.
</p>
<p align="justify">
    <strong>III.IX – Consultoria Jurídica Básica</strong>
    : elaboração de contratos SCM, Link Dedicado, Permanência e Termo de
    Adesão, atualização dos instrumentos de acordo com modificações
    legislativas ou normativas, orientações da rescisão dos contratos dos
    provedores com seus usuários finais, indicação das medidas jurídicas a
    serem tomadas em caso de procedimentos administrativos na Anatel e
    divulgação de informativos acerca de inovações regulatórias.
</p>
<p align="justify">
    <strong>III.X – Orientações Contábeis Básicas:</strong>
    Auxilio sobre requerimento e confecção da Nota Fiscal modelo 21, Indicação
    dos CNAE´s específico para licença e atividade de SCM e Indicação quanto à
    filiação sindical e o recolhimento das contribuições sindicais.
</p>
<p align="justify">
    <strong>III.XI -</strong>
    <strong>Auxilio Boletos com usuário final – </strong>
    A CONTRATADA auxiliará a CONTRATANTE na confecção dos boletos bancários a
    serem emitidos para adimplir a relação jurídica entre a prestadora de
    serviços de telecomunicações e seu usuário final, sempre em estrita
    obediência às exigências da Anatel.
</p>
<p align="justify">
    <strong>
        III.XII – Informativo de Situação Financeira perante a Anatel:
    </strong>
    A CONTRATADA divulgará o CONTRATANTE acerca de eventuais débitos em aberto
    na Anatel e o orientará quanto às condições de regularização.
</p>
<p align="justify">
    <strong>III.XIII – Cobrança do CONDENCINE:</strong>
    Auxílio na emissão do documento de cobrança do CONDENCINE.
</p>
<p align="justify">
    <strong>
        III.XIV – Informativo de Alterações Administrativas e/ou Técnicas:
    </strong>
    A CONTRATADA atualizará o CONTRATANTE acerca de novas exigências ou
    parâmetros da Anatel sobre questões técnicas e administrativas, se
    responsabilizando, também, por elaborar o ofício de comunicação à Agência
    quando sobrevier alteração no contrato social do cliente.
</p>
<p align="justify">
    <strong>III.XV - Auxilio</strong>
    <strong> inclusão ou retirada responsável técnico CREA</strong>
    Cumprirá à CONTRATADA guiar a CONTRATANTE nos procedimentos de inclusão,
    modificação ou retirada de responsáveis técnicos junto ao CREA e à Anatel.
</p>
<p align="justify">
    <strong>III.XVI - Cadastramento de POP junto a Anatel</strong>
    : Isenção do custo de projeto mediante o custeio das taxas administrativas
    (Anatel e CREA), limitado a um laudo mensal não acumulativo.
</p>
<p align="justify">
    <strong>III.XVII - Orientação Técnica em Licitação</strong>
    : Sugestões no âmbito exclusivamente técnico ao CONTRATANTE para norteá-lo
    na participação em Licitações de Serviços em Telecomunicações.
</p>
<p align="justify">
    <strong>III.XVIII - 30 Tickets de Call Center Transbordo:</strong>
    O CONTRATADO fará jus a 30 atendimentos de Call Center receptivo dentro do
    exercício mensal, exclusivamente para transbordo, não acumulativos nos
    meses posteriores.
</p>
<p align="justify">
    <u>Orientações Transbordo:</u>
</p>
<ol>
    <li>
        <p>
            O CONTRANTE deverá avisar com 24hrs de antecedência que será
            realizado o transbordo. Caso não seja avisada a transferência,
            poderão ocorrer filas no atendimento;
        </p>
    </li>
</ol>
<ol start="2">
    <li>
        <p>
            Ligações excedentes possuem o custo de R$ 10,00 (dez reais);
        </p>
    </li>
</ol>
<ol start="3">
    <li>
        <p align="justify">
            As ligações recebidas pela CONTRATANTE serão transferidas para a
            CONTRATADA, através de sistema voip (voz sobre ip), sendo de
            obrigação da contratante a disponibilização de um canal voip e uma
            conexão estável de pelo menos 256 kbps durante o fluxo das
            ligações;
        </p>
    </li>
</ol>
<ol start="4">
    <li>
        <p align="justify">
            <a name="page2"></a>
            A CONTRATADA não se responsabiliza por prejuízo em detrimento da má
            configuração ou má qualidade do equipamento da parte CONTRATANTE,
            bem como a infraestrutura utilizada. Caso necessário, a CONTRATADA
            poderá oferecer um equipamento adequado para os atendimentos, com
            um custo à parte.
        </p>
    </li>
</ol>
<ol start="5">
    <li>
        <p align="justify">
            O número de atendimento (sac) deve ser fornecido pela CONTRATANTE e
            colocado juntamente ao cadastro para que sejam feitos testes.
        </p>
    </li>
</ol>
<ol start="6">
    <li>
        <p align="justify">
            Este serviço não substitui as outras formas de atendimento e
            gerenciamento do atendimento da parte CONTRATANTE, o contrato em
            referência trata-se apenas do atendimento de primeiro nível,
            abertura de chamados.
        </p>
    </li>
</ol>
<ol start="7">
    <li>
        <p align="justify">
            A CONTRATANTE terá acesso ao sistema por login e senha exclusiva,
            limitado a 03 (três) usuários. O custo para usuários adicionais é
            de R$ 50,00 (cinquenta reais)
        </p>
    </li>
</ol>
<ol start="8">
    <li>
        <p align="justify">
            É obrigação da CONTRATANTE fechar os chamados abertos no sistema de
            gerenciamento da CONTRATADA com as tratativas realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>CLÁUSULA QUARTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel).
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA QUINTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ </strong><strong>{valor_total_contrato}</strong>, eis
    que a CONTRATANTE aderiu ao <u><strong>{tipo_contrato}</strong></u>, pelo
    período estipulado na cláusula segunda desta avença, o qual, por mera
liberalidade da CONTRATADA, será adimplido mediante    <strong>{meses} prestações de {prestacao}</strong> cada uma, vencendo a
    primeira parcela no dia <u><strong>{dia_primeira_parcela}</strong></u> e as
    demais no mesmo dia dos meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SEXTA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATADA se compromete expressamente, através do presente, a tomar
    todas as precauções necessárias para salvaguardar o sigilo das mesmas, bem
    como evitar e prevenir revelação a terceiros, não podendo utilizá-las para
    outros projetos que por ventura esteja desenvolvendo, exceto se devidamente
    autorizado por escrito pela CONTRATANTE.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATADA serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATADA obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATANTE danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATANTE, desde que legítima detentora do direito a tais informações,
    poderá tomar todas as medidas judiciais e extrajudiciais, inclusive de
    caráter cautelar ou de antecipação de tutela jurisdicional, que julgar
    cabíveis à defesa de seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – DA RESCISÃO</strong>
</p>
<p align="justify">
    <a name="_GoBack"></a>
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor
    restante do contrato à parte que originou o descumprimento, com vencimento
    para 5 (cinco) dias úteis após a ocorrência.
</p>
<p align="justify">
    VII.II – Conforme avençado alhures, uma vez que a CONTRATADA rescinda o
    presente pacto antes de transcorrido integralmente o prazo de 36 (trinta e
    seis) meses, também deverá ressarcir a CONTRATANTE na exata quantia da
    isenção que obteve em função da contratação nesta modalidade, qual seja, de
    R$2.500,00 (dois mil e quinhentos reais), nos moldes do previsto no
    parágrafo segundo da cláusula segunda desta avença.
</p>
<p align="justify">
    VII.III - Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 30 (trinta) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.IV - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA– DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    Brasília, {data}.
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>_______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-light-scm');

------------------------------------------------------------------------------pos-outorga-light-scm







UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>
        CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE CONSULTORIA TÉCNICA PARA
        CREDENCIMENTO E GESTÃO DE OBRIGAÇÕES SCM PERANTE A ANATEL
    </strong>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>, com sede em C 01
    Lote 01/12 Sala 338, CEP: 72010-010 Edifício Taguatinga Trade Center –
    Taguatinga Centro - Brasília - DF, inscrita no CNPJ sob o
    n.º10.225.044/0001-73, neste ato representado por seus sócios Engenheiro
    Rodrigo Silva Oliveira, brasileiro, natural de Goiânia/GO, solteiro,
    nascido em 13 de Novembro de 1980, Empresário, portador do documento de
    identidade n.º 1.857.494 SSP-DF e do CPF n.º 701.815.431-68, residente em
    AV do Contorno Lote 02 AC. Rabelo Vila Planalto, Brasília / DF, CEP
    70803-210; e Engenheira Ana Paula de Lira Meira, brasileira, natural de
    Brasília/DF, casada, nascida em 16 de Abril de 1980, portador do documento
    de identidade n.º1.882.723 SSP-DF e do CPF n.º 883.079.721-91, residente na
    QNE 21 CASA 15 Taguatinga Norte, Brasília/DF, CEP 72125-210, adiante
designada apenas <strong>CONTRATADA</strong> e    <strong>{razao social}</strong>, situada no endereço {logradouro}
    nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado}, CEP: {cep}
    Inscrito no CNPJ Sob o nº {cnpj} neste ato representado por: {socios},
    doravante denominada CONTRATANTE, têm, entre si, justas e acertadas o
    presente Contrato de Prestação de Serviços de Consultoria Técnica para
    Credenciamento e Gestão de Obrigações SCM perante a Anatel, que se regerá
    pelas cláusulas e condições a seguir entabuladas:
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA - DA ADESÃO A ESTE INSTRUMENTO</strong>
</p>
<p align="justify">
    A adesão pelo CONTRATANTE ao presente Contrato efetiva-se alternativamente
    por meio de quaisquer dos seguintes eventos abaixo:
</p>
<p align="justify">
    a) Aceite verbal em negociação via telefone;
</p>
<p align="justify">
    b) Assinatura do CONTRATO;
</p>
<p align="justify">
    c) Preenchimento de cadastro e aceite “on-line”.
</p>
<p align="justify">
    d) Pagamento de boleto bancário ou depósito em Conta Corrente da
    CONTRATADA.
</p>
<p align="justify">
    e) Percepção, de qualquer forma, dos serviços objeto do presente Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DO OBJETO</strong>
</p>
<p align="justify">
    É objeto do presente contrato a prestação de consultoria, pela CONTRATADA à
    CONTRATANTE, a fim de auxiliá-la na obtenção de credenciamento perante a
    Anatel para exploração do Serviço de Comunicação Multimídia, bem como a
    posterior gestão e consultoria acerca das obrigações da empresa credenciada
    perante a Agência Reguladora.
</p>
<p align="justify">
    <strong>CLÁUSULA TERCEIRA – DA VIGÊNCIA</strong>
</p>
<p align="justify">
    O contrato perdurará pelo prazo inicial de 12 (doze) meses, renovando-se
    automaticamente por igual período subsequente, exceto se houver prévia
    comunicação, por escrito, no prazo de 30 (trinta) dias, do desejo de pôr
    termo ao contrato ao término de sua vigência.
</p>
<p align="justify">
    No entanto, o pacto também poderá ser rescindido nas hipóteses delineadas
    na Cláusula Oitava, com as consequências também delimitadas por aquela
    disposição, as quais ora são mutuamente aceitas e comprometidas.
</p>
<p align="justify">
    <strong>CLÁUSULA QUARTA - DAS OBRIGAÇÕES DA CONTRATADA</strong>
</p>
<p align="justify">
    São deveres da CONTRATADA<strong>:</strong>
</p>
<ol type="a">
    <li>
        <p align="justify">
            Informar à CONTRATANTE os documentos necessários para a obtenção do
            credenciamento ao Serviço de Comunicação Multimídia, junto à
            Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Instruir à CONTRATANTE a respeito do procedimento para registro da
            empresa no CREA.
        </p>
    </li>
    <li>
        <p align="justify">
            Analisar a documentação da CONTRATANTE indicando as modificações
            necessárias para atender ao disposto na Legislação Vigente, em
            especial o disposto na Lei n.° 9.472, no Decreto n.° 2.617/98, no
            Decreto n.° 2.534/98, na Resolução n.° 73 da Anatel, na Resolução
            n.° 65, da Anatel, e na Resolução n.° 272, da Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Representação junto à Anatel: a CONTRATADA representará a
            CONTRATANTE perante a Anatel, para prestar esclarecimentos e
            responder as dúvidas relacionadas à exploração do Serviço de
            Comunicação Multimídia (SCM), bem como acompanhará periodicamente a
            tramitação dos processos e, quando necessário, tomará as medidas
            para agilizar seu andamento, inclusive através de protocolos e
            ofícios.<strong> </strong>
        </p>
    </li>
    <li>
        <p align="justify">
            Sistema de Coleta de Informações (SICI) - As empresas prestadoras
            de serviços de telecomunicações no regime privado devem manter
            atualizado um banco de dados com informações referentes à prestação
            de serviços em suas respectivas áreas de atuação (Sistema de Coleta
            de Informações - SICI), cumprindo à CONTRATADA colaborar com o
            preenchimento periódico deste banco, evitando sanções por parte da
            ANATEL.
        </p>
    </li>
    <li>
        <p align="justify">
            Orientações sobre Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE):
            A CONTRATADA deverá verificar sobre quais serviços prestados pela
            CONTRATANTE deverão incidir contribuições, tais quais o Fundo de
            Universalização das Telecomunicações (Fust), o Fundo para o
            Desenvolvimento Tecnológico das Telecomunicações (Funttel) e a
            Condencine. Além disso, a CONTRATADA assessorará a CONTRATANTE,
            mensalmente, no procedimento de recolhimento do Fust, do Funttel e
            do Fundo de Fiscalização das Telecomunicações (Fistel), procedendo
            ao aviso de boletos em aberto perante a Anatel.
        </p>
    </li>
    <li>
        <p align="justify">
            Calendário de Eventos, cursos, fóruns e publicações: Cumprirá à
            CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
            acerca dos eventos relacionados às telecomunicações e especialmente
            aos provedores.
        </p>
    </li>
    <li>
        <p align="justify">
            Auxiliar a CONTRATANTE na preparação dos documentos necessários
            para o licenciamento das Estações de Telecomunicações do Serviço
            Comunicação Multimídia, quando necessário.
        </p>
    </li>
    <li>
        <p align="justify">
            Representar a CONTRATANTE junto à Anatel durante todo o processo de
            credenciamento, tomando todas as medidas necessárias para que o
            mesmo corra com a maior celeridade possível.
        </p>
    </li>
    <li>
        <p align="justify">
            Oferecer ao CONTRATANTE a cópia do presente instrumento, contendo
            todas as especificidades da prestação de serviço contratada.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>CLÁUSULA QUINTA - DAS OBRIGAÇÕES DA CONTRATANTE</strong>
</p>
<p align="justify">
    São deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção do credenciamento.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar dentro do prazo o pagamento dos boletos emitidos pela
            Anatel em nome da CONTRATANTE, em especial o Preço Público pelo
            Direito de Exploração de Serviços de Telecomunicações e pelo
            Direito de Exploração do Serviço de Comunicação Multimídia (SCM) e
            a Taxa de Fiscalização de Instalação (TFI).
        </p>
    </li>
    <li>
        <p align="justify">
            Entregar tempestivamente todos os documentos e informações exigidos
            para a conclusão do procedimento de outorga, sob pena de não o
            fazendo e tal omissão desencadear em prejuízo dos trabalhos ora
            avençados, arcar com as consequências legais e contratuais de sua
            desídia.
        </p>
    </li>
    <li>
        <p align="justify">
            A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo
            de contrato, modelo de carta, projeto, apresentação, panfleto ou
            qualquer documento criado e utilizado pela CONTRATADA, salvo com
            sua autorização prévia por escrito.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento tempestivamente, conforme disposto na Cláusula
            Quinta deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    <strong>CLÁUSULA SEXTA - DO CUSTO E DA FORMA DE PAGAMENTO</strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
A consultoria possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, através de boletos bancários, conforme programação abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
multa pecuniária de 2%, além de juros de mora de 1% ao mês, calculados    <em>pro rata die</em>, e correção monetária pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo Segundo.</strong>
    Em caso de a inadimplência implicar em necessidade de cobrança judicial dos
    valores ora acordados, a CONTRATANTE deve arcar, ainda, com as custas e
    despesas processuais, além de honorários advocatícios contratuais de 20%
    sobre o valor da causa, sem prejuízo dos honorários sucumbenciais.
</p>
<p align="justify">
    <strong>Parágrafo Terceiro</strong>
    . Na hipótese do atraso no pagamento de algum dos boletos acima persistir
    por mais de 10 (dez) dias após o seu respectivo vencimento, a CONTRATADA
    suspenderá imediatamente a prestação dos serviços, sem prejuízo da
    exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros. Caso, ainda assim, perdure o atraso até se atingir 30 (trinta)
    dias do vencimento do boleto, faculta-se à CONTRATADA, independentemente de
    notificação ou aviso, considerar rescindido o instrumento, implicando no
vencimento antecipado das demais parcelas vincendas, exigíveis    <em>incontinenti</em>, com o devido acréscimo dos encargos moratórios e
    multa da cláusula oitava deste instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA - DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Parágrafo Segundo.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DA INDEPENDÊNCIA DOS CONTRATANTES</strong>
</p>
<p align="justify">
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Parágrafo Único.</strong>
    Ademais, não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA – DA RESCISÃO E DAS PENALIDADES</strong>
</p>
<p align="justify">
    Caso quaisquer das partes der causa à rescisão, por descumprimento ou
    infração de suas obrigações, deverá indenizar a parte inocente por sua
    conduta violadora ou desidiosa, imputando-se à CONTRATADA, caso incorrer
    nestas hipóteses, reverter à CONTRATANTE 20% do valor total deste
    instrumento, o que poderá ocorrer mediante devolução de valores já pagos ou
    desconsideração de parcelas vincendas; ou na hipótese de tal conduta ser
    atribuível à CONTRATANTE, especialmente na infração ao disposto nas alíneas
    da Cláusula Quarta e Parágrafo Terceiro da Cláusula Quinta, também
    continuará obrigada ao valor total do preço ora consignado, com o acréscimo
    dos encargos moratórios e cláusula penal de 20% sobre o valor global deste
    contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA DÉCIMA - DO FORO</strong>
</p>
<p align="justify">
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    Brasília, {data}.
</p>
<p align="center">
    <strong>{</strong>
    <strong>assinatura</strong>
    <strong>} </strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>
<p align="left">
    <strong>Testemunhas:</strong>
</p>
<p align="left">
    <strong>________________________________</strong>
</p>
<p align="left">
    <strong>Nome</strong>
</p>
<p align="left">
    <strong>CPF</strong>
</p>
<p align="left">
    <strong>________________________________</strong>
</p>
<p align="left">
    <strong>Nome</strong>
</p>
<p align="left">
    <strong>CPF</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='minuta-gestao-scm');

------------------------------------------------------------------------------minuta-gestao-scm




UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS DE ENGENHARIA</strong>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>, com sede em C 01
    Lote 01/12 Sala 338, CEP: 72010-010 Edifício Taguatinga Trade Center –
    Taguatinga Centro - Brasília - DF, inscrita no CNPJ sob o
    n.º10.225.044/0001-73, neste ato representado por seus sócios Engenheiro
    Rodrigo Silva Oliveira, brasileiro, natural de Goiânia/GO, solteiro,
    nascido em 13 de Novembro de 1980, Empresário, portador do documento de
    identidade n.º 1.857.494 SSP-DF e do CPF n.º 701.815.431-68, residente em
    AV do Contorno Lote 02 AC. Rabelo Vila Planalto, Brasília / DF, CEP
    70803-210; e Engenheira Ana Paula de Lira Meira, brasileira, natural de
    Brasília/DF, casada, nascida em 16 de Abril de 1980, portador do documento
    de identidade n.º1.882.723 SSP-DF e do CPF n.º 883.079.721-91, residente na
    QNE 21 CASA 15 Taguatinga Norte, Brasília/DF, CEP 72125-210, adiante
designada apenas <strong>CONTRATADA</strong> e    <strong>{razao social}</strong>, situada no endereço {logradouro}
    nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado}, CEP: {cep}
    Inscrito no CNPJ Sob o nº {cnpj} neste ato representado por: {socios},
    doravante denominada CONTRATANTE, têm, entre si, justas e acertadas o
    presente Contrato de Prestação de Serviços de Engenharia, que se regerá
    pelas cláusulas e condições a seguir entabuladas:
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA - DA ADESÃO A ESTE INSTRUMENTO</strong>
</p>
<p align="justify">
    A adesão pelo CONTRATANTE ao presente Contrato efetiva-se alternativamente
    por meio de quaisquer dos seguintes eventos abaixo:
</p>
<p align="justify">
    a) Aceite verbal em negociação via telefone;
</p>
<p align="justify">
    b) Assinatura do CONTRATO;
</p>
<p align="justify">
    c) Preenchimento de cadastro e aceite “on-line”.
</p>
<p align="justify">
    d) Pagamento de boleto bancário ou depósito em Conta Corrente da
    CONTRATADA.
</p>
<p align="justify">
    e) Percepção, de qualquer forma, dos serviços objeto do presente Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DO OBJETO</strong>
</p>
<p align="justify">
    2.1. A CONTRATADA prestará serviços de Engenharia solicitados pela ANATEL,
    disponibilizando, para tanto, um Engenheiro de Telecomunicações para
    assinar pela empresa outorgada, sendo o mesmo responsável pelo envio dos
    relatórios SICI mensalmente. Impende ressaltar que o Engenheiro de
    Telecomunicações é uma determinação obrigatória pela ANATEL, conforme o
    art.9° da Resolução n°218 de 29/06/73 do CONFEA.
</p>
<p align="justify">
    2.2. O Responsável Técnico indicado pela CONTRATADA deverá recolher a
    Anotação de Responsabilidade Técnica referente aos serviços ora
    contratados, antes do início dos trabalhos e prestará serviços à
    CONTRATANTE com ampla, total, irrestrita autonomia, sem qualquer tipo de
    subordinação jurídica, hierárquica ou existência de vínculo empregatício.
</p>
<p align="justify">
    <strong>CLÁUSULA TERCEIRA – DA VIGÊNCIA </strong>
</p>
<p align="justify">
    3.1. O contrato perdurará pelo prazo inicial de 12 (doze) meses,
    renovando-se automaticamente por igual período subsequente, exceto se
    houver prévia comunicação, por escrito, no prazo de 30 (trinta) dias, do
    desejo de pôr termo ao contrato ao término de sua vigência.
</p>
<p align="justify">
    3.2. No entanto, o pacto também poderá ser rescindido nas hipóteses
    delineadas na Cláusula Oitava, com as consequências também delimitadas por
    aquela disposição, as quais ora são mutuamente aceitas e comprometidas.
</p>
<p align="left">
    <strong>CLÁUSULA QUARTA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    4.1. Os serviços a serem executados englobarão o registro da empresa no
    CREA para emissão da Certidão exigida pela Anatel, além da consecução da
    responsabilidade técnica exigida pela agência reguladora para atos e
    declarações a ela atinentes.
</p>
<p align="justify">
    4.2.<strong> </strong>As taxas referentes ao registro da empresa do CREA
    além de quaisquer outras taxas, impostos ou despesas administrativas
    inerentes à prestação de serviços ora entabulada, incutirão exclusivamente
    à CONTRATANTE.
</p>
<p align="justify">
    <strong>CLÁUSULA QUINTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    5.1. A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    5.2. Ademais, a CONTRATADA não se responsabilizará por inconsistência de
    informações prestadas pela CONTRATANTE, ficando pactuado que é de única,
    integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    5.3. Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    5.4. Ademais, também são deveres da CONTRATANTE:
</p>
<ol type="a">
    <li>
        <p align="justify">
            Fornecer à CONTRATADA todas as informações e documentos necessários
            para o bom andamento e cumprimento do objeto deste contrato, bem
            como uma procuração (datada e com firma reconhecida) para
            representá-la junto à Anatel;
        </p>
    </li>
    <li>
        <p align="justify">
            Alterar os documentos, quando necessário, de acordo com as
            indicações da CONTRATADA, para atender as exigências legais
            indispensáveis à obtenção do credenciamento.
        </p>
    </li>
    <li>
        <p align="justify">
            Entregar tempestivamente todos os documentos e informações exigidos
            para a conclusão do procedimento de outorga, sob pena de não o
            fazendo e tal omissão desencadear em prejuízo dos trabalhos ora
            avençados, arcar com as consequências legais e contratuais de sua
            desídia.
        </p>
    </li>
    <li>
        <p align="justify">
            A CONTRATANTE não poderá utilizar-se de qualquer formulário, modelo
            de contrato, modelo de carta, projeto, apresentação, panfleto ou
            qualquer documento criado e utilizado pela CONTRATADA, salvo com
            sua autorização prévia por escrito.
        </p>
    </li>
    <li>
        <p align="justify">
            Realizar o pagamento tempestivamente, conforme disposto na Cláusula
            Sexta deste contrato.
        </p>
    </li>
</ol>
<p align="justify">
    5.5. Fica a CONTRATANTE ciente que não há prazo determinado para respostas,
    ofícios ou procedimentos, uma vez que a análise dos documentos e a
    consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel).
</p>
<p align="justify">
    5.6. A CONTRATADA não se responsabilizará por qualquer prejuízo decorrente
    de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    5.7. As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA SEXTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
A consultoria possui custo total de R$    <strong>{valor_total_contrato}</strong> a ser pago pela CONTRATANTE à
    CONTRATADA, através de boletos bancários, conforme programação abaixo:
</p>
<p align="center">
    {tabela_parcelas}
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    Em caso de inadimplemento por parte do CONTRATANTE quanto ao pagamento do
    serviço prestado, deverá incidir sobre o valor do presente instrumento,
multa pecuniária de 2%, além de juros de mora de 1% ao mês, calculados    <em>pro rata die</em>, e correção monetária pelo Índice Geral de Preços de
    Mercado (IGP-M) da Fundação Getúlio Vargas.
</p>
<p align="justify">
    <strong>Parágrafo Segundo.</strong>
    Em caso de a inadimplência implicar em necessidade de cobrança judicial dos
    valores ora acordados, a CONTRATANTE deve arcar, ainda, com as custas e
    despesas processuais, além de honorários advocatícios contratuais de 20%
    sobre o valor da causa, sem prejuízo dos honorários sucumbenciais.
</p>
<p align="justify">
    <strong>Parágrafo Terceiro</strong>
    . Na hipótese do atraso no pagamento de algum dos boletos acima persistir
    por mais de 10 (dez) dias após o seu respectivo vencimento, a CONTRATADA
    suspenderá imediatamente a prestação dos serviços, sem prejuízo da
    exigibilidade dos encargos contratuais, ficando o seu restabelecimento
    condicionado ao pagamento do(s) valor(es) em atraso, acrescido (s) da multa
    e dos juros. Caso, ainda assim, perdure o atraso até se atingir 30 (trinta)
    dias do vencimento do boleto, faculta-se à CONTRATADA, independentemente de
    notificação ou aviso, considerar rescindido o instrumento, implicando no
vencimento antecipado das demais parcelas vincendas, exigíveis    <em>incontinenti</em>, com o devido acréscimo dos encargos moratórios e
    multa da cláusula oitava deste instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA - DA CONFIDENCIALIDADE DAS INFORMAÇÕES</strong>
</p>
<p align="justify">
    As Partes comprometem-se a não revelar as informações confidenciais a
    qualquer pessoa ou entidade, que não aquelas relacionadas à negociação, sem
    o prévio consentimento, por escrito, da parte Reveladora.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    Caso seja requerida a revelação das informações confidenciais por qualquer
    foro de jurisdição competente, lei, regulação, agência do governo,
    administração de ordem legal, desde que a Parte requerida a revelar forneça
    a outra parte aviso prévio de tal ordem ou requerimento, no prazo de 10
    (dez) dias, contados da notificação da entidade, permitindo a Parte
    Reveladora requerer medida cautelar ou outro recurso legal apropriado.
</p>
<p align="justify">
    <strong>Parágrafo Segundo.</strong>
    Para o propósito deste instrumento, o termo “informação confidencial”
    significa toda informação relevante relacionada às Partes ou a seus
    negócios e a operações, reveladas ou de qualquer outra maneira tornadas
    disponíveis pela Parte Reveladora à Parte Receptora, inclusive modelos de
    documentos.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DA INDEPENDÊNCIA DOS CONTRATANTES</strong>
</p>
<p align="justify">
    O presente contrato não estabelece entre as partes, de forma direta ou
    indireta, qualquer forma de sociedade, associação, relação de emprego ou
    responsabilidade solidária ou conjunta.
</p>
<p align="justify">
    <strong>Parágrafo Único.</strong>
    Ademais, não se estabelece por força do presente contrato, qualquer vinculo
    empregatício ou responsabilidade por parte da CONTRATADA ou da CONTRATANTE
    com relação aos empregados, prepostos ou terceiros das outras partes, que
    venham a ser envolvidos na prestação dos serviços objeto do presente
    Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA – DA RESCISÃO E DAS PENALIDADES</strong>
</p>
<p align="justify">
    Caso quaisquer das partes der causa à rescisão, por descumprimento ou
    infração de suas obrigações, deverá indenizar a parte inocente por sua
    conduta violadora ou desidiosa, imputando-se à CONTRATADA, caso incorrer
    nestas hipóteses, reverter à CONTRATANTE 20% do valor total deste
    instrumento, o que poderá ocorrer mediante devolução de valores já pagos ou
    desconsideração de parcelas vincendas; ou na hipótese de tal conduta ser
    atribuível à CONTRATANTE, especialmente na infração ao disposto nas alíneas
    da Cláusula Quarta e Parágrafo Terceiro da Cláusula Quinta, também
    continuará obrigada ao valor total do preço ora consignado, com o acréscimo
    dos encargos moratórios e cláusula penal de 20% sobre o valor global deste
    contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA DÉCIMA - DO FORO</strong>
</p>
<p align="justify">
    Para dirimir quaisquer controvérsias oriundas do contrato, as partes elegem
    o foro da comarca Brasília - DF, com renúncia expressa a qualquer outro por
    mais privilegiado que seja.
</p>
<p align="justify">
    Por estarem assim justos e contratadas, firmam o presente instrumento, em
    duas vias de igual teor, juntamente com 2 (duas) testemunhas.
</p>
<p align="left">
    Brasília, {data}.
</p>
<p align="center">
    <strong>{assinatura} </strong>
</p>
<p align="center">
    <strong>_____________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA</strong>
</p>
<p align="left">
    <strong>Testemunhas:</strong>
</p>
<p align="left">
    <strong>________________________________</strong>
</p>
<p align="left">
    <strong>Nome</strong>
</p>
<p align="left">
    <strong>CPF</strong>
</p>
<p align="left">
    <strong>________________________________</strong>
</p>
<p align="left">
    <strong>Nome</strong>
</p>
<p align="left">
    <strong>CPF</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='minuta-contratual-crea');

------------------------------------------------------------------------------minuta-contratual-crea






UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$<p align="center">
    <strong>CONTRATO DE PRESTAÇÃO DE SERVIÇOS </strong>
</p>
<p align="center">
    <strong>
        PARA CREDENCIMENTO E GESTÃO DE OBRIGAÇÕES SCM PERANTE A ANATEL
    </strong>
</p>
<p align="center">
    <u><strong>Pacote Flex </strong></u>
</p>
<p align="justify">
Pelo presente instrumento particular,    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME</strong>, empresa com
    sede em Brasília, no Central 1 Lt 1/12, sala 338, Taguatinga, CEP
    72.010-010, no Distrito Federal, inscrita no CNPJ sob o nº
    10.225.044/0001-73, e no Cadastro Estadual sob o nº 01882121.00-65, neste
    ato representado por <strong>Ana Paula Lira Meira</strong>, inscrita no CPF
    nº 883.079.721.91, Engenheira da Computação, casada, telefone nº 61
    3046-2406, adiante designada CONTRATADA e;
</p>
<p align="justify">
    <strong>{razao social}</strong>
    , situada no endereço {logradouro} nº{numero}, Bairro: {bairro} Cidade:
    {municipio}/{estado}, CEP: {cep} Inscrito no CNPJ Sob o nº {cnpj} neste ato
    representado por: {socios}, doravante denominada CONTRATANTE, declaram que,
    nesta data, ajustam entre si, de comum acordo e na melhor forma de direito,
    o presente Contrato de Prestação de Serviços de Consultoria Técnica para
    Credenciamento e Gestão de Obrigações SCM perante a Anatel, que será regido
    pela legislação vigente e pelas cláusulas e condições seguintes:
</p>
<p align="justify">
    As partes contratantes, após terem tido conhecimento prévio das
    especificidades da Proposta Comercial (que faz parte integrante deste
    contrato), do texto deste instrumento e compreendido o seu sentido e
    alcance, tem, justo e acordado, o presente contrato de prestação de
    serviços, descrito e caracterizado neste instrumento, ficando entendido que
    o presente negócio jurídico se regulará pelas cláusulas e condições a
    seguir alinhadas, bem como pelos serviços pormenorizados na Proposta,
    mutuamente aceitas e outorgadas.
</p>
<p align="justify">
    <strong>CLÁUSULA PRIMEIRA - DA ADESÃO A ESTE INSTRUMENTO</strong>
</p>
<p align="justify">
    A adesão pelo CONTRATANTE ao presente Contrato efetiva-se alternativamente
    por meio de quaisquer dos seguintes eventos abaixo:
</p>
<p align="justify">
    a) Aceite verbal em negociação via telefone;
</p>
<p align="justify">
    b) Assinatura do CONTRATO;
</p>
<p align="justify">
    c) Preenchimento de cadastro e aceite “on-line”.
</p>
<p align="justify">
    d) Pagamento de boleto bancário ou depósito em Conta Corrente da
    CONTRATADA.
</p>
<p align="justify">
    e) Percepção, de qualquer forma, dos serviços objeto do presente Contrato.
</p>
<p align="justify">
    <strong>CLÁUSULA SEGUNDA – DO OBJETO</strong>
</p>
<p align="justify">
    A CONTRATADA se compromete a prestar consultoria pós outorga com o objetivo
    de cumprir as exigências da Anatel após a obtenção de autorização para
    exploração do serviço de comunicação multimídia (SCM), visando à qualidade
    do serviço e desenvolvimento da contratante.
</p>
<p align="justify">
    <strong>
        CLÁUSULA TERCEIRA – DA VIGÊNCIA E DO PRAZO DE PERMANÊNCIA MÍNIMO
    </strong>
</p>
<p align="justify">
    O contrato perdurará pelo prazo inicial de 36 (trinta e seis) meses,
    renovando-se automaticamente por igual período subsequente, exceto se
    houver prévia comunicação, por escrito, no prazo de 30 (trinta) dias, do
    desejo de pôr termo ao contrato ao término de sua vigência.
</p>
<p align="justify">
    <strong>Parágrafo Primeiro.</strong>
    O início da prestação dos serviços ora entabulados se consubstanciará tão
    logo a CONTRATANTE proceder à assinatura, reconhecimento de firmas e
    remessa via correios deste instrumento à sede da CONTRATADA.
</p>
<p align="justify">
    <strong>Parágrafo Segundo. </strong>
    Mediante a assinatura neste instrumento, a CONTRATANTE se compromete a se
manter na base de clientes da CONTRATADA pelo período mínimo estipulado no    <em>caput</em> desta cláusula e, como contrapartida, recebe a isenção da
    assessoria para obtenção e manutenção do credenciamento perante a Anatel,
    que possui valor nominal avulso de R$2.500,00 (dois mil e quinhentos
    reais).
</p>
<p align="justify">
    <strong>Parágrafo Terceiro. </strong>
    Na eventualidade de a CONTRATANTE rescindir este instrumento antes de finda
    sua vigência, além da multa preconizada no item VII.I, deverá reembolsar à
    CONTRATADA todo o descontos que obteve em razão da fidelização.
</p>
<p>
    <strong>CLÁUSULA QUARTA – DA ESPECIFICAÇÃO DOS SERVIÇOS</strong>
</p>
<p align="justify">
    Os serviços a serem prestados pela CONTRATADA à CONTRATANTE corresponderão
    à escolha da última, a qual, após análise da Proposta Comercial e
confrontando-a com sua capacidade e necessidade, optou por contratar o    <u><strong>PACOTE FLEX</strong></u><strong> </strong>e conterá todos os
    serviços abaixo delineados:
</p>
<p align="justify">
    <strong>III.I</strong>
    – <strong>Representação junto à Anatel</strong>: a CONTRATADA representará
    a CONTRATANTE perante a Anatel, para prestar esclarecimentos e responder as
    dúvidas relacionadas à exploração do Serviço de Comunicação Multimídia
    (SCM), bem como acompanhará periodicamente a tramitação dos processos e,
    quando necessário, tomará as medidas para agilizar seu andamento, inclusive
    através de protocolos e ofícios.
</p>
<p align="justify">
    <strong>III.II</strong>
    – <strong>Entrevista Inicial: </strong>inquirição ao CONTRATANTE, para o
    fornecimento de informações e preenchimento de <em>check-list</em> de
    inclusão, para análise das respostas e orientações iniciais acerca do
    serviço.
</p>
<p align="justify">
    <strong>III.III</strong>
    – <strong>Sistema de Coleta de Informações (SICI);</strong> - As empresas
    prestadoras de serviços de telecomunicações no regime privado devem manter
    atualizado um banco de dados com informações referentes à prestação de
    serviços em suas respectivas áreas de atuação (Sistema de Coleta de
    Informações - SICI), cumprindo à CONTRATADA colaborar com o preenchimento
    periódico deste banco, evitando sanções por parte da ANATEL.
</p>
<p align="justify">
    <strong>III.IV</strong>
– <strong>Orientações sobre </strong>    <strong>Taxas e Contribuições (FUST/FUNTTEL/CONDENCINE): </strong>A
    CONTRATADA deverá verificar sobre quais serviços prestados pela CONTRATANTE
    deverão incidir contribuições, tais quais o Fundo de Universalização das
    Telecomunicações (Fust), o Fundo para o Desenvolvimento Tecnológico das
    Telecomunicações (Funttel) e a Condencine. Além disso, a CONTRATADA
    assessorará a CONTRATANTE, mensalmente, no procedimento de recolhimento do
    Fust, do Funttel e do Fundo de Fiscalização das Telecomunicações (Fistel),
    procedendo ao aviso de boletos em aberto perante a Anatel.
</p>
<p align="justify">
    <strong>III.V</strong>
    – <strong>Calendário de Eventos, cursos, fóruns e publicações:</strong>
    Cumprirá à CONTRATADA fornecer periodicamente à CONTRATANTE um informativo
    acerca dos eventos relacionados às telecomunicações e especialmente aos
    provedores, além de indicar revistas especializadas, com o escopo de
    propiciar o crescimento e solidificação do Provedor.
</p>
<p align="justify">
    <strong>III.VI – Inovação</strong>
    : serviço voltado a divulgar e a orientar a CONTRATANTE em novos processos
    e projetos na área de telecomunicações, objetivando o crescimento e
    desenvolvimento de sua empresa com soluções inovadoras, criativas e com
    alto valor agregado no mercado, englobando, também, a divulgação de Editais
    e Licitações vigentes para participação na área de Telecomunicações.
</p>
<p align="justify">
    <strong>III.VII – Organização de Documentos</strong>
    : Orientações sobre a necessidade de obtenção, guarda e exibição de
    documentos obrigatórios em caso de fiscalização da Anatel.
</p>
<p align="justify">
    <strong>III.VIII – Sistemas Interativos da Anatel</strong>
    : recomendações e direções sobre a utilização e registros no sistema FOCUS
    da Anatel.
</p>
<p align="justify">
    <strong>III.IX – Consultoria Jurídica Básica</strong>
    : elaboração de contratos SCM, Link Dedicado, Permanência e Termo de
    Adesão, atualização dos instrumentos de acordo com modificações
    legislativas ou normativas, orientações da rescisão dos contratos dos
    provedores com seus usuários finais, indicação das medidas jurídicas a
    serem tomadas em caso de procedimentos administrativos na Anatel e
    divulgação de informativos acerca de inovações regulatórias.
</p>
<p align="justify">
    <strong>III.X – Orientações Contábeis Básicas:</strong>
    Auxilio sobre requerimento e confecção da Nota Fiscal modelo 21, Indicação
    dos CNAE´s específico para licença e atividade de SCM e Indicação quanto à
    filiação sindical e o recolhimento das contribuições sindicais.
</p>
<p align="justify">
    <strong>III.XI -</strong>
    <strong>Auxilio Boletos com usuário final – </strong>
    A CONTRATADA auxiliará a CONTRATANTE na confecção dos boletos bancários a
    serem emitidos para adimplir a relação jurídica entre a prestadora de
    serviços de telecomunicações e seu usuário final, sempre em estrita
    obediência às exigências da Anatel.
</p>
<p align="justify">
    <strong>
        III.XII – Informativo de Situação Financeira perante a Anatel:
    </strong>
    A CONTRATADA divulgará o CONTRATANTE acerca de eventuais débitos em aberto
    na Anatel e o orientará quanto às condições de regularização.
</p>
<p align="justify">
    <strong>III.XIII – Cobrança do CONDENCINE:</strong>
    Auxílio na emissão do documento de cobrança do CONDENCINE.
</p>
<p align="justify">
    <strong>
        III.XIV – Informativo de Alterações Administrativas e/ou Técnicas:
    </strong>
    A CONTRATADA atualizará o CONTRATANTE acerca de novas exigências ou
    parâmetros da Anatel sobre questões técnicas e administrativas, se
    responsabilizando, também, por elaborar o ofício de comunicação à Agência
    quando sobrevier alteração no contrato social do cliente.
</p>
<p align="justify">
    <strong>III.XV - Auxilio</strong>
    <strong> inclusão ou retirada responsável técnico CREA</strong>
    Cumprirá à CONTRATADA guiar a CONTRATANTE nos procedimentos de inclusão,
    modificação ou retirada de responsáveis técnicos junto ao CREA e à Anatel.
</p>
<p align="justify">
    <strong>III.XVI - Cadastramento de POP junto a Anatel</strong>
    : Isenção do custo de projeto mediante o custeio das taxas administrativas
    (Anatel e CREA), limitado a um laudo mensal não acumulativo.
</p>
<p align="justify">
    <strong>III.XVII - Orientação Técnica em Licitação</strong>
    : Sugestões no âmbito exclusivamente técnico ao CONTRATANTE para norteá-lo
    na participação em Licitações de Serviços em Telecomunicações.
</p>
<p align="justify">
    <strong>III.XVIII - 30 Tickets de Call Center Transbordo:</strong>
    O CONTRATADO fará jus a 30 atendimentos de Call Center receptivo dentro do
    exercício mensal, exclusivamente para transbordo, não acumulativos nos
    meses posteriores.
</p>
<p align="justify">
    <u>Orientações Transbordo:</u>
</p>
<ol>
    <li>
        <p>
            O CONTRANTE deverá avisar com 24hrs de antecedência que será
            realizado o transbordo. Caso não seja avisada a transferência,
            poderão ocorrer filas no atendimento;
        </p>
    </li>
</ol>
<ol start="2">
    <li>
        <p>
            Ligações excedentes possuem o custo de R$ 10,00 (dez reais);
        </p>
    </li>
</ol>
<ol start="3">
    <li>
        <p align="justify">
            As ligações recebidas pela CONTRATANTE serão transferidas para a
            CONTRATADA, através de sistema voip (voz sobre ip), sendo de
            obrigação da contratante a disponibilização de um canal voip e uma
            conexão estável de pelo menos 256 kbps durante o fluxo das
            ligações;
        </p>
    </li>
</ol>
<ol start="4">
    <li>
        <p align="justify">
            <a name="page2"></a>
            A CONTRATADA não se responsabiliza por prejuízo em detrimento da má
            configuração ou má qualidade do equipamento da parte CONTRATANTE,
            bem como a infraestrutura utilizada. Caso necessário, a CONTRATADA
            poderá oferecer um equipamento adequado para os atendimentos, com
            um custo à parte.
        </p>
    </li>
</ol>
<ol start="5">
    <li>
        <p align="justify">
            O número de atendimento (sac) deve ser fornecido pela CONTRATANTE e
            colocado juntamente ao cadastro para que sejam feitos testes.
        </p>
    </li>
</ol>
<ol start="6">
    <li>
        <p align="justify">
            Este serviço não substitui as outras formas de atendimento e
            gerenciamento do atendimento da parte CONTRATANTE, o contrato em
            referência trata-se apenas do atendimento de primeiro nível,
            abertura de chamados.
        </p>
    </li>
</ol>
<ol start="7">
    <li>
        <p align="justify">
            A CONTRATANTE terá acesso ao sistema por login e senha exclusiva,
            limitado a 03 (três) usuários. O custo para usuários adicionais é
            de R$ 50,00 (cinquenta reais)
        </p>
    </li>
</ol>
<ol start="8">
    <li>
        <p align="justify">
            É obrigação da CONTRATANTE fechar os chamados abertos no sistema de
            gerenciamento da CONTRATADA com as tratativas realizadas.
        </p>
    </li>
</ol>
<p align="justify">
    <em>Parágrafo único.</em>
    Na hipótese de a CONTRATANTE, no curso do contrato entre as partes, desejar
    a obtenção da outorga para exploração do Serviço de Comunicação Multimídia,
    a CONTRATADA o fará sem qualquer custo adicional, desde que a CONTRATANTE
    esteja adimplente com todas suas responsabilidades ora avençadas.
</p>
<p align="justify">
    <strong>CLÁUSULA QUINTA – DAS OBRIGAÇÕES DAS PARTES</strong>
</p>
<p align="justify">
    IV.I - A CONTRATANTE se responsabiliza pelo envio periódico e tempestivo de
    todas as informações, documentos e dados necessários para a consecução dos
    serviços ora contratados, sob pena de, assim não o fazendo, assumir toda e
    qualquer responsabilidade decorrente desta omissão, desonerando, por
    conseguinte, completamente a CONTRATADA.
</p>
<p align="justify">
    IV.I.I - Ademais, a CONTRATADA não se responsabilizará por inconsistência
    de informações prestadas pela CONTRATANTE, especialmente as relacionadas ao
    faturamento e declarações ao FUST e ao FUNTTEL, ficando pactuado que é de
    única, integral e exclusiva responsabilidade da CONTRATANTE proceder com
    regularidade nas informações transmitidas à Anatel, sendo, por via oblíqua,
    vedado transferir tais obrigações à CONTRATADA.
</p>
<p align="justify">
    IV.II – Todas as taxas, impostos ou despesas referentes à execução dos
    serviços objeto deste instrumento correrão por conta exclusiva da
    CONTRATANTE, cumprindo à CONTRATADA, neste particular, a conferência da
    exatidão de tais incidências.
</p>
<p align="justify">
    IV.II.I - A CONTRATANTE arcará, ainda, com eventuais custas e despesas,
    tais quais transporte, hospedagem, alimentação, extração de fotocópias, de
    autenticações e envio de documentos, de expedição de certidões e quaisquer
    outras que decorrerem dos serviços ora contratados, mediante apresentação
    de demonstrativos analíticos pela CONTRATADA.
</p>
<p align="justify">
    IV.III - Fica a CONTRATANTE ciente que não há prazo determinado para
    respostas, ofícios ou procedimentos, uma vez que a análise dos documentos e
    a consequente expedição dos resultados são de responsabilidade exclusiva da
    Agência Nacional de Telecomunicações (Anatel).
</p>
<p align="justify">
    IV.IV - A CONTRATADA não se responsabilizará por qualquer prejuízo
    decorrente de falhas da CONTRATANTE relacionadas aos serviços objeto deste
    instrumento, seja por incorreta execução, entendimento equivocado,
    negligência, imperícia, imprudência ou quaisquer outros fatores, não
    podendo a CONTRATADA, por óbvio, sofrer quaisquer sanções ou prejuízos em
    virtude de tais ocorrências.
</p>
<p align="justify">
    IV.V – As PARTES são, individualmente, as únicas e exclusivas responsáveis
    por seus próprios profissionais, do ponto de vista técnico e trabalhista,
    garantindo suas competências e capacidades, inexistindo qualquer vínculo
    obrigacional além do ora convencionado.
</p>
<p align="justify">
    <strong>
        CLÁUSULA SEXTA - DO PREÇO, DA FORMA DE PAGAMENTO E DO REAJUSTE
    </strong>
</p>
<p align="justify">
    <a name="__DdeLink__716_421627098"></a>
    O pagamento referente ao instrumento ora firmado perfazerá a importância
    total de <strong>R$ {valor_total_contrato}</strong>, eis que a CONTRATANTE
    aderiu ao <u><strong>Plano Flex</strong></u>, pelo período estipulado na
    cláusula segunda desta avença, o qual, por mera liberalidade da CONTRATADA,
será adimplido mediante    <strong>{num_parcelas} prestações de R$ {prestacao}</strong> cada uma,
vencendo a primeira parcela no dia    <u><strong>{dia_primeira_parcela}</strong></u> e as demais no mesmo dia dos
    meses subsequentes.
</p>
<p align="justify">
    <strong>Parágrafo primeiro.</strong>
    No ato de assinatura deste instrumento, a CONTRATADA providenciará o envio
    dos respectivos boletos bancários à sede da CONTRATANTE, via e-mail e
    correios.
</p>
<p align="justify">
    <strong>Parágrafo segundo.</strong>
    Em caso de atraso no adimplemento das parcelas mensais, além de facultada a
    interrupção na prestação do serviço, incidirá multa moratória no importe de
    5% (cinco por cento) sobre o valor em aberto, além de juros legais
    calculados <em>pro rata die</em> e correção monetária pelo IGP-M, ou por
    outro índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>Parágrafo terceiro. </strong>
    Os valores pactuados no <em>caput</em> desta cláusula, na hipótese de
    renovação contratual, sofrerão reajuste anual pelo IGP-M, ou por outro
    índice que eventualmente vier a substituí-lo.
</p>
<p align="justify">
    <strong>CLÁUSULA SÉTIMA – </strong>
    <strong>DA CONFIDENCIALIDADE</strong>
</p>
<p align="justify">
    VI.I. Os serviços e as informações técnicas específicas utilizadas na
    consecução dos serviços prestados pela empresa CONTRATADA deverão ser
    utilizados única e exclusivamente para o fim ora estabelecido, motivo pelo
    qual a CONTRATADA se compromete expressamente, através do presente, a tomar
    todas as precauções necessárias para salvaguardar o sigilo das mesmas, bem
    como evitar e prevenir revelação a terceiros, não podendo utilizá-las para
    outros projetos que por ventura esteja desenvolvendo, exceto se devidamente
    autorizado por escrito pela CONTRATANTE.
</p>
<p align="justify">
    <strong>Parágrafo único.</strong>
    As informações técnicas que não poderão ser passadas pela CONTRATADA serão
    aquelas consideradas sigilosas, ou seja, que não estejam protegidas através
    de concessão de patente.
</p>
<p align="justify">
    VI.II. Outrossim, a CONTRATADA obriga-se, expressamente, por qualquer
    motivo ou razão, a não utilizar, divulgar, propagar, reproduzir, explorar,
    publicar, duplicar, transferir ou revelar, direta ou indiretamente, por si
    ou através de terceiros, quaisquer destas informações.
</p>
<p align="justify">
    VI.III. A violação da presente Cláusula de Confidencialidade, pelo uso
    indevido de qualquer informação, sem a devida autorização, causará à
    CONTRATANTE danos e prejuízos irreparáveis. Porquanto, uma vez lesada a
    CONTRATANTE, desde que legítima detentora do direito a tais informações,
    poderá tomar todas as medidas judiciais e extrajudiciais, inclusive de
    caráter cautelar ou de antecipação de tutela jurisdicional, que julgar
    cabíveis à defesa de seus direitos, inclusive perdas e danos.
</p>
<p align="justify">
    <strong>CLÁUSULA OITAVA – DA RESCISÃO</strong>
</p>
<p align="justify">
    VII.I - O presente instrumento será rescindido pelo término de seu prazo de
    vigência e desinteresse das partes pela prorrogação, bem como caso uma das
    partes descumpra o estabelecido em qualquer uma das cláusulas deste
    contrato, aplicando-se multa de 20% (vinte por cento) sobre o valor
    restante do contrato à parte que originou o descumprimento, com vencimento
    para 5 (cinco) dias úteis após a ocorrência.
</p>
<p align="justify">
    VII.II – Conforme avençado alhures, uma vez que a CONTRATADA rescinda o
    presente pacto antes de transcorrido integralmente o prazo de 36 (trinta e
    seis) meses, também deverá ressarcir a CONTRATANTE na exata quantia da
    isenção que obteve em função da contratação nesta modalidade, qual seja, de
    R$2.500,00 (dois mil e quinhentos reais), nos moldes do previsto no
    parágrafo segundo da cláusula segunda desta avença.
</p>
<p align="justify">
    VII.III - Na hipótese de a CONTRATANTE incorrer em atrasos no adimplemento
    de alguma das parcelas, além das penalidades previstas no Parágrafo Segundo
    da Cláusula Quinta, persistindo a mora da CONTRATANTE após 30 (trinta) dias
    do vencimento de alguma das parcelas, os serviços serão imediatamente
    suspensos, respondendo a CONTRATANTE junto aos órgãos os quais a CONTRATADA
    atua pela desídia ou falta de continuidade nos serviços até então
    prestados, além de incidir, a título de cláusula penal, indenização à
    CONTRATADA na quantia correspondente a uma prestação mensal ora ajustada.
</p>
<p align="justify">
    VII.IV - Em qualquer hipótese rescisória, salvo em caso de mora da
    CONTRATANTE, a parte que a desejar deve comunicar a outra por escrito, e
    com antecedência mínima de 30 (trinta) dias em relação ao vencimento do
    próximo boleto bancário, permanecendo o cumprimento do contrato pelos 30
    (trinta) dias posteriores à comunicação, quando se formalizará o
    encerramento do contrato, por intermédio de Distrato.
</p>
<p align="justify">
    <strong>CLÁUSULA NONA – DAS DISPOSIÇÕES GERAIS</strong>
</p>
<p align="justify">
    VIII.I - Declaram as PARTES que tiveram ampla liberdade quanto à presente
    contratação, a qual foi feita em estrita observância aos limites do
    respectivo fim econômico ou social, pela boa-fé e/ou pelos bons costumes,
    levando em consideração inclusive que não estão em situação de premente
    necessidade e têm plenas condições de cumprir todas as cláusulas e
    condições que constituem seus direitos e obrigações constantes no presente
    instrumento.
</p>
<p align="justify">
    VIII.II - Todos os termos e condições desta avença vinculam as PARTES bem
    como seus sucessores a qualquer título. Dessa forma, as PARTES se
    comprometem a cientificar eventuais sucessores acerca desse instrumento e
    da obrigatoriedade de sua execução.
</p>
<p align="justify">
    VIII.III - As disposições deste instrumento somente poderão ser alteradas
    mediante acordo escrito entre as partes, através de termos aditivos que
    farão parte integrante do contrato, ficando, desde já, consignado que atos
    de tolerância não configurarão novação contratual.
</p>
<p align="justify">
    VIII.IV - A CONTRATADA poderá alterar, modificar ou aditar o presente
    instrumento, unilateralmente, inclusive no que diz respeito às condições
    dos serviços, através de meros comunicados/aditivos, sempre com o objetivo
    de aprimorá-lo e/ou adequá-lo a novas disposições normativas, as quais se
    afigurem essenciais para a continuidade da prestação de serviços.
</p>
<p align="justify">
    VIII.IV.I – Considerando que a prestação dos serviços ora celebrada deve
    sempre estar em consonância com as respectivas normas legais vigentes,
    advindo sua alteração, caberá contratante adaptar-se à eventuais mudanças
    legais/resolutórias, que acarretarão em exclusão ou acréscimo de itens ao
    presente contrato.
</p>
<p align="justify">
    VIII.V - As PARTES reconhecem o correio eletrônico como meio válido, eficaz
    e suficiente de quaisquer comunicações ou avisos concernentes ao presente
    instrumento.
</p>
<p align="justify">
    <strong>CLÁUSULA DÉCIMA – DO FORO</strong>
</p>
<p align="justify">
    As partes elegem o foro da Comarca de Brasília/DF para dirimir quaisquer
    controvérsias oriundas do presente pacto, em detrimento de qualquer outro,
    por mais especial ou privilegiado que seja.
</p>
<p align="justify">
    E por estarem justos e acertados, assinam, na presença das testemunhas
    abaixo qualificadas, que a tudo assistem e apostam suas firmas, o presente
    Contrato em duas vias de igual teor e valor, para que o mesmo surte seus
    efeitos legais a partir da presente data.
</p>
<p align="justify">
    <a name="_GoBack"></a>
    Brasília, {data}.
</p>
<p align="center">
    <strong>{assinatura}</strong>
</p>
<p align="center">
    <strong>CONTRATANTE</strong>
</p>
<p align="center">
    <strong>_______________________________________________________</strong>
</p>
<p align="center">
    <strong>SCM ENGENHARIA DE TELECOMUNICAÇÕES LTDA - ME </strong>
</p>
<p align="center">
    <strong>CONTRATADA</strong>
</p>
<p align="justify">
    <strong>1</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>
<p align="justify">
    <strong>2</strong>
    <sup><u><strong>a</strong></u></sup>
    <strong> Testemunha</strong>
</p>$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='flex-scm-fidelidade');

------------------------------------------------------------------------------flex-scm-fidelidade





UPDATE comercial.tab_modelo_contrato
   SET 
    txt_modelo=$$$$
 WHERE 
cod_contrato_tipo_contrato_fk=
(SELECT cod_atributos_valores
  FROM public.tab_atributos_valores where sgl_valor='pos-outorga-light-scm');

------------------------------------------------------------------------------pos-outorga-light-scm

