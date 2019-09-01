<?php

declare(strict_types = 1);

namespace App\Views;

use jc21\CliTable;
use App\Domain\Model\Race\RunningHorseInternalState;

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
            $state    = new RunningHorseInternalState($horse);
            $result[] = $state->data();
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
        $table->addField('Full s distance', 'fullSpeedDistance', false, 'white');
        $table->addField('Time', 'time', false, 'white');
        $table->addField('Seconds / Meter', 'secondsPerMeter', false, 'white');
//        $table->addField('DOB', 'dobTime', new CliTableManipulator('datelong'));
//        $table->addField('Admin', 'isAdmin', new CliTableManipulator('yesno'), 'yellow');
//        $table->addField('Last Seen', 'lastSeenTime', new CliTableManipulator('nicetime'), 'red');
//        $table->addField('Expires', 'expires', new CliTableManipulator('duetime'), 'green');
        $table->injectData($this->horses);
        $table->display();
    }

    public function __toString()
    {
        return join("\n", $this->horses) . "\n\n";
    }
}
