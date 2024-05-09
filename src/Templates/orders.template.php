<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Аутентификация</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <header class="navbar navbar-expand-lg bd-navbar sticky-top">
        <div class="container">
            <div class="row">
                <h1>Заказы</h1>
            </div>
        </div>
        
    </header>

    <div class="container">
        <div class="row">
            <div id="root">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Идентификатор</th>
                            <th>Время</th>
                            <th>Контрагент</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        (async () => {
            const rawResponse = await fetch('/orders', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const response = await rawResponse.json();
        let template = '';

        if (response.rows) {
            response.rows.forEach((element) => {
                template += `
                    <tr>
                        <td>${element.name}</td>
                        <td>${element.moment}</td>
                        <td>${element.agent.name}</td>
                        <td>${element.sum.toString().substring(0, element.sum.toString().length - 2) + '.' + element.sum.toString().slice(-2)}</td>
                        <td>${element.state.name}</td>
                    </tr>         
                `;
            })
        }

        document.getElementById('tbody').innerHTML = template;
        })();
    </script>
</body>
</html>