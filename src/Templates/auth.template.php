<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Аутентификация</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body style="display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    flex-direction: column;">

    <header class="navbar navbar-expand-lg bd-navbar sticky-top">
        <div class="container">
            <div class="row">
                <h1>Вход в систему</h1>
            </div>
        </div>
        
    </header>

    <div class="container">
        <div class="row" style="display: flex;
            align-items: center;
            justify-content: center;">
            <form method="post" action="/auth" style="max-width: 500px;">
                <input type="hidden" name="csrf" value="<?php echo $data['csrf']; ?>">
                <div class="mb-3">
                    <label for="login" class="form-label">Логин</label>
                    <input type="text" class="form-control" id="login" name="login" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-success">Отправить</button>
            </form>
        </div>
    </div>
</body>
</html>