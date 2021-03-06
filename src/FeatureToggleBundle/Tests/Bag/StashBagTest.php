<?php

namespace BestIt\FeatureToggleBundle\Tests\Bag;

use BestIt\FeatureToggleBundle\Bag\StashBag;
use BestIt\FeatureToggleBundle\Exception\StashNotFoundException;
use BestIt\FeatureToggleBundle\Stash\StashInterface;
use PHPUnit\Framework\TestCase;
use Traversable;

/**
 * Class StashBagTest
 *
 * @author Michel Chowanski <chowanski@bestit-online.de>
 * @package BestIt\FeatureToggleBundle\Tests\Bag
 */
class StashBagTest extends TestCase
{
    /**
     * Test add function
     *
     * @return void
     */
    public function testAdd()
    {
        $bag = new StashBag();
        $bag->add($cookieStash = $this->createMock(StashInterface::class));
        $bag->add($configStash = $this->createMock(StashInterface::class));

        $configStash
            ->method('getName')
            ->willReturn('config');

        static::assertSame($configStash, $bag->get('config'));
    }

    /**
     * Test has function
     *
     * @return void
     */
    public function testHas()
    {
        $bag = new StashBag();
        $bag->add($cookieStash = $this->createMock(StashInterface::class));
        $bag->add($configStash = $this->createMock(StashInterface::class));

        $configStash
            ->method('getName')
            ->willReturn('config');

        $cookieStash
            ->method('getName')
            ->willReturn('cookie');

        static::assertEquals(true, $bag->has('config'));
        static::assertEquals(false, $bag->has('foobar'));
    }

    /**
     * Test get function
     *
     * @return void
     */
    public function testGet()
    {
        $bag = new StashBag();
        $bag->add($cookieStash = $this->createMock(StashInterface::class));
        $bag->add($configStash = $this->createMock(StashInterface::class));

        $configStash
            ->method('getName')
            ->willReturn('config');

        $cookieStash
            ->method('getName')
            ->willReturn('cookie');

        static::assertSame($configStash, $bag->get('config'));
    }

    /**
     * Test get function
     *
     * @return void
     */
    public function testGetMissingFeature()
    {
        $this->expectException(StashNotFoundException::class);

        $bag = new StashBag();
        $bag->add($cookieStash = $this->createMock(StashInterface::class));
        $bag->add($configStash = $this->createMock(StashInterface::class));

        $configStash
            ->method('getName')
            ->willReturn('config');

        $cookieStash
            ->method('getName')
            ->willReturn('cookie');

        $bag->get('custom_object');
    }

    /**
     * Test iteration and ordering
     *
     * @return void
     */
    public function testIteration()
    {
        $bag = new StashBag();
        $bag->add($cookieStash = $this->createMock(StashInterface::class));
        $bag->add($configStash = $this->createMock(StashInterface::class));
        $bag->add($customObjectStash = $this->createMock(StashInterface::class));

        $configStash
            ->method('getName')
            ->willReturn('config');

        $cookieStash
            ->method('getName')
            ->willReturn('cookie');

        $customObjectStash
            ->method('getName')
            ->willReturn('custom_object');

        static::assertInstanceOf(Traversable::class, $bag);

        $i = 0;
        foreach ($bag as $order => $stash) {
            switch ($i) {
                case 0:
                    static::assertSame($cookieStash, $stash);
                    break;

                case 1:
                    static::assertSame($configStash, $stash);
                    break;

                case 2:
                    static::assertSame($customObjectStash, $stash);
                    break;
            }

            $i++;
        }
    }

    /**
     * Test get all
     *
     * @return void
     */
    public function testAll()
    {
        $bag = new StashBag();
        $bag->add($cookieStash = $this->createMock(StashInterface::class));
        $bag->add($configStash = $this->createMock(StashInterface::class));
        $bag->add($customObjectStash = $this->createMock(StashInterface::class));

        $configStash
            ->method('getName')
            ->willReturn('config');

        $cookieStash
            ->method('getName')
            ->willReturn('cookie');

        $customObjectStash
            ->method('getName')
            ->willReturn('custom_object');

        static::assertInstanceOf(Traversable::class, $bag);

        $i = 0;
        foreach ($bag->all() as $order => $stash) {
            switch ($i) {
                case 0:
                    static::assertSame($cookieStash, $stash);
                    break;

                case 1:
                    static::assertSame($configStash, $stash);
                    break;

                case 2:
                    static::assertSame($customObjectStash, $stash);
                    break;
            }

            $i++;
        }
    }
}
