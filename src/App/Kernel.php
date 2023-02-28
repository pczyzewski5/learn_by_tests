<?php

namespace App;

use App\CompilerPass\ControllerCompilerPass;
use App\CompilerPass\RequestValidatorCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{yaml,yml}';

    public function getProjectDir(): string
    {
        return \dirname(__DIR__) . '/../';
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir() . '/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', $this->debug);
        $container->setParameter('container.dumper.inline_factories', true);
        $confDir = $this->getProjectDir() . '/config';

        $loader->load($confDir . '/{common}/{packages}/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/' . $this->environment . '/{packages}/*' . self::CONFIG_EXTS, 'glob');

        $loader->load($confDir . '/{common}/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/' . $this->environment . '/{services}' . self::CONFIG_EXTS, 'glob');

        $loader->load($confDir . '/{common}/{parameters}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/' . $this->environment . '/{parameters}' . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routes->import($confDir . '/{common}/{routes}' . self::CONFIG_EXTS);
        $routes->import($confDir . '/' . $this->environment . '/{routes}' . self::CONFIG_EXTS);
    }

    protected function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ControllerCompilerPass());
    }
}
