<?php

namespace BornMT\ApcoPay\Support;

class Configuration
{
    public function __construct(
        public string $username,
        public string $password,
        public string $pid,
        public string $url
    ) {}
}
