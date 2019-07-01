<?php

namespace Tests\Unit;

use App\Team;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_name()
    {
        $team = new Team(['name' => 'Acme']);
        $this->assertEquals('Acme', $team->name);
    }

    /** @test */
    public function it_can_add_members()
    {
        $team = factory(Team::class)->create();

        $user = factory(User::class)->create();
        $userTwo = factory(User::class)->create();

        $team->add($user);
        $team->add($userTwo);

        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function it_has_a_maximum_size()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $users = factory(User::class, 3)->create();
        
        $team->add($users->get(0));
        $team->add($users->get(1));
        
        $this->assertEquals(2, $team->count());

        $this->expectException('Exception');
        $team->add($users->get(2));
    }

    /** @test */
    public function when_adding_many_members_at_once_you_still_may_not_exceed_the_team_maximum_size()
    {
        $team = factory(Team::class)->create(['size' => 2]);
        $users = factory(User::class, 3)->create();

        $this->expectException('Exception');

        $team->add($users);
    }

    /** @test */
    public function it_can_add_multiple_members_at_once()
    {
        $team = factory(Team::class)->create();
        $users = factory(User::class, 2)->create();

        $team->add($users);

        $this->assertEquals(2, $team->count());
    }

    /** @test */
    public function it_can_remove_a_member()
    {
        $team = factory(Team::class)->create();
        $users = factory(User::class, 2)->create();

        $team->add($users);

        $team->remove($users->get(0));

        $this->assertEquals(1, $team->count());
    }

    /** @test */
    public function it_can_remove_more_than_one_member_at_once()
    {
        $team = factory(Team::class)->create(['size' => 3]);
        $users = factory(User::class, 3)->create();

        $team->add($users);

        $team->remove($users->slice(0,2));

        $this->assertEquals(1, $team->count());
    }

    /** @test */
    public function it_can_remove_all_members_at_once()
    {
        $team = factory(Team::class)->create();
        $users = factory(User::class, 2)->create();

        $team->add($users);

        $team->restart();

        $this->assertEquals(0, $team->count());
    }
}
