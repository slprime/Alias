<?php

namespace slprime;

class Alias {

    /**
     * @var array
     */
    protected $aliases = [];

    public function __construct (array $aliases = []) {
        foreach ($aliases as $alias => $path) {
            $this->setAlias($alias, $path);
        }
    }

    /**
     * Set a base directory for a alias.
     *
     * @param string $alias The alias.
     * @param string $path A base directory for class files in the namespace.
     * @throws UndefinedAliasException
     * @return void
     */
    public function setAlias(string $alias, string $path): void {

        // normalize alias
        if (strncmp($alias, '@', 1)) {
            $alias = '@' . $alias;
        }

        $alias = rtrim($alias, "/");

        $root = $this->getAliasRoot($alias);

        // normalize the base directory with a trailing separator
        $path = $this->getAlias($path);

        $this->aliases[$root][$alias] = $path;
        arsort($this->aliases[$root]);
    }

    /**
     * Replace alias in path directory
     *
     * @param string $alias
     * @param bool $throwException
     * @return string|null
     * @throws UndefinedAliasException
     */
    public function getAlias(string $alias, bool $throwException = true) {

        // not an alias
        if (strncmp($alias, '@', 1)) {
            return $alias;
        }

        $root = $this->getAliasRoot($alias);

        if (isset($this->aliases[$root])) {

            foreach ($this->aliases[$root] as $name => $path) {
                if (strpos($alias . "/", $name . "/") === 0) {
                    return $path . substr($alias, strlen($name));
                }
            }

        }

        if ($throwException) {
            throw new UndefinedAliasException("Invalid path alias: $alias");
        }

        return null;
    }

    /**
     * @param string $alias
     * @return string
     */
    private function getAliasRoot (string $alias): string {

        if (false === ($pos = strpos($alias, '/'))) {
            return $alias;
        }

        return substr($alias, 0, $pos);
    }

}