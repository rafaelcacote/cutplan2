<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Componente Endereço</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <h1>Teste do Componente de Endereço</h1>
        
        <form>
            <x-endereco-form 
                :estados="[]" 
                :municipios="[]" 
                title="Endereço de Teste"
                prefix="endereco"
                :required="true"
            />
        </form>
    </div>
    
    @stack('scripts')
</body>
</html>