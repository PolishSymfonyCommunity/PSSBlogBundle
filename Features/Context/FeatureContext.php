<?php

namespace PSS\Bundle\BlogBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\Pending;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Symfony\Component\Finder\Finder;

if (file_exists(__DIR__ . '/../support/bootstrap.php')) {
    require_once __DIR__ . '/../support/bootstrap.php';
}

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements ClosuredContextInterface
{
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
        parent::__construct($kernel);

        if (file_exists(__DIR__ . '/../support/env.php')) {
            $world = $this;
            require(__DIR__ . '/../support/env.php');
        }
    }

    public function getKernel()
    {
        return $this->kernel;
    }

    public function getStepDefinitionResources() {
        if (file_exists(__DIR__ . '/../steps')) {
            $finder = new Finder();
            return $finder->files()->name('*.php')->in(__DIR__ . '/../steps');
        }
        return array();
    }

    public function getHookDefinitionResources() {
        if (file_exists(__DIR__ . '/../support/hooks.php')) {
            return array(__DIR__ . '/../support/hooks.php');
        }
        return array();
    }

    public function __call($name, array $args) {
        if (isset($this->$name) && is_callable($this->$name)) {
            return call_user_func_array($this->$name, $args);
        } else {
            $trace = debug_backtrace();
            trigger_error(
                'Call to undefined method ' . get_class($this) . '::' . $name .
                ' in ' . $trace[0]['file'] .
                ' on line ' . $trace[0]['line'],
                E_USER_ERROR
            );
        }
    }
}
