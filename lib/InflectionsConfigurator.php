<?php

namespace ICanBoogie;

interface InflectionsConfigurator
{
    /**
     * Configure inflections using the methods `plural()`, `singular()`, `irregular()`…
     */
    public static function configure(Inflections $inflections): void;
}
