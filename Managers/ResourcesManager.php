<?php

namespace Modules\Account\Managers;

use Symfony\Component\Finder\Finder;

class ResourcesManager
{
    /**
     * @param $cls
     * @return array
     * @throws \ReflectionException
     */
    public function findMetadata($cls)
    {
        $resources = [];
        $reflectionClass = new \ReflectionClass($cls);
        $publicMethods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach($publicMethods as $publicMethod) {
            if(
                !$publicMethod->isConstructor() &&
                !$publicMethod->isDestructor() &&
                !$publicMethod->isAbstract() &&
                !$publicMethod->isClosure() &&
                !$publicMethod->isFinal() &&
                !$publicMethod->isInternal() &&
                !$publicMethod->isStatic() &&
                ($publicMethod->getDeclaringClass()->getName()==$cls)
            ) {
                $resource = [];
                $resource['resource'] = $cls.'@'.$publicMethod->getName();
                $resources[] = $resource;
            }
        }

        return $resources;
    }

    public function findResources($wildCardDirectoryPath)
    {
        $finder = new Finder();
        $resources = [];
        $directories = $finder->in($wildCardDirectoryPath)->directories();
        foreach($directories as $directory) {
            $classesByPath = $this->findClasses($directory->getPath());
            foreach($classesByPath as $cls) {
                $metadata = $this->findMetadata($cls);
                $resources = array_merge($resources, $metadata);
            }
        }

        return $resources;
    }

    /**
     * @param $path
     * @return array
     */
    public function findClasses($path)
    {
        $fqcns = array();

        $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2; // Skip namespace keyword and whitespace
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2; // Skip class keyword and whitespace
                    $fqcns[] = $namespace.'\\'.$tokens[$index][1];

                    # break if you have one class per file (psr-4 compliant)
                    # otherwise you'll need to handle class constants (Foo::class)
                    break;
                }
            }
        }

        return $fqcns;
    }
}