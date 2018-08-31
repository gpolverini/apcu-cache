<?php

namespace Amco\Cache;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @author Gabriel Polverini <polverini.gabriel@gmail.com>
 *
 * @group Cache
 */
class APCUserCacheTest extends TestCase
{
    public function setUp()
    {
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testGetInvalidArgument()
    {
        $cache = new APCUserCache();

        $key = new \StdClass();
        try {
            $cache->get($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = 1;
        try {
            $cache->get($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = [];
        try {
            $cache->get($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testGet()
    {
        $cache = new APCUserCache();
        $key = 'key_test';
        $default = 'default_test';
        $this->assertNull($cache->get($key));
        $this->assertEquals($default, $cache->get($key, $default));
        $value = 'value_test';
        $cache->set($key, $value);
        $this->assertEquals($value, $cache->get($key, $default));
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testSetInvalidArgument()
    {
        $cache = new APCUserCache();
        $value = 'value_test';

        $key = new \StdClass();
        try {
            $cache->set($key, $value);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = 1;
        try {
            $cache->set($key, $value);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = [];
        try {
            $cache->set($key, $value);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = 'key_test';
        try {
            $cache->set($key, $value, new \StdClass());
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Exception
     */
    public function testSet()
    {
        $cache = new APCUserCache();
        $key = 'key_test';
        $value = 'value_test';
        $this->assertTrue($cache->set($key, $value));
        $this->assertTrue($value === $cache->get($key));
        $ttl = 5;
        $this->assertTrue($cache->set($key, $value, $ttl));
        $this->assertTrue($value === $cache->get($key));
        $ttl = new \DateInterval('PT'.time().'S');
        $this->assertTrue($cache->set($key, $value, $ttl));
        $this->assertTrue($value === $cache->get($key));

    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testDeleteInvalidArgument()
    {
        $cache = new APCUserCache();

        $key = new \StdClass();
        try {
            $cache->delete($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = 1;
        try {
            $cache->delete($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = [];
        try {
            $cache->delete($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testDelete()
    {
        $cache = new APCUserCache();
        $key = 'key_test';
        $value = 'value_test';
        $cache->set($key, $value);
        $this->assertTrue($cache->delete($key));
        $this->assertNull($cache->get($key));
    }

    /**
     * @test
     */
    public function testClear()
    {
        $this->assertTrue((new APCUserCache())->clear());
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testGetMultipleInvalidArgument()
    {
        $cache = new APCUserCache();

        $key = new \StdClass();
        try {
            $cache->getMultiple($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = 1;
        try {
            $cache->getMultiple($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = [1];
        try {
            $cache->getMultiple($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testGetMultiple()
    {
        $cache = new APCUserCache();
        $key_test_1 = 'key_test_1';
        $key_test_2 = 'key_test_2';
        $default = 'default_test';
        $keys = [$key_test_1, $key_test_2];
        $ret = $cache->getMultiple($keys, $default);
        $this->assertTrue(is_array($ret) && count($ret) == count($keys));
        $this->assertTrue(
            $ret[$key_test_1] == $default
            && $ret[$key_test_2] == $default
        );
        $value = 'value_test';
        $cache->set($key_test_1, $value);
        $ret = $cache->getMultiple($keys, $default);
        $this->assertTrue(is_array($ret) && count($ret) == count($keys));
        $this->assertTrue(
            $ret[$key_test_1] == $value
            && $ret[$key_test_2] == $default
        );
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testSetMultipleInvalidArgument()
    {
        $cache = new APCUserCache();

        $values = new \StdClass();
        try {
            $cache->setMultiple($values);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $values = 1;
        try {
            $cache->setMultiple($values);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $values = [1 => ''];
        try {
            $cache->setMultiple($values);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $values = ['key_test' => 'value_test'];
        try {
            $cache->setMultiple($values, new \StdClass());
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Exception
     */
    public function testSetMultiple()
    {
        $cache = new APCUserCache();
        $key_test_1 = 'key_test_1';
        $key_test_2 = 'key_test_2';
        $default = 'default_test';
        $values = [
            $key_test_1 => $default,
            $key_test_2 => $default
        ];
        $this->assertTrue($cache->setMultiple($values));
        $ttl = 5;
        $this->assertTrue($cache->setMultiple($values, $ttl));
        $ttl = new \DateInterval('PT'.time().'S');
        $this->assertTrue($cache->setMultiple($values, $ttl));
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testDeleteMultipleInvalidArgument()
    {
        $cache = new APCUserCache();

        $keys = new \StdClass();
        try {
            $cache->deleteMultiple($keys);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $keys = 1;
        try {
            $cache->deleteMultiple($keys);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $keys = [1];
        try {
            $cache->deleteMultiple($keys);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testDeleteMultiple()
    {
        $cache = new APCUserCache();
        $key_test_1 = 'key_test_1';
        $key_test_2 = 'key_test_2';
        $keys = [$key_test_1, $key_test_2];
        $this->assertTrue($cache->deleteMultiple($keys));
    }

    /**
     * @test
     *
     * @@throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testHasInvalidKey()
    {
        $cache = new APCUserCache();

        $key = new \StdClass();
        try {
            $cache->has($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = 1;
        try {
            $cache->has($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }

        $key = [];
        try {
            $cache->has($key);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \Psr\SimpleCache\InvalidArgumentException);
        }
    }

    /**
     * @test
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function testHas()
    {
        $cache = new APCUserCache();
        $key = 'key_test';
        $this->assertFalse($cache->has($key));
        $cache->set($key, '');
        $this->assertTrue($cache->has($key));
    }
}
