<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            position: relative;
        }

        .header-top {
            display: table;
            width: 100%;
            padding: 15px 0;
        }

        .header-left {
            display: table-cell;
            width: 40%;
            vertical-align: middle;
        }

        .header-right {
            display: table-cell;
            width: 60%;
            vertical-align: middle;
            text-align: right;
            padding-right: 20px;
        }

        .logo-placeholder {
            width: 150px;
            height: 60px;
            border: 2px dashed #2E5BBA;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2E5BBA;
            font-size: 10px;
            text-align: center;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .header-date {
            font-size: 14px;
            color: #2E5BBA;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .blue-bar {
            background: linear-gradient(90deg, #2E5BBA 0%, #4A90E2 100%);
            height: 35px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-top: 10px;
            text-align: center;
        }

        .orcamento-title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
            width: 100%;
            margin: 0 auto;
        }

        .cliente-section {
            margin: 25px 0;
            padding: 0;
        }

        .cliente-info {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cliente-title {
            color: #2E5BBA;
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 15px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #2E5BBA;
            padding-bottom: 8px;
        }

        .cliente-content {
            font-size: 11px;
            line-height: 1.6;
            color: #333;
        }

        .cliente-content .client-name {
            font-weight: bold;
            color: #2E5BBA;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .cliente-content .info-line {
            margin: 4px 0;
            display: block;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-row {
            display: table-row;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }

        .info-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            height: 80px;
        }

        .info-box h3 {
            margin: 0 0 8px 0;
            color: #007bff;
            font-size: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }

        .info-box p {
            margin: 2px 0;
            font-size: 10px;
            line-height: 1.2;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-row {
            display: table-row;
        }

        .info-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 5px;
        }

        .info-box {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            height: 80px;
        }

        .info-box h3 {
            margin: 0 0 8px 0;
            color: #007bff;
            font-size: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }

        .info-box p {
            margin: 2px 0;
            font-size: 10px;
            line-height: 1.2;
        }

        .empresa-cliente-section {
            display: none;
        }

        .info-grid {
            display: none;
        }

        .info-row {
            display: none;
        }

        .info-col {
            display: none;
        }

        .info-box {
            display: none;
        }

        .info-box h3 {
            display: none;
        }

        .info-box p {
            display: none;
        }

        .empresa-col,
        .cliente-col {
            display: none;
        }

        .empresa-info,
        .cliente-info {
            display: none;
        }

        .info-title {
            display: none;
        }

        .info-content {
            display: none;
        }

        .info-content .company-name,
        .info-content .client-name {
            display: none;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            background-color: #2E5BBA;
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            border: 1px solid #2E5BBA;
        }

        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        .servico-cell {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            width: 20%;
            border-right: 1px solid #ddd;
        }

        .descricao-cell {
            width: 60%;
            padding: 8px 12px;
        }

        .valor-cell {
            width: 20%;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
            background-color: #f8f9fa;
        }

        .descricao-cell ul {
            margin: 0;
            padding-left: 15px;
        }

        .descricao-cell li {
            margin-bottom: 3px;
            font-size: 11px;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .total-row.final {
            font-weight: bold;
            font-size: 14px;
            border-bottom: 2px solid #2E5BBA;
            color: #2E5BBA;
        }

        .observacoes {
            margin-top: 40px;
            clear: both;
        }

        .observacoes h3 {
            color: #2E5BBA;
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-top">
            <div class="header-left">
                <div class="logo-placeholder">
                    LOGO DA EMPRESA<br>
                    <small>(150x60px)</small>
                </div>
            </div>
            <div class="header-right">
                <div class="header-date">Data: {{ $orcamento->created_at->format('d/m/Y') }}</div>
                @if ($orcamento->validade)
                    <div style="font-size: 12px; color: #666;">Validade: {{ $orcamento->validade->format('d/m/Y') }}
                    </div>
                @endif
                <div style="font-size: 12px; color: #666; margin-top: 5px;">Status: {{ $orcamento->status_label }}</div>
            </div>
        </div>
        <div class="blue-bar">
            <div class="orcamento-title">ORÇAMENTO</div>
        </div>
    </div>

    <div class="cliente-section">
        <div class="cliente-info">
            <div class="cliente-title">Dados do Cliente</div>
            <div class="cliente-content">
                <span class="client-name">{{ $orcamento->cliente->nome }}</span>

                @if ($orcamento->cliente->documento)
                    <span class="info-line"><strong>Documento:</strong> {{ $orcamento->cliente->documento }}</span>
                @endif

                @if ($orcamento->cliente->endereco)
                    <span class="info-line">
                        <strong>Endereço:</strong>
                        {{ $orcamento->cliente->endereco->logradouro }}, {{ $orcamento->cliente->endereco->numero }}
                        @if ($orcamento->cliente->endereco->complemento)
                            - {{ $orcamento->cliente->endereco->complemento }}
                        @endif
                    </span>
                    <span class="info-line">
                        <strong>Cidade:</strong>
                        {{ $orcamento->cliente->endereco->municipio->nome }} -
                        {{ $orcamento->cliente->endereco->municipio->estado->uf }}
                        - CEP: {{ $orcamento->cliente->endereco->cep }}
                    </span>
                @endif

                @if ($orcamento->cliente->telefone)
                    <span class="info-line"><strong>Telefone:</strong> {{ $orcamento->cliente->telefone }}</span>
                @endif

                @if ($orcamento->cliente->email)
                    <span class="info-line"><strong>Email:</strong> {{ $orcamento->cliente->email }}</span>
                @endif
            </div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>SERVIÇO</th>
                <th>DESCRIÇÃO</th>
                <th>VALOR</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Agrupar itens por serviço
                $itensAgrupados = [];
                foreach ($orcamento->itens as $item) {
                    if ($item->item_servico_id && strpos($item->descricao, ' - ') !== false) {
                        // Item de serviço
                        $partes = explode(' - ', $item->descricao, 2);
                        $nomeServico = $partes[0];
                        $nomeItem = $partes[1];

                        if (!isset($itensAgrupados[$nomeServico])) {
                            $itensAgrupados[$nomeServico] = [
                                'itens' => [],
                                'valor_total' => 0,
                            ];
                        }

                        $itensAgrupados[$nomeServico]['itens'][] = $nomeItem;
                        $itensAgrupados[$nomeServico]['valor_total'] += $item->quantidade * $item->preco_unitario;
                    } else {
                        // Item manual
                        $nomeServico = 'Outros Serviços';
                        if (!isset($itensAgrupados[$nomeServico])) {
                            $itensAgrupados[$nomeServico] = [
                                'itens' => [],
                                'valor_total' => 0,
                            ];
                        }

                        $itensAgrupados[$nomeServico]['itens'][] = $item->descricao;
                        $itensAgrupados[$nomeServico]['valor_total'] += $item->quantidade * $item->preco_unitario;
                    }
                }
            @endphp

            @foreach ($itensAgrupados as $nomeServico => $dadosServico)
                <tr>
                    <td class="servico-cell">{{ $nomeServico }}</td>
                    <td class="descricao-cell">
                        <ul>
                            @foreach ($dadosServico['itens'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="valor-cell">R$ {{ number_format($dadosServico['valor_total'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>R$ {{ number_format($orcamento->subtotal, 2, ',', '.') }}</span>
        </div>
        @if ($orcamento->desconto > 0)
            <div class="total-row">
                <span>Desconto:</span>
                <span>- R$ {{ number_format($orcamento->desconto, 2, ',', '.') }}</span>
            </div>
        @endif
        <div class="total-row final">
            <span>TOTAL:</span>
            <span>R$ {{ number_format($orcamento->total, 2, ',', '.') }}</span>
        </div>
    </div>

    @if ($orcamento->observacoes)
        <div class="observacoes">
            <h3>OBSERVAÇÕES:</h3>
            <p>{{ $orcamento->observacoes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Este orçamento foi gerado em {{ now()->format('d/m/Y H:i') }}</p>
        <p>Orçamento válido conforme condições apresentadas</p>
    </div>
</body>

</html>
