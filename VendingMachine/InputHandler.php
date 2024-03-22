<?php

namespace VendingMachine;

class InputHandler
{
    /**
     * @param string $prompt
     * @return string
     */
    public function getInput(string $prompt): string
    {
        echo $prompt;
        return rtrim(fgets(STDIN), "\n");
    }
}