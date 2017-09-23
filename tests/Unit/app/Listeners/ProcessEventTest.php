<?php

namespace Tests\Unit\App\Listeners;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Event;
use App\Events\NewEvent;

class ProcessEventTest extends TestCase
{
    
    use RefreshDatabase;
    
    /**
     * ensure that the sns event payload is parsed correctly
     *
     * @return void
     */
    public function test_it_saves_the_eb_environment_when_it_does_not_exsit()
    {
        
        $user = factory(\App\User::class)->create();
        $team = factory(\App\Team::class)->make();
        $team->owner_id = $user->id;
        $team->save();
        
        $this->assertEquals(0, $team->ebenvironments()->count());
        
        $eb_event = new Event;
        $eb_event->team_id = $team->id;
        $eb_event->sns_message_id = 'test_'.str_random(15);
        $eb_event->sns_type = 'Notification';
        $eb_event->payload = '{"Type": "Notification", "Message": "Timestamp: Sat Sep 23 20:52:30 UTC 2017\nMessage: Environment health has transitioned from Warning to Ok.\n\nEnvironment: api-production-worker\nApplication: api.lawnstarter.com\n\nEnvironment URL: http://null\nNotificationProcessId: e83ead36-850c-4b93-8e04-e689d45f1c3a", "Subject": "AWS Elastic Beanstalk Notification - Environment health has transitioned from Warning to Ok.", "TopicArn": "arn:aws:sns:us-east-1:512078713017:Deployment_Slack", "MessageId": "4174e153-5ef9-5a57-a3ff-b313950bea7b", "Signature": "Qt9q0erv0+jTOlUZVaT45unpbXgq65yuMaCZbOMg0JYn2kw845JyuHZl+dqI9fj8GzB3eP7jGJ7aZb9E4aEdnR4nr5A1OEy+38PF65yqbCsiZGdbdtUm1o3jKQDZxLBne51Dy4xuUcjbz6e8HJ1Od8SLoZCmk81Rs5YtNk9yHZ+HLJX9+zemqx/sYa8CMw5+BmlYUCLjHdn2NOgQbCScyBqLc+ewlBGfA8rM+317P6+Llgn2Yng4KjuzEdWCBvwLVzaIFo1e7wL40BuHMQaF1SPksisaQP1sPDAsCT1BRYeWNkrGAtR+Bfo0rWfrJHLpWv+j3VnjPRioB/KckjPbCw==", "Timestamp": "2017-09-23T20:53:06.553Z", "SigningCertURL": "https://sns.us-east-1.amazonaws.com/SimpleNotificationService-433026a4050d206028891664da859041.pem", "UnsubscribeURL": "https://sns.us-east-1.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:us-east-1:512078713017:Deployment_Slack:a2cb0258-41b6-4855-a469-d6d7a5549bcf", "SignatureVersion": "1"}';
        $eb_event->save();   
        
        event(new NewEvent($eb_event));
        
        $this->assertEquals(1, $team->ebenvironments()->count());
    }
    
    /**
     * ensure that the sns event payload is parsed correctly
     *
     * @return void
     */
    public function test_it_does_not_duplicate_the_eb_environment_when_it_exsits()
    {
        
        $user = factory(\App\User::class)->create();
        $team = factory(\App\Team::class)->make();
        $team->owner_id = $user->id;
        $team->save();
        $env = factory(\App\EbEnvironment::class)->make([
            'eb_application' => 'api.lawnstarter.com',
            'eb_environment' => 'api-production-worker',
        ]);
        $team->ebenvironments()->save($env);
        
        
        $this->assertEquals(1, $team->ebenvironments()->count());
        
        $eb_event = new Event;
        $eb_event->team_id = $team->id;
        $eb_event->sns_message_id = 'test_'.str_random(15);
        $eb_event->sns_type = 'Notification';
        $eb_event->payload = '{"Type": "Notification", "Message": "Timestamp: Sat Sep 23 20:52:30 UTC 2017\nMessage: Environment health has transitioned from Warning to Ok.\n\nEnvironment: api-production-worker\nApplication: api.lawnstarter.com\n\nEnvironment URL: http://null\nNotificationProcessId: e83ead36-850c-4b93-8e04-e689d45f1c3a", "Subject": "AWS Elastic Beanstalk Notification - Environment health has transitioned from Warning to Ok.", "TopicArn": "arn:aws:sns:us-east-1:512078713017:Deployment_Slack", "MessageId": "4174e153-5ef9-5a57-a3ff-b313950bea7b", "Signature": "Qt9q0erv0+jTOlUZVaT45unpbXgq65yuMaCZbOMg0JYn2kw845JyuHZl+dqI9fj8GzB3eP7jGJ7aZb9E4aEdnR4nr5A1OEy+38PF65yqbCsiZGdbdtUm1o3jKQDZxLBne51Dy4xuUcjbz6e8HJ1Od8SLoZCmk81Rs5YtNk9yHZ+HLJX9+zemqx/sYa8CMw5+BmlYUCLjHdn2NOgQbCScyBqLc+ewlBGfA8rM+317P6+Llgn2Yng4KjuzEdWCBvwLVzaIFo1e7wL40BuHMQaF1SPksisaQP1sPDAsCT1BRYeWNkrGAtR+Bfo0rWfrJHLpWv+j3VnjPRioB/KckjPbCw==", "Timestamp": "2017-09-23T20:53:06.553Z", "SigningCertURL": "https://sns.us-east-1.amazonaws.com/SimpleNotificationService-433026a4050d206028891664da859041.pem", "UnsubscribeURL": "https://sns.us-east-1.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:us-east-1:512078713017:Deployment_Slack:a2cb0258-41b6-4855-a469-d6d7a5549bcf", "SignatureVersion": "1"}';
        $eb_event->save();   
        
        event(new NewEvent($eb_event));
        
        $this->assertEquals(1, $team->ebenvironments()->count());
    }
}



// 