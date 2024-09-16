<?php

namespace SV\MultiPrefix;

interface ILinkablePrefix
{
    public function getSvPrefixFilterLink(int $prefixId, string $linkType = ''): string;
}