<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/project.css">
    <link rel="stylesheet" href="/css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Histórico de pontos</title>
</head>

<body>
    <div class="value" style="text-align: center">
        <h1 id="heart-now">Histórico de pontos</h1><br>
    </div>

    <div class="today-stats">
        <div class="title">
            <h4>Última semana</h4><br>
        </div>

        <div class="stats" style="align-items: center">
            <canvas id="myChart"></canvas><br>
            <div>
                <b>
                    <p style="color: #121F49">Média da semana: <span id="media">X</span></p>
                </b>
                <b>
                    <p style="color: #F9A11B;">Menor valor da semana: <span id="minimo">X</span></p>
                </b>
                <b>
                    <p style="color: #F24C27">Maior valor da semana: <span id="maximo">X</span></p>
                </b>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        const timetoupdate = 30;
        var caloriesExpendedData = [];
        var weightData = [];
        var heartMinutesData = [];
        var stepsCountData = [];
        var valuesArray;
        var datesArray;

        function carregarDados(url) {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('dados:', data);
                    exibirDados(data);
                },
                error: function(error) {
                    console.error('Erro ao carregar dados:', error);
                }
            });
        }



        function exibirDados(response) {
            var media = $("#media");
            var minimo = $("#minimo");
            var maximo = $("#maximo");


            // Itera sobre cada tipo de dado (steps_count, calories_expended, weight, heart_minutes)
            for (var dataType in response) {
                if (response.hasOwnProperty(dataType)) {
                    var dataPoints = response[dataType];

                    // Verifica se dataPoints é uma matriz e não está vazio
                    if (Array.isArray(dataPoints) && dataPoints.length > 0) {
                        // Itera sobre cada ponto de dados
                        dataPoints.forEach(function(dataPoint) {
                            // Verifica se as propriedades essenciais estão presentes
                            if (dataPoint.hasOwnProperty('value') && dataPoint.hasOwnProperty('startTime') && dataPoint.hasOwnProperty('endTime')) {
                                // Adapte conforme necessário, dependendo da estrutura específica de cada tipo de dado
                                var value = dataPoint['value'];
                                var startTime = dataPoint['startTime'];
                                var endTime = dataPoint['endTime'];

                                // Adiciona os dados ao array apropriado
                                switch (dataType) {
                                    case 'steps_count':
                                        stepsCountData.push({
                                            value: value,
                                            startTime: startTime,
                                            endTime: endTime
                                        });
                                        break;
                                    case 'calories_expended':
                                        caloriesExpendedData.push({
                                            value: value,
                                            startTime: startTime,
                                            endTime: endTime
                                        });
                                        break;
                                    case 'weight':
                                        weightData.push({
                                            value: value,
                                            startTime: startTime,
                                            endTime: endTime
                                        });
                                        break;
                                    case 'heart_minutes':
                                        heartMinutesData.push({
                                            value: value,
                                            startTime: startTime,
                                            endTime: endTime
                                        });
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
            if (Array.isArray(stepsCountData) && stepsCountData.length > 0) {
                valuesArray = stepsCountData.map(function(entry) {
                    return entry.value;
                });
                console.log("values: ", valuesArray)
                datesArray = stepsCountData.map(function(entry) {
                    return entry.endTime.slice(0, 11);
                });
                let sum = valuesArray.reduce(function(a, b) {
                    return a + b;
                });
                media.html("" + Math.trunc(sum/valuesArray.length));
                maximo.html("" + Math.max(...valuesArray));
                minimo.html("" + Math.min(...valuesArray));

            } else {

            }



            console.log("values: ", valuesArray);
            console.log("values: ", datesArray);
            console.log('Dados de steps_count:', stepsCountData.value);
            console.log('Dados de calories_expended:', caloriesExpendedData);
            console.log('Dados de weight:', weightData);
            console.log('Dados de heart_minutes:', heartMinutesData);
            // Configuração do gráfico, type bar = vertical
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    //Podemos deixar em dias assim com formato dia/mes ou então somente o dia da semana
                    labels: datesArray,
                    datasets: [{
                        label: 'Pontos',
                        data: valuesArray,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

        }

        carregarDados("https://v1.nocodeapi.com/gabrielprisco/fit/fLzdQAHmJTPhNYui/aggregatesDatasets?dataTypeName=steps_count,calories_expended,weight,heart_minutes&timePeriod=7days");
        /*setInterval(function() {
            carregarDados("https://v1.nocodeapi.com/gabrielprisco/fit/fLzdQAHmJTPhNYui/aggregatesDatasets?dataTypeName=steps_count,calories_expended,weight,heart_minutes&timePeriod=7days");
        }, timetoupdate * 1000);*/

        //Matheus coloca os dados dos pontos aqui, cada elemento do array é um dia da semana
    </script>
</body>

</html>