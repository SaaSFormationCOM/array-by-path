<?php

namespace SaaSFormation\ArrayByPath;

class RetrieveArrayValueByPathService
{
    public function find(string $path, array $data): mixed
    {
        try {
            return $this->get($path, $data);
        } catch(InvalidPathException $e) {
            return null;
        }
    }

    /**
     * @throws InvalidPathException
     */
    public function get(string $path, array $data): mixed
    {
        $pathParts = explode('.', $path);

        foreach($pathParts as $part) {
            if(isset($data[$part])) {
                $data = $data[$part];
            } else {
                throw new InvalidPathException("$path is not a valid path for the provided array.");
            }
        }

        return $data;
    }
}
