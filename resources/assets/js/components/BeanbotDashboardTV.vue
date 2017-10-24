<template>
    <div class="container-fluid" v-if="applications !== null && teamHasApplications">
        <div  v-for="(environments, group) in applications">
            <h1 style="color: #FFF;">{{ group }}</h1>
            <div class="row">
                <div class="col-md-3" v-for="environment in environments">
                    <div class="alert" v-bind:class="{ 
                        'alert-danger': environment.status.status === 'Severe' ||  environment.status.status === 'Degraded', 
                        'alert-warning': environment.status.status === 'Warning' || environment.status.status === 'Unknown',
                        'alert-success': environment.status.status === 'Ok' || environment.status.status === 'Info',
                        }">
                        
                        <div class="media">
                            <div class="media-left">
                                
                                <i class="fa fa fa-3x" v-bind:class="{
                                    'fa-refresh fa-spin': environment.last_deployment !== null && environment.last_deployment.deployment_completed_at === null,
                                    'fa-circle': environment.last_deployment == null || environment.last_deployment.deployment_completed_at !== null}"></i>
                                
                                
                            </div>
                            <div class="media-body">
                                
                                <p>
                                    <strong>{{ environment.eb_application }}</strong><br />
                                    <small>{{ environment.eb_environment }}</small>
                                </p>
                                
                                <div v-if="environment.last_deployment !== null && environment.last_deployment.deployment_completed_at === null">
                                    <deployment-progress :startedAt="environment.last_deployment.created_at" :durationProjected="environment.last_deployment.duration_projected"></deployment-progress>
                                </div>
                                
                                <div v-if="environment.last_deployment !== null && environment.last_deployment.deployment_completed_at !== null">
                                    Last Deploy: <strong><timeago :since="moment.utc(environment.last_deployment.created_at)" :auto-update="60"></timeago></strong>
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

    var moment = require('moment');

    export default {
        
        props: ["currentTeam"],
        
        methods: {
            
            fetchData() {
                
                var vm = this;
                
                axios.get('/api/dashboard/tv')
                    .then(function(response) {
                        vm.applications = response.data;
                        vm.teamHasApplications = true
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },
          
            listen() {
                
                var vm = this;
                
                window.Echo.private('team.'+vm.currentTeam.id)
                    .listen('EbEnvironmentStatusChangeReported', event => {
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