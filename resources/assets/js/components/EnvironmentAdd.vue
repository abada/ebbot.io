<template>
    <div>
        <div v-if="intro === true">
            
            <div class="media">
                <div class="media-left">
                    <i class="fa fa-plus-circle fa-2x"></i>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">Add addtional Elastic Beanstalk Environments</h3>
                    <p>
                        Its really easy to quickly add all your applications to Beanbot
                        the following step-by-step wizard makes it a matter of a few mintues.
                    </p>
            
                    <button type="button" class="btn btn-primary" v-on:click="intro = false">Let's Get Started</button>
                </div>
            </div>
            
        </div>
    
        
        <div v-if="intro !== true">
        
            <div class="media">
                <div class="media-left">
                    <i class="fa fa-circle-o fa-2x" v-if="arn === ''"></i>
                    <i class="fa fa-check-circle-o fa-2x status-ok" v-else="arn === ''"></i>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">Create / Find a SNS Topic ARN</h3>
                    <div v-if="arn === ''">
                        <p>
                            <span class="status-ok">
                                <strong>You only need one ARN for all 
                                environments</strong> but can have a dedicated 
                                ARN per environment. It is up to you and your organization's prefences / needs.
                            </span><br />
                            <small>BeanBot uses webhooks powered by SNS to update you on the state
                            of your elastic beanstalk environment.
                            This keeps your stack secure by not prodividing BeanBot with 
                            any sensitive keys.</small><br /><br />
                        </p>      
                        <ol>
                            <li>
                                <strong>Go to <a href="https://console.aws.amazon.com/sns/v2/home#/topics" target="_blank">https://console.aws.amazon.com/sns/v2/home#/topics</a></strong><br />
                                Create a new topic (or use one you already have for elastic beanstalk apps).<br /><br />
                                <ol>
                                    <li>
                                        <strong>Create a New Topic</strong><br /> 
                                        Click <code>Create New Topic</code>, the 
                                        names are up to you. We recommend BeanBot.
                                        <br />
                                        <br />
                                    </li>
                                    <li>
                                        <strong>Subscribe BeanBot to the new Topic</strong><br />
                                        Select the checkbox next to the new topic and then click <code>Actions > Subscribe to topic</code>
                                        <table class="table">
                                            <tr>
                                                <th>Protocol</th><td>HTTPS</td>
                                            </tr>
                                            <tr>
                                                <th>Endpoint</th><td>{{ endpoint }}</td>
                                            </tr>
                                        </table>
                                    </li>
                                </ol>
                                <br />
                            </li>
                            <li>
                                <strong>Paste the Topic's ARN here</strong>
                                <input type="text" class="form-control" v-model="arn" />
                            </li>
                        </ol>
                    </div>
                    <div v-else="arn === ''">
                        <input type="text" class="form-control" v-model="arn" placeholder="Your Topic's ARN" />
                        <br />
                    </div>
                </div>
            </div>
            
            <div class="media">
                <div class="media-left">
                    <i class="fa fa-circle-o fa-2x" v-if="arn === ''"></i>
                    <i class="fa fa-rocket fa-2x" v-else="arn === ''"></i>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">Update Elastic Beanstalk Environment to send Notifications</h3>
                    <div v-if="arn === ''">
                        <p>
                            <small>We can't configure the environments yet! We need the ARN first!</small>
                        </p>
                    </div>
                    <div v-else="arn === ''">
                        <p>
                            <small>The only way to configure elastic beanstalk 
                            notifications is to run a command in the 
                            <a href="https://aws.amazon.com/cli/" target="_blank">AWS CLI</a>. 
                            The following steps will generate the correct command for your applications.</small>
                        </p>
                        
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="region" class="col-sm-2 control-label">EB Region</label>
                                <div class="col-sm-8">
                                      <input type="text" class="form-control" id="region" placeholder="us-east-1" v-model="region">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="eb_appliation" class="col-sm-2 control-label">Application</label>
                                <div class="col-sm-8">
                                      <input type="text" class="form-control" id="eb_appliation" placeholder="application-name-here" v-model="eb_appliation">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="eb_environment" class="col-sm-2 control-label">Environment</label>
                                <div class="col-sm-8">
                                      <input type="text" class="form-control" id="eb_environment" placeholder="environment-name-here" v-model="eb_environment">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <br />
                                    <strong>Execute the following command in your terminal:</strong>
                                    <textarea class="form-control" readonly="" rows="5">aws --region {{ region }} elasticbeanstalk update-environment \
--application-name {{ eb_appliation }} \
--environment-name {{ eb_environment }} \
--option-settings Namespace=aws:elasticbeanstalk:sns:topics,OptionName="Notification Topic ARN",Value={{ arn }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>

    export default {
        
        props: ["endpoint", "intro"],
        
        data() {
            return {
                arn: '',
                region: 'us-east-1',
                eb_appliation: '',
                eb_environment: '',
            }  
        },
        
        mounted() {
        
        }
    }
</script>