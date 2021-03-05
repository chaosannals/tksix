<?php

namespace tksix\middleware;

use ReflectionClass;
use tksix\exception\PermitException;
use tksix\permit\AbstractPermission;

class PermitMiddleware
{
    public function handle($request, $next)
    {
        // 自定义 Request 必须提供 permissions 方法获取权限。
        $tags = $request->permissions();

        // 控制器权限验证
        $cname = $request->controller();
        $cclass = new ReflectionClass($cname);
        $cattrs = $cclass->getAttributes(AbstractPermission::class);
        foreach ($cattrs as $cattr) {
            if (!$cattr->newInstance()->permit($tags)) {
                throw new PermitException();
            }
        }

        // 操作权限验证
        $aname = $request->action();
        $aclass = $cclass->getMethod($aname);
        $aattrs = $aclass->getAttributes(AbstractPermission::class);
        foreach ($aattrs as $aattr) {
            if (!$aattr->newInstance()->permit($tags)) {
                throw new PermitException();
            }
        }

        return $next($request);
    }
}
