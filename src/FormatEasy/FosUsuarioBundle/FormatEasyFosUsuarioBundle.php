<?php

namespace FormatEasy\FosUsuarioBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FormatEasyFosUsuarioBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
