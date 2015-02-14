<?php
namespace Pmp\Core\Events;

trait EventRecorder
{
    protected $events = [];

    public function getRecordedEvents()
    {
        return $this->events;
    }

    public function clearRecordedEvents()
    {
        $this->events = [];
    }

    public function recordThat($event)
    {
        $this->events[] = $event;
    }
}
