<?php

namespace frontend\tests\unit\controllers;

use common\models\Club;
use frontend\controllers\ClientController;
use frontend\tests\unit\ControllerTestCase;
use common\models\Client;
use yii\web\NotFoundHttpException;

class ClientControllerTest extends ControllerTestCase
{
    public function testCreateClientSuccess(): void
    {
        // Сначала создаем клуб, чтобы использовать его id
        $club = new Club([
            'name' => 'Test Club',
            'created_by' => $this->testUser->id,
            'updated_by' => $this->testUser->id,
        ]);
        $club->save();

        $model = new Client([
            'full_name' => 'Тестовый клиент',
            'gender' => 'male',
            'club_ids' => [$club->id],
            'birth_date' => '1990-01-01',
        ]);

        $this->assertTrue($model->save(), 'Client should be saved');

        // Проверяем, что данные сохранились правильно
        $this->assertEquals('Тестовый клиент', $model->full_name);
        $this->assertEquals('male', $model->gender);
        $this->assertEquals([$club->id], $model->club_ids);
    }

    public function testCreateClientValidationError(): void
    {
        $model = new Client([
            'full_name' => '', // ошибка валидации
            'gender' => '', // ошибка валидации
            'club_ids' => [], // ошибка валидации
        ]);

        $this->assertFalse($model->validate(), 'Client validation should fail');
        $this->assertArrayHasKey('full_name', $model->errors);
        $this->assertArrayHasKey('gender', $model->errors);
        $this->assertArrayHasKey('club_ids', $model->errors);
    }

    public function testFindModelNotFound(): void
    {
        $controller = new ClientController('client', \Yii::$app);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Клиент не найден.');

        // Используем рефлексию для вызова protected метода
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('findModel');
        $method->setAccessible(true);
        $method->invokeArgs($controller, [999999]);
    }

    public function testControllerActions(): void
    {
        $controller = new ClientController('client', \Yii::$app);

        // Проверяем, что контроллер создается
        $this->assertInstanceOf(ClientController::class, $controller);

        // Проверяем, что методы существуют
        $this->assertTrue(method_exists($controller, 'actionIndex'));
        $this->assertTrue(method_exists($controller, 'actionView'));
        $this->assertTrue(method_exists($controller, 'actionCreate'));
        $this->assertTrue(method_exists($controller, 'actionUpdate'));
        $this->assertTrue(method_exists($controller, 'actionDelete'));
    }
}