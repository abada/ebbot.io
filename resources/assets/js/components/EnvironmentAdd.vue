<template>
    <div>
    
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
                        <small>The only way to configure elastic beanstalk notifications is to run a command in the AWS CLI. The following steps will generate the correct command for your applications.</small>
                    </p>
                </div>
                
                
            </div>
        </div>
        
    </div>
</template>

<script>

    export default {
        
        props: ["endpoint"],
        
        data() {
            return {
                arn: '',
                region: '',
                eb_appliation: '',
                eb_environment: '',
            }  
        },
        
        mounted() {
        
        }
    }
</script>