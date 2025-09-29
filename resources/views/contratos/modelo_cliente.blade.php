<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1, h2, h3 { margin: 0 0 8px; }
        .header { text-align: center; margin-bottom: 16px; }
        .section { margin-bottom: 16px; }
        .muted { color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f2f2f2; text-align: left; }
        .small { font-size: 11px; }
    </style>
    <title>Contrato - {{ $projeto->nome }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
    <div class="header">
        <h1>Contrato de Prestação de Serviços</h1>
        <div class="muted">Projeto: {{ $projeto->nome }} ({{ $projeto->codigo ?? 'N/D' }})</div>
        <div class="muted">Data: {{ now()->format('d/m/Y') }}</div>
    </div>

    <div class="section">
        <h2>Dados do Contratante (Cliente)</h2>
        <p>
            <strong>Nome:</strong> {{ $cliente->nome }}<br>
            <strong>Documento:</strong> {{ $cliente->documento }}<br>
            <strong>E-mail:</strong> {{ $cliente->email }}<br>
            <strong>Telefone:</strong> {{ $cliente->telefone }}<br>
            @if(optional($cliente->endereco)->logradouro)
                <strong>Endereço:</strong>
                {{ $cliente->endereco->logradouro }}, {{ $cliente->endereco->numero }} -
                {{ $cliente->endereco->bairro }} -
                {{ $cliente->endereco->cidade }}/{{ $cliente->endereco->estado }} -
                CEP {{ $cliente->endereco->cep }}
            @endif
        </p>
    </div>

    <div class="section">
        <h2>Objeto do Contrato</h2>
        <p class="small">O presente instrumento tem por objeto a execução do projeto identificado acima, conforme itens e condições abaixo descritos.</p>
    </div>

    <div class="section">
        <h3>Itens do Projeto</h3>
        @if($itens->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 45%">Descrição</th>
                        <th style="width: 10%">Qtd</th>
                        <th style="width: 15%">Unidade</th>
                        <th style="width: 15%">Preço Orcado</th>
                        <th style="width: 15%">Preço Real</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itens as $item)
                        <tr>
                            <td>
                                {{ $item->descricao }}
                                @if($item->observacao)
                                    <div class="small muted">{{ $item->observacao }}</div>
                                @endif
                            </td>
                            <td>{{ number_format($item->quantidade, 3, ',', '.') }}</td>
                            <td>{{ optional($item->unidade)->sigla ?? optional($item->unidade)->nome ?? '-' }}</td>
                            <td>R$ {{ $item->preco_orcado ? number_format($item->preco_orcado, 2, ',', '.') : '-' }}</td>
                            <td>R$ {{ $item->preco_real ? number_format($item->preco_real, 2, ',', '.') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="muted">Sem itens cadastrados no projeto.</p>
        @endif
    </div>

    <div class="section">
        <h3>Condições Gerais</h3>
        <p class="small">
            Aqui você pode inserir suas cláusulas padrão (prazos, garantia, responsabilidades, pagamentos, rescisão, foro etc.).
            Este é um modelo inicial; podemos substituir por um layout específico a partir de um .docx que você enviar.
        </p>
    </div>

    <div class="section">
        <table style="border:0">
            <tr>
                <td style="border:0; width:50%; text-align:center; padding-top:40px">
                    ________________________________<br>
                    Contratante: {{ $cliente->nome }}
                </td>
                <td style="border:0; width:50%; text-align:center; padding-top:40px">
                    ________________________________<br>
                    Contratada: {{ config('app.name') }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
