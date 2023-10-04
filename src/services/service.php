<?php
    class Service {
        protected static $instances = [];
        protected function __construct()
        {
            // Do Nothing
        }

        // Get the singleton instance of the class
        public static function getInstance(){
            $className = static::class;
            if (!isset(self::$instances[$className])) {
                self::$instances[$className] = new static();
            }

            return self::$instances[$className];
        }
    }
?>