<?php

function foiMordido()
{
    return rand(0, 1) === 1;
}

$mordeu = foiMordido() ? '' : ' NÃO';

echo "Joãozinho$mordeu mordeu o seu dedo\n";
