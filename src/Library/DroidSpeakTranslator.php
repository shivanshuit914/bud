<?php

namespace Library;

use Exception;

class DroidSpeakTranslator implements Translator
{
    public function translate(string $binary): string
    {
        $binary = str_replace(' ', '', $binary);
        if (false === $this->validate($binary)) {
            throw new Exception('Binary is not valid');
        }

        return pack('H*', base_convert($binary, 2, 16));
    }

    private function validate(string $binary): bool
    {
        if (true === is_int(strlen($binary)/8) && preg_match('~^[01]+$~', $binary)) {
            return true;
        }

        return false;
    }
}
