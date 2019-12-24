<?php

namespace Tests;

use App\User;
use App\Event;
use App\Venue;
use Illuminate\Support\Carbon;

class EventTestHelpers {
    
    public static function createEvent($user)
    {
        $venue = factory(Venue::class)->create();
        $event = Event::create([
            'user_id' => $user->id,
            'date' => new Carbon('2021-03-21'),
            'time' => time('21:30'),
            'set_length' => 60,
            'venue_id' => $venue->id,
            'rider' => 'Got beers',
            'pay' => 450
        ]);

        return $event;
    }

    public static function testAddValidation($context, $field)
    {
        $user = factory(User::class)->create();
        $venue = factory(Venue::class)->create();
        $arr = [
            'user_id' => $user->id,
            'date' => new Carbon('2021-03-21'),
            'set_length' => 60,
            'venue_id' => $venue->id,
            'pay' => 450
        ];
        
        unset($arr[$field]);

        $response = $context->actingAs($user, 'api')
            ->post('/api/events', $arr);
        return $response;
    }

    public function testUpdateValidation($field)
    {
        $user = factory(User::class)->create();
        $venue = factory(Venue::class)->create();
        $arr = [
            'user_id' => $user->id,
            'date' => new Carbon('2021-03-21'),
            'set_length' => 60,
            'venue_id' => $venue->id,
            'pay' => 450
        ];
        
        unset($arr[$field]);

        $event = Self::createEvent($user);
        $response = Self::actingAs($user, 'api')
            ->patch('/api/events/' . $event->id, $arr);

        $response->assertSessionHasErrors($field);
    }
    
}