# Небольшой пример авторизации на php
Особенность в том что позволяет авторизоваться на одном и том же сайте 
обращаясь к нему по разным портам. В том случае если ваш сайт выводит
разные данные с одних исходников на разных портах, будет полезно. Решение за счет создания каждой php-сессии своей папки хранения по каждому порту
Сессии создаются в [DOCUMENT_ROOT]/session/[SERVER_PORT]

## Важно
Не проверял вопрос безопасности. Сессии создаются в папке проекта, что теоретически должно быть небезопасно