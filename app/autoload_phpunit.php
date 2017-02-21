<?php

/**
 * fix for phpunit 6
 */
if (!class_exists('\PHPUnit_Framework_TestCase', true)) {
    class_alias('\PHPUnit\Framework\TestCase', '\PHPUnit_Framework_TestCase');
}

return require_once 'autoload.php';
