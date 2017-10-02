<template>
    <div class="container-fluid" v-if="applications !== null && teamHasApplications">
        <div class="row" v-for="(environments, application) in applications">
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
                            
                            <strong>{{ environment.eb_environment }}</strong><br />
                            <small>{{ environment.eb_application }}</small>
                            
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
                
                axios.get('/api/dashboard')
                    .then(function(response) {
                        vm.applications = response.data;
                        console.log(vm.applications);
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