UPDATE public.tab_atributos_valores
   SET dsc_descricao='PORTES'
 WHERE sgl_valor='PT';


INSERT INTO public.tab_atributos(
            dsc_descricao, sgl_chave)
    VALUES ('Estado civil', 'estado-civil');


INSERT INTO public.tab_atributos_valores(
             fk_atributos_valores_atributos_id, sgl_valor, 
            dsc_descricao)
    VALUES ( (select cod_atributos from public.tab_atributos where sgl_chave='estado-civil'), 'S', 'Solteiro'),
	( (select cod_atributos from public.tab_atributos where sgl_chave='estado-civil'), 'C', 'Casado'),
     ( (select cod_atributos from public.tab_atributos where sgl_chave='estado-civil'), 'P', 'Separado'),
     ( (select cod_atributos from public.tab_atributos where sgl_chave='estado-civil'), 'D', 'Sivorciado'),
     ( (select cod_atributos from public.tab_atributos where sgl_chave='estado-civil'), 'V', 'Viúvo');



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
designada apenas <strong>CONTRATADA</strong> e    <strong>{razao social}</strong>, situada no endereço {logradouro}
    nº{numero}, Bairro: {bairro} Cidade: {municipio}/{estado}, CEP: {cep}
Inscrito no CNPJ Sob o nº {cnpj} neste ato representado por: {    <strong>representate_comercial</strong>}, {nacionalidade}, {estado_civil},
    {profissao}, RG nº {rg} SSP/{ssp} CPF nº {cpj} Residente e {logradouro_f}
    nº{numero_r}, Bairro: {bairro_r} Cidade: {municipio_r}/{estado_r}, CEP:
{cep_r}, Fone: {telefone} e EMAIL    <a href="mailto:ademir_aas@yahoo.com.br">{</a>email}, doravante denominada
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
<p align="center">
    {tabela_parcelas}
</p>
<dl>
    <dd>
        <table width="527" cellpadding="7" border='1' cellspacing="0">
            <colgroup>
                <col width="25"/>
                <col width="75"/>
                <col width="200"/>
                <col width="171"/>
            </colgroup>
            <tbody>
                <tr valign="top">
                    <td width="25">
                        <p align="justify">
                            Nº
                        </p>
                    </td>
                    <td width="75">
                        <p align="justify">
                            Valor
                        </p>
                    </td>
                    <td width="200">
                        <p align="justify">
                            Descrição
                        </p>
                    </td>
                    <td width="171">
                        <p align="justify">
                            Data de Vencimento
                        </p>
                    </td>
                </tr>
                <tr valign="top">
                    <td width="25">
                        <p align="justify">
                            01
                        </p>
                    </td>
                    <td width="75">
                        <p align="justify">
                            R$ 200,00
                        </p>
                    </td>
                    <td width="200">
                        <p align="justify">
                            (Duzentos reais)
                        </p>
                    </td>
                    <td width="171">
                        <p align="left">
                            28 de Fevereiro de 2015
                        </p>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </dd>
</dl>
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
</p>
<p align="center">
    <strong>_______________________________________________</strong>
</p>
<p align="center">
    <strong>{razao_social}</strong>
    <strong> </strong>
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
  FROM public.tab_atributos_valores where sgl_valor='minuta')
