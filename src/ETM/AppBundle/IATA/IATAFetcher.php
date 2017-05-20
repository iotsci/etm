<?php

namespace ETM\AppBundle\IATA;

use Symfony\Component\Filesystem\Filesystem;

class IATAFetcher
{
    protected $fileSystem;
    protected $IATAJson;

    public function __construct(Filesystem $filesystem, $pathToIATAJson)
    {
        $this->fileSystem = $filesystem;
        $this->IATAJson = $pathToIATAJson;
    }

    public function fetch()
    {
        $this->validate();

        return file_get_contents($this->IATAJson);
    }

    protected function validate() {

        if (! $this->isFileExists()) {
            throw new \RuntimeException(sprintf("Файл \"%s\" не существует", $this->IATAJson));
        }

    }

    protected function isFileExists()
    {
        return $this->fileSystem->exists($this->IATAJson);
    }
}