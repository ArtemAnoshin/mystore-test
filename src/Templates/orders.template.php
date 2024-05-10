<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Заказы</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/uikit.min.css" rel="stylesheet">
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
                <table class="table ui-table">
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
        (
            async () => {
                const ordersResponse = await fetch('/orders', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                // Заказы и набор статусов
                const response = await ordersResponse.json();

                // Шаблон для данных в виде таблицы
                let template = '';
                // Все статусы
                const allStatuses = response?.statuses;
                const allOrders = response?.orders;
    
                // Функция отрисовки селекта со статусами
                const statuses = (statuses, currentStatusId, orderId) => {
                    let options = '';
                    options += `<select class="order-status-selector">`;
                    statuses.forEach((status) => {
                        const currentStatus = (status.id === currentStatusId) ? 'selected' : '';
                        options += `
                            <option ${currentStatus} value="${orderId + '|' + status.id}">${status.name}</option>
                        `;
                    });
                    options += `</select>`;
                    return options;
                };

                if (allOrders) {
                    allOrders.forEach((element) => {
                        template += `
                            <tr>
                                <td><a href="${element.link}" target="blank">${element.name}</a></td>
                                <td>${element.moment}</td>
                                <td><a href="${element.agent_href}" target="blank">${element.agent_name}</a></td>
                                <td>${element.sum.toString().substring(0, element.sum.toString().length - 2) + '.' + element.sum.toString().slice(-2)}</td>
                                <td>${statuses(allStatuses, element.state_id, element.id)}</td>
                            </tr>         
                        `;
                    })
                }

                document.getElementById('tbody').innerHTML = template;

                // Сменить статус
                const orderStatuses = document.querySelectorAll('.order-status-selector');

                for (let i = 0; i < orderStatuses.length; i++) {
                    orderStatuses[i].addEventListener('change', function() {
                        const response = fetch('/changeStatus', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                data: this.value
                            })
                        });

                        alert('Статус заказа изменен');
                    });
                }
            }
        )();
    </script>
</body>
</html>