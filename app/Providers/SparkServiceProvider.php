<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Carbon\Carbon;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'BeanBot.io',
        'product' => 'BeanBot',
        'street' => '800 W 3rd Street, Ste 3302',
        'location' => 'Austin, TX 78701',
        'phone' => '(570) 472-4958',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'support@beanbot.io';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'weigert.jonas@gmail.com',
        'jonas@lawnstarter.com',
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useStripe()->noCardUpFront()->teamTrialDays(28);

        Spark::freeTeamPlan()
            ->features([
                'First', 'Second', 'Third'
            ]);

        Spark::teamPlan('Basic', 'provider-id-1')
            ->price(10)
            ->features([
                'First', 'Second', 'Third'
            ]);
            
        Spark::swap('TeamRepository@create', function ($user, array $data) {
            return Spark::team()->forceCreate([
                'owner_id' => $user->id,
                'name' => $data['name'],
                'endpoint' => str_random(20),
                'trial_ends_at' => Carbon::now()->addDays(Spark::teamTrialDays()),
            ]);
        });
    }
}
