<?php

$debug = true;
require $_SERVER['DOCUMENT_ROOT'] . "/bootstrap.php";

/* @var $twig Twig_Environment */
$twig = $container->get('twig');
/* @var $em Doctrine\ORM\EntityManager */
$em = $container->get('em');

