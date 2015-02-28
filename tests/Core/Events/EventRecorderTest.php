<?php

use Pmp\Core\Events\EventRecorder;

class EventRecorderImpl
{
    use EventRecorder;
}

class EventRecorderTest extends PHPUnit_Framework_TestCase
{
    private $eventRecorder;

    public function setUp()
    {
        $this->eventRecorder = new EventRecorderImpl(); 
    }

    /**
     * @test
     */
    public function recordThat_stores_an_event()
    {
        $this->eventRecorder->recordThat('event');
        $this->eventRecorder->recordThat('event2');
        $this->assertCount(2, $this->eventRecorder->getRecordedEvents());
    }

    /**
     * @test
     */
    public function clearRecoredEvents_clears_the_list_of_events()
    {
        $this->eventRecorder->recordThat('event');
        $this->eventRecorder->recordThat('event2');
        $this->assertCount(2, $this->eventRecorder->getRecordedEvents());
        $this->eventRecorder->clearRecordedEvents();
        $this->assertCount(0, $this->eventRecorder->getRecordedEvents());
    }
}