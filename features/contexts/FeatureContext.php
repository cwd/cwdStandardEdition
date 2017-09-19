<?php
namespace App\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Behat\MinkExtension\Context\MinkContext;

/**
 * This context class contains the definitions of the steps used by the demo 
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 * 
 * @see http://behat.org/en/latest/quick_start.html
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Response|null
     */
    private $response;

    private $container;

    public function __construct($kernel, $container)
    {
        $this->container = $container;
        $this->kernel = $kernel;
        $this->resetDb($container);
    }

        /**
         * @Then the menu item :arg1 is active
         *
         * @param string $item
         */
        public function theMenuItemIsActive($item)
    {
        $this->assertElementContainsText('ul.sidebar-menu > li.active', $item);
    }

        /**
         * Load test fixtures from the given directory.
         *
         * @param ContainerInterface $container
         */
        protected function resetDb($container)
    {
        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $executor = new ORMExecutor($container->get('doctrine.orm.default_entity_manager'), $purger);
        $executor->purge();
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived()
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
    }
}
