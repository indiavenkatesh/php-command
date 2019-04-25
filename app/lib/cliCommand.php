<?php
declare(strict_types=1);

class cliCommand {

    private $options = array();
    private $arguments = array();

    function __construct(array $args) {
        $this->config();
        $this->addOption('help');
        $this->parseArguments($args);

        if(isset($this->arguments['help'])) {
            $this->printHelpText();
            die;
        }
    }

    function addOption(string $name, string $type = '', string $desc = ''): void {
        $this->options[] = array(
            'name' => $name,
            'type' => $type,
            'description' => $desc
        );
    }

    function getOptions(): array {
        return $this->options;
    }

    function getArguments(): array {
        return $this->arguments;
    }

    function parseArguments(array $args): void {
        $options = array_column($this->options, 'name');
        foreach($args as $index => $arg) {
            if($this->isOptionKey($arg)) {
                $optionKey = str_replace('--', '', $arg);
                if(!in_array($optionKey, $options)) {
                    throw new Exception(
                        sprintf("\" %s \" is not a valid option. Check --help for further.", $optionKey)
                    );
                }
                $this->arguments[$optionKey] = "";
            } else {
                if($index == 0) {
                    throw new Exception("Invalid options! Check --help for further.");
                }
                $this->arguments[$optionKey] = $arg;
            }
        }
    }

    function isOptionKey(string $key): bool {
        return substr($key, 0, 2) == '--';
    }

    function printHelpText() {
        echo "Usage: php index.php " . get_class($this) . " [--options]" . "\n" . "\n";
        
        $rows = array();
        foreach($this->options as $option) {
            $rows[] = array(
                $option['name'],
                $option['type'],
                $option['description']
            );
        }

        $table = new \cli\Table();
        $table->setHeaders(array('Key', 'Type', 'Description'));
        $table->setRows($rows);
        $table->display();
    }

    function config(): void {}

    function exec(): void {}
}