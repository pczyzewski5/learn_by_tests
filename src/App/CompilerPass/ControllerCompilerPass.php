<?php

declare(strict_types=1);

namespace App\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ControllerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('controller.service_arguments') as $id => $tags) {
            $definition = $container->findDefinition($id);
            $definition->addMethodCall(
                'setFormFactory',
                [$container->getDefinition('form.factory')]
            ); $definition->addMethodCall(
                'setTwig',
                [$container->getDefinition('twig')]
            );
        }
    }
}
