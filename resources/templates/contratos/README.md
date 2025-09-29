Coloque aqui o template DOCX oficial do contrato do cliente.

Arquivo sugerido: contrato_cliente.docx

Placeholders suportados:
- ${CLIENTE_NOME}
- ${CLIENTE_DOCUMENTO}
- ${CLIENTE_EMAIL}
- ${CLIENTE_TELEFONE}
- ${CLIENTE_ENDERECO}

- ${PROJETO_NOME}
- ${PROJETO_CODIGO}
- ${PROJETO_DATA}
- ${PROJETO_DATA_INICIO}
- ${PROJETO_DATA_ENTREGA_PREVISTA}

Itens (defina uma linha com estes placeholders para a tabela e o sistema clona para cada item):
- ${ITEM_DESCRICAO}
- ${ITEM_QTD}
- ${ITEM_UNIDADE}
- ${ITEM_PRECO_ORCADO}
- ${ITEM_PRECO_REAL}

Dicas:
- Use uma tabela com a linha dos placeholders acima. O sistema usa cloneRow para repetir a linha por item.
- Para logo da empresa, podemos usar ${EMPRESA_LOGO} como imagem (setImageValue) quando disponível.
