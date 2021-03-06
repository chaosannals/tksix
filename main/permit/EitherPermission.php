<?php

namespace tksix\permit;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class EitherPermission extends AbstractPermission
{
    private $tags;

    public function __construct($tags)
    {
        $this->tags = array_unique($tags);
    }

    public function permit($tags)
    {
        $diff = array_diff($this->$tags, $tags);
        return count($diff) > 0;
    }
}
