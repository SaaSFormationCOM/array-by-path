<?php

namespace SaaSFormation\ArrayByPath;

class SetValueToArrayByPathService
{
    /**
     * @throws PathAlreadyExistsException
     */
    public function insert(string $path, array &$data, mixed $value): void
    {
        $this->set($path, $data, $value);
    }

    public function upsert(string $path, array &$data, mixed $value)
    {
        $this->set($path, $data, $value, true);
    }

    /**
     * @throws PathAlreadyExistsException
     */
    private function set(string $path, array &$data, mixed $value, bool $override = false): void
    {
        $pathParts = explode('.', $path);
        $totalParts = count($pathParts);
        $pointer = &$data;

        for($i = 0; $i < $totalParts; $i++) {
            if($i + 1 != $totalParts) {
                if(!isset($pointer[$pathParts[$i]])) {
                    $pointer[$pathParts[$i]] = [];
                }
                $pointer = &$pointer[$pathParts[$i]];
            } else {
                if(!$override && isset($pointer[$pathParts[$i]])) {
                    throw new PathAlreadyExistsException("Path $path is already present in array. Use upsert to override the value.");
                }
                $pointer[$pathParts[$i]] = $value;
            }
        }
    }
}
