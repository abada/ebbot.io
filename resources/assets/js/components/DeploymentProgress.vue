<template>
    
    <div class="progress" style="margin:0px;">
        <div class="progress-bar active" v-bind:class="{ 'progress-bar-striped': percentage >= 100 }" role="progressbar" v-bind:aria-valuenow="percentage" aria-valuemin="0" aria-valuemax="100" v-bind:style="'width:'+ percentage +'%'">
            <span class="sr-only">{{ percentage }}% Complete</span>
        </div>
    </div>
    
</template>

<script>

     var moment = require('moment');

    export default {
        
        props: ["startedAt", "durationProjected"],
        
        data() {
            return {
                now: moment(),
            }
        },
        
        mounted() {
          var vm = this;
          setInterval(function () {
             vm.$data.now = moment()
          }, 1000)
        }, 
        
        computed: {
            
            percentage: function() {
                var vm = this;
                var now = moment.utc(vm.now);
                var seconds_elapsed = Math.abs(moment.utc(vm.startedAt).diff(now)) / 1000;
                var percentage = Math.min(((seconds_elapsed / vm.durationProjected) * 100), 100);
                return percentage;
            }
            
        }
        
        
    }
</script>