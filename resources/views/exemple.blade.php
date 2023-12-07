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
        var caloriesExpendedData = [];
        var weightData = [];
        var heartMinutesData = [];
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

        var stepsCountData = [];


function exibirDados(response) {
    var container = $('#dados-container');
    container.empty();

    // Itera sobre cada tipo de dado (steps_count, calories_expended, weight, heart_minutes)
    for (var dataType in response) {
        if (response.hasOwnProperty(dataType)) {
            var dataPoints = response[dataType];

            // Verifica se dataPoints é uma matriz e não está vazio
            if (Array.isArray(dataPoints) && dataPoints.length > 0) {
                // Itera sobre cada ponto de dados
                dataPoints.forEach(function (dataPoint) {
                    // Verifica se as propriedades essenciais estão presentes
                    if (dataPoint.hasOwnProperty('value') && dataPoint.hasOwnProperty('startTime') && dataPoint.hasOwnProperty('endTime')) {
                        // Adapte conforme necessário, dependendo da estrutura específica de cada tipo de dado
                        var value = dataPoint['value'];
                        var startTime = dataPoint['startTime'];
                        var endTime = dataPoint['endTime'];

                        // Adiciona os dados ao array apropriado
                        switch (dataType) {
                            case 'steps_count':
                                stepsCountData.push({ value: value, startTime: startTime, endTime: endTime });
                                break;
                            case 'calories_expended':
                                caloriesExpendedData.push({ value: value, startTime: startTime, endTime: endTime });
                                break;
                            case 'weight':
                                weightData.push({ value: value, startTime: startTime, endTime: endTime });
                                break;
                            case 'heart_minutes':
                                heartMinutesData.push({ value: value, startTime: startTime, endTime: endTime });
                                break;
                            default:
                                console.error('Tipo de dado desconhecido:', dataType);
                        }

                        
                    } else {
                        console.error('Ponto de dados inválido para ' + dataType + ':', dataPoint);
                    }
                });
            } else {
                console.error('Os dados para ' + dataType + ' não são uma matriz ou estão vazios.', response);
            }
        }
    }

    // Agora você tem os dados armazenados nas variáveis stepsCountData, caloriesExpendedData, weightData e heartMinutesData
    console.log('Dados de steps_count:', stepsCountData);
    console.log('Dados de calories_expended:', caloriesExpendedData);
    console.log('Dados de weight:', weightData);
    console.log('Dados de heart_minutes:', heartMinutesData);

}




    carregarDados("https://v1.nocodeapi.com/gabrielprisco/fit/fLzdQAHmJTPhNYui/aggregatesDatasets?dataTypeName=steps_count,calories_expended,weight,heart_minutes&timePeriod=7days");

        // Atualize os dados a cada 30 segundos (ajuste conforme necessário)
        //setInterval(carregarDados("https://v1.nocodeapi.com/gabrielprisco/fit/fLzdQAHmJTPhNYui/aggregatesDatasets?dataTypeName=steps_count,calories_expended,weight,heart_minutes&timePeriod=7days"), 30000);
    </script>
</body>

</html>