<html>
<head>
    <title>Relatório</title>
</head>
<body>
    <h1>Relatório</h1>
    
    {{-- Exiba os dados aqui --}}
    <div id="dados-container">
        <!-- Os dados serão exibidos aqui -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function carregarDados(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    exibirDados(data);
                },
                error: function (error) {
                    console.error('Erro ao carregar dados:', error);
                }
            });
        }

        function exibirDados(response) {
        var container = $('#dados-container');
        container.empty();

        // Verifique se a resposta contém a propriedade "Data Points"
        if (response.hasOwnProperty('Data Points')) {
            var dados = response['Data Points'];

            // Certifique-se de que dados é uma matriz antes de usar forEach
            if (Array.isArray(dados) && dados.length > 0) {
                // Vamos assumir que os dados contêm um objeto com a propriedade "fitValue"
                var fitValue = dados[0]['fitValue'];

                // Certifique-se de que fitValue é uma matriz antes de usar forEach
                if (Array.isArray(fitValue) && fitValue.length > 0) {
                    // Vamos assumir que fitValue contém um objeto com a propriedade "value"
                    var value = fitValue[0]['value'];

                    // Certifique-se de que value é definido antes de acessar suas propriedades
                    if (value) {
                        container.append('<p>Peso: ' + value['fpVal'] + '</p>');
                    } else {
                        console.error('A propriedade "value" é indefinida.', fitValue);
                    }
                } else {
                    console.error('A propriedade "fitValue" não é uma matriz ou está vazia.', dados);
                }
            } else {
                console.error('Os "Data Points" não são uma matriz ou estão vazios.', response);
            }
        } else {
            console.error('A resposta não contém a propriedade "Data Points".', response);
        }
    }


        // Carregue os dados inicialmente
        carregarDados('/relatorioPeso');

        // Atualize os dados a cada 5 segundos (ajuste conforme necessário)
        setInterval(function () {
            carregarDados('/relatorioPeso');
        }, 5000);
        
    </script>
</body>
</html>