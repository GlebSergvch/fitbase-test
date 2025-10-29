<?php

namespace frontend\tests\unit;

use Yii;
use yii\base\InvalidConfigException;
use common\models\User;
use Codeception\Test\Unit;

class ControllerTestCase extends Unit
{
    protected ?User $testUser = null;

    protected function _before(): void
    {
        parent::_before();

        // Настройка request компонента
        Yii::$app->set('request', [
            'class' => 'yii\web\Request',
            'cookieValidationKey' => 'test-key-for-cookie-validation',
            'scriptFile' => __DIR__ . '/index.php',
            'scriptUrl' => '/index.php',
        ]);

        // Настройка user компонента
        Yii::$app->set('user', [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false, // отключаем сессии для тестов
        ]);

        // Настройка assetManager
        Yii::$app->set('assetManager', [
            'class' => 'yii\web\AssetManager',
            'basePath' => Yii::getAlias('@runtime/assets'),
            'baseUrl' => '/assets',
        ]);

        // Настройка session (если используется)
        Yii::$app->set('session', [
            'class' => 'yii\web\Session',
            'timeout' => 3600,
        ]);

        // Создаем или находим тестового пользователя
        $this->testUser = User::findOne(1);
        if (!$this->testUser) {
            $this->testUser = new User([
                'id' => 1,
                'username' => 'test',
                'email' => 'test@example.com',
                'status' => User::STATUS_ACTIVE,
                'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('123456'),
                'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
                'created_at' => time(),
                'updated_at' => time(),
            ]);

            if (!$this->testUser->save(false)) {
                throw new \RuntimeException('Не удалось создать тестового пользователя: ' . json_encode($this->testUser->errors));
            }
        }

        // Устанавливаем пользователя без использования сессии
        Yii::$app->user->setIdentity($this->testUser);
    }

    protected function _after(): void
    {
        parent::_after();
        Yii::$app->user->setIdentity(null);
    }
}