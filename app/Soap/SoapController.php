<?php

declare(strict_types=1);

namespace App\Soap;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Server;
use Laminas\Soap\Server\DocumentLiteralWrapper;
use Laminas\Soap\Wsdl;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\ComplexTypeStrategyInterface;
use SoapFault;

class SoapController
{
    protected string $name;

    protected string $service;

    protected string $endpoint;

    protected array $exceptions;

    protected array $types;

    protected ComplexTypeStrategyInterface $strategy;

    protected array $headers;

    protected array $options;

    /**
     * Initializes service attributes, disable PHP WSDL caching.
     */
    public function init(string $key): void
    {
        $config = config('soap.services.' . $key);

        if (!$config) {
            throw new Exception('Please specify a valid service configuration.');
        }

        $this->name = $config['name'];
        $this->service = $config['class'];
        $this->endpoint = self::currentUrlRoot();
        $this->exceptions = $config['exceptions'];
        $this->types = $config['types'];

        $strategies = [
            'AnyType',
            'ArrayOfTypeComplex',
            'ArrayOfTypeSequence',
            'DefaultComplexType'
        ];

        $strategy = ($config['strategy']) ? : 'ArrayOfTypeComplex';

        if (!in_array($strategy, $strategies)) {
            throw new Exception('Please specify a valid complex type strategy.');
        }

        $strategy = "Laminas\\Soap\\Wsdl\\ComplexTypeStrategy\\" . $strategy;
        $this->strategy = new $strategy();

        $this->headers = $config['headers'];
        $this->options = array_key_exists('options', $config) ? $config['options'] : [];

        if (!array_key_exists('Content-Type', $this->headers)) {
            $this->headers = Arr::add($this->headers, 'Content-Type', 'application/xml; charset=utf-8');
        }

        ini_set('soap.wsdl_cache_enable', '0');
        ini_set('soap.wsdl_cache_ttl', '0');
    }

    /**
     * Returns results of a call to the specified service.
     *
     * @param $key
     * @return Factory|Response|View
     */
    public function server($key)
    {
        $output = new Response();
        ob_start();

        try {
            $this->init($key);

            foreach($this->headers as $key => $value) {
                $output->headers->set($key, $value);
            }

            $this->createWsdlFile();
            $fullPathToWsdl = public_path() . DIRECTORY_SEPARATOR . 'wsdl.xml';

            if (isset($_GET['wsdl'])) {
                echo file_get_contents($fullPathToWsdl);
            } else {
                $server = new Server($fullPathToWsdl);
                $server->setClass(new DocumentLiteralWrapper(new $this->service()));
                $server->registerFaultException($this->exceptions);
                $server->setOptions($this->options);

                // Intercept response, then decide what to do with it.
                $server->setReturnResponse(true);
                $response = $server->handle();

                if ($response instanceof SoapFault) {
                    $output->headers->set("Status", 500);
                    echo self::serverFault($response);
                } else {
                    echo $response;
                }
            }

        } catch (Exception $exception) {
            $output->headers->set("Status", 500);
            echo self::serverFault($exception);
        }

        $output->setContent(ob_get_clean());

        return $output;
    }

    /**
     * Gets the current absolute URL path, minus the query string.
     *
     * @return string
     */
    public static function currentUrlRoot(): string
    {
        $url = url(app()->request->server()['REQUEST_URI']);
        $pos = strpos($url, '?');

        return $pos ? substr($url, 0, $pos) : $url;
    }

    /**
     * Logs message if logging is enabled in config, return input fluently.
     *
     * @param string $message
     * @return string
     */
    public static function log($message = ''): string
    {
        if(config('soap.logging', false)) {
            Log::info($message);
        }

        return $message;
    }

    /**
     * Returns error response and log stack trace.
     *
     * @param Exception $exception
     * @return Factory|View
     */
    public static function serverFault(Exception $exception)
    {
        self::log($exception->getTraceAsString());
        $faultCode = 'SOAP-ENV:Server';
        $faultString = $exception->getMessage();

        return view('soap::fault', compact('faultCode', 'faultString'));
    }

    /**
     * Creates wsdl file.
     */
    public function createWsdlFile(): void
    {
        $wsdl = new Wsdl('wsdl', $this->endpoint);

        foreach($this->types as $key => $class) {
            $wsdl->addType($class, $key);
        }

        $this->strategy->setContext($wsdl);

        foreach($this->types as $key => $class) {
            $this->strategy->addComplexType($class);
        }

        $discover = new AutoDiscover($this->strategy);
        $discover->setBindingStyle(array('style' => 'document'));
        $discover->setOperationBodyStyle(array('use' => 'literal'));
        $discover->setClass($this->service);
        $discover->setUri($this->endpoint);
        $discover->setServiceName($this->name);
        $xml = $discover->toXml();
        file_put_contents(public_path() . DIRECTORY_SEPARATOR . 'wsdl.xml', $xml);
    }
}
