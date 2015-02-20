<?php
namespace Pmp\Infrastructure\Aop\Aspects;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;

class LoggingAspect implements Aspect
{
    /**
     * @Around("@execution(Pmp\Infrastructure\Annotations\Loggable)")
     * @return mixed
     */
    public function aroundLoggable(MethodInvocation $invocation)
    {
        $method = $invocation->getMethod()->name;
        echo "Entering " . $method;
        try {
            $result = $invocation->proceed();
        } catch (Exception $e) {
            echo "Error: " . $method . ' details: ' . $e;
            throw $e;
        }
        return $result;
    }
}