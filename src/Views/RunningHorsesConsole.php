<?php

declare(strict_types = 1);

namespace App\Views;

use jc21\CliTable;

final class RunningHorsesConsole
{
    private $horses;

    public function __construct(array $horses)
    {
        $this->horses = $horses;
    }

    private function toArray()
    {
        $result = [];

        foreach ($this->horses as $horse) {
            $result[] = [
                'id'        => $horse->horse()->id(),
                'speed'     => $horse->horse()->stats()->speed(),
                'strength'  => $horse->horse()->stats()->strength(),
                'endurance' => $horse->horse()->stats()->endurance(),
                'distance'  => $horse->stats()->distance(),
                'time'      => $horse->stats()->time()
            ];
        }

        return $result;
    }

    public function render()
    {
        $table = new CliTable;

        $table->setTableColor('blue');
        $table->setHeaderColor('cyan');
        $table->addField('Horse id', 'id', false, 'white');
        $table->addField('Speed', 'speed', false, 'white');
        $table->addField('Strength', 'strength', false, 'white');
        $table->addField('Endurance', 'endurance', false, 'white');
        $table->addField('Distance', 'distance', false, 'white');
        $table->addField('Time', 'time', false, 'white');
//        $table->addField('DOB', 'dobTime', new CliTableManipulator('datelong'));
//        $table->addField('Admin', 'isAdmin', new CliTableManipulator('yesno'), 'yellow');
//        $table->addField('Last Seen', 'lastSeenTime', new CliTableManipulator('nicetime'), 'red');
//        $table->addField('Expires', 'expires', new CliTableManipulator('duetime'), 'green');
        $table->injectData($this->toArray());
        $table->display();
    }

    public function __toString()
    {
        return join("\n", $this->horses) . "\n\n";
    }
}
