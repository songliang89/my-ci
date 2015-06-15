<?php

namespace ESQ;
    
/**
 * Chaining helper
 * Set up a call proxy to an object, but register additional methods on the proxy
 * allows you to proxy methods to your object, but extend the functionality.
 *    
 * //say you have some chainable object, that returns a new object,
 * //but you want to be able to go back to the root object later.
 * //you can create a proxy to the new object with a registered method that returns the original:
 * $myObject = $chainableObject->myOtherObject();
 * $proxy = new Proxy($myObject);
 * $proxy->register('back', function () use($chainableObject) {
 *     return $chainableObject;
 * });
 * return $proxy;
 */
class Proxy {

    private $proxyObject;
    private $registeredMethods;

    public function __construct($proxyObject) {
        $this->proxyObject = $proxyObject;
        $this->registeredMethods = array();
    }

    public function __tostring() {
        return sprintf('[Proxy %s]', get_class($this->proxyObject));
    }

    /**
     * Register method on proxy layer
     */
    public function register ($methodName, $closure) {
        $this->registeredMethods[$methodName] = $closure;
        return $this;
    }

    public function __call($name, $arguments) {
        if(isset($this->registeredMethods[$name])) {
            $rval = call_user_func_array($this->registeredMethods[$name], $arguments);
        }
        elseif(method_exists($this->proxyObject, $name)) {
            $rval = call_user_func_array(array($this->proxyObject, $name), $arguments);
        }
        else {
            throw new \Exception("Invalid method name: $name");
        }

        //return proxy, if return value is proxied object
        if ($rval === $this->proxyObject) {
            return $this;
        }
        else {
            return $rval;
        }
    }

}
