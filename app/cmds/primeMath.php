<?php
declare(strict_types=1);

require_once ROOT . "app/lib/cliCommand.php";
require_once ROOT . "app/lib/PrimeNumbers.php";

class primeMath extends cliCommand {

    function __construct(array $args) {
        parent::__construct($args);
    }

    function config(): void {
        $this->addOption('count', 'Int', 'Give the count of prime number display');
        $this->addOption('multiply', 'Null', 'For displaying the table of prime numbers multiplication');
    }

    function exec(): void {
        $input = $this->getArguments();

        $count = $input["count"] ?? 10;

        $primeNos = new PrimeNumbers((int)$count);
        
        if(isset($input['multiply'])) {
            $table = new \cli\Table();

            $headers = $primeNos->array();
            array_unshift($headers, '');
            $table->setHeaders($headers);

            $tableData = $this->getPrimeMultipleTableData($primeNos->array());
            $table->setRows($tableData);
            $table->display();
        } else {
            $table = new \cli\Table();
            $headers = $primeNos->array();
            $table->setHeaders($headers);
            $table->display();
        }
    }

    function getPrimeMultipleTableData($primeNos): array {
        $tableData = array();
        foreach($primeNos as $prime1) {
            $data = array();
            $data[] = $prime1->toInt();
            foreach($primeNos as $prime2) {
                $data[] =  $prime1->toInt() * $prime2->toInt();
            }
            $tableData[] = $data;
        }
        return $tableData;
    }
}