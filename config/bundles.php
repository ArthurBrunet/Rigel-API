<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Sonata\Doctrine\Bridge\Symfony\SonataDoctrineSymfonyBundle::class => ['all' => true],
    Sonata\Twig\Bridge\Symfony\SonataTwigSymfonyBundle::class => ['all' => true],
    Sonata\Exporter\Bridge\Symfony\SonataExporterSymfonyBundle::class => ['all' => true],
    Sonata\BlockBundle\SonataBlockBundle::class => ['all' => true],
    Knp\Bundle\MenuBundle\KnpMenuBundle::class => ['all' => true],
    Sonata\AdminBundle\SonataAdminBundle::class => ['all' => true],
];
