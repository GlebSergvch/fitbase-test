<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Fitbase</h1>
    <br>
</p>


1) скопировать .env.dist в .env

2) сбилдить контейнер:
    docker-compose up --build -d

3) composer i в app контейнере

4) создать тестовую бд:
    ./scripts/create_test_db.sh

5) запуск миграций:
   docker-compose exec app php yii migrate --interactive=0

6) накатить миграции в тестовую бд:
docker-compose exec app php yii migrate --interactive=0 --db=db-test

7) создать админа:
   docker-compose exec app php yii user/create admin@fitbase.ru admin 123456

8) запуск тестов:
docker-compose exec app ./vendor/bin/codecept run unit frontend/tests/unit/controllers -c frontend/codeception.yml