<?php
namespace Library;

interface Translator
{
    public function translate(string $input) : string;
}