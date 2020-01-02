<?php

namespace Tests\Feature;

use App\User;
use App\Event;
use App\Tour;
use App\Venue;
use App\Accomadation;
use App\Address;

use Illuminate\Support\Carbon;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\EventTestHelpers;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_own_events()
    {
        $user = factory(User::class)->create();
        factory(Event::class, 2)->create([
            'user_id' => 23,
            'tour_id' => null
        ]);
        factory(Event::class, 3)->create([
            'user_id' => $user->id,
            'tour_id' => null
        ]);

        $response = $this->actingAs($user, 'api')
            ->get('/api/events');

        $response->assertOk()
                ->assertJsonCount(3, 'events');
    }

    /** @test */
    public function events_will_be_paginated()
    {
        $user = factory(User::class)->create();
        factory(Event::class, 20)->create([
            'user_id' => $user->id,
            'tour_id' => null
        ]);

        $response = $this->actingAs($user, 'api')
            ->get('/api/events');

        $response->assertOk()
                ->assertJsonCount(10, 'events');
    }

    // FILTERS

    /** @test */
    public function user_can_filter_by_past_events()
    {
        
    }

    /** @test */
    public function user_can_filter_by_future_events()
    {
        
    }

    /** @test */
    public function user_can_filter_between_two_dates()
    {
        
    }

    /** @test */
    public function an_event_can_be_added()
    {
        $user = factory(User::class)->create();
        $venue = factory(Venue::class)->create();
        $tour = factory(Tour::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/events', [
                'user_id' => $user->id,
                'tour_id' => $tour->id,
                'date' => new Carbon('2021-03-21'),
                'time' => '21:30',
                'set_length' => 60,
                'venue_id' => $venue->id,
                'rider' => 'Got beers',
                'pay' => 450
            ]);

        $event = Event::first();

        $response->assertOk();

        $this->assertCount(1, Event::all());

        $this->assertEquals($user->id, $event->user_id);
        $this->assertEquals($tour->id, $event->tour_id);
        $this->assertStringContainsString('2021-03-21', $event->date);
        $this->assertEquals('21:30', $event->time);
        $this->assertEquals(60, $event->set_length);
        $this->assertEquals($venue->id, $event->venue_id);
        $this->assertEquals('Got beers', $event->rider);
        $this->assertEquals(450, $event->pay);
    }

    /** @test */
    public function an_event_can_be_updated()
    {
        $user = factory(User::class)->create();
        $event = EventTestHelpers::createEvent($user);
        $venue = factory(Venue::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('PATCH', '/api/events/' . $event->id, [
                    'date' => new Carbon('2021-04-22'),
                    'time' => '22:30',
                    'set_length' => 90,
                    'venue_id' => $venue->id,
                    'rider' => 'Nothing...',
                    'pay' => 600
                ]);

        $updatedEvent = Event::first();

        $response->assertOk();
        $this->assertStringContainsString('2021-04-22', $updatedEvent->date);
        $this->assertEquals('22:30', $updatedEvent->time);
        $this->assertEquals(90, $updatedEvent->set_length);
        $this->assertEquals('Nothing...', $updatedEvent->rider);
        $this->assertEquals(600, $updatedEvent->pay);
    }

    /** @test */
    public function user_cant_inject_data()
    {
        $user = factory(User::class)->create();
        $event = EventTestHelpers::createEvent($user);

        $response = $this->actingAs($user, 'api')
            ->json('PATCH', '/api/events/' . $event->id, [
                    'user_id' => 4,
                    'date' => new Carbon('2021-04-22'),
                    'time' => '22:30',
                    'set_length' => 90,
                    'rider' => 'Nothing...',
                    'pay' => 600
                ]);

        $updatedEvent = Event::first();
        $this->assertEquals($user->id, $updatedEvent->user_id);
    }    

    /** @test */
    public function an_event_can_be_deleted()
    {
        $user = factory(User::class)->create();
        $event = EventTestHelpers::createEvent($user);

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', '/api/events/' . $event->id);

        $response->assertOk();
        $this->assertCount(0, Event::all());
    }

    /** @test */
    public function only_logged_in_can_manage_events()
    {
        $user = factory(User::class)->create();
        $event = EventTestHelpers::createEvent($user);

        $getResponse = $this->get('/api/events');
        $postResponse = $this->post('/api/events', [
            'anything' => 'yeah'
        ]);
        $patchResponse = $this->patch('/api/events/' . $event->id, [
            'anything' => 'yeah'
        ]);
        $deleteResponse = $this->delete('/api/events/' . $event->id);

        $getResponse->assertStatus(401);
        $postResponse->assertStatus(401);
        $patchResponse->assertStatus(401);
        $deleteResponse->assertStatus(401);
    }

    /** @test */
    public function user_can_only_manage_own_events()
    {
        $user1 = factory(User::class)->create();
        $event1 = EventTestHelpers::createEvent($user1);

        $user2 = factory(User::class)->create();
        $event2 = EventTestHelpers::createEvent($user2);

        $getResponse = $this->actingAs($user2, 'api')
            ->get('/api/events/' . $event1->id);

        $patchResponse = $this->actingAs($user2, 'api')
            ->patch('/api/events/' . $event1->id, [
                'anything' => 'yeah'
            ]);


        $deleteResponse = $this->actingAs($user2, 'api')
            ->delete('/api/events/' . $event1->id);

        $getResponse->assertStatus(403);
        $patchResponse->assertStatus(403);
        $deleteResponse->assertStatus(403);
    }

    // VALIDATION

    /** @test */
    public function add_event_requires_date(){
        $response = EventTestHelpers::testAddValidation($this, 'date');
        $response->assertSessionHasErrors('date');
    }

    // /** @test */
    // public function add_event_requires_set_length(){
    //     $this->testAddValidation('set_length');
    // }

    // /** @test */
    // public function add_event_requires_venue_id(){
    //     $this->testAddValidation('venue_id');
    // }

    // /** @test */
    // public function add_event_requires_pay(){
    //     $this->testAddValidation('pay');
    // }

    // /** @test */
    // public function update_event_requires_date(){
    //     $this->testUpdateValidation('date');
    // }

    // /** @test */
    // public function update_event_requires_set_length(){
    //     $this->testUpdateValidation('set_length');
    // }

    // /** @test */
    // public function update_event_requires_venue_id(){
    //     $this->testUpdateValidation('venue_id');
    // }

    // /** @test */
    // public function update_event_requires_pay(){
    //     $this->testUpdateValidation('pay');
    // }
}