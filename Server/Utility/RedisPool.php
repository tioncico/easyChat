<?php
/**
 * Created by PhpStorm.
 * User: windrunner414
 * Date: 3/18/18
 * Time: 12:44 PM
 */

namespace App\Utility;

use EasySwoole\Config;
use EasySwoole\Core\Component\Pool\AbstractInterface\Pool;
use EasySwoole\Core\Swoole\Coroutine\Client\Redis;

class RedisPool extends Pool
{
    /**
     * 实现getObj方法
     * @param  float  $timeOut 超时连接等待时间
     * @return null|Redis          Redis连接对象
     */
    public function getObj($timeOut = 0.1) : ? Redis
    {
        // TODO: Change the autogenerated stub
        return parent::getObj($timeOut);
    }

    /**
     * 实现创建对象方法
     * @return Redis
     */
    protected function createObject()
    {
        $conf = Config::getInstance()->getConf('REDIS');
        $redis = new Redis($conf['host'], $conf['port'], $conf['serialize'], $conf['auth']);
        if (is_callable($conf['errorHandler'])) {
            $redis->setErrorHandler($conf['errorHandler']);
        }
        try {
            $redis->exec('select', $conf['dbName'] ?? 0);
        } catch (\Exception $e) {
        }
        return $redis;
    }
}
