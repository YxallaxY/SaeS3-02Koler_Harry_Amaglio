<?php
namespace touiteur\loader;
class autoLoader
{
    private string $name;
    private string $path;

    public function __construct($nameSpace, $pathFile)
    {
        $this->path = $pathFile;
        $this->name = $nameSpace;

    }

    public function loadClass($className)
    {
        $className = str_replace($this->name, $this->path, $className);
        $className = str_replace("\\", "/", $className);
        $className = $className . ".php";
        if (is_file($className)) {
            require_once $className;
        }
    }

    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

}
