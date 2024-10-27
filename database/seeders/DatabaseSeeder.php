<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Event;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $me = User::factory()->withPersonalTeam()->create([
            'name' => 'Michał Rosa',
            'email' => 'michalrosa17@gmail.com',
            'password' => Hash::make('asdfasdf'),
        ]);

        $team = Team::factory()->create([
            'name' => 'Patriot',
            'user_id' => $me,
            'personal_team' => false,
        ]);

        $me->switchTeam($team);

        $users = User::factory(10)->withPersonalTeam()->create()
            ->each(function ($user) use ($team) {
                // This uses the team_user table that comes with Jetstream
                $team->users()->attach(
                    $user->id,
                    ['role' => 'editor']  // Jetstream default roles are 'admin' or 'editor'
                );
                $user->switchTeam($team);
            });

        $faker = \Faker\Factory::create();
        $events = Event::factory(10)->create([
            'user_id' => $me,
            'team_id' => $team,
        ])
            ->each(function ($event) use ($team, $faker) {
                $allTeamUsers = $team->users;

                $selectedUsers = $faker->randomElements(
                    $allTeamUsers->pluck('id')->toArray(),
                    $faker->numberBetween(2, 5)
                );

                // Attach selected users to the event
                $event->attendees()->attach($selectedUsers);

            });

    }
}
