<?php

namespace AddonsLab\Core;

/**
 * Dependency injection container and object type factory.
 * This is practically the duplicate of XF2 implementation
 * It allows us to use the same interface in XF 1.x and XF2.x versions for loading dependencies
 */
class Container implements \ArrayAccess
{
	protected $data = array();
	protected $cache = array();
	protected $cacheable = array();

	protected $factory = array();
	protected $factoryObjects = array();

	public function offsetGet($key)
	{
		if (array_key_exists($key, $this->cache))
		{
			return $this->cache[$key];
		}

		if (array_key_exists($key, $this->data))
		{
			$value = $this->data[$key];

			$output = ($this->isInvokable($value) ? $value($this) : $value);
			if (!empty($this->cacheable[$key]))
			{
				$this->cache[$key] = $output;
			}

			return $output;
		}

		throw new \InvalidArgumentException("Container key '$key' was not found");
	}

	public function isCached($key)
	{
		return array_key_exists($key, $this->cache);
	}

	public function decache($key)
	{
		unset($this->cache[$key]);
	}

	public function offsetSet($key, $value)
	{
		$this->set($key, $value);
	}

	public function offsetExists($key)
	{
		if (array_key_exists($key, $this->data))
		{
			return true;
		}

		return false;
	}

	public function offsetUnset($key)
	{
		unset($this->data[$key], $this->cache[$key], $this->cacheable[$key]);
	}

	public function __get($key)
	{
		return $this->offsetGet($key);
	}

	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	public function __isset($key)
	{
		return $this->offsetExists($key);
	}

	public function set($key, $value, $cache = null)
	{
		$this->data[$key] = $value;

		if ($cache === null)
		{
			$cache = $this->isInvokable($value);
		}
		$this->cacheable[$key] = (bool)$cache;
		unset($this->cache[$key]);
	}
	
	public function wrap($callable)
	{
		return function() use ($callable)
		{
			return $callable;
		};
	}

	public function extend($key, $callable)
	{
		if (!$this->isInvokable($callable))
		{
			throw new \InvalidArgumentException("Extension must be invokable");
		}

		if (!array_key_exists($key, $this->data))
		{
			throw new \InvalidArgumentException("Container key '$key' was not found");
		}

		$value = $this->data[$key];
		$this->data[$key] = function(Container $container) use ($value, $callable)
		{
			$output = ($container->isInvokable($value) ? $value($container) : $value);
			return $callable($output, $container);
		};

		if (array_key_exists($key, $this->cache))
		{
			// this has already been cached, so we need to run this now so that the
			// next call picks this up
			$this->cache[$key] = $callable($this->cache[$key], $this);
		}
	}

	public function getOriginal($key)
	{
		if (array_key_exists($key, $this->data))
		{
			return $this->data[$key];
		}

		throw new \InvalidArgumentException("Container key '$key' was not found");
	}

	public function factory($type, $callable, $cacheable = true)
	{
		if (!$this->isInvokable($callable))
		{
			throw new \InvalidArgumentException("Factory must be invokable");
		}

		$this->factory[$type] = array($callable, $cacheable);
	}

	public function extendFactory($type, $callable)
	{
		if (!$this->isInvokable($callable))
		{
			throw new \InvalidArgumentException("Extension must be invokable");
		}

		if (!isset($this->factory[$type]))
		{
			throw new \InvalidArgumentException("Factory type '$type' was not found");
		}

		$original = $this->factory[$type][0];
		$this->factory[$type][0] = function($class, array $params, Container $container) use ($original, $callable)
		{
			return $callable($class, $params, $container, $original);
		};
	}

	public function removeFactory($type)
	{
		unset($this->factory[$type], $this->factoryObjects[$type]);
	}

	public function create($type, $key, array $params = array())
	{
		if (!isset($this->factory[$type]))
		{
			throw new \InvalidArgumentException("Factory type '$type' was not found");
		}

		list($callable, $cacheable) = $this->factory[$type];

		if ($cacheable && isset($this->factoryObjects[$type][$key]))
		{
			return $this->factoryObjects[$type][$key];
		}

		$object = $callable($key, $params, $this);
		if ($cacheable)
		{
			$this->factoryObjects[$type][$key] = $object;
		}

		return $object;
	}

	public function getInvokableFactory($type)
	{
	    $obj=$this;
		return function($class, array $params = array()) use ($type, $obj)
		{
			return $obj->create($type, $class, $params);
		};
	}

	public function decacheFactory($type, $class = null)
	{
		if ($class)
		{
			unset($this->factoryObjects[$type][$class]);
		}
		else
		{
			unset($this->factoryObjects[$type]);
		}
	}

	public function createObject($class, array $params = array(), $failSilently = false)
	{
		$params = array_values($params);

		if (!class_exists($class))
		{
			if ($failSilently)
			{
				return null;
			}
			throw new \LogicException("Class $class does not exist");
		}

		switch (count($params))
		{
			case 0: return new $class();
			case 1: return new $class($params[0]);
			case 2: return new $class($params[0], $params[1]);
			case 3: return new $class($params[0], $params[1], $params[2]);
			case 4: return new $class($params[0], $params[1], $params[2], $params[3]);
			case 5: return new $class($params[0], $params[1], $params[2], $params[3], $params[4]);

			default:
				$reflection = new \ReflectionClass($class);
				return $reflection->newInstanceArgs($params);
		}
	}

	protected function isInvokable($value)
	{
		return is_object($value) && method_exists($value, '__invoke');
	}

	public function __sleep()
	{
		throw new \LogicException('Instances of ' . __CLASS__ . ' cannot be serialized or unserialized');
	}

	public function __wakeup()
	{
		throw new \LogicException('Instances of ' . __CLASS__ . ' cannot be serialized or unserialized');
	}
}