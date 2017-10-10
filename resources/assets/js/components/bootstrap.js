
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');

import BeanbotDashboard from './BeanbotDashboard.vue';
import BeanbotDashboardTV from './BeanbotDashboardTV.vue';
import DeploymentProgress from './DeploymentProgress.vue';
import EnvironmentAdd from './EnvironmentAdd.vue';

Vue.component('beanbot-dashboard', BeanbotDashboard);
Vue.component('beanbot-dashboard-tv', BeanbotDashboardTV);
Vue.component('deployment-progress', DeploymentProgress);
Vue.component('environment-add', EnvironmentAdd);
