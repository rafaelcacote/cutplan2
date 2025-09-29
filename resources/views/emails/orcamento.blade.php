<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orçamento {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            text-align: center;
            padding: 15px;
            background: #e3f2fd;
            border-radius: 8px;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }
        .info-value {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin-top: 5px;
        }
        .total-highlight {
            background: #e8f5e8 !important;
            color: #2e7d32 !important;
        }
        .message-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 15px 10px;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Orçamento #{{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}</h1>
        <p>{{ config('app.name') }}</p>
    </div>

    <div class="content">
        <div class="card">
            <h2>Olá, {{ $orcamento->cliente->nome }}!</h2>
            
            <p>Segue anexo o orçamento solicitado. Confira os detalhes abaixo:</p>

            @if(isset($customMessage) && !empty($customMessage))
                <div class="message-box">
                    <strong>Mensagem personalizada:</strong>
                    <p>{{ $customMessage }}</p>
                </div>
            @endif

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Data</div>
                    <div class="info-value">{{ $orcamento->created_at->format('d/m/Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Validade</div>
                    <div class="info-value">
                        @if($orcamento->validade)
                            {{ $orcamento->validade->format('d/m/Y') }}
                        @else
                            30 dias
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Itens</div>
                    <div class="info-value">{{ $orcamento->itens->count() }}</div>
                </div>
                <div class="info-item total-highlight">
                    <div class="info-label">Valor Total</div>
                    <div class="info-value">R$ {{ number_format($orcamento->total, 2, ',', '.') }}</div>
                </div>
            </div>

            @if($orcamento->desconto > 0)
                <p style="text-align: center; color: #d32f2f;">
                    <strong>Desconto aplicado: R$ {{ number_format($orcamento->desconto, 2, ',', '.') }}</strong>
                </p>
            @endif

            @if($orcamento->observacoes)
                <div class="message-box">
                    <strong>Observações:</strong>
                    <p>{{ $orcamento->observacoes }}</p>
                </div>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('orcamentos.public', $orcamento->uuid) }}" class="btn">
                    📱 Visualizar Online
                </a>
                <p style="color: #666; font-size: 14px; margin-top: 10px;">
                    Clique no link acima para visualizar o orçamento completo no seu navegador
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Este email foi enviado automaticamente. Por favor, não responda.</p>
            <p>Para dúvidas ou aprovação do orçamento, entre em contato conosco.</p>
        </div>
    </div>
</body>
</html>