<?php

namespace frontend\tests\unit\controllers;

use frontend\controllers\ClubController;
use frontend\tests\unit\ControllerTestCase;
use common\models\Club;
use yii\web\NotFoundHttpException;

class ClubControllerTest extends ControllerTestCase
{
    public function testCreateClubSuccess(): void
    {
        $model = new Club([
            'name' => 'Тестовый клуб',
            'created_by' => $this->testUser->id,
            'updated_by' => $this->testUser->id,
        ]);

        $this->assertTrue($model->save(), 'Club should be saved');
        $this->assertEquals('Тестовый клуб', $model->name);
    }

    public function testFindClubNotFound(): void
    {
        $controller = new ClubController('club', \Yii::$app);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Клуб не найден.');

        // Используем рефлексию для вызова protected метода
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('findModel');
        $method->setAccessible(true);
        $method->invokeArgs($controller, [999999]);
    }

    public function testControllerActions(): void
    {
        $controller = new ClubController('club', \Yii::$app);

        // Проверяем, что контроллер создается
        $this->assertInstanceOf(ClubController::class, $controller);

        // Проверяем, что методы существуют
        $this->assertTrue(method_exists($controller, 'actionIndex'));
        $this->assertTrue(method_exists($controller, 'actionView'));
        $this->assertTrue(method_exists($controller, 'actionCreate'));
        $this->assertTrue(method_exists($controller, 'actionUpdate'));
        $this->assertTrue(method_exists($controller, 'actionDelete'));
    }
}