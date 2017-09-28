<template>
    <div>
        
        <div class="panel" v-if="applications === null">
            <div class="panel-body text-center">
                <br />
                <p><i class="fa fa-circle-o-notch fa-spin fa-2x"></i></p>
                <small>Fetching Elastic Beanstalk Status</small>
            </div>
        </div>
        
        <div class="alert alert-info" v-if="applications !== null && !teamHasApplications">
            <strong>Looks like Beanbot has not received any events from any of your environments.</strong><br />
            Once you have updated your elastic beanstalk environments to send events to your SNS topic you are all set.<br /> 
            It takes until then next change on that environment (deploy, status chamge, config change...) for it to appear here.
        </div>
        
        <div class="panel panel-default" v-if="applications !== null && teamHasApplications">
            <table class="table table-hover table-eb">
                <tbody v-for="(environments, application) in applications">
                    <tr>
                        <th><i class="fa fa-globe fa-2x"></i></th>
                        <th colspan=2>{{ application }}</th>
                        <th>Status</th>
                        <th class="text-center" width="1"><i class="fa fa-bullhorn"></i></th>
                        <th>Deploy</th>
                        <th></th>
                    </tr>
                    <tr v-for="environment in environments" v-bind:class="{ 
                        'danger': environment.status.status === 'Severe' ||  environment.status.status === 'Degraded', 
                        'warning': environment.status.status === 'Warning'}">
                        <td width="1"></td>
                        <td width="1">
                            <i class="fa fa-circle fa-1x" v-bind:class="{ 
                                'status-ok': environment.status.status === 'Ok',
                                'status-info': environment.status.status === 'Info',
                                'status-warning': environment.status.status === 'Warning',
                                'status-unknown': environment.status.status === 'Unknown',
                                'status-degraded': environment.status.status === 'Degraded',
                                'status-severe': environment.status.status === 'Severe'
                                }"></i>
                        </td>
                        <td>
                            <a href="https://console.aws.amazon.com/elasticbeanstalk/home" target="_blank">{{ environment.eb_environment }}</a>
                        </td>
                        <td>
                            <span v-if="environment.status !== null">
                                <strong style="font-family:monospace; text-transform:uppercase;">{{ environment.status.status }}</strong><br />
                                <small>{{ moment.utc().to(moment.utc(environment.status.status_set_at)) }}</small>
                            </span>
                            <span v-else="environment.status !== null">
                                <em>
                                    Unknown<br />
                                    <small>Never Reported</small>
                                </em>
                            </span>
                        </td>
                        <td>
                            <a :href="'/eb-environments/'+ environment.id+'/settings'">
                                {{ environment.notification_count }}
                            </a>
                        </td>
                        <td>
                            <span v-if="environment.last_deployment !== null">
                                <span v-if="environment.last_deployment.deployment_completed_at == null">
                                    <i class="fa fa-refresh fa-spin"></i>
                                    Deploying...
                                </span>
                                <span v-else="environment.last_deployment.deployment_completed_at == null">
                                    {{ moment.utc(environment.last_deployment.deployment_completed_at).format('ddd, MMM Do YYYY, h:mm A') }} UTC<br />
                                    <small>
                                        {{ moment.utc().to(moment.utc(environment.last_deployment.created_at)) }},
                                        Duration: {{ moment(environment.last_deployment.created_at).to(environment.last_deployment.deployment_completed_at, true) }}
                                    </small>
                                </span>
                            </span>
                            <span v-else="environment.last_deployment !== null">
                                <em>
                                    Unknown<br />
                                    <small>No Deploy Detected Yet</small>
                                </em>
                            </span>
                        </td>
                        <td width="1">
                            <a :href="'/eb-environments/'+ environment.id" class="btn btn-default">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

    var moment = require('moment');

    export default {
        
        props: ["currentTeam"],
        
        methods: {
            
            fetchData() {
                
                var vm = this;
                
                axios.get('/api/dashboard')
                    .then(function(response) {
                        vm.applications = response.data;
                        vm.teamHasApplications = !Array.isArray(vm.applications);
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
          
            listen() {
                
                var vm = this;
                
                window.Echo.private('team.'+vm.currentTeam.id)
                    .listen('EbEnvironmentStatusChanged', event => {
                        vm.fetchData();
                    });
                    
                window.Echo.private('team.'+vm.currentTeam.id)
                    .listen('EbEnvironmentDeployStarted', event => {
                        vm.fetchData();
                    });
                    
                window.Echo.private('team.'+vm.currentTeam.id)
                    .listen('EbEnvironmentDeployCompleted', event => {
                        vm.fetchData();
                    });
                    
            }
            
        },
        
        data() {
            return {
                applications: null,
                moment: moment,
                team_id: null,
                teamHasApplications: false,
            }  
        },
        
        mounted() {
            
            var vm = this;
            this.fetchData();
            this.listen();
        }
    }
</script>

<style type="text/css">
    
    table.table-eb > tbody > tr > td,
    table.table-eb > tbody > tr > th {
        vertical-align:middle;
    }
    
</style>