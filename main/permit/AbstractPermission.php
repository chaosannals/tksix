<?php

namespace tksix\permit;

abstract class AbstractPermission
{
    abstract function permit($tags);
}
