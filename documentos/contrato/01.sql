
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
  FROM public.tab_atributos_valores where sgl_valor='spda')


