<?php
namespace Pmp\Infrastructure\Aop\Aspects;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\Around;

class LoggingAspect implements Aspect
{
    /**
     * @Before("execution(public Pmp\Domain\Model\Agency\Agency->prospect(*))")
     */
    public function beforeMethodExecution(MethodInvocation $invocation)
    {
        echo "Executing " . $invocation->getMethod()->name;
    }
}