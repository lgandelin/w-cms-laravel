<?php

namespace Webaccess\WCMSLaravel\Helpers;

class BlockTypesVariable
{
    private $variables;

    public function addVariable($identifier, $variable) {
        $this->variables[$identifier]= $variable;
    }

    public function getVariable($identifier) {
        return $this->variables[$identifier];
    }

    public function getVariables() {
        return $this->variables;
    }
} 