<?php

namespace SV\MultiPrefix\Repository;

interface IMultiPrefixFinder
{
    public function extractCategoryIdsForMultiPrefix(): array;
    public function getMultiPrefixLinkTableEntity(): string;
    public function incrementAliasForMultiPrefixLink(): int;
}