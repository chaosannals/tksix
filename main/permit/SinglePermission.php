<?php

namespace tksix\permit;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class SinglePermission extends AbstractPermission
{
    private $tag;

    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    public function permit($tags)
    {
        return in_array($this->tag, $tags, true);
    }
}
