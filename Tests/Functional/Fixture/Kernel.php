<?php

namespace RDV\Bundle\MigrationBundle\Tests\Functional\Fixture;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use RDV\Bundle\MigrationBundle\RdvMigrationBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Tests\Fixtures\KernelForTest;

class Kernel extends KernelForTest
{
    /** @var array */
    protected $registrableBundles = array();

    /** @var \Closure */
    protected $configCallback;

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        $this->cacheDir = sys_get_temp_dir() . '/kernel' . mt_rand();
        mkdir($this->cacheDir, 0755, true);
        return $this->cacheDir;
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . mt_rand();
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        $bundles = [
            new FrameworkBundle(),
            new TwigBundle(),
            new DoctrineBundle(),
            new RdvMigrationBundle(),
        ];

        return array_merge($bundles, $this->registrableBundles);
    }

    /**
     * @param array $bundles
     * @return $this
     */
    public function setRegistrableBundles($bundles)
    {
        $this->registrableBundles = $bundles;

        return $this;
    }

    /**
     * @param \Closure $callback
     * @return $this
     */
    public function setConfigCallback(\Closure $callback)
    {
        $this->configCallback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config.yml');
        if (is_callable($this->configCallback)) {
            $loader->load($this->configCallback);
        }
    }

    public function __destruct()
    {
        array_map('unlink', glob($this->cacheDir . '/*'));
        rmdir($this->cacheDir);
    }
}
